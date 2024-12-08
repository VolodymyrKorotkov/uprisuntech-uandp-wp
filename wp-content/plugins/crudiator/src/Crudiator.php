<?php

namespace Crudiator;

// WordPress標準クラスのWP_List_Tableをベースクラスとする為、まだ存在しない場合はここで読み込みます
if (!class_exists('WP_List_Table')) {
  if (!defined("ABSPATH")) { // 万が一WordPressで定義されているABSPATHが無い場合は何もせずreturnする
    return;
  }
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

use \WP_List_Table;
use Medoo\Medoo;
use PDO;
use PDOException;

/**
 * Class Crudiator
 * WordPressでよく使われる管理画面のテーブル表示のクラス WP_List_Table を拡張して、
 * 簡単にCRUD操作ができるようにしたクラスです。
 */
class Crudiator extends WP_List_Table {
  private $user = null;         // WordPress User
  private $medoo = null;        // Medooインスタンス
  private $menu_title = null;   // メニュータイトル
  private $page_name = null;    // ページ名
  private $hook_name = "";
  private $fields = null;       // テーブルカラム情報
  private $table = null;        // テーブル名
  private $primary_keys = [];   // 複合キー対応
  private $is_auto_increment = false; // AUTO_INCREMENT
  private $fulltext_columns = [];     // 全文検索インデックス情報
  private $last_error = "";     // データベースエラー時のエラーメッセージ
  private $display_as = null;
  private $page_url = "";
  private $sql_query = "";      // CRUDで実行した時のデバッグ用SQL

  // このクラスをカスタマイズする為のオプション値。ここで定義しているのは初期値となる。
  private $options = [
    "insert"                     => true,
    "detail"                     => true,
    "update"                     => true,
    "delete"                     => true,
    "export"                     => true,
    "filter"                     => true,
    "fulltext_search"            => true,
    "fulltext_search_type"       => "IN BOOLEAN MODE",
    "list_perpage"               => true,
    "list_column_display_toggle" => true,
    "list_perpage_number"        => self::DEFAULT_PER_PAGE,
    "autocomplete"               => "on",
    "debug"                      => false,
  ];

  const FORM_INPUT_NAME_KEY = '__crudiator_input_names__';
  const DEFAULT_PER_PAGE = 10;

  // 絞り込み検索で使える比較演算子とその文字列
  private $operators = [];

  /**
   * @param       $table          対象のDBテーブル名
   * @param array $options        CRUDパラメータ
   */
  public function __construct($table, $options = []) {

    // このCrudiatorで扱うテーブル
    $this->table = $table;

    // 初期値にユーザーオプションをマージする
    $this->options = array_merge($this->options, $options);

    // 名称変更はよく使うのでメンバ変数として持つ
    $this->display_as = $this->get_option("display_as");

    // WP_List_Table のconstructorを呼び出す
    parent::__construct(array(
      'singular' => 'crudiator_item', // シングル表示のcssクラス名
      'plural'   => 'crudiator_list', // リスト表示のcssクラス名
      'ajax'     => false        // ajaxサポート
    ));

  }

  /**
   * メインメニューを作る関数
   * WordPressの標準関数 add_menu_page をインスパイアされた関数
   * @param        $page_title
   * @param        $menu_title
   * @param        $capability
   * @param        $menu_slug
   * @param string $function
   * @param string $icon_url
   * @param null   $position
   */
  public function add_menu_page($page_title = "", $menu_title = "", $capability = "manage_options", $menu_slug = "", $icon_url = '', $position = null) {
    // 空文字が渡った場合はテーブル名で自動補完
    $page_title = (empty($page_title)) ? $this->table : esc_html($page_title);  // エスケープする必要ある
    $menu_title = (empty($menu_title)) ? $this->table : esc_html($menu_title);  // エスケープする必要ある
    $menu_slug  = (empty($menu_slug)) ? $this->table : $menu_slug;

    $this->menu_title = $menu_title;  // 後でページ内タイトルで使うので保存
    $this->page_name  = $menu_slug;

    // WordPressの関数呼び出すのみ
    $this->hook_name = add_menu_page($page_title, $menu_title, $capability, $menu_slug, [$this, "render"], $icon_url, $position);

    // render処理の前に呼ぶ関数を登録
    add_action('load-' . $this->hook_name, [$this, "main"]);

  }

  /**
   * サブメニューを作る関数
   * WordPressの標準関数 add_submenu_page をインスパイアされた関数
   * @param        $parent_slug
   * @param        $page_title
   * @param        $menu_title
   * @param        $capability
   * @param        $menu_slug
   * @param null   $position
   */
  public function add_submenu_page($parent_slug, $page_title = "", $menu_title = "", $capability = "manage_options", $menu_slug = "", $position = null) {

    // 空文字が渡った場合はテーブル名で自動補完
    $page_title = (empty($page_title)) ? $this->table : esc_html($page_title);  // エスケープする必要ある
    $menu_title = (empty($menu_title)) ? $this->table : esc_html($menu_title);  // エスケープする必要ある
    $menu_slug  = (empty($menu_slug)) ? $this->table : $menu_slug;

    $this->menu_title = $menu_title;  // 後でページ内タイトルで使うので保存
    $this->page_name  = $menu_slug;

    // WordPressの関数呼び出すのみ
    $this->hook_name = add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, [$this, "render"], $position);

    // render処理の前に呼ぶ関数を登録
    add_action('load-' . $this->hook_name, [$this, "main"]);

  }

  /**
   * Crudiatorを処理する上での初期化処理
   * @return void
   */
  private function initialize() {
    // nonceのタイムアウトはデフォルト24時間で長いので、セキュリティを考慮して1時間とする。
    // 20220827 以下screen_optionを追加したが値を保存する時この1時間だとnonceチェックが失敗するのでやめた。
//    add_filter('nonce_life', function () {
//      return HOUR_IN_SECONDS;   // 1時間
//    });

    // WordPressのnotice出力関数を事前に登録する
    add_action('admin_notices', [$this, 'output_notice']);

    // 管理画面にアクセスしたWordPressユーザーの保存
    $this->user = wp_get_current_user();

    // 絞り込みの演算子一覧
    $this->operators = [
      "eq"   => $this->__("equals"),                        // "次の値と等しい"
      "neq"  => $this->__("does not equal"),                // "次の値と等しくない"
      "gt"   => $this->__("is greater than"),               // "次の値より大きい"
      "ge"   => $this->__("is greater than or equal to"),   // "次の値以上"
      "lt"   => $this->__("is less than"),                  // "次の値より小さい"
      "le"   => $this->__("is less than or equal to"),      // "次の値以下"
      "cs"   => $this->__("contains"),                      // "次の文字列を含む"
      "ncs"  => $this->__("does not contain"),              // "次の文字列を含まない"
      "sw"   => $this->__("starts with"),                   // "次の文字列で始まる"
      "nsw"  => $this->__("does not start with"),           // "次の文字列で始まらない"
      "ew"   => $this->__("ends with"),                     // "次の文字列で終わる"
      "new"  => $this->__("does not ends with"),            // "次の文字列で終わらない"
      "isn"  => $this->__("is null"),                       // "値がNULLである"
      "isnn" => $this->__("is not null"),                   // "値がNULLではない"
      // 以下はUIとともに作り込みが必要。BETWEENはいらないかな。INはあってもいいかも？
//    "bt"  => "BETWEEN", // between        次の値と値の間
//    "in"  => "IN",      // IN句           次の複数の値と一致
    ];

    // ver付きの自動読み込み
    $assets_js  = [
      "datetimepicker" => ["assets/lib/datetimepicker/jquery.datetimepicker.full.min.js", ["jquery"]],
      "crudiator_js"   => ["assets/js/crudiator.js", ["jquery", "datetimepicker"]]
    ];
    $assets_css = [
      "datetimepicker" => ["assets/lib/datetimepicker/jquery.datetimepicker.min.css"],
      "crudiator_css"  => ["assets/css/crudiator.css"]
    ];
    $this->wp_enqueue_assets($assets_js, $assets_css);

    // js用に翻訳データを渡します。
    $translation_array = array(
      'confirm_delete_list'   => $this->__('Do you want to delete the item ?'),/*"次のデータを削除しても宜しいですか？"*/
      'confirm_delete_this'   => $this->__('Do you want to delete this item ?'),/*"このデータを削除しても宜しいですか？"*/
      'confirm_delete_select' => $this->__('Do you want to delete selected item ?'),/*"選択したデータを削除しても宜しいですか？"*/
      'item_count'            => $this->__('Item count : '),/*データ件数 : */
      'item_no_select'        => $this->__("Item not selected."),/*"項目が選択されていません"*/
      'view_filter_export'    => $this->__("When in View or Filter view, data for that condition will be exported."),/*ビュー表示又は絞り込み表示をしている時はその条件のデータがエクスポートされます。*/
    );
    wp_localize_script('crudiator_js', 'translate_str', $translation_array);

    /* ここからDB情報取得するのでPDOのインスタンス化 */
    if ($connection = $this->get_option("connection")) {    // ユーザーオプションで指定がある場合は接続先を変更することが出来る
      if (isset($connection["hostname"], $connection["database"], $connection["username"], $connection["password"])) {
        $db_host = $connection["hostname"];
        $db_name = $connection["database"];
        $db_user = $connection["username"];
        $db_pass = $connection["password"];
      }
    } else {
      // WordPressで定義されているDB接続情報を使う
      $db_host = DB_HOST;
      $db_name = DB_NAME;
      $db_user = DB_USER;
      $db_pass = DB_PASSWORD;
    }

    // PDOラッパーライブラリをnewすればDB接続エラーを例外で検知出来るのでここでtryで囲む
    try {
      $this->medoo = new Medoo([
        'type'     => 'mysql',
        'host'     => $db_host,
        'database' => $db_name,
        'username' => $db_user,
        'password' => $db_pass,
        'error'    => PDO::ERRMODE_EXCEPTION,
        'option'   => [
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
        "logging"  => true,    // trueにする全ての実行クエリを保存する。falseにすると最後の実行クエリのみ保存。
      ]);
    } catch (PDOException $ex) {
      $error_msg        = $this->__("Crudiator does not work properly because database connection by PDO is not possible.") . "<br/>";
      $error_msg        .= $this->__("Error Message: ") . $ex->getMessage();
      $this->last_error = $error_msg;
      return false;
    }

    // カラム情報は何かと使うのでここでメンバー変数に持っておく
    try {
      $this->fields = $this->get_db_columns_info($db_name, $this->table);
    } catch (PDOException $ex) {
      $this->last_error = $this->__("Unable to retrieve table information.");  // "テーブル情報を取得できません。"
      return false;
    }

    // この時点でテーブル情報を取得出来ない場合はエラー文言入れて返す
    if (!$this->fields) {
      $this->last_error = $this->__("Unable to retrieve table information.");  // "テーブル情報を取得できません。"
      return false;
    }

    // 主キーの取得
    foreach ($this->fields as $column_name => $field) {
      if (isset($field["COLUMN_KEY"]) && $field["COLUMN_KEY"] == "PRI") {
        $this->primary_keys[] = $column_name;
      }
      // AUTO_INCREMENTかどうかのフラグもここで判定する
      if (isset($field["EXTRA"]) && strtoupper($field["EXTRA"]) == "AUTO_INCREMENT") {
        $this->is_auto_increment = true;
      }
    }

    // 主キー無しはここでupdate, delete, detailを無効にする
    if (count($this->primary_keys) == 0) {
      $this->options["update"] = false;
      $this->options["delete"] = false;
      $this->options["detail"] = false;
    }

    // 20230414 Medooの全文検索は複合条件が出来ない為一旦無効化している
//    /* 全文検索用のカラムチェック */
//    if ($fulltext_columns = $this->get_option("fulltext_columns")) {  // ユーザー指定がある時はそれに従う
//      $this->fulltext_columns = $fulltext_columns;
//    } else {
//      // FULLTEXTに対応しているか調べる
//      $table_index = $this->get_db_index_info($db_name, $this->table);
//
//      // FULLTEXT自動認識の場合は最初に見つかったFULLTEXTのキーを優先とする
//      $fulltext_key = "";
//      foreach ($table_index as $_index) {
//        if ($fulltext_key == "") {  // 初回
//          if (isset($_index["INDEX_TYPE"]) && strtoupper($_index["INDEX_TYPE"]) == "FULLTEXT") {
//            $fulltext_key             = $_index["INDEX_NAME"];
//            $this->fulltext_columns[] = $_index["COLUMN_NAME"];
//          }
//        } else if ($fulltext_key != "") {
//          // そのキーに複数カラムがあった場合はそれを収集する
//          if (isset($_index["INDEX_NAME"]) && $_index["INDEX_NAME"] == $fulltext_key) {
//            $this->fulltext_columns[] = $_index["COLUMN_NAME"];
//          }
//        }
//      }
//    }

    return true;
  }

  /**
   * Crudiatorのエントリーポイントで、ここから処理が始まる。
   * リダイレクト処理などはここで行う必要がある。
   * @return void
   */
  public function main() {
    // 最初にお作法としてhookから呼ばれているかをチェックする
    $screen = get_current_screen();
    if (!is_object($screen) || $screen->id != $this->hook_name) {
      return;
    }

    // ここからメイン処理が始まるので主キー取得などの初期化処理をする
    $init_result = $this->initialize();

    // DB情報を取得出来ない等で、初期化失敗しているならこの後の処理はせず抜ける
    if (!$init_result) {
      return false;
    }

    // HTTPメソッドとアクションで処理を分岐
    // 20230615 以下の書き方で一度変数として取得していたけど、
    // $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
    // PHP8.1からFILTER_SANITIZE_STRINGが非推奨となりWarning出るので変数として取らないようにした。
    if (isset($_SERVER["REQUEST_METHOD"]) && strtoupper($_SERVER["REQUEST_METHOD"]) === "POST") {
      $method = "POST";
    } else {
      $method = "GET";
    }
    $action = $this->current_action();    // WP_List_Tableのアクション取得関数

    // 指定のアクションがあった時に、カスタムオプションとしてfalseが設定されていた場合はエラー
    $action_list = ["insert", "detail", "update", "delete", "export", "filter"];  // 対象のアクション
    if (in_array($action, $action_list) && $this->get_option($action) == false) {
      $this->last_error = $this->__("This operation is not allowed.");  // この操作は許可されていません。
      return;
    } else if ($action == "bulk_delete" && $this->get_option("delete") == false) {  // bulk_deleteはdeleteに含まれる
      $this->last_error = $this->__("This operation is not allowed.");  // この操作は許可されていません。
      return;
    }

    /* action別処理の振り分け */
    if ($action === false) {   // actionに何も指定がない時はfalseになり、table表示
      // pagedの入力をEnterで実行すると余計なQueryStringが付くので除去して再アクセスする
      if (isset($_GET["paged"]) && isset($_GET["_wpnonce"]) && isset($_GET["_wp_http_referer"])) {
        $this->exec_redirect_paged(); // この中でリダイレクトする
      }
      $this->prepare_items();       // tableのrender処理前に事前にSQLを実行する
      $this->set_screen_option();   // table表示の時のみ表示オプションの設定をする
    } else if ($action == "insert") { // 新規
      if ($method == "POST") {        // POST時にデータ挿入処理
        $this->exec_insert_action();
      }
    } else if ($action == "detail") { // 詳細
      $this->check_primary_key_param();
    } else if ($action == "update") { // 更新
      if ($this->check_primary_key_param()) {
        if ($method == "POST") {
          $this->exec_update_action();
        }
      }
    } else if ($action == "delete") { // 消去
      if ($this->check_primary_key_param()) {
        $this->exec_delete_action();
      }
    } else if ($action == "export") { // エクスポート
      $this->exec_export_action();
    } else if ($action == "bulk_delete") {  // 一括削除
      $this->exec_bulk_delete_action();
    }
  }

  /**
   * WPテーマのfunctions.phpからadd_menu_pageで紐付ける静的メソッド
   * そのURLにアクセスされた時に呼び出され、テーブルコンテンツを出力する
   * WPから呼び出されるからpublicの必要がある。
   * @param $table      対象のDBテーブル名
   * @param $options    変更するパラメータ
   */
  public function render() {

    // actionパラメータを取得
    $action = $this->current_action();

    // actionリクエストごとにページ振り分け
    // DB処理でエラーがあった時はここでエラーを表示する
    if ($this->last_error) {  // main処理で事前にエラーがあった場合はここに入りoutput_noticeでエラー出力する
      $this->output_error();
    } else if ($action == "insert" && $this->get_option("insert")) {
      $this->output_insert_html();
    } else if ($action == "detail" && $this->get_option("detail")) {
      $this->output_detail_html();
    } else if ($action == "update" && $this->get_option("update")) {
      $this->output_update_html();
    } else {
      $this->output_table_html();   // 何もアクションの指定がない時は一覧表示
    }

    // output系の処理後にデバッグクエリを出力する
    if ($this->get_option("debug") == true) {
      $this->output_debug_html();
    }

  }

  /**
   * 画面上部の［表示オプション］の描画準備をします
   * @return void
   */
  private function set_screen_option() {

    // 1ページのリスト表示件数機能
    if ($this->get_option("list_perpage") == true) {

      // デフォルト値を決定する。カスタム設定があればそっちを優先。なければデフォ値(10)
      $list_perpage_number = $this->get_option("list_perpage_number");
      if ($list_perpage_number && is_numeric($list_perpage_number) && $list_perpage_number > 0) {
        $default_perpage = $list_perpage_number;
      } else {
        $default_perpage = self::DEFAULT_PER_PAGE;
      }

      $per_page_args = [
        'label'   => $this->__('Number of items per page:'),  // "ページごとに表示する項目数:"
        'default' => $default_perpage,
        'option'  => "crudiator_{$this->page_name}_per_page"
      ];
      add_screen_option('per_page', $per_page_args);
    }

    // カラムの表示／非表示の機能
    if ($this->get_option("list_column_display_toggle")) {
      // 表示オプション用カラムの為に登録
      add_filter("manage_{$this->hook_name}_columns", [$this, "on_manage_screen_columns"]);
    }
  }

  /**
   * 「表示オプション」のカラム一覧のフック処理
   * これで返したカラムを表す。
   * @return array|mixed
   */
  public function on_manage_screen_columns() {

    $columns = $this->get_columns();

    // checkboxの次のカラムだけはプライマリーカラムでrow_actionがあるので含めない
    // また、以下のカラム名はそもそも特別な為表示オプションで非表示に出来ない。
    // '_title', 'cb', 'comment', 'media', 'name', 'title', 'username', 'blogname'
    foreach ($columns as $key => $name) {
      if ($key == "cb") {
        continue;
      }
      unset($columns[$key]);
      break;
    }

    return $columns;
  }

  ////////// ここからWP_List_Tableのオーバーライドメソッド //////////

  /**
   * 現在のaction取得処理をオーバーライド
   * @return false|mixed|string
   */
  public function current_action() {
    // まずは親クラスのアクション取得
    $action = parent::current_action();

    // falseの場合はここから子クラスの追加アクション判定
    if ($action === false) {
      // ［エクスポート］submitボタンが押された場合のみ$_REQUESTに入ってくるのでそれで判定出来る
      if (isset($_REQUEST['export_action']) && -1 != $_REQUEST['export_action']) {
        $action = "export";
      }
    }

    return $action;
  }

  protected function get_views() {
    $views_ary    = [];
    $option_where = $this->get_option("where", []);
    $views        = $this->get_option("views");
    if ($views && is_array($views) && count($views) > 0) {
      // views指定がある場合は最初に「すべて」を挿入する
      // 全件数をチェック
      $all_count = $this->medoo->count($this->table, $option_where);
      $url       = $this->get_page_url();
      $all_class = "";
      if (!isset($_GET["view"])) {  // 何も指定ない場合はすべてがcurrent
        $all_class = "current";
      }
      $views_ary["all"] = "<a href='{$url}' class='{$all_class}'>{$this->__("All")}</a> " .
        "<span class=\"count\">(" . esc_html($all_count) . ")</span>"; // "すべて"

      // viewごとに件数を取得していく
      $idx = 1;
      foreach ($views as $view_name => $condition) {
        $view_idx = "view_{$idx}";
        // viewの条件はwhere条件の影響を受けない（影響するとより自由なビュー出力が出来なくなる）
        $item_count = $this->medoo->count($this->table, $condition);
        $view_class = "";
        if (isset($_GET["view"]) && $_GET["view"] == $view_name) {
          $view_class = "current";
        }
        $view_url             = $this->get_page_url(["view" => $view_name]);
        $views_ary[$view_idx] = "<a href='{$view_url}' class='{$view_class}'>" . esc_html($view_name) . "</a> " .
          "<span class=\"count\">(" . esc_html($item_count) . ")</span>";
        $idx++;
      }
    }
    return $views_ary;
  }

  /**
   * 一括(bulk)操作時のアクション
   * @return string[]
   */
  protected function get_bulk_actions() {
    $actions = [];
    if ($this->get_option("delete") == true) {
      $actions["bulk_delete"] = $this->__("Bulk delete");  // "一括削除"
    }
    return $actions;
  }

  /**
   * セルの値の下に列挙するアクションのハンドルメソッド
   * 丁度プライマリー引数があるのでデフォルトではプライマリーセルの時だけ編集、削除を追加する
   * @param object $item
   * @param string $column_name
   * @param string $primary
   * @return string
   */
  protected function handle_row_actions($item, $column_name, $primary) {
    // 最初のカラム値に行アクションを追加します
    if ($column_name === $primary) {

      $actions  = [];
      $pri_vals = $this->get_primary_values($item); // 主キーの値取得

      // detailが許可されていればdetailリンクを追加
      if ($this->get_option("detail") == true) {
        $detail_href       = $this->get_page_url(["action" => "detail", "id" => $pri_vals]);
        $actions['detail'] = "<a href='" . esc_attr($detail_href) . "'>{$this->__("View")}</a>";  // "閲覧"
      }

      // updateが許可されていればupdateリンクを追加
      if ($this->get_option("update") == true) {
        $update_href       = $this->get_page_url(["action" => "update", "id" => $pri_vals]);
        $actions['update'] = "<a href='" . esc_attr($update_href) . "'>{$this->__("Edit")}</a>";  // "編集"
      }

      // deleteが許可されていればdeleteリンクを追加
      if ($this->get_option("delete") == true) {
        $delete_href = $this->get_delete_url($pri_vals);
        // 削除リンクには現在のページ番号もつける
        $pagenum = $this->get_pagenum();  // $_REQUEST["paged"]を安全に取得。pagedがない時は1になる。
        if ($pagenum != 1) {  // 1は最初のページなので1以外の時のみ付与すればOK
          $delete_href .= sprintf("&paged=%s", $pagenum);
        }
        $actions["delete"] = "<a href='" . esc_attr($delete_href) . "'>{$this->__("Delete")}</a>";  // "削除"
      }

      return $this->row_actions($actions);
    }
  }

  /**
   * 並び替え可能なカラムを返却する
   * @return array|array[]
   */
  protected function get_sortable_columns() {
    $sortable_columns = [];
    if ($opt_sortable_columns = $this->get_option("list_sortable_columns")) {
      foreach ($opt_sortable_columns as $sortable_column) {
        // 2番目の値をtrueにすると最初のクリック時で降順にするっぽい。falseにすると最初のクリックで昇順になる
        $sortable_columns[$sortable_column] = [$sortable_column, true];
      }
    } else {
      // オプション指定がない場合は全て並び替え可能とする
      foreach ($this->fields as $column => $column_attr) {
        $sortable_columns[$column] = [$column, true];
      }
    }
    return $sortable_columns;
  }

  /**
   * displayの中で呼ばれる継承関数
   * @param string $which 'top' or 'bottom'
   */
  protected function extra_tablenav($which) {
    /**
     * ここで一括操作以外のボタンなどを作っていきます。
     * 注意すべきなのは、ここで<input type="submit" />を用意してしまうと、
     * 大元のformに含まれてしまいPOST時に複雑になるので、
     * <a class="button">でキックできるリンクを作るようにします。
     */

    // くどいのでtopだけの表示でよい
    if ($which == "top") {
      // 絞り込み機能（データ0件で非表示にしていないのは絞り込み結果で0件の時にダイアログが開けなくなるから）
      if ($this->get_option("filter") == true) {
        echo "
<div id='crudiator_filter' class='alignleft filter_action'>
  <button id='crudiator_filter_button' class='button' type='button'>{$this->__('Filter Data'/*'データを絞り込み'*/)}</button>
</div>";
      }

      if ($this->get_option("export") == true && count($this->items) > 0) {
        // エクスポート
        $export_encodes = [];
        if (get_user_locale() == "ja") {    // 日本の場合はSJISが主流なので先にSJIS
          $export_encodes["SJIS"] = "Shift-JIS";
        }
        $export_encodes["UTF-8"] = "UTF-8";

        // エクスポートは同じformに対してexport_actionをsubmitする
        echo '
        <div id="crudiator_export" class="alignleft export_action">
          <select class="export_encode" name="export_encode">';
        foreach ($export_encodes as $val => $str) {
          echo "<option value='" . esc_attr($val) . "'>" . esc_html($str) . "</option>";
        }
        echo "
          </select><input type='submit' name='export_action' class='button' value='{$this->__('Export')}' />
        </div>";
      }

      // データを全文検索又は絞り込みした場合はhiddenでそのパラメータを埋めておくと、
      // ページングの直入力実行でも適用される。（［>］ボタンは最初からリンクに付与されているので大丈夫）
      // また、全文検索と絞り込みは共存出来ないようにしている
      if ($search = $this->get_search_str()) {
        echo "<input type='hidden' name='s' value='" . esc_attr($search) . "' />";
      } else if ($filter_ary = $this->get_filter_ary()) {
        foreach ($filter_ary as $i => $filter) {
          echo "<input type='hidden' name='filter[" . esc_attr($i) . "][f]' value='" . esc_attr($filter["f"]) . "' />";
          echo "<input type='hidden' name='filter[" . esc_attr($i) . "][o]' value='" . esc_attr($filter["o"]) . "' />";
          echo "<input type='hidden' name='filter[" . esc_attr($i) . "][v]' value='" . esc_attr($filter["v"]) . "' />";
          if ($i >= 1 && isset($filter["ao"])) {
            echo "<input type='hidden' name='filter[" . esc_attr($i) . "][ao]' value='" . esc_attr($filter["ao"]) . "' />";
          }
        }
      }
      $view = filter_input(INPUT_GET, "view");
      if ($this->get_option("views") && $view) {
        echo "<input type='hidden' name='view' value='" . esc_attr($view) . "' />";
      }
      $sortable = $this->get_sortable_columns();
      $orderby  = filter_input(INPUT_GET, "orderby");
      $orderdir = filter_input(INPUT_GET, "order");
      if ($orderby && $orderdir && array_key_exists($orderby, $sortable) && in_array(strtoupper($orderdir), ["ASC", "DESC"])) {
        echo "<input type='hidden' name='orderby' value='" . esc_attr($orderby) . "' />";
        echo "<input type='hidden' name='order' value='" . esc_attr($orderdir) . "' />";
      }
    }
  }

  /**
   * チェックボックスのhtmlを返却する
   * @param object $item
   * @return string|void
   */
  protected function column_cb($item) {
    // 主キーの値を配列で取得してjsonにする。複合キーでも対応できるように。
    $value = json_encode($this->get_primary_values($item));
    return "<input type='checkbox' name='" . esc_attr($this->_args['singular']) . "[]' value='" . esc_attr($value) . "' />";
  }

  /**
   * 行のデータの値をhtmlで返却する
   * 値ごとに何か特殊なhtmlで返却したい場合はここでcolumn_nameで判断して変更して返却する
   * @param object $item
   * @param string $column_name
   */
  protected function column_default($item, $column_name) {

    // 特定ページの特定カラムのフィルター
    if (has_filter("crudiator_list_custom_column_{$this->page_name}_{$column_name}")) {
      $value = isset($item[$column_name]) ? $item[$column_name] : null;
      $html  = apply_filters("crudiator_list_custom_column_{$this->page_name}_{$column_name}", $value, $item);
      $html  = wp_kses_post($html); // scriptタグなどは無害化
    } else if (has_filter("crudiator_custom_column_{$this->page_name}_{$column_name}")) {
      $value = isset($item[$column_name]) ? $item[$column_name] : null;
      $html  = apply_filters("crudiator_custom_column_{$this->page_name}_{$column_name}", $value, $item);
      $html  = wp_kses_post($html); // scriptタグなどは無害化
    } else {
      // カスタム関数がない場合最適な値を返す
      if ($column_name == $this->get_primary_column()) {
        if ($this->get_option("detail") == true) {
          // プライマリーカラム（最初のカラム）の時だけ太字にする
          $url  = $this->get_page_url(["action" => "detail", "id" => $this->get_primary_values($item)]);
          $html = sprintf('<a href="%s" style="font-weight: bold;">%s</a>', esc_attr($url), $this->get_output_value($column_name, $item));
        } else if ($this->get_option("update") == true) { // detailがfalseの場合はWordPressっぽくupdateのリンクにする
          $url  = $this->get_page_url(["action" => "update", "id" => $this->get_primary_values($item)]);
          $html = sprintf('<a href="%s" style="font-weight: bold;">%s</a>', esc_attr($url), $this->get_output_value($column_name, $item));
        } else {
          $html = $this->get_output_value($column_name, $item);
        }
      } else {
        $html = $this->get_output_value($column_name, $item);
      }
    }
    return $html;
  }

  /**
   * 1行を出力するメソッド
   * trに主キーの値を埋め込みたいのでオーバーライドしている
   * @param array|object $item
   */
  public function single_row($item) {
    $pri_vals = $this->get_primary_values($item);
    echo '<tr class="crudiator-row" data-id="' . esc_attr(json_encode($pri_vals)) . '">';
    $this->single_row_columns($item);
    echo '</tr>';
  }

  /**
   * テーブル表示に必要なカラムの設定
   * @return array|mixed
   */
  public function get_columns() {
    $columns = [];

    // 一括処理が1つでもあればチェックボックスを入れる
    if (count($this->get_bulk_actions()) > 0) {
      $columns['cb'] = '<input type="checkbox" />';
    }

    // 最初にオプションのカラム指定があるか見る
    if ($option_list_columns = $this->get_option("list_columns")) { // リストカラムがまず優先 
      foreach ($option_list_columns as $column) {
        $columns[$column] = $this->get_display_as($column);
      }
    } else if ($option_columns = $this->get_option("columns")) {    // 次に共通カラム
      foreach ($option_columns as $column) {
        $columns[$column] = $this->get_display_as($column);
      }
    } else {
      // テーブル構造に従ってカラムを入れる
      // 注）fieldsを取得前にget_columnsを呼び出されることがありWarningとなるのでfieldsのNULLチェックをする
      // 2回のWarning出力なので恐らくテーブルの見出し部分かと思われる。
      // NULLの場合何も返さないことになるが、その後テーブル見出しは正常表示しているのでこれでも問題はないはず。
      if ($this->fields != null) {
        foreach ($this->fields as $column_name => $field) {
          // 全て出力すると表示量が多くなってしまうので、自動カラムの時はtextarea相当のものは飛ばす
          $form_parts_type = $this->auto_form_parts_type($field);
          if ($form_parts_type == "textarea") {
            continue;
          }
          // キーにカラム名を入れて、値にカラム文字列を入れる
          $columns[$column_name] = $this->get_display_as($column_name);
        }
      }
    }


    // keyが実データの連想配列のkey、valueがカラムの表示文字列となる
    return $columns;
  }

  /**
   * テーブル表示するときのデータ(items)を準備します。
   * @throws Exception
   */
  public function prepare_items() {
    try {
      // WP_List_Tablesが持つデータ配列プロパティは空配列で初期化する
      $this->items = [];

      $columns  = $this->get_columns();
      $screen   = get_current_screen();
      $hidden   = get_hidden_columns($screen);
      $sortable = $this->get_sortable_columns();
      $per_page = $this->get_per_page_value();

      $this->_column_headers = array($columns, $hidden, $sortable);

      // where条件配列を生成
      $where = $this->get_where();

      // 条件が決定したら、最初にこの条件の最大レコード数を取得する
      $total_items = $this->medoo->count($this->table, $where);

      // 次に一覧データを取得するので順番を決めるorder配列を生成
      $where["ORDER"] = $this->get_order();

      // get_pagenumの前にWP_List_Tableの関数でセットする
      $this->set_pagination_args(array(
        'total_items' => $total_items,                    // アイテム最大数
        'per_page'    => $per_page,                       // 現在のページ件数
        'total_pages' => ceil($total_items / $per_page)   // 最大ページ数
      ));

      // そして現在のページ番号を取得する（total_pagesを先にセットすることで範囲外を正すことができる。）
      $page_num = $this->get_pagenum();

      // 現在のページからのオフセット計算
      $offset         = $per_page * ($page_num - 1);
      $where["LIMIT"] = [$offset, $per_page]; // OFFSET LIMIT の配列で渡す

      // データ取得を実行
      // カラム指定は * にして全取得する必要がある。それによってオプションのカラム指定で主キーがなくても問題なくなる
      // TODO: blobデータのカラムとかを考えると、ここはデフォルトではカラム限定した方がいい
      $data = $this->medoo->select($this->table, "*", $where);

      $this->items = $data;

      return $data;
    } catch (PDOException $ex) {
      // Medooのcount()かselect()でPDOExceptionが発生する可能性があり、そういう場合は例外メッセージをエラー内容とする
      $this->last_error = $ex->getMessage();
      return false;
    }
  }

  ////////// ここまでWP_List_Tableのオーバーライドメソッド //////////

  /**
   * その時の状態に応じたwhere配列を生成して返却します
   * @return array|void
   */
  private function get_where() {
    $where = [];

    // viewパラメータがあってオプションとして有効な時はそちらを優先する
    $view = filter_input(INPUT_GET, "view", FILTER_DEFAULT);
    if ($view && $view_where = $this->get_option_sub("views", $view)) {
      // 配列じゃなかった場合はエラー
      if (!is_array($view_where)) {
        die($this->__("Only arrays are allowed for the view option. Please check the documentaion."));// "viewオプションは配列のみ許可されています。ドキュメントをご確認ください。"
      }

      foreach ($view_where as $key => $val) {
        // MATCHはMedooの複合where条件で使えないので禁止にする
        if (preg_match("/^(MATCH)/i", $key)) {
          die($this->__("The use of MATCH is not permitted in the VIEW."));
        } else if (preg_match("/^(AND|OR)/i", $key)) { // ANDかORの指定がある時はバッティング防止の為コメントつけて追加する
          $where[$key . " #view_where"] = $val;
        } else {
          $where["AND #view_where"] = $view_where;
        }
        break;
      }
    } else if ($option_where = $this->get_option("where")) {  // view指定がない時でwhere指定がある時
      // 配列じゃなかった場合はエラー
      if (!is_array($option_where)) {
        die($this->__("Only arrays are allowed for the where option. Please check the documentation."));
        // "whereオプションは配列のみ許可されています。ドキュメントをご確認ください。"
      }

      foreach ($option_where as $key => $val) {
        // MATCHはMedooの複合where条件で使えないので禁止にする
        if (preg_match("/^(MATCH)/i", $key)) {
          die($this->__("The use of MATCH is not permitted in the WHERE."));
        } else if (preg_match("/^(AND|OR)/i", $key)) { // ANDかORの指定がある時はバッティング防止の為コメントつけて追加する
          $where[$key . " #option_where"] = $val;
        } else {
          $where["AND #option_where"] = $option_where;
        }
        break;
      }
    }

    /**
     * 2023/03/21
     * Medooで全文検索の複合where条件は出来ないので一旦機能DROPする。
     * やるとするならMedoo::rawを使えば出来るかもしれない。
     */
//    if ($search = $this->get_search_str()) {
//      // TODO: 全文検索は他のwhere条件がうまくいってから確認する
//      die("全文検索は他のwhere条件がうまくいってから確認する");
//      $search               = preg_replace("/　/u", " ", $search);  // 全角スペースは半角スペースに変える
//      $fulltext_search_type = $this->get_option("fulltext_search_type");
//
//      $where["MATCH"] = [
//        "columns" => $this->fulltext_columns,
//        "keyword" => $search,
//        "mode"    => "boolean"
//      ];
//    }

    if ($filter_ary = $this->get_filter_ary()) {
      $filter_where_and = [];
      $filter_where_or  = [];
      foreach ($filter_ary as $i => $filter) {
        $field    = $filter["f"];
        $operator = $filter["o"];
        $value    = $filter["v"];

        // 2つ目の配列(添え字1)以降で、aoパラメータがORの時はこれまでのAND条件をマージする
        if ($i >= 1) {
          if (isset($filter["ao"]) && preg_match("/^(OR)$/i", $filter["ao"])) {
            // 注意）Medooで2段階のANDOR指定をする時は下位のキーにもANDコメントが必要！
            $filter_where_or["AND #{$i}"] = $filter_where_and;  // 同名キーじゃなければいいから$iを使う
            $filter_where_and             = []; // ORに入れたのでクリアする
          }
        }

        // where配列に条件を入れていく。複数条件の場合
        if ($operator == "eq") {            // equals
          $filter_where_and[$field . " #{$i}"] = $value;
        } else if ($operator == "neq") {    // not equal
          $filter_where_and["{$field}[!]" . " #{$i}"] = $value;
        } else if ($operator == "gt") {     // greater than
          $filter_where_and["{$field}[>]" . " #{$i}"] = $value;
        } else if ($operator == "ge") {     // greater than or equal to
          $filter_where_and["{$field}[>=]" . " #{$i}"] = $value;
        } else if ($operator == "lt") {     // less than
          $filter_where_and["{$field}[<]" . " #{$i}"] = $value;
        } else if ($operator == "le") {     // less than or equal to
          $filter_where_and["{$field}[<=]" . " #{$i}"] = $value;
        } else if ($operator == "cs") {     // contain string
          $filter_where_and["{$field}[~]" . " #{$i}"] = addcslashes($value, '\_%');  // LIKE系のユーザー入力の予約文字は無効化
        } else if ($operator == "ncs") {    // not contain string
          $filter_where_and["{$field}[!~]" . " #{$i}"] = $value;
        } else if ($operator == "sw") {     // start with
          $filter_where_and["{$field}[~]" . " #{$i}"] = addcslashes($value, '\_%') . "%";
        } else if ($operator == "nsw") {    // not start with
          $filter_where_and["{$field}[!~]" . " #{$i}"] = addcslashes($value, '\_%') . "%";
        } else if ($operator == "ew") {     // end with
          $filter_where_and["{$field}[~]" . " #{$i}"] = "%" . addcslashes($value, '\_%');
        } else if ($operator == "new") {    // not end with
          $filter_where_and["{$field}[!~]" . " #{$i}"] = "%" . addcslashes($value, '\_%');
        } else if ($operator == "isn") {    // is null
          $filter_where_and["{$field}" . " #{$i}"] = NULL;
        } else if ($operator == "isnn") {   // is not null
          $filter_where_and["{$field}[!]" . " #{$i}"] = NULL;
        }
      }

      // ORが一つでもある時は最後のAND条件を追加後、OR条件とする
      if (count($filter_where_or) > 0) {
        $filter_where_or["AND #last"] = $filter_where_and;
        $where["OR #filter_where"]    = $filter_where_or;
      } else {
        // ORが一つもない時はANDとして一応コメント付きのAND条件とする
        $where["AND #filter_where"] = $filter_where_and;
      }
    }

    return $where;
  }

  /**
   * その時の状態に応じたorder配列を生成して返却します
   * @return array|string[]
   */
  private function get_order() {
    $order_ary = [];
    $sortable  = $this->get_sortable_columns();

    // 並び替え指定は orderby と order があった時に指定する
    $orderby  = filter_input(INPUT_GET, "orderby");
    $orderdir = filter_input(INPUT_GET, "order");
    // sortable内で定義されていて且つascやdescかどうかのチェック
    if ($orderby && $orderdir && array_key_exists($orderby, $sortable) && in_array(strtoupper($orderdir), ["ASC", "DESC"])) {
      // ユーザー指定の順番とする
      $order_ary = [$orderby => strtoupper($orderdir)];
    } else {

      // 並び替え指定がない時はオプションの順番がまず優先
      if ($order_by = $this->get_option("list_order")) {
        foreach ($order_by as $column => $direction) {
          if (array_key_exists($column, $this->fields) && in_array(strtoupper($direction), ["ASC", "DESC"])) {
            $order_ary[$column] = $direction;
          }
        }
      } else {
        // オプションも指定ない時は主キーの昇順とする
        if (count($this->primary_keys) > 0) {
          $order_ary = [];
          foreach ($this->primary_keys as $key) {
            $order_ary[$key] = "ASC";
          }
        } else {  // 万が一主キーもなければ最初のカラムの昇順とする
          reset($this->fields);
          $first_key = key($this->fields);
          $order_ary = [$first_key => "ASC"];
        }
      }
    }

    return $order_ary;
  }

  /**
   * このページのURLを生成します。
   * WordPressのadmin_url関数は内部でDB呼び出しをするのでこの関数を使って負荷を軽くします。
   * @param $param    配列で渡すとQueryStringとなってURLに付与します。
   * @return string
   */
  private function get_page_url($param = null) {

    if (!$this->page_url) {
      $this->page_url = menu_page_url($this->page_name, false);
    }

    $page_url = $this->page_url;
    if ($param && is_array($param)) {
      $page_url .= "&" . http_build_query($param);  // 既にpageパラメータがあるから&でつなぐ
    }

    return $page_url;
  }

  /**
   * オプションを取得。存在しない場合はfalseを返却。
   * @param $name
   * @return bool|mixed
   */
  private function get_option($name, $default = false) {
    if (isset($this->options[$name])) {
      return $this->options[$name];
    }
    return $default;
  }

  /**
   * オプションの二次元配列までを調べる。
   * get_optionで多次元配列まで調べる書き方をしたかったけど、複雑になりすぎるので個別にした。
   * @param $name
   * @param $subname
   * @param $default
   * @return void
   */
  private function get_option_sub($name, $subname, $default = false) {
    if (isset($this->options[$name][$subname])) {
      return $this->options[$name][$subname];
    } else {
      return $default;
    }
  }

  /**
   * 1ページのアイテム表示件数の値を決定します。
   */
  private function get_per_page_value() {
    $key = "crudiator_{$this->page_name}_per_page";

    // まずユーザーmetaテーブルに値があればそれを使う
    $user_id        = get_current_user_id();
    $per_page_value = get_user_meta($user_id, $key, true);
    if ($per_page_value && is_numeric($per_page_value)) {
      return intval($per_page_value);
    }

    // 次にオプションの値を使う。この時カスタム設定があればその値となる。
    $list_perpage_number = $this->get_option("list_perpage_number");
    if ($list_perpage_number && is_numeric($list_perpage_number) && $list_perpage_number > 0) {
      return $list_perpage_number;
    }

    // ここはフェイルセーフでプラグインデフォルト値
    return self::DEFAULT_PER_PAGE;
  }

  /**
   * カラム名をオプションの指定文字列に変換して返却します。
   * @param $column_name
   * @return mixed
   */
  private function get_display_as($column_name) {
    // 配列であり指定のカラム名があれば
    if (is_array($this->display_as) && isset($this->display_as[$column_name])) {
      return $this->display_as[$column_name];
    } else {
      return $column_name;
    }
  }

  /**
   * DBの値をフロントに表示する際の変換関数です。
   * @param $column_name
   * @param $item
   * @return string
   */
  private function get_output_value($column_name, $item) {
    // もし$itemの中にこのカラムのキーがなければ空文字にしておく（独自カラムの関数忘れなど）
    if (!array_key_exists($column_name, $item)) {
      $html = "";
    } else if (is_null($item[$column_name])) {
      // null値は明示的にわかるようにする
      $html = "<span class='null-value'>(null)</span>";
    } else {
      // 出力用のhtmlを返すのでここでエスケープする。改行はデフォルトでbr変換する。
      $html = nl2br($this->h($item[$column_name]));
    }

    return $html;
  }

  /**
   * GETパラメータから主キーの値を取得します。
   * GETからの取得処理を1つにまとめたく。
   * @return mixed
   */
  private function get_primary_ids() {
    // idパラメータに単一キー又は複合キーの値が配列で入っているのでそれを取得する
    $ids = filter_input(INPUT_GET, 'id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    return $ids;
  }

  /**
   * データから主キーの値を取得する。
   * 値の順番はSHOW columsで取得したカラム順番に対応する
   * @param $row
   * @return array|false
   */
  private function get_primary_values($row) {
    $values = [];
    foreach ($this->primary_keys as $key) {
      if (!isset($row[$key])) {  // 主キーの値を取得しようとしてデータがない場合は異常事態。一旦falseを返却。
        return false;
      }
      $values[] = $row[$key];
    }
    return $values;
  }

  /**
   * Medooに渡す主キーのWHERE配列を作ります
   * @param $values
   * @return array
   */
  private function get_primary_where($values) {
    $where = [];
    foreach ($this->primary_keys as $idx => $key) {
      $where[$key] = $values[$idx];
    }
    return $where;
  }

  /**
   * 1レコードの削除URLを返します。
   * @param $ids    配列でidを渡します。複合キーの場合は複数値の配列で渡します。
   * @return string
   */
  private function get_delete_url($ids) {
    // 削除URLはそのまま削除処理につながるので、nonceが追加された安全なリンクを生成します。
    // 参考URL<https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/wp_nonce_url>
    $delete_url = wp_nonce_url($this->get_page_url(["action" => "delete", "id" => $ids]), "delete");
    return $delete_url;
  }

  /**
   * insertとupdateに必要なフォーム入力のname文字列の配列を取得する。
   * POSTからの取得処理を一つにまとめたく。
   * @return false|mixed
   */
  private function get_form_input_names() {
    $form_input_name_json = filter_input(INPUT_POST, self::FORM_INPUT_NAME_KEY);
    if (!$form_input_name_json) {
      return false;
    }

    $form_input_names = [];

    // json文字列をデコードして配列にする
    $form_input_name_ary = json_decode($form_input_name_json, true);
    if ($form_input_name_ary && is_array($form_input_name_ary)) { // デコードに成功していれば
      foreach ($form_input_name_ary as $input_name) {
        // テーブルのカラム名として実在するものだけにフィルタリングする
        if (isset($this->fields[$input_name])) {
          $form_input_names[] = $input_name;
        }
      }
    }

    return $form_input_names;
  }

  private function get_search_str() {
    $search = filter_input(INPUT_GET, 's', FILTER_DEFAULT);

    return $search;
  }

  /**
   * filter機能が有効で且つ、$_GETのfilterパラメータの形式が正しければ、
   * 添え字を振り直したfilter配列を返します。
   * ※各コードで必要になったので共通関数とした。
   *
   * @return false|null
   */
  private function get_filter_ary() {
    $filter_ary = [];
    /**
     * まず、filter機能が有効であること
     * filter配列が存在すること、配列であること
     */
    $filters = filter_input(INPUT_GET, 'filter', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($this->get_option("filter") && $filters) {
      // filter配列があればそのパラメータをチェック
      $valid_flag = false;
      foreach ($filters as $filter) {
        // issetは可変引数で渡せる
        if (isset($filter["f"], $filter["o"], $filter["v"], $this->operators[$filter["o"]])) {
          $filter_ary[] = $filter;
        } else {
          return false; // このパラメータがない場合はfalseを返す
        }
      }
    }
    return $filter_ary;
  }

  /**
   * データベースのテーブルのカラム情報を返します。
   * カラムのデータ型・デフォルト値・主キー・AutoIncrement等の情報を、カラム名をキーにした配列で返します。
   * @param $db_name
   * @param $table
   * @return array|false
   */
  private function get_db_columns_info($db_name, $table) {

    // SELECT文を構築していきます
    $sql = "SELECT *";

    // FROM句でMySQL専用のメタスキーマを指定する
    // ここでテーブル名を``で囲むとインスタンス化した時の接続DBを自動付与するので要注意。
    // ハードコーディングなので問題ない。
    $sql .= " FROM INFORMATION_SCHEMA.COLUMNS";

    // WHERE句の構成 インスタンス化した接続DBとは違うので直接記述
    $sql .= " WHERE `table_schema` = :table_schema AND `table_name` = :table_name";

    // ORDER句の構成 テーブル定義したカラム順番で取得したいのでこの指定をする
    $sql .= " ORDER BY `ordinal_position` ASC";

    // MedooのPrepared Statementで安全に取得する
    $results = $this->medoo->query(
      $sql, [
        ":table_schema" => $db_name,
        ":table_name"   => $table
      ]
    )->fetchAll();

    // 使いやすいようカラム名をキーにした配列にする
    $results = array_column($results, null, 'COLUMN_NAME');

    return $results;
  }

  /**
   * 指定テーブルのインデックス情報を取得します。
   * @param $db_name
   * @param $table
   * @return array|false
   */
  private function get_db_index_info($db_name, $table) {

    // SELECT文を構築していきます
    $sql = "SELECT *";

    // FROM句でMySQL専用のメタスキーマを指定する
    // ここでテーブル名を``で囲むとインスタンス化した時の接続DBを自動付与するので要注意。ハードコーディングなので問題ない。
    $sql .= " FROM INFORMATION_SCHEMA.STATISTICS";

    // WHERE句の構成 インスタンス化した接続DBとは違うので直接記述（_selectを使うとデータ型取得(_datatype)で同じ事をする為）
    $sql .= " WHERE `table_schema` = :table_schema AND `table_name` = :table_name";

    // MedooのPrepared Statementで安全に取得する
    $results = $this->medoo->query(
      $sql, [
        ":table_schema" => $db_name,
        ":table_name"   => $table
      ]
    )->fetchAll();

    return $results;
  }

  /**
   * 安全に配列の値を返却します。
   * @param       $item
   * @param array $array
   * @param       $default
   * @return mixed|null
   */
  private function element($item, array $array, $default = NULL) {
    return array_key_exists($item, $array) ? $array[$item] : $default;
  }

  /**
   * WordPressのnotice出力をします。
   * エラーやGETパラメータの条件が一致した時のみ出力します。
   * @return void
   */
  public function output_notice() {
    $notice_type = "";
    $notice_msg  = "";
    if ($this->last_error) {
      $notice_type = "notice-error";
      $notice_msg  = $this->last_error;
    } else if (isset($_GET["delete"], $_GET["delete_num"]) && $_GET["delete"] == "success" && !empty($_GET["delete_num"])) {
      $notice_type = "notice-success";
      $notice_msg  = $_GET["delete_num"] . $this->__(" items deleted."); /* 件のデータを削除しました。*/
    } else if (isset($_GET["insert"]) && $_GET["insert"] == "success") {
      $notice_type = "notice-success";
      $notice_msg  = $this->__("Data added."); /* "データを追加しました。" */
    } else if (isset($_GET["update"]) && $_GET["update"] == "success") {
      $notice_type = "notice-success";
      $notice_msg  = $this->__("Data updated."); /* "データを更新しました。" */
    }

    // エラーメッセージはこちらで制御しているからescしない
    if ($notice_type && $notice_msg) {
      echo "
<div class='notice " . esc_attr($notice_type) . " is-dismissible'>
  <p>" . esc_html($notice_msg) . "</p>
</div>
";
    }
  }

  /**
   * ヘッダーHTMLの出力
   * @param $action
   * @param $menu_title
   * @return void
   */
  private function output_header($action, $menu_title) {
    // 主キーカラム名をjsonで渡す
    $primary_keys_json = json_encode($this->primary_keys);  // json化してる時点でエスケープは要らない
    echo "
<script>
  var CRUDIATOR_PAGE_URL = '{$this->get_page_url()}';
  var CRUDIATOR_PRIMARY_KEYS = {$primary_keys_json};
</script>
<div id='crudiator-wrap' class='wrap crudiator action-" . esc_attr($action) . "'>
<h1 class='wp-heading-inline'>" . esc_html($menu_title) . "</h1>";
  }

  /**
   * フッターHTMLの出力
   * @return void
   */
  private function output_footer() {
    echo "</div><!--#crudiator-wrap-->";
  }

  private function output_error($notice_msg = "") {
    // WordPress準拠のhtml
    $this->output_header("error", $this->__("An error has occurred."));  // "エラーが発生しました。"

    /*
     * main処理で事前にnotice登録している場合はここでoutput_notice側の表示処理が入るが、
     * rendre処理でエラーの場合は直接notice_msgを渡してここで直で表示処理をする。
     */
    if ($notice_msg) {
      echo "
<div class='notice notice-error is-dismissible'>
  <p>" . esc_html($notice_msg) . "</p>
</div>
";
    }

    echo "
<div>
  <button class='button' onclick='window.history.back();'>{$this->__('Back')}</button>
</div>
";

    $this->output_footer();
  }

  private function output_debug_html() {
    $logs = [];

    // 何かしらのクエリを実行後に描画処理に遷移パターンがあるので、ここでデバッグ用クエリを抽出する
    if ($last_logs = get_user_meta($this->user->ID, 'crudiator_last_query', true)) {
      $logs = array_merge($logs, $last_logs);
      delete_user_meta($this->user->ID, "crudiator_last_query");  // 取得したら用済みなので空にする
    }

    // Medooで保存してある実行クエリを抽出
    if ($this->medoo) {
      $logs = array_merge($logs, $this->medoo->log());
    }

    if (!$logs) {
      return false;
    }
    $last_query = "";
    foreach ($logs as $log) {
      if ($last_query) {
        $last_query .= "\n";  // 次の行を足す前に改行
      }
      $last_query .= "> " . $log;
    }
    ?>
    <div id="crudiator-debug" data-show="on" style="display:none;">
      <div class="expand-btn"></div>
      <div class="crudiator-debug-wrap" style="">
        <div class="crudiator-debug-content">
          <h4>[Crudiator] Executed Query : </h4><code><?php echo nl2br(esc_html($last_query)) ?></code>
        </div>
      </div>
    </div>
    <?php
  }

  private function output_table_html() {
    // WordPress準拠のhtml
    $this->output_header("table", $this->menu_title);

    if ($this->get_option("insert") == true) {
      $insert_href = $this->get_page_url(['action' => 'insert']);
      echo "<a href='" . esc_attr($insert_href) . "' class='page-title-action'>{$this->__('Add New')}</a>"; /*'新規追加'*/
    }

    // 検索実行時の検索文字列等をサブタイトルとして表示
    $this->output_subtitle();

    echo '<hr class="wp-header-end">';

    // viewリンクの表示
    $this->views();

    /**
     * 全文検索フォーム
     * tableフォームに含めると他のパラメータとの共存が色々面倒になるので切り離している。
     */
    if ($this->get_option("fulltext_search") && $this->fulltext_columns) {
      echo "<form id='crudiator_search_form' method='GET' action='" . esc_attr($this->get_page_url()) . "'>
        <input type='hidden' name='page' value='" . esc_attr($this->page_name) . "'/>";
      $this->search_box($this->__('Search Text'), 'fulltext'/*'テキストを検索'*/);
      echo "</form>";
    }

    /**
     * メインフォームのmethodは一括操作で多くのパラメータを送る事を懸念してPOSTがいいと思っていたけど、
     * 2022年8月現在、URLの文字数制限はIE亡き世界では、Safari(Mac)の4096文字までの模様。
     * 参考良記事<https://qiita.com/pro_matuzaki/items/70fb639f7ed7463f9943>
     * なのでGETでも問題なさそうだし、WordPress本体の投稿一覧のフォームでもGETを使っているのでGETを採用する。
     * で、GETにするとactionのURLのQueryStringは消えるので、ちゃんとhiddenでpageパラメータを書いておく。
     */
    ?>
    <form id="crudiator_form" method="GET" action="<?php echo esc_attr($this->get_page_url()) ?>">
      <input type="hidden" name="page" value="<?php echo esc_attr($this->page_name) ?>"/>
      <?php $this->display(); ?>
    </form>

    <?php

    if ($this->get_option("filter") == true) {
      $this->output_filter_dialog();
    }

    $this->output_footer();
  }


  private function output_detail_html() {
    // GETパラメータから主キー値取得
    $ids   = $this->get_primary_ids();
    $where = $this->get_primary_where($ids);
    $row   = $this->medoo->get($this->table, "*", $where);

    $update_href = $this->get_page_url(["action" => "update", "id" => $ids]);
    $delete_href = $this->get_delete_url($ids);

    $detail_fields = [];
    if ($detail_columns = $this->get_option("detail_columns")) {
      foreach ($detail_columns as $column) {
        // detailの場合はレコード値なくてもカスタムカラムで出力するかもしれないので空文字入れておく
        $detail_fields[$column] = (isset($row[$column])) ? $row[$column] : "";
      }
    } else if ($base_columns = $this->get_option("columns")) {
      foreach ($base_columns as $column) {
        // detailの場合はレコード値なくてもカスタムカラムで出力するかもしれないので空文字入れておく
        $detail_fields[$column] = (isset($row[$column])) ? $row[$column] : "";
      }
    } else {
      $detail_fields = $row;
    }

    $this->output_header("detail", $this->__("View Data"));  // "データを詳細表示"
    ?>
    <table class="form-table">
      <tbody>
        <?php foreach ($detail_fields as $key => $val) { ?>
          <tr>
            <th scope="row">
              <?php echo $this->h($this->get_display_as($key)) ?>
            </th>
            <td>
              <?php
              if (has_filter("crudiator_detail_custom_column_{$this->page_name}_{$key}")) {
                $value = isset($row[$key]) ? $row[$key] : null;
                $html  = apply_filters("crudiator_detail_custom_column_{$this->page_name}_{$key}", $value, $row);
                echo wp_kses_post($html);
              } else if (has_filter("crudiator_custom_column_{$this->page_name}_{$key}")) {
                $value = isset($row[$key]) ? $row[$key] : null;
                $html  = apply_filters("crudiator_custom_column_{$this->page_name}_{$key}", $value, $row);
                echo wp_kses_post($html);
              } else {
                echo $this->get_output_value($key, $detail_fields);
              } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p class="detail-buttons">
      <?php
      if ($this->get_option("update") == true) {
        echo "<a href='" . esc_attr($update_href) . "' class='button update'>{$this->__('Edit')}</a>";  /*'編集'*/
      }
      if ($this->get_option("delete") == true) {
        echo "<a href='" . esc_attr($delete_href) . "' class='button button-danger delete'>{$this->__('Delete')}</a>";  /*'削除'*/
      }
      ?>
    </p>
    <?php
    $this->output_footer();
  }

  private function output_insert_html() {
    // ユーザーオプションがある場合はそれを出力します
    $insert_fields  = [];
    $insert_columns = $this->get_option("insert_columns", []);
    if ($insert_columns) {
      foreach ($insert_columns as $column) {
        if (isset($this->fields[$column])) {
          $insert_fields[$column] = $this->fields[$column];
        }
      }
    } else if ($base_columns = $this->get_option("columns")) {
      foreach ($base_columns as $column) {
        if (isset($this->fields[$column])) {
          $insert_fields[$column] = $this->fields[$column];
        }
      }
    } else {
      $insert_fields = $this->fields;
    }
    $autocomplte = $this->get_option("autocomplete");
    $this->output_header("insert", $this->__("Add New Data"));  // "新規データを追加"
    ?>
    <?php if ($this->get_option("require_columns")) { ?>
      <p class='required-warning'><?php echo $this->__("* required fields") /* "* は必須項目です" */ ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo esc_attr($this->get_page_url(["action" => "insert"])) ?>" autocomplete="<?php echo esc_html($autocomplte) ?>">
      <table class="form-table">
        <tbody>
          <?php
          $form_names = [];
          foreach ($insert_fields as $column_name => $column_attr) {
            // MySQL側で自動で値がセットされるカラムの場合は項目としてデフォルトでは出さない。
            // ただし、insert_columnsで指定していた場合は入力出来る。
            if ($this->is_auto_value_column($column_attr) && !in_array($column_name, $insert_columns)) {
              continue;
            }
            ?>
            <tr>
              <th scope="row">
                <?php $this->output_input_header($column_name); ?>
              </th>
              <td>
                <div class="form-parts-box">
                  <?php
                  $form_names[] = $column_name;
                  $this->output_input_parts($column_attr, $column_name);
                  ?>
                </div>
                <?php
                if ($description = $this->get_option_sub("description", $column_name)) {
                  echo '<p class="description">' . wp_kses_post($description) . '</p>';
                } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php $this->output_form_names_hidden($form_names); ?>
      <?php wp_nonce_field('insert'); ?>
      <?php submit_button($this->__("Save")); /*"保存"*/ ?>
    </form>
    <?php
    $this->output_footer();
  }

  private function output_update_html() {
    // GETパラメータから主キー値取得
    $ids   = $this->get_primary_ids();
    $where = $this->get_primary_where($ids);
    $row   = $this->medoo->get($this->table, "*", $where);

    // 最終的にこの配列に入るカラムが編集対象カラム
    $update_fields = [];

    // ユーザーオプションがある場合はそれを出力します
    $update_columns = $this->get_option("update_columns", []);
    if ($update_columns) {
      foreach ($update_columns as $column) {
        if (isset($this->fields[$column])) {
          $update_fields[$column] = $this->fields[$column];
        }
      }
    } else if ($base_columns = $this->get_option("columns")) {
      foreach ($base_columns as $column) {
        if (isset($this->fields[$column])) {
          $update_fields[$column] = $this->fields[$column];
        }
      }
    } else {
      $update_fields = $this->fields;
    }
    $autocomplte = $this->get_option("autocomplete");
    $this->output_header("update", $this->__("Edit Data")); // "データ編集"
    ?>
    <a href="<?php echo $this->get_page_url(["action" => "insert"]) ?>" class="page-title-action"><?php echo $this->__("Add New") /* "新規追加" */ ?></a>
    <hr class="wp-header-end">

    <?php if ($this->get_option("require_columns")) { ?>
      <p class='required-warning'><?php echo $this->__("* required fields"); /* "* は必須項目です" */ ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo $this->get_page_url(["action" => "update", "id" => $ids]) ?>" autocomplete="<?php echo $autocomplte ?>">
      <table class="form-table">
        <tbody>
          <?php
          $form_names = []; // このformの入力として求めるname集
          foreach ($update_fields as $column_name => $column_attr) {
            $readonly = false;
            // ここでreadonly判定をするが、update_columnsで指定している場合は、
            // PRIMARYやAUTOINCREMENT関係なく編集可能とする(readonlyにすることはない)のでまず配列存在チェックする。
            if (!in_array($column_name, $update_columns)) {
              if ($column_attr["COLUMN_KEY"] == "PRI") {
                // 主キーがAUTO_INCREMENTの場合は編集禁止
                $readonly = true;
              } else if ($this->is_auto_value_column($column_attr)) {
                // MySQL側で自動で値がセットされるカラムの場合は編集禁止
                $readonly = true;
              }
            }
            ?>
            <tr>
              <th scope="row">
                <?php $this->output_input_header($column_name); ?>
              </th>
              <td>
                <div class="form-parts-box">
                  <?php
                  // readonly項目は値表示のみ
                  if ($readonly) {
                    echo isset($row[$column_name]) ? $this->h($row[$column_name]) : "";
                  } else {
                    $form_names[] = $column_name;
                    $this->output_input_parts($column_attr, $column_name, $row);
                  }
                  ?>
                </div>
                <?php
                if ($description = $this->get_option_sub("description", $column_name)) {
                  echo '<p class="description">' . wp_kses_post($description) . '</p>';
                } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php $this->output_form_names_hidden($form_names); ?>
      <?php wp_nonce_field('update'); ?>
      <?php submit_button($this->__("Save Changes")); /*"変更を保存"*/ ?>
    </form>
    <?php
    $this->output_footer();
  }

  private function output_subtitle() {
    if ($search = $this->get_search_str()) {
      echo "<span class='subtitle'>{$this->__("Search results for")}: <strong>" . esc_html($search) . "</strong></span>";/*検索結果*/
    } else if ($this->get_option("filter") == true) { ?>
      <?php
      // 絞り込み条件のパラメータがある時はその条件文字列を列挙する
      $locale     = get_user_locale();
      $filter_str = "";
      if ($filter_ary = $this->get_filter_ary()) {
        foreach ($filter_ary as $i => $filter) {
          // 2個目(添え字1)からは論理演算子付与
          if ($i >= 1 && isset($filter["ao"])) {
            $filter_str .= " " . $filter["ao"] . " ";
          }
          $filter_str .= $this->get_display_as($filter["f"]);
          $filter_str .= ($locale == "ja") ? " は " : " ";      // 日本だけ意味が通るように「は」を入れる
          $filter_str .= $this->operators[$filter["o"]];
          // IS NULL系ではなかったら、値を出力する
          if (!preg_match("/is/i", $filter["o"])) {
            $filter_str .= " ({$filter["v"]})";
          }
        }
        echo "<span class='subtitle'>{$this->__("filter condition : ")}<strong>" . esc_html($filter_str) . "</strong></span>";
      } ?>
    <?php }
  }

  private function output_input_header($column_name) {
    $html = "<span class='input-header-label'>" . esc_html($this->get_display_as($column_name)) . "</span>";
    // 入力必須カラム
    $require_columns = $this->get_option("require_columns");

    if ($require_columns && in_array($column_name, $require_columns)) {
      $html .= "<span class='required-label'>*</span>";
    }

    echo $html;
  }

  private function output_input_parts($column_attr, $column_name, $row = null) {
    $action = $this->current_action();

    // short name
    $n = $column_name;  // name
    $v = "";            // value

    // 入力必須カラム
    $r               = ""; // required
    $require_columns = $this->get_option("require_columns");
    if ($require_columns && in_array($n, $require_columns)) {
      $r = "required";
    }

    // 入力タイプのオプション有無
    $input_type = $this->get_option_sub("input_type", $n, false);

    // 入力タイプが手動でも自動でもvalue決定処理は同じなのでここでする
    if ($action == "insert") {
      // insert画面ではデフォルト値の指定がある時のみ
      if ($input_type && isset($input_type["default"])) {
        $v = $input_type["default"];
      }
    } else if ($action == "update") {
      // update画面ではDBデータがあってNULLではない時
      if ($row && array_key_exists($n, $row) && !is_null($row[$n])) {
        // 生のDBデータを出力したいのでWPのapply_filterを含むesc_htmlは使わず、純粋なhtmlspecialcharsを使う。
        $v = $row[$n];
      }
    }

    // このカラムに入力タイプがある場合はそっちを優先する
    if ($input_type) {
      // 指定が配列の場合は特殊フィールドタイプ
      $type = $input_type["type"];

      // placeholder指定
      $ph = "";
      if (isset($input_type["placeholder"])) {
        $ph = "placeholder='{$this->h($input_type["placeholder"])}'";
      }

      // WordPress標準のwidthを設定するclassを付与する
      $class_ary = ["form-parts", $type];
      if ($type == "textarea") {
        $class_ary[] = "large-text";
      } else if (in_array($type, ["integer", "text", "password", "date", "time", "datetime"])) {
        $class_ary[] = "regular-text";
      } else {
        // radioやdropdown等は何もしないのが美しい
      }
      $c = implode(" ", $class_ary);

      $max = "";
      if (isset($input_type["maxlength"])) {
        $max = "maxlength='{$this->h($input_type["maxlength"])}'";
      }

      if ($type == "integer") {
        $html = "<input type='text' name='{$this->h($n)}' class='{$c}' value='{$this->h($v)}' {$ph} {$r} {$max}/>";
      } else if ($type == "text") {
        $html = "<input type='text' name='{$this->h($n)}' class='{$c}' value='{$this->h($v)}' {$ph} {$r} {$max}/>";
      } else if ($type == "textarea") {
        $html = "<textarea name='{$this->h($n)}' class='{$c}' rows='10' cols='50' {$ph} {$r} {$max}>{$this->h($v)}</textarea>";
      } else if ($type == "password") {
        $html = "<input type='password' name='{$this->h($n)}' class='{$c}' value='{$this->h($v)}' {$ph} {$r} {$max}/>";
      } else if ($type == "radio") {
        $rule        = $input_type["rule"];
        $html        = "<fieldset class='radio-field'>";
        $is_pure_ary = (array_values($rule) === $rule); // trueなら普通配列、falseなら連想配列
        foreach ($rule as $val => $str) {
          $val     = ($is_pure_ary) ? $str : $val;  // 普通配列なら表示文字を値にも使う
          $checked = ($v && $v == $val) ? "checked" : "";
          $html    .= "<p><label><input type='radio' name='{$this->h($n)}' class='{$c}' value='{$val}' {$checked} {$r} />{$str}</label></p>";
        }
        $html .= "</fieldset>";
      } else if ($type == "dropdown" || $type == "multiselect") {
        $rule        = $input_type["rule"];
        $multiple    = ($type == "multiselect") ? "multiple" : "";
        $html        = "<select name='{$this->h($n)}' {$multiple} class='{$c}' {$r}>";
        $is_pure_ary = (array_values($rule) === $rule); // trueなら普通配列、falseなら連想配列
        foreach ($rule as $val => $str) {
          $val     = ($is_pure_ary) ? $str : $val;  // 普通配列なら表示文字を値にも使う
          $checked = ($v && $v == $val) ? "selected" : "";
          $html    .= "<option value='{$val}' {$checked}>{$str}</option>";
        }
        $html .= "</select>";
      } else if ($type == "date") {
        $html = "<input type='text' name='{$this->h($n)}' class='{$c}' value='{$this->h($v)}' {$ph} {$r} {$max}/>";
      } else if ($type == "time") {
        $html = "<input type='text' name='{$this->h($n)}' class='{$c}' value='{$this->h($v)}' {$ph} {$r} {$max}/>";
      } else if ($type == "datetime") {
        $html = "<input type='text' name='{$this->h($n)}' class='{$c}' value='{$this->h($v)}' {$ph} {$r} {$max}/>";
      } else {
        throw new LogicException($this->__("Unknown input type specified")/*"不明な入力タイプが指定されました"*/);
      }

      echo $html;
    } else {  // 自動判定
      // MySQLのデータ型から入力タイプを自動判定
      $type = $this->auto_form_parts_type($column_attr);
      /*
       * 自動判定処理についての実装ポリシー
       * 
       * ■default値について
       * MySQL側のDefault値をinputやtextareaのvalueとして事前セット、はしない。
       * 何故ならDefault値でNULLはよく使われるがそれを適用して新規画面でNULLチェックボックスをONにすると
       * 入力のユーザービリティに欠けるから。
       * では、NULL以外のDefault値を事前セットするという考えもあるが、そうなると仕様として煩雑になるので、
       * やはり自動判定で事前セットはせず、未入力にした時にMySQLのDefault値を活かす、とするのが良い。
       * 
       * ■maxlengthについて
       * MySQLのvarchar(50)等のデータ長が取れる時はそれをmaxlength属性として適用する。
       * 厳密には日本語1文字は3バイトあるので整合が取れない事があるが、テーブルのcharsetがutf8やutf8mb4なら
       * varchar(50)は日本語でも50文字までとなるので問題ない。
       * しかも最近ではcharsetにutf8やutf8mb4が推奨されて設定されているので、ユーザビリティ向上の為にも自動設定が良い。
       * どうしてもmaxlengthを変えたい場合はカスタム設定を案内する。
       */
      $max = "";
      if (isset($column_attr["CHARACTER_MAXIMUM_LENGTH"]) && is_numeric($column_attr["CHARACTER_MAXIMUM_LENGTH"])) {
        $max = 'maxlength="' . $column_attr["CHARACTER_MAXIMUM_LENGTH"] . '"';
      }
      if ($type == "textarea") {
        echo "<textarea name='{$this->h($n)}' class='large-text {$this->h($type)} form-parts' rows='10' cols='50' {$max} {$this->h($r)}>{$this->h($v)}</textarea>";
      } else {
        // 編集画面でデータがNULLじゃなければ$valueを復元
        echo "<input type='text' name='{$this->h($n)}' {$max} class='regular-text {$this->h($type)} form-parts' value='{$this->h($v)}' {$this->h($r)}/>";
      }
    }

    // NOT NULLではないNULL値が許可されたカラムはNULLチェックボックスを用意
    /**
     * 「not_null_columnsというオプションの実装有無についての考察」
     *  MySQLのNOT NULL制約がついてないカラムでも、カスタムでNULLチェックボックスを非表示出来る事を考えたが、
     *  それが出来ると、Default値がNULLになっていて新規挿入で未入力の時にNULLがセットされて、以後NULLから戻せない、
     *  という現象が発生するのでやめた。Default値がNULLではない時にのみそのようなカスタムが出来てもいいが、
     *  それだと仕様が煩雑になるのでよくないと思われる。
     */
    if (strtoupper($column_attr["IS_NULLABLE"]) == "YES") {
      $checked = ($row && is_null($row[$n])) ? "checked" : "";
      echo "<label class='null-checkbox'><input type='checkbox' class='form-parts-null' {$this->h($checked)} /><span>null</span></label>";
    }

  }

  /**
   * データを絞り込みの<li>を出力します
   * filter[]のindexはsubmit時に振りなおします。（なので厳密にはPHP側でname属性は定義しなくてもいい。。）
   * @param null $idx
   * @param null $filter
   * @return void
   */
  private function output_filter_li($idx = null, $filter = null) {
    $i        = (is_null($idx)) ? "" : $idx;
    $andor    = (isset($filter["ao"])) ? $filter["ao"] : null;
    $field    = (isset($filter["f"])) ? $filter["f"] : null;
    $operator = (isset($filter["o"])) ? $filter["o"] : null;
    $value    = (isset($filter["v"])) ? $filter["v"] : null;

    /* 絞り込み対象カラムを決定 */
    if ($option_filter_columns = $this->get_option("filter_columns", [])) {
      $filter_columns = $option_filter_columns;
    } else if ($option_columns = $this->get_option("columns", [])) {
      $filter_columns = $option_columns;
    } else {
      $filter_columns = array_keys($this->fields);  // テーブルカラムがデフォルト
    }
    ?>
    <li>
      <fieldset class="andor-radio">
        <?php
        $andOrAry = ["AND", "OR"];
        foreach ($andOrAry as $_andor) {
          $checked = "";
          // nullの時はANDがデフォルトcheckedにする。nullでない時は同値の時
          if (($andor == null && $_andor == "AND") || ($andor != null && $andor == $_andor)) {
            $checked = "checked='checked'";
          }
          echo "
<label>
  <input class='andor' type='radio' name='filter[" . esc_attr($i) . "][ao]' value='" . esc_attr($_andor) . "' " . esc_html($checked) . " />" . esc_html($_andor) . "
</label>";
        }
        ?>
      </fieldset>
      <div class="condition">
        <button type="button" class="button button-del-condition">-</button>
        <select class="field" name="filter[<?php echo esc_attr($i) ?>][f]">
          <?php foreach ($this->fields as $column_name => $_field) {
            // 絞り込みカラムの指定配列に含まれなかったら除外
            if (!in_array($column_name, $filter_columns)) {
              continue;
            }
            // fieldが渡されて選択肢内にあったら
            $selected     = (!is_null($field) && $field == $column_name) ? "selected" : "";
            $display_name = $this->get_display_as($column_name);
            echo "<option value='" . esc_attr($column_name) . "' " . esc_attr($selected) . ">" . esc_html($display_name) . "</option>";
          } ?>
        </select>
        <select class="operator" name="filter[<?php echo esc_attr($i) ?>][o]">
          <?php foreach ($this->operators as $val => $string) {
            // operatorが渡されて選択肢内にあったら
            $selected = (!is_null($operator) && $operator == $val) ? "selected" : "";
            echo "<option value='" . esc_attr($val) . "' " . esc_attr($selected) . ">" . esc_html($string) . "</option>";
          } ?>
        </select>
        <?php
        $val = (!is_null($value)) ? $value : '';
        $ro  = "";
        // operatorが渡されてIS, IS NOT系だった場合はreadonly属性にしてvalueを消去
        if (!is_null($operator) && preg_match("/is/i", $operator)) {
          $val = "";
          $ro  = "readonly";
        }
        echo "<input type='text' class='value' name='filter[" . esc_attr($i) . "][v]' value='" . esc_attr($val) . "' " . esc_attr($ro) . "/>";
        ?>
      </div>
    </li>
  <?php }

  /**
   * データを絞り込みダイアログのhtmlを出力します。
   * @return void
   */
  private function output_filter_dialog() {
    $filter_ary = $this->get_filter_ary();
    $class      = ($filter_ary && count($filter_ary) > 1) ? "multi-condition" : ""; // 複数条件ある時のクラス名付与
    ?>
    <div id="crudiator-filter-wrap" class="notification-dialog-wrap file-editor-warning hidden">
      <div id="crudiator-filter-dialog-background" class="notification-dialog-background"></div>
      <div id="crudiator-filter-dialog" class="notification-dialog">
        <div id="crudiator-filter-dialog-content" class="<?php echo esc_attr($class) ?>">
          <form id="crudiator-filter-form" method="GET" action="<?php echo esc_attr($this->get_page_url()) ?>">
            <?php // GETのform送信ではactionのGETパラメータが消える為hiddenでpage_nameを記述 ?>
            <input type="hidden" name="page" value="<?php echo esc_attr($this->page_name) ?>"/>
            <?php if (isset($_GET["view"])) { ?>
              <input type="hidden" name="view" value="<?php echo esc_attr($_GET["view"]) ?>"/>
            <?php } ?>
            <h1><?php echo $this->__("Filter Data") /* "データを絞り込み" */ ?></h1>
            <?php
            $li_cnt = 1;  // liの数。初期値は未入力条件1つあるので1。
            if (is_array($filter_ary) && count($filter_ary) > 0) {  // filter指定がある時は配列の数
              $li_cnt = count($filter_ary);
            }
            ?>
            <ul class="condition-list" data-li_cnt="<?php echo esc_attr($li_cnt) ?>">
              <?php
              // 条件指定があった時はここでその条件を復元
              if ($filter_ary) {
                foreach ($filter_ary as $i => $filter) {
                  $this->output_filter_li($i, $filter);
                }
              } else {
                // 条件指定がない時は添え字0で、値の入っていない1行だけ出力
                $this->output_filter_li(0);
              }
              ?>
            </ul>
            <div class="condition-option">
              <button type="button" class="button button-add-condition">+</button>
            </div>
            <p class="crudiator-filter-buttons">
              <?php if ($filter_ary) { ?>
                <a class="remove_filter" href="<?php echo esc_attr($this->get_page_url()) ?>"><?php echo $this->__("Reset filter") /* "絞り込みを解除" */ ?></a>
              <?php } ?>
              <button type="button" class="button button-cancel"><?php echo $this->__("Cancel") /* "キャンセル" */ ?></button>
              <button type="submit" class="button button-primary button-exec"><?php echo $this->__("Start") /* "開始" */ ?></button>
            </p>
          </form>
        </div>
      </div>

      <template id="crudiator-condition-template">
        <?php // jsから複製出来る用にここで空のliを出力する
        $this->output_filter_li(); ?>
      </template>

    </div>
    <?php
  }

  /**
   * カラム情報から自動で
   * @param $column_attr
   * @return string
   */
  private function auto_form_parts_type($column_attr) {
    $datatype = strtolower($column_attr["DATA_TYPE"]);

    // $typeには "int(11) unsigned", "varchar(255)", "datetime" など様々な文字列が入るのでここで判定処理
    // int(11)やdecimal(10,3)など桁数指定があったりするのでpreg_match判定が最適
    if (preg_match("/int/", $datatype)) {
      $form_component = "integer";
    } else if (preg_match("/decimal|numeric|float|double/", $datatype)) {
      $form_component = "float";
    } else if ($datatype == "date") {
      $form_component = "date";
    } else if ($datatype == "time") {
      $form_component = "time";
    } else if (in_array($datatype, ["datetime", "timestamp"])) {
      $form_component = "datetime";
    } else if (preg_match("/year/", $datatype)) {
      $form_component = "integer";
    } else if (preg_match("/char/", $datatype)) {  // CHAR, VARCHAR
      $form_component = "text";
      // 500文字以上ならtextareaにする
      if (isset($column_attr["CHARACTER_MAXIMUM_LENGTH"]) && intval($column_attr["CHARACTER_MAXIMUM_LENGTH"]) >= 500) {
        $form_component = "textarea";
      }
    } else if (strpos($datatype, "text") !== false) {  // TEXT, LONGTEXT, MEDIUMTEXT, TINYTEXT
      $form_component = "textarea";
    } else if (preg_match("/json/", $datatype)) {
      $form_component = "textarea";
    } else if (preg_match("/blob/", $datatype)) {
      $form_component = "textarea";
    } else {
      // 判定出来ないものは全てtextとする
      $form_component = "text";
    }

    return $form_component;
  }

  /**
   * 挿入と更新で対象となるnamesを出力しておく
   * @param $form_names
   */
  private function output_form_names_hidden($form_names) {
    $names_json = json_encode($form_names);
    echo '<input type="hidden" name="' . self::FORM_INPUT_NAME_KEY . '" value="' . $this->h($names_json) . '" />';
  }

  /**
   * 自動で値がセットされるカラムかどうかを返却します。
   * @param $column_attr  MySQLから取得出来るカラム属性情報
   * @return bool         trueの場合は自動で値がセットされるカラムです。
   */
  private function is_auto_value_column($column_attr) {
    // 自動採番(AUTO_INCREMENT)か、自動日付(CURRENT_TIMESTAMP)の場合はtrue。
    // 20230504 MariaDBの場合は、COLUMN_DEFAULT に "current_timestamp()" で括弧が入っているので、
    // 文字列を含むかどうかの為にstriposを使っている。
    // strposではなく、大文字小文字を区別しないstriposを使って判定。
    if ((!empty($column_attr["EXTRA"]) && stripos($column_attr["EXTRA"], "AUTO_INCREMENT") !== false) ||
      (!empty($column_attr["COLUMN_DEFAULT"]) && stripos($column_attr["COLUMN_DEFAULT"], "CURRENT_TIMESTAMP") !== false)) {
      return true;
    }
    return false;
  }

  /**
   * assetsをwp_enqueueに入れてフロントソースを読み込みます。
   * verを自動付与します。
   * @param array $assets_js
   * @param array $assets_css
   */
  private function wp_enqueue_assets($assets_js = [], $assets_css = []) {
    // js
    foreach ($assets_js as $handle => $asset) {
      $src = CRUDIATOR_DIR_URL . $asset[0];
      $ver = ($this->is_local()) ? false : date("YmdHis", filemtime(CRUDIATOR_DIR . "/" . $asset[0]));
      if (isset($asset[1])) {
        $deps = $asset[1];
      } else {
        $deps = [];
      }
      wp_enqueue_script($handle, $src, $deps, $ver);
    }

    // css
    foreach ($assets_css as $handle => $asset) {
      $src = CRUDIATOR_DIR_URL . $asset[0];
      $ver = ($this->is_local()) ? false : date("YmdHis", filemtime(CRUDIATOR_DIR . "/" . $asset[0]));
      if (isset($asset[1])) {
        $deps = $asset[1];
      } else {
        $deps = [];
      }
      wp_enqueue_style($handle, $src, $deps, $ver);
    }
  }

  /**
   * オプションとして機能が有効かのチェックとnonceチェックをまとめてします。
   * @param $option_name
   * @param $nonce_action   wp_verify_nonceをしたい時もあるので空文字じゃなければcheck_admin_refererを実行する
   * @return void
   */
  private function check_option_and_nonce($option_name, $nonce_action = "") {
    // 機能有効チェック
    if ($this->get_option($option_name) == false) {
      $this->redirect_menutop_exit(); // 有効でない場合はメニュートップに飛ばす
    }

    // nonceチェック。false判定を見ているけどnonceエラーの場合は関数内でdie()となる
    if ($nonce_action) {
      check_admin_referer($nonce_action);
    }
  }

  /**
   * detail, update, delete で使うQueryStringの主キーパラメータが正しいかどうかを判定します。
   * 異常があった場合はエラーメッセージにエラー内容をセットして、render処理で表示。
   * @return void
   */
  private function check_primary_key_param() {
    // GETパラメータから主キー値取得
    $ids = $this->get_primary_ids();

    // idキーの値を取得出来ないのはエラー
    if (!$ids || !is_array($ids) || count($ids) == 0) {
      $this->last_error = $this->__("Invalid parameter");     /*"不正なパラメータです"*/
      return false;
    }

    // 主キーの分だけidキーの値がないのはエラー（単一主キーで2つ以上あってもNGだし、複合キーでその数だけないのもNG）
    if (count($ids) != count($this->primary_keys)) {
      $this->last_error = $this->__("Invalid parameter");     /*"不正なパラメータです"*/
      return false;
    }

    // この関数を使う時は、detail, update, delete で、既に単一データが存在するはずなので、データ有無チェック
    $where = $this->get_primary_where($ids);
    $exist = $this->medoo->has($this->table, $where);

    if (!$exist) {
      $this->last_error = $this->__("Data does not exist.");  // データが存在しません。  
      return false;
    }

    return true;
  }

  /**
   * リストページにリダイレクトします
   */
  private function redirect_menutop_exit() {
    $this->redirect_exit($this->get_page_url());
  }

  /**
   * リダイレクトして忘れないようにexitまで実行します
   * @param $url
   */
  private function redirect_exit($url) {
    wp_redirect($url);
    exit;
  }

  /**
   * データの挿入処理をします
   * @return false|void
   */
  private function exec_insert_action() {
    // 機能有効性とnonceチェック
    $this->check_option_and_nonce("insert", "insert");

    $input_names = $this->get_form_input_names();
    // パラメータチェック
    if (!$input_names) {
      $this->last_error = $this->__("Invalid parameter"); // "不正なパラメータです"
      return false;
    }

    $data = [];
    foreach ($input_names as $input_name) {
      $val = filter_input(INPUT_POST, $input_name); // NULLが返る場合は、NULLチェックボックスONで送られていないという事
      if (!is_null($val)) {
        // 新規挿入時のみ、入力項目として送られているけど空文字のものはセットしない
        // 何故なら空文字をセットすることでdatetimeに""を挿入してMySQL側のエラーとなることが多いから
        // 空文字の場合はテーブルのデフォルト値に委ねる
        if ($val !== "") {
          $data[$input_name] = $val;
        }
      } else {
        $data[$input_name] = null;  // 必要な入力なのに送られていない場合はNULL値をセットする
      }
    }

    // 挿入前にフィルターがある場合はフィルター処理をする
    if (has_filter("crudiator_before_insert_{$this->page_name}")) {
      $data = apply_filters("crudiator_before_insert_{$this->page_name}", $data); // 挿入前のデータを渡す
      if (is_array($data)) {    // 配列だったらデータが返ってきているので正しい
        // フィルター処理後にもう一度このテーブルに存在するカラムのみとする
        foreach ($data as $key => $val) {
          if (!array_key_exists($key, $this->fields)) {
            unset($data[$key]);
          }
        }
      } else {  // 配列以外が返った場合はエラー
        if (is_string($data)) { // 文字列の場合はエラー文字列
          $this->last_error = $data;
        } else {  // そもそも何も返らない
          $this->last_error = $this->__("No value returned in callback function before data insertion");/*"データ挿入前のコールバック関数で値が返ってきません"*/
        }
        return false;
      }
    }

    // 挿入実行処理
    try {
      $this->medoo->insert($this->table, $data);
    } catch (PDOException $ex) {
      // 実行後のエラーはmedooから取得する
      $this->last_error = $this->__("Database Error : ") . $ex->getMessage();
      return false;
    }

    // 実行クエリをユーザーメタに保存
    $this->store_execute_query($this->medoo->log());

    // 主キーの値を取得する
    $pri_vals = [];
    if ($this->is_auto_increment) { // AUTO_INCREMENTならPDOの関数から取得
      $pri_vals[] = $this->medoo->id();
    } else {    // AUTO_INCREMENTじゃないなら主キーから値を取得
      foreach ($this->primary_keys as $key) {
        $pri_vals[] = $data[$key];
      }
    }

    // 挿入後アクション処理
    if (has_action("crudiator_after_insert_{$this->page_name}")) {
      $where         = $this->get_primary_where($pri_vals);
      $inserted_rows = $this->medoo->select($this->table, "*", $where);
      $inserted_row  = $inserted_rows[0];
      do_action("crudiator_after_insert_{$this->page_name}", $inserted_row);
    }

    // 成功時は編集詳細ページで成功文言出力ページにリダイレクトする
    if (count($this->primary_keys) > 0) {
      $url = $this->get_page_url(["action" => "update", "id" => $pri_vals, "insert" => "success"]);
    } else {  // 主キー無しの場合はページTOPに戻す
      $url = $this->get_page_url(["insert" => "success"]);
    }

    $this->redirect_exit($url);

  }

  /**
   * 特定レコードのデータベース更新処理をします。
   * @return bool|int|mixed
   */
  private function exec_update_action() {
    // 機能有効性とnonceチェック
    $this->check_option_and_nonce("update", "update");

    // フォームの入力フィールド名取得
    $input_names = $this->get_form_input_names();

    if (!$input_names) {
      $this->last_error = $this->__("Invalid parameter"); // "不正なパラメータです"
      return false;
    }

    // GETパラメータから主キー値取得
    $ids   = $this->get_primary_ids();
    $where = $this->get_primary_where($ids);

    $data = [];
    foreach ($input_names as $input_name) {
      $val = filter_input(INPUT_POST, $input_name); // NULLが返る場合は、NULLチェックボックスONで送られていないという事
      if (!is_null($val)) {
        $data[$input_name] = $val;
      } else {
        $data[$input_name] = null;  // 必要な入力なのに送られていない場合はNULL値をセットする
      }
    }

    // 挿入前にフィルターがある場合はフィルター処理をする
    if (has_filter("crudiator_before_update_{$this->page_name}")) {
      $data = apply_filters("crudiator_before_update_{$this->page_name}", $data); // 挿入前のデータを渡す
      if (is_array($data)) {    // 配列だったらデータが返ってきているので正しい
        // フィルター処理後にもう一度このテーブルに存在するカラムのみとする
        foreach ($data as $key => $val) {
          if (!array_key_exists($key, $this->fields)) {
            unset($data[$key]);
          }
        }
      } else {  // 配列以外が返った場合はエラー
        if (is_string($data)) { // 文字列の場合はエラー文字列
          $this->last_error = $data;
        } else {  // そもそも何も返らない
          $this->last_error = $this->__("No value returned in callback function before data update");/*"データ更新前のコールバック関数で値が返ってきません"*/
        }
        return false;
      }
    }

    try {
      // The returned object of update() is PDOStatement, so you can use its methods to get more information. 
      $pdos = $this->medoo->update($this->table, $data, $where);
      // $pdos->rowCount(); // これで変更行数を取得。もしも使う時用のメモ。  
    } catch (PDOException $ex) {
      // エラーはPDOの例外から取得する
      $this->last_error = $this->__("Database Error : ") . $ex->getMessage();
      return false;
    }

    // 実行クエリをユーザーメタに保存
    $this->store_execute_query($this->medoo->log());

    // update時にもしデータの中に主キーがあったなら渡ってきた$idを変える
    $pri_vals = [];
    foreach ($this->primary_keys as $idx => $key) {
      if (array_key_exists($key, $data)) {  // 更新データに主キーがあった場合
        $pri_vals[] = $data[$key];
      } else {    // 更新データに主キーがなければ渡ってきたidパラメータから取得（通常はこちら）
        $pri_vals[] = $ids[$idx];
      }
    }

    // 更新後アクション処理
    if (has_action("crudiator_after_update_{$this->page_name}")) {
      $primary_keys = $this->get_primary_where($pri_vals);
      $new_row      = $this->medoo->get($this->table, "*", $primary_keys);
      do_action("crudiator_after_update_{$this->page_name}", $new_row);
    }

    // 成功時は編集詳細ページで成功文言出力ページにリダイレクトする
    $url = $this->get_page_url(["action" => "update", "id" => $pri_vals, "update" => "success"]);
    $this->redirect_exit($url);

  }

  /**
   * 特定レコードのデータベース更新処理をしいます。
   * 成功した場合は削除した件数を返却、失敗した場合はエラーメッセージを格納してfalseを返却します。
   * @param $id
   * @return bool|int
   */
  private function exec_delete_action() {

    // 機能有効性とnonceチェック
    $this->check_option_and_nonce("delete", "delete");

    // GETパラメータの主キーからデータを取得
    $ids   = $this->get_primary_ids();
    $where = $this->get_primary_where($ids); // 主キーはidパラメータで渡している
    $data  = $this->medoo->get($this->table, "*", $where);

    // 削除前フィルター関数
    if (has_filter("crudiator_before_delete_{$this->page_name}")) {
      $data = apply_filters("crudiator_before_delete_{$this->page_name}", $data);
      if (!is_array($data)) {    // deleteは加工するわけではないので配列以外かどうかだけチェック
        if (is_string($data)) { // 文字列の場合はエラー文字列
          $this->last_error = $data;
        } else {  // そもそも何も返らない
          $this->last_error = $this->__("No value returned in callback function before data deletion");/*"データ削除前のコールバック関数で値が返ってきません"*/
        }
        return false;
      }
    }

    try {
      // The return object of delete() is PDOStatement, so you can use its methods to get more information. 
      $result     = $this->medoo->delete($this->table, $where);
      $delete_num = $result->rowCount();
    } catch (PDOException $ex) {
      $this->last_error = $this->__("Database Error : ") . $ex->getMessage();
      return false;
    }

    // 実行クエリをユーザーメタに保存
    $this->store_execute_query($this->medoo->log());

    // 削除に成功していた時のみコールバック関数も実行する
    if ($delete_num == 0) {
      $this->last_error = $this->__("Failed to delete.");
      return false;
    }

    // 削除後アクション関数
    if (has_action("crudiator_after_delete_{$this->page_name}")) {
      do_action("crudiator_after_delete_{$this->page_name}", $data);
    }

    // 成功時はその行があったページにリダイレクトする
    $url     = $this->get_page_url(["delete" => "success", "delete_num" => $delete_num]);
    $pagenum = $this->get_pagenum();
    if ($pagenum != 1) {        // 1ページ目以外は引き継ぐ
      $url .= "&paged={$pagenum}";
    }
    $this->redirect_exit($url);

  }

  private function exec_bulk_delete_action() {
    // 機能有効性とnonceチェック
    $this->check_option_and_nonce("delete", 'bulk-' . $this->_args['plural']);

    // チェックボックスのチェックされた値を取得
    $crudiator_items = filter_input(INPUT_GET, $this->_args['singular'], FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    // パラメータチェック
    if (!$crudiator_items) {  // constructorで渡した単一アイテムのキー
      $this->last_error = $this->__("Invalid parameter"); // "不正なパラメータです"
      return false;
    }

    // 一括削除なのでMedoo用の複数WHERE配列を作っていく
    $where_ary = [];
    foreach ($crudiator_items as $crudiator_item) {
      $pri_vals = json_decode($crudiator_item, true);
      if (!$pri_vals) {
        continue;
      }

      // 主キーの分だけidキーの値がないのはエラー（単一主キーで2つ以上あってもNGだし、複合キーでその数だけないのもNG）
      if (count($pri_vals) != count($this->primary_keys)) {
        $this->last_error = $this->__("Invalid parameter");     /*"不正なパラメータです"*/
        return false;
      }

      // 主キー値配列をwhere型にする
      $where       = $this->get_primary_where($pri_vals);
      $where_ary[] = $where;  // 複数配列として突っ込む
    }

    // 一括削除前フィルター処理
    if (has_filter("crudiator_before_bulk_delete_{$this->page_name}")) {
      $data = apply_filters("crudiator_before_bulk_delete_{$this->page_name}", $where_ary);
      if (!is_array($data)) {  // deleteは加工するわけではないので配列以外かどうかだけチェック。主キー配列が返れば正常。
        if (is_string($data)) { // 文字列の場合はエラー文字列
          $this->last_error = $data;
        } else {  // そもそも何も返らない
          $this->last_error = $this->__("No value is returned in the callback function before bulk processing");/*"一括処理前のコールバック関数で値が返ってきません"*/
        }
        return false;
      }
    }

    $table      = $this->table;
    $delete_num = 0;
    // Medooのトランザクション関数を使って連続処理
    $this->medoo->action(function ($database) use ($table, $where_ary, &$delete_num) {

      try {
        foreach ($where_ary as $where) {
          $result = $database->delete($table, $where);
          if ($result->rowCount() == 0) {
            // ここでエラーメッセージを残してfalse返却でロールバック
            $this->last_error = $this->__("The following record could not be deleted. : ") . json_encode($where);
            return false;
          }
          $delete_num++;
        }
      } catch (PDOException $ex) {
        $this->last_error = $this->__("Database Error : ") . $ex->getMessage();
        return false;
      }

    });

    // 例外発生した時はエラー文字列入るのでfalse返却してエラー表示
    if ($this->last_error) {
      return false;
    }

    // 実行クエリをユーザーメタに保存
    $this->store_execute_query($this->medoo->log());

    // 一括削除後アクション処理
    if (has_action("crudiator_after_bulk_delete_{$this->page_name}")) {
      do_action("crudiator_after_bulk_delete_{$this->page_name}", $where_ary);
    }

    // 成功時はその行があったページにリダイレクトする
    $url     = $this->get_page_url(["delete" => "success", "delete_num" => $delete_num]);
    $pagenum = $this->get_pagenum();
    if ($pagenum != 1) {        // 1ページ目以外は引き継ぐ
      $url .= "&paged={$pagenum}";
    }
    $this->redirect_exit($url);

  }

  /**
   * DBレコードのエクスポートを処理します。
   * @return false|void
   */
  private function exec_export_action() {
    // 機能有効性とnonceチェック
    $this->check_option_and_nonce("export");

    $allow_encodes = ["SJIS", "UTF-8"];
    $encode        = "SJIS";
    if (isset($_GET["export_encode"]) && in_array($_GET["export_encode"], $allow_encodes)) {
      $encode = filter_input(INPUT_GET, "export_encode");
    }

    $columns = array_keys($this->fields); // デフォルトは全カラム

    // エクスポートしたいカラムの指定がある時はそれを使う
    if ($export_columns = $this->get_option("export_columns")) {
      if (is_array($export_columns)) {
        $columns = $export_columns;
      }
    } else if ($option_columns = $this->get_option("columns")) {    // 次に共通カラム
      if (is_array($option_columns)) {
        $columns = $option_columns;
      }
    }

    // 存在するカラムのみにする
    $select_columns = [];
    foreach ($columns as $column) {
      if (isset($this->fields[$column])) {
        $select_columns[] = $column;
      }
    }

    // where条件配列を生成
    $where = $this->get_where();

    // 次に一覧データを取得するので順番を決めるorder配列を生成
    $where["ORDER"] = $this->get_order();

    // データ取得
    try {
      $rows = $this->medoo->select($this->table, $select_columns, $where);
    } catch (PDOException $ex) {
      // エラーはPDOの例外から取得する
      $this->last_error = $this->__("Database Error : ") . $ex->getMessage();
      return false;
    }

    // TODO: これはフィルターでいいかもしれない
    // 電話番号などの値をExcelのCSV開きで文字列として認識させたい場合は=""で囲む処理
    if ($export_string_columns = $this->get_option("export_string_columns")) {
      foreach ($rows as &$row) {
        foreach ($row as $key => &$val) {
          if ($export_string_columns && in_array($key, $export_string_columns)) {
            $val = '="' . $val . '"';
          }
        }
      }
    }

    // カラム名をdisplay_asで変換
    $export_headers = [];
    if ($this->display_as) {
      foreach ($select_columns as $column) {
        $export_headers[] = $this->get_display_as($column);
      }
    }

    $filename = $this->table . "_" . date("Y-m-d_His");

    MyCsv::export($filename, $rows, $encode, $export_headers);
  }

  /**
   * 必要なパラメータのみ継続してURLを整えてリダイレクトする
   * @return void
   */
  private function exec_redirect_paged() {

    $param = [];

    // 検索か絞り込みはどちらか
    if ($search = $this->get_search_str()) {
      $param["s"] = $search;
    } else if ($filter_ary = $this->get_filter_ary()) {
      $param["filter"] = $filter_ary;
    }

    // view指定があれば
    $view = filter_input(INPUT_GET, "view");
    if ($this->get_option("views") && $view) {
      $param["view"] = $view;
    }

    // 順番指定があれば
    $orderby = filter_input(INPUT_GET, "orderby");
    $order   = filter_input(INPUT_GET, "order");
    if ($orderby && $order) {
      $param["orderby"] = $orderby;
      $param["order"]   = $order;
    }

    // ページ番号は最後
    if ($paged = filter_input(INPUT_GET, "paged")) {
      $param["paged"] = $paged;
    }

    $this->redirect_exit($this->get_page_url($param));
  }

  /**
   * デバッグ用に画面に実行クエリを表示する為に保存しておきます。
   * @return void
   */
  private function add_executed_query($query) {
    if ($this->get_option("debug") == true) {
      $this->sql_query .= $query . "\n";
    }
  }

  /**
   * デバッグ用の実行クエリを画面またぎでも確認出来るようDB保存します
   * @return void
   */
  private function store_execute_query($query) {
    if ($this->get_option("debug") == true) {
      update_user_meta($this->user->ID, "crudiator_last_query", $query);
    }
  }

  private function h($value) {
    // DBの生データ出力時はこちらを使う
    return htmlspecialchars($value, ENT_QUOTES);
  }

  private function __($text) {
    return __($text, "crudiator");
  }

  private function is_local() {
    if (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
      return true;
    }
    return false;
  }

}

// 表示オプションの［適用］を押した時の保存フィルター。
// 発火タイミングが早すぎる為このプラグインファイルがロードされたこのタイミングで登録している。
// 9がミソ。このフィルターは他の画面にも影響するので普通10の所1早く実行している。
// ここでは$valueを単純に返しているだけなので特別問題ではないし、画面毎に処理を書けば尚更問題無い。
// 20230427 namespace対応したらCrudiator内のstaticメソッドをコールバックで呼ばれなくなったので無名関数渡しにした。
// ひょっとしたらstaticメソッドでも呼ぶ方法があるかもしれないが押し通す理由もないのでこれで良し。
add_filter('set-screen-option', function ($status, $option, $value) {
  /**
   * この関数は扱い方が難しく、set-screen-optionにフックしていると他のカスタムページの
   * 保存処理にも反応してしまう。なので、大前提として基本的に$valueは常にそのまま返す。
   * これで一応他のカスタムページでも影響は少なくなるはずである。
   * ただし他のフックで何か$valueに変更を加えられた後にこのフックが処理されると、こっちが優先となる。
   * まぁそのあたりは他のフックでも同条件だし、フック内で保存してリダイレクトするとか
   * 他のフックもお互い様ではある。それに5.4.2以降はさらに特定optionだけのフックもあるので、
   * これで$valueを返せば値は確実に保存される。というわけで一番お行儀の良い書き方が以下である。
   * このプラグインで使っている$option値であればその特定optionのフックにして値を返すのだ。
   * misc.php の set_screen_options() の処理内容を見れば納得出来る。
   */
  if (preg_match("/crudiator_.+_per_page/", $option)) {
    // v5.4.2以降は特定$optionのフックが使えるのでここで紐づける
    add_filter("set_screen_option_{$option}", function ($status, $option, $value) {

      // ここで$valueを返せばこの画面での表示オプションの値は確実に保存される
      return $value;
    }, 10, 3);
  }

  // 他のフックへの影響を少なくするよう$valueはそのまま返す。
  return $value;
}, 9, 3);

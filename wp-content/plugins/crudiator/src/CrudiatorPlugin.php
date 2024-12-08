<?php

namespace Crudiator;

use Medoo\Medoo;

// autoloadがあるのにここでCrudiator.phpを読み込む理由は、
// 表示オプションの件数表示切り替えの為に、add_filter("set-screen-option") 事前に登録する必要がある為。
require_once __DIR__ . "/Crudiator.php";

class CrudiatorPlugin {
  private $crudiator_meta_inputs = [];
  private $medoo = null;

  // PHP5系でも使えるように後から配列定義
  private $CRUDIATOR_RULES = [];

  public function __construct() {

    // 第3引数はWP_PLUGIN_DIRからの相対パスでlanguagesディレクトリを指定する
    $plugin_rel_path = basename(CRUDIATOR_DIR);
    load_plugin_textdomain('crudiator', false, "{$plugin_rel_path}/languages");

    // CRUDIATORカスタム投稿の登録
    add_action('init', [$this, "on_init"]);

    // CRUDIATORカスタム投稿のメニュー反映
    // priorityはdefault 10なので、それよりも1遅くすることでサブメニューの追加時に親スラッグが存在する
    add_action('admin_menu', [$this, "on_admin_menu"], 11);

    // クラス内で使う変数の初期化
    $this->initialize();
  }

  private function initialize() {
    // メニュータイプ
    $this->CRUDIATOR_RULES["menu_type"] = [
      "topmenu" => $this->__("Top level menu"),
      "submenu" => $this->__("Sub level menu"),
    ];
    // アクセス権限
    $this->CRUDIATOR_RULES["capability"] = [
      "manage_options"    => $this->__("Administrator"), // 管理者(シングルサイト内のすべての管理機能にアクセスできるユーザー)
      "edit_others_posts" => $this->__("Editor"), // 編集者(他のユーザーの投稿を含むすべての投稿を公開、管理できるユーザー)
      "publish_posts"     => $this->__("Author"), // 投稿者(自身の投稿を公開、管理できるユーザー)
      "edit_posts"        => $this->__("Contributor"),  // 寄稿者(自身の投稿を編集・管理できるが、公開はできないユーザー)
      "read"              => $this->__("Subscriber"), // 購読者(プロフィール管理のみを実行できるユーザー)
    ];

  }

  public function on_init() {

    // Crudiatorのメニュー管理は基本的に管理者のみとします。
    // 管理者以外は使う側のユーザーの想定なのでメニュー管理は出来ないようにします。
    if (!current_user_can('manage_options')) {  // この関数はcapabilityを渡すのが正しい使い方
      return;
    }

    // PDOによるデータベース接続チェック
    // DockerなどでPDOのmysqlドライバーが入ってない場合は例外となる
    try {
      // Medooでデータベース接続
      $this->medoo = new Medoo([
        'type'     => 'mysql',
        'host'     => DB_HOST,
        'database' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASSWORD
      ]);
    } catch (PDOException $ex) {
      // エラー表示
      add_action('admin_notices', function () use ($ex) { // 無名関数はphp5.3以降使用可能
        $screen = get_current_screen();
        if ($screen->post_type == "crudiator") {
          /*"PDOによるデータベース接続が出来ない為、Crudiatorは正常に動きません。"*/
          $error_msg = $this->__("Crudiator does not work properly because database connection by PDO is not possible.") . "<br>";
          $error_msg .= $this->__("Error Message: ") . $ex->getMessage();
          echo "
<div class='notice notice-error is-dismissible'>
<p>" . esc_html($error_msg) . "</p>
</div>";
        }
      });
    }

    /* カスタム投稿の登録 */
    $args = array(
      'labels'               => array(
        'name'               => $this->__("Crudiator"),  // h1に表示される投稿タイプの一般名。通常は複数形だがCrudiatorsがダサいので単数形にする。
        'singular_name'      => $this->__("Table"),  // この投稿タイプのオブジェクト 1 個の名前（単数形）
        'menu_name'          => $this->__("Crudiator"), // メニュー名のテキスト
        'name_admin_bar'     => $this->__("Crudiator"),  // 管理バーの「新規追加」ドロップダウンに入れる名前
        'all_items'          => $this->__("All Tables"),//"{$itemname}一覧",   // メニューの「すべての〜」に使うテキスト
        'add_new'            => $this->__('Add New'),       // 「新規追加」のテキスト。
        'add_new_item'       => $this->__("Add New Table"), // 「新規〜を追加」のテキスト。
        'edit_item'          => $this->__("Edit Table"),     // 「〜を編集」のテキスト
        'new_item'           => $this->__("New Table"),        // 「新規〜」のテキスト
        'view_item'          => $this->__("View Table"),     // 「〜を表示」のテキスト
        'search_items'       => $this->__("Search Tables"),     // 「〜を検索」のテキスト
        'not_found'          => $this->__("No tables found."),
        'not_found_in_trash' => $this->__("No tables found in Trash."),
        'parent_item_colon'  => $this->__("Parent Tables"),
      ),
      'description'          => '',     // 投稿タイプの簡潔な説明。
      'public'               => false,  // 投稿タイプをパブリックにしない。他のところで明示的に用意しない限り、管理画面とフロントエンドのどちらからも使えない。
      'exclude_from_search'  => true,   // この投稿タイプの投稿をフロントエンドの検索結果から除外するかどうか。
      'publicly_queryable'   => false,  // フロントエンドで post_type クエリが実行可能かどうか。
      'show_ui'              => true,   // この投稿タイプを管理するデフォルト UI を生成するかどうか。
      'show_in_nav_menus'    => false,  // ナビゲーションメニューでこの投稿タイプが選択可能かどうか。
      'show_in_menu'         => true,   // 管理画面にこの投稿タイプを表示するかどうか。
      'show_in_admin_bar'    => false,  // この投稿タイプを WordPress の管理バーから使えるようにするかどうか。
      'has_archive'          => false,  // この投稿タイプのアーカイブを有効にするかどうか。
      'menu_position'        => 80,     // 80 - 設定の下
      // アイコンはhttps://developer.wordpress.org/resource/dashicons/#database から選んだ databaseは5.5以上なのでversion分岐にする
      'menu_icon'            => version_compare($GLOBALS['wp_version'], '5.5', '>=') ? "dashicons-database" : "dashicons-index-card",
      'hierarchical'         => false,  // この投稿タイプが階層を持つ（例：固定ページ）かどうか。true の場合、親を指定できるようになる。当初trueにしていたけど親を持つ必要がないのでfalseにした。
      'register_meta_box_cb' => '',     // 編集フォームのメタボックスをセットアップするのに呼び出すコールバック関数を指定する（関数名を文字列で指定）
      'rewrite'              => false,  // この投稿タイプのパーマリンクのリライト方法を変更する。リライトを避けるには false を指定する。
      'query_var'            => true,   // この投稿に使用する query_var キーの名前。true - $post_type の値
      'can_export'           => true,   // この投稿タイプをエクスポート可能かどうか。
      'show_in_rest'         => false,  // この投稿タイプを RESTAPI に含めるかどうか。
      'supports'             => array('title'),
    );
    register_post_type('crudiator', $args);

    /* カスタム投稿が追加出来たらそれに付随するフックを紐付けます。 */

    // カスタム投稿のカスタムフィールド
    add_action('add_meta_boxes_crudiator', [$this, "on_add_meta_boxes"]);
    // カスタム投稿の保存処理
    add_action('save_post_crudiator', [$this, 'on_save_post']);
    // カスタム投稿のタイトル出力後の処理
    add_action('edit_form_after_title', [$this, 'on_edit_form_after_title']);
    // カスタム投稿のタイトル欄のplaceholder処理
    add_filter('enter_title_here', [$this, 'on_enter_title_here']);
    // カスタム投稿一覧のカラム処理
    add_filter('manage_crudiator_posts_columns', [$this, 'on_manage_posts_columns']);
    add_action('manage_crudiator_posts_custom_column', [$this, 'on_manage_posts_custom_column'], 10, 2);
    // カスタム投稿のrow_actionを追加
    add_filter('post_row_actions', [$this, 'on_post_row_actions'], 10, 2);

    /**
     * カスタム投稿でのみscriptの読み込む
     * 当初、admin_print_scripts-post-new.php, admin_print_scripts-post.php に紐付けていたけど、
     * これはそのコールバック関数内で<script></script>を出力する為のフックとのこと。
     */
    add_action('admin_head-post-new.php', [$this, 'on_admin_head_post']);  // 新規
    add_action('admin_head-post.php', [$this, 'on_admin_head_post']);      // 編集

  }

  /**
   * crudiatorのカスタム投稿をメニューとして反映します。
   * @return void
   */
  function on_admin_menu() {

    $crudiator_posts = get_posts([
      'numberposts' => -1,  // 全て
      'post_type'   => "crudiator",
      'orderby'     => "ID",
      'order'       => "ASC"
    ]);

    // crudiatorの投稿がなければそのまま返却
    if (!$crudiator_posts || count($crudiator_posts) == 0) {
      return;
    }

    foreach ($crudiator_posts as $crudiator_post) {
      $meta = get_post_custom($crudiator_post->ID);

      if (isset($meta["_table_name"][0]) && isset($meta["_menu_type"][0])) {
        $table_name = $meta["_table_name"][0];
        $page_title = $crudiator_post->post_title;
        $menu_title = $crudiator_post->post_title;
        $capability = (!empty($meta["_capability"][0])) ? $meta["_capability"][0] : "manage_options";
        $menu_slug  = (!empty($meta["_menu_slug"][0])) ? $meta["_menu_slug"][0] : strtolower($table_name);

        $options             = [];
        $custom_setting_json = (!empty($meta["_custom_setting_json"][0])) ? $meta["_custom_setting_json"][0] : "";
        if ($custom_setting_json) {
          $options = json_decode($custom_setting_json, true);
          if ($options == null || json_last_error() !== JSON_ERROR_NONE) {
            $options = [];
          }
        }

        if ($meta["_menu_type"][0] == "topmenu") {
          $icon_url = (!empty($meta["_icon_url"][0])) ? $meta["_icon_url"][0] : "";
          $position = (!empty($meta["_position_topmenu"][0])) ? $meta["_position_topmenu"][0] : null;

          (new Crudiator($table_name, $options))
            ->add_menu_page($page_title, $menu_title, $capability, $menu_slug, $icon_url, $position);

        } else if ($meta["_menu_type"][0] == "submenu") {
          $parent_slug = (!empty($meta["_submenu_parent"][0])) ? $meta["_submenu_parent"][0] : "";
          $position    = (!empty($meta["_position_submenu"][0])) ? $meta["_position_submenu"][0] : null;

          (new Crudiator($table_name, $options))
            ->add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $position);

        }
      }
    }
  }

  /**
   * 特定の管理画面のheadセクションで発火します。
   * @return void
   */
  function on_admin_head_post() {
    /**
     * 投稿、固定ページでも発火しているので投稿タイプで分岐する
     */
    if (get_post_type() == 'crudiator') {
      // 管理画面用のadmin.jsを読み込み
      $adminjs = "assets/js/crudiator-admin.js";
      $src     = CRUDIATOR_DIR_URL . $adminjs;
      $ver     = date("YmdHis", filemtime(CRUDIATOR_DIR . "/" . $adminjs));
      wp_enqueue_script("crudiator-admin_js", $src, ["jquery"], $ver);

      // crudiatorの投稿編集画面でのみ紐付けたいのでここで登録。何かエラーがある場合はこれで通知する。
      add_action('admin_notices', [$this, 'on_admin_notices']);
    }
  }

  /**
   * CRUDIATORの投稿データに何かしらのエラーがある時などに通知する
   * @return void
   */
  function on_admin_notices() {
    global $post;
    $screen = get_current_screen();
    if ($screen->post_type == "crudiator") {
      $custom_setting_json = get_post_meta($post->ID, "_custom_setting_json", true);
      if (!empty($custom_setting_json)) {
        $options = json_decode($custom_setting_json, true);
        if ($options == null || json_last_error() !== JSON_ERROR_NONE) {
          $error_msg      = $this->__("The custom settings do not work because the format of the json string in the custom settings is incorrect."); // カスタム設定のjson文字列の書式に誤りがある為カスタム設定は機能しません。
          $json_error_msg = json_last_error_msg();

          $html = <<<HTML
<div class='notice notice-error is-dismissible'>
<p>{$error_msg}<br>&gt; {$json_error_msg}</p>
</div>
HTML;
          echo $html;
        }
      }

    }
  }

  function on_add_meta_boxes() {

    // crudiatorのカスタム投稿タイプにメタボックスを追加
    $id       = "crudiator_table_base_setting"; // metaボックスのhtml ID
    $title    = $this->__("Base setting");  /*"基本設定"*/
    $callback = "output_crudiator_table_base_setting";
    $screen   = "crudiator";
    $context  = 'advanced';
    $priority = 'default';
    add_meta_box($id, $title, [$this, $callback], $screen, $context, $priority);

    // カスタム
    $id       = "crudiator_tables_custom_setting";
    $title    = $this->__("Custom setting");  /*"カスタム設定"*/
    $callback = "output_crudiator_table_custom_setting";
    $screen   = "crudiator";
    $context  = 'advanced';
    $priority = 'default';
    add_meta_box($id, $title, [$this, $callback], $screen, $context, $priority);
  }

  /**
   * crudiatorのカスタム投稿で保存するmetaデータを準備します。
   * @return void
   */
  private function ready_crudiator_meta_rule() {
    global $menu;

    // 予めインスタンス化しているMedooを使用してこのDBのテーブル一覧を取得する
    if ($this->medoo) {
      $sql    = "SHOW FULL TABLES";
      $tables = $this->medoo->query($sql)->fetchAll();
    } else {
      $tables = [];
    }

    $table_name_rule = [];
    $key             = "Tables_in_" . DB_NAME;
    foreach ($tables as $table) {
      // Table_typeが"VIEW"は除く
      if ($table["Table_type"] == "BASE TABLE") {
        $table_name                   = $table[$key];
        $table_name_rule[$table_name] = $table_name;
      }
    }

    $this->crudiator_meta_inputs["table_name"] = [
      "name"        => $this->__("Database Table"), // データベース テーブル
      "type"        => "select",
      "rule"        => $table_name_rule, // ここにDBテーブル一覧を
      "required"    => true,
      "description" => $this->__("Select the target table for CRUD on the database."),/*"データベース上のCRUDの対象となるテーブルを選択します。"*/
    ];

    $this->crudiator_meta_inputs["menu_slug"] = [
      "name"        => $this->__("Slug Name"),/*"スラッグ名"*/
      "type"        => "text",
      "required"    => true,
      "description" => $this->__("Enter the slug name that will be part of the URL. Only lowercase alphanumeric, hyphen, and underscores characters are valid.<br>When the Database Table is selected, it will be populated subsidiarily."),/*"メニューURLの一部となるスラッグ名を入力します。小文字英数字・ハイフン・アンダースコアのみ有効です。<br/>データベーステーブルを選択すると補完的に入力されます。"*/
      "validation"  => function ($value) {
        // requiredにしているけど万が一空文字の時はテーブル名をデフォルト値とする
        if (empty($value) && isset($_POST["table_name"])) {
          $value = sanitize_title($_POST["table_name"]);
        }
        return $value;
      }
    ];

    $this->crudiator_meta_inputs["menu_type"] = [
      "name"        => $this->__("Menu Type"),/*"メニュータイプ"*/
      "type"        => "select",
      "rule"        => $this->CRUDIATOR_RULES["menu_type"],
      "description" => $this->__("Select whether it is a top-level menu or a submenu within the top level."),/*"トップレベルのメニューか、トップレベル内のサブメニューかを選択します。"*/
    ];

    // TODO: 親から子にする時も自分メニューは除く処理が必要

    $submenu_parent_rule = [];  // 必ず選ばせるので空配列で始める
    foreach ($menu as $menu_idx => $menu_val) {
      // セパレーターの場合は飛ばす
      if (count($menu_val) >= 5 && $menu_val[4] == "wp-menu-separator") {
        continue;
      }
      // 文字列にhtmlタグが入る場合があるのでその場合は除去
      if (preg_match("/^([^ ]+) <.+/", $menu_val[0], $matches)) {
        $submenu_parent_rule[$menu_val[2]] = $matches[1]; // $menu_val[2]にスラッグ名やそれと同等のものが入っている
      } else {
        $submenu_parent_rule[$menu_val[2]] = $menu_val[0];
      }
    }
    $this->crudiator_meta_inputs["submenu_parent"] = [
      "name"        => $this->__("Parent Menu"),/*"サブメニュー時の親メニュー"*/
      "type"        => "select",
      "rule"        => $submenu_parent_rule,
      "description" => $this->__("Selects the parent menu when the menu type is submenu selection."),/*"メニュータイプがサブメニュー選択時に、親メニューを選択します。"*/
      "disabled"    => "disabled",
    ];

    // あまり入力させたくないのでメニュー名はpost_titleとした
//    $this->crudiator_meta_inputs["menu_name"] = [
//      "name"        => "メニュー名",
//      "type"        => "text",
//      "description" => "ここに入力した文字がメニュー名として表示されます。",
//    ];

    // TODO:自分自身のページは除く必要がある

    $position_topmenu = ["" => "--"];
    foreach ($menu as $menu_idx => $menu_val) {
      // 同値でもなく、+1でもない値ということで+0.1とした。（同値は表示されない）
      $pos_val = strval($menu_idx + 0.1);
      // セパレーターの場合は別
      if (count($menu_val) >= 5 && $menu_val[4] == "wp-menu-separator") {
        $position_topmenu[$pos_val] = "ー";
      } else {
        // 文字列にhtmlタグが入る場合があるのでその場合は除去
        if (preg_match("/^([^ ]+) <.+/", $menu_val[0], $matches)) {
          $position_topmenu[$pos_val] = $matches[1];
        } else {
          $position_topmenu[$pos_val] = $menu_val[0];
        }
      }
//      $position_topmenu[$pos_val] .= "の下";  // 説明することにした
    }
    $this->crudiator_meta_inputs["position_topmenu"] = [
      "name"        => $this->__("Menu Position"),/*"メニュー位置"*/
      "type"        => "select",
      "rule"        => $position_topmenu,
      "description" => $this->__("This menu appears below the selected menu.<br>If omitted, it will appear at the bottom of all menus."),/*'選択したメニューの下にこのメニューが表示されます。<br/>省略した場合は全てのメニューの一番下に表示されます。'*/
    ];

    $this->crudiator_meta_inputs["position_submenu"] = [
      "name"        => $this->__("Menu Position"),/*"メニュー位置"*/
      "type"        => "number",
      "description" => $this->__("Specify the position of the submenu to be displayed by any number from 1.<br>If omitted, they are displayed in the order of registration."),/*'サブメニューの表示される位置を1からの任意の数字で指定します。<br/>省略した場合は登録順に表示されます。'*/
      "validation"  => function ($value) {
        if (!empty($value)) {
          if (is_numeric($value)) {
            return intval($value);
          } else {
            return 1; // 数字じゃない場合は1にする
          }
        }
        return $value;
      }
    ];

    // dashiconファイルからクラス名を抜き出す処理書いてみたけどやはり使いにくかった
    // 普通にWordPressのサイト見せて文字列貼り付ける方がユーザーも楽だ
    $dashicon_css  = ABSPATH . WPINC . "/css/dashicons.css";
    $icon_url_rule = ["" => "--"];
    if (file_exists($dashicon_css)) {
      // cssファイルからdashicons-のクラス名を抜き出す
      $css_str = file_get_contents($dashicon_css);
      if (preg_match_all("/\.dashicons-(.+):before\s*\{/", $css_str, $matches)) {
        foreach ($matches[1] as $match) {
          if ($match == "before") continue;
          $icon_url_rule["dashicons-" . $match] = $match;
        }
      }
    }
    if (count($icon_url_rule) > 10) { // 最低10個以上あればちゃんと抜け出したと言える
      $icon_url_type = "select";
      $icon_url_desc = $this->__("Select the menu icon.You can check the list of icons on the official <a href='https://developer.wordpress.org/resource/dashicons/#menu' target='_blank'>WordPress website</a>.");/*'メニューアイコンを選択します。<a href="https://developer.wordpress.org/resource/dashicons/#menu" target="_blank">WordPress公式サイト</a>でアイコン一覧を確認出来ます。'*/
    } else {
      $icon_url_type = "text";
      $icon_url_desc = 'WordPress公式サイトの<a href="https://developer.wordpress.org/resource/dashicons/#menu" target="_blank">Dashiconsのページ</a>で確認して、<code>dashicons-</code>から始まる文字を入力します。';
    }

    $this->crudiator_meta_inputs["icon_url"] = [
      "name"        => $this->__("Menu Icon"),/*"アイコン"*/
      "type"        => $icon_url_type,
      "rule"        => $icon_url_rule,
      "placeholder" => "dashicons-menu",
      "description" => $icon_url_desc,
    ];

    /**
     * アクセス権限は下記ページを参考にしてcapability名をセットする。
     * https://wpdocs.osdn.jp/%E3%83%A6%E3%83%BC%E3%82%B6%E3%83%BC%E3%81%AE%E7%A8%AE%E9%A1%9E%E3%81%A8%E6%A8%A9%E9%99%90
     * 例えば投稿者を選択した場合はpublish_postsは管理者・編集者・投稿者が持っているので許可となる。
     */
    $this->crudiator_meta_inputs["capability"] = [
      "name"        => $this->__("Permission"),  // アクセス権
      "type"        => "select",
      "rule"        => $this->CRUDIATOR_RULES["capability"],
      "description" => $this->__("Select the permissions that allow you to view this menu. <br>It will be displayed to users with the selected permissions or higher."),/*"このメニューを閲覧することが出来る権限を選択します。<br/>選択した権限以上のユーザーに表示されます。"*/
    ];
  }

  /**
   * ボックスのコンテンツをプリント
   *
   * @param WP_Post $post The object for the current post/page.
   */
  function output_crudiator_table_base_setting($post) {
    $this->ready_crudiator_meta_rule();

    // nonceフィールドを追加して後でチェックする
    wp_nonce_field('post_crudiator_table', '_crudiatornonce');

    echo '<table class="form-table"><tbody>';

    foreach ($this->crudiator_meta_inputs as $meta_key => $meta_input) {
      echo "<tr class='crudiator_meta_input " . esc_attr($meta_key) . "'><th>" . esc_html($meta_input['name']) . "</th><td>";

      // metaキーはprefixにアンダースコアがつける。
      // そうすることでprivateフィールドとなり、投稿画面のカスタムフィールドとして表示されない。
      $value = get_post_meta($post->ID, "_{$meta_key}", true);
      $type  = $meta_input['type'];
      $req   = (isset($meta_input['required']) && $meta_input['required'] == true) ? 'required' : '';
      if ($type == "text" || $type == "number") {
        $ph = (isset($meta_input["placeholder"])) ? $meta_input["placeholder"] : "";
        echo "<input type='" . esc_attr($type) . "' name='" . esc_attr($meta_key) . "' value='" . esc_attr($value) . "' placeholder='" . esc_attr($ph) . "' " . esc_attr($req) . "/>";
      } else if ($type == "select") {
        echo "<select name='" . esc_attr($meta_key) . "' " . esc_attr($req) . ">";
        foreach ($meta_input["rule"] as $val => $str) {
          echo "<option value='" . esc_attr($val) . "' " . selected($value, $val) . ">" . esc_html($str) . "</option>";
        }
        echo "</select>";
      }

      if (isset($meta_input["description"])) {
        // desciption はドキュメントページへのリンクもあるので、scriptタグなどは除外するwp_kese_postを使う
        echo "<p class='description'>" . wp_kses_post($meta_input["description"]) . "</p>";
      }
      echo "</td></tr>";
    }

    echo '</tbody></table>';
  }

  function output_crudiator_table_custom_setting($post) {
    $value = get_post_meta($post->ID, "_custom_setting_json", true);
    // AWSのよくあるjson設定を参考にしたfont-family
    $font = "Monaco, Menlo, Consolas, 'Courier Prime', Courier, 'Courier New', monospace";
    ?>
    <table class="form-table">
      <tbody>
        <tr>
          <th><?= $this->__("Custom setting");/*"カスタム設定"*/ ?> json</th>
          <td>
            <textarea name="custom_setting_json" class="large-text" rows='20' cols='50' style="font-family: <?= $font ?>"><?= $value ?></textarea>
            <p class="description"><?= $this->__("If you want to make custom settings, enter them here in json format.<br>Please refer to the <a href='https://crudiator.com/document/' target='_blank'>documentation</a> for an example.")/*カスタム設定をjson形式で記述します。記述例は<a href="https://crudiator.com/ja/document/" target="_blank">ドキュメント</a>を参考にしてください。*/ ?></p>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
  }

  function on_save_post($post_id) {

    /*
     * save_postアクションは他の時にも起動する場合があるので、
     * 適切な認証とともに送られてきたデータかどうかを検証する必要がある。
     */

    // crudiator専用nonceがセットされているかどうか確認
    if (!isset($_POST['_crudiatornonce'])) {
      return;
    }

    // nonceが正しいかどうか検証
    // check_admin_referer()という認証関数もあるが、これだと失敗時にdieしてしまい、
    // 他からも呼ばれる場合があるsave_postには適していない。
    // 20220913 save_post_{post_type} に変えたので大丈夫かもしれない。いつか変える。
    if (!wp_verify_nonce($_POST['_crudiatornonce'], 'post_crudiator_table')) {
      return;
    }

    // 自動保存の場合はなにもしない
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    // 必要なキーが何かを判断する準備
    $this->ready_crudiator_meta_rule();

    // 必要なキーだけ登録していく
    foreach ($this->crudiator_meta_inputs as $meta_key => $meta_input) {
      if (array_key_exists($meta_key, $_POST)) {
        // キーによってサニタイズする
        if ($meta_key == "menu_slug") {
          $meta_value = sanitize_title($_POST[$meta_key]);
        } else {
          $meta_value = sanitize_text_field($_POST[$meta_key]);
        }

        // 検証
        if ($meta_input["type"] == "select") {  // selectは予め用意したruleにあるかどうか
          if (!array_key_exists($meta_value, $meta_input["rule"])) {
            wp_die($this->__("Invalid value for meta_key.") . "meta_key = {$meta_key}");
          }
        } else if (isset($meta_input["validation"])) {  // validationがある場合は
          $meta_value = call_user_func($meta_input["validation"], $meta_value);
          if ($meta_value === false) {
            wp_die($this->__("Invalid value for meta_key.") . "meta_key = {$meta_key}");
          }
        }

        // DBにはprefixにアンダースコアをつけて投稿画面で非表示とする
        $private_meta_key = '_' . $meta_key;
        update_post_meta($post_id, $private_meta_key, $meta_value);
      }
    }

    // カスタムjsonだけ別個で保存
    if (array_key_exists("custom_setting_json", $_POST)) {
      update_post_meta($post_id, '_custom_setting_json', $_POST["custom_setting_json"]);
    }

  }

  function on_edit_form_after_title() {
    $screen = get_current_screen();
    if ($screen->post_type == "crudiator") {
      echo '<div>' . $this->__("This string becomes the menu name.")/*この文字列がメニュー名になります。*/ . '</div>';
    }
  }

  function on_enter_title_here($title) {
    $screen = get_current_screen();
    if ($screen->post_type == 'crudiator') {
      $title = $this->__("Add menu name");/*'メニュー名を追加'*/
    }
    return $title;
  }

  function on_manage_posts_columns($columns) {
    // タイトルは「メニュー名」に変更
    $columns['title'] = $this->__("Menu Name"); // メニュー名

    // 独自カラムを追加
    $columns['table_name'] = $this->__("Database Table"); // 対象テーブル
    $columns['menu_type']  = $this->__("Menu Type");  // メニュータイプ
    $columns['permission'] = $this->__("Permission");  // アクセス権

    // 日付は列の最後に移動
    $date = $columns['date'];
    unset($columns['date']);
    $columns['date'] = $date;

    return $columns;
  }

  function on_manage_posts_custom_column($column_name, $post_id) {
    if ($column_name == 'table_name') {
      $metavalue = get_post_meta($post_id, '_table_name', true);
      echo isset($metavalue) ? "<code>" . esc_html($metavalue) . "</code>" : '－';
    } else if ($column_name == 'menu_type') {
      $metavalue = get_post_meta($post_id, '_menu_type', true);
      echo isset($this->CRUDIATOR_RULES["menu_type"][$metavalue]) ? $this->CRUDIATOR_RULES["menu_type"][$metavalue] : '－';
    } else if ($column_name == 'permission') {
      $metavalue = get_post_meta($post_id, '_capability', true);
      echo isset($this->CRUDIATOR_RULES["capability"][$metavalue]) ? $this->CRUDIATOR_RULES["capability"][$metavalue] : '－';
    }
  }

  function on_post_row_actions($actions, $post) {
    //check for your post type
    if ($post->post_type == "crudiator") {
      $menu_slug = get_post_meta($post->ID, '_menu_slug', true);

      if (empty($menu_slug)) {  // スラッグ名を指定していない時はテーブル名としている
        $menu_slug = get_post_meta($post->ID, '_table_name', true);
      }
      if ($menu_slug) {
        $url             = admin_url("admin.php?page={$menu_slug}");
        $actions["show"] = "<a href='" . esc_attr($url) . "'>" . $this->__("Show")/*表示*/ . "</a>";
      }
    }
    return $actions;
  }

  private function __($text) {
    return __($text, "crudiator");
  }
}

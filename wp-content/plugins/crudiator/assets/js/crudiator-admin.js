jQuery(function () {
  var $ = jQuery.noConflict();

  // ドキュメントが読み込まれた時にまずメニュー状態による入力を変えます。
  change_menu_type();
  change_icon_url();

  // selectが変更された時の処理登録
  $('#post-body select[name="table_name"]').change(change_table_name);
  $("#post-body select[name='menu_type']").change(change_menu_type);
  $("#post-body select[name='icon_url']").change(change_icon_url);

  // post_titleは入力必須フィールドとする
  $('#post-body input[name="post_title"]').attr('required', 'required');

  // スラッグ名は小文字英数字・ハイフン・アンダースコアのみに変換する
  $('#post-body input[name="menu_slug"]').on('input', function () {
    $(this).val(sanitize_slug($(this).val()));
  })

  // もし新規ページなどでスラッグ名が空の場合はテーブル名から入力する
  if ($('#post-body input[name="menu_slug"]').val() == "") {
    change_table_name();
  }

  // スラッグ名として不正な文字を除去します
  function sanitize_slug(str) {
    // 英数小文字・ハイフン・アンダースコアのみにする
    str = str.replace(/[^a-z\-\_0-9]+/i, '').toLowerCase();
    return str;
  }

  // データベーステーブルが変更されたらそのテーブル名をスラッグ名に補完入力します
  function change_table_name() {
    // もしテーブル名が日本語の場合は空文字となりmenu_slugのrequiredで保存不可となる
    var menu_slug = sanitize_slug($('#post-body select[name="table_name"]').val());
    $('#post-body input[name="menu_slug"]').val(menu_slug);
  }

  function change_menu_type() {
    var $select = $(".crudiator_meta_input.menu_type select[name='menu_type']");
    if ($select.val() == "topmenu") {
      $("select[name='submenu_parent']").attr("disabled", "disabled");
      $("[name='icon_url']").removeAttr("disabled", "disabled");
      $('.crudiator_meta_input.position_topmenu').show();
      $('.crudiator_meta_input.position_submenu').hide();
    } else if ($select.val() == "submenu") {
      $("select[name='submenu_parent']").removeAttr("disabled", "disabled");
      $("[name='icon_url']").attr("disabled", "disabled");
      $('.crudiator_meta_input.position_topmenu').hide();
      $('.crudiator_meta_input.position_submenu').show();
    }
  }

  function change_icon_url() {
    $icon_url = $('[name="icon_url"]');
    $('.icon_url_preview').remove();
    if ($icon_url.val() != "") {
      var html = '<span class="icon_url_preview dashicons-before ' + $icon_url.val() + '" style="display: inline-block;margin-left: 4px;"></span>'
      $icon_url.after(html);
    }
  }
});
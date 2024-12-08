jQuery(function () {
  var $ = jQuery.noConflict();
  var isBulkAction = false;

  $.datetimepicker.setLocale('ja');

  $('#crudiator-wrap input[type="text"].datetime').datetimepicker({
    format: 'Y-m-d H:i:s',
  });

  $('#crudiator-wrap input[type="text"].date').datetimepicker({
    format: 'Y-m-d',
    timepicker: false,
  });

  $('#crudiator-wrap input[type="text"].time').datetimepicker({
    format: 'H:i:s',
    datepicker: false,
  });

  // 数値型・小数点型は数値系のみ入力とする
  $('#crudiator-wrap .integer, #crudiator-wrap .float').on('input', function () {
    $(this).val($(this).val().replace(/[^\.\-0-9]+/i, ''))
  })

  // crudiator内の削除リンクにバインド
  $('.crudiator .delete a').click(function () {
    // テーブル内の削除リンクはどのデータかを確認した上で削除処理
    var pri_val_json = $(this).parents('.crudiator-row').attr('data-id');
    var pri_val = JSON.parse(pri_val_json);
    var msg = translate_str.confirm_delete_list + "\n";
    for (var i = 0; i < CRUDIATOR_PRIMARY_KEYS.length; i++) {
      if (i != 0) { // 2個目以降はカンマ付与
        msg += ", ";
      }
      msg += CRUDIATOR_PRIMARY_KEYS[i] + " : " + String(pri_val[i]);
    }

    if (window.confirm(msg)) {
      return true;
    }
    return false;
  })

  // 詳細ページの削除ボタン  
  $('#crudiator-wrap.action-detail .detail-buttons .delete').click(function () {
    // 詳細ページは単一データが表示された状態なので単純な確認した上で削除処理
    if (window.confirm(translate_str.confirm_delete_this)) {
      return true;
    }
    return false;
  })

  // 一括操作のボタンが押された時
  $('#doaction, #doaction2').click(function () {
    isBulkAction = true;  // 一括操作のボタンが押されたことをフラグとして持つ
  })

  // 一括操作時のsubmit
  $('form#crudiator_form').submit(function ($e) {
    // 一括操作ボタンが押されてた場合はアクションごとの操作にする
    if (isBulkAction == true) {
      var bulk_action = $('#bulk-action-selector-top').val();
      if (bulk_action == "bulk_delete") {

        var item_num = $('#crudiator-wrap input[name="crudiator_item[]"]:checked').length;

        // 選択チェック
        if (item_num === 0) {
          window.alert(translate_str.item_no_select);
          return false;
        }
        var msg = translate_str.confirm_delete_select + "\n";
        msg += translate_str.item_count + item_num;
        if (window.confirm(msg)) {
          return true;
        } else {
          isBulkAction = false; // キャンセルしたのでフラグもリセット
          return false;
        }
      }
    } else {
      // それ以外のページングや全文検索のボタンやEnter実行の場合は一括操作のアクションを無効にして送信する
      $('#bulk-action-selector-top').val("-1");
      $('#bulk-action-selector-bottom').val("-1");
      $('#crudiator_form input[name="crudiator_item[]"]').prop("checked", false);
      $('#crudiator_form input#cb-select-all-1').prop("checked", false);
      return true;
    }
  });

  /**
   * 更新ページでDOMが読み込まれた後にnullチェックボックスがcheckedの場合はその入力パーツをdisabled状態にする。
   * これは、保存時にエラーがあってブラウザバックした時も対象である。
   * ここでは敢えて10ms遅らせているのがミソ。遅らせているというよりはChromeのブラウザバックによる値復元処理に
   * スレッドを渡した後の実行にしている。Firefoxでは大丈夫だったがChromeはこれをしないとダメだった。
   * 因みに1msでも大丈夫だったが、少しだけ余裕を持って10msとしている。
   */
  setTimeout(function () {
    $('#crudiator-wrap .null-checkbox input[type=checkbox]').each(function () {
      if ($(this).prop("checked") == true) { // == null
        var $form_parts = $(this).parents('td').find('.form-parts');
        $form_parts.attr('disabled', "disabled");
      }
    });
  }, 10);

  $('#crudiator-wrap .null-checkbox input[type=checkbox]').change(function () {
    var $td = $(this).parents('td');  // 直属のtd
    var $form_parts = $td.find('.form-parts');  // 入力系部品
    if ($(this).prop("checked") == true) {
      $form_parts.attr('disabled', "disabled");
    } else {  // false
      $form_parts.removeAttr('disabled');
    }
  });

  // ［データを絞り込み］ボタン
  $('#crudiator_filter_button').click(function () {
    var $crudiator_filter_wrap = $('#crudiator-filter-wrap');
    // hiddenクラスを消して絞り込み画面を表示
    if ($crudiator_filter_wrap.hasClass('hidden')) {
      $crudiator_filter_wrap.removeClass('hidden');
    }
  });

  // データを絞り込みの［キャンセル］ボタン、又はダイアログ背景のクリック
  $('#crudiator-filter-dialog .button-cancel, #crudiator-filter-dialog-background').click(function () {
    var $crudiator_filter_wrap = $('#crudiator-filter-wrap');
    $crudiator_filter_wrap.addClass('hidden');
  });

  // データを絞り込みの［実行］ボタン
  $('#crudiator-filter-form').submit(function () {
    $('#crudiator-filter-form .condition-list li').each(function () {
      // 1つめのandorだけ送らないようにする
      $(this).find('.andor').attr("disabled", "disabled");
      return false;
    });
    return true;
  });

  // データを絞り込みの［＋］ボタン（条件追加）
  $('#crudiator-filter-dialog .button-add-condition').click(function () {

    /**
     * やっぱりここで複数条件のindexの採番をすることにした。
     * 何故かというと、根本原因はinput type="radio"のname！
     * 一つの同じnameのhtmlにすると、3つ以上条件ある時に同じradioグループとなってしまい同時に選択されてしまうから。
     * なので、html生成時に完全に決定されたnameにする必要がある為、
     * この条件追加イベントで自動インクリメントされたnameを決定する。
     */
    var i = $('#crudiator-filter-form .condition-list').attr('data-li_cnt'); // 現在のliの数がそのまま次のindexとなりえる
    var $html = $($('#crudiator-condition-template').html());
    $html.find('.andor').attr('name', "filter[" + i + "][ao]");
    $html.find('.field').attr('name', "filter[" + i + "][f]");
    $html.find('.operator').attr('name', "filter[" + i + "][o]");
    $html.find('.value').attr('name', "filter[" + i + "][v]");

    $('#crudiator-filter-dialog .condition-list').append($html);
    $('#crudiator-filter-form .condition-list').attr('data-li_cnt', (Number(i) + 1));  // liの数を1増やす

    if (!$('#crudiator-filter-dialog-content').hasClass("multi-condition")) {
      $('#crudiator-filter-dialog-content').addClass('multi-condition');
    }
  });

  // データを絞り込みの［ー］ボタン（条件削除）
  $('#crudiator-filter-dialog .condition-list').on('click', '.button-del-condition', function () {
    var $li = $(this).parents('li');
    $li.remove();
    if ($('.condition-list li').length == 1) {
      $('#crudiator-filter-dialog-content').removeClass('multi-condition');
    }
  });

  // 比較演算子の選択
  $('#crudiator-filter-dialog .condition-list').on('change', '.operator', function () {
    var val = $(this).val();
    if (val.indexOf("is") !== -1) { // IS系はinputを無効化する
      $(this).parents('li').find('input.value').attr("readonly", "readonly");
    } else {
      $(this).parents('li').find('input.value').removeAttr("readonly");
    }
  });

  $('#crudiator_export input[name="export_action"]').click(function () {
    var s = location.search;
    // viewパラメータまたはfilterパラメータがある場合はメッセージ出す
    if (s.indexOf("view") !== -1 || s.indexOf("filter") !== -1) {
      window.alert(translate_str.view_filter_export);
    }
    return true;
  });

  // debugウィンドウ要素がある場合のみ
  var $crudiatorDebug = $('#crudiator-debug');
  if ($crudiatorDebug.length) {
    // 最初にローカルストレージからdebugウィンドウの表示状態を取得する
    var show = localStorage.getItem("crudiator-debug-show");
    // ローカルストレージにそのキー値がないか（初回）、もしくは"on"なら最初は表示状態にする
    if (!show || show == "on") {
      $crudiatorDebug.attr("data-show", "on");
    } else {
      $crudiatorDebug.attr("data-show", "off");
    }

    $crudiatorDebug.show(); // display:none;の解除 こうすることで最初のheightのtransitionを見せない

    // 拡縮ボタンのクリックで要素を拡縮する
    $crudiatorDebug.find('.expand-btn').click(function () {
      var attrDataShow = $crudiatorDebug.attr("data-show");
      if (!attrDataShow || attrDataShow == "on") {
        $crudiatorDebug.attr("data-show", "off");
        localStorage.setItem("crudiator-debug-show", "off");
      } else {    // data-show="off"
        $crudiatorDebug.attr("data-show", "on");
        localStorage.setItem("crudiator-debug-show", "on");
      }
    });
  }

});
<?php
/**
 * Crudiator内で使う定数
 * Crudiatorクラスのconst定数だと関数使えないので、
 * このようにファイルでdefine定義してautoload.phpで読み込むようにした。
 */
define("CRUDIATOR_DIR", __DIR__);
define("CRUDIATOR_DIR_URL", plugin_dir_url(__FILE__));
<?php
namespace Crudiator;


/**
 * CSVダウンロードを簡単にするクラス
 */
class MyCsv {

  static function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
  }

  static function array2csv(array &$array, $encode, $columns = []) {
    if (count($array) == 0) {
      return null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    
    // カラム指定があるときはそちらを優先
    if ( $columns ){
      fputcsv($df, $columns);
    }else{
      fputcsv($df, array_keys(reset($array)));
    }
    
    foreach ($array as $row) {
      fputcsv($df, $row);
    }
    fclose($df);
    $output_str = ob_get_clean();
    
    // SJIS指定の場合はエンコードする
    if ( $encode == "SJIS" ) {
      // サポートされるコーディング文字列はこちら↓
      // https://www.php.net/manual/ja/mbstring.supported-encodings.php
      $output_str = mb_convert_encoding($output_str, "SJIS", "UTF-8");
    }
    
    return $output_str;
  }

  /**
   * csvファイルとしてダウンロードさせます
   * @param $array
   * @param $encode
   */
  static function export($filename, $array, $encode, $columns = []) {
    self::download_send_headers($filename . ".csv");
    echo self::array2csv($array, $encode, $columns);
    exit();
  }

}

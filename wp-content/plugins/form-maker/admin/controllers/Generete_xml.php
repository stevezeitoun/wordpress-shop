<?php

/**
 * Class FMControllerGenerete_xml
 */
class FMControllerGenerete_xml {
  /**
   * Execute.
   */
  public function execute() {
    $this->display();
  }

  public function display() {
    $form_id = (int) $_REQUEST['form_id'];
    $limitstart = (int) $_REQUEST['limitstart'];
    $send_header = (int) $_REQUEST['send_header'];
    $params = WDW_FM_Library::get_submissions_to_export();
    $data = $params[0];
    $title = $params[1];
    define('PHP_TAB', "\t");
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/form-maker';
    if ( !is_dir($file_path) ) {
      mkdir($file_path, 0777);
    }
    $tempfile = $file_path . '/export' . $form_id . '.txt';
    if ( $limitstart == 0 && file_exists($tempfile) ) {
      unlink($tempfile);
    }
    $output = fopen($tempfile, "a");
    if ( $limitstart == 0 ) {
      fwrite($output, '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL);
      fwrite($output, '<form title="' . $title . '">' . PHP_EOL);
    }
    foreach ( $data as $key1 => $value1 ) {
      fwrite($output, PHP_TAB . '<submission id="' . $key1 . '">' . PHP_EOL);
      foreach ( $value1 as $key => $value ) {
        fwrite($output, PHP_TAB . PHP_TAB . '<field title="' . $key . '">' . PHP_EOL);
        fwrite($output, PHP_TAB . PHP_TAB . PHP_TAB . '<![CDATA[' . $value . ']]>' . PHP_EOL);
        fwrite($output, PHP_TAB . PHP_TAB . '</field>' . PHP_EOL);
      }
      fwrite($output, PHP_TAB . '</submission>' . PHP_EOL);
    }
    if ( $send_header == 1 ) {
      fwrite($output, '</form>');
      fclose($output);
      $txtfile = fopen($tempfile, "r");
      $txtfilecontent = fread($txtfile, filesize($tempfile));
      fclose($txtfile);
      $filename = $title . "_" . date('Ymd') . ".xml";
      header('Content-Encoding: Windows-1252');
      header('Content-type: text/xml; charset=utf-8');
      header("Content-Disposition: attachment; filename=\"$filename\"");
      echo $txtfilecontent;
      unlink($tempfile);
    }

    die();
  }
}

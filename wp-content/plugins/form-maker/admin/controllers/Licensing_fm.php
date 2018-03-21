<?php

/**
 * Class FMControllerLicensing_fm
 */
class FMControllerLicensing_fm {
  private $view;
  public function __construct() {
    require_once WDFM()->plugin_dir . "/admin/views/Licensing_fm.php";
    $this->view = new FMViewLicensing_fm();
  }
  public function execute() {
    $task = WDW_FM_Library::get('task');
    $id = (int) WDW_FM_Library::get('current_id', 0);
    if (method_exists($this, $task)) {
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    $this->view->display();
  }
}
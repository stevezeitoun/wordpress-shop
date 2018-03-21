<?php

/**
 * Class FMControllerOptions_fm
 */
class FMControllerOptions_fm {
  private $model;
  private $view;

  public function __construct() {
    require_once WDFM()->plugin_dir . "/admin/models/Options_fm.php";
    $this->model = new FMModelOptions_fm();
    require_once WDFM()->plugin_dir . "/admin/views/Options_fm.php";
    $this->view = new FMViewOptions_fm();
  }

  public function execute() {
    $task = WDW_FM_Library::get('task');
    $id = (int) WDW_FM_Library::get('current_id', 0);
    if ( method_exists($this, $task) ) {
      check_admin_referer(WDFM()->nonce, WDFM()->nonce);
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    $fm_settings = get_option('fm_settings');
    $this->view->display($fm_settings);
  }

  public function save() {
    $message = $this->model->save_db();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                'page' => $page,
                                                'task' => 'display',
                                                'message' => $message,
                                              ), admin_url('admin.php')));
  }
}

<?php

class FMControllerShow_matrix {
  /**
   * @var $view
   */
  private $view;

  /**
   * Execute.
   */
  public function execute() {
    $this->display();
  }

  /**
   * Display.
   */
  public function display() {
    // Load FMViewShow_matrix class.
    require_once WDFM()->plugin_dir . "/admin/views/FMShowMatrix.php";
    $this->view = new FMViewShow_matrix();
    // Set params for view.
    $params = array();
    $this->view->display($params);
  }
}

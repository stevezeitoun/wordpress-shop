<?php

/**
 * Class FMControllerFormmakereditcountryinpopup
 */
class FMControllerFormmakereditcountryinpopup {
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
    // Load FMViewFromeditcountryinpopup class.
    require_once WDFM()->plugin_dir . "/admin/views/FMEditCountryinPopup.php";
    $this->view = new FMViewFromeditcountryinpopup();
    // Set params for view.
    $params = array();
    $params['field_id'] = WDW_FM_Library::get('field_id', 0);
    $this->view->display($params);
  }
}

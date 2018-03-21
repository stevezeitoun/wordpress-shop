<?php

/**
 * Class FMControllerSelect_data_from_db
 */
class FMControllerSelect_data_from_db {
  /**
   * @var $model
   */
  private $model;
  /**
   * @var $view
   */
  private $view;

  public function __construct() {
    // Load FMModelSelect_data_from_db class.
    require_once WDFM()->plugin_dir . "/admin/models/FMSelectDataFromDb.php";
    $this->model = new FMModelSelect_data_from_db();
    // Load FMViewSelect_data_from_db class.
    require_once WDFM()->plugin_dir . "/admin/views/FMSelectDataFromDb.php";
    $this->view = new FMViewSelect_data_from_db();
  }

  /**
   * Execute.
   */
  public function execute() {
    $task = WDW_FM_Library::get('task', 0);
    $id = WDW_FM_Library::get('id', 0);
    $form_id = WDW_FM_Library::get('form_id', 0);
    $field_id = WDW_FM_Library::get('field_id', 0);
    $value_disabled = WDW_FM_Library::get('value_disabled', 0);
    $field_type = WDW_FM_Library::get('field_type', '');
    if ( $task && method_exists($this, $task) ) {
      $this->$task($form_id, $field_type = "");
    }
    else {
      $this->display($id, $form_id, $field_id, $field_type, $value_disabled);
    }
  }

  /**
   * Display.
   *
   * @param  int    $id
   * @param  int    $form_id
   * @param  int    $field_id
   * @param  string $field_type
   * @param  int    $value_disabled
   */
  public function display( $id, $form_id, $field_id, $field_type, $value_disabled ) {
    // Set params for view.
    $params = array();
    $params['id'] = $id;
    $params['form_id'] = $form_id;
    $params['field_id'] = $field_id;
    $params['field_type'] = $field_type;
    $params['value_disabled'] = $value_disabled;
    $this->view->display($params);
  }

  /**
   * Data base tables.
   *
   * @param  int    $form_id
   * @param  string $field_type
   */
  public function db_tables( $form_id, $field_type ) {
    // Get tables.
    $tables = $this->model->get_tables();
    // Set params for view.
    $params = array();
    $params['form_id'] = $form_id;
    $params['field_type'] = $field_type;
    $params['tables'] = $tables;
    $this->view->db_tables($params);
  }

  public function db_table_struct_select( $form_id, $field_type ) {
    // Get labels by form id.
    $label = $this->model->get_labels($form_id);
    // Get table struct.
    $table_struct = $this->model->get_table_struct();
    // Set params for view.
    $params = array();
    $params['form_id'] = $form_id;
    $params['field_type'] = $field_type;
    $params['label'] = $label;
    $params['table_struct'] = $table_struct;
    $this->view->db_table_struct_select($params);
  }
}

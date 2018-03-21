<?php

/**
 * Class FMControllerFormMakerSQLMapping
 */
class FMControllerFormMakerSQLMapping {
  /**
   * @var $model
   */
  private $model;
  /**
   * @var $view
   */
  private $view;

  /**
   * FMControllerFormMakerSQLMapping constructor.
   */
  public function __construct() {
    // Load FMModelFormMakerSQLMapping class.
    require_once WDFM()->plugin_dir . "/admin/models/FMSqlMapping.php";
    $this->model = new FMModelFormMakerSQLMapping();
    // Load FMViewFormMakerSQLMapping class.
    require_once WDFM()->plugin_dir . "/admin/views/FMSqlMapping.php";
    $this->view = new FMViewFormMakerSQLMapping();
  }

  /**
   * Execute.
   */
  public function execute() {
    $id = WDW_FM_Library::get('id', '');
    $form_id = WDW_FM_Library::get('form_id', '');
    $task = WDW_FM_Library::get('task', '');
    if ( $task && method_exists($this, $task) ) {
      $this->$task($form_id);
    }
    else {
      if ( $id ) {
        $this->edit_query($id, $form_id);
      }
      else {
        $this->add_query($form_id);
      }
    }
  }

  /**
   * Add query.
   *
   * @param  int $form_id
   */
  public function add_query( $form_id ) {
    // Get labels by form id.
    $label = $this->model->get_labels($form_id);
    // Set params for view.
    $params = array();
    $params['label'] = $label;
    $params['form_id'] = $form_id;
    $this->view->add_query($params);
  }

  /**
   * Edit query.
   *
   * @param  int $id
   * @param  int $form_id
   */
  public function edit_query( $id, $form_id ) {
    // Get labels by form id.
    $label = $this->model->get_labels($form_id);
    // Get query by id.
    $query_obj = $this->model->get_query($id);
    $temp = explode('***wdfcon_typewdf***', $query_obj->details);
    $con_type = $temp[0];
    $temp = explode('***wdfcon_methodwdf***', $temp[1]);
    $con_method = $temp[0];
    $temp = explode('***wdftablewdf***', $temp[1]);
    $table_cur = $temp[0];
    $temp = explode('***wdfhostwdf***', $temp[1]);
    $host = $temp[0];
    $temp = explode('***wdfportwdf***', $temp[1]);
    $port = $temp[0];
    $temp = explode('***wdfusernamewdf***', $temp[1]);
    $username = $temp[0];
    $temp = explode('***wdfpasswordwdf***', $temp[1]);
    $password = $temp[0];
    $temp = explode('***wdfdatabasewdf***', $temp[1]);
    $database = $temp[0];
    $details = $temp[1];
    $tables = $this->model->get_tables_saved($con_type, $username, $password, $database, $host);
    $table_struct = $this->model->get_table_struct_saved($con_type, $username, $password, $database, $host, $table_cur, $con_method);
    // Set params for view.
    $params = array();
    $params['id'] = $id;
    $params['form_id'] = $form_id;
    $params['label'] = $label;
    $params['query_obj'] = $query_obj;
    $params['tables'] = $tables;
    $params['table_struct'] = $table_struct;
    $this->view->edit_query($params);
  }

  /**
   * DB tables.
   *
   * @param  int $form_id
   */
  public function db_tables( $form_id ) {
    // Get all tables.
    $tables = $this->model->get_tables();
    // Set params for view.
    $params = array();
    $params['tables'] = $tables;
    $params['form_id'] = $form_id;
    $this->view->db_tables($params);
  }

  /**
   * DB table struct.
   *
   * @param  int $form_id
   */
  public function db_table_struct( $form_id ) {
    $con_method = WDW_FM_Library::get('con_method', '');
    // Get labels by form id.
    $label = $this->model->get_labels($form_id);
    // Get table struct.
    $table_struct = $this->model->get_table_struct();
    // Set params for view.
    $params = array();
    $params['form_id'] = $form_id;
    $params['label'] = $label;
    $params['table_struct'] = $table_struct;
    $params['con_method'] = $con_method;
    $this->view->db_table_struct($params);
  }

  public function save_query() {
    global $wpdb;
    $form_id = ((isset($_GET['form_id'])) ? (int) $_GET['form_id'] : 0);
    $query = ((isset($_POST['query'])) ? stripslashes(wp_specialchars_decode($_POST['query'])) : "");
    $details = ((isset($_POST['details'])) ? esc_html($_POST['details']) : "");
    $save = $wpdb->insert($wpdb->prefix . 'formmaker_query', array(
      'form_id' => $form_id,
      'query' => $query,
      'details' => $details,
    ), array(
                            '%d',
                            '%s',
                            '%s',
                          ));
  }

  public function update_query() {
    global $wpdb;
    $id = ((isset($_GET['id'])) ? (int) $_GET['id'] : 0);
    $form_id = ((isset($_GET['form_id'])) ? (int) $_GET['form_id'] : 0);
    $query = ((isset($_POST['query'])) ? stripslashes(wp_specialchars_decode($_POST['query'])) : "");
    $details = ((isset($_POST['details'])) ? esc_html($_POST['details']) : "");
    $save = $wpdb->update($wpdb->prefix . 'formmaker_query', array(
      'form_id' => $form_id,
      'query' => $query,
      'details' => $details,
    ), array( 'id' => $id ));
  }
}

<?php

/**
 * Class FMControllerBlocked_ips_fm
 */
class FMControllerBlocked_ips_fm {
  private $model;
  private $view;
  private $bulk_action_name = '';
  private $items_per_page = 20;
  private $actions = array();

  public function __construct() {
    require_once WDFM()->plugin_dir . "/admin/models/Blocked_ips_fm.php";
    require_once WDFM()->plugin_dir . "/admin/views/Blocked_ips_fm.php";
    $this->model = new FMModelBlocked_ips_fm();
    $this->view = new FMViewBlocked_ips_fm();

    $this->page = WDW_FM_Library::get('page');

    $this->bulk_action_name = 'bulk_action';

    $this->actions = array(
      'delete' => array(
        'title' => __('Delete', WDFM()->prefix),
        $this->bulk_action_name => __('deleted', WDFM()->prefix),
      ),
    );
  }

  public function execute() {
    $task = WDW_FM_Library::get('task');
    $id = (int) WDW_FM_Library::get('current_id', 0);

    if ( method_exists($this, $task) ) {
      check_admin_referer(WDFM()->nonce, WDFM()->nonce);
      $block_action = $this->bulk_action_name;
      $action = WDW_FM_Library::get( $block_action, -1 );
      if ( $action != -1 ) {
        $this->$block_action($action);
      }
      else {
        $this->$task($id);
      }
    }
    else {
      $this->display();
    }
  }

  public function display() {
    $params = array();
    $params['order'] = WDW_FM_Library::get('order', 'desc');
    $params['orderby'] = WDW_FM_Library::get('orderby', 'id');
    // To prevent SQL injections.
    if ( !in_array($params['orderby'], array( 'id', 'ip' )) ) {
      $params['orderby'] = 'id';
    }
    $params['order'] = $params['order'] == 'desc' ? 'desc' : 'asc';

    $params['items_per_page'] = $this->items_per_page;

    $params['rows_data'] = $this->model->get_rows_data($params);

    $params['total'] = $this->model->total();

    $params['actions'] = $this->actions;
    $params['page'] = $this->page;

    $this->view->display($params);
  }

  /**
   * Bulk actions.
   *
   * @param $task
   */
  public function bulk_action($task) {
    $message = 0;
    $successfully_updated = 0;
    $check = WDW_FM_Library::get('check', '');
    if ( $check ) {
      foreach ( $check as $id => $item ) {
        if ( method_exists($this, $task) ) {
          $message = $this->$task($id, TRUE);
          if ( $message != 2 ) {
            // Increase successfully updated items count, if action doesn't failed.
            $successfully_updated++;
          }
        }
      }
      if ( $successfully_updated ) {
        $block_action = $this->bulk_action_name;
        $message = sprintf(_n('%s item successfully %s.', '%s items successfully %s.', $successfully_updated, WDFM()->prefix), $successfully_updated, $this->actions[$task][$block_action]);
      }
    }
    WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                'page' => $this->page,
                                                'task' => 'display',
                                                ($message === 2 ? 'message' : 'msg') => $message,
                                              ), admin_url('admin.php')));
  }

  public function insert_blocked_ip() {

    $page = WDW_FM_Library::get('page');

    $ip = WDW_FM_Library::get('ip','');

    $insert = $this->model->insert_fm_blocked(array('ip' => $ip,), array('%s',));
    if( !$insert ){
      $message = 2;
      WDW_FM_Library::fm_redirect(add_query_arg(array(
          'page' => $page,
          'task' => 'display',
          'message' => $message,
      ), admin_url('admin.php')));
    }
  }

  public function delete_blocked_ip( $id ) {
    $page = WDW_FM_Library::get('page');
    // check  id for db
    if(isset($id) && $id != "") {
      $id = intval($id);
      $delete = $this->model->delete_data($id);

      if( !$delete ){
        $message = 2;
        WDW_FM_Library::fm_redirect(add_query_arg(array(
            'page' => $page,
            'task' => 'display',
            'message' => $message,
        ), admin_url('admin.php')));
      }

    }
    else { // return message Failed
      $message = 2;
      WDW_FM_Library::fm_redirect(add_query_arg(array(
          'page' => $page,
          'task' => 'display',
          'message' => $message,
      ), admin_url('admin.php')));
    }

    $total = $this->model->total(); // get total count of blocked IPs
    if( ($total % $this->items_per_page) == 0 ) {

      echo '<div id="total_for_paging">'.$total/$this->items_per_page.'</div>'; // send to JS page number
    }


  }

  public function update_blocked_ip( $id ) {
    $page = WDW_FM_Library::get('page');

    // check  id for db
    if(isset($id) && $id != "") {
      $id = intval($id);
      $ip = WDW_FM_Library::get('ip', '');
      $update = $this->model->update_fm_blocked(array('ip' => $ip,), array('id' => $id));

      if( !$update ){
        $message = 2;
        WDW_FM_Library::fm_redirect(add_query_arg(array(
            'page' => $page,
            'task' => 'display',
            'message' => $message,
        ), admin_url('admin.php')));
      }

    }
    else { // return message Failed
      $message = 2;
      WDW_FM_Library::fm_redirect(add_query_arg(array(
          'page' => $page,
          'task' => 'display',
          'message' => $message,
      ), admin_url('admin.php')));
    }

  }

  public function delete( $id, $bulk = FALSE ) {
    if ( $this->model->delete_data($id) ) {
      $message = 3;
    }
    else {
      $message = 2;
    }

    if ( $bulk ) {
      return $message;
    }
    else {
      WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                  'page' => $this->page,
                                                  'task' => 'display',
                                                  'message' => $message,
                                                ), admin_url('admin.php')));
    }
  }

  public function save() {
    $message = $this->save_db();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                'page' => $page,
                                                'task' => 'display',
                                                'message' => $message,
                                              ), admin_url('admin.php')));
  }

  public function save_db() {
    $id = (isset($_POST['current_id']) ? (int) $_POST['current_id'] : 0);
    $ip = (isset($_POST['ip']) ? esc_html(stripslashes($_POST['ip'])) : '');
    if ( $id != 0 ) {
      $save = $this->model->update_fm_blocked(array(
                                                'ip' => $ip,
                                              ), array( 'id' => $id ));
    }
    else {
      $save = $this->model->insert_fm_blocked(array(
                                                'ip' => $ip,
                                              ), array(
                                                '%s',
                                              ));
    }
    if ( $save !== FALSE ) {
      $message = 1;
    }
    else {
      $message = 2;
    }
    return $message;
  }

  public function save_all() {
    $flag = FALSE;
    $ips_id_col = $this->model->get_col_data();
    foreach ( $ips_id_col as $ip_id ) {
      if ( isset($_POST['ip' . $ip_id]) ) {
        $ip = esc_html(stripslashes($_POST['ip' . $ip_id]));
        if ( $ip == '' ) {
          $this->model->delete_data($ip_id);
        }
        else {
          $flag = TRUE;
          $this->model->update_fm_blocked(array(
                                            'ip' => $ip,
                                          ), array( 'id' => $ip_id ));
        }
      }
    }
    if ( $flag ) {
      $message = 1;
    }
    else {
      $message = 0;
    }
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                'page' => $page,
                                                'task' => 'display',
                                                'message' => $message,
                                              ), admin_url('admin.php')));
  }
}

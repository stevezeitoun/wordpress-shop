<?php

/**
 * Class FMModelBlocked_ips_fm
 */
class FMModelBlocked_ips_fm {
  /**
   * Get blocked Ips.
   *
   * @param $params
   *
   * @return array|null|object
   */
  public function get_rows_data($params) {
    $order = $params['order'];
    $orderby = $params['orderby'];
    $items_per_page = $params['items_per_page'];
    $search = WDW_FM_Library::get('s', '');
    $page = (int) WDW_FM_Library::get('paged', 1);
    $limit = $page ? ($page - 1) * $items_per_page : 0;

    global $wpdb;
    $query = "SELECT * FROM `" . $wpdb->prefix . "formmaker_blocked` ";
    if ( $search ) {
      $query .= 'WHERE `ip` LIKE "%' . $search . '%"';
    }
    $query .= ' ORDER BY `' . $orderby . '` ' . $order;
    $query .= " LIMIT " . $limit . "," . $items_per_page;
    $rows = $wpdb->get_results($query);

    return $rows;
  }

  public function get_row_data( $id ) {
    global $wpdb;
    if ( $id != 0 ) {
      $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'formmaker_blocked WHERE id="%d"', $id));
    }
    else {
      $row = new stdClass();
      $row->id = 0;
      $row->ip = '';
    }

    return $row;
  }

  /**
   * Return total count of blocked IPs.
   *
   * @return null|string
   */
  public function total() {
    global $wpdb;
    $query = "SELECT COUNT(*) FROM `" . $wpdb->prefix . "formmaker_blocked`";

    $search = WDW_FM_Library::get('s', '');
    if ( $search ) {
      $query .= ' WHERE `ip` LIKE "%' . $search . '%"';
    }

    $total = $wpdb->get_var($query);
    return $total;
  }

  /**
   * Update formmaker_blocked table.
   *
   * @param array $params
   * @param array $where
   *
   * @return bool
   */
  public function update_fm_blocked( $params, $where ) {
    global $wpdb;
    return $wpdb->update($wpdb->prefix . 'formmaker_blocked', $params, $where);
  }

  /**
   * Insert to formmaker_blocked table.
   *
   * @param array $param_ins
   * @param array $param_type
   *
   * @return bool
   */
  public function insert_fm_blocked( $param_ins, $param_type ) {
    global $wpdb;
    return $wpdb->insert($wpdb->prefix . 'formmaker_blocked', $param_ins, $param_type);
  }

  /**
   * Get col id from formmaker_blocked table.
   *
   * @return array
   */
  public function get_col_data() {
    global $wpdb;
    return $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'formmaker_blocked');
  }

  /**
   * Delete blocked IP.
   *
   * @param int $id
   *
   * @return array
   */
  public function delete_data( $id ) {
    global $wpdb;
    return $wpdb->query($wpdb->prepare('DELETE FROM `' . $wpdb->prefix . 'formmaker_blocked` WHERE id="%d"', $id));
  }
}

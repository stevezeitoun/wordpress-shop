<?php

/**
 * Class FMModelFormMakerSQLMapping
 */
class FMModelFormMakerSQLMapping {
  /**
   * Get query by id.
   *
   * @param $id
   *
   * @return array|null|object|void
   */
  function get_query( $id ) {
    global $wpdb;
    $rows = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "formmaker_query where id=" . $id);

    return $rows;
  }

  /**
   * Get labels by id.
   *
   * @param  int $id
   *
   * @return (string|null) $rows
   */
  function get_labels( $id ) {
    global $wpdb;
    $rows = $wpdb->get_var("SELECT label_order_current FROM " . $wpdb->prefix . "formmaker where id=" . $id);

    return $rows;
  }

  /**
   * Get tables.
   *
   * @return object $tables
   */
  function get_tables() {
    global $wpdb;
    $con_type = $_POST['con_type'];
    if ( $con_type == 'local' ) {
      $query = "SHOW TABLES";
      $tables = $wpdb->get_col($query);
    }
    else {
      if ( $con_type == 'remote' ) {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $database = isset($_POST['database']) ? $_POST['database'] : '';
        $host = isset($_POST['host']) ? $_POST['host'] : '';
        $wpdb_temp = new wpdb($username, $password, $database, $host);
        $query = "SHOW TABLES";
        $tables = $wpdb_temp->get_col($query);
      }
    }

    return $tables;
  }

  function get_tables_saved( $con_type, $username, $password, $database, $host ) {
    global $wpdb;
    if ( $con_type == 'local' ) {
      $query = "SHOW TABLES";
      $tables = $wpdb->get_col($query);
    }
    else {
      if ( $con_type == 'remote' ) {
        $wpdb_temp = new wpdb($username, $password, $database, $host);
        $query = "SHOW TABLES";
        $tables = $wpdb_temp->get_col($query);
      }
    }

    return $tables;
  }

  function get_table_struct() {
    global $wpdb;
    $name = isset($_POST['name']) ? $_POST['name'] : NULL;
    if ( !$name ) {
      return array();
    }
    $con_method = $_POST['con_method'];
    $con_type = $_POST['con_type'];
    $query = "SHOW COLUMNS FROM " . $name;
    if ( $con_type == 'remote' ) {
      $username = isset($_POST['username']) ? $_POST['username'] : '';
      $password = isset($_POST['password']) ? $_POST['password'] : '';
      $database = isset($_POST['database']) ? $_POST['database'] : '';
      $host = isset($_POST['host']) ? $_POST['host'] : '';
      $wpdb_temp = new wpdb($username, $password, $database, $host);
      $table_struct = $wpdb_temp->get_results($query);
    }
    else {
      $table_struct = $wpdb->get_results($query);
    }

    return $table_struct;
  }

  function get_table_struct_saved( $con_type, $username, $password, $database, $host, $name, $con_method ) {
    global $wpdb;
    if ( !$name ) {
      return array();
    }
    $query = "SHOW COLUMNS FROM " . $name;
    if ( $con_type == 'remote' ) {
      $wpdb_temp = new wpdb($username, $password, $database, $host);
      $table_struct = $wpdb_temp->get_results($query);
    }
    else {
      $table_struct = $wpdb->get_results($query);
    }

    return $table_struct;
  }
}
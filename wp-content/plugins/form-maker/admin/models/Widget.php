<?php

/**
 * Class FMModelWidget
 */
class FMModelWidget {
  public function get_gallery_rows_data() {
    global $wpdb;
    $query = 'SELECT * FROM ' . $wpdb->prefix . 'formmaker';
    if ( WDFM()->is_free && !function_exists('WDCFM') ) {
      $query .= (!WDFM()->is_free ? '' : ' WHERE id' . (WDFM()->is_free == 1 ? ' NOT ' : ' ') . 'IN (' . (get_option('contact_form_forms', '') != '' ? get_option('contact_form_forms') : 0) . ')');
    }
    $query .= ' order by `title`';
    $rows = $wpdb->get_results($query);

    return $rows;
  }
}

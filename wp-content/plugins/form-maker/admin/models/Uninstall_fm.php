<?php

class FMModelUninstall_fm {
  public function delete_db_tables() {
    global $wpdb;
    $true_or_false_forms = !WDFM()->is_free ? false : $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'formmaker WHERE `id`' . (WDFM()->is_free == 1 ? ' NOT ' : ' ') . 'IN (' . (get_option('contact_form_forms', '') != '' ? get_option('contact_form_forms') : 0) . ')');
    if ($true_or_false_forms) {
      $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'formmaker WHERE `id`' . (WDFM()->is_free == 1 ? ' NOT ' : ' ') . 'IN (' . (get_option('contact_form_forms', '') != '' ? get_option('contact_form_forms') : 0) . ')');
      $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'formmaker_submits WHERE `form_id`' . (WDFM()->is_free == 1 ? ' NOT ' : ' ') . 'IN (' . (get_option('contact_form_forms', '') != '' ? get_option('contact_form_forms') : 0) . ')');
      $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'formmaker_views WHERE `form_id`' . (WDFM()->is_free == 1 ? ' NOT ' : ' ') . 'IN (' . (get_option('contact_form_forms', '') != '' ? get_option('contact_form_forms') : 0) . ')');
    }
    else {
      $email_verification_post_id = $wpdb->get_var('SELECT mail_verification_post_id  FROM ' . $wpdb->prefix . 'formmaker WHERE mail_verification_post_id != 0');
      delete_option('wd_form_maker_version');
      delete_option('formmaker_cureent_version');
      delete_option('contact_form_themes');
      delete_option('contact_form_forms');
      delete_option('form_maker_pro_active');
      delete_option('fm_admin_notice');
      delete_option('cfm_admin_notice');
      delete_option('fm_settings');
      delete_option('fmc_settings');
      delete_option('fm_subscribe_done');
      delete_option('cfm_subscribe_done');
      wp_delete_post($email_verification_post_id);

      // Delete form js and css files.
      $wp_upload_dir = wp_upload_dir();
      $frontend_js = $wp_upload_dir['basedir'] . '/form-maker-frontend/js/';
      if ( is_dir($frontend_js) ) {
        $js_files = scandir($frontend_js);
        foreach ( $js_files as $js_file ) {
          if ( is_file($frontend_js . $js_file) ) {
            $filename = pathinfo($frontend_js . $js_file);
            if ( $filename['extension'] == 'js' ) {
              unlink($frontend_js . $js_file);
            }
          }
        }
      }
      $frontend_css = $wp_upload_dir['basedir'] . '/form-maker-frontend/css/';
      if ( is_dir($frontend_css) ) {
        $css_files = scandir($frontend_css);
        foreach ( $css_files as $css_file ) {
          if ( is_file($frontend_css . $css_file) ) {
            $filename = pathinfo($frontend_css . $css_file);
            if ( $filename['extension'] == 'css' ) {
              unlink($frontend_css . $css_file);
            }
          }
        }
      }
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_submits');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_views');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_themes');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_sessions');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_blocked');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_query');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_backup');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_mailchimp');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_reg');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_post_gen_options');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_email_conditions');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_dbox_int');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_pdf_options');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_pdf');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_pushover');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_stripe');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_save_options');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_saved_entries');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_saved_attributes');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_calculator');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_gdrive_int');
      $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'formmaker_display_options');
    }
  }
}

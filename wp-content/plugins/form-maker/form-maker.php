<?php
/**
 * Plugin Name: Form Maker
 * Plugin URI: https://web-dorado.com/products/form-maker-wordpress.html
 * Description: This plugin is a modern and advanced tool for easy and fast creating of a WordPress Form. The backend interface is intuitive and user friendly which allows users far from scripting and programming to create WordPress Forms.
 * Version: 1.12.20
 * Author: WebDorado Form Builder Team
 * Author URI: https://web-dorado.com/wordpress-plugins-bundle.html
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('ABSPATH') || die('Access Denied');

final class WDFM {
  /**
   * The single instance of the class.
   */
  protected static $_instance = null;
  /**
   * Plugin directory path.
   */
  public $plugin_dir = '';
  /**
   * Plugin directory url.
   */
  public $plugin_url = '';
  /**
   * Plugin front urls.
   */
  public $front_urls = array();
  /**
   * Plugin main file.
   */
  public $main_file = '';
  /**
   * Plugin version.
   */
  public $plugin_version = '';
  /**
   * Plugin database version.
   */
  public $db_version = '';
  /**
   * Plugin menu slug.
   */
  public $menu_slug = '';
  /**
   * Plugin menu slug.
   */
  public $prefix = '';
  public $css_prefix = '';
  public $js_prefix = '';

  public $nicename = '';
  public $nonce = 'nonce_fm';
  public $is_free = 1;
  public $is_demo = false;

  /**
   * Main WDFM Instance.
   *
   * Ensures only one instance is loaded or can be loaded.
   *
   * @static
   * @return WDFM - Main instance.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * WDFM Constructor.
   */
  public function __construct() {
    $this->define_constants();
    require_once($this->plugin_dir . '/framework/WDW_FM_Library.php');
    if (is_admin()) {
      require_once(wp_normalize_path($this->plugin_dir . '/admin/views/view.php'));
    }
    $this->add_actions();
    if (session_id() == '' || (function_exists('session_status') && (session_status() == PHP_SESSION_NONE))) {
      @session_start();
    }
  }

  /**
   * Define Constants.
   */
  private function define_constants() {
	$this->plugin_dir = WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__));
    $this->plugin_url = plugins_url(plugin_basename(dirname(__FILE__)));
    $this->front_urls = $this->get_front_urls();
    $this->main_file = plugin_basename(__FILE__);
    $this->plugin_version = '1.12.20';
    $this->db_version = '2.12.20';
    $this->menu_slug = 'manage_fm';
    $this->prefix = 'form_maker';
    $this->css_prefix = 'fm_';
    $this->js_prefix  = 'fm_';
    $this->nicename = __('Form Maker', $this->prefix);
    $this->menu_postfix = '_fm';
    $this->plugin_postfix = '';
  }

  /**
   * Add actions.
   */
  private function add_actions() {
    add_action('init', array($this, 'init'), 9);
    add_action('admin_menu', array( $this, 'form_maker_options_panel' ) );

    add_action('wp_ajax_manage' . $this->menu_postfix, array($this, 'form_maker_ajax')); //Post/page search on display options pages.
    add_action('wp_ajax_get_stats' . $this->plugin_postfix, array($this, 'form_maker')); //Show statistics
    add_action('wp_ajax_generete_csv' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Export csv.
    add_action('wp_ajax_generete_xml' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Export xml.
    add_action('wp_ajax_formmakerwdcaptcha' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Generete captcha image and save it code in session.
    add_action('wp_ajax_nopriv_formmakerwdcaptcha' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Generete captcha image and save it code in session for all users.
    add_action('wp_ajax_formmakerwdmathcaptcha' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Generete math captcha image and save it code in session.
    add_action('wp_ajax_nopriv_formmakerwdmathcaptcha' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Generete math captcha image and save it code in session for all users.
    add_action('wp_ajax_product_option' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Open product options on add paypal field.
    add_action('wp_ajax_FormMakerEditCountryinPopup' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Open country list.
    add_action('wp_ajax_FormMakerMapEditinPopup' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Open map in submissions.
    add_action('wp_ajax_FormMakerIpinfoinPopup' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Open ip in submissions.
    add_action('wp_ajax_show_matrix' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Edit matrix in submissions.
    add_action('wp_ajax_FormMakerSubmits' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Open submissions in submissions.

    if ( !$this->is_demo ) {
      add_action('wp_ajax_FormMakerSQLMapping' . $this->plugin_postfix, array($this, 'form_maker_ajax')); // Add/Edit SQLMaping from form options.
      add_action('wp_ajax_select_data_from_db' . $this->plugin_postfix, array( $this, 'form_maker_ajax' )); // select data from db.
    }

    add_action('wp_ajax_manage' . $this->plugin_postfix, array($this, 'form_maker_ajax')); //Show statistics

    if ( !$this->is_free ) {
      add_action('wp_ajax_paypal_info', array($this, 'form_maker_ajax')); // Paypal info in submissions page.
      add_action('wp_ajax_checkpaypal', array($this, 'form_maker_ajax')); // Notify url from Paypal Sandbox.
      add_action('wp_ajax_nopriv_checkpaypal', array($this, 'form_maker_ajax')); // Notify url from Paypal Sandbox for all users.
      add_action('wp_ajax_get_frontend_stats', array($this, 'form_maker_ajax_frontend')); //Show statistics frontend
      add_action('wp_ajax_nopriv_get_frontend_stats', array($this, 'form_maker_ajax_frontend')); //Show statistics frontend
      add_action('wp_ajax_frontend_show_map', array($this, 'form_maker_ajax_frontend')); //Show map frontend
      add_action('wp_ajax_nopriv_frontend_show_map', array($this, 'form_maker_ajax_frontend')); //Show map frontend
      add_action('wp_ajax_frontend_show_matrix', array($this, 'form_maker_ajax_frontend')); //Show matrix frontend
      add_action('wp_ajax_nopriv_frontend_show_matrix', array($this, 'form_maker_ajax_frontend')); //Show matrix frontend
      add_action('wp_ajax_frontend_paypal_info', array($this, 'form_maker_ajax_frontend')); //Show paypal info frontend
      add_action('wp_ajax_nopriv_frontend_paypal_info', array($this, 'form_maker_ajax_frontend')); //Show paypal info frontend
      add_action('wp_ajax_frontend_generate_csv', array($this, 'form_maker_ajax_frontend')); //generate csv frontend
      add_action('wp_ajax_nopriv_frontend_generate_csv', array($this, 'form_maker_ajax_frontend')); //generate csv frontend
      add_action('wp_ajax_frontend_generate_xml', array($this, 'form_maker_ajax_frontend')); //generate xml frontend
      add_action('wp_ajax_nopriv_frontend_generate_xml', array($this, 'form_maker_ajax_frontend')); //generate xml frontend
    }

    // Add media button to WP editor.
    add_action('wp_ajax_FMShortocde' . $this->plugin_postfix, array($this, 'form_maker_ajax'));
    add_filter('media_buttons_context', array($this, 'media_button'));

    add_action('admin_head', array($this, 'form_maker_admin_ajax'));//js variables for admin.

    // Form maker shortcodes.
    if ( !is_admin() ) {
      add_shortcode('FormPreview' . $this->plugin_postfix, array($this, 'fm_form_preview_shortcode'));
      if ($this->is_free != 2) {
        add_shortcode('Form', array($this, 'fm_shortcode'));
      }
      if (!($this->is_free == 1)) {
        add_shortcode('contact_form', array($this, 'fm_shortcode'));
        add_shortcode('wd_contact_form', array($this, 'fm_shortcode'));
      }
      add_shortcode('email_verification' . $this->plugin_postfix, array($this, 'fm_email_verification_shortcode'));
    }
    // Action to display not emedded type forms.
    if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
      add_action('wp_footer', array($this, 'FM_front_end_main'));
    }

    // Form Maker Widget.
    if (class_exists('WP_Widget')) {
      add_action('widgets_init',  array($this, 'register_widgets'));
    }

    // Form maker activation.
    register_activation_hook(__FILE__, array($this, 'form_maker_on_activate'));
    if ( (!isset($_GET['action']) || $_GET['action'] != 'deactivate')
      && (!isset($_GET['page']) || $_GET['page'] != 'uninstall' . $this->menu_postfix) ) {
      add_action('admin_init', array($this, 'form_maker_activate'));
    }
    add_action('admin_notices', array($this, 'fm_topic'), 11);

    // Register scripts/styles.
    add_action('wp_enqueue_scripts', array($this, 'register_frontend_scripts'));
    add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));

    // Set per_page option for submissions.
    add_filter('set-screen-option', array($this, 'set_option_submissions'), 10, 3);

    // Check add-ons versions.
    if ($this->is_free != 2) {
      add_action('admin_notices', array($this, 'fm_check_addons_compatibility'));
    }

    add_action('plugins_loaded', array($this, 'plugins_loaded'));

    add_filter('wpseo_whitelist_permalink_vars', array($this, 'add_query_vars_seo'));
  }

  /**
   * Wordpress init actions.
   */
  public function init() {
    ob_start();
    $this->fm_overview();

    // Register fmemailverification post type
    $this->register_fmemailverification_cpt();

    // Register fmformpreview post type
    $this->register_form_preview_cpt();
  }

  /**
   * Plugins loaded actions.
   */
  public function plugins_loaded() {
    // Languages localization.
    load_plugin_textdomain($this->prefix, FALSE, basename(dirname(__FILE__)) . '/languages');
    // Initialize add-ons.
    if ($this->is_free != 2) {
      do_action('fm_init_addons');
    }
  }

  /**
   * Plugin menu.
   */
  public function form_maker_options_panel() {
    $parent_slug = !$this->is_free ? $this->menu_slug : null;
    if( !$this->is_free || get_option( "fm_subscribe_done" ) == 1 ) {
      add_menu_page($this->nicename, $this->nicename, 'manage_options', $this->menu_slug, array( $this, 'form_maker' ), $this->plugin_url . '/images/FormMakerLogo-16.png');
      $parent_slug = $this->menu_slug;
    }
    add_submenu_page($parent_slug, __('Forms', $this->prefix), __('Forms', $this->prefix), 'manage_options', $this->menu_slug, array($this, 'form_maker'));
    $submissions_page = add_submenu_page($parent_slug, __('Submissions', $this->prefix), __('Submissions', $this->prefix), 'manage_options', 'submissions' . $this->menu_postfix, array($this, 'form_maker'));
    add_action('load-' . $submissions_page, array($this, 'submissions_per_page'));

    add_submenu_page(null, __('Blocked IPs', $this->prefix), __('Blocked IPs', $this->prefix), 'manage_options', 'blocked_ips' . $this->menu_postfix, array($this, 'form_maker'));
    add_submenu_page($parent_slug, __('Themes', $this->prefix), __('Themes', $this->prefix), 'manage_options', 'themes' . $this->menu_postfix, array($this, 'form_maker'));
	  add_submenu_page($parent_slug, __('Options', $this->prefix), __('Options', $this->prefix), 'manage_options', 'options' . $this->menu_postfix, array($this, 'form_maker'));
	  if ($this->is_free) {
      add_submenu_page($parent_slug, __('Pro Version', $this->prefix), __('Pro Version', $this->prefix), 'manage_options', 'licensing' . $this->menu_postfix, array($this, 'form_maker'));
    }
    add_submenu_page(null, __('Uninstall', $this->prefix), __('Uninstall', $this->prefix), 'manage_options', 'uninstall' . $this->menu_postfix, array($this, 'form_maker'));
	  add_submenu_page($parent_slug, __('Add-ons', $this->prefix), __('Add-ons', $this->prefix), 'manage_options', 'extensions' . $this->menu_postfix, array($this , 'fm_extensions'));
  }

  /**
   * Set front plugin url.
   *
   * return string  $plugin_url
   */
  private function set_front_plugin_url() {
    $plugin_url = plugins_url(plugin_basename(dirname(__FILE__)));

    return $plugin_url;
  }

  /**
   * Set front upload url.
   *
   * return string  $upload_url
   */
  private function set_front_upload_url() {
    $wp_upload_dir = wp_upload_dir();
    $upload_url = str_replace(get_option('siteurl'), get_option('home'), $wp_upload_dir['baseurl']);

    return $upload_url;
  }

  /**
   * Get front urls.
   *
   * return array  $urls
   */
  public function get_front_urls() {
    $urls = array();
    $urls['plugin_url'] = $this->set_front_plugin_url();
    $urls['upload_url'] = $this->set_front_upload_url();

    return $urls;
  }

  /**
   * Add per_page screen option for submissions page.
   */
  function submissions_per_page() {
    $option = 'per_page';
    $args_rates = array(
      'label' => __('Number of items per page:', $this->prefix),
      'default' => 20,
      'option' => 'fm_submissions_per_page'
    );
    add_screen_option( $option, $args_rates );
  }

  /**
   * Set per_page option for submissions page.
   *
   * @param $status
   * @param $option
   * @param $value
   * @return mixed
   */
  function set_option_submissions($status, $option, $value) {
    if ( 'fm_submissions_per_page' == $option ) return $value;
    return $status;
  }

  /**
   * Output for admin pages.
   */
  public function form_maker() {
    if (function_exists('current_user_can')) {
      if (!current_user_can('manage_options')) {
        die('Access Denied');
      }
    }
    else {
      die('Access Denied');
    }
    $page = WDW_FM_Library::get('page');
    if (($page != '') && (($page == 'manage' . $this->menu_postfix) || ($page == 'options' . $this->menu_postfix) || ($page == 'submissions' . $this->menu_postfix) || ($page == 'blocked_ips' . $this->menu_postfix) || ($page == 'themes' . $this->menu_postfix) || ($page == 'uninstall' . $this->menu_postfix) || ($page == 'extensions' . $this->menu_postfix) || ($this->is_free && $page == 'licensing' . $this->menu_postfix))) {
      $page = ucfirst(substr($page, 0, strlen($page) - strlen($this->menu_postfix)));
      // This ugly span is here to hide admin output while css files are not loaded. Temporary.
      // todo: Remove span somehow.
      echo '<div id="fm_loading"></div>';
      echo '<span id="fm_admin_container" class="fm-form-container" style="display: none;">';
      require_once ($this->plugin_dir . '/admin/controllers/' . $page . '_fm.php');
      $controller_class = 'FMController' . $page . $this->menu_postfix;
      $controller = new $controller_class();
      $controller->execute();
      echo '</span>';
    }
  }
  
  /**
   * Output for Add-on pages.
   */
  public function fm_extensions() {
    if ( function_exists('current_user_can') ) {
      if ( !current_user_can('manage_options') ) {
        die('Access Denied');
      }
    }
    else {
      die('Access Denied');
    }
    require_once($this->plugin_dir . '/featured/featured.php');
    fm_extensions_page('form-maker');
  }

  /**
   * Register widgets.
   */
  public function register_widgets() {
	require_once($this->plugin_dir . '/admin/controllers/Widget.php');
	register_widget('FMControllerWidget' . $this->plugin_postfix);
  }

  /**
   * Register Admin styles/scripts.
   */
  public function register_admin_scripts() {
    // Admin styles.
    wp_register_style('fm-tables', $this->plugin_url . '/css/form_maker_tables.css', array(), $this->plugin_version);
    wp_register_style('fm-first', $this->plugin_url . '/css/form_maker_first.css', array(), $this->plugin_version);
    wp_register_style('fm-phone_field_css', $this->plugin_url . '/css/intlTelInput.css', array(), $this->plugin_version);
    wp_register_style('fm-jquery-ui', $this->plugin_url . '/css/jquery-ui.custom.css', array(), $this->plugin_version);
    wp_register_style('fm-style', $this->plugin_url . '/css/style.css', array(), $this->plugin_version);
    wp_register_style('fm-codemirror', $this->plugin_url . '/css/codemirror.css', array(), $this->plugin_version);
    wp_register_style('fm-layout', $this->plugin_url . '/css/form_maker_layout.css', array(), $this->plugin_version);
    wp_register_style('fm-bootstrap', $this->plugin_url . '/css/fm-bootstrap.css', array(), $this->plugin_version);
    wp_register_style('fm-colorpicker', $this->plugin_url . '/css/spectrum.css', array(), $this->plugin_version);
    if (!$this->is_free) {
      wp_register_style('jquery.fancybox', $this->plugin_url . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5');
    }
    // Add-ons page
    wp_register_style('fm-featured', $this->plugin_url . '/featured/style.css', array(), $this->plugin_version);
    wp_register_style('fm-featured-admin', $this->plugin_url . '/featured/admin.css', array(), $this->plugin_version);

    // Admin scripts.
    $fm_settings = get_option('fm_settings');
    $google_map_key = !empty($fm_settings['map_key']) ? '&key=' . $fm_settings['map_key'] : '';

    wp_register_script('google-maps', 'https://maps.google.com/maps/api/js?v=3.exp' . $google_map_key);
    wp_register_script('fm-gmap_form', $this->plugin_url . '/js/if_gmap_back_end.js', array(), $this->plugin_version);

    wp_register_script('fm-phone_field', $this->plugin_url . '/js/intlTelInput.js', array(), '11.0.0');

    wp_register_script('fm-admin', $this->plugin_url . '/js/form_maker_admin.js', array(), $this->plugin_version);
    wp_register_script('fm-manage', $this->plugin_url . '/js/form_maker_manage.js', array(), $this->plugin_version);
    wp_register_script('fm-manage-edit', $this->plugin_url . '/js/form_maker_manage_edit.js', array(), $this->plugin_version);
    wp_register_script('fm-formmaker_div', $this->plugin_url . '/js/formmaker_div.js', array(), $this->plugin_version);
    wp_register_script('fm-form-options', $this->plugin_url . '/js/form_maker_form_options.js', array(), $this->plugin_version);
    wp_register_script('fm-form-advanced-layout', $this->plugin_url . '/js/form_maker_form_advanced_layout.js', array(), $this->plugin_version);
    wp_register_script('fm-add-fields', $this->plugin_url . '/js/add_field.js', array('fm-formmaker_div'), $this->plugin_version);
    wp_localize_script('fm-add-fields', 'form_maker', array(
      'countries' => WDW_FM_Library::get_countries(),
      'states' => WDW_FM_Library::get_states(),
      'plugin_url' => $this->plugin_url,
      'nothing_found' => __('Nothing found.', $this->prefix),
      'captcha_created' => __('The captcha already has been created.', $this->prefix),
      'update' => __('Update', $this->prefix),
      'add' => __('Add', $this->prefix),
      'add_field' => __('Add Field', $this->prefix),
      'edit_field' => __('Edit Field', $this->prefix),
      'disabled1' => __('This field type is disabled in free version.', $this->prefix),
      'disabled2' => __('Please upgrade to Paid version.', $this->prefix),
      'stripe1' => __('Please install ', $this->prefix),
      'stripe2' => __(' add-on to use this feature.', $this->prefix),
      'stripe3' => __('To use this feature, please go to Form Options > Payment Options and select "Stripe" as the Payment Method.', $this->prefix),
      'sunday' => __('Sunday', $this->prefix),
      'monday' => __('Monday', $this->prefix),
      'tuesday' => __('Tuesday', $this->prefix),
      'wednesday' => __('Wednesday', $this->prefix),
      'thursday' => __('Thursday', $this->prefix),
      'friday' => __('Friday', $this->prefix),
      'saturday' => __('Saturday', $this->prefix),
      'leave_empty' => __('Leave empty to set the width to 100%.', $this->prefix),
      'is_demo' => $this->is_demo,
      'important_message' => __('The free version is limited up to 7 fields to add. If you need this functionality, you need to buy the commercial version.', $this->prefix),
      'no_preview' => __('No preview available.', $this->prefix),
      'invisible_recaptcha_error' => sprintf( __('%s Old reCAPTCHA keys will not work for %s. Please make sure to enable the API keys for Invisible reCAPTCHA.', $this->prefix), '<b>'. __('Note:',  $this->prefix) .'</b>', '<b>'. __('Invisible reCAPTCHA',  $this->prefix) .'</b>' ),
      'type_text_description' => __('This field is a single line text input.', $this->prefix).'<br><br>'.__('To set a default value, just fill the field above.', $this->prefix).'<br><br>'.__('You can set the text input as Required, making sure the submitter provides a value for it.',  $this->prefix).'<br><br>'.__('Validation (RegExp.) option in Advanced options lets you configure Regular Expression for your Single Line Text field. Use Common Regular Expressions select box to use built-in validation patterns. For instance, in case you can add a validation for decimal number, IP address or zip code by selecting corresponding options of Common Regular Expressions drop-down.',  $this->prefix) .'<br><br>'.__('Additionally, you can add HTML attributes to your form fields with Additional Attributes.', $this->prefix),
      'type_textarea_description' => __('This field adds a textarea box to your form. Users can write alphanumeric text, special characters and line breaks.', $this->prefix).'<br><br>'.__('You can set the text input as Required, making sure the submitter provides a value for it.', $this->prefix).'<br><br>'.__('Set the width and height of the textarea box using Size(px) option.', $this->prefix),
      'type_number_description' => __('This is an input text that accepts only numbers. Users can type a number directly, or use the spinner arrows to specify it.', $this->prefix).'<br><br>'.__('Step option defines the number to increment/decrement the spinner value, when the users press up or down arrows.', $this->prefix).'<br><br>'.__('Use Min Value and Max Value options to set lower and upper limitation for the value of this Number field.', $this->prefix).'<br><br>'.__('To set a default value, just fill the field above.', $this->prefix),
      'type_select_description' => __('This field allows the submitter to choose values from select box. Just click (+) Option button and fill in all options you will need or click  (+) From Database to fill the options from a database table.',  $this->prefix) .'<br><br>'.__('In case you need to have option values to be different from option names, mark Enable option\'s value from Advanced options as checked.', $this->prefix),
      'type_radio_description' => __('Using this field you can add a list of Radio buttons to your form. Just click (+) Option button and fill in all options you will need or click  (+) From Database to fill the options from a database table.', $this->prefix).'<br><br>'.__('Relative Position lets you choose the position of options in relation to each other. Whereas Option Label Position lets you select the position of radio button label.', $this->prefix).'<br><br>'.__('In case you need to have option values to be different from option names, mark Enable option\'s value from Advanced options as checked.', $this->prefix).'<br><br>'.__('And by enabling Allow other, you can let the user to write their own specific value.', $this->prefix),
      'type_checkbox_description' => __('Multiple Choice field lets you have a list of Checkboxes. This field allows the submitter to choose more than one values.', $this->prefix).'<br><br>'.__('Just click (+) Option button and fill in all options you will need or click  (+) From Database to fill the options from a database table.', $this->prefix).'<br><br>'.__('Relative Position lets you choose the position of options in relation to each other. Whereas Option Label Position lets you select the position of radio button label.', $this->prefix).'<br><br>'.__('In case you need to have option values to be different from option names, mark Enable option\'s value from Advanced options as checked.', $this->prefix).'<br><br>'.__('And by enabling Allow other, you can let the user to write their own specific value.', $this->prefix),
      'type_recaptcha_description' => sprintf(__('Form Maker is integrated with Google ReCaptcha, which protects your forms from spam bots. Before adding ReCaptcha to your form, you need to configure Site and Secret Keys by registering your website on %s', $this->prefix),'<a href="https://www.google.com/recaptcha/intro/" target="_blank">'. __('Google ReCaptcha website',  $this->prefix) .'</a>').'<br><br>'.__('After registering and creating the keys, copy them to Form Maker > Options page.', $this->prefix),
      'type_submit_description' => __('The Submit button validates all form field values, saves them on MySQL database of your website, sends emails and performs other actions configured in Form Options. You can have more than one submit button in your form.', $this->prefix),
      'type_captcha_description' => __('You can use this field as an alternative to ReCaptcha to protect your forms against spambots. It’s a random combination of numbers and letters, and users need to type them in correctly to submit the form.', $this->prefix).'<br><br>'.__('You can specify the number of symbols in Simple Captcha using Symbols (3 - 9) option.', $this->prefix),
      'type_name_description' => __('This field lets the user write their name.', $this->prefix).'<br><br>'.__('To set a default value, just fill the field above.', $this->prefix).'<br><br>'.__('Enabling Autofill with user name setting will automatically fill in Name field with the name of the logged in user.', $this->prefix).'<br><br>'.__('In case you do not wish to receive the same data for the same Name field twice, activate Allow only unique values option.', $this->prefix),
      'type_email_description' => __('This field is an input field that accepts an email address.', $this->prefix).'<br><br>'.__('To set a default value, just fill the field above.', $this->prefix).'<br><br>'.__('Using Confirmation Email setting in Advanced Options you can require the submitter to re-type their email address.', $this->prefix).'<br><br>'.__('Autofill with user email will autofill Email field with the email address of the logged in user.', $this->prefix).'<br><br>'.__('Upon successful submission of the Form, you have the option to send the submitted data (or just a confirmation message) to the email address entered here. To do this you need to set the corresponding options on Form Options > Email Options page.', $this->prefix),
      'type_phone_description' => __('This field is an input for a phone number. It provides a list of country flags, which users can select and have their country code automatically added to the phone number.', $this->prefix).'<br><br>'.__('In case you do not wish to receive the same data for the same Phone field more than once, activate Allow only unique values setting from Advanced options.', $this->prefix),
      'type_address_description' => __('This field lets you skip a few steps and quickly add one set for requesting the address of the submitter. Use Overall size(px) option to set the width of Address field.', $this->prefix).'<br><br>'.__('You can enable or disable elements of Address field using Disable Field(s) setting in Advanced Options.', $this->prefix).'<br><br>'.__('You can turn State/Province/Region field into a list of US states by activating Use list for US states setting from Advanced Options. Note: This only works in case United States is selected for Country select box.', $this->prefix),
      'type_mark_on_map_description' => __('Mark on Map field lets users to drag the map pin and drop it on their selected location. You can specify a default address for the location pin with Address option.', $this->prefix).'<br><br>'.__('In addition, Marker Info setting allows you to provide additional details about the location. It will appear after users click on the location pin.', $this->prefix),
      'type_country_list_description' => __('Country List is a select box which provides a list of all countries in alphabetical order.', $this->prefix).'<br><br>'.__('You can include/exclude specific countries from the list using the Edit country list setting in Advanced Options.', $this->prefix),
      'type_date_of_birth_description' => __('Users can specify their birthday or any date with this field.', $this->prefix).'<br><br>'.__('Use Fields separator setting in Advanced options to change the divider between day, month and year boxes.', $this->prefix).'<br><br>'.__('You can set the fields to be text inputs or select boxes using Day field type, Month field type and Year field type options.', $this->prefix).'<br><br>'.__('In addition, you can specify the width of day, month and year fields using Day field size(px), Month field size(px) and Year field size(px) settings.', $this->prefix),
      'type_file_upload_description' => __('You can allow users to upload single or multiple documents, images and various files through your form.', $this->prefix).'<br><br>'.__('Use Allowed file extensions option to specify all acceptable file formats. Make sure to separate them with commas.', $this->prefix).'<br><br>'.__('Mark Allow Uploading Multiple Files option in Advanced Options to allow users to select and upload multiple files.', $this->prefix),
      'type_map_description' => __('Map field can be used for pinning one or more locations on Google Map and displaying them on your form.', $this->prefix).'<br><br>'.__('Press the small Plus icon to add a location pin.', $this->prefix),
      'type_time_description' => __('Time field of Form Maker plugin will allow users to specify time value. Set the time format of the field to 24-hour or 12-hour using Time Format option.', $this->prefix),
      'type_send_copy_description' => __('When users fill in an email address using Email Field, this checkbox will allow them to choose if they wish to receive a copy of the submission email.', $this->prefix).'<br><br>'.__('Note: Make sure to configure Form Options > Email Options of your form.', $this->prefix),
      'type_stars_description' => __('Add Star rating field to your form with this field. You can display as many stars, as you will need, set the number using Number of Stars option.', $this->prefix),
      'type_rating_description' => __('Place Rating field on your form to have radio buttons, which indicate rating from worst to best. You can set many radio buttons to display using Scale Range option.', $this->prefix),
      'type_slider_description' => __('Slider field lets users specify the field value by dragging its handle from Min Value to Max Value.', $this->prefix),
      'type_range_description' => __('You can use this field to let users choose a numeric range by providing values for 2 number inputs. Its Step option allows to set the increment/decrement of spinners’ values, when users click on up or down arrows.', $this->prefix),
      'type_grades_description' => __('Users will be able to grade specified items with this field. The sum of all values will appear below the field with Total parameter.', $this->prefix).'<br><br>'.__('Items option allows you to add multiple options to your Grades field.', $this->prefix),
      'type_matrix_description' => __('Table of Fields lets you place a matrix on your form, which will let the submitter to answer a few questions with one field.', $this->prefix).'<br><br>'.__('It allows you to configure the matrix with radio buttons, checkboxes, text boxes or drop-downs. Use Input Type option to set this.', $this->prefix),
      'type_hidden_description' => __('Hidden Input field is similar to Single Line Text field, but it is not visible to users. Hidden Fields are handy, in case you need to run a custom Javascript and submit the result with the info on your form.', $this->prefix).'<br><br>'.__('Name option of this field is mandatory. Note: we highly recommend you to avoid using spaces or special characters in Hidden Input name. You can write the custom Javascript code using the editor on Form Options > Javascript page.', $this->prefix),
      'type_button_description' => __('In case you wish to run custom Javascript on your form, you can place Custom Button on your form. Its lets you call the script with its OnClick function.', $this->prefix).'<br><br>'.__('You can write the custom Javascript code using the editor on Form Options > Javascript page.', $this->prefix),
      'type_password_description' => __('Password input can be used to allow users provide secret text, such as passwords. All symbols written in this field are replaced with dots.', $this->prefix).'<br><br>'.__('You can activate Password Confirmation option to ask users to repeat the password.', $this->prefix),
      'type_phone_area_code_description' => __('Phone-Area Code is a Phone type field, which allows users to write Area Code and Phone Number into separate inputs.', $this->prefix),
      'type_arithmetic_captcha_description' => __('Arithmetic Captcha is quite similar to Simple Captcha. However, instead of showing random symbols, it displays arithmetic operations.', $this->prefix).'<br><br>'.__('You can set the operations using Operations option. The field can use addition (+), subtraction (-), multiplication (*) and division (/).', $this->prefix).'<br><br>'.__('Make sure to separate the operations with commas.', $this->prefix),
      'type_price_description' => __('Users can set a payment amount of their choice with Price field. Assigns minimum and maximum limits on its value using Range option.', $this->prefix).'<br><br>'.__('To set a default value, just fill the field above.', $this->prefix).'<br><br>'.__('Additionally, you can activate Readonly attribute. This way, users will not be able to edit the value of Price.', $this->prefix).'<br><br>'.__('Note: Make sure to configure Form Options > Payment Options of your form.', $this->prefix),
      'type_payment_select_description' => __('Payment Select field lets you create lists of products, one of which the submitter can choose to buy through your form. Add or edit list items using Options setting of the fields.', $this->prefix).'<br><br>'.__('Enable Quantity property from Advanced Options, in case you would like the users to mention the quantity of items they purchase.', $this->prefix).'<br><br>'.__('Also, you can configure custom or built-in Product Properties for your products, such as Color, T-Shirt Size or Print Size.', $this->prefix).'<br><br>'.__('Note: Make sure to configure Form Options > Payment Options of your form.', $this->prefix),
      'type_payment_radio_description' => __('Payment Single Choice field lets you create lists of products, one of which the submitter can choose to buy through your form. Add or edit list items using Options setting of the fields.', $this->prefix).'<br><br>'.__('Enable Quantity property from Advanced Options, in case you would like the users to mention the quantity of items they purchase.', $this->prefix).'<br><br>'.__('Also, you can configure custom or built-in Product Properties for your products, such as Color, T-Shirt Size or Print Size.', $this->prefix).'<br><br>'.__('Note: Make sure to configure Form Options > Payment Options of your form.', $this->prefix),
      'type_payment_checkbox_description' => __('Payment Multiple Choice field lets you create lists of products, which the submitter can choose to buy through your form. Add or edit list items using Options setting of the fields.', $this->prefix).'<br><br>'.__('Enable Quantity property from Advanced Options, in case you would like the users to mention the quantity of items they purchase.', $this->prefix).'<br><br>'.__('Also, you can configure custom or built-in Product Properties for your products, such as Color, T-Shirt Size or Print Size.', $this->prefix).'<br><br>'.__('Note: Make sure to configure Form Options > Payment Options of your form.', $this->prefix),
      'type_shipping_description' => __('Shipping allows you to configure shipping types, set price for each of them and display them on your form as radio buttons.', $this->prefix),
      'type_total_description' => __('Please Total field to your payment form to sum up the values of Payment fields. ', $this->prefix),
      'type_stripe_description' => __('This field adds the credit card details inputs (card number, expiration date, etc.) and allows you to accept direct payments made by credit cards.', $this->prefix),
     ));

    wp_register_script('fm-codemirror', $this->plugin_url . '/js/layout/codemirror.js', array(), '2.3');
    wp_register_script('fm-clike', $this->plugin_url . '/js/layout/clike.js', array(), '1.0.0');
    wp_register_script('fm-formatting', $this->plugin_url . '/js/layout/formatting.js', array(), '1.0.0');
    wp_register_script('fm-css', $this->plugin_url . '/js/layout/css.js', array(), '1.0.0');
    wp_register_script('fm-javascript', $this->plugin_url . '/js/layout/javascript.js', array(), '1.0.0');
    wp_register_script('fm-xml', $this->plugin_url . '/js/layout/xml.js', array(), '1.0.0');
    wp_register_script('fm-php', $this->plugin_url . '/js/layout/php.js', array(), '1.0.0');
    wp_register_script('fm-htmlmixed', $this->plugin_url . '/js/layout/htmlmixed.js', array(), '1.0.0');

    wp_register_script('fm-colorpicker', $this->plugin_url . '/js/spectrum.js', array(), $this->plugin_version);

    wp_register_script('fm-admin', $this->plugin_url . '/js/form_maker_admin.js', array(), $this->plugin_version);
    wp_register_script('fm-themes', $this->plugin_url . '/js/themes.js', array(), $this->plugin_version);

    wp_register_script('fm-submissions', $this->plugin_url . '/js/form_maker_submissions.js', array(), $this->plugin_version);
    wp_register_script('fm-ng-js', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js', array(), '1.5.0');

    wp_localize_script('fm-admin', 'form_maker', array(
      'countries' => WDW_FM_Library::get_countries(),
      'delete_confirmation' => __('Do you want to delete selected items?', $this->prefix),
      'select_at_least_one_item' => __('You must select at least one item.', $this->prefix),
      ));
    if (!$this->is_free) {
      wp_register_script('jquery.fancybox.pack', $this->plugin_url . '/js/fancybox/jquery.fancybox.pack.js', array(), '2.1.5');
    }
    else {
      wp_register_style('fm-deactivate-css',  $this->plugin_url . '/wd/assets/css/deactivate_popup.css', array(), $this->plugin_version);
      wp_register_script('fm-deactivate-popup', $this->plugin_url . '/wd/assets/js/deactivate_popup.js', array(), $this->plugin_version, true );
      $admin_data = wp_get_current_user();
      wp_localize_script( 'fm-deactivate-popup', 'fmWDDeactivateVars', array(
        "prefix" => "fm" ,
        "deactivate_class" => 'fm_deactivate_link',
        "email" => $admin_data->data->user_email,
        "plugin_wd_url" => "https://web-dorado.com/products/wordpress-form.html",
      ));
      wp_register_style('fm-license' . $this->menu_postfix, $this->plugin_url . '/css/license.css', array(), $this->plugin_version);
    }
  }

  /**
   * Admin ajax scripts.
   */
  public function register_admin_ajax_scripts() {
    wp_register_style('fm-tables', $this->plugin_url . '/css/form_maker_tables.css', array(), $this->plugin_version);
    wp_register_style('fm-style', $this->plugin_url . '/css/style.css', array(), $this->plugin_version);
    wp_register_style('fm-jquery-ui', $this->plugin_url . '/css/jquery-ui.custom.css', array(), $this->plugin_version);

    wp_register_script('fm-shortcode' . $this->menu_postfix, $this->plugin_url . '/js/shortcode.js', array('jquery'), $this->plugin_version);

    $fm_settings = get_option('fm_settings');
    $google_map_key = !empty($fm_settings['map_key']) ? '&key=' . $fm_settings['map_key'] : '';

    wp_register_script('google-maps', 'https://maps.google.com/maps/api/js?v=3.exp' . $google_map_key);
    wp_register_script('fm-gmap_form', $this->plugin_url . '/js/if_gmap_back_end.js', array(), $this->plugin_version);

    wp_localize_script('fm-shortcode' . $this->menu_postfix, 'form_maker', array(
      'insert_form' => __('You must select a form', $this->prefix),
      'update' => __('Update', $this->prefix),
    ));
  }

  /**
   * admin-ajax actions for admin.
   */
  public function form_maker_ajax() {
    $page = WDW_FM_Library::get('action');
    if ( $page != 'formmakerwdcaptcha' . $this->plugin_postfix && $page != 'formmakerwdmathcaptcha' . $this->plugin_postfix && $page != 'checkpaypal' . $this->plugin_postfix ) {
      if ( function_exists('current_user_can') ) {
        if ( !current_user_can('manage_options') ) {
          die('Access Denied');
        }
      }
      else {
        die('Access Denied');
      }
    }
    if ( $page != '' ) {
      $page = ucfirst(substr($page, 0, strlen($page) - strlen($this->plugin_postfix)));
      if ( !is_file($this->plugin_dir . '/admin/controllers/' . $page . '.php') ) {
        die('The file <b> ' . $page . ' </b> not found.');
      }
      $this->register_admin_ajax_scripts();
      require_once($this->plugin_dir . '/admin/controllers/' . $page . '.php');
      $controller_class = 'FMController' . $page . $this->plugin_postfix;
      $controller = new $controller_class();
      $controller->execute();
    }
  }

  /**
   * admin-ajax actions for site.
   */
  public function form_maker_ajax_frontend() {
    $allowed_pages = array(
      'form_submissions',
    );
    $allowed_actions = array(
      'frontend_generate_xml',
      'frontend_generate_csv',
      'frontend_paypal_info',
      'frontend_show_matrix',
      'frontend_show_map',
      'get_frontend_stats',
    );

    $action = WDW_FM_Library::get('action');
    $page = WDW_FM_Library::get('page');
    if ( !empty($page) && in_array($page, $allowed_pages)
      && !empty($action) &&  in_array($action, $allowed_actions) ) {
      $this->register_frontend_ajax_scripts();
      require_once ($this->plugin_dir . '/frontend/controllers/' . $page . '.php');
      $controller_class = 'FMController' . ucfirst($page);
      $controller = new $controller_class();
      $controller->execute();
    }
  }

  /**
   * Javascript variables for admin.
   * todo: change to array.
   */
  public function form_maker_admin_ajax() {
    $upload_dir = wp_upload_dir();
    ?>
    <script>
      var fm_site_url = '<?php echo site_url() .'/'; ?>';
      var admin_url = '<?php echo admin_url('admin.php'); ?>';
      var plugin_url = '<?php echo $this->plugin_url; ?>';
      var upload_url = '<?php echo $upload_dir['baseurl']; ?>';
      var nonce_fm = '<?php echo wp_create_nonce($this->nonce); ?>';
      // Set shortcode popup dimensions.
      function fm_set_shortcode_popup_dimensions(tbWidth, tbHeight) {
        var tbWindow = jQuery('#TB_window'), H = jQuery(window).height(), W = jQuery(window).width(), w, h;
        w = (tbWidth && tbWidth < W - 90) ? tbWidth : W - 40;
        h = (tbHeight && tbHeight < H - 60) ? tbHeight : H - 40;
        if (tbWindow.size()) {
          tbWindow.width(w).height(h);
          jQuery('#TB_iframeContent').width(w).height(h - 27);
          tbWindow.css({'margin-left': '-' + parseInt((w / 2), 10) + 'px'});
          if (typeof document.body.style.maxWidth != 'undefined') {
            tbWindow.css({'top': (H - h) / 2, 'margin-top': '0'});
          }
        }
      }
    </script>
    <?php
  }

  /**
   * Form maker preview shortcode output.
   *
   * @return mixed|string
   */
  public function fm_form_preview_shortcode() {
    // check is adminstrator
    if ( !current_user_can('manage_options') ) {
      echo __('Sorry, you are not allowed to access this page.', $this->prefix);
    }
    else {
      $id = WDW_FM_Library::get('wdform_id', 0);
	    $display_options = WDW_FM_Library::display_options( $id );
      $type = $display_options->type;

      $attrs = array( 'id' => $id );
      if ($type == "embedded") {
        ob_start();
        $this->FM_front_end_main($attrs, $type); // embedded popover topbar scrollbox
        return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
      }
    }
  }

  /**
   * Form maker shortcode output.
   *
   * @param $attrs
   * @return mixed|string
   */
  public function fm_shortcode($attrs) {
    ob_start();
    $this->FM_front_end_main($attrs, 'embedded');

    return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
  }

  /**
   * Form maker output.
   *
   * @param array $params
   * @param string $type
   */
  public function FM_front_end_main($params = array(), $type = '') {
    if ( !isset($params['type']) ) {
      $form_id = isset($params['id']) ? (int) $params['id'] : 0;
      wd_form_maker($form_id, $type);
    }
    else if (!$this->is_free) {
      $shortcode_deafults = array(
        'id' => 0,
        'startdate' => '',
        'enddate' => '',
        'submit_date' => '',
        'submitter_ip' => '',
        'username' => '',
        'useremail' => '',
        'form_fields' => '1',
        'show' => '1,1,1,1,1,1,1,1,1,1',
      );
      shortcode_atts($shortcode_deafults, $params);

      require_once($this->plugin_dir . '/frontend/controllers/form_submissions.php');
      $controller = new FMControllerForm_submissions();
		
      $submissions = $controller->execute($params);

      echo $submissions;
    }
    return;
  }

  /**
   * Email verification output.
   */
  public function fm_email_verification_shortcode() {
    require_once($this->plugin_dir . '/frontend/controllers/verify_email.php');
    $controller_class = 'FMControllerVerify_email';
    $controller = new $controller_class();
    $controller->execute();
  }

  /**
   * Register email verification custom post type.
   */
  public function register_fmemailverification_cpt() {
    $args = array(
      'public' => true,
	    'exclude_from_search' => true,
      'show_in_menu' => false,
      'create_posts' => 'do_not_allow',
      'capabilities' => array(
        'create_posts' => FALSE,
        'edit_post' => 'edit_posts',
        'read_post' => 'edit_posts',
        'delete_posts' => FALSE,
      )
    );

    register_post_type('fmemailverification', $args);
  }
  
    /**
   * Register form preview custom post type.
   */
  public function register_form_preview_cpt() {
    $args = array(
        'public' => true,
        'exclude_from_search' => true,
        'show_in_menu' => false,
        'create_posts' => 'do_not_allow',
        'capabilities' => array(
        'create_posts' => FALSE,
        'edit_post' => 'edit_posts',
        'read_post' => 'edit_posts',
        'delete_posts' => FALSE,
      )
    );

    register_post_type('form-maker' . $this->plugin_postfix, $args);
  }  
 
  /**
   * Frontend scripts/styles.
   */
  public function register_frontend_scripts() {
	$front_plugin_url = $this->front_urls['plugin_url'];
    wp_register_style('fm-jquery-ui', $front_plugin_url . '/css/jquery-ui.custom.css', array(), $this->plugin_version);

    $fm_settings = get_option('fm_settings');
    $google_map_key = !empty($fm_settings['map_key']) ? '&key=' . $fm_settings['map_key'] : '';
    wp_register_script('google-maps', 'https://maps.google.com/maps/api/js?v=3.exp' . $google_map_key);

    wp_register_script('fm-phone_field', $front_plugin_url . '/js/intlTelInput.js', array(), $this->plugin_version);

    wp_register_style('fm-phone_field_css', $front_plugin_url . '/css/intlTelInput.css', array(), $this->plugin_version);
    wp_register_style('fm-frontend', $front_plugin_url . '/css/form_maker_frontend.css', array(), $this->plugin_version);

    wp_register_script('fm-frontend', $front_plugin_url . '/js/main_div_front_end.js', array(), $this->plugin_version);
    wp_register_script('fm-gmap_form', $front_plugin_url . '/js/if_gmap_front_end.js', array(), $this->plugin_version);

    wp_localize_script('fm-frontend', 'fm_objectL10n', array(
      'states' => WDW_FM_Library::get_states(),
      'plugin_url' => $front_plugin_url,
      'form_maker_admin_ajax' => admin_url('admin-ajax.php'),
      'fm_file_type_error' => addslashes(__('Can not upload this type of file', $this->prefix)),
      'fm_field_is_required' => addslashes(__('Field is required', $this->prefix)),
      'fm_min_max_check_1' => addslashes((__('The ', $this->prefix))),
      'fm_min_max_check_2' => addslashes((__(' value must be between ', $this->prefix))),
      'fm_spinner_check' => addslashes((__('Value must be between ', $this->prefix))),
      'fm_clear_data' => addslashes((__('Are you sure you want to clear saved data?', $this->prefix))),
      'fm_grading_text' => addslashes(__('Your score should be less than', $this->prefix)),
      'time_validation' => addslashes(__('This is not a valid time value.', $this->prefix)),
      'number_validation' => addslashes(__('This is not a valid number value.', $this->prefix)),
      'date_validation' => addslashes(__('This is not a valid date value.', $this->prefix)),
      'year_validation' => addslashes(sprintf(__('The year must be between %s and %s', $this->prefix), '%%start%%', '%%end%%')),
    ));

    $google_fonts = WDW_FM_Library::get_google_fonts();
    $fonts = implode("|", str_replace(' ', '+', $google_fonts));
    wp_register_style('fm-googlefonts', 'https://fonts.googleapis.com/css?family=' . $fonts . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic', null, null);

    wp_register_style('fm-animate', $front_plugin_url . '/css/fm-animate.css', array(), $this->plugin_version);

    wp_register_script('fm-g-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=fmRecaptchaInit&render=explicit');

    // Register admin styles to use in frontend submissions.
    wp_register_script('gmap_form_back', $front_plugin_url . '/js/if_gmap_back_end.js', array(), $this->plugin_version);

    if (!$this->is_free) {
      wp_register_script('fm-file-upload', $front_plugin_url . '/js/file-upload.js', array(), $this->plugin_version);
      wp_register_style('fm-submissions_css', $front_plugin_url . '/css/style_submissions.css', array(), $this->plugin_version);
    }
  }

  /**
   * Frontend ajax scripts.
   */
  public function register_frontend_ajax_scripts() {
    $fm_settings = get_option('fm_settings');
    $google_map_key = !empty($fm_settings['map_key']) ? '&key=' . $fm_settings['map_key'] : '';
    wp_register_script('google-maps', 'https://maps.google.com/maps/api/js?v=3.exp' . $google_map_key);
    wp_register_script('fm-gmap_form_back', $front_plugin_url . '/js/if_gmap_back_end.js', array(), $this->plugin_version);
  }

  /**
   * Activate plugin.
   */
  public function form_maker_on_activate() {
    $this->form_maker_activate();
    WDFMInsert::install_demo_forms();
    $this->init();
    flush_rewrite_rules();
  }

  /**
   * Activate plugin.
   */
  public function form_maker_activate() {
    if (!$this->is_free) {
      deactivate_plugins("contact-form-maker/contact-form-maker.php");
      delete_transient('fm_update_check');
    }
    $version = get_option("wd_form_maker_version");
    $new_version = $this->db_version;
    global $wpdb;
    require_once $this->plugin_dir . "/form_maker_insert.php";
    if (!$version) {
      if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "formmaker'") == $wpdb->prefix . "formmaker") {
        deactivate_plugins($this->main_file);
        wp_die(__("Oops! Seems like you installed the update over a quite old version of Form Maker. Unfortunately, this version is deprecated.<br />Please contact Web-Dorado support team at support@web-dorado.com. We will take care of this issue as soon as possible.", $this->prefix));
      }
      else {
        add_option("wd_form_maker_version", $new_version, '', 'no');
        WDFMInsert::form_maker_insert();
        $email_verification_post = array(
          'post_title' => 'Email Verification',
          'post_content' => '[email_verification]',
          'post_status' => 'publish',
          'post_author' => 1,
          'post_type' => 'fmemailverification',
        );
        $mail_verification_post_id = wp_insert_post($email_verification_post);

        add_option('fm_settings', array('public_key' => '', 'private_key' => '', 'csv_delimiter' => ',', 'map_key' => ''));
        $wpdb->update($wpdb->prefix . "formmaker", array(
          'mail_verification_post_id' => $mail_verification_post_id,
        ), array('id' => 1), array(
          '%d',
        ), array('%d'));
      }
    }
    elseif (version_compare($version, $new_version, '<')) {
      $version = substr_replace($version, '1.', 0, 2);
      require_once $this->plugin_dir . "/form_maker_update.php";
      $mail_verification_post_ids = $wpdb->get_results($wpdb->prepare('SELECT mail_verification_post_id FROM ' . $wpdb->prefix . 'formmaker WHERE mail_verification_post_id!="%d"', 0));
      if ($mail_verification_post_ids) {
        foreach ($mail_verification_post_ids as $mail_verification_post_id) {
          $update_email_ver_post_type = array(
            'ID' => (int)$mail_verification_post_id->mail_verification_post_id,
            'post_type' => 'fmemailverification',
          );
          wp_update_post($update_email_ver_post_type);
        }
      }
      WDFMUpdate::form_maker_update($version);
      update_option("wd_form_maker_version", $new_version);

      if (FALSE === $fm_settings = get_option('fm_settings')) {
        $recaptcha_keys = $wpdb->get_row('SELECT `public_key`, `private_key` FROM ' . $wpdb->prefix . 'formmaker WHERE public_key!="" and private_key!=""', ARRAY_A);
        $public_key = isset($recaptcha_keys['public_key']) ? $recaptcha_keys['public_key'] : '';
        $private_key = isset($recaptcha_keys['private_key']) ? $recaptcha_keys['private_key'] : '';
        add_option('fm_settings', array('public_key' => $public_key, 'private_key' => $private_key, 'csv_delimiter' => ',', 'map_key' => ''));
      }
    }
  }

  /**
   * Form maker topics at page top.
   */
  public function fm_topic() {
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    $page = str_replace($this->menu_postfix, '', $page);
    $task = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';
    $user_guide_link = 'https://web-dorado.com/wordpress-form-maker/';
    $support_forum_link = 'https://wordpress.org/support/plugin/form-maker';
    $pro_icon = $this->plugin_url . '/images/wd_logo.png';
    $pro_link = 'https://web-dorado.com/files/fromFormMaker.php';
    $support_icon = $this->plugin_url . '/images/support.png';
    $prefix = $this->prefix;
    switch ($page) {
      case 'blocked_ips': {
        $help_text = __('block IPs', $this->prefix);
        $user_guide_link .= 'blocking-ips.html';
        break;
      }
      case 'options': {
        $help_text = __('edit form settings', $this->prefix);
        $user_guide_link .= 'themes-and-options.html';
        break;
      }
      case 'licensing': {
        $help_text = '';
        $user_guide_link .= '';
        break;
      }
      case 'manage': {
        switch ($task) {
          case 'edit':
          case 'edit_old': {
            $help_text = __('add fields to your form', $this->prefix);
            $user_guide_link .= 'form-fields/basic-fields.html';
            break;
          }
          case 'form_options':
          case 'form_options_old': {
            $help_text = __('edit form options', $this->prefix);
            $user_guide_link .= 'form-options/general-options.html';
            break;
          }
          case 'display_options': {
            $help_text = __('edit display options', $this->prefix);
            $user_guide_link .= 'display-options-publishing/configuring-display-options.html';
            break;
          }
          default: {
            $help_text = __('create, edit forms', $this->prefix);
            $user_guide_link .= 'creating-form.html';
          }
        }
        break;
      }
      case 'submissions': {
        $help_text = __('view and manage form submissions', $this->prefix);
        $user_guide_link .= 'submissions.html';
        break;
      }
      case 'themes': {
        $help_text = __('create, edit form themes', $this->prefix);
        $user_guide_link .= 'themes-and-options.html';
        break;
      }
      default: {
        return '';
      }
    }
    ob_start();
    ?>
    <style>
      .wd_topic {
        background-color: #ffffff;
        border: none;
        box-sizing: border-box;
        clear: both;
        color: #6e7990;
        font-size: 14px;
        font-weight: bold;
        line-height: 44px;
        margin: 0;
        padding: 0 0 0 15px;
        vertical-align: middle;
        width: 98%;
      }
      .wd_topic .wd_help_topic {
        float: left;
      }
      .wd_topic .wd_help_topic a {
        color: #0073aa;
      }
      .wd_topic .wd_help_topic a:hover {
        color: #00A0D2;
      }
      .wd_topic .wd_support {
        float: right;
        margin: 0 10px;
      }
      .wd_topic .wd_support img {
        vertical-align: middle;
      }
      .wd_topic .wd_support a {
        text-decoration: none;
        color: #6E7990;
      }
      .wd_topic .wd_pro {
        float: right;
        padding: 0;
      }
      .wd_topic .wd_pro a {
        border: none;
        box-shadow: none !important;
        text-decoration: none;
      }
      .wd_topic .wd_pro img {
        border: none;
        display: inline-block;
        vertical-align: middle;
      }
      .wd_topic .wd_pro a,
      .wd_topic .wd_pro a:active,
      .wd_topic .wd_pro a:visited,
      .wd_topic .wd_pro a:hover {
        background-color: #D8D8D8;
        color: #175c8b;
        display: inline-block;
        font-size: 11px;
        font-weight: bold;
        padding: 0 10px;
        vertical-align: middle;
      }
    </style>
    <div class="update-nag wd_topic">
      <?php
      if ($help_text) {
        ?>
      <span class="wd_help_topic">
        <?php echo sprintf(__('This section allows you to %s.', $prefix), $help_text); ?>
            <a target="_blank" href="<?php echo $user_guide_link; ?>">
          <?php _e('Read More in User Manual', $prefix); ?>
        </a>
      </span>
        <?php
      }
      if ($this->is_free) {
        $text = strtoupper(__('Upgrade to paid version', $prefix));
        ?>
        <div class="wd_pro">
          <a target="_blank" href="<?php echo $pro_link; ?>">
            <img alt="web-dorado.com" title="<?php echo $text; ?>" src="<?php echo $pro_icon; ?>" />
            <span><?php echo $text; ?></span>
          </a>
        </div>
        <?php
      }
      if ($this->is_free) {
        ?>
        <span class="wd_support">
      <a target="_blank" href="<?php echo $support_forum_link; ?>">
        <img src="<?php echo $support_icon; ?>" />
        <?php _e('Support Forum', $prefix); ?>
      </a>
    </span>
        <?php
      }
      ?>
    </div>
    <?php
    echo ob_get_clean();
  }

  /**
   * Form maker overview.
   */
  public function fm_overview() {
    if (is_admin() && !isset($_REQUEST['ajax'])) {
      if (!class_exists("DoradoWeb")) {
        require_once($this->plugin_dir . '/wd/start.php');
      }
      global $fm_options;
      $fm_options = array(
        "prefix" => "fm",
        "wd_plugin_id" => 31,
        "plugin_title" => "Form Maker",
        "plugin_wordpress_slug" => "form-maker",
        "plugin_dir" => $this->plugin_dir,
        "plugin_main_file" => __FILE__,
        "description" => __('Form Maker plugin is a modern and advanced tool for easy and fast creating of a WordPress Form. The backend interface is intuitive and user friendly which allows users far from scripting and programming to create WordPress Forms.', $this->prefix),
        // from web-dorado.com
        "plugin_features" => array(
          0 => array(
            "title" => __("Easy to Use", $this->prefix),
            "description" => __("This responsive form maker plugin is one of the most easy-to-use form builder solutions available on the market. Simple, yet powerful plugin allows you to quickly and easily build any complex forms.", $this->prefix),
          ),
          1 => array(
            "title" => __("Customizable Fields", $this->prefix),
            "description" => __("All the fields of Form Maker plugin are highly customizable, which allows you to change almost every detail in the form and make it look exactly like you want it to be.", $this->prefix),
          ),
          2 => array(
            "title" => __("Submissions", $this->prefix),
            "description" => __("You can view the submissions for each form you have. The plugin allows to view submissions statistics, filter submission data and export in csv or xml formats.", $this->prefix),
          ),
          3 => array(
            "title" => __("Multi-Page Forms", $this->prefix),
            "description" => __("With the form builder plugin you can create muilti-page forms. Simply use the page break field to separate the pages in your forms.", $this->prefix),
          ),
          4 => array(
            "title" => __("Themes", $this->prefix),
            "description" => __("The WordPress Form Maker plugin comes with a wide range of customizable themes. You can choose from a list of existing themes or simply create the one that better fits your brand and website.", $this->prefix),
          )
        ),
        // user guide from web-dorado.com
        "user_guide" => array(
          0 => array(
            "main_title" => __("Installing", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/introduction.html",
            "titles" => array()
          ),
          1 => array(
            "main_title" => __("Creating a new Form", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/creating-form.html",
            "titles" => array()
          ),
          2 => array(
            "main_title" => __("Configuring Form Options", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/form-options/general-options.html",
            "titles" => array()
          ),
          3 => array(
            "main_title" => __("Description of The Form Fields", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/form-fields/basic-fields.html",
            "titles" => array(
              array(
                "title" => __("Selecting Options from Database", $this->prefix),
                "url" => "https://web-dorado.com/wordpress-form-maker/description-of-form-fields/selecting-options-from-database.html",
              ),
            )
          ),
          4 => array(
            "main_title" => __("Publishing the Created Form", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/creating-form.html",
            "titles" => array()
          ),
          5 => array(
            "main_title" => __("Blocking IPs", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/submissions.html",
            "titles" => array()
          ),
          6 => array(
            "main_title" => __("Managing Submissions", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/submissions.html",
            "titles" => array()
          ),
          7 => array(
            "main_title" => __("Publishing Submissions", $this->prefix),
            "url" => "https://web-dorado.com/wordpress-form-maker/other-publishing-options.html",
            "titles" => array()
          ),
        ),
        "video_youtube_id" => "tN3_c6MhqFk",  // e.g. https://www.youtube.com/watch?v=acaexefeP7o youtube id is the acaexefeP7o
        "plugin_wd_url" => "https://web-dorado.com/products/wordpress-form.html",
        "plugin_wd_demo_link" => "http://wpdemo.web-dorado.com",
        "plugin_wd_addons_link" => "https://web-dorado.com/products/wordpress-form/add-ons.html",
        "after_subscribe" => admin_url('admin.php?page=overview' . $this->menu_postfix), // this can be plagin overview page or set up page
        "plugin_wizard_link" => '',
        "plugin_menu_title" => $this->nicename,
        "plugin_menu_icon" => $this->plugin_url . '/images/FormMakerLogo-16.png',
        "deactivate" => ($this->is_free ? true : false),
        "subscribe" => ($this->is_free ? true : false),
        "custom_post" => 'manage' . $this->menu_postfix,
        "menu_position" => null,
      );

      dorado_web_init($fm_options);
    }
  }

  /**
   * Add media button to Wp editor.
   *
   * @param $context
   *
   * @return string
   */
  function media_button($context) {
    ob_start();
    $url = add_query_arg(array('action' => 'FMShortocde' . $this->plugin_postfix, 'task' => 'form', 'TB_iframe' => '1'), admin_url('admin-ajax.php'));
    ?>
    <a onclick="tb_click.call(this); fm_set_shortcode_popup_dimensions(400, 140); return false;" href="<?php echo $url; ?>" class="button" title="<?php _e('Insert Form', $this->prefix); ?>">
      <span class="wp-media-buttons-icon" style="background: url('<?php echo $this->plugin_url; ?>/images/fm-media-form-button.png') no-repeat scroll left top rgba(0, 0, 0, 0);"></span>
      <?php _e('Add Form', $this->prefix); ?>
    </a>
    <?php
    $url = add_query_arg(array('action' => 'FMShortocde' . $this->plugin_postfix, 'task' => 'submissions', 'TB_iframe' => '1'), admin_url('admin-ajax.php'));
    ?>
    <a onclick="tb_click.call(this); fm_set_shortcode_popup_dimensions(500, 570); return false;" href="<?php echo $url; ?>" class="button" title="<?php _e('Insert submissions', $this->prefix); ?>">
      <span class="wp-media-buttons-icon" style="background: url('<?php echo $this->plugin_url; ?>/images/fm-media-submissions-button.png') no-repeat scroll left top rgba(0, 0, 0, 0);"></span>
      <?php _e('Add Submissions', $this->prefix); ?>
    </a>
    <?php
    $context .= ob_get_clean();

    return $context;
  }


  /**
   * Check add-ones version compatibility with FM.
   *
   */
  function  fm_check_addons_compatibility() {
    $add_ons = array(
      'form-maker-export-import' => array('version' => '2.0.7', 'file' => 'fm_exp_imp.php'),
      'form-maker-save-progress' => array('version' => '1.0.1', 'file' => 'fm_save.php'),
      'form-maker-conditional-emails' => array('version' => '1.1.2', 'file' => 'fm_conditional_emails.php'),
      'form-maker-pushover' => array('version' => '1.0.1', 'file' => 'fm_pushover.php'),
      'form-maker-mailchimp' => array('version' => '1.0.1', 'file' => 'fm_mailchimp.php'),
      'form-maker-reg' => array('version' => '1.1.0', 'file' => 'fm_reg.php'),
      'form-maker-post-generation' => array('version' => '1.0.2', 'file' => 'fm_post_generation.php'),
      'form-maker-dropbox-integration' => array('version' => '1.1.1', 'file' => 'fm_dropbox_integration.php'),
      'form-maker-gdrive-integration' => array('version' => '1.0.0', 'file' => 'fm_gdrive_integration.php'),
      'form-maker-pdf-integration' => array('version' => '1.0.3', 'file' => 'fm_pdf_integration.php'),
      'form-maker-stripe' => array('version' => '1.0.1', 'file' => 'fm_stripe.php'),
      'form-maker-calculator' => array('version' => '1.0.3', 'file' => 'fm_calculator.php'),
    );

    $add_ons_notice = array();
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    foreach ($add_ons as $add_on_key => $add_on_value) {
      $addon_path = plugin_dir_path( dirname(__FILE__) ) . $add_on_key . '/' . $add_on_value['file'];
      if (is_plugin_active($add_on_key . '/' . $add_on_value['file'])) {
        $addon = get_plugin_data($addon_path); // array
        if (version_compare($addon['Version'], $add_on_value['version'], '<=')) {   //compare versions
          deactivate_plugins($addon_path);
          array_push($add_ons_notice, $addon['Name']);
        }
      }
    }

    if (!empty($add_ons_notice)) {
      $this->fm_addons_compatibility_notice($add_ons_notice);
    }
  }

  /**
   * Incompatibility message.
   *
   * @param $add_ons_notice
   */
  function fm_addons_compatibility_notice($add_ons_notice) {
    $addon_names = implode($add_ons_notice, ', ');
    $count = count($add_ons_notice);
    $single = __('Please update the %s add-on to start using.', $this->prefix);
    $plural = __('Please update the %s add-ons to start using.', $this->prefix);
    echo '<div class="error"><p>' . sprintf( _n($single, $plural, $count, $this->prefix), $addon_names ) .'</p></div>';
  }

	public function add_query_vars_seo($vars) {
		$vars[] = 'form_id';
		return $vars;
	}
}

/**
 * Main instance of WDFM.
 *
 * @return WDFM The main instance to prevent the need to use globals.
 */
function WDFM() {
  return WDFM::instance();
}

WDFM();

/**
 * Form maker output.
 *
 * @param $id
 * @param string $type
 */
function wd_form_maker($id, $type = 'embedded') {
  require_once (WDFM()->plugin_dir . '/frontend/controllers/form_maker.php');
  $controller = new FMControllerForm_maker();
  $form = $controller->execute($id, $type);
  echo $form;
}

/**
 * Show notice to install backup plugin
 */
function fm_bp_install_notice() {
  // Remove old notice.
  if ( get_option('wds_bk_notice_status') !== FALSE ) {
    update_option('wds_bk_notice_status', '1', 'no');
  }

  // Show notice only on plugin pages.
  if ( !isset($_GET['page']) || strpos(esc_html($_GET['page']), '_fm') === FALSE ) {
    return '';
  }

  $meta_value = get_option('wd_bk_notice_status');
  if ( $meta_value === '' || $meta_value === FALSE ) {
    ob_start();
    $prefix = WDFM()->prefix;
    $nicename = WDFM()->nicename;
    $url = WDFM()->plugin_url;
    $dismiss_url = add_query_arg(array( 'action' => 'wd_bp_dismiss' ), admin_url('admin-ajax.php'));
    $install_url = esc_url(wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=backup-wd'), 'install-plugin_backup-wd'));
    ?>
    <div class="notice notice-info" id="wd_bp_notice_cont">
      <p>
        <img id="wd_bp_logo_notice" src="<?php echo $url . '/images/logo.png'; ?>" />
        <?php echo sprintf(__("%s advises: Install brand new FREE %s plugin to keep your forms and website safe.", $prefix), $nicename, '<a href="https://wordpress.org/plugins/backup-wd/" title="' . __("More details", $prefix) . '" target="_blank">' .  __("Backup WD", $prefix) . '</a>'); ?>
        <a class="button button-primary" href="<?php echo $install_url; ?>">
          <span onclick="jQuery.post('<?php echo $dismiss_url; ?>');"><?php _e("Install", $prefix); ?></span>
        </a>
      </p>
      <button type="button" class="wd_bp_notice_dissmiss notice-dismiss" onclick="jQuery('#wd_bp_notice_cont').hide(); jQuery.post('<?php echo $dismiss_url; ?>');"><span class="screen-reader-text"></span></button>
    </div>
    <style>
      @media only screen and (max-width: 500px) {
        body #wd_backup_logo {
          max-width: 100%;
        }
        body #wd_bp_notice_cont p {
          padding-right: 25px !important;
        }
      }
      #wd_bp_logo_notice {
        width: 40px;
        float: left;
        margin-right: 10px;
      }
      #wd_bp_notice_cont {
        position: relative;
      }
      #wd_bp_notice_cont a {
        margin: 0 5px;
      }
      #wd_bp_notice_cont .dashicons-dismiss:before {
        content: "\f153";
        background: 0 0;
        color: #72777c;
        display: block;
        font: 400 16px/20px dashicons;
        speak: none;
        height: 20px;
        text-align: center;
        width: 20px;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }
      .wd_bp_notice_dissmiss {
        margin-top: 5px;
      }
    </style>
    <?php
    echo ob_get_clean();
  }
}

if ( !is_dir( plugin_dir_path( dirname(__FILE__) ) . 'backup-wd') ) {
  add_action('admin_notices', 'fm_bp_install_notice');
}

if ( !function_exists('wd_bps_install_notice_status') ) {
  // Add usermeta to db.
  function wd_bps_install_notice_status() {
    update_option('wd_bk_notice_status', '1', 'no');
  }
  add_action('wp_ajax_wd_bp_dismiss', 'wd_bps_install_notice_status');
}

function fm_add_plugin_meta_links($meta_fields, $file) {
  if ( plugin_basename(__FILE__) == $file ) {
    $plugin_url = "https://wordpress.org/support/plugin/form-maker";
    $prefix = WDFM()->prefix;
    $meta_fields[] = "<a href='" . $plugin_url . "' target='_blank'>" . __('Support Forum', $prefix) . "</a>";
    $meta_fields[] = "<a href='" . $plugin_url . "/reviews#new-post' target='_blank' title='" . __('Rate', $prefix) . "'>
            <i class='wdi-rate-stars'>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
      . "</i></a>";

    $stars_color = "#ffb900";

    echo "<style>"
      . ".wdi-rate-stars{display:inline-block;color:" . $stars_color . ";position:relative;top:3px;}"
      . ".wdi-rate-stars svg{fill:" . $stars_color . ";}"
      . ".wdi-rate-stars svg:hover{fill:" . $stars_color . "}"
      . ".wdi-rate-stars svg:hover ~ svg{fill:none;}"
      . "</style>";
  }

  return $meta_fields;
}

if ( WDFM()->is_free ) {
  add_filter("plugin_row_meta", 'fm_add_plugin_meta_links', 10, 2);
}

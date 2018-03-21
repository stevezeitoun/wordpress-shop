<?php

/**
 * Class FMViewOptions_fm
 */
class FMViewOptions_fm extends FMAdminView {
  /**
   * FMViewOptions_fm constructor.
   */
  public function __construct() {
    wp_enqueue_style('fm-tables');

    wp_enqueue_script('jquery');
    wp_enqueue_script('fm-admin');
  }

  /**
   * Display page.
   */
  public function display($params) {
    ob_start();
    echo $this->title(array(
      'title' => __('Options', WDFM()->prefix),
      'title_class' => 'wd-header',
      'add_new_button' => FALSE,
    ));
    $buttons = array(
      'save' => array(
        'title' => __('Save', WDFM()->prefix),
        'value' => 'save',
        'onclick' => 'fm_set_input_value(\'task\', \'save\')',
        'class' => 'button-primary',
      ),
    );
    echo $this->buttons($buttons);
    echo $this->body($params);
    // Pass the content to form.
    $form_attr = array(
      'id' => 'options_form',
      'action' => add_query_arg(array('page' => 'options' . WDFM()->menu_postfix), 'admin.php'),
    );
    echo $this->form(ob_get_clean(), $form_attr);
  }

  public function body($fm_settings) {
    $public_key = isset($fm_settings['public_key']) ? $fm_settings['public_key'] : '';
    $private_key = isset($fm_settings['private_key']) ? $fm_settings['private_key'] : '';
    $csv_delimiter = isset($fm_settings['csv_delimiter']) ? $fm_settings['csv_delimiter'] : ',';
    $fm_advanced_layout = isset($fm_settings['fm_advanced_layout']) && $fm_settings['fm_advanced_layout'] == '1' ? '1' : '0';
    $map_key = isset($fm_settings['map_key']) ? $fm_settings['map_key'] : '';
    $uninstall_href = add_query_arg( array( 'page' => 'uninstall' . WDFM()->menu_postfix), admin_url('admin.php') );
    ?>
    <div class="wd-table">
      <div class="wd-table-col wd-table-col-50 wd-table-col-left">
        <div class="wd-box-section">
          <div class="wd-box-title">
            <strong><?php _e('Recaptcha', WDFM()->prefix); ?></strong>
          </div>
          <div class="wd-box-content">
            <span class="wd-group">
              <label class="wd-label" for="public_key"><?php _e('Site key', WDFM()->prefix); ?></label>
              <input id="public_key" name="public_key" value="<?php echo $public_key; ?>" type="text" />
            </span>
            <span class="wd-group">
              <label class="wd-label" for="private_key"><?php _e('Secret key', WDFM()->prefix); ?></label>
              <input id="private_key" name="private_key" value="<?php echo $private_key; ?>" type="text" />
              <p class="description">
                <?php echo sprintf(__('%s for your site from ReCaptcha website and copy the provided here.', WDFM()->prefix), '<a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">' . __('Get ReCaptcha Site and Secret Keys', WDFM()->prefix) . '</a>'); ?>
              </p>
            </span>
            <span class="wd-group wd-right">

            </span>
          </div>
        </div>
        <div class="wd-box-section">
          <div class="wd-box-title">
            <strong><?php _e('Google Maps', WDFM()->prefix); ?></strong>
          </div>
          <div class="wd-box-content">
            <span class="wd-group">
              <label class="wd-label" for="map_key"><?php _e('Map API Key', WDFM()->prefix); ?></label>
              <input id="map_key" name="map_key" value="<?php echo $map_key; ?>" type="text" />
              <p class="description">
                <?php echo _e('Get', WDFM()->prefix); ?>
                <a href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend&keyType=CLIENT_SIDE&reusekey=true" target="_blank"><?php _e('Google Map API key', WDFM()->prefix); ?></a>
                <?php echo _e(' and copy them to this input. Make sure the key does not have restrictions.', WDFM()->prefix); ?>
              </p>
            </span>
          </div>
        </div>
      </div>
      <div class="wd-table-col wd-table-col-50 wd-table-col-right">
        <div class="wd-box-section">
          <div class="wd-box-title">
            <strong><?php _e('Other', WDFM()->prefix); ?></strong>
          </div>
          <div class="wd-box-content">
            <span class="wd-group">
              <label class="wd-label" for="csv_delimiter"><?php _e('CSV Delimiter', WDFM()->prefix); ?></label>
              <input id="csv_delimiter" name="csv_delimiter" value="<?php echo $csv_delimiter; ?>" type="text" />
              <p class="description"><?php _e('This option sets the symbol, which will be used to separate the values in CSV file of form submissions.', WDFM()->prefix); ?></p>
            </span>
            <span class="wd-group">
              <label class="wd-label"><?php _e('Enable Advanced Layout', WDFM()->prefix); ?></label>
              <input <?php echo checked($fm_advanced_layout, '1'); ?> id="fm_advanced_layout-1" class="wd-radio" value="1" name="fm_advanced_layout" type="radio"/>
              <label class="wd-label-radio" for="fm_advanced_layout-1"><?php _e('Yes', WDFM()->prefix); ?></label>
              <input <?php echo checked($fm_advanced_layout, '0'); ?> id="fm_advanced_layout-0" class="wd-radio" value="0" name="fm_advanced_layout" type="radio"/>
              <label class="wd-label-radio" for="fm_advanced_layout-0"><?php _e('No', WDFM()->prefix); ?></label>
              <p class="description"><?php _e('If you wish to build your form with HTML, instead of using Form Maker’s user-friendly interface, you can enable Advanced Layout. It can be accessed from the form editor.', WDFM()->prefix); ?></p>
            </span>
            <span class="wd-group">
              <label class="wd-label"><?php echo sprintf(__('Uninstall %s', WDFM()->prefix), WDFM()->nicename); ?></label>
              <a class="button" href="<?php echo $uninstall_href ?>"><?php _e('Uninstall', WDFM()->prefix); ?></a>
            </span>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}

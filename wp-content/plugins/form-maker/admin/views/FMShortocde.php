<?php

/**
 * Class FMViewFMShortocde
 */
class FMViewFMShortocde {
  /**
   * FMViewFMShortocde constructor.
   */
  public function __construct() {
    wp_print_scripts('fm-shortcode' . WDFM()->menu_postfix);

    wp_print_styles('wp-admin');
    wp_print_styles('buttons');

    wp_print_styles('fm-tables');
    wp_print_scripts('jquery-ui-datepicker');

    if (!WDFM()->is_free) {
      wp_print_styles('fm-jquery-ui');
      wp_print_styles('fm-style');
    }
  }

  /**
   * Insert form.
   *
   * @param array $forms
   */
  public function form( $forms ) {
    ?>
    <body class="wp-core-ui" data-width="400" data-height="140">
      <div class="wd-table">
        <div class="wd-table-col">
          <div class="wd-box-content wd-box-content-shortcode">
            <span class="wd-group">
              <select name="form_maker_id">
                <option value="0"><?php _e('-Select a Form-', WDFM()->prefix); ?></option>
                <?php
                if ( $forms ) {
                  foreach ( $forms as $form ) {
                    ?>
                <option value="<?php echo $form->id; ?>" <?php if (!$form->published) { echo 'disabled="disabled"';}  ?>><?php echo $form->title . ($form->published ? '' : ' - ' . __('Unpublished', WDFM()->prefix)); ?></option>
                    <?php
                  }
                }
                ?>
              </select>
            </span>
            <span class="wd-group wd-right">
              <input class="wd-button button-primary" type="button" name="insert" value="<?php _e('Insert', WDFM()->prefix); ?>" onclick="insert_shortcode('form')" />
            </span>
          </div>
        </div>
      </div>
    </body>
    <?php
    die();
  }

  /**
   * Insert submissions.
   *
   * @param array $forms
   */
  public function submissions( $forms ) {
    ?>
    <body class="wp-core-ui" data-width="500" data-height="570">
      <?php
      if ( WDFM()->is_free ) {
        ?>
        <div class="wd-fixed-message">
          <?php echo WDW_FM_Library::message_id(0, __('Front end submissions are disabled in free version.', WDFM()->prefix), 'error'); ?>
        </div>
        <div class="wd-fixed-conteiner"></div>
        <?php
      }
      ?>
      <div class="wd-table">
        <div class="wd-table-col">
          <div class="wd-box-content wd-box-content-shortcode">
            <span class="wd-group">
              <select name="form_maker_id">
                <option value="0"><?php _e('-Select a Form-', WDFM()->prefix); ?></option>
                <?php
                if ( $forms ) {
                  foreach ( $forms as $form ) {
                    ?>
                    <option value="<?php echo $form->id; ?>" <?php if (!$form->published) { echo 'disabled="disabled"';}  ?>><?php echo $form->title . ($form->published ? '' : ' - ' . __('Unpublished', WDFM()->prefix)); ?></option>
                    <?php
                  }
                }
                ?>
              </select>
            </span>
            <span class="wd-group">
              <label class="wd-label" for="public_key"><?php _e('Select Date Range', WDFM()->prefix); ?></label>
              <label for="startdate"><?php _e('From', WDFM()->prefix); ?>:</label>
              <input class="initial-width wd-datepicker" type="text" name="startdate" id="startdate" size="10" maxlength="10" value="" />
              <label for="enddate"><?php _e('To', WDFM()->prefix); ?>:</label>
              <input class="initial-width wd-datepicker" type="text" name="enddate" id="enddate" size="10" maxlength="10" value="" />
            </span>
          </div>
        </div>
      </div>
      <div class="wd-table">
        <div class="wd-table-col wd-table-col-50 wd-table-col-left">
          <div class="wd-box-content wd-box-content-shortcode">
            <span class="wd-group">
              <label class="wd-label"><?php _e('Select fields', WDFM()->prefix); ?></label>
              <ul>
                <li>
                  <input type="checkbox" checked="checked" id="submit_date" name="submit_date" value="submit_date" />
                  <label for="submit_date"><?php _e('Submit Date', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="submitter_ip" name="submitter_ip" value="submitter_ip" />
                  <label for="submitter_ip"><?php _e('Submitter\'s IP Address', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="username" name="username" value="username" />
                  <label for="username"><?php _e('Submitter\'s Username', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="useremail" name="useremail" value="useremail" />
                  <label for="useremail"><?php _e('Submitter\'s Email Address', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="form_fields" name="form_fields" value="form_fields" />
                  <label for="form_fields"><?php _e('Form Fields', WDFM()->prefix); ?></label>
                </li>
                <p class="description">
                  <?php _e('You can hide specific form fields from Form General Options.', WDFM()->prefix); ?>
                </p>
              </ul>
            </span>
            <span class="wd-group">
              <label class="wd-label"><?php _e('Export to', WDFM()->prefix); ?></label>
              <ul>
                <li>
                  <input type="checkbox" checked="checked" id="csv" name="csv" value="csv" />
                  <label for="csv"><?php _e('CSV', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="xml" name="xml" value="xml" />
                  <label for="xml"><?php _e('XML', WDFM()->prefix); ?></label>
                </li>
              </ul>
            </span>
          </div>
        </div>
        <div class="wd-table-col wd-table-col-50 wd-table-col-right">
          <div class="wd-box-content wd-box-content-shortcode">
            <span class="wd-group">
              <label class="wd-label"><?php _e('Show', WDFM()->prefix); ?></label>
              <ul>
                <li>
                  <input type="checkbox" checked="checked" id="title" name="title" value="title" />
                  <label for="title"><?php _e('Title', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="search" name="search" value="search" />
                  <label for="search"><?php _e('Search', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="ordering" name="ordering" value="ordering" />
                  <label for="ordering"><?php _e('Ordering', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="entries" name="entries" value="entries" />
                  <label for="entries"><?php _e('Entries', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="views" name="views" value="views" />
                  <label for="views"><?php _e('Views', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="conversion_rate" name="conversion_rate" value="conversion_rate" />
                  <label for="conversion_rate"><?php _e('Conversion Rate', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="pagination" name="pagination" value="pagination" />
                  <label for="pagination"><?php _e('Pagination', WDFM()->prefix); ?></label>
                </li>
                <li>
                  <input type="checkbox" checked="checked" id="stats" name="stats" value="stats" />
                  <label for="stats"><?php _e('Statistics', WDFM()->prefix); ?></label>
                </li>
              </ul>
            </span>
          </div>
        </div>
      </div>
      <div class="wd-table">
        <div class="wd-table-col">
          <div class="wd-box-content wd-box-content-shortcode">
            <span class="wd-group wd-right">
              <input class="wd-button button-primary" type="button" name="insert" value="<?php _e('Insert', WDFM()->prefix); ?>" onclick="insert_shortcode('submissions')" />
            </span>
          </div>
        </div>
      </div>
    </body>
    <?php
    die();
  }
}

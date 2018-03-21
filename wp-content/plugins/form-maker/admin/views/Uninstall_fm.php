<?php

class FMViewUninstall_fm {
  /**
   * FMViewUninstall_fm constructor.
   */
  public function __construct() {
    wp_enqueue_style('fm-tables');
    wp_enqueue_script('fm-admin');
    if (WDFM()->is_free) {
      wp_enqueue_style('fm-deactivate-css');
      wp_enqueue_script('fm-deactivate-popup');
    }
  }

  public function display( $params ) {
    global $wpdb;
    $prefix = $wpdb->prefix;
    $addons = $params['addons'];
    ?>
    <form method="post" action="admin.php?page=uninstall<?php echo WDFM()->menu_postfix; ?>" style="width:95%;">
      <?php wp_nonce_field(WDFM()->nonce, WDFM()->nonce); ?>
      <div class="wrap">
        <div class="uninstall-banner">
          <div class="uninstall_icon">
          </div>
          <div class="fm-logo-title">Uninstall Form Maker</div>
        </div>
        <br />
        <div class="goodbye-text">
          Before uninstalling the plugin, please Contact our
          <a href="https://web-dorado.com/support/contact-us.html" target='_blank'>support team</a>. We'll do our best to help you out with your issue. We value each and every user and value what’s right for our users in everything we do.<br>
          However, if anyway you have made a decision to uninstall the plugin, please take a minute to
          <a href="https://web-dorado.com/support/contact-us.html" target='_blank'>Contact us</a> and tell what you didn't like for our plugins further improvement and development. Thank you !!!
        </div>
        <div class="goodbye-text" style="color: red;">
          Note, that uninstalling Form Maker will remove all forms, submissions and other data on the plugin.<br />Please make sure you don't have any important information before you proceed.
        </div>
        <p>
          Deactivating Form Maker plugin does not remove any data that may have been created, such as the Forms and the Submissions. To completely remove this plugin, you can uninstall it here.
        </p>
        <p style="color: red;">
          <strong>WARNING:</strong>
          Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.
        </p>
        <p style="color: red">
          <strong>The following WordPress Options/Tables will be DELETED:</strong>
        </p>
        <table class="widefat">
          <thead>
          <tr>
            <th>Database Tables</th>
          </tr>
          </thead>
          <tr>
            <td valign="top">
              <ol>
                <li><?php echo $prefix; ?>formmaker</li>
                <li><?php echo $prefix; ?>formmaker_backup</li>
                <li><?php echo $prefix; ?>formmaker_blocked</li>
                <li><?php echo $prefix; ?>formmaker_submits</li>
                <li><?php echo $prefix; ?>formmaker_views</li>
                <li><?php echo $prefix; ?>formmaker_themes</li>
                <li><?php echo $prefix; ?>formmaker_sessions</li>
                <li><?php echo $prefix; ?>formmaker_query</li>
                <li><?php echo $prefix; ?>formmaker_display_options</li>
                <?php
                foreach ( $addons as $addon => $addon_name ) {
                  if ( defined($addon) && is_plugin_active(constant($addon)) ) {
                    if ( is_array($addon_name) ) {
                      foreach ( $addon_name as $ad_name ) {
                        echo '<li>' . $prefix . 'formmaker_' . $ad_name . '</li>';
                      }
                    }
                    else {
                      echo '<li>' . $prefix . 'formmaker_' . $addon_name . '</li>';
                    }
                  }
                }
                ?>
              </ol>
            </td>
          </tr>
        </table>
        <p style="text-align: center;">
          Do you really want to uninstall Form Maker?
        </p>
        <p style="text-align: center;">
          <input type="checkbox" name="Form Maker" id="check_yes" value="yes" />&nbsp;<label for="check_yes">Yes</label>
        </p>
        <p style="text-align: center;">
          <input type="submit" value="UNINSTALL" class="button-primary" onclick="if (check_yes.checked) {  if (confirm('You are About to Uninstall Form Maker from WordPress.\nThis Action Is Not Reversible.')) { fm_set_input_value('task', 'uninstall'); } else { return false; } } else { return false; }" />
        </p>
      </div>
      <input id="task" name="task" type="hidden" value="" />
    </form>
    <?php
  }

  public function uninstall( $params ) {
    $prefix = $params['prefix'];
    $addons = $params['addons']; //array
    $deactivate_url = add_query_arg(array(
                                      'action' => 'deactivate',
                                      'plugin' => WDFM()->main_file,
                                    ), admin_url('plugins.php'));
    $deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_' . WDFM()->main_file);
    ?>
    <div id="message" class="updated fade">
      <p>The following Database Tables successfully deleted:</p>
      <p><?php echo $prefix; ?>formmaker,</p>
      <p><?php echo $prefix; ?>formmaker_backup,</p>
      <p><?php echo $prefix; ?>formmaker_blocked,</p>
      <p><?php echo $prefix; ?>formmaker_sessions,</p>
      <p><?php echo $prefix; ?>formmaker_submits,</p>
      <p><?php echo $prefix; ?>formmaker_themes,</p>
      <p><?php echo $prefix; ?>formmaker_views,</p>
      <p><?php echo $prefix; ?>formmaker_query,</p>
      <p><?php echo $prefix; ?>formmaker_display_options.</p>
      <?php
      foreach ( $addons as $addon => $addon_name ) {
        if ( defined($addon) && is_plugin_active(constant($addon)) ) {
          if ( is_array($addon_name) ) {
            foreach ( $addon_name as $ad_name ) {
              echo '<p>' . $prefix . 'formmaker_' . $ad_name . '</p>';
            }
          }
          else {
            echo '<p>' . $prefix . 'formmaker_' . $addon_name . '</p>';
          }
        }
      }
      ?>
    </div>
    <div class="wrap">
      <h2>Uninstall Form Maker</h2>
      <p>
        <strong><a href="<?php echo $deactivate_url; ?>" class="fm_deactivate_link" data-uninstall="1">Click Here</a> To Finish the Uninstallation and Form Maker
          will be Deactivated Automatically.</strong></p>
      <input id="task" name="task" type="hidden" value="" />
    </div>
    <?php
  }
}

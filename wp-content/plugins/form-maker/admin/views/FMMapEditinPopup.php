<?php

/**
 * Class FMViewFrommapeditinpopup
 */
class FMViewFrommapeditinpopup {
  /**
   * Display.
   *
   * @param array $params
   */
  public function display( $params ) {
    wp_print_scripts('google-maps');
    wp_print_scripts('fm-gmap_form');
    $long = $params['long'];
    $lat  = $params['lat'];
    ?>
    <table style="margin:0px; padding:0px">
      <tr>
        <td><b><?php _e('Address:', WDFM()->prefix); ?></b></td>
        <td><input type="text" id="addrval0" style="border:0px; background:none" size="80" readonly /></td>
      </tr>
      <tr>
        <td><b><?php _e('Longitude:', WDFM()->prefix); ?></b></td>
        <td><input type="text" id="longval0" style="border:0px; background:none" size="80" readonly /></td>
      </tr>
      <tr>
        <td><b><?php _e('Latitude:', WDFM()->prefix); ?></b></td>
        <td><input type="text" id="latval0" style="border:0px; background:none" size="80" readonly /></td>
      </tr>
    </table>
    <div id="0_elementform_id_temp" long="<?php echo $long ?>" center_x="<?php echo $long ?>" center_y="<?php echo $lat ?>" lat="<?php echo $lat ?>" zoom="8" info="" style="width:600px; height:400px; "></div>
    <script>
      if_gmap_init("0");
      add_marker_on_map(0, 0, "<?php echo $long; ?>", "<?php echo $lat; ?>", "");
    </script>
    <?php

    die();
  }
}

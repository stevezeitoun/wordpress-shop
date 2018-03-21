<?php

/**
 * Class FMViewFromipinfoinpopup
 */
class FMViewFromipinfoinpopup {
  /**
   * Display.
   *
   * @param array $params
   */
  public function display( $params ) {
    $ip = $params['ip'];
    $city = $params['city'];
    $country = $params['country'];
    $country_flag = $params['country_flag'];
    $countryCode = $params['countryCode'];
    $timezone = $params['timezone'];
    $lat = $params['lat'];
    $lon = $params['lon'];
    ?>
    <style>
      .admintable {
        height: 100%;
        margin: 0 auto;
        padding: 0;
        width: 100%;
      }

      table.admintable td.key, table.admintable td.paramlist_key {
        background-color: #F6F6F6;
        border-bottom: 1px solid #E9E9E9;
        border-right: 1px solid #E9E9E9;
        color: #666666;
        font-weight: bold;
        margin-right: 10px;
        text-align: right;
        width: 140px;
      }
    </style>
    <table class="admintable">
      <tr>
        <td class="key"><b><?php _e('IP', WDFM()->prefix); ?>:</b></td>
        <td><?php echo $ip; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('City', WDFM()->prefix); ?>:</b></td>
        <td><?php echo $city; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Country', WDFM()->prefix); ?>:</b></td>
        <td><?php echo $country . ' ' . $country_flag; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('CountryCode', WDFM()->prefix); ?>:</b></td>
        <td><?php echo $countryCode; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Timezone', WDFM()->prefix); ?>:</b></td>
        <td><?php echo $timezone; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Latitude', WDFM()->prefix); ?>:</b></td>
        <td><?php echo $lat; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Longitude', WDFM()->prefix); ?>:</b></td>
        <td><?php echo $lon; ?></td>
      </tr>
    </table>
    <?php

    die();
  }
}

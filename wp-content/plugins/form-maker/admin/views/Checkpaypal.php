<?php

/**
 * Class FMViewCheckpaypal
 */
class FMViewCheckpaypal {
  /**
   * Payment information template.
   *
   * @param array $template_params
   *
   * @return string
   */
  public function payment_information_template( $template_params ) {
    $form_session = $template_params['form_session'];
    $data = $template_params['data'];
    $tax = $data['tax'];
    $total = $data['total'];
    $shipping = $data['shipping'];
    $currency = $form_session->currency;
    ob_start();
    ?>
    <table class="admintable" border="1">
      <tr>
        <td class="key"><?php _e('Currency', WDFM()->prefix); ?></td>
        <td><?php echo $currency; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Date', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->ord_last_modified; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Status', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->status; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Full name', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->full_name; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Email', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->email; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Phone', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->phone; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Mobile phone', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->mobile_phone; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Fax', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->fax; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Address', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->address; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('Payment info', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->paypal_info; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('IPN', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->ipn; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('tax', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->tax; ?>%</td>
      </tr>
      <tr>
        <td class="key"><?php _e('shipping', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->shipping; ?></td>
      </tr>
      <tr>
        <td class="key"><?php _e('read', WDFM()->prefix); ?></td>
        <td><?php echo $form_session->read; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Item total', WDFM()->prefix); ?></b></td>
        <td><?php echo ($total - $tax - $shipping) . $currency; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Tax', WDFM()->prefix); ?></b></td>
        <td> <?php echo $tax . $currency; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Shipping and handling', WDFM()->prefix); ?></b></td>
        <td><?php echo $shipping . $currency; ?></td>
      </tr>
      <tr>
        <td class="key"><b><?php _e('Total', WDFM()->prefix); ?></b></td>
        <td><?php echo $total . $currency; ?></td>
      </tr>
    </table>
    <?php

    return ob_get_clean();
  }
}

<?php

/**
 * Class FMViewPaypal_info
 */
class FMViewPaypal_info {
  /**
   * Display.
   *
   * @param array $params
   */
  public function display( $params ) {
    $row = $params['row'];
    if ( !isset($row->ipn) ) {
      ?>
      <div style="width:100%; text-align: center; height: 70%; vertical-align: middle;">
        <h1 style="vertical-align: middle; margin: auto; color: #000"><p>No information yet</p></h1>
      </div>
      <?php
    }
    else {
      ?>
      <style>
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
      <h2>Payment Info</h2>
      <table class="admintable">
        <?php
        if ( $row->currency ) {
          ?>
          <tr>
            <td class="key">Currency</td>
            <td><?php echo $row->currency; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->ord_last_modified ) {
          ?>
          <tr>
            <td class="key">Last modified</td>
            <td><?php echo $row->ord_last_modified; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->status ) {
          ?>
          <tr>
            <td class="key">Status</td>
            <td><?php echo $row->status; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->full_name ) {
          ?>
          <tr>
            <td class="key">Full name</td>
            <td><?php echo $row->full_name; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->email ) {
          ?>
          <tr>
            <td class="key">Email</td>
            <td><?php echo $row->email; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->phone ) {
          ?>
          <tr>
            <td class="key">Phone</td>
            <td><?php echo $row->phone; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->mobile_phone ) {
          ?>
          <tr>
            <td class="key">Mobile phone</td>
            <td><?php echo $row->mobile_phone; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->fax ) {
          ?>
          <tr>
            <td class="key">Fax</td>
            <td><?php echo $row->fax; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->address ) {
          ?>
          <tr>
            <td class="key">Address</td>
            <td><?php echo $row->address; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->paypal_info ) {
          ?>
          <tr>
            <td class="key">Info</td>
            <td><?php echo $row->paypal_info; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->ipn ) {
          ?>
          <tr>
            <td class="key">IPN</td>
            <td><?php echo $row->ipn; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->tax ) {
          ?>
          <tr>
            <td class="key">Tax</td>
            <td><?php echo $row->tax; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->shipping ) {
          ?>
          <tr>
            <td class="key">Shipping</td>
            <td><?php echo $row->shipping; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->read ) {
          ?>
          <tr>
            <td class="key">Read</td>
            <td><?php echo $row->read; ?></td>
          </tr>
          <?php
        }
        ?>
        <?php
        if ( $row->total ) {
          ?>
          <tr>
            <td class="key">Total</td>
            <td><b><?php echo $row->total; ?></b></td>
          </tr>
          <?php
        }
        ?>
      </table>
      <?php
    }

    die();
  }
}

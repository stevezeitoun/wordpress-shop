<?php

class WDW_FM_Library {

  public static $qpKeys = array(
    "\x00",
    "\x01",
    "\x02",
    "\x03",
    "\x04",
    "\x05",
    "\x06",
    "\x07",
    "\x08",
    "\x09",
    "\x0A",
    "\x0B",
    "\x0C",
    "\x0D",
    "\x0E",
    "\x0F",
    "\x10",
    "\x11",
    "\x12",
    "\x13",
    "\x14",
    "\x15",
    "\x16",
    "\x17",
    "\x18",
    "\x19",
    "\x1A",
    "\x1B",
    "\x1C",
    "\x1D",
    "\x1E",
    "\x1F",
    "\x7F",
    "\x80",
    "\x81",
    "\x82",
    "\x83",
    "\x84",
    "\x85",
    "\x86",
    "\x87",
    "\x88",
    "\x89",
    "\x8A",
    "\x8B",
    "\x8C",
    "\x8D",
    "\x8E",
    "\x8F",
    "\x90",
    "\x91",
    "\x92",
    "\x93",
    "\x94",
    "\x95",
    "\x96",
    "\x97",
    "\x98",
    "\x99",
    "\x9A",
    "\x9B",
    "\x9C",
    "\x9D",
    "\x9E",
    "\x9F",
    "\xA0",
    "\xA1",
    "\xA2",
    "\xA3",
    "\xA4",
    "\xA5",
    "\xA6",
    "\xA7",
    "\xA8",
    "\xA9",
    "\xAA",
    "\xAB",
    "\xAC",
    "\xAD",
    "\xAE",
    "\xAF",
    "\xB0",
    "\xB1",
    "\xB2",
    "\xB3",
    "\xB4",
    "\xB5",
    "\xB6",
    "\xB7",
    "\xB8",
    "\xB9",
    "\xBA",
    "\xBB",
    "\xBC",
    "\xBD",
    "\xBE",
    "\xBF",
    "\xC0",
    "\xC1",
    "\xC2",
    "\xC3",
    "\xC4",
    "\xC5",
    "\xC6",
    "\xC7",
    "\xC8",
    "\xC9",
    "\xCA",
    "\xCB",
    "\xCC",
    "\xCD",
    "\xCE",
    "\xCF",
    "\xD0",
    "\xD1",
    "\xD2",
    "\xD3",
    "\xD4",
    "\xD5",
    "\xD6",
    "\xD7",
    "\xD8",
    "\xD9",
    "\xDA",
    "\xDB",
    "\xDC",
    "\xDD",
    "\xDE",
    "\xDF",
    "\xE0",
    "\xE1",
    "\xE2",
    "\xE3",
    "\xE4",
    "\xE5",
    "\xE6",
    "\xE7",
    "\xE8",
    "\xE9",
    "\xEA",
    "\xEB",
    "\xEC",
    "\xED",
    "\xEE",
    "\xEF",
    "\xF0",
    "\xF1",
    "\xF2",
    "\xF3",
    "\xF4",
    "\xF5",
    "\xF6",
    "\xF7",
    "\xF8",
    "\xF9",
    "\xFA",
    "\xFB",
    "\xFC",
    "\xFD",
    "\xFE",
    "\xFF"
  );
  public static $qpReplaceValues = array(
    "=00",
    "=01",
    "=02",
    "=03",
    "=04",
    "=05",
    "=06",
    "=07",
    "=08",
    "=09",
    "=0A",
    "=0B",
    "=0C",
    "=0D",
    "=0E",
    "=0F",
    "=10",
    "=11",
    "=12",
    "=13",
    "=14",
    "=15",
    "=16",
    "=17",
    "=18",
    "=19",
    "=1A",
    "=1B",
    "=1C",
    "=1D",
    "=1E",
    "=1F",
    "=7F",
    "=80",
    "=81",
    "=82",
    "=83",
    "=84",
    "=85",
    "=86",
    "=87",
    "=88",
    "=89",
    "=8A",
    "=8B",
    "=8C",
    "=8D",
    "=8E",
    "=8F",
    "=90",
    "=91",
    "=92",
    "=93",
    "=94",
    "=95",
    "=96",
    "=97",
    "=98",
    "=99",
    "=9A",
    "=9B",
    "=9C",
    "=9D",
    "=9E",
    "=9F",
    "=A0",
    "=A1",
    "=A2",
    "=A3",
    "=A4",
    "=A5",
    "=A6",
    "=A7",
    "=A8",
    "=A9",
    "=AA",
    "=AB",
    "=AC",
    "=AD",
    "=AE",
    "=AF",
    "=B0",
    "=B1",
    "=B2",
    "=B3",
    "=B4",
    "=B5",
    "=B6",
    "=B7",
    "=B8",
    "=B9",
    "=BA",
    "=BB",
    "=BC",
    "=BD",
    "=BE",
    "=BF",
    "=C0",
    "=C1",
    "=C2",
    "=C3",
    "=C4",
    "=C5",
    "=C6",
    "=C7",
    "=C8",
    "=C9",
    "=CA",
    "=CB",
    "=CC",
    "=CD",
    "=CE",
    "=CF",
    "=D0",
    "=D1",
    "=D2",
    "=D3",
    "=D4",
    "=D5",
    "=D6",
    "=D7",
    "=D8",
    "=D9",
    "=DA",
    "=DB",
    "=DC",
    "=DD",
    "=DE",
    "=DF",
    "=E0",
    "=E1",
    "=E2",
    "=E3",
    "=E4",
    "=E5",
    "=E6",
    "=E7",
    "=E8",
    "=E9",
    "=EA",
    "=EB",
    "=EC",
    "=ED",
    "=EE",
    "=EF",
    "=F0",
    "=F1",
    "=F2",
    "=F3",
    "=F4",
    "=F5",
    "=F6",
    "=F7",
    "=F8",
    "=F9",
    "=FA",
    "=FB",
    "=FC",
    "=FD",
    "=FE",
    "=FF"
  );
  const LINELENGTH = 72;
  const LINEEND = "\n";

  public static $fm_js_content;
  /**
   * Get request value.
   *
   * @param string $key
   * @param string $default_value
   * @param bool $esc_html
   *
   * @return string|array
   */
  public static function get($key, $default_value = '', $esc_html = true) {
    if (isset($_GET[$key])) {
      $value = $_GET[$key];
    }
    elseif (isset($_POST[$key])) {
      $value = $_POST[$key];
    }
    elseif (isset($_REQUEST[$key])) {
      $value = $_REQUEST[$key];
    }
    else {
      $value = $default_value;
    }
    if (is_array($value)) {
      array_walk_recursive($value, array('self', 'validate_data'), $esc_html);
    }
    else {
      self::validate_data($value, $esc_html);
    }
    return $value;
  }

  /**
   * Validate data.
   *
   * @param $value
   * @param $esc_html
   */
  private static function validate_data(&$value, $esc_html) {
    $value = stripslashes($value);
    if ($esc_html) {
      $value = esc_html($value);
    }
  }

  /**
   * Generate message container  by message id or directly by message.
   *
   * @param int $message_id
   * @param string $message If message_id is 0
   * @param string $type
   *
   * @return mixed|string|void
   */
  public static function message_id($message_id, $message = '', $type = 'updated') {
    if ($message_id) {
      switch ( $message_id ) {
        case 1: {
          $message = 'Item Successfully Saved.';
          $type = 'updated';
          break;
        }
        case 2: {
          $message = 'Failed.';
          $type = 'error';
          break;
        }
        case 3: {
          $message = 'Item successfully deleted.';
          $type = 'updated';
          break;
        }
        case 4: {
          $message = "You can't delete default theme";
          $type = 'error';
          break;
        }
        case 5: {
          // Todo: delete message.
          $message = 'Items successfully deleted.';
          $type = 'updated';
          break;
        }
        case 6: {
          // Todo: delete message.
          $message = 'You must select at least one item.';
          $type = 'error';
          break;
        }
        case 7: {
          $message = 'The item is successfully set as default.';
          $type = 'updated';
          break;
        }
        case 8: {
          $message = 'Options Successfully Saved.';
          $type = 'updated';
          break;
        }
        case 9:
          $message = 'Item successfully published.';
          $type = 'updated';
          break;
        case 10:
          $message = 'Item successfully unpublished.';
          $type = 'updated';
          break;
        case 11:
          $message = 'Item successfully duplicated.';
          $type = 'updated';
          break;
        case 12:
          $message = 'IP Successfully Blocked.';
          $type = 'updated';
          break;
        case 13:
          $message = 'IP Successfully Unblocked.';
          $type = 'updated';
          break;
        case 14:
          $message = 'Submission Successfully Saved.';
          $type = 'updated';
          break;
        default: {
          $message = '';
          break;
        }
      }
    }

    if ($message) {
      ob_start();
      ?><div class="<?php echo $type; ?> inline">
      <p>
        <strong><?php echo $message; ?></strong>
      </p>
      </div><?php
      $message = ob_get_clean();
    }

    return $message;
  }

  /**
   * Generate message.
   *
   * @param string $message
   * @param string $type
   *
   * @return mixed|string|void
   */
  public static function message($message, $type) {
    if ( $message ) {
      ob_start();
      ?><div class="fm-message <?php echo $type; ?>"><?php echo $message; ?></div><?php
      $message = ob_get_clean();
    }
    return $message;
  }

  public static function fm_container($theme_id, $form_body) {
    return '<div class="fm-form-container fm-theme' . $theme_id . '">' . $form_body . '</div>';
  }

  /**
   * Ordering.
   *
   * @param        $id
   * @param        $orderby
   * @param        $order
   * @param        $text
   * @param        $page_url
   * @param string $additional_class
   *
   * @return string
   */
  public static function ordering($id, $orderby, $order, $text, $page_url, $additional_class = '') {
    $class = array(
      ($orderby == $id ? 'sorted': 'sortable'),
      $order,
      $additional_class,
      'col_' . $id,
    );
    $order = (($orderby == $id) && ($order == 'asc')) ? 'desc' : 'asc';
    ob_start();
    ?>
    <th id="<?php echo $id; ?>" class="<?php echo implode(' ', $class); ?>">
      <a href="<?php echo add_query_arg( array('orderby' => $id, 'order' => $order), $page_url ); ?>"
         title="<?php _e('Click to sort by this item', WDFM()->prefix); ?>">
        <span><?php echo $text; ?></span><span class="sorting-indicator"></span>
      </a>
    </th>
    <?php
    return ob_get_clean();
  }

  //Todo: remove this function.
  public static function search($search_by, $search_value, $form_id) {
    ?>
    <div class="alignleft actions" style="clear:both;">
      <script>
        function fm_search() {
          document.getElementById("page_number").value = "1";
          document.getElementById("search_or_not").value = "search";
          document.getElementById("<?php echo $form_id; ?>").submit();
        }
        function fm_reset() {
          if (document.getElementById("search_value")) {
            document.getElementById("search_value").value = "";
          }
          if (document.getElementById("search_select_value")) {
            document.getElementById("search_select_value").value = 0;
          }
          document.getElementById("<?php echo $form_id; ?>").submit();
        }
      </script>
      <div class="fm-search">
        <label for="search_value"><?php echo $search_by; ?>:</label>
        <input type="text" id="search_value" name="search_value" value="<?php echo esc_html($search_value); ?>"/>
        <button class="fm-icon search-icon" onclick="fm_search()">
        </button>
        <button class="fm-icon reset-icon" onclick="fm_reset()">
        </button>
      </div>
    </div>
    <?php
  }

  public static function search_select($search_by, $search_select_value, $playlists, $form_id) {
    ?>
    <div class="alignleft actions" style="clear:both;">
      <script>
        function fm_search_select() {
          document.getElementById("page_number").value = "1";
          document.getElementById("search_or_not").value = "search";
          document.getElementById("<?php echo $form_id; ?>").submit();
        }
      </script>
      <div class="alignleft actions" >
        <label for="search_select_value" style="font-size:14px; width:50px; display:inline-block;"><?php echo $search_by; ?>:</label>
        <select id="search_select_value" name="search_select_value" onchange="fm_search_select();" style="float: none; width: 150px;">
          <?php
          foreach ($playlists as $id => $playlist) {
            ?>
            <option value="<?php echo $id; ?>" <?php echo (($search_select_value == $id) ? 'selected="selected"' : ''); ?>><?php echo $playlist; ?></option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>
    <?php
  }

  //Todo: remove this function.
  public static function html_page_nav($count_items, $page_number, $form_id, $items_per_page = 20) {
    $limit = 20;
    if ($count_items) {
      if ($count_items % $limit) {
        $items_county = ($count_items - $count_items % $limit) / $limit + 1;
      }
      else {
        $items_county = ($count_items - $count_items % $limit) / $limit;
      }
    }
    else {
      $items_county = 1;
    }
    ?>
    <script type="text/javascript">
      var items_county = <?php echo $items_county; ?>;
      function fm_page(x, y) {
        switch (y) {
          case 1:
            if (x >= items_county) {
              document.getElementById('page_number').value = items_county;
            }
            else {
              document.getElementById('page_number').value = x + 1;
            }
            break;
          case 2:
            document.getElementById('page_number').value = items_county;
            break;
          case -1:
            if (x == 1) {
              document.getElementById('page_number').value = 1;
            }
            else {
              document.getElementById('page_number').value = x - 1;
            }
            break;
          case -2:
            document.getElementById('page_number').value = 1;
            break;
          default:
            document.getElementById('page_number').value = 1;
        }

        jQuery('#pagination_clicked').val('1');
        document.getElementById('<?php echo $form_id; ?>').submit();
      }

      function check_enter_key(e) {
        var key_code = (e.keyCode ? e.keyCode : e.which);
        if (key_code == 13) { /*Enter keycode*/
          if (jQuery('#current_page').val() >= items_county) {
            document.getElementById('page_number').value = items_county;
          }
          else {
            document.getElementById('page_number').value = jQuery('#current_page').val();
          }
          jQuery('#pagination_clicked').val('1');
          document.getElementById('<?php echo $form_id; ?>').submit();
        }
        return true;
      }
    </script>
    <div class="tablenav-pages">
      <span class="displaying-num">
        <?php
        if ($count_items != 0) {
          echo $count_items; ?> item<?php echo (($count_items == 1) ? '' : 's');
        }
        ?>
      </span>
      <?php
      if ($count_items > $items_per_page) {
      $first_page = "first-page";
      $prev_page = "prev-page";
      $next_page = "next-page";
      $last_page = "last-page";
      if ($page_number == 1) {
        $first_page = "first-page disabled";
        $prev_page = "prev-page disabled";
        $next_page = "next-page";
        $last_page = "last-page";
      }
      if ($page_number >= $items_county) {
        $first_page = "first-page ";
        $prev_page = "prev-page";
        $next_page = "next-page disabled";
        $last_page = "last-page disabled";
      }
      ?>
      <span class="pagination-links">
        <a class="<?php echo $first_page; ?>" title="Go to the first page" href="javascript:fm_page(<?php echo $page_number; ?>,-2);">«</a>
        <a class="<?php echo $prev_page; ?>" title="Go to the previous page" href="javascript:fm_page(<?php echo $page_number; ?>,-1);">‹</a>
        <span class="paging-input">
          <span class="total-pages">
          <input class="current_page" id="current_page" name="current_page" value="<?php echo $page_number; ?>" onkeypress="return check_enter_key(event)" title="Go to the page" type="text" size="1" />
        </span> of
        <span class="total-pages">
            <?php echo $items_county; ?>
          </span>
        </span>
        <a class="<?php echo $next_page ?>" title="Go to the next page" href="javascript:fm_page(<?php echo $page_number; ?>,1);">›</a>
        <a class="<?php echo $last_page ?>" title="Go to the last page" href="javascript:fm_page(<?php echo $page_number; ?>,2);">»</a>
        <?php
        }
        ?>
      </span>
    </div>
    <input type="hidden" id="page_number" name="page_number" value="<?php echo ((isset($_POST['page_number'])) ? (int) $_POST['page_number'] : 1); ?>" />
    <input type="hidden" id="search_or_not" name="search_or_not" value="<?php echo ((isset($_POST['search_or_not'])) ? esc_html($_POST['search_or_not']) : ''); ?>"/>
    <?php
  }

  public static function ajax_search($search_by, $search_value, $form_id) {
    ?>
    <div class="alignleft actions" style="clear:both;">
      <script>
        function fm_search() {
          document.getElementById("page_number").value = "1";
          document.getElementById("search_or_not").value = "search";
          fm_ajax_save('<?php echo $form_id; ?>');
        }
        function fm_reset() {
          if (document.getElementById("search_value")) {
            document.getElementById("search_value").value = "";
          }
          fm_ajax_save('<?php echo $form_id; ?>');
        }
      </script>
      <div class="alignleft actions" style="">
        <label for="search_value" style="font-size:14px; width:60px; display:inline-block;"><?php echo $search_by; ?>:</label>
        <input type="text" id="search_value" name="search_value" class="fm_search_value" value="<?php echo esc_html($search_value); ?>" style="width: 150px;<?php echo (get_bloginfo('version') > '3.7') ? ' height: 28px;' : ''; ?>" />
      </div>
      <div class="alignleft actions">
        <input type="button" value="Search" onclick="fm_search()" class="button-secondary action">
        <input type="button" value="Reset" onclick="fm_reset()" class="button-secondary action">
      </div>
    </div>
    <?php
  }

  public static function ajax_html_page_nav($count_items, $page_number, $form_id) {
    $limit = 20;
    if ($count_items) {
      if ($count_items % $limit) {
        $items_county = ($count_items - $count_items % $limit) / $limit + 1;
      }
      else {
        $items_county = ($count_items - $count_items % $limit) / $limit;
      }
    }
    else {
      $items_county = 1;
    }
    ?>
    <script type="text/javascript">
      var items_county = <?php echo $items_county; ?>;
      function fm_page(x, y) {
        switch (y) {
          case 1:
            if (x >= items_county) {
              document.getElementById('page_number').value = items_county;
            }
            else {
              document.getElementById('page_number').value = x + 1;
            }
            break;
          case 2:
            document.getElementById('page_number').value = items_county;
            break;
          case -1:
            if (x == 1) {
              document.getElementById('page_number').value = 1;
            }
            else {
              document.getElementById('page_number').value = x - 1;
            }
            break;
          case -2:
            document.getElementById('page_number').value = 1;
            break;
          default:
            document.getElementById('page_number').value = 1;
        }
        fm_ajax_save('<?php echo $form_id; ?>');
      }
      function check_enter_key(e) {
        var key_code = (e.keyCode ? e.keyCode : e.which);
        if (key_code == 13) { /*Enter keycode*/
          if (jQuery('#current_page').val() >= items_county) {
            document.getElementById('page_number').value = items_county;
          }
          else {
            document.getElementById('page_number').value = jQuery('#current_page').val();
          }

          fm_ajax_save('<?php echo $form_id; ?>');
          return false;
        }
        return true;
      }
    </script>
    <div id="tablenav-pages" class="tablenav-pages">
      <span class="displaying-num">
        <?php
        if ($count_items != 0) {
          echo $count_items; ?> item<?php echo (($count_items == 1) ? '' : 's');
        }
        ?>
      </span>
      <?php
      if ($count_items > $limit) {
      $first_page = "first-page";
      $prev_page = "prev-page";
      $next_page = "next-page";
      $last_page = "last-page";
      if ($page_number == 1) {
        $first_page = "first-page disabled";
        $prev_page = "prev-page disabled";
        $next_page = "next-page";
        $last_page = "last-page";
      }
      if ($page_number >= $items_county) {
        $first_page = "first-page ";
        $prev_page = "prev-page";
        $next_page = "next-page disabled";
        $last_page = "last-page disabled";
      }
      ?>
      <span class="pagination-links">
        <a class="<?php echo $first_page; ?>" title="Go to the first page" onclick="fm_page(<?php echo $page_number; ?>,-2)">«</a>
        <a class="<?php echo $prev_page; ?>" title="Go to the previous page" onclick="fm_page(<?php echo $page_number; ?>,-1)">‹</a>
        <span class="paging-input">
          <span class="total-pages">
          <input class="current_page" id="current_page" name="current_page" value="<?php echo $page_number; ?>" onkeypress="return check_enter_key(event)" title="Go to the page" type="text" size="1" />
        </span> of
        <span class="total-pages">
            <?php echo $items_county; ?>
          </span>
        </span>
        <a class="<?php echo $next_page ?>" title="Go to the next page" onclick="fm_page(<?php echo $page_number; ?>,1)">›</a>
        <a class="<?php echo $last_page ?>" title="Go to the last page" onclick="fm_page(<?php echo $page_number; ?>,2)">»</a>
        <?php
        }
        ?>
      </span>
    </div>
    <input type="hidden" id="page_number" name="page_number" value="<?php echo ((isset($_POST['page_number'])) ? (int) $_POST['page_number'] : 1); ?>" />
    <input type="hidden" id="search_or_not" name="search_or_not" value="<?php echo ((isset($_POST['search_or_not'])) ? esc_html($_POST['search_or_not']) : ''); ?>"/>
    <?php
  }

  public static function fm_redirect($url) {
    $url = html_entity_decode(wp_nonce_url($url, WDFM()->nonce, WDFM()->nonce));
    ?>
    <script>
      window.location = "<?php echo $url; ?>";
    </script>
    <?php
    exit();
  }

  public static function get_google_fonts() {
    $google_fonts = array( 'Open Sans' => 'Open Sans', 'Oswald' => 'Oswald', 'Droid Sans' => 'Droid Sans', 'Lato' => 'Lato', 'Open Sans Condensed' => 'Open Sans Condensed', 'PT Sans' => 'PT Sans', 'Ubuntu' => 'Ubuntu', 'PT Sans Narrow' => 'PT Sans Narrow', 'Yanone Kaffeesatz' => 'Yanone Kaffeesatz', 'Roboto Condensed' => 'Roboto Condensed', 'Source Sans Pro' => 'Source Sans Pro', 'Nunito' => 'Nunito', 'Francois One' => 'Francois One', 'Roboto' => 'Roboto', 'Raleway' => 'Raleway', 'Arimo' => 'Arimo', 'Cuprum' => 'Cuprum', 'Play' => 'Play', 'Dosis' => 'Dosis', 'Abel' => 'Abel', 'Droid Serif' => 'Droid Serif', 'Arvo' => 'Arvo', 'Lora' => 'Lora', 'Rokkitt' => 'Rokkitt', 'PT Serif' => 'PT Serif', 'Bitter' => 'Bitter', 'Merriweather' => 'Merriweather', 'Vollkorn' => 'Vollkorn', 'Cantata One' => 'Cantata One', 'Kreon' => 'Kreon', 'Josefin Slab' => 'Josefin Slab', 'Playfair Display' => 'Playfair Display', 'Bree Serif' => 'Bree Serif', 'Crimson Text' => 'Crimson Text', 'Old Standard TT' => 'Old Standard TT', 'Sanchez' => 'Sanchez', 'Crete Round' => 'Crete Round', 'Cardo' => 'Cardo', 'Noticia Text' => 'Noticia Text', 'Judson' => 'Judson', 'Lobster' => 'Lobster', 'Unkempt' => 'Unkempt', 'Changa One' => 'Changa One', 'Special Elite' => 'Special Elite', 'Chewy' => 'Chewy', 'Comfortaa' => 'Comfortaa', 'Boogaloo' => 'Boogaloo', 'Fredoka One' => 'Fredoka One', 'Luckiest Guy' => 'Luckiest Guy', 'Cherry Cream Soda' => 'Cherry Cream Soda', 'Lobster Two' => 'Lobster Two', 'Righteous' => 'Righteous', 'Squada One' => 'Squada One', 'Black Ops One' => 'Black Ops One', 'Happy Monkey' => 'Happy Monkey', 'Passion One' => 'Passion One', 'Nova Square' => 'Nova Square', 'Metamorphous' => 'Metamorphous', 'Poiret One' => 'Poiret One', 'Bevan' => 'Bevan', 'Shadows Into Light' => 'Shadows Into Light', 'The Girl Next Door' => 'The Girl Next Door', 'Coming Soon' => 'Coming Soon', 'Dancing Script' => 'Dancing Script', 'Pacifico' => 'Pacifico', 'Crafty Girls' => 'Crafty Girls', 'Calligraffitti' => 'Calligraffitti', 'Rock Salt' => 'Rock Salt', 'Amatic SC' => 'Amatic SC', 'Leckerli One' => 'Leckerli One', 'Tangerine' => 'Tangerine', 'Reenie Beanie' => 'Reenie Beanie', 'Satisfy' => 'Satisfy', 'Gloria Hallelujah' => 'Gloria Hallelujah', 'Permanent Marker' => 'Permanent Marker', 'Covered By Your Grace' => 'Covered By Your Grace', 'Walter Turncoat' => 'Walter Turncoat', 'Patrick Hand' => 'Patrick Hand', 'Schoolbell' => 'Schoolbell', 'Indie Flower' => 'Indie Flower' );
    return $google_fonts;
  }

  public static function cleanData( &$str ) {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if ( strstr($str, '"') ) {
      $str = '"' . str_replace('"', '""', $str) . '"';
    }
  }

  /**
   * Get display options.
   *
   * @param $id
   *
   * @return array|null|object|stdClass|void
   */
  public static function display_options( $id ) {
    global $wpdb;
    $row = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'formmaker_display_options as display WHERE form_id = ' . (int) $id);
    if ( !$row ) {
      $row = new stdClass();
      $row->form_id = $id;
      $row->type = 'embedded';
      $row->scrollbox_loading_delay = 0;
      $row->popover_animate_effect = '';
      $row->popover_loading_delay = 0;
      $row->popover_frequency = 0;
      $row->topbar_position = 1;
      $row->topbar_remain_top = 1;
      $row->topbar_closing = 1;
      $row->topbar_hide_duration = 0;
      $row->scrollbox_position = 1;
      $row->scrollbox_trigger_point = 20;
      $row->scrollbox_hide_duration = 0;
      $row->scrollbox_auto_hide = 1;
      $row->hide_mobile = 0;
      $row->scrollbox_closing = 1;
      $row->scrollbox_minimize = 1;
      $row->scrollbox_minimize_text = '';
      $row->display_on = 'everything';
      $row->posts_include = '';
      $row->pages_include = '';
      $row->display_on_categories = '';
      $row->current_categories = '';
      $row->show_for_admin = 0;
    }

    return $row;
  }

  /**
   * Create js file.
   *
   * @param        $form_id
   * @param bool   $force_rewrite
   */
  public static function create_js( $form_id, $force_rewrite = FALSE ) {
    $wp_upload_dir = wp_upload_dir();
    $frontend_dir = '/form-maker-frontend/';
    if ( !is_dir($wp_upload_dir['basedir'] . $frontend_dir) ) {
      mkdir($wp_upload_dir['basedir'] . $frontend_dir);
      file_put_contents($wp_upload_dir['basedir'] . $frontend_dir . 'index.html', WDW_FM_Library::forbidden_template());
    }
    if ( !is_dir($wp_upload_dir['basedir'] . $frontend_dir . 'js') ) {
      mkdir($wp_upload_dir['basedir'] . $frontend_dir . 'js');
      file_put_contents($wp_upload_dir['basedir'] . $frontend_dir . 'js/index.html', WDW_FM_Library::forbidden_template());
    }
    $frontend_js = $wp_upload_dir['basedir'] . $frontend_dir . 'js/fm-script-' . $form_id . '.js';
    if ( !$force_rewrite && file_exists($frontend_js) ) {
      return;
    }
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'formmaker WHERE id="%d"', $form_id));
    if ( !$row ) {
      return;
    }

    clearstatcache();
    $jsfile = fopen($frontend_js, "w");
    $pattern = '/\/\/(.+)(\r\n|\r|\n)/';

    $row_display = WDW_FM_Library::display_options($form_id);
    $row->javascript = str_replace('function before_reset()', 'function before_reset' . $form_id . '()', $row->javascript);
    $row->javascript = str_replace('function before_load()', 'function before_load' . $form_id . '()', $row->javascript);
    $row->javascript = str_replace('function before_submit()', 'function before_submit' . $form_id . '()', $row->javascript);
    $check_js = '';
    $onsubmit_js = '';
    $onload_js = '';
    $currency_code = array(
      'USD',
      'EUR',
      'GBP',
      'JPY',
      'CAD',
      'MXN',
      'HKD',
      'HUF',
      'NOK',
      'NZD',
      'SGD',
      'SEK',
      'PLN',
      'AUD',
      'DKK',
      'CHF',
      'CZK',
      'ILS',
      'BRL',
      'TWD',
      'MYR',
      'PHP',
      'THB',
    );
    $currency_sign = array(
      '$',
      '&#8364;',
      '&#163;',
      '&#165;',
      'C$',
      'Mex$',
      'HK$',
      'Ft',
      'kr',
      'NZ$',
      'S$',
      'kr',
      'zl',
      'A$',
      'kr',
      'CHF',
      'Kc',
      '&#8362;',
      'R$',
      'NT$',
      'RM',
      '&#8369;',
      '&#xe3f;',
    );
    if ( $row->payment_currency ) {
      $form_currency = $currency_sign[array_search($row->payment_currency, $currency_code)];
    }
    else {
      $form_currency = '';
    }
    $form_paypal_tax = $row->tax;
    $stripe_enable = 0;
    $is_type = array();
    $id1s = array();
    $types = array();
    $labels = array();
    $paramss = array();
    $fields = explode('*:*new_field*:*', $row->form_fields);
    $fields = array_slice($fields, 0, count($fields) - 1);
    foreach ( $fields as $field ) {
      $temp = explode('*:*id*:*', $field);
      array_push($id1s, $temp[0]);
      $temp = explode('*:*type*:*', $temp[1]);
      array_push($types, $temp[0]);
      $temp = explode('*:*w_field_label*:*', $temp[1]);
      array_push($labels, $temp[0]);
      array_push($paramss, $temp[1]);
    }
    $labels_and_ids = array_combine($id1s, $types);
    $show_hide = array();
    $field_label = array();
    $all_any = array();
    $condition_params = array();
    $type_and_id = array();
    $condition_js = '';
    if ( $row->condition != "" ) {
      $conditions = explode('*:*new_condition*:*', $row->condition);
      $conditions = array_slice($conditions, 0, count($conditions) - 1);
      $count_of_conditions = count($conditions);
      foreach ( $conditions as $condition ) {
        $temp = explode('*:*show_hide*:*', $condition);
        array_push($show_hide, $temp[0]);
        $temp = explode('*:*field_label*:*', $temp[1]);
        array_push($field_label, $temp[0]);
        $temp = explode('*:*all_any*:*', $temp[1]);
        array_push($all_any, $temp[0]);
        array_push($condition_params, $temp[1]);
      }
      foreach ( $id1s as $id1s_key => $id1 ) {
        $type_and_id[$id1] = $types[$id1s_key];
      }
      for ( $k = 0; $k < $count_of_conditions; $k++ ) {
        if ( $show_hide[$k] ) {
          $display = 'removeAttr("style")';
          $display_none = 'css("display", "none")';
        }
        else {
          $display = 'css("display", "none")';
          $display_none = 'removeAttr("style")';
        }
        if ( $all_any[$k] == "and" ) {
          $or_and = '&&';
        }
        else {
          $or_and = '||';
        }
        if ( $condition_params[$k] ) {
          $cond_params = explode('*:*next_condition*:*', $condition_params[$k]);
          $cond_params = array_slice($cond_params, 0, count($cond_params) - 1);
          for ( $l = 0; $l < count($cond_params); $l++ ) {
            $params_value = explode('***', $cond_params[$l]);
            if ( !isset($type_and_id[$params_value[0]]) ) {
              unset($cond_params[$l]);
            }
          }
          $cond_params = array_values($cond_params);
          $if = '';
          $keyup = '';
          $change = '';
          $click = '';
          $blur = '';
          for ( $m = 0; $m < count($cond_params); $m++ ) {
            $params_value = explode('***', wp_specialchars_decode($cond_params[$m], 'single'));
            switch ( $type_and_id[$params_value[0]] ) {
              case "type_text":
              case "type_password":
              case "type_textarea":
              case "type_number":
              case "type_submitter_mail":
              case "type_spinner":
              case "type_paypal_price_new":
              case "type_date_new":
              case "type_phone_new":
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val().indexOf("' . $params_value[2] . '")' . $like_or_not . '-1 ';
                }
                else {
                  if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                    $params_value[2] = "";
                    $params_value[1] = $params_value[1] . "=";
                  }
                  $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ';
                }
                $keyup .= '#wdform_' . $params_value[0] . '_element' . $form_id . ', ';
                if ( $type_and_id[$params_value[0]] == "type_date_new" ) {
                  $change .= '#wdform_' . $params_value[0] . '_element' . $form_id . ', ';
                }
                if ( $type_and_id[$params_value[0]] == "type_spinner" ) {
                  $click .= '#wdform_' . $params_value[0] . '_element' . $form_id . ' ~ a, ';
                }
                if ( $type_and_id[$params_value[0]] == "type_phone_new" ) {
                  $blur = '#wdform_' . $params_value[0] . '_element' . $form_id . ', ';
                }
                break;
              case "type_name":
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $extended0 = '';
                  $extended1 = '';
                  $extended2 = '';
                  $extended3 = '';
                  $normal0 = '';
                  $normal1 = '';
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $name_fields = explode(' ', $params_value[2]);
                  if ( $name_fields[0] != '' ) {
                    $extended0 = 'jQuery("#wdform_' . $params_value[0] . '_element_title' . $form_id . '").val().indexOf("' . $name_fields[0] . '")' . $like_or_not . '-1 ';
                    $normal0 = 'jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val().indexOf("' . $name_fields[0] . '")' . $like_or_not . '-1 ';
                  }
                  if ( isset($name_fields[1]) && $name_fields[1] != '' ) {
                    $extended1 = 'jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val().indexOf("' . $name_fields[1] . '")' . $like_or_not . '-1 ';
                    $normal1 = 'jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val().indexOf("' . $name_fields[1] . '")' . $like_or_not . '-1 ';
                  }
                  if ( isset($name_fields[2]) && $name_fields[2] != '' ) {
                    $extended2 = 'jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val().indexOf("' . $name_fields[2] . '")' . $like_or_not . '-1 ';
                  }
                  if ( isset($name_fields[3]) && $name_fields[3] != '' ) {
                    $extended3 = 'jQuery("#wdform_' . $params_value[0] . '_element_middle' . $form_id . '").val().indexOf("' . $name_fields[3] . '")' . $like_or_not . '-1 ';
                  }
                  if ( isset($name_fields[3]) ) {
                    $extended = '';
                    $normal = '';
                    if ( $extended0 ) {
                      $extended = $extended0;
                      if ( $extended1 ) {
                        $extended .= ' && ' . $extended1;
                        if ( $extended2 ) {
                          $extended .= ' && ' . $extended2;
                        }
                        if ( $extended3 ) {
                          $extended .= ' && ' . $extended3;
                        }
                      }
                      else {
                        if ( $extended2 ) {
                          $extended .= ' && ' . $extended2;
                        }
                        if ( $extended3 ) {
                          $extended .= ' && ' . $extended3;
                        }
                      }
                    }
                    else {
                      if ( $extended1 ) {
                        $extended = $extended1;
                        if ( $extended2 ) {
                          $extended .= ' && ' . $extended2;
                        }
                        if ( $extended3 ) {
                          $extended .= ' && ' . $extended3;
                        }
                      }
                      else {
                        if ( $extended2 ) {
                          $extended = $extended2;
                          if ( $extended3 ) {
                            $extended .= ' && ' . $extended3;
                          }
                        }
                        else {
                          if ( $extended3 ) {
                            $extended = $extended3;
                          }
                        }
                      }
                    }
                    if ( $normal0 ) {
                      $normal = $normal0;
                      if ( $normal1 ) {
                        $normal .= ' && ' . $normal1;
                      }
                    }
                    else {
                      if ( $normal1 ) {
                        $normal = $normal1;
                      }
                    }
                  }
                  else {
                    if ( isset($name_fields[2]) ) {
                      $extended = "";
                      $normal = "";
                      if ( $extended0 ) {
                        $extended = $extended0;
                        if ( $extended1 ) {
                          $extended .= ' && ' . $extended1;
                        }
                        if ( $extended2 ) {
                          $extended .= ' && ' . $extended2;
                        }
                      }
                      else {
                        if ( $extended1 ) {
                          $extended = $extended1;
                          if ( $extended2 ) {
                            $extended .= ' && ' . $extended2;
                          }
                        }
                        else {
                          if ( $extended2 ) {
                            $extended = $extended2;
                          }
                        }
                      }
                      if ( $normal0 ) {
                        $normal = $normal0;
                        if ( $normal1 ) {
                          $normal .= ' && ' . $normal1;
                        }
                      }
                      else {
                        if ( $normal1 ) {
                          $normal = $normal1;
                        }
                      }
                    }
                    else {
                      if ( isset($name_fields[1]) ) {
                        $extended = '';
                        $normal = '';
                        if ( $extended0 ) {
                          if ( $extended1 ) {
                            $extended = $extended0 . ' && ' . $extended1;
                          }
                          else {
                            $extended = $extended0;
                          }
                        }
                        else {
                          if ( $extended1 ) {
                            $extended = $extended1;
                          }
                        }
                        if ( $normal0 ) {
                          if ( $normal1 ) {
                            $normal = $normal0 . ' && ' . $normal1;
                          }
                          else {
                            $normal = $normal0;
                          }
                        }
                        else {
                          if ( $normal1 ) {
                            $normal = $normal1;
                          }
                        }
                      }
                      else {
                        $extended = $extended0;
                        $normal = $normal0;
                      }
                    }
                  }
                  if ( $extended != "" && $normal != "" ) {
                    $if .= ' ((jQuery("#wdform_' . $params_value[0] . '_element_title' . $form_id . '").length != 0 || jQuery("#wdform_' . $params_value[0] . '_element_middle' . $form_id . '").length != 0) ?  ' . $extended . ' : ' . $normal . ') ';
                  }
                  else {
                    $if .= ' true';
                  }
                }
                else {
                  if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                    $name_and_or = $params_value[1] == "=" ? "&&" : "||";
                    $name_empty_or_not = $params_value[1] . "=";
                    $extended = ' (jQuery("#wdform_' . $params_value[0] . '_element_title' . $form_id . '").val()' . $name_empty_or_not . '"" ' . $name_and_or . ' jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $name_empty_or_not . '"" ' . $name_and_or . ' jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val()' . $name_empty_or_not . '"" ' . $name_and_or . ' jQuery("#wdform_' . $params_value[0] . '_element_middle' . $form_id . '").val()' . $name_empty_or_not . '"") ';
                    $normal = ' (jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $name_empty_or_not . '"" ' . $name_and_or . ' jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val()' . $name_empty_or_not . '"") ';
                    $if .= ' ((jQuery("#wdform_' . $params_value[0] . '_element_title' . $form_id . '").length != 0 || jQuery("#wdform_' . $params_value[0] . '_element_middle' . $form_id . '").length != 0) ?  ' . $extended . ' : ' . $normal . ') ';
                  }
                  else {
                    $extended0 = '';
                    $extended1 = '';
                    $extended2 = '';
                    $extended3 = '';
                    $normal0 = '';
                    $normal1 = '';
                    $name_fields = explode(' ', $params_value[2]);
                    if ( $name_fields[0] != '' ) {
                      $extended0 = 'jQuery("#wdform_' . $params_value[0] . '_element_title' . $form_id . '").val()' . $params_value[1] . '"' . $name_fields[0] . '"';
                      $normal0 = 'jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $params_value[1] . '"' . $name_fields[0] . '"';
                    }
                    if ( isset($name_fields[1]) && $name_fields[1] != '' ) {
                      $extended1 = 'jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $params_value[1] . '"' . $name_fields[1] . '"';
                      $normal1 = 'jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val()' . $params_value[1] . '"' . $name_fields[1] . '"';
                    }
                    if ( isset($name_fields[2]) && $name_fields[2] != '' ) {
                      $extended2 = 'jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val()' . $params_value[1] . '"' . $name_fields[2] . '"';
                    }
                    if ( isset($name_fields[3]) && $name_fields[3] != '' ) {
                      $extended3 = 'jQuery("#wdform_' . $params_value[0] . '_element_middle' . $form_id . '").val()' . $params_value[1] . '"' . $name_fields[3] . '"';
                    }
                    if ( isset($name_fields[3]) ) {
                      $extended = '';
                      $normal = '';
                      if ( $extended0 ) {
                        $extended = $extended0;
                        if ( $extended1 ) {
                          $extended .= ' && ' . $extended1;
                          if ( $extended2 ) {
                            $extended .= ' && ' . $extended2;
                          }
                          if ( $extended3 ) {
                            $extended .= ' && ' . $extended3;
                          }
                        }
                        else {
                          if ( $extended2 ) {
                            $extended .= ' && ' . $extended2;
                          }
                          if ( $extended3 ) {
                            $extended .= ' && ' . $extended3;
                          }
                        }
                      }
                      else {
                        if ( $extended1 ) {
                          $extended = $extended1;
                          if ( $extended2 ) {
                            $extended .= ' && ' . $extended2;
                          }
                          if ( $extended3 ) {
                            $extended .= ' && ' . $extended3;
                          }
                        }
                        else {
                          if ( $extended2 ) {
                            $extended = $extended2;
                            if ( $extended3 ) {
                              $extended .= ' && ' . $extended3;
                            }
                          }
                          else {
                            if ( $extended3 ) {
                              $extended = $extended3;
                            }
                          }
                        }
                      }
                      if ( $normal0 ) {
                        $normal = $normal0;
                        if ( $normal1 ) {
                          $normal .= ' && ' . $normal1;
                        }
                      }
                      else {
                        if ( $normal1 ) {
                          $normal = $normal1;
                        }
                      }
                    }
                    else {
                      if ( isset($name_fields[2]) ) {
                        $extended = "";
                        $normal = "";
                        if ( $extended0 ) {
                          $extended = $extended0;
                          if ( $extended1 ) {
                            $extended .= ' && ' . $extended1;
                          }
                          if ( $extended2 ) {
                            $extended .= ' && ' . $extended2;
                          }
                        }
                        else {
                          if ( $extended1 ) {
                            $extended = $extended1;
                            if ( $extended2 ) {
                              $extended .= ' && ' . $extended2;
                            }
                          }
                          else {
                            if ( $extended2 ) {
                              $extended = $extended2;
                            }
                          }
                        }
                        if ( $normal0 ) {
                          $normal = $normal0;
                          if ( $normal1 ) {
                            $normal .= ' && ' . $normal1;
                          }
                        }
                        else {
                          if ( $normal1 ) {
                            $normal = $normal1;
                          }
                        }
                      }
                      else {
                        if ( isset($name_fields[1]) ) {
                          $extended = '';
                          $normal = '';
                          if ( $extended0 ) {
                            if ( $extended1 ) {
                              $extended = $extended0 . ' && ' . $extended1;
                            }
                            else {
                              $extended = $extended0;
                            }
                          }
                          else {
                            if ( $extended1 ) {
                              $extended = $extended1;
                            }
                          }
                          if ( $normal0 ) {
                            if ( $normal1 ) {
                              $normal = $normal0 . ' && ' . $normal1;
                            }
                            else {
                              $normal = $normal0;
                            }
                          }
                          else {
                            if ( $normal1 ) {
                              $normal = $normal1;
                            }
                          }
                        }
                        else {
                          $extended = $extended0;
                          $normal = $normal0;
                        }
                      }
                    }
                    if ( $extended != "" && $normal != "" ) {
                      $if .= ' ((jQuery("#wdform_' . $params_value[0] . '_element_title' . $form_id . '").length != 0 || jQuery("#wdform_' . $params_value[0] . '_element_middle' . $form_id . '").length != 0) ?  ' . $extended . ' : ' . $normal . ') ';
                    }
                    else {
                      $if .= ' true';
                    }
                  }
                }
                $keyup .= '#wdform_' . $params_value[0] . '_element_title' . $form_id . ', #wdform_' . $params_value[0] . '_element_first' . $form_id . ', #wdform_' . $params_value[0] . '_element_last' . $form_id . ', #wdform_' . $params_value[0] . '_element_middle' . $form_id . ', ';
                break;
              case "type_phone":
                if ( $params_value[1] == "==" || $params_value[1] == "!=" ) {
                  $phone_fields = explode(' ', $params_value[2]);
                  if ( isset($phone_fields[1]) ) {
                    if ( $phone_fields[0] != '' && $phone_fields[1] != '' ) {
                      $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $params_value[1] . '"' . $phone_fields[0] . '" && jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val()' . $params_value[1] . '"' . $phone_fields[1] . '") ';
                    }
                    else {
                      if ( $phone_fields[0] == '' ) {
                        $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val()' . $params_value[1] . '"' . $phone_fields[1] . '") ';
                      }
                      else {
                        if ( $phone_fields[1] == '' ) {
                          $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $params_value[1] . '"' . $phone_fields[1] . '") ';
                        }
                      }
                    }
                  }
                  else {
                    $if .= ' jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ';
                  }
                }
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $phone_fields = explode(' ', $params_value[2]);
                  if ( isset($phone_fields[1]) ) {
                    if ( $phone_fields[0] != '' && $phone_fields[1] != '' ) {
                      $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val().indexOf("' . $phone_fields[0] . '")' . $like_or_not . '-1 && jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val().indexOf("' . $phone_fields[1] . '")' . $like_or_not . '-1)';
                    }
                    else {
                      if ( $phone_fields[0] == '' ) {
                        $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val().indexOf("' . $phone_fields[1] . '")' . $like_or_not . '-1) ';
                      }
                      else {
                        if ( $phone_fields[1] == '' ) {
                          $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val().indexOf("' . $phone_fields[0] . '")' . $like_or_not . '-1) ';
                        }
                      }
                    }
                  }
                  else {
                    $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val().indexOf("' . $phone_fields[0] . '")' . $like_or_not . '-1) ';
                  }
                }
                if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                  $params_value[2] = "";
                  $and_or_phone = ($params_value[1] == "=" ? "&&" : "||");
                  $params_value[1] = $params_value[1] . "=";
                  $if .= ' (jQuery("#wdform_' . $params_value[0] . '_element_first' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ' . $and_or_phone . ' jQuery("#wdform_' . $params_value[0] . '_element_last' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '") ';
                }
                $keyup .= '#wdform_' . $params_value[0] . '_element_first' . $form_id . ', #wdform_' . $params_value[0] . '_element_last' . $form_id . ', ';
                break;
              case "type_paypal_price":
                if ( $params_value[1] == "==" || $params_value[1] == "!=" ) {
                  $if .= ' (jQuery("#wdform_' . $params_value[0] . '_td_name_cents").attr("style") == "display: none;" ? jQuery("#wdform_' . $params_value[0] . '_element_dollars' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" : parseFloat(jQuery("#wdform_' . $params_value[0] . '_element_dollars' . $form_id . '").val()+"."+jQuery("#wdform_' . $params_value[0] . '_element_cents' . $form_id . '").val())' . $params_value[1] . 'parseFloat("' . str_replace('.0', '.', $params_value[2]) . '"))';
                }
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $if .= ' (jQuery("#wdform_' . $params_value[0] . '_td_name_cents").attr("style") == "display: none;" ? jQuery("#wdform_' . $params_value[0] . '_element_dollars' . $form_id . '").val().indexOf("' . $params_value[2] . '")' . $like_or_not . '-1 : (jQuery("#wdform_' . $params_value[0] . '_element_dollars' . $form_id . '").val()+"."+jQuery("#wdform_' . $params_value[0] . '_element_cents' . $form_id . '").val()).indexOf("' . str_replace('.0', '.', $params_value[2]) . '")' . $like_or_not . '-1) ';
                }
                if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                  $params_value[2] = "";
                  $and_or_price = ($params_value[1] == "=" ? "&&" : "||");
                  $params_value[1] = $params_value[1] . "=";
                  $if .= ' (jQuery("#wdform_' . $params_value[0] . '_td_name_cents").attr("style") == "display: none;" ? jQuery("#wdform_' . $params_value[0] . '_element_dollars' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" : (jQuery("#wdform_' . $params_value[0] . '_element_dollars' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ' . $and_or_price . ' jQuery("#wdform_' . $params_value[0] . '_element_cents' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '"))';
                }
                $keyup .= '#wdform_' . $params_value[0] . '_element_dollars' . $form_id . ', #wdform_' . $params_value[0] . '_element_cents' . $form_id . ', ';
                break;
              case "type_own_select":
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val().indexOf("' . $params_value[2] . '")' . $like_or_not . '-1 ';
                }
                else {
                  if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                    $params_value[2] = "";
                    $params_value[1] = $params_value[1] . "=";
                  }
                  $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ';
                }
                $change .= '#wdform_' . $params_value[0] . '_element' . $form_id . ', ';
                break;
              case "type_paypal_select":
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val().indexOf("' . $params_value[2] . '")' . $like_or_not . '-1 ';
                }
                else {
                  if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                    $params_value[2] = "";
                    $params_value[1] = $params_value[1] . "=";
                    $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '"';
                  }
                  else {
                    if ( strpos($params_value[2], '*:*value*:*') > -1 ) {
                      $and_or = $params_value[1] == "==" ? '&&' : '||';
                      $choise_and_value = explode("*:*value*:*", $params_value[2]);
                      $params_value[2] = $choise_and_value[1];
                      $params_label = $choise_and_value[0];
                      $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ' . $and_or . ' jQuery("div[wdid=' . $params_value[0] . '] select option:selected").text()' . $params_value[1] . '"' . $params_label . '" ';
                    }
                    else {
                      $if .= ' jQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ';
                    }
                  }
                }
                $change .= '#wdform_' . $params_value[0] . '_element' . $form_id . ', ';
                break;
              case "type_address":
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $if .= ' jQuery("#wdform_' . $params_value[0] . '_country' . $form_id . '").val().indexOf("' . $params_value[2] . '")' . $like_or_not . '-1 ';
                }
                else {
                  if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                    $params_value[2] = "";
                    $params_value[1] = $params_value[1] . "=";
                  }
                  $if .= ' jQuery("#wdform_' . $params_value[0] . '_country' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ';
                }
                $change .= '#wdform_' . $params_value[0] . '_country' . $form_id . ', ';
                break;
              case "type_country":
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $if .= ' wdformjQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val().indexOf("' . $params_value[2] . '")' . $like_or_not . '-1 ';
                }
                else {
                  if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                    $params_value[2] = "";
                    $params_value[1] = $params_value[1] . "=";
                  }
                  $if .= ' wdformjQuery("#wdform_' . $params_value[0] . '_element' . $form_id . '").val()' . $params_value[1] . '"' . $params_value[2] . '" ';
                }
                $change .= '#wdform_' . $params_value[0] . '_element' . $form_id . ', ';
                break;
              case "type_radio":
              case "type_paypal_radio":
              case "type_paypal_shipping":
                if ( $params_value[1] == "==" || $params_value[1] == "!=" ) {
                  if ( strpos($params_value[2], '*:*value*:*') > -1 ) {
                    $and_or = $params_value[1] == "==" ? '&&' : '||';
                    $choise_and_value = explode("*:*value*:*", $params_value[2]);
                    $params_value[2] = $choise_and_value[1];
                    $params_label = $choise_and_value[0];
                    $if .= ' jQuery("input[name^=\'wdform_' . $params_value[0] . '_element' . $form_id . '\']:checked").val()' . $params_value[1] . '"' . $params_value[2] . '" ' . $and_or . ' jQuery("input[name^=\'wdform_' . $params_value[0] . '_element' . $form_id . '\']:checked").attr("title")' . $params_value[1] . '"' . $params_label . '" ';
                  }
                  else {
                    $if .= ' jQuery("input[name^=\'wdform_' . $params_value[0] . '_element' . $form_id . '\']:checked").val()' . $params_value[1] . '"' . $params_value[2] . '" ';
                  }
                  $click .= 'div[wdid=' . $params_value[0] . '] input[type=\'radio\'], ';
                }
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $click .= 'div[wdid=' . $params_value[0] . '] input[type=\'radio\'], ';
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  $if .= ' (jQuery("input[name^=\'wdform_' . $params_value[0] . '_element' . $form_id . '\']:checked").val() ? (jQuery("input[name^=\'wdform_' . $params_value[0] . '_element' . $form_id . '\']:checked").attr("other") ? false  : (jQuery("input[name^=\'wdform_' . $params_value[0] . '_element' . $form_id . '\']:checked").val().indexOf("' . $params_value[2] . '")' . $like_or_not . '-1 )) : false) ';
                }
                if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                  $ckecked_or_no = ($params_value[1] == "=" ? "!" : "");
                  $if .= ' ' . $ckecked_or_no . 'jQuery("input[name^=\'wdform_' . $params_value[0] . '_element' . $form_id . '\']:checked").val()';
                  $click .= 'div[wdid=' . $params_value[0] . '] input[type=\'radio\'], ';
                }
                break;
              case "type_checkbox":
              case "type_paypal_checkbox":
                if ( $params_value[1] == "==" || $params_value[1] == "!=" ) {
                  if ( $params_value[2] ) {
                    $choises = explode('@@@', $params_value[2]);
                    $choises = array_slice($choises, 0, count($choises) - 1);
                    if ( $params_value[1] == "!=" ) {
                      $is = "!";
                    }
                    else {
                      $is = "";
                    }
                    foreach ( $choises as $key1 => $choise ) {
                      if ( $type_and_id[$params_value[0]] == "type_paypal_checkbox" ) {
                        $choise_and_value = explode("*:*value*:*", $choise);
                        $if .= ' ' . $is . '(jQuery("#form' . $form_id . ' div[wdid=' . $params_value[0] . '] input[value=\"' . $choise_and_value[1] . '\"]").is(":checked") && jQuery("div[wdid=' . $params_value[0] . '] input[title=\"' . $choise_and_value[0] . '\"]"))';
                      }
                      else {
                        $if .= ' ' . $is . 'jQuery("#form' . $form_id . ' div[wdid=' . $params_value[0] . '] input[value=\"' . $choise . '\"]").is(":checked") ';
                      }
                      if ( $key1 != count($choises) - 1 ) {
                        $if .= '&&';
                      }
                    }
                    $click .= 'div[wdid=' . $params_value[0] . '] input[type=\'checkbox\'], ';
                  }
                  else {
                    if ( $or_and == '&&' ) {
                      $if .= ' true';
                    }
                    else {
                      $if .= ' false';
                    }
                  }
                }
                if ( $params_value[1] == "%" || $params_value[1] == "!%" ) {
                  $like_or_not = ($params_value[1] == "%" ? ">" : "==");
                  if ( $params_value[2] ) {
                    $choises = explode('@@@', $params_value[2]);
                    $choises = array_slice($choises, 0, count($choises) - 1);
                    if ( $type_and_id[$params_value[0]] == "type_paypal_checkbox" ) {
                      foreach ( $choises as $key1 => $choise ) {
                        $choise_and_value = explode("*:*value*:*", $choise);
                        $if .= ' jQuery("div[wdid=' . $params_value[0] . ']  input[type=\"checkbox\"]:checked").serialize().indexOf("' . $choise_and_value[1] . '")' . $like_or_not . '-1 ';
                        if ( $key1 != count($choises) - 1 ) {
                          $if .= '&&';
                        }
                      }
                    }
                    else {
                      foreach ( $choises as $key1 => $choise ) {
                        $if .= ' jQuery("div[wdid=' . $params_value[0] . ']  input[type=\"checkbox\"]:checked").serialize().indexOf("' . str_replace(" ", "+", $choise) . '")' . $like_or_not . '-1 ';
                        if ( $key1 != count($choises) - 1 ) {
                          $if .= '&&';
                        }
                      }
                    }
                    $click .= 'div[wdid=' . $params_value[0] . '] input[type=\'checkbox\'], ';
                  }
                  else {
                    if ( $or_and == '&&' ) {
                      $if .= ' true';
                    }
                    else {
                      $if .= ' false';
                    }
                  }
                }
                if ( $params_value[1] == "=" || $params_value[1] == "!" ) {
                  $ckecked_or_no = ($params_value[1] == "=" ? "==" : ">");
                  $if .= ' jQuery("div[wdid=' . $params_value[0] . '] input[type=\"checkbox\"]:checked").length' . $ckecked_or_no . '0 ';
                  $click .= 'div[wdid=' . $params_value[0] . '] input[type=\'checkbox\'], ';
                }
                break;
            }
            if ( $m != count($cond_params) - 1 ) {
              $params_value_next = explode('***', $cond_params[$m + 1]);
              if ( isset($type_and_id[$params_value_next[0]]) ) {
                $if .= $or_and;
              }
            }
          }
          if ( $if ) {
            $condition_js .= '
  if(' . $if . ') {
    jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display . ';
  }
  else {
    jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display_none . ';
  }';
          }
          if ( $keyup ) {
            $condition_js .= '
  jQuery("' . substr($keyup, 0, -2) . '").keyup(function() {
    if(' . $if . ') {
      jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display . ';
    }
    else {
      jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display_none . ';
    }
  });';
          }
          if ( $change ) {
            $condition_js .= '
  jQuery("' . substr($change, 0, -2) . '").change(function() {
    if(' . $if . ') {
      jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display . ';
    }
    else {
      jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display_none . ';
    }
  });';
          }
          if ( $blur ) {
            $condition_js .= '
							jQuery("' . substr($blur, 0, -2) . '").blur(function() {
								if(' . $if . ')
									jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display . ';
								else
									jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display_none . '; });';
          }
          if ( $click ) {
            $condition_js .= '
  jQuery("' . substr($click, 0, -2) . '").click(function() {
    if(' . $if . ') {
      jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display . ';
    }
    else {
      jQuery("#form' . $form_id . ' div[wdid=' . $field_label[$k] . ']").' . $display_none . ';
    }
  });';
          }
        }
      }
    }
    $form = $row->form_front;
    $req_fields = array();
    $check_regExp_all = array();
    $check_paypal_price_min_max = array();
    $file_upload_check = array();
    $spinner_check = array();
    foreach ( $id1s as $id1s_key => $id1 ) {
      $label = $labels[$id1s_key];
      $type = $types[$id1s_key];
      $params = $paramss[$id1s_key];
      if ( strpos($form, '%' . $id1 . ' - ' . $label . '%') || strpos($form, '%' . $id1 . ' -' . $label . '%') ) {
        $required = FALSE;
        $param = array();
        $param['attributes'] = '';
        $is_type[$type] = TRUE;
        switch ( $type ) {
          case 'type_send_copy': {
            $params_names = array( 'w_field_label_size', 'w_field_label_pos', 'w_first_val', 'w_required' );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_first_val',
                'w_required',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $onsubmit_js .= 'if(!jQuery("#wdform_' . $id1 . '_element' . $form_id . '").is(":checked")) {
              jQuery("<input type=\"hidden\" name=\"wdform_send_copy_' . $form_id . '\" value=\"1\" />").appendTo("#form' . $form_id . '");}';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_text': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
            );
            $temp = $params;
            if ( strpos($temp, 'w_regExp_status') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_regExp_status',
                'w_regExp_value',
                'w_regExp_common',
                'w_regExp_arg',
                'w_regExp_alert',
                'w_unique',
              );
            }
            if ( strpos($temp, 'w_readonly') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_regExp_status',
                'w_regExp_value',
                'w_regExp_common',
                'w_regExp_arg',
                'w_regExp_alert',
                'w_unique',
                'w_readonly',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_regExp_status',
                'w_regExp_value',
                'w_regExp_common',
                'w_regExp_arg',
                'w_regExp_alert',
                'w_unique',
                'w_readonly',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $param['w_regExp_status'] = (isset($param['w_regExp_status']) ? $param['w_regExp_status'] : "no");
            $check_regExp = '';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            if ( $param['w_regExp_status'] == 'yes' ) {
              $check_regExp_all[$id1] = array(
                $param["w_regExp_value"],
                $param["w_regExp_arg"],
                $param["w_regExp_alert"],
              );
            }
            break;
          }
          case 'type_number': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_password': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_required',
                'w_unique',
                'w_class',
              );
            }
            if ( strpos($temp, 'w_verification') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_required',
                'w_unique',
                'w_class',
                'w_verification',
                'w_verification_label',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_textarea': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size_w',
              'w_size_h',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size_w',
                'w_size_h',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_phone': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_mini_labels',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_required',
                'w_unique',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_phone_new': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_hide_label',
              'w_size',
              'w_first_val',
              'w_top_country',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onload_js .= '
								jQuery("#wdform_' . $id1 . '_element' . $form_id . '").intlTelInput({
									nationalMode: false,
									preferredCountries: [ "' . $param["w_top_country"] . '" ],
									customPlaceholder: "Phone",
								});
							';
            break;
          }
          case 'type_name': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_first_val',
              'w_title',
              'w_mini_labels',
              'w_size',
              'w_name_format',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_name_fields') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_size',
                'w_name_format',
                'w_required',
                'w_unique',
                'w_class',
                'w_name_fields',
              );
            }
            if ( strpos($temp, 'w_autofill') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_size',
                'w_name_format',
                'w_required',
                'w_unique',
                'w_class',
                'w_name_fields',
                'w_autofill',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_first_val',
                'w_title',
                'w_mini_labels',
                'w_size',
                'w_name_format',
                'w_required',
                'w_unique',
                'w_class',
                'w_name_fields',
                'w_autofill',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_address': {
            $w_states = self::get_states();
            $w_state_options = '';
            foreach ( $w_states as $w_state ) {
              $w_state_options .= '<option value="' . $w_state . '">' . $w_state . '</option>';
            }
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_mini_labels',
              'w_disabled_fields',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_mini_labels',
                'w_disabled_fields',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $post = isset($_POST['wdform_' . ($id1 + 5) . '_country' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 5) . '_country' . $form_id])) : NULL;
            if ( isset($post) ) {
              $onload_js .= '
  jQuery("#wdform_' . $id1 . '_country' . $form_id . '").val("' . (isset($_POST['wdform_' . ($id1 + 5) . "_country" . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 5) . "_country" . $form_id])) : '') . '");';
            }
            if ( isset($w_disabled_fields[6]) && $w_disabled_fields[6] == 'yes' ) {
              $onload_js .= '
  jQuery("#wdform_' . $id1 . '_country' . $form_id . '").change(function() {
    if( jQuery(this).val() == "United States") {
      jQuery("#wdform_' . $id1 . '_state' . $form_id . '").parent().append("<select type=\"text\" id=\"wdform_' . $id1 . '_state' . $form_id . '\" name=\"wdform_' . ($id1 + 3) . '_state' . $form_id . '\" style=\"width: 100%;\" ' . $param['attributes'] . '>' . addslashes($w_state_options) . '</select><label class=\"mini_label\" id=\"' . $id1 . '_mini_label_state\">' . $w_mini_labels[3] . '</label>");
      jQuery("#wdform_' . $id1 . '_state' . $form_id . '").parent().children("input:first, label:first").remove();
    }
    else {
      if(jQuery("#wdform_' . $id1 . '_state' . $form_id . '").prop("tagName") == "SELECT") {
        jQuery("#wdform_' . $id1 . '_state' . $form_id . '").parent().append("<input type=\"text\" id=\"wdform_' . $id1 . '_state' . $form_id . '\" name=\"wdform_' . ($id1 + 3) . '_state' . $form_id . '\" value=\"' . (isset($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . ($id1 + 3) . '_state' . $form_id])) : "") . '\" style=\"width: 100%;\" ' . $param['attributes'] . '><label class=\"mini_label\">' . $w_mini_labels[3] . '</label>");
        jQuery("#wdform_' . $id1 . '_state' . $form_id . '").parent().children("select:first, label:first").remove();
      }
    }
  });';
            }
            break;
          }
          case 'type_submitter_mail': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_first_val',
              'w_title',
              'w_required',
              'w_unique',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_autofill') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
                'w_autofill',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
                'w_autofill',
              );
            }
            if ( strpos($temp, 'w_verification') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_first_val',
                'w_title',
                'w_required',
                'w_unique',
                'w_class',
                'w_verification',
                'w_verification_label',
                'w_verification_placeholder',
                'w_autofill',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_checkbox': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_flow',
              'w_choices',
              'w_choices_checked',
              'w_rowcol',
              'w_required',
              'w_randomize',
              'w_allow_other',
              'w_allow_other_num',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_field_option_pos') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_flow',
                'w_choices',
                'w_choices_checked',
                'w_rowcol',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_value_disabled',
                'w_choices_value',
                'w_choices_params',
                'w_class',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_hide_label',
                'w_flow',
                'w_choices',
                'w_choices_checked',
                'w_rowcol',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_value_disabled',
                'w_choices_value',
                'w_choices_params',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $post_value = isset($_POST["counter" . $form_id]) ? esc_html($_POST["counter" . $form_id]) : NULL;
            $is_other = FALSE;
            if ( isset($post_value) ) {
              if ( $param['w_allow_other'] == "yes" ) {
                $is_other = FALSE;
                $other_element = isset($_POST['wdform_' . $id1 . "_other_input" . $form_id]) ? esc_html($_POST['wdform_' . $id1 . "_other_input" . $form_id]) : NULL;
                if ( isset($other_element) ) {
                  $is_other = TRUE;
                }
              }
            }
            else {
              $is_other = ($param['w_allow_other'] == "yes" && $param['w_choices_checked'][$param['w_allow_other_num']] == 'true');
            }
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            if ( $is_other ) {
              $onload_js .= '
  show_other_input("wdform_' . $id1 . '","' . $form_id . '"); jQuery("#wdform_' . $id1 . '_other_input' . $form_id . '").val("' . (isset($_POST['wdform_' . $id1 . "_other_input" . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . "_other_input" . $form_id])) : '') . '");';
            }
            if ( $param['w_randomize'] == 'yes' ) {
              $onload_js .= '
  jQuery("#form' . $form_id . ' div[wdid=' . $id1 . '] .wdform-element-section> div").shuffle();';
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_allow_other' . $form_id . '\" value=\"' . $param['w_allow_other'] . '\" />").appendTo("#form' . $form_id . '");
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_allow_other_num' . $form_id . '\" value=\"' . $param['w_allow_other_num'] . '\" />").appendTo("#form' . $form_id . '");';
            break;
          }
          case 'type_radio': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_flow',
              'w_choices',
              'w_choices_checked',
              'w_rowcol',
              'w_required',
              'w_randomize',
              'w_allow_other',
              'w_allow_other_num',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_field_option_pos') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_flow',
                'w_choices',
                'w_choices_checked',
                'w_rowcol',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_value_disabled',
                'w_choices_value',
                'w_choices_params',
                'w_class',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_hide_label',
                'w_flow',
                'w_choices',
                'w_choices_checked',
                'w_rowcol',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_value_disabled',
                'w_choices_value',
                'w_choices_params',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $post_value = isset($_POST["counter" . $form_id]) ? esc_html($_POST["counter" . $form_id]) : NULL;
            $is_other = FALSE;
            if ( isset($post_value) ) {
              if ( $param['w_allow_other'] == "yes" ) {
                $is_other = FALSE;
                $other_element = isset($_POST['wdform_' . $id1 . "_other_input" . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . "_other_input" . $form_id])) : "";
                if ( isset($other_element) ) {
                  $is_other = TRUE;
                }
              }
            }
            else {
              $is_other = ($param['w_allow_other'] == "yes" && $param['w_choices_checked'][$param['w_allow_other_num']] == 'true');
            }
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            if ( $is_other ) {
              $onload_js .= '
  show_other_input("wdform_' . $id1 . '","' . $form_id . '"); jQuery("#wdform_' . $id1 . '_other_input' . $form_id . '").val("' . (isset($_POST['wdform_' . $id1 . "_other_input" . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . "_other_input" . $form_id])) : '') . '");';
            }
            if ( $param['w_randomize'] == 'yes' ) {
              $onload_js .= '
  jQuery("#form' . $form_id . ' div[wdid=' . $id1 . '] .wdform-element-section> div").shuffle();';
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_allow_other' . $form_id . '\" value=\"' . $param['w_allow_other'] . '\" />").appendTo("#form' . $form_id . '");
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_allow_other_num' . $form_id . '\" value=\"' . $param['w_allow_other_num'] . '\" />").appendTo("#form' . $form_id . '");';
            break;
          }
          case 'type_own_select': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_choices',
              'w_choices_checked',
              'w_choices_disabled',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_choices_value') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_choices',
                'w_choices_checked',
                'w_choices_disabled',
                'w_required',
                'w_value_disabled',
                'w_choices_value',
                'w_choices_params',
                'w_class',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_choices',
                'w_choices_checked',
                'w_choices_disabled',
                'w_required',
                'w_value_disabled',
                'w_choices_value',
                'w_choices_params',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_country': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_countries',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_countries',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_time': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_time_type',
              'w_am_pm',
              'w_sec',
              'w_hh',
              'w_mm',
              'w_ss',
              'w_mini_labels',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_time_type',
                'w_am_pm',
                'w_sec',
                'w_hh',
                'w_mm',
                'w_ss',
                'w_mini_labels',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_date': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_date',
              'w_required',
              'w_class',
              'w_format',
              'w_but_val',
            );
            $temp = $params;
            if ( strpos($temp, 'w_disable_past_days') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_date',
                'w_required',
                'w_class',
                'w_format',
                'w_but_val',
                'w_disable_past_days',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $param['w_disable_past_days'] = isset($param['w_disable_past_days']) ? $param['w_disable_past_days'] : 'no';
            $disable_past_days = $param['w_disable_past_days'] == 'yes' ? 'true' : 'false';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            if ( $disable_past_days == 'true' ) {
              $check_js .= '
  if( Date.parse(jQuery("#wdform_' . $id1 . '_element' . $form_id . '").val() + " 23:59:59") < fm_currentDate.getTime() ) {
    alert("' . __('You cannot select former dates. Choose a date starting from the current one.', WDFM()->prefix) . '");
    return false;
  }';
            }
            $date_format= str_replace('%', '', $param['w_format']);

            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_date_format' . $form_id . '\" value=\"' . $date_format . '\" />").appendTo("#form' . $form_id . '");';
            break;
          }
          case 'type_date_new': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_date',
              'w_required',
              'w_show_image',
              'w_class',
              'w_format',
              'w_start_day',
              'w_default_date',
              'w_min_date',
              'w_max_date',
              'w_invalid_dates',
              'w_show_days',
              'w_hide_time',
              'w_but_val',
              'w_disable_past_days',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_date',
                'w_required',
                'w_show_image',
                'w_class',
                'w_format',
                'w_start_day',
                'w_default_date',
                'w_min_date',
                'w_max_date',
                'w_invalid_dates',
                'w_show_days',
                'w_hide_time',
                'w_but_val',
                'w_disable_past_days',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $default_date = (isset($_POST['wdform_' . $id1 . "_element" . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . "_element" . $form_id])) : $param['w_default_date']);
            $w_show_week_days = explode('***', $param['w_show_days']);
            $w_hide_sunday = $w_show_week_days[0] == 'yes' ? '' : ' && day != 0';
            $w_hide_monday = $w_show_week_days[1] == 'yes' ? '' : ' && day != 1';
            $w_hide_tuesday = $w_show_week_days[2] == 'yes' ? '' : ' && day != 2';
            $w_hide_wednesday = $w_show_week_days[3] == 'yes' ? '' : ' && day != 3';
            $w_hide_thursday = $w_show_week_days[4] == 'yes' ? '' : ' && day != 4';
            $w_hide_friday = $w_show_week_days[5] == 'yes' ? '' : ' && day != 5';
            $w_hide_saturday = $w_show_week_days[6] == 'yes' ? '' : '&& day != 6';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onload_js .= '
  jQuery("#button_calendar_' . $id1 . ', #fm-calendar-' . $id1 . '").click(function() {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '").datepicker("show");
  });
  jQuery("#wdform_' . $id1 . '_element' . $form_id . '").datepicker({
    dateFormat: format_date,
    minDate: "' . $param['w_min_date'] . '",
    maxDate: "' . $param['w_max_date'] . '",
    changeMonth: true,
    changeYear: true,
    yearRange: "-100:+50",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: "' . $param['w_start_day'] . '",
    beforeShow: function(input, inst) {
      jQuery("#ui-datepicker-div").addClass("fm_datepicker");
    },
    beforeShowDay: function(date) {
      var invalid_dates = "' . $param["w_invalid_dates"] . '";
      var invalid_dates_finish = [];
      var invalid_dates_start = invalid_dates.split(",");
      var invalid_date_range =[];
      for(var i = 0; i < invalid_dates_start.length; i++ ) {
        invalid_dates_start[i] = invalid_dates_start[i].trim();
        if(invalid_dates_start[i].length < 11 || invalid_dates_start[i].indexOf("-") == -1){
          invalid_dates_finish.push(invalid_dates_start[i]);
        }
        else{
          if(invalid_dates_start[i].indexOf("-") > 4) {
            invalid_date_range.push(invalid_dates_start[i].split("-"));
          }
          else {
            var invalid_date_array = invalid_dates_start[i].split("-");
            var start_invalid_day = invalid_date_array[0] + "-" + invalid_date_array[1] + "-" + invalid_date_array[2];
            var end_invalid_day = invalid_date_array[3] + "-" + invalid_date_array[4] + "-" + invalid_date_array[5];
            invalid_date_range.push([start_invalid_day, end_invalid_day]);
          }
        }
      }
      jQuery.each(invalid_date_range, function( index, value ) {
        for(var d = new Date(value[0]); d <= new Date(value[1]); d.setDate(d.getDate() + 1)) {
          invalid_dates_finish.push(jQuery.datepicker.formatDate(format_date, d));
        }
      });
      var string_days = jQuery.datepicker.formatDate(format_date, date);
      var day = date.getDay();
      return [ invalid_dates_finish.indexOf(string_days) == -1 ' . $w_hide_sunday . $w_hide_monday . $w_hide_tuesday . $w_hide_wednesday . $w_hide_thursday . $w_hide_friday . $w_hide_saturday . '];
    }
  });
  var default_date;
  var date_value = jQuery("#wdform_' . $id1 . '_element' . $form_id . '").val();
  (date_value != "") ? default_date = date_value : default_date = "' . $default_date . '";
  var format_date = "' . $param['w_format'] . '";
  jQuery("#wdform_' . $id1 . '_element' . $form_id . '").datepicker("option", "dateFormat", format_date);
  if(default_date == "today") {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '").datepicker("setDate", new Date());
  }
  else if (default_date.indexOf("d") == -1 && default_date.indexOf("m") == -1 && default_date.indexOf("y") == -1 && default_date.indexOf("w") == -1) {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '").datepicker("setDate", default_date);
  }
  else {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '").datepicker("setDate", default_date);
  }';
            break;
          }
          case 'type_date_range': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_date',
              'w_required',
              'w_show_image',
              'w_class',
              'w_format',
              'w_start_day',
              'w_default_date_start',
              'w_default_date_end',
              'w_min_date',
              'w_max_date',
              'w_invalid_dates',
              'w_show_days',
              'w_hide_time',
              'w_but_val',
              'w_disable_past_days',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_date',
                'w_required',
                'w_show_image',
                'w_class',
                'w_format',
                'w_start_day',
                'w_default_date_start',
                'w_default_date_end',
                'w_min_date',
                'w_max_date',
                'w_invalid_dates',
                'w_show_days',
                'w_hide_time',
                'w_but_val',
                'w_disable_past_days',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $param['w_default_date_start'] == 'today' ) {
              $default_date_start = 'new Date()';
            }
            else {
              $default_date_start = $param['w_default_date_start'];
            }
            $w_show_week_days = explode('***', $param['w_show_days']);
            $w_hide_sunday = $w_show_week_days[0] == 'yes' ? '' : ' && day != 0';
            $w_hide_monday = $w_show_week_days[1] == 'yes' ? '' : ' && day != 1';
            $w_hide_tuesday = $w_show_week_days[2] == 'yes' ? '' : ' && day != 2';
            $w_hide_wednesday = $w_show_week_days[3] == 'yes' ? '' : ' && day != 3';
            $w_hide_thursday = $w_show_week_days[4] == 'yes' ? '' : ' && day != 4';
            $w_hide_friday = $w_show_week_days[5] == 'yes' ? '' : ' && day != 5';
            $w_hide_saturday = $w_show_week_days[6] == 'yes' ? '' : '&& day != 6';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onload_js .= '
  jQuery("#button_calendar_' . $id1 . '0").click(function() {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("show");
  });
  jQuery("#button_calendar_' . $id1 . '1").click(function() {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("show");
  });
  jQuery("input[id^=\'wdform_' . $id1 . '_element' . $form_id . '\']").datepicker({
    dateFormat: "mm/dd/yy",
    minDate: "' . $param['w_min_date'] . '",
    maxDate: "' . $param['w_max_date'] . '",
    changeMonth: true,
    changeYear: true,
    yearRange: "-100:+50",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: "' . $param['w_start_day'] . '",
    beforeShow: function(input, inst) {
      jQuery("#ui-datepicker-div").addClass("fm_datepicker");
    },
    beforeShowDay: function(date){
      var invalid_dates = "' . $param["w_invalid_dates"] . '";
      var invalid_dates_finish = [];
      var invalid_dates_start = invalid_dates.split(",");
      var invalid_date_range =[];
      for(var i = 0; i < invalid_dates_start.length; i++ ){
        invalid_dates_start[i] = invalid_dates_start[i].trim();
        if(invalid_dates_start[i].length < 11 || invalid_dates_start[i].indexOf("-") == -1) {
          invalid_dates_finish.push(invalid_dates_start[i]);
        }
        else {
          if(invalid_dates_start[i].indexOf("-") > 4) {
            invalid_date_range.push(invalid_dates_start[i].split("-"));
          }
          else {
            var invalid_date_array = invalid_dates_start[i].split("-");
            var start_invalid_day = invalid_date_array[0] + "-" + invalid_date_array[1] + "-" + invalid_date_array[2];
            var end_invalid_day = invalid_date_array[3] + "-" + invalid_date_array[4] + "-" + invalid_date_array[5];
            invalid_date_range.push([start_invalid_day, end_invalid_day]);
          }
        }
      }
      jQuery.each(invalid_date_range, function( index, value ) {
        for(var d = new Date(value[0]); d <= new Date(value[1]); d.setDate(d.getDate() + 1)) {
          invalid_dates_finish.push(jQuery.datepicker.formatDate("mm/dd/yy", d));
        }
      });
      var string_days = jQuery.datepicker.formatDate("mm/dd/yy", date);
      var day = date.getDay();
      return [ invalid_dates_finish.indexOf(string_days) == -1 ' . $w_hide_sunday . $w_hide_monday . $w_hide_tuesday . $w_hide_wednesday . $w_hide_thursday . $w_hide_friday . $w_hide_saturday . '];
    }
  });
  var default_date_start;
  var date_start_value = jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").val();
  (date_start_value != "") ? default_date_start = date_start_value : default_date_start = "' . $param['w_default_date_start'] . '";
  var format_date = "' . $param['w_format'] . '";
  jQuery("#wdform_' . $id1 . '_element' . $form_id . '").datepicker("option", "dateFormat", format_date);
  if(default_date_start =="today") {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("setDate", new Date());
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("option", "minDate", new Date());
  }
  else if(default_date_start.indexOf("d") == -1 && default_date_start.indexOf("m") == -1 && default_date_start.indexOf("y") == -1 && default_date_start.indexOf("w") == -1) {
    if(default_date_start !== "") {
      default_date_start = jQuery.datepicker.formatDate(format_date, new Date(default_date_start));
      jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("setDate", default_date_start);
      jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("option", "minDate", default_date_start);
    }
    else {
      jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("setDate", default_date_start);
    }
  }
  else {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("setDate", default_date_start);
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("option", "minDate", default_date_start);
  }
  var default_date_end;
  var date_end_value = jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").val();
  (date_end_value != "") ? default_date_end = date_end_value : default_date_end = "' . $param['w_default_date_end'] . '";
  var format_date = "' . $param['w_format'] . '";
  jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("option", "dateFormat", format_date);
  jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("option", "dateFormat", format_date);
  if(default_date_end =="today") {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("setDate", new Date());
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("option", "maxDate", new Date());
  }
  else if(default_date_end.indexOf("d") == -1 && default_date_end.indexOf("m") == -1 && default_date_end.indexOf("y") == -1 && default_date_end.indexOf("w") == -1) {
    if(default_date_end !== "") {
      default_date_end = jQuery.datepicker.formatDate(format_date, new Date(default_date_end));
      jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("setDate", default_date_end);
      jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("option", "maxDate", default_date_end);
    }
    else {
      jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("setDate", default_date_end);
    }
  }
  else {
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '1").datepicker("setDate", default_date_end);
    jQuery("#wdform_' . $id1 . '_element' . $form_id . '0").datepicker("option", "maxDate", default_date_end);
  }';
            break;
          }
          case 'type_date_fields': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_day',
              'w_month',
              'w_year',
              'w_day_type',
              'w_month_type',
              'w_year_type',
              'w_day_label',
              'w_month_label',
              'w_year_label',
              'w_day_size',
              'w_month_size',
              'w_year_size',
              'w_required',
              'w_class',
              'w_from',
              'w_to',
              'w_divider',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_day',
                'w_month',
                'w_year',
                'w_day_type',
                'w_month_type',
                'w_year_type',
                'w_day_label',
                'w_month_label',
                'w_year_label',
                'w_day_size',
                'w_month_size',
                'w_year_size',
                'w_required',
                'w_class',
                'w_from',
                'w_to',
                'w_divider',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $param['w_day_type'] != "SELECT" ) {
              $w_day_type = '<input type="text" value="' . $param['w_day'] . '" id="wdform_' . $id1 . '_day' . $form_id . '" name="wdform_' . $id1 . '_day' . $form_id . '" style="width: ' . $param['w_day_size'] . 'px;" ' . $param['attributes'] . '>';
              $onload_js .= '
  jQuery("#wdform_' . $id1 . '_day' . $form_id . '").blur(function() {if (jQuery(this).val() == "0") jQuery(this).val(""); else add_0(this)});';
            }
            if ( $param['w_month_type'] != "SELECT" ) {
              $onload_js .= '
  jQuery("#wdform_' . $id1 . '_month' . $form_id . '").blur(function() {if (jQuery(this).val() == "0") jQuery(this).val(""); else add_0(this)});';
            }
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_file_upload': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_destination',
              'w_extension',
              'w_max_size',
              'w_required',
              'w_multiple',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_destination',
                'w_extension',
                'w_max_size',
                'w_required',
                'w_multiple',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              if ( isset($temp[1]) ) {
                $temp = $temp[1];
              }
              else {
                $temp = '';
              }
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $file_upload_check[$id1] = $param['w_extension'];
            if ( WDFM()->is_demo ) {
              $onsubmit_js .= 'alert( "You can\'t upload file in demo.");';
            }
            break;
          }
          case 'type_captcha': {
            $params_names = array( 'w_field_label_size', 'w_field_label_pos', 'w_digit', 'w_class' );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array( 'w_field_label_size', 'w_field_label_pos', 'w_hide_label', 'w_digit', 'w_class' );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $onload_js .= '
  jQuery("#wd_captcha' . $form_id . '").click(function() {captcha_refresh("wd_captcha","' . $form_id . '")});';
            $onload_js .= '
  jQuery("#_element_refresh' . $form_id . '").click(function() {captcha_refresh("wd_captcha","' . $form_id . '")});';
            array_push($req_fields, $id1);
            $onload_js .= '
  captcha_refresh("wd_captcha", "' . $form_id . '");';
            break;
          }
          case 'type_arithmetic_captcha': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_count',
              'w_operations',
              'w_class',
              'w_input_size',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_count',
                'w_operations',
                'w_class',
                'w_input_size',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $onload_js .= '
  jQuery("#wd_arithmetic_captcha' . $form_id . '").click(function() { captcha_refresh("wd_arithmetic_captcha","' . $form_id . '") });';
            $onload_js .= '
  jQuery("#_element_refresh' . $form_id . '").click(function() {captcha_refresh("wd_arithmetic_captcha","' . $form_id . '")});';
            array_push($req_fields, $id1);
            $onload_js .= '
  captcha_refresh("wd_arithmetic_captcha", "' . $form_id . '");';
            break;
          }
          case 'type_mark_map': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_center_x',
              'w_center_y',
              'w_long',
              'w_lat',
              'w_zoom',
              'w_width',
              'w_height',
              'w_info',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_center_x',
                'w_center_y',
                'w_long',
                'w_lat',
                'w_zoom',
                'w_width',
                'w_height',
                'w_info',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $onload_js .= '
  if_gmap_init("wdform_' . $id1 . '", ' . $form_id . ');';
            $onload_js .= '
  add_marker_on_map("wdform_' . $id1 . '", 0, "' . $param['w_long'] . '", "' . $param['w_lat'] . '", "' . str_replace(array(
                                                                                                                                                  "\r\n",
                                                                                                                                                  "\n",
                                                                                                                                                  "\r",
                                                                                                                                                ), '<br />', $param['w_info']) . '", ' . $form_id . ',true);';
            break;
          }
          case 'type_map': {
            $params_names = array(
              'w_center_x',
              'w_center_y',
              'w_long',
              'w_lat',
              'w_zoom',
              'w_width',
              'w_height',
              'w_info',
              'w_class',
            );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $param['w_long'] = explode('***', $param['w_long']);
            $param['w_lat'] = explode('***', $param['w_lat']);
            $param['w_info'] = explode('***', $param['w_info']);
            foreach ( $param['w_long'] as $key => $w_long ) {
              $onload_js .= '
  add_marker_on_map("wdform_' . $id1 . '",' . $key . ', "' . $w_long . '", "' . $param['w_lat'][$key] . '", "' . str_replace(array(
                                                                                                                                                           "\r\n",
                                                                                                                                                           "\n",
                                                                                                                                                           "\r",
                                                                                                                                                         ), '<br />', $param['w_info'][$key]) . '", ' . $form_id . ',false);';
            }
            break;
          }
          case 'type_paypal_price': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_first_val',
              'w_title',
              'w_mini_labels',
              'w_size',
              'w_required',
              'w_hide_cents',
              'w_class',
              'w_range_min',
              'w_range_max',
            );
            $temp = $params;
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $onload_js .= '
  jQuery("#wdform_' . $id1 . '_element_cents' . $form_id . '").blur(function() {add_0(this)});';
            $onload_js .= '
  jQuery("#wdform_' . $id1 . '_element_cents' . $form_id . '").keypress(function(event) {return check_isnum_interval(event,this,0,99)});';
            if ( $required ) {
              $check_js .= '
  if(x.find(jQuery("div[wdid=' . $id1 . ']")).length != 0 && x.find(jQuery("div[wdid=' . $id1 . ']")).css("display") != "none") {
    if(jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").val() == "' . $w_title[0] . '" || jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").val() == "") {
      alert("' . addslashes($label . ' ' . __('field is required.', WDFM()->prefix)) . '");
      old_bg=x.find(jQuery("div[wdid=' . $id1 . ']")).css("background-color");
      x.find(jQuery("div[wdid=' . $id1 . ']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
      jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").focus();
      return false;
    }
  }';
            }
            $check_js .= '
  if(x.find(jQuery("div[wdid=' . $id1 . ']")).length != 0 && x.find(jQuery("div[wdid=' . $id1 . ']")).css("display") != "none") {
    dollars=0;
    cents=0;
    if(jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").val() != "' . $w_title[0] . '" || jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").val()) {
      dollars =jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").val();
    }
    if(jQuery("#wdform_' . $id1 . '_element_cents' . $form_id . '").val() != "' . $w_title[1] . '" || jQuery("#wdform_' . $id1 . '_element_cents' . $form_id . '").val()) {
      cents =jQuery("#wdform_' . $id1 . '_element_cents' . $form_id . '").val();
    }
    var price=dollars+"."+cents;
    if(isNaN(price)) {
      alert("Invalid value of number field");
      old_bg=x.find(jQuery("div[wdid=' . $id1 . ']")).css("background-color");
      x.find(jQuery("div[wdid=' . $id1 . ']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
      jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").focus();
      return false;
    }
    var range_min=' . ($param['w_range_min'] ? $param['w_range_min'] : 0) . ';
    var range_max=' . ($param['w_range_max'] ? $param['w_range_max'] : -1) . ';
    if(' . ($required ? 'true' : 'false') . ' || jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").val() != "' . $w_title[0] . '" || jQuery("#wdform_' . $id1 . '_element_cents' . $form_id . '").val() != "' . $w_title[1] . '") {
      if((range_max!=-1 && parseFloat(price)>range_max) || parseFloat(price)<range_min) {
        alert("' . addslashes((__('The', WDFM()->prefix)) . $label . (__('value must be between', WDFM()->prefix)) . ($param['w_range_min'] ? $param['w_range_min'] : 0) . '-' . ($param['w_range_max'] ? $param['w_range_max'] : "any")) . '");
        old_bg=x.find(jQuery("div[wdid=' . $id1 . ']")).css("background-color");
        x.find(jQuery("div[wdid=' . $id1 . ']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
        jQuery("#wdform_' . $id1 . '_element_dollars' . $form_id . '").focus();
        return false;
      }
    }
  }';
            break;
          }
          case 'type_paypal_price_new': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_first_val',
              'w_title',
              'w_size',
              'w_required',
              'w_class',
              'w_range_min',
              'w_range_max',
              'w_readonly',
              'w_currency',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_first_val',
                'w_title',
                'w_size',
                'w_required',
                'w_class',
                'w_range_min',
                'w_range_max',
                'w_readonly',
                'w_currency',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $check_paypal_price_min_max[$id1] = array(
              $label,
              $param['w_title'],
              $required,
              $param['w_range_min'],
              $param['w_range_max'],
            );
            break;
          }
          case 'type_paypal_select': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_size',
              'w_choices',
              'w_choices_price',
              'w_choices_checked',
              'w_choices_disabled',
              'w_required',
              'w_quantity',
              'w_quantity_value',
              'w_class',
              'w_property',
              'w_property_values',
            );
            $temp = $params;
            if ( strpos($temp, 'w_choices_params') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_size',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_choices_disabled',
                'w_required',
                'w_quantity',
                'w_quantity_value',
                'w_choices_params',
                'w_class',
                'w_property',
                'w_property_values',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_size',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_choices_disabled',
                'w_required',
                'w_quantity',
                'w_quantity_value',
                'w_choices_params',
                'w_class',
                'w_property',
                'w_property_values',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $param['w_property'] = explode('***', $param['w_property']);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_label' . $form_id . '\" />").val(jQuery("#wdform_' . $id1 . '_element' . $form_id . ' option:selected").text()).appendTo("#form' . $form_id . '");';
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_quantity_label' . $form_id . '\" />").val("' . (__("Quantity", WDFM()->prefix)) . '").appendTo("#form' . $form_id . '");';
            foreach ( $param['w_property'] as $key => $property ) {
              $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_property_label' . $form_id . $key . '\" />").val("' . $property . '").appendTo("#form' . $form_id . '");';
            }
            break;
          }
          case 'type_paypal_checkbox': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_flow',
              'w_choices',
              'w_choices_price',
              'w_choices_checked',
              'w_required',
              'w_randomize',
              'w_allow_other',
              'w_allow_other_num',
              'w_class',
              'w_property',
              'w_property_values',
              'w_quantity',
              'w_quantity_value',
            );
            $temp = $params;
            if ( strpos($temp, 'w_field_option_pos') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_flow',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_choices_params',
                'w_class',
                'w_property',
                'w_property_values',
                'w_quantity',
                'w_quantity_value',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_hide_label',
                'w_flow',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_choices_params',
                'w_class',
                'w_property',
                'w_property_values',
                'w_quantity',
                'w_quantity_value',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $param['w_property'] = explode('***', $param['w_property']);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_label' . $form_id . '\" />").val((jQuery("#wdform_' . $id1 . '_element' . $form_id . ' input:checked").length != 0) ? jQuery("#wdform_' . $id1 . '_element' . $form_id . ' input:checked").attr("id").replace("element", "elementlabel_") : "").appendTo("#form' . $form_id . '");';
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_quantity_label' . $form_id . '\" />").val("' . (__("Quantity", WDFM()->prefix)) . '").appendTo("#form' . $form_id . '");';
            foreach ( $param['w_property'] as $key => $property ) {
              $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_property_label' . $form_id . $key . '\" />").val("' . $property . '").appendTo("#form' . $form_id . '");';
            }
            break;
          }
          case 'type_paypal_radio': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_flow',
              'w_choices',
              'w_choices_price',
              'w_choices_checked',
              'w_required',
              'w_randomize',
              'w_allow_other',
              'w_allow_other_num',
              'w_class',
              'w_property',
              'w_property_values',
              'w_quantity',
              'w_quantity_value',
            );
            $temp = $params;
            if ( strpos($temp, 'w_field_option_pos') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_flow',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_choices_params',
                'w_class',
                'w_property',
                'w_property_values',
                'w_quantity',
                'w_quantity_value',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_hide_label',
                'w_flow',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_choices_params',
                'w_class',
                'w_property',
                'w_property_values',
                'w_quantity',
                'w_quantity_value',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $param['w_property'] = explode('***', $param['w_property']);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_label' . $form_id . '\" />").val(jQuery("label[for=\'"+jQuery("input[name^=\'wdform_' . $id1 . '_element' . $form_id . '\']:checked").attr("id")+"\']").eq(0).text()).appendTo("#form' . $form_id . '");';
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_quantity_label' . $form_id . '\" />").val("' . (__("Quantity", WDFM()->prefix)) . '").appendTo("#form' . $form_id . '");';
            foreach ( $param['w_property'] as $key => $property ) {
              $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_property_label' . $form_id . $key . '\" />").val("' . $property . '").appendTo("#form' . $form_id . '");';
            }
            break;
          }
          case 'type_paypal_shipping': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_flow',
              'w_choices',
              'w_choices_price',
              'w_choices_checked',
              'w_required',
              'w_randomize',
              'w_allow_other',
              'w_allow_other_num',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_field_option_pos') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_flow',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_choices_params',
                'w_class',
              );
            }
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_field_option_pos',
                'w_hide_label',
                'w_flow',
                'w_choices',
                'w_choices_price',
                'w_choices_checked',
                'w_required',
                'w_randomize',
                'w_allow_other',
                'w_allow_other_num',
                'w_choices_params',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_element_label' . $form_id . '\" />").val(jQuery("label[for=\'"+jQuery("input[name^=\'wdform_' . $id1 . '_element' . $form_id . '\']:checked").attr("id")+"\']").eq(0).text()).appendTo("#form' . $form_id . '");';
            break;
          }
          case 'type_star_rating': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_field_label_col',
              'w_star_amount',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_field_label_col',
                'w_star_amount',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            for ( $i = 0; $i < $param['w_star_amount']; $i++ ) {
              $onload_js .= '
  jQuery("#wdform_' . $id1 . '_star_' . $i . '_' . $form_id . '").mouseover(function() {change_src(' . $i . ',"wdform_' . $id1 . '", ' . $form_id . ', "' . $param['w_field_label_col'] . '");});';
              $onload_js .= '
  jQuery("#wdform_' . $id1 . '_star_' . $i . '_' . $form_id . '").mouseout(function() {reset_src(' . $i . ',"wdform_' . $id1 . '", ' . $form_id . ');});';
              $onload_js .= '
  jQuery("#wdform_' . $id1 . '_star_' . $i . '_' . $form_id . '").click(function() {select_star_rating(' . $i . ',"wdform_' . $id1 . '", ' . $form_id . ',"' . $param['w_field_label_col'] . '", "' . $param['w_star_amount'] . '");});';
            }
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $post = isset($_POST['wdform_' . $id1 . '_selected_star_amount' . $form_id]) ? esc_html(stripslashes($_POST['wdform_' . $id1 . '_selected_star_amount' . $form_id])) : NULL;
            if ( isset($post) ) {
              $onload_js .= '
  select_star_rating(' . ($post - 1) . ',"wdform_' . $id1 . '", ' . $form_id . ',"' . $param['w_field_label_col'] . '", "' . $param['w_star_amount'] . '");';
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_star_amount' . $form_id . '\" value=\"' . $param['w_star_amount'] . '\" />").appendTo("#form' . $form_id . '");';
            break;
          }
          case 'type_scale_rating': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_mini_labels',
              'w_scale_amount',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_mini_labels',
                'w_scale_amount',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_scale_amount' . $form_id . '\" value=\"' . $param['w_scale_amount'] . '\" />").appendTo("#form' . $form_id . '");';
            break;
          }
          case 'type_spinner': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_field_width',
              'w_field_min_value',
              'w_field_max_value',
              'w_field_step',
              'w_field_value',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_field_width',
                'w_field_min_value',
                'w_field_max_value',
                'w_field_step',
                'w_field_value',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $onload_js .= '
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '")[0].spin = null;
  spinner = jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '").spinner();
  if ("' . $param['w_field_value'] . '" == "null") { spinner.spinner("value", ""); }
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '").spinner({ min: "' . $param['w_field_min_value'] . '"});
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '").spinner({ max: "' . $param['w_field_max_value'] . '"});
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '").spinner({ step: "' . $param['w_field_step'] . '"});';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            $spinner_check[$id1] = array( $param['w_field_min_value'], $param['w_field_max_value'] );
            break;
          }
          case 'type_slider': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_field_width',
              'w_field_min_value',
              'w_field_max_value',
              'w_field_value',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_field_width',
                'w_field_min_value',
                'w_field_max_value',
                'w_field_value',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $onload_js .= '
  jQuery("#wdform_' . $id1 . '_element' . $form_id . '")[0].slide = null;
  jQuery("#wdform_' . $id1 . '_element' . $form_id . '").slider({
    range: "min",
    value: eval(' . $param['w_field_value'] . '),
    min: eval(' . $param['w_field_min_value'] . '),
    max: eval(' . $param['w_field_max_value'] . '),
    slide: function( event, ui ) {
      jQuery("#wdform_' . $id1 . '_element_value' . $form_id . '").html("" + ui.value);
      jQuery("#wdform_' . $id1 . '_slider_value' . $form_id . '").val("" + ui.value);
    }
  });';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_range': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_field_range_width',
              'w_field_range_step',
              'w_field_value1',
              'w_field_value2',
              'w_mini_labels',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_field_range_width',
                'w_field_range_step',
                'w_field_value1',
                'w_field_value2',
                'w_mini_labels',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $onload_js .= '
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '0")[0].spin = null;
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '1")[0].spin = null;
  spinner0 = jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '0").spinner();
  if ("' . $param['w_field_value1'] . '" == "null") { spinner0.spinner("value", ""); }
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '").spinner({ step: ' . $param['w_field_range_step'] . '});
  spinner1 = jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '1").spinner();
  if ("' . $param['w_field_value2'] . '" == "null") { spinner1.spinner("value", ""); }
  jQuery("#form' . $form_id . ' #wdform_' . $id1 . '_element' . $form_id . '").spinner({ step: ' . $param['w_field_range_step'] . '});';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_grading': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_items',
              'w_total',
              'w_required',
              'w_class',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_items',
                'w_total',
                'w_required',
                'w_class',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $w_items = explode('***', $param['w_items']);
            $w_items_labels = implode(':', $w_items);
            $onload_js .= '
  jQuery("#wdform_' . $id1 . '_element' . $form_id . ' input").change(function() {sum_grading_values("wdform_' . $id1 . '",' . $form_id . ');});';
            $onload_js .= '
  jQuery("#wdform_' . $id1 . '_element' . $form_id . ' input").keyup(function() {sum_grading_values("wdform_' . $id1 . '",' . $form_id . ');});';
            $onload_js .= '
  jQuery("#wdform_' . $id1 . '_element' . $form_id . ' input").keyup(function() {sum_grading_values("wdform_' . $id1 . '",' . $form_id . ');});';
            $onload_js .= '
  sum_grading_values("wdform_' . $id1 . '",' . $form_id . ');';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            if ($param['w_total'] != '' && $param['w_total'] != '0') {
              $check_js .= '
  var isAllowdedSubmit = true;
  if(x.find(jQuery("div[wdid=' . $id1 . ']")).length != 0 && x.find(jQuery("div[wdid=' . $id1 . ']")).css("display") != "none") {
    if(parseInt(jQuery("#wdform_' . $id1 . '_sum_element' . $form_id . '").html()) > ' . $param['w_total'] . ') {
      alert("' . addslashes(__("Your score should be less than", WDFM()->prefix)) . ' ' . $param['w_total'] . '");
      return false;
    }
  }';
            }
            $onsubmit_js .= '
  jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_hidden_item' . $form_id . '\" value=\"' . $w_items_labels . ':' . $param['w_total'] . '\" />").appendTo("#form' . $form_id . '");';
            break;
          }
          case 'type_matrix': {
            $params_names = array(
              'w_field_label_size',
              'w_field_label_pos',
              'w_field_input_type',
              'w_rows',
              'w_columns',
              'w_required',
              'w_class',
              'w_textbox_size',
            );
            $temp = $params;
            if ( strpos($temp, 'w_hide_label') > -1 ) {
              $params_names = array(
                'w_field_label_size',
                'w_field_label_pos',
                'w_hide_label',
                'w_field_input_type',
                'w_rows',
                'w_columns',
                'w_required',
                'w_class',
                'w_textbox_size',
              );
            }
            foreach ( $params_names as $params_name ) {
              $temp = explode('*:*' . $params_name . '*:*', $temp);
              $param[$params_name] = $temp[0];
              $temp = $temp[1];
            }
            $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
            $onsubmit_js .= 'jQuery("<input type=\"hidden\" name=\"wdform_' . $id1 . '_input_type' . $form_id . '\" value=\"' . $param['w_field_input_type'] . '\" /><input type=\"hidden\" name=\"wdform_' . $id1 . '_hidden_row' . $form_id . '\" value=\"' . esc_html(addslashes($param['w_rows'])) . '\" /><input type=\"hidden\" name=\"wdform_' . $id1 . '_hidden_column' . $form_id . '\" value=\"' . esc_html(addslashes($param['w_columns'])) . '\" />").appendTo("#form' . $form_id . '");';
            if ( $required ) {
              array_push($req_fields, $id1);
            }
            break;
          }
          case 'type_paypal_total': {
            $onload_js .= 'set_total_value(' . $form_id . ');';
            break;
          }
            break;
        }
      }
    }
    $onsubmit_js .= '
  var disabled_fields = "";
  jQuery("#form' . $form_id . ' div[wdid]").each(function() {
    if(jQuery(this).css("display") == "none") {
      disabled_fields += jQuery(this).attr("wdid");
      disabled_fields += ",";
    }
    if(disabled_fields) {
      jQuery("<input type=\"hidden\" name=\"disabled_fields' . $form_id . '\" value =\""+disabled_fields+"\" />").appendTo("#form' . $form_id . '");
    }
  });';
    ob_start();
    ?>
    var fm_currentDate = new Date();
    var FormCurrency_<?php echo $form_id; ?> = '<?php echo $form_currency ?>';
    var FormPaypalTax_<?php echo $form_id; ?> = '<?php echo $form_paypal_tax ?>';
    var check_submit<?php echo $form_id; ?> = 0;
    var check_before_submit<?php echo $form_id; ?> = {};
    var required_fields<?php echo $form_id; ?> = <?php echo json_encode($req_fields) ?>;
    var labels_and_ids<?php echo $form_id; ?> = <?php echo json_encode($labels_and_ids) ?>;
    var check_regExp_all<?php echo $form_id; ?> = <?php echo json_encode($check_regExp_all) ?>;
    var check_paypal_price_min_max<?php echo $form_id; ?> = <?php echo json_encode($check_paypal_price_min_max) ?>;
    var file_upload_check<?php echo $form_id; ?> = <?php echo json_encode($file_upload_check) ?>;
    var spinner_check<?php echo $form_id; ?> = <?php echo json_encode($spinner_check) ?>;
    var scrollbox_trigger_point<?php echo $form_id; ?> = '<?php echo $row_display->scrollbox_trigger_point; ?>';
    var header_image_animation<?php echo $form_id; ?> = '<?php echo $row->header_image_animation; ?>';
    var scrollbox_loading_delay<?php echo $form_id; ?> = '<?php echo $row_display->scrollbox_loading_delay; ?>';
    var scrollbox_auto_hide<?php echo $form_id; ?> = '<?php echo $row_display->scrollbox_auto_hide; ?>';
    <?php
    $stripe_enable = ($stripe_enable && ($stripe_enable == 1 || $stripe_enable == 0)) ? $stripe_enable : 2;
    ?>
    <?php echo preg_replace($pattern, ' ', $row->javascript); ?>

    function onload_js<?php echo $form_id ?>() {<?php
    echo $onload_js; ?>

    }
    function condition_js<?php echo $form_id ?>() {<?php
    echo $condition_js; ?>

    }
    function check_js<?php echo $form_id ?>(id, form_id) {
    if (id != 0) {
    x = jQuery("#" + form_id + "form_view"+id);
    }
    else {
    x = jQuery("#form"+form_id);
    }<?php
    echo $check_js; ?>
    }
    function onsubmit_js<?php echo $form_id ?>() {
    <?php echo $onsubmit_js; ?>
    }
    jQuery(window).load(function () {
    formOnload(<?php echo $form_id ?>);
    });
    form_view_count<?php echo $form_id ?> = 0;
    jQuery(document).ready(function () {
    fm_document_ready(<?php echo $form_id ?>);
    });
    <?php
    $js_content = ob_get_clean();
    WDW_FM_Library::$fm_js_content = $js_content;
    fwrite($jsfile, $js_content);
    fclose($jsfile);
    clearstatcache();
  }

  /**
   * Get submissions to export.
   *
   * @return array
   */
  public static function get_submissions_to_export() {
    global $wpdb;
    $is_paypal_info = FALSE;
    $params = array();
    $group_id_s = array();
    $form_id = (int) $_REQUEST['form_id'];
    $limitstart = (int) $_REQUEST['limitstart'];
    $search_labels = isset($_REQUEST['search_labels']) ? $_REQUEST['search_labels'] : '';
    $verified_emails = isset($_REQUEST['verified_emails']) ? json_decode(stripslashes($_REQUEST['verified_emails']), TRUE) : array();
    $paypal_info_fields = array(
      'currency',
      'ord_last_modified',
      'status',
      'full_name',
      'fax',
      'mobile_phone',
      'email',
      'phone',
      'address',
      'paypal_info',
      'ipn',
      'tax',
      'shipping',
    );
    $paypal_info_labels = array(
      'Currency',
      'Last modified',
      'Status',
      'Full Name',
      'Fax',
      'Mobile phone',
      'Email',
      'Phone',
      'Address',
      'Paypal info',
      'IPN',
      'Tax',
      'Shipping',
    );
    if ( $search_labels ) {
      $query = $wpdb->prepare("SELECT distinct group_id FROM " . $wpdb->prefix . "formmaker_submits where form_id=%d and group_id IN(" . $search_labels . ")", $form_id);
      $group_id_s = $wpdb->get_col($query);
    }
    $query = $wpdb->prepare("SELECT distinct element_label FROM " . $wpdb->prefix . "formmaker_submits where form_id=%d", $form_id);
    $labels = $wpdb->get_col($query);
    $query_lable = $wpdb->prepare("SELECT label_order,title FROM " . $wpdb->prefix . "formmaker where id=%d", $form_id);
    $rows_lable = $wpdb->get_results($query_lable);
    $ptn = "/[^a-zA-Z0-9_]/";
    $rpltxt = "";
    $title = isset($rows_lable[0]) ? preg_replace($ptn, $rpltxt, $rows_lable[0]->title) : '';
    $sorted_labels_id = array();
    $sorted_labels = array();
    $sorted_types = array();
    $label_titles = array();
    $label_id = array();
    $label_order = array();
    $label_order_original = array();
    $label_type = array();
    if ( $labels ) {
      $label_all = explode('#****#', $rows_lable[0]->label_order);
      $label_all = array_slice($label_all, 0, count($label_all) - 1);
      foreach ( $label_all as $key => $label_each ) {
        $label_id_each = explode('#**id**#', $label_each);
        array_push($label_id, $label_id_each[0]);
        $label_oder_each = explode('#**label**#', $label_id_each[1]);
        array_push($label_order_original, $label_oder_each[0]);
        $label_temp = preg_replace($ptn, $rpltxt, $label_oder_each[0]);
        array_push($label_order, $label_temp);
        array_push($label_type, $label_oder_each[1]);
      }
      foreach ( $label_id as $key => $label ) {
        if ( in_array($label, $labels) && $label_type[$key] != 'type_arithmetic_captcha'
          && in_array($label, $labels) && $label_type[$key] != 'type_stripe' ) {
          array_push($sorted_labels, $label_order[$key]);
          array_push($sorted_labels_id, $label);
          array_push($label_titles, stripslashes($label_order_original[$key]));
          array_push($sorted_types, $label_type[$key]);
        }
      }
    }
    $m = count($sorted_labels);
    $wpdb->query("SET SESSION group_concat_max_len = 1000000");
    $rows = array();
    if ( $search_labels ) {
      $query = $wpdb->prepare("SELECT group_id, ip, date, user_id_wd, GROUP_CONCAT( element_label SEPARATOR ',') as element_label, GROUP_CONCAT( element_value SEPARATOR '*:*el_value*:*') as element_value FROM " . $wpdb->prefix . "formmaker_submits where form_id= %d and group_id IN(" . $search_labels . ") GROUP BY group_id ORDER BY date ASC limit %d, %d", $form_id, $limitstart, 1000);
      $rows = $wpdb->get_results($query, OBJECT_K);
    }
    $data = array();
    $group_id_s_count = $limitstart + 1000 < count($group_id_s) ? $limitstart + 1000 : count($group_id_s);
    sort($group_id_s, SORT_NUMERIC);
    for ( $www = $limitstart; $www < $group_id_s_count; $www++ ) {
      $i = $group_id_s[$www];
      $field_key = array_search($i, $label_id);
      if ( $label_type[$field_key] != 'type_arithmetic_captcha'
        && $label_type[$field_key] != 'type_stripe' ) {
        $data_temp = array();
        $tt = $rows[$i];
        $date = $tt->date;
        $ip = $tt->ip;
        $user_id = get_userdata($tt->user_id_wd);
        $username = $user_id ? $user_id->display_name : "";
        $useremail = $user_id ? $user_id->user_email : "";
        $data_temp['ID'] = $i;
        $data_temp['Submit date'] = $date;
        $data_temp['Submitter\'s IP'] = $ip;
        $data_temp['Submitter\'s Username'] = $username;
        $data_temp['Submitter\'s Email Address'] = $useremail;
        $element_labels = explode(',', $tt->element_label);
        $element_values = explode('*:*el_value*:*', $tt->element_value);
        for ( $h = 0; $h < $m; $h++ ) {
          if ( isset($data_temp[$label_titles[$h]]) ) {
            $label_titles[$h] .= '(1)';
          }
          if ( in_array($sorted_labels_id[$h], $element_labels) ) {
            $element_value = $element_values[array_search($sorted_labels_id[$h], $element_labels)];
            if ( strpos($element_value, "*@@url@@*") ) {
              $file_names = '';
              $new_files = explode("*@@url@@*", $element_value);
              foreach ( $new_files as $new_file ) {
                if ( $new_file ) {
                  $file_names .= $new_file . ", ";
                }
              }
              $data_temp[stripslashes($label_titles[$h])] = $file_names;
            }
            elseif ( strpos($element_value, "***br***") ) {
              $element_value = str_replace("***br***", ', ', $element_value);
              if ( strpos($element_value, "***quantity***") ) {
                $element_value = str_replace("***quantity***", '', $element_value);
              }
              if ( strpos($element_value, "***property***") ) {
                $element_value = str_replace("***property***", '', $element_value);
              }
              if ( substr($element_value, -2) == ', ' ) {
                $data_temp[stripslashes($label_titles[$h])] = substr($element_value, 0, -2);
              }
              else {
                $data_temp[stripslashes($label_titles[$h])] = $element_value;
              }
            }
            elseif ( strpos($element_value, "***map***") ) {
              $data_temp[stripslashes($label_titles[$h])] = 'Longitude:' . str_replace("***map***", ', Latitude:', $element_value);
            }
            elseif ( strpos($element_value, "***star_rating***") ) {
              $element = str_replace("***star_rating***", '', $element_value);
              $element = explode("***", $element);
              $data_temp[stripslashes($label_titles[$h])] = ' ' . $element[1] . '/' . $element[0];
            }
            elseif ( strpos($element_value, "@@@") !== FALSE ) {
              $data_temp[stripslashes($label_titles[$h])] = str_replace("@@@", ' ', $element_value);
            }
            elseif ( strpos($element_value, "***grading***") ) {
              $element = str_replace("***grading***", '', $element_value);
              $grading = explode(":", $element);
              $items_count = sizeof($grading) - 1;
              $items = "";
              $total = "";
              for ( $k = 0; $k < $items_count / 2; $k++ ) {
                $items .= $grading[$items_count / 2 + $k] . ": " . $grading[$k] . ", ";
                $total += $grading[$k];
              }
              $items .= "Total: " . $total;
              $data_temp[stripslashes($label_titles[$h])] = $items;
            }
            elseif ( strpos($element_value, "***matrix***") ) {
              $element = str_replace("***matrix***", '', $element_value);
              $matrix_value = explode('***', $element);
              $matrix_value = array_slice($matrix_value, 0, count($matrix_value) - 1);
              $mat_rows = $matrix_value[0];
              $mat_columns = $matrix_value[$mat_rows + 1];
              $matrix = "";
              $aaa = array();
              $var_checkbox = 1;
              $selected_value = "";
              $selected_value_yes = "";
              $selected_value_no = "";
              for ( $k = 1; $k <= $mat_rows; $k++ ) {
                if ( $matrix_value[$mat_rows + $mat_columns + 2] == "radio" ) {
                  if ( $matrix_value[$mat_rows + $mat_columns + 2 + $k] == 0 ) {
                    $checked = "0";
                    $aaa[1] = "";
                  }
                  else {
                    $aaa = explode("_", $matrix_value[$mat_rows + $mat_columns + 2 + $k]);
                  }
                  for ( $l = 1; $l <= $mat_columns; $l++ ) {
                    $checked = $aaa[1] == $l ? '1' : '0';
                    $matrix .= '[' . $matrix_value[$k] . ',' . $matrix_value[$mat_rows + 1 + $l] . ']=' . $checked . "; ";
                  }
                }
                else {
                  if ( $matrix_value[$mat_rows + $mat_columns + 2] == "checkbox" ) {
                    for ( $l = 1; $l <= $mat_columns; $l++ ) {
                      $checked = $matrix_value[$mat_rows + $mat_columns + 2 + $var_checkbox] == 1 ? '1' : '0';
                      $matrix .= '[' . $matrix_value[$k] . ',' . $matrix_value[$mat_rows + 1 + $l] . ']=' . $checked . "; ";
                      $var_checkbox++;
                    }
                  }
                  else {
                    if ( $matrix_value[$mat_rows + $mat_columns + 2] == "text" ) {
                      for ( $l = 1; $l <= $mat_columns; $l++ ) {
                        $text_value = $matrix_value[$mat_rows + $mat_columns + 2 + $var_checkbox];
                        $matrix .= '[' . $matrix_value[$k] . ',' . $matrix_value[$mat_rows + 1 + $l] . ']=' . $text_value . "; ";
                        $var_checkbox++;
                      }
                    }
                    else {
                      for ( $l = 1; $l <= $mat_columns; $l++ ) {
                        $selected_text = $matrix_value[$mat_rows + $mat_columns + 2 + $var_checkbox];
                        $matrix .= '[' . $matrix_value[$k] . ',' . $matrix_value[$mat_rows + 1 + $l] . ']=' . $selected_text . "; ";
                        $var_checkbox++;
                      }
                    }
                  }
                }
              }
              $data_temp[stripslashes($label_titles[$h])] = $matrix;
            }
            else {
              $val = strip_tags(htmlspecialchars_decode($element_value));
              $val = stripslashes(str_replace('&#039;', "'", $val));
              $data_temp[stripslashes($label_titles[$h])] = $val;
            }
          }
          else {
            $data_temp[stripslashes($label_titles[$h])] = '';
          }
          if ( isset($verified_emails[$sorted_labels_id[$h]]) && $sorted_types[$h] == "type_submitter_mail" ) {
            if ( $data_temp[stripslashes($label_titles[$h])] == '' ) {
              $data_temp[stripslashes($label_titles[$h]) . '(verified)'] = '';
            }
            else {
              if ( in_array($i, $verified_emails[$sorted_labels_id[$h]]) ) {
                $data_temp[stripslashes($label_titles[$h]) . '(verified)'] = 'yes';
              }
              else {
                $data_temp[stripslashes($label_titles[$h]) . '(verified)'] = 'no';
              }
            }
          }
        }
        $item_total = $wpdb->get_var($wpdb->prepare("SELECT `element_value` FROM " . $wpdb->prefix . "formmaker_submits where group_id=%d AND element_label=%s", $i, 'item_total'));
        $total = $wpdb->get_var($wpdb->prepare("SELECT `element_value` FROM " . $wpdb->prefix . "formmaker_submits where group_id=%d AND element_label=%s", $i, 'total'));
        $payment_status = $wpdb->get_var($wpdb->prepare("SELECT `element_value` FROM " . $wpdb->prefix . "formmaker_submits where group_id=%d AND element_label=%s", $i, '0'));
        if ( $item_total ) {
          $data_temp['Item Total'] = $item_total;
        }
        if ( $total ) {
          $data_temp['Total'] = $total;
        }
        if ( $payment_status ) {
          $data_temp['Payment Status'] = $payment_status;
        }
        $query = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "formmaker_sessions where group_id=%d", $i);
        $paypal_info = $wpdb->get_results($query);
        if ( $paypal_info ) {
          $is_paypal_info = TRUE;
        }
        if ( $is_paypal_info ) {
          foreach ( $paypal_info_fields as $key => $paypal_info_field ) {
            if ( $paypal_info ) {
              $data_temp['PAYPAL_' . $paypal_info_labels[$key]] = $paypal_info[0]->$paypal_info_field;
            }
            else {
              $data_temp['PAYPAL_' . $paypal_info_labels[$key]] = '';
            }
          }
        }
        $data[$i] = $data_temp;
      }
    }
    array_push($params, $data);
    array_push($params, $title);
    array_push($params, $is_paypal_info);

    return $params;
  }

  /**
   * No items.
   *
   * @param $title
   *
   * @return string
   */
  public static function no_items($title) {
    $title = ($title != '') ? strtolower($title) : 'items';
    ob_start();
    ?><tr class="no-items">
    <td class="colspanchange" colspan="0"><?php echo sprintf(__('No %s found.', WDFM()->prefix), $title); ?></td>
    </tr><?php
    return ob_get_clean();
  }

  /**
   * Get current page url.
   *
   * @return string
   */
  public static function get_current_page_url() {
    global $wp;
    return add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
  }

  /**
   * Get all addons.
   *
   * @return array $addons
   */
  public static function get_all_addons_path() {
    $addons = array(
      'form-maker-export-import/fm_exp_imp.php',
      'form-maker-save-progress/fm_save.php',
      'form-maker-conditional-emails/fm_conditional_emails.php',
      'form-maker-pushover/fm_pushover.php',
      'form-maker-mailchimp/fm_mailchimp.php',
      'form-maker-reg/fm_reg.php',
      'form-maker-post-generation/fm_post_generation.php',
      'form-maker-dropbox-integration/fm_dropbox_integration.php',
      'form-maker-gdrive-integration/fm_gdrive_integration.php',
      'form-maker-pdf-integration/fm_pdf_integration.php',
      'form-maker-stripe/fm_stripe.php',
      'form-maker-calculator/fm_calculator.php'
    );
    return $addons;
  }

  /**
   * Deactivate all addons.
   *
   * @return bool $addon
   */
  public static function deactivate_all_addons() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    $addons = WDW_FM_Library::get_all_addons_path();
    foreach ( $addons as $addon ) {
      if( is_plugin_active( $addon ) ) {
        deactivate_plugins( $addon );
      }
    }
  }

  /**
   * Get countries list.
   *
   * @return array
   */
  public static function get_countries() {
    $countries = array(
      "" => "",
      "Afghanistan" => __("Afghanistan", WDFM()->prefix),
      "Albania" => __("Albania", WDFM()->prefix),
      "Algeria" => __("Algeria", WDFM()->prefix),
      "Andorra" => __("Andorra", WDFM()->prefix),
      "Angola" => __("Angola", WDFM()->prefix),
      "Antigua and Barbuda" => __("Antigua and Barbuda", WDFM()->prefix),
      "Argentina" => __("Argentina", WDFM()->prefix),
      "Armenia" => __("Armenia", WDFM()->prefix),
      "Australia" => __("Australia", WDFM()->prefix),
      "Austria" => __("Austria", WDFM()->prefix),
      "Azerbaijan" => __("Azerbaijan", WDFM()->prefix),
      "Bahamas" => __("Bahamas", WDFM()->prefix),
      "Bahrain" => __("Bahrain", WDFM()->prefix),
      "Bangladesh" => __("Bangladesh", WDFM()->prefix),
      "Barbados" => __("Barbados", WDFM()->prefix),
      "Belarus" => __("Belarus", WDFM()->prefix),
      "Belgium" => __("Belgium", WDFM()->prefix),
      "Belize" => __("Belize", WDFM()->prefix),
      "Benin" => __("Benin", WDFM()->prefix),
      "Bhutan" => __("Bhutan", WDFM()->prefix),
      "Bolivia" => __("Bolivia", WDFM()->prefix),
      "Bosnia and Herzegovina" => __("Bosnia and Herzegovina", WDFM()->prefix),
      "Botswana" => __("Botswana", WDFM()->prefix),
      "Brazil" => __("Brazil", WDFM()->prefix),
      "Brunei" => __("Brunei", WDFM()->prefix),
      "Bulgaria" => __("Bulgaria", WDFM()->prefix),
      "Burkina" => __("Burkina Faso", WDFM()->prefix),
      "Burundi" => __("Burundi", WDFM()->prefix),
      "Cambodia" => __("Cambodia", WDFM()->prefix),
      "Cameroon" => __("Cameroon", WDFM()->prefix),
      "Canada" => __("Canada", WDFM()->prefix),
      "Cape Verde" => __("Cape Verde", WDFM()->prefix),
      "Central African Republic" => __("Central African Republic", WDFM()->prefix),
      "Chad" => __("Chad", WDFM()->prefix),
      "Chile" => __("Chile", WDFM()->prefix),
      "China" => __("China", WDFM()->prefix),
      "Colombia" => __("Colombia", WDFM()->prefix),
      "Comoros" => __("Comoros", WDFM()->prefix),
      "Congo (Brazzaville)" => __("Congo (Brazzaville)", WDFM()->prefix),
      "Congo" => __("Congo", WDFM()->prefix),
      "Costa Rica" => __("Costa Rica", WDFM()->prefix),
      "Cote d'Ivoire" => __("Cote d'Ivoire", WDFM()->prefix),
      "Croatia" => __("Croatia", WDFM()->prefix),
      "Cuba" => __("Cuba", WDFM()->prefix),
      "Curacao" => __("Curacao", WDFM()->prefix),
      "Cyprus" => __("Cyprus", WDFM()->prefix),
      "Czech Republic" => __("Czech Republic", WDFM()->prefix),
      "Denmark" => __("Denmark", WDFM()->prefix),
      "Djibouti" => __("Djibouti", WDFM()->prefix),
      "Dominica" => __("Dominica", WDFM()->prefix),
      "Dominican Republic" => __("Dominican Republic", WDFM()->prefix),
      "East Timor (Timor Timur" => __("East Timor (Timor Timur)", WDFM()->prefix),
      "Ecuador" => __("Ecuador", WDFM()->prefix),
      "Egypt" => __("Egypt", WDFM()->prefix),
      "El Salvador" => __("El Salvador", WDFM()->prefix),
      "Equatorial" => __("Equatorial Guinea", WDFM()->prefix),
      "Eritrea" => __("Eritrea", WDFM()->prefix),
      "Estonia" => __("Estonia", WDFM()->prefix),
      "Ethiopia" => __("Ethiopia", WDFM()->prefix),
      "Fiji" => __("Fiji", WDFM()->prefix),
      "Finland" => __("Finland", WDFM()->prefix),
      "France" => __("France", WDFM()->prefix),
      "Gabon" => __("Gabon", WDFM()->prefix),
      "Gambia, The" => __("Gambia, The", WDFM()->prefix),
      "Georgia" => __("Georgia", WDFM()->prefix),
      "Germany" => __("Germany", WDFM()->prefix),
      "Ghana" => __("Ghana", WDFM()->prefix),
      "Greece" => __("Greece", WDFM()->prefix),
      "Grenada" => __("Grenada", WDFM()->prefix),
      "Guatemala" => __("Guatemala", WDFM()->prefix),
      "Guinea" => __("Guinea", WDFM()->prefix),
      "Guinea-Bissau" => __("Guinea-Bissau", WDFM()->prefix),
      "Guyana" => __("Guyana", WDFM()->prefix),
      "Haiti" => __("Haiti", WDFM()->prefix),
      "Honduras" => __("Honduras", WDFM()->prefix),
      "Hong Kong" => __("Hong Kong", WDFM()->prefix),
      "Hungary" => __("Hungary", WDFM()->prefix),
      "Iceland" => __("Iceland", WDFM()->prefix),
      "India" => __("India", WDFM()->prefix),
      "Indonesia" => __("Indonesia", WDFM()->prefix),
      "Iran" => __("Iran", WDFM()->prefix),
      "Iraq" => __("Iraq", WDFM()->prefix),
      "Ireland" => __("Ireland", WDFM()->prefix),
      "Israel" => __("Israel", WDFM()->prefix),
      "Italy" => __("Italy", WDFM()->prefix),
      "Jamaica" => __("Jamaica", WDFM()->prefix),
      "Japan" => __("Japan", WDFM()->prefix),
      "Jordan" => __("Jordan", WDFM()->prefix),
      "Kazakhstan" => __("Kazakhstan", WDFM()->prefix),
      "Kenya" => __("Kenya", WDFM()->prefix),
      "Kiribati" => __("Kiribati", WDFM()->prefix),
      "Korea, North" => __("Korea, North", WDFM()->prefix),
      "Korea, South" => __("Korea, South", WDFM()->prefix),
      "Kuwait" => __("Kuwait", WDFM()->prefix),
      "Kyrgyzstan" => __("Kyrgyzstan", WDFM()->prefix),
      "Laos" => __("Laos", WDFM()->prefix),
      "Latvia" => __("Latvia", WDFM()->prefix),
      "Lebanon" => __("Lebanon", WDFM()->prefix),
      "Lesotho" => __("Lesotho", WDFM()->prefix),
      "Liberia" => __("Liberia", WDFM()->prefix),
      "Libya" => __("Libya", WDFM()->prefix),
      "Liechtenstein" => __("Liechtenstein", WDFM()->prefix),
      "Lithuania" => __("Lithuania", WDFM()->prefix),
      "Luxembourg" => __("Luxembourg", WDFM()->prefix),
      "Macedonia" => __("Macedonia", WDFM()->prefix),
      "Madagascar" => __("Madagascar", WDFM()->prefix),
      "Malawi" => __("Malawi", WDFM()->prefix),
      "Malaysia" => __("Malaysia", WDFM()->prefix),
      "Maldives" => __("Maldives", WDFM()->prefix),
      "Mali" => __("Mali", WDFM()->prefix),
      "Malta" => __("Malta", WDFM()->prefix),
      "Marshall Islands" => __("Marshall Islands", WDFM()->prefix),
      "Mauritania" => __("Mauritania", WDFM()->prefix),
      "Mauritius" => __("Mauritius", WDFM()->prefix),
      "Mexico" => __("Mexico", WDFM()->prefix),
      "Micronesia" => __("Micronesia", WDFM()->prefix),
      "Moldova" => __("Moldova", WDFM()->prefix),
      "Monaco" => __("Monaco", WDFM()->prefix),
      "Mongolia" => __("Mongolia", WDFM()->prefix),
      "Morocco" => __("Morocco", WDFM()->prefix),
      "Mozambique" => __("Mozambique", WDFM()->prefix),
      "Myanmar" => __("Myanmar", WDFM()->prefix),
      "Namibia" => __("Namibia", WDFM()->prefix),
      "Nauru" => __("Nauru", WDFM()->prefix),
      "Nepal" => __("Nepal", WDFM()->prefix),
      "Netherlands" => __("Netherlands", WDFM()->prefix),
      "New Zealand" => __("New Zealand", WDFM()->prefix),
      "Nicaragua" => __("Nicaragua", WDFM()->prefix),
      "Niger" => __("Niger", WDFM()->prefix),
      "Nigeria" => __("Nigeria", WDFM()->prefix),
      "Norway" => __("Norway", WDFM()->prefix),
      "Oman" => __("Oman", WDFM()->prefix),
      "Pakistan" => __("Pakistan", WDFM()->prefix),
      "Palau" => __("Palau", WDFM()->prefix),
      "Panama" => __("Panama", WDFM()->prefix),
      "Papua New Guinea" => __("Papua New Guinea", WDFM()->prefix),
      "Paraguay" => __("Paraguay", WDFM()->prefix),
      "Peru" => __("Peru", WDFM()->prefix),
      "Philippines" => __("Philippines", WDFM()->prefix),
      "Poland" => __("Poland", WDFM()->prefix),
      "Portugal" => __("Portugal", WDFM()->prefix),
      "Puerto Rico" => __("Puerto Rico", WDFM()->prefix),
      "Qatar" => __("Qatar", WDFM()->prefix),
      "Romania" => __("Romania", WDFM()->prefix),
      "Russia" => __("Russia", WDFM()->prefix),
      "Rwanda" => __("Rwanda", WDFM()->prefix),
      "Saint Kitts and Nevis" => __("Saint Kitts and Nevis", WDFM()->prefix),
      "Saint Lucia" => __("Saint Lucia", WDFM()->prefix),
      "Saint Vincent" => __("Saint Vincent", WDFM()->prefix),
      "Samoa" => __("Samoa", WDFM()->prefix),
      "San Marino" => __("San Marino", WDFM()->prefix),
      "Sao Tome and Principe" => __("Sao Tome and Principe", WDFM()->prefix),
      "Saudi Arabia" => __("Saudi Arabia", WDFM()->prefix),
      "Senegal" => __("Senegal", WDFM()->prefix),
      "Serbia and Montenegro" => __("Serbia and Montenegro", WDFM()->prefix),
      "Seychelles" => __("Seychelles", WDFM()->prefix),
      "Sierra Leone" => __("Sierra Leone", WDFM()->prefix),
      "Singapore" => __("Singapore", WDFM()->prefix),
      "Slovakia" => __("Slovakia", WDFM()->prefix),
      "Slovenia" => __("Slovenia", WDFM()->prefix),
      "Solomon Islands" => __("Solomon Islands", WDFM()->prefix),
      "Somalia" => __("Somalia", WDFM()->prefix),
      "South Africa" => __("South Africa", WDFM()->prefix),
      "Spain" => __("Spain", WDFM()->prefix),
      "Sri Lanka" => __("Sri Lanka", WDFM()->prefix),
      "Sudan" => __("Sudan", WDFM()->prefix),
      "Suriname" => __("Suriname", WDFM()->prefix),
      "Swaziland" => __("Swaziland", WDFM()->prefix),
      "Sweden" => __("Sweden", WDFM()->prefix),
      "Switzerland" => __("Switzerland", WDFM()->prefix),
      "Syria" => __("Syria", WDFM()->prefix),
      "Taiwan" => __("Taiwan", WDFM()->prefix),
      "Tajikistan" => __("Tajikistan", WDFM()->prefix),
      "Tanzania" => __("Tanzania", WDFM()->prefix),
      "Thailand" => __("Thailand", WDFM()->prefix),
      "Togo" => __("Togo", WDFM()->prefix),
      "Tonga" => __("Tonga", WDFM()->prefix),
      "Trinidad and Tobago" => __("Trinidad and Tobago", WDFM()->prefix),
      "Tunisia" => __("Tunisia", WDFM()->prefix),
      "Turkey" => __("Turkey", WDFM()->prefix),
      "Turkmenistan" => __("Turkmenistan", WDFM()->prefix),
      "Tuvalu" => __("Tuvalu", WDFM()->prefix),
      "Uganda" => __("Uganda", WDFM()->prefix),
      "Ukraine" => __("Ukraine", WDFM()->prefix),
      "United Arab Emirates" => __("United Arab Emirates", WDFM()->prefix),
      "United Kingdom" => __("United Kingdom", WDFM()->prefix),
      "United States" => __("United States", WDFM()->prefix),
      "Uruguay" => __("Uruguay", WDFM()->prefix),
      "Uzbekistan" => __("Uzbekistan", WDFM()->prefix),
      "Vanuatu" => __("Vanuatu", WDFM()->prefix),
      "Vatican City" => __("Vatican City", WDFM()->prefix),
      "Venezuela" => __("Venezuela", WDFM()->prefix),
      "Vietnam" => __("Vietnam", WDFM()->prefix),
      "Wales" => __("Wales", WDFM()->prefix),
      "Yemen" => __("Yemen", WDFM()->prefix),
      "Zambia" => __("Zambia", WDFM()->prefix),
      "Zimbabwe" => __("Zimbabwe", WDFM()->prefix),
    );

    return $countries;
  }

  /**
   * Get states list.
   *
   * @return array
   */
  public static function get_states() {
    $states = array(
      "" => "",
      "Alabama" => __("Alabama", WDFM()->prefix),
      "Alaska" => __("Alaska", WDFM()->prefix),
      "Arizona" => __("Arizona", WDFM()->prefix),
      "Arkansas" => __("Arkansas", WDFM()->prefix),
      "California" => __("California", WDFM()->prefix),
      "Colorado" => __("Colorado", WDFM()->prefix),
      "Connecticut" => __("Connecticut", WDFM()->prefix),
      "Delaware" => __("Delaware", WDFM()->prefix),
      "District Of Columbia" => __("District Of Columbia", WDFM()->prefix),
      "Florida" => __("Florida", WDFM()->prefix),
      "Georgia" => __("Georgia", WDFM()->prefix),
      "Hawaii" => __("Hawaii", WDFM()->prefix),
      "Idaho" => __("Idaho", WDFM()->prefix),
      "Illinois" => __("Illinois", WDFM()->prefix),
      "Indiana" => __("Indiana", WDFM()->prefix),
      "Iowa" => __("Iowa", WDFM()->prefix),
      "Kansas" => __("Kansas", WDFM()->prefix),
      "Kentucky" => __("Kentucky", WDFM()->prefix),
      "Louisiana" => __("Louisiana", WDFM()->prefix),
      "Maine" => __("Maine", WDFM()->prefix),
      "Maryland" => __("Maryland", WDFM()->prefix),
      "Massachusetts" => __("Massachusetts", WDFM()->prefix),
      "Michigan" => __("Michigan", WDFM()->prefix),
      "Minnesota" => __("Minnesota", WDFM()->prefix),
      "Mississippi" => __("Mississippi", WDFM()->prefix),
      "Missouri" => __("Missouri", WDFM()->prefix),
      "Montana" => __("Montana", WDFM()->prefix),
      "Nebraska" => __("Nebraska", WDFM()->prefix),
      "Nevada" => __("Nevada", WDFM()->prefix),
      "New Hampshire" => __("New Hampshire", WDFM()->prefix),
      "New Jersey" => __("New Jersey", WDFM()->prefix),
      "New Mexico" => __("New Mexico", WDFM()->prefix),
      "New York" => __("New York", WDFM()->prefix),
      "North Carolina" => __("North Carolina", WDFM()->prefix),
      "North Dakota" => __("North Dakota", WDFM()->prefix),
      "Ohio" => __("Ohio", WDFM()->prefix),
      "Oklahoma" => __("Oklahoma", WDFM()->prefix),
      "Oregon" => __("Oregon", WDFM()->prefix),
      "Pennsylvania" => __("Pennsylvania", WDFM()->prefix),
      "Rhode Island" => __("Rhode Island", WDFM()->prefix),
      "South Carolina" => __("South Carolina", WDFM()->prefix),
      "South Dakota" => __("South Dakota", WDFM()->prefix),
      "Tennessee" => __("Tennessee", WDFM()->prefix),
      "Texas" => __("Texas", WDFM()->prefix),
      "Utah" => __("Utah", WDFM()->prefix),
      "Vermont" => __("Vermont", WDFM()->prefix),
      "Virginia" => __("Virginia", WDFM()->prefix),
      "Washington" => __("Washington", WDFM()->prefix),
      "West Virginia" => __("West Virginia", WDFM()->prefix),
      "Wisconsin" => __("Wisconsin", WDFM()->prefix),
      "Wyoming" => __("Wyoming", WDFM()->prefix),
    );

    return $states;
  }

  /**
   * Localize ui datepicker.
   *
   * @return string
   */
  public static function localize_ui_datepicker() {
    return 'jQuery(document).ready(function(jQuery){
      jQuery.datepicker.setDefaults( {
        "closeText":"' . __('Done', WDFM()->prefix) . '",
        "prevText":"' . __('Prev', WDFM()->prefix) . '",
        "nextText":"' . __('Next', WDFM()->prefix) . '",
        "currentText":"' . __('Today', WDFM()->prefix) . '",
        "monthNames":["' . __('January', WDFM()->prefix) . '","' . __('February', WDFM()->prefix) . '","' . __('March', WDFM()->prefix) . '","' . __('April', WDFM()->prefix) . '","' . __('May', WDFM()->prefix) . '","' . __('June', WDFM()->prefix) . '","' . __('July', WDFM()->prefix) . '","' . __('August', WDFM()->prefix) . '","' . __('September', WDFM()->prefix) . '","' . __('October', WDFM()->prefix) . '","' . __('November', WDFM()->prefix) . '","' . __('December', WDFM()->prefix) . '"],
        "monthNamesShort":["' . __('Jan', WDFM()->prefix) . '","' . __('Feb', WDFM()->prefix) . '","' . __('Mar', WDFM()->prefix) . '","' . __('Apr', WDFM()->prefix) . '","' . __('May', WDFM()->prefix) . '","' . __('Jun', WDFM()->prefix) . '","' . __('Jul', WDFM()->prefix) . '","' . __('Aug', WDFM()->prefix) . '","' . __('Sep', WDFM()->prefix) . '","' . __('Oct', WDFM()->prefix) . '","' . __('Nov', WDFM()->prefix) . '","' . __('Dec', WDFM()->prefix) . '"],
        "dayNames":["' . __('Sunday', WDFM()->prefix) . '","' . __('Monday', WDFM()->prefix) . '","' . __('Tuesday', WDFM()->prefix) . '","' . __('Wednesday', WDFM()->prefix) . '","' . __('Thursday', WDFM()->prefix) . '","' . __('Friday', WDFM()->prefix) . '","' . __('Saturday', WDFM()->prefix) . '"],
        "dayNamesShort":["' . __('Sun', WDFM()->prefix) . '","' . __('Mon', WDFM()->prefix) . '","' . __('Tue', WDFM()->prefix) . '","' . __('Wed', WDFM()->prefix) . '","' . __('Thu', WDFM()->prefix) . '","' . __('Fri', WDFM()->prefix) . '","' . __('Sat', WDFM()->prefix) . '"],
       "dayNamesMin":["' . __('Su', WDFM()->prefix) . '","' . __('Mo', WDFM()->prefix) . '","' . __('Tu', WDFM()->prefix) . '","' . __('We', WDFM()->prefix) . '","' . __('Th', WDFM()->prefix) . '","' . __('Fr', WDFM()->prefix) . '","' . __('Sa', WDFM()->prefix) . '"]
      });
    })';
  }

  /**
   * Forbidden template.
   *
   * @return string
   */
  public static function forbidden_template() {
    return '<!DOCTYPE html>
				<html>
				<head>
					<title>403 Forbidden</title>
				</head>
				<body>
					<p>Directory access is forbidden.</p>
				</body>
				</html>';
  }

  /**
   * Sanitize parameters and send email.
   *
   * @param string $recipient
   * @param string $subject
   * @param string $message
   * @param array  $header_arr
   * @param array  $attachment
   *
   * @return bool
   */
  public static function mail($recipient, $subject, $message = '', $header_arr = array(), $attachment = array()) {
    $recipient = trim($recipient, ',');
    $recipient = explode(',', $recipient);
    $recipient = array_map('trim', $recipient);
    if ( empty($recipient) ) {
      return FALSE;
    }

    if ( function_exists('mb_internal_encoding') ) {
      mb_internal_encoding('UTF-8');
    }

    $subject = html_entity_decode($subject, ENT_QUOTES);
    $subject = stripslashes($subject);
    if ( function_exists('mb_encode_mimeheader') ) {
      $subject = mb_encode_mimeheader($subject, 'UTF-8', 'Q');
    }

    $message = stripslashes($message);
//    $message = self::encodeQuotedPrintable($message);

    $headers = array();

//    $headers[] = 'Content-Transfer-Encoding: QUOTED-PRINTABLE';

    if ( isset($header_arr['from_name']) && $header_arr['from_name'] ) {
      $from_name = $header_arr['from_name'];
      $from_name = html_entity_decode($from_name, ENT_QUOTES);
      $from_name = stripslashes($from_name);
      if ( function_exists('mb_encode_mimeheader') ) {
        $from_name = mb_encode_mimeheader($from_name, 'UTF-8', 'Q');
      }
      //                $from_str .= "'" . $from_name . "' ";
      self::$email_from_name = $from_name;
      add_filter('wp_mail_from_name', array('WDW_FM_Library', 'mail_from_name'));
    }

    if ( isset($header_arr['from']) && $header_arr['from'] ) {
      $from = $header_arr['from'];
      $from = trim($from);
      $from = trim($from, ',');
      //            $from_str = "From: ";

      //            $from_str .= "<" . $from . ">";
      //            $headers[] = $from_str;
      self::$email_from = $from;
      add_filter('wp_mail_from', array('WDW_FM_Library', 'mail_from'));
    }

    if ( isset($header_arr['content_type']) && $header_arr['content_type'] ) {
      //      $headers[] = "Content-Type: " . $header_arr['content_type'];
      self::$email_content_type = $header_arr['content_type'];
      add_filter('wp_mail_content_type', array('WDW_FM_Library', 'mail_content_type'));
    }

    if ( isset($header_arr['charset']) && $header_arr['charset'] ) {
      //      $headers[] = $header_arr['charset'];
      self::$email_charset = $header_arr['charset'];
      add_filter('wp_mail_charset', array('WDW_FM_Library', 'mail_charset'));
    }

    if ( isset($header_arr['reply_to']) && $header_arr['reply_to'] ) {
      $reply_to = $header_arr['reply_to'];
      $reply_to = trim($reply_to);
      $reply_to = trim($reply_to, ',');
      $headers[] = "Reply-To: <" . $reply_to . ">";
    }

    if ( isset($header_arr['cc']) && $header_arr['cc'] ) {
      $cc = $header_arr['cc'];
      $cc = trim($cc);
      $cc = trim($cc, ',');
      $headers[] = "Cc: " . $cc;
    }

    if ( isset($header_arr['bcc']) && $header_arr['bcc'] ) {
      $bcc = $header_arr['bcc'];
      $bcc = trim($bcc);
      $bcc = trim($bcc, ',');
      $headers[] = "Bcc: " . $bcc;
    }

    $sent = wp_mail($recipient, $subject, $message, $headers, $attachment);

    remove_filter('wp_mail_content_type', array('WDW_FM_Library', 'mail_content_type'));
    remove_filter('wp_mail_charset', array('WDW_FM_Library', 'mail_charset'));
    remove_filter('wp_mail_from', array('WDW_FM_Library', 'mail_from'));
    remove_filter('wp_mail_from_name', array('WDW_FM_Library', 'mail_from_name'));

    return $sent;
  }
  public static $email_content_type;
  public static $email_charset;
  public static $email_from;
  public static $email_from_name;
  public static function mail_content_type() {
    return self::$email_content_type;
  }
  public static function mail_charset() {
    return self::$email_charset;
  }
  public static function mail_from() {
    return self::$email_from;
  }
  public static function mail_from_name() {
    return self::$email_from_name;
  }

  /**
   * Get labels parameters.
   *
   * @param int $form_id
   * @param int $page_num
   * @param int $per_num
   *
   * @return array $labels_parameters
   */
  public static function get_labels_parameters($form_id, $page_num = 0, $per_num = 0) {
    global $wpdb;
    $labels = array();
    $labels_id = array();
    $form_labels = array();
    $sorted_labels_id = array();
    $label_names = array();
    $label_types = array();
    $sorted_label_types = array();
    $label_names_original = array();
    $labels_parameters = array();
    $join_query = array();
    $join_where = array();
    $join_verified = array();
    $rows_ord = array();
    $join = '';
    $query = $wpdb->prepare("SELECT `group_id`,`element_value` FROM " . $wpdb->prefix . "formmaker_submits  WHERE `form_id`='%d' and `element_label` = 'verifyinfo' ", $form_id);
    $ver_emails_data = $wpdb->get_results($query);
    $ver_emails_array = array();
    if ( $ver_emails_data ) {
      foreach ( $ver_emails_data as $ver_email ) {
        $elem_label = str_replace('verified**', '', $ver_email->element_value);
        $query = $wpdb->prepare("SELECT `element_value` FROM " . $wpdb->prefix . "formmaker_submits  WHERE `form_id`='%d' AND `group_id` = '%d' AND `element_label` = '%s' ", $form_id, (int) $ver_email->group_id, $elem_label);
        if ( !isset($ver_emails_array[$elem_label]) ) {
          $ver_emails_array[$elem_label] = array();
        }
        if ( !in_array($wpdb->get_var($query), $ver_emails_array[$elem_label]) ) {
          $ver_emails_array[$elem_label][] = $wpdb->get_var($query);
        }
      }
    }
    for ( $i = 0; $i < 9; $i++ ) {
      array_push($labels_parameters, NULL);
    }
    $sorted_label_names = array();
    $sorted_label_names_original = array();
    $where_labels = array();
    $where2 = array();
    $order_by = ((isset($_POST['order_by']) && esc_html(stripslashes($_POST['order_by'])) != '') ? esc_html(stripslashes($_POST['order_by'])) : 'group_id');
    $asc_or_desc = ((isset($_POST['asc_or_desc']) && $_POST['asc_or_desc'] == 'asc') ? 'asc' : 'desc');

    $lists['hide_label_list'] = ((isset($_POST['hide_label_list'])) ? esc_html(stripslashes($_POST['hide_label_list'])) : '');
    $lists['startdate'] = ((isset($_POST['startdate'])) ? esc_html(stripslashes($_POST['startdate'])) : '');
    $lists['enddate'] = ((isset($_POST['enddate'])) ? esc_html(stripslashes($_POST['enddate'])) : '');
    $lists['ip_search'] = ((isset($_POST['ip_search'])) ? esc_html(stripslashes($_POST['ip_search'])) : '');
    $lists['username_search'] = ((isset($_POST['username_search'])) ? esc_html(stripslashes($_POST['username_search'])) : '');
    $lists['useremail_search'] = ((isset($_POST['useremail_search'])) ? esc_html(stripslashes($_POST['useremail_search'])) : '');
    $lists['id_search'] = ((isset($_POST['id_search'])) ? esc_html(stripslashes($_POST['id_search'])) : '');
    if ( $lists['ip_search'] ) {
      $where[] = 'ip LIKE "%' . $lists['ip_search'] . '%"';
    }
    if ( $lists['startdate'] != '' ) {
      $where[] = " `date`>='" . $lists['startdate'] . " 00:00:00' ";
    }
    if ( $lists['enddate'] != '' ) {
      $where[] = " `date`<='" . $lists['enddate'] . " 23:59:59' ";
    }
    if ( $lists['username_search'] ) {
      $where[] = 'user_id_wd IN (SELECT ID FROM ' . $wpdb->prefix . 'users WHERE display_name LIKE "%' . $lists['username_search'] . '%")';
    }
    if ( $lists['useremail_search'] ) {
      $where[] = 'user_id_wd IN (SELECT ID FROM ' . $wpdb->prefix . 'users WHERE user_email LIKE "%' . $lists['useremail_search'] . '%")';
    }
    if ( $lists['id_search'] ) {
      $where[] = 'group_id =' . (int) $lists['id_search'];
    }
    $where[] = 'form_id=' . $form_id . '';
    $where = (count($where) ? ' ' . implode(' AND ', $where) : '');
    if ( $order_by == 'group_id' or $order_by == 'date' or $order_by == 'ip' ) {
      $orderby = ' ORDER BY ' . $order_by . ' ' . $asc_or_desc . '';
    }
    elseif ( $order_by == 'display_name' or $order_by == 'user_email' ) {
      $orderby = ' ORDER BY (SELECT ' . $order_by . ' FROM ' . $wpdb->prefix . 'users WHERE ID=user_id_wd) ' . $asc_or_desc . '';
    }
    else {
      $orderby = "";
    }
    if ( $form_id ) {
      for ( $i = 0; $i < 9; $i++ ) {
        array_pop($labels_parameters);
      }
      $query = "SELECT distinct element_label FROM " . $wpdb->prefix . "formmaker_submits WHERE " . $where;
      $results = $wpdb->get_results($query);
      for ( $i = 0; $i < count($results); $i++ ) {
        array_push($labels, $results[$i]->element_label);
      }
      $form = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "formmaker WHERE id='%d'", $form_id));
      if ( !empty($form->label_order) && strpos($form->label_order, 'type_paypal_') ) {
        $form->label_order = $form->label_order . "item_total#**id**#Item Total#**label**#type_paypal_payment_total#****#total#**id**#Total#**label**#type_paypal_payment_total#****#0#**id**#Payment Status#**label**#type_paypal_payment_status#****#";
      }
      if ( !empty($form->label_order)) {
        $form_labels = explode('#****#', $form->label_order);
      }
      $form_labels = array_slice($form_labels, 0, count($form_labels) - 1);
      foreach ( $form_labels as $key => $form_label ) {
        $label_id = explode('#**id**#', $form_label);
        array_push($labels_id, $label_id[0]);
        $label_name_type = explode('#**label**#', $label_id[1]);
        array_push($label_names_original, $label_name_type[0]);
        $ptn = "/[^a-zA-Z0-9_]/";
        $rpltxt = "";
        $label_name = preg_replace($ptn, $rpltxt, $label_name_type[0]);
        array_push($label_names, $label_name);
        array_push($label_types, $label_name_type[1]);
      }
      foreach ( $labels_id as $key => $label_id ) {
        if ( in_array($label_id, $labels) ) {
          if ( !in_array($label_id, $sorted_labels_id) ) {
            array_push($sorted_labels_id, $label_id);
          }
          array_push($sorted_label_names, $label_names[$key]);
          array_push($sorted_label_types, $label_types[$key]);
          array_push($sorted_label_names_original, $label_names_original[$key]);
          if ( isset($_POST[$form_id . '_' . $label_id . '_search']) ) {
            $search_temp = esc_html($_POST[$form_id . '_' . $label_id . '_search']);
          }
          else {
            $search_temp = '';
          }
          $search_temp = strtolower($search_temp);
          $lists[$form_id . '_' . $label_id . '_search'] = $search_temp;
          if ( $search_temp ) {
            $join_query[] = 'search';
            $join_where[] = array( 'label' => $label_id, 'search' => $search_temp );
          }
          if ( isset($_POST[$form_id . '_' . $label_id . '_search_verified']) ) {
            $search_verified = $_POST[$form_id . '_' . $label_id . '_search_verified'];
            $lists[$form_id . '_' . $label_id . '_search_verified'] = $search_verified;
          }
          else {
            $search_verified = '';
          }
          if ( $search_verified && isset($ver_emails_array[$label_id]) ) {
            $join_query[] = 'search';
            $join_where[] = NULL;
            $join_verified[] = array(
              'label' => $label_id,
              'ver_search' => implode('|', $ver_emails_array[$label_id]),
            );
          }
        }
      }
      if ( strpos($order_by, "_field") ) {
        if ( in_array(str_replace("_field", "", $order_by), $labels) ) {
          $join_query[] = 'sort';
          $join_where[] = array( 'label' => str_replace("_field", "", $order_by) );
        }
      }
      $cols = 'group_id';
      if ( $order_by == 'date' or $order_by == 'ip' ) {
        $cols = 'group_id, date, ip';
      }
      $ver_where = '';
      if ( !empty($join_verified) ) {
        foreach ( $join_verified as $key_ver => $join_ver ) {
          $ver_where .= '(element_label="' . $join_ver['label'] . '" AND element_value REGEXP "' . $join_ver['ver_search'] . '" ) AND';
        }
      }
      switch ( count($join_query) ) {
        case 0:
          $join = 'SELECT distinct group_id FROM ' . $wpdb->prefix . 'formmaker_submits WHERE ' . $where;
          break;
        case 1:
          if ( $join_query[0] == 'sort' ) {
            $join = 'SELECT group_id FROM ' . $wpdb->prefix . 'formmaker_submits WHERE ' . $where . ' AND element_label="' . $join_where[0]['label'] . '" ';
            $join_count = 'SELECT count(group_id) FROM ' . $wpdb->prefix . 'formmaker_submits WHERE form_id="' . $form_id . '" AND element_label="' . $join_where[0]['label'] . '" ';
            $orderby = ' ORDER BY `element_value` ' . $asc_or_desc;
          }
          else {
            if ( isset($join_where[0]['search']) ) {
              $join = 'SELECT group_id FROM ' . $wpdb->prefix . 'formmaker_submits WHERE element_label="' . $join_where[0]['label'] . '" AND  (element_value LIKE "%' . $join_where[0]['search'] . '%" OR element_value LIKE "%' . str_replace(' ', '@@@', $join_where[0]['search']) . '%")  AND ' . $where;
            }
            else {
              $join = 'SELECT group_id FROM ' . $wpdb->prefix . 'formmaker_submits WHERE  ' . $ver_where . $where;
            }
          }
          break;
        default:
          if ( !empty($join_verified) ) {
            if ( isset($join_where[0]['search']) ) {
              $join = 'SELECT t.group_id from (SELECT t1.group_id from (SELECT ' . $cols . ' FROM ' . $wpdb->prefix . 'formmaker_submits WHERE (element_label="' . $join_where[0]['label'] . '" AND (element_value LIKE "%' . $join_where[0]['search'] . '%" OR element_value LIKE "%' . str_replace(' ', '@@@', $join_where[0]['search']) . '%")) AND ' . $where . ' ) as t1 JOIN (SELECT group_id FROM ' . $wpdb->prefix . 'formmaker_submits WHERE  ' . $ver_where . $where . ') as t2 ON t1.group_id = t2.group_id) as t ';
            }
            else {
              $join = 'SELECT t.group_id FROM (SELECT ' . $cols . '  FROM ' . $wpdb->prefix . 'formmaker_submits WHERE ' . $ver_where . $where . ') as t ';
            }
          }
          else {
            $join = 'SELECT t.group_id FROM (SELECT ' . $cols . '  FROM ' . $wpdb->prefix . 'formmaker_submits WHERE ' . $where . ' AND element_label="' . $join_where[0]['label'] . '" AND  (element_value LIKE "%' . $join_where[0]['search'] . '%" OR element_value LIKE "%' . str_replace(' ', '@@@', $join_where[0]['search']) . '%" )) as t ';
          }
          for ( $key = 1; $key < count($join_query); $key++ ) {
            if ( $join_query[$key] == 'sort' ) {
              if ( isset($join_where[$key]) ) {
                $join .= 'LEFT JOIN (SELECT group_id as group_id' . $key . ', element_value   FROM ' . $wpdb->prefix . 'formmaker_submits WHERE ' . $where . ' AND element_label="' . $join_where[$key]['label'] . '") as t' . $key . ' ON t' . $key . '.group_id' . $key . '=t.group_id ';
                $orderby = ' ORDER BY t' . $key . '.`element_value` ' . $asc_or_desc . '';
              }
            }
            else {
              if ( isset($join_where[$key]) ) {
                $join .= 'INNER JOIN (SELECT group_id as group_id' . $key . ' FROM ' . $wpdb->prefix . 'formmaker_submits WHERE ' . $where . ' AND element_label="' . $join_where[$key]['label'] . '" AND  (element_value LIKE "%' . $join_where[$key]['search'] . '%" OR element_value LIKE "%' . str_replace(' ', '@@@', $join_where[$key]['search']) . '%")) as t' . $key . ' ON t' . $key . '.group_id' . $key . '=t.group_id ';
              }
            }
          }
          break;
      }
      $pos = strpos($join, 'SELECT t.group_id');
      if ( $pos === FALSE ) {
        $query = str_replace(array(
                               'SELECT group_id',
                               'SELECT distinct group_id',
                             ), array( 'SELECT count(distinct group_id)', 'SELECT count(distinct group_id)' ), $join);
      }
      else {
        $query = str_replace('SELECT t.group_id', 'SELECT count(t.group_id)', $join);
      }
      $total = $wpdb->get_var($query);
      $query_sub_count = "SELECT count(distinct group_id) from " . $wpdb->prefix . "formmaker_submits";
      $sub_count = (int) $wpdb->get_var($query_sub_count);
      $query = $join . ' ' . $orderby . ' LIMIT ' . $page_num . ', '.$per_num;
      $results = $wpdb->get_results($query);
      for ( $i = 0; $i < count($results); $i++ ) {
        array_push($rows_ord, $results[$i]->group_id);
      }
      $query1 = $join . ' ' . $orderby;
      $searched_group_ids = $wpdb->get_results($query1);
      $searched_ids = array();
      for ( $i = 0; $i < count($searched_group_ids); $i++ ) {
        array_push($searched_ids, $searched_group_ids[$i]->group_id);
      }
      $where2 = array();
      $where2[] = "group_id='0'";
      foreach ( $rows_ord as $rows_ordd ) {
        $where2[] = "group_id='" . $rows_ordd . "'";
      }
      $where2 = (count($where2) ? ' WHERE ' . implode(' OR ', $where2) . '' : '');
      $query = 'SELECT * FROM ' . $wpdb->prefix . 'formmaker_submits ' . $where2;
      $rows = $wpdb->get_results($query);
      $group_ids = $rows_ord;
      $lists['total'] = $total;
      $lists['limit'] = $per_num;
      $where_choices = $where;
      array_push($labels_parameters, $sorted_labels_id);
      array_push($labels_parameters, $sorted_label_types);
      array_push($labels_parameters, $lists);
      array_push($labels_parameters, $sorted_label_names);
      array_push($labels_parameters, $sorted_label_names_original);
      array_push($labels_parameters, $rows);
      array_push($labels_parameters, $group_ids);
      array_push($labels_parameters, $where_choices);
      array_push($labels_parameters, $searched_ids);
    }

    return $labels_parameters;
  }

  /**
   * Encode a given string with the QUOTED_PRINTABLE mechanism and wrap the lines.
   *
   * @param  string $str
   * @param  int    $lineLength Line length; defaults to {@link LINELENGTH}
   * @param  string $lineEnd    Line end; defaults to {@link LINEEND}
   *
   * @return string
   */
  public static function encodeQuotedPrintable( $str, $lineLength = self::LINELENGTH, $lineEnd = self::LINEEND ) {
    $out = '';
    $str = self::_encodeQuotedPrintable($str);
    // Split encoded text into separate lines
    while ( strlen($str) > 0 ) {
      $ptr = strlen($str);
      if ( $ptr > $lineLength ) {
        $ptr = $lineLength;
      }
      // Ensure we are not splitting across an encoded character
      $pos = strrpos(substr($str, 0, $ptr), '=');
      if ( $pos !== FALSE && $pos >= $ptr - 2 ) {
        $ptr = $pos;
      }
      // Check if there is a space at the end of the line and rewind
      if ( $ptr > 0 && $str[$ptr - 1] == ' ' ) {
        --$ptr;
      }
      // Add string and continue
      $out .= substr($str, 0, $ptr) . '=' . $lineEnd;
      $str = substr($str, $ptr);
    }
    $out = rtrim($out, $lineEnd);
    $out = rtrim($out, '=');

    return $out;
  }

  /**
   * Converts a string into quoted printable format.
   *
   * @param  string $str
   *
   * @return string
   */
  private static function _encodeQuotedPrintable( $str ) {
    $str = str_replace('=', '=3D', $str);
    $str = str_replace(self::$qpKeys, self::$qpReplaceValues, $str);
    $str = rtrim($str);

    return $str;
  }

  /**
   * decode a quoted printable encoded string
   * The charset of the returned string depends on your iconv settings.
   *
   * @param  string $string Encoded string
   *
   * @return string         Decoded string
   */
  public static function decodeQuotedPrintable( $string ) {
    return quoted_printable_decode($string);
  }
}

/*
* 	Rre.
*
*	@param array 	$data
*	@param boolean 	$e
*
* 	@return string	$data
*/
if (!function_exists('pre')) {
  function pre($data = false, $e = false)
  {
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    print "<pre><xmp>";
    print_r($data);
    print "\r\n Called in : " . $caller['file'] . ", At line:" . $caller['line'];
    echo "</xmp></pre>\n";
    if ($e) { exit; }
  }
}

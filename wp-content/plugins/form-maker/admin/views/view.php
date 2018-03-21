<?php
defined('ABSPATH') || die('Access Denied');

/**
 * Admin view class.
 */
class FMAdminView {
  /**
   * Generate form.
   *
   * @param string $content
   * @param array  $attr
   *
   * @return string Form html.
   */
  protected function form($content = '', $attr = array()) {
    ob_start();
    // Form.
    $action = isset($attr['action']) ? esc_attr($attr['action']) : '';
    $method = isset($attr['method']) ? esc_attr($attr['method']) : 'post';
    $name = isset($attr['name']) ? esc_attr($attr['name']) : WDFM()->prefix . '_form';
    $id = isset($attr['id']) ? esc_attr($attr['id']) : '';
    $class = isset($attr['class']) ? esc_attr($attr['class']) : WDFM()->prefix . '_form';
    $style = isset($attr['style']) ? esc_attr($attr['style']) : '';
    $current_id = isset($attr['current_id']) ? esc_attr($attr['current_id']) : '';
    ?><div class="wrap">
    <?php
    // Generate message container by message id or directly by message.
    $message_id = WDW_FM_Library::get('message', 0);
    $message = WDW_FM_Library::get('msg', '');
    echo WDW_FM_Library::message_id($message_id, $message);
    ?>
      <form
          <?php echo $action ? 'action="' . $action . '"' : ''; ?>
          <?php echo $method ? 'method="' . $method . '"' : ''; ?>
          <?php echo $name ? ' name="' . $name . '"' : ''; ?>
          <?php echo $id ? ' id="' . $id . '"' : ''; ?>
          <?php echo $class ? ' class="' . $class . '"' : ''; ?>
          <?php echo $style ? ' style="' . $style . '"' : ''; ?>
      ><?php
      echo $content;
      // Add nonce to form.
      wp_nonce_field(WDFM()->nonce, WDFM()->nonce);
        ?>
        <input id="task" name="task" type="hidden" value=""/>
        <input id="current_id" name="current_id" type="hidden" value="<?php echo $current_id; ?>"/>
      </form>
    </div><?php
    return ob_get_clean();
  }

  /**
   * Generate title.
   *
   * @param array $params
   *
   * @return string Title html.
   */
  protected function title($params) {
    $title = !empty($params['title']) ? $params['title'] : '';
    $title_class = !empty($params['title_class']) ? $params['title_class'] : '';
    $title_name = !empty($params['title_name']) ? $params['title_name'] : '';
    $title_id = !empty($params['title_id']) ? $params['title_id'] : '';
    $title_value = !empty($params['title_value']) ? $params['title_value'] : '';
		$add_new_button = !empty($params['add_new_button']) ? $params['add_new_button'] : '';

	$attributes = '';
    if ( !empty($add_new_button) && is_array($add_new_button) ) {
      foreach ( $add_new_button as $key => $val ) {
        $attributes .= $key . '="' . $val . '"';
      }
    }

    ob_start();
    ?><div class="wd-page-title <?php echo $title_class; ?>">
      <h1 class="wp-heading-inline"><?php echo $title; ?>
      <?php
      if ( $title_name || $title_id || $title_value ) {
        ?>
        <span id="fm-title-edit">
          <input type="text" id="<?php echo $title_id; ?>" name="<?php echo $title_name; ?>" value="<?php echo $title_value; ?>" />
        </span>
        <?php
      }
      if ( $add_new_button ) {
        ?>
        <a class="page-title-action" <?php echo $attributes; ?>>
          <?php _e('Add New', WDFM()->prefix); ?>
        </a>
        <?php
      }
      ?>
      </h1>
    </div><?php
    return ob_get_clean();
  }

  /**
   * Generate buttons.
   *
   * @param array $buttons
   * @param bool $single
   * @param array $parent
   *
   * @return array Buttons html.
   */
  protected function buttons($buttons = array(), $single = FALSE, $parent = array()) {
    ob_start();
    if ( !$single ) {
      $parent_id = isset($parent['id']) ? esc_attr($parent['id']) : '';
      $parent_class = isset($parent['class']) ? esc_attr($parent['class']) : 'wd-buttons';
      $parent_style = isset($parent['style']) ? esc_attr($parent['style']) : '';
      ?>
    <div
      <?php echo $parent_id ? 'id="' . $parent_id . '"' : ''; ?>
      <?php echo $parent_class ? ' class="' . $parent_class . '"' : ''; ?>
      <?php echo $parent_style ? ' style="' . $parent_style . '"' : ''; ?>
      >
      <?php
    }
    foreach ($buttons as $button) {
      $title = isset($button['title']) ? esc_attr($button['title']) : '';
      $value = isset($button['value']) ? esc_attr($button['value']) : '';
      $name = isset($button['name']) ? esc_attr($button['name']) : '';
      $id = isset($button['id']) ? esc_attr($button['id']) : '';
      $class = isset($button['class']) ? esc_attr($button['class']) : '';
      $style = isset($button['style']) ? esc_attr($button['style']) : '';
      $onclick = isset($button['onclick']) ? esc_attr($button['onclick']) : '';
      ?><button type="submit"
               <?php echo $value ? ' value="' . $value . '"' : ''; ?>
               <?php echo $name ? ' name="' . $name . '"' : ''; ?>
               <?php echo $id ? ' id="' . $id . '"' : ''; ?>
               class="wd-button <?php echo $class; ?>"
               <?php echo $style ? ' style="' . $style . '"' : ''; ?>
               <?php echo $onclick ? ' onclick="' . $onclick . '"' : ''; ?>
         ><?php echo $title; ?></button><?php
    }
    if ( !$single ) {
      ?>
    </div>
      <?php
    }
    return ob_get_clean();
  }

  /**
   * Search.
   *
   * @return string
   */
  protected function search() {
    $search = WDW_FM_Library::get('s', '');
    ob_start();
    ?>
    <p class="search-box">
      <input name="s" value="<?php echo $search; ?>" type="search" onkeypress="return input_search(event, this)" />
      <input class="button" value="<?php _e('Search', WDFM()->prefix); ?>" type="button" onclick="search(this)" />
    </p>
    <?php

    return ob_get_clean();
  }

  /**
   * Pagination.
   *
   * @param     $page_url
   * @param     $total
   * @param int $items_per_page
   *
   * @return string
   */
  protected function pagination($page_url, $total, $items_per_page = 20) {
    $page_number = WDW_FM_Library::get('paged', 1);
    $search = WDW_FM_Library::get('s', '');
    $orderby = WDW_FM_Library::get('orderby', '');
    $order = WDW_FM_Library::get('order', '');
	$url_arg = array();
	if( !empty($search) ) {
		$url_arg['s'] = $search;
	}
	if( !empty($orderby) ) {
		$url_arg['orderby'] = $orderby;
	}
	if( !empty($order) ) {
		$url_arg['order'] = $order;
	}
    $page_url = add_query_arg($url_arg, $page_url);
	  
    if ( $total ) {
      if ( $total % $items_per_page ) {
        $pages_count = ($total - $total % $items_per_page) / $items_per_page + 1;
      }
      else {
        $pages_count = ($total - $total % $items_per_page) / $items_per_page;
      }
    }
    else {
      $pages_count = 1;
    }
    ob_start();
    ?>
    <div class="tablenav-pages">
      <span class="displaying-num">
        <?php printf(_n('%s item', '%s items', $total, WDFM()->prefix), $total); ?>
      </span>
      <?php
      if ( $total > $items_per_page ) {
        ?>
      <span class="pagination-links" data-pages-count="<?php echo $pages_count; ?>">
        <?php
        if ( $page_number == 1 ) {
          ?>
          <span class="tablenav-pages-navspan" aria-hidden="true">«</span>
          <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
          <?php
        }
        else {
          ?>
          <a href="<?php echo add_query_arg(array('paged' => 1), $page_url); ?>" class="first-page"><span class="screen-reader-text"><?php _e('First page', WDFM()->prefix); ?></span><span aria-hidden="true">«</span></a>
          <a href="<?php echo add_query_arg(array('paged' => ($page_number == 1 ? 1 : ($page_number - 1))), $page_url); ?>" class="previous-page"><span class="screen-reader-text"><?php _e('Previous page', WDFM()->prefix); ?></span><span aria-hidden="true">‹</span></a>
          <?php
        }
        ?>
        <span class="paging-input">
          <label for="current-page-selector" class="screen-reader-text"><?php _e('Current Page', WDFM()->prefix); ?></label>
          <input type="text" class="current-page" name="current_page" value="<?php echo $page_number; ?>" onkeypress="return input_pagination(event, this)" size="1" />
          <span class="tablenav-paging-text">
             <?php _e('of', WDFM()->prefix); ?>
            <span class="total-pages"><?php echo $pages_count; ?></span>
          </span>
        </span>
        <?php
        if ( $page_number >= $pages_count ) {
          ?>
          <span class="tablenav-pages-navspan" aria-hidden="true">›</span>
          <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
          <?php
        }
        else {
          ?>
          <a href="<?php echo add_query_arg(array('paged' => ($page_number >= $pages_count ? $pages_count : ($page_number + 1))), $page_url); ?>" class="next-page"><span class="screen-reader-text"><?php _e('Next page', WDFM()->prefix); ?></span><span aria-hidden="true">›</span></a>
          <a href="<?php echo add_query_arg(array('paged' => $pages_count), $page_url); ?>" class="last-page"><span class="screen-reader-text"><?php _e('Last page', WDFM()->prefix); ?></span><span aria-hidden="true">»</span></a>
          <?php
        }
        ?>
      </span>
        <?php
      }
      ?>
    </div>
    <?php

    return ob_get_clean();
  }

  protected function bulk_actions($actions) {
    ob_start();
    ?>
    <div class="alignleft actions bulkactions">
      <label for="bulk-action-selector-top" class="screen-reader-text"><?php _e('Select bulk action', WDFM()->prefix); ?></label>
      <select name="bulk_action" id="bulk-action-selector-top">
        <option value="-1"><?php _e('Bulk Actions', WDFM()->prefix); ?></option>
        <?php
        foreach ( $actions as $key => $action ) {
          ?>
          <option value="<?php echo $key; ?>"><?php echo $action['title']; ?></option>
          <?php
        }
        ?>
      </select>
      <input type="button" id="doaction" class="button action" onclick="wd_bulk_action(this)" value="<?php _e('Apply', WDFM()->prefix); ?>" />
    </div>
    <?php

    return ob_get_clean();
  }

  function import_popup_div() {
    if (WDFM()->is_free != 2) {
      do_action('fm_popup_import_content');
    }
  }
}

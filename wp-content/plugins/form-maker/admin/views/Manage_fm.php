<?php

class FMViewManage_fm extends FMAdminView {
  /**
   * FMViewManage_fm constructor.
   */
  public function __construct() {
    wp_enqueue_style('fm-tables');
    wp_enqueue_style('fm-first');
    wp_enqueue_style('fm-style');
    wp_enqueue_style('fm-layout');

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('fm-admin');
    wp_enqueue_script('fm-manage');
    /*$inline_styles = '#fm_admin_container .wdform_page .wdform_section .wdform_column.ui-sortable:empty:last-child:after {
  content: "' . __('Drop a field here to create a column.', WDFM()->prefix) . '";
}';
    wp_add_inline_style('fm-style', $inline_styles);*/
  }

  /**
   * Display page.
   */
  public function display($params) {
	$this->import_popup_div();
    ob_start(); 	
    echo $this->body($params);
    // Pass the content to form.
    $form_attr = array(
      'id' => 'manage_form',
      'class' =>'wd-form',
      'action' => add_query_arg(array('page' => 'manage' . WDFM()->menu_postfix), 'admin.php'),
    );
    echo $this->form(ob_get_clean(), $form_attr);
  }

  /**
   * Generate page body.
   *
   * @return string Body html.
   */
  public function body($params) {
    $page = $params['page'];
    $actions = $params['actions'];
    $form_preview_link = $params['form_preview_link'];
    $rows_data = $params['rows_data'];
    $total = $params['total'];
    $order = $params['order'];
    $orderby = $params['orderby'];
    $items_per_page = $params['items_per_page'];

    $page_url = add_query_arg(array(
                                'page' => $page,
                                WDFM()->nonce => wp_create_nonce(WDFM()->nonce),
                              ), admin_url('admin.php'));
    echo $this->title(array(
                        'title' => __('Forms', WDFM()->prefix),
                        'title_class' => 'wd-header',
                        'add_new_button' => array(
                          'href' => add_query_arg(array( 'page' => $page, 'task' => 'add' ), admin_url('admin.php')),
                        ),
                      ));
    echo $this->search();
    ?>
    <div class="tablenav top">
      <?php
      echo $this->bulk_actions($actions);
      if (WDFM()->is_free != 2) {
        echo $this->exp_imp_buttons();
      }
      echo $this->pagination($page_url, $total, $items_per_page);
      ?>
    </div>

    <table class="adminlist table table-striped wp-list-table widefat fixed pages">
      <thead>
        <tr>
          <td id="cb" class="manage-column column-cb check-column">
            <label class="screen-reader-text" for="cb-select-all-1"><?php _e('Select all', WDFM()->prefix); ?></label>
            <input id="check_all" type="checkbox" />
          </td>
          <?php echo WDW_FM_Library::ordering('title', $orderby, $order, __('Title', WDFM()->prefix), $page_url, 'col_title column-primary wd-left'); ?>
          <?php echo WDW_FM_Library::ordering('type', $orderby, $order, __('Type', WDFM()->prefix), $page_url, 'col_type wd-left'); ?>
          <th class="col_count wd-left"><?php _e('Submissions', WDFM()->prefix); ?></th>
          <?php echo WDW_FM_Library::ordering('id', $orderby, $order, __('Shortcode', WDFM()->prefix), $page_url, 'wd-center'); ?>
          <th class="col_function wd-center"><?php _e('PHP function', WDFM()->prefix); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ( $rows_data ) {
          foreach ( $rows_data as $row_data ) {
            $alternate = (!isset($alternate) || $alternate == '') ? 'class="alternate"' : '';
            $old = isset($row_data->form) && ($row_data->form != '');

            $edit_url = add_query_arg(array( 'page' => $page, 'task' => 'edit', 'current_id' => $row_data->id ), admin_url('admin.php'));
            $duplicate_url = add_query_arg(array('task' => 'duplicate', 'current_id' => $row_data->id), $page_url);
            $publish_url = add_query_arg(array('task' => ($row_data->published ? 'unpublish' : 'publish'), 'current_id' => $row_data->id), $page_url);
            $delete_url = add_query_arg(array('task' => 'delete', 'current_id' => $row_data->id), $page_url);
            $preview_url = add_query_arg( array('wdform_id' => $row_data->id), $form_preview_link );
            ?>
            <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
              <th class="check-column">
                <input id="check_<?php echo $row_data->id; ?>" name="check[<?php echo $row_data->id; ?>]" type="checkbox" class="form_title"  data-id="<?php echo $row_data->id; ?>" />
              </th>
              <td class="column-primary" data-colname="<?php _e('Title', WDFM()->prefix); ?>">
                <strong>
                  <?php
                  if ( !$old ) {
                   ?>
                  <a href="<?php echo $edit_url; ?>">
                    <?php echo $row_data->title; ?>
                  </a>
                    <?php
                  }
                  else {
                    echo $row_data->title;
                  }
                  ?>
                  <?php
                  if ( !$row_data->published ) {
                    ?>
                    —
                    <span class="post-state"><?php _e('Unpublished', WDFM()->prefix); ?></span>
                    <?php
                  }
                  ?>
                </strong>
                <div class="row-actions">
                  <?php
                  if ( !$old ) {
                    ?>
                  <span>
                    <a href="<?php echo $edit_url; ?>"><?php _e('Edit', WDFM()->prefix); ?></a>
                    |
                  </span>
                    <?php
                  }
                  ?>
                  <span>
                    <a href="<?php echo $duplicate_url; ?>"><?php _e('Duplicate', WDFM()->prefix); ?></a>
                    |
                  </span>
                  <span>
                    <a href="<?php echo $publish_url; ?>"><?php echo ($row_data->published ? __('Unpublish', WDFM()->prefix) : __('Publish', WDFM()->prefix)); ?></a>
                    |
                  </span>
                  <span class="trash">
                    <a onclick="if (!confirm('<?php echo addslashes(__('Do you want to delete selected item?', WDFM()->prefix)); ?>')) {return false;}" href="<?php echo $delete_url; ?>"><?php _e('Delete', WDFM()->prefix); ?></a>
                    |
                  </span>
                  <span>
                   <a href="<?php echo $preview_url; ?>" target="_blank"><?php _e('Preview', WDFM()->prefix); ?></a>
                  </span>
                </div>
                <button class="toggle-row" type="button">
                  <span class="screen-reader-text"><?php _e('Show more details', WDFM()->prefix); ?></span>
                </button>
              </td>
              <td data-colname="<?php _e('Type', WDFM()->prefix); ?>">
                <?php echo ucfirst($row_data->type); ?>
                <div class="row-actions">
                  <span>
                    <a href="<?php echo add_query_arg(array('task' => 'display_options', 'current_id' => $row_data->id), $page_url); ?>"><?php _e('Set display options', WDFM()->prefix); ?></a>
                  </span>
                </div>
              </td>
              <td data-colname="<?php _e('Submissions', WDFM()->prefix); ?>">
                <?php
                if ($row_data->submission_count != 0) {
                  ?>
                <a title="<?php _e('View sumbissions', WDFM()->prefix); ?>" target="_blank" href="<?php echo add_query_arg(array(
                                                                    'page' => 'submissions' . WDFM()->menu_postfix,
                                                                    'task' => 'display',
                                                                    'current_id' => $row_data->id,
                                                                  ), admin_url('admin.php')); ?>">
                  <?php
                }
                echo $row_data->submission_count;
                if ($row_data->submission_count != 0) {
                  ?>
                </a>
                  <?php
                }
              ?>
              </td>
              <td data-colname="<?php _e('Shortcode', WDFM()->prefix); ?>">
                <input type="text" value='[Form id="<?php echo $row_data->id; ?>"]' onclick="fm_select_value(this)" size="12" readonly="readonly" />
              </td>
              <td data-colname="<?php _e('PHP function', WDFM()->prefix); ?>">
                <input type="text" value='&#60;?php wd_form_maker(<?php echo $row_data->id; ?>, "<?php echo $row_data->type; ?>"); ?&#62;' onclick="fm_select_value(this)"  readonly="readonly" />
              </td>
            </tr>
            <?php
          }
        }
        else {
          echo WDW_FM_Library::no_items('forms');
        }
        ?>
      </tbody>
    </table>
	<?php
	}
	
	function exp_imp_buttons() {
		$buttons_action = apply_filters('imp_exp_buttons', array());
		$list = "<div class='ei_buttons'>";

		foreach( $buttons_action as $buttons_action_key => $buttons_action_value ) {
			$list .= '<a '.$buttons_action_value.' >' . $buttons_action_key . '</a>';
		}
		$list .= "</div>";
		return $list;
	}

	public function edit($params) {
		wp_enqueue_style('thickbox');
		wp_enqueue_style('fm-phone_field_css');
		wp_enqueue_style('fm-jquery-ui');
		wp_enqueue_style('fm-codemirror');
		wp_enqueue_style('fm-colorpicker');

		wp_enqueue_script('thickbox');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-spinner');
		wp_enqueue_script('jquery-ui-datepicker');
    if ( function_exists('wp_add_inline_script') ) { // Since Wordpress 4.5.0
      wp_add_inline_script('jquery-ui-datepicker', WDW_FM_Library::localize_ui_datepicker());
    }
    else {
      echo '<script>' . WDW_FM_Library::localize_ui_datepicker() . '</script>';
    }
		wp_enqueue_media();
		wp_enqueue_script('google-maps');
		wp_enqueue_script('fm-gmap_form');
		wp_enqueue_script('fm-phone_field');
		wp_enqueue_script('fm-formmaker_div');
		wp_enqueue_script('fm-codemirror');
		wp_enqueue_script('fm-formatting');
		wp_enqueue_script('fm-clike');
		wp_enqueue_script('fm-css');
		wp_enqueue_script('fm-javascript');
		wp_enqueue_script('fm-xml');
		wp_enqueue_script('fm-php');
		wp_enqueue_script('fm-htmlmixed');
		wp_enqueue_script('fm-colorpicker');
		wp_enqueue_script('fm-manage-edit');
		wp_enqueue_script('fm-add-fields');

		$id = $params['id'];
		$row = $params['row'];
		$page_title = $params['page_title'];
		$page_url = $params['page_url'];

		$themes 	= $params['themes'];
		$default_theme = $params['default_theme'];
		$labels = $params['labels'];
		$form_preview_link = $params['form_preview_link'];
		$animation_effects = $params['animation_effects'];

		$stripe_addon = $params['stripe_addon']; 

		if ( isset($row->backup_id) ) {
			if ( $row->backup_id != "" ) {
				$next_backup_id = $params['next_backup_id'];
				$prev_backup_id = $params['prev_backup_id'];
			}
		}
		?>	
		<script type="text/javascript">
			gen = <?php echo $row->counter; ?>;
			is_sortable = <?php echo $row->sortable ?>;	
			is_addon_calculator_active = <?php echo (defined('WD_FM_CALCULATOR') && is_plugin_active(constant('WD_FM_CALCULATOR'))) ? 1 : 0; ?>;
			is_addon_stripe_active = <?php echo $stripe_addon['enable'] ? 1 : 0; ?>;
			is_stripe_enabled = <?php echo ($stripe_addon['enable'] && $stripe_addon['stripe_enable'] ? 1 : 0); ?>;
			labels_id_array = [<?php echo $labels['id']; ?>];
      labels_label_array = [<?php echo $labels['label']; ?>];
      labels_type_array = [<?php echo $labels['type']; ?>];

			form_view = 1;
			form_view_count = 1;
			form_view_max = 1;
      form_fields_initial = '<?php echo rawurlencode($row->form_fields); ?>';
      form_fields_initial = decodeURIComponent(form_fields_initial);

      default_theme  = '<?php echo $default_theme; ?>';
			theme_edit_url = '<?php echo add_query_arg( array('page' => 'themes' . WDFM()->menu_postfix, 'task' =>'edit'), $page_url); ?>';
			jQuery(document).ready(function () {
				set_theme();
			});
		</script>
		<form class="wrap" id="manage_form" method="post" autocomplete="off" action="admin.php?page=manage<?php echo WDFM()->menu_postfix; ?>">
      <?php
      // Generate message container by message id or directly by message.
      $message_id = WDW_FM_Library::get('message', 0);
      $message = WDW_FM_Library::get('msg', '');
      echo WDW_FM_Library::message_id($message_id, $message);
      ?>
			<?php wp_nonce_field(WDFM()->nonce, WDFM()->nonce); ?>
			<h2 class="fm-h2-message"></h2>
			<div class="fm-page-header">
				<div class="wd-page-title wd-header">
					<h1 class="wp-heading-inline"><?php _e('Form Title', WDFM()->prefix); ?></h1>
					<input id="title" name="title" value="<?php echo $row->title; ?>" data-initial-value="<?php echo $row->title; ?>" class="fm-check-change" type="text" />
					<div class="fm-page-actions">
					<?php
						if ( isset($row->backup_id) ) {
						  if ( $row->backup_id != "" ) {
							$backup_id = $next_backup_id;
							if ( $backup_id ) { ?>
							  <button class="button redo-button button-large" onclick="if (fm_check_required('title', '<?php _e('Form Title', WDFM()->prefix); ?>') || !FormManageSubmitButton()) {return false;}; jQuery('#saving_text').html('<?php _e('Redo', WDFM()->prefix); ?>');fm_set_input_value('task', 'redo');">
								<?php _e('Redo', WDFM()->prefix); ?>
							  </button>
							  <?php
							}
							$backup_id = $prev_backup_id;
							if ( $backup_id ) { ?>
							  <button class="button undo-button button-large" onclick="if (fm_check_required('title', '<?php _e('Form Title', WDFM()->prefix); ?>') || !FormManageSubmitButton()) {return false;}; jQuery('#saving_text').html('<?php _e('Undo', WDFM()->prefix); ?>');fm_set_input_value('task', 'undo');">
								<span></span>
								<?php _e('Undo', WDFM()->prefix); ?>
							  </button>
							  <?php
							}
						  }
						}
					?>
					<button class="button button-primary button-large" onclick="if (fm_check_required('title', '<?php _e('Form Title', WDFM()->prefix); ?>') || !FormManageSubmitButton()) {return false;}; fm_set_input_value('task', 'apply');">
					<?php
					  if ($row->title) {
						_e('Update', WDFM()->prefix);
					  }
					  else {
						_e('Publish', WDFM()->prefix);
					  }
					  ?>
					</button>
					<button class="button preview-button button-large"<?php if (!$row->title) echo ' disabled="disabled"' ?> <?php echo ($row->title) ? 'onclick="window.open(\''. add_query_arg( array('wdform_id' => $id), $form_preview_link ) .'\', \'_blank\'); return false;"' : ''; ?>><?php _e('Preview', WDFM()->prefix); ?></button>
				  </div>
				</div>
				<div class="fm-clear"></div>
			</div>
			<div class="fm-theme-banner">
				<div class="fm-theme"  style="float:left; position: relative">
					<span><?php _e('Theme', WDFM()->prefix); ?>:&nbsp;</span>
					<select id="theme" name="theme" data-initial-value="<?php echo $row->theme; ?>" class="fm-check-change" onChange="set_theme()">
						<optgroup label="New Themes">
							<?php
							$optiongroup = true;
							foreach ($themes as $theme) {
							if ($optiongroup && $theme->version == 1) {
							$optiongroup = false;
							?>
						</optgroup>
						<optgroup label="Outdated Themes">
							<?php
							}
							?>
							<option value="<?php echo $theme->id; ?>" <?php echo (($theme->id == $row->theme) ? 'selected' : ''); ?> data-version="<?php echo $theme->version; ?>"><?php echo $theme->title; ?></option>
							<?php
							}
							?>
						</optgroup>
					</select>
					<a id="edit_css" class="pointer" onclick="window.open('<?php echo add_query_arg(array('current_id' => ($row->theme ? $row->theme : $default_theme), WDFM()->nonce => wp_create_nonce(WDFM()->nonce)), admin_url('admin.php?page=themes' . WDFM()->menu_postfix . '&task=edit')); ?>'); return false;">
						<?php _e('Edit', WDFM()->prefix); ?>
					</a>
          <br />
          <div id="old_theme_notice" style="display: none;"><div class="error inline"><p><?php _e('The theme you have selected is outdated. Please choose one from New Themes section.', WDFM()->prefix); ?></p></div></div>
				</div>
				<div class="fm-page-actions">
				<?php if( $id ){ ?> 
					<a class="button button-primary" href="<?php echo $params['form_options_url']; ?>"><?php _e('Form Options', WDFM()->prefix); ?></a>
					<a class="button" href="<?php echo $params['display_options_url']; ?>"><?php _e('Display Options', WDFM()->prefix); ?></a>
				  <?php
					if ( !empty($params['advanced_layout_url']) ) {
					  ?>
          <a class="button" href="<?php echo $params['advanced_layout_url']; ?>"><?php _e('Advanced Layout', WDFM()->prefix); ?></a>
					  <?php
					}
				}
				?>
				</div>
			</div>
			<div class="fm-clear"></div>
			<?php echo $this->add_fields(); ?>
			<?php if (!function_exists('the_editor')) { ?>
					<iframe id="tinymce" style="display: none;"></iframe>
			<?php } ?>			
			<div class="meta-box-sortables" style="margin-top:30px;">
				<div id="postexcerpt" class="postbox closed" >
					<button type="button" class="button-link handlediv" aria-expanded="true">
						<span class="screen-reader-text"><?php _e('Toggle panel: Form Header', WDFM()->prefix); ?></span>
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
					<h2 class="hndle"><span><?php _e('Form Header', WDFM()->prefix); ?></span></h2>
					<div class="inside">
						<div id="fm-header-content" class="panel-content">
							<div>
								<div class="fm-row">
									<label><?php _e('Title:', WDFM()->prefix); ?></label>
									<input type="text" id="header_title" name="header_title" class="fm-check-change" value="<?php echo $row->header_title; ?>" data-initial-value="<?php echo $row->header_title; ?>" />
								</div>
								<div class="fm-row">
									<label><?php _e('Description:', WDFM()->prefix); ?></label>
									<div id="description_editor" style="display: inline-block; vertical-align: middle;">
										<input type="hidden" id="header_description_initial_value" value="<?php echo rawurlencode($row->header_description); ?>" />
										<?php if (user_can_richedit()) {
											wp_editor($row->header_description, 'header_description', array('teeny' => TRUE, 'textarea_name' => 'header_description', 'media_buttons' => FALSE, 'textarea_rows' => 5));
										}
										else { ?>
											<textarea name="header_description" id="header_description" cols="40" rows="5" style="height: 350px;" class="mce_editable fm-check-change" aria-hidden="true" data-initial-value="<?php echo $row->header_description; ?>"><?php echo $row->header_description; ?></textarea>
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<div>
								<div class="fm-row">
									<label><?php _e('Image:', WDFM()->prefix); ?></label>
									<input type="text" id="header_image_url" name="header_image_url" class="fm-check-change" value="<?php echo $row->header_image_url; ?>" data-initial-value="<?php echo $row->header_image_url; ?>" />
									<button class="button add-button medium" onclick="fmOpenMediaUploader(event); return false;"><?php _e('Add Image', WDFM()->prefix); ?></button>
									<?php $header_bg = $row->header_image_url ? 'background-image: url('.$row->header_image_url.'); background-position: center;' : ''; ?>
									<div id="header_image" class="header_img<?php if (!$row->header_image_url) echo ' fm-hide'; ?>" style="<?php echo $header_bg; ?>">
										<button type="button" id="remove_header_img" onclick="fmRemoveHeaderImage(event); return false;">
											<i class="mce-ico mce-i-dashicon dashicons-no"></i>
										</button>
									</div>
								</div>
								<div class="fm-row">
									<label><?php _e('Image Animation:', WDFM()->prefix); ?></label>
									<select name="header_image_animation" class="fm-check-change" data-initial-value="<?php echo $row->header_image_animation; ?>">
										<?php
										foreach($animation_effects as $anim_key => $animation_effect){
											$selected = $row->header_image_animation == $anim_key ? 'selected="selected"' : '';
											echo '<option value="'.$anim_key.'" '.$selected.'>'.$animation_effect.'</option>';
										}
										?>
									</select>
								</div>
								<div class="fm-row">
									<label for="header_hide_image"><?php _e('Hide Image on Mobile:', WDFM()->prefix); ?></label>
									<input type="checkbox" id="header_hide_image" name="header_hide_image" value="1" data-initial-value="<?php echo $row->header_hide_image; ?>" <?php echo $row->header_hide_image == '1' ? 'checked="checked"' : '' ?> />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="fm-edit-content">
				<div class="fm-drag-and-drop">
					<div>
						<label for="enable_sortable"><?php _e('Enable Drag & Drop', WDFM()->prefix); ?></label>
						<button name="sortable" id="enable_sortable" class="fm-checkbox-radio-button <?php echo $row->sortable == 1 ? 'fm-yes' : 'fm-no' ?>" onclick="enable_drag(this); return false;" value="<?php echo $row->sortable; ?>">
							<span></span>
						</button>
						<input type="hidden" name="sortable" id="sortable_hidden" value="<?php echo $row->sortable; ?>"/>
					</div>
				</div>
					  <div style="display: table; width: 100%;" id="page_bar">
						<div id="page_navigation" style="display: table-row;">
						  <div align="center" id="pages" show_title="<?php echo $row->show_title; ?>" show_numbers="<?php echo $row->show_numbers; ?>" type="<?php echo $row->pagination; ?>" style="display: table-cell;  width:90%;"></div>
						  <div align="left" id="edit_page_navigation"></div>
						</div>
					  </div>
					<div id="take" class="main">
					<?php echo $row->form_front; ?>
					<div class="wdform_column ui-sortable" id="add_field_cont">

						<div id="add_field" class="ui-sortable-handle">
							<div class="first-time-use">
								<span class="first-time-use-close dashicons dashicons-no-alt"></span>
								<?php _e('Drag icon to the form to add a field.', WDFM()->prefix); ?>
							</div>

							<div type="type_text" class="wdform_field">
							<div class="add-new-button button-primary"  onclick="popup_ready(); Enable(); return false;">
								<span class="dashicons dashicons-move"></span>
								<?php _e('New Field', WDFM()->prefix); ?>
							</div>
						  </div>
					  </div>
					</div>
				  </div>
			</div>
			<input type="hidden" name="form_front" id="form_front" />
			<input type="hidden" name="form_fields" id="form_fields" />
			<input type="hidden" name="pagination" id="pagination" />
			<input type="hidden" name="show_title" id="show_title" />
			<input type="hidden" name="show_numbers" id="show_numbers" />
			<input type="hidden" name="public_key" id="public_key" />
			<input type="hidden" name="private_key" id="private_key" />
			<input type="hidden" name="recaptcha_theme" id="recaptcha_theme" />
			<input type="hidden" id="label_order" name="label_order" value="<?php echo $row->label_order; ?>" />
			<input type="hidden" id="label_order_current" name="label_order_current" value="<?php echo $row->label_order_current; ?>" />
			<input type="hidden" name="counter" id="counter" value="<?php echo $row->counter; ?>" />
			<input type="hidden" name="backup_id" id="backup_id" value="<?php echo $row->backup_id;?>">
			<input type="hidden" name="option" value="com_formmaker" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="cid[]" value="<?php echo $id; ?>" />
			<input type="hidden" id="task" name="task" value=""/>
			<input type="hidden" id="current_id" name="current_id" value="<?php echo $row->id; ?>" />
		</form>
		<?php
	}

  public function add_fields() {
    $pro_fields1 = array('file_upload', 'map', 'paypal');
    $pro_fields2 = array('file_upload', 'paypal', 'checkbox', 'radio', 'survey', 'time_and_date', 'select');
    $fields = array(
      __('BASIC FIELDS', WDFM()->prefix) => array(
        array('type' => 'text', 'subtype' => 'text', 'title' => __('Single Line Text', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'textarea', 'title' => __('Paragraph Text', WDFM()->prefix)),
        array('type' => 'survey', 'subtype' => 'spinner', 'title' => __('Number', WDFM()->prefix)),
        array('type' => 'time_and_date', 'subtype' => 'date_new', 'title' => __('Date', WDFM()->prefix)),
        array('type' => 'select', 'subtype' => 'own_select', 'title' => __('Select', WDFM()->prefix)),
        array('type' => 'radio', 'subtype' => '', 'title' => __('Single Choice', WDFM()->prefix)),
        array('type' => 'checkbox', 'subtype' => '', 'title' => __('Multiple Choice', WDFM()->prefix)),
        array('type' => 'captcha', 'subtype' => 'recaptcha', 'title' => __('Recaptcha', WDFM()->prefix)),
        array('type' => 'button', 'subtype' => 'submit_reset', 'title' => __('Submit', WDFM()->prefix)),
		array('type' => 'captcha', 'subtype' => 'captcha', 'title' => __('Simple Captcha', WDFM()->prefix)),
	  ),
      __('USER INFO FIELDS', WDFM()->prefix) => array(
        array('type' => 'text', 'subtype' => 'name', 'title' => __('Name', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'submitter_mail', 'title' => __('Email', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'phone_new', 'title' => __('Phone', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'address', 'title' => __('Address', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'mark_map', 'title' => __('Mark on Map', WDFM()->prefix)),
        array('type' => 'select', 'subtype' => 'country', 'title' => __('Country List', WDFM()->prefix)),
        array('type' => 'time_and_date', 'subtype' => 'date_fields', 'title' => __('Date of Birth', WDFM()->prefix)),
      ),
      __('LAYOUT FIELDS', WDFM()->prefix) => array(
        array('type' => 'editor', 'subtype' => '', 'title' => __('HTML', WDFM()->prefix)),
        array('type' => 'section_break', 'subtype' => '', 'title' => __('Section', WDFM()->prefix)),
        array('type' => 'page_break', 'subtype' => '', 'title' => __('Page', WDFM()->prefix)),
      ),
      __('ADVANCED', WDFM()->prefix) => array(
        array('type' => 'file_upload', 'subtype' => '', 'title' => __('File Upload', WDFM()->prefix)),
        array('type' => 'map', 'subtype' => '', 'title' => __('Map', WDFM()->prefix)),
        array('type' => 'time_and_date', 'subtype' => 'time', 'title' => __('Time', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'send_copy', 'title' => __('Receive Copy', WDFM()->prefix)),
        array('type' => 'time_and_date', 'subtype' => 'date_range', 'title' => __('Date Range', WDFM()->prefix)),
        array('type' => 'survey', 'subtype' => 'star_rating', 'title' => __('Stars', WDFM()->prefix)),
        array('type' => 'survey', 'subtype' => 'scale_rating', 'title' => __('Rating', WDFM()->prefix)),
        array('type' => 'survey', 'subtype' => 'slider', 'title' => __('Slider', WDFM()->prefix)),
        array('type' => 'survey', 'subtype' => 'range', 'title' => __('Range', WDFM()->prefix)),
        array('type' => 'survey', 'subtype' => 'grading', 'title' => __('Grades', WDFM()->prefix)),
        array('type' => 'survey', 'subtype' => 'matrix', 'title' => __('Table of Fields', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'hidden', 'title' => __('Hidden Input', WDFM()->prefix)),
        array('type' => 'button', 'subtype' => 'button', 'title' => __('Custom Button', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'password', 'title' => __('Password', WDFM()->prefix)),
        array('type' => 'text', 'subtype' => 'phone', 'title' => __('Phone-Area Code', WDFM()->prefix)),
        array('type' => 'captcha', 'subtype' => 'arithmetic_captcha', 'title' => __('Arithmetic Captcha', WDFM()->prefix)),
      ),
      __('PAYMENT', WDFM()->prefix) => array(
        array('type' => 'paypal', 'subtype' => 'paypal_price_new', 'title' => __('Price', WDFM()->prefix)),
        array('type' => 'paypal', 'subtype' => 'paypal_select', 'title' => __('Payment Select', WDFM()->prefix)),
        array('type' => 'paypal', 'subtype' => 'paypal_radio', 'title' => __('Payment Single Choice', WDFM()->prefix)),
        array('type' => 'paypal', 'subtype' => 'paypal_checkbox', 'title' => __('Payment Multiple Choice', WDFM()->prefix)),
        array('type' => 'paypal', 'subtype' => 'paypal_shipping', 'title' => __('Shipping', WDFM()->prefix)),
        array('type' => 'paypal', 'subtype' => 'paypal_total', 'title' => __('Total', WDFM()->prefix)),
        array('type' => 'paypal', 'subtype' => 'stripe', 'title' => __('Stripe', WDFM()->prefix)),
      ),
    );
    ob_start();
    ?>
    <div class="add-popup js">
      <div class="popup-header">
        <span class="popup-title">
          <?php _e('Add field', WDFM()->prefix); ?>
        </span>
        <span title="<?php _e('Close', WDFM()->prefix); ?>" alt="<?php _e('Close', WDFM()->prefix); ?>" class="close-popup dashicons dashicons-no-alt" onclick="close_window()"></span>
      </div>
      <div class="popup-body meta-box-sortables">
        <div class="popup-body-col field_types">
		  <div class="field_types_cont">
			<h2 class="hndle field-types-filter_header"><span><?php _e('FIELD TYPES', WDFM()->prefix); ?></span></h2>
			<span class="field-types-filter-cont">
            	<input class="field-types-filter" value="" placeholder="<?php _e('Filter', WDFM()->prefix); ?>" tabindex="-1" type="search" />
            </span>
			<div class="postbox filtered-fields hide">
              <button class="button-link handlediv" type="button" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel</span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle">
                <span><?php _e('Filtered fields', WDFM()->prefix); ?></span>
              </h2>
              <div class="inside"></div>
            </div>
            <?php
            foreach ($fields as $section => $field) {
              ?>
              <div class="postbox<?php echo $section != __('BASIC FIELDS', WDFM()->prefix) ? " closed" : ""; ?>">
                <button class="button-link handlediv" type="button" aria-expanded="true">
                  <span class="screen-reader-text"><?php echo __('Toggle panel:', WDFM()->prefix) , $section; ?></span>
                  <span class="toggle-indicator" aria-hidden="false"></span>
                </button>
                <h2 class="hndle">
                  <span><?php echo $section; ?></span>
                </h2>
                <div class="inside">
                  <?php
                  foreach ($field as $button) {
                    ?>
                    <button class="<?php echo ((WDFM()->is_free == 1 && in_array($button['type'], $pro_fields1)) || (WDFM()->is_free == 2 && in_array($button['type'], $pro_fields2))) ? 'wd-pro-fields ' : ''; ?>wd-button button-secondary" onclick="addRow(event, this, '<?php echo $button['type']; ?>', '<?php echo $button['subtype']; ?>'); return false;" data-type="type_<?php echo $button['subtype'] ? $button['subtype'] : $button['type']; ?>">
                      <span class="field-type-button wd<?php echo ($button['subtype'] == '' ? $button['type'] : $button['subtype']); ?>"></span>
                      <?php echo $button['title']; ?>
                    </button>
                    <?php
                  }
                  ?>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <div class="popup-body-col field_options">
          <div id="edit_table"></div>
        </div>
        <div class="popup-body-col field_preview">
          <div id="add-button-cont" class="add-button-cont">
            <button class="button button-primary button-hero wd-add-button" onclick="add(0, false); return false;">
              <?php _e('Add', WDFM()->prefix);?>
            </button>
          </div>
          <div id="show_table">
          </div>
        </div>
      </div>
      <input type="hidden" id="old" />
      <input type="hidden" id="old_selected" />
      <input type="hidden" id="element_type" />
      <input type="hidden" id="editing_id" />
      <input type="hidden" value="<?php echo WDFM()->plugin_url; ?>" id="form_plugins_url" />
      <div id="main_editor" style="position: fixed; display: none; z-index: 140;">
        <?php if ( user_can_richedit() ) {
          wp_editor('', 'form_maker_editor', array(
            'teeny' => TRUE,
            'textarea_name' => 'form_maker_editor',
            'media_buttons' => FALSE,
            'textarea_rows' => 5,
          ));
        }
        else { ?>
          <textarea name="form_maker_editor" id="form_maker_editor" cols="40" rows="5" style="width: 440px; height: 350px;" class="mce_editable" aria-hidden="true"></textarea>
          <?php
        }
        ?>
      </div>
    </div>
    <?php
    return ob_get_clean();
  }
	
	public function form_options( $params ) {	
		wp_enqueue_style('thickbox');
		wp_enqueue_style('fm-phone_field_css');
		wp_enqueue_style('fm-jquery-ui');
		wp_enqueue_style('fm-codemirror');
		wp_enqueue_style('fm-colorpicker');

		wp_enqueue_script('thickbox');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-spinner');
		wp_enqueue_script('jquery-ui-datepicker');
    if ( function_exists('wp_add_inline_script') ) { // Since Wordpress 4.5.0
      wp_add_inline_script('jquery-ui-datepicker', WDW_FM_Library::localize_ui_datepicker());
    }
    else {
      echo '<script>' . WDW_FM_Library::localize_ui_datepicker() . '</script>';
    }
		wp_enqueue_media();
		wp_enqueue_script('google-maps');
		wp_enqueue_script('fm-form-options');
		wp_enqueue_script('fm-gmap_form');
		wp_enqueue_script('fm-phone_field');
		wp_enqueue_script('fm-formmaker_div');
		wp_enqueue_script('fm-codemirror');
		wp_enqueue_script('fm-formatting');
		wp_enqueue_script('fm-clike');
		wp_enqueue_script('fm-css');
		wp_enqueue_script('fm-javascript');
		wp_enqueue_script('fm-xml');
		wp_enqueue_script('fm-php');
		wp_enqueue_script('fm-htmlmixed');
		wp_enqueue_script('fm-colorpicker');
		
		$id 		= $params['id'];
		$page 		= $params['page'];
		$page_url 	= $params['page_url'];
		ob_start();
		echo $this->body_form_options($params);
		
		// Pass the content to form.
		$form_attr = array(
			'id' => 'adminForm',
			'name' => 'adminForm',
			'class' => WDFM()->css_prefix . 'form_options wd-form',
			'current_id' => $id,
			'action' => add_query_arg( array('page' => $page, 'current_id' => $id ), $page_url),
		);
		echo $this->form(ob_get_clean(), $form_attr);		
	}
	
	/**
	* Generate page body form options.
	*
	* @param array $params
	*
	* @return string Body html.
	*/
	private function body_form_options( $params ) {
$id = $params['id'];
$page = $params['page'];
$page_title = $params['page_title'];
$page_url = $params['page_url'];
$back_url = $params['back_url'];
$fieldset_id = $params['fieldset_id'];
$addons = $params['addons'];
$row = $params['row'];
$themes = $params['themes'];
$default_theme = $params['default_theme'];
$queries = $params['queries'];
$userGroups = $params['userGroups'];
$fields = $params['fields'];
$fields_count = $params['fields_count'];
$stripe_addon = $params['stripe_addon'];
$payment_method = $params['payment_method'];
$label_label = $params['label_label'];
$label_type = $params['label_type'];
echo $this->title(array(
                    'title' => $page_title,
                    'title_class' => 'wd-header',
                    'add_new_button' => FALSE,
                  ));
$buttons = array(
  'save' => array(
    'title' => __('Update', WDFM()->prefix),
    'value' => 'save',
    'onclick' => 'if( ! wd_fm_apply_options(\'apply_form_options\') ){ return false; }',
    'class' => 'button-primary',
  ),
  'back' => array(
    'title' => __('Back to Form', WDFM()->prefix),
    'value' => 'back',
    'onclick' => 'window.open(\'' . $back_url . '\', \'_self\'); return false;',
    'class' => 'button',
  )
);
echo $this->buttons($buttons);
$label_titles_for_submissions = array();
$labels_id_for_submissions = array();
$payment_info = $params['payment_info'];
$labels_for_submissions = $params['labels_for_submissions'];
if ( $labels_for_submissions ) {
  $labels_id_for_submissions = $params['labels_id_for_submissions'];
  $label_titles_for_submissions = $params['label_titles_for_submissions'];
}
$stats_labels_ids = $params['stats_labels_ids'];
$stats_labels = $params['stats_labels'];
?>
  <div class="fm-clear"></div>
  <div class="submenu-box">
    <div class="submenu-pad">
      <ul id="submenu" class="configuration">
        <li>
          <a id="general" class="fm_fieldset_tab" onclick="form_maker_options_tabs('general')" href="#"><?php _e('General Options', WDFM()->prefix); ?></a>
        </li>
        <li>
          <a id="emailTab" class="fm_fieldset_tab" onclick="form_maker_options_tabs('emailTab')" href="#"><?php _e('Email Options', WDFM()->prefix); ?></a>
        </li>
        <li>
          <a id="actions" class="fm_fieldset_tab" onclick="form_maker_options_tabs('actions')" href="#"><?php _e('Actions after Submission', WDFM()->prefix); ?></a>
        </li>
        <li>
          <a id="payment" class="fm_fieldset_tab" onclick="form_maker_options_tabs('payment')" href="#"><?php _e('Payment Options', WDFM()->prefix); ?></a>
        </li>
        <li>
          <a id="javascript" class="fm_fieldset_tab" onclick="form_maker_options_tabs('javascript'); codemirror_for_javascript();" href="#"><?php _e('JavaScript', WDFM()->prefix); ?></a>
        </li>
        <li>
          <a id="conditions" class="fm_fieldset_tab" onclick="form_maker_options_tabs('conditions')" href="#"><?php _e('Conditional Fields', WDFM()->prefix); ?></a>
        </li>
        <li>
          <a id="mapping" class="fm_fieldset_tab" onclick="form_maker_options_tabs('mapping')" href="#"><?php _e('MySQL Mapping', WDFM()->prefix); ?></a>
        </li>
        <?php
        if ( !empty($addons['tabs']) ) {
          foreach ( $addons['tabs'] as $addon => $name ) {
            ?>
            <li>
              <a id="<?php echo $addon; ?>" class="fm_fieldset_tab" onclick="form_maker_options_tabs('<?php echo $addon; ?>')" href="#"><?php echo $name; ?></a>
            </li>
            <?php
          }
        }
        ?>
      </ul>
    </div>
  </div>
  <div class="fm-clear"></div>
<div>
  <div id="general_fieldset" class="adminform fm_fieldset_deactive">
    <div class="wd-table">
      <div class="wd-table-col wd-table-col-50 wd-table-col-left">
        <div class="wd-box-section">
          <div class="wd-box-content">
						<span class="wd-group">
						  <label class="wd-label"><?php _e('Published', WDFM()->prefix); ?></label>
						  <input type="radio" name="published" <?php echo $row->published == 1 ? 'checked="checked"' : '' ?> id="fm_go-published-1" class="wd-radio" value="1">
						  <label class="wd-label-radio" for="fm_go-published-1"><?php _e('Yes', WDFM()->prefix); ?></label>
						  <input type="radio" name="published" <?php echo $row->published == 0 ? 'checked="checked"' : '' ?> id="fm_go-published-0" class="wd-radio" value="0">
						  <label class="wd-label-radio" for="fm_go-published-0"><?php _e('No', WDFM()->prefix); ?></label>
						</span>
            <span class="wd-group">
						  <label class="wd-label"><?php _e('Save data(to database)', WDFM()->prefix); ?></label>
						  <input type="radio" name="savedb" <?php echo $row->savedb == 1 ? 'checked="checked"' : '' ?> id="fm_go-savedb-1" class="wd-radio" value="1">
						  <label class="wd-label-radio" for="fm_go-savedb-1"><?php _e('Yes', WDFM()->prefix); ?></label>
						  <input type="radio" name="savedb" <?php echo $row->savedb == 0 ? 'checked="checked"' : '' ?> id="fm_go-savedb-0" class="wd-radio" value="0">
						  <label class="wd-label-radio" for="fm_go-savedb-0"><?php _e('No', WDFM()->prefix); ?></label>
                <p class="description"><?php _e('IMPORTANT! If you disable this option, the information submitted through this form will not be saved in the database and will not be displayed on the Submissions page.', WDFM()->prefix); ?></p>
            </span>
            <span class="wd-group theme-wrap">
							<label class="wd-label"><?php _e('Theme', WDFM()->prefix); ?></label>
							<select id="theme" name="theme" onChange="set_theme()">
								<optgroup label="<?php _e('New Themes', WDFM()->prefix); ?>">
								  <option value="0" <?php echo $row->theme && $row->theme == 0 ? 'selected' : '' ?> data-version="2"><?php _e('Inherit From Website Theme', WDFM()->prefix); ?></option>
                  <?php
                  $optiongroup = TRUE;
                  foreach ($themes

                  as $theme) {
                  if ($optiongroup && $theme->version == 1) {
                  $optiongroup = FALSE;
                  ?>
									</optgroup>
									<optgroup label="<?php _e('Outdated Themes', WDFM()->prefix); ?>">
									<?php } ?>
                    <option value="<?php echo $theme->id; ?>" <?php echo(($theme->id == $row->theme) ? 'selected' : ''); ?> data-version="<?php echo $theme->version; ?>"><?php echo $theme->title; ?></option>
                    <?php } ?>
								</optgroup>
							</select>
							<a id="edit_css" class="options-edit-button" onclick="window.open('<?php echo add_query_arg(array(
                                                                                                            'current_id' => ($row->theme && $row->theme != '0' ? $row->theme : $default_theme),
                                                                                                            WDFM()->nonce => wp_create_nonce(WDFM()->nonce)
                                                                                                          ), admin_url('admin.php?page=themes' . WDFM()->menu_postfix . '&task=edit')); ?>'); return false;"><?php _e('Edit', WDFM()->prefix); ?></a>
							<div id="old_theme_notice" class="error inline" style="display: none;"><p><?php _e('The theme you have selected is outdated. Please choose one from New Themes section.', WDFM()->prefix); ?></p></div>
                            <p class="description"><?php _e('The appearance of your forms is controlled by the theme you select with this option. Press Edit button to open and modify your form theme.', WDFM()->prefix); ?></p>

            </span>
            <span class="wd-group">
							<label class="wd-label" for="requiredmark"><?php _e('Required fields mark', WDFM()->prefix); ?></label>
							<input type="text" id="requiredmark" name="requiredmark" value="<?php echo $row->requiredmark; ?>">
			    <p class="description"><?php _e('Use this option to change the mark for required fields of your form.', WDFM()->prefix); ?></p>
            </span>
            <span class="wd-group">
						  <label class="wd-label"><?php _e('Save Uploads', WDFM()->prefix); ?></label>
						  <input type="radio" name="save_uploads" <?php echo $row->save_uploads == 1 ? 'checked="checked"' : '' ?> id="fm_go-save_uploads-1" class="wd-radio" value="1">
						  <label class="wd-label-radio" for="fm_go-save_uploads-1"><?php _e('Yes', WDFM()->prefix); ?></label>
						  <input type="radio" name="save_uploads" <?php echo $row->save_uploads == 0 ? 'checked="checked"' : '' ?> id="fm_go-save_uploads-0" class="wd-radio" value="0">
						  <label class="wd-label-radio" for="fm_go-save_uploads-0"><?php _e('No', WDFM()->prefix); ?></label>
			    <p class="description"><?php _e('IMPORTANT! If you disable this option, the files uploaded through your form will not be saved on your site. The files will still be sent to emails and saved in Google Drive or Dropbox, if configured.', WDFM()->prefix); ?></p>
            </span>
          </div>
        </div>
      </div>
      <div class="wd-table-col wd-table-col-50 wd-table-col-right">
        <div class="wd-box-section">
          <div class="wd-box-content">
						<span class="wd-group">
							<label class="wd-label"><?php _e('Allow User to see submissions', WDFM()->prefix); ?></label>
              <?php
              $checked_UserGroup = explode(',', $row->user_id_wd);
              $i = 0;
              foreach ( $userGroups as $val => $uG ) {
                echo "\r\n" . '<input type="checkbox" value="' . $val . '"  id="user_' . $i . '" ';
                if ( in_array($val, $checked_UserGroup) ) {
                  echo ' checked="checked"';
                }
                echo ' onchange="acces_level(' . count($userGroups) . ')" /><label for="user_' . $i . '">' . $uG["name"] . '</label><br>';
                $i++;
              }
              ?>
              <input type="checkbox" value="guest" id="user_<?php echo $i; ?>" onchange="acces_level(<?php echo count($userGroups); ?>)"<?php echo(in_array('guest', $checked_UserGroup) ? 'checked="checked"' : '') ?>/><label for="user_<?php echo $i; ?>">Guest</label>
							<input type="hidden" name="user_id_wd" value="<?php echo $row->user_id_wd ?>" id="user_id_wd" />
                        <p class="description"><?php _e('Mark all user roles which will be able to view front-end submissions, when you publish them on a post or page.', WDFM()->prefix); ?></p>
                     </span>
            <?php if ( count($label_titles_for_submissions) ) { ?>
              <span class="wd-group">
								<label class="wd-label"><?php _e('Fields to hide in frontend submissions', WDFM()->prefix); ?></label>
								<ul id="form_fields">
									<li>
										<input type="checkbox" name="all_fields" id="all_fields" onclick="checkAllByParentId('form_fields'); checked_labels('filed_label')" value="submit_id,<?php echo implode(',', $labels_id_for_submissions) . "," . ($payment_info ? "payment_info" : ""); ?>" />
										<label for="all_fields"><?php _e('Select All', WDFM()->prefix); ?></label>
									</li>
                  <?php
                  echo "<li><input type=\"checkbox\" id=\"submit_id\" name=\"submit_id\" value=\"submit_id\" class=\"filed_label\"  onclick=\"checked_labels('filed_label')\"><label for=\"submit_id\">ID</label></li>";
                  for ( $i = 0, $n = count($label_titles_for_submissions); $i < $n; $i++ ) {
                    $field_label = $label_titles_for_submissions[$i];
                    echo "<li><input type=\"checkbox\" id=\"filed_label" . $i . "\" name=\"filed_label" . $i . "\" value=\"" . $labels_id_for_submissions[$i] . "\" class=\"filed_label\" onclick=\"checked_labels('filed_label')\"><label for=\"filed_label" . $i . "\">" . (strlen($field_label) > 80 ? substr($field_label, 0, 80) . '...' : $field_label) . "</label></li>";
                  }
                  if ( $payment_info ) {
                    echo "<li><input type=\"checkbox\" id=\"payment_info\" name=\"payment_info\" value=\"payment_info\" class=\"filed_label\" onclick=\"checked_labels('filed_label')\"><label for=\"payment_info\">Payment Info</label></li>";
                  }
                  ?>
								</ul>
                  <input type="hidden" name="frontend_submit_fields" value="<?php echo $row->frontend_submit_fields ?>" id="frontend_submit_fields" />
                  <p class="description"><?php _e('Select fields of the form and Stats Fields which will not to be displayed within front-end submissions, when you publish them.', WDFM()->prefix); ?></p>
                </span>
              <?php if ( $stats_labels ) { ?>
                <span class="wd-group">
                    <label class="wd-label"><?php _e('Stats fields:', WDFM()->prefix); ?></label>
                        <ul id="stats_fields">
                            <li>
                                <input type="checkbox" name="all_stats_fields" id="all_stats_fields" onclick="checkAllByParentId('stats_fields'); checked_labels('stats_filed_label');" value="<?php echo implode(',', $stats_labels_ids) . ","; ?>">
                                <label for="all_stats_fields"><?php _e('Select All', WDFM()->prefix); ?></label>
                            </li>
                             <?php
                                  for ( $i = 0, $n = count($stats_labels); $i < $n; $i++ ) {
                                    $field_label = $stats_labels[$i];
                                    echo "<li><input type=\"checkbox\" id=\"stats_filed_label" . $i . "\" name=\"stats_filed_label" . $i . "\" value=\"" . $stats_labels_ids[$i] . "\" class=\"stats_filed_label\" onclick=\"checked_labels('stats_filed_label')\"><label for=\"stats_filed_label" . $i . "\">" . (strlen($field_label) > 80 ? substr($field_label, 0, 80) . '...' : $field_label) . "</label></li>";
                                  }
                                  ?>
                         </ul>
                    <input type="hidden" name="frontend_submit_stat_fields" value="<?php echo $row->frontend_submit_stat_fields ?>" id="frontend_submit_stat_fields" />
                    <p class="description"><?php _e('Select fields of the form and Stats Fields which will not to be displayed within front-end submissions, when you publish them.', WDFM()->prefix); ?></p>
                </span>
              <?php }
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="emailTab_fieldset" class="adminform fm_fieldset_deactive js">
    <div class="wd-table">
      <div class="wd-table-col wd-table-col-100">
        <div class="wd-box-section">
          <div class="wd-box-content">
            <div class="wd-group">
              <label class="wd-label"><?php _e('Send E-mail', WDFM()->prefix); ?></label>
              <input type="radio" name="sendemail" <?php echo $row->sendemail == 1 ? 'checked="checked"' : '' ?> id="fm_sendemail-1" class="wd-radio" value="1" onchange="fm_toggle_email_options(true)" />
              <label class="wd-label-radio" for="fm_sendemail-1"><?php _e('Yes', WDFM()->prefix); ?></label>
              <input type="radio" name="sendemail" <?php echo $row->sendemail == 0 ? 'checked="checked"' : '' ?> id="fm_sendemail-0" class="wd-radio" value="0" onchange="fm_toggle_email_options(false)" />
              <label class="wd-label-radio" for="fm_sendemail-0"><?php _e('No', WDFM()->prefix); ?></label>
              <p class="description"><?php _e('Enable this setting to send submitted information to administrators and/or the submitter.', WDFM()->prefix); ?></p>
              <p class="description fm_email_options"><?php _e('In case you cannot find the submission email in your Inbox, make sure to check the Spam folder as well.', WDFM()->prefix); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="fm-clear"></div>
    <div class="wd-table meta-box-sortables fm_email_options" id="fm_email_options">
      <div class="wd-table-col wd-table-col-50 wd-table-col-left">
        <div class="wd-box-section">
          <div class="wd-box-title">
            <strong><?php _e('Email to Administrator', WDFM()->prefix); ?></strong>
          </div>
          <div class="wd-box-content">
            <div class="wd-group">
              <label class="wd-label" for="mailToAdd"><?php _e('Email to send submissions to', WDFM()->prefix); ?></label>
              <input type="text" id="mailToAdd" name="mailToAdd" class="mailToAdd" />
              <input type="hidden" id="mail" name="mail" value="<?php echo $row->mail . ($row->mail && (substr($row->mail, -1) != ',') ? ',' : ''); ?>" />
              <span class="dashicons dashicons-plus-alt" title="<?php _e('Add more emails', WDFM()->prefix); ?>" onclick="if (fm_check_email('mailToAdd')) {return false;};fm_add_submission_email('mail', 'mailToAdd', 'cfm_mail_div', '<?php echo WDFM()->plugin_url; ?>')"></span>
              <div id="cfm_mail_div">
                <?php
                $mail_array = explode(',', $row->mail);
                foreach ( $mail_array as $mail ) {
                  if ( $mail && $mail != ',' ) {
                    ?>
                    <p class="fm_mail_input">
                      <span class="mail_name"><?php echo $mail; ?></span><span class="dashicons dashicons-trash" onclick="fm_delete_mail(this, '<?php echo $mail; ?>')" title="<?php _e('Delete Email', WDFM()->prefix); ?>"></span>
                    </p>
                    <?php
                  }
                }
                ?>
              </div>
              <p class="description"><?php _e('Specify the email address(es), to which submitted form information will be sent. For multiple email addresses separate with commas.', WDFM()->prefix); ?></p>
            </div>
            <div class="wd-group">
              <label class="wd-label" for="mail_subject"><?php _e('Subject', WDFM()->prefix); ?></label>
              <input type="text" id="mail_subject" name="mail_subject" value="<?php echo $row->mail_subject ?>" class="mail_subject" />
              <span class="dashicons dashicons-plus-alt" onclick="document.getElementById('mail_subject_labels').style.display='block';"></span>
              <?php
              $choise = "'mail_subject'";
              echo '<div style="position:relative; top:-3px;"><div id="mail_subject_labels" class="email_labels" style="display:none;">';
              for ( $i = 0; $i < count($label_label); $i++ ) {
                if ( $label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_mark_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_file_upload" || $label_type[$i] == "type_send_copy" || $label_type[$i] == "type_matrix" ) {
                  continue;
                }
                $param = htmlspecialchars(addslashes($label_label[$i]));
                $fld_label = $param;
                if ( strlen($fld_label) > 30 ) {
                  $fld_label = wordwrap(htmlspecialchars(addslashes($label_label[$i])), 30);
                  $fld_label = explode("\n", $fld_label);
                  $fld_label = $fld_label[0] . ' ...';
                }
                echo "<a onClick=\"insertAtCursor(" . $choise . ",'" . $param . "'); document.getElementById('mail_subject_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">" . $fld_label . "</a>";
              }
              echo "<a onClick=\"insertAtCursor(" . $choise . ",'subid'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Submission ID</a>";
              echo "<a onClick=\"insertAtCursor(" . $choise . ",'username'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Username</a>";
              echo '</div></div>';
              ?>
              <p class="description"><?php _e('Add a custom subject for the submission email. Click the Plus (+) button to select a form field, the value of which will be set as the subject. In case it’s left blank, Form Title will be set as the subject of submission emails.', WDFM()->prefix); ?></p>
            </div>
            <div class="wd-group">
              <label class="wd-label" for="script_mail"><?php _e('Custom Text in Email For Administrator', WDFM()->prefix); ?></label>
              <div class="fm_textarea-buttons">
                <?php $choise = "'script_mail'"; ?>
                <input class="button" type="button" value="All fields list" onClick="insertAtCursor(<?php echo $choise; ?>, 'all')" />
                <input class="button" type="button" value="Submission ID" onClick="insertAtCursor(<?php echo $choise; ?>,'subid')" />
                <input class="button" type="button" value="Ip" onClick="insertAtCursor(<?php echo $choise; ?>,'ip')" />
                <input class="button" type="button" value="Username" onClick="insertAtCursor(<?php echo $choise; ?>,'username')" />
                <input class="button" type="button" value="User Email" onClick="insertAtCursor(<?php echo $choise; ?>,'useremail')" />
                <?php
                for ( $i = 0; $i < count($label_label); $i++ ) {
                  if ( $label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_mark_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_send_copy" ) {
                    continue;
                  }
                  $param = htmlspecialchars(addslashes($label_label[$i]));
                  $fld_label = $param;
                  if ( strlen($fld_label) > 30 ) {
                    $fld_label = wordwrap(htmlspecialchars(addslashes($label_label[$i])), 30);
                    $fld_label = explode("\n", $fld_label);
                    $fld_label = $fld_label[0] . ' ...';
                  }
                  if ( $label_type[$i] == "type_file_upload" ) {
                    ?>
                    <input class="button" type="button" value="<?php echo $fld_label . '(as image)'; ?>" onClick="insertAtCursor(<?php echo $choise; ?>, '<?php echo $param; ?>')" />
                    <input class="button" type="button" value="<?php echo $fld_label . '(as link)'; ?>" onClick="insertAtCursor(<?php echo $choise; ?>, '<?php echo $param . '(link)'; ?>')" />
                    <?php
                  }
                  else {
                    ?>
                    <input class="button" type="button" value="<?php echo $fld_label; ?>" onClick="insertAtCursor(<?php echo $choise; ?>, '<?php echo $param; ?>')" />
                    <?php
                  }
                }
                ?>
              </div>
              <?php
              if ( user_can_richedit() ) {
                wp_editor($row->script_mail, 'script_mail', array(
                  'teeny' => TRUE,
                  'textarea_name' => 'script_mail',
                  'media_buttons' => FALSE,
                  'textarea_rows' => 5
                ));
              }
              else {
                ?>
                <textarea name="script_mail" id="script_mail" cols="20" rows="10" style="width:300px; height:450px;"><?php echo $row->script_mail; ?></textarea>
                <?php
              }
              ?>
              <p class="description"><?php _e('Write custom content to the email message which is sent to administrator. Include All Fields List to forward all submitted information, or click on fields buttons to use individual field values in the content.', WDFM()->prefix); ?></p>
            </div>
            <div class="postbox closed">
              <button class="button-link handlediv" type="button" aria-expanded="true">
                <span class="screen-reader-text"><?php _e('Toggle panel:', WDFM()->prefix); ?></span>
                <span class="toggle-indicator" aria-hidden="false"></span>
              </button>
              <h2 class="hndle">
                <span><?php _e('Advanced', WDFM()->prefix); ?></span>
              </h2>
              <div class="inside">
                <div class="wd-group">
                  <label class="wd-label"><?php _e('Email From', WDFM()->prefix); ?></label>
                  <?php
                  $is_other = TRUE;
                  for ( $i = 0; $i < $fields_count - 1; $i++ ) {
                    ?>
                    <input class="wd-radio" type="radio" name="from_mail" id="from_mail<?php echo $i; ?>" value="<?php echo(!is_numeric($fields[$i]) ? substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) : $fields[$i]); ?>" <?php echo((!is_numeric($fields[$i]) ? substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) : $fields[$i]) == $row->from_mail ? 'checked="checked"' : ''); ?> onclick="wdhide('mail_from_other_wrap'); fm_clear_input_value('mail_from_other');" />
                    <label class="wd-label-radio" for="from_mail<?php echo $i; ?>"><?php echo substr($fields[$i + 1], 0, strpos($fields[$i + 1], '*:*w_field_label*:*')); ?></label>
                    <?php
                    if ( !is_numeric($fields[$i]) ) {
                      if ( substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) == $row->from_mail ) {
                        $is_other = FALSE;
                      }
                    }
                    else {
                      if ( $fields[$i] == $row->from_mail ) {
                        $is_other = FALSE;
                      }
                    }
                  }
                  ?>
                  <input style="<?php echo ($fields_count == 1) ? 'display:none;' : ''; ?>" class="wd-radio" type="radio" id="other" name="from_mail" value="other" <?php echo ($is_other) ? 'checked="checked"' : ''; ?> onclick="wdshow('mail_from_other_wrap')" />
                  <label style="<?php echo ($fields_count == 1) ? 'display:none;' : ''; ?>" class="wd-label-radio" for="other"><?php _e('Other', WDFM()->prefix); ?></label>
                  <p style="display: <?php echo ($is_other) ? 'block;' : 'none;'; ?>" id="mail_from_other_wrap">
                    <input type="text" name="mail_from_other" id="mail_from_other" value="<?php echo ($is_other) ? $row->from_mail : ''; ?>" />
                  </p>
                  <p class="description"><?php _e('Specify the email address from which the administrator will receive the email.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="from_name"><?php _e('From Name', WDFM()->prefix); ?></label>
                  <input type="text" name="from_name" value="<?php echo $row->from_name; ?>" id="from_name" class="from_name" />
                  <span class="dashicons dashicons-plus-alt" onclick="document.getElementById('mail_from_labels').style.display='block';"></span>
                  <div style="position:relative; top:-1px;">
                    <div id="mail_from_labels" class="email_labels" style="display:none;">
                      <?php
                      $choise = "'from_name'";
                      echo "<a onClick=\"insertAtCursor(" . $choise . ",'username'); document.getElementById('mail_from_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Username</a>";
                      for ( $i = 0; $i < count($label_label); $i++ ) {
                        if ( $label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_mark_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_file_upload" || $label_type[$i] == "type_send_copy" || $label_type[$i] == "type_matrix" ) {
                          continue;
                        }
                        $param = htmlspecialchars(addslashes($label_label[$i]));
                        $fld_label = $param;
                        if ( strlen($fld_label) > 30 ) {
                          $fld_label = wordwrap(htmlspecialchars(addslashes($label_label[$i])), 30);
                          $fld_label = explode("\n", $fld_label);
                          $fld_label = $fld_label[0] . ' ...';
                        }
                        echo "<a onClick=\"insertAtCursor(" . $choise . ",'" . $param . "'); document.getElementById('mail_from_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">" . $fld_label . "</a>";
                      }
                      echo "<a onClick=\"insertAtCursor(" . $choise . ",'subid'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Submission ID</a>";
                      echo "<a onClick=\"insertAtCursor(" . $choise . ",'username'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Username</a>";
                      ?>
                    </div>
                  </div>
                  <p class="description"><?php _e('Set the name which is shown as the sender’s name in submission or confirmation emails. Press the Plus (+) button to select a field value.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="from_name"><?php _e('Reply to (if different from "Email From")', WDFM()->prefix); ?></label>
                  <?php
                  $is_other = TRUE;
                  for ( $i = 0; $i < $fields_count - 1; $i++ ) {
                    ?>
                    <input class="wd-radio" type="radio" name="reply_to" id="reply_to<?php echo $i; ?>" value="<?php echo(!is_numeric($fields[$i]) ? substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) : $fields[$i]); ?>" <?php echo((!is_numeric($fields[$i]) ? substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) : $fields[$i]) == $row->reply_to ? 'checked="checked"' : ''); ?> onclick="wdhide('reply_to_other_wrap'); fm_clear_input_value('reply_to_other');" />
                    <label class="wd-label-radio" for="reply_to<?php echo $i; ?>"><?php echo substr($fields[$i + 1], 0, strpos($fields[$i + 1], '*:*w_field_label*:*')); ?></label>
                    <?php
                    if ( !is_numeric($fields[$i]) ) {
                      if ( substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) == $row->reply_to ) {
                        $is_other = FALSE;
                      }
                    }
                    else {
                      if ( $fields[$i] == $row->reply_to ) {
                        $is_other = FALSE;
                      }
                    }
                  }
                  ?>
                  <input style="<?php echo ($fields_count == 1) ? 'display: none;' : ''; ?>" class="wd-radio" type="radio" id="other1" name="reply_to" value="other" <?php echo ($is_other) ? 'checked="checked"' : ''; ?> onclick="wdshow('reply_to_other_wrap')" />
                  <label style="<?php echo ($fields_count == 1) ? 'display: none;' : ''; ?>" class="wd-label-radio" for="other1"><?php _e('Other', WDFM()->prefix); ?></label>
                  <p style="display: <?php echo ($is_other) ? 'block;' : 'none;'; ?>" id="reply_to_other_wrap">
                    <input type="text" name="reply_to_other" value="<?php echo ($is_other && $row->reply_to) ? $row->reply_to : ''; ?>" id="reply_to_other" />
                  </p>
                  <p class="description"><?php _e('Specify an alternative email address, to which the administrator will be able to reply upon receiving the message.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="mail_cc"><?php _e('CC', WDFM()->prefix); ?></label>
                  <input type="text" id="mail_cc" name="mail_cc" value="<?php echo $row->mail_cc ?>" />
                  <p class="description"><?php _e('Provide additional email addresses to send the submission or confirmation email to. The receiver will be able to view all other recipients.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="mail_bcc"><?php _e('BCC', WDFM()->prefix); ?></label>
                  <input type="text" id="mail_bcc" name="mail_bcc" value="<?php echo $row->mail_bcc ?>" />
                  <p class="description"><?php _e('Write additional email addresses to send the submission or confirmation email to. The receiver will not be able to view other recipients.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label"><?php _e('Mode', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_mode" <?php echo $row->mail_mode == 1 ? 'checked="checked"' : '' ?> id="fm_mo_mail_mode-1" class="wd-radio" value="1">
                  <label class="wd-label-radio" for="fm_mo_mail_mode-1"><?php _e('HTML', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_mode" <?php echo $row->mail_mode == 0 ? 'checked="checked"' : '' ?> id="fm_mo_mail_mode-0" class="wd-radio" value="0">
                  <label class="wd-label-radio" for="fm_mo_mail_mode-0"><?php _e('Text', WDFM()->prefix); ?></label>
                  <p class="description"><?php _e('Select the layout of the submission email, Text or HTML.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label"><?php _e('Attach File', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_attachment" <?php echo $row->mail_attachment == 1 ? 'checked="checked"' : '' ?> id="fm_mo_mail_attachment-1" class="wd-radio" value="1">
                  <label class="wd-label-radio" for="fm_mo_mail_attachment-1"><?php _e('Yes', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_attachment" <?php echo $row->mail_attachment == 0 ? 'checked="checked"' : '' ?> id="fm_mo_mail_attachment-0" class="wd-radio" value="0">
                  <label class="wd-label-radio" for="fm_mo_mail_attachment-0"><?php _e('No', WDFM()->prefix); ?></label>
                  <p class="description"><?php _e('If you have File Upload fields on your form, enable this setting to attach uploaded files to submission or confirmation email.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label"><?php _e('Email empty fields', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_emptyfields" <?php echo $row->mail_emptyfields == 1 ? 'checked="checked"' : '' ?> id="fm_mo_mail_emptyfields-1" class="wd-radio" value="1">
                  <label class="wd-label-radio" for="fm_mo_mail_emptyfields-1"><?php _e('Yes', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_emptyfields" <?php echo $row->mail_emptyfields == 0 ? 'checked="checked"' : '' ?> id="fm_mo_mail_emptyfields-0" class="wd-radio" value="0">
                  <label class="wd-label-radio" for="fm_mo_mail_emptyfields-0"><?php _e('No', WDFM()->prefix); ?></label>
                  <p class="description"><?php _e('Disable this setting, in case you do not want to include form fields, which are left empty by the submitter.', WDFM()->prefix); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="wd-table-col wd-table-col-50 wd-table-col-right">
        <div class="wd-box-section">
          <div class="wd-box-title">
            <strong><?php _e('Email to User', WDFM()->prefix); ?></strong>
          </div>
          <div class="wd-box-content">
            <div class="wd-group">
              <label class="wd-label"><?php _e('Send to', WDFM()->prefix); ?></label>
              <?php
              $fields = explode('*:*id*:*type_submitter_mail*:*type*:*', $row->form_fields);
              $fields_count = count($fields);
              if ( $fields_count == 1 ) {
                _e('There is no email field', WDFM()->prefix);
              }
              else {
                for ( $i = 0; $i < $fields_count - 1; $i++ ) {
                  ?>
                  <div>
                    <input type="checkbox" name="send_to<?php echo $i; ?>" id="send_to<?php echo $i; ?>" value="<?php echo(!is_numeric($fields[$i]) ? substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) : $fields[$i]); ?>" <?php echo(is_numeric(strpos($row->send_to, '*' . (!is_numeric($fields[$i]) ? substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) : $fields[$i]) . '*')) ? 'checked="checked"' : ''); ?> style="margin: 0px 5px 0px 0px;" />
                    <label for="send_to<?php echo $i; ?>"><?php echo substr($fields[$i + 1], 0, strpos($fields[$i + 1], '*:*w_field_label*:*')); ?></label>
                  </div>
                  <?php
                }
              }
              ?>
              <p class="description"><?php _e('Use this setting to select the email field of your form, to which the submissions will be sent.', WDFM()->prefix); ?></p>
            </div>
            <div class="wd-group">
              <label class="wd-label" for="mail_subject_user"><?php _e('Subject', WDFM()->prefix); ?></label>
              <input type="text" name="mail_subject_user" value="<?php echo $row->mail_subject_user ?>" id="mail_subject_user" class="mail_subject_user" />
              <span class="dashicons dashicons-plus-alt" onclick="document.getElementById('mail_subject_user_labels').style.display='block';"></span>
              <div style="position:relative; top:-1px;">
                <div id="mail_subject_user_labels" class="email_labels" style="display:none;">
                  <?php
                  $choise = "'mail_subject_user'";
                  for ( $i = 0; $i < count($label_label); $i++ ) {
                    if ( $label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_mark_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_file_upload" || $label_type[$i] == "type_send_copy" ) {
                      continue;
                    }
                    $param = htmlspecialchars(addslashes($label_label[$i]));
                    $fld_label = $param;
                    if ( strlen($fld_label) > 30 ) {
                      $fld_label = wordwrap(htmlspecialchars(addslashes($label_label[$i])), 30);
                      $fld_label = explode("\n", $fld_label);
                      $fld_label = $fld_label[0] . ' ...';
                    }
                    echo "<a onClick=\"insertAtCursor(" . $choise . ",'" . $param . "'); document.getElementById('mail_subject_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">" . $fld_label . "</a>";
                  }
                  echo "<a onClick=\"insertAtCursor(" . $choise . ",'subid'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Submission ID</a>";
                  echo "<a onClick=\"insertAtCursor(" . $choise . ",'username'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Username</a>";
                  ?>
                </div>
              </div>
              <p class="description"><?php _e('Add a custom subject for the submission email. Click the Plus (+) button to select a form field, the value of which will be set as the subject. In case it’s left blank, Form Title will be set as the subject of submission emails.', WDFM()->prefix); ?></p>
            </div>
            <div class="wd-group">
              <label class="wd-label" for="script_mail_user"><?php _e('Custom Text in Email For User', WDFM()->prefix); ?></label>
              <div class="fm_textarea-buttons">
                <?php $choise = "'script_mail_user'"; ?>
                <input class="button" type="button" value="All fields list" onClick="insertAtCursor(<?php echo $choise; ?>, 'all')" />
                <input class="button" type="button" value="Submission ID" onClick="insertAtCursor(<?php echo $choise; ?>,'subid')" />
                <input class="button" type="button" value="Ip" onClick="insertAtCursor(<?php echo $choise; ?>,'ip')" />
                <input class="button" type="button" value="Username" onClick="insertAtCursor(<?php echo $choise; ?>,'username')" />
                <input class="button" type="button" value="User Email" onClick="insertAtCursor(<?php echo $choise; ?>,'useremail')" />
                <?php
                for ( $i = 0; $i < count($label_label); $i++ ) {
                  if ( $label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_mark_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_send_copy" ) {
                    continue;
                  }
                  $param = htmlspecialchars(addslashes($label_label[$i]));
                  $fld_label = $param;
                  if ( strlen($fld_label) > 30 ) {
                    $fld_label = wordwrap(htmlspecialchars(addslashes($label_label[$i])), 30);
                    $fld_label = explode("\n", $fld_label);
                    $fld_label = $fld_label[0] . ' ...';
                  }
                  if ( $label_type[$i] == "type_file_upload" ) {
                    ?>
                    <input class="button" type="button" value="<?php echo $fld_label . '(as image)'; ?>" onClick="insertAtCursor(<?php echo $choise; ?>, '<?php echo $param; ?>')" />
                    <input class="button" type="button" value="<?php echo $fld_label . '(as link)'; ?>" onClick="insertAtCursor(<?php echo $choise; ?>, '<?php echo $param . '(link)'; ?>')" />
                    <?php
                  }
                  else {
                    ?>
                    <input class="button" type="button" value="<?php echo $fld_label; ?>" onClick="insertAtCursor(<?php echo $choise; ?>, '<?php echo $param; ?>')" />
                    <?php
                  }
                }
                ?>
                <input <?php echo($row->mail_verify == 0 ? 'style="display:none;"' : ''); ?> class="button verification_div" type="button" value="Verification link" onClick="insertAtCursor(<?php echo $choise; ?>,'Verification link')" />
              </div>
              <?php
              if ( user_can_richedit() ) {
                wp_editor($row->script_mail_user, 'script_mail_user', array(
                  'teeny' => TRUE,
                  'textarea_name' => 'script_mail_user',
                  'media_buttons' => FALSE,
                  'textarea_rows' => 5
                ));
              }
              else {
                ?>
                <textarea name="script_mail_user" id="script_mail_user" cols="20" rows="10" style="width:300px; height:450px;"><?php echo $row->script_mail_user; ?></textarea>
                <?php
              }
              ?>
              <p class="description"><?php _e('Write custom content to the email message which is sent to submitter. Include All Fields List to forward all submitted information, or click on fields buttons to use individual field values in the content.', WDFM()->prefix); ?></p>
            </div>
            <div class="postbox closed">
              <button class="button-link handlediv" type="button" aria-expanded="true">
                <span class="screen-reader-text"><?php _e('Toggle panel:', WDFM()->prefix); ?></span>
                <span class="toggle-indicator" aria-hidden="false"></span>
              </button>
              <h2 class="hndle">
                <span><?php _e('Advanced', WDFM()->prefix); ?></span>
              </h2>
              <div class="inside">
                <div class="wd-group">
                  <label class="wd-label" for="mail_from_user"><?php _e('Email From', WDFM()->prefix); ?></label>
                  <input type="text" id="mail_from_user" name="mail_from_user" value="<?php echo $row->mail_from_user; ?>" />
                  <p class="description"><?php _e('Specify the email address from which the submitter will receive the email.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="mail_from_name_user"><?php _e('From Name', WDFM()->prefix); ?></label>
                  <input type="text" name="mail_from_name_user" value="<?php echo $row->mail_from_name_user; ?>" id="mail_from_name_user" class="mail_from_name_user" />
                  <span class="dashicons dashicons-plus-alt" onclick="document.getElementById('mail_from_name_user_labels').style.display='block';"></span>
                  <div style="position:relative; top:-1px;">
                    <div id="mail_from_name_user_labels" class="email_labels" style="display:none;">
                      <?php
                      $choise = "'mail_from_name_user'";
                      for ( $i = 0; $i < count($label_label); $i++ ) {
                        if ( $label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_mark_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_file_upload" || $label_type[$i] == "type_send_copy" ) {
                          continue;
                        }
                        $param = htmlspecialchars(addslashes($label_label[$i]));
                        $fld_label = $param;
                        if ( strlen($fld_label) > 30 ) {
                          $fld_label = wordwrap(htmlspecialchars(addslashes($label_label[$i])), 30);
                          $fld_label = explode("\n", $fld_label);
                          $fld_label = $fld_label[0] . ' ...';
                        }
                        echo "<a onClick=\"insertAtCursor(" . $choise . ",'" . $param . "'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">" . $fld_label . "</a>";
                      }
                      echo "<a onClick=\"insertAtCursor(" . $choise . ",'subid'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Submission ID</a>";
                      echo "<a onClick=\"insertAtCursor(" . $choise . ",'username'); document.getElementById('mail_from_name_user_labels').style.display='none';\" style=\"display:block; text-decoration:none;\">Username</a>";
                      ?>
                    </div>
                  </div>
                  <p class="description"><?php _e('Set the name which is shown as the sender’s name in submission or confirmation emails. Press the Plus (+) button to select a field value.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="reply_to_user"><?php _e('Reply to (if different from "Email From")', WDFM()->prefix); ?></label>
                  <input type="text" name="reply_to_user" value="<?php echo $row->reply_to_user; ?>" id="reply_to_user" />
                  <p class="description"><?php _e('Specify an alternative email address, to which the submitter will be able to reply upon receiving the message.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="mail_cc_user"><?php _e('CC', WDFM()->prefix); ?></label>
                  <input type="text" name="mail_cc_user" value="<?php echo $row->mail_cc_user ?>" id="mail_cc_user" />
                  <p class="description"><?php _e('Provide additional email addresses to send the submission or confirmation email to. The receiver will be able to view all other recipients.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label" for="mail_bcc_user"><?php _e('BCC', WDFM()->prefix); ?></label>
                  <input type="text" name="mail_bcc_user" value="<?php echo $row->mail_bcc_user ?>" id="mail_bcc_user" />
                  <p class="description"><?php _e('Write additional email addresses to send the submission or confirmation email to. The receiver will not be able to view other recipients.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label"><?php _e('Mode', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_mode_user" <?php echo $row->mail_mode_user == 1 ? 'checked="checked"' : '' ?> id="fm_mo_mail_mode_user-1" class="wd-radio" value="1">
                  <label class="wd-label-radio" for="fm_mo_mail_mode_user-1"><?php _e('HTML', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_mode_user" <?php echo $row->mail_mode_user == 0 ? 'checked="checked"' : '' ?> id="fm_mo_mail_mode_user-0" class="wd-radio" value="0">
                  <label class="wd-label-radio" for="fm_mo_mail_mode_user-0"><?php _e('Text', WDFM()->prefix); ?></label>
                  <p class="description"><?php _e('Select the layout of the submission email, Text or HTML.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label"><?php _e('Attach File', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_attachment_user" <?php echo $row->mail_attachment_user == 1 ? 'checked="checked"' : '' ?> id="fm_mo_mail_attachment_user-1" class="wd-radio" value="1">
                  <label class="wd-label-radio" for="fm_mo_mail_attachment_user-1"><?php _e('Yes', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_attachment_user" <?php echo $row->mail_attachment_user == 0 ? 'checked="checked"' : '' ?> id="fm_mo_mail_attachment_user-0" class="wd-radio" value="0">
                  <label class="wd-label-radio" for="fm_mo_mail_attachment_user-0"><?php _e('No', WDFM()->prefix); ?></label>
                  <p class="description"><?php _e('If you have File Upload fields on your form, enable this setting to attach uploaded files to submission or confirmation email.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group">
                  <label class="wd-label"><?php _e('Email verification', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_verify" <?php echo $row->mail_verify == 1 ? 'checked="checked"' : '' ?> id="fm_mo_mail_verify-1" onclick="wdshow('expire_link')" class="wd-radio" value="1">
                  <label class="wd-label-radio" for="fm_mo_mail_verify-1"><?php _e('Yes', WDFM()->prefix); ?></label>
                  <input type="radio" name="mail_verify" <?php echo $row->mail_verify == 0 ? 'checked="checked"' : '' ?> id="fm_mo_mail_verify-0" onclick="wdhide('expire_link')" class="wd-radio" value="0">
                  <label class="wd-label-radio" for="fm_mo_mail_verify-0"><?php _e('No', WDFM()->prefix); ?></label>
                  <p class="description"><?php _e('Activate this option, in case you would like the users to verify their email addresses. If it’s enabled, the user email will contain a verification link.', WDFM()->prefix); ?></p>
                </div>
                <div class="wd-group" <?php echo($row->mail_verify == 0 ? 'style="display:none;"' : '') ?> id="expire_link">
                  <label class="wd-label" for="mail_verify_expiretime"><?php _e('Verification link expires in', WDFM()->prefix); ?></label>
                  <input class="inputbox" type="text" name="mail_verify_expiretime" maxlength="10" value="<?php echo($row->mail_verify_expiretime ? $row->mail_verify_expiretime : 0); ?>" onkeypress="return check_isnum_point(event)" id="mail_verify_expiretime">
                  <small><?php _e(' -- hours (0 - never expires).', WDFM()->prefix); ?></small>
                  <a target="_blank" href="<?php echo add_query_arg(array(
                                                                      'post' => $params["mail_ver_id"],
                                                                      'action' => 'edit',
                                                                    ), admin_url('post.php')); ?>"><?php _e('Edit post', WDFM()->prefix); ?></a>
                  <p class="description"><?php _e('Use this option to specify a time period (hours), during which the user will be able to verify their email address.', WDFM()->prefix); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="actions_fieldset" class="adminform fm_fieldset_deactive">
    <div class="wd-table">
      <div class="wd-table-col-70">
        <div class="wd-box-section">
          <div class="wd-box-content">
						<span class="wd-group">
							<label class="wd-label"><?php _e('Action type', WDFM()->prefix); ?></label>
							<input type="radio" name="submit_text_type" id="text_type_none" onclick="set_type('none')" value="1" <?php echo ($row->submit_text_type != 2 && $row->submit_text_type != 3 && $row->submit_text_type != 4 && $row->submit_text_type != 5) ? "checked" : ""; ?> />
							<label for="text_type_none"><?php _e('Stay on Form', WDFM()->prefix); ?></label>
							<br>
							<input type="radio" name="submit_text_type" id="text_type_post" onclick="set_type('post')" value="2" <?php echo ($row->submit_text_type == 2) ? "checked" : ""; ?> />
							<label for="text_type_post"><?php _e('Post', WDFM()->prefix); ?></label>
							<br>
							<input type="radio" name="submit_text_type" id="text_type_page" onclick="set_type('page')" value="5" <?php echo ($row->submit_text_type == 5) ? "checked" : ""; ?> />
							<label for="text_type_page"><?php _e('Page', WDFM()->prefix); ?></label>
							<br>
							<input type="radio" name="submit_text_type" id="text_type_custom_text" onclick="set_type('custom_text')" value="3" <?php echo ($row->submit_text_type == 3) ? "checked" : ""; ?> />
							<label for="text_type_custom_text"><?php _e('Custom Text', WDFM()->prefix); ?></label>
							<br>
							<input type="radio" name="submit_text_type" id="text_type_url" onclick="set_type('url')" value="4" <?php echo ($row->submit_text_type == 4) ? "checked" : ""; ?> />
							<label for="text_type_url"><?php _e('URL', WDFM()->prefix); ?></label>
						</span>
            <span class="wd-group">
							<div id="post" <?php echo(($row->submit_text_type != 2) ? 'style="display:none"' : ''); ?>>
								<label class="wd-label"><?php _e('Post', WDFM()->prefix); ?></label>
								<select id="post_name" name="post_name">
									<option value="0">- Select Post -</option>
                  <?php
                  $args = array( 'posts_per_page' => 10000 );
                  query_posts($args);
                  while ( have_posts() ) : the_post();
                    ?>
                    <option value="<?php $x = get_permalink(get_the_ID());
                    echo $x; ?>" <?php echo(($row->article_id == $x) ? 'selected="selected"' : ''); ?>><?php the_title(); ?></option>
                    <?php
                  endwhile;
                  wp_reset_query();
                  ?>
								</select>								
							</div>
							<div id="page" <?php echo(($row->submit_text_type != 5) ? 'style="display:none"' : ''); ?>>
								<label class="wd-label"><?php _e('Page', WDFM()->prefix); ?></label>
								<select id="page_name" name="page_name">
									<option value="0">- Select Page -</option>
                  <?php
                  $pages = get_pages();
                  foreach ( $pages as $page ) {
                    $page_id = get_page_link($page->ID);
                    ?>
                    <option value="<?php echo $page_id; ?>" <?php echo(($row->article_id == $page_id) ? 'selected="selected"' : ''); ?>><?php echo $page->post_title; ?></option>
                    <?php
                  }
                  wp_reset_query();
                  ?>
								</select>
							</div>
							<div id="custom_text" <?php echo(($row->submit_text_type != 3) ? 'style="display: none;"' : ''); ?>>
								<label class="wd-label"><?php _e('Text', WDFM()->prefix); ?></label>
								<div class="fm_textarea-buttons">
									<?php $choise = "'submit_text'"; ?>
                  <input class="button" type="button" value="Submission ID" onClick="insertAtCursor(<?php echo $choise; ?>,'subid')" />
									<input class="button" type="button" value="Ip" onClick="insertAtCursor(<?php echo $choise; ?>,'ip')" />
									<input class="button" type="button" value="User Id" onClick="insertAtCursor(<?php echo $choise; ?>, 'userid')" />
									<input class="button" type="button" value="Username" onClick="insertAtCursor(<?php echo $choise; ?>,'username')" />
									<input class="button" type="button" value="User Email" onClick="insertAtCursor(<?php echo $choise; ?>,'useremail')" />
                  <?php
                  for ( $i = 0; $i < count($label_label); $i++ ) {
                    if ( $label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_mark_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_send_copy" || $label_type[$i] == "type_file_upload" ) {
                      continue;
                    }
                    $param = htmlspecialchars(addslashes($label_label[$i]));
                    $fld_label = $param;
                    if ( strlen($fld_label) > 30 ) {
                      $fld_label = wordwrap(htmlspecialchars(addslashes($label_label[$i])), 30);
                      $fld_label = explode("\n", $fld_label);
                      $fld_label = $fld_label[0] . ' ...';
                    }
                    ?>
                    <input class="button" type="button" value="<?php echo $fld_label; ?>" onClick="insertAtCursor(<?php echo $choise; ?>, '<?php echo $param; ?>')" />
                    <?php
                  }
                  ?>
								</div>
                <?php
                if ( user_can_richedit() ) {
                  wp_editor($row->submit_text, 'submit_text', array(
                    'teeny' => TRUE,
                    'textarea_name' => 'submit_text',
                    'media_buttons' => FALSE,
                    'textarea_rows' => 5
                  ));
                }
                else {
                  ?>
                  <textarea cols="36" rows="5" id="submit_text" name="submit_text" style="resize: vertical; width:100%">
										<?php echo $row->submit_text; ?>
									</textarea>
                  <?php
                }
                ?>
							</div>
							<div id="url" <?php echo(($row->submit_text_type != 4) ? 'style="display:none"' : ''); ?>>
								<label class="wd-label"><?php _e('URL', WDFM()->prefix); ?></label>
								<input type="text" id="url" name="url" value="<?php echo $row->url; ?>" />
							</div>
						</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="payment_fieldset" class="adminform fm_fieldset_deactive">
    <div class="wd-table">
      <div class="wd-table-col-70">
        <div class="wd-box-section">
          <div class="wd-box-content">
            <div class="wd-group">
              <label class="wd-label"><?php _e('Payment Method', WDFM()->prefix); ?></label>
              <input type="radio" name="paypal_mode" id="paypal_mode0" value="none" class="wd-radio" <?php echo ($payment_method == "none") ? "checked" : ""; ?> onchange="fm_change_payment_method('none');" />
              <label for="paypal_mode0"><?php _e('None', WDFM()->prefix); ?></label><br>
              <input type="radio" name="paypal_mode" id="paypal_mode1" value="paypal" class="wd-radio" <?php echo ($payment_method == "paypal") ? "checked" : ""; ?> onchange="fm_change_payment_method('paypal');" />
              <label for="paypal_mode1"><?php _e('Paypal', WDFM()->prefix); ?></label><br>
              <input type="radio" name="paypal_mode" id="paypal_mode2" value="stripe" <?php echo ($payment_method == "stripe") ? "checked" : ""; ?> class="wd-radio" onchange="fm_change_payment_method('stripe');" />
              <label for="paypal_mode2"><?php _e('Stripe', WDFM()->prefix); ?></label>
            </div>
            <div class="fm_payment_option">
              <div class="wd-group">
                <label class="wd-label" for="payment_currency"><?php _e('Payment Currency', WDFM()->prefix); ?></label>
                <select id="payment_currency" name="payment_currency">
                  <option value="USD" <?php echo(($row->payment_currency == 'USD') ? 'selected' : ''); ?>>$ &#8226; U.S. Dollar</option>
                  <option value="EUR" <?php echo(($row->payment_currency == 'EUR') ? 'selected' : ''); ?>>&#8364; &#8226; Euro</option>
                  <option value="GBP" <?php echo(($row->payment_currency == 'GBP') ? 'selected' : ''); ?>>&#163; &#8226; Pound Sterling</option>
                  <option value="JPY" <?php echo(($row->payment_currency == 'JPY') ? 'selected' : ''); ?>>&#165; &#8226; Japanese Yen</option>
                  <option value="CAD" <?php echo(($row->payment_currency == 'CAD') ? 'selected' : ''); ?>>C$ &#8226; Canadian Dollar</option>
                  <option value="MXN" <?php echo(($row->payment_currency == 'MXN') ? 'selected' : ''); ?>>Mex$ &#8226; Mexican Peso</option>
                  <option value="HKD" <?php echo(($row->payment_currency == 'HKD') ? 'selected' : ''); ?>>HK$ &#8226; Hong Kong Dollar</option>
                  <option value="HUF" <?php echo(($row->payment_currency == 'HUF') ? 'selected' : ''); ?>>Ft &#8226; Hungarian Forint</option>
                  <option value="NOK" <?php echo(($row->payment_currency == 'NOK') ? 'selected' : ''); ?>>kr &#8226; Norwegian Kroner</option>
                  <option value="NZD" <?php echo(($row->payment_currency == 'NZD') ? 'selected' : ''); ?>>NZ$ &#8226; New Zealand Dollar</option>
                  <option value="SGD" <?php echo(($row->payment_currency == 'SGD') ? 'selected' : ''); ?>>S$ &#8226; Singapore Dollar</option>
                  <option value="SEK" <?php echo(($row->payment_currency == 'SEK') ? 'selected' : ''); ?>>kr &#8226; Swedish Kronor</option>
                  <option value="PLN" <?php echo(($row->payment_currency == 'PLN') ? 'selected' : ''); ?>>zl &#8226; Polish Zloty</option>
                  <option value="AUD" <?php echo(($row->payment_currency == 'AUD') ? 'selected' : ''); ?>>A$ &#8226; Australian Dollar</option>
                  <option value="DKK" <?php echo(($row->payment_currency == 'DKK') ? 'selected' : ''); ?>>kr &#8226; Danish Kroner</option>
                  <option value="CHF" <?php echo(($row->payment_currency == 'CHF') ? 'selected' : ''); ?>>CHF &#8226; Swiss Francs</option>
                  <option value="CZK" <?php echo(($row->payment_currency == 'CZK') ? 'selected' : ''); ?>>Kc &#8226; Czech Koruny</option>
                  <option value="ILS" <?php echo(($row->payment_currency == 'ILS') ? 'selected' : ''); ?>>&#8362; &#8226; Israeli Sheqel</option>
                  <option value="BRL" <?php echo(($row->payment_currency == 'BRL') ? 'selected' : ''); ?>>R$ &#8226; Brazilian Real</option>
                  <option value="TWD" <?php echo(($row->payment_currency == 'TWD') ? 'selected' : ''); ?>>NT$ &#8226; Taiwan New Dollars</option>
                  <option value="MYR" <?php echo(($row->payment_currency == 'MYR') ? 'selected' : ''); ?>>RM &#8226; Malaysian Ringgit</option>
                  <option value="PHP" <?php echo(($row->payment_currency == 'PHP') ? 'selected' : ''); ?>>&#8369; &#8226; Philippine Peso</option>
                  <option value="THB" <?php echo(($row->payment_currency == 'THB') ? 'selected' : ''); ?>>&#xe3f; &#8226; Thai Bahtv</option>
                </select>
                <p class="description"><?php _e('Choose the currency to be used for the payments made through your form.', WDFM()->prefix); ?></p>
              </div>
              <div class="wd-group">
                <label class="wd-label" for="tax"><?php _e('Tax', WDFM()->prefix); ?> (%)</label>
                <input type="text" name="tax" id="tax" value="<?php echo $row->tax; ?>" class="text_area" onKeyPress="return check_isnum_point(event)">
                <p class="description"><?php _e('Specify the percentage of the tax. It will be calculated from the total payment amount of your form.', WDFM()->prefix); ?></p>
              </div>
              <div class="wd-group">
                <label class="wd-label"><?php _e('Checkout Mode', WDFM()->prefix); ?></label>
                <input type="radio" name="checkout_mode" <?php echo $row->checkout_mode == 1 ? 'checked="checked"' : '' ?> id="checkout_mode-1" class="wd-radio" value="1">
                <label class="wd-label-radio" for="checkout_mode-1"><?php _e('Production', WDFM()->prefix); ?></label>
                <input type="radio" name="checkout_mode" <?php echo $row->checkout_mode == 0 ? 'checked="checked"' : '' ?> id="checkout_mode-0" class="wd-radio" value="0">
                <label class="wd-label-radio" for="checkout_mode-0"><?php _e('Testmode', WDFM()->prefix); ?></label>
              </div>
              <div class="wd-group">
                <label class="wd-label" for="paypal_email"><?php _e('Paypal email', WDFM()->prefix); ?></label>
                <input type="text" name="paypal_email" id="paypal_email" value="<?php echo $row->paypal_email; ?>" class="text_area">
                <p class="description"><?php _e('Provide the email address of a valid PayPal account. It will receive the payments made through your form.', WDFM()->prefix); ?></p>
              </div>
            </div>
            <div class="fm_payment_option_stripe">
              <?php
              if ( $stripe_addon['enable'] && !empty($stripe_addon['html']) ) {
                echo $stripe_addon['html'];
              }
              else {
                $stripe_add_on_link = '<a href="https://web-dorado.com/products/wordpress-form/add-ons/stripe.html" target="_blank">' . __('Form Maker Stripe Integration', WDFM()->prefix) . '</a>';
                echo '<div class="error inline"><p>' . sprintf(__("Please install %s add-on to use this feature.", WDFM()->prefix), $stripe_add_on_link) . '</p></div>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="javascript_fieldset" class="adminform fm_fieldset_deactive">
    <div class="wd-table">
      <div class="wd-table-col-100">
        <div class="wd-box-section">
          <div class="wd-box-content">
						<span class="wd-group">
							<textarea cols="60" rows="30" name="javascript" id="form_javascript"><?php echo $row->javascript; ?></textarea>
						</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="conditions_fieldset" class="adminform fm_fieldset_deactive">
    <?php
    $ids = array();
    $types = array();
    $labels = array();
    $paramss = array();
    $all_ids = array();
    $all_labels = array();
    $select_and_input = array(
      "type_text",
      "type_password",
      "type_textarea",
      "type_name",
      "type_number",
      "type_phone",
      "type_phone_new",
      "type_submitter_mail",
      "type_address",
      "type_spinner",
      "type_checkbox",
      "type_radio",
      "type_own_select",
      "type_paypal_price",
      "type_paypal_price_new",
      "type_paypal_select",
      "type_paypal_checkbox",
      "type_paypal_radio",
      "type_paypal_shipping",
      "type_date_new"
    );
    $select_type_fields = array(
      "type_address",
      "type_checkbox",
      "type_radio",
      "type_own_select",
      "type_paypal_select",
      "type_paypal_checkbox",
      "type_paypal_radio",
      "type_paypal_shipping"
    );
    $fields = explode('*:*new_field*:*', $row->form_fields);
    $fields = array_slice($fields, 0, count($fields) - 1);
    foreach ( $fields as $field ) {
      $temp = explode('*:*id*:*', $field);
      array_push($ids, $temp[0]);
      array_push($all_ids, $temp[0]);
      $temp = explode('*:*type*:*', $temp[1]);
      array_push($types, $temp[0]);
      $temp = explode('*:*w_field_label*:*', $temp[1]);
      array_push($labels, $temp[0]);
      array_push($all_labels, $temp[0]);
      array_push($paramss, $temp[1]);
    }
    foreach ( $types as $key => $value ) {
      if ( !in_array($types[$key], $select_and_input) ) {
        unset($ids[$key]);
        unset($labels[$key]);
        unset($types[$key]);
        unset($paramss[$key]);
      }
    }
    $ids = array_values($ids);
    $labels = array_values($labels);
    $types = array_values($types);
    $paramss = array_values($paramss);
    $chose_ids = implode('@@**@@', $ids);
    $chose_labels = implode('@@**@@', $labels);
    $chose_types = implode('@@**@@', $types);
    $chose_paramss = implode('@@**@@', $paramss);
    $all_ids_cond = implode('@@**@@', $all_ids);
    $all_labels_cond = implode('@@**@@', $all_labels);
    $show_hide = array();
    $field_label = array();
    $all_any = array();
    $condition_params = array();
    $count_of_conditions = 0;
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
    }
    else {
      $show_hide[0] = 1;
      $all_any[0] = 'and';
      $condition_params[0] = '';
      if ( $all_ids ) {
        $field_label[0] = $all_ids[0];
      }
    }
    ?>
    <div class="wd-table">
      <div class="wd-table-col-70">
        <div class="wd-box-section">
          <div class="wd-box-content">
            <div class="wd-group" id="conditions_fieldset_wrap">
              <p class="description"><?php _e('Press Add Condition button to configure the first condition of your form. Show/Hide select box represents the action which will be completed, if all or any of the condition statements are fulfilled. Use the second drop-down menu to select the field which will be shown or hidden. Click the little Plus (+) icon to add the statement of your form condition.', WDFM()->prefix); ?><br><br></p>
              <div style="text-align: right;">
                  <button class="wd-button button-primary" onclick="add_condition('<?php echo $chose_ids; ?>', '<?php echo htmlspecialchars(addslashes($chose_labels)); ?>', '<?php echo $chose_types; ?>', '<?php echo htmlspecialchars(addslashes($chose_paramss)); ?>', '<?php echo $all_ids_cond; ?>', '<?php echo htmlspecialchars(addslashes($all_labels_cond)); ?>'); return false;"><?php _e('Add Condition', WDFM()->prefix); ?></button>
              </div>
              <?php
              for ( $k = 0; $k < $count_of_conditions; $k++ ) {
                if ( in_array($field_label[$k], $all_ids) ) { ?>
                  <div id="condition<?php echo $k; ?>" class="fm_condition">
                    <div id="conditional_fileds<?php echo $k; ?>">
                      <select id="show_hide<?php echo $k; ?>" name="show_hide<?php echo $k; ?>" class="fm_condition_show_hide">
                        <option value="1" <?php if ( $show_hide[$k] == 1 ) {
                          echo 'selected="selected"';
                        } ?>><?php _e('Show', WDFM()->prefix); ?></option>
                        <option value="0" <?php if ( $show_hide[$k] == 0 ) {
                          echo 'selected="selected"';
                        } ?>><?php _e('Hide', WDFM()->prefix); ?></option>
                      </select>
                      <select id="fields<?php echo $k; ?>" name="fields<?php echo $k; ?>" class="fm_condition_fields">
                        <?php
                        foreach ( $all_labels as $key => $value ) {
                          if ( $field_label[$k] == $all_ids[$key] ) {
                            $selected = 'selected="selected"';
                          }
                          else {
                            $selected = '';
                          }
                          echo '<option value="' . $all_ids[$key] . '" ' . $selected . '>' . $value . '</option>';
                        }
                        ?>
                      </select>
                      <span>if</span>
                      <select id="all_any<?php echo $k; ?>" name="all_any<?php echo $k; ?>" class="fm_condition_all_any">
                        <option value="and" <?php if ( $all_any[$k] == "and" ) {
                          echo 'selected="selected"';
                        } ?>><?php _e('all', WDFM()->prefix); ?></option>
                        <option value="or" <?php if ( $all_any[$k] == "or" ) {
                          echo 'selected="selected"';
                        } ?>><?php _e('any', WDFM()->prefix); ?></option>
                      </select>
                      <span style="display: inline-block; width: 100%; max-width: 235px;"><?php _e('of the following match:', WDFM()->prefix); ?></span>
                      <span class="dashicons dashicons-trash" onclick="delete_condition('<?php echo $k; ?>')"></span>
                      <span class="dashicons dashicons-plus-alt" onclick="add_condition_fields(<?php echo $k; ?>,'<?php echo $chose_ids; ?>', '<?php echo htmlspecialchars(addslashes($chose_labels)); ?>', '<?php echo $chose_types; ?>', '<?php echo htmlspecialchars(addslashes($chose_paramss)); ?>')"></span>
                    </div>
                    <?php
                    if ( $condition_params[$k] ) {
                      $_params = explode('*:*next_condition*:*', $condition_params[$k]);
                      $_params = array_slice($_params, 0, count($_params) - 1);
                      foreach ( $_params as $key => $_param ) {
                        $key_select_or_input = '';
                        $param_values = explode('***', $_param);
                        $multiselect = explode('@@@', $param_values[2]);
                        if ( in_array($param_values[0], $ids) ) { ?>
                          <div id="condition_div<?php echo $k; ?>_<?php echo $key; ?>">
                            <select id="field_labels<?php echo $k; ?>_<?php echo $key; ?>" class="fm_condition_field_labels" onchange="change_choices(this.options[this.selectedIndex].id+'_<?php echo $key; ?>','<?php echo $chose_ids; ?>', '<?php echo $chose_types; ?>', '<?php echo htmlspecialchars(addslashes($chose_paramss)); ?>')">
                              <?php
                              foreach ( $labels as $key1 => $value ) {
                                if ( $param_values[0] == $ids[$key1] ) {
                                  $selected = 'selected="selected"';
                                  if ( $types[$key1] == "type_checkbox" || $types[$key1] == "type_paypal_checkbox" ) {
                                    $multiple = 'multiple="multiple" class="multiple_select"';
                                  }
                                  else {
                                    $multiple = '';
                                  }
                                  $key_select_or_input = $key1;
                                }
                                else {
                                  $selected = '';
                                }
                                if ( $field_label[$k] != $ids[$key1] ) {
                                  echo '<option id="' . $k . '_' . $key1 . '" value="' . $ids[$key1] . '" ' . $selected . '>' . $value . '</option>';
                                }
                              }
                              ?>
                            </select>

                            <select id="is_select<?php echo $k; ?>_<?php echo $key; ?>" class="fm_condition_is_select">
                              <option value="==" <?php if ( $param_values[1] == "==" ) {
                                echo 'selected="selected"';
                              } ?>>is
                              </option>
                              <option value="!=" <?php if ( $param_values[1] == "!=" ) {
                                echo 'selected="selected"';
                              } ?>>is not
                              </option>
                              <option value="%" <?php if ( $param_values[1] == "%" ) {
                                echo 'selected="selected"';
                              } ?>>like
                              </option>
                              <option value="!%" <?php if ( $param_values[1] == "!%" ) {
                                echo 'selected="selected"';
                              } ?>>not like
                              </option>
                              <option value="=" <?php if ( $param_values[1] == "=" ) {
                                echo 'selected="selected"';
                              } ?>>empty
                              </option>
                              <option value="!" <?php if ( $param_values[1] == "!" ) {
                                echo 'selected="selected"';
                              } ?>>not empty
                              </option>
                            </select>

                            <?php if ( $key_select_or_input !== '' && in_array($types[$key_select_or_input], $select_type_fields) ) : ?>
                              <select id="field_value<?php echo $k; ?>_<?php echo $key; ?>" <?php echo $multiple; ?> class="fm_condition_field_select_value">
                                <?php
                                switch ( $types[$key_select_or_input] ) {
                                  case "type_own_select":
                                  case "type_paypal_select":
                                    $w_size = explode('*:*w_size*:*', $paramss[$key_select_or_input]);
                                    break;
                                  case "type_radio":
                                  case "type_checkbox":
                                  case "type_paypal_radio":
                                  case "type_paypal_checkbox":
                                  case "type_paypal_shipping":
                                    $w_size = explode('*:*w_flow*:*', $paramss[$key_select_or_input]);
                                    break;
                                }
                                $w_choices = explode('*:*w_choices*:*', $w_size[1]);
                                $w_choices_array = explode('***', $w_choices[0]);
                                if ( $types[$key_select_or_input] == 'type_radio' || $types[$key_select_or_input] == 'type_checkbox' || $types[$key_select_or_input] == 'type_own_select' ) {
                                  if ( strpos($w_choices[1], 'w_value_disabled') > -1 ) {
                                    $w_value_disabled = explode('*:*w_value_disabled*:*', $w_choices[1]);
                                    $w_choices_value = explode('*:*w_choices_value*:*', $w_value_disabled[1]);
                                    $w_choices_value = $w_choices_value[0];
                                  }
                                  if ( isset($w_choices_value) ) {
                                    $w_choices_value_array = explode('***', $w_choices_value);
                                  }
                                  else {
                                    $w_choices_value_array = $w_choices_array;
                                  }
                                }
                                else {
                                  $w_choices_price = explode('*:*w_choices_price*:*', $w_choices[1]);
                                  $w_choices_value = $w_choices_price[0];
                                  $w_choices_value_array = explode('***', $w_choices_value);
                                }
                                for ( $m = 0; $m < count($w_choices_array); $m++ ) {
                                  if ( $types[$key_select_or_input] == "type_paypal_checkbox" || $types[$key_select_or_input] == "type_paypal_radio" || $types[$key_select_or_input] == "type_paypal_shipping" || $types[$key_select_or_input] == "type_paypal_select" ) {
                                    $w_choice = $w_choices_array[$m] . '*:*value*:*' . $w_choices_value_array[$m];
                                  }
                                  else {
                                    $w_choice = $w_choices_value_array[$m];
                                  }
                                  if ( in_array(esc_html($w_choice), $multiselect) ) {
                                    $selected = 'selected="selected"';
                                  }
                                  else {
                                    $selected = '';
                                  }
                                  if ( strpos($w_choices_array[$m], '[') === FALSE && strpos($w_choices_array[$m], ']') === FALSE ) {
                                    echo '<option id="choise_' . $k . '_' . $m . '" value="' . $w_choice . '" ' . $selected . '>' . $w_choices_array[$m] . '</option>';
                                  }
                                }
                                if ( $types[$key_select_or_input] == "type_address" ) {
                                  $w_countries = WDW_FM_Library::get_countries();
                                  $w_options = '';
                                  foreach ( $w_countries as $w_country ) {
                                    if ( in_array($w_country, $multiselect) ) {
                                      $selected = 'selected="selected"';
                                    }
                                    else {
                                      $selected = '';
                                    }
                                    echo '<option value="' . $w_country . '" ' . $selected . '>' . $w_country . '</option>';
                                  }
                                }
                                ?>
                              </select>
                            <?php else :
                              if ( $key_select_or_input != '' && ($types[$key_select_or_input] == "type_number" || $types[$key_select_or_input] == "type_phone") ) {
                                $onkeypress_function = "onkeypress='return check_isnum_space(event)'";
                              }
                              else {
                                if ( $key_select_or_input != '' && ($types[$key_select_or_input] == "type_paypal_price" || $types[$key_select_or_input] == "type_paypal_price_new") ) {
                                  $onkeypress_function = "onkeypress='return check_isnum_point(event)'";
                                }
                                else {
                                  $onkeypress_function = "";
                                }
                              }
                              ?>
                              <input id="field_value<?php echo $k; ?>_<?php echo $key; ?>" type="text" value="<?php echo $param_values[2]; ?>" <?php echo $onkeypress_function; ?> class="fm_condition_field_input_value">
                            <?php endif; ?>
                            <span class="dashicons dashicons-trash" id="delete_condition<?php echo $k; ?>_<?php echo $key; ?>" onclick="delete_field_condition('<?php echo $k; ?>_<?php echo $key; ?>')"></span>
                          </div>
                          <?php
                        }
                      }
                    }
                    ?>
                  </div>
                  <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="condition" name="condition" value="<?php echo $row->condition; ?>" />
  </div>

  <div id="mapping_fieldset" class="adminform fm_fieldset_deactive">
    <?php
    if ( WDFM()->is_demo ) {
      echo WDW_FM_Library::message_id(0, 'This feature is disabled in demo.', 'error');
    }
    else {
    ?>
    <div class="wd-table">
      <div class="wd-table-col-70">
        <div class="wd-box-section">
          <div class="wd-box-content">
            <div class="wd-group">
              <p class="description"><?php _e('WordPress Form Maker stores the submitted information into [prefix]_formmaker_submits MySQL database table of your website by default. With MySQL Mapping functionality of Form Maker you can insert this data into any local or remote table of your choice, or perform other queries based on submitted values. Press Add Query button to configure the first query for this form.', WDFM()->prefix); ?></p><br><br>
              <div style="text-align: right; padding-bottom: 20px;">
                <button id="add_query" class="wd-button button-primary" onclick="tb_show('', '<?php echo add_query_arg(array(
                                                                                                                         'action' => 'FormMakerSQLMapping' . WDFM()->plugin_postfix,
                                                                                                                         'id' => 0,
                                                                                                                         'form_id' => $row->id,
                                                                                                                         'width' => '1000',
                                                                                                                         'height' => '500',
                                                                                                                         'TB_iframe' => '1'
                                                                                                                       ), admin_url('admin-ajax.php')); ?>'); return false;"><?php _e('Add Query', WDFM()->prefix); ?></button>
              </div>
              <?php if ( $queries ) { ?>
                <table class="wp-list-table widefat fixed posts table_content">
                  <thead>
                  <tr>
                    <th style="width:86%;" class="table_large_col"><?php _e('Query', WDFM()->prefix); ?></th>
                    <th style="width:14%;" class="table_large_col"><?php _e('Delete', WDFM()->prefix); ?></th>
                  </tr>
                  </thead>
                  <?php
                  for ( $i = 0, $n = count($queries); $i < $n; $i++ ) {
                    $query = $queries[$i];
                    $link = add_query_arg(array(
                                            'action' => 'FormMakerSQLMapping' . WDFM()->plugin_postfix,
                                            'id' => $query->id,
                                            'form_id' => $row->id,
                                            'width' => '1000',
                                            'height' => '500',
                                            'TB_iframe' => '1'
                                          ), admin_url('admin-ajax.php'));
                    $remove_query = add_query_arg(array(
                                                    'task' => 'remove_query',
                                                    'current_id' => $id,
                                                    'query_id' => $query->id,
                                                    'fieldset_id' => 'mapping'
                                                  ), $page_url)
                    ?>
                    <tr <?php if ( !$k ) {
                      echo "class=\"alternate\"";
                    } ?>>
                      <td align="center">
                        <a rel="{handler: 'iframe', size: {x: 530, y: 370}}" onclick="tb_show('', '<?php echo $link; ?>'); return false;" style="cursor:pointer;">
                          <?php echo $query->query; ?>
                        </a>
                      </td>
                      <td align="center" class="table_small_col check-column">
                        <a href="<?php echo $remove_query; ?>"><span class="dashicons dashicons-trash"></span></a></td>
                    </tr>
                    <?php
                  }
                  ?>
                </table>
                <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    }
        ?>
			</div>
			<?php
				if ( !empty ($addons['html']) ){
					foreach($addons['html'] as  $addon => $html) {
						echo $html;
					}
				}
			?>
		</div>
		<input type="hidden" name="boxchecked" value="0">
		<input type="hidden" name="fieldset_id" id="fieldset_id" value="<?php echo $fieldset_id; ?>" />
		<script>
			default_theme  = '<?php echo $default_theme; ?>';
			payment_method = '<?php echo $payment_method; ?>';
			theme_edit_url = '<?php echo add_query_arg( array('page' => 'themes' . WDFM()->menu_postfix, 'task' =>'edit'), $page_url); ?>';
			
			jQuery(document).ready( function () {
				set_theme();
			});
		</script>
		<?php		
	}
	
	/**
	* Form layout.
	*
	* @param array $params
	*
	*/
	public function form_layout( $params ) {
		wp_enqueue_style('fm-codemirror');
		wp_enqueue_style('fm-colorpicker');
		
		wp_enqueue_script('fm-codemirror');
		wp_enqueue_script('fm-formatting');
		wp_enqueue_script('fm-formatting');
		wp_enqueue_script('fm-clike');
		wp_enqueue_script('fm-css');
		wp_enqueue_script('fm-javascript');
		wp_enqueue_script('fm-xml');
		wp_enqueue_script('fm-php');
		wp_enqueue_script('fm-htmlmixed');
		wp_enqueue_script('fm-colorpicker');
		wp_enqueue_script('fm-form-advanced-layout');	
		
		$id 		= $params['id'];
		$page 		= $params['page'];
		$page_title = $params['page_title'];
		$page_url 	= $params['page_url'];
		$back_url 	= $params['back_url'];
		$row 		= $params['row'];

		$title = array(
					'title' => $page_title,
					'title_class' => 'wd-header',
					'add_new_button' => FALSE,
				);
		$buttons = array(
					'save' => array(
						'title' => __('Update', WDFM()->prefix),
						'value' => 'save',
						'onclick' => 'fm_apply_advanced_layout(\'apply_layout\');',
						'class' => 'button-primary'
					),
					'back' => array(
						'title' => __('Back to Form', WDFM()->prefix),
						'value' => 'back',
						'onclick' => 'window.open(\''. $back_url .'\', \'_self\'); return false;',
						'class' => 'button'
					)
				);
					
		ob_start();		
		echo $this->title( $title );
		echo $this->buttons( $buttons );			
		echo $this->body_form_layout( $params );
			
		// Pass the content to form.
		$form_attr = array(
			'id' => WDFM()->css_prefix . 'ApplyLayoutForm',
			'name' => 'adminForm',
			'class' => WDFM()->css_prefix . 'advanced_layout wd-form',
			'current_id' => $id,
			'enctype' => 'multipart/form-data',
			'action' => add_query_arg( array('page' => $page, 'current_id' => $id ), $page_url),
		);
		echo $this->form(ob_get_clean(), $form_attr);
	}
	
	/**
	* Generate page body form layout.
	*
	* @param array $params
	* @return string Body html.
	*/
	private function body_form_layout( $params ) { 
		$id = $params['id'];
		$row = $params['row'];
		$ids = $params['ids'];
		$types = $params['types'];
		$labels = $params['labels'];		
		?>
		<div class="wd-table">
			<div class="wd-table-col-100">
				<div class="wd-box-section">						  
					<div class="wd-box-content">
						<p><?php _e('To customize the layout of the form fields uncheck the Auto-Generate Layout box and edit the HTML.', WDFM()->prefix); ?></p>
						<p><?php _e('You can change positioning, add in-line styles and etc. Click on the provided buttons to add the corresponding field.', WDFM()->prefix); ?></p>
						<p><?php _e('This will add the following line:', WDFM()->prefix); ?> 
						<b><span class="cm-tag">&lt;div</span> <span class="cm-attribute">wdid</span>=<span class="cm-string">"example_id"</span> <span class="cm-attribute">class</span>=<span class="cm-string">"wdform_row"</span><span class="cm-tag">&gt;</span>%example_id - Example%<span class="cm-tag">&lt;/div&gt;</span></b>	, where <b><span class="cm-tag">&lt;div&gt;</span></b> <?php _e('is used to set a row.', WDFM()->prefix); ?></p>
						<p>
							<b style="color:red"><?php _e('Notice', WDFM()->prefix); ?></b><br>
							<?php _e('Make sure not to publish the same field twice. This will cause malfunctioning of the form.', WDFM()->prefix); ?>
						</p>
						<div class="wd-group">
							<label class="wd-label autogen_layout_label" for="autogen_layout"><?php _e('Auto Generate Layout?', WDFM()->prefix); ?></label>
							<input type="checkbox" value="1" name="autogen_layout" id="autogen_layout" <?php echo (($row->autogen_layout) ? 'checked="checked"' : ''); ?> />
						</div>
						<div class="wd-group">
							<div style="margin-bottom: 10px">
							<?php
								foreach($ids as $key => $id) {
									if ($types[$key] != "type_section_break") {
										?>
										<button type="button" onClick="insertAtCursor_form('<?php echo $ids[$key]; ?>','<?php echo $labels[$key]; ?>')" class="button" title="<?php echo $labels[$key]; ?>"><?php echo $labels[$key]; ?></button>
										<?php
									}
								}
							?>
							</div>
							<span class="button button-hero fm_auto_format_button" onclick="autoFormat()"><strong><?php _e('Apply Source Formatting', WDFM()->prefix); ?></strong> <em>(<?php _e('ctrl-enter', WDFM()->prefix); ?>)</em></span>
							<textarea id="source" name="source" style="display: none;"></textarea>
							<input type="hidden" name="custom_front" id="custom_front" value="" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var form_front = '<?php echo addslashes($row->form_front);?>';
			var custom_front = '<?php echo addslashes($row->custom_front);?>';			
		</script>
		<?php 
	}

	public function display_options($params) {
		$row = $params['row'];
		$id = $params['id'];
		$fieldset_id  = $params['fieldset_id'];
		$page = $params['page'];
		$page_url = $params['page_url'];


		if($fieldset_id != "embedded") $row->type = $fieldset_id;

		ob_start();
		echo $this->body_display_options($params);

		// Pass the content to form.
		$form_attr = array(
			'id' => 'adminForm',
			'name' => 'adminForm',
			'class' => WDFM()->prefix . '_display_options wd-form',
			'current_id' => $id,
			'action' => add_query_arg( array('page' => $page, 'current_id' => $id ), $page_url),
		);
		echo $this->form(ob_get_clean(), $form_attr);


	}

	public function body_display_options($params) {
		$row = $params['row'];
		$page_title = $params['page_title'];
		$animation_effects = $params['animation_effects'];
		$back_url  	= $params['back_url'];

		echo $this->title(array(
			'title' => $page_title,
			'title_class' => 'wd-header',
			'add_new_button' => FALSE,
		));

		$buttons = array(
			'save' => array(
				'title' => __('Update', WDFM()->prefix),
				'value' => 'save',
				'onclick' => 'fm_apply_options(\'apply_display_options\');',
				'class' => 'button-primary',
			),
			'back' => array(
				'title' => __('Back to Form', WDFM()->prefix),
				'value' => 'back',
				'onclick' => 'window.open(\''. $back_url .'\', \'_self\'); return false;',
				'class' => 'button',
			)
		);

		echo $this->buttons($buttons);
		?>

		<div class="fm-clear"></div>
		<div class="display-options-container">
			<div id="type_settings_fieldset" class="adminform">

				<div class="wd-table">
					<div class="wd-table-col-70 wd-table-col-left">
						<div class="wd-box-section">
							<div class="wd-box-content">
											<span>
											<div class="fm-row fm-form-types">
												<label  class="wd-label"><?php  _e('Form Type', WDFM()->prefix); ?></label>
												<label>
													<input type="radio" name="form_type" value="embedded" onclick="change_form_type('embedded'); change_hide_show('fm-embedded');"
														<?php echo $row->type == 'embedded' ? 'checked="checked"' : '' ?>>
													<span class="fm-embedded <?php echo $row->type == 'embedded' ? ' active' : '' ?>"></span>
													<p>Embedded</p>
												</label>
												<label>
													<input type="radio" name="form_type" value="popover" onclick="change_form_type('popover'); change_hide_show('fm-popover');"
														<?php echo $row->type == 'popover' ? 'checked="checked"' : '' ?>>
													<span class="fm-popover <?php echo $row->type == 'popover' ? ' active' : '' ?>"></span>
													<p>Popup</p>
												</label>
												<label>
													<input type="radio" name="form_type" value="topbar" onclick="change_form_type('topbar'); change_hide_show('fm-topbar');"
														<?php echo $row->type == 'topbar' ? 'checked="checked"' : '' ?>>
													<span class="fm-topbar <?php echo $row->type == 'topbar' ? ' active' : '' ?>"></span>
													<p>Topbar</p>
												</label>
												<label>
													<input type="radio" name="form_type" value="scrollbox" onclick="change_form_type('scrollbox'); change_hide_show('fm-scrollbox');"<?php echo $row->type == 'scrollbox' ? 'checked="checked"' : '' ?>>
													<span class="fm-scrollbox <?php echo $row->type == 'scrollbox' ? ' active' : '' ?>"></span>
													<p>Scrollbox</p>
												</label>
											</div>
											</span>
							</div>
						</div>
					</div>
				</div>

				<div class="wd-table">
					<div class="wd-table-col-70 wd-table-col-left">
						<div class="wd-box-section">
							<div class="wd-box-content">
								<span class="wd-group fm-embedded <?php echo $row->type == 'embedded' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Form Placement', WDFM()->prefix); ?></label>
									<div id="fm-embedded-element">
									<p><?php  _e('Use', WDFM()->prefix); ?></p>
									<input type="text" value='[Form id="<?php echo $row->form_id; ?>"]' onclick="fm_select_value(this)"  readonly="readonly" style="width:155px !important;"/>
									<p><?php  _e('shortcode to display the form.', WDFM()->prefix); ?></p>
									</div>
								</span>
								<span class="wd-group fm-popover <?php echo $row->type == 'popover' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Animation Effect', WDFM()->prefix); ?></label>
									<select id="popover_animate_effect" name="popover_animate_effect">
										<?php
										foreach($animation_effects as $anim_key => $animation_effect){
											$selected = $row->popover_animate_effect == $anim_key ? 'selected="selected"' : '';
											echo '<option value="'.$anim_key.'" '.$selected.'>'.$animation_effect.'</option>';
										}
										?>
									</select>
								</span>
								<span class="wd-group fm-popover <?php echo $row->type != 'popover' ? 'fm-hide' : 'fm-show'; ?>">
									<label class="wd-label"><?php  _e('Loading Delay', WDFM()->prefix); ?></label>
									<input type="number" name="popover_loading_delay" value="<?php echo $row->popover_loading_delay; ?>" /> seconds
									<div>
										<?php  _e('Define the amount of time before the form popup appears after the page loads.', WDFM()->prefix); ?>
										<?php  _e('Set 0 for no delay.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-popover <?php echo $row->type == 'popover' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Frequency', WDFM()->prefix); ?></label>
									<input type="number" name="popover_frequency" value="<?php echo $row->popover_frequency; ?>" /> days
									<div>
										<?php  _e('Display the popup to the same visitor (who has closed the popup/submitted the form) after this period.', WDFM()->prefix); ?>
										<?php  _e('Set the value to 0 to always show.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-topbar <?php echo $row->type == 'topbar' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Position', WDFM()->prefix); ?></label>
									<input type="radio" name="topbar_position" <?php echo $row->topbar_position == 1 ? 'checked="checked"' : '' ?> id="fm_do-topbarpos-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-topbarpos-1"><?php  _e('Top', WDFM()->prefix); ?></label>
									<input type="radio" name="topbar_position" <?php echo $row->topbar_position == 0 ? 'checked="checked"' : '' ?> id="fm_do-topbarpos-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-topbarpos-0"><?php  _e('Bottom', WDFM()->prefix); ?></label>
								</span>
								<span class="wd-group fm-topbar topbar_remain_top <?php echo $row->type != 'topbar' ? 'fm-hide' : ($row->topbar_position == 1 ? 'fm-show' : 'fm-hide') ?>">
									<label class="wd-label"><?php  _e('Remain at top when scrolling', WDFM()->prefix); ?></label>
									<input type="radio" name="topbar_remain_top" <?php echo $row->topbar_remain_top == 1 ? 'checked="checked"' : '' ?> id="fm_do-remaintop-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-remaintop-1"><?php  _e('Yes', WDFM()->prefix); ?></label>
									<input type="radio" name="topbar_remain_top" <?php echo $row->topbar_remain_top == 0 ? 'checked="checked"' : '' ?> id="fm_do-remaintop-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-remaintop-0"><?php  _e('No', WDFM()->prefix); ?></label>
								</span>
								<span class="wd-group fm-topbar <?php echo $row->type == 'topbar' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Allow Closing the bar', WDFM()->prefix); ?></label>
									<input type="radio" name="topbar_closing" <?php echo $row->topbar_closing == 1 ? 'checked="checked"' : '' ?> id="fm_do-topbarclosing-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-topbarclosing-1"><?php  _e('Yes', WDFM()->prefix); ?></label>
									<input type="radio" name="topbar_closing" <?php echo $row->topbar_closing == 0 ? 'checked="checked"' : '' ?> id="fm_do-topbarclosing-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-topbarclosing-0"><?php  _e('No', WDFM()->prefix); ?></label>
								</span>
								<span class="wd-group fm-topbar topbar_hide_duration <?php echo $row->type != 'topbar' ? 'fm-hide' : 'fm-show' ?>">
									<label class="wd-label"><?php  _e('Frequency', WDFM()->prefix); ?></label>
									<input type="number" name="topbar_hide_duration" value="<?php echo $row->topbar_hide_duration; ?>"/>days
									<div>
										<?php  _e('Display the topbar to the same visitor (who has closed the popup/submitted the form) after this period.', WDFM()->prefix); ?>
										<?php  _e('Set the value to 0 to always show.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-scrollbox <?php echo $row->type == 'scrollbox' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Position', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_position" <?php echo $row->scrollbox_position == 0 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxposition-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-scrollboxposition-0"><?php  _e('Left', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_position" <?php echo $row->scrollbox_position == 1 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxposition-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-scrollboxposition-1"><?php  _e('Right', WDFM()->prefix); ?></label>
								</span>
								<span class="wd-group fm-scrollbox <?php echo $row->type != 'scrollbox' ? 'fm-hide' : 'fm-show'; ?>">
									<label class="wd-label"><?php  _e('Loading Delay', WDFM()->prefix); ?></label>
									<input type="number" name="scrollbox_loading_delay" value="<?php echo $row->scrollbox_loading_delay; ?>" /> seconds
									<div>
										<?php  _e('Define the amount of time before the form scrollbox appears after the page loads. Set 0 for no delay.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-scrollbox <?php echo $row->type == 'scrollbox' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Frequency', WDFM()->prefix); ?></label>
									<input type="number" name="scrollbox_hide_duration" value="<?php echo $row->scrollbox_hide_duration; ?>"/>days
									<div>
										<?php  _e('Display the scrollbox to the same visitor (who has closed the popup/submitted the form) after this period.', WDFM()->prefix); ?>
										<?php  _e('Set the value to 0 to always show.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-popover fm-topbar fm-scrollbox <?php echo $row->type != 'embedded' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Always show for administrator', WDFM()->prefix); ?></label>
									<input type="radio" name="show_for_admin" <?php echo $row->show_for_admin == 1 ? 'checked="checked"' : '' ?> id="fm_do-showforadmin-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-showforadmin-1"><?php  _e('Yes', WDFM()->prefix); ?></label>
									<input type="radio" name="show_for_admin" <?php echo $row->show_for_admin == 0 ? 'checked="checked"' : '' ?> id="fm_do-showforadmin-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-showforadmin-0"><?php  _e('No', WDFM()->prefix); ?></label>
									<div>
										<?php  _e('If this option is enabled, website admins will always see the form.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-scrollbox <?php echo $row->type == 'scrollbox' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Trigger Point', WDFM()->prefix); ?></label>
									<input type="number" name="scrollbox_trigger_point" value="<?php echo $row->scrollbox_trigger_point; ?>"/>%
									<div>
										<?php  _e('Set the percentage of the page height, where the scrollbox form will appear after scrolling down.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-scrollbox <?php echo $row->type == 'scrollbox' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Allow Closing the bar', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_closing" <?php echo $row->scrollbox_closing == 1 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxclosing-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-scrollboxclosing-1"><?php  _e('Yes', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_closing" <?php echo $row->scrollbox_closing == 0 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxclosing-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-scrollboxclosing-0"><?php  _e('No', WDFM()->prefix); ?></label>
								</span>
								<span class="wd-group fm-scrollbox <?php echo $row->type == 'scrollbox' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Allow Minimize', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_minimize" <?php echo $row->scrollbox_minimize == 1 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxminimize-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-scrollboxminimize-1"><?php  _e('Yes', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_minimize" <?php echo $row->scrollbox_minimize == 0 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxminimize-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-scrollboxminimize-0"><?php  _e('No', WDFM()->prefix); ?></label>
								</span>
								<span class="wd-group fm-scrollbox minimize_text <?php echo $row->type == 'scrollbox' && $row->scrollbox_minimize == 1 ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Minimize Text', WDFM()->prefix); ?></label>
									<input type="text" name="scrollbox_minimize_text" value="<?php echo $row->scrollbox_minimize_text; ?>"/>
								</span>
								<span class="wd-group fm-scrollbox <?php echo $row->type == 'scrollbox' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Auto Hide', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_auto_hide" <?php echo $row->scrollbox_auto_hide == 1 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxautohide-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-scrollboxautohide-1"><?php  _e('Yes', WDFM()->prefix); ?></label>
									<input type="radio" name="scrollbox_auto_hide" <?php echo $row->scrollbox_auto_hide == 0 ? 'checked="checked"' : '' ?> id="fm_do-scrollboxautohide-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-scrollboxautohide-0"><?php  _e('No', WDFM()->prefix); ?></label>
									<div>
										<?php  _e('Hide the scrollbox form again when visitor scrolls back up.', WDFM()->prefix); ?>
									</div>
								</span>
								<span class="wd-group fm-popover fm-topbar fm-scrollbox <?php echo $row->type != 'embedded' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Display on', WDFM()->prefix); ?></label>
									<ul class="pp_display pp_display_on"><?php
										$posts_and_pages = $params['posts_and_pages'];
										$stat_types = array('everything' => 'All', 'home' => 'Homepage', 'archive' => 'Archives');

										$def_post_types = array('post' => 'Post', 'page' => 'Page');
										$custom_post_types = get_post_types( array(
											'public'   => true,
											'_builtin' => false,
										) );

										$post_types = array_merge($def_post_types, $custom_post_types);
										$all_types = $stat_types + $post_types;
										$selected_types = explode(',', $row->display_on);
										$show_cats = in_array('post', $selected_types);
										$m = 0;
										foreach($all_types as $post_key => $post_type){
											$checked = in_array('everything', $selected_types) || in_array($post_key, $selected_types) ? 'checked="checked"' : '';
											$postclass = $post_key != 'page' && in_array($post_key, array_keys($def_post_types)) ? 'class="catpost"' : '';
											echo '<li><input id="pt'.$m.'" type="checkbox" name="display_on[]" value="'.$post_key.'" '.$checked.' '.$postclass.'/><label for="pt'.$m.'">'.$post_type.'</label></li>';
											$m++;
										}
										?>
									</ul>
								</span>
								<span class="wd-group fm-popover fm-topbar fm-scrollbox fm-cat-show <?php echo $row->type != 'embedded' && $show_cats ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e("Display on these categories' posts", WDFM()->prefix); ?></label>
									<ul class="pp_display pp_display_on_categories"><?php
										$categories = $params['categories'];
										$selected_categories = $params['selected_categories'];
										$current_categories_array = $params['current_categories_array'];
										$m = 0;
										foreach($categories as $cat_key => $category){
											$checked = ((!$row->current_categories && !$row->display_on_categories) || in_array($cat_key, $selected_categories) || (in_array('auto_check_new', $selected_categories) && !in_array($cat_key, $current_categories_array))) ? 'checked="checked"' : '';

											echo '<li><input id="cat'.$m.'" type="checkbox" name="display_on_categories[]" value="'.$cat_key.'" '.$checked.'/><label for="cat'.$m.'">'.$category.'</label></li>';
											$m++;
										}
										$auto_check = (!$row->current_categories && !$row->display_on_categories) || in_array('auto_check_new', $selected_categories) ? 'checked="checked"' : '';
										echo '<li><br/><input id="cat'.$m.'" type="checkbox" name="display_on_categories[]" value="auto_check_new" '.$auto_check.'/><label for="cat'.$m.'">Automatically check new categories</label></li>';
										$current_categories = !$row->current_categories && !$row->display_on_categories ? implode(',', array_keys($categories)) : $row->current_categories;
										?>
									</ul>
									<input type="hidden" name="current_categories" value="<?php echo $current_categories; ?>"/>
								</span>
								<span class="wd-group fm-popover fm-topbar fm-scrollbox fm-posts-show <?php echo (in_array('everything', $selected_types) || in_array('post', $selected_types)) && $row->type != 'embedded' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Display on these posts', WDFM()->prefix); ?></label>
									<div class="fm-mini-heading">
										<?php  _e('Click on input area to view the list of posts.', WDFM()->prefix); ?>
										<?php  _e('If left empty the form will appear on all posts.', WDFM()->prefix); ?>
									</div>
									<p><?php  _e('Posts defined below will override all settings above.', WDFM()->prefix); ?></p>
									<ul class="fm-pp">
										<li class="pp_selected"><?php if($row->posts_include){
												$posts_include = explode(',', $row->posts_include);
												foreach($posts_include as $post_exclude){
													if(isset($posts_and_pages[$post_exclude])){
														$ptitle = $posts_and_pages[$post_exclude]['title'];
														$ptype = $posts_and_pages[$post_exclude]['post_type'];
														echo '<span data-post_id="'.$post_exclude.'">['.$ptype.'] - '.$ptitle.'<span class="pp_selected_remove">x</span></span>';
													}
												}
											} ?></li>
										<li>
											<input type="text" class="pp_search_posts" value="" data-post_type="only_posts" style="width: 100% !important;" />
											<input type="hidden" class="pp_exclude" name="posts_include" value="<?php echo $row->posts_include; ?>" />
											<span class="fm-loading"></span>
										</li>
										<li class="pp_live_search fm-hide">
											<ul class="pp_search_results">

											</ul>
										</li>
									</ul>
								</span>
								<span class="wd-group fm-popover fm-topbar fm-scrollbox fm-pages-show <?php echo (in_array('everything', $selected_types) || in_array('page', $selected_types)) && $row->type != 'embedded' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Display on these pages', WDFM()->prefix); ?></label>
									<div class="fm-mini-heading">
										<?php  _e('Click on input area to view the list of pages. ', WDFM()->prefix); ?>
										<?php  _e('If left empty the form will appear on all pages.', WDFM()->prefix); ?>
									</div>
									<p><?php  _e('Pages defined below will override all settings above.', WDFM()->prefix); ?></p>
									<ul class="fm-pp">
										<li class="pp_selected"><?php if($row->pages_include){
												$pages_include = explode(',', $row->pages_include);
												foreach($pages_include as $page_exclude){
													if(isset($posts_and_pages[$page_exclude])){
														$ptitle = $posts_and_pages[$page_exclude]['title'];
														$ptype = $posts_and_pages[$page_exclude]['post_type'];
														echo '<span data-post_id="'.$page_exclude.'">['.$ptype.'] - '.$ptitle.'<span class="pp_selected_remove">x</span></span>';
													}
												}
											} ?></li>
										<li>
											<input type="text" class="pp_search_posts" value="" data-post_type="only_pages" style="width: 100% !important;" />
											<input type="hidden" class="pp_exclude" name="pages_include" value="<?php echo $row->pages_include; ?>" />
											<span class="fm-loading"></span>
										</li>
										<li class="pp_live_search fm-hide">
											<ul class="pp_search_results">
											</ul>
										</li>
									</ul>
								</span>
								<span class="wd-group fm-popover fm-topbar fm-scrollbox <?php echo $row->type != 'embedded' ? 'fm-show' : 'fm-hide' ?>">
									<label class="wd-label"><?php  _e('Hide on Mobile', WDFM()->prefix); ?></label>
									<input type="radio" name="hide_mobile" <?php echo $row->hide_mobile == 1 ? 'checked="checked"' : '' ?> id="fm_do-hidemobile-1" class="wd-radio" value="1">
									<label class="wd-label-radio" for="fm_do-hidemobile-1"><?php  _e('Yes', WDFM()->prefix); ?></label>
									<input type="radio" name="hide_mobile" <?php echo $row->hide_mobile == 0 ? 'checked="checked"' : '' ?> id="fm_do-hidemobile-0" class="wd-radio" value="0">
									<label class="wd-label-radio" for="fm_do-hidemobile-0"><?php  _e('No', WDFM()->prefix); ?></label>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
<?php
/**
 * Class FMViewSubmissions_fm
 */
class  FMViewSubmissions_fm extends FMAdminView {
  private $model;

  public function __construct( $model ) {
    $this->model = $model;
    wp_enqueue_style('thickbox');
    wp_enqueue_style('fm-tables');
    wp_enqueue_style('fm-style');
    wp_enqueue_style('fm-jquery-ui');
    wp_enqueue_style('jquery.fancybox');

    wp_enqueue_script('thickbox');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-progressbar');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('jquery-ui-widget');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('jquery-ui-spinner');
    wp_enqueue_script('jquery-ui-mouse');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    if ( function_exists('wp_add_inline_script') ) { // Since Wordpress 4.5.0
      wp_add_inline_script('jquery-ui-datepicker', WDW_FM_Library::localize_ui_datepicker());
    }
    else {
      echo '<script>' . WDW_FM_Library::localize_ui_datepicker() . '</script>';
    }
    wp_enqueue_script('fm-admin');
    wp_enqueue_script('fm-manage');
    wp_enqueue_script('fm-submissions');
    wp_enqueue_script('jquery.fancybox.pack');
  }

	/**
	* Forms page.
	* @param $params
	*/
	public function forms( $params ) {
		$id 	  	= $params['id'];
		$page		= $params['page'];
		$page_title = $params['page_title'];
		$page_url 	= $params['page_url'];
		$forms 	  	= $params['forms'];
		echo '<div class="wrap">';
		echo $this->title(array(
                        'title' => $page_title,
                        'title_class' => 'wd-header',
                      ));
		?>
		<br>
		<div class="tablenav top">
			<div class="alignleft">
				<?php echo $this->saelect_form( array('id' => $id, 'forms' => $forms, 'page' => $page, 'page_url' => $page_url) ); ?>
			</div>
			<div class="fm-export-tools">
				<?php $blocked_ips_link = add_query_arg(array( 'page' => 'blocked_ips' . WDFM()->menu_postfix ), $page_url); ?>
				<a class="button" href="<?php echo $blocked_ips_link; ?>" target="_blank"><?php echo _e('Blocked IPs', WDFM()->prefix);?></a>
			</div>
		</div>
		<?php if( !$id ) { ?>
			<table class="wp-list-table widefat fixed striped posts">
				<body id="the-list">
					<tr class="no-items">
						<td class="colspanchange" colspan="0"><?php _e('Please select a form to view submissions', WDFM()->prefix); ?></td>
					</tr>
				</body>
			</table>
		<?php }
		echo '</div>';
	}

	/**
	* Display page.
	*/
	public function display( $params ) {
		$id = $params['id'];
		$page = $params['page'];
		$page_url = $params['page_url'];
		ob_start();
		echo $this->body($params);

		// Pass the content to form.
		$form_attr = array(
			// 'id' => WDFM()->prefix . '_submissions',
			'id' => 'admin_form',
			'name' => WDFM()->prefix . '_submissions',
			'class' => WDFM()->prefix . '_submissions wd-form',
			'action' => add_query_arg( array('page' => $page, 'task' => 'display', 'current_id' => $id ), $page_url),
		);
		echo $this->form(ob_get_clean(), $form_attr);
	}

	/**
	* Generate page body.
	*
	* @return string Body html.
	*/
	public function body( $params ) {
		global $wpdb;
		$form_id  = $params['id'];
		$page 	  = $params['page'];
		$page_url = $params['page_url'];
		$page_title = $params['page_title'];
		$pagination_url = $params['pagination_url'];
		$page_per_num = $params['page_per_num'];

		$forms 	  	= $params['forms'];
		$statistics = $params['statistics'];
		$actions  	= $params['actions'];
		$blocked_ips = $params['blocked_ips'];

		$sorted_labels_id 	= $params['sorted_labels_id'];

		$sorted_label_types = $params['sorted_label_types'];
		$sorted_label_names = $params['sorted_label_names'];
		$sorted_label_names_original = $params['sorted_label_names_original'];
		$label_name_ids = $params['label_name_ids'];

		$where_choices 	= $params['where_choices'];
		$searched_ids 	= $params['searched_ids'];
		$order_by 		= $params['order_by'];
		$asc_or_desc 	= $params['asc_or_desc'];

		$lists 		= $params['lists'];
		$style_id 	= $params['style_id'];
		$style_date = $params['style_date'];
		$style_ip 	= $params['style_ip'];

		$style_username 	= $params['style_username'];
		$style_useremail 	= $params['style_useremail'];
		$style_payment_info = $params['style_payment_info'];

		$oder_class_default = $params['oder_class_default'];
		$oder_class 		= $params['oder_class'];
		$m = $params['m'];

		$group_id_s = $params['group_id_s'];
		$is_search 	= $params['is_search'];
		$is_stats 	= $params['is_stats'];

		$rows 		= $params['rows'];
		$rows_data 	= $params['rows_data'];
		$subs_count = $params['subs_count'];
		$pdf_data   = $params['pdf_data'];

		$is_search 	= $params['is_search'];
		$is_stats 	= $params['is_stats'];

		$verified_emails = array();

		echo $this->title(array(
						'title' => $page_title,
						'title_class' => 'wd-header',
					  ));

	?>
	<br>
	<div>
		<?php echo $this->saelect_form( array('id' => $form_id, 'forms' => $forms, 'page' => $page, 'page_url' => $page_url) ); ?>
		<div class="fm-reports">
			<div class="fm-tools-button">
				<div class="fm-total_entries"><?php echo $statistics["total_entries"]; ?></div>
				<?php echo _e('Entries', WDFM()->prefix);?>
			</div>
			<div class="fm-tools-button">
				<div class="fm-total_rate"><?php echo $statistics["conversion_rate"]; ?></div>
				<?php echo _e('Conversion Rate', WDFM()->prefix);?>
			</div>
			<div class="fm-tools-button">
				<div class="fm-total_views"><?php echo $statistics["total_views"] ? $statistics["total_views"] : 0; ?></div>
				<?php echo _e('Views', WDFM()->prefix);?>
			</div>
		</div>
		<div class="fm-export-tools">
			<?php $blocked_ips_link = add_query_arg(array( 'page' => 'blocked_ips' . WDFM()->menu_postfix ), $page_url); ?>
			<a class="button" href="<?php echo $blocked_ips_link; ?>" target="_blank"><?php echo _e('Blocked IPs', WDFM()->prefix);?></a>
			<button class="button" onclick="export_submissions('csv', 0); return false;"><?php echo _e('Export to CSV', WDFM()->prefix);?></button>
			<button class="button" onclick="export_submissions('xml', 0); return false;"><?php echo _e('Export to XML', WDFM()->prefix);?></button>
		</div>
	</div>
	<div class="tablenav top">
	<?php
		echo $this->bulk_actions($actions);
		?>
		<div class="alignleft actions fm-bulk-actions">
			<input type="button" class="button action" onclick="toggleChBDiv(true); return false;" value="<?php echo _e('Add/Remove Columns', WDFM()->prefix);?>">
			<input type="hidden" name="hide_label_list" value="">
			<button type="button" class="button action" onclick="show_hide_filter(); return false;"><span class="show-filter <?php echo !($is_search) ? '' : 'hide'?>"><?php echo  __('Show Filters', WDFM()->prefix); ?></span> <span class="hide-filter <?php echo !($is_search) ? 'hide' : 'show'?>" ><?php echo __('Hide Filters', WDFM()->prefix);?></span></button>
			<span class="search_reset_button <?php echo ($is_search) ? '' : 'hide'; ?>">
				<input type="button" class="button action" onclick="fm_form_submit(event, 'admin_form'); return false;" value="<?php echo _e('Search', WDFM()->prefix);?>">
				<input type="button" class="button action <?php echo ($is_search) ? '' : 'hide'; ?>" onclick="remove_all(); fm_set_input_value('order_by', 'group_id'); fm_set_input_value('asc_or_desc', 'desc'); fm_form_submit(event, 'admin_form'); return false;" value="<?php echo _e('Reset', WDFM()->prefix);?>">
			</span>
		</div>
	<?php
		echo $this->pagination($pagination_url, $subs_count, $page_per_num);
	?>
	</div>
	<div style="width: 100%;">

		<div class="table-wrapper-1 <?php echo ($m == 0) ? 'no-scroll' : ''; ?>">
			<div class="table-scroll-1"></div>
		</div>
		<div class="table-wrapper-2 <?php echo ($m == 0) ? 'no-scroll' : ''; ?>">
			<div class="table-scroll-2 submit_content" id="fm-scroll">
				<table class="adminlist table table-striped wp-list-table widefat fixed pages">
				<thead>
				<tr class="fm_table_head">
					<td id="cb" class="column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1"><?php _e('Select all', WDFM()->prefix);?></label>
						<input type="checkbox" id="check_all">
					</td>
					<th id="submitid_fc" class="<?php if ( $order_by == "group_id" ) {
							echo $oder_class;
						}
						else {
							echo $oder_class_default;
						} ?> col_id" <?php echo $style_id; ?> data-colname="<?php _e('ID', WDFM()->prefix);?>">
						<a href="" class="sub_id" onclick="fm_set_input_value('order_by', 'group_id');
							fm_set_input_value('asc_or_desc', '<?php echo(($order_by == 'group_id' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
							fm_form_submit(event, 'admin_form')">
							<span><?php echo _e('ID', WDFM()->prefix);?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th id="submitsubmitdate_fc" class="column-primary col-submit-date <?php if ( $order_by == "date" ) {
							echo $oder_class;
						  }
						  else {
							echo $oder_class_default;
						  } ?>" <?php echo $style_date; ?> data-colname="<?php _e('Submit date', WDFM()->prefix);?>">
						<a href="" onclick="fm_set_input_value('order_by', 'date');
						  fm_set_input_value('asc_or_desc', '<?php echo(($order_by == 'date' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
						  fm_form_submit(event, 'admin_form')">
						  <span><?php _e('Submit date', WDFM()->prefix);?></span>
						  <span class="sorting-indicator"></span>
						</a>
					</th>
					<th scope="col" id="submitterip_fc" class="submitterip_fc <?php if ( $order_by == "ip" ) {
						echo $oder_class;
					  }
					  else {
						echo $oder_class_default;
					  } ?>" <?php echo $style_ip; ?> data-colname="<?php _e('Submitter\'s IP', WDFM()->prefix);?>">
						<a href="" onclick="fm_set_input_value('order_by', 'ip');
						  fm_set_input_value('asc_or_desc', '<?php echo(($order_by == 'ip' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
						  fm_form_submit(event, 'admin_form')">
						  <span><?php _e('Submitter\'s IP', WDFM()->prefix);?></span>
						  <span class="sorting-indicator"></span>
						</a>
					</th>
					<th scope="col" id="submitterusername_fc" class="submitterusername_fc <?php if ( $order_by == "display_name" ) {
                        echo $oder_class;
                      }
                      else {
                        echo $oder_class_default;
                      } ?>" <?php echo $style_username; ?> data-colname="<?php _e('Submitter\'s Username', WDFM()->prefix);?>">
					<a href="" onclick="fm_set_input_value('order_by', 'display_name');
					  fm_set_input_value('asc_or_desc', '<?php echo(($order_by == 'display_name' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
					  fm_form_submit(event, 'admin_form')">
					  <span><?php _e('Submitter\'s Username', WDFM()->prefix);?></span>
					  <span class="sorting-indicator"></span>
					</a>
				    </th>
					<th scope="col" id="submitteremail_fc" class="submitteremail_fc <?php if ( $order_by == "user_email" ) {
						echo $oder_class;
					  }
					  else {
						echo $oder_class_default;
					  } ?>" <?php echo $style_useremail; ?> data-colname="<?php _e('Submitter\'s Email Address', WDFM()->prefix);?>">
						<a href="" onclick="fm_set_input_value('order_by', 'user_email');
						  fm_set_input_value('asc_or_desc', '<?php echo(($order_by == 'user_email' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
						  fm_form_submit(event, 'admin_form')">
						  <span><?php _e('Submitter\'s Email Address', WDFM()->prefix);?></span>
						  <span class="sorting-indicator"></span>
						</a>
					</th>
					  <?php
					  $stripe_paypal = false;
					  for ( $i = 0; $i < count($sorted_label_names); $i++ ) {
						$styleStr = $this->model->hide_or_not($lists['hide_label_list'], $sorted_labels_id[$i]);
						$field_title = $this->model->get_type_address($sorted_label_types[$i], $sorted_label_names_original[$i]);
						$textdata = $this->gen_shorter_text($field_title, 42);

						if ( $sorted_label_types[$i] == 'type_paypal_payment_status' || $sorted_label_types[$i] == 'type_stripe' ) {
							$stripe_paypal = true;
							if ( $sorted_label_types[$i] != 'type_stripe' ) {
							?>
							<th <?php echo $styleStr; ?> id="<?php echo $sorted_labels_id[$i] . '_fc'; ?>" class="table_large_col <?php echo $sorted_labels_id[$i] . '_fc ';
							if ( $order_by == $sorted_labels_id[$i] . "_field" ) {
							  echo $oder_class . '"';
							}
							else {
								echo $oder_class_default . '"';
							} ?>" data-colname="<?php echo $field_title; ?>">
							  <a href="" onclick="fm_set_input_value('order_by', '<?php echo $sorted_labels_id[$i] . '_field'; ?>'); fm_set_input_value('asc_or_desc', '<?php echo(($order_by == $sorted_labels_id[$i] . '_field' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>'); fm_form_submit(event, 'admin_form')">
								<span><?php echo $textdata['text']; ?></span>
								<span class="sorting-indicator"></span>
							  </a>
							</th>
							<?php
							}
						}
						else {
						?>
						  <th <?php echo $styleStr; ?> id="<?php echo $sorted_labels_id[$i] . '_fc'; ?>" class="<?php echo ($sorted_label_types[$i] == 'type_mark_map' || $sorted_label_types[$i] == 'type_matrix') ? 'table_large_col ' : '';
							  echo $sorted_labels_id[$i] . '_fc';
							  if ( $order_by == $sorted_labels_id[$i] . "_field" ) {
								echo $oder_class . '"';
							  }
							  else {
								echo $oder_class_default . '"';
							  } ?>" data-colname="<?php echo $field_title; ?>">
							<a href="" onclick="fm_set_input_value('order_by', '<?php echo $sorted_labels_id[$i] . '_field'; ?>'); fm_set_input_value('asc_or_desc', '<?php echo(($order_by == $sorted_labels_id[$i] . '_field' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>'); fm_form_submit(event, 'admin_form')">
							  <span <?php if($textdata['status']) { ?> class="fm_masterTooltip" title="<?php echo $field_title; ?>" <?php } ?> ><?php echo $textdata['text']; ?></span>
							  <span class="sorting-indicator"></span>
							</a>
						  </th>
						  <?php
						}
					}
					if( $stripe_paypal ) { ?>
						<th id="payment_info_fc" class="column-autor payment_info_fc" <?php echo $style_payment_info; ?> data-colname="<?php _e('Payment Info', WDFM()->prefix); ?>"><?php _e('Payment Info', WDFM()->prefix); ?></th>
					<?php  } ?>
				</tr>				
				<tr id="fm-fields-filter" style="display: none;">
					<th></th>
					<th class="submitid_fc" <?php echo $style_id; ?> >
						<input type="text" name="id_search" id="id_search" value="<?php echo $lists['id_search'] ?>" style="width:30px" />
					</th>
					<th class="submitdate_fc" <?php echo $style_date; ?>>
						<table align="center" style="margin:auto" class="simple_table">
					  <tr class="simple_table">
						<td class="simple_table" style="text-align: left;">From:</td>
						<td style="text-align: center;" class="simple_table">
						  <input class="inputbox" type="text" name="startdate" id="startdate" size="10" maxlength="10" value="<?php echo $lists['startdate']; ?>" />
						</td>
					  </tr>
					  <tr class="simple_table">
						<td style="text-align: left;" class="simple_table">To:</td>
						<td style="text-align: center;" class="simple_table">
						  <input class="inputbox" type="text" name="enddate" id="enddate" size="10" maxlength="10" value="<?php echo $lists['enddate']; ?>" />
						</td>
					  </tr>
					</table>
					</th>
					<th class="submitterip_fc" <?php echo $style_ip; ?>>
						<input type="text" name="ip_search" id="ip_search" value="<?php echo $lists['ip_search']; ?>" />
					</th>
					<th class="submitterusername_fc" <?php echo $style_username; ?>>
						<input type="text" name="username_search" id="username_search" value="<?php echo $lists['username_search']; ?>" />
					</th>
					<th class="submitteremail_fc" <?php echo $style_useremail; ?>>
						<input type="text" name="useremail_search" id="useremail_search" value="<?php echo $lists['useremail_search']; ?>" />
					</th>
					<?php
						$column_count = 0;
						for ( $i = 0; $i < count($sorted_label_names); $i++ ) {
							if ( $sorted_label_types[$i] == 'type_stripe' ) {
							  continue;
							}
							$styleStr = $this->model->hide_or_not($lists['hide_label_list'], $sorted_labels_id[$i]);
							if ( !$is_search ) {
							  if ( $lists[$form_id . '_' . $sorted_labels_id[$i] . '_search'] || isset($lists[$form_id . '_' . $sorted_labels_id[$i] . '_search_verified']) ) {
								$is_search = TRUE;
							  }
							}
							switch ( $sorted_label_types[$i] ) {
							  case 'type_mark_map': ?>
								<th class="table_large_col <?php echo $sorted_labels_id[$i]; ?>_fc" <?php echo $styleStr; ?>></th>
								<?php
								break;
							case 'type_paypal_payment_status': ?>
								<th class="table_large_col <?php echo $sorted_labels_id[$i]; ?>_fc" <?php echo $styleStr; ?>>
								  <select style="font-size: 11px; margin: 0; padding: 0; height: inherit;" name="<?php echo $form_id . '_' . $sorted_labels_id[$i]; ?>_search" id="<?php echo $form_id . '_' . $sorted_labels_id[$i]; ?>_search" value="<?php echo $lists[$form_id . '_' . $sorted_labels_id[$i] . '_search']; ?>">
									<option value=""></option>
									<option value="canceled">Canceled</option>
									<option value="cleared">Cleared</option>
									<option value="cleared by payment review">Cleared by payment review</option>
									<option value="completed">Completed</option>
									<option value="denied">Denied</option>
									<option value="failed">Failed</option>
									<option value="held">Held</option>
									<option value="in progress">In progress</option>
									<option value="on hold">On hold</option>
									<option value="paid">Paid</option>
									<option value="partially refunded">Partially refunded</option>
									<option value="pending verification">Pending verification</option>
									<option value="placed">Placed</option>
									<option value="processing">Processing</option>
									<option value="refunded">Refunded</option>
									<option value="refused">Refused</option>
									<option value="removed">Removed</option>
									<option value="returned">Returned</option>
									<option value="reversed">Reversed</option>
									<option value="temporary hold">Temporary hold</option>
									<option value="unclaimed">Unclaimed</option>
								  </select>
								  <script>
									var element = document.getElementById('<?php echo $form_id . '_' . $sorted_labels_id[$i]; ?>_search');
									element.value = '<?php echo $lists[$form_id . '_' . $sorted_labels_id[$i] . '_search']; ?>';
								  </script>
								</th>
								<th class="table_large_col payment_info_fc" <?php echo $style_payment_info; ?>>&nbsp;</th>
								<?php
							break;
							  case 'type_submitter_mail':
								$query = $wpdb->prepare('SELECT id FROM ' . $wpdb->prefix . 'formmaker_submits WHERE form_id ="%d" AND element_label="verifyInfo" AND element_value="verified**%d"', $form_id, $sorted_labels_id[$i]);
								$is_verified_exist = $wpdb->get_var($query);
								?>
								<th class="<?php echo $sorted_labels_id[$i]; ?>_fc" <?php echo $styleStr; ?>>
								  <div style="width:220px;">
									<input name="<?php echo $form_id . '_' . $sorted_labels_id[$i] . '_search'; ?>" id="<?php echo $form_id . '_' . $sorted_labels_id[$i] . '_search'; ?>" type="text" value="<?php echo $lists[$form_id . '_' . $sorted_labels_id[$i] . '_search']; ?>">
									<?php if ( $is_verified_exist ) { ?>
									  <label for="<?php echo $form_id . '_' . $sorted_labels_id[$i] . '_search_verified'; ?>">Verified</label>
									  <input name="<?php echo $form_id . '_' . $sorted_labels_id[$i] . '_search_verified'; ?>" id="<?php echo $form_id . '_' . $sorted_labels_id[$i] . '_search_verified'; ?>" type="checkbox" <?php if ( isset($lists[$form_id . '_' . $sorted_labels_id[$i] . '_search_verified']) ) {
										echo "checked='checked'";
									  } ?> onChange="this.form.submit();">
									<?php } ?>
								  </div>
								</th>
								<?php
								break;
							default: ?>
								<th class="<?php echo $sorted_labels_id[$i]; ?>_fc" <?php echo $styleStr; ?>>
								  <input name="<?php echo $form_id . '_' . $sorted_labels_id[$i] . '_search'; ?>" id="<?php echo $form_id . '_' . $sorted_labels_id[$i] . '_search'; ?>" type="text" value="<?php echo $lists[$form_id . '_' . $sorted_labels_id[$i] . '_search']; ?>">
								</th>
								<?php
							break;
							}
						  }
						$column_count = $i;
					?>
				</tr>
				</thead>
				<tbody>
				<?php
				$k = 0;
				if( !empty($group_id_s) ) {
					for ( $www = 0, $qqq = count($group_id_s); $www < $qqq; $www++ ) {
						$i = $group_id_s[$www];
						$alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
						$temp = $this->model->array_for_group_id($group_id_s[$www], $rows);
						$data = $temp[0];
						$userinfo = get_userdata($data->user_id_wd);
						$useremail = $userinfo ? $userinfo->user_email : "";
						$username = $userinfo ? $userinfo->display_name : "";
						?>
						<tr id="tr_<?php echo $data->group_id; ?>" class="<?php echo $alternate; ?>">
							<th class="check-column">
								<input type="checkbox" id="check_<?php echo $data->group_id; ?>" name="check[<?php echo $data->group_id; ?>]">
							</th>
							<td id="submitid_fc" class="col-id" data-colname="<?php _e('ID', WDFM()->prefix);?>" <?php echo $style_id; ?>>
								<a href="" onclick="fm_set_input_value('task', 'edit'); fm_set_input_value('current_id',<?php echo $data->group_id; ?>); fm_form_submit(event, 'admin_form');"><?php echo $data->group_id; ?></a>
							</td>
							<td class="column-primary col-submit-date" data-colname="<?php _e('Submit date', WDFM()->prefix);?>" <?php echo $style_date; ?>>
								<?php
									$view_url 		= add_query_arg( array(
																  'action'	 => 'FormMakerSubmits' . WDFM()->plugin_postfix,
																  'group_id' => $data->group_id,
																  'form_id'  => $form_id,
																  'width'	=> '600',
																  'height' 	=> '500',
																  'TB_iframe' => '1',
																), admin_url('admin-ajax.php'));

									$edit_url		= add_query_arg( array( 'task' => 'edit', 'current_id' => $data->group_id, 'form_id' => $form_id ), $page_url );
									$delete_url 	= add_query_arg( array( 'task' => 'delete', 'current_id' => $data->group_id, 'form_id' => $form_id ), $page_url );
									$block_url 		= add_query_arg( array( 'task' => 'block_ip', 'current_id' => $data->group_id, 'form_id' => $form_id ), $page_url );
									$unblock_url 	= add_query_arg( array( 'task' => 'unblock_ip', 'current_id' => $data->group_id, 'form_id' => $form_id ), $page_url );

									$ip_infoin_popup_url = add_query_arg( array(
																	   'action' => 'FormMakerIpinfoinPopup' . WDFM()->plugin_postfix,
																	   'data_ip' => $data->ip,
																	   'width' => '450',
																	   'height' => '300',
																	   'TB_iframe' => '1',
																	 ), admin_url('admin-ajax.php'));

								?>
								<p><strong><a href="<?php echo $edit_url; ?>" target="_blank"><?php echo $data->date; ?></a></strong></p>
								<div class="row-actions">
									<span><a href="<?php echo $view_url; ?>" class="thickbox thickbox-preview" title="<?php _e("View submission", WDFM()->prefix); ?>"><?php _e('View', WDFM()->prefix); ?></a> |</span>
									<span><a href="<?php echo $edit_url; ?>" target="_blank" title="<?php _e("Edit submission", WDFM()->prefix); ?>"><?php _e('Edit', WDFM()->prefix); ?></a> |</span>
									<?php if ( $pdf_data && isset($pdf_data[$group_id_s[$www]]) ){ ?>
										<span><a href="<?php echo site_url() . '/' . $pdf_data[$group_id_s[$www]]; ?>" download ><?php _e('Download PDF', WDFM()->prefix); ?></a> |</span>
									<?php } ?>
									<span class="trash"><a href="<?php echo $delete_url; ?>" title="<?php _e("Edit submission", WDFM()->prefix); ?>" onclick="if (!confirm('<?php echo addslashes(__('Do you want to delete selected item?', WDFM()->prefix)); ?>')) {return false;}"><?php _e('Delete', WDFM()->prefix); ?></a></span>

									<button class="toggle-row" type="button"><span class="screen-reader-text"><?php _e("Show more details", WDFM()->prefix); ?></span></button>
								</div>
							</td>
							<td class="submitterip_fc sub-align" id="submitterip_fc" <?php echo $style_ip; ?> data-colname="<?php _e('Show submitter information', WDFM()->prefix);?>">
								<p><a class="thickbox-preview" href="<?php echo $ip_infoin_popup_url; ?>" title="<?php _e("Show submitter information", WDFM()->prefix); ?>" <?php echo (!in_array($data->ip, $blocked_ips)) ? '' : 'style="color: #FF0000;"'; ?>><?php echo $data->ip; ?></a></p>
								<div class="row-actions">
								<?php if( !in_array($data->ip, $blocked_ips) ){ ?>
									<span><a href="<?php echo $block_url; ?>" title="<?php _e("Block IP", WDFM()->prefix); ?>"><?php _e('Block IP', WDFM()->prefix); ?></a></span>
									<?php } else { ?>
									<span><a href="<?php echo $unblock_url; ?>" title="<?php _e("Unblock IP ", WDFM()->prefix); ?>"><?php _e('Unblock IP', WDFM()->prefix); ?></a></span>
								<?php } ?>
								</div>
							</td>
							<td class="table_large_col submitterusername_fc sub-align" id="submitterusername_fc" <?php echo $style_username; ?> data-colname="<?php _e('Submitter\'s Username', WDFM()->prefix);?>">
								<p><?php echo $username; ?></p>
							</td>
							<td class="table_large_col submitteremail_fc sub-align" id="submitteremail_fc" <?php echo $style_useremail; ?> data-colname="<?php _e('Submitter\'s Email Address', WDFM()->prefix);?>">
									<p><?php echo $useremail; ?></p>
							</td>
							<?php							
							for ( $h = 0; $h < $m; $h++ ) {
							  $ispaypal = false;
							  if ( $sorted_label_types[$h] == 'type_stripe' ) {
								continue;
							  }
							  $not_label = TRUE;
							  for ( $g = 0; $g < count($temp); $g++ ) {
							    if ( !isset($sorted_label_types[$g]) ) {
							      continue;
								}
								$styleStr = $this->model->hide_or_not($lists['hide_label_list'], $sorted_labels_id[$h]);
								$temp[$g]->element_value = $sorted_label_types[$g] != 'type_file_upload' ? esc_html($temp[$g]->element_value) : $temp[$g]->element_value;
								if ( $temp[$g]->element_label == $sorted_labels_id[$h] ) {
								  if ( strpos($temp[$g]->element_value, "***map***") ) {
									$map_params = explode('***map***', $temp[$g]->element_value);
									?>
									<td class="table_large_col <?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php _e('Show on Map', WDFM()->prefix);?>">
									  <a class="thickbox-preview" href="<?php echo add_query_arg(array(
																								   'action' => 'FormMakerMapEditinPopup' . WDFM()->plugin_postfix,
																								   'long' => $map_params[0],
																								   'lat' => $map_params[1],
																								   'width' => '620',
																								   'height' => '550',
																								   'TB_iframe' => '1',
																								 ), admin_url('admin-ajax.php')); ?>" title="<?php _e("Show on Map", WDFM()->prefix); ?>"><?php _e("Show on Map", WDFM()->prefix); ?></a>
									</td>
									<?php
								  }
								  elseif ( strpos($temp[$g]->element_value, "*@@url@@*") ) {
									?>
									<td class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php _e('URL', WDFM()->prefix);?>">
									  <?php
									  $new_files = explode("*@@url@@*", $temp[$g]->element_value);
									  foreach ( $new_files as $new_file ) {
										if ( $new_file ) {
										  $new_filename = explode('/', $new_file);
										  $new_filename = $new_filename[count($new_filename) - 1];
										  ?>
										  <a target="_blank" class="fm_fancybox" rel="group_<?php echo $www; ?>" href="<?php echo $new_file; ?>"><?php echo $new_filename; ?></a>
										  <br />
										  <?php
										}
									  }
									  ?>
									</td>
									<?php
								  }
								  elseif ( strpos($temp[$g]->element_value, "***star_rating***") ) {
									$view_star_rating_array = $this->model->view_for_star_rating($temp[$g]->element_value, $temp[$g]->element_label);
									$stars = $view_star_rating_array[0];
									?>
									<td align="center" class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php _e('Star rating', WDFM()->prefix);?>"><?php echo $stars; ?></td>
									<?php
								  }
								  elseif ( strpos($temp[$g]->element_value, "***matrix***") ) {
									?>
									<td class="table_large_col <?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php _e('Matrix', WDFM()->prefix);?>">
									  <a class="thickbox-preview" href="<?php echo add_query_arg(array(
																								   'action' => 'show_matrix' . WDFM()->plugin_postfix,
																								   'matrix_params' => str_replace('#', '%23', urlencode($temp[$g]->element_value)),
																								   'width' => '620',
																								   'height' => '550',
																								   'TB_iframe' => '1',
																								 ), admin_url('admin-ajax.php')); ?>" title="<?php _e("Show Matrix", WDFM()->prefix); ?>"><?php _e("Show Matrix", WDFM()->prefix); ?></a>
									</td>
									<?php
								  }
								  elseif ( strpos($temp[$g]->element_value, "@@@") !== FALSE || $temp[$g]->element_value == "@@@" || $temp[$g]->element_value == "@@@@@@@@@" ) {
									?>
									<td class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" <?php echo $styleStr; ?> data-colname="<?php echo !empty($label_name_ids[$sorted_labels_id[$h]]) ? $label_name_ids[$sorted_labels_id[$h]] : ''; ?>">
									  <p><?php echo str_replace("@@@", " ", $temp[$g]->element_value); ?></p>
									</td>
									<?php
								  }
								  elseif ( strpos($temp[$g]->element_value, "***grading***") ) {
									$view_grading_array = $this->model->view_for_grading($temp[$g]->element_value);
									$items = $view_grading_array[0];
									?>
									<td class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php _e('Grading', WDFM()->prefix);?>">
									  <p><?php echo $items; ?></p>
									</td>
									<?php
								  }
								  else {									
									// check is paypal status
									if($sorted_labels_id[$h] == 0 &&  !empty($temp[$g]->element_value) ) {
										$ispaypal = true;
									}

									if ( strpos($temp[$g]->element_value, "***quantity***") ) {
									  $temp[$g]->element_value = str_replace("***quantity***", " ", $temp[$g]->element_value);
									}
									if ( strpos($temp[$g]->element_value, "***property***") ) {
									  $temp[$g]->element_value = str_replace("***property***", " ", $temp[$g]->element_value);
									}
									if ( $sorted_label_types[$h] == "type_submitter_mail" ) {
									  $query = $wpdb->prepare('SELECT id FROM ' . $wpdb->prefix . 'formmaker_submits WHERE form_id ="%d" AND group_id="%d" AND element_value="verified**%d"', $form_id, $i, $sorted_labels_id[$h]);
									  $isverified = $wpdb->get_var($query);
									  if ( $isverified ) {
										if ( !isset($verified_emails[$sorted_labels_id[$h]]) ) {
										  $verified_emails[$sorted_labels_id[$h]] = array();
										}
										$verified_emails[$sorted_labels_id[$h]][] = $i;
										?>
										<td class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php echo !empty($label_name_ids[$sorted_labels_id[$h]]) ? $label_name_ids[$sorted_labels_id[$h]] : ''; ?>">
										  <p><?php echo $temp[$g]->element_value; ?>
											<span style="color:#2DA068;">( Verified <img src="<?php echo WDFM()->plugin_url . '/images/verified.png'; ?>" /> )</span>
										  </p>
										</td>
									  <?php }
									  else { ?>
										<td class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php echo !empty($label_name_ids[$sorted_labels_id[$h]]) ? $label_name_ids[$sorted_labels_id[$h]] : ''; ?>">
										  <p><?php  echo $temp[$g]->element_value; ?></p>
										</td>
									  <?php }
									}
									else {
										$element_value = str_replace("***br***", '<br>', stripslashes($temp[$g]->element_value));
                    $textdata = $this->gen_shorter_text($element_value, 100);
									  ?>
									  <td class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?> data-colname="<?php echo !empty($label_name_ids[$sorted_labels_id[$h]]) ? $label_name_ids[$sorted_labels_id[$h]] : ''; ?>">
										<p><?php echo $textdata['text']; ?></p>
									  </td>
									  <?php
									}
								  }
								  $not_label = FALSE;
								}
							}

							  if ( $not_label ) {
								?>
								<td class="<?php echo $sorted_labels_id[$h]; ?>_fc sub-align" id="<?php echo $sorted_labels_id[$h]; ?>_fc" <?php echo $styleStr; ?>>
								  <p>&nbsp;</p>
								</td>
								<?php
							  }
						}
						if ( $ispaypal ) {
						  ?>
							<td class="payment_info_fc sub-align" id="payment_info_fc" <?php echo $style_payment_info; ?> data-colname="<?php _e('Paypal information', WDFM()->prefix); ?>">
								<a class="thickbox-preview" href="<?php echo add_query_arg(array(
																						 'action' => 'paypal_info' . WDFM()->plugin_postfix,
																						 'id' => $i,
																						 'width' => '600',
																						 'height' => '500',
																						 'TB_iframe' => '1',
																					   ), admin_url('admin-ajax.php')); ?>" title="<?php _e("Paypal information", WDFM()->prefix); ?>">
								<img src="<?php echo WDFM()->plugin_url . '/images/info.png'; ?>" />
								</a>
							</td>
						  <?php
						}
						?>
					  </tr>
					  <?php
					  $k = 1 - $k;
					}
				}
				else {
					echo WDW_FM_Library::no_items('submissions');
				}
				?>
				</tbody>
			  </table>
			</div>
		</div>
	</div>
	<?php
        if ( $sorted_label_types ) {
          foreach ( $sorted_label_types as $key => $sorted_label_type ) {
            if ( $this->model->check_radio_type($sorted_label_type) ) {
              $is_stats = TRUE;
              break;
            }
          }
          if ( $is_stats ) {
            $ajax_nonce = wp_create_nonce( WDFM()->nonce );
            ?>            
            <div class="fm-statistics">
              <h2><?php echo _e('Statistics', WDFM()->prefix);?></h2>
              <table class="stats">
                <tr>
                  <td colspan="3">
                    <select id="sorted_label_key">
                      <option value=""><?php echo _e('- Select -', WDFM()->prefix);?></option>
                      <?php
                      foreach ( $sorted_label_types as $key => $sorted_label_type ) {
                        if ( $sorted_label_type == "type_checkbox" || $sorted_label_type == "type_radio" || $sorted_label_type == "type_own_select" || $sorted_label_type == "type_country" || $sorted_label_type == "type_paypal_select" || $sorted_label_type == "type_paypal_radio" || $sorted_label_type == "type_paypal_checkbox" || $sorted_label_type == "type_paypal_shipping" ) {
                          ?>
                          <option value="<?php echo $key; ?>"><?php echo $sorted_label_names_original[$key]; ?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>
					<p class="fm_error_sorted_label_key"><?php echo _e('Please select the field!', WDFM()->prefix);?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label style="margin-left: 7px;"><?php echo _e('Date From:', WDFM()->prefix);?></label>
                  </td>
                  <td>
                    <input class="inputbox" type="text" name="startstats" id="startstats" size="9" maxlength="9" />
                    <?php echo _e('To:', WDFM()->prefix);?>
					<input class="inputbox" type="text" name="endstats" id="endstats" size="9" maxlength="9" />
                  </td>
                  <td>
					<span class="fm-div_stats-loading spinner"></span>
                    <button class="button" onclick="show_stats(); return false;"><?php _e('Show', WDFM()->prefix); ?></button>					
                  </td>
                </tr>
              </table>
              <div id="div_stats"></div>
            </div>
            <script>			
			show_stats_url = "<?php echo add_query_arg( array('action' => 'get_stats' . WDFM()->plugin_postfix, 'task' => 'show_stats', 'current_id' => $form_id ), $page_url); ?>";
			</script>
            <?php
          }
        }
	?>
	<div class="fm_modal">
		<div id="fm-progressbar">
			<div class="fm-progress-label">Loading...</div>
		</div>
    </div>
	<div class="export_progress">
		<span class="exp_count"><?php echo $subs_count; ?></span> left from <?php echo $subs_count; ?>
    </div>
    <div id="sbox-overlay" onclick="toggleChBDiv(false);"></div>
	<script>
		<?php
			if ( isset($sorted_label_names) ) {
			  $templabels = array_merge(array(
										  'submitid',
										  'submitterip',
										  'submitterusername',
										  'submitteremail',
										), $sorted_labels_id);
			  $sorted_label_names_for_check = array_merge(array(
															'ID',
															"Submitter's IP",
															"Submitter's Username",
															"Submitter's Email Address",
														  ), $sorted_label_names_original);
			}
			else {
			  $templabels = array(
				'submitid',
				'submitterip',
				'submitterusername',
				'submitteremail',
			  );
			  $sorted_label_names_for_check = array(
				'ID',
				"Submitter's IP",
				'Submitter\'s Username',
				'Submitter\'s Email Address',
			  );
			}
		?>

		function clickLabChBAll(ChBAll) {
			if (ChBAll.checked) {
				document.forms.admin_form.hide_label_list.value = '';
				var ChBDivInputs = document.getElementById('ChBDiv').getElementsByTagName('input');
				for (var i = 1, input; input = ChBDivInputs[i++]; ) {
					if(input.id != 'ChBAll'){
						input.checked = ChBAll.checked;
					}
				}
			}
			else {
			  document.forms.admin_form.hide_label_list.value = '@<?php echo implode($templabels, '@@') ?>@' + '@payment_info@';
			  for (i = 0; i <= ChBAll.form.length; i++) {
				if (typeof(ChBAll.form[i]) != "undefined") {
				  if (ChBAll.form[i].type == "checkbox") {
						ChBAll.form[i].checked = false;
				  }
				}
			  }
			}
			renderColumns();
		}
	</script>
	<div id="ChBDiv">
	<p class="add-col-header"><?php _e('Select columns', WDFM()->prefix); ?></p>
    <div class="fm_check_labels">
			<input type="checkbox" <?php echo ( !$lists['hide_label_list'] ) ? 'checked="checked"' : ''; ?> onclick="clickLabChBAll(this)" id="ChBAll" />
			<label for="ChBAll"><?php _e('All', WDFM()->prefix); ?></label>
		</div>
    <?php
    foreach ( $templabels as $key => $curlabel ) {
      if ( strpos($lists['hide_label_list'], '@' . $curlabel . '@') === FALSE ) {
        ?>
    <div class="fm_check_labels">
      <input type="checkbox" checked="checked" onclick="clickLabChB('<?php echo $curlabel; ?>', this)" id="fm_check_id_<?php echo $curlabel; ?>" />
      <label for="fm_check_id_<?php echo $curlabel; ?>"> <?php echo stripslashes($sorted_label_names_for_check[$key]); ?></label>
    </div>
        <?php
      }
      else {
        ?>
    <div class="fm_check_labels">
      <input type="checkbox" onclick="clickLabChB('<?php echo $curlabel; ?>', this)" id="fm_check_id_<?php echo $curlabel; ?>" />
      <label for="fm_check_id_<?php echo $curlabel; ?>"> <?php echo stripslashes($sorted_label_names_for_check[$key]); ?></label>
    </div>
        <?php
      }
    }
    $ispaypal = FALSE;
    for ( $i = 0; $i < count($sorted_label_names); $i++ ) {
      if ( $sorted_label_types[$i] == 'type_paypal_payment_status' || $sorted_label_types[$i] == 'type_stripe' ) {
        $ispaypal = TRUE;
      }
    }
    if ( $ispaypal ) {
      ?>
      <div class="fm_check_labels">
        <input type="checkbox" onclick="clickLabChB('payment_info', this)" id="fm_check_payment_info" <?php echo (strpos($lists['hide_label_list'], '@payment_info@') === FALSE) ? 'checked="checked"' : ''; ?> />
        <label for="fm_check_payment_info"><?php _e('Payment info', WDFM()->prefix); ?></label>
      </div>
      <?php
    }
    ?>
    <div class="done-cont">
      <button onclick="toggleChBDiv(false); return false;" class="button button-primary"><?php _e('Done', WDFM()->prefix); ?></button>
    </div>
  </div>
	<script type="text/javascript">
		function export_submissions(type, limit) {
			var progressbar = jQuery("#fm-progressbar");
			var progressLabel = jQuery(".fm-progress-label");
			progressbar.progressbar({
			  max: <?php echo $subs_count; ?>
			});
			jQuery.ajax({
			  type: "POST",
			  url: "<?php echo add_query_arg(array(
											   'form_id' => $form_id,
											   'send_header' => 0,
											 ), admin_url('admin-ajax.php')); ?>&action=generete_" + type + "&limitstart=" + limit,
			  data: {search_labels: '<?php echo $searched_ids; ?>', verified_emails: jQuery('#verified_emails').val()},
			  beforeSend: function () {
				if (<?php echo $subs_count; ?> >=
				1000
				)
				jQuery('.fm_modal').show();
			  },
			  success: function (data) {
				if (limit < <?php echo $subs_count; ?>) {
				  limit += 1000;
				  export_submissions(type, limit);
				  progressbar.progressbar("value", limit);
				  loaded_percent = Math.round((progressbar.progressbar("value") * 100) / parseInt(<?php echo $subs_count; ?>));
				  progressLabel.text(loaded_percent + ' %');
				  progressbarValue = progressbar.find(".fm-progress-label");
				  if (loaded_percent >= 46) {
					progressbarValue.css({
					  "color": '#fff',
					});
				  }
				  else {
					progressbarValue.css({
					  "color": '#444',
					});
				  }
				}
				else {
				  jQuery('.fm_modal').hide();
				  progressbar.progressbar("value", 0);
				  progressLabel.text('Loading ...');
				  progressbarValue = progressbar.find(".fm-progress-label");
				  progressbarValue.css({
					"color": '#444',
				  });
				  window.location = "<?php echo add_query_arg(array(
																'form_id' => $form_id,
																'send_header' => 1,
															  ), admin_url('admin-ajax.php')); ?>&action=generete_" + type + "&limitstart=" + limit;
				}
			  }
			});
		}
		function remove_all() {
			if (document.getElementById('startdate')) {
			  document.getElementById('startdate').value = '';
			}
			if (document.getElementById('enddate')) {
			  document.getElementById('enddate').value = '';
			}
			if (document.getElementById('id_search')) {
			  document.getElementById('id_search').value = '';
			}
			if (document.getElementById('ip_search')) {
			  document.getElementById('ip_search').value = '';
			}
			if (document.getElementById('username_search')) {
			  document.getElementById('username_search').value = '';
			}
			if (document.getElementById('useremail_search')) {
			  document.getElementById('useremail_search').value = '';
			}
			<?php
			foreach($sorted_label_types as $slt_index => $slt_val){
            if ($slt_val != "type_mark_map" && $slt_val != "type_stripe") {
				?>
					document.getElementById('<?php echo $form_id . '_' . $sorted_labels_id[$slt_index] . '_search'; ?>').value = '';
				<?php
				}
				if ($slt_val == "type_submitter_mail") {
				?>
					if (document.getElementById('<?php echo $form_id . '_' . $sorted_labels_id[$slt_index] . '_search_verified'; ?>')) {
					  document.getElementById('<?php echo $form_id . '_' . $sorted_labels_id[$slt_index] . '_search_verified'; ?>').checked = false;
					}
				<?php
				}
			}
			?>
    }

	function show_hide_filter() {
      jQuery(".show-filter").toggle();
      jQuery(".hide-filter").toggle();
      if (document.getElementById('fm-fields-filter').style.display == "none") {
        document.getElementById('fm-fields-filter').style.display = '';
		jQuery('.fm-bulk-actions .search_reset_button').show();
      }
      else {
        document.getElementById('fm-fields-filter').style.display = "none";
        jQuery('.fm-bulk-actions .search_reset_button').hide();
      }
	  add_scroll_width();
      return false;
    }

    jQuery(document).ready(function () {
      jQuery('.theme-detail').click(function () {
        jQuery(this).siblings('.themedetaildiv').toggle();
        return false;
      });
      jQuery("#startdate, #startstats, #enddate, #endstats").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
      });
    });
    jQuery(window).on("resize", function () {
	   var width = jQuery(window).width();
      if (width <= 765) {
        document.getElementById('fm-fields-filter').style.display = 'none';
        remove_scroll_width();
      }
      else {
        if ( jQuery('.hide-filter.hide').is(":visible") ) {
			document.getElementById('fm-fields-filter').style.display = '';
		}
        add_scroll_width();
      }
    });
	jQuery(window).on('load', function (e) {
		fm_popup();
		if (typeof jQuery().fancybox !== 'undefined' && jQuery.isFunction(jQuery().fancybox)) {
		  jQuery(".fm_fancybox").fancybox({
			'maxWidth ': 600,
			'maxHeight': 500
		  });
		}
    });
		<?php if ($is_search) { ?>
		  document.getElementById('fm-fields-filter').style.display = '';
		<?php } ?>
		</script>
	<input id="form_id" name="form_id" type="hidden" value="<?php echo $form_id; ?>">
	<input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php echo $asc_or_desc; ?>"/>
	<input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>"/>
	<?php
	}

  public function show_stats( $params ) {
	ob_start();
    $sorted_label_name_original = $params['sorted_label_name_original'];
    $choices_labels = $params['choices_labels'];
    $choices_count = $params['choices_count'];
    $all = $params['all'];
    $unanswered = $params['unanswered'];
    $colors = $params['colors'];
    $choices_colors = $params['choices_colors'];
    ?>
    <br />
    <div class="field-label"><?php echo stripslashes($sorted_label_name_original); ?></div>
    <table class="adminlist">
      <thead>
        <tr>
          <th width="20%"><?php _e('Choices', WDFM()->prefix); ?></th>
          <th><?php _e('Percentage', WDFM()->prefix); ?></th>
          <th width="10%" style="text-align: left;"><?php _e('Count', WDFM()->prefix); ?></th>
        </tr>
      </thead>
      <?php
      $k = 0;
      if ( !empty($choices_labels) ) {
        foreach ( $choices_labels as $key => $choices_label ) {
          if ( strpos($choices_label, "***quantity***") ) {
          $choices_label = str_replace("***quantity***", " ", $choices_label);
        }
        if ( strpos($choices_label, "***property***") ) {
          $choices_label = str_replace("***property***", " ", $choices_label);
        }
        ?>
        <tr>
          <td class="label<?php echo $k; ?>"><?php echo str_replace("***br***", '<br>', $choices_label) ?></td>
          <td>
            <div class="fm-bordered-progress bordered" style="width:<?php echo ($choices_count[$key] / ($all - $unanswered)) * 100; ?>%; background-color:<?php echo $colors[$key % 2]; ?>;"></div>
            <div <?php echo($choices_count[$key] / ($all - $unanswered) != 1 ? 'class="fm-bordered-progress bordered' . $k . '"' : "") ?> style="width:<?php echo 100 - ($choices_count[$key] / ($all - $unanswered)) * 100; ?>%;"><span class="fm-bordered-progress-percent"><?php echo round( ($choices_count[$key] / ($all - $unanswered)) * 100 , 2 ); ?> %</span></div>
          </td>
          <td>
            <div>
              <div class="fm-bordered-count-arrow"style="border-right:8px solid <?php echo $choices_colors[$key % 2]; ?>;"></div>
              <div class="fm-bordered-count" style="background-color:<?php echo $choices_colors[$key % 2]; ?>;">
                <?php echo $choices_count[$key] ?>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="3">
          </td>
        </tr>
          <?php
          $k = 1 - $k;
        }
      }
      if ( $unanswered ) {
        ?>
        <tr>
          <td colspan="2" style="text-align:right; color: #000;"><?php _e('Unanswered', WDFM()->prefix); ?></td>
          <td><strong style="margin-left:10px;"><?php echo $unanswered; ?></strong></td>
        </tr>
        <?php
      }
      ?>
      <tr>
        <td colspan="2" style="text-align:right; color: #000;"><strong><?php _e('Total', WDFM()->prefix); ?></strong></td>
        <td><strong style="margin-left:10px;"><?php echo $all; ?></strong></td>
      </tr>
    </table>
    <?php
	return ob_get_clean();
    die();
  }

  public function edit( $params ) {
    $form = $params['form'];
    $current_id = $params['current_id'];
    $rows = $params['rows'];
    $labels_id = $params['labels_id'];
    $labels_name = $params['labels_name'];
    $labels_type = $params['labels_type'];
    $username = $params['username'];
    $useremail = $params['useremail'];
    ?>
  <div class="wrap">
		<?php
		// Generate message container by message id or directly by message.
		$message_id = WDW_FM_Library::get('message', 0);
		$message = WDW_FM_Library::get('msg', '');
		echo WDW_FM_Library::message_id($message_id, $message);
		?>
		<form action="admin.php?page=submissions<?php echo WDFM()->menu_postfix; ?>" method="post" id="adminForm" name="adminForm"  class="form_maker_submissions_edit wd-form">
			<div class="wd-page-title wd-header">
				<h1 class="wp-heading-inline"><?php _e('Edit Submission', WDFM()->prefix); ?></h1>
			</div>
			<div class="wd-buttons">
				<button class="button button-primary button-large" onclick="fm_set_input_value('task', 'save'); fm_set_input_value('current_id', <?php echo $current_id; ?>); fm_form_submit(event, 'adminForm');"><?php _e('Save', WDFM()->prefix); ?></button>
			</div>
			<div class="wd-table">
				<div class="wd-table-col wd-table-col-50 wd-table-col-left">
					<div class="wd-box-section">
						<div class="wd-box-content non-editable">
              <div class="wd-group">
                <label class="wd-label" for="id"><?php _e('Form', WDFM()->prefix); ?></label>
                <span><?php echo $form->title; ?></span>
              </div>
							<div class="wd-group">
								<label class="wd-label" for="id"><?php _e('ID', WDFM()->prefix); ?></label>
								<span><?php echo $rows[0]->group_id; ?></span>
							</div>
							<div class="wd-group">
								<label class="wd-label" for="id"><?php _e('Date', WDFM()->prefix); ?></label>
								<span><?php echo $rows[0]->date; ?></span>
							</div>
							<div class="wd-group">
								<label class="wd-label" for="id"><?php _e('IP', WDFM()->prefix); ?></label>
								<span><?php echo $rows[0]->ip; ?></span>
							</div>
							<div class="wd-group">
								<label class="wd-label" for="id"><?php _e('Submitter\'s Username', WDFM()->prefix); ?></label>
								<span><?php echo $username; ?></span>
							</div>
							<div class="wd-group">
								<label class="wd-label" for="id"><?php _e('Submitter\'s Email Address', WDFM()->prefix); ?></label>
								<span><?php echo $useremail; ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="wd-table-col wd-table-col-50 wd-table-col-right">
					<div class="wd-box-section">
						<div class="wd-box-content">
							<?php
								foreach ( $labels_id as $key => $label_id ) {
								  if ( $this->model->check_type_for_edit_function($labels_type[$key]) ) {
									$element_value = $this->model->check_for_submited_label($rows, $label_id);
									if ( $element_value == "continue" ) {
									  continue;
									}
									switch ( $labels_type[$key] ) {
									  case 'type_checkbox':
										$choices = explode('***br***', $element_value);
										$choices = array_slice($choices, 0, count($choices) - 1);
										?>
										<div class="wd-group">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<?php  foreach ( $choices as $choice_key => $choice ) { ?>
												<input type="text" name="submission_<?php echo $label_id . '_' . $choice_key; ?>" id="submission_<?php echo $label_id . '_' . $choice_key; ?>" value="<?php echo $choice; ?>" size="80" />
											<?php } ?>
										</div>
										<?php
										break;
										case 'type_paypal_payment_status':
										?>
										<div class="wd-group">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<select name="submission_0" id="submission_0">
											  <option value=""></option>
											  <option value="Canceled"><?php echo _e('Canceled', WDFM()->prefix); ?></option>
											  <option value="Cleared"><?php echo _e('Cleared', WDFM()->prefix); ?></option>
											  <option value="Cleared by payment review"><?php echo _e('Cleared by payment review', WDFM()->prefix); ?></option>
											  <option value="Completed"><?php echo _e('Completed', WDFM()->prefix); ?></option>
											  <option value="Denied"><?php echo _e('Denied', WDFM()->prefix); ?></option>
											  <option value="Failed"><?php echo _e('Failed', WDFM()->prefix); ?></option>
											  <option value="Held"><?php echo _e('Held', WDFM()->prefix); ?></option>
											  <option value="In progress"><?php echo _e('In progress', WDFM()->prefix); ?></option>
											  <option value="On hold"><?php echo _e('On hold', WDFM()->prefix); ?></option>
											  <option value="Paid"><?php echo _e('Paid', WDFM()->prefix); ?></option>
											  <option value="Partially refunded"><?php echo _e('Partially refunded', WDFM()->prefix); ?></option>
											  <option value="Pending verification"><?php echo _e('Pending verification', WDFM()->prefix); ?></option>
											  <option value="Placed"><?php echo _e('Placed', WDFM()->prefix); ?></option>
											  <option value="Processing"><?php echo _e('Processing', WDFM()->prefix); ?></option>
											  <option value="Refunded"><?php echo _e('Refunded', WDFM()->prefix); ?></option>
											  <option value="Refused"><?php echo _e('Refused', WDFM()->prefix); ?></option>
											  <option value="Removed"><?php echo _e('Removed', WDFM()->prefix); ?></option>
											  <option value="Returned"><?php echo _e('Returned', WDFM()->prefix); ?></option>
											  <option value="Reversed"><?php echo _e('Reversed', WDFM()->prefix); ?></option>
											  <option value="Temporary hold"><?php echo _e('Temporary hold', WDFM()->prefix); ?></option>
											  <option value="Unclaimed"><?php echo _e('Unclaimed', WDFM()->prefix); ?></option>
											</select>
											<script>
											  var element = document.getElementById("submission_0");
											  element.value = "<?php echo $element_value; ?>";
											</script>
										  </div>
										<?php
										break;
									  case 'type_star_rating':
										$star_rating_array = $this->model->images_for_star_rating($element_value, $label_id);
										$edit_stars = $star_rating_array[0];
										$stars_value = $star_rating_array[1];
										?>
										<div class="wd-group">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<?php echo $edit_stars; ?>
											<input type="hidden" id="<?php echo $label_id; ?>_star_amountform_id_temp" name="<?php echo $label_id; ?>_star_amountform_id_temp" value="<?php echo $stars_value[0]; ?>">
											<input type="hidden" name="<?php echo $label_id; ?>_star_colorform_id_temp" id="<?php echo $label_id; ?>_star_colorform_id_temp" value="<?php echo $stars_value[1]; ?>">
											<input type="hidden" id="<?php echo $label_id; ?>_selected_star_amountform_id_temp" name="<?php echo $label_id; ?>_selected_star_amountform_id_temp" value="<?php echo $stars_value[0]; ?>">
											<input type="hidden" name="submission_<?php echo $label_id; ?>" id="submission_<?php echo $label_id; ?>" value="<?php echo $element_value; ?>" size="80" />
										</div>
										<?php
										break;
									  case "type_scale_rating":
										$scale_rating_array = $this->model->params_for_scale_rating($element_value, $label_id);
										$scale = $scale_rating_array[0];
										$scale_radio = $scale_rating_array[1];
										$checked = $scale_rating_array[2];
										?>
										<div class="wd-group">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<?php echo $scale; ?>
											<input type="hidden" id="<?php echo $label_id; ?>_scale_checkedform_id_temp" name="<?php echo $label_id; ?>_scale_checkedform_id_temp" value="<?php echo $scale_radio[1]; ?>">
											<input type="hidden" name="submission_<?php echo $label_id; ?>" id="submission_<?php echo $label_id; ?>" value="<?php echo $element_value; ?>" size="80" />
										</div>
										<?php
										break;
									  case 'type_range':
										$range = $this->model->params_for_type_range($element_value, $label_id);
										?>
										<div class="wd-group type_range">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<?php echo $range; ?>
											<input type="hidden" name="submission_<?php echo $label_id; ?>" id="submission_<?php echo $label_id; ?>" value="<?php echo $element_value; ?>" size="80" />
										</div>
										<?php
										break;
									  case 'type_spinner':
										?>
										<div class="wd-group">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<input type="text" name="submission_<?php echo $label_id; ?>" id="submission_<?php echo $label_id; ?>" value="<?php echo str_replace("*@@url@@*", '', $element_value); ?>" size="20" />
										</div>
										<?php
										break;
									  case 'type_grading':
										$type_grading_array = $this->model->params_for_type_grading($element_value, $label_id);
										$garding = $type_grading_array[0];
										$garding_value = $type_grading_array[1];
										$sum = $type_grading_array[2];
										$items_count = $type_grading_array[3];
										$element_value1 = $type_grading_array[4];
										?>
										<div class="wd-group type_grading">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<?php echo $garding; ?>
											<p style="padding-left: 80px;">
												<span id="<?php echo $label_id; ?>_grading_sumform_id_temp"><?php echo $sum; ?></span> /
												<span id="<?php echo $label_id; ?>_grading_totalform_id_temp"><?php echo $garding_value[$items_count]; ?></span>
												<span id="<?php echo $label_id; ?>_text_elementform_id_temp"></span>
											</p>
											<input type="hidden" id="<?php echo $label_id; ?>_element_valueform_id_temp" name="<?php echo $label_id; ?>_element_valueform_id_temp" value="<?php echo $element_value1; ?>" />
											<input type="hidden" id="<?php echo $label_id; ?>_grading_totalform_id_temp" name="<?php echo $label_id; ?>_grading_totalform_id_temp" value="<?php echo $garding_value[$items_count]; ?>" />
											<input type="hidden" name="submission_<?php echo $label_id; ?>" id="submission_<?php echo $label_id; ?>" value="<?php echo $element_value; ?>" size="80" />
										</div>
										<?php
										break;
									  case 'type_matrix':
										$type_matrix_array = $this->model->params_for_type_matrix($element_value, $label_id);
										$matrix = $type_matrix_array[0];
										$new_filename = $type_matrix_array[1];
										?>
										<div class="wd-group type_matrix">
											<label class="wd-label"><?php echo $labels_name[$key]; ?></label>
											<input type="hidden" id="<?php echo $label_id; ?>_matrixform_id_temp" name="<?php echo $label_id; ?>_matrixform_id_temp" value="<?php echo $new_filename; ?>">
											<?php echo $matrix; ?>
											<input type="hidden" name="submission_<?php echo $label_id; ?>" id="submission_<?php echo $label_id; ?>" value="<?php echo $element_value; ?>" size="80" />
										</div>
										<?php
										break;
									  default:
										if ( strpos($element_value, "@@@") !== FALSE ) {
										  $element_value = str_replace("@@@", " ", $element_value);
										}
										?>
										<div class="wd-group">
											<label class="wd-label" for="submission_<?php echo $label_id; ?>"><?php echo $labels_name[$key]; ?></label>
											<input type="text" name="submission_<?php echo $label_id; ?>" id="submission_<?php echo $label_id; ?>" value="<?php echo str_replace("*@@url@@*", '', $element_value); ?>" size="80" />
										</div>
										<?php
										break;
									}
								  }
								}
								?>
						</div>
					</div>
				</div>
			</div>
			<?php wp_nonce_field(WDFM()->nonce, WDFM()->nonce); ?>
			<input type="hidden" name="option" value="com_formmaker" />
			<input type="hidden" id="current_id" name="current_id" value="<?php echo $rows[0]->group_id; ?>" />
			<input type="hidden" name="form_id" value="<?php echo $rows[0]->form_id; ?>" />
			<input type="hidden" name="date" value="<?php echo $rows[0]->date; ?>" />
			<input type="hidden" name="ip" value="<?php echo $rows[0]->ip; ?>" />
			<input type="hidden" id="task" name="task" value="" />
			<input type="hidden" value="<?php echo WDFM()->plugin_url; ?>" id="form_plugins_url" />
		</form>
	</div>
    <?php
  }

	/**
	* Print saelect form.
	* @param $params
	*/
	private function saelect_form( $params ) {
    if ( !empty($params['forms']) ) {
			$page = $params['page'];
			$page_url = $params['page_url'];
			?>
			<select name="form_id" id="form_id">
				<option value="0"><?php _e('- Select a form -', WDFM()->prefix); ?></option>
				<?php
					foreach ( $params['forms'] as $form ) {
						$selected = ( $form->id == $params['id'] ) ? 'selected="selected"' : '';
						$show_url = add_query_arg( array( 'page' => $page, 'task' => 'display', 'current_id' => $form->id ), admin_url('admin.php'));
						echo '<option value="' . $form->id . '" ' . $selected . ' data-submission-href="' . $show_url . '">' . $form->title . '</option>';
					}
				?>
			</select>
			<script>
				jQuery(document).ready(function () {
					jQuery( '#form_id' ).on("change", function () {
						if (jQuery(this).val() > 0) {
							var href = jQuery( '#form_id option:selected' ).attr( 'data-submission-href' );
							location.href = href;
						}
					});
				});
			</script>
			<?php
		}
	}

  /**
   * Generate short text.
   *
   * @param $text , $chars_limit
   *
   * @return array.
   */
  public function gen_shorter_text( $text, $chars_limit ) {
    $data = array();
    // Check if length is larger than the character limit.
    if ( strlen($text) > $chars_limit && $text == strip_tags($text) ) {
      // If so, cut the string at the character limit.
      $new_text = mb_substr( $text, 0, $chars_limit,"utf-8" );
      // Trim off white space.
      $new_text = trim($new_text);
      // Add at end of text ...
      $data['status'] = TRUE;
      $data['text'] = $new_text . "...";
    }
    // If not just return the text and status as is.
    else {
      $data['status'] = FALSE;
      $data['text'] = $text;
    }
    return $data;
  }
}

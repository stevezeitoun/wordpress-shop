<?php
/**
 * Class FMControllerSubmissions_fm
 */
class FMControllerSubmissions_fm {
	/**
	* @var $model
	*/
	private $model;
	/**
	* @var $view
	*/
	private $view;
	/**
	* @var string $page
	*/
	private $page;	
	/**
	* @var string $bulk_action_name
	*/
	private $bulk_action_name;
	/**
	* @var string $page_url
	*/
	private $page_url;
	/**
	* @var int $page_per_num
	*/
	private $page_per_num = 20;
	/**
	* @var array $actions
	*/
	private $actions = array();

	public function __construct() {
		// Load FMModelSubmissions_fm class.
		require_once WDFM()->plugin_dir . "/admin/models/Submissions_fm.php";
		$this->model = new FMModelSubmissions_fm();
		// Load FMViewSubmissions_fm class.
		require_once WDFM()->plugin_dir . "/admin/views/Submissions_fm.php";
		$this->view = new FMViewSubmissions_fm($this->model);

		$this->page 	= WDW_FM_Library::get('page');
		$this->page_url = add_query_arg( array (
												'page' => $this->page,
												WDFM()->nonce => wp_create_nonce(WDFM()->nonce),
											  ), admin_url('admin.php')
										  );

		$this->bulk_action_name = 'bulk_action';
		$this->actions = array(
		  'block_ip' => array(
			'title' => __('Block IPs', WDFM()->prefix),
			$this->bulk_action_name => __('Blocked', WDFM()->prefix),
			),		
		  'unblock_ip' => array(
			'title' => __('Unblock IPs', WDFM()->prefix),
			$this->bulk_action_name => __('Unblocked', WDFM()->prefix),
		  ),	
		  'delete' => array(
			'title' => __('Delete', WDFM()->prefix),
			$this->bulk_action_name => __('Deleted', WDFM()->prefix),
		  ),
		);

		$user = get_current_user_id();
		$screen = get_current_screen();
		if ( !empty($user) && !empty($screen) ) {
			$option = $screen->get_option('per_page', 'option');
			$per_page = get_user_meta($user, $option, true);
			if ( $per_page ) {
				$this->page_per_num = $per_page;
			}
		}
	}

	/**
	* Execute.
	*/
	public function execute() {
		$task = WDW_FM_Library::get('task');
		$id = (int) WDW_FM_Library::get('current_id', 0);
		if ( method_exists($this, $task) ) {
		if ( $task != 'display' ) {
			check_admin_referer(WDFM()->nonce, WDFM()->nonce);
		}
		  $block_action = $this->bulk_action_name;
		  $action = WDW_FM_Library::get( $block_action , -1 );	
		  if ( $action != -1 ) {			
			$this->$block_action($action);
		  }
		  else {
			$this->$task($id);
		  }
		}
		else {
		  $this->forms($id);
		}
	}

	/**
   * Bulk actions.
   *
   * @param $task
   */
	public function bulk_action($task) {
		$form_id = WDW_FM_Library::get('form_id', 0);
		$check 	 = WDW_FM_Library::get('check', '');

		$message = 0;
		$successfully_updated = 0;

		if ( $check ) {
		  foreach ( $check as $id => $item ) {
			if ( method_exists($this, $task) ) {
			  $message = $this->$task($id, TRUE);
			  if ( $message != 2 ) {
				// Increase successfully updated items count, if action doesn't failed.
				$successfully_updated++;
			  }
			}
		  }
		  if ( $successfully_updated ) {
			$block_action = $this->bulk_action_name;
			$message = sprintf(_n('%s item successfully %s.', '%s items successfully %s.', $successfully_updated, WDFM()->prefix), $successfully_updated, $this->actions[$task][$block_action]);
		  }
		}
		WDW_FM_Library::fm_redirect( add_query_arg( array('page' => $this->page, 'task' => 'display', 'current_id' => $form_id, ($message === 2 ? 'message' : 'msg') => $message), admin_url('admin.php') ) );
	}

	/**
	* Forms.
	* @param  int $id
	*/	
	public function forms($id) {
		// Set params for view.
		$params = array();
		$params['id'] 			= $id;
		$params['page'] 		= $this->page;
		$params['page_url']		= $this->page_url;					  
		$params['page_title'] 	= __('Submissions', WDFM()->prefix);
		$params['forms'] 		= $this->model->get_forms();
		
		$this->view->forms($params);
	}

	/**
	* Display.
	* @param  int $id
	*/
	public function display( $id = 0 ) {
		// Set params for view.
		$params = array();
		$params['id'] 			= $id;
		$params['page'] 		= $this->page;
		$params['page_url']		= $this->page_url;	
		$params['page_title']   = __('Submissions', WDFM()->prefix);
		$params['actions'] 		= $this->actions;
		
		// Set pagination params.		
		$params['pagination_url']  = add_query_arg( array( 'task' => 'display', 'current_id' => $id ), $this->page_url );
		$params['page_per_num']    = $this->page_per_num;
		$page = (int) WDW_FM_Library::get('paged', 1);
		$page_num = $page ? ($page - 1) * $params['page_per_num'] : 0;	
		
		$params['forms'] = $this->model->get_forms();		
		$params['statistics']  = $this->model->get_statistics( $id );
		$params['blocked_ips'] = $this->model->blocked_ips();
		
		$labels_parameters = $this->model->get_labels_parameters( $id , $page_num, $params['page_per_num'] );
		$params['sorted_labels_id'] 	= $labels_parameters[0];
		$params['sorted_label_types']	= $labels_parameters[1];
		$params['sorted_label_names'] 	= $labels_parameters[3];
		$params['sorted_label_names_original'] = $labels_parameters[4];
		
		$label_name_ids = array();
		foreach($labels_parameters[0] as $key => $label_id) {
			$label_name_ids[$label_id] = $labels_parameters[4][$key];
		}
		$params['label_name_ids'] = $label_name_ids;
		$group_ids = ((isset($labels_parameters[6])) ? $labels_parameters[6] : NULL);
		$params['group_id_s'] = $this->model->sort_group_ids(count($params['sorted_label_names']), $group_ids);
		$params['where_choices'] = $labels_parameters[7];
		$params['searched_ids'] = $labels_parameters[8] ? implode(',', $labels_parameters[8]) : '';		
		
		$params['order_by']		= (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'group_id');
		$params['asc_or_desc'] 	= ((isset($_POST['asc_or_desc']) && $_POST['asc_or_desc'] == 'asc') ? 'asc' : 'desc');
		
		$lists = $labels_parameters[2];
		$params['lists'] = $lists;
		$params['style_id'] = $this->model->hide_or_not($lists['hide_label_list'], '@submitid@');
		$params['style_date'] = $this->model->hide_or_not($lists['hide_label_list'], '@submitdate@');
		$params['style_ip'] = $this->model->hide_or_not($lists['hide_label_list'], '@submitterip@');
		$params['style_username'] = $this->model->hide_or_not($lists['hide_label_list'], '@submitterusername@');
		$params['style_useremail'] = $this->model->hide_or_not($lists['hide_label_list'], '@submitteremail@');
		$params['style_payment_info'] = $this->model->hide_or_not($lists['hide_label_list'], '@payment_info@');   
	
		$params['oder_class_default'] = "manage-column column-autor sortable desc";
		$params['oder_class'] = "manage-column column-autor column-title sorted " . $params['asc_or_desc'];
		$params['m'] = count($params['sorted_label_names']);
		
		$is_search = false;
		foreach($lists as $list_key => $list_val){
			if(!empty($_POST[$list_key])) {
				$is_search = true;
			}
		}
		$params['is_search'] = $is_search; // (($lists['ip_search'] || $lists['startdate'] || $lists['enddate'] || $lists['username_search'] || $lists['useremail_search'] || $lists['id_search']) ? true : false );
		$params['is_stats'] = FALSE;
		
		$params['rows_data']    = $lists;
		$params['rows'] 		= $labels_parameters[5];
		$params['subs_count'] 	= $labels_parameters[2]['total'];
		
		// Check is active pdf-integration add-on.
		$params['pdf_data'] = array();
		if ( defined('WD_FM_PDF') && is_plugin_active(constant('WD_FM_PDF')) ) {
			require_once(WD_FM_PDF_DIR . '/model.php');	
			$params['pdf_data'] = WD_FM_PDF_model::get_pdf_data( $id );
		}
		
		$this->view->display($params);
	}

	/**
	* Show stats.
	* @param  int $id
	*/
	public function show_stats( $id = 0 ) {
		ob_clean();
		$key = (int) WDW_FM_Library::get('sorted_label_key', '');
		
		$page = (int) WDW_FM_Library::get('paged', 1);
		$page_num = $page ? ($page - 1) * $this->page_per_num : 0;	
		
		$labels_parameters = $this->model->get_labels_parameters( $id, $page_num, $this->page_per_num);
		$where_choices = $labels_parameters[7];
		$sorted_label_names_original = $labels_parameters[4];
		$sorted_labels_id = $labels_parameters[0];
		
		$all = 0;
		$choices_labels = array();
		$sorted_label_name_original = '';
		$choices_count = '';
		$unanswered = NULL;
		$colors = array();
		$choices_colors = array();
		if ( count($sorted_labels_id) != 0 ) {
		  $choices_params = $this->model->statistic_for_radio($where_choices, $sorted_labels_id[$key]);
		  $sorted_label_name_original = $sorted_label_names_original[$key];
		  $choices_count = $choices_params[0];
		  $choices_labels = $choices_params[1];
		  $unanswered = $choices_params[2];
		  $all = $choices_params[3];
		  $colors = $choices_params[4];
		  $choices_colors = $choices_params[5];
		}
				
		// Set params for view.
		$params = array();
		$params['key'] = $key;
		$params['all'] = $all;
		$params['choices_labels'] = $choices_labels;
		$params['sorted_label_name_original'] = $sorted_label_name_original;
		$params['choices_count'] = $choices_count;
		$params['unanswered'] = $unanswered;
		$params['colors'] = $colors;
		$params['choices_colors'] = $choices_colors;
		
		$json = array();
		$json['html'] = $this->view->show_stats($params);
		echo json_encode($json); exit;
  }

	/**
	* Edit.
	* @param  int $id
	*/
  public function edit( $id=0 ) {
	$form_id = WDW_FM_Library::get('form_id', 0);
    $data = $this->model->get_data_of_group_id( $id );
	if ( empty($data[0]) ) {
		WDW_FM_Library::fm_redirect( add_query_arg( array('page' => $this->page, 'task' => 'display', 'current_id' => $id ), admin_url('admin.php') ) );
	}

    $labels_id = '';
    $rows = array();
    $labels_type = array();
    $labels_name = array();
    $ispaypal = array();
    if ( !empty($data) ) {
      $labels_id = $data[1];
      $rows = $data[0];
      $labels_name = $data[2];
      $labels_type = $data[3];
      $ispaypal = $data[4];
      $form = $data[5];
      $userinfo = get_userdata($rows[0]->user_id_wd);
    }

    $username = $userinfo ? $userinfo->display_name : "";
    $useremail = $userinfo ? $userinfo->user_email : "";

    // Set params for view.
    $params = array();
    $params['form_id'] 	  = $form_id;
    $params['form'] 	  = $form;
    $params['current_id'] = $id;
    $params['rows'] 	  = $rows;
    $params['labels_id']  = $labels_id;
    $params['labels_name'] = $labels_name;
    $params['labels_type'] = $labels_type;
    $params['ispaypal'] = $ispaypal;
    $params['username'] = $username;
    $params['useremail'] = $useremail;
    $this->view->edit($params);
  }

	/**
	* Save.
	* @param  int $id
	*/
	public function save( $id = 0 ) {
		$form_id = WDW_FM_Library::get('form_id', 0);
		$this->save_db( $id, $form_id );
	}

	/**
	* Save.
	* @param  int $id
	* @param  int $form_id
	*/
	public function save_db( $id, $form_id) {
		$id 	= (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
		$date 	= esc_html($_POST['date']);
		$ip 	= esc_html($_POST['ip']);

		$form = $this->model->get_all($form_id);
		$label_id = array();
		$label_order_original = array();
		$label_type = array();
		if ( strpos($form->label_order, 'type_paypal_') ) {
		  $form->label_order = $form->label_order . "0#**id**#Payment Status#**label**#type_paypal_payment_status#****#";
		}
		$label_all = explode('#****#', $form->label_order);
		$label_all = array_slice($label_all, 0, count($label_all) - 1);
		foreach ( $label_all as $key => $label_each ) {
		  $label_id_each = explode('#**id**#', $label_each);
		  array_push($label_id, $label_id_each[0]);
		  $label_oder_each = explode('#**label**#', $label_id_each[1]);
		  array_push($label_order_original, $label_oder_each[0]);
		  array_push($label_type, $label_oder_each[1]);
		}
		foreach ( $label_id as $key => $label_id_1 ) {
		  if ( isset($_POST["submission_" . $label_id_1]) ) {
			$element_value = (isset($_POST["submission_" . $label_id_1]) ? esc_html(stripslashes($_POST["submission_" . $label_id_1])) : " ");
			$result = $this->model->get_id($id, $label_id_1);
			if ( $label_type[$key] == 'type_file_upload' ) {
			  if ( $element_value ) {
				$element_value = $element_value . "*@@url@@*";
			  }
			}
			if ( $result ) {
			  $save = $this->model->update_fm_submits(array(
														'element_value' => stripslashes($element_value),
													  ), array(
														'group_id' => $id,
														'element_label' => $label_id_1,
													  ), array(
														'%s',
													  ), array(
														'%d',
														'%s',
													  ));
			}
			else {
			  $save = $this->model->insert_fm_submits(array(
														'form_id' => $form_id,
														'element_label' => $label_id_1,
														'element_value' => stripslashes($element_value),
														'group_id' => $id,
														'date' => $date,
														'ip' => $ip,
													  ), array(
														'%d',
														'%s',
														'%s',
														'%d',
														'%s',
														'%s',
													  ));
			}
		  }
		  else {
			if ( isset($_POST["submission_" . $label_id_1 . '_0']) ) {
			  $element_value = '';
			  for ( $z = 0; $z < 21; $z++ ) {
				$element_value_ch = isset($_POST["submission_" . $label_id_1 . '_' . $z]) ? $_POST["submission_" . $label_id_1 . '_' . $z] : NULL;
				if ( isset($element_value_ch) ) {
				  $element_value = $element_value . $element_value_ch . '***br***';
				}
				else {
				  break;
				}
			  }
			  $result = $this->model->get_id($id, $label_id_1);
			  if ( $result ) {
				$save = $this->model->update_fm_submits(array(
														  'element_value' => stripslashes($element_value),
														), array(
														  'group_id' => $id,
														  'element_label' => $label_id_1,
														), array(
														  '%s',
														), array(
														  '%d',
														  '%s',
														));
			  }
			  else {
				$save = $this->model->insert_fm_submits(array(
														  'form_id' => $form_id,
														  'element_label' => $label_id_1,
														  'element_value' => stripslashes($element_value),
														  'group_id' => $id,
														  'date' => $date,
														  'ip' => $ip,
														), array(
														  '%d',
														  '%s',
														  '%s',
														  '%d',
														  '%s',
														  '%s',
														));
			  }
			}
		  }
		}
		
		$message = 2;
		if ( $save !== FALSE ) {
		  $message = 14;
		}
		$args = array(
					'page' 	=> $this->page,
					'task'  => 'edit',
					'current_id' => $id,
					'form_id' => $form_id,
					'message' => $message,
				);
		
		WDW_FM_Library::fm_redirect(add_query_arg( $args, admin_url('admin.php')) );
  }

	/**
   * Delete form by id.
   *
   * @param      $id
   * @param bool $bulk
   *
   * @return int
   */
	public function delete( $id, $bulk = FALSE ) {		
		$form_id = (int) WDW_FM_Library::get('form_id', 0);		
		$delete = $this->model->delete_row($id);
		$message = 2;
		if ( $delete ) {
			$message = 3;
		}
		
		if ( $bulk ) {
			return $message;
		}
	
		WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                'page' 		=> $this->page,
                                                'task' 		=> 'display',
                                                'current_id'=> $form_id,
                                                'message' 	=> $message,
                                              ), admin_url('admin.php')));	
	}

	/**
	* Block IP form by id.
	*
	* @param      $id
	* @param bool $bulk
	*
	* @return int
	*/
	public function block_ip( $id, $bulk = FALSE ) {
		global $wpdb;
		
		$form_id = (int) WDW_FM_Library::get('form_id', 0);		
		$q 	 = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'formmaker_submits WHERE group_id ="%d"', $id);
		$row = $wpdb->get_row($q);		
		$message = 2;	
		
		if( !empty($row) ) {
			if( !$this->model->get_ips( $row->ip ) ) {
				$save = $this->model->set_ips( array('ip' => $row->ip), array( '%s', ) );
				  
				if($save){
					$message = 12;
				}
			}
		}		
		if ( $bulk ) {
			return $message;
		}

		WDW_FM_Library::fm_redirect(add_query_arg( array(
												'page' 		=> $this->page,
												'task' 		=> 'display',
												'current_id'=> $form_id,
												'message' 	=> $message,
											  ), admin_url('admin.php')) );	
	}
	
	/**
	* Unblock IP form by id.
	*
	* @param      $id
	* @param bool $bulk
	*
	* @return int
	*/
	public function unblock_ip( $id, $bulk = FALSE ) {
		global $wpdb;
		
		$form_id = (int) WDW_FM_Library::get('form_id', 0);
		$q 	 = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'formmaker_submits WHERE group_id ="%d"', $id);
		$row = $wpdb->get_row($q);		
		$message = 2;
		
		if( !empty($row) ) {
			if( $this->model->get_ips( $row->ip ) ) {
				$delete = $this->model->delete_by_ip( $row->ip );				  
				if($delete){
					$message = 13;
				}
			}
		}
		
		if ( $bulk ) {
			return $message;
		}

		WDW_FM_Library::fm_redirect(add_query_arg( array(
												'page' 		=> $this->page,
												'task' 		=> 'display',
												'current_id'=> $form_id,
												'message' 	=> $message,
											  ), admin_url('admin.php')) );	
	}
}

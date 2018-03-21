<?php

/**
 * Class FMControllerThemes_fm
 */
class FMControllerThemes_fm {
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
   * @var int $items_per_page
   */
  private $items_per_page = 20;
  /**
   * @var array $actions
   */
	private $actions = array();

  public function __construct() {
    require_once WDFM()->plugin_dir . "/admin/models/Themes_fm.php";
    $this->model = new FMModelThemes_fm();
    require_once WDFM()->plugin_dir . "/admin/views/Themes_fm.php";
    $this->view = new FMViewThemes_fm();
    $this->page = WDW_FM_Library::get('page');
	  $this->bulk_action_name = 'bulk_action';
	
    $this->actions = array(
      'duplicate' => array(
        'title' => __('Duplicate', WDFM()->prefix),
        $this->bulk_action_name => __('duplicated', WDFM()->prefix),
      ),
      'delete' => array(
        'title' => __('Delete', WDFM()->prefix),
        $this->bulk_action_name => __('deleted', WDFM()->prefix),
      ),
    );
  }

  /**
   * Execute.
   */
  public function execute() {
    $task = WDW_FM_Library::get('task');
    $id = (int) WDW_FM_Library::get('current_id', 0);
    if ( method_exists($this, $task) ) {
      if ( $task != 'add' && $task != 'edit' && $task != 'display' ) {
        check_admin_referer(WDFM()->nonce, WDFM()->nonce);
      }
      $block_action = $this->bulk_action_name;
      $action = WDW_FM_Library::get($block_action, -1);
		  if ( $action != -1 ) {
			$this->$block_action($action);
		  }
      else {
        $this->$task($id);
      }
    }
    else {
      $this->display();
    }
  }

  /**
   * Display.
   */
  public function display() {
    // Set params for view.
    $params = array();
    $params['page'] = $this->page;
    $params['page_title'] = __('Themes', WDFM()->prefix);
    $params['actions'] = $this->actions;
    $params['order'] = WDW_FM_Library::get('order', 'desc');
    $params['orderby'] = WDW_FM_Library::get('orderby', 'default');
    // To prevent SQL injections.
    $params['order'] = ($params['order'] == 'desc') ? 'desc' : 'asc';
    if ( !in_array($params['orderby'], array( 'title', 'default' )) ) {
      $params['orderby'] = 'default';
    }
    $params['items_per_page'] = $this->items_per_page;
    $page = (int) WDW_FM_Library::get('paged', 1);
    $page_num = $page ? ($page - 1) * $params['items_per_page'] : 0;
    $params['page_num'] = $page_num;
    $params['search'] = WDW_FM_Library::get('s', '');;
    $params['total'] = $this->model->total();
    $params['rows_data'] = $this->model->get_rows_data($params);
    $this->view->display($params);
  }

  /**
   * Bulk actions.
   *
   * @param $task
   */
	public function bulk_action($task) {
		$message = 0;
		$successfully_updated = 0;

		$check = WDW_FM_Library::get('check', '');

		if ( $check ) {
		  foreach ( $check as $form_id => $item ) {
			if ( method_exists($this, $task) ) {
			  $message = $this->$task($form_id, TRUE);
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

		WDW_FM_Library::fm_redirect(add_query_arg(array(
													'page' => $this->page,
													'task' => 'display',
													($message === 2 ? 'message' : 'msg') => $message,
												  ), admin_url('admin.php')));

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
    $isDefault = $this->model->get_default($id);
    if ( $isDefault ) {
      $message = 4;
    }
    else {
      $table = 'formmaker_themes';
      $delete = $this->model->delete_rows(array(
                                            'table' => $table,
                                            'where' => 'id = ' . $id,
                                          ));
      if ( $delete ) {
        $message = 3;
      }
      else {
        $message = 2;
      }
    }
    if ( $bulk ) {
      return $message;
    }
    WDW_FM_Library::fm_redirect( add_query_arg( array('page' => $this->page, 'task' => 'display', 'message' => $message), admin_url('admin.php') ) );
  }

  /**
   * Duplicate by id.
   *
   * @param      $id
   * @param bool $bulk
   *
   * @return int
   */
  public function duplicate( $id, $bulk = FALSE ) {
    $message = 2;
    $table = 'formmaker_themes';
    $row = $this->model->select_rows("get_row", array(
      "selection" => "*",
      "table" => $table,
      "where" => "id=" . (int) $id,
    ));
    if ( $row ) {
      $row = (array) $row;
      unset($row['id']);
      $row['default'] = 0;
      $inserted = $this->model->insert_data_to_db($table, (array) $row);
      if ( $inserted !== FALSE ) {
        $message = 11;
      }
    }
    if ( $bulk ) {
      return $message;
    }
    else {
      WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                  'page' => $this->page,
                                                  'task' => 'display',
                                                  'message' => $message,
                                                ), admin_url('admin.php')));
    }
  }

  /**
   * Edit.
   *
   * @param int $id
   */
  public function edit($id = 0) {
    $params = array();
    $params['id'] = (int) $id;
    $params['row'] = $this->model->get_row_data($params['id'], FALSE);

    if ( $id != 0 && empty($params['row']) ) {
      WDW_FM_Library::fm_redirect( add_query_arg( array('page' => $this->page, 'task' => 'display'), admin_url('admin.php') ) );
    }
    $params['page_title'] = $params['row']->title;
    $params['param_values'] = $params['row']->css;
  	$params['tabs'] = array(
      'global' => __('Global Parameters', WDFM()->prefix),
      'header' => __('Header', WDFM()->prefix),
      'content' => __('Content', WDFM()->prefix),
      'input_select' => __('Inputbox', WDFM()->prefix),
      'choices' => __('Choices', WDFM()->prefix),
      'subscribe' => __('General Buttons', WDFM()->prefix),
      'paigination' => __('Pagination', WDFM()->prefix),
      'buttons' => __('Buttons', WDFM()->prefix),
      'close_button' => __('Close(Minimize) Button', WDFM()->prefix),
      'minimize' => __('Minimize Text', WDFM()->prefix),
      'other' => __('Other', WDFM()->prefix),
      'custom_css' => __('Custom CSS', WDFM()->prefix),
    );
    $border_types = array(
      '' => '',
      'solid' => 'Solid',
      'dotted' => 'Dotted',
      'dashed' => 'Dashed',
      'double' => 'Double',
      'groove' => 'Groove',
      'ridge' => 'Ridge',
      'inset' => 'Inset',
      'outset' => 'Outset',
      'initial' => 'Initial',
      'inherit' => 'Inherit',
      'hidden' => 'Hidden',
      'none' => 'None',
    );
    $borders = array(
      '' => '',
      'top' => __('Top', WDFM()->prefix),
      'right' => __('Right', WDFM()->prefix),
      'bottom' => __('Bottom', WDFM()->prefix),
      'left' => __('Left', WDFM()->prefix)
  	);
    $position_types = array(
	   '' => '',
      'static' => 'Static',
      'relative' => 'Relative',
      'fixed' => 'Fixed',
      'absolute' => 'Absolute',
    );
    $font_weights = array(
      '' => '',
      'normal' => 'Normal',
      'bold' => 'Bold',
      'bolder' => 'Bolder',
      'lighter' => 'Lighter',
      'initial' => 'Initial',
    );
    $aligns = array( '' => '', 'left' => __('Left', WDFM()->prefix), 'center' => __('Center', WDFM()->prefix), 'right' =>  __('Right', WDFM()->prefix) );
    $basic_fonts = array(
      '' => '',
      'arial' => 'Arial',
      'lucida grande' => 'Lucida grande',
      'segoe ui' => 'Segoe ui',
      'tahoma' => 'Tahoma',
      'trebuchet ms' => 'Trebuchet ms',
      'verdana' => 'Verdana',
      'cursive' => 'Cursive',
      'fantasy' => 'Fantasy',
      'monospace' => 'Monospace',
      'serif' => 'Serif',
    );
    $bg_repeats = array(
      '' => '',
      'repeat' => 'repeat',
      'repeat-x' => 'repeat-x',
      'repeat-y' => 'repeat-y',
      'no-repeat' => 'no-repeat',
      'initial' => 'initial',
      'inherit' => 'inherit',
    );
    $google_fonts = WDW_FM_Library::get_google_fonts();
    $font_families = $basic_fonts + $google_fonts;
    $params['fonts'] = implode("|", str_replace(' ', '+', $google_fonts));    
    $params['all_params'] = $this->all_params($params['param_values'], $borders, $border_types, $font_weights, $position_types, $aligns, $bg_repeats, $font_families);

    $this->view->edit($params);
  }

  // set all params in array
  public function all_params( $param_values, $borders, $border_types, $font_weights, $position_types, $aligns, $bg_repeats, $font_families ) {
    $all_params = array(
      'global' => array(
        array(
          'label' => '',
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Font Family', WDFM()->prefix),
          'name' => 'GPFontFamily',
          'type' => 'select',
          'options' => $font_families,
          'class' => '',
          'value' => isset($param_values->GPFontFamily) ? $param_values->GPFontFamily : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'AGPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->AGPWidth) ? $param_values->AGPWidth : '',
          'after' => '%',
        ),
        array(
          'label' => __('Width (for scrollbox, popup form types)', WDFM()->prefix),
          'name' => 'AGPSPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->AGPSPWidth) ? $param_values->AGPSPWidth : '',
          'after' => '%',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'AGPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g. 3px 5px or 3% 5%', WDFM()->prefix),
          'value' => isset($param_values->AGPPadding) ? $param_values->AGPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'AGPMargin',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->AGPMargin) ? $param_values->AGPMargin : '',
          'placeholder' => __('e.g. 5px 10px or 5% 10%', WDFM()->prefix),
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'AGPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'AGPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #e5e5e5',
          'value' => isset($param_values->AGPBorderColor) ? $param_values->AGPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'AGPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->AGPBorderType) ? $param_values->AGPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'AGPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->AGPBorderWidth) ? $param_values->AGPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'AGPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->AGPBorderRadius) ? $param_values->AGPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' =>  __('Box Shadow', WDFM()->prefix),
          'name' => 'AGPBoxShadow',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->AGPBoxShadow) ? $param_values->AGPBoxShadow : '',
          'placeholder' =>  __('e.g.', WDFM()->prefix) . ' 5px 5px 2px #888888',
          'after' => '</div>',
        ),
      ),
      'header' => array(
        array(
          'label' => __('General Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Alignment', WDFM()->prefix),
          'name' => 'HPAlign',
          'type' => 'select',
          'options' => $borders,
          'class' => '',
          'value' => isset($param_values->HPAlign) ? $param_values->HPAlign : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'HPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->HPBGColor) ? $param_values->HPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'HPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HPWidth) ? $param_values->HPWidth : '',
          'after' => '%',
        ),
        array(
          'label' => __('Width (for topbar form type)', WDFM()->prefix),
          'name' => 'HTPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HTPWidth) ? $param_values->HTPWidth : '',
          'after' => '%',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'HPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 3px 5px or 3% 5%',
          'value' => isset($param_values->HPPadding) ? $param_values->HPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'HPMargin',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HPMargin) ? $param_values->HPMargin : '',
          'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'after' => '',
        ),
        array(
          'label' => __('Text Align', WDFM()->prefix),
          'name' => 'HPTextAlign',
          'type' => 'select',
          'options' => $aligns,
          'class' => '',
          'value' => isset($param_values->HPTextAlign) ? $param_values->HPTextAlign : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'HPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'HPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->HPBorderColor) ? $param_values->HPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'HPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->HPBorderType) ? $param_values->HPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'HPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HPBorderWidth) ? $param_values->HPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'HPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HPBorderRadius) ? $param_values->HPBorderRadius : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Title Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'HTPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HTPFontSize) ? $param_values->HTPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'HTPWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->HTPWeight) ? $param_values->HTPWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'HTPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->HTPColor) ? $param_values->HTPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Description Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'HDPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HDPFontSize) ? $param_values->HDPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'HDPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->HDPColor) ? $param_values->HDPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Image Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Alignment', WDFM()->prefix),
          'name' => 'HIPAlign',
          'type' => 'select',
          'options' => $borders,
          'class' => '',
          'value' => isset($param_values->HIPAlign) ? $param_values->HIPAlign : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'HIPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HIPWidth) ? $param_values->HIPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'HIPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->HIPHeight) ? $param_values->HIPHeight : '',
          'after' => 'px</div>',
        ),
      ),
      'content' => array(
        array(
          'label' => __('General Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'GPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->GPBGColor) ? $param_values->GPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'GPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->GPFontSize) ? $param_values->GPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'GPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->GPFontWeight) ? $param_values->GPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'GPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->GPWidth) ? $param_values->GPWidth : '',
          'after' => '%',
        ),
        array(
          'label' => __('Width (for topbar form type)', WDFM()->prefix),
          'name' => 'GTPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->GTPWidth) ? $param_values->GTPWidth : '',
          'after' => '%',
        ),
        array(
          'label' => __('Alignment', WDFM()->prefix),
          'name' => 'GPAlign',
          'type' => 'select',
          'options' => $aligns,
          'class' => '',
          'value' => isset($param_values->GPAlign) ? $param_values->GPAlign : '',
          'after' => '',
        ),
        array(
          'label' => __('Background URL', WDFM()->prefix),
          'name' => 'GPBackground',
          'type' => 'text',
          'class' => '',
		  // 'placeholder' => __('e.g. http:// or https://', WDFM()->prefix),
          'value' => isset($param_values->GPBackground) ? $param_values->GPBackground : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Repeat', WDFM()->prefix),
          'name' => 'GPBackgroundRepeat',
          'type' => 'select',
          'options' => $bg_repeats,
          'class' => '',
          'value' => isset($param_values->GPBackgroundRepeat) ? $param_values->GPBackgroundRepeat : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Position', WDFM()->prefix),
          'name1' => 'GPBGPosition1',
          'name2' => 'GPBGPosition2',
          'type' => '2text',
          'class' => 'fm-2text',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' px|%, top|bottom|left|right|center',
          'value1' => isset($param_values->GPBGPosition1) ? $param_values->GPBGPosition1 : '',
          'value2' => isset($param_values->GPBGPosition2) ? $param_values->GPBGPosition2 : '',
          'before1' => '',
          'before2' => '',
          'after' => '',
        ),
        array(
          'label' => __('Background Size', WDFM()->prefix),
          'name1' => 'GPBGSize1',
          'name2' => 'GPBGSize2',
          'type' => '2text',
          'class' => 'fm-2text',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' px|%, auto|cover|contain',
          'value1' => isset($param_values->GPBGSize1) ? $param_values->GPBGSize1 : '',
          'value2' => isset($param_values->GPBGSize2) ? $param_values->GPBGSize2 : '',
          'before1' => '',
          'before2' => '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'GPColor',
          'type' => 'text',
          'class' => 'color',
          'value' => isset($param_values->GPColor) ? $param_values->GPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'GPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 3px 5px or 3% 5%',
          'value' => isset($param_values->GPPadding) ? $param_values->GPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'GPMargin',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->GPMargin) ? $param_values->GPMargin : '',
          'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'GPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'GPBorderColor',
          'type' => 'text',
          'class' => 'color',
          'value' => isset($param_values->GPBorderColor) ? $param_values->GPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'GPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->GPBorderType) ? $param_values->GPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'GPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->GPBorderWidth) ? $param_values->GPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'GPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->GPBorderRadius) ? $param_values->GPBorderRadius : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Mini labels (name, phone, address, checkbox, radio) Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'GPMLFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->GPMLFontSize) ? $param_values->GPMLFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'GPMLFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->GPMLFontWeight) ? $param_values->GPMLFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'GPMLColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->GPMLColor) ? $param_values->GPMLColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'GPMLPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 3px 5px or 3% 5%',
          'value' => isset($param_values->GPMLPadding) ? $param_values->GPMLPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'GPMLMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'value' => isset($param_values->GPMLMargin) ? $param_values->GPMLMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Section Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'SEPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->SEPBGColor) ? $param_values->SEPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'SEPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 3px 5px or 3% 5%',
          'value' => isset($param_values->SEPPadding) ? $param_values->SEPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'SEPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'value' => isset($param_values->SEPMargin) ? $param_values->SEPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Section Column Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'COPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 3px 5px or 3% 5%',
          'value' => isset($param_values->COPPadding) ? $param_values->COPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'COPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'value' => isset($param_values->COPMargin) ? $param_values->COPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Footer Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'FPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->FPWidth) ? $param_values->FPWidth : '',
          'after' => '%',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'FPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .'  3px 5px or 3% 5%',
          'value' => isset($param_values->FPPadding) ? $param_values->FPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'FPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .'  5px 10px or 5% 10%',
          'value' => isset($param_values->FPMargin) ? $param_values->FPMargin : '',
          'after' => '</div>',
        ),
      ),
      'input_select' => array(
        array(
          'label' => '',
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'IPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->IPHeight) ? $param_values->IPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'IPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->IPFontSize) ? $param_values->IPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'IPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->IPFontWeight) ? $param_values->IPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'IPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix)  .' #efefef',
          'value' => isset($param_values->IPBGColor) ? $param_values->IPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'IPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix)  .' #efefef',
          'value' => isset($param_values->IPColor) ? $param_values->IPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'IPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .'  3px 5px or 3% 5%',
          'value' => isset($param_values->IPPadding) ? $param_values->IPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'IPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .'  5px 10px or 5% 10%',
          'value' => isset($param_values->IPMargin) ? $param_values->IPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'IPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'IPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .'  #efefef',
          'value' => isset($param_values->IPBorderColor) ? $param_values->IPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'IPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->IPBorderType) ? $param_values->IPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'IPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->IPBorderWidth) ? $param_values->IPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'IPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->IPBorderRadius) ? $param_values->IPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Box Shadow', WDFM()->prefix),
          'name' => 'IPBoxShadow',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->IPBoxShadow) ? $param_values->IPBoxShadow : '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 5px 2px #888888',
          'after' => '</div>',
        ),
        array(
          'label' => __('Dropdown additional', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Appearance', WDFM()->prefix),
          'name' => 'SBPAppearance',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' normal, icon, window, button, menu, field',
          'value' => isset($param_values->SBPAppearance) ? $param_values->SBPAppearance : '',
          'after' => '',
        ),
        array(
          'label' => __('Background URL', WDFM()->prefix),
          'name' => 'SBPBackground',
          'type' => 'text',
          'class' => '',
		  // 'placeholder' => __('e.g. http:// or https://', WDFM()->prefix),
          'value' => isset($param_values->SBPBackground) ? $param_values->SBPBackground : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Repeat', WDFM()->prefix),
          'name' => 'SBPBGRepeat',
          'type' => 'select',
          'options' => $bg_repeats,
          'class' => '',
          'value' => isset($param_values->SBPBGRepeat) ? $param_values->SBPBGRepeat : '',
          'after' => '',
        ),
        array(
          'label' => '',
          'type' => 'label',
          'class' => '',
          'after' => '</div>',
        ),
      ),
      'choices' => array(
        array(
          'label' => __('Single Choice', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'SCPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->SCPBGColor) ? $param_values->SCPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'SCPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SCPWidth) ? $param_values->SCPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'SCPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SCPHeight) ? $param_values->SCPHeight : '',
          'after' => 'px',
        ),
		array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'SCPMargin',
          'type' => 'text',
          'class' => '5px',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'value' => isset($param_values->SCPMargin) ? $param_values->SCPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'SCPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'SCPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->SCPBorderColor) ? $param_values->SCPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'SCPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->SCPBorderType) ? $param_values->SCPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'SCPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SCPBorderWidth) ? $param_values->SCPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'SCPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SCPBorderRadius) ? $param_values->SCPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Box Shadow', WDFM()->prefix),
          'name' => 'SCPBoxShadow',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 5px 2px #888888',
          'value' => isset($param_values->SCPBoxShadow) ? $param_values->SCPBoxShadow : '',
          'after' => '',
        ),
        array(
          'label' => __('Checked Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'SCCPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->SCCPBGColor) ? $param_values->SCCPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'SCCPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SCCPWidth) ? $param_values->SCCPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'SCCPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SCCPHeight) ? $param_values->SCCPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'SCCPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'value' => isset($param_values->SCCPMargin) ? $param_values->SCCPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'SCCPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SCCPBorderRadius) ? $param_values->SCCPBorderRadius : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Multiple Choice', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'MCPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->MCPBGColor) ? $param_values->MCPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'MCPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MCPWidth) ? $param_values->MCPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'MCPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MCPHeight) ? $param_values->MCPHeight : '',
          'after' => 'px',
        ),
		 array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'MCPMargin',
          'type' => 'text',
          'class' => '5px',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 10px or 5% 10%',
          'value' => isset($param_values->MCPMargin) ? $param_values->MCPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'MCPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'MCPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' #efefef',
          'value' => isset($param_values->MCPBorderColor) ? $param_values->MCPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'MCPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->MCPBorderType) ? $param_values->MCPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'MCPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MCPBorderWidth) ? $param_values->MCPBorderWidth : '',
          'after' => 'px',
        ),
       
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'MCPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MCPBorderRadius) ? $param_values->MCPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Box Shadow', WDFM()->prefix),
          'name' => 'MCPBoxShadow',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) .' 5px 5px 2px #888888',
          'value' => isset($param_values->MCPBoxShadow) ? $param_values->MCPBoxShadow : '',
          'after' => '',
        ),
        array(
          'label' => __('Checked Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'MCCPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) .'#efefef',
          'value' => isset($param_values->MCCPBGColor) ? $param_values->MCCPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Background URL', WDFM()->prefix),
          'name' => 'MCCPBackground',
          'type' => 'text',
          'class' => '',
		  // 'placeholder' => __('e.g. http:// or https://', WDFM()->prefix),
          'value' => isset($param_values->MCCPBackground) ? $param_values->MCCPBackground : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Repeat', WDFM()->prefix),
          'name' => 'MCCPBGRepeat',
          'type' => 'select',
          'options' => $bg_repeats,
          'class' => '',
          'value' => isset($param_values->MCCPBGRepeat) ? $param_values->MCCPBGRepeat : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Position', WDFM()->prefix),
          'name1' => 'MCCPBGPos1',
          'name2' => 'MCCPBGPos2',
          'type' => '2text',
          'class' => 'fm-2text',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' px|%, top|bottom|left|right|center',
          'value1' => isset($param_values->MCCPBGPos1) ? $param_values->MCCPBGPos1 : '',
          'value2' => isset($param_values->MCCPBGPos2) ? $param_values->MCCPBGPos2 : '',
          'before1' => '',
          'before2' => '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'MCCPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MCCPWidth) ? $param_values->MCCPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'MCCPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MCCPHeight) ? $param_values->MCCPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'MCCPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->MCCPMargin) ? $param_values->MCCPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'MCCPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MCCPBorderRadius) ? $param_values->MCCPBorderRadius : '',
          'after' => 'px</div>',
        ),
      ),
      'subscribe' => array(
        array(
          'label' => __('Global Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Alignment', WDFM()->prefix),
          'name' => 'SPAlign',
          'type' => 'select',
          'options' => $aligns,
          'class' => '',
          'value' => isset($param_values->SPAlign) ? $param_values->SPAlign : '',
          'after' => '</div>',
        ),
        array(
          'label' => __('Submit', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'SPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->SPBGColor) ? $param_values->SPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'SPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SPWidth) ? $param_values->SPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'SPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SPHeight) ? $param_values->SPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'SPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SPFontSize) ? $param_values->SPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'SPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->SPFontWeight) ? $param_values->SPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'SPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->SPColor) ? $param_values->SPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'SPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5px or 3% 5%',
          'value' => isset($param_values->SPPadding) ? $param_values->SPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'SPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->SPMargin) ? $param_values->SPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'SPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'SPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->SPBorderColor) ? $param_values->SPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'SPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->SPBorderType) ? $param_values->SPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'SPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SPBorderWidth) ? $param_values->SPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'SPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SPBorderRadius) ? $param_values->SPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Box Shadow', WDFM()->prefix),
          'name' => 'SPBoxShadow',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 5px 2px #888888',
          'value' => isset($param_values->SPBoxShadow) ? $param_values->SPBoxShadow : '',
          'after' => '',
        ),
        array(
          'label' => __('Hover Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'SHPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->SHPBGColor) ? $param_values->SHPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'SHPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->SHPColor) ? $param_values->SHPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'SHPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'SHPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->SHPBorderColor) ? $param_values->SHPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'SHPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->SHPBorderType) ? $param_values->SHPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'SHPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->SHPBorderWidth) ? $param_values->SHPBorderWidth : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Reset', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'BPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->BPBGColor) ? $param_values->BPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'BPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->BPWidth) ? $param_values->BPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'BPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->BPHeight) ? $param_values->BPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'BPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->BPFontSize) ? $param_values->BPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'BPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->BPFontWeight) ? $param_values->BPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'BPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->BPColor) ? $param_values->BPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'BPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5xp or 3% 5%',
          'value' => isset($param_values->BPPadding) ? $param_values->BPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'BPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10xp or 5% 10%',
          'value' => isset($param_values->BPMargin) ? $param_values->BPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'BPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'BPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->BPBorderColor) ? $param_values->BPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'BPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->BPBorderType) ? $param_values->BPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'BPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->BPBorderWidth) ? $param_values->BPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'BPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->BPBorderRadius) ? $param_values->BPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Box Shadow', WDFM()->prefix),
          'name' => 'BPBoxShadow',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 5px 2px #888888',
          'value' => isset($param_values->BPBoxShadow) ? $param_values->BPBoxShadow : '',
          'after' => '',
        ),
        array(
          'label' => __('Hover Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'BHPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->BHPBGColor) ? $param_values->BHPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'BHPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->BHPColor) ? $param_values->BHPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'BHPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'BHPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->BHPBorderColor) ? $param_values->BHPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'BHPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->BHPBorderType) ? $param_values->BHPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'BHPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->BHPBorderWidth) ? $param_values->BHPBorderWidth : '',
          'after' => 'px</div>',
        ),
      ),
      'paigination' => array(
        array(
          'label' => __('Active', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'PSAPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PSAPBGColor) ? $param_values->PSAPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'PSAPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSAPFontSize) ? $param_values->PSAPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'PSAPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->PSAPFontWeight) ? $param_values->PSAPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'PSAPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PSAPColor) ? $param_values->PSAPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'PSAPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSAPHeight) ? $param_values->PSAPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Line Height', WDFM()->prefix),
          'name' => 'PSAPLineHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSAPLineHeight) ? $param_values->PSAPLineHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'PSAPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5px or 3% 5%',
          'value' => isset($param_values->PSAPPadding) ? $param_values->PSAPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'PSAPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->PSAPMargin) ? $param_values->PSAPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'PSAPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'PSAPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PSAPBorderColor) ? $param_values->PSAPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'PSAPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
		  'value' => isset($param_values->PSAPBorderType) ? $param_values->PSAPBorderType : '',
          'after' => '',
        ),
        array(
		   'label' => __('Border Width', WDFM()->prefix),
          'name' => 'PSAPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSAPBorderWidth) ? $param_values->PSAPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'PSAPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSAPBorderRadius) ? $param_values->PSAPBorderRadius : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Inactive', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'PSDPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PSDPBGColor) ? $param_values->PSDPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'PSDPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSDPFontSize) ? $param_values->PSDPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'PSDPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->PSDPFontWeight) ? $param_values->PSDPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'PSDPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PSDPColor) ? $param_values->PSDPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'PSDPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSDPHeight) ? $param_values->PSDPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Line Height', WDFM()->prefix),
          'name' => 'PSDPLineHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSDPLineHeight) ? $param_values->PSDPLineHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'PSDPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5px or 3% 5%',
          'value' => isset($param_values->PSDPPadding) ? $param_values->PSDPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'PSDPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->PSDPMargin) ? $param_values->PSDPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'PSDPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'PSDPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PSDPBorderColor) ? $param_values->PSDPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'PSDPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->PSDPBorderType) ? $param_values->PSDPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'PSDPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSDPBorderWidth) ? $param_values->PSDPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'PSDPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSDPBorderRadius) ? $param_values->PSDPBorderRadius : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Steps', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '',
        ),
        array(
          'label' => __('Alignment', WDFM()->prefix),
          'name' => 'PSAPAlign',
          'type' => 'select',
          'options' => $aligns,
          'class' => '',
          'value' => isset($param_values->PSAPAlign) ? $param_values->PSAPAlign : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'PSAPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PSAPWidth) ? $param_values->PSAPWidth : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Percentage', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'PPAPWidth',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 500px or 50%',
          'value' => isset($param_values->PPAPWidth) ? $param_values->PPAPWidth : '',
          'after' => '</div>',
        ),
      ),
      'buttons' => array(
        array(
          'label' => __('Global Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'BPFontSize',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->BPFontSize) ? $param_values->BPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'BPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->BPFontWeight) ? $param_values->BPFontWeight : '',
          'after' => '</div>',
        ),
        array(
          'label' => __('Next Button Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'NBPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->NBPBGColor) ? $param_values->NBPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'NBPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->NBPWidth) ? $param_values->NBPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'NBPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->NBPHeight) ? $param_values->NBPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Line Height', WDFM()->prefix),
          'name' => 'NBPLineHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->NBPLineHeight) ? $param_values->NBPLineHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'NBPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->NBPColor) ? $param_values->NBPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'NBPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5px or 3% 5%',
          'value' => isset($param_values->NBPPadding) ? $param_values->NBPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'NBPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->NBPMargin) ? $param_values->NBPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'NBPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'NBPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->NBPBorderColor) ? $param_values->NBPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'NBPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->NBPBorderType) ? $param_values->NBPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'NBPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->NBPBorderWidth) ? $param_values->NBPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'NBPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->NBPBorderRadius) ? $param_values->NBPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Box Shadow', WDFM()->prefix),
          'name' => 'NBPBoxShadow',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 5px 2px #888888',
          'value' => isset($param_values->NBPBoxShadow) ? $param_values->NBPBoxShadow : '',
          'after' => '',
        ),
        array(
          'label' => __('Hover Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'NBHPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->NBHPBGColor) ? $param_values->NBHPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'NBHPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->NBHPColor) ? $param_values->NBHPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'NBHPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'NBHPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->NBHPBorderColor) ? $param_values->NBHPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'NBHPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->NBHPBorderType) ? $param_values->NBHPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'NBHPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->NBHPBorderWidth) ? $param_values->NBHPBorderWidth : '',
          'after' => 'px</div>',
        ),
        array(
          'label' => __('Previous Button Parameters', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'PBPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PBPBGColor) ? $param_values->PBPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Width', WDFM()->prefix),
          'name' => 'PBPWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PBPWidth) ? $param_values->PBPWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Height', WDFM()->prefix),
          'name' => 'PBPHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PBPHeight) ? $param_values->PBPHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Line Height', WDFM()->prefix),
          'name' => 'PBPLineHeight',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PBPLineHeight) ? $param_values->PBPLineHeight : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'PBPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PBPColor) ? $param_values->PBPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'PBPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5px or 3% 5%',
          'value' => isset($param_values->PBPPadding) ? $param_values->PBPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'PBPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->PBPMargin) ? $param_values->PBPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'PBPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'PBPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PBPBorderColor) ? $param_values->PBPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'PBPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->PBPBorderType) ? $param_values->PBPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'PBPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PBPBorderWidth) ? $param_values->PBPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'PBPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PBPBorderRadius) ? $param_values->PBPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Box Shadow', WDFM()->prefix),
          'name' => 'PBPBoxShadow',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 5px 2px #888888',
          'value' => isset($param_values->PBPBoxShadow) ? $param_values->PBPBoxShadow : '',
          'after' => '',
        ),
        array(
          'label' => __('Hover Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'PBHPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PBHPBGColor) ? $param_values->PBHPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'PBHPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PBHPColor) ? $param_values->PBHPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'PBHPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'PBHPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->PBHPBorderColor) ? $param_values->PBHPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'PBHPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->PBHPBorderType) ? $param_values->PBHPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'PBHPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->PBHPBorderWidth) ? $param_values->PBHPBorderWidth : '',
          'after' => 'px</div>',
        ),
      ),
      'close_button' => array(
        array(
          'label' => '',
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Position', WDFM()->prefix),
          'name' => 'CBPPosition',
          'type' => 'select',
          'options' => $position_types,
          'class' => '',
          'value' => isset($param_values->CBPPosition) ? $param_values->CBPPosition : '',
          'after' => '',
        ),
        array(
          'label' => __('Top', WDFM()->prefix),
          'name' => 'CBPTop',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 100px or 10%',
          'value' => isset($param_values->CBPTop) ? $param_values->CBPTop : '',
          'after' => '',
        ),
        array(
          'label' => __('Right', WDFM()->prefix),
          'name' => 'CBPRight',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 100px or 10%',
          'value' => isset($param_values->CBPRight) ? $param_values->CBPRight : '',
          'after' => '',
        ),
        array(
          'label' => __('Bottom', WDFM()->prefix),
          'name' => 'CBPBottom',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 100px or 10%',
          'value' => isset($param_values->CBPBottom) ? $param_values->CBPBottom : '',
          'after' => '',
        ),
        array(
          'label' => __('Left', WDFM()->prefix),
          'name' => 'CBPLeft',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 100px or 10%',
          'value' => isset($param_values->CBPLeft) ? $param_values->CBPLeft : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'CBPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->CBPBGColor) ? $param_values->CBPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'CBPFontSize',
          'type' => 'text',
          'class' => '13',
          'value' => isset($param_values->CBPFontSize) ? $param_values->CBPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'CBPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->CBPFontWeight) ? $param_values->CBPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'CBPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->CBPColor) ? $param_values->CBPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'CBPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5px or 3% 5%',
          'value' => isset($param_values->CBPPadding) ? $param_values->CBPPadding : '',
          'after' => '',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'CBPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->CBPMargin) ? $param_values->CBPMargin : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'CBPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'CBPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->CBPBorderColor) ? $param_values->CBPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'CBPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->CBPBorderType) ? $param_values->CBPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'CBPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->CBPBorderWidth) ? $param_values->CBPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'CBPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->CBPBorderRadius) ? $param_values->CBPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Hover Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'CBHPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->CBHPBGColor) ? $param_values->CBHPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'CBHPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->CBHPColor) ? $param_values->CBHPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'CBHPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'CBHPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->CBHPBorderColor) ? $param_values->CBHPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'CBHPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->CBHPBorderType) ? $param_values->CBHPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'CBHPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->CBHPBorderWidth) ? $param_values->CBHPBorderWidth : '',
          'after' => 'px</div>',
        ),
      ),
      'minimize' => array(
        array(
          'label' => '',
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'MBPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->MBPBGColor) ? $param_values->MBPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Font Size', WDFM()->prefix),
          'name' => 'MBPFontSize',
          'type' => 'text',
          'class' => '13',
          'value' => isset($param_values->MBPFontSize) ? $param_values->MBPFontSize : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Font Weight', WDFM()->prefix),
          'name' => 'MBPFontWeight',
          'type' => 'select',
          'options' => $font_weights,
          'class' => '',
          'value' => isset($param_values->MBPFontWeight) ? $param_values->MBPFontWeight : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'MBPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->MBPColor) ? $param_values->MBPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Text Align', WDFM()->prefix),
          'name' => 'MBPTextAlign',
          'type' => 'select',
          'options' => $aligns,
          'class' => '',
          'value' => isset($param_values->MBPTextAlign) ? $param_values->MBPTextAlign : '',
          'after' => '',
        ),
        array(
          'label' => __('Padding', WDFM()->prefix),
          'name' => 'MBPPadding',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 3px 5px or 3% 5%',
          'value' => isset($param_values->MBPPadding) ? $param_values->MBPPadding : '',
          'after' => 'px|%',
        ),
        array(
          'label' => __('Margin', WDFM()->prefix),
          'name' => 'MBPMargin',
          'type' => 'text',
          'class' => '',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' 5px 10px or 5% 10%',
          'value' => isset($param_values->MBPMargin) ? $param_values->MBPMargin : '',
          'after' => 'px|%',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'MBPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'MBPBorderColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->MBPBorderColor) ? $param_values->MBPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'MBPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->MBPBorderType) ? $param_values->MBPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'MBPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MBPBorderWidth) ? $param_values->MBPBorderWidth : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Border Radius', WDFM()->prefix),
          'name' => 'MBPBorderRadius',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MBPBorderRadius) ? $param_values->MBPBorderRadius : '',
          'after' => 'px',
        ),
        array(
          'label' => __('Hover Parameters', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background Color', WDFM()->prefix),
          'name' => 'MBHPBGColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->MBHPBGColor) ? $param_values->MBHPBGColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'MBHPColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->MBHPColor) ? $param_values->MBHPColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border', WDFM()->prefix),
          'name' => 'MBHPBorder',
          'type' => 'checkbox',
          'options' => $borders,
          'class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Border Color', WDFM()->prefix),
          'name' => 'MBHPBorderColor',
          'type' => 'text',
          'class' => 'color',
          'value' => isset($param_values->MBHPBorderColor) ? $param_values->MBHPBorderColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Type', WDFM()->prefix),
          'name' => 'MBHPBorderType',
          'type' => 'select',
          'options' => $border_types,
          'class' => '',
          'value' => isset($param_values->MBHPBorderType) ? $param_values->MBHPBorderType : '',
          'after' => '',
        ),
        array(
          'label' => __('Border Width', WDFM()->prefix),
          'name' => 'MBHPBorderWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->MBHPBorderWidth) ? $param_values->MBHPBorderWidth : '',
          'after' => 'px</div>',
        ),
      ),
      'other' => array(
        array(
          'label' => __('Inactive Text', WDFM()->prefix),
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'OPDeInputColor',
          'type' => 'text',
          'class' => 'color',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' #efefef',
          'value' => isset($param_values->OPDeInputColor) ? $param_values->OPDeInputColor : '',
          'after' => '',
        ),
        array(
          'label' => __('Font Style', WDFM()->prefix),
          'name' => 'OPFontStyle',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->OPFontStyle) ? $param_values->OPFontStyle : '',
          'after' => '',
        ),
        array(
          'label' => __('Required', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Color', WDFM()->prefix),
          'name' => 'OPRColor',
          'type' => 'text',
          'class' => 'color',
          'value' => isset($param_values->OPRColor) ? $param_values->OPRColor : '',
          'after' => '',
        ),
        array(
          'label' => __('File Upload', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Background URL', WDFM()->prefix),
          'name' => 'OPFBgUrl',
          'type' => 'text',
          'class' => '',
		  // 'placeholder' => __('e.g. http:// or https://', WDFM()->prefix),
          'value' => isset($param_values->OPFBgUrl) ? $param_values->OPFBgUrl : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Repeat', WDFM()->prefix),
          'name' => 'OPFBGRepeat',
          'type' => 'select',
          'options' => $bg_repeats,
          'class' => '',
          'value' => isset($param_values->OPFBGRepeat) ? $param_values->OPFBGRepeat : '',
          'after' => '',
        ),
        array(
          'label' => __('Background Position', WDFM()->prefix),
          'name1' => 'OPFPos1',
          'name2' => 'OPFPos2',
          'type' => '2text',
          'class' => 'fm-2text',
		  'placeholder' => __('e.g.', WDFM()->prefix) . ' px|%, top|bottom|left|right|center',
          'value1' => isset($param_values->OPFPos1) ? $param_values->OPFPos1 : '',
          'value2' => isset($param_values->OPFPos2) ? $param_values->OPFPos2 : '',
          'before1' => '',
          'before2' => '',
          'after' => '',
        ),
        array(
          'label' => __('Grading', WDFM()->prefix),
          'type' => 'label',
          'class' => 'fm-mini-title',
          'after' => '<br/>',
        ),
        array(
          'label' => __('Text Width', WDFM()->prefix),
          'name' => 'OPGWidth',
          'type' => 'text',
          'class' => '',
          'value' => isset($param_values->OPGWidth) ? $param_values->OPGWidth : '',
          'after' => 'px</div>',
        ),
      ),
      'custom_css' => array(
        array(
          'label' => '',
          'type' => 'panel',
          'class' => 'col-md-12',
          'label_class' => '',
          'after' => '',
        ),
        array(
          'label' => __('Custom CSS', WDFM()->prefix),
          'name' => 'CUPCSS',
          'type' => 'textarea',
          'class' => '',
          'value' => isset($param_values->CUPCSS) ? $param_values->CUPCSS : '',
          'after' => '</div>',
        ),
      ),
    );

    return $all_params;
  }

  /**
   * Save theme.
   */
  public function apply() {
    $data = $this->save_db();
    $page = WDW_FM_Library::get('page');
    $active_tab = WDW_FM_Library::get('active_tab');
    $pagination = WDW_FM_Library::get('pagination-type');
    $form_type = WDW_FM_Library::get('form_type');
    WDW_FM_Library::fm_redirect(add_query_arg(array(
                                                'page' => $page,
                                                'task' => 'edit',
                                                'current_id' => $data['id'],
                                                'message' => $data['msg'],
                                                'active_tab' => $active_tab,
                                                'pagination' => $pagination,
                                                'form_type' => $form_type,
                                              ), admin_url('admin.php')));
  }

  /**
   * Save theme to DB.
   *
   * @return array
   */
  public function save_db() {
    global $wpdb;
    $id = (int) WDW_FM_Library::get('current_id', 0);
    $title = (isset($_POST['title']) ? esc_html(stripslashes($_POST['title'])) : '');
    $version = 2;
    $params = (isset($_POST['params']) ? stripslashes(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $_POST['params'])) : '');
    $default = (isset($_POST['default']) ? esc_html(stripslashes($_POST['default'])) : 0);
    if ( $id != 0 ) {
      $save = $this->model->update_formmaker_themes(array(
                                                      'title' => $title,
                                                      'css' => $params,
                                                      'default' => $default,
                                                    ), array( 'id' => $id ));
      $version = $this->model->get_theme_version($id);
    }
    else {
      $save = $this->model->insert_theme(array(
                                           'title' => $title,
                                           'css' => $params,
                                           'default' => $default,
                                           'version' => $version,
                                         ));
      $id = $wpdb->insert_id;
    }
    if ( $save !== FALSE ) {
      require_once WDFM()->plugin_dir . "/frontend/models/form_maker.php";
      $model_frontend = new FMModelForm_maker();
      $form_theme = json_decode(html_entity_decode($params), TRUE);
      $model_frontend->create_css($id, $form_theme, $version == 1, TRUE);

      $msg = 1;
    }
    else {
      $msg = 2;
    }
    return array('id' => $id, 'msg' => $msg);
  }

  /**
   * Set default.
   *
   * @param $id
   */
	public function setdefault( $id ) {
		$this->model->update_formmaker_themes( array( 'default' => 0 ), array( 'default' => 1 ) );
		$save = $this->model->update_formmaker_themes( array( 'default' => 1 ), array( 'id' => $id ) );
		if ( $save !== FALSE ) {
		  $message = 7;
		}
		else {
		  $message = 2;
		}
		$page = WDW_FM_Library::get('page');
		WDW_FM_Library::fm_redirect(add_query_arg(array(
													'page' => $page,
													'task' => 'display',
													'message' => $message,
												  ), admin_url('admin.php')));
	  }
}

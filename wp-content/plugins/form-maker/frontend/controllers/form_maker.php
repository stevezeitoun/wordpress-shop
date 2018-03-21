<?php

/**
 * Class FMControllerForm_maker
 */
class FMControllerForm_maker {
  private $view;
  private $model;
  private $form_preview = false;

  /**
   * FMControllerVerify_email constructor.
   */
  public function __construct() {
    $queried_obj = get_queried_object();
    // check is custom post type in review page.
    if ($queried_obj && isset($queried_obj->post_type) && $queried_obj->post_type == 'form-maker' && $queried_obj->post_name == 'preview') {
      $this->form_preview = true;
    }

    require_once WDFM()->plugin_dir . "/frontend/models/form_maker.php";
    $this->model = new FMModelForm_maker();

    require_once WDFM()->plugin_dir . "/frontend/views/form_maker.php";
    $this->view = new FMViewForm_maker($this->model);
  }

  /**
   * Execute.
   *
   * @param        $id
   * @param string $type
   *
   * @return string|void
   */
  public function execute( $id, $type = 'embedded' ) {
    return $this->display($id, $type);
  }

  /**
   * Display.
   *
   * @param $id
   * @param $type
   *
   * @return string|void
   */
  public function display( $id, $type ) {
    $fm_settings = get_option('fm_settings');
    if ( $type == 'embedded' ) {
      $result = $this->model->showform($id, $type);
      if ( !$result ) {
        return;
      }
      $ok = $this->model->savedata($result[0], $id);
      if ( is_numeric($ok) ) {
        $this->model->remove($ok);
      }
      $this->model->increment_views_count($id);
      return $this->view->display($result, $fm_settings, $id, $type);
    }
    else {
      // Get all forms.
      $forms = $this->model->all_forms();

      return $this->autoload_form($forms, $fm_settings);
    }
  }

  public function autoload_form($forms, $fm_settings) {
    $fm_forms = array();

    foreach ($forms as $key => $form) {
      $display_on_this = FALSE;
      $error = 'success';
      $message = FALSE;
      $id = (int)$form->id;
      $type = $form->type;
      if (isset($_SESSION['redirect_paypal' . $id]) && ($_SESSION['redirect_paypal' . $id] == 1)) {
        $_SESSION['redirect_paypal' . $id] = 0;
      }
      elseif (isset($_SESSION['massage_after_submit' . $id]) && $_SESSION['massage_after_submit' . $id] != '') {
        $massage_after_submit = $_SESSION['massage_after_submit' . $id];
        if ($massage_after_submit) {
          $message = TRUE;
        }
      }
      $display_on = explode(',', $form->display_on);
      $posts_include = explode(',', $form->posts_include);
      $pages_include = explode(',', $form->pages_include);
      $categories_display = explode(',', $form->display_on_categories);
      $current_categories = explode(',', $form->current_categories);
      $posts_include = array_filter($posts_include);
      $pages_include = array_filter($pages_include);
      if ($display_on) {
        wp_reset_query();
        if (in_array('everything', $display_on)) {
          if (is_singular()) {
            if ((is_singular('page') && (!$pages_include || in_array(get_the_ID(), $pages_include))) || (!is_singular('page') && (!$posts_include || in_array(get_the_ID(), $posts_include)))) {
              $display_on_this = TRUE;
            }
          }
          else {
            $display_on_this = TRUE;
          }
        }
        else {
          if (is_archive()) {
            if (in_array('archive', $display_on)) {
              $display_on_this = TRUE;
            }
          }
          else {
            $page_id = (is_front_page() && !is_page()) ? 'homepage' : get_the_ID();
            $current_post_type = 'homepage' == $page_id ? 'home' : get_post_type($page_id);
            if (is_singular() || 'home' == $current_post_type) {
              if (in_array('home', $display_on) && is_front_page()) {
                $display_on_this = TRUE;
              }
            }
            $posts_and_pages = array();
            foreach ($display_on as $dis) {
              if (!in_array($dis, array('everything', 'home', 'archive', 'category'))) {
                $posts_and_pages[] = $dis;
              }
            }
            if ($posts_and_pages && is_singular($posts_and_pages)) {
              switch ($current_post_type) {
                case 'page' :
                case 'home' :
                  if (!$pages_include || in_array($page_id, $pages_include)) {
                    $display_on_this = TRUE;
                  }
                  break;
                case 'post':
                  if (!$posts_include || in_array($page_id, $posts_include)) {
                    $display_on_this = TRUE;
                  }
                  else {
                    $categories = get_the_terms($page_id, 'category');
                    $post_cats = array();
                    if ($categories) {
                      foreach ($categories as $category) {
                        $post_cats[] = $category->term_id;
                      }
                    }
                    foreach ($post_cats as $single_cat) {
                      if (in_array($single_cat, $categories_display)) {
                        $display_on_this = TRUE;
                      }
                    }
                    if (FALSE === $display_on_this && !in_array('auto_select_new', $categories_display)) {
                      foreach ($post_cats as $single_cat) {
                        if (!in_array($single_cat, $current_categories)) {
                          $display_on_this = TRUE;
                        }
                      }
                    }
                    else {
                      $display_on_this = TRUE;
                    }
                  }
                  break;
                default:
                  if (in_array($current_post_type, $display_on)) {
                    $display_on_this = TRUE;
                  }
                  break;
              }
            }
          }
        }
      }
      $show_for_admin = current_user_can('administrator') && $form->show_for_admin ? 'true' : 'false';

      if ( $this->form_preview && ($id == WDW_FM_Library::get('wdform_id', 0)) ) {
        $display_on_this = TRUE;
      }

      $form_result = $this->model->showform($id, $type);
      if ( !$form_result ) {
        continue;
      }
      $ok = $this->model->savedata($form_result[0], $id);
      if ( is_numeric($ok) ) {
        $this->model->remove($ok);
      }
      $this->model->increment_views_count($id);

      $form_html = $this->view->display($form_result, $fm_settings, $id, $type);
      $fm_forms[$id] = $this->view->autoload_form($id, $form, $type, $form_html, $display_on_this, $message, $error, $show_for_admin);
    }

    return implode($fm_forms);
  }
}

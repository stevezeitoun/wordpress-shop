<?php

/**
 * Class FMViewWidget
 */
class FMViewWidget {
  function widget( $args, $instance, $execute ) {
    extract($args);
    $title = $instance['title'];
    $form_id = (isset($instance['form_id']) ? $instance['form_id'] : 0);
    // Before widget.
    echo $before_widget;
    // Title of widget.
    if ( $title ) {
      echo $before_title . $title . $after_title;
    }
    // Widget output.
    echo $execute;
    // After widget.
    echo $after_widget;
  }

  // Widget Control Panel.
  function form( $instance, $ids_FM, $id_title, $name_title, $id_form_id, $name_form_id ) {
    $defaults = array(
      'title' => '',
      'form_id' => 0,
    );
    $instance = wp_parse_args((array) $instance, $defaults);
    ?>
    <p>
      <label for="<?php echo $id_title; ?>">Title:</label>
      <input class="widefat" id="<?php echo $id_title; ?>" name="<?php echo $name_title; ?>" type="text" value="<?php echo $instance['title']; ?>" />
      <label for="<?php echo $id_form_id; ?>">Select a form:</label>
      <select class="widefat" name="<?php echo $name_form_id; ?>" id="<?php echo $id_form_id; ?>">
        <option style="text-align:center" value="0">- Select a Form -</option>
        <?php
        $ids_Form_Maker = $ids_FM;
        foreach ( $ids_Form_Maker as $arr_Form_Maker ) {
          ?>
          <option value="<?php echo $arr_Form_Maker->id; ?>" <?php if ( $arr_Form_Maker->id == $instance['form_id'] ) {
            echo "SELECTED";
          } ?>><?php echo $arr_Form_Maker->title; ?></option>
        <?php } ?>
      </select>
    </p>
    <?php
  }
}

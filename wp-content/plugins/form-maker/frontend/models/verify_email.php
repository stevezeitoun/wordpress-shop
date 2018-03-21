<?php

/**
 * Class FMModelVerify_email
 */
class FMModelVerify_email {
  /**
   * Set given email as validated and return message.
   *
   * @param $gid
   * @param $md5
   * @param $email
   *
   * @return bool|mixed|string|void
   */
  function set_validation( $gid, $md5, $email ) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT * FROM `" . $wpdb->prefix . "formmaker_submits` WHERE group_id='%d' AND element_label REGEXP 'verifyInfo'", $gid);
    $submissions = $wpdb->get_results($query);
    if ( !$submissions ) {
      return FALSE;
    }

    $message = '';
    foreach ( $submissions as $submission ) {
      if ( $submission->element_label == 'verifyInfo' ) {
        $message = __('Your email address is already verified.', WDFM()->prefix);
        continue;
      }
      elseif ( $submission->element_label == 'verifyInfo@' . $email ) {
        $verifyInfo = explode('**', $submission->element_value);
        $key = $verifyInfo[0];
        $expHour = $verifyInfo[1];
        $recipient = $verifyInfo[2];
        if ( $recipient == $email ) {
          $date = strtotime($submission->date);
          if ( $key === $md5 ) {
            $now = time();
            $hourInterval = floor(($now - $date) / 3600);
            if ( $expHour > 0 && $hourInterval > $expHour ) {
              $message = __('Your email verification has timed out.', WDFM()->prefix);
            }
            else {
              $data = array(
                'element_value' => 'verified**' . $recipient,
                'element_label' => 'verifyInfo',
              );
              $where = array(
                'group_id' => $gid,
                'element_label' => 'verifyInfo@' . $recipient,
              );

              $updated = $wpdb->update($wpdb->prefix . "formmaker_submits", $data, $where);

              if ( $updated !== FALSE ) {
                $message = __('Your email has been successfully verified.', WDFM()->prefix);
              }
            }
          }
          else {
            $message = __('Verification link is invalid.', WDFM()->prefix);
          }
          break;
        }
        else {
          continue;
        }
      }
    }

    return $message;
  }
}

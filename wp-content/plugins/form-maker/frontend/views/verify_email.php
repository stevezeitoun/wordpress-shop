<?php

/**
 * Class FMViewVerify_email
 */
class FMViewVerify_email {
  /**
   * Display message.
   *
   * @param $message
   */
	public function display($message) {
		echo WDW_FM_Library::message($message, 'fm-notice-success');
	}
}

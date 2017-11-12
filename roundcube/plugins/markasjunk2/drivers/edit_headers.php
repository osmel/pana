<?php

/**
 * Edit headers
 * @version 1.0
 * @author Philip Weir
 */

class markasjunk2_edit_headers
{
	public function spam(&$uids)
	{
		$this->_edit_headers($uids, true);
	}

	public function ham(&$uids)
	{
		$this->_edit_headers($uids, false);
	}

	private function _edit_headers(&$uids, $spam)
	{
		$rcmail = rcube::get_instance();
		$args = $spam ? $rcmail->config->get('markasjunk2_spam_patterns') : $rcmail->config->get('markasjunk2_ham_patterns');

		if (sizeof($args['patterns']) == 0)
			return;

		$mbox = rcube_utils::get_input_value('_mbox', rcube_utils::INPUT_POST);

		$new_uids = array();
		foreach (explode(",", $uids) as $uid) {
			$raw_message = $rcmail->storage->get_raw_body($uid);
			$raw_headers = $rcmail->storage->get_raw_headers($uid);

			$updated_headers = preg_replace($args['patterns'], $args['replacements'], $raw_headers);
			$raw_message = str_replace($raw_headers, $updated_headers, $raw_message);

			$saved = $rcmail->storage->save_message($mbox, $raw_message);

			if ($saved !== false) {
				$rcmail->output->command('rcmail_markasjunk2_move', null, $uid);
				array_push($new_uids, $saved);
			}

		}

		if (sizeof($new_uids) > 0)
			$uids = implode(',', $new_uids);
	}
}

?>
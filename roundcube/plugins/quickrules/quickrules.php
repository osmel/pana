<?php

/**
 * QuickRules
 *
 * Plugin to allow the user to quickly create filters from the message list
 *
 * @version @package_version@
 * @requires SieveRules plugin
 * @author Philip Weir
 */
class quickrules extends rcube_plugin
{
	public $task = 'mail|settings';

	// default values: label => value
	private $headers = array('subject' => 'header::Subject',
					'from' => 'address::From',
					'to' => 'address::To',
					'cc' => 'address::Cc',
					'bcc' => 'address::Bcc',
					'envelopeto' => 'envelope::To',
					'envelopefrom' => 'envelope::From'
					);

	private $operators = array('filtercontains' => 'contains',
					'filternotcontains' => 'notcontains',
					'filteris' => 'is',
					'filterisnot' => 'notis',
					'filterexists' => 'exists',
					'filternotexists' => 'notexists'
					);

	private $flags = array('flagread' => '\\Seen',
					'flagdeleted' => '\\Deleted',
					'flaganswered' => '\\Answered',
					'flagdraft' => '\\Draft',
					'flagflagged' => '\\\\Flagged'
					);

	private $additional_headers = array('List-Id');

	function init()
	{
		// load required plugin
		$this->require_plugin('sieverules');

		$rcmail = rcube::get_instance();
		$this->register_action('plugin.quickrules.add', array($this, 'init_rule'));

		if ($rcmail->task == 'mail' && ($rcmail->action == '' || $rcmail->action == 'show')) {
			$this->add_texts('localization', true);
			$this->include_script('quickrules.js');
			$this->include_stylesheet($this->local_skin_path() .'/quickrules.css');
			if ($rcmail->output->browser->ie && $rcmail->output->browser->ver == 6)
				$this->include_stylesheet($this->local_skin_path() . '/ie6hacks.css');

			$this->add_button(array('command' => 'plugin.quickrules.create', 'type' => 'link', 'class' => 'button buttonPas quickrules disabled', 'classact' => 'button quickrules', 'classsel' => 'button quickrulesSel', 'title' => 'quickrules.createfilterbased', 'label' => 'quickrules.createfilter'), 'toolbar');
		}

		if ($_SESSION['plugin.quickrules']) {
			$this->add_hook('storage_init', array($this, 'fetch_headers'));
			$this->_create_rule();
		}
	}

	function init_rule()
	{
		$_SESSION['plugin.quickrules'] = true;
		$_SESSION['plugin.quickrules.uids'] = rcube_utils::get_input_value('_uid', rcube_utils::INPUT_POST);
		$_SESSION['plugin.quickrules.mbox'] = rcube_utils::get_input_value('_mbox', rcube_utils::INPUT_POST);

		rcube::get_instance()->output->redirect(array('task' => 'settings', 'action' => 'plugin.sieverules'));
	}

	function fetch_headers($attr)
	{
		$attr['fetch_headers'] .= trim($attr['fetch_headers'] . join(' ', $this->additional_headers));
		return($attr);
	}

	private function _create_rule()
	{
		$rcmail = rcube::get_instance();
		if ($rcmail->action == 'plugin.sieverules' || $rcmail->action == 'plugin.sieverules.add') {
			$this->include_script('quickrules.js');

			if ($rcmail->action == 'plugin.sieverules.add') {
				$uids = $_SESSION['plugin.quickrules.uids'];
				$mbox = $_SESSION['plugin.quickrules.mbox'];
				$rcmail->storage_init();

				$rules = array();
				$actions = array();
				foreach (explode(",", $uids) as $uid) {
					$message = new rcube_message($uid);
					$rules[] = rcube_output::json_serialize(array('header' => $this->headers['from'], 'op' => $this->operators['filteris'], 'target' => $message->sender['mailto']));

					$recipients = array();
					$recipients_array = rcube_mime::decode_address_list($message->headers->to);
					foreach ($recipients_array as $recipient)
						$recipients[] = $recipient['mailto'];

					$identity = $rcmail->user->get_identity();
					$recipient_str = join(', ', $recipients);
					if ($recipient_str != $identity['email'])
						$rules[] = rcube_output::json_serialize(array('header' => $this->headers['to'], 'op' => $this->operators['filteris'], 'target' => $recipient_str));

					if (strlen($message->subject) > 0)
						$rules[] = rcube_output::json_serialize(array('header' => $this->headers['subject'], 'op' => $this->operators['filtercontains'], 'target' => $message->subject));

					foreach ($this->additional_headers as $header) {
						if (strlen($message->headers->others[strtolower($header)]) > 0)
							$rules[] = rcube_output::json_serialize(array('header' => 'other::' . $header, 'op' => $this->operators['filteris'], 'target' => $message->headers->others[strtolower($header)]));
					}

					if ($mbox != 'INBOX')
						$actions[] = rcube_output::json_serialize(array('act' => 'fileinto', 'props' => $mbox));

					foreach ($message->headers->flags as $flag) {
						if ($flag == 'Flagged')
							$actions[] = rcube_output::json_serialize(array('act' => 'imapflags', 'props' => $this->flags['flagflagged']));
					}
				}

				$this->api->output->add_script(rcmail_output::JS_OBJECT_NAME . "_quickrules_rules = [" . implode(',', $rules) . "];");
				$this->api->output->add_script(rcmail_output::JS_OBJECT_NAME . "_quickrules_actions = [" . implode(',', $actions) . "];");

				$_SESSION['plugin.quickrules'] = false;
				$_SESSION['plugin.quickrules.uids'] = '';
				$_SESSION['plugin.quickrules.mbox'] = '';
			}
		}
	}
}

?>
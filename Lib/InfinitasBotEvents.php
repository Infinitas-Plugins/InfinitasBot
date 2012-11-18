<?php
/**
 * InfinitasBotEvents
 *
 * @package InfinitasBot.Lib
 */

/**
 *
 */

class InfinitasBotEvents extends AppEvents {
/**
 * Get plugin details
 *
 * @param Event $Event the event being called
 *
 * @return array
 */
	public function onPluginRollCall(Event $Event) {
		return array(
			'name' => 'Bot',
			'description' => 'Infinitas powered IRC bot',
			'icon' => '/infinitas_bot/img/icon.png',
			'author' => 'Infinitas',
			'dashboard' => array(
				'plugin' => 'infinitas_bot',
				'controller' => 'infinitas_bot_channels',
				'action' => 'dashboard'
			)
		);
	}

/**
 * Load css
 *
 * @param Event $Event
 *
 * @return array
 */
	public function onRequireCssToLoad(Event $Event) {
		return array(
			'InfinitasBot.infinitas_bot'
		);
	}

/**
 * Irc message event
 *
 * Log IRC messages that are not commands. Also handle some other core commands:
 *
 * - seen: Get when the passed user was last seen
 *
 * @param Event $Event
 * @param array $data
 *
 * @return void
 */
	public function onIrcMessage(Event $Event, $data = null) {
		if(empty($data['command'])) {
			ClassRegistry::init('InfinitasBot.InfinitasBotLog')->logChat($data);
		}

		if($data['command'] == 'seen') {
			$user = ClassRegistry::init('InfinitasBot.InfinitasBotUser')->field('last_seen', array(
				'InfinitasBotUser.username' => $data['args']
			));
			if($user) {
				App::uses('CakeTime', 'Utility');
				$Event->Handler->reply($data['channel'], ':to: :username was last seen :date', array(
					'to' => $data['to'],
					'username' => $data['args'],
					'date' => CakeTime::timeAgoInWords($user)
				));
				return true;
			}
			$Event->Handler->reply($data['channel'], ':to: I dont think :username has been here before', array(
				'to' => $data['to'],
				'username' => $data['args']
			));
			return true;
		}

		if($data['command'] == 'quit') {
			$admins = ClassRegistry::init('Users.User')->getAdmins();
			if(!empty($admins[$data['user']])) {
				$Event->Handler->quit('only because you asked so nicely', $data['args']);
				return true;
			}

			$Event->Handler->reply($data['channel'], ':user: Why would I do that?', array(
				'user' => $data['user']
			));
			return true;
		}
	}

/**
 * Event when user joins
 *
 * @param Event $Event the event being triggered
 * @param array $data the data being parsed
 *
 * @return boolean
 */
	public function onIrcUserJoin(Event $Event, $data = null) {
		$Event->Handler->reply($data['channel'], 'Welcome, :to', array(
			'to' => $data['to']
		));

		return true;
	}

	public function onIrcUserPart(Event $Event, $data = null) {

	}

	public function onIrcQuit(Event $Event, $data = null) {
		$this->_checkPid($data)->delete();
	}

/**
 * Save a lock file with the current pid
 *
 * If a lock file exists for the current channel it will not start.
 *
 * @param Event $Event
 * @param array $data the parsed message
 *
 * @throws CakeException
 */
	public function onIrcJoin(Event $Event, $channel = null) {
		$Pid = $this->_checkPid($channel);
		$processId = getmypid();
		if((int)trim($Pid->read()) == file_exists('/proc/') . $processId) {
			throw new CakeException('InfinitasBot is already running');
		}
		return $Pid->write($processId);
	}

	protected function _checkPid($channel) {
		return new File(TMP . 'lock' . DS . 'InfinitasBot' . DS . $channel , true);
	}

}
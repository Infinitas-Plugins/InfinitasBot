<?php
/**
 *
 */

App::uses('IrcSocket', 'InfinitasBot.Network');

/**
 * IrcLib
 *
 * @property IrcSocket $IrcSocket
 */

class IrcLib {
/**
 * Active users in the channel
 *
 * @var array
 */
	protected $_activeUsers = array();

/**
 * The connection being used
 *
 * @var array
 */
	protected $_connection = array();

/**
 * Handler for output
 *
 * Valid callback to be used with call_user_func
 *
 * @var string|array
 */
	protected $_outputHandler = 'print_r';

/**
 * Constructor
 *
 * @param array $connection the connection details to use
 *
 * @return void
 */
	public function __construct(array $connection = array()) {
		if(empty($connection)) {
			$connection = Configure::read('InfinitasBot.server');
		}

		$this->_connection = $connection;
		$this->IrcSocket = new IrcSocket($this->_connection);
	}

	public function outputHandler($handler) {
		if(!is_callable($handler)) {
			throw new InvalidArgumentException('Passed handler is not callable');
		}

		$this->_outputHandler = $handler;
	}

/**
 * Join the requested channels
 *
 * @param array $options the login options
 *
 * @return boolean
 */
	public function login(array $options = array()) {
		$options = array_merge(array(
			'nick' => Configure::read('InfinitasBot.nick'),
			'password' => Configure::read('InfinitasBot.password'),
			'host' => $this->_connection['host']
		), $options);

		$this->_whoAmI = $options['nick'];

		$this->IrcSocket->message('NICK :nick', $options);
		$this->IrcSocket->message('USER :nick :host botts : :nick', $options);
		return $this;
	}

/**
 * Join the requested channels
 *
 * @param array $channels channels to join
 *
 * @return boolean
 */
	function join($channels = array()) {
		if(empty($channels)) {
			$channels = array_values(ClassRegistry::init('InfinitasBot.InfinitasBotChannel')->find('list'));

			if (empty($channels)) {
				throw new InvalidArgumentException('No channels selected');
			}
		}

		foreach ($channels as $channel => $password) {
			if (is_numeric($channel)) {
				$channel = $password;
				$password = null;
			}
			try {
				EventCore::trigger($this, 'ircJoin', $channel);
				$this->IrcSocket->message('JOIN :channel :password', array(
					'channel' => $channel,
					'password' => $password
				));
				$this->_activeUsers[$channel] = array();
			} catch (Exception $e) {
				$this->output('<notice>Cant join</notice> :exception', array(
					'exception' => $e->getMessage()
				));
			}
		}

		return true;
	}

	public function watch() {
		$this->IrcSocket->connect();

		$this->login();
		$this->join();

		while($this->IrcSocket->isConnected() && !$this->IrcSocket->isEof()) {
			$line = $this->IrcSocket->read();
			if(empty($line['irc_command'])) {
				continue;
			}

			if($line['irc_command'] != 'PING') {
				$line['infinitas_bot_user_id'] = ClassRegistry::init('InfinitasBot.InfinitasBotUser')->find('userId', array(
					'user' => $line['user']
				));
				$line['infinitas_bot_channel_id'] = ClassRegistry::init('InfinitasBot.InfinitasBotChannel')->find('channelId', array(
					'channel' => $line['channel']
				));
			}

			$this->_handleInput($line);
		}
	}

	public function output($out, array $options = array()) {
		if(!empty($options)) {
			$out = String::insert($out, $options);
		}
		call_user_func($this->_outputHandler, $out);
	}

	public function reply($channel, $message, array $options = array()) {
		if(!empty($options)) {
			$message = String::insert($message, $options);
		}
		$options = array(
			'channel' => $channel,
			'message' => $message,
			'bot' => $this->_whoAmI
		);
		$this->output('<info>:bot</info>: :message', $options);
		$this->IrcSocket->message('PRIVMSG :channel ::message', $options);
	}

/**
 * Quit IRC
 *
 * @param string $message the quit message
 *
 * @return boolean
 */
	public function quit($message = 'leaving', $channel = null) {
		if($channel) {
			EventCore::trigger($this, 'ircQuit', $channel);
			return $this->IrcSocket->message('PART :channel :message', array(
				'message' => $message,
				'channel' => $channel
			));
		}
		
		EventCore::trigger($this, 'ircQuit');
		return $this->IrcSocket->message('QUIT :message', array(
			'message' => $message
		));
	}

	protected function _handleInput($input) {
		$input['bot'] = $this->_whoAmI;
		switch(strtolower($input['irc_command'])) {
			case 'notice':
				$this->output('<info>Notice</info> :message', $input);
				break;

			case '412':
				$this->output('<warning>Error</warning> :message', $input);
				break;

			case 'quit':
				$this->output('<warning>Quit</warning> :message', $input);
				break;

			case 'ping':
				$this->output('<info>Ping</info> Responded to a ping');
				break;

			case '353':
				$users = explode(':', $input['message'], 3);
				if(!empty($users[1])) {
					$users = explode(' ', $users[1]);
					$this->output('<question>Users:</question> (:count) :users', array(
						'count' => count($users),
						'users' => String::toList($users)
					));
				} else {
					$this->output('<warning>Users:</warning> could not parse');
				}
				break;

			case '433':
				$this->output('<warning>Nick taken<warning> :bot', $input);
				$this->IrcSocket->message('NICK :bot', array(
					'bot' => $input['bot'] . '_'
				));
				break;

			case 'join':
				$this->output('<question>Join</question> :user', $input);
				$this->_trigger('ircUserJoin', $input);
				break;

			case 'part':
				$this->output('<question>Part</question> :user', $input);
				$this->_trigger('ircUserPart', $input);
				break;

			case 'privmsg':
				$this->output('<success>:user</success>: :message', $input);
				$this->_trigger('ircMessage', $input);
				break;

			default:
				$this->output('<warning>Unknown</warning> :irc_command: :raw', $input);
		}
	}

/**
 * Trigger an event and check if something handled the message
 *
 * If nothing handled it, try a tell and if nothing give a command not found
 *
 * @param string $event the event to trigger
 * @param array $data the parsed message data
 *
 * @return void
 */
	protected function _trigger($event, $data) {
		$results = array();
		try {
			$results = EventCore::trigger($this, $event, $data);
			$results = array_unique(array_filter($results[$event]));
		} catch (Exception $e) {
			$this->output('<emergency>Exception</emergency> :exception', array(
				'exception' => $e->getMessage()
			));
			$this->reply($data['channel'], $e->getMessage());
		}

		$count = count($results);

		$commandNotFound = substr($data['message'], 0, 1) == '!' && (!$count || ($count == 1 && !current($results)));
		if($commandNotFound) {
			$message = ':to: Command :command not found';
			$tell = ClassRegistry::init('InfinitasBot.InfinitasBotTell')->find('tell', $data['command']);
			if($tell) {
				$message = ':to: ' . $tell;
			}

			$this->reply($data['channel'], $message, $data);
		}
	}

}
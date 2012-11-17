<?php
/**
 * IrcSocket
 *
 * @package InfinitasBot.Network
 */
App::uses('CakeSocket', 'Network');

/**
 * IrcSocket
 */
class IrcSocket extends CakeSocket {
/**
 * Send a message to the server
 *
 * Method will use String::insert() to add anything from the $options into the $message
 * \r\n is also added to the end of the message by default
 * 
 * @param string $message the message to send
 * @param array $options the options for the message
 * @param string $lineEnd the line ending to use
 * 
 * @return boolean
 */
	public function message($message, array $options = array(), $lineEnd = "\r\n") {
		if(!empty($options)) {
			$message = String::insert($message, $options);
		}
		return $this->write($message . $lineEnd);
	}

	public function isConnected() {
		return $this->connection;
	}

	public function isEof() {
		return feof($this->connection);
	}

	public function connect() {
		if($this->isConnected()) {
			return true;
		}

		if(parent::connect()) {
			return true;
		}

		throw new CakeException('Unable to connect');
	}

	public function read() {
		$data = parent::read();

		$ping = $this->isPing($data);
		if($ping) {
			return $ping;
		}

		return $this->_parseMessage($data);
	}

	protected function _parseMessage(&$data) {
		$return = array(
			'irc_command' => null,
			'host' => null,
			'channel' => null,
			'message' => null,
			'command' => null,
			'args' => null,
			'user' => null,
			'to' => null,
			'raw' => $data
		);
		
		$params = $this->getParams("\s:", $data, 5);
		if(!empty($params)) {
			if(!empty($params[2])) {
				$return['irc_command'] = $params[2];
			}
			if(!empty($params[3])) {
				$return['channel'] = $params[3];
			}
			if(!empty($params[4])) {
				$return['message'] = $params[4];
				if(substr($return['message'], 0, 1) == '!') {
					$matches = array();
					if(preg_match('/!tell ([\S]+) about ([\S]+)( .*)?/i', $return['message'], $matches)) {
						if(count($matches) >= 3) {
							$return['to'] = $matches[1];
							$return['command'] = $matches[2];
						}
						if(!empty($matches[3])) {
							$return['args'] = trim($matches[3]);
						}
					} else {
						$command = explode(' ', $return['message'], 2);
						$return['command'] = substr($command[0], 1);
						if(!empty($command[1])) {
							$return['args'] = trim($command[1]);
						}
					}
				}
			}
		}
		
		if(!empty($params[1])) {
			$user = $this->getParams("!", $params[1], 3);
			if(!empty($user[0])) {
				$return['user'] = $user[0];
				if(empty($return['to'])) {
					$return['to'] = $return['user'];
				}
			}
			if(!empty($user[1])) {
				$return['host'] = $user[1];
			}	
		}

		return $return;
	}

	public function getParams($regex, &$string, $offset = -1) {
		return str_replace(array("\r\n", "\n"), '', preg_split("/[{$regex}]+/", $string, $offset));
	}

/**
 * Check if the message was a ping
 *
 * Will return the PONG to the server if it was a PING
 * 
 * @param string $data the message from the server
 * 
 * @return boolean
 */
	public function isPing(&$data) {
		if(strstr($data, 'PING') === false) {
			return false;
		}

		list(, $ping) = $this->getParams(':', $data, 2);
		if(!empty($ping)) {
			$this->write('PONG :ping', array(
				'ping' => $ping
			));
		}
		return array(
			'irc_command' => 'PING',
			'raw' => $data
		);
	}

}
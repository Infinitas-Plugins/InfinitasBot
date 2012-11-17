<?php
/**
 * IrcShell
 *
 * @package InfinitasBot.Console
 */

App::uses('IrcLib', 'InfinitasBot.Lib');
Configure::write('debug', 2);

/**
 * IrcShell
 */
class IrcShell extends AppShell {
	public function main() {

	}

	public function run() {
		$this->Irc = new IrcLib();
		$this->Irc->outputHandler(array($this, 'out'));
		$this->Irc->watch();
	}
	
}
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

	public function onIrcMessage(Event $Event, $data = null) {
		ClassRegistry::init('InfinitasBot.InfinitasBotLog')->logChat($data);
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
		// @todo clear lock
	}

	public function onIrcJoin(Event $Event, $data = null) {
		// @todo check and create lock
	}

}
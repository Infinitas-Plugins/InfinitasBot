<?php
App::uses('InfinitasBotLog', 'InfinitasBot.Model');

/**
 * InfinitasBotLog Test Case
 *
 */
class InfinitasBotLogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.infinitas_bot.infinitas_bot_log',
		'plugin.infinitas_bot.infinitas_bot_user',
		'plugin.infinitas_bot.infinitas_bot_channel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InfinitasBotLog = ClassRegistry::init('InfinitasBot.InfinitasBotLog');
		$this->modelClass = $this->InfinitasBotLog->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InfinitasBotLog);

		parent::tearDown();
	}

	public function testLogChat() {
		$result = $this->{$this->modelClass}->find('count');
		$this->assertEquals($result, 1);

		$result = $this->{$this->modelClass}->logChat(array(
			'infinitas_bot_user_id' => 'bob',
			'infinitas_bot_channel_id' => 'bob-channel',
			'message' => 'foobar'
		));

		$result = $this->{$this->modelClass}->find('count');
		$this->assertEquals($result, 2);

		$result = $this->{$this->modelClass}->logChat(array(
			'infinitas_bot_user_id' => 'sam',
			'infinitas_bot_channel_id' => 'bob-channel',
			'message' => 'foobar'
		));

		$result = $this->{$this->modelClass}->find('count');
		$this->assertEquals($result, 2);

		$result = $this->{$this->modelClass}->logChat(array(
			'infinitas_bot_user_id' => 'bob',
			'infinitas_bot_channel_id' => 'fake',
			'message' => 'foobar'
		));

		$result = $this->{$this->modelClass}->find('count');
		$this->assertEquals($result, 2);
	}

}

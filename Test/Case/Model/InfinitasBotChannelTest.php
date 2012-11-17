<?php
App::uses('InfinitasBotChannel', 'InfinitasBot.Model');

/**
 * InfinitasBotChannel Test Case
 *
 */
class InfinitasBotChannelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.infinitas_bot.infinitas_bot_channel',
		'plugin.infinitas_bot.infinitas_bot_log'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InfinitasBotChannel = ClassRegistry::init('InfinitasBot.InfinitasBotChannel');
		$this->modelClass = $this->InfinitasBotChannel->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InfinitasBotChannel);

		parent::tearDown();
	}

	public function testFindChannelId() {
		$result = $this->{$this->modelClass}->find('channelId', array(
			'channel' => 'bob-channel'
		));
		$this->assertEquals($result, 'bob-channel');

		$this->assertFalse($this->{$this->modelClass}->find('channelId'));
		$this->assertFalse($this->{$this->modelClass}->find('channelId', array(
			'channel' => 'foobar'
		)));
	}

}

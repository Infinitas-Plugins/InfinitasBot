<?php
App::uses('InfinitasBotTell', 'InfinitasBot.Model');

/**
 * InfinitasBotTell Test Case
 *
 */
class InfinitasBotTellTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.infinitas_bot.infinitas_bot_tell',
		'plugin.infinitas_bot.infinitas_bot_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InfinitasBotTell = ClassRegistry::init('InfinitasBot.InfinitasBotTell');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InfinitasBotTell);

		parent::tearDown();
	}

/**
 * testGetViewData method
 *
 * @return void
 */
	public function testGetViewData() {
	}

}

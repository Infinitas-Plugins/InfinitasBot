<?php
App::uses('InfinitasBotUser', 'InfinitasBot.Model');

/**
 * InfinitasBotUser Test Case
 *
 */
class InfinitasBotUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.infinitas_bot.infinitas_bot_user',
		'plugin.infinitas_bot.infinitas_bot_log'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InfinitasBotUser = ClassRegistry::init('InfinitasBot.InfinitasBotUser');
		$this->modelClass = $this->InfinitasBotUser->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InfinitasBotUser);

		parent::tearDown();
	}

/**
 * test create user
 *
 * @return void
 */
	public function testCreateUser() {
		$result = $this->{$this->modelClass}->createUser('bob');
		$this->assertEquals($result, 'bob');

		$result = $this->{$this->modelClass}->createUser('sam');
		$this->assertTrue(strlen($result) == 36);

		$result = $this->{$this->modelClass}->createUser('jane');
		$this->assertTrue(strlen($result) == 36);

		$result = $this->{$this->modelClass}->find('count');
		$this->assertEquals($result, 3);
	}

	public function testFindUserId() {
		$result = $this->{$this->modelClass}->find('userId', array(
			'username' => 'bob'
		));
		$this->assertEquals($result, 'bob');

		$this->assertFalse($this->{$this->modelClass}->find('userId'));
		$this->assertFalse($this->{$this->modelClass}->find('userId', array(
			'username' => 'madeup'
		)));
	}

	public function testUpdateLastSeen() {
		$result = $this->{$this->modelClass}->field('last_seen', array(
			$this->modelClass . '.username' => 'bob'
		));
		$this->assertEquals($result, '2012-11-16 17:11:48');

		$this->{$this->modelClass}->updateSeen('bob');

		$result = $this->{$this->modelClass}->field('last_seen', array(
			$this->modelClass . '.username' => 'bob'
		));
		$this->assertEquals($result, date('Y-m-d H:i:s'));
	}

}

<?php
/**
 * @brief fixture file for InfinitasBotUser tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class InfinitasBotUserFixture extends CakeTestFixture {
	public $name = 'InfinitasBotUser';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'last_seen' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'bob',
			'username' => 'bob',
			'last_seen' => '2012-11-16 17:11:48',
			'created' => '2012-11-16 17:11:48',
			'modified' => '2012-11-16 17:11:48'
		),
	);
}
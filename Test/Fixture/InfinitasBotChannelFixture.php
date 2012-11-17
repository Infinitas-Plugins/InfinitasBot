<?php
/**
 * @brief fixture file for InfinitasBotChannel tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class InfinitasBotChannelFixture extends CakeTestFixture {
	public $name = 'InfinitasBotChannel';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'bob-channel',
			'name' => 'bob-channel',
			'created' => '2012-11-16 17:10:48',
			'modified' => '2012-11-16 17:10:48'
		),
	);
}
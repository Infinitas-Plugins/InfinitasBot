<?php
	/**
	 * Infinitas Releas
	 *
	 * Auto generated database update
	 */
	 
	class R50a6f01b3c9c44509e6032eb6318cd70 extends CakeRelease {

	/**
	* Migration description
	*
	* @var string
	* @access public
	*/
		public $description = 'Migration for InfinitasBot version 0.1.1';

	/**
	* Plugin name
	*
	* @var string
	* @access public
	*/
		public $plugin = 'InfinitasBot';

	/**
	* Actions to be performed
	*
	* @var array $migration
	* @access public
	*/
		public $migration = array(
			'up' => array(
			'create_table' => array(
				'infinitas_bot_channels' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'infinitas_bot_logs' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'infinitas_bot_user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'infinitas_bot_channel_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'message' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'infinitas_bot_tells' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'infinitas_bot_user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'infinitas_bot_users' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'last_seen' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'infinitas_bot_channels', 'infinitas_bot_logs', 'infinitas_bot_tells', 'infinitas_bot_users'
			),
		),
		);

	
	/**
	* Before migration callback
	*
	* @param string $direction, up or down direction of migration process
	* @return boolean Should process continue
	* @access public
	*/
		public function before($direction) {
			return true;
		}

	/**
	* After migration callback
	*
	* @param string $direction, up or down direction of migration process
	* @return boolean Should process continue
	* @access public
	*/
		public function after($direction) {
			return true;
		}
	}
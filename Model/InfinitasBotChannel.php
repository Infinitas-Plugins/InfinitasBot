<?php
/**
 * InfinitasBotChannel model
 *
 * @brief Add some documentation for InfinitasBotChannel model.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/InfinitasBot
 * @package	   InfinitasBot.Model
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class InfinitasBotChannel extends InfinitasBotAppModel {

	public $findMethods = array(
		'channelId' => true
	);

/**
 * hasMany relations for this model
 *
 * @access public
 * @var array
 */
	public $hasMany = array(
		'InfinitasBotLog' => array(
			'className' => 'InfinitasBotLog',
			'foreignKey' => 'infinitas_bot_channel_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * overload the construct method so that you can use translated validation
 * messages.
 *
 * @access public
 *
 * @param mixed $id string uuid or id
 * @param string $table the table that the model is for
 * @param string $ds the datasource being used
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
	}

/**
 * Get a channel id
 * 
 * @param string $state [description]
 * @param array $query [description]
 * @param array $results [description]
 * 
 * @return string|boolean
 */
	protected function _findChannelId($state, $query, $results = array()) {
		if($state == 'before') {
			if(empty($query['channel'])) {
				$query['channel'] = null;
			}

			$query['fields'] = array(
				$this->alias . '.' . $this->primaryKey
			);

			$query['conditions'] = array(
				$this->alias . '.name' => $query['channel']
			);

			$query['limit'] = 1;
			return $query;
		}

		if(empty($results[0][$this->alias]['id'])) {
			return false;
		}

		return $results[0][$this->alias]['id'];
	}

}
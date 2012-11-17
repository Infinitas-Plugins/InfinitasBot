<?php
/**
 * InfinitasBotTell model
 *
 * @brief Add some documentation for InfinitasBotTell model.
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

class InfinitasBotTell extends InfinitasBotAppModel {
/**
 * Custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'tell' => true
	);

/**
 * belongsTo relations for this model
 *
 * @access public
 * @var array
 */
	public $belongsTo = array(
		'InfinitasBotUser' => array(
			'className' => 'InfinitasBot.InfinitasBotUser',
			'foreignKey' => 'infinitas_bot_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
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
			'description' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'infinitas_bot_user_id' => array(
				'uuid' => array(
					'rule' => array('uuid'),
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
 * Find a tell
 *
 * @param string $state [description]
 * @param array $query [description]
 * @param array $results [description]
 *
 * @return boolean|string
 */
	protected function _findTell($state, $query, $results = array()) {
		if($state == 'before') {
			if(empty($query[0])) {
				$query[0] = null;
			}

			$query['fields'] = array(
				$this->alias . '.description'
			);

			$query['conditions'] = array(
				$this->alias . '.' . $this->displayField => $query[0]
			);
			$query['limit'] = 1;
			return $query;
		}

		if(empty($results[0][$this->alias]['description'])) {
			return false;
		}

		return $results[0][$this->alias]['description'];
	}

}
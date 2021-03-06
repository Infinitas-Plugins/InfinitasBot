<?php
/**
 * InfinitasBotUser model
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/InfinitasBot
 * @package InfinitasBot.Model
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class InfinitasBotUser extends InfinitasBotAppModel {
/**
 * The display field for select boxes
 *
 * @var string
 */
	public $displayField = 'username';

	public $findMethods = array(
		'userId' => true
	);

/**
 * hasMany relations
 *
 * @var array
 */
	public $hasMany = array(
		'InfinitasBotLog' => array(
			'className' => 'InfinitasBot.InfinitasBotLog',
			'foreignKey' => 'infinitas_bot_user_id',
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
 * Constructor
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
			'username' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
				),
				'isUnique' => array(
					'rule' => 'isUnique'
				)
			),
			'last_seen' => array(
				'datetime' => array(
					'rule' => array('datetime'),
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
 * Save a new user record
 *
 * @param string $username
 *
 * @return string
 */
	public function createUser($username) {
		$this->create();
		$saved = $this->save(array(
			'username' => $username,
			'last_seen' => date('Y-m-d H:i:s')
		));
		if(!$saved) {
			return $this->find('userId', array(
				'username' => $username
			));
		}
		return $this->id;
	}

/**
 * Update the last seen time
 *
 * @param string $username the username or id of the user being updated
 *
 * @return boolean
 */
	public function updateSeen($username) {
		return $this->updateAll(
			array($this->alias . '.last_seen' => '\'' . date('Y-m-d H:i:s') . '\''),
			array('or' => array(
				$this->alias . '.username' => $username,
				$this->alias . '.' . $this->primaryKey => $username,
			))
		);
	}

/**
 * Get a users id
 *
 * @param string $state [description]
 * @param array $query [description]
 * @param array $results [description]
 *
 * @return string|boolean
 */
	protected function _findUserId($state, $query, $results = array()) {
		if($state == 'before') {
			if(empty($query['username'])) {
				$query['username'] = null;
			}

			$query['fields'] = array(
				$this->alias . '.' . $this->primaryKey
			);

			$query['conditions'] = array(
				$this->alias . '.username' => $query['username']
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
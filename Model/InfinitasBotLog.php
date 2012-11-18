<?php
/**
 * InfinitasBotLog model
 *
 * @brief Add some documentation for InfinitasBotLog model.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/InfinitasBot
 * @package	   InfinitasBot.Model
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class InfinitasBotLog extends InfinitasBotAppModel {
/**
 * Custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'paginated' => true,
		'directLink' => true
	);

/**
 * belongsTo relations
 *
 * @var array
 */
	public $belongsTo = array(
		'InfinitasBotUser' => array(
			'className' => 'InfinitasBot.InfinitasBotUser',
			'foreignKey' => 'infinitas_bot_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'InfinitasBotChannel' => array(
			'className' => 'InfinitasBot.InfinitasBotChannel',
			'foreignKey' => 'infinitas_bot_channel_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
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

		$this->order = array(
			$this->alias . '.created' => 'desc'
		);

		$this->validate = array(
			'infinitas_bot_user_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'infinitas_bot_channel_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'message' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
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
 * Log a message
 *
 * @param array $data the parsed message
 *
 * @return boolean
 */
	public function logChat($data) {
		if(empty($data['infinitas_bot_user_id'])) {
			$data['infinitas_bot_user_id'] = $this->InfinitasBotUser->createUser($data['user']);
		}

		$this->create();
		return (bool)$this->save(array(
			'infinitas_bot_user_id' => $data['infinitas_bot_user_id'],
			'infinitas_bot_channel_id' => $data['infinitas_bot_channel_id'],
			'message' => trim($data['message'])
		));
	}

/**
 * Get paginated logs with related user data
 *
 * @param type $state
 * @param type $query
 * @param type $results
 *
 * @return array
 */
	protected function _findPaginated($state, $query, $results = array()) {
		if($state == 'before') {
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.message',
				$this->alias . '.created',

				$this->InfinitasBotUser->alias . '.' . $this->InfinitasBotUser->primaryKey,
				$this->InfinitasBotUser->alias . '.' . $this->InfinitasBotUser->displayField
			));

			$query['joins'][] = $this->autoJoinModel($this->InfinitasBotUser->fullModelName());
			return $query;
		}

		return $results;
	}

/**
 * Get the data for sharing a link
 *
 * @param type $state
 * @param type $query
 * @param type $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findDirectLink($state, $query, $results = array()) {
		if($state == 'before') {
			if(empty($query[0])) {
				throw new InvalidArgumentException(__d('infinitas_bot', 'Message could not be found'));
			}
			$countBefore = $this->find('count', array(
				'conditions' => array(
					$this->alias . '.created > LogJoin.created'
				),
				'joins' => array(
					$this->autoJoinModel(array(
						'model' => $this->fullModelName(),
						'alias' => 'LogJoin',
						'conditions' => array(
							$this->alias . '.' . $this->primaryKey . ' = LogJoin.' . $this->primaryKey,
							'LogJoin.' . $this->primaryKey => $query[0]
						)
					))
				)
			));

			if($query['limit']) {
				$query['page'] = round($countBefore / $query['limit']) + 1;
			}

			return self::_findPaginated($state, $query);
		}

		return self::_findPaginated($state, $query, $results);
	}

}

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
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class InfinitasBotLog extends InfinitasBotAppModel {
/**
 * Additional behaviours that are attached to this model
 *
 * @access public
 * @var array
 */
	public $actsAs = array(
		// 'Libs.Feedable',
		// 'Libs.Rateable'
	);

/**
 * How the default ordering on this model is done
 *
 * @access public
 * @var array
 */
	public $order = array(
	);

/**
 * hasOne relations for this model
 *
 * @access public
 * @var array
 */
	public $hasOne = array(
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
 * hasMany relations for this model
 *
 * @access public
 * @var array
 */
	public $hasMany = array(
	);

/**
 * hasAndBelongsToMany relations for this model
 *
 * @access public
 * @var array
 */
	public $hasAndBelongsToMany = array(
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

	public function logChat($data) {
		if(empty($data['infinitas_bot_user_id'])) {
			$data['infinitas_bot_user_id'] = $this->InfinitasBotUser->createUser($data['user']);
		}
		$this->create();
		return $this->save(array(
			'infinitas_bot_user_id' => $data['infinitas_bot_user_id'],
			'infinitas_bot_channel_id' => $data['infinitas_bot_channel_id'],
			'message' => $data['message']
		));
	}

}

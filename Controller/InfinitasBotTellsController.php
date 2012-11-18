<?php
/**
 * InfinitasBotTellsController
 *
 * @package	   InfinitasBot.Controller
 */

/**
 * InfinitasBotTellsController
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/InfinitasBot
 * @package	   InfinitasBot.Controller
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class InfinitasBotTellsController extends InfinitasBotAppController {
/**
 * Show a paginated list of InfinitasBotTell records.
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'InfinitasBotUser',
			)
		);

		$infinitasBotTells = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('infinitasBotTells', 'filterOptions'));
	}

	public function add() {
		$this->notice('invalid');
	}

	public function edit() {
		$this->notice('invalid');
	}

/**
 * @brief the index method
 *
 * Show a paginated list of InfinitasBotTell records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'InfinitasBotUser',
			)
		);

		$infinitasBotTells = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('infinitasBotTells', 'filterOptions'));
	}

/**
 * Adding new InfinitasBotTell records.
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$infinitasBotUsers = $this->InfinitasBotTell->InfinitasBotUser->find('list');
		$this->set(compact('infinitasBotUsers'));
	}

/**
 * Edit old InfinitasBotTell records.
 *
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$infinitasBotUsers = $this->InfinitasBotTell->InfinitasBotUser->find('list');
		$this->set(compact('infinitasBotUsers'));
	}

}
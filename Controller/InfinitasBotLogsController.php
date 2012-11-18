<?php
/**
 * InfinitasBotLogsController
 *
 * @package InfinitasBot.Controller
 */

/**
 * InfinitasBotLogsController
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/InfinitasBot
 * @package InfinitasBot.Controller
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class InfinitasBotLogsController extends InfinitasBotAppController {
/**
 * Show a paginated list of InfinitasBotLog records.
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'paginated'
		);
		$this->_logs();
	}

/**
 * Direct link to message
 *
 * @param string $id the message id to link to
 */
	public function link($id = null) {
		$this->Paginator->settings = array(
			'directLink',
			$id
		);
		try {
			$this->_logs();
		} catch(Exception $e) {
			$this->notice($e);
		}

		$this->render('index');
	}

/**
 * Shared for index and link
 *
 * @return void
 */
	protected function _logs() {
		$infinitasBotLogs = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$this->set(compact('infinitasBotLogs', 'filterOptions'));
	}

/**
 * Disable add
 *
 * @return void
 */
	public function add() {
		$this->notice('invalid');
	}

/**
 * Disable edit
 *
 * @return void
 */
	public function edit() {
		$this->notice('invalid');
	}

/**
 * Show a paginated list of InfinitasBotLog records.
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'paginated'
		);

		$infinitasBotLogs = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$this->set(compact('infinitasBotLogs', 'filterOptions'));
	}

/**
 * Adding new InfinitasBotLog records.
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$infinitasBotUsers = $this->InfinitasBotLog->InfinitasBotUser->find('list');
		$infinitasBotChannels = $this->InfinitasBotLog->InfinitasBotChannel->find('list');
		$this->set(compact('infinitasBotUsers', 'infinitasBotChannels'));
	}

/**
 * Edit existing InfinitasBotLog records.
 *
 * @param string $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$infinitasBotUsers = $this->InfinitasBotLog->InfinitasBotUser->find('list');
		$infinitasBotChannels = $this->InfinitasBotLog->InfinitasBotChannel->find('list');
		$this->set(compact('infinitasBotUsers', 'infinitasBotChannels'));
	}

}
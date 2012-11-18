<?php
	/**
	 * @brief Add some documentation for this admin_add form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/InfinitasBot
	 * @package	InfinitasBot.views.admin_add
	 * @license	http://infinitas-cms.org/mit-license The MIT License
	 * @since   0.9b1
	 *
	 * @author dogmatic69
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */
	echo $this->Form->create(null, array(
		'inputDefaults' => array(
			'empty' => Configure::read('Website.empty_select')
		)
	));
		echo $this->Infinitas->adminEditHead();
		echo $this->Form->input('id');
		$tabs = array(
			__d('infinitas_bot', 'Tell')
		);
		$contents = array(
			implode('', array(
				$this->Form->input('name', array(
					'label' => __d('infinitas_bot', 'Tell')
				)),
				$this->Form->input('description', array(
					'type' => 'text',
					'label' => __d('infinitas_bot', 'Return')
				)),
				$this->Form->input('infinitas_bot_user_id', array(
					'label' => __d('infinitas_bot', 'User')
				))
			))
		);
		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();

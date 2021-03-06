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
	echo $this->Form->create();
		echo $this->Infinitas->adminEditHead(); ?>
		<fieldset>
			<h1><?php echo __('Infinitas bot logs'); ?></h1><?php
				echo $this->Form->input('id');
				echo $this->Infinitas->wysiwyg('InfinitasBotLog.message');
			?>
		</fieldset>

		<fieldset>
			<h1><?php echo __('Configuration'); ?></h1><?php
				echo $this->Form->input('infinitas_bot_user_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('infinitas_bot_channel_id', array('empty' => Configure::read('Website.empty_select')));
		?>
		</fieldset><?php
	echo $this->Form->end();

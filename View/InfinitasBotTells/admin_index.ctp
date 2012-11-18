<?php
/**
 * @brief Add some documentation for this admin_index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/InfinitasBot
 * @package	   InfinitasBot.View.admin_index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
echo $this->Form->create(null, array('action' => 'mass'));
echo $this->Infinitas->adminIndexHead($filterOptions, array(
	'add',
	'edit',
	'copy',
	'delete',
));
echo $this->Filter->alphabetFilter();
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					$this->Form->checkbox('all') => array(
						'class' => 'first',
						'style' => 'width: 25px;'
					),
					$this->Paginator->sort('InfinitasBotUser.username', __d('infinitas_bot', 'User')) => array(
						'style' => 'width: 125px;'
					),
					$this->Paginator->sort('name', __d('infinitas_bot', 'Tell')) => array(
						'style' => 'width: 125px;'
					),
					$this->Paginator->sort('description', __d('infinitas_bot', 'Return')),
					$this->Paginator->sort('modified') => array(
						'style' => 'width: 100px;'
					),
				)
			);

			foreach ($infinitasBotTells as $infinitasBotTell) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($infinitasBotTell); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($infinitasBotTell['InfinitasBotUser']['username'], array('controller' => 'infinitas_bot_users', 'action' => 'view', $infinitasBotTell['InfinitasBotUser']['id'])); ?>
					</td>
					<td><?php echo $this->Html->adminQuickLink($infinitasBotTell['InfinitasBotTell']); ?>&nbsp;</td>
					<td><?php echo h($infinitasBotTell['InfinitasBotTell']['description']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($infinitasBotTell['InfinitasBotTell']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>
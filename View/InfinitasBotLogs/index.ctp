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
 */
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					'#' => array(
						'style' => 'width: 15px;'
					),
					$this->Paginator->sort('created', __d('infinitas_bot', 'At')) => array(
						'style' => 'width: 120px;'
					),
					$this->Paginator->sort('InfinitasBotUser.id', __d('infinitas_bot', 'User')) => array(
						'style' => 'width: 100px;'
					),
					__d('infinitas_bot', 'Message') => array(
						'class' => 'message'
					),
				),
				false
			);

			foreach ($infinitasBotLogs as $infinitasBotLog) {
				$class = array(
					$this->Infinitas->rowClass()
				);
				if(in_array($infinitasBotLog['InfinitasBotLog']['id'], $this->request->params['pass'])) {
					$class[] = 'highlight';
				} ?>
				<tr class="<?php echo implode(' ', $class); ?>">
					<td>
						<?php
							echo $this->Html->link('#', array(
								'action' => 'link',
								$infinitasBotLog['InfinitasBotLog']['id']
							));
						?>&nbsp;
					</td>
					<td><?php echo CakeTime::niceShort($infinitasBotLog['InfinitasBotLog']['created']); ?>&nbsp;</td>
					<td>
						<?php
							echo $this->Html->link($infinitasBotLog['InfinitasBotUser']['username'], array(
								'controller' => 'infinitas_bot_users',
								'action' => 'view',
								$infinitasBotLog['InfinitasBotUser']['id']
							));
						?>&nbsp;
					</td>
					<td class="message">
						<?php
							echo $this->Text->autoLinkUrls(h($infinitasBotLog['InfinitasBotLog']['message']), array(
								'rel' => 'nofollow'
							));
						?>&nbsp;
					</td>
				</tr><?php
			}
		?>
	</table>
</div>
<?php echo $this->element('pagination/navigation'); ?>
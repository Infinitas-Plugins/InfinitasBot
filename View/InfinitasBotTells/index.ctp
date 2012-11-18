<?php
/**
 * List tells
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/InfinitasBot
 * @package InfinitasBot.View.index
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(array(
				$this->Paginator->sort('name', __d('infinitas_bot', 'Tell')) => array(
					'style' => 'width: 125px;'
				),
				$this->Paginator->sort('description'),
				$this->Paginator->sort('modified') => array(
					'style' => 'width:75px;'
				),
			), false);

			foreach ($infinitasBotTells as $infinitasBotTell) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><strong><?php echo $infinitasBotTell['InfinitasBotTell']['name']; ?></strong>&nbsp;</td>
					<td>
						<?php
							echo $this->Text->autoLinkUrls(h($infinitasBotTell['InfinitasBotTell']['description']), array(
								'rel' => 'nofollow'
							));
						?>&nbsp;
					</td>
					<td><?php echo CakeTime::niceShort($infinitasBotTell['InfinitasBotTell']['modified']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
</div>
<?php

/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */

defined('_JEXEC') or die();

?>
<?php if (count ($oRows) > 0 ) { ?>
<div class="cWindowNotification forGroup-Request">
	<p class="cWindowSubject">
		<b><?php echo JText::_('COM_COMMUNITY_GROUPS_NEW_INVITATION'); ?></b>
	</p>

	<ul class="cWindowStream forGroup-Request cResetList">
	<?php foreach ( $oRows as $row ) : ?>
	<li id="noti-request-group-<?php echo $row->id; ?>">
		<a href="<?php echo $row->url; ?>" class="cStream-Avatar cFloat-L">
			<img src="<?php echo $row->groupAvatar; ?>" class="cAvatar" alt="<?php echo $this->escape($row->name); ?>"/>
		</a>
		<div class="cStream-Content">
			<div class="cStream-Headline" id="msg-request-<?php echo $row->id; ?>">
				<?php echo JText::sprintf('COM_COMMUNITY_GROUPS_REQUESTED_NOTIFICATION' , $row->name ,  $row->groupName); ?>		
			</div>

			<div class="cStream-Actions" id="noti-answer-group-<?php echo $row->id; ?>">
				<a href="javascript:void(0);" onclick="joms.jQuery('#noti-answer-group-<?php echo $row->id; ?>').remove(); jax.call('community' , 'notification,ajaxGroupJoinRequest' , '<?php echo $row->id ?>' , '<?php echo $row->groupId; ?>');">
					<?php echo JText::_('COM_COMMUNITY_PENDING_ACTION_APPROVE'); ?>
				</a>

				<b>&middot;</b>

				<a href="javascript:void(0);" onclick="joms.jQuery('#noti-answer-group-<?php echo $row->id; ?>').remove(); jax.call('community','notification,ajaxGroupRejectRequest', '<?php echo $row->id ?>' , '<?php echo $row->groupId; ?>');">
					<?php echo JText::_('COM_COMMUNITY_FRIENDS_PENDING_ACTION_REJECT'); ?>
				</a>

				<b>&middot;</b>

				<a style="text-indent: 0;" href="<?php echo CUrlHelper::groupLink($row->groupId); ?>" >
					<?php echo JText::_('COM_COMMUNITY_EVENTS_GO'); ?>
				</a>
			</div>

			<div class="cStream-Error" id="error-request-<?php echo $row->id; ?>"></div>
		</div>
	</li>
	<?php endforeach; ?>
	</ul>
</div>
<?php }//end if ?>
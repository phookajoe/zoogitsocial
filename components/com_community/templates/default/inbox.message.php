<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
?>

<div class="cInbox-Stream<?php if(isset($isMine) && $isMine) echo ' Mine'?> clearfix" id="message-<?php echo $msg->id; ?>" >
	<a href="<?php echo $authorLink;?>" class="cMessage-Avatar cFloat-L">
		<img src="<?php echo $user->getThumbAvatar(); ?>" alt="<?php echo $user->getDisplayName(); ?>" width="48" class="cAvatar" />
	</a>

	<div class="cMessage-Body">
		<a class="cButton cButton-Small cFloat-R" href="javascript:jax.call('community', 'inbox,ajaxRemoveMessage', <?php echo $msg->id; ?>);" title="<?php echo JText::_('COM_COMMUNITY_INBOX_REMOVE_MESSAGE'); ?>">
			<?php echo JText::_('COM_COMMUNITY_INBOX_REMOVE_MESSAGE'); ?>
		</a>
		<b class="cMessage-Author">
			<a href="<?php echo $authorLink;?>"><?php echo $user->getDisplayName(); ?></a>
		</b>
		<br />
		<small class="cMessage-Time">
		<?php
			$postdate =  CTimeHelper::getDate($msg->posted_on);
			echo $postdate->format( JText::_('DATE_FORMAT_LC2') );
		?>
		</small>

		<div class="cMessage-Content">
			<?php echo $msg->body; ?>
		</div>
	</div>
</div>

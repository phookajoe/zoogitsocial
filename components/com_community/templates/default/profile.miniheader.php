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
<div class="cToolBox cProfile-ToolBox clearfix">
	<a class="cToolBox-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$user->id); ?>">
		<img src="<?php echo $user->getThumbAvatar(); ?>" alt="<?php echo $user->getDisplayName(); ?>" class="cAvatar" />
	</a>
	<b class="cToolBox-Name"><?php echo $user->getDisplayName(); ?></b>
	<div class="small">
		<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$user->id); ?>">
			<?php echo JText::_('COM_COMMUNITY_GO_TO_PROFILE'); ?>
		</a>
	</div>

	<ul class="cToolBox-Options cFloatedList cResetList cFloat-R">
		<?php if(!$isFriend && !$isMine) { ?>
		<li>
			<a href="javascript:void(0)" onclick="joms.friends.connect('<?php echo $user->id;?>')">
				<i class="com-icon-user-plus"></i>
				<span><?php echo JText::_('COM_COMMUNITY_PROFILE_ADD_AS_FRIEND'); ?></span>
			</a>
		</li>
		<?php } ?>

		<?php if($config->get('enablephotos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=myphotos&userid='.$user->id); ?>">
				<i class="com-icon-photos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_PHOTOS'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if($config->get('enablevideos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos&task=myvideos&userid='.$user->id); ?>">
				<i class="com-icon-videos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_VIDEOS_GALLERY'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if( !$isMine && $config->get('enablepm') ): ?>
		<li>
			<a onclick="<?php echo $sendMsg; ?>" href="javascript:void(0);">
				<i class="com-icon-mail-go"></i>
				<span><?php echo JText::_('COM_COMMUNITY_INBOX_SEND_MESSAGE'); ?></span>
			</a>
		</li>
		<?php endif; ?>
	</ul>

</div>
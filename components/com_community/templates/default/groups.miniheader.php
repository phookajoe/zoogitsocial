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
<div class="cToolBox cGroups-ToolBox clearfix">
	<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$group->id); ?>" class="cToolBox-Avatar cFloat-L">
		<img src="<?php echo $group->getThumbAvatar(); ?>" alt="<?php echo $this->escape($group->name); ?>" class="cAvatar cAvatar-Small" />
	</a>
	<b class="cToolBox-Name"><?php echo $this->escape($group->name); ?></b>
	<div class="small">
		<a class="cToolBox-LinkBack" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$group->id); ?>">
			<?php echo JText::_('COM_COMMUNITY_GROUPS_BACK_BUTTON'); ?>
		</a>
	</div>
	<ul class="cToolBox-Options cFloatedList cResetList cFloat-R">
		<?php if($allowCreateEvent && $config->get('group_events') && $config->get('enableevents') && ($config->get('createevents'))): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&groupid='.$group->id); ?>">
				<i class="com-icon-events"></i>
				<span><?php echo JText::_('COM_COMMUNITY_EVENTS'); ?></span>
			</a>
		</li>
		<?php endif; ?>
		
		<?php if($allowManagePhotos  && $config->get('groupphotos') && $config->get('enablephotos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&groupid='.$group->id); ?>">
				<i class="com-icon-photos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_PHOTOS'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if($allowManageVideos && $config->get('groupvideos') && $config->get('enablevideos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos&groupid='.$group->id); ?>">
				<i class="com-icon-videos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_VIDEOS_GALLERY'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if($config->get('creatediscussion')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussions&groupid='.$group->id); ?>">
				<i class="com-icon-comment"></i>
				<span><?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewmembers&groupid='.$group->id); ?>">
				<i class="com-icon-groups"></i>
				<span><?php echo JText::_('COM_COMMUNITY_GROUPS_MEMBERS'); ?></span>
			</a>
		</li>
	</ul>
</div>

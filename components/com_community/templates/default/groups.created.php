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
<div class="cLayout cGroups-Created">
	<p><?php echo JText::_('COM_COMMUNITY_GROUPS_CREATE_SUCCESS');?></p>

	<ul class="cPageOptions cResetList">
		<li>
			<i class="com-icon-avatar"></i>
			<a href="<?php echo $linkUpload; ?>">
				<?php echo JText::_('COM_COMMUNITY_GROUPS_UPLOAD_AVATAR');?>
			</a>
		</li>
		<li>
			<i class="com-icon-bell-plus"></i>
			<a href="<?php echo $linkBulletin; ?>">
				<?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_CREATE');?>
			</a>
		</li>
		<li>
			<i class="com-icon-comment-plus"></i>
			<a href="<?php echo $linkDiscussion; ?>">
				<?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION_CREATE');?>
			</a>
		</li>
		<li>
			<i class="com-icon-groups-edit"></i>
			<a href="<?php echo $linkEdit;?>">
				<?php echo JText::_('COM_COMMUNITY_GROUPS_EDIT_DESC');?>
			</a>
		</li>
		<li>
			<i class="com-icon-groups"></i>
			<a href="<?php echo $link; ?>">
				<?php echo JText::_('COM_COMMUNITY_GROUPS_GOTO');?>
			</a>
		</li>
	</ul>
</div>
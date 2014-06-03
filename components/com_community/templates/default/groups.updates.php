<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 */
defined('_JEXEC') or die();

if($userid!=0) 
{
?>
<div class="cLayout cGroups-Updates">

	<?php if(sizeof($this->view('groups')->modGetUserGroups($userid))>0) { ?>

	<div class="cSidebar">
		<?php echo $this->view('groups')->modUserGroups($userid); ?>
		<?php echo $this->view('groups')->modUserGroupPending($userid); ?>
		<?php echo $this->view('groups')->modUserGroupUpcomingEvents($userid); ?>
		<?php echo $this->view('groups')->modUserGroupVideosUpdate($userid); ?>
		<?php echo $this->view('groups')->modUserAlbumsUpdate($userid); ?>
	</div>

	<div class="cMain">
		<?php
		$groupupdate = array_merge($this->view('groups')->modGetUserAnnouncement($userid),$this->view('groups')->modGetUserParticipatedDiscussion($userid));
		
		if(sizeof($groupupdate)>0) {
		?>
		<?php echo $this->view('groups')->modUserParticipatedDiscussion($userid); ?>
		<?php echo $this->view('groups')->modUserAnnouncement($userid); ?>
		<?php } elseif(!empty($my->_groups)) { ?>
		<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_GROUP_NO_UPDATE'); ?></div>
		<?php }else {?>
		<div class="cEmpty cAlert"><?php echo JText::sprintf( 'COM_COMMUNITY_GROUPS_UPDATE_DEFAULT' , CRoute::_('index.php?option=com_community&view=groups') ); ?></div>
		<?php } ?>
	</div>
	<?php } elseif(!empty($my->_groups)) { ?>
	<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_GROUP_NO_UPDATE'); ?></div>
	<?php }else {?>
	<div class="cEmpty cAlert"><?php echo JText::sprintf( 'COM_COMMUNITY_GROUPS_UPDATE_DEFAULT' , CRoute::_('index.php?option=com_community&view=groups') ); ?></div>
	
   <?php } ?>
</div>
<?php 
} 
else 
{ 
?>
<div class="cEmpty cAlert"><?php echo JText::sprintf( 'COM_COMMUNITY_GROUPS_UPDATE_NOT_LOGGED_IN' , CRoute::_( 'index.php?option=com_community&view=frontpage' ), CRoute::_( 'index.php?option=com_community&view=register' )) ?></div>
<?php 
} 
?>

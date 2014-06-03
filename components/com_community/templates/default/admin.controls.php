<?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
if( $isCommunityAdmin)
{
?>
<ul class="cPageAdmin cResetList cFloatedList clearfix">
	<li>
	<?php if( !$blocked ) { ?>
		<a href="javascript:void(0);" onclick="joms.users.banUser('<?php echo $userid; ?>', '0' );"><?php echo JText::_('COM_COMMUNITY_BAN_USER');?></a>
	<?php } else { ?>
		<a href="javascript:void(0);" onclick="joms.users.banUser('<?php echo $userid; ?>' , '1');"><?php echo JText::_('COM_COMMUNITY_UNBAN_USER');?></a>
	<?php } ?>
	</li>

<?php 
if( $showFeatured ){ 
	if( !$isFeatured ) { ?>
		<li><a onclick="joms.featured.add('<?php echo $userid;?>','search');" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_MAKE_FEATURED'); ?></a></li>
	<?php } else { ?>
		<li><a onclick="joms.featured.remove('<?php echo $userid;?>','search');" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_REMOVE_FEATURED'); ?></a></li>
	<?php }
} ?>

	<li><a href="javascript:void(0);" onclick="joms.users.uploadNewPicture('<?php echo $userid;?>');"><?php echo JText::_('COM_COMMUNITY_PROFILE_AVATAR_EDIT');?></a></li>

<?php if( $jConfig->get('sef') ){ ?>
	<li><a href="javascript:void(0);" onclick="joms.users.updateURL('<?php echo $userid;?>');"><?php echo JText::_('COM_COMMUNITY_PROFILE_CHANGE_ALIAS');?></a></li>
<?php } ?>

<?php if( !$isDefaultPhoto ) { ?>
	<li><a href="javascript:void(0);" onclick="joms.users.removePicture('<?php echo $userid;?>');"><?php echo JText::_('COM_COMMUNITY_REMOVE_PROFILE_PICTURE');?></a></li>
<?php } ?>

<?php if($videoid) { ?>
	<li><a href="javascript:void(0);" onclick="joms.videos.removeConfirmProfileVideo('<?php echo $userid;?>', '<?php echo $videoid;?>');"><?php echo JText::_('COM_COMMUNITY_VIDEOS_REMOVE_PROFILE_VIDEO');?></a></li>
<?php } ?>
</ul>
<?php
}
?>
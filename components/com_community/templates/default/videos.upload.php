<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
?>


<form name="uploadVideo" id="uploadVideo" class="cForm" method="post" action="<?php echo CRoute::_('index.php?option=com_community&view=videos&task=upload');?>" enctype="multipart/form-data">


<ul class="cFormList cFormVertical cListReset">

	<!-- video file -->
	<li>
		<label for="file" class="form-label">
			*<?php echo JText::_('COM_COMMUNITY_VIDEOS_SELECT_VIDEO_FILE');?>
		</label>
		<div class="form-field">
			<input type="file" name="videoFile" id="file" class="button required" onChange='joms.videos.checkSize(this)'/>
			<div class="form-helper"><?php echo JText::sprintf('COM_COMMUNITY_MAXIMUM_UPLOAD_LIMIT', $uploadLimit); ?></div>
		</div>
	</li>

	<!-- video title -->
	<li>
		<label for="videoTitle" class="form-label">
			*<?php echo JText::_('COM_COMMUNITY_VIDEOS_TITLE'); ?>
		</label>
		<div class="form-field">
			<input type="text" id="videoTitle" name="title" class="input text required" size="35"  maxlength="255" />
		</div>
	</li>

	<!-- video description -->
	<li>
		<label for="description" class="form-label">
			<?php echo JText::_('COM_COMMUNITY_VIDEOS_DESCRIPTION'); ?>
		</label>
		<div class="form-field">
			<textarea id="description" name="description" class="input textarea fullwidth"></textarea>
		</div>
	</li>

	<!-- location -->
	<?php if ($enableLocation) { ?>
	<li>
		<label for="location" class="form-label">
			<?php echo JText::_('COM_COMMUNITY_VIDEOS_LOCATION');?>
		</label>
		<div class="form-field">
			<input name="location" id="location" type="text" size="35" value ="" class="input location"/>
			<div class="form-helper"><?php echo JText::_('COM_COMMUNITY_VIDEOS_LOCATION_DESCRIPTION'); ?></div>
		</div>
	</li>
	<?php } ?>

	<!-- video category -->
	<li>
		<label for="category" class="form-label">
			<?php echo JText::_('COM_COMMUNITY_VIDEOS_CATEGORY'); ?>
		</label>
		<div class="form-field">
			<?php echo $list['category']; ?>
		</div>
	</li>


	<?php if ($creatorType != VIDEO_GROUP_TYPE) { ?>
	<!-- video privacy -->
	<li>
		<label for="category" class="form-label">
			<?php echo JText::_('COM_COMMUNITY_VIDEOS_WHO_CAN_SEE'); ?>
		</label>
		<div class="form-field">
			<?php echo CPrivacy::getHTML( 'permissions', $permissions, COMMUNITY_PRIVACY_BUTTON_LARGE ); ?>
		</div>
	</li>
	<?php } ?>

	<li class="has-seperator">
		<div class="form-field">
			<div class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></div>
			<?php if($videoUploadLimit > 0 && $videoUploaded/$videoUploadLimit>=COMMUNITY_SHOW_LIMIT) { ?>
			<div class="form-helper"><?php echo JText::sprintf('COM_COMMUNITY_VIDEOS_UPLOAD_LIMIT_STATUS', $videoUploaded, $videoUploadLimit ); ?></div>
			<?php } ?>
		</div>
	</li>
	<li class="has-seperator">
		<?php echo '<button class="cButton cButton-Blue" onclick="joms.videos.submitUploadVideo();">' . JText::_('COM_COMMUNITY_VIDEOS_UPLOAD') . '</button>'; ?>
	</li>
</ul>

<input type="hidden" name="creatortype" value="<?php echo $creatorType; ?>" />
<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
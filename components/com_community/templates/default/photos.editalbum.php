<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	album	An object of CTableAlbum
 */
defined('_JEXEC') or die();
?>
<form name="newalbum" id="newalbum" method="post" action="<?php echo CRoute::getURI(); ?>" class="cForm community-form-validate">


<ul class="cFormList cFormHorizontal cResetList">
	<?php echo $beforeFormDisplay;?>

	<!-- name -->
	<li>
		<label for="name" class="form-label">
			*<?php echo JText::_('COM_COMMUNITY_PHOTOS_ALBUM_NAME');?>
		</label>
		<div class="form-field">
			<input type="text" id="name" name="name" class="input text required" size="35" value="<?php echo $this->escape($album->name); ?>" />
		</div>
	</li>
	<!-- location -->
	<?php if ($enableLocation) { ?>
	<li>
		<label for="location" class="form-label">
			<?php echo JText::_('COM_COMMUNITY_PHOTOS_ALBUM_LOCATION');?>
		</label>
		<div class="form-field">
			<input name="location" id="location" class="input text" type="text" size="35" value ="<?php echo $this->escape($album->location); ?>"/>
			<div class="form-helper"><?php echo JText::_('COM_COMMUNITY_PHOTOS_ALBUM_LOCATION_DESC'); ?></div>
		</div>
	</li>
	<?php } ?>

	<!-- description -->
	<li>
		<label for="description" class="form-label">
			<?php echo JText::_('COM_COMMUNITY_PHOTOS_ALBUM_DESC');?>
		</label>
		<div class="form-field">
			<textarea name="description" id="description" class="description input textarea"><?php echo $this->escape($album->description); ?></textarea>
		</div>
	</li>

	<!-- permission -->	
	<li>
		<label for="privacy" class="form-label">
			<?php echo JText::_('COM_COMMUNITY_PHOTOS_PRIVACY_VISIBILITY');?>
		</label>
		<?php if ($type == 'group') { ?>
		<div class="form-field">
			<span class="uneditable-input"><?php echo JText::_( 'COM_COMMUNITY_PHOTOS_GROUP_MEDIA_PRIVACY_TIPS' ); ?></span>
		</div>
		<?php } else { ?>
		<div class="form-field">
			<div class="form-privacy inline">
				<?php echo CPrivacy::getHTML( 'permissions', $permissions, COMMUNITY_PRIVACY_BUTTON_LARGE ); ?>
			</div>
		</div>
		<?php } ?>
	</li>

	<!-- hint -->
	<li class="has-seperator">
		<div class="form-field"><span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span></div>
	</li>
	<?php echo $afterFormDisplay;?>

	<!-- button -->
	<li>
		<div class="form-field">
			<input type="hidden" name="albumid" value="<?php echo $album->id; ?>" />
			<input type="hidden" name="referrer" value="<?php echo $referrer; ?>" />
			<input type="hidden" name="type" value="<?php echo $type;?>" />
			<?php if(empty($album->id)) { ?>
			<input type="submit" class="cButton cButton-Blue validateSubmit" value="<?php echo JText::_('COM_COMMUNITY_PHOTOS_CREATE_ALBUM_BUTTON');?>" />
			<?php } else { ?>
			<input type="submit" class="cButton cButton-Blue validateSubmit" value="<?php echo JText::_('COM_COMMUNITY_PHOTOS_SAVE_ALBUM_BUTTON');?>" />
			<?php } ?>
			<input type="button" class="cButton" onclick="history.go(-1);return false;" value="<?php echo JText::_('COM_COMMUNITY_CANCEL_BUTTON');?>" />
			<?php echo JHTML::_( 'form.token' ); ?>	
		</div>
	</li>
</ul>
</form>
<script type="text/javascript">
	joms.jQuery( document ).ready( function(){
    	joms.privacy.init();
	});
	cvalidate.init();
	cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("COM_COMMUNITY_ENTRY_MISSING")); ?>');
</script>
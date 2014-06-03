<div id="photo-<?php echo $photo->id; ?>" class="compose-photo">
	<img src="<?php echo JURI::base().$photo->thumbnail; ?>" alt="" />
	<a class="cButton cButton-Small creator-change-photo" href="javascript: void(0);"><?php echo JText::_('COM_COMMUNITY_PHOTOS_CHANGE'); ?></a>
</div>
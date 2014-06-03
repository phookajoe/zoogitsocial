<div id="video-<?php echo $video->id; ?>" class="compose-video jomNameTips clearfix" title="<?php echo $this->escape( JHTML::_('string.truncate', $video->description , VIDEO_TIPS_LENGTH )); ?>">

    <div class="cVideo-Thumb cFloat-L">
		<img src="<?php echo $video->getThumbnail(); ?>" width="<?php echo $videoThumbWidth; ?>" height="<?php echo $videoThumbHeight; ?>" alt="" />
		<b><?php echo $video->getDurationInHMS(); ?></b>
    </div>

    <div class="cVideo-Content">
		<b><?php echo $video->getTitle(); ?></b>
		<div>
			<a class="cButton cButton-Small creator-change-video" href="javascript: void;"><?php echo JText::_('COM_COMMUNITY_CHANGE_VIDEO'); ?></a>
		</div>
	</div>

	<div class="clear"></div>

	<div class="compose-category">
		<label><?php echo JText::_('COM_COMMUNITY_VIDEOS_CATEGORY');?></label>
		<?php echo $categoryHTML; ?>
		<script type="text/javascript">
			function updateCategoryId()
			{
				var catid = joms.jQuery('#category_id').val();
				jax.call('community','videos,ajaxSetVideoCategory', '<?php echo $video->id; ?>', catid );
			}
		</script>
	</div>

</div>
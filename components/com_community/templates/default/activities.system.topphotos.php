<?php
	$model		= CFactory::getModel( 'photos');
	$photos		= $model->getPopularPhotos( 9 , 0 );

	$tmpl   =	new CTemplate();
?>
<div class="cStream-Content">
	<div class="cStream-Headline">
		<b><?php echo JText::_('COM_COMMUNITY_ACTIVITIES_TOP_PHOTOS'); ?></b>
	</div>
	<div class="cStream-Attachment">
		<div class="cStream-Photo top-photos row-fluid">
		<?php
		foreach( $photos as $photo )
		{
		?>
			<b class="span3">
				<a href="<?php echo $photo->getPhotoLink();?>" class="cSnip-Photo" title="<?php echo $this->escape($photo->caption);?>">
					<?php 
					$user = CFactory::getUser($photo->creator); 
					?>
					<img class="cPhoto-Thumb" alt="<?php echo $this->escape($photo->caption);?>" src="<?php echo $photo->getThumbURI();?>" />
					<span>
						<i><?php echo JText::sprintf('COM_COMMUNITY_PHOTOS_UPLOADED_BY' , $user->getDisplayName() );?></i>
					</span>
				</a>
			</b>
		<?php
		}
		?>
		</div>
	</div>
	<?php $this->load('activities.actions'); ?>
</div>
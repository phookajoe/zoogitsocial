<?php
$model		= CFactory::getModel( 'videos');
$videos		= $model->getPopularVideos( 3 );

$tmpl		=	new CTemplate();
?>
<div class="cStream-Content">
	<div class="cStream-Headline">
		<b><?php echo JText::_('COM_COMMUNITY_ACTIVITIES_TOP_VIDEOS'); ?></b>
	</div>
	<div class="cStream-Attachment">
		<div class="cSnippets Block">
		<?php
		foreach( $videos as $video )
		{
			$user = CFactory::getUser( $video->creator );
		?>
			<div class="cSnip Video clearfix">
				<a href="<?php echo $video->getURL();?>" class="cSnip-Avatar Video cFloat-L">
					<img alt="<?php echo $this->escape($video->title);?>" src="<?php echo $video->getThumbnail();?>" />
					<b><?php echo $video->getDurationInHMS();?></b>
				</a>
				<div class="cSnip-Detail Video">
					<a href="<?php echo $video->getURL();?>" class="cSnip-Title">
						<?php echo $this->escape($video->title); ?>
					</a>
					<div class="cSnip-Info small">
						<span><?php 

						if(CStringHelper::isPlural($video->getHits())) {
							echo JText::sprintf('COM_COMMUNITY_VIDEOS_HITS_COUNT_MANY', $video->getHits());
						} else {
							echo JText::sprintf('COM_COMMUNITY_VIDEOS_HITS_COUNT', $video->getHits());
						}

						?>
						</span>
						<span><?php echo JText::_('COM_COMMUNITY_VIDEOS_UPLOADED_BY'); ?> <a href="<?php echo CUrlHelper::userLink($user->id); ?>"><?php echo $user->getDisplayName(); ?></a></span>
					</div>
				</div>
			</div>
		<?php
		}
		?>
		</div>
	</div>
	<?php $this->load('activities.actions'); ?>
</div>

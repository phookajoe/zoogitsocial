<?php
$photosModel = CFactory::getModel( 'photos' );
$total       = $photosModel->getTotalSitePhotos();
?>
<div class='cStream-Content'>
	<div class="cStream-Headline">
		<b><?php echo JText::sprintf('COM_COMMUNITY_TOTAL_PHOTOS_ACTIVITY_TITLE', CRoute::_('index.php?option=com_community&view=photos') ,$total); ?></b>
	</div>
</div>
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
<h3 class="app-box-header">
	<?php echo JText::_('COM_COMMUNITY_PHOTOS_NEW_PHOTOS'); ?>
</h3>
<div class="app-box-content">
	
	<?php
	if( $latestPhotos )
	{
	?>
	<ul class="cThumbsList cResetList clearfix">	
	<?php
		for( $i = 0 ; $i < count( $latestPhotos ); $i++ )
		{
			$row	=& $latestPhotos[$i];
	?>
	<li>
	<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=photo&albumid=' . $row->albumid .  '&userid=' . $row->user->id . '&photoid=' . $row->id);?>">
		<img class="cAvatar cMediaAvatar jomNameTips" title="<?php echo JText::sprintf('COM_COMMUNITY_PHOTOS_UPLOADED_BY' , $row->user->getDisplayName() );?>" src="<?php echo $row->getThumbURI(); ?>" alt="<?php echo $this->escape( $row->user->getDisplayName() );?>" />
	</a>
	</li>
	<?php
		}
	?>
	</ul>
	<?php
	}
	else
	{
	?>
	<div class="cEmpty"><?php echo JText::_('COM_COMMUNITY_PHOTOS_NO_PHOTOS_UPLOADED');?></div>
	<?php } ?>
</div>

<div class="app-box-footer">
	<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos'); ?>"><?php echo JText::_('COM_COMMUNITY_FRONTPAGE_VIEW_ALL_PHOTOS'); ?></a>
</div>
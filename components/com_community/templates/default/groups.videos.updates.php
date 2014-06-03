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

<?php if( $videos ){ ?>
<div class="cModule cGroups-VideoUpdates app-box">
	<!-- top title -->
	<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_GROUPS_VIDEO_UPDATES'); ?></h3>
	<div class="app-box-content">
		<ul class="cThumbsList cResetList clearfix">	
		<?php	foreach($videos as $video){ ?>
		<li>
			<!-- thumbnail for videos -->
			<a class="cVideo-Thumb" href="<?php echo CRoute::_('index.php?option=com_community&view=videos&task=video&groupid='.$video->getId().'&videoid='.$video->getId());?>">
				<img class="cAvatar cMediaAvatar jomNameTips" src="<?php echo $video->getThumbnail(); ?>" title="<?php echo $video->getTitle(); ?>" />
				<b class="cVideo-Duration"><?php echo $video->getDurationInHMS(); ?></b>
			</a>
		</li> 
		<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>

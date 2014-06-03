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
<?php if( $albums ){ ?>
<div class="cModule cGroups-AlbumUpdates app-box">
	<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_GROUPS_LATEST_ALBUM_UPDATE_TITLE'); ?></h3>
	<div class="app-box-content">
		<ul class="cThumbDetails cResetList">
		<?php foreach($albums as $album){ ?>
			<li>
				<a class="cThumb-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=album&albumid='.$album['album_id'].'&groupid='.$album['groupid']); ?>">
					<img class="cAvatar" src="<?php echo $album['album_thumb']; ?>" alt=" <?php echo $album['album_name']; ?> " />
				</a>
				<div class="cThumb-Detail">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=album&albumid='.$album['album_id'].'&groupid='.$album['groupid']); ?>" class="cThumb-Title"> 	
						<?php echo $album['group_name']; ?>
					</a> 				
					<div class="cThumb-Brief small">
						<?php echo JText::sprintf('COM_COMMUNITY_UPLOADED_BY', CRoute::_('index.php?option=com_community&view=profile&userid='.$album['creator_id']), $album['creator_name']); ?>
					</div>
				</div>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>
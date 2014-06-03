<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @param	$discussions	An array of discussions object
 * @param	$groupId		The group id
 * @param	$total			The number of total discussions 
 */
defined('_JEXEC') or die();
?>
	<?php if( $announcements ) {?>
	<h3 class="cStreamTitle cResetH"><?php echo JText::_('COM_COMMUNITY_GROUPS_ANNOUNCEMENT_UPDATE_TITLE'); ?></h3>
	<ul class="cStreamList forAnnouncement pushedUp cResetList">
		<?php foreach($announcements as $announcement){ ?>
		<li>			
			<b class="cStream-Avatar cFloat-L">
				<img src="<?php echo $announcement['user_avatar']; ?>" class="cAvatar" />
			</b>
			<div class="cStream-Content">
				<div class="cStream-Headline">
					<a href="<?php echo $announcement['announcement_link'] ?>" ><?php echo $announcement['title']; ?></a> 
					<span class="arrow">&#9654;</span> 
					<a href="<?php echo $announcement['group_link']; ?>" > <?php echo $announcement['group_name']; ?> </a>
				</div>
				<div class="cStream-Attachment">
					<?php echo $announcement['message']; ?>
				</div>
				<div class="cStream-Actions small">
					<span><?php echo $announcement['user_name'];?></span>
					<span><?php echo $announcement['created_interval']; ?></span>
				</div>
			</div>
		</li>
		<?php } ?>
	</ul>
	<?php } ?>
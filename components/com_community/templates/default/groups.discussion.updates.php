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
	<?php if( $discussions ) {?>
	<h3 class="cStreamTitle cResetH"><?php echo JText::_('COM_COMMUNITY_GROUPS_PARTICIPATED_DISCUSSION_UPDATE'); ?></h3>
	<ul class="cStreamList forDiscussion pushedUp cResetList">
		<?php foreach($discussions as $discussion){ ?>
		<li>			
			<b class="cStream-Avatar cFloat-L">
				<img src="<?php echo CFactory::getUser($discussion['post_by'])->getThumbAvatar(); ?>" class="cAvatar" />	
			</b>
			<div class="cStream-Content">
				<div class="cStream-Headline">
					<a href="<?php echo $discussion['discussion_link'] ?>" ><?php echo $discussion['title']; ?></a> 
					<span class="arrow">&#9654;</span> 
					<a href="<?php echo $discussion['group_link']; ?>" > <?php echo $discussion['group_name']; ?> </a>
				</div>
				<div class="cStream-Attachment">
					<?php echo substr($discussion['comment'],0,250); if(strlen($discussion['comment']) > 250){echo ' ...';} ?>
				</div>
				<div class="cStream-Actions clearfix small">
					<span><?php echo $discussion['created_by']; ?></span>
					<span><?php echo $discussion['created_interval']; ?></span>
				</div>
			</div>
		</li>
		<?php } ?>
	</ul>
	<?php } ?>
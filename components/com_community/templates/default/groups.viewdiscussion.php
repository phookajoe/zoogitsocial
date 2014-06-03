<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @params	isAdmin		boolean is this group belong to me
 * @params	members		An array of member objects
 * @params	title		A string that represents the title of the discussion
 * @params	parentid	An integer value of the discussion parent.
 * @params	groupid		An integer value of the discussion's group id.
 */
defined('_JEXEC') or die();
CAssets::attach('assets/easytabs/jquery.easytabs.min.js', 'js');
?>
<!-- COMMUNITY: START cLayout -->
<div class="cLayout cPage cGroup-ViewDiscussion">

	<div class="cPageActions clearfix">
		<div class="cPageAction cFloat-R">
			<?php echo $reportHTML;?>
			<?php echo $bookmarksHTML;?>
		</div>

		<div class="cPageMeta cFloat-L">
			<i class="update-icon com-icon-comment"></i>
			<span><?php echo JText::sprintf('COM_COMMUNITY_GROUPS_DISCUSSION_CREATOR_TIME_LINK' , $creatorLink , $creator->getDisplayName() , $discussion->created);?></span>
		</div>
	</div>

	<!-- COMMUNITY: START Sidebar -->
	<div class="cSidebar">
		<?php echo $filesharingHTML;?>

		<?php
			$keywords = explode(' ',$discussion->title);
			echo $this->view('groups')->modRelatedDiscussion($keywords);
		?>
	</div>
	<!-- COMMUNITY: END Sidebar -->

	<!-- COMMUNITY: START Discussion Area -->
	<div class="cMain">
		<div class="cPageStory clearfull">
			<!--Discussion : Avatar-->
			<a href="<?php echo CUrlHelper::userLink($creator->id); ?>" class="cPageStory-Author cFloat-L"><img class="cAvatar" src="<?php echo $creator->getThumbAvatar(); ?>" border="0" alt="" /></a>
			<!--Discussion : Avatar-->

			<!--Discussion : Detail-->
			<div class="cPageStory-Content">
				<?php echo $discussion->message; ?>
			</div>
			<!--Discussion : Detail-->
		</div>

		<div class="cPageStory-Replies">
			<?php if($config->get('group_discuss_order') == 'DESC'){ ?>
				<div id="wallForm" class="cWall-Form"><?php echo $wallForm; ?></div>
				<div id="wallContent" class="cWall-Content"><?php echo $wallContent; ?></div>
			<?php } else { ?>
				<div id="wallContent" class="cWall-Content"><?php echo $wallContent; ?></div>
				<div id="wallForm" class="cWall-Form"><?php echo $wallForm; ?></div>
			<?php } ?>
		</div>

	</div>
	<!-- COMMUNITY: END Discussion Area -->

</div>
<!-- COMMUNITY: END cLayout -->
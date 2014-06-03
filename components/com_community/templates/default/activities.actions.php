<?php
// test
// $act->app can be a single word or in app.action form.
// EG:// 'event', 'event.wall'. Find the first part only
$appName = explode('.', $act->app);
$appName = $appName[0];

// Grab primary object to be used in permission checking, defined by appname
$obj = $act;
if( $appName == 'groups'){
$obj = $this->group;
}

if($appName == 'events'){
$obj = $this->event;
}

$my = CFactory::getUser();
$allowLike = !empty($my->id);
$allowComment = ($my -> authorise('community.add','activities.comment.'.$this->act->actor, $obj) );
$showLocation = !empty($this->act->location);

// @todo: delete permission shoudl be handled within ACL system
$allowDelete= ( ($act->actor == $my->id) || $isCommunityAdmin) && ($my->id != 0);

// Allow system message deletion only for admin
if($act->app == 'users.featured'){
$allowDelete=  $isCommunityAdmin;
}

//Discussion Replies shouldnt allow any commenting - 30Jan13 (http://www.ijoomla.com:8080/browse/JOM-142)
if($act->app == 'groups.discussion.reply'){
$allowComment = false;
}

// Allow comment for system post
if($appName == 'system'){
$allowComment = !empty($my->id);
}

?>
<div class="cStream-Actions clearfull small">
<i class="cStream-Icon com-icon-<?php echo $appName;?> <?php if( isset($act->isFeatured))  echo 'com-icon-award-gold' ;?>"></i>

<!-- Show likes -->
<?php if($allowLike) { ?>
<span>
<?php if($act->userLiked!=COMMUNITY_LIKE) { ?>
<a id="like_id<?php echo $act->id?>" href="#like" ><?php echo JText::_('COM_COMMUNITY_LIKE');?></a>
<?php } else { ?>
<a id="like_id<?php echo $act->id?>" href="#unlike" ><?php echo JText::_('COM_COMMUNITY_UNLIKE');?></a>
<?php } ?>
</span>
<?php } ?>

<!-- Show if it is explicitly allowed: -->
<?php if($allowComment ) { ?>
<span><a href="javascript:void(0);" onclick="joms.miniwall.show('<?php echo $act->id; ?>');return false;"><?php echo JText::_('COM_COMMUNITY_COMMENT');?></a></span>
<?php } ?>

<?php if( $showLocation ) { ?>
<span><a onclick="joms.activities.showMap(<?php echo $act->id; ?>, '<?php echo urlencode($act->location); ?>');" class="newsfeed-location" title="<?php echo JText::_('COM_COMMUNITY_VIEW_LOCATION_TIPS');?>" href="javascript: void(0)"><?php echo JText::_('COM_COMMUNITY_VIEW_LOCATION');?></a></span>
<?php } ?>

<?php /* Allow deleted */ ?>
<?php if( $allowDelete ) { ?>
<span><a href="#deletePost" class="newsfeed-location" title="<?php echo JText::_('COM_COMMUNITY_DELETE');?>" href="javascript: void(0)"><?php echo JText::_('COM_COMMUNITY_DELETE');?></a></span>
<?php } ?>

<?php
// Format created date
$date = JFactory::getDate($act->created);
$createdTime = CTimeHelper::timeLapse($date);
?>
<span><?php echo $createdTime; ?></span>

<?php
// Show access class for "friends (30)" or "me only (40)"
$accessClass = 'public'; // NO need to display this
$accessClass = ($act->access == PRIVACY_FRIENDS) ? 'site' : $accessClass ;
$accessClass = ($act->access == PRIVACY_FRIENDS) ? 'friends' : $accessClass ;
$accessClass = ($act->access == PRIVACY_PRIVATE) ? 'me' : $accessClass ;

$accessTitle = "";
$accessTitle = ($accessClass == 'site') ? JText::_('COM_COMMUNITY_PRIVACY_TITLE_SITE_MEMBERS') : $accessTitle;
$accessTitle = ($accessClass == 'friends') ? JText::_('COM_COMMUNITY_PRIVACY_TITLE_FRIENDS') : $accessTitle;
$accessTitle = ($accessClass == 'me') ? JText::_('COM_COMMUNITY_PRIVACY_TITLE_ME') : $accessTitle;

if($accessClass != 'public') {
?>
<span>
<i class="com-glyph-lock-<?php echo $accessClass; ?>" title="<?php echo $accessTitle; ?>"></i>
</span>
<?php } ?>
</div>

<?php if( $allowComment || $allowLike || $showLike) { ?>
<div class="cStream-Respond wall-cocs" id="wall-cmt-<?php echo $act->id; ?>">
<?php if($act->likeCount > 0 && $showLike) { /* hide count if no one like it */?>
<div class="cStream-Likes">
<i class="stream-icon com-icon-thumbup"></i>
<a onclick="jax.call('community','system,ajaxStreamShowLikes', '<?php echo $act->id; ?>');return false;" href="#showLikes"><?php echo ($act->likeCount > 1) ? JText::sprintf('COM_COMMUNITY_LIKE_THIS_MANY', $act->likeCount) : JText::sprintf('COM_COMMUNITY_LIKE_THIS', $act->likeCount); ?></a>
</div>
<?php } ?>
<?php if( $act->commentCount > 1 ) { ?>
<div class="cStream-More" data-commentmore="true">
<i class="stream-icon com-icon-comment"></i>
<a href="#showallcomments"><?php echo JText::sprintf('COM_COMMUNITY_ACTIVITY_NO_COMMENT',$act->commentCount,'wall-cmt-count') ?></a>
</div>
<?php } ?>
<?php if( $act->commentCount > 0 ) { ?>
<?php echo $act->commentLast; ?>
<?php } ?>

<?php if($allowComment ) : ?>
<div class="cStream-Form stream-form wallform <?php if($act->commentCount == 0): echo 'wallnone'; endif; ?>" data-formblock="true">
<!-- post new comment form -->
<form action="">
	<textarea class="cStream-FormText input textarea" cols="" rows="" style="height: 40px;" name="comment"></textarea>

	<div class="cStream-FormSubmit">
		<a class="cStream-FormCancel" onclick="joms.miniwall.cancel('<?php echo $act->id; ?>');return false;" href="#cancelPostinComment"><?php echo JText::_('COM_COMMUNITY_CANCEL_BUTTON');?></a>
		<button type="submit" class="cButton cButton-Black cButton-Small" onclick="joms.miniwall.add('<?php echo $act->id; ?>');return false;"><?php echo JText::_('COM_COMMUNITY_POST_COMMENT_BUTTON');?></button>
	</div>
</form>
</div>

<?php /* Hide reply button if no one has post a comment */ ?>
<?php if( $allowComment ): ?>
<div  data-replyblock="true" <?php if( $act->commentCount == 0 ) { echo 'style="display:none"'; }?> >
<span class="cStream-Reply"><a href="javascript:void(0);" onclick="joms.miniwall.show('<?php echo $act->id; ?>')" ><?php echo JText::_('COM_COMMUNITY_REPLY');?></a></span>

</div>
<?php endif; ?>
<?php endif; ?>

</div>
<?php } ?>


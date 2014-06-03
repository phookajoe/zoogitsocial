
 <?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
?>
<div class="invitation-bg">
<form name="invitation-form" id="community-invitation-form" class="cForm">
<div id="invitation-error"></div>
<?php
if( $displayFriends )
{
?>

<script type="text/javascript">
joms.jQuery(document).ready(function() {
	joms.jQuery(".cTabNavContainer").easytabs({
		defaultTab: "#ctab-result"
	});
});
</script>

<div class="cWindowFinder searchWrap">
	<input class="input text" type="text" onkeyup="joms.friends.loadFriend(this.value,'<?php echo $callback;?>','<?php echo $cid;?>','0','<?php echo $limit;?>');" value="" placeholder="<?php echo JText::_('COM_COMMUNITY_INVITE_TYPE_YOUR_FRIEND_NAME');?>" name="friendsearch" id="friend-search-filter">
</div>

<div class="cTabNavContainer">

<ul class="cTabNav">
	<li id="ctab-result" onclick="joms.invitation.showResult();"><a href="#community-invitation"><?php echo JText::_('COM_COMMUNITY_INVITATION_SEARCH_RESULT');?></a></li>
	<li id="ctab-selected" onclick="joms.invitation.showSelected();"><a href="#community-invited"><?php echo JText::_('COM_COMMUNITY_INVITATION_SELECTED_FRIENDS');?></a></li>
</ul>

	<div id="community-invitation" class="cTab clrfix">
		<ul id="community-invitation-list" class="cUserGrid cResetList cFloatedList clearfull">
		<!-- HERE -->
		</ul>
		<div id="community-invitation-loadmore">
			<a onClick="joms.friends.loadMoreFriend('<?php echo $callback;?>','<?php echo $cid;?>','0','<?php echo $limit;?>');" href="javascript:void(0)"><?php echo JText::_('COM_COMMUNITY_INBOX_LOAD_MORE');?> </a>
		</div>
	</div>
	<div id="community-invited" class="cTab clrfix">
		<ul id="community-invited-list" class="cUserGrid cResetList cFloatedList clearfull">
		<!-- HERE -->
		</ul>
	</div>
</div>
<?php
}
?>
</form>
</div>

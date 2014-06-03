<?php
/**
 * @packageJomSocial
 * @subpackage Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

// The target/actor is of no importance. If the current user is either of of them, they should read it as 'you'
$user1 = CFactory::getUser($act->actor);
$user2 = CFactory::getUser($act->target);

$my = CFactory::getUser();
$you = null;
$other = null;

if($my->id == $user1->id) {
	$you = $user1;
	$other = $user2;
}

if($my->id == $user2->id) {
	$you = $user2;
	$other = $user1;
}
?>
<div class="cStream-Content Compact">
	<div class="cStream-Headline">
		<i class="cStream-Icon com-icon-user-plus cFloat-L"></i>
		<?php
		if(!is_null($you))
		{
			// @todo: use sprintf with language code
			echo JText::sprintf('COM_COMMUNITY_STREAM_MY_FRIENDS', $other->getDisplayName());
		?>
		<?php
		} else {
			// @todo: use sprintf with language code
			echo JText::sprintf('COM_COMMUNITY_STREAM_OTHER_FRIENDS', $user1->getDisplayName(),$user2->getDisplayName(), CUrlHelper::userLink($user1->id), CUrlHelper::userLink($user2->id));
		}
		?>
	</div>
</div>
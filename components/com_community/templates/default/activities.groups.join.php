<?php
/**
 * @packageJomSocial
 * @subpackage Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

$user = CFactory::getUser($this->act->actor);
$users = explode(',', $this->actors);
$actorsHTML = array();
?>
<div class="cStream-Content">
	<i class="cStream-Icon com-icon-groups"></i>
	<?php foreach($users as $actor) {
		$user = CFactory::getUser($actor);
		$actorsHTML[] = '<a class="cStream-Author" href="'. CUrlHelper::userLink($user->id).'">'. $user->getDisplayName().'</a>';
	}
	echo implode(', ', $actorsHTML);
	echo JText::sprintf('COM_COMMUNITY_GROUPS_GROUP_JOIN' , $this->group->getLink(), $this->group->name); ?>
</div>
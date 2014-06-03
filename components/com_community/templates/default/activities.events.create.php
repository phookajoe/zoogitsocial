<?php
$user = CFactory::getUser($this->act->actor); ?>
<div class="cStream-Content">
	<i class="cStream-Icon com-icon-events"></i>
	<a class="cStream-Author" href="<?php echo CUrlHelper::userLink($user->id); ?>"><?php echo $user->getDisplayName(); ?></a> - 
	<?php echo JText::sprintf('COM_COMMUNITY_EVENTS_ACTIVITIES_NEW_EVENT' , CUrlHelper::eventLink($this->event->id), $this->event->title); ?>
</div>
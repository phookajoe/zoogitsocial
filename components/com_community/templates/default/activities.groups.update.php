<div class="cStream-Content">
<?php
$user = CFactory::getUser($this->act->actor); ?>
<i class="cStream-Icon com-icon-groups"></i>
<a class="cStream-Author" href="<?php echo CUrlHelper::userLink($user->id); ?>"><?php echo $user->getDisplayName(); ?></a> - 
<?php echo JText::sprintf('COM_COMMUNITY_GROUPS_GROUP_UPDATED' , $this->group->getLink() , $this->group->name );?>
</div>
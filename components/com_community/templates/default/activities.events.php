<?php

$user = CFactory::getUser($this->act->actor);

// Setup event table
$event = JTable::getInstance('Event', 'CTable');
$event->load($act->eventid);
$this->set('event', $event);

$param = new JRegistry($this->act->params);
$action = $param->get('action');
$actors = $param->get('actors');
$this->set('actors', $actors);
?>

<?php if( $this->act->app == 'events.wall') { ?>
		<?php $this->load('activities.profile'); ?>
	<?php } else if( $action == 'events.create') { ?>
		<?php $this->load('activities.events.create'); ?>
	<?php } else if( $action == 'events.attendence.attend') { ?>
		<?php $this->load('activities.events.attend'); ?>
	<?php } else { ?>
	<?php
		$table = JTable::getInstance('Activity','CTable');
		$table->load($this->act->id);
		if(!$table->delete()){
	?>
<a class="cStream-Avatar cFloat-L" href="<?php echo CUrlHelper::userLink($user->id); ?>">
	<img class="cAvatar" data-author="<?php echo $user->id; ?>" src="<?php echo $user->getThumbAvatar(); ?>">
</a>

<div class="cStream-Content">
	<div class="cStream-Attachment">
		<?php
		$html = CGroups::getActivityContentHTML($act);
		echo $html;
		?>
	</div>

	<?php $this->load('activities.actions'); ?>
</div>
<?php }} ?>
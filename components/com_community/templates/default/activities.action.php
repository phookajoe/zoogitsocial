<div class="stream-actions small">		
	<i class="stream-icon com-icon-profile"></i>
	<?php echo $act->created; ?>				
	<!-- if no one likes yet, then show: -->
	$this->load('activities.actions');					
	<!-- Show if it is explicitly allowed: -->							
	<div class="clr"></div>
</div>
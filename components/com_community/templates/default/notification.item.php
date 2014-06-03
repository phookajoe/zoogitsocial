<?php

/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */

defined('_JEXEC') or die();

?>

<div class="cWindowNotification forGeneral">            
	<p class="cStreamSubject">
		<b><?php echo JText::_('COM_COMMUNITY_ACTIVITY_UPDATE_NOTIFICATION'); ?></b>
	</p>

	<ul class="cWindowStream forGeneral cResetList">
		<?php foreach ( $iRows as $row ) : ?>
		<li id="noti-request-group-<?php echo $row->id; ?>">
			<a href="<?php echo $row->url; ?>" class="cStream-Avatar cFloat-L">
				<img src="<?php echo $row->actorAvatar; ?>" class="cAvatar" alt="<?php echo $this->escape($row->actorName); ?>"/>
			</a>
			<div class="cStream-Content">
				<div id="notification-msg-<?php echo $row->id; ?>" class="cStream-Headline notification-msg-item">
					<?php echo CContentHelper::injectTags($row->content,$row->params,true); ?>
				</div>
				<div class="cStream-Clock small">
					<?php echo $row->timeDiff; ?>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<script>
joms.jQuery(".notification-msg-item a").each(function(key,val){
	joms.jQuery(val).attr("target","_blank");
	joms.jQuery(val).click(function(e){
		if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();	
	});
});
joms.jQuery(".mini-profile").each(function(key,val){
	joms.jQuery(val).click(function(e){
		var link = joms.jQuery(this).find(".avatar a").attr("href");
		if (link.length > 0){
			window.open(link,null);
		}
	});
});
</script>
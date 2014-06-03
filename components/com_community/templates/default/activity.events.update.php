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
<ul class ="cDetailList clrfix">
	<li class="avatarWrap">
		<a href="<?php echo ($event->contentid) ?  CUrlHelper::groupeventLink($event->id,$event->contentid) : CUrlHelper::eventLink($event->id); ?>"><img style="width: 64px; height: auto" class="cAvatar" src="<?php echo $event->getThumbAvatar();?>" /></a>
	</li>
	<li class="detailWrap">
		
		<strong><a href="<?php echo ($event->contentid) ?  CUrlHelper::groupeventLink($event->id,$event->contentid) : CUrlHelper::eventLink($event->id); ?>"><?php echo strip_tags($event->title); ?></a></strong>
		<small>
			<?php if (strlen(strip_tags($event->description))) echo JHTML::_('string.truncate', strip_tags($event->description) , $config->getInt('streamcontentlength')).'<br />';?>
			<?php echo $event->getStartDateHTML(); ?><br />
			<?php echo $event->getEndDateHTML(); ?><br />
			<?php echo strip_tags($event->location); ?><br />
		</small>
	</li>
</ul>
<div class="clr"></div>
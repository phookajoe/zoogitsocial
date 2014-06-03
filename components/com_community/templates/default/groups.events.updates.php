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
<?php if( $events ){ ?>
<div class="cModule cGroups-EventsUpdates app-box">
	<h3 class="app-box-header">
		<?php echo JText::_('COM_COMMUNITY_EVENTS_UPCOMING'); ?>
	</h3>
	<div class="app-box-content">
		<ul class="cThumbDetails cResetList">
			<?php foreach($events as $event){ ?>
			<li>
				<b class="cThumb-Calendar cFloat-L">
					<b><?php echo CEventHelper::formatStartDate($event, JText::_('M') ); ?></b>
					<b><?php echo CEventHelper::formatStartDate($event, JText::_('d') ); ?></b>
				</b>
				<div class="cThumb-Detail">
					<a class="cThumb-Title" href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewevent&eventid='.$event->id); ?>"><?php echo $this->escape($event->title); ?></a>
					<div class="cThumb-Location">
						<?php echo $this->escape( $event->location );?>
					</div>
					<div class="cThumb-Members small">
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewguest&eventid=' . $event->id . '&type='.COMMUNITY_EVENT_STATUS_ATTEND);?>">
							<?php echo JText::sprintf((cIsPlural($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_MANY_GUEST_COUNT':'COM_COMMUNITY_EVENTS_GUEST_COUNT', $event->confirmedcount );?>
						</a>
					</div>
				</div>
			</li>		 
			<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>

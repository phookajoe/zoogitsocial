<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @params	groups		An array of events objects.
 */
defined('_JEXEC') or die();
?>
<?php
if( $events )
{
?>
<ul class="cIndexList forEvents cResetList">
<?php
	for( $i = 0; $i < count( $events ); $i++ )
	{
		$event =& $events[$i];
?>
	<li>
		<div class="cIndex-Box clearfix">

			<a href="<?php echo $event->getLink();?>" class="cIndex-Avatar cFloat-L">
				<img src="<?php echo $event->getThumbAvatar();?>" alt="<?php echo $this->escape($event->title); ?>" class="cAtavar" />

				<?php if( $isExpired || CEventHelper::isPast($event) ) { ?>
					<b class="cStatus-Past"><?php echo JText::_('COM_COMMUNITY_EVENTS_PAST'); ?></b>
				<?php } else if(CEventHelper::isToday($event)) { ?>
					<b class="cStatus-OnGoing"><?php echo JText::_('COM_COMMUNITY_EVENTS_ONGOING'); ?></b>
				<?php } ?>
			</a>


			<div class="cIndex-Content">
				<h3 class="cIndex-Name cResetH">
					<a href="<?php echo $event->getLink();?>"><?php echo $this->escape($event->title); ?></a>
				</h3>
				<div class="cIndex-Status">
					<div class="cIndex-Date"><b><?php echo CEventHelper::formatStartDate($event, $config->get('eventdateformat') ); ?></b></div>
					<i class="cIndex-Location"><?php echo $this->escape($event->location);?></i>
					<!-- <div class="cIndex-Time small"><?php echo JText::sprintf('COM_COMMUNITY_EVENTS_DURATION', CTimeHelper::getFormattedTime($event->startdate, $timeFormat), CTimeHelper::getFormattedTime($event->enddate, $timeFormat)); ?></div> -->
				</div>
				<div class="cIndex-Actions">
					<div>
						<i class="com-icon-groups"></i>
						<?php if( $isExpired || CEventHelper::isPast($event) ) { ?>
						<a href="<?php echo $event->getGuestLink( COMMUNITY_EVENT_STATUS_ATTEND );?>"><?php echo JText::sprintf((cIsPlural($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_COUNT_MANY_PAST':'COM_COMMUNITY_EVENTS_COUNT_PAST', $event->confirmedcount);?></a>
						<?php } else { ?>
						<a href="<?php echo $event->getGuestLink( COMMUNITY_EVENT_STATUS_ATTEND );?>"><?php echo JText::sprintf((cIsPlural($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_MANY_GUEST_COUNT':'COM_COMMUNITY_EVENTS_GUEST_COUNT', $event->confirmedcount);?></a>
						<?php } ?>
					</div>
					<?php
					if( $isCommunityAdmin && $showFeatured ) {
						if( !in_array($event->id, $featuredList) )
						{
					?>
					<div class="cIndex-Feature">
						<a class="cButton Icon"
						   onclick="joms.featured.add('<?php echo $event->id;?>','events');"
						   href="javascript:void(0);"
						   title="<?php echo JText::_('COM_COMMUNITY_MAKE_FEATURED'); ?>">
							<i class="com-icon-award-plus"></i>
						</a>
					</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</li>
<?php
	}
?>
</ul>
	<?php
	if ( !empty($pagination))
	{
	?>
	<div class="cPagination">
		<?php echo $pagination->getPagesLinks(); ?>
	</div>
	<?php
	}
	?>
<?php
} else {
?>
<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_EVENTS_NO_EVENTS_ERROR'); ?></div>
<?php } ?>




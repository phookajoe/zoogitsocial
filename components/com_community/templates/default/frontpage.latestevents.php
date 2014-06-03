<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 */
defined('_JEXEC') or die();

if( !empty( $events ) )
{
?>
<h3 class="app-box-header"><?php if($config->get('eventfrontpagelist')) { echo JText::_('COM_COMMUNITY_EVENTS_UPCOMING'); } else { echo JText::_('COM_COMMUNITY_FEATURED_EVENTS'); } ?></h3>
<div class="app-box-content">
	<ul class="cThumbDetails cResetList">
		<?php foreach( $events as $event ){ ?>
		<li <?php if(!empty($event->summary)): ?>class="jomNameTips" title="<?php echo $this->escape( $event->summary);?>" <?php endif; ?>>
			<b class="cThumb-Calendar cFloat-L">
				<b><?php echo CEventHelper::formatStartDate($event, JText::_('M') ); ?></b>
				<b><?php echo CEventHelper::formatStartDate($event, JText::_('d') ); ?></b>
			</b>
			<div class="cThumb-Detail">
				<a href="<?php echo $event->getLink();?>" class="cThumb-Title"><?php echo $this->escape( $event->title ); ?></a>
				<div class="cThumb-Location">
					<?php echo $this->escape( $event->location );?>
				</div>
				<div class="cThumb-Members small">
					<a href="<?php echo $event->getGuestLink( COMMUNITY_EVENT_STATUS_ATTEND );?>">
						<?php echo JText::sprintf((cIsPlural($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT_MANY':'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT', $event->confirmedcount);?>
					</a>
				</div>
			</div>
		</li>
		<?php } ?>
	</ul>
</div>
<div class="app-box-footer">
	<a href="<?php echo CRoute::_('index.php?option=com_community&view=events'); ?>"><?php echo JText::_('COM_COMMUNITY_FRONTPAGE_VIEW_ALL_EVENTS'); ?></a>
</div>
<?php
}
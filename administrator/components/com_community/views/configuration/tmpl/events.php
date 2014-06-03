<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS' ); ?></legend>
	<a href="http://documentation.jomsocial.com/wiki/Frontend_moderation_options_in_events" target="_blank"><?php echo JText::_('COM_COMMUNITY_DOC'); ?></a>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="350" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ENABLE_EVENTS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_ENABLE_EVENTS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ENABLE_EVENTS' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enableevents' , null , $this->config->get('enableevents') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td width="350" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ENABLE_GUEST_SEARCH' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_ENABLE_GUEST_SEARCH_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ENABLE_GUEST_SEARCH' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enableguestsearchevents' , null , $this->config->get('enableguestsearchevents') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td width="350" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_MODERATE_EVENT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_MODERATE_EVENT_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_MODERATE_EVENT' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'event_moderation' , null , $this->config->get('event_moderation') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ALLOW_CREATION' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_ALLOW_CREATION_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ALLOW_CREATION' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'createevents' , null , $this->config->get('createevents') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_REPEAT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_SHOW_FEATURED_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_REPEAT' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enablerepeat' , null , $this->config->get('enablerepeat') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_CREATE_LIMIT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_CREATE_LIMIT_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_CREATE_LIMIT' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="eventcreatelimit" value="<?php echo $this->config->get('eventcreatelimit' );?>" size="10" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ICAL_EXPORT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_ICAL_EXPORT_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ICAL_EXPORT' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'eventexportical' , null , $this->config->get('eventexportical') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ICAL_IMPORT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_ICAL_IMPORT_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_ICAL_IMPORT' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'event_import_ical' , null , $this->config->get('event_import_ical') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_SHOW_MAPS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_SHOW_MAPS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_SHOW_MAPS' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'eventshowmap' , null , $this->config->get('eventshowmap') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
            
            <tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_DEFAULT_RADIUS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_DEFAULT_RADIUS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_DEFAULT_RADIUS' ); ?>
					</span>
				</td>
				<td>       	
                    <input <?php if($this->config->get('eventradiusmeasure') == COMMUNITY_EVENT_UNIT_KM) echo 'checked="checked"'; ?> type="radio" name="eventradiusmeasure" id="eventradiusmeasure_1" value="<?php echo COMMUNITY_EVENT_UNIT_KM; ?>" onclick="document.getElementById('nearby_radius_measurement').innerHTML='<?php echo COMMUNITY_EVENT_UNIT_KM; ?>';" />
					<label for="eventradiusmeasure_1"><?php echo JText::_('COM_COMMUNITY_EVENTS_KILOMETER');?></label>
                    
                    <input <?php if(!$this->config->get('eventradiusmeasure') || $this->config->get('eventradiusmeasure') == COMMUNITY_EVENT_UNIT_MILES) echo 'checked="checked"'; ?> type="radio" name="eventradiusmeasure" id="eventradiusmeasure_2" value="<?php echo COMMUNITY_EVENT_UNIT_MILES; ?>" onclick="document.getElementById('nearby_radius_measurement').innerHTML='<?php echo COMMUNITY_EVENT_UNIT_MILES; ?>';" />
					<label for="eventradiusmeasure_2"><?php echo JText::_('COM_COMMUNITY_EVENTS_MILES');?></label>                    
				</td>
			</tr>
            
            
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_NEARBY_RADIUS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_NEARBY_RADIUS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_NEARBY_RADIUS' ); ?>
					</span>
				</td>
				<td>
					<select name="event_nearby_radius">
							<option value="<?php echo COMMUNITY_EVENT_WITHIN_5; ?>"<?php echo ( $this->config->get('event_nearby_radius') == COMMUNITY_EVENT_WITHIN_5 ) ? ' selected="true"' : '';?>>5</option>
							<option value="<?php echo COMMUNITY_EVENT_WITHIN_10; ?>"<?php echo ( $this->config->get('event_nearby_radius') == COMMUNITY_EVENT_WITHIN_10 ) ? ' selected="true"' : '';?>>10</option>
							<option value="<?php echo COMMUNITY_EVENT_WITHIN_20; ?>"<?php echo ( $this->config->get('event_nearby_radius') == COMMUNITY_EVENT_WITHIN_20 ) ? ' selected="true"' : '';?>>20</option>
							<option value="<?php echo COMMUNITY_EVENT_WITHIN_50; ?>"<?php echo ( $this->config->get('event_nearby_radius') == COMMUNITY_EVENT_WITHIN_50 ) ? ' selected="true"' : '';?>>50</option>
					</select>
                    <label id="nearby_radius_measurement"><?php echo $this->config->get('eventradiusmeasure'); ?></label>
				</td>
			</tr>

			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_CALENDAR_FIRST_DAY' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_CALENDAR_FIRST_DAY_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_CALENDAR_FIRST_DAY' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="event_calendar_firstday">
							<option value="<?php echo COMMUNITY_EVENT_CALENDAR_MONDAY; ?>"<?php echo ( $this->config->get('event_calendar_firstday') == COMMUNITY_EVENT_CALENDAR_MONDAY ) ? ' selected="true"' : '';?>><?php echo JText::_( 'COM_COMMUNITY_EVENTS_MONDAY_OPTION' ); ?></option>
							<option value="<?php echo COMMUNITY_EVENT_CALENDAR_SUNDAY; ?>"<?php echo ( $this->config->get('event_calendar_firstday') == COMMUNITY_EVENT_CALENDAR_SUNDAY ) ? ' selected="true"' : '';?>><?php echo JText::_( 'COM_COMMUNITY_EVENTS_SUNDAY_OPTION' ); ?></option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>

<fieldset class="adminform">
	<legend><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_TIME_FORMAT' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_LISTINGS_DATE_FORMAT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_LISTINGS_DATE_FORMAT_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_LISTINGS_DATE_FORMAT' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="eventdateformat">
							<option value="M d Y"<?php echo ( $this->config->get('eventdateformat') == 'M d Y' ) ? ' selected="true"' : '';?>><?php echo JText::_('COM_COMMUNITY_MONTH_DAY_OPTION');?></option>
							<option value="d M Y"<?php echo ( $this->config->get('eventdateformat') == 'd M Y' ) ? ' selected="true"' : '';?>><?php echo JText::_('COM_COMMUNITY_DAY_MONTH_OPTION');?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_TIME_SELECTION_FORMAT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_TIME_SELECTION_FORMAT_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_TIME_SELECTION_FORMAT' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="eventshowampm">
							<option value="1"<?php echo ( $this->config->get('eventshowampm') == '1' ) ? ' selected="true"' : '';?>><?php echo JText::_('COM_COMMUNITY_12H_OPTION');?></option>
							<option value="0"<?php echo ( $this->config->get('eventshowampm') == '0' ) ? ' selected="true"' : '';?>><?php echo JText::_('COM_COMMUNITY_24H_OPTION');?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_SHOW_TIMEZONE' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_EVENTS_SHOW_TIMEZONE_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_EVENTS_SHOW_TIMEZONE' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'eventshowtimezone' , null , $this->config->get('eventshowtimezone') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>

		</tbody>
	</table>
</fieldset>
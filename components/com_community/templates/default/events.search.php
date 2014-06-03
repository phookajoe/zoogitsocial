<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	posted	boolean	Determines whether the current state is a posted event.
 * @param	search	string	The text that the user used to search 
 */
defined('_JEXEC') or die();
?>
<div id="cLayout cSearch Events">

	<form name="jsform-events-search" method="get" action="" class="cSearch-Form cForm">
		
		<ol class="cFormList cFormHorizontal cResetList">
			
			<?php if(!empty($beforeFormDisplay)){ ?>
			<?php echo $beforeFormDisplay; ?>
			<?php } ?>
			
			
			<li>
				<label for="search" class="form-label"><?php echo JText::_('COM_COMMUNITY_SEARCH_FOR'); ?></label>
				<div class="form-field">
					<input type="text" class="input text" name="search" value="<?php echo $this->escape($search); ?>" size="50" style="width: 80%" />
				</div>
			</li>
			
			<li>
				<label for="catid" class="form-label">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_CATEGORY');?>
				</label>
				<div class="form-field">
					<select name="catid" id="catid" class="required input input-block-level text">
						<option value="0" selected><?php echo JText::_('COM_COMMUNITY_EVENTS_CATEGORY_TIPS');?></option>
						<?php
						foreach( $categories as $category )
						{
						?>
							<option value="<?php echo $category->id; ?>" <?php if( $category->id == $catId ) { ?>selected<?php } ?>><?php echo JText::_( $this->escape($category->name) ); ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</li>

			<li>
				<label class="form-label">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_START_DATE'); ?>
				</label>
				<div class="form-field">
					<span title="<?php echo JText::_('COM_COMMUNITY_EVENTS_START_TIME_TIPS'); ?>">
						<?php echo JHTML::_('calendar',  $advance['startdate'] , 'startdate', 'startdate', '%Y-%m-%d', array('class'=>'required', 'size'=>'20',  'maxlength'=>'20' , 'readonly' => 'true') );?>
					</span>
				</div>
			</li>

			<li>
				<label class="form-label">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_END_DATE'); ?>
				</label>
				<div class="form-field">
					<span title="<?php echo JText::_('COM_COMMUNITY_EVENTS_END_TIME_TIPS'); ?>">
						<?php echo JHTML::_('calendar',  $advance['enddate'], 'enddate', 'enddate', '%Y-%m-%d', array('class'=>'required', 'size'=>'20',  'maxlength'=>'20' , 'readonly' => 'true') );?>
					</span>
				</div>
			</li>

			<li>
				<label class="form-label">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_FROM'); ?>
				</label>
				<div class="form-field">
					
					<script type="text/javascript">
						joms.jQuery('document').ready(function()
 						{
						    validateFormValue();

						    // Check if the browsers support W3C Geolocation API
						    // If yes, show the auto-detect link
						    if( navigator.geolocation )
						    {
							    joms.jQuery('#proto__detectButton').show();
						    }
						});

						function get_current_location()
						{
						    joms.jQuery('#proto__currentLocationValue').hide();
						    joms.jQuery('#proto__detectButton').hide();
						    joms.jQuery('#proto__detectingCurrentLocation').show();

						    navigator.geolocation.getCurrentPosition(function(location)
						    {
							var lat	=   location.coords.latitude;
							var lng	=   location.coords.longitude;

							// Reverse Geocoding
							geocoder    =   new google.maps.Geocoder();
							var latlng  =   new google.maps.LatLng( lat, lng );

							geocoder.geocode({'latLng': latlng}, function(results, status){
							    if( status == google.maps.GeocoderStatus.OK ){
								if ( results[4] ){
								    var newLocation = results[4].formatted_address;

								    if( newLocation.length != 0 )
								    {
							    joms.jQuery("#proto_selectRadius").removeAttr("disabled");
							    joms.jQuery("#distance_unit1").removeAttr("disabled");
							    joms.jQuery("#distance_unit2").removeAttr("disabled");
								    }

								    joms.jQuery("#proto__detectingCurrentLocation").hide();
								    joms.jQuery("#proto__currentLocationValue").attr("value", newLocation).show();
								}
							    } else {
								alert("Geocoder failed due to: " + status);
							    }
							});

							joms.jQuery("#proto__detectButton").show();
						    });
						}

						function validateFormValue()
						{
						    var input = joms.jQuery("#proto__currentLocationValue").val();

						    if( input.length != 0 )
						    {
							joms.jQuery("#proto_selectRadius").removeAttr("disabled");
							joms.jQuery("#distance_unit1").removeAttr("disabled");
							joms.jQuery("#distance_unit2").removeAttr("disabled");
						    }
						    else
						    {
							joms.jQuery("#proto_selectRadius").attr("disabled", "disabled");
							joms.jQuery("#distance_unit1").attr("disabled", "disabled");
							joms.jQuery("#distance_unit2").attr("disabled", "disabled");
						    }
						}
					</script>

					<div id="proto__currentLocation">
						<input type="text" name="location" id="proto__currentLocationValue" value="<?php echo $this->escape($advance['fromlocation']); ?>" class="input text" onkeyup="validateFormValue();" style="width:50%" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_SEARCH_FROM_TIPS'); ?>" />
						<span id="proto__detectingCurrentLocation" class="loading" style="float: left;"></span>
						<a id="proto__detectButton" href="javascript: void(0)" style="display: none;" onclick="get_current_location();" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_AUTODETECT_LOCATION'); ?>" class="cButton"><?php echo JText::_('COM_COMMUNITY_EVENTS_AUTODETECT_LOCATION'); ?></a>
					</div>
				</div>
			</li>

			<li>
				<label class="form-label">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_WITHIN'); ?>
				</label>
				<div class="form-field">
					<select id="proto_selectRadius" name="radius" class="required" disabled="disabled" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_WITHIN_TIPS'); ?>">
						<option value="<?php echo null; ?>" <?php if( empty($advance['radius']) ){ ?>selected<?php } ?>></option>
						<option value="<?php echo COMMUNITY_EVENT_WITHIN_5; ?>" <?php if( $advance['radius'] == COMMUNITY_EVENT_WITHIN_5 ){ ?>selected<?php } ?>><?php echo COMMUNITY_EVENT_WITHIN_5; ?></option>
						<option value="<?php echo COMMUNITY_EVENT_WITHIN_10; ?>" <?php if( $advance['radius'] == COMMUNITY_EVENT_WITHIN_10 ){ ?>selected<?php } ?>><?php echo COMMUNITY_EVENT_WITHIN_10; ?></option>
						<option value="<?php echo COMMUNITY_EVENT_WITHIN_20; ?>" <?php if( $advance['radius'] == COMMUNITY_EVENT_WITHIN_20 ){ ?>selected<?php } ?>><?php echo COMMUNITY_EVENT_WITHIN_20; ?></option>
						<option value="<?php echo COMMUNITY_EVENT_WITHIN_50; ?>" <?php if( $advance['radius'] == COMMUNITY_EVENT_WITHIN_50 ){ ?>selected<?php } ?>><?php echo COMMUNITY_EVENT_WITHIN_50; ?></option>
					</select>
					<input id="distance_unit1" type="radio" name="unit" class="required input radio" value="<?php echo COMMUNITY_EVENT_UNIT_KM; ?>" disabled="disabled" <?php if( $unit === COMMUNITY_EVENT_UNIT_KM ){ ?>checked<?php } ?>> <?php echo JText::_('COM_COMMUNITY_EVENTS_KILOMETER'); ?>
					<input id="distance_unit2" type="radio" name="unit" class="required input radio" value="<?php echo COMMUNITY_EVENT_UNIT_MILES; ?>" disabled="disabled" <?php if( $unit === COMMUNITY_EVENT_UNIT_MILES || empty($unit) ){ ?>checked <?php } ?>> <?php echo JText::_('COM_COMMUNITY_EVENTS_MILES'); ?>
				</div>
			</li>
			
			<?php if(!empty($afterFormDisplay)){ ?>
			<?php echo $afterFormDisplay; ?>
			<?php } ?>
			
			<li class="form-action has-seperator">
				<div class="form-field">
					<input type="submit" value="<?php echo JText::_('COM_COMMUNITY_SEARCH_BUTTON');?> <?php echo JText::_('COM_COMMUNITY_EVENTS');?>" class="cButton cButton-Blue" />
				</div>
			</li>
		</ol>

		<?php echo JHTML::_( 'form.token' ); ?>
		<input type="hidden" value="com_community" name="option" />
		<input type="hidden" value="events" name="view" />
		<input type="hidden" value="search" name="task" />
		<input type="hidden" value="<?php echo CRoute::getItemId();?>" name="Itemid" />
        <input type="hidden" name="posted" value="1">
	</form>



	<?php 
	if($posted)
	{
	?>
	<div class="cSearch-Result">
		<p>
			<span>
				<?php echo JText::sprintf( 'COM_COMMUNITY_SEARCH_RESULT' , $search ); ?>
			</span>
			
			<span class="cFloat-R">
				<?php echo JText::sprintf( (CStringHelper::isPlural($eventsCount)) ? 'COM_COMMUNITY_EVENTS_SEARCH_RESULT_TOTAL_MANY' : 'COM_COMMUNITY_EVENTS_SEARCH_RESULT_TOTAL' , $eventsCount ); ?>
			</span>
		</p>

		<?php echo $eventsHTML; ?>		
	</div>
	<?php
	}
	?>


	<?php 
	if( $searchLinks ) 
	{
	?>
	<div class="cSearch-Jumper">
		<?php
		echo JText::_('COM_COMMUNITY_SEARCH_FOR');

		foreach ($searchLinks as $key => $value) 
		{
		?>
		<a href="<?php echo $value; ?>"><?php echo ucwords($key); ?></a>
		<?php
		}
		?>
	</div>
	<?php
	}
	?>
</div>
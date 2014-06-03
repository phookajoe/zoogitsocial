<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @params	categories Array	An array of categories
 */
defined('_JEXEC') or die();
?>
<div class="cLayout cEvents-Forms">
<form method="post" action="<?php echo CRoute::getURI(); ?>" id="createEvent" name="createEvent" class="cForm community-form-validate">

	<script type="text/javascript">

		joms.jQuery(document).ready(function(){

			joms.events.showDesc();

			joms.jQuery("#repeat option[value=" + '<?php echo $event->repeat;?>' + "]").attr("selected", "selected");

			<?php if ($event->id > 0 ) { ?>
				joms.jQuery('#repeat').hide();
				repeatlabel = joms.jQuery('#repeat option:selected').text();
				joms.jQuery('#repeatcontent').html(repeatlabel);
			<?php } ?>

		});

		joms.jQuery('#createEvent').submit(function(event) {

			<?php echo $editor->saveText( 'description' ); ?>

			// show cwindow repeat action for current / future
			<?php if ($event->id > 0 && $event->isRecurring() && $enableRepeat) { ?>
				if (joms.jQuery('#repeataction').val() == '') {
					joms.events.save();
					return false;
				}
			<?php }?>

		});

	</script>

	<?php if(!$event->id && $eventcreatelimit != 0 ) { ?>
		<?php if($eventCreated/$eventcreatelimit>=COMMUNITY_SHOW_LIMIT) { ?>
		<div class="hints">
			<?php echo JText::sprintf('COM_COMMUNITY_EVENTS_CREATION_LIMIT_STATUS', $eventCreated, $eventcreatelimit ); ?>
		</div>
		<?php } ?>
	<?php } ?>

		<ul class="cFormList cFormHorizontal cResetList">

			<?php echo $beforeFormDisplay;?>

			<!-- events name -->
			<li>
				<label for="title" class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_EVENTS_TITLE_LABEL'); ?>
				</label>
				<div class="form-field">
					<input name="title" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_TITLE_TIPS'); ?>" id="title" type="text" size="45" maxlength="255" class="required input text jomNameTips" value="<?php echo $this->escape($event->title); ?>" style="width: 80%" />
					<?php
					if( $helper->hasPrivacy() )
					{
					?>
						<label for="permission-private" class="label-checkbox">
							<input type="checkbox" class="input checkbox" name="permission" id="permission-private" value="1"<?php echo ($event->permission == COMMUNITY_PRIVATE_EVENT ) ? ' checked="checked"' : '';?> />
							<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_TYPE_TIPS');?>">
								<?php echo JText::_('COM_COMMUNITY_EVENTS_PRIVATE_EVENT');?>
							</span>
						</label>
					<?php
					}
					?>
				</div>
			</li>



			<!--events summary-->
			<li>
				<label for="summary" class="form-label">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_SUMMARY')?>
				</label>
				<div class="form-field">
					<textarea name="summary" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_SUMMARY_TIPS')?>" id="summary" maxlength="140" class="jomNameTips" style="width:80%;height:50px;resize:vertical;"><?php echo $this->escape($event->summary);?></textarea>
				</div>
			</li>



			<!-- events description -->
			<li id="event-discription" style="display:none">
				<label for="description" class="form-label">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_DESCRIPTION');?>
				</label>
				<div class="form-field">
					<?php if( $config->get( 'htmleditor' ) == 'none' && $config->getBool('allowhtml') ) { ?>
						<div class="htmlTag"><?php echo JText::_('COM_COMMUNITY_HTML_TAGS_ALLOWED');?></div>
					<?php } ?>

					<?php
					if( !CStringHelper::isHTML($event->description)
						&& $config->get('htmleditor') != 'none'
						&& $config->getBool('allowhtml') )
					{
						$event->description = CStringHelper::nl2br($event->description);
					}
					?>

					<?php echo $editor->displayEditor( 'description',  $event->description , '95%', '150', '10', '20' , false ); ?>
				</div>
			</li>



			<!-- events category -->
			<li>
				<label for="catid" class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_EVENTS_CATEGORY');?>
				</label>
				<div class="form-field">
					<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_CATEGORY_TIPS');?>"><?php echo $lists['categoryid']; ?></span>
				</div>
			</li>



			<!-- events location -->
			<li>
				<label for="location" class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_EVENTS_LOCATION'); ?>
				</label>
				<div class="form-field">
					<input title="<?php echo JText::_('COM_COMMUNITY_EVENTS_LOCATION_TIPS'); ?>" name="location" id="location" type="text" size="45" maxlength="255" class="required input text jomNameTips" value="<?php echo $this->escape($event->location); ?>" />
					<span class="form-helper">
						<?php echo JText::_('COM_COMMUNITY_EVENTS_LOCATION_DESCRIPTION');?>
					</span>
				</div>
			</li>



			<!-- events start datetime -->
			<li id="event-start-datetime" class="has-seperator">
				<label class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_EVENTS_START_TIME'); ?>
				</label>
				<div class="form-field">
					<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_START_TIME_TIPS'); ?>">
						<script type="text/javascript">
							<!-- add calendar listener to the field -->
							window.addEvent('domready', function() {Calendar.setup({
							inputField: "startdate",
							ifFormat: "Y-m-d",
							button: "startdate",
							singleClick: true,
							firstDay: 0
							});});
						</script>
						<?php echo JHTML::_('calendar',  $startDate->format( 'Y-m-d' ) , 'startdate', 'startdate', '%Y-%m-%d', array('class'=>'required', 'size'=>'10',  'maxlength'=>'10' , 'readonly' => 'true', 'onchange' => 'updateEndDate();', 'id'=>'startdate') );?>
						<span id="start-time">
						<?php echo $startHourSelect; ?>:<?php  echo $startMinSelect; ?> <?php echo $startAmPmSelect;?>
						</span>
						<script type="text/javascript">
							function updateEndDate(){
								var startdate	=   joms.jQuery('#startdate').val();
								var enddate		=   joms.jQuery('#enddate').val();
								var repeatend	=   joms.jQuery('#repeatend').val();

								tmpenddate		=	new Date(enddate);
								tmpstartdate	=   new Date(startdate);
								tmprepeatend    =   new Date(repeatend);

								if(tmpenddate < tmpstartdate){
									joms.jQuery('#enddate').val( startdate );
								}

								if(tmprepeatend < tmpstartdate){
									joms.jQuery('#repeatend').val( startdate );
								}
							}
						</script>
					</span>
				</div>
			</li>



			<!-- events end datetime -->
			<li id="event-end-datetime">
				<label class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_EVENTS_END_TIME'); ?>
				</label>
				<div class="form-field">
					<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_END_TIME_TIPS'); ?>">
						<script type="text/javascript">
							window.addEvent('domready', function() {Calendar.setup({
							inputField: "enddate",
							ifFormat: "Y-m-d",
							button: "enddate",
							singleClick: true,
							firstDay: 0
							});});
						</script>
						<?php echo JHTML::_('calendar',  $endDate->format( 'Y-m-d' ) , 'enddate', 'enddate', '%Y-%m-%d', array('class'=>'required', 'size'=>'10',  'maxlength'=>'10' , 'readonly' => 'true', 'id'=>'enddate', 'onchange' => 'updateStartDate();') );?>
						<span id="end-time">
						<?php echo $endHourSelect; ?>:<?php echo $endMinSelect; ?> <?php echo $endAmPmSelect;?>
						<script type="text/javascript">
							function updateStartDate(){
								var enddate	=   joms.jQuery('#enddate').val();
								var startdate	=   joms.jQuery('#startdate').val();
								var repeatend	=   joms.jQuery('#repeatend').val();

								tmpenddate		=	new Date(enddate);
								tmpstartdate	=   new Date(startdate);
								tmprepeatend    =   new Date(repeatend);

								if(tmpenddate < tmpstartdate){
									joms.jQuery('#startdate').val( enddate );
								}

								if(tmprepeatend < tmpenddate){
									joms.jQuery('#repeatend').val( enddate );
								}
							}
						</script>
						</span>
					</span>
				</div>

				<script type="text/javascript">
					function toggleEventDateTime()
					{
						if( joms.jQuery('#allday').attr('checked') == 'checked' ){
							joms.jQuery('#start-time, #end-time').hide();
						}else{
							joms.jQuery('#start-time, #end-time').show();
						}
					}

					function toggleEventRepeat()
					{
						if( joms.jQuery('#repeat').val() != '' ){
							joms.jQuery('#repeatendinput').show();
							limitdesc = '';
							if (joms.jQuery('#repeat').val() == 'daily') {
								limitdesc = '<?php echo addslashes(sprintf(Jtext::_('COM_COMMUNITY_EVENTS_REPEAT_LIMIT_DESC'), COMMUNITY_EVENT_RECURRING_LIMIT_DAILY));?>';
							}else if (joms.jQuery('#repeat').val() == 'weekly') {
								limitdesc = '<?php echo addslashes(sprintf(Jtext::_('COM_COMMUNITY_EVENTS_REPEAT_LIMIT_DESC'), COMMUNITY_EVENT_RECURRING_LIMIT_WEEKLY));?>';
							}else if (joms.jQuery('#repeat').val() == 'monthly') {
								limitdesc = '<?php echo addslashes(sprintf(Jtext::_('COM_COMMUNITY_EVENTS_REPEAT_LIMIT_DESC'), COMMUNITY_EVENT_RECURRING_LIMIT_MONTHLY));?>';
							}
							joms.jQuery('#repeatlimitdesc').html(limitdesc);
							joms.jQuery('#repeatlimitdesc').show();
						}else{
							joms.jQuery('#repeatendinput').hide();
							joms.jQuery('#repeatlimitdesc').hide();
						}
					}
				</script>
			</li>



			<li>
				<div class="form-field">
					<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_ALL_DAY_TIPS');?>">
						<input class="input checkbox" id="allday" name="allday" type="checkbox" onclick="toggleEventDateTime();" value="1" <?php if($event->allday){ echo 'checked'; } ?> />&nbsp;<?php echo JText::_('COM_COMMUNITY_EVENTS_ALL_DAY'); ?>
					</span>
				</div>
			</li>

			<?php
			if ($enableRepeat)
			{
			?>
			<li>
				<label for="repeat" class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT'); ?>
				</label>
				<div class="form-field">
					<span class="jomNameTips" original-title="<?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_TIPS'); ?>">
					<span id="repeatcontent"></span>
					<select name="repeat" id="repeat" onChange="toggleEventRepeat()">
						<option value=""><?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_NONE'); ?></option>
						<option value="daily"><?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_DAILY'); ?></option>
						<option value="weekly"><?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_WEEKLY'); ?></option>
						<option value="monthly"><?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_MONTHLY'); ?></option>
					</select>
					</span>

					<span id="repeatendinput">
					<span class="label">&nbsp;&nbsp;*<?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_END'); ?>&nbsp;</span>
					<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_END_TIPS'); ?>">
						<script type="text/javascript">
							<!-- add calendar listener to the field -->
							window.addEvent('domready', function() {Calendar.setup({
							inputField: "repeatend",
							ifFormat: "%Y-%m-%d",
							button: "repeatend",
							singleClick: true,
							firstDay: 0
							});});
						</script>
						<?php

										if (!strtotime($event->repeatend)  || $event->repeatend == '0000-00-00' ) {
											$repeatend = null;
										} else {
											$repeatend = $repeatEndDate->format( 'Y-m-d' );
										}

										echo JHTML::_('calendar',  $repeatend , 'repeatend', 'repeatend', '%Y-%m-%d', array('class'=>'required', 'size'=>'10',  'maxlength'=>'10' , 'readonly' => 'true', 'id'=>'repeatend', 'onchange' => 'updateEventDate();') );?>
						<script type="text/javascript">
							function updateEventDate(){
								var enddate		=   joms.jQuery('#enddate').val();
								var startdate	=   joms.jQuery('#startdate').val();
								var repeatend	=   joms.jQuery('#repeatend').val();

								tmpenddate		=	new Date(enddate);
								tmpstartdate	=   new Date(startdate);
								tmprepeatend    =   new Date(repeatend);

								if(tmprepeatend < tmpstartdate){
									joms.jQuery('#startdate').val( repeatend );
								}

								if(tmprepeatend < tmpenddate){
									joms.jQuery('#enddate').val( repeatend );
								}
							}
						</script>
					</span>
					</span>
					<div class="small" id="repeatlimitdesc"></div>
				</div>
			</li>
			<?php
			}
			?>



			<?php
			if( $config->get('eventshowtimezone') )
			{
			?>
			<li>
				<label class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_TIMEZONE'); ?>
				</label>
				<div class="form-field">
					<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_SET_TIMEZONE'); ?>">
						<select name="offset">
						<?php
						$defaultTimeZone = isset($event->offset)?$event->offset:$systemOffset;
						foreach( $timezones as $offset => $value ){
						?>
							<option value="<?php echo $offset;?>"<?php echo $defaultTimeZone == $offset ? ' selected="selected"' : '';?>><?php echo $value;?></option>
						<?php
						}
						?>
						</select>
					</span>
				</div>
			</li>
			<?php
			}
			?>



			<!-- events tickets -->
			<li class="has-seperator">
				<label for="ticket" class="form-label">
					*<?php echo JText::_('COM_COMMUNITY_EVENTS_NO_SEAT'); ?>
				</label>
				<div class="form-field">
					<input title="<?php echo JText::_('COM_COMMUNITY_EVENTS_NO_SEAT_DESCRIPTION'); ?>" name="ticket" id="ticket" type="text" size="10" maxlength="5" class="required jomNameTips" value="<?php echo (empty($event->ticket)) ? '0' : $this->escape($event->ticket); ?>" />

					<?php
					if( $helper->hasInvitation() )
					{
					?>
					<label for="allowinvite0" class="label-checkbox">
						<input type="checkbox" class="input checkbox" name="allowinvite" id="allowinvite0" value="1"<?php echo ($event->allowinvite ) ? ' checked="checked"' : '';?> />
						<span class="jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_GUEST_INVITE_TIPS'); ?>">
							<?php echo JText::_('COM_COMMUNITY_EVENTS_GUEST_INVITE'); ?>
						</span>
					</label>
					<?php
					}
					?>
				</div>
			</li>



			<?php echo $afterFormDisplay;?>



			<li class="has-seperator">
				<div class="form-field">
					<span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span>
				</div>
			</li>

			<!-- event buttons -->
			<li class="form-action">
				<div class="form-field">
					<?php echo JHTML::_( 'form.token' ); ?>
					<?php if(!$event->id): ?>
					<input name="action" type="hidden" value="save" />
					<?php endif;?>
					<input type="hidden" name="eventid" value="<?php echo $event->id;?>" />
					<input type="hidden" name="repeataction" id="repeataction" value="" />
					<input type="submit" class="button cButton cButton-Blue validateSubmit" value="<?php echo ($event->id) ? JText::_('COM_COMMUNITY_SAVE_BUTTON') : JText::_('COM_COMMUNITY_EVENTS_CREATE_BUTTON');?>" />
					<input type="button" class="button cButton" onclick="history.go(-1);return false;" value="<?php echo JText::_('COM_COMMUNITY_CANCEL_BUTTON');?>" />
				</div>
			</li>
		</ul>
	</form>
</div>
<script type="text/javascript">
	cvalidate.init();
	cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("COM_COMMUNITY_ENTRY_MISSING")); ?>');
	cvalidate.noticeTitle	= '<?php echo addslashes(JText::_('COM_COMMUNITY_NOTICE') );?>';

	/*
		The calendar.js does not display properly under IE when a page has been
		scrolled down. This behaviour is present everywhere within the Joomla site.
		We are injecting our fixes into their code by adding the following
		at the end of the fixPosition() function:
		if (joms.jQuery(el).parents('#community-wrap').length>0)
		{
			var anchor   = joms.jQuery(el);
			var calendar = joms.jQuery(self.element);
			box.x = anchor.offset().left - calendar.outerWidth() + anchor.outerWidth();
			box.y = anchor.offset().top - calendar.outerHeight();
		}
		Unobfuscated version of "JOOMLA/media/system/js/calendar.js" was taken from
		http://www.dynarch.com/static/jscalendar-1.0/calendar.js for reference.
	*/
	joms.jQuery(document).ready(function()
	{
		Calendar.prototype.showAtElement=function(c,d){var a=this;var e=Calendar.getAbsolutePos(c);if(!d||typeof d!="string"){this.showAt(e.x,e.y+c.offsetHeight);return true}function b(j){if(j.x<0){j.x=0}if(j.y<0){j.y=0}var l=document.createElement("div");var i=l.style;i.position="absolute";i.right=i.bottom=i.width=i.height="0px";document.body.appendChild(l);var h=Calendar.getAbsolutePos(l);document.body.removeChild(l);if(Calendar.is_ie){h.y+=document.body.scrollTop;h.x+=document.body.scrollLeft}else{h.y+=window.scrollY;h.x+=window.scrollX}var g=j.x+j.width-h.x;if(g>0){j.x-=g}g=j.y+j.height-h.y;if(g>0){j.y-=g}if(joms.jQuery(c).parents("#community-wrap").length>0){var f=joms.jQuery(c);var k=joms.jQuery(a.element);j.x=f.offset().left-k.outerWidth()+f.outerWidth();j.y=f.offset().top-k.outerHeight()}}this.element.style.display="block";Calendar.continuation_for_the_fucking_khtml_browser=function(){var f=a.element.offsetWidth;var i=a.element.offsetHeight;a.element.style.display="none";var g=d.substr(0,1);var j="l";if(d.length>1){j=d.substr(1,1)}switch(g){case"T":e.y-=i;break;case"B":e.y+=c.offsetHeight;break;case"C":e.y+=(c.offsetHeight-i)/2;break;case"t":e.y+=c.offsetHeight-i;break;case"b":break}switch(j){case"L":e.x-=f;break;case"R":e.x+=c.offsetWidth;break;case"C":e.x+=(c.offsetWidth-f)/2;break;case"l":e.x+=c.offsetWidth-f;break;case"r":break}e.width=f;e.height=i+40;a.monthsCombo.style.display="none";b(e);a.showAt(e.x,e.y)};if(Calendar.is_khtml){setTimeout("Calendar.continuation_for_the_fucking_khtml_browser()",10)}else{Calendar.continuation_for_the_fucking_khtml_browser()}};
		toggleEventDateTime();
		toggleEventRepeat();
	});
</script>
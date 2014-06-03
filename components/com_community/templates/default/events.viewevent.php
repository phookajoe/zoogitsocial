	<?php
/**
 * @package		JomSocial
 * @subpackage	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @params	isMine		boolean is this group belong to me
 * @params	categories	Array An array of categories object
 * @params	members		Array An array of members object
 * @params	event		Event A group object that has the property of a group
 * @params	wallForm	string A html data that will output the walls form.
 * @params	wallContent string A html data that will output the walls data.
 **/
defined('_JEXEC') or die();
CAssets::attach('assets/easytabs/jquery.easytabs.min.js', 'js');
CAssets::attach('assets/ajaxfileupload.pack.js', 'js');
CAssets::attach('assets/joms.jomSelect.js', 'js');
CAssets::attach('assets/imgareaselect/scripts/jquery.imgareaselect.min.js', 'js');
CAssets::attach('assets/imgareaselect/css/imgareaselect-avatar.css', 'css');
$showStream = ($isEventGuest || $isMine || $isAdmin || $isCommunityAdmin || $handler->manageable());
?>

<div class="cLayout cPage cEvent">
	<div class="cPageActions clearfix">
		<div class="cPageAction cFloat-R">
			<?php echo $reportHTML;?>
			<?php echo $bookmarksHTML;?>
		</div>

		<!-- Group Buddy -->
		<?php if( $isAdmin && !$isMine ) { ?>
		<div class="cPageAdmin cFloat-L" title="<?php echo JText::_('COM_COMMUNITY_GROUPS_USER_ADMIN'); ?>">
			<i class="com-icon-award-silver"></i>
			<span><?php echo JText::_('COM_COMMUNITY_GROUPS_USER_ADMIN'); ?></span>
		</div>
		<?php } else if( $isMine || COwnerHelper::isCommunityAdmin()) { ?>
		<div class="cPageOwner cFloat-L" title="<?php echo JText::_('COM_COMMUNITY_EVENTS_USER_CREATOR'); ?>">
			<i class="com-icon-award-gold"></i>
			<span><?php echo JText::_('COM_COMMUNITY_EVENTS_USER_CREATOR'); ?></span>
		</div>
		<?php } ?>
		<!-- Group Buddy -->
	</div>
	<!-- begin: .cLayout -->
	<div class="cLayout">

		<!-- Event Approval -->
		<?php if( $waitingApproval ) { ?>
		<div class="cAlert alert-info">
			<i class="com-icon-waiting"></i>
			<span><?php echo JText::_('COM_COMMUNITY_EVENTS_APPROVEL_WAITING'); ?></span>
		</div>
		<?php }?>


		<?php if( $isInvited ){ ?>
		<div id="events-invite-<?php echo $event->id; ?>" class="cInvite cAlert alert-info clearfix">
			<div class="cInvite-Content">
				<div class="cInvite-Message">
					<?php echo JText::sprintf( 'COM_COMMUNITY_EVENTS_YOUR_INVITED', $join ); $test = 1; ?>
				</div>

				<?php if ($friendsCount) { ?>
				<div class="cInvite-Relations">
					<?php echo JText::sprintf( (CStringHelper::isPlural($friendsCount)) ? 'COM_COMMUNITY_EVENTS_FRIEND' : 'COM_COMMUNITY_EVENTS_FRIEND_MANY', $friendsCount ); ?>
				</div>
				<?php } ?>

				<div class="cInvite-Actions">
					<?php echo JText::_( 'COM_COMMUNITY_EVENTS_RSVP_NOTIFICATION' ) . JText::_('COM_COMMUNITY_OR'); ?>
					<a href="javascript:void(0);" onclick="jax.call('community','events,ajaxRejectInvitation','<?php echo $event->id; ?>');">
						<?php echo JText::_('COM_COMMUNITY_EVENTS_REJECT'); ?>
					</a>
				</div>
			</div>
		</div>
		<?php } ?>

		<!-- begin: .cSidebar -->
		<div class="cSidebar">

			<!-- event administration -->
			<?php if($isMine || $isCommunityAdmin || $isAdmin || $handler->manageable()) { ?>
			<div id="community-event-option" class="cModule cEventControls app-box control-admin collapse">
				<h3 class="app-box-header" href="javascript: void(0)" onclick="joms.apps.toggle('#community-event-option');"><?php echo JText::_('COM_COMMUNITY_EVENTS_ADMIN_OPTION'); ?></h3>
				<div class="app-box-menus">
					<div class="app-box-menu toggle">
						<a class="app-box-menu-icon" href="javascript: void(0)" onclick="joms.apps.toggle('#community-event-option');"></a>
					</div>
				</div>

				<div class="app-box-content" style="display:block">
					<ul class="app-box-list for-menu cResetList">
						<?php if( $isMine || $isCommunityAdmin || $isAdmin) {?>
							<!-- Send email to participants -->
							<li>
								<i class="com-icon-mail-go"></i>
								<a href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=sendmail&eventid=' . $event->id );?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_EMAIL_SEND');?></a>
							</li>
							<!-- Edit Event -->
							<li>
								<i class="com-icon-events-edit"></i>
								<a href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=edit&eventid=' . $event->id );?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_EDIT');?></a>
							</li>
						<?php } ?>

						<?php if( ($event->permission != COMMUNITY_PRIVATE_EVENT) && ($isMine || $isCommunityAdmin || $isAdmin) ){ ?>
							<!-- Copy Event -->
							<li>
								<i class="com-icon-events-import"></i>
								<a href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=create&eventid=' . $event->id );?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_DUPLICATE');?></a>
							</li>
						<?php } ?>


						<?php if( $handler->manageable() ) { ?>
							<!-- Delete Event -->
							<li class="important">
								<i class="com-icon-events-delete"></i>
								<a class="event-delete" href="javascript:void(0);" onclick="javascript:joms.events.deleteEvent('<?php echo $event->id;?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_DELETE'); ?></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
			<!-- end event administration -->

			<?php if( ( $isMine || $isAdmin || $isCommunityAdmin) && ( $unapproved > 0 ) ) { ?>
			<div class="cModule cPage-Approval app-box control-approval">
				<ul class="app-box-list for-menu cResetList">
					<li>
						<i class="com-icon-user-plus"></i>
						<a href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=viewguest&type='.COMMUNITY_EVENT_STATUS_REQUESTINVITE.'&eventid=' . $event->id);?>">
							<?php echo JText::sprintf((CStringHelper::isPlural($unapproved)) ? 'COM_COMMUNITY_EVENTS_PENDING_INVITE_MANY'	 :'COM_COMMUNITY_EVENTS_PENDING_INVITE' , $unapproved ); ?>
						</a>
					</li>
				</ul>
			</div>
			<?php } ?>

			<!-- New Event Response -->
			<?php if( $handler->isAllowed() && !$isPastEvent ) { ?>
			<div id="community-event-rsvp" class="cModule cEvent-Respond app-box">
				<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_EVENTS_YOUR_RSVP'); ?></h3>
				<div class="app-box-content">
					<div class="cEvent-Rsvp">
						<p><?php echo JText::_('COM_COMMUNITY_EVENTS_ATTENDING_QUESTION'); ?></p>
						<select onchange="joms.events.submitRSVP(<?php echo $event->id;?>,this)">
							<?php if($event->getMemberStatus($my->id)==0) { ?><option class="noResponse" selected="selected"><?php echo JText::_('COM_COMMUNITY_GROUPS_INVITATION_RESPONSE')?></option> <?php }?>
							<option class="attend" <?php if($event->getMemberStatus($my->id) == COMMUNITY_EVENT_STATUS_ATTEND){echo "selected='selected'"; }?> value="<?php echo COMMUNITY_EVENT_STATUS_ATTEND; ?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_RSVP_ATTEND')?></option>
							<option class="notAttend" <?php if($event->getMemberStatus($my->id) >= COMMUNITY_EVENT_STATUS_WONTATTEND ){echo "selected='selected'"; }?> value="<?php echo COMMUNITY_EVENT_STATUS_WONTATTEND; ?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_RSVP_NOT_ATTEND')?></option>
						</select>
					</div>
				</div>
			</div>
			<?php }?>
			<!-- Event Response -->

			<div id="community-event-members" class="cModule cEvent-Member app-box">

				<h3 class="app-box-header"><?php echo JText::sprintf('COM_COMMUNITY_EVENTS_CONFIRMED_GUESTS'); ?></h3>
				<?php if($eventMembersCount>0){ ?>
					<div class="app-box-content">
						<ul class="cThumbsList cResetList clearfix">
							<?php
							if($eventMembers) {
								foreach($eventMembers as $member) {
							?>
								<li>
									<a href="<?php echo CUrlHelper::userLink($member->id); ?>">
										<img class="cAvatar jomNameTips" src="<?php echo $member->getThumbAvatar(); ?>" title="<?php echo CTooltip::cAvatarTooltip($member);?>" alt="" />
									</a>
								</li>
							<?php
								}
							}
							?>
						</ul>
					</div>
					<div class="app-box-footer">
						<a href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=viewguest&eventid=' . $event->id . '&type='.COMMUNITY_EVENT_STATUS_ATTEND );?>">
							<?php echo JText::_('COM_COMMUNITY_VIEW_ALL');?> (<?php echo $eventMembersCount; ?>)
						</a>
						<?php if( ( ($isEventGuest && ($event->allowinvite)) || $isMine || $isCommunityAdmin || $isAdmin ) && $handler->hasInvitation() && $handler->isExpired()) { ?>
							<span class="cFloat-L"><?php echo $inviteHTML; ?></span>
						<?php } ?>
					</div>
				<?php }
				else
				echo JText::_('COM_COMMUNITY_EVENTS_NO_USER_ATTENDING_MESSAGE')
				?>
			</div>


			<!-- begin: map -->
			<?php if( $config->get('eventshowmap') && ( $handler->isAllowed() || $event->permission != COMMUNITY_PRIVATE_EVENT ) ) {	?>
				<?php

				if(CMapping::validateAddress($event->location)){
					?>
					<div id="community-event-map" class="cModule cEvent-Map app-box">
						<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_MAP_LOCATION');?></h3>
						<div class="app-box-content event-description">
							<!-- begin: dynamic map -->
							<?php echo CMapping::drawMap('event-map', $event->location); ?>
							<div id="event-map" style="height:210px;width:100%;margin:5px 0;">
								<?php echo JText::_('COM_COMMUNITY_MAPS_LOADING'); ?>
							</div>
							<!-- end: dynamic map -->
							<div class="event-address small"><?php echo CMapping::getFormatedAdd($event->location); ?></div>
						</div>
						<div class="app-box-footer">
							<a href="http://maps.google.com/?q=<?php echo urlencode($event->location); ?>" target="_blank"><?php echo JText::_('COM_COMMUNITY_EVENTS_FULL_MAP'); ?></a>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			<!-- end: map -->

			<?php $this->renderModules( 'js_side_top' ); ?>
			<?php $this->renderModules( 'js_events_side_top' ); ?>

			<!-- Event Menu -->
			<?php if($memberStatus != COMMUNITY_EVENT_STATUS_BLOCKED) { ?>
			<div id="community-event-action" class="cModule cEvent-Extra app-box">
				<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_EVENTS_OPTION'); ?></h3>
				<div class="app-box-content">
					<!-- Event Menu List -->
					<ul class="app-box-list for-menu cResetList">
						<?php if( $handler->showPrint() ) { ?>
						<!-- Print Event -->
						<li>
							<i class="com-icon-printer"></i>
							<a href="javascript:void(0)" onclick="window.open('<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=printpopup&eventid='.$event->id); ?>','', 'menubar=no,width=600,height=700,toolbar=no');"><?php echo JText::_('COM_COMMUNITY_EVENTS_PRINT');?></a>
						</li>
						<?php } ?>

						<?php if( $handler->showExport() && $config->get('eventexportical') ) { ?>
						<!-- Export Event -->
						<li>
							<i class="com-icon-events-import"></i>
							<a href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=export&format=raw&eventid=' . $event->id); ?>" ><?php echo JText::_('COM_COMMUNITY_EVENTS_EXPORT_ICAL');?></a>
						</li>
						<?php } ?>

						<?php if( (!$isEventGuest) && ($event->permission == COMMUNITY_PRIVATE_EVENT) && (!$waitingApproval)) { ?>
						<!-- Join Event -->
						<li>
							<i class="com-icon-events-plus"></i>
							<a href="javascript:void(0);" onclick="javascript:joms.events.join('<?php echo $event->id;?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_INVITE_REQUEST'); ?></a>
						</li>
						<?php } ?>

						<?php if( (!$isMine) && !($waitingRespond) && (COwnerHelper::isRegisteredUser()) ) { ?>
						<!-- Leave Event -->
						<li class="important">
							<i class="com-icon-events-delete"></i>
							<a href="javascript:void(0);" onclick="joms.events.leave('<?php echo $event->id;?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_IGNORE');?></a>
						</li>
						<?php } ?>
					</ul>
					<!-- Event Menu List -->
				</div>
			</div>
			<!-- end #community-event-action -->

			<?php } ?>
			<!-- Event Menu -->

			<!-- Event in the series -->
			<?php if ($eventSeries && $seriesCount > 1) { ?>
			<div class="cGroup-Events cModule">
				<h3><?php echo JText::_('COM_COMMUNITY_EVENTS_SERIES');?></h3>
				<div class="app-box-content">
					<div id="community-group-container">
						<ul class="cResetList">
						<?php
						$grouplink = '';
						if ($event->contentid > 0) {
							$grouplink = '&groupid=' . $event->contentid;
						}

						foreach( $eventSeries as $series ) {
						?>
							<li class="jsRel jomNameTips" title="<?php echo $this->escape( $series->summary );?>">
								<div class="event-date jsLft">
									<div><?php echo CEventHelper::formatStartDate($series, $config->get('eventdateformat') ); ?></div>
									<div><img class="cAvatar jsLft" src="<?php echo $series->getThumbAvatar();?>" alt="<?php echo $this->escape( $series->title );?>" /></div>
								</div>
								<div class="event-detail jsDetail">
									<div class="event-title small">
										<b><a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewevent&eventid=' . $series->id . $grouplink);?>">
											<?php echo $series->title;?>
										</a></b>
									</div>
									<div class="event-loc small">
										<?php echo $series->location;?>
									</div>
									<div class="event-attendee small">
										<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewguest&eventid=' . $series->id . $grouplink);?>"><?php echo JText::sprintf((cIsPlural($series->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT_MANY':'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT', $series->confirmedcount);?></a>
									</div>
								</div>
								<div class="clr"></div>
							</li>
						<?php } ?>
						</ul>
					</div>
				</div>

				<div class="app-box-footer">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=events' . $grouplink . '&parent=' . $event->parent);?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_VIEW_SERIES'). '(' . $seriesCount . ')';?></a>
				</div>
			</div>
			<?php } ?>
			<!-- Event in the series -->

		<?php $this->renderModules( 'js_events_side_bottom' ); ?>
		<?php $this->renderModules( 'js_side_bottom' ); ?>
		</div>
		<!-- end: .cSidebar -->

		<!-- begin: .cMain -->
		<div class="cMain">

			<div class="cPageHeader">
				<div class="cPageAvatar cFloat-L">
					<div>
						<img src="<?php echo $event->getAvatar( 'avatar' ); ?>" border="0" alt="<?php echo $this->escape($event->title);?>" />

						<?php if ($isAdmin || $isCommunityAdmin || $isMine) { ?>
						<b>
							<a href="javascript:void(0)" onclick="joms.events.uploadAvatar('event','<?php echo $event->id?>', '<?php echo $event->isRecurring();?>')"><?php echo JText::_('COM_COMMUNITY_CHANGE_AVATAR')?></a>
						</b>
						<?php } ?>
					</div>

					<span class="cPage-Like" id="like-container"><?php echo $likesHTML; ?></span>
				</div>

				<div class="cPageInfo">
					<ul class="cPageInfo-List cResetList">
						<li class="info-row event-category">
							<b><?php echo JText::_('COM_COMMUNITY_EVENTS_CATEGORY'); ?>:</b>
							<div>
								<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&categoryid=' . $event->catid);?>"><?php echo JText::_( $event->getCategoryName() ); ?></a>
							</div>
						</li>
						<li class="info-row event-created">
							<b><?php echo JText::_('COM_COMMUNITY_EVENTS_TIME')?></b>
							<div>
								<?php echo ($allday) ? JText::sprintf('COM_COMMUNITY_EVENTS_ALLDAY_DATE',$event->startdateHTML) : JText::sprintf('COM_COMMUNITY_EVENTS_DURATION',$event->startdateHTML,$event->enddateHTML); ?>
								<?php if( $config->get('eventshowtimezone') ) { ?>
									<div class="small"><?php echo $timezone; ?></div>
								<?php } ?>
							</div>
						</li>

			    		<!-- Location info -->
						<li class="info-row event-location">
							<b><?php echo JText::_('COM_COMMUNITY_EVENTS_LOCATION');?></b>
							<div id="community-event-data-location">
								<a href="http://maps.google.com/?q=<?php echo urlencode($event->location); ?>" target="_blank"><?php echo $event->location; ?></a>
							</div>
						</li>

						<!--Event Summary-->
						<li class="info-row event-summary">
							<b><?php echo JText::_('COM_COMMUNITY_EVENTS_VIEW_SUMMARY');?></b>
							<div>
								<?php echo $event->summary; ?>
							</div>
						</li>

						<!--Event Occurence -->
						<?php if ($event->isRecurring()) { ?>
						<li class="info-row event-occurence">
							<b><?php echo JText::_('COM_COMMUNITY_EVENTS_OCCURENCE');?></b>
							<div>
								<?php echo JText::_('COM_COMMUNITY_EVENTS_REPEAT_' . strtoupper($event->repeat)); ?>
							</div>
						</li>
						<?php }?>

						<!--Event Admins-->
						<li class="info-row event-admins">
							<b><?php echo JText::_('COM_COMMUNITY_EVENTS_ADMINS')?></b>
							<div>
								<?php echo $adminsList;?>
							</div>
						</li>

						<!-- Number of tickets -->
						<li class="info-row event-tickets">
							<b><?php echo JText::_('COM_COMMUNITY_EVENTS_SEATS_AVAILABLE');?></b>
							<div>
							<?php
								if($event->ticket)
									echo JText::sprintf('COM_COMMUNITY_EVENTS_TICKET_STATS', $event->ticket, $eventMembersCount, ($event->ticket - $eventMembersCount));
								else
									echo JText::sprintf('COM_COMMUNITY_EVENTS_UNLIMITED_SEAT');
							?>
							</div>
						</li>
					</ul>
				</div>
			</div>


		<!-- Global Application Tab bar framework -->
		<div class="cTabsBar clearfull">
			<ul class="cPageTabs cResetList cFloatedList clearfix">
				<li <?php if( $showStream ) {echo 'class="cTabCurrent"';} else {echo 'class="cTabDisabled"';} ?>><a href="javascript:void(0)"><?php echo JText::_('COM_COMMUNITY_FRONTPAGE_RECENT_ACTIVITIES');?></a></li>
				<li <?php if(!$isEventGuest) {echo 'class="cTabCurrent"';} ?>><a href="javascript:void(0)"><?php echo JText::_('COM_COMMUNITY_EVENTS_DETAIL');?></a></li>
				<!--li <?php if(!$isEventGuest) {echo 'class="cTabDisabled"';} ?>><a href="javascript:void(0)">Event Program</a></li-->
			</ul>
		</div>
		<!-- END: Global Application Tab bar framework -->

		<!-- START: Global Application Tab bar contents -->
		<div class="cTabsContentWrap">

			<!-- Tab 1: Activity Stream Container -->
			<?php if( $showStream ) { ?>
			<div class="cTabsContent  <?php if($showStream) {echo 'cTabsContentCurrent';} ?>">
				<!-- Stream -->
				 <?php if( $showStream ) { $status->render(); } ?>
				<div class="cActivity cEvent-Activity" id="activity-stream-container">
					<div class="cActivity-LoadLatest cActivity-Button joms-latest-activities-container">
						<a id="activity-update-click" href="javascript:void(0);"></a>
					</div>
					<?php echo $streamHTML; ?>
				</div>
				<!-- end: stream -->
			</div>
			<?php } ?>
			<!-- Tab 1: END -->

			<!-- Tab 2: Event Details -->
			<div class="cTabsContent <?php if(!$isEventGuest) {echo 'cTabsContentCurrent';} ?>">
				<div class="cEvent-Description">
					<?php
					if( !CStringHelper::isHTML($event->description) )
					{
						echo CStringHelper::nl2br($event->description);
					}
					else
					{
						echo $event->description;
					}
					?>
				</div>
			</div>
			<!-- Tab 2: END -->
		</div>
		<!-- END: Global Application Tab bar contents -->

	</div>

</div>
<!-- end: .cLayout -->
</div>
<script type="text/javascript">
      joms.jQuery(function(){
        joms.jQuery("select").jomSelect();
      });
</script>
<?php if($editEvent) {?>
<script type="text/javascript">
	joms.events.edit();
</script>
<?php } ?>

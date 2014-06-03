<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @params	isMine		boolean is this group belong to me
 * @params	members		Array	An array of members object
 * @params	group		Group	A group object that has the property of a group
 * @params	wallForm	string A html data that will output the walls form.
 **/

defined('_JEXEC') or die();
CAssets::attach('assets/easytabs/jquery.easytabs.min.js', 'js');
CAssets::attach('assets/ajaxfileupload.pack.js', 'js');
CAssets::attach('assets/imgareaselect/scripts/jquery.imgareaselect.min.js', 'js');
CAssets::attach('assets/imgareaselect/css/imgareaselect-avatar.css', 'css');
?>

<div class="cLayout cPage cGroup">
	<div class="cPageActions clearfix">
		<div class="cPageAction cFloat-R">
			<?php echo $reportHTML;?>
			<?php echo $bookmarksHTML;?>
		</div>

		<?php if( $isAdmin && !$isMine ) { ?>
		<div class="cPageAdmin cFloat-L">
			<i class="com-icon-award-silver"></i>
			<span><?php echo JText::_('COM_COMMUNITY_GROUPS_USER_ADMIN'); ?></span>
		</div>
		<?php } else if( $isMine || $isSuperAdmin) { ?>
		<div class="cPageOwner cFloat-L">
			<i class="com-icon-award-gold"></i>
			<span><?php echo JText::_('COM_COMMUNITY_GROUPS_USER_CREATOR'); ?></span>
		</div>
		<?php }?>
	</div>





	<?php if( $waitingApproval ) { ?>
	<div class="cAlert alert-info">
		<i class="com-icon-waiting"></i>
		<span><?php echo JText::_('COM_COMMUNITY_GROUPS_APPROVAL_PENDING'); ?></span>
	</div>
	<?php }?>

	<?php if($isInvited){ ?>
	<div id="groups-invite-<?php echo $group->id; ?>" class="cInvite cAlert alert-info">

		<div class="cInvite-Message">
			<?php echo JText::sprintf( 'COM_COMMUNITY_GROUPS_YOU_INVITED', $join); ?>
		</div>
		<div class="cInvite-Relations">
			<p><?php echo JText::sprintf( (CStringHelper::isPlural($friendsCount)) ? 'COM_COMMUNITY_GROUPS_FRIEND' : 'COM_COMMUNITY_GROUPS_FRIEND_MANY', $friendsCount ); ?></p>
		</div>

		<div class="cInvite-Actions">
			<a href="javascript:void(0);" onclick="jax.call('community','groups,ajaxAcceptInvitation','<?php echo $group->id; ?>');" class="cButton cButton-Blue">
				<?php echo JText::_('COM_COMMUNITY_EVENTS_ACCEPT'); ?>
			</a>
			<a href="javascript:void(0);" onclick="jax.call('community','groups,ajaxRejectInvitation','<?php echo $group->id; ?>');" class="cButton">
				<?php echo JText::_('COM_COMMUNITY_EVENTS_REJECT'); ?>
			</a>
		</div>
	</div>
	<?php } ?>





	<!-- begin: .cSidebar -->
	<div class="cSidebar">

	<?php $this->renderModules( 'js_side_top' ); ?>
	<?php $this->renderModules( 'js_groups_side_top' ); ?>

		<!-- Group's Controller -->
		<?php if( $isMine || $isSuperAdmin || $isAdmin ) { ?>
		<div id="community-group-admin" class="cModule cGroups-Control app-box control-admin collapse">
			<h3 class="app-box-header" href="javascript: void(0)" onclick="joms.apps.toggle('#community-group-admin');">
				<?php echo JText::_('COM_COMMUNITY_GROUPS_ADMIN_OPTION'); ?>
			</h3>
			<div class="app-box-menus">
				<div class="app-box-menu toggle">
					<a class="app-box-menu-icon" href="javascript: void(0)" onclick="joms.apps.toggle('#community-group-admin');"></a>
				</div>
			</div>

			<div class="app-box-content" style="display:block;">
				<ul class="app-box-list for-menu cResetList">
					<?php if( $isAdmin || $isSuperAdmin ) { ?>
						<!-- Edit Group -->
						<li>
							<i class="com-icon-groups-edit"></i>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=edit&groupid=' . $group->id );?>">
							<?php echo JText::_('COM_COMMUNITY_GROUPS_EDIT');?>
							</a>
						</li>
					<?php } ?>

					<?php if( $isAdmin || $isSuperAdmin){ ?>
						<li>
							<i class="com-icon-mail-go"></i>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=sendmail&groupid=' . $group->id );?>" class="community-invite-email">
								<?php echo JText::_('COM_COMMUNITY_GROUPS_SENDMAIL');?>
							</a>
						</li>
					<?php } ?>

					<?php if( $config->get('createannouncement') && ($isAdmin || $isSuperAdmin) ): ?>
						<!-- Add Bulletin -->
						<li>
							<i class="com-icon-bell-plus"></i>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=addnews&groupid=' . $group->id );?>">
							<?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_CREATE');?>
							</a>
						</li>
					<?php endif; ?>

					<?php if( $isSuperAdmin ) { ?>
						<!-- Unpublish Group -->
						<li>
							<i class="com-icon-groups-lock"></i>
							<a href="javascript:void(0);" onclick="javascript:joms.groups.unpublish('<?php echo $group->id;?>');">
							<?php echo JText::_('COM_COMMUNITY_GROUPS_UNPUBLISH'); ?>
							</a>
						</li>
					<?php } ?>

					<?php if( $isSuperAdmin || ($isMine)) { ?>
						<!-- Delete Group -->
						<li class="important">
							<i class="com-icon-groups-delete"></i>
							<a href="javascript:void(0);" onclick="javascript:joms.groups.deleteGroup('<?php echo $group->id;?>');">
							<?php echo JText::_('COM_COMMUNITY_GROUPS_DELETE_GROUP_BUTTON'); ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<?php } ?>
		<!-- Group's Controller -->



		<!-- Group's Approval -->
		<?php if( ( $isMine || $isAdmin || $isSuperAdmin) && ( $unapproved > 0 ) ) { ?>
		<div class="cModule cPage-Approval app-box control-approval">
			<ul class="app-box-list for-menu cResetList">
				<li>
					<i class="com-icon-user-plus"></i>
					<a class="friend" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewmembers&approve=1&groupid=' . $group->id);?>">
						<?php echo JText::sprintf((CStringHelper::isPlural($unapproved)) ? 'COM_COMMUNITY_GROUPS_APPROVAL_NOTIFICATION_MANY'  :'COM_COMMUNITY_GROUPS_APPROVAL_NOTIFICATION' , $unapproved ); ?>
					</a>
				</li>
			</ul>
		</div>
		<?php } ?>
		<!-- Group's Approval -->



		<!-- Group's Controller -->
		<?php if( ($isMember && !$isBanned) || ((!$isMember && !$isBanned) && !$waitingApproval) || $isMine || $isAdmin || $isSuperAdmin ) { ?>
		<div class="cModule cGroups-Options app-box">
			<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_GROUPS_OPTION'); ?></h3>

			<div class="app-box-content">
				<ul class="app-box-list for-menu cResetList">
					<?php if( $config->get('creatediscussion') && ( ($isMember && !$isBanned) && !($waitingApproval) || $isSuperAdmin) ): ?>
					<!-- Add Discussion -->
					<li>
						<i class="com-icon-comment-plus"></i>
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=adddiscussion&groupid=' . $group->id );?>">
						<?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION_CREATE');?>
						</a>
					</li>
					<?php endif; ?>

					<?php if( $allowCreateEvent && $config->get('group_events') && $config->get('enableevents') && ($config->get('createevents') || COwnerHelper::isCommunityAdmin()) ) { ?>
					<li>
						<i class="com-icon-events-plus"></i>
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=create&groupid=' . $group->id);?>">
						<?php echo JText::_('COM_COMMUNITY_GROUPS_CREATE_EVENT');?>
						</a>
					</li>

						<?php if( $config->get('event_import_ical')) { ?>
						<li>
							<i class="com-icon-events-import"></i>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=import&groupid=' . $group->id);?>">
							<?php echo JText::_('COM_COMMUNITY_GROUPS_IMPORT_EVENT');?>
							</a>
						</li>
						<?php }?>
					<?php } ?>

					<?php if( $allowManagePhotos  && $config->get('groupphotos') && $config->get('enablephotos') ) { ?>
					<?php if( $albums ) { ?>
					<!-- Add Photo -->
					<li>
						<i class="com-icon-photos-plus"></i>
						<a href="javascript:void(0);" onclick="joms.notifications.showUploadPhoto('','<?php echo $group->id; ?>'); return false;">
						<?php echo JText::_('COM_COMMUNITY_PHOTOS_UPLOAD_PHOTOS');?>
						</a>
					</li>
					<?php } ?>

					<!-- Add Album -->
					<li>
						<i class="com-icon-album-plus"></i>
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&groupid=' . $group->id . '&task=newalbum');?>">
						<?php echo JText::_('COM_COMMUNITY_PHOTOS_CREATE_ALBUM_BUTTON');?>
						</a>
					</li>
					<?php } ?>

					<?php if( $allowManageVideos && $config->get('groupvideos') && $config->get('enablevideos') ){ ?>
					<!-- Add Video -->
					<li>
						<i class="com-icon-videos-plus"></i>
						<a href="javascript:void(0)" onclick="joms.videos.addVideo('<?php echo VIDEO_GROUP_TYPE; ?>', '<?php echo $group->id; ?>')">
						<?php echo JText::_('COM_COMMUNITY_VIDEOS_ADD');?>
						</a>
					</li>
					<?php } ?>

					<?php if( (!$isMember && !$isBanned) && !($waitingApproval) ) { ?>
					<!-- Join Group -->
					<li>
						<i class="com-icon-groups-plus"></i>
						<a class="group-join" href="javascript:void(0);" onclick="javascript:joms.groups.join(<?php echo $group->id;?>,'yes');">
						<?php echo JText::_('COM_COMMUNITY_GROUPS_JOIN'); ?>
						</a>
					</li>
					<?php } ?>
					<?php if( ($isAdmin) || ($isMine) || ($isMember && !$isBanned) ) { ?>
					<!-- Invite Friend -->
					<li>
						<i class="com-icon-groups-plus"></i>
						<?php echo $inviteHTML;?>
					</li>
					<?php } ?>
					<!--View Available File-->
					<?php if( (($isAdmin) || ($isMine) || ($isMember && !$isBanned)) && $isFile) { ?>
					<li>
						<i class="com-icon-drawer"></i>
						<a href="javascript:void(0)" onClick="joms.file.viewFile('group',<?php echo $group->id?>)"><?php echo JText::_('COM_COMMUNITY_FILES_VIEW_GROUP')?></a>
					</li>
					<?php } ?>
					<?php if( ($isMember && !$isBanned) && (!$isMine) && !($waitingApproval) && (COwnerHelper::isRegisteredUser()) ) { ?>
					<!-- Leave Group -->
					<li>
						<i class="com-icon-door-out"></i>
						<a href="javascript:void(0);" onclick="joms.groups.leave('<?php echo $group->id;?>');">
						<?php echo JText::_('COM_COMMUNITY_GROUPS_LEAVE');?>
						</a>
					</li>
					<?php } ?>

				</ul>
			</div>
			<?php } else {?>
			<?php echo JText::_('COM_COMMUNITY_GROUPS_BANNED_OPTION'); ?>
			<?php } ?>
		</div>
		<!-- Group's Controller -->


	<!-- Group's Module' -->
	<?php if( $group->approvals=='0' || $isMine || ($isMember && !$isBanned) || $isSuperAdmin ) { ?>


		<!-- Group's Members @ Sidebar -->
		<?php if($members){ ?>
		<div class="cModule cGroups-Members app-box">
			<h3 class="app-box-header"><?php echo JText::sprintf('COM_COMMUNITY_GROUPS_MEMBERS'); ?></h3>

			<div class="app-box-content">
				<ul class="cThumbsList cResetList clearfix">
				<?php foreach($members as $member) { ?>
					<li>
						<a href="<?php echo CUrlHelper::userLink($member->id); ?>">
							<img border="0" class="cAvatar jomNameTips" src="<?php echo $member->getThumbAvatar(); ?>" title="<?php echo CTooltip::cAvatarTooltip($member);?>" alt="<?php echo CTooltip::cAvatarTooltip($member);?>" />
						</a>
					</li>
				<?php if(--$limit < 1) break; } ?>
				</ul>
			</div>

			<div class="app-box-footer">
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewmembers&groupid=' . $group->id);?>">
					<?php echo JText::_('COM_COMMUNITY_VIEW_ALL');?> (<?php echo $membersCount; ?>)
				</a>
			</div>
		</div>
		<?php } ?>
		<!-- Group's Members @ Sidebar -->


		<!-- Group Events @ Sidebar -->
		<?php if( $showEvents ){ ?>
		<div class="cModule app-box">
			<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_EVENTS');?></h3>

			<div class="app-box-content">
				<?php if( $events ){ ?>
				<ul class="cThumbDetails cResetList">
				<?php
				foreach( $events as $event )
				{
					$creator			= CFactory::getUser($event->creator);
				?>
					<li>
						<b class="cThumb-Calendar cFloat-L">
							<b><?php echo CEventHelper::formatStartDate($event, JText::_('M') ); ?></b>
							<b><?php echo CEventHelper::formatStartDate($event, JText::_('d') ); ?></b>
						</b>
						<div class="cThumb-Detail">
							<div class="event-detail">
								<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewevent&eventid=' . $event->id.'&groupid=' . $group->id);?>" class="cThumb-Title">
									<?php echo $event->title;?>
								</a>
								<div class="cThumb-Location">
									<?php // echo $event->getCategoryName();?>
									<?php echo $event->location;?>
								</div>
								<!-- <div class="eventTime"><?php echo JText::sprintf('COM_COMMUNITY_EVENTS_DURATION', JHTML::_('date', $event->startdate, JText::_('DATE_FORMAT_LC2') ), JHTML::_('date', $event->enddate, JText::_('DATE_FORMAT_LC2') )); ?></div> -->
								<div class="cThumb-Members small">
									<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewguest&groupid=' . $group->id . '&eventid=' . $event->id . '&type='.COMMUNITY_EVENT_STATUS_ATTEND);?>"><?php echo JText::sprintf((cIsPlural($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_MANY_GUEST_COUNT':'COM_COMMUNITY_EVENTS_GUEST_COUNT', $event->confirmedcount);?></a>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
				</ul>
				<?php } else { ?>
				<div class="cEmpty"><?php echo JText::_('COM_COMMUNITY_EVENTS_NOT_CREATED');?></div>
				<?php } ?>
			</div>
			<div class="app-box-footer">
				<!-- <div class="app-box-info"><?php echo JText::sprintf( 'COM_COMMUNITY_EVENTS_COUNT_DISPLAY' , count($events) , $totalEvents ); ?></div> -->
				<?php if( $allowCreateEvent && ($isMember && !$isBanned) ) { ?>
				<a class="cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=create&groupid=' . $group->id );?>">
					<?php echo JText::_('COM_COMMUNITY_GROUPS_CREATE_EVENT');?>
				</a>
				<?php }	?>
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&groupid=' . $group->id );?>">
					<?php echo JText::_('COM_COMMUNITY_EVENTS_ALL_EVENTS');?>
				</a>
			</div>
		</div>
		<?php } ?>
		<!-- Group Events @ Sidebar -->


		<!-- Group Photo @ Sidebar -->
		<?php if( $config->get('enablephotos') && $config->get('groupphotos') && $showPhotos){ ?>
		<?php // if($this->params->get('groupsPhotosPosition') == 'js_groups_side_bottom'){ ?>
		<?php if( $albums ) { ?>
		<div class="cModule cGroupPhotos app-box">
			<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_PHOTOS_PHOTO_ALBUMS');?></h3>

			<div class="app-box-content">
				<ul class="cThumbsList cResetList clearfix">
					<?php foreach($albums as $album ) { ?>
					<li>
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $album->id . '&groupid=' . $group->id);?>">
							<img class="cAvatar cMediaAvatar jomNameTips" title="<?php echo $this->escape( $album->name );?>" src="<?php echo $album->getCoverThumbURI();?>" alt="<?php echo $album->getCoverThumbURI();?>" />
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>

			<div class="app-box-footer">
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&groupid=' . $group->id );?>">
					<?php echo JText::_('COM_COMMUNITY_VIEW_ALL_ALBUMS').' ('.count($albums).')';?>
				</a>
			</div>
		</div>
		<?php } ?>
		<?php // } ?>
		<?php } ?>
		<!-- Group Photo @ Sidebar -->


		<!-- Group Video @ Sidebar -->
		<?php if($config->get('enablevideos') && $config->get('groupvideos') && $showVideos){ ?>
		<?php // if($this->params->get('groupsVideosPosition') == 'js_groups_side_bottom'){ ?>
		<?php if($videos) { ?>
		<div class="cModule cGroupVideo app-box">
			<h3 class="app-box-header cResetH"><?php echo JText::_('COM_COMMUNITY_VIDEOS');?></h3>

			<div class="app-box-content">
				<ul class="cThumbsList cResetList clearfix">
				<?php foreach( $videos as $video ) { ?>
					<li>
						<a class="cVideo-Thumb jomNameTips" href="<?php echo $video->getURL(); ?>" title="<?php echo $video->title; ?>">
							<img src="<?php echo $video->getThumbnail(); ?>" class="cAvatar cMediaAvatar" />
							<b class="cVideo-Duration"><?php echo $video->getDurationInHMS(); ?></b>
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>

			<div class="app-box-footer">
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos&groupid='.$group->id); ?>">
					<?php echo JText::_('COM_COMMUNITY_VIDEOS_ALL').' ('.$totalVideos.')'; ?>
				</a>
			</div>
		</div>
		<?php } ?>
		<?php // } ?>
		<?php } ?>
	<?php } ?>


	<?php $this->renderModules( 'js_groups_side_bottom' ); ?>
	<?php $this->renderModules( 'js_side_bottom' ); ?>

	</div>
	<!-- end: .cSidebar -->

	<!-- begin: .cMain -->
	<div class="cMain">

		<div class="cPageHeader">
			<!-- Page Avatar -->
			<div class="cPageAvatar cFloat-L">
				<div>
					<img src="<?php echo $group->getAvatar( 'avatar' ); ?>" border="0" alt="<?php echo $this->escape($group->name);?>" />

					<?php if ($isAdmin || $isSuperAdmin || $isMine) { ?>
					<b>
						<a href="javascript:void(0)" onclick="joms.photos.uploadAvatar('group','<?php echo $group->id?>')"><?php echo JText::_('COM_COMMUNITY_CHANGE_AVATAR')?></a>
					</b>
					<?php } ?>
				</div>

				<span class="cPage-Like" id="like-container"><?php echo $likesHTML; ?></span>
			</div>
			<!-- Page Avatar -->

			<!-- Group Top: Group Main -->
			<div class="cPageInfo">
				<ul class="cPageInfo-List cResetList">
					<li class="cGroup-Category">
						<b><?php echo JText::_('COM_COMMUNITY_GROUPS_CATEGORY'); ?>:</b>
						<div class="info-data">
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=display&categoryid=' . $group->categoryid);?>"><?php echo JText::_( $group->getCategoryName() ); ?></a>
						</div>
					</li>

					<li class="cGroup-Created">
						<b><?php echo JText::_('COM_COMMUNITY_GROUPS_CREATE_TIME');?>:</b>
						<div class="info-data">
							<?php echo JHTML::_('date', $group->created, JText::_('DATE_FORMAT_LC')); ?>
						</div>
					</li>

					<li class="cGroup-Owner">
						<b><?php echo JText::_('COM_COMMUNITY_GROUPS_ADMINS');?>:</b>
						<div class="info-data">
							<?php echo $adminsList;?>
						</div>
					</li>
				</ul>
			</div>
		</div>


		<!-- Application Tabs' Toolbar -->
		<div class="cTabsBar clearfull">
			<ul class="cPageTabs cResetList cFloatedList clearfix">
				<li <?php if($isMember || $isSuperAdmin) {echo 'class="cTabCurrent"';} else if($isPrivate){echo 'class="cTabDisabled"';} ?>>
					<a href="javascript:void(0)"><?php echo JText::_('COM_COMMUNITY_FRONTPAGE_RECENT_ACTIVITIES');?><?php if($alertNewStream){ echo '<span></span>'; } ?></a>
				</li>
				<li <?php if(!$isMember &&!$isSuperAdmin ) {echo 'class="cTabCurrent"';} ?>>
					<a href="javascript:void(0)"><?php echo JText::_('COM_COMMUNITY_GROUPS_DESCRIPTION');?></a>
				</li>
				<?php if($config->get('createannouncement')) { ?>
				<li <?php if((!$isMember && !$isSuperAdmin) || ($isPrivate && !$isMember)) {echo 'class="cTabDisabled"';} ?>>
					<a href="javascript:void(0)"><?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN');?><?php if($alertNewBulletin){ echo '<span></span>'; } ?></a>
				</li>
				<?php } ?>
				<?php if($config->get('creatediscussion') ){?>
				<li <?php if(!$isMember && !$isSuperAdmin && $isPrivate) { echo 'class="cTabDisabled"'; } ?>>
					<a href="javascript:void(0)"><?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION');?><?php if($alertNewDiscussion){ echo '<span></span>'; } ?></a>
				</li>
			</ul>	<?php }?>
		</div>
		<!-- Application Tabs' Toolbar -->

		<!-- Application Tabs's Content -->
		<div class="cTabsContentWrap">

			<!-- Tab Content : Activity Stream -->
			<?php
				if( $group->approvals=='0' || $isMine || ($isMember && !$isBanned) || $isSuperAdmin )
				{
			?>
			<div class="cTabsContent  <?php if($isMember || $isSuperAdmin) {echo 'cTabsContentCurrent';} ?>">

				<?php if($isMember || $isSuperAdmin) { $status->render(); } ?>
				<div class="cActivity cGroup-Activity" id="activity-stream-container">
					<div class="cActivity-LoadLatest cActivity-Button joms-latest-activities-container">
						<a id="activity-update-click" href="javascript:void(0);"></a>
					</div>

					<?php echo $streamHTML; ?>
					
					<div class="cActivity-LoadMore cActivity-Button joms-newsfeed-more" id="activity-more">
                        			<a class="more-activity-text" href="javascript:void(0);" onclick="joms.activities.more();">
						<?php echo JText::_('COM_COMMUNITY_MORE');?>
						</a>
						<div class="loading"></div>
                    			</div>
				</div>

			</div>
			<?php
				}
			?>
			<!-- Tab Content : Activity Stream -->


			<!-- Tab Content : Description -->
			<div class="cTabsContent <?php if(!$isMember && !$isSuperAdmin) {echo 'cTabsContentCurrent';} ?>">

				<div class="cGroup-Description">
					<?php echo $group->description; ?>
				</div>

			</div>
			<!-- Tab Content : Description -->


			<!-- Tab Content : Announcements -->
			<?php
				if( $group->approvals=='0' || $isMine || ($isMember && !$isBanned) || $isSuperAdmin )
				{
					if( $config->get('createannouncement') )
					{
			?>
			<div class="cTabsContent">

				<div class="cGroup-Announcments">
					<?php echo $bulletinsHTML; ?>

					<div class="cUpdatesHelper small clearfull">
						<span class="updates-options cFloat-R">
							<?php if( $isAdmin || $isSuperAdmin ): ?>
							<a class="app-box-action" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=addnews&groupid=' . $group->id );?>"><?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_CREATE');?></a>
							<?php endif; ?>

							<?php if( $bulletins ): ?>
							<a class="app-box-action" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewbulletins&groupid=' . $group->id);?>"><?php echo JText::_('COM_COMMUNITY_GROUPS_BULLETIN_VIEW_ALL');?></a>
							<?php endif; ?>
						</span>
						<span class="updates-pagination"><?php if (count($bulletins)>1) {echo JText::sprintf( 'COM_COMMUNITY_GROUPS_BULLETIN_COUNT_OF' , count($bulletins) , $totalBulletin );} ?></span>
					</div>
				</div>

			</div>
			<?php
					}
				}
			?>
			<!-- Tab Content : Announcements -->


			<!-- Tab Content : Discussions -->
			<?php
				if( $group->approvals=='0' || $isMine || ($isMember && !$isBanned) || $isSuperAdmin )
				{
					if( $config->get('creatediscussion') )
					{
			?>
			<div class="cTabsContent">
				<div class="cGroup-Discussions">

					<?php echo $discussionsHTML; ?>

					<div class="cUpdatesHelper small clearfull">
						<span class="updates-options cFloat-R">
							<?php if( ($isMember && !$isBanned) && !($waitingApproval) || $isSuperAdmin): ?>
							<a class="app-box-action" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&groupid=' . $group->id . '&task=adddiscussion');?>">
								<?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION_CREATE');?>
							</a>
							<?php endif; ?>
							<?php if ( $discussions ): ?>
							<a class="app-box-action" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussions&groupid=' . $group->id );?>">
								<?php echo JText::_('COM_COMMUNITY_GROUPS_VIEW_ALL_DISCUSSIONS');?>
							</a>
							<?php endif; ?>
						</span>
						<span class="updates-pagination"><?php if (count($discussions)>1) { echo JText::sprintf( 'COM_COMMUNITY_GROUPS_DISCUSSION_COUNT_OF' , count($discussions) , $totalDiscussion );} ?></span>
					</div>
				</div>
			</div>
			<?php
					}
				}
			?>
			<!-- Tab Content : Discussions -->

		</div>
		<!-- Application Tabs's Content -->

	</div>
	<!-- end: .cMain -->
</div>



<?php if($editGroup) {?>
<script type="text/javascript">
	joms.groups.edit();
</script>
<?php } ?>


<script type="text/javascript" >

	// When people are viewing the 'discussion' page longer than 5 seconds,'
	joms.jQuery('#community-group-dicussion').parent().bind('onAfterShow', function() {
		jax.call('community', 'groups,ajaxUpdateCount', 'discussion', <?php echo $group->id; ?> );
	});

	// When people are viewing the 'discussion' page longer than 5 seconds,'
	joms.jQuery('#community-group-news').parent().bind('onAfterShow', function() {
		jax.call('community', 'groups,ajaxUpdateCount', 'bulletin', <?php echo $group->id; ?> );
	});


</script>

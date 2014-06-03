<?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class CommunityActivitiesController extends CommunityBaseController
{
	/**
	 * Return all newer activities from the given streamid,
	 * @param  int $streamid most recent stream id
	 * @param  string $filter   public, mine, friends, groups, events
	 * @return [type]           [description]
	 */
	public function ajaxGetRecentActivities( $streamid, $filter = null, $filterId = null )
	{

		$response    = new JAXResponse();
		$config      = CFactory::getConfig();
		$my          = CFactory::getUser();
		$html 		 = '';

		$activitiesLib = new CActivities();
		$html = $activitiesLib->getLatestStream( $streamid, $filter , $filterId);

		$response->addScriptCall('joms.activities.appendNewStream', $html, $config->get('stream_refresh_interval') );

		return $response->sendResponse();
	}

	/**
	 * Return the number of recent activities since the given id
	 * @param  [type] $streamid [description]
	 * @param  [type] $filter   [description]
	 * @return [type]           [description]
	 */
	public function ajaxGetRecentActivitiesCount( $streamid, $filter = null, $filterId = null )
	{

		$response    = new JAXResponse();
		$config      = CFactory::getConfig();
		$my          = CFactory::getUser();
		$html 		 = '';

		$activitiesModel 	= CFactory::getModel('activities');
		$activitiesLib 		= new CActivities();
		$html = $activitiesLib->getLatestStreamCount( $streamid, $filter , $filterId);

		//$count = $activitiesModel->countActivities('', '', '', 0 , '', $streamid* (-1) );
		$nextActivitiesCheck = $config->get('stream_refresh_interval');

		// if stream only for guest/disable dont load the auto refresh
		if($my->id == 0 && ($this->get('showactivitystream')===2 || $this->get('showactivitystream')===0)){
			return false;
		}

		// Only reload the next
		if(!$config->get('enable_refresh') || $config->get('showactivitystream') == '0' ){
			$nextActivitiesCheck = 0;
		}

		$newMessage = $html==1?JText::sprintf('COM_COMMUNITY_NEW_MESSAGES',$html):JText::sprintf('COM_COMMUNITY_NEW_MESSAGES_MANY',$html);
		$response->addScriptCall('joms.activities.announceNewStream', $html,  $nextActivitiesCheck, $newMessage);

		return $response->sendResponse();
	}

	public function ajaxGetOlderActivities($streamid, $filter, $filterId)
	{
		$response    = new JAXResponse();
		$config      = CFactory::getConfig();
		$my          = CFactory::getUser();
		$html 		 = '';

		$activitiesLib = new CActivities();
		$html = $activitiesLib->getOlderStream( $streamid, $filter, $filterId );

		$response->addScriptCall('joms.activities.prependOldStream', $html );

		return $response->sendResponse();
	}

	/**
	 * Method to retrieve activities via AJAX
	 **/
	public function ajaxGetActivities($exclusions, $type, $userId, $latestId = 0, $isProfile = 'false', $filter = '', $app = '', $appId = '')
	{
		$response    = new JAXResponse();
		$config      = CFactory::getConfig();
		$my          = CFactory::getUser();
		$filterInput = JFilterInput::getInstance();

		$exclusions  = $filterInput->clean($exclusions, 'string');
		$type        = $filterInput->clean($type, 'string');
		$userId      = $filterInput->clean($userId, 'int');
		$latestId    = $filterInput->clean($latestId, 'int');
		$isProfile   = $filterInput->clean($isProfile, 'string');
		$app         = $filterInput->clean($app, 'string');
		$appId       = $filterInput->clean($appId, 'int');



		$act = new CActivityStream();

		if (($app == 'group' || $app) == 'event' && $appId > 0)
		{
			// for application stream
			$option = array(
				'app'        => $app.'s',
				'apptype'    => $app,
				'exclusions' => $exclusions,
			);

			$option[$app.'id']  = $appId; //application id for the right application
			$option['latestId'] = ($latestId > 0) ? $latestId : 0;
			$html               = $act->getAppHTML( $option );

		}
		elseif (in_array($type, array('active-profile', 'me-and-friends', 'friends', 'self', 'active-profile-and-friends')))
		{
			// For main and profile stream


			$friendsModel = CFactory::getModel('Friends');

			if ($isProfile != 'false')
			{
				//requested from profile
				$target = array($userId); //by default, target is self

				if ($filter == 'friends')
				{
					$target = $friendsModel->getFriendIds($userId);
				}

				$html = $act->getHTML($userId, $target, null, $config->get('maxactivities'), 'profile', '', true, COMMUNITY_SHOW_ACTIVITY_MORE, $exclusions, COMMUNITY_SHOW_ACTIVITY_ARCHIVED, 'all', $latestId);
			}
			else
			{
				$html = $act->getHTML($userId, $friendsModel->getFriendIds( $userId ), null, $config->get('maxactivities'), '', '', true, COMMUNITY_SHOW_ACTIVITY_MORE, $exclusions, COMMUNITY_SHOW_ACTIVITY_ARCHIVED, 'all', $latestId );
			}
		}
		else
		{
			$html = $act->getHTML('', '', null, $config->get('maxactivities'), '', '', true, COMMUNITY_SHOW_ACTIVITY_MORE, $exclusions, COMMUNITY_SHOW_ACTIVITY_ARCHIVED, 'all', $latestId);
		}

		$html = trim($html, " \n\t\r");
		$text = JText::_('COM_COMMUNITY_ACTIVITIES_NEW_UPDATES');

		if ($latestId == 0)
		{
			// Append new data at bottom.
			$response->addScriptCall('joms.activities.append', $html );
		}
		else
		{
			if ($html != '')
			{
				// $response->addScriptCall('joms.activities.appendLatest', $html, $config->get('stream_refresh_interval'), $text );
			}
			else
			{
				// $response->addScriptCall('joms.activities.nextActivitiesCheck' ,$config->get('stream_refresh_interval') );
			}
		}


		return $response->sendResponse();
	}

	/**
	 * Get content for activity based on the activity id.
	 *
	 *	@params	$activityId	Int	Activity id
	 **/
	public function ajaxGetContent($activityId)
	{
		$my          = CFactory::getUser();
		$showMore    = true;
		$objResponse = new JAXResponse();
		$model       = CFactory::getModel( 'Activities' );

		$filter      = JFilterInput::getInstance();
		$activityId  = $filter->clean($activityId, 'int');




		// These core apps has default privacy issues with it
		$coreapps = array('photos','walls','videos', 'groups' );

		// make sure current user has access to the content item
		// For known apps, we can filter this manually
		$activity = $model->getActivity($activityId);

		if (in_array($activity->app, $coreapps))
		{
			switch ($activity->app)
			{
				case 'walls':
					// make sure current user has permission to the profile
					$showMore = CPrivacy::isAccessAllowed($my->id, $activity->target, 'user', 'privacyProfileView');
					break;
				case 'videos':
					// Each video has its own privacy setting within the video itself
					$video    = JTable::getInstance('Video', 'CTable');
					$video->load($activity->cid);
					$showMore = CPrivacy::isAccessAllowed($my->id, $activity->actor, 'custom', $video->permissions);
					break;

				case 'photos':
					// for photos, we uses the actor since the target is 0 and he
					// is doing the action himself
					$album    = JTable::getInstance('Album', 'CTable');
					$album->load($activity->cid);
					$showMore = CPrivacy::isAccessAllowed($my->id, $activity->actor, 'custom', $album->permissions);
					break;
				case 'groups':
			}
		}
		else
		{
			// if it is not one of the core apps, we should allow plugins to decide
			// if they want to block the 'more' view
		}

		if ($showMore)
		{
			$act     = $model->getActivity($activityId);
			$content = CActivityStream::getActivityContent($act);

			$objResponse->addScriptCall('joms.activities.setContent', $activityId, $content);
		}
		else
		{
			$content = JText::_('COM_COMMUNITY_ACCESS_FORBIDDEN');
			$content = nl2br($content);
			$content = CString::str_ireplace("\n", '', $content);
			$objResponse->addScriptCall('joms.activities.setContent', $activityId, $content);
		}

		$objResponse->addScriptCall('joms.tooltip.setup();');

		return $objResponse->sendResponse();
	}

	/**
	 * Hide the activity from the profile
	 * @todo: we should also hide all aggregated activities
	 */
	public function ajaxHideActivity($userId, $activityId, $app = '')
	{
		$objResponse = new JAXResponse();
		$model       = $this->getModel('activities');
		$my          = CFactory::getUser();

		$filter      = JFilterInput::getInstance();
		$userId      = $filter->clean($userId, 'int');
		$activityId  = $filter->clean($activityId, 'int');
		$app         = $filter->clean($app, 'string');

		// Guests should not be able to hide anything.
		if ($my->id == 0)
		{
			return false;
		}


		$id = $my->id;

		// Administrators are allowed to hide others activity.


		if (COwnerHelper::isCommunityAdmin())
		{
			$id	= $userId;
		}

		// to do user premission checking
		$user = CFactory::getUser();

		//if activity is within app, the only option is to delete, not to hide
		switch ($app)
		{
			case 'groups.wall':
				$act = JTable::getInstance('Activity', 'CTable');
				$act->load($activityId);
				$group_id = $act->groupid;

				$group = JTable::getInstance('Group', 'CTable');
				$group->load($group_id);

				//superadmin, group creator can delete all the activity while normal user can delete thier own post only
				if ($user->authorise('community.delete', 'activities.'.$activityId, $group))
				{
					$model->deleteActivity($app, $activityId, $group);
				}
				break;
			case 'events.wall':
				//to retrieve the event id
				$act = JTable::getInstance('Activity', 'CTable');
				$act->load($activityId);
				$event_id = $act->eventid;

				$event = JTable::getInstance('Event', 'CTable');
				$event->load($event_id);

				if ($user->authorise('community.delete', 'activities.'.$activityId, $event))
				{
					$model->deleteActivity($app, $activityId, $event);

					$wall = $this->getModel('wall');
					$wall->deleteAllChildPosts($activityId, $app);
				}
				break;
			default:
				//delete if this activity belongs to the current user
				if ($user->authorise('community.delete', 'activities.'.$activityId))
				{
					$model->deleteActivity($app, $activityId);
				}
				else
				{
					$model->hide($id, $activityId);
				}
		}


		$objResponse->addScriptCall('joms.jQuery("#profile-newsfeed-item'.$activityId.'").fadeOut("5400");');
		$objResponse->addScriptCall('joms.jQuery("#mod_profile-newsfeed-item'.$activityId.'").fadeOut("5400");');

		$this->cacheClean(array(COMMUNITY_CACHE_TAG_ACTIVITIES));
		return $objResponse->sendResponse();
	}

	public function ajaxConfirmDeleteActivity($app, $activityId)
	{
		$objResponse = new JAXResponse();

		$header      = JText::_('COM_COMMUNITY_ACTVITIES_REMOVE');
		$message     = JText::_('COM_COMMUNITY_ACTVITIES_REMOVE_MESSAGE');

		$actions     = '<button class="button" onclick="jax.call(\'community\', \'activities,ajaxDeleteActivity\', \''.$app.'\', \''.$activityId.'\' );">' . JText::_('COM_COMMUNITY_YES') . '</button>';
		$actions     .= '&nbsp;<button class="button" onclick="cWindowHide();">' . JText::_('COM_COMMUNITY_NO') . '</button>';

		$objResponse->addAssign('cwin_logo', 'innerHTML', $header);
		$objResponse->addScriptCall('cWindowAddContent', $message, $actions);

		return $objResponse->sendResponse();
	}

	/**
	 *
	 * @param  [type] $app        [description]
	 * @param  [type] $activityId [description]
	 * @return [type]             [description]
	 */
	public function ajaxDeleteActivity( $app, $activityId )
	{
		$my = CFactory::getUser();
		$objResponse = new JAXResponse();
		$model       = $this->getModel('activities');

		$filter      = JFilterInput::getInstance();
		$app         = $filter->clean($app, 'string');
		$activityId  = $filter->clean($activityId, 'int');

		$activity	= JTable::getInstance( 'Activity' , 'CTable' );
		$activity->load( $activityId );

		// @todo: do permission checking within the ACL
		if ( $activity->allowDelete() )
		{

			$activity	= JTable::getInstance( 'Activity' , 'CTable' );
			$activity->load( $activityId );
			$activity->delete( $app );

			$objResponse->addScriptCall('joms.jQuery("ul.cStreamList [data-streamid='.$activityId.']").fadeOut("5400", function () { joms.jQuery(this).remove(); });');		
			CUserPoints::assignPoint('wall.remove');
		}

		$this->cacheClean(array(COMMUNITY_CACHE_TAG_ACTIVITIES));

		$objResponse->addScriptCall('cWindowHide();');


		return $objResponse->sendResponse();
	}

	/**
	 * AJAX method to add predefined activity
	 **/
	public function ajaxAddPredefined( $key , $message = '' )
	{
		$objResponse = new JAXResponse();
		$my          = CFactory::getUser();

		$filter      = JFilterInput::getInstance();
		$key         = $filter->clean($key, 'string');
		$message     = $filter->clean($message, 'string');




		if ( ! COwnerHelper::isCommunityAdmin())
		{
			return;
		}

		// Predefined system custom activity.
		$system      = array('system.registered', 'system.populargroup', 'system.totalphotos', 'system.popularprofiles', 'system.popularphotos', 'system.popularvideos');

		$act         = new stdClass();
		$act->actor  = 0; //$my->id; System message should not capture actor. Otherwise the stream filter will be inaccurate
		$act->target = 0;
		$act->app    = 'system';
		$act->access = PRIVACY_FORCE_PUBLIC;
		$params      = new CParameter('');

		if (in_array($key, $system))
		{
			switch($key)
			{
				case 'system.registered':


					// $usersModel   = CFactory::getModel( 'user' );
					// $now          = new JDate();
					// $date         = CTimeHelper::getDate();
					// $title        = JText::sprintf('COM_COMMUNITY_TOTAL_USERS_REGISTERED_THIS_MONTH_ACTIVITY_TITLE', $usersModel->getTotalRegisteredByMonth($now->format('Y-m')) , $date->_monthToString($now->format('m')));
					$act->app   = 'system.members.registered';
					$act->cmd     = 'system.registered';
					$act->title   = '';
					$act->content = '';
					$params->set('action', 'registered_users');

					break;
				case 'system.populargroup':
					// $groupsModel = CFactory::getModel('groups');
					// $activeGroup = $groupsModel->getMostActiveGroup();

					// $title       = JText::sprintf('COM_COMMUNITY_MOST_POPULAR_GROUP_ACTIVITY_TITLE', $activeGroup->name);
					// $act->cmd    = 'groups.popular';
					// $act->cid    = $activeGroup->id;
					// $act->title  = $title;
					$act->app   = 'system.groups.popular';
					$params->set('action', 'top_groups');
					// $params->set('group_url', CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$activeGroup->id));

					break;
				case 'system.totalphotos':
					// $photosModel = CFactory::getModel( 'photos' );
					// $total       = $photosModel->getTotalSitePhotos();
					$act->app   = 'system.photos.total';
					$act->cmd   = 'photos.total';
					$act->title = '';//JText::sprintf('COM_COMMUNITY_TOTAL_PHOTOS_ACTIVITY_TITLE', $total);

					$params->set('action', 'total_photos');
					// $params->set('photos_url', CRoute::_('index.php?option=com_community&view=photos'));

					break;
				case 'system.popularprofiles':

					$act->app   = 'system.members.popular';
					$act->cmd   = 'members.popular';
					$act->title = '';//JText::sprintf('COM_COMMUNITY_ACTIVITIES_TOP_PROFILES', 5);

					$params->set('action', 'top_users');
					// $params->set('count', 5);

					break;
				case 'system.popularphotos':
					$act->app   = 'system.photos.popular';
					$act->cmd   = 'photos.popular';
					$act->title = '';//JText::sprintf('COM_COMMUNITY_ACTIVITIES_TOP_PHOTOS', 5);

					$params->set('action', 'top_photos');
					// $params->set('count', 5);

					break;
				case 'system.popularvideos':
					$act->app   = 'system.videos.popular';
					$act->cmd   = 'videos.popular';
					$act->title =  '';//JText::sprintf( 'COM_COMMUNITY_ACTIVITIES_TOP_VIDEOS', 5 );

					$params->set('action', 'top_videos');
					// $params->set('count', 5);

					break;
			}

		}
		else
		{
			// For additional custom activities, we only take the content passed by them.
			if ( ! empty($message))
			{
				$message    = CStringHelper::escape($message);

				$app        = explode('.', $key);
				$app        = isset($app[0]) ? $app[0] : 'system';
				$act->app   = 'system.message';
				$act->title = JText::_($message);

				$params->set('action', 'message');
			}
		}

		$this->cacheClean(array(COMMUNITY_CACHE_TAG_ACTIVITIES));

		// Allow comments on all these
		$act->comment_id   = CActivities::COMMENT_SELF;
		$act->comment_type = $key;

		// Allow like for all admin activities
		$act->like_id      = CActivities::LIKE_SELF;
		$act->like_type    = $key;

		// Add activity logging
		CActivityStream::add($act, $params->toString());

		$objResponse->addAssign('activity-stream-container', 'innerHTML', $this->_getActivityStream());
		$objResponse->addScriptCall("joms.jQuery('.jomTipsJax').addClass('jomTips');");
		$objResponse->addScriptCall('joms.tooltip.setup();');

		return $objResponse->sendResponse();
	}

	private function _getActivityStream()
	{


		$act  = new CActivityStream();
		$html = $act->getHTML('', '', null, 0, '', '', true, COMMUNITY_SHOW_ACTIVITY_MORE);

		return $html;
	}

}

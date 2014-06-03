<?php
/**
 * @category	Library
 * @package		JomSocial
 * @subpackage	Photos
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );
//CFactory::load( 'libraries' , 'comment' );

class CEvents implements
	CCommentInterface, CStreamable
{

	static public function sendCommentNotification( CTableWall $wall , $message )
	{
		//CFactory::load( 'libraries' , 'notification' );
		$event	= JTable::getInstance( 'Event' , 'CTable' );
		$event->load($wall->contentid);
		$my			= CFactory::getUser();
		$targetUser	= CFactory::getUser( $wall->post_by );
		$url		= 'index.php?option=com_community&view=events&task=viewevent&eventid=' . $wall->contentid;
		$params 	= $targetUser->getParams();

		$params		= new CParameter( '' );
		$params->set( 'url' , $url );
		$params->set( 'message' , $message );
		$params->set( 'event' , $event->title );
		$params->set( 'event_url' , $url );

		CNotificationLibrary::add( 'events_submit_wall_comment' , $my->id , $targetUser->id , JText::sprintf('PLG_WALLS_WALL_COMMENT_EMAIL_SUBJECT' , $my->getDisplayName() ) , '' , 'events.wallcomment' , $params );
		return true;
	}

	/**
	 * Return an array of valid 'app' code to fetch from the stream
	 * @return array
	 */
	static public function getStreamAppCode(){
		return array('events.wall', 'event.attend');
	}


	static public function getActivityContentHTML($act)
	{
		// Ok, the activity could be an upload OR a wall comment. In the future, the content should
		// indicate which is which
		$html 	 = '';
		$param 	 = new CParameter( $act->params );
		$action  = $param->get('action' , false);

		if( $action == 'events.create'  )
		{
			return CEvents::getEventSummary($act->cid, $param);
		}
		else if( $action == 'event.join' || $action ==  'event.attendence.attend' )
		{
			return CEvents::getEventSummary($act->cid, $param);
		}
		else if( $action == 'event.wall.create' || $action == 'events.wall.create')
		{


			$wallid = $param->get('wallid' , 0);
			$html = CWallLibrary::getWallContentSummary($wallid);
			return $html;
		}

		return $html;
	}

	static public function getEventSummary($eventid, $param)
	{
		$config = CFactory::getConfig();
		$model  =CFactory::getModel( 'events' );
		$event	= JTable::getInstance( 'Event' , 'CTable' );
		$event->load( $eventid );

		// Add tagging code
		/*
		$tagsHTML = '';
		if($config->get('tags_events') && $config->get('tags_show_in_stream')){

			$tags = new CTags();
			$tagsHTML = $tags->getHTML('events', $eventid, false);
		}*/

		$tmpl	= new CTemplate();
		$tmpl->set( 'event'		, $event );
		$tmpl->set( 'param'		, $param );

		return $tmpl->fetch( 'activity.events.update' );
	}

	/**
	 * Return array of rss-feed compatible data
	 */
	public function getFEED($maxEntry=20, $userid=null)
	{

		$events   = array();

        //CFactory::load( 'helpers' , 'owner' );
		//CFactory::load( 'models' , 'events' );

		$model    = new CommunityModelEvents();
        $eventObjs= $model->getEvents( null, $userid );

		if( $eventObjs )
		{
			foreach( $eventObjs as $row )
			{
				$event	= JTable::getInstance( 'Event' , 'CTable' );
				$event->load( $row->id );
				$events[]	= $event;
			}
			unset($eventObjs);
		}

		return $events;
	}

	/**
	 * Return HTML formatted stream for events
	 * @param type $eventid
	 * @deprecated use CActivities directly instead
	 */
	public function getStreamHTML( $event )
	{
		$activities = new CActivities();
		$streamHTML = $activities->getOlderStream(1000000000,'active-event', $event->id);

		// $streamHTML = $activities->getAppHTML(
		// 			array(
		// 				'app' => CActivities::APP_EVENTS,
		// 				'eventid' => $event->id,
		// 				'apptype' => 'event'
		// 			)
		// 		);

		return $streamHTML;
	}

	/**
	 * Return true is the user can post to the stream
	 **/
	public function isAllowStreamPost( $userid, $options )
	{
		// Guest cannot post.
		if( $userid == 0){
			return false;
		}

		// Admin can comment on any post
		if(COwnerHelper::isCommunityAdmin()){
			return true;
		}

		$event	= JTable::getInstance( 'Event' , 'CTable' );
-		$event->load( $options['eventid'] );
		return $event->isMember($userid);
	}

        public static function getEventMemberHTML( $eventId )
        {
            //CFactory::load( 'libraries' , 'tooltip' );
            //CFactory::load( 'helpers' , 'event' );
        	$my = CFactory::getUser();
            $event                              = JTable::getInstance( 'Event' , 'CTable' );
            $event->load($eventId);
            $eventMembers			= $event->getMembers( COMMUNITY_EVENT_STATUS_ATTEND, 12 , CC_RANDOMIZE );
            $eventMembersCount		= $event->getMembersCount( COMMUNITY_EVENT_STATUS_ATTEND );

            for( $i = 0; ($i < count($eventMembers)); $i++)
            {
			$row	=  $eventMembers[$i];
			$eventMembers[$i]	= CFactory::getUser( $row->id );
            }
            $handler	= CEventHelper::getHandler( $event );
            
            $isEventGuest	= $event->isMember( $my->id );
            $isMine			= ($my->id == $event->creator);
			$isAdmin		= $event->isAdmin( $my->id );

            $tmpl	= new CTemplate();
            $tmpl->set('isEventGuest',$isEventGuest);
            $tmpl->set( 'isMine'				, $isMine );
			$tmpl->set( 'isAdmin'			, $isAdmin );
            $tmpl->set( 'eventMembers',    $eventMembers );
            $tmpl->set( 'eventMembersCount',    $eventMembersCount );
            $tmpl->set( 'handler',    $handler );
            $tmpl->set( 'eventId',  $eventId);
            $tmpl->set( 'event',  $event);

            return $tmpl->fetch( 'events.members.html' );
        }



	/**
	 * Return event recurring save HTML.
	 **/
	static public function getEventRepeatSaveHTML($selected = "")
	{
		$message	= JText::_('COM_COMMUNITY_EVENTS_REPEAT_MESSAGE');

		$message   .= '<br/><br/><input type="radio" id="repeatcurrent" name="repeattype" value="current" checked><strong>&nbsp;&nbsp;' . JText::_('COM_COMMUNITY_EVENTS_REPEAT_MESSAGE_ONLY_THIS') .'</strong><br/>';
		$message   .= '<div style="padding-left:18px">'.JText::_('COM_COMMUNITY_EVENTS_REPEAT_MESSAGE_ONLY_THIS_DESC') . '</div>';

		$selectfuture = $selected == 'future' ? 'checked' : '';
		$message   .= '<br/><input type="radio" id="repeatfuture" name="repeattype" value="future" ' .$selectfuture. '><strong>&nbsp;&nbsp;' . JText::_('COM_COMMUNITY_EVENTS_REPEAT_MESSAGE_FOLLOWING') .'</strong><br />';
		$message   .=  '<div style="padding-left:18px">'.JText::_('COM_COMMUNITY_EVENTS_REPEAT_MESSAGE_FOLLOWING_DESC') . '</div><br/><br/>';

		return $message;
	}

	/**
	 * Add stream for new created event.
         * @since 2.6
	 **/
        public function addEventStream($event)
        {
            //CFactory::load( 'helpers' , 'event' );
            $handler = CEventHelper::getHandler( $event );
            $my	     = CFactory::getUser();

            //CFactory::load( 'helpers' , 'event' );
            $handler = CEventHelper::getHandler( $event );

            // Activity stream purpose if the event is a public event
            $action_str = 'events.create';
            if( $handler->isPublic() && $event->isPublished())
            {
                $actor		= $event->creator;
                $target		= 0;
                $content	= '';
                $cid		= $event->id;
                $app		= 'events';
                $act		= $handler->getActivity( 'events.create' , $actor, $target , $content , $cid , $app );
                $url		= $handler->getFormattedLink( 'index.php?option=com_community&view=events&task=viewevent&eventid=' . $event->id , false , true , false );

                // Set activity group id if the event is in group
                $act->groupid	= ($event->type == 'group') ? $event->contentid : null;
                $act->eventid	= $event->id;
                $act->location	= $event->location;

                $act->comment_id   = $event->id;
                $act->comment_type = 'events';

                $act->like_id	= $event->id;
                $act->like_type	= 'events';

                $params		= new CParameter('');
                $cat_url        = $handler->getFormattedLink( 'index.php?option=com_community&view=events&task=display&categoryid=' . $event->catid , false , true , false );
                $params->set( 'action', $action_str );
                $params->set( 'event_url', $url );
                $params->set( 'event_category_url', $cat_url );

                // Add activity logging

                CActivityStream::add( $act, $params->toString() );
            }
        }


	/**
	 * Add notifcation to group's member for new created event.
         * @since 2.6
	 **/
        public function addGroupNotification($event)
        {


            if($event->type == CEventHelper::GROUP_TYPE && $event->contentid != 0 && $event->isPublished()){



                $my = CFactory::getUser();

                $group = JTable::getInstance( 'Group' , 'CTable' );
                $group->load( $event->contentid );

                $modelGroup    = CFactory::getModel( 'groups' );
                $groupMembers  = array();
                $groupMembers  = $modelGroup->getMembersId($event->contentid, true );

                // filter event creator.
                if ($key = array_search($event->creator, $groupMembers))
                {
                    unset($groupMembers[$key]);
                }

                $subject       = JText::sprintf('COM_COMMUNITY_GROUP_NEW_EVENT_NOTIFICATION', $my->getDisplayName(), $group->name );
                $params	       = new CParameter( '' );
                $params->set( 'title' , $event->title );
                $params->set('group' , $group->name );
                $params->set('group_url' , 'index.php?option=com_community&view=groups&task=viewgroup&groupid='.$event->contentid );
                $params->set('event' , $event->title );
                $params->set('event_url' , 'index.php?option=com_community&view=events&task=viewevent&groupid='.$event->contentid.'&eventid='.$event->id );
                $params->set( 'url', 'index.php?option=com_community&view=events&task=viewevent&eventid='.$event->id);
                CNotificationLibrary::add( 'groups_create_event' , $my->id , $groupMembers , JText::sprintf('COM_COMMUNITY_GROUP_NEW_EVENT_NOTIFICATION') , '' , 'groups.event' , $params);
            }
        }

	/**
	 * Return true is the user is a group admin
	 **/
	public function isAdmin($userid,$eventid)
	{
		$event	= JTable::getInstance( 'Event' , 'CTable' );
		$event->load( $eventid );
		return $event->isAdmin($userid);
	}
}
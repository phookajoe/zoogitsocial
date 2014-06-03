<?php
/**
 * @category	Library
 * @package		JomSocial
 * @subpackage	user
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.'/components/com_community/libraries/core.php';

class CMiniHeader
{

	public static function load()
	{
		$jspath = JPATH_BASE.'/components/com_community';
		include_once $jspath.'/libraries/template.php';

		$config	= CFactory::getConfig();

		$js = 'assets/window-1.0.min.js';
		CAssets::attach($js, 'js');

		$js = 'assets/script-1.2.min.js';
		CAssets::attach($js, 'js');

		$css = 'assets/window.css';
		CAssets::attach($css, 'css');


		CTemplate::addStyleSheet('style');
	}

	public static function showMiniHeader($userId)
	{
		CMiniHeader::load();

		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		JFactory::getLanguage()->load('com_community');

		$option = $jinput->request->get('option', '', 'STRING'); //JRequest::getVar('option', '' , 'REQUEST');
		$my 	= CFactory::getUser();
		$config	= CFactory::getConfig();

		if ( ! empty($userId))
		{
			$user = CFactory::getUser($userId);


			$sendMsg = CMessaging::getPopup($user->id);
			$tmpl    = new CTemplate();

			$tmpl->set('my', $my);
			$tmpl->set('user', $user);
			$tmpl->set('isMine', COwnerHelper::isMine($my->id, $user->id));
			$tmpl->set('sendMsg', $sendMsg);
			$tmpl->set('config', $config);
			$tmpl->set('isFriend', CFriendsHelper::isConnected($user->id, $my->id) && $user->id != $my->id);

			$showMiniHeader = $option == 'com_community' ? $tmpl->fetch('profile.miniheader') : '<div id="community-wrap" style="min-height:50px;">'.$tmpl->fetch('profile.miniheader').'</div>' ;

			return $showMiniHeader;
		}
	}

	public static function showGroupMiniHeader( $groupId )
	{
		CMiniHeader::load();

		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		$option = $jinput->request->get('option', '', 'STRING'); //JRequest::getVar('option', '', 'REQUEST');
		JFactory::getLanguage()->load('com_community');

		$group = JTable::getInstance('Group', 'CTable');
		$group->load($groupId);
		$my = CFactory::getUser();

		// @rule: Test if the group is unpublished, don't display it at all.
		if ( ! $group->published)
		{
			return '';
		}


		if ( ! empty($group->id) && $group->id != 0)
		{
			$isMember = $group->isMember($my->id);
			$config   = CFactory::getConfig();


			$allowManagePhotos = CGroupHelper::allowManagePhoto($group->id);
			$allowManageVideos = CGroupHelper::allowManageVideo($group->id);
			$allowCreateEvent  = CGroupHelper::allowCreateEvent($my->id , $group->id);

			$tmpl = new CTemplate();

			$tmpl->set('my', $my);
			$tmpl->set('group', $group);
			$tmpl->set('isMember', $isMember);
			$tmpl->set('config', $config);
			$tmpl->set('allowManagePhotos', $allowManagePhotos);
			$tmpl->set('allowManageVideos', $allowManageVideos);
			$tmpl->set('allowCreateEvent', $allowCreateEvent);

			$showMiniHeader = $option == 'com_community' ? $tmpl->fetch('groups.miniheader') : '<div id="community-wrap" style="min-height:50px;">'.$tmpl->fetch('groups.miniheader').'</div>';

			return $showMiniHeader;
		}
	}

}
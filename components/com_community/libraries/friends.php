<?php

/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class CFriends extends JObject
{

	/**
	 * Load messaging javascript header
	 */
	public function load()
	{
		if ( ! defined('CMESSAGING_LOADED'))
		{
			$config	= CFactory::getConfig();
			include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

			$js = 'assets/window-1.0.min.js';
			CAssets::attach($js, 'js');

			$css = 'assets/window.css';
			CAssets::attach($css, 'css');

			$css = 'templates/'.$config->get('template').'/css/style.css';
			CAssets::attach($css, 'css');
		}
	}

	/**
	 * Get link to popup window
	 */
	public function getPopup($id)
	{
		CFriends::load();
		return "joms.friends.connect('{$id}')";
	}

	public function add($target = 0, $friends = array())
	{
		// remove duplicate id
		$friends = array_unique($friends);
		$model   = CFactory::getModel('friends');
		$my      = JFactory::getUser();

		if ($target == 0 || empty($friends))
		{
			return false;
		}

		foreach ($friends as $friendId)
		{
			$connection	= count($model->getFriendConnection($target, $friendId));

			// If stanger id is not in connection and stranger id in not myId, do add
			if ($connection == 0 && $friendId != $my->id)
			{
				$model->addFriendRequest($friendId, $target);
			}
		}

		return true;
	}

	public function remove($target, $friends = array())
	{
		// remove duplicate id
		$friends = array_unique($friends);
		$model   = CFactory::getModel('friends');

		if ($target == 0 || empty($friends))
		{
			return false;
		}

		foreach ($friends as $friendId)
		{
			$model->deleteFriend($target, $friendId);
		}

		return true;
	}

	public function request($target, $friends = array())
	{
		// remove duplicate id
		$friends    = array_unique($friends);
		$model      = CFactory::getModel('friends');
		$targetUser = CFactory::getUser($target);
		$my         = JFactory::getUser();


		$params = new CParameter('');
		$params->set('url' , 'index.php?option=com_community&view=profile&userid='.$targetUser->id);

		if ($target == 0 || empty($friends))
		{
			return false;
		}

		foreach ($friends as $friendId)
		{
			$connection	= count($model->getFriendConnection($target, $friendId));

			// If stanger id is not in connection and stranger id in not myId, do add
			if ($connection == 0 && $friendId != $my->id)
			{
				$model->addFriend($friendId, $target);
				CNotificationLibrary::add('friends_request_connection', $targetUser->id, $friendId, JText::sprintf('COM_COMMUNITY_FRIEND_ADD_REQUEST', $targetUser->getDisplayName() ), '', 'friends.request', $params);
			}
		}

		return true;
	}
}
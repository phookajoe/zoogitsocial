<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class CMessaging
{
	/**
	 * Load messaging javascript header
	 */
	static public function load()
	{
		if( ! defined('CMESSAGING_LOADED'))
		{
			$config	= CFactory::getConfig();
			include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

			$js = 'assets/window-1.0.min.js';
			CAssets::attach($js, 'js');

			$js = 'assets/script-1.2.min.js';
			CAssets::attach($js, 'js');

			$css = 'assets/window.css';
			CAssets::attach($css, 'css');


			CTemplate::addStyleSheet('style');
		}
	}

	/**
	 * Get link to popup window
	 */
	static public function getPopup($id)
	{
		CMessaging::load();
		return "joms.messaging.loadComposeWindow('{$id}')";
	}

	static public function send($data)
	{
		//notifyEmailMessage
	}
}
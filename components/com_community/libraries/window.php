<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class CWindow
{
	/**
	 * Load messaging javascript header
	 */
	static public function load()
	{
		static $loaded = false;

		if ( ! $loaded)
		{
			$config	= CFactory::getConfig();

			require_once JPATH_ROOT.'/components/com_community/libraries/core.php';

			$js = 'assets/window-1.0.min.js';
			CAssets::attach($js, 'js');


			CTemplate::addStyleSheet('style');

			$css = 'assets/window.css';
			CAssets::attach($css, 'css');
		}
	}
}
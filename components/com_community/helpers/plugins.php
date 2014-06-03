<?php
/**
 * @category 	Library
 * @package		JomSocial
 * @subpackage	Core 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.plugin.plugin' );

class CPluginHelper extends JPluginHelper {
	public static function getPluginPath($type, $plugin = null) {
		if (!$plugin) {
			return JPATH_PLUGINS .'/'. $type;
		}
		//joomla 1.6 keeps plugin in seperated folders
		return JPATH_PLUGINS .'/'. $type .'/'. $plugin .'/'. $plugin;
	}
	
	public static function getPluginURI($type, $plugin = null) {
		if (!$plugin) {
			return '/plugins/' . $type;
		}
		//joomla 1.6 keeps plugin in seperated folders
		return '/plugins/' . $type . '/' . $plugin;
	}
}

?>

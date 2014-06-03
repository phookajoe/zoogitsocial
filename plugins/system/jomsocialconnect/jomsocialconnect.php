<?php
/**
 * @copyright   (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license     http://www.azrul.com Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * Facebook Namespace Plugin
 */
class plgSystemJomsocialConnect extends JPlugin
{
	public function onAfterRender()
	{
		$fbml = '<html xmlns:fb="http://ogp.me/ns/fb#" ';
		$html = JResponse::getBody();
		
		$html = JString::str_ireplace('<html', $fbml, $html);
		
		JResponse::setBody($html);
	}
}

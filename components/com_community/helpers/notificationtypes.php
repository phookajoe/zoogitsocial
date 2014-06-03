<?php
/**
 * @category	Library
 * @package		JomSocial
 * @subpackage	user 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );

class CNotificationTypesHelper {
	
	const EMAIL_TYPE_PREFIX	= 'etype_';
	const GLOBAL_TYPE_PREFIX	= 'notif_';
	static public function convertEmailId($id){
		if($id){
			return CNotificationTypesHelper::EMAIL_TYPE_PREFIX . $id ;
		}
		return '';
	}
	static public function convertNotifId($id){
		if($id){
			return CNotificationTypesHelper::GLOBAL_TYPE_PREFIX . $id ;
		}	
		return '';
	}
}
<?php
/**
 * @category	Helper
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class CFriendsHelper
{
	/**
	 * Check if 2 friends is connected or not
	 * @param	int userid1
	 * @param	int userid2
	 * @return	bool  
	 */ 
	static public function isConnected($id1, $id2)
	{
		// Static caching for this session
		static $isFriend = array();
		if( !empty($isFriend[$id1.'-'.$id2]) ){
			return $isFriend[$id1.'-'.$id2];
		}
		
		if(($id1 == $id2) && ($id1 != 0))
			return true;
		
		if($id1 == 0 || $id2 == 0)
			return false;
		
			/*
		$db = JFactory::getDBO();
		$sql = 'SELECT count(*) FROM ' . $db->quoteName('#__community_connection')
			  .' WHERE ' . $db->quoteName('connect_from') .'=' . $db->Quote($id1) .' AND ' . $db->quoteName('connect_to') .'=' . $db->Quote($id2)
			  .' AND ' . $db->quoteName('status') .' = ' . $db->Quote(1);
			
		$db->setQuery($sql);
		$result = $db->loadResult();
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		
		$isFriend[$id1.'-'.$id2] = $result;
		*/
		
		// change method to get connection since list friends stored in community_users as well
		$user = CFactory::getUser($id1);
    	$isConnected = $user->isFriendWith($id2);
		
		return $isConnected;
	}

	static public function isWaitingApproval($id1,$id2){
		$db = JFactory::getDBO();
		$sql = 'SELECT count(*) FROM ' . $db->quoteName('#__community_connection')
			  .' WHERE ' . $db->quoteName('connect_from') .'=' . $db->Quote($id1) .' AND ' . $db->quoteName('connect_to') .'=' . $db->Quote($id2)
			  .' AND ' . $db->quoteName('status') .' = ' . $db->Quote(0);
			
		$db->setQuery($sql);
		$result = $db->loadResult();
		if($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr());
	}

	return !empty($result)?true:false;
}
}


/**
 * Deprecated since 1.8
 */
function friendIsConnected($id1, $id2)
{
	return CFriendsHelper::isConnected( $id1 , $id2 );
}
 

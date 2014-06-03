<?php
/**
 * @category	Helper
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );

class CMenuHelper
{
	/**
	 *	Returns an object of data containing user's address information
	 *
	 *	@access	static
	 *	@params	int	$userId
	 *	@return stdClass Object	 	 	 
	 **/
	static public function getComponentId()
	{
		$db		= JFactory::getDBO();

		//component id is retrieved from #__extensions table, overwrite query
		$query	= 'SELECT ' . $db->quoteName( 'extension_id' ) . ' FROM '
					. $db->quoteName( '#__extensions' ) . ' WHERE '
					. $db->quoteName( 'element' ) . '=' . $db->Quote( 'com_community' ) . ' '
					. 'AND ' . $db->quoteName( 'type' ) . '=' . $db->Quote( 'component' );
		
		
		$db->setQuery( $query );
		return $db->loadResult();
	}
	
	static public function getMenuIdByTitle($title){
		$db		= JFactory::getDBO();
		//component id is retrieved from #__extensions table, overwrite query
		$query	= 'SELECT ' . $db->quoteName( 'id' ) . ' FROM '
				. $db->quoteName( '#__menu' ) . ' WHERE '
				. $db->quoteName( 'title' ) . '=' . $db->Quote( $title );
		
		$db->setQuery( $query );
		return $db->loadResult();
	}
	
	
	//to update parent_id and level field in the menu table because the store funtion wont work
	static public function alterMenuTable($id){
		$db		= JFactory::getDBO();
		
		$data = new stdClass();
		$data -> id = $id;
		$data -> level = 1;
		$data -> parent_id = 1;
		$db->updateObject( '#__menu' , $data , 'id' );
	}
}
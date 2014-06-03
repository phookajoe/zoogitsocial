<?php
/**
 * @category	Tables
 * @package		JomSocial
 * @subpackage	FieldValue 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class CTableFieldValue extends JTable
{
	var $id 		= null;
	var $user_id	= null;
	var $field_id	= null;
	var $value		= null;
	var $access		= null;

	public function __construct( &$db )
	{
		parent::__construct( '#__community_fields_values', 'id', $db );
		//J2.5 compatibility: fix automatically initialize value on access column
		$this->access = null;		
	}
	
	public function load( $userId=NULL , $fieldId=true )
	{
		$db		= $this->getDBO();
		$query	= 'SELECT * FROM ' . $db->quoteName( '#__community_fields_values' ) . ' '
				. 'WHERE ' . $db->quoteName('field_id') . ' = ' . $db->Quote( $fieldId ) . ' AND '
				. $db->quoteName('user_id') . '=' . $db->Quote( $userId );

		$db->setQuery( $query );
		$result	= $db->loadObject();

		if(is_null($result)) return false;

		return $this->bind( $result );
	}

	public function bind($src, $ignore = array()){
		if(empty($src) || is_null($src) ) {return true;}
		return parent::bind($src, $ignore );
	}
}

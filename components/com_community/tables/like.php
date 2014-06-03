<?php
/**
 * @category	Tables
 * @package	JomSocial
 * @subpackage	Voting
 * @copyright	(C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license	GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class CTableLike extends JTable
{
    
	// Tables' fileds
	var $id		=   null;
	var $element	=   null;
	var $uid	=   null;
	var $like	=   null;
	var $dislike	=   null;

	/**
	 * Constructor
	 */
	public function __construct( &$db )
	{
		parent::__construct( '#__community_likes', 'id', $db );
	}

	public function store($updateNulls=null)
	{
		return parent::store();
	}

	public function loadInfo( $element, $itemId )
	{
		
		$db	= JFactory::getDBO();

		$query	=   'SELECT * FROM ' . $db->quoteName('#__community_likes') . ' '
			    . 'WHERE ' . $db->quoteName('element') . '=' . $db->Quote( $element ) . ' '
			    . 'AND ' . $db->quoteName('uid') . '=' . $db->Quote( $itemId );

		$db->setQuery( $query );

		$result	=   $db->loadObject();

		if ($result)
		{
			$this->bind( $result );
		}
		
		return;
	}
}
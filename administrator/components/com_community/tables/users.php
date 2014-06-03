<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * JomSocial Table Model
 */
class CommunityTableUsers extends JTable
{
	var $userid			= null;
	var $status			= null;
	var $points			= null;
	var $posted_on		= null;
	var $avatar			= null;
	var $thumb			= null;
	var $invite			= null;
	var $params			= null;
	var $view			= null;
	var $friendcount	= null;

	public function __construct(&$db)
	{
		parent::__construct('#__community_users','userid', $db);
	}

	public function getFriendCount()
	{
		$db		= JFactory::getDBO();

		$query = 'SELECT COUNT(*) FROM '.$db->quoteName( '#__community_connection').' AS ' . $db->quoteName('a');
		$query .= ' INNER JOIN '.$db->quoteName( '#__users').' AS ' . $db->quoteName('b') . ' ON ' . $db->quoteName('a') . '.' .$db->quoteName('connect_to') . ' = ' . $db->quoteName('b') . '.' . $db->quoteName('id');
		$query .= ' WHERE ' . $db->quoteName('a') . '.' . $db->quoteName('connect_from') . ' = '.$db->Quote( $this->userid );
		$query .= ' AND ' . $db->quoteName('a'). '.' . $db->quoteName('STATUS') . ' = ' . $db->Quote(1);

		$db->setQuery( $query );
		$count	= $db->loadResult();

		return $count;
	}
}
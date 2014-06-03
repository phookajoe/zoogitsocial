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
class CommunityTableGroupMembers extends JTable
{
	var $groupid		= null;
	var $memberid		= null;
	var $approved		= null;
	var $permissions	= null;

	public function __construct(&$db)
	{
		parent::__construct('#__community_groups_members','id', $db);
	}

	public function load(  $keys=null, $reset=true  )
	{
		$memberId = $keys['memberId'];
		$groupId = $keys['groupId'];

		$db		= $this->getDBO();

		$query	= 'SELECT * FROM ' . $db->quoteName( '#__community_groups_members' ) . ' '
				. 'WHERE ' . $db->quoteName( 'groupid' ) . '=' . $db->Quote( $groupId ) . ' '
				. 'AND ' . $db->quoteName( 'memberid' ) . '=' . $db->Quote( $memberId );
		$db->setQuery( $query );

		$member	= $db->loadObject();

		if( !$member )
			return false;

		$this->groupid		= $member->groupid;
		$this->memberid		= $member->memberid;
		$this->approved		= $member->approved;
		$this->permissions	= $member->permissions;

		return true;
	}

	public function store()
	{
		$db		= $this->getDBO();

		$query	= 'UPDATE ' . $db->quoteName( '#__community_groups_members' ) . ' '
				. 'SET ' . $db->quoteName( 'approved' ) . '=' . $db->Quote( $this->approved ) . ','
				. $db->quoteName( 'permissions' ) . '=' . $db->Quote( $this->permissions ) . ' '
				. 'WHERE ' . $db->quoteName( 'groupid' ) . '=' . $db->Quote( $this->groupid ) . ' '
				. 'AND ' . $db->quoteName( 'memberid' ) . '=' . $db->Quote( $this->memberid );
		$db->setQuery( $query );
		return $db->query();
	}
}
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
class CommunityTableVideosCategories extends JTable
{
	var $id				= null;
	var $parent			= null;
	var $name			= null;
	var $description		= null;
	var $published			= null;


	public function __construct(&$db)
	{
		parent::__construct('#__community_videos_category','id', $db);
	}

	public function delete( $id )
	{
		$db	= JFactory::getDBO();

		// Check if any groups are assigned into this category
		$query		= 'SELECT COUNT(*) FROM ' . $db->quoteName('#__community_videos') . ' '
					. 'WHERE ' . $db->quoteName('category_id') . '=' . $db->Quote($id);
		$db->setQuery( $query );
		$count		= $db->loadResult();

		if($count <= 0)
		{
			// Only delete if no groups are assigned to this category.
			parent::delete( $id );
			return true;
		}

		return false;
	}
}

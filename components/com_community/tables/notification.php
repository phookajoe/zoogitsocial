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
class CTableNotification extends JTable
{
	var $id				= null;
	var $actor			= null;
	var $target			= null;
	var $content		= null;
	var $type			= null;
	var $cmd_type		= null;
	var $status			= null;
	var $created		= null;
	var $params			= null;
	
	public function __construct(&$db)
	{
		parent::__construct('#__community_notifications','id', $db);
	}
}
?>
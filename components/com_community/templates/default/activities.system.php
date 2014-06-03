<?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

$param = new CParameter($this->act->params); 
$action = $param->get('action');

switch ($action) {
	case 'registered_users':
		$this->load('activities.system.registered');
		break;

	case 'total_photos':
		$this->load('activities.system.totalphotos');
		break;

	case 'top_videos':
		$this->load('activities.system.topvideos');
		break;
	case 'top_photos':
		$this->load('activities.system.topphotos');
		break;

	case 'top_users':
		$this->load('activities.system.topusers');
		break;

	case 'top_groups':
		$this->load('activities.system.topgroups');
		break;

	case 'message':
		$this->load('activities.system.message');
		break;
	default:
		# code...
		break;
}
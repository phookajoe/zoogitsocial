<?php

/**
 * @category    Core
 * @package     JomSocial
 * @copyright   (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license     GNU/GPL, see LICENSE.php
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * This is the entry point for the AJAX calls.
 * We filter this out instead so that the AJAX methods can be called within the
 * controller.
 *
 * @param  string $func
 * @param  array  $args
 * @return mixed
 **/
function communityAjaxEntry($func, $args = null)
{
	// The first index will always be 'admin' to distinguish between admin ajax
	// calls and front end ajax calls.
	// $method[0]	= 'admin'
	// $method[1]	= CONTROLLER
	// $method[2]	= CONTROLLER->METHOD

	if (substr($func, 0, 5) === 'admin')
	{
		// @TODO: Not sure why we need to fetch ?func from REQUEST again.
		$func = $_REQUEST['func'];

		list($isAdmin, $controller, $method) = explode(',', $func);

		$controllerFile = JString::strtolower($controller);

		if (file_exists(JPATH_COMPONENT.'/controllers/'.$controllerFile.'.php'))
		{
			require_once JPATH_COMPONENT.'/controllers/'.$controllerFile.'.php';

			$controller = JString::ucfirst($controller);
			$controller = 'CommunityController'.$controller;
			$controller = new $controller();

			return call_user_func_array(array(&$controller, $method) , $args);
		}
	}
}
<?php

/**
 * @category    Core
 * @package     JomSocial
 * @copyright   (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license     GNU/GPL, see LICENSE.php
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

define('COMMUNITY_ASSETS_PATH', JPATH_COMPONENT.'/assets');
define('COMMUNITY_ASSETS_URL', JURI::base().'components/com_community/assets');
define('COMMUNITY_BASE_PATH', dirname(JPATH_BASE).'/components/com_community');
define('COMMUNITY_BASE_ASSETS_PATH', JPATH_BASE.'/components/com_community/assets');
define('COMMUNITY_BASE_ASSETS_URL', JURI::root().'components/com_community/assets');
define('COMMUNITY_CONTROLLERS', JPATH_COMPONENT.'/controllers');

// @TODO to be removed.
jimport('joomla.version');
$version    = new JVersion();
$joomla_ver = $version->getHelpVersion();
// @ENDTODO
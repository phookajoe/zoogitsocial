<?php

/**
 * @category    Core
 * @package     JomSocial
 * @copyright   (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license     GNU/GPL, see LICENSE.php
 */

// Dont allow direct linking
defined( '_JEXEC' ) or die('Restricted access');

function com_uninstall() 
{
	require_once JPATH_ROOT.'/components/com_community/defines.community.php';
	
	$asset = JTable::getInstance('Asset');

	if ($asset->loadByName('com_community')) 
	{
		$asset->delete();
	}

	$db = JFactory::getDBO();	
	
	// Remove jomsocialuser plugin during uninstall to prevent error 
	// during login/logout of Joomla.
	$query = 'DELETE FROM '.$db->quoteName(PLUGIN_TABLE_NAME).' '
		 	.'WHERE '.$db->quoteName('element').'='.$db->quote('jomsocialuser').' AND '
		 	.$db->quoteName('folder').'='.$db->quote('user');

	$db->setQuery($query);
	$db->query();

	$pluginPath = JPATH_ROOT.'/plugins/user/jomsocialuser/';	
	
	if (JFile::exists($pluginPath.'jomsocialuser.php'))
	{
		JFile::delete($pluginPath.'jomsocialuser.php');
	}
	
	if (JFile::exists($pluginPath.'jomsocialuser.xml'))
	{
		JFile::delete($pluginPath.'jomsocialuser.xml');
	}
	
	removeBackupTemplate('blueface');
	removeBackupTemplate('bubble');
	removeBackupTemplate('blackout');

	return true;   
}

function removeBackupTemplate($name)
{
	$path = JPATH_ROOT.'/components/com_community/templates/';

	if (JFolder::exists($path))
	{
		$backups = JFolder::folders($path, '^'.$name.'_bak[0-9]');

		foreach($backups as $backup)
		{
			JFolder::delete($path.$backup);
		}
	}
}
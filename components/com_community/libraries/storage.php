<?php
/**
 * @copyright (C) 2009 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.file' );

require_once( JPATH_ROOT .'/components/com_community/libraries/storage/s3.php' );
require_once( JPATH_ROOT .'/components/com_community/libraries/storage/file.php' );

class CStorage
{
	public static function getStorage($type = 'file')
	{
		// If store file is empty, it should default to 'file'
		if( empty($type) )
		{
			$type = 'file';
		}
		
		$classname = ucfirst($type) . '_CStorage';
		$obj = new $classname();
		$obj->_init();
		return $obj;
	}
}


class CStorageMethod
{
	/**
	 * Put a resource into a remote storage.
	 * Return true if successful	 
	 */
	public function put()
	{
	}
	
	public function exists()
	{
	}
	
	/**
	 * Retrive the entire resource locally
	 */	 	
	public function get($uri)
	{
	}
	
	public function getURI(){}
	
	public function read(){}
	public function write(){}
	public function delete(){}
	public function getExt(){}
}



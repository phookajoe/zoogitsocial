<?php
/**
 * @category	Libraries
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
 
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
define( 'JPATH_BASE', dirname(dirname(dirname(dirname(__FILE__)))) );

if (!defined('JPATH_PLATFORM')) {
	define('JPATH_PLATFORM', dirname(__FILE__));
}
require_once( JPATH_BASE.'/includes/defines.php' );
require_once( JPATH_LIBRARIES.'/joomla/base/object.php' );
if(file_exists ( JPATH_LIBRARIES.'/cms/version/version.php' ))
{
	$joomla_ver = '0.25';
}
require_once( JPATH_LIBRARIES.'/loader.php' );

if($joomla_ver >= '0.25')
{
	require_once( JPATH_LIBRARIES.'/joomla/string/string.php' );
	require_once( JPATH_LIBRARIES.'/joomla/filesystem/path.php' );
	$post_string = $_GET['target'];
}
else
{
	
	require_once( JPATH_LIBRARIES.'/joomla/environment/request.php' );
	require_once( JPATH_LIBRARIES.'/joomla/filter/filterinput.php'  );
	
	$mainframe	= JFactory::getApplication();
	$jinput 	= $mainframe->input;
	$post_string = $jinput->get('target', 0 , 'NONE');
}

	require_once( JPATH_LIBRARIES.'/joomla/factory.php' );
	
	require_once( JPATH_LIBRARIES.'/joomla/environment/response.php' );
	require_once( JPATH_LIBRARIES.'/joomla/environment/uri.php' );
	require_once( JPATH_LIBRARIES.'/joomla/filesystem/file.php' );
	
$pos	= $post_string;
$file	= JURI::getInstance()->toString();

$pieces = explode('/', $file);
$count	= count($pieces);
$file	= $pieces[$count-1];

$pieces = explode('?', $file);
$file	= $pieces[0];

//$file	= str_replace( JURI::root() , '', $file); var_dump($file);
$file	= JPATH::clean(JPATH_BASE.'/'.base64_decode($file));
$fileName	= JFile::getName($file);

if(!JFile::exists($file))
{
	echo 'file not found: ' . $fileName;
	exit;
}

$fh		= fopen($file, 'rb') or die ('cannot open file: ' . $fileName);
$fileSize = filesize($file) - (($pos > 0) ? $pos  + 1 : 0);
fseek($fh, $pos);

$binary_header	= strtoupper(JFile::getExt($file)).pack('C', 1).pack('C', 1).pack('N', 9).pack('N', 9);

session_cache_limiter('none');
JResponse::clearHeaders();
JResponse::setHeader( 'Expires', 'Mon, 26 Jul 1997 05:00:00 GMT', true );
JResponse::setHeader( 'Last-Modified', gmdate("D, d M Y H:i:s") . ' GMT', true );
JResponse::setHeader( 'Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0', true );
JResponse::setHeader( 'Pragma', 'no-cache', true );
JResponse::setHeader( 'Content-Disposition', 'attachment; filename="'.$fileName.'"', true);
JResponse::setHeader( 'Content-Length', ($pos > 0) ? $fileSize + 13 : $fileSize, true );
JResponse::setHeader( 'Content-Type', 'video/x-flv', true );
JResponse::sendHeaders();

if($pos > 0) 
{
	print $binary_header;
}

$limit_bw		= true;
$packet_size	= 90 * 1024;
$packet_interval= 0.3;

while(!feof($fh)) 
{
	if(!$limit_bw)
	{
		print(fread($fh, filesize($file)));
	}
	else
	{
		$time_start = microtime(true);
		print(fread($fh, $packet_size));
		$time_stop = microtime(true);
		$time_difference = $time_stop - $time_start;
		if($time_difference < $packet_interval)
		{
			usleep($packet_interval * 1000000 - $time_difference * 1000000);
		}
	}
}

exit;
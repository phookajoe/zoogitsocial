<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.filesystem.file' );

class  plgSystemJomsocialUpdate extends JPlugin
{

	public function plgSystemJomsocialUpdate(& $subject, $config)
	{

		parent::__construct($subject, $config);

		$this->mainframe	= JFactory::getApplication();

                $lang = JFactory::getLanguage();
                $lang->load('com_community.menu',JPATH_ADMINISTRATOR);

                // Load javascript
		if( $this->_loadPlugin() )
			$this->_loadScript();

	}

	public function onAfterRender()
	{
		// Render status
		if( $this->_loadPlugin() )
			$this->_renderStatus();
	}

	private function _loadPlugin()
	{
		$my			= JFactory::getUSer();
		$arrayFormat= array('feed','raw');
		$format		= JRequest::getVar( 'format' , '' , 'REQUEST' );
		$nohtml		= JRequest::getVar( 'no_html' , '' , 'REQUEST' );
		$jax	 	= JPluginHelper::isEnabled('system', 'azrul.system');

		// Load only for backend
		if( $this->mainframe->isAdmin() && $my->id && $nohtml != 1 && !in_array($format,$arrayFormat) && $jax ){
			return true;
		}

		return false;
	}

	private function _loadScript()
	{
		$document	= JFactory::getDocument();
		$task		= JRequest::getCmd( 'task' , '' );

		if( $task != 'azrul_ajax' )
		{
			$document->addScript( JURI::root() . 'components/com_community/assets/joms.jquery-1.8.1.min.js' );
			$document->addScript( JURI::root() . 'components/com_community/assets/window-1.0.js' );
			$document->addScript( JURI::root() . 'administrator/components/com_community/assets/admin.js' );
		}
		// Attach the Front end Window CSS
		$css		= rtrim( JURI::root() , '/' ) . '/components/com_community/assets/window.css';

		$document->addStyleSheet( $css );


	}

	private function _renderStatus()
	{
		$date	= JFactory::getDate();
		$jparam	= new JConfig();

		if( !JFile::exists( JPATH_ROOT .'/administrator/components/com_community/community.xml' ) )
		{
			return false;
		}

		if(JFile::exists( JPATH_ROOT .'/administrator/components/com_community/jomsocialupdate.ini' ))
			$lastcheckdate	= JFile::read(JPATH_ROOT .'/administrator/components/com_community/jomsocialupdate.ini');
		else
			$lastcheckdate	= $date->format('Y-m-d H:i:s');
			JFile::write(JPATH_ROOT .'/administrator/components/com_community/jomsocialupdate.ini',$lastcheckdate);

		$dayInterval	= 1; // days
		$currentdate	= $date->format('Y-m-d H:i:s');

	    $checkVersion	= strtotime($currentdate) > strtotime($lastcheckdate)+($dayInterval*60*60*24);

		// Load language
		$lang		= JFactory::getLanguage();
		$lang->load( 'com_community', JPATH_ROOT .'/administrator' );

		$button	= $this->_getButton($checkVersion);
		$html	= JResponse::getBody();
		$html	= str_replace( '<div id="module-status">' , '<div id="module-status">' . $button , $html );

	  	// Load AJAX library for the back end.
		$jaxScript = '';
		$noHTML	= JRequest::getInt( 'no_html' , 0 );
		$format		= JRequest::getWord( 'format' , 'html' );
		if( !$noHTML && $format == 'html' )
		{
			require_once(AZRUL_SYSTEM_PATH .'/pc_includes/ajax.php');
			$jax		= new JAX( AZRUL_SYSTEM_LIVE . '/pc_includes' );
			$jax->setReqURI( rtrim( JURI::root() , '/' ). '/administrator/index.php' );
			$jaxScript	= $jax->getScript();
		}
		JResponse::setBody( $html . $jaxScript );
	}

	private function _getButton($checkVersion=false)
	{
		$button		= '';
		$updateText	= 'Jomsocial is updated';

		// Get the current build number
		$data		= $this->_getCurrentVersionData();
		$build		= $this->_getLocalBuildNumber();
		$version	= $this->_getLocalVersionNumber();

		if( $checkVersion && !empty($data->version) ){
			// Test versions
			if( $version < $data->version || ( ($version <= $data->version) && ( $build < $data->build ) ) )  {
				$updateText	= 'Jomsocial Update Available!';

				$button	= '<span class="jomsocial-update" style="background:#F0F0F0 url(\'components/com_community/assets/icons/community-favicon.png\') no-repeat scroll 3px 3px;">
								<a href="javascript:void(0);" onclick="azcommunity.checkVersion();">
									' . JText::_($updateText) . '
								</a>
							</span>';
			}
		}

		// If local community.xml not found
		if( empty($version) )
			$button	= '<span class="jomsocial-update" style="color:red;background:#F0F0F0 url(\'components/com_community/assets/icons/community-favicon.png\') no-repeat scroll 3px 3px;">
						Jomsocial Not Installed
						</span>';

		// If remote community.xml not found
		if( empty($data->version) )
			$button	= '<span class="jomsocial-update" style="color:red;background:#F0F0F0 url(\'components/com_community/assets/icons/community-favicon.png\') no-repeat scroll 3px 3px;">
						Jomsocial.com is not connected
						</span>';

		return $button;
	}


	private function _getLocalBuildNumber()
	{
		$versionString	= $this->_getLocalVersionString();
		$tmpArray		= explode( '.' , $versionString );

		if( isset($tmpArray[2]) )
		{
			return $tmpArray[2];
		}

		// Unknown build number.
		return 0;
	}

	private function _getLocalVersionNumber()
	{
		$versionString	= $this->_getLocalVersionString();

		$tmpArray		= explode( '.' , $versionString );

		if( isset($tmpArray[0] ) && isset( $tmpArray[1] ) )
		{
			return doubleval( $tmpArray[0] . '.' . $tmpArray[1] );
		}
		return 0;
	}

	/**
	 * Read version from remove server
	 * @return [object] [version of current info in server]
	 */
	private function _getCurrentVersionData()
	{
		$xml = JPATH_ROOT .'/administrator/components/com_community/community.xml';;

		$parser = new SimpleXMLElement($xml, NULL, TRUE);

		return $parser;
	}

	/**
	 * Read local xml file to get current version
	 * @return [string] [Current version]
	 */
	private function _getLocalVersionString()
	{
		static $version	= '';

		$xml	= JPATH_ROOT .'/administrator/components/com_community/community.xml';

		$parser	= new SimpleXMLElement( $xml , NULL , true );

		if( is_object($parser) && empty( $version ) )
		{
			$version		= $parser->version;
		}

		return $version;
	}
}
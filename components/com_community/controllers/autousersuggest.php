<?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class CommunityAutoUserSuggestController extends CommunityBaseController
{
	public function ajaxAutoUserSuggest()
	{
		$config			= CFactory::getConfig();
		$displayName	= $config->get('displayname');
		$html 			= '';
		
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;
		
		$searchModel = CFactory::getModel( 'Search' );
		$searchName = $jinput->get('q', '', 'STRING'); //JRequest::getVar('q', '');
		
		$suggestions = $searchModel->getAutoUserSuggest($searchName, $displayName);
		
		if(!empty($suggestions))
		{
			$names="";
			foreach( $suggestions as $row ){
				$user 	= CFactory::getUser( $row->id );
				$avatar = $user->getAvatar();
				$names .= $row->username."|".$row->id."|".$avatar."|\n";
			}
			
			echo $names;
		}
		exit ();
	}
}

<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * to use CHTML::sort($array)
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );

class CFilterBar
{
	static public function getHTML( $url , $sortItems = array() , $defaultSort = '' , $filterItems = array() , $defaultFilter = '' )
	{
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;
		$cleanURL	= $url;
		$uri		= JFactory::getURI();
		$queries	= JRequest::get('GET');

		// If there is Itemid in the querystring, we need to unset it so that CRoute
		// will generate it's correct Itemid
		if( isset( $queries['Itemid'] ) )
		{
			unset( $queries['Itemid'] );
		}

		// Force link to start with first page
		if( isset($queries['limitstart']) )
		{
			unset($queries['limitstart']);
		}

		if( isset($queries['start']) )
		{
			unset($queries['start']);
		}

		$selectedSort	= $jinput->get->get('sort', $defaultSort, 'STRING'); //JRequest::getVar( 'sort', $defaultSort , 'GET' );
		$selectedFilter = $jinput->get->get('filter', $defaultFilter, 'STRING'); //JRequest::getVar( 'filter', $defaultFilter, 'GET' );

		$tmpl		= new CTemplate();
		$tmpl->set( 'queries'			, $queries );
		$tmpl->set( 'selectedSort' 		,  $selectedSort );
		$tmpl->set( 'selectedFilter' 	, $selectedFilter );
		$tmpl->set( 'sortItems' 		, $sortItems );
		$tmpl->set( 'uri'				, $uri );
		$tmpl->set( 'filterItems'		, $filterItems );

		return $tmpl->fetch( 'filterbar.html' );
	}
}
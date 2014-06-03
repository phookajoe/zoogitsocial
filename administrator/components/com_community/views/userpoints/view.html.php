<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

/**
 * Configuration view for JomSocial
 */
class CommunityViewUserPoints extends JViewLegacy
{
	/**
	 * The default method that will display the output of this view which is called by
	 * Joomla
	 *
	 * @param	string template	Template file name
	 **/
	public function display( $tpl = null )
	{
		global $option;
		$mainframe	= JFactory::getApplication();

		$userpoints	= $this->get( 'UserPoints' );
		$pagination	= $this->get( 'Pagination' );
		$ordering	= $this->get( 'Ordering' );

		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');

		$acl   = JFactory::getACL();
 		$this->assignRef( 'userpoints'	, $userpoints );
 		$this->assignRef( 'pagination'	, $pagination );
 		$this->assignRef( 'lists'	, $ordering );
 		$this->assignRef( 'acl'	, $acl );

		parent::display( $tpl );
	}

	/**
	 * Method to get the publish status HTML
	 *
	 * @param	object	Field object
	 * @param	string	Type of the field
	 * @param	string	The ajax task that it should call
	 * @return	string	HTML source
	 **/
	public function getPublish( &$row , $type , $ajaxTask )
	{

		$imgY	= 'tick.png';
		$imgX	= 'publish_x.png';

		$image	= $row->$type ? $imgY : $imgX;

		$alt	= $row->published ? JText::_('COM_COMMUNITY_PUBLISHED') : JText::_('COM_COMMUNITY_UNPUBLISH');

		$href	= '<a class="jgrid" href="javascript:void(0);" onclick="azcommunity.togglePublish(\'' . $ajaxTask . '\',\'' . $row->id . '\',\'' . $type . '\');">';

		$state	= $row->$type ? 'publish' : 'unpublish';
		$href	.= '<span class="state '.$state.'"><span class="text">'.$alt.'</span></span></a>';

		return $href;
	}

	/**
	 * Private method to set the toolbar for this view
	 *
	 * @access private
	 *
	 * @return null
	 **/
	public function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( JText::_('COM_COMMUNITY_USER_POINTS'), 'userpoints' );

		// Add the necessary buttons
		JToolBarHelper::back( JText::_('COM_COMMUNITY_HOME'), 'index.php?option=com_community');
		JToolBarHelper::divider();
		JToolBarHelper::addNew('ruleScan', JText::_('COM_COMMUNITY_USERPOINTS_RULE_SCAN'));
		JToolBarHelper::publishList('publish', JText::_('COM_COMMUNITY_PUBLISH'));
		JToolBarHelper::unpublishList('unpublish', JText::_('COM_COMMUNITY_UNPUBLISH'));
		JToolBarHelper::trash('removeRules', JText::_('COM_COMMUNITY_DELETE'));
	}
}
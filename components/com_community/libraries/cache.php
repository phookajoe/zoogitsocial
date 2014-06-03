<?php
/**
 * @category	Helper
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.cache.cache');

class CFastCache {
	
	private $_handler = null;
	private $_caching = false;
	
	/**
	 * Constructor
	 *
	 */	 
	public function __construct($handler)
	{
		$this->_handler = $handler;
		$this->_caching = extension_loaded('apc');
	}
	
	
	/**
	 * Generate unique cache id
	 */	 	
	private function _getCacheId($id){
		return 'jomsocial-'.md5($id);
	}
	
	/**
	 * STore the cache
	 */	 	
	public function store($data, $id, $group=null){
		if(!$this->_caching)
			return;
			
		$cacheid = $this->_getCacheId($id);
		if(!is_null($group)){
			// Store the id list in the group list
			$tags = apc_fetch('jomsocial-tags');
			
			// If tags is missing, the whole cache might be invalid, clear it all
			if(!is_array($tags)){
				apc_clear_cache('user');
				$tags = array();
			}
			
			foreach($group as $tag){
				if(!isset($tags[$tag])){
					$tags[$tag] = array();
				}
				
				if(! in_array($cacheid, $tags[$tag]) )
					$tags[$tag][] = $cacheid;
			}
			
			// Store this key back
			apc_store('jomsocial-tags', $tags, 0 );
			
		}
		// Do not use any group
		return apc_store($cacheid, $data);
	}
	
	/**
	 * Return the cache
	 */	 	
	public function get($id){
		if(!$this->_caching)
			return FALSE;
			
		$cacheid = $this->_getCacheId($id);
		
		// Do not use any group
		return apc_fetch($cacheid);
	}
	
	/**
	 * Clean the cache. If group is specified, clean only the group
	 */	 	
	public function clean($group=null, $mode='group'){
		if(!$this->_caching)
			return;
			
		if(!is_null($group)){
			$tags = apc_fetch('jomsocial-tags');
			
			if(is_null($tags)){
				apc_clear_cache('user');
				$tags = array();
			}
			
			// @todo: for each cache id, we should clear it from other tag list as well
			foreach($group as $tag){
				if(!empty($tags[$tag])){
					foreach($tags[$tag] as $id){
						apc_delete($id);
					}
				}
			}
		} else {
			// Clear everything
			apc_clear_cache('user');
		}
		return true;
	}
}
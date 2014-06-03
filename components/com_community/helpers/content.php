<?php
/**
 * @category	Helper
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class CContentHelper
{
	/**
	 * Inject data from paramter to content tags ({}) .
	 * 
	 * @param	$content	Original content with content tags.
	 * @param	$params	Text contain all values need to be replaced.
	 * @param	$html	Auto detect url tag and insert inline.
	 * @return	$text	The content after replacing.	 	 	 
	 **/	 		
	static public function injectTags( $content,$paramsTxt,$html=false )
	{
		$params = new CParameter( $paramsTxt );
		preg_match_all("/{(.*?)}/", $content, $matches, PREG_SET_ORDER);
		if(!empty( $matches )) 
		{
			foreach ($matches as $val) 
			{	
				$replaceWith = JString::trim($params->get($val[1], null));
				if( !is_null( $replaceWith ) ) 
				{
					//if the replacement start with 'index.php', we can CRoute it
					if( JString::strpos($replaceWith, 'index.php') === 0){
						$replaceWith = CRoute::getExternalURL($replaceWith);
					}
					if($html) {
						$replaceUrl = $params->get($val[1].'_url', null);
						if( !is_null( $replaceUrl ) ) 
						{
							//if the replacement start with 'index.php', we can CRoute it
							if( JString::strpos($replaceUrl, 'index.php') === 0){
								$replaceUrl = CRoute::getExternalURL($replaceUrl);
							}
							$replaceWith = '<a href="'.$replaceUrl.'">'.$replaceWith.'</a>';
						}
					}
					$content	= CString::str_ireplace($val[0], $replaceWith, $content);
				}
			}
		}		
		return $content;
	}
}
<?php
/**
 * @category	Helper
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class CStringHelper
{
	/**
	 * Tests a bunch of text and see if it contains html tags.
	 *
	 * @param	$text	String	A text value.
	 * @return	$text	Boolean	True if the text contains html tags and false otherwise.
	 **/
	static public function isHTML( $text )
	{
		$pattern	= '/\<p\>|\<br\>|\<br \/\>|\<b\>|\<div\>/i';
		preg_match( $pattern , JString::strtolower($text) , $matches );

		return empty($matches ) ? false : true;
	}

		/**
	 *  Auto-link the given string
	 */
	static function autoLink($text)
	{
		/* subdomain must be taken into consideration too */
	   $pattern  = '~(
					  (
					   #(?<=([^[:punct:]]{1})|^)			# that must not start with a punctuation (to check not HTML)
					   	https?://[^-][a-zA-Z0-9-]*?[.]	# normal URL lookup
					   )
					   [^\s()<>]+						# characters that satisfy SEF url
					   (?:								# followed by
					   		\([\w\d]+\)					# common character
					   		|							# OR
					   		([^[:punct:]\s]|/)			# any non-punctuation character followed by space OR forward slash
					   )
					 )~x';
		   $callback = create_function('$matches', '
		       $url       = array_shift($matches);
		       $url_parts = parse_url($url);

		       $text = parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH);
		       //$text = preg_replace("/^www./", "", $text);

		       $last = -(strlen(strrchr($text, "/"))) + 1;
		       if ($last < 0) {
		           $text = substr($text, 0, $last) . "&hellip;";
		       }
				$isInternal = JURI::isInternal($url) ? \'\': \'target="_blank" \';
		       return sprintf(\'<a rel="nofollow" \'.$isInternal .\' href="%s">%s</a>\', $url, $text);
		   ');
	   return preg_replace_callback($pattern, $callback, $text);
	}

	/**
	 * Automatically converts new line to html break tag.
	 *
	 * @param	$text	String	A text value.
	 * @return	$text	String	A formatted data which contains html break tags.
	 **/
	static public function nl2br( $text )
	{
		$text	= CString::str_ireplace(array("\r\n", "\r", "\n"), "<br />", $text );
		return preg_replace("/(<br\s*\/?>\s*){3,}/", "<br /><br />", $text);
	}

	static public function isPlural($num)
	{
		return !CStringHelper::isSingular($num);
	}

	static public function isSingular($num)
	{
		$config = CFactory::getConfig();
		$singularnumbers = $config->get('singularnumber');
		$singularnumbers = explode(',', $singularnumbers);

		return in_array($num, $singularnumbers);
	}

	static public function escape($var, $function='htmlspecialchars')
	{
		if (in_array($function, array('htmlspecialchars', 'htmlentities')))
		{
			return call_user_func($function, $var, ENT_COMPAT, 'UTF-8');
		}
		return call_user_func($function, $var);
	}

	/**
	 * @deprecated
	 */
	static public function clean($string)
	{
		jimport('joomla.filter.filterinput');
		$safeHtmlFilter =  JFilterInput::getInstance();
		return $safeHtmlFilter->clean($string);

	}

	/**
	 * @todo: this would fail if the username contains {} char
	 */
	static public function replaceThumbnails( $data )
	{
		// Replace matches for {user:thumbnail:ID} so that this can be fixed even if the caching is enabled.
		$html	= preg_replace_callback('/\{user:thumbnail:(.*)\}/', array('CStringHelper','replaceThumbnail') , $data );

		return $html;
	}

	static public function replaceThumbnail(  $matches )
	{
		static	$data = array();

		if( !isset($data[$matches[1]]) )
		{
			$user	= CFactory::getUser( $matches[1] );
			$data[ $matches[1] ]	= $user->getThumbAvatar();
		}

		return $data[ $matches[1] ];
	}

	/**
	 * Truncate the given text
	 * @deprecated Use truncate instead. Trim has different meaning in PHP
	 * @param string	$value
	 * @param int		$length
	 * @return string
	 */
	static public function trim( $value , $length )
	{
		return JHTML::_('string.truncate', $value, $length);
	}

	/**
	 * Truncate the given text and append with '...' if necessary
	 * @param string $str			string to truncate
	 * @param int	 $lenght		length of the final string
	 * @deprecated in 2.8. Removed in 3.0
	 */
	static public function truncate( $value , $length, $wrapSuffix =  '<span>...</span>', $excludeImg = true )
	{
		if( $excludeImg )
		{
			$value = preg_replace("/<img[^>]+\>/i", " ", $value);
		}

		if( JString::strlen($value) > $length )
		{
			return JString::substr( $value , 0 , $length ) . ' ' . $wrapSuffix;
		}
		return $value;
	}

	static public function getRandom($length = 11)
	{
		$map			= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$len 			= strlen($map);
		$stat			= stat(__FILE__);
		$randomString	= '';

		if(empty($stat) || !is_array($stat))
			$stat = array(php_uname());

		mt_srand(crc32(microtime() . implode('|', $stat)));
		for ($i = 0; $i < $length; $i ++) {
			$randomString .= $map[mt_rand(0, $len -1)];
		}

		return $randomString;
	}
}

/**
 * Deprecated since 1.8
 */
function cIsPlural($num)
{
	return !CStringHelper::isSingular( $num );
}

/**
 * Deprecated since 1.8
 */
function cIsSingular($num)
{
	return CStringHelper::isSingular( $num );
}

/**
 * Deprecated since 1.8
 */
function cEscape($var, $function='htmlspecialchars')
{
	return CStringHelper::escape( $var , $function );
}

/**
 * Deprecated since 1.8
 */
function cCleanString($string)
{
	return CStringHelper::clean( $string );
}

/**
 * Deprecated since 1.8
 */
function cReplaceThumbnails( $data )
{
	return CStringHelper::replaceThumbnails( $data );
}

/**
 * Deprecated since 1.8
 */
function cTrimString( $value , $length )
{
	return JHTML::_('string.truncate', $value , $length );
}
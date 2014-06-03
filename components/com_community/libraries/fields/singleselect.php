<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ROOT.'/components/com_community/libraries/fields/select.php');

class CFieldsSingleselect extends CFieldsSelect
{
	public function getFieldHTML( $field , $required,$isDropDown = false)
	{
		return parent::getFieldHTML($field, $required, $isDropDown);
	}

}
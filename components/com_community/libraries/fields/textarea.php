<?php
/**
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once COMMUNITY_COM_PATH.'/libraries/fields/profilefield.php';

class CFieldsTextarea extends CProfileField
{
	public function getFieldHTML($field, $required)
	{



		$params   = new CParameter($field->params);
		$readonly = $params->get('readonly') && ! COwnerHelper::isCommunityAdmin() ? ' readonly=""' : '';
		$style    = $this->getStyle() ? ' style="'.$this->getStyle().'" ' : '';

		//extract the max char since the settings is in params
		$max_char = $params->get('max_char');
		$config   = CFactory::getConfig();
		$js       = 'assets/validate-1.5.min.js';

		CAssets::attach($js, 'js');

		// If maximum is not set, we define it to a default
		$max_char = empty( $max_char ) ? 200 : $max_char;
		$class    = ($field->required == 1) ? ' required' : '';
		$class    .= ! empty( $field->tips ) ? ' jomNameTips tipRight' : '';
		$html     = '<textarea id="field'.$field->id.'" name="field'.$field->id.'" class="textarea'.$class.'" title="'.CStringHelper::escape( JText::_( $field->tips ) ).'"'.$style.$readonly.'>'.$field->value.'</textarea>';
		$html     .= '<span id="errfield'.$field->id.'msg" style="display:none;">&nbsp;</span>';
		$html     .= '<script type="text/javascript">cvalidate.setMaxLength("#field'.$field->id.'", "'.$max_char.'");</script>';

		return $html;
	}

	public function isValid( $value , $required )
	{
		if ($required && empty($value))
		{
			return false;
		}
		//validate string length
		if ( ! $this->validLength($value))
		{
			return false;
		}

		return true;
	}
}

<?php
/**
 * @package		JomSocial
 * @subpackage 	Libraries
 * @copyright (C) 2012 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

class CInput extends JInput {

	public function __get($name)
	{
		if (isset($this->inputs[$name]))
		{
			return $this->inputs[$name];
		}

		$className = 'CInput' . $name;
		if (class_exists($className))
		{
			$this->inputs[$name] = new $className(null, $this->options);
			return $this->inputs[$name];
		}

		$superGlobal = '_' . strtoupper($name);
		if (isset($GLOBALS[$superGlobal]))
		{
			$this->inputs[$name] = new CInput($GLOBALS[$superGlobal], $this->options);
			return $this->inputs[$name];
		}

		// TODO throw an exception
	}

	/**
	 * Gets a value from the input data.
	 *
	 * @param   string  $name     Name of the value to get.
	 * @param   mixed   $default  Default value to return if variable does not exist.
	 * @param   string  $filter   Filter to apply to the value.
	 *
	 * @return  mixed  The filtered input value.
	 *
	 * @since   11.1
	 */
	public function get($name, $default = null, $filter = 'cmd')
	{

		// No filtering in RAW format
		if( strtoupper($filter) == 'RAW') {

			if (isset($this->data[$name]))
			{
				return $this->data[$name];
			}

			return $default;
		}
		return parent::get($name, $default, $filter);
	}
}
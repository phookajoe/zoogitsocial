<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.registry.registry');

class CParameter extends JRegistry
{
	/**
	 * [$_xml description]
	 * @var [type]
	 */
	protected $_xml = null;

	/**
	 * __construct description
	 * @param [object] $data    [description]
	 * @param [string] $xmlPath [description]
	 */
	public function __construct($data, $xmlPath = NULL)
	{
		parent::__construct($data);
		
		if(!is_null($xmlPath))
		{
			$this->_xml = new SimpleXMLElement($xmlPath,NULL,true);
		}
	}

	/**
	* @param string name
	* @param string group [currently not used, being put there to imitate JParameter render()]
	* @return string html
	*/
	public function render()
	{
		$html	= array();
		$html[]	= '<table width="100%" class="cFormTable" cellspacing="0" cellspacing="0">';
		$params	= $this->_xml->params;
		$data	= $this->data;

		foreach($params as $param)
		{
			foreach($param as $_param)
			{
				$html[] = '<tr>';

				if($_param['type'] == 'spacer')
				{
					$html[] = '<td class="label"><span class="editlinktip"> </span></td>';
					$html[] = '<td class="field" valign="top">'.$_param['default'].'</td>';
				}
				else
				{
					$html[] = '<td class="label"><span class="editlinktip" title="'.(empty($_param['description']) ? '' : $_param['description'] ).'">'. $_param['label'] .'</span></td>';
					$html[] = '<td class="field" valign="top">'. $this->_generateHTML($_param,$data) .'</td>';
				}


				$thml[] = '</tr>';
			}
		}

		$html[] = '</table>';

		return implode("\n", $html);

	}
	/**
	 * [bind description]
	 * @param  [type] $data  [description]
	 * @param  string $group [description]
	 * @return [type]        [description]
	 */
	public function bind($data, $group = '_default')
	{
		if (is_array($data))
		{
			return $this->loadArray($data, $group);

		} elseif (is_object($data))
		{
			return $this->loadObject($data, $group);

		} else
		{
			// Return JSON
			return $this->loadString($data);
		}

	}
	/**
	 * [generateHTML description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	private function _generateHTML($data,$value)
	{
		if(!is_object($data))
		{
			return false;
		}

		$html = array();

		// Setup empty value if tehre is none
		if(empty($value->$data['name'])){
			$value->$data['name'] = '';
		}

		switch ($data['type'])
		{
			case 'list':
				$html[] = '<select title="'.(empty($data['description']) ? '' : $data['description'] ).'" id="params'.$data['name'].'" name="params['.$data['name'].']">';
				$html[] = $this->_getOption($data,$value->$data['name']);
				$html[] = '</select>';
				break;
			case 'radio':
				$html[] = $this->_getRadio($data,$value->$data['name']);
				break;
			case 'twitter':
				$html[] = CTwitter::getOAuthRequest();
				break;
			case 'text':
				$html[] = '<input title="'.(empty($data['description']) ? '' : $data['description'] ).'" id=params'.$data['name'].' class="text_area" type="text" value="'.$value->$data['name'].'" name=params['.$data['name'].']>';
				break;
			case 'textarea':
				$html[] = '<textarea title="'.(empty($data['description']) ? '' : $data['description'] ).'" id="params'.$data['name'].' class="fullwidth" rows="" cols="" name="'.$data['name'].'">'.$value->$data['name'].'</textarea>';
				break;
		}

		return implode("\n",$html);
	}

	/**
	 * [getOption description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	private function _getOption($data,$value)
	{
		$html = array();
		foreach($data->children() as $_data)
		{
			$selected = ($_data['value'] == $value) ? ' selected="selected"' : '';
			$html[] = '<option value='.$_data['value'].$selected.'>'.$_data['name'].'</option>';
		}

		return implode("\n", $html);
	}
	private function _getRadio($data,$value)
	{
		$html = array();
		$name = $data['name'];

		foreach($data->children() as $_data)
		{
			$selected = (isset($value) && $_data['value'] == $value) ? ' checked="checked"' : '';
			$html[] = '<input title="'.(empty($data['description']) ? '' : $data['description'] ).'" id="params'.$name.$_data['value'].'" type="radio" name="params['.$name.']" value='.$_data['value'].$selected.' />';
			$html[] = '<label for="params'.$name.$_data['value'].'">'.$_data['name'].'</label>';
		}

		return implode("\n", $html);
	}
}

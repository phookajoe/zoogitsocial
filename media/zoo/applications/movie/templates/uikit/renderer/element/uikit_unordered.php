<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// create label
$label = '';
if (isset($params['showlabel']) && $params['showlabel']) {
	$label .= '<h2 class="uk-margin-top-remove">';
	$label .= ($params['altlabel']) ? $params['altlabel'] : $element->config->get('name');
	$label .= ': </h2>';
}

// create class attribute
$class = 'element element-'.$element->getElementType();

?>

<?php echo $label; ?>

<ul class="uk-list">
    <li class="<?php echo $class; ?>">
    	<?php echo $element->render($params); ?>
    </li>
</ul>
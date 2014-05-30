<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$css_class = $this->application->getGroup().'-'.$this->template->name;

?>

<div class="yoo-zoo <?php echo $css_class; ?> <?php echo $css_class.'-tag'; ?>">

	<?php if ($this->params->get('template.show_alpha_index')) : ?>
		<?php echo $this->partial('alphaindex'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('template.show_title')) : ?>
	<h1 class="uk-h1 <?php echo 'uk-text-'.$this->params->get('template.alignment'); ?>"><?php echo JText::_('Recipes tagged with').': '.$this->tag; ?></h1>
	<?php endif; ?>

	<?php

		// render items
		if (count($this->items)) {
			$has_categories = false;
			$itemstitle = '';
			echo $this->partial('items', compact('itemstitle', 'has_categories'));
		}

	?>

</div>
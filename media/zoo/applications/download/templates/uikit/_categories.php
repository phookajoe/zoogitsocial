<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php

	// init vars
	$i = 0;

	// render rows
	foreach ($this->selected_categories as $category) {
		if ($category && !($category->totalItemCount() || $this->params->get('config.show_empty_categories', false))) continue;
		if ($i % $this->params->get('template.categories_cols') == 0) echo ($i > 0 ? '</div><hr class="uk-grid-divider"><div class="uk-grid uk-grid-divider" data-uk-grid-margin data-uk-grid-match>' : '<div class="uk-grid uk-grid-divider" data-uk-grid-margin data-uk-grid-match>');
		echo '<div class="uk-width-medium-1-'.$this->params->get('template.categories_cols').'">'.$this->partial('category', compact('category')).'</div>';
		$i++;
	}
	if (!empty($this->selected_categories)) {
		echo '</div>';
	}

?>
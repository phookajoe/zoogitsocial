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
	$columns = $this->params->get('template.items_cols', 2);
	reset($this->items);

	// render rows
	while ((list($key, $item) = each($this->items))) {
		if ($i % $columns == 0) echo ($i > 0 ? '</div><div class="uk-grid uk-grid-divider" data-uk-grid-margin data-uk-grid-match>' : '<div class="uk-grid uk-grid-divider" data-uk-grid-margin data-uk-grid-match>');
		echo '<div class="uk-width-medium-1-'.$columns.'">'.$this->partial('item', compact('item')).'</div>';
		$i++;
	}
	if (!empty($this->items)) {
		echo '</div>';
	}

?>

<?php echo $this->partial('pagination'); ?>
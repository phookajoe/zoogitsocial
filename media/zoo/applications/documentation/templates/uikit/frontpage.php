<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// show description only if it has content
if (!$this->application->description) {
	$this->params->set('template.show_description', 0);
}

// show title only if it has content
if (!$this->application->getParams()->get('content.title')) {
	$this->params->set('template.show_title', 0);
}

// show image only if an image is selected
if (!($image = $this->application->getImage('content.image'))) {
	$this->params->set('template.show_image', 0);
}

$css_class = $this->application->getGroup().'-'.$this->template->name;

?>

<div class="yoo-zoo <?php echo $css_class; ?> <?php echo $css_class.'-frontpage'; ?>">

	<?php if ($this->params->get('template.show_title') || $this->params->get('template.show_description') || $this->params->get('template.show_image')) : ?>

		<?php if ($this->params->get('template.show_title')) : ?>
		<h1 class="<?php echo 'uk-text-'.$this->params->get('template.alignment'); ?>"><?php echo $this->application->getParams()->get('content.title'); ?></h1>
		<?php endif; ?>

		<?php if ($this->application->getParams()->get('content.subtitle')) : ?>
		<p class="uk-text-large <?php echo 'uk-text-'.$this->params->get('template.alignment'); ?>"><?php echo $this->application->getParams()->get('content.subtitle'); ?></p>
		<?php endif; ?>

		<?php if ($this->params->get('template.show_description') || $this->params->get('template.show_image')) : ?>
		<div class="uk-margin">
			<?php if ($this->params->get('template.show_image')) : ?>
			<img class="<?php echo 'uk-align-'.($this->params->get('template.alignment') == "left" || $this->params->get('template.alignment') == "right" ? 'medium-' : '').$this->params->get('template.alignment'); ?>" src="<?php echo $image['src']; ?>" title="<?php echo $this->application->getParams()->get('content.title'); ?>" alt="<?php echo $this->application->getParams()->get('content.title'); ?>" <?php echo $image['width_height']; ?>/>
			<?php endif; ?>
			<?php if ($this->params->get('template.show_description')) echo $this->application->getText($this->application->description); ?>
		</div>
		<?php endif; ?>

	<?php endif; ?>

	<?php

		// render categories
		$has_categories = false;
		if ($this->params->get('template.show_categories', true) && ($this->category->childrenHaveItems() || $this->params->get('config.show_empty_categories', false))) {

			// init vars
			$has_categories = true;
			$i = 0;

			// render rows
			foreach ($this->selected_categories as $category) {
				if ($category && !($category->totalItemCount() || $this->params->get('config.show_empty_categories', false))) continue;
				if ($i % $this->params->get('template.categories_cols') == 0) echo ($i > 0 ? '</div><div class="uk-grid" data-uk-grid-margin>' : '<div class="uk-grid" data-uk-grid-margin>');
				echo '<div class="uk-width-medium-1-'.$this->params->get('template.categories_cols').'">'.$this->partial('frontpage_category', compact('category')).'</div>';
				$i++;
			}
			if (!empty($this->selected_categories)) {
				echo '</div>';
			}

		}

	?>

	<?php

		// render items
		if (count($this->items)) {
			echo $this->partial('items', compact('has_categories'));
		}

	?>

</div>
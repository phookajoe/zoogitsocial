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

<div class="uk-grid" data-uk-grid-margin>

	<div class="uk-width-medium-3-4 <?php if($view->params->get('template.item_sidebar_alignment') == 'left') echo 'uk-push-medium-1-4'; ?>">

		<?php if ($this->checkPosition('title')) : ?>
		<h1 class="uk-h1"><?php echo $this->renderPosition('title'); ?></h1>
		<?php endif; ?>

		<?php if ($this->checkPosition('subtitle')) : ?>
		<p class="uk-text-large">
			<?php echo $this->renderPosition('subtitle', array('style' => 'comma')); ?>
		</p>
		<?php endif; ?>

		<?php if ($this->checkPosition('description')) : ?>
			<?php echo $this->renderPosition('description'); ?>
		<?php endif; ?>

		<?php if ($this->checkPosition('contact')) : ?>
		<div class="uk-margin">
			<h3><?php echo JText::_('Contact'); ?></h3>
			<ul class="uk-list">
				<?php echo $this->renderPosition('contact', array('style' => 'uikit_list')); ?>
			</ul>
		</div>
		<?php endif; ?>

	</div>

	<?php if ($this->checkPosition('sidebar')) : ?>
	<div class="uk-width-medium-1-4 <?php if($view->params->get('template.item_sidebar_alignment') == 'left') echo 'uk-pull-medium-3-4'; ?>">
		<?php echo $this->renderPosition('sidebar', array('style' => 'uikit_panel')); ?>
	</div>
	<?php endif; ?>

</div>
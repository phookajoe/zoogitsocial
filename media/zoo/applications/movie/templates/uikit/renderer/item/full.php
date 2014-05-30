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

<?php if ($this->checkPosition('top')) : ?>
	<?php echo $this->renderPosition('top', array('style' => 'uikit_block')); ?>
<?php endif; ?>

<div class="uk-grid" data-uk-grid-margin>

	<div class="uk-width-medium-3-4 <?php if($view->params->get('template.item_sidebar_alignment') == 'left') echo 'uk-push-medium-1-4'; ?>">

		<?php if ($this->checkPosition('title')) : ?>
		<h1 class="uk-h1"><?php echo $this->renderPosition('title'); ?></h1>
		<?php endif; ?>

		<?php if ($this->checkPosition('meta')) : ?>
		<p class="uk-text-muted">
			<?php echo $this->renderPosition('meta', array('style' => 'comma')); ?>
		</p>
		<?php endif; ?>

		<?php if ($this->checkPosition('description')) : ?>
			<?php echo $this->renderPosition('description', array('style' => 'uikit_blank')); ?>
		<?php endif; ?>

		<?php if ($this->checkPosition('specification')) : ?>
		<ul class="uk-list">
			<?php echo $this->renderPosition('specification', array('style' => 'uikit_list')); ?>
		</ul>
		<?php endif; ?>

		<?php if ($view->params->get('template.show_spoiler_warning')) : ?>
		<p class="uk-alert uk-alert-warning"><?php echo '<strong>'.JText::_('Warning').'</strong> '.JText::_('The following summary contains spoilers'); ?></p>
		<?php endif; ?>

		<?php if ($this->checkPosition('summary')) : ?>
			<?php echo $this->renderPosition('summary', array('style' => 'uikit_blank')); ?>
		<?php endif; ?>

	</div>

	<?php if ($this->checkPosition('sidebar')) : ?>
	<div class="uk-width-medium-1-4 <?php if($view->params->get('template.item_sidebar_alignment') == 'left') echo 'uk-pull-medium-3-4'; ?>">
		<?php echo $this->renderPosition('sidebar', array('style' => 'uikit_panel')); ?>
	</div>
	<?php endif; ?>

</div>

<?php if ($this->checkPosition('bottom')) : ?>
	<?php echo $this->renderPosition('bottom', array('style' => 'uikit_block')); ?>
<?php endif;
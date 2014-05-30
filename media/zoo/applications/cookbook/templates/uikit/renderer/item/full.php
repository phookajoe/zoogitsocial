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

	<?php if ($this->checkPosition('title') || $this->checkPosition('header')) : ?>

		<?php if ($this->checkPosition('header')) : ?>
		<div class="uk-align-medium-right">
			<?php echo $this->renderPosition('header', array('style' => 'uikit_block')); ?>
		</div>
		<?php endif; ?>

		<?php if ($this->checkPosition('title')) : ?>
		<h1 class="uk-h1"><?php echo $this->renderPosition('title'); ?></h1>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($this->checkPosition('infobar')) : ?>
	<ul class="uk-subnav uk-subnav-line">
		<?php echo $this->renderPosition('infobar', array('style' => 'uikit_list')); ?>
	</ul>
	<?php endif; ?>

<div class="uk-panel uk-panel-box">
<?php if ($this->checkPosition('media') || $this->checkPosition('ingredients')) : ?>

	<?php if ($this->checkPosition('media')) : $alignment = $view->params->get('template.item_media_alignment'); ?>
	<div class="uk-thumbnail <?php echo 'uk-align-'.($alignment == "left" || $alignment == "right" ? 'medium-' : '').$alignment; ?>">
		<?php echo $this->renderPosition('media'); ?>
	</div>
	<?php endif; ?>

	<?php if ($this->checkPosition('ingredients')) : ?>
		<?php echo $this->renderPosition('ingredients', array('style' => 'uikit_blank_panel')); ?>
	<?php endif; ?>

<?php endif; ?>
</div>

<div class="uk-margin">

	<div class="uk-grid" data-uk-grid-margin>

		<div class="uk-width-medium-3-4 <?php if($view->params->get('template.item_sidebar_alignment') == 'left') echo 'uk-push-medium-1-4'; ?>">

			<?php if ($this->checkPosition('directions')) : ?>
				<?php echo $this->renderPosition('directions', array('style' => 'uikit_blank')); ?>
			<?php endif; ?>

		</div>

	<?php if ($this->checkPosition('sidebar') || $this->checkPosition('directions')) : ?>
		<?php if ($this->checkPosition('sidebar')) : ?>
		<div class="uk-width-medium-1-4 <?php if($view->params->get('template.item_sidebar_alignment') == 'left') echo 'uk-pull-medium-3-4'; ?>">
			<?php echo $this->renderPosition('sidebar', array('style' => 'uikit_panel')); ?>
		</div>
		<?php endif; ?>
	<?php endif; ?>

	</div>

</div>

<?php if ($this->checkPosition('bottom')) : ?>
	<?php echo $this->renderPosition('bottom', array('style' => 'uikit_block')); ?>
</div>
<?php endif;
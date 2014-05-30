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

<?php if ($this->checkPosition('title')) : ?>
<h1><?php echo $this->renderPosition('title'); ?></h1>
<?php endif; ?>

<?php if ($this->checkPosition('media')) : ?>
<div class="<?php echo 'uk-align-'.($view->params->get('template.item_media_alignment') == "left" || $view->params->get('template.item_media_alignment') == "right" ? 'medium-' : '').$view->params->get('template.item_media_alignment'); ?>">
	<?php echo $this->renderPosition('media'); ?>
</div>
<?php endif; ?>

<?php if ($this->checkPosition('description')) : ?>
	<?php echo $this->renderPosition('description'); ?>
<?php endif; ?>

<?php if ($this->checkPosition('specification')) : ?>
<h3><?php echo JText::_('Specifications'); ?></h3>
<ul class="uk-list">
	<?php echo $this->renderPosition('specification', array('style' => 'uikit_list')); ?>
</ul>
<?php endif; ?>

<?php if ($this->checkPosition('bottom')) : ?>
	<?php echo $this->renderPosition('bottom', array('style' => 'uikit_block')); ?>
<?php endif; ?>

<?php if ($this->checkPosition('related')) : ?>
	<?php echo $this->renderPosition('related', array('style' => 'uikit_grid_multirow')); ?>
<?php endif; ?>
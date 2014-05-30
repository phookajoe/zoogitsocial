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

<?php if ($this->checkPosition('media')) : ?>
<div class="uk-thumbnail <?php echo 'uk-align-'.($view->params->get('template.items_media_alignment') == "left" || $view->params->get('template.items_media_alignment') == "right" ? 'medium-' : '').$view->params->get('template.items_media_alignment'); ?>">
	<?php echo $this->renderPosition('media'); ?>
</div>
<?php endif; ?>

<?php if ($this->checkPosition('title')) : ?>
<h3 class="uk-margin-remove">
	<?php echo $this->renderPosition('title'); ?>
</h3>
<?php endif; ?>

<?php if ($this->checkPosition('description')) : ?>
	<?php echo $this->renderPosition('description'); ?>
<?php endif; ?>

<?php if ($this->checkPosition('specification')) : ?>
<ul class="uk-list">
	<?php echo $this->renderPosition('specification', array('style' => 'uikit_list')); ?>
</ul>
<?php endif; ?>

<?php if ($this->checkPosition('links')) : ?>
<ul class="uk-subnav uk-subnav-line">
	<?php echo $this->renderPosition('links', array('style' => 'uikit_subnav')); ?>
</ul>
<?php endif;
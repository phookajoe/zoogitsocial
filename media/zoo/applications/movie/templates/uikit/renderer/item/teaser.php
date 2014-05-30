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
<div class="<?php echo 'uk-text-'.($view->params->get('template.items_media_alignment') == "left" || $view->params->get('template.items_media_alignment') == "right" ? 'medium-' : '').$view->params->get('template.items_media_alignment'); ?>">
	<?php echo $this->renderPosition('media'); ?>
</div>
<?php endif; ?>

<?php if ($this->checkPosition('title')) : ?>
<h2 class="uk-h5 uk-margin uk-text-truncate <?php echo 'uk-text-'.$view->params->get('template.items_media_alignment'); ?>">
	<?php echo $this->renderPosition('title'); ?>
</h2>
<?php endif; ?>

<?php if ($this->checkPosition('description')) : ?>
<ul class="uk-list">
	<?php echo $this->renderPosition('description', array('style' => 'uikit_list')); ?>
</ul>
<?php endif;
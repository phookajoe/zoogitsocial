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
<h1 class="uk-h1"><?php echo $this->renderPosition('title'); ?></h1>
<?php endif; ?>

<?php if ($this->checkPosition('content')) : ?>
	<?php echo $this->renderPosition('content'); ?>
<?php endif; ?>

<?php if ($this->checkPosition('related')) : ?>
	<h3><?php echo JText::_('Related Links'); ?></h3>
	<?php echo $this->renderPosition('related'); ?>
<?php endif; ?>

<?php if ($this->checkPosition('meta') || $this->checkPosition('taxonomy')) : ?>
<div class="uk-text-muted">

	<?php if ($this->checkPosition('meta')) : ?>
		<?php echo $this->renderPosition('meta'); ?>
	<?php endif; ?>

	<?php if ($this->checkPosition('taxonomy')) : ?>
		<?php echo $this->renderPosition('taxonomy'); ?>
	<?php endif; ?>

</div>
<?php endif; ?>

<?php if ($this->checkPosition('bottom')) : ?>
	<?php echo $this->renderPosition('bottom', array('style' => 'uikit_block')); ?>
<?php endif;
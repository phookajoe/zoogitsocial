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

<div class="uk-grid" data-uk-grid-match="{target:'.uk-panel'}">

    <div class="uk-width-medium-3-4">
        <div class="uk-panel">
            <?php if ($this->checkPosition('specification')) : ?>
            <ul class="uk-list uk-list-line">
                <?php echo $this->renderPosition('specification', array('style' => 'uikit_list')); ?>
            </ul>
            <?php endif; ?>

            <?php if ($this->checkPosition('button')) : ?>
            <div class="uk-margin">
                <?php echo $this->renderPosition('button'); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="uk-width-medium-1-4">

        <div class="uk-panel uk-panel-box">
            <?php if ($this->checkPosition('media')) : ?>
            <div class="uk-margin">
                <?php echo $this->renderPosition('media'); ?>
            </div>
            <?php endif; ?>

            <?php if ($this->checkPosition('right')) : ?>
            <div class="uk-margin">
                <?php echo $this->renderPosition('right'); ?>
            </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<?php if ($this->checkPosition('bottom')) : ?>
	<?php echo $this->renderPosition('bottom', array('style' => 'uikit_block')); ?>
<?php endif;
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

<?php if ($this->checkPosition('title')) : ?>
<h2>
	<?php echo $this->renderPosition('title'); ?>
</h2>
<?php endif; ?>

<?php if ($this->checkPosition('description')) : ?>
	<?php echo $this->renderPosition('description'); ?>
<?php endif; ?>

<?php if ($this->checkPosition('links')) : ?>
<ul class="uk-subnav uk-subnav-line">
	<?php echo $this->renderPosition('links', array('style' => 'uikit_subnav')); ?>
</ul>
<?php endif;
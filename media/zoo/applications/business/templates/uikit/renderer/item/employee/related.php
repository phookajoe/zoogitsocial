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
<li class="uk-width-medium-1-2">
	<?php if ($this->checkPosition('media')) : ?>
	<div class="uk-thumbnail uk-align-medium-left">
		<?php echo $this->renderPosition('media'); ?>
	</div>
	<?php endif; ?>

	<?php if ($this->checkPosition('title')) : ?>
	<h4 class="uk-margin-remove">
		<?php echo $this->renderPosition('title'); ?>
	</h4>
	<?php endif; ?>

	<?php if ($this->checkPosition('subtitle')) : ?>
	<div>
		<?php echo $this->renderPosition('subtitle', array('style' => 'comma')); ?>
	</div>
	<?php endif; ?>

	<?php if ($this->checkPosition('links')) : ?>
	<ul class="uk-subnav uk-subnav-line uk-margin-remove">
		<?php echo $this->renderPosition('links', array('style' => 'uikit_subnav')); ?>
	</ul>
	<?php endif; ?>
</li>
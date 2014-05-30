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
<div class="uk-clearfix">
    <?php if ($this->checkPosition('media')) : ?>
    <div class="uk-align-medium-left">
    	<?php echo $this->renderPosition('media'); ?>
    </div>
    <?php endif; ?>

    <?php if ($this->checkPosition('title')) : ?>
    <h4 class="uk-h5 uk-margin-remove">
    	<?php echo $this->renderPosition('title'); ?>
    </h4>
    <?php endif; ?>
</div>
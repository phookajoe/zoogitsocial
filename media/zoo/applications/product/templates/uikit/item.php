<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$css_class = $this->application->getGroup().'-'.$this->template->name;

?>

<div class="yoo-zoo <?php echo $css_class; ?> <?php echo $css_class.'-'.$this->item->alias; ?>">

	<?php echo $this->renderer->render('item.full', array('view' => $this, 'item' => $this->item)); ?>

	<?php if ($this->application->isCommentsEnabled() && ($this->item->isCommentsEnabled() || $this->item->getCommentsCount(1))) : ?>
		<?php echo $this->app->comment->renderComments($this, $this->item); ?>
	<?php endif; ?>

</div>
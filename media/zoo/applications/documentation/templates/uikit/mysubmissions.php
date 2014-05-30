<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// include syntaxhighlighter
$this->app->document->addScript($this->template->resource.'libraries/prettify/prettify.js');
$css = $this->application->getParams('site')->get('template.prettify_style', 'prettify.css');
$this->app->document->addStylesheet($this->template->resource.'libraries/prettify/'.$css);

$css_class = $this->application->getGroup().'-'.$this->template->name;

?>

<div class="yoo-zoo <?php echo $css_class; ?> <?php echo $css_class.'-'.$this->submission->alias; ?>">

	<h1 class="uk-h1"><?php echo JText::_('My Submissions'); ?></h1>

	<p><?php echo sprintf(JText::_('Hi %s, here you can edit your submissions and add new submission.'), $this->user->name); ?></p>

	<?php

		echo $this->partial('mysubmissions');

	?>

</div>

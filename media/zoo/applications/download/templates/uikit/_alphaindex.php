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

<ul class="uk-subnav uk-subnav-line uk-text-center">
	<?php
        foreach (explode("\n", $this->alpha_index->render()) as $char) {
            echo "<li>{$char}</li>\n";
        }
    ?>
</ul>

<hr>
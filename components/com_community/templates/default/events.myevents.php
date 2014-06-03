<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */
defined('_JEXEC') or die();
?>

<div class="cLayout cEvents-MyEvents">
	<?php echo $sortings; ?>

	<div class="cSidebar">
		<?php echo $this->view('events')->modEventPendingList(); ?>
	</div>

	<div class="cMain">
		<?php echo $eventsHTML; ?>
	</div>
</div>
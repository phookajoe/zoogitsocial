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

<div class="cAlert alert-error">
	<?php echo JText::_('COM_COMMUNITY_PERMISSION_DENIED_WARNING');?>
</div>
<?php 
$this->load('frontpage.guests.php');
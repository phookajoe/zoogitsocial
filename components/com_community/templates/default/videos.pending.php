<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * 
 */
defined('_JEXEC') or die();
?>

<p><?php echo JText::_('COM_COMMUNITY_VIDEOS_PENDING_VIDEOS_STEPS'); ?></p>

<div class="cVideoIndex">
	<?php echo $videosHTML;?>
</div>
<?php 
if ( $pagination->getPagesLinks() ) 
{
?>
<div class="cPagination">
	<?php echo $pagination->getPagesLinks(); ?>
</div>
<?php 
} 
?>

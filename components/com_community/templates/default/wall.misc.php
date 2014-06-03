<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php 
 */
defined('_JEXEC') or die();
?>

<?php if(!empty($viewAllLink)): ?>
<div class="cComments-All">
	<a href="<?php echo $viewAllLink; ?>" class="cButton">
		<?php echo JText::_('COM_COMMUNITY_VIEW_ALL'); ?><?php if (isset($count)) echo ' ('.$count.')'; ?>
	</a>
</div>
<?php endif; ?>
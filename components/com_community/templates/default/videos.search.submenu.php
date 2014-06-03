<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	posted	boolean	Determines whether the current state is a posted event.
 */
defined('_JEXEC') or die();
?>

<ul class="cSubmenu-Search cResetList">
	<li>
		<form class="cForm" name="jsform-videos-search" method="get" action="<?php echo $url; ?>" class="clearfix">
			<input type="text" class="input text" name="search-text" value="" />
			<input type="submit" value="<?php echo JText::_('COM_COMMUNITY_SEARCH'); ?>" class="cButton cButton-Black cButton-Small">

			<?php echo JHTML::_( 'form.token' ) ?>
			<input type="hidden" name="option" value="com_community" />
			<input type="hidden" name="view" value="videos" />
			<input type="hidden" name="task" value="search" />
			<input type="hidden" name="Itemid" value="<?php echo CRoute::getItemId();?>" />
		</form>
	</li>
</ul>
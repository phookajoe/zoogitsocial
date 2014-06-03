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
		<form class="cForm" name="jsform-search" method="get" action="<?php echo $url; ?>">
			<input type="text" class="input text" name="q" value="" />
			<label class="label-checkbox">
				<input type="checkbox" name="avatar" style="margin-right: 5px;" value="1" class="input checkbox">
				<?php echo JText::_('COM_COMMUNITY_EVENTS_AVATAR_ONLY'); ?>
			</label>
			<input class="cButton cButton-Black cButton-Small" type="submit" value="<?php echo JText::_('COM_COMMUNITY_SEARCH'); ?>">
			<?php echo JHTML::_( 'form.token' ) ?>
			<input type="hidden" value="com_community" name="option" />
			<input type="hidden" value="search" name="view" />
			<input type="hidden" value="<?php echo CRoute::getItemId();?>" name="Itemid" />
		</form>
	</li>
</ul>
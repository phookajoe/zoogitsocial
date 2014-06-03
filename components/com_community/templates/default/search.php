<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @param	author		string
 * @param	$results	An array of user objects for the search result
 */
defined('_JEXEC') or die();
?>
<div class="cLayout cSearch">
	<form name="jsform-search" method="get" action="" class="cSearch-Form cForm">

		<label for="q" class="cSearch-Input clearfix">
			<input type="text" id="q" class="cSearch-Text cFloat-L" name="q" value="<?php echo $this->escape( $query ); ?>" placeholder="<?php echo JText::_('COM_COMMUNITY_SEARCH_PEOPLE_PLACEHOLDER');?>" />
			<input type="submit" value="<?php echo JText::_('COM_COMMUNITY_SEARCH_BUTTON_TEMP');?>" class="cButton cButton-Blue cFloat-R" name="Search" />
		</label>

		<div class="cSearch-Helper">
			<label class="label-checkbox">
				<input type="checkbox" name="avatar" id="avatar" value="1" class="input checkbox "<?php echo ($avatarOnly) ? ' checked="checked"' : ''; ?>>
				<?php echo JText::_('COM_COMMUNITY_EVENTS_AVATAR_ONLY'); ?>
			</label>
		</div>

		<input type="hidden" name="option" value="com_community" />
		<input type="hidden" name="view" value="search" />
		<input type="hidden" name="Itemid" value="<?php echo CRoute::_getDefaultItemid();?>">
	</form>

	<?php
	if( $results )
	{
	?>
	<div class="cSearch-Result">
		<p>
			<b><?php echo JText::_('COM_COMMUNITY_SEARCH_RESULTS');?></b>
		</p>
		<?php echo $resultHTML;?>
	</div>
	<?php
	}
	else if( empty( $results ) && !empty( $query ) )
	{
	?>
	<div class="cAlert cEmpty">
		<?php echo JText::_('COM_COMMUNITY_NO_RESULT_FROM_SEARCH');?>
	</div>
	<?php
	}
	?>

	<div class="cSearch-Jumper">
	<?php
	echo JText::_('COM_COMMUNITY_SEARCH_FOR');

	foreach ($searchLinks as $key => $value)
	{
	?>
		<a href="<?php echo $value; ?>"><?php echo $key; ?></a>
	<?php
	}
	?>
	</div>
</div>
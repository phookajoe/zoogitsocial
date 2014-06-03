<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	posted	boolean	Determines whether the current state is a posted event.
 * @param	search	string	The text that the user used to search 
 */
defined('_JEXEC') or die();
?>
<div class="cLayout cSearch Groups">
	<form name="jsform-groups-search" method="get" action="" class="cSearch-Form cForm">
		<?php if(!empty($beforeFormDisplay)){ ?>
			<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
				<?php echo $beforeFormDisplay; ?>
			</table>
		<?php } ?>
		
		<label class="cSearch-Input clearfix" for="q">
			<span class="input-wrap">
				<input type="text" id="q" class="cSearch-Text cFloat-L" name="search" value="<?php echo $this->escape($search); ?>" style="width: 100%;" placeholder="<?php echo JText::_('COM_COMMUNITY_SEARCH_GROUP_PLACEHOLDER');?>" />
			</span>

		<?php if(!empty($afterFormDisplay)){ ?>
			<table class="formtable" cellspacing="1" cellpadding="0" style="width: 98%;">
				<?php echo $afterFormDisplay; ?>
			</table>
		<?php } ?>

		<div class="clearfix">
			<input type="submit" value="<?php echo JText::_('COM_COMMUNITY_SEARCH_BUTTON');?>" class="cButton cButton-Blue cFloat-R" />
			<?php // echo JText::_('COM_COMMUNITY_GROUPS_CATEGORY');?>
			<select name="catid" id="catid" class="required" title="" style="width: 40%">
				<option value="0" selected><?php echo JText::_('COM_COMMUNITY_GROUPS_CATEGORY_TIPS');?></option>
				<?php
				foreach( $categories as $category )
				{
				?>
					<option value="<?php echo $category->id; ?>" <?php if( $category->id == $catId ) { ?>selected<?php } ?>>
						<?php echo JText::_( $this->escape($category->name) ); ?>
					</option>
				<?php
				}
				?>
			</select>
		</div>


		<?php echo JHTML::_( 'form.token' ); ?>
		<input type="hidden" value="com_community" name="option" />
		<input type="hidden" value="groups" name="view" />
		<input type="hidden" value="search" name="task" />
		<input type="hidden" value="<?php echo CRoute::getItemId();?>" name="Itemid" />
	</form>
	
	<?php
	if( $posted )
	{
	?>
	<div class="cSearch-Result">
		<p>
			<span>
				<?php echo JText::sprintf( 'COM_COMMUNITY_GROUPS_SEARCH_RESULT' , $search ); ?>
			</span>
			<span class="cFloat-R">
				<?php echo JText::sprintf( (CStringHelper::isPlural($groupsCount)) ? 'COM_COMMUNITY_GROUPS_SEARCH_RESULT_TOTAL_MANY' : 'COM_COMMUNITY_GROUPS_SEARCH_RESULT_TOTAL' , $groupsCount ); ?>
			</span>
			<div style="clear:both;"></div>
		</p>

		<?php echo $groupsHTML; ?>
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
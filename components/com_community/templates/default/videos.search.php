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

<div class="cLayout cSearch Videos">
	<form name="searchVideo" action="<?php echo CRoute::getURI(); ?>" method="get" class="cSearch-Form cForm">
		<label for="q" class="cSearch-Input clearfix">
			<input type="text" id="q" class="cSearch-Text cFloat-L" name="search-text" placeholder="<?php echo JText::_('COM_COMMUNITY_SEARCH_VIDEO_PLACEHOLDER');?>" />
			<input type="submit" name="search" class="cButton cButton-Blue cFloat-R" value="<?php echo JText::_('COM_COMMUNITY_SEARCH_BUTTON_TEMP');?>"/>
		</label>
		
		<input type="hidden" name="Itemid" value="<?php echo CRoute::getItemId(); ?>" />
		<input type="hidden" name="option" value="com_community" />
		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="view" value="videos" />
	</form>
	
	<?php
	if( !empty($search) )
	{
	?>
	<div class="cSearch-Result">
		<p>
			<span>
				<?php echo JText::sprintf( 'COM_COMMUNITY_SEARCH_RESULT' , $search ); ?>
			</span>
			<span class="cFloat-R">
				<?php echo JText::sprintf( (CStringHelper::isPlural($videosCount)) ? 'COM_COMMUNITY_VIDEOS_SEARCH_RESULT_TOTAL_MANY' : 'COM_COMMUNITY_VIDEOS_SEARCH_RESULT_TOTAL' , $videosCount ); ?>
			</span>
		</p>
		
		<?php echo $videosHTML; ?>

		<?php 
		if ( !empty($pagination) ) 
		{
		?>
		<div class="cPagination">
			<?php echo $pagination; ?>
		</div>
		<?php
		}
		?>
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
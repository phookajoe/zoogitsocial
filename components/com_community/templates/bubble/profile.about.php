<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	profile			A Profile object that contains profile fields for this specific user
 * @param	profile->
 * @params	isMine		boolean is this profile belongs to me?
 */
defined('_JEXEC') or die();
?>
<div class="cProfile-Fields">
	<h2 class="cProfile-Heading cResetH">
		<?php echo JText::_('COM_COMMUNITY_ABOUT_ME');?>

		<?php if( $isMine ): ?>
		<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&task=edit');?>" class="cProfile-LinkEdit cButton cButton-Small">
			<?php echo JText::_('COM_COMMUNITY_PROFILE_EDIT'); ?>
		</a>
		<?php endif; ?>
	</h2>
<?php
	$i=1;
	foreach( $profile['fields'] as $groupName => $items )
	{
?>
	<div class="cField">
		<?php if( $groupName != 'ungrouped' ): ?>
		<h3 class="cField-Title cResetH"><?php echo JText::_( $groupName ); ?></h3>
		<?php endif; ?>
		
		<ul class="cField-List cResetList">
			<?php foreach( $items as $item ): ?>
			<li>
				<h3 class="cField-Name cResetH"><?php echo JText::_( $item['name'] ); ?></h3>

				<?php if( !empty($item['searchLink']) && is_array($item['searchLink']) ): ?>
					<div class="cField-Content">
						<?php foreach($item['searchLink'] as $linkKey=>$linkValue): ?>
						<?php $item['value'] = $linkKey; ?>
							<a href="<?php echo $linkValue; ?>"><?php echo CProfileLibrary::getFieldData( $item ) ?></a><br />
						<?php endforeach; ?>

					</div>
				<?php else: ?>
					<div class="cField-Content">
						<?php if(!empty($item['searchLink'])) :?>
							<a href="<?php echo $item['searchLink']; ?>">
						<?php endif; ?>

						<?php echo CProfileLibrary::getFieldData( $item ); ?>

						<?php if(!empty($item['searchLink'])) :?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</li>
			<?php endforeach; ?>
		</ul>
	</div>

<?php
	$i++;
	}
?>
</div>
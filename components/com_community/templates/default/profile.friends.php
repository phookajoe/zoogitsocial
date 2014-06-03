<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	friends		array or CUser (all user)
 * @param	total		integer total number of friends
 * @param	user		CFactory User object 
 */
defined('_JEXEC') or die();
?>

<div class="cModule cProfile-Friends app-box">
	<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_PROFILE_FRIENDS'); ?></h3>
	<div class="app-box-content">
		<ul class="cResetList cThumbsList clearfix">
		<?php
		if( $friends )
		{
		?>
			<?php
			for($i = 0; ($i < 12) && ($i < count($friends)); $i++) {
				$friend =& $friends[$i];
			?>
			<li>
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$friend->id); ?>">
					<img alt="<?php echo $friend->getDisplayName();?>" title="<?php echo $friend->getTooltip(); ?>" src="<?php echo $friend->getThumbAvatar(); ?>" class="cAvatar jomNameTips" />
				</a>
			</li>
			<?php } ?>
		</ul>
		<?php
		}
		else
		{
		?>
			<div class="cEmpty"><?php echo JText::_('COM_COMMUNITY_NO_FRIENDS_YET');?></div>
		<?php
		}
		?>
	</div>
	<div class="app-box-footer">
		<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $user->id ); ?>">
			<span><?php echo JText::_('COM_COMMUNITY_FRIENDS_VIEW_ALL'); ?></span>
			<span>(<?php echo $total;?>)</span>
		</a>
	</div>
</div>

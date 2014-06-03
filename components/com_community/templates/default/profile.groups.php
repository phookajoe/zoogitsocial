<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @param	groups		Array	Array of groups object
 * @param	total		integer total number of groups
 * @param	user		CFactory User object
 */
defined('_JEXEC') or die();
?>
<div class="cModule cProfile-Groups app-box">
	<h3 class="app-box-header cResetH"><?php echo JText::_('COM_COMMUNITY_GROUPS'); ?></h3>
	<div class="app-box-content">
			<?php
			if (count($groups) > 0)
			{
			?>
			<ul class="cResetList cThumbsList clearfix">
			<?php
				for($i = 0; ($i < 12) && ($i < count($groups)); $i++)
				{
					$row	= $groups[$i];
			?>
			<li>
				<a href="<?php echo $row->getLink( true );?>">
					<img title="<?php echo $this->escape($row->name);?>" alt="<?php echo $this->escape($row->name);?>" src="<?php echo $row->getThumbAvatar(); ?>" class="cAvatar jomNameTips"/>
				</a>
			</li>
			<?php
				}
			?>
			</ul>
			<?php
			}
			else
			{
			?>
				<div class="cEmpty"><?php echo JText::_('COM_COMMUNITY_GROUPS_NO_JOINED_YET');?></div>
			<?php
			}
			?>
	</div>
	<div class="app-box-footer">
		<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=mygroups&userid=' . $user->id ); ?>">
			<?php echo JText::_('COM_COMMUNITY_GROUPS_VIEW_ALL'); ?>
			<span>(<?php echo $total;?>)</span>
		</a>
	</div>
</div>


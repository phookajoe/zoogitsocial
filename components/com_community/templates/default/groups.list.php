<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @params	groups		An array of group objects.
 */
defined('_JEXEC') or die();

$config	= CFactory::getConfig();
?>
<a id="lists" name="listing"></a>
<div class="cLayout">
	<?php
	if( $groups )
	{
	?>
	<ul class="cIndexList forGroups cResetList">
	<?php
		for( $i = 0; $i < count( $groups ); $i++ )
		{
			$group	=& $groups[$i]; 
	?>
		<li>
			<div class="cIndex-Box">
				<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=groups&task=viewgroup&groupid=' . $group->id );?>" class="cIndex-Avatar cFloat-L">
					<img src="<?php echo $group->getThumbAvatar();?>" alt="<?php echo $this->escape($group->name); ?>" class="cAvatar" />
					<?php
					if($group->approvals == COMMUNITY_PRIVATE_GROUP)
					{
						echo '<b class="cStatus-Private">'.JText::_('COM_COMMUNITY_GROUPS_PRIVATE').'</b>';
					}
					?>
				</a>

				<div class="cIndex-Content">
					<h3 class="cIndex-Name cResetH">
						<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=groups&task=viewgroup&groupid=' . $group->id );?>">
							<?php echo $this->escape($group->name); ?>
						</a>
					</h3>
					<div class="cIndex-Meta small"><?php echo JText::sprintf('COM_COMMUNITY_GROUPS_CREATE_TIME_ON' , JHTML::_('date', $group->created, JText::_('DATE_FORMAT_LC')) );?></div>
					<div class="cIndex-Status"><?php echo ($config->get('allowhtml')) ? $group->description : $this->escape($group->description); ?></div>
					
					<div class="cIndex-Actions clearfix">
						<div>
							<i class="com-icon-groups"></i>
							<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=groups&task=viewmembers&groupid=' . $group->id ); ?>"><?php echo JText::sprintf((CStringHelper::isPlural($group->membercount)) ? 'COM_COMMUNITY_GROUPS_MEMBER_COUNT_MANY':'COM_COMMUNITY_GROUPS_MEMBER_COUNT', $group->membercount);?></a>
						</div>
						<?php if($config->get('creatediscussion') ){?>
						<div>
							<i class="com-icon-comment"></i>
							<?php echo JText::sprintf((CStringHelper::isPlural($group->discusscount)) ? 'COM_COMMUNITY_GROUPS_DISCUSSION_COUNT_MANY' :'COM_COMMUNITY_GROUPS_DISCUSSION_COUNT', $group->discusscount);?>
						</div>
						<?php }?>
						<div>
							<i class="com-icon-wall"></i>
							<?php echo JText::sprintf((CStringHelper::isPlural($group->wallcount)) ? 'COM_COMMUNITY_GROUPS_WALL_COUNT_MANY' : 'COM_COMMUNITY_GROUPS_WALL_COUNT', $group->wallcount);?>
						</div>
						<?php
						if( $isCommunityAdmin && $showFeatured )
						{
							if( !in_array($group->id, $featuredList) )
							{
						?>
						<div class="cIndex-Feature">
							<a onclick="joms.featured.add('<?php echo $group->id;?>','groups');" 
							   href="javascript:void(0);" 
							   class="cButton Icon"
							   title="<?php echo JText::_('COM_COMMUNITY_MAKE_FEATURED'); ?>">
							
								<i class="com-icon-award-plus"></i>
							</a>
						</div>
						<?php			
							}
						}
						?>
						
					</div>
				</div>
			</div>
		</li>
	<?php
		}
	?>
	</ul>
		<?php 
		if ( !empty($pagination) ) 
		{
		?>
		<div class="cPagination">
			<?php echo $pagination->getPagesLinks(); ?>
		</div>
		<?php 
		} 
		?>
	<?php
	}
	else
	{
	?>
	<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_GROUPS_NOITEM'); ?></div>
	<?php
	}
	?>

	
</div>
<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @params	isMine		boolean is this group belong to me
 * @params	members		An array of member objects
 */
defined('_JEXEC') or die();
?>
<div class="cLayout cGroups-ViewMembers">
<?php
if( $type == '1' && !( $isMine || $isAdmin || $isSuperAdmin ) )
{
?>
	<div>
		<?php echo JText::_('COM_COMMUNITY_PERMISSION_DENIED_WARNING'); ?>
	</div>
<?php
}
else
{
?>
	<?php if( $members ): ?>
		<div id="notice"></div>
		<ul class="cIndexList forGroupMembers cResetList">
	<?php
		foreach( $members as $member )
		{
			//$member->isAdmin
			if( $member->isBanned && !( $isMine || $isAdmin || $isSuperAdmin ) )
			{
				continue;
			}

	?>

		<li id="member_<?php echo $member->id;?>">
			<div class="cIndex-Box clearfix">
				<a class="cIndex-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid=' . $member->id); ?>">
					<img class="cAvatar" src="<?php echo $member->getThumbAvatar(); ?>" alt="<?php echo $member->getDisplayName(); ?>" />
					<?php if($member->isOnline()) { ?>
					<b class="cStatus-Online"><?php echo JText::_('COM_COMMUNITY_ONLINE'); ?></b>
					<?php } ?>
				</a>
				<div class="cIndex-Content">

					<?php if( $isAdmin || $isSuperAdmin ) : ?>
					<div class="cIndex-Control cButton-Dropdown cFloat-R">

						<a  href="javascript:void(0);" class="cButton"><i class="com-glyph-setting"></i></a>
						<ul class="cDropDown-Link Right cResetList">

							<li class="setAdmin <?php if( $member->isAdmin ){echo 'cHidden'; }?>">
								<a href="javascript:void(0);" onclick="jax.call('community','groups,ajaxAddAdmin','<?php echo $member->id;?>','<?php echo $groupid;?>');">
									<?php echo JText::_('COM_COMMUNITY_GROUPS_ADMIN'); ?>
								</a>
							</li>

							<li class="setAdmin<?php if( ( $isAdmin || $isSuperAdmin ) && !$member->isAdmin ) { echo ' cHidden'; } ?>">
								<a href="javascript:void(0);" onclick="jax.call('community','groups,ajaxRemoveAdmin','<?php echo $member->id;?>','<?php echo $groupid;?>');">
									<?php echo JText::_('COM_COMMUNITY_GROUPS_REVERT_ADMIN'); ?>
								</a>
							</li>

							<?php
								if( $member->id != $group->ownerid && !$group->isAdmin( $member->id ) && $my->id != $member->id && !COwnerHelper::isCommunityAdmin($member->id) )
								{
									if( !$member->isBanned && ( $isAdmin || $isSuperAdmin ) )
									{
							?>
							<li>
								<a href="javascript:void(0);" onclick="jax.call('community','groups,ajaxBanMember', '<?php echo $member->id;?>' , '<?php echo $groupid;?>');">
									<?php echo JText::_('COM_COMMUNITY_GROUPS_BAN_MEMBER'); ?>
								</a>
							</li>
							<?php
									}
									else if( $member->isBanned == COMMUNITY_GROUP_BANNED && ( $isAdmin || $isSuperAdmin ) )
									{
							?>
							<li>
								<a href="javascript:void(0);" onclick="jax.call('community','groups,ajaxUnbanMember', '<?php echo $member->id;?>' , '<?php echo $groupid;?>');">
									<?php echo JText::_('COM_COMMUNITY_GROUPS_MEMBER_UNBAN'); ?>
								</a>
							</li>
							<?php
									}
								}
							?>
							<?php
								if( ($isMine || $isAdmin || $isSuperAdmin) && $my->id != $member->id )
								{
							?>
							<li class="hasSeperator">
								<a href="javascript:void(0)" onclick="joms.groups.confirmMemberRemoval(<?php echo $member->id; ?>, <?php echo $groupid;?>);" >
									<?php echo JText::_('COM_COMMUNITY_GROUPS_REMOVE_MEMBER_MESSAGE');?>
								</a>
							</li>
							<?php
								}
							?>
						</ul>
					</div>
					<?php endif; ?>

					<h3 class="cIndex-Name cResetH">
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid=' . $member->id); ?>"><?php echo $member->getDisplayName(); ?></a>
					</h3>

					<?php if ( $member->getStatus() ) { ?>
					<div class="cIndex-Status"><?php echo $member->getStatus() ;?></div>
					<?php } ?>

					<!-- .cIndex-Action -->
					<div class="cIndex-Actions">

						<?php if( $my->id != $member->id && $config->get('enablepm') ): ?>
						<div>
							<i class="com-icon-mail-go"></i>
							<a onclick="joms.messaging.loadComposeWindow(<?php echo $member->id; ?>)" href="javascript:void(0);">
								<?php echo JText::_('COM_COMMUNITY_INBOX_SEND_MESSAGE'); ?>
							</a>
						</div>
						<?php endif; ?>

						<div>
							<i class="com-icon-groups"></i>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $member->id );?>">
								<?php echo JText::sprintf( (CStringHelper::isPlural($member->friendsCount)) ? 'COM_COMMUNITY_FRIENDS_COUNT_MANY' : 'COM_COMMUNITY_FRIENDS_COUNT' , $member->friendsCount);?>
							</a>
						</div>

						<?php if( !$member->approved && ($isMine || $isAdmin || $isSuperAdmin ) ): ?>
						<div class="cFloat-R" id="groups-approve-<?php echo $member->id;?>">
							<i class="com-icon-tick"></i>
							<a href="javascript:void(0);" onclick="jax.call('community','groups,ajaxApproveMember', '<?php echo $member->id;?>' , '<?php echo $groupid;?>');">
								<?php echo JText::_('COM_COMMUNITY_PENDING_ACTION_APPROVE'); ?>
							</a>
						</div>
						<?php endif; ?>

					</div>
					<!-- .cIndex-Action -->
				</div>

			</div>
		</li>

	<?php
		}
	?>
	</ul>
	<?php endif; ?>
<?php
}
?>

<?php
if ( $pagination->getPagesLinks() )
{
?>
<div class="cPagination">
	<?php echo $pagination->getPagesLinks(); ?>
</div>
<?php
}
?>
</div>
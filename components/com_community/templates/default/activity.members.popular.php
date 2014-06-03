<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */
defined('_JEXEC') or die();
?>
<div class="cStream-Content">
	<div class="cStream-Headline">
		<b><?php echo JText::_('COM_COMMUNITY_ACTIVITIES_TOP_MEMBERS'); ?></b>
	</div>

	<div class="cStream-Attachment">
		<div class="cSnippets Block">
		<?php
			foreach( $members as $user )
			{
				$numFriends = $user->getFriendCount();
			?>
			<div class="cSnip clearfix">
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid=' . $user->id );?>" class="cSnip-Avatar cFloat-L">
					<img alt="<?php echo $this->escape($user->getDisplayName());?>" src="<?php echo $user->getThumbAvatar();?>" class="cAvatar cAvatar-Large" title="" />
				</a>
				<div class="cSnip-Detail">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid=' . $user->id );?>" class="cSnip-Title">
						<?php echo CTooltip::cAvatarTooltip($user);; ?>
					</a>
					<div class="cSnip-Info small">
						<span>
							<a href="#"><?php echo JText::sprintf( (CStringHelper::isPlural($numFriends)) ? 'COM_COMMUNITY_FRIENDS_COUNT_MANY' : 'COM_COMMUNITY_FRIENDS_COUNT', $numFriends); ?></a>
						</span>
						<?php
						if( !$my->isFriendWith($user->id)) { ?>
						<span>
							<a href="javascript:void(0)" onclick="joms.friends.connect('<?php echo $user->id;?>')"><?php echo JText::_('COM_COMMUNITY_PROFILE_ADD_AS_FRIEND'); ?></a>
						</span>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php
			}
		?>
		</div>
	</div>
	<?php $this->load('activities.actions'); ?>
</div>

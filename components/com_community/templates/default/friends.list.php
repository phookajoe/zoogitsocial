<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @param	author		string
 * @param	categories	An array of category objects.
 * @params	groups		An array of group objects.
 * @params	pagination	A JPagination object.
 * @params	isJoined	boolean	determines if the current browser is a member of the group
 * @params	isMine		boolean is this wall entry belong to me ?
 * @params	config		A CConfig object which holds the configurations for JomSocial
 */
defined('_JEXEC') or die();
?>
<?php echo $sortings; ?>

<div class="cLayout cFriends-List">
	<?php 
		if( !empty( $friends ) ) 
		{ 
	?>
	<ul class="cIndexList forFriendsList cResetList">
	<?php 
		foreach( $friends as $user ) : 
	?>
	<li id="friend-<?php echo $user->id; ?>">
		<div class="cIndex-Box clearfix">
			<a href="<?php echo $user->profileLink; ?>" class="cIndex-Avatar cFloat-L">
				<img src="<?php echo $user->getThumbAvatar(); ?>" alt="<?php echo $user->getDisplayName(); ?>" class="cAvatar" />
				<?php if($user->isOnline()) { ?>
				<b class="cStatus-Online"><?php echo JText::_('COM_COMMUNITY_ONLINE'); ?></b>
				<?php } ?>
			</a>

			<div class="cIndex-Content">
				<h3 class="cIndex-Name cResetH">
					<a href="<?php echo $user->profileLink; ?>">
						<?php echo $user->getDisplayName(); ?>
					</a>
				</h3>
				<?php if ( $user->getStatus() ) { ?>
				<div class="cIndex-Status">
					<?php echo $user->getStatus(); ?>
				</div>
				<?php } ?>

				<div class="cIndex-Actions">
					<?php if ($my->authorise('community.view', 'friends.pm.' . $user->id)):?>
					<div>
						<i class="com-icon-mail-go"></i>
						<a onclick="joms.messaging.loadComposeWindow(<?php echo $user->id; ?>)" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_INBOX_SEND_MESSAGE'); ?></a>
					</div>
					<?php endif; ?>
					<div>
						<i class="com-icon-groups"></i>
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $user->id );?>"><?php echo JText::sprintf( (CStringHelper::isPlural($user->friendsCount)) ? 'COM_COMMUNITY_FRIENDS_COUNT_MANY' : 'COM_COMMUNITY_FRIENDS_COUNT' , $user->friendsCount);?></a>
					</div>
					<?php if( $isMine ): ?>
					<div class="cFloat-R">
						<i class="com-icon-groups-delete"></i>
						<a href="javascript:void(0);" onclick="joms.friends.confirmFriendRemoval(<?php echo $user->id; ?>);">
							<?php echo JText::_('COM_COMMUNITY_REMOVE_FRIEND'); ?>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
	</ul>
	<?php 
		} else {
	?>
	<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_NO_FRIENDS_YET'); ?></div>
	<?php
		}
	?>	
</div>
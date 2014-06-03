<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */
defined('_JEXEC') or die();
$viewName = JRequest::getCmd( 'view');
$taskName = JRequest::getCmd( 'task');
// call the auto refresh on specific page
?>

<?php if($showToolbar) : ?>
<ul class="cToolBar cResetList clearfix">
	<li class="cMenu-Icon">
		<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=frontpage' );?>"<?php echo $active == 0 ? ' class="active"' :'';?>>
			<i class="com-toolbar-home"></i>
		</a>
	</li>
	<?php
		foreach( $menus as $menu )
		{
			$class	= !empty( $menu->childs ) ? ' cHas-Childs' : '';
	?>
	<li class="cMenu-Text<?php echo $class;?>">
		<a href="<?php echo CRoute::_( $menu->item->link );?>"<?php echo $active === $menu->item->id ? ' class="active"' : '';?>><?php echo JText::_( $menu->item->name );?></a>
		<?php
		if( !empty($menu->childs) )
		{
		?>
			<ul class="cChilds cResetList">
			<?php
			foreach( $menu->childs as $child )
			{
			?>
				<li>
					<?php if( $child->script ){ ?>
						<a href="javascript:void(0);" onclick="<?php echo $child->link;?>">
					<?php } else { ?>
						<a href="<?php echo CRoute::_( $child->link );?>">
					<?php } ?>
					<?php echo JText::_( $child->name );?></a>
				</li>
			<?php
			}
			?>
			</ul>
		<?php
		}
		?>
	</li>
	<?php
		}
	?>
	<li class="cMenu-Icon">
		<a href="javascript:joms.notifications.showWindow();" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_GLOBAL' );?>">
			<i class="com-toolbar-notification"></i>
			<?php if( $newEventInviteCount ) { ?>
			<b><?php echo $newEventInviteCount; ?></b>
			<?php } ?>
		</a>
	</li>
	<li class="cMenu-Icon">
		<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=friends&task=pending' );?>" onclick="joms.notifications.showRequest();return false;" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INVITE_FRIENDS' );?>">
			<i class="com-toolbar-friends"></i>
			<?php if( $newFriendInviteCount ){ ?><b><?php echo $newFriendInviteCount; ?></b><?php } ?>
		</a>
	</li>
	<li class="cMenu-Icon">
		<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=inbox' );?>"  onclick="joms.notifications.showInbox();return false;" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INBOX' );?>">
			<i class="com-toolbar-inbox"></i>
			<?php if( $newMessageCount ){ ?><b><?php echo $newMessageCount; ?></b><?php } ?>
		</a>
	</li>
	<li class="cMenu-Icon cFloat-R">
	<form class="cForm" action="<?php echo JRoute::_('index.php');?>" method="post" name="communitylogout" id="communitylogout">
		<a href="javascript:void(0);" title="<?php echo JText::_('COM_COMMUNITY_LOGOUT'); ?>" onclick="document.communitylogout.submit();">
			<i class="com-toolbar-signout"></i>
		</a>
		<input type="hidden" name="option" value="<?php echo COM_USER_NAME ; ?>" />
		<input type="hidden" name="task" value="<?php echo COM_USER_TAKS_LOGOUT ; ?>" />
		<input type="hidden" name="return" value="<?php echo $logoutLink; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
	</li>
</ul>
<?php endif; ?>

<?php if ( $miniheader ) : ?>
	<?php echo @$miniheader; ?>
<?php endif; ?>

<?php if ( !empty( $groupMiniHeader ) ) : ?>
	<?php echo $groupMiniHeader; ?>
<?php endif; ?>

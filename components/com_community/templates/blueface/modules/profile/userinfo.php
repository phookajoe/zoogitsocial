<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 **/
defined('_JEXEC') or die();

if( $isMine ): ?>

<script type="text/javascript" language="javascript">

joms.jQuery(document).ready(function(){

	var profileStatus = joms.jQuery('#profile-new-status');
	var statusText    = joms.jQuery('#statustext');
	var saveStatus    = joms.jQuery('#save-status');

	statusText.data('COM_COMMUNITY_PROFILE_STATUS_INSTRUCTION', '<?php echo addslashes(JText::_('COM_COMMUNITY_PROFILE_STATUS_INSTRUCTION')); ?>')
			  .val(statusText.data('COM_COMMUNITY_PROFILE_STATUS_INSTRUCTION'));

	joms.utils.textAreaWidth(statusText);
	joms.utils.autogrow(statusText);

	statusText.focus(function()
	{
		profileStatus.removeClass('inactive');
		statusText.val('');
	}).blur(function()
	{
		if (statusText.val()=='')
		{
			setTimeout(function()
			{
				statusText.val(statusText.data('COM_COMMUNITY_PROFILE_STATUS_INSTRUCTION'));
				profileStatus.addClass('inactive');
			}, 200);
		}
	});

	saveStatus.click(function()
	{
		var newStatusText = statusText.val();
		jax.call('community', 'status,ajaxUpdate', statusText.val());

		/* Update page */
// 		joms.jQuery('#profile-status-message').html(newStatusText);
// 		joms.jQuery('title').val(newStatusText); // Note: This omits out the member name.

		statusText.val('').trigger('blur');
	});
	joms.profile.setStatusLimit( statusText );
});
</script>
<?php endif; ?>

<div class="cProfile-Header">
	<h2 class="cProfile-Name cResetH">
		<?php if( $isMine ): ?>
			<?php echo JText::sprintf('COM_COMMUNITY_PROFILE_WELCOME_BACK', $user->getDisplayName()); ?>
		<?php else : ?>
			<?php echo $user->getDisplayName(); ?>
		<?php endif; ?>
	</h2>


	<?php if ( $user->getStatus() ) : ?>
	<div class="cProfile-Status">
		<p><?php echo $user->getStatus(); ?></p>
		<span class="small"><?php echo $profile->posted_on; ?></span>
	</div>
	<?php endif; ?>
	

	<?php if( !$isMine ): ?>
	<div class="cPageTools clearfull">
	<ul class="cPageToolbox cResetList cFloatedList clearfix">
		<?php if(!$isFriend && !$isMine && !$isBlocked): ?>
		<li>
			<a href="javascript:void(0)" onclick="joms.friends.connect('<?php echo $profile->id;?>')">
				<i class="com-icon-user-plus"></i>
				<span><?php echo JText::_('COM_COMMUNITY_PROFILE_ADD_AS_FRIEND'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if($config->get('enablephotos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=myphotos&userid='.$profile->id); ?>">
				<i class="com-icon-photos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_PHOTOS'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if($showBlogLink): ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_myblog&blogger=' . $user->getDisplayName() . '&Itemid=' . $blogItemId ); ?>">
				<i class="com-icon-blog"></i>
				<span><?php echo JText::_('COM_COMMUNITY_BLOG'); ?></span>
			</a>
		</li>
		<?php endif; ?>
						
		<?php if($config->get('enablevideos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos&task=myvideos&userid='.$profile->id); ?>">
				<i class="com-icon-videos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_VIDEOS_GALLERY'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if( !$isMine && $config->get('enablepm')): ?>
		<li>
			<a onclick="<?php echo $sendMsg; ?>" href="javascript:void(0);">
				<i class="com-icon-mail-go"></i>
				<span><?php echo JText::_('COM_COMMUNITY_INBOX_SEND_MESSAGE'); ?></span>
			</a>
		</li>
		<?php endif; ?>
	</ul>
	</div>
	<?php endif; ?>

</div>
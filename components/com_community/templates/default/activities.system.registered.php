<?php
$usersModel   = CFactory::getModel( 'user' );
$now          = new JDate();
$date         = CTimeHelper::getDate();

$users 			 = $usersModel->getUserRegisteredByMonth($now->format('Y-m'));
$totalRegistered = count($users); //$usersModel->getTotalRegisteredByMonth($now->format('Y-m'));

$title        = JText::sprintf('COM_COMMUNITY_TOTAL_USERS_REGISTERED_THIS_MONTH_ACTIVITY_TITLE',
					$totalRegistered ,
					$date->monthToString($now->format('%m')));
?>
<div class="cStream-Content">
	<div class="cStream-Headline">
		<b><?php echo JText::_('COM_COMMUNITY_TOTAL_USERS_REGISTERED_THIS_MONTH'); ?></b>
		<div class="cStream-Status">
			<?php echo $title; ?>
		</div>
	</div>
	<?php if($totalRegistered > 0) { ?>
	<div class="cStream-Attachment">

		<div class="cSnippets Block">
		<?php foreach($users  as $user ) { ?>
		<?php
			$registerDate = $user->registerDate;
		?>
			<div class="cSnip clearfix">
				<a class="cSnip-Avatar cFloat-L" href="#">
					<img class="cAvatar" src="<?php echo $user->getThumbAvatar(); ?>" >
				</a>
				<div class="cSnip-Detail">
					<a class="cSnip-Title" href="<?php echo CUrlHelper::userLink($user->id); ?>">
						<?php echo $user->getDisplayName(); ?>
					</a>
					<div class="cSnip-Info small">
						<span>
							<?php echo JText::_('COM_COMMUNITY_MEMBER_SINCE'); ?>: <?php echo JHTML::_('date', $registerDate , JText::_('DATE_FORMAT_LC1')); ?>
						</span>
						<span>
							<a href="javascript:void(0)" onclick="joms.friends.connect('<?php echo $user->id;?>')"><span><?php echo JText::_('COM_COMMUNITY_PROFILE_ADD_AS_FRIEND'); ?></span></a>
						</span>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
	<?php } ?>
	<?php $this->load('activities.actions'); ?>
</div>
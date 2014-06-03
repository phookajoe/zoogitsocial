<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */
defined('_JEXEC') or die(); ?>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/ajaxfileupload.pack.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/imgareaselect/scripts/jquery.imgareaselect.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::root();?>components/com_community/assets/imgareaselect/css/imgareaselect-avatar.css" />
<script type="text/javascript">joms.filters.bind();</script>

<?php $this->renderModules( 'js_profile_top' ); ?>

<?php echo $adminControlHTML; ?>

<div class="cPageActions clearfix">
	<div class="cPageAction cFloat-R">
		<?php echo $blockUserHTML;?>
		<?php echo $reportsHTML;?>
		<?php echo $bookmarksHTML;?>
	</div>
</div>

<div class="cSidebar">

	<!-- User avatar -->
	<div class="cModule cProfile-Avatar">
		 <div class="cPageAvatar">
		 	<div>
				<img src="<?php echo $user->getAvatar(); ?>" alt="<?php echo $this->escape( $user->getDisplayName() ); ?>" />
				<?php if( $isMine ): ?>
				<b class="cAvatarOption"><a href="javascript:void(0)" onclick="joms.photos.uploadAvatar('profile','<?php echo $user->id?>')"><?php echo JText::_('COM_COMMUNITY_CHANGE_AVATAR')?></a></b>
				<?php endif; ?>
			</div>
		</div>

		<!-- Profile video link -->
		<?php if( $config->get('enablevideos') ){ ?>
		<?php 		if( $config->get('enableprofilevideo') && ($videoid != 0) ){ ?>
			<div class="cProfile-LinkVideo">
				<a onclick="joms.videos.playProfileVideo( <?php echo $videoid; ?> , <?php echo $user->id; ?> )" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_VIDEOS_MY_PROFILE');?></a>
			</div>
		<?php 		} ?>
		<?php } ?>
		<!-- end profile video link-->

		<!-- like box -->
		<div class="cProfile-Like"><span id="like-container"><?php echo $likesHTML; ?></span></div>
		<!-- end like box -->
	</div>
	<!-- end Avatar -->

	<?php $this->renderModules( 'js_side_top' ); ?>
	<?php $this->renderModules( 'js_profile_side_top' ); ?>
	<?php echo $sidebarTop; ?>


	<?php echo $this->view('profile')->modGetFriendsHTML(); ?>
	<?php if( $config->get('enablegroups')){ ?>
	<?php echo $this->view('profile')->modGetGroupsHTML(); ?>
	<?php } ?>


	<?php echo $sidebarBottom; ?>
	<?php $this->renderModules( 'js_profile_side_bottom' ); ?>
	<?php $this->renderModules( 'js_side_bottom' ); ?>
</div>




<div class="cMain">

	<?php echo $this->view('profile')->modProfileUserinfo(); ?>

	<div class="cProfile-Statistic">
		<?php if($config->get('enablekarma')){ ?>
		<div class="cStats-Karma">
			<b>
				<span><?php echo $user->_points; ?></span>
				<span><?php echo JText::sprintf( (CStringHelper::isPlural($user->_points)) ? 'COM_COMMUNITY_POINTS' : 'COM_COMMUNITY_SINGULAR_POINT' ); ?></span>
			</b>
		</div>
		<?php } ?>

		<?php if($config->get('enablegroups')){ ?>
		<div class="cStats-Groups">
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=mygroups&userid='.$user->id); ?>">
				<span><?php echo $totalgroups; ?></span>
				<span><?php echo JText::sprintf( (CStringHelper::isPlural($totalgroups)) ? 'COM_COMMUNITY_GROUPS_PLURAL_GROUP' : 'COM_COMMUNITY_SINGULAR_GROUP' ); ?></span>
			</a>
		</div>
		<?php } ?>

		<div class="cStats-Friends">
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid='.$user->id); ?>">
				<span><?php echo $totalfriends; ?></span>
				<span><?php echo JText::sprintf( (CStringHelper::isPlural($totalfriends)) ? 'COM_COMMUNITY_FRIENDS' : 'COM_COMMUNITY_SINGULAR_FRIEND' ); ?></span>
			</a>
		</div>

		<?php if( $config->get('enablephotos') ) { ?>
		<div class="cStats-Photos">
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=myphotos&userid='.$user->id); ?>">
				<span><?php echo $totalphotos; ?></span>
				<span><?php echo JText::sprintf( (CStringHelper::isPlural($totalphotos)) ? 'COM_COMMUNITY_PHOTOS' : 'COM_COMMUNITY_SINGULAR_PHOTO' ); ?></span>
			</a>
		</div>
		<?php } ?>

		<div class="cStats-Activity">
			<b>
				<span><?php echo (!$totalactivities == 0) ? $totalactivities : 0; ?></span>
				<span><?php echo JText::sprintf( (CStringHelper::isPlural($totalactivities)) ? 'COM_COMMUNITY_ACTIVITIES' : 'COM_COMMUNITY_ACTIVITY' ); ?></span>
			</b>
		</div>
	</div>

	<?php echo $about; ?>
	<?php $this->renderModules( 'js_profile_feed_top' ); ?>

	<div class="activity-stream-front">
			<div class="joms-latest-activities-container">
				<a id="activity-update-click" href="javascript:void(0);">1 new update </a>
			</div>
			<?php
				$this->view('profile')->modProfileUserstatus();
			?>
			<div class="activity-stream-profile">
				<div id="activity-stream-container">
				<?php echo $newsfeed; ?>
				</div>
			</div>

			<?php $this->renderModules( 'js_profile_feed_bottom' ); ?>
			<div id="apps-sortable" class="connectedSortable" >
			<?php
				$this->view('profile')->modProfileActivities();
			?>
			<?php echo $content; ?>
			</div>
	</div>
</div>

<?php $this->renderModules( 'js_profile_bottom' ); ?>

<?php /* Insert plugin javascript at the bottom */ echo $jscript; ?>
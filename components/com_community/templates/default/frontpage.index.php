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
<script type="text/javascript">joms.filters.bind();</script>
<!-- begin: #cFrontpageWrapper -->

	<?php
	/**
	 * if user logged in
	 * 		load frontpage.members.php
	 * else
	 * 		load frontpage.guest.php
	 */
	echo $header;
	?>


	<!-- begin: .cLayout -->
	<div class="cLayout">
		<!-- begin: .cSidebar -->
		<div class="cSidebar">
			<?php $this->renderModules( 'js_side_top' ); ?>

			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Searchbox section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if( $this->params->get('showsearch') == '1' || ($this->params->get('showsearch') == '2' && $my->id != 0 ) ) { ?>
			<?php if($this->params->get('showsearch')) { ?>
				<div class="cModule cFrontPage-Search app-box">
					<h3 class="app-box-header">
						<?php echo JText::_('COM_COMMUNITY_SEARCH'); ?>
					</h3>
					<div class="app-box-content">
						<form name="search" id="cFormSearch" method="get" action="<?php echo CRoute::_('index.php?option=com_community&view=search');?>">
							<div class="cSearch-Box input-wrap">
								<input type="text" class="input text" id="keyword" name="q" style="width: 100%" />
								<a class="cButton-Search" href="javascript:void(0);" onclick="joms.jQuery('#cFormSearch').submit();">
									<i class="com-glyph-search"></i>
									<!-- <span><?php echo JText::_('COM_COMMUNITY_SEARCH_BUTTON_TEMP'); ?></span> -->
								</a>
								<input type="hidden" name="option" value="com_community" />
								<input type="hidden" name="view" value="search" />
							</div>
						</form>
					</div>
					<div class="app-box-footer">
						<?php echo JText::sprintf('COM_COMMUNITY_TRY_ADVANCED_SEARCH', CRoute::_('index.php?option=com_community&view=search&task=advancesearch') ); ?>
					</div>
				</div>
			<?php } ?>
			<?php } ?>



			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Latest members section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if($this->params->get('showlatestmembers') ){ ?>
			<?php if ( ($this->params->get( 'showlatestmembers' ) == '1' || ( $this->params->get('showlatestmembers') == '2' && $my->id != 0 )) && !empty($latestMembers) ) { ?>
				<div class="cModule cFrontPage-LatestMembers app-box">
					<?php echo $latestMembers; ?>
				</div>
			<?php } ?>
			<?php } ?>




			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Latest groups section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if($this->params->get('showlatestgroups')) { ?>
			<?php if($config->get('enablegroups') ) { ?>
			<?php if( !empty($latestGroups) && ( $this->params->get('showlatestgroups') == '1' || ($this->params->get('showlatestgroups') == '2' && $my->id != 0 ) ) ) { ?>
			<div class="cModule cFrontPage-LatestGroups app-box">
				<?php echo $latestGroups; ?>
			</div>
			<?php } ?>
			<?php } ?>
			<?php } ?>



			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Latest events section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if($this->params->get('frontpage_latest_events')) { ?>
			<?php if($config->get('enableevents') ) { ?>
			<?php if( !empty($latestEvents) && ( $this->params->get('frontpage_latest_events') == '1' || ($this->params->get('frontpage_latest_events') == '2' && $my->id != 0 ) ) ) { ?>
			<div class="cModule cFrontPage-LatestEvents app-box">
				<?php echo $latestEvents; ?>
			</div>
			<?php } ?>
			<?php } ?>
			<?php } ?>

			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Latest photos section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if($this->params->get('showlatestphotos')) { ?>
			<?php if($config->get('enablephotos')){ ?>
			<?php if( $this->params->get('showlatestphotos') == '1' || ($this->params->get('showlatestphotos') == '2' && $my->id != 0 ) ) { ?>
			<div class="cModule cFrontPage-LatestPhotos app-box">
				<?php echo $latestPhotosHTML; ?>
			</div>
			<?php } ?>
			<?php } ?>
			<?php } ?>


			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Latest videos section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if($config->get('enablevideos')) { ?>
			<?php if($this->params->get('showlatestvideos') ){ ?>
			<?php if( $this->params->get('showlatestvideos') == '1' || ($this->params->get('showlatestvideos') == '2' && $my->id != 0 ) ) { ?>
			<div class="cModule cFrontPage-LatestVideos app-box">
				<h3 class="app-box-header">
					<?php echo JText::_('COM_COMMUNITY_VIDEOS'); ?>
				</h3>
				<div id="latest-videos-nav" class="app-box-filter">
					<i class="loading cFloat-R"></i>
					<div>
						<a class="newest-videos active-state" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_VIDEOS_NEWEST') ?></a>
						<b>&middot;</b>
						<a class="featured-videos" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_FEATURED') ?></a>
						<b>&middot;</b>
						<a class="popular-videos" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_VIDEOS_POPULAR') ?></a>
					</div>
				</div>
				<div id="latest-videos-container" class="app-box-content">
					<?php echo $latestVideosHTML;?>
				</div>

				<div class="app-box-footer">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos'); ?>"><?php echo JText::_('COM_COMMUNITY_VIDEOS_ALL'); ?></a>
				</div>
			</div>
			<?php } ?>
			<?php } ?>
			<?php } ?>


			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Whos online section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if($this->params->get('showonline') && count( $onlineMembers )>0) { ?>
			<?php if( $this->params->get('showonline') == '1' || ($this->params->get('showonline') == '2' && $my->id != 0 ) ) { ?>
			<div class="cModule cFrontPage-ShowOnline app-box">
				<h3 class="app-box-header">
					<?php echo JText::_('COM_COMMUNITY_FRONTPAGE_WHOSE_ONLINE'); ?>
				</h3>
				<div class="app-box-content">
					<ul class="cResetList cThumbsList clearfix">
						<?php for ( $i = 0; $i < count( $onlineMembers ); $i++ ) { ?>
							<?php $row =& $onlineMembers[$i]; ?>
							<li>
								<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$row->id ); ?>">
									<img class="cAvatar jomNameTips" src="<?php echo $row->user->getThumbAvatar(); ?>" title="<?php echo CTooltip::cAvatarTooltip($row->user); ?>" alt="<?php echo $this->escape( $row->user->getDisplayName() );?>" />
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
			<?php } ?>

			<?php $this->renderModules( 'js_side_bottom' ); ?>

		</div>
		<!-- end: .cSidebar -->


			<!-- begin: .cMain -->
			<div class="cMain">
			<?php
			/**
			 * ----------------------------------------------------------------------------------------------------------
			 * Activity stream section here
			 * ----------------------------------------------------------------------------------------------------------
			 */
			?>
			<?php if( $config->get('showactivitystream') == '1' || ($config->get('showactivitystream') == '2' && $my->id != 0 ) ) { ?>
			<!-- Recent Activities -->
			<h2 class="cResetH"><?php echo JText::_('COM_COMMUNITY_FRONTPAGE_RECENT_ACTIVITIES'); ?></h2>

			<?php $userstatus->render(); ?>

			<?php if ( $alreadyLogin == 1 ) : ?>
				<div id="activity-stream-nav" class="cFilter clearfull">
					<ul class="filters cFloat-R cResetList cFloatedList">
						<li class="filter <?php echo $config->get('frontpageactivitydefault') == 'all' ? ' active': '';?>">
							<a class="all-activity" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_VIEW_ALL') ?></a>
						</li>
						<li class="filter <?php echo $config->get('frontpageactivitydefault') == 'friends' ? ' active': '';?>">
							<a class="me-and-friends-activity" href="javascript:void(0);"><?php echo JText::_('COM_COMMUNITY_ME_AND_FRIENDS') ?></a>
						</li>
					</ul>
				</div>
			<?php endif; ?>

			<div class="cActivity cFrontpage-Activity" id="activity-stream-container">
				<div class="cActivity-LoadLatest cActivity-Button joms-latest-activities-container">
					<a id="activity-update-click" href="javascript:void(0);"></a>
				</div>

				<?php echo $userActivities; ?>
			</div>
		<?php } ?>

		</div>
		<!-- end: .cMain -->

	</div>
	<!-- end: .cLayout -->
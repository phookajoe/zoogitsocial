<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @param	author		string
 * @param	categories	An array of category objects.
 * @param	category	An integer value of the selected category id if 0, not selected.
 * @params	groups		An array of group objects.
 * @params	pagination	A JPagination object.
 * @params	isJoined	boolean	determines if the current browser is a member of the group
 * @params	isMine		boolean is this wall entry belong to me ?
 * @params	config		A CConfig object which holds the configurations for JomSocial
 * @params	sorttype	A string of the sort type.
 */
defined('_JEXEC') or die();
?>

<div class="cLayout cIndex cGroups-Index">

	<!-- FEATURED GROUP -->
	<?php if( $featuredHTML ){ ?>
	<?php echo $featuredHTML; ?><!--call groups.featured.php -->
	<?php } ?>

	<div class="cLayout">

		<div class="cSidebar">
			<div class="cGroup-Categories app-box">
			<?php if ( $index ) : ?>
				<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_CATEGORIES');?></h3>
				<div class="app-box-content">
					<ul class="app-box-list for-menu cResetList">
						<li>
							<i class="com-icon-folder"></i>
						<?php if( $category->parent == COMMUNITY_NO_PARENT && $category->id == COMMUNITY_NO_PARENT ){ ?>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups');?>"><?php echo JText::_( 'COM_COMMUNITY_GROUPS_ALL_GROUPS' ); ?></a>
						<?php }else{ ?>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=display&categoryid=' . $category->parent ); ?>"><?php echo JText::_('COM_COMMUNITY_BACK_TO_PARENT'); ?></a>
						<?php }  ?>
						</li>
						<?php if( $categories ): ?>
							<?php foreach( $categories as $row ): ?>
								<li>
									<i class="com-icon-folder"></i>
									<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=display&categoryid=' . $row->id ); ?>"><?php echo JText::_( $this->escape($row->name) ); ?></a>
									<?php if( $row->count > 0 ){ ?><span class="cCount">&nbsp;<?php echo $row->count; ?></span><?php } ?>
								</li>
							<?php endforeach; ?>
						<?php else: ?>
							<?php if( $category->parent == COMMUNITY_NO_PARENT && $category->id == COMMUNITY_NO_PARENT ){ ?>
								<li>
									<i class="com-icon-folder"></i>
									<?php echo JText::_('COM_COMMUNITY_GROUPS_CATEGORY_NOITEM'); ?>
								</li>
							<?php } ?>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
			</div>
			<?php if($config->get('creatediscussion') ){?>
			<?php echo $discussionsHTML;?>
			<?php }?>
		</div>

		<!-- ALL GROUP LIST -->
		<div class="cMain">
			<?php echo $sortings; ?>
			<?php echo $groupsHTML;?>
		</div>
	</div>
</div><!--.cIndex-->

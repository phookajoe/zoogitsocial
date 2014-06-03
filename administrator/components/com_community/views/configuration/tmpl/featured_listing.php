<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_LISTING' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_ENABLED_FEATURED' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_SHOW_FEATURED_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_ENABLED_FEATURED' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'show_featured' , null , $this->config->get('show_featured') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_ALBUM_SCROLL' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_ALBUM_SCROLL_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_ALBUM_SCROLL' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="featuredalbumscroll">
						<option <?php echo ( $this->config->get('featuredalbumscroll') == '1' ) ? 'selected="true"' : ''; ?> value="1">1</option>
						<option <?php echo ( $this->config->get('featuredalbumscroll') == '2' ) ? 'selected="true"' : ''; ?> value="2">2</option>
						<option <?php echo ( $this->config->get('featuredalbumscroll') == '3' ) ? 'selected="true"' : ''; ?> value="3">3</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_VIDEO_SCROLL' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_VIDEO_SCROLL_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_VIDEO_SCROLL' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="featuredvideoscroll">
						<option <?php echo ( $this->config->get('featuredvideoscroll') == '1' ) ? 'selected="true"' : ''; ?> value="1">1</option>
						<option <?php echo ( $this->config->get('featuredvideoscroll') == '2' ) ? 'selected="true"' : ''; ?> value="2">2</option>
						<option <?php echo ( $this->config->get('featuredvideoscroll') == '3' ) ? 'selected="true"' : ''; ?> value="3">3</option>

					</select>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_EVENT_SCROLL' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_EVENT_SCROLL_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_EVENT_SCROLL' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="featuredeventscroll">
						<option <?php echo ( $this->config->get('featuredeventscroll') == '1' ) ? 'selected="true"' : ''; ?> value="1">1</option>
						<option <?php echo ( $this->config->get('featuredeventscroll') == '2' ) ? 'selected="true"' : ''; ?> value="2">2</option>
						<option <?php echo ( $this->config->get('featuredeventscroll') == '3' ) ? 'selected="true"' : ''; ?> value="3">3</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_GROUP_SCROLL' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_GROUP_SCROLL_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_GROUP_SCROLL' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="featuredgroupscroll">
						<option <?php echo ( $this->config->get('featuredgroupscroll') == '1' ) ? 'selected="true"' : ''; ?> value="1">1</option>
						<option <?php echo ( $this->config->get('featuredgroupscroll') == '2' ) ? 'selected="true"' : ''; ?> value="2">2</option>
						<option <?php echo ( $this->config->get('featuredgroupscroll') == '3' ) ? 'selected="true"' : ''; ?> value="3">3</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MEMBER_SCROLL' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_MEMBER_SCROLL_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MEMBER_SCROLL' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="featuredmemberscroll">
						<option <?php echo ( $this->config->get('featuredmemberscroll') == '1' ) ? 'selected="true"' : ''; ?> value="1">1</option>
						<option <?php echo ( $this->config->get('featuredmemberscroll') == '2' ) ? 'selected="true"' : ''; ?> value="2">2</option>
						<option <?php echo ( $this->config->get('featuredmemberscroll') == '3' ) ? 'selected="true"' : ''; ?> value="3">3</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_USERS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_USERS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_USERS' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="featureduserslimit" value="<?php echo $this->config->get('featureduserslimit' );?>" size="4" /> <?php echo JText::_('COM_COMMUNITY_USERS');?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_VIDEOS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_VIDEOS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_VIDEOS' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="featuredvideoslimit" value="<?php echo $this->config->get('featuredvideoslimit');?>" size="4" /> <?php echo JText::_('COM_COMMUNITY_VIDEOS');?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_GROUPS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_GROUPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_GROUPS' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="featuredgroupslimit" value="<?php echo $this->config->get('featuredgroupslimit' );?>" size="4" /> <?php echo JText::_('COM_COMMUNITY_GROUPS');?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_ALBUMS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_ALBUMS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_ALBUMS' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="featuredalbumslimit" value="<?php echo $this->config->get('featuredalbumslimit' );?>" size="4" /> <?php echo JText::_('COM_COMMUNITY_ALBUMS');?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_EVENTS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_EVENTS_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_FEATURED_MAXIMUM_EVENTS' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="featuredeventslimit" value="<?php echo $this->config->get('featuredeventslimit' );?>" size="4" /> <?php echo JText::_('COM_COMMUNITY_EVENTS');?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_ALBUM_PHOTO_PAGINATION' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_ALBUM_PHOTO_PAGINATION_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_ALBUM_PHOTO_PAGINATION' ); ?>
					</span>
				</td>
				<td valign="top">
					<select name="listlimit">
						<option <?php echo ( $this->config->get('listlimit') == '16' ) ? 'selected="true"' : ''; ?> value="16">16</option>
						<option <?php echo ( $this->config->get('listlimit') == '20' ) ? 'selected="true"' : ''; ?> value="20">20</option>
						<option <?php echo ( $this->config->get('listlimit') == '24' ) ? 'selected="true"' : ''; ?> value="24">24</option>
						<option <?php echo ( $this->config->get('listlimit') == '28' ) ? 'selected="true"' : ''; ?> value="28">28</option>
						<option <?php echo ( $this->config->get('listlimit') == '32' ) ? 'selected="true"' : ''; ?> value="32">32</option>
						<option <?php echo ( $this->config->get('listlimit') == '36' ) ? 'selected="true"' : ''; ?> value="36">36</option>
						<option <?php echo ( $this->config->get('listlimit') == '40' ) ? 'selected="true"' : ''; ?> value="40">40</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>
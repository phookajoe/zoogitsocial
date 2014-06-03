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
	<legend><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY' ); ?></legend>
	<h3><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_USER_PRIVACY' ); ?></h3>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_PROFILE_PRIVACY' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_PROFILE_PRIVACY_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_PROFILE_PRIVACY' ); ?>
					</span>
				</td>
				<td valign="top" class="privacyprofile">
					<?php echo $this->getPrivacyHTML( 'privacyprofile' , $this->config->get('privacyprofile') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_FRIENDS_PRIVACY' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_FRIENDS_PRIVACY_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_FRIENDS_PRIVACY' ); ?>
					</span>
				</td>
				<td valign="top" class="privacyfriends">
					<?php echo $this->getPrivacyHTML( 'privacyfriends' , $this->config->get('privacyfriends') , true ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_PHOTOS_PRIVACY' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_PHOTOS_PRIVACY_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_PHOTOS_PRIVACY' ); ?>
					</span>
				</td>
				<td valign="top" class="privacyphotos">
					<?php echo $this->getPrivacyHTML( 'privacyphotos' , $this->config->get('privacyphotos') , true ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_VIDEOS_PRIVACY' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_VIDEOS_PRIVACY_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_VIDEOS_PRIVACY' ); ?>
					</span>
				</td>
				<td valign="top" class="privacyvideos">
					<?php echo $this->getPrivacyHTML( 'privacyvideos' , $this->config->get('privacyvideos') , true ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_GROUPLIST_PRIVACY' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_GROUPLIST_PRIVACY_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_GROUPLIST_PRIVACY' ); ?>
					</span>
				</td>
				<td valign="top" class="privacy_groups_list">
					<?php echo $this->getPrivacyHTML( 'privacy_groups_list' , $this->config->get('privacy_groups_list') , true ); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="button" value="<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_RESET_EXISTING_PRIVACY_BUTTON');?>" onclick="azcommunity.resetprivacy();" />
					<span id="privacy-update-result"></span>
				</td>
			</tr>
		</tbody>
	</table>
	<h3><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_EMAIL_NOTIFICATIONS' ); ?></h3>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_NOTIFICATION_LIMIT' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_NOTIFICATION_LIMIT_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_NOTIFICATION_LIMIT' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="maxnotification" value="<?php echo $this->config->get('maxnotification',20 );?>" size="10" />
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_DAYS' ); ?>
				</td>
			</tr>		
			<tr>
				<td width="300" class="key">
					<?php echo JText::_( 'COM_COMMUNITY_TYPE' ); ?>
					</span>
				</td>
				<td class="key" style="text-align:center;">	
					<?php echo JText::_( 'COM_COMMUNITY_EMAIL' ); ?>
				</td>
				<td class="key" style="text-align:center;">	
					<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATION' ); ?>
				</td>
			</tr>

			<?php 	
				foreach($this->notificationTypes->getTypes() as $group){
					foreach($group->child as $id => $type){
						$emailId  = $this->notificationTypes->convertEmailId($id);
						$notifId  = $this->notificationTypes->convertNotifId($id);
						$emailset = $this->config->get($emailId);
						$notifset = $this->config->get($notifId);
					
			?>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( $type->description ); ?>::<?php echo JText::_($type->tips); ?>">
					<?php echo JText::_( $type->description ); ?>
					</span>
				</td>
				<td valign="top"  style="text-align:center;">
				<input type="hidden" name="<?php echo $emailId; ?>" value="0" />
				<input class="notification_cfg" id="<?php echo $emailId ?>" type="checkbox" name="<?php echo $emailId; ?>" value="1" <?php if( $emailset == 1) echo 'checked="checked"'; ?> />
				</td>
				<td valign="top"  style="text-align:center;">
				<input type="hidden" name="<?php echo $notifId; ?>" value="0" />
				<input class="notification_cfg" id="<?php echo $notifId; ?>" type="checkbox" name="<?php echo $notifId; ?>" value="1" <?php if( $notifset == 1) echo 'checked="checked"'; ?> />
				</td>
			</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="2">
					<input type="button" value="<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_RESET_EXISTING_NOTIFICATION_BUTTON');?>" onclick="azcommunity.resetnotification('<?php echo JText::_('COM_COMMUNITY_PLEASE_WAIT_BUTTON')?>');" />
					<span id="notification-update-result"></span>
				</td>
			</tr>			
		</tbody>
	</table>
	<h3><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_ADMINISTRATORS' ); ?></h3>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_HIDE_ADMINS' ); ?>::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_PRIVACY_HIDE_ADMINS_TIPS'); ?>">
					<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_PRIVACY_HIDE_ADMINS' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'privacy_show_admins' , null , $this->config->get('privacy_show_admins') , JText::_('COM_COMMUNITY_YES_OPTION') , JText::_('COM_COMMUNITY_NO_OPTION') ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>
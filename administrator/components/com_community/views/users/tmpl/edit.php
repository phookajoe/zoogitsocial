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
<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla calls it
 **/
 Joomla.submitbutton = function(action){
 	submitbutton( action );
 }
function submitbutton( action )
{
	if( action == 'removeavatar' )
	{
		jax.call('community' , 'admin,users,ajaxRemoveAvatar' , '<?php echo $this->user->id;?>');
	}
	else
	{
		var form = document.adminForm;

		if( action == 'cancel')
		{
			submitform( action );
			return;
		}

		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");

		// do field validation
		if (joms.jQuery.trim(form.name.value) == "")
		{
			alert( "<?php echo JText::_('COM_COMMUNITY_USERS_PROVIDE_NAME_WARNING'); ?>" );
		}
		else if (form.username.value == "")
		{
			alert( "<?php echo JText::_('COM_COMMUNITY_USERS_PROVIDE_LOGIN_NAME_WARNING'); ?>" );
		}
		else if (r.exec(form.username.value) || form.username.value.length < 2)
		{
			alert( "<?php echo JText::_('COM_COMMUNITY_USERS_INVALID_LOGIN_WARNING'); ?>" );
		}
		else if (joms.jQuery.trim(form.email.value) == "")
		{
			alert( "<?php echo JText::_('COM_COMMUNITY_USERS_PROVIDE_EMAIL_WARNING'); ?>" );
		}
		else if (((joms.jQuery.trim(form.password.value) != "") || (joms.jQuery.trim(form.password2.value) != "")) && (form.password.value != form.password2.value))
		{
			alert( "<?php echo JText::_('COM_COMMUNITY_USERS_PASSWORD_MISMATCH_WARNING'); ?>" );
		}
		else
		{
			submitform( action );
		}
	}
}
</script>
<form name="adminForm" id="adminForm" action="index.php?option=com_community" method="POST">
<?php
echo JHtml::_('tabs.start', 'profile-fields' , array('startOffset'=>0));
echo JHtml::_('tabs.panel', JText::_('COM_COMMUNITY_USERS_ACCOUNT_DETAILS') , 'details-page' );
?>
<table  width="100%" class="admintable" cellspacing="1">
	<tr>
		<td class="key">
			<label for="username"><?php echo JText::_('COM_COMMUNITY_USERS_PROFILE_PICTURE'); ?></label>
		</td>
		<td class="paramlist_value">
			<img id="user-avatar" src="<?php echo $this->escape( $this->user->getThumbAvatar() );?>" style="border: 1px solid #eee;" alt="<?php echo $this->escape( $this->user->getDisplayName() );?>" />
			<div id="user-avatar-message"></div>
		</td>
	</tr>
	<tr>
		<td class="key"><?php echo JText::_('COM_COMMUNITY_USER_STATUS');?></td>
		<td class="paramlist_value">
			<!-- <input type="text" name="status" size="80" value="<?php echo $this->escape( $this->user->getStatus() );?>" /> -->
			<textarea name="status" cols="56" rows="6"><?php echo $this->escape( $this->user->getStatus(true) );?></textarea>
		</td>
	</tr>
	<tr>
		<td class="key">
			<label for="username"><?php echo JText::_('COM_COMMUNITY_USER_NAME'); ?></label>
		</td>
		<td class="paramlist_value">
			<input type="text" name="username" value="<?php echo $this->user->get('username');?>" />
		</td>
	</tr>
	<tr>
		<td class="key">
			<label id="jsemailmsg"><?php echo JText::_('COM_COMMUNITY_EMAIL'); ?></label>
		</td>
		<td class="paramlist_value">
			<input type="text" class="inputbox" id="email" name="email" value="<?php echo $this->escape( $this->user->get('email') );?>" size="80" />
		</td>
	</tr>
	<tr>
		<td class="key">
			<label for="name"><?php echo JText::_('COM_COMMUNITY_NAME'); ?></label>
		</td>
		<td>
			<input class="inputbox" type="text" id="name" name="name" value="<?php echo $this->escape( $this->user->get('name') );?>" size="80" />
			<div style="clear:both;"></div>
			<span id="errnamemsg" style="display:none;">&nbsp;</span>
		</td>
	</tr>
	<tr>
		<td class="key">
			<label for="jspassword">
				<?php echo JText::_('COM_COMMUNITY_PASSWORD'); ?>
			</label>
		</td>
		<td>
			<input id="password" name="password" class="inputbox" type="password" value="" size="80"/>
			<span id="errjspasswordmsg" style="display: none;"> </span>
		</td>
	</tr>
	<tr>
		<td class="key">
			<label for="jspassword2">
				<?php echo JText::_('COM_COMMUNITY_VERIFY_PASSWORD'); ?>
			</label>
		</td>
		<td>
			<input id="password2" class="inputbox" type="password" value="" size="80" name="password2"/>
			<span id="errjspassword2msg" style="display:none;"> </span>
			<div style="clear:both;"></div>
			<span id="errpasswordmsg" style="display:none;">&nbsp;</span>
		</td>
	</tr>
	<?php if($this->profilelist): ?>
	<tr>
		<td class="key">
			<label class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_USERS_PROFILE_TYPE' );?>::<?php echo JText::_('COM_COMMUNITY_USERS_PROFILE_TYPE');?>" for="profiletype">
				<?php echo JText::_( 'COM_COMMUNITY_USERS_PROFILE_TYPE' ); ?>
			</label>
		</td>
		<td>
			<?php echo $this->profilelist; ?>
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td class="key">
			<?php echo JText::_('COM_COMMUNITY_USER_POINTS'); ?>
		</td>
		<td>
			<input id="userpoint" name="userpoint" class="inputbox" type="text" value="<?php echo $this->user->getKarmaPoint();?>" size="8" style="text-align: center;"/>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('COM_COMMUNITY_BLOCK_USER'); ?>
		</td>
		<td>
			<?php echo JHTML::_('select.booleanlist',  'block', 'class="inputbox" size="1"', $this->user->get('block') ); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('COM_COMMUNITY_RECEIVE_SYSTEM_EMAILS'); ?>
		</td>
		<td>
			<?php echo JHTML::_('select.booleanlist',  'sendEmail', 'class="inputbox" size="1"', $this->user->get('sendEmail') ); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('COM_COMMUNITY_USERS_REGISTERED_DATE'); ?>
		</td>
		<td>
			<?php echo JHTML::_('date', $this->user->get('registerDate'), COMMUNITY_DATE_FORMAT_REGISTERED );?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<?php echo JText::_('COM_COMMUNITY_USERS_LAST_VISIT_DATE'); ?>
		</td>
		<td>
			<?php echo ($this->user->get('lastvisitDate') == "0000-00-00 00:00:00") ? JText::_('COM_COMMUNITY_NEVER') : JHTML::_('date', $this->user->get('lastvisitDate'), COMMUNITY_DATE_FORMAT_REGISTERED ); ?>
		</td>
	</tr>
	<tr>
		<td class="key">
			<label class="hasTip" title="<?php echo JText::_( 'COM_COMMUNITY_DAYLIGHT_SAVING_OFFSET' );?>::<?php echo JText::_('COM_COMMUNITY_DAYLIGHT_SAVING_OFFSET_TOOLTIP');?>" for="daylightsavingoffset">
				<?php echo JText::_( 'COM_COMMUNITY_DAYLIGHT_SAVING_OFFSET' ); ?>
			</label>
		</td>
		<td>
			<?php echo $this->offsetList; ?>
		</td>
	</tr>
</table>
<?php if(isset($this->params)) :  echo $this->params->render( 'params' ); endif; ?>
<?php
// Create tabs
foreach( $this->user->profile['fields'] as $group => $groupFields )
{
	echo JHtml::_('tabs.panel', JText::_($group) , $group . '-page' );
?>
	<table class="paramlist admintable" cellspacing="1" style="width: 100%;">
	<tbody>
<?php
	foreach( $groupFields as $field )
	{
		$field	= JArrayHelper::toObject ( $field );
		$field->value	= $this->escape( $field->value );
?>
		<tr>
			<td class="key" id="lblfield<?php echo $field->id;?>"><?php if($field->required == 1) echo '*'; ?><?php echo JText::_( $field->name );?></td>
			<td><?php echo CProfileLibrary::getFieldHTML( $field , '' ); ?></td>
		</tr>
<?php
	}
?>
	</tbody>
	</table>
<?php

}
echo JHtml::_('tabs.end');
?>
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="userid" value="<?php echo $this->user->id; ?>" />
<input type="hidden" name="option" value="com_community" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
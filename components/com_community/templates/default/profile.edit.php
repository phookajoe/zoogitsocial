<?php
/**
 * @package	JomSocial
 * @subpackage Core
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
$validPassword = JText::sprintf( JText::_( 'VALID_AZ09', true ), JText::_( 'Password', true ), 4 );
?>
<?php if( $showProfileType ){ ?>
<div class="com-notice">
		<?php if( $multiprofile->id != COMMUNITY_DEFAULT_PROFILE ){ ?>
			<?php echo JText::sprintf('COM_COMMUNITY_CURRENT_PROFILE_TYPE' , $multiprofile->name );?>
		<?php } else { ?>
			<?php echo JText::_('COM_COMMUNITY_CURRENT_DEFAULT_PROFILE_TYPE');?>
		<?php } ?>
		[ <a href="<?php echo CRoute::_('index.php?option=com_community&view=multiprofile&task=changeprofile');?>"><?php echo JText::_('COM_COMMUNITY_CHANGE');?></a> ]
</div>
<?php } ?>


<div class="cLayout cProfile-Edit">
	<form name="jsform-profile-edit" id="frmSaveProfile" action="<?php echo CRoute::getURI(); ?>" method="POST" class="cForm community-form-validate">

		<ul class="cTabsMenu cResetList cFloatedList clearfix">
			<li><a href="#basicSet"><?php echo JText::_('COM_COMMUNITY_PROFILE_SETTING_INFO');?></a></li>
			<li><a href="#detailSet"><?php echo JText::_('COM_COMMUNITY_PROFILE_SETTING_INFO_DETAILS');?></a></li>
		</ul>

		<div class="cTabsContent">

			<div id="basicSet" class="section"> <!-- Profile Basic Setting -->
				<?php
				foreach ( $fields as $name => $fieldGroup )
				{
						if ($name != 'ungrouped')
						{
				?>
				<div class="ctitle">
					<h2><?php echo JText::_( $name );?></h2>
				</div>
				<?php
						}
				?>
				<ul class="cFormList cFormHorizontal cResetList">
					<?php
						foreach ( $fieldGroup as $f )
						{
							$f = JArrayHelper::toObject ( $f );

							// DO not escape 'SELECT' values. Otherwise, comparison for
							// selected values won't work
							if($f->type != 'select'){
								$f->value	= $this->escape( $f->value );
							}
					?>
							<li>
								<label id="lblfield<?php echo $f->id;?>" for="field<?php echo $f->id;?>" class="form-label">
									<?php if($f->required == 1) echo '*'; ?><?php echo JText::_( $f->name );?>
								</label>
								<div class="form-field">
									<?php echo CProfileLibrary::getFieldHTML( $f , '' ); ?>
									<div class="form-privacy">
										<?php echo CPrivacy::getHTML( 'privacy' . $f->id , $f->access ); ?>
									</div>
								</div>
							</li>
					<?php
						}
					?>
				</ul>
				<?php
				}
				?>

				<?php if(!empty($afterFormDisplay)){ ?>
					<?php echo $afterFormDisplay; ?>
				<?php } ?>

				<input type="hidden" name="action" value="save" />
			</div> <!-- end basic setting -->


			<div id="detailSet" class="section"> <!-- Profile Detail Setting -->
				<?php if(!empty($beforeFormDisplay)){ ?>
				<div class="before-form">
					<?php echo $beforeFormDisplay; ?>
				</div>
				<?php } ?>

				<ul class="cFormList cFormHorizontal cResetList">
					<!-- username -->
					<li>
						<label class="form-label" for="username"><?php echo JText::_('COM_COMMUNITY_PROFILE_USERNAME'); ?></label>
						<div class="form-field">
							<span class="uneditable-input"><?php echo $this->escape($user->get('username')); ?></span>
						</div>
					</li>
					<?php if (!$isUseFirstLastName) { ?>
					<!-- fullname -->
					<li>
						<label class="form-label" for="name"><?php echo JText::_('COM_COMMUNITY_PROFILE_YOURNAME'); ?></label>
						<div class="form-field">
							<input class="input text" type="text" id="name" name="name" size="40" value="<?php echo $this->escape($user->get('name'));?>" />
						</div>
					</li>
					<?php } ?>
					<!-- email -->
					<li>
						<label class="form-label" for="jsemail"><?php echo JText::_( 'COM_COMMUNITY_EMAIL' ); ?></label>
						<div class="form-field">
							<input type="text" class="input text" id="jsemail" name="jsemail" size="40" value="<?php echo $this->escape( $user->get('email') ); ?>" />
							<input type="hidden" id="email" name="email" value="<?php echo $user->get('email'); ?>" />
							<input type="hidden" id="emailpass" name="emailpass" id="emailpass" value="<?php echo $this->escape( $user->get('email') ); ?>"/>
							<span id="errjsemailmsg" style="display:none;">&nbsp;</span>
						</div>
					</li>
					<?php if ( !$associated ) : ?>
					<?php     if ( $user->get('password') ) : ?>
					<!-- password -->
					<li>
						<label class="form-label" for="jspassword"><?php echo JText::_( 'COM_COMMUNITY_PASSWORD' ); ?></label>
						<div class="form-field">
							<input id="jspassword" name="jspassword" class="input password" size="40" type="password" value="" />
							<span id="errjspasswordmsg" style="display: none;"> </span>
						</div>
					</li>
					<!-- 2nd password -->
					<li>
						<label class="form-label" for="jspassword2"><?php echo JText::_( 'COM_COMMUNITY_VERIFY_PASSWORD' ); ?></label>
						<div class="form-field">
							<input id="jspassword2" name="jspassword2" class="input password" type="password" size="40" value="" />
							<span id="errjspassword2msg" style="display:none;"> </span>
							<div style="clear:both;"></div>
							<span id="errpasswordmsg" style="display:none;">&nbsp;</span>
						</div>
					</li>
					<?php     endif; ?>
					<?php endif; ?>

					<?php if(isset($params))
							echo $params->render( 'params' );
					 ?>

					<!-- DST -->
					<li class="has-seperator">
							<label class="form-label jomNameTips" title="<?php echo JText::_('COM_COMMUNITY_DAYLIGHT_SAVING_OFFSET_TOOLTIP');?>" for="daylightsavingoffset">
								<?php echo JText::_( 'COM_COMMUNITY_DAYLIGHT_SAVING_OFFSET' ); ?>
							</label>
						<div class="form-field">
							<?php echo $offsetList; ?>
						</div>
					</li>

					<!-- group buttons -->
					<input type="hidden" name="id" value="<?php echo $user->get('id');?>" />
					<input type="hidden" name="gid" value="<?php echo $user->get('gid');?>" />
					<input type="hidden" name="option" value="com_community" />
					<input type="hidden" name="view" value="profile" />
					<input type="hidden" name="task" value="edit" />
					<input type="hidden" id="password" name="password" />
					<input type="hidden" id="password2" name="password2" />
					<?php echo JHTML::_( 'form.token' ); ?>

				</ul>

				<?php
				if( $config->get('fbconnectkey') && $config->get('fbconnectsecret') )
				{
				?>
					<div class="ctitle"><h2><?php echo JText::_('COM_COMMUNITY_ASSOCIATE_FACEBOOK_LOGIN' );?></h2></div>
				<?php
					if( $isAdmin )
					{
				?>
					<div class="small facebook"><?php echo JText::_('COM_COMMUNITY_ADMIN_NOT_ALLOWED_TO_ASSOCIATE_FACEBOOK');?></div>
				<?php
					}
					else
					{
						if( $associated )
						{
						?>
							<div class="small facebook"><?php echo JText::_('COM_COMMUNITY_ACCOUNT_ALREADY_MERGED');?></div>
							<!--
							<div>
								<input<?php echo $readPermission ? ' checked="checked" disabled="true"' : '';?> type="checkbox" id="facebookread" name="connectpermission" onclick="FB.Connect.showPermissionDialog('read_stream', function(x){if(!x){ joms.jQuery('#facebookread').attr('checked',false);}}, true );">
								<label for="facebookread" style="display: inline;"><?php echo JText::_('COM_COMMUNITY_ALLOW_SITE_TO_READ_UPDATES_FROM_YOUR_FACEBOOK_ACCOUNT');?></label>
							</div>
							-->
							<br/>
							<div>
								<input<?php echo !empty($fbPostStatus) ? ' checked="checked"' : '';?> type="checkbox" id="postFacebookStatus" name="postFacebookStatus">
								<label for="postFacebookStatus" style="display: inline;"><?php echo JText::_('COM_COMMUNITY_ALLOW_SITE_TO_PUBLISH_UPDATES_TO_YOUR_FACEBOOK_ACCOUNT');?></label>
							</div>
						<?php
						}
						else
						{
							echo $fbHtml;
						}
					}
				}
				?>
			</div>

			<ul class="cFormList cFormHorizontal cResetList">
				<li class="has-seperator">
					<div class="form-field">
						<span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span>
					</div>
				</li>
				<li>
					<div class="form-field">
						<input type="submit" name="frmSubmit" onclick="submitbutton(); return false;" class="cButton cButton-Blue" value="<?php echo JText::_('COM_COMMUNITY_SAVE_BUTTON'); ?>" />
					</div>
				</li>
			</ul>
		</form>
	</div> <!-- .end: .cTabsContent-->
</div>
<script type="text/javascript">
	cvalidate.init();
	cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("COM_COMMUNITY_ENTRY_MISSING")); ?>');
	cvalidate.setSystemText('JOINTEXT','<?php echo addslashes(JText::_("COM_COMMUNITY_AND")); ?>');

	joms.jQuery( document ).ready( function(){

		joms.privacy.init();

	var tabContainers = joms.jQuery('.cTabsContent > div');

	var url = document.location.href;

	var filter = ':first';

	if(url.indexOf("#detailSet")!== -1)
	{
		filter = ':last';
	}

	joms.jQuery('.cTabsMenu li a').click(function () {
		tabContainers.hide().filter(this.hash).fadeIn(500);
		joms.jQuery('.cTabsMenu li a').removeClass('selected');
		joms.jQuery(this).addClass('selected');
		return false;
	}).filter(filter).click();

	});

function submitbutton() {
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

	//hide all the error messsage span 1st
	joms.jQuery('#name').removeClass('invalid');
	joms.jQuery('#jspassword').removeClass('invalid');
	joms.jQuery('#jspassword2').removeClass('invalid');
	joms.jQuery('#jsemail').removeClass('invalid');

	joms.jQuery('#errnamemsg').hide();
	joms.jQuery('#errnamemsg').html('&nbsp');

	joms.jQuery('#errpasswordmsg').hide();
	joms.jQuery('#errpasswordmsg').html('&nbsp');

	joms.jQuery('#errjsemailmsg').hide();
	joms.jQuery('#errjsemailmsg').html('&nbsp');

	joms.jQuery('#password').val(joms.jQuery('#jspassword').val());
	joms.jQuery('#password2').val(joms.jQuery('#jspassword2').val());

	// do field validation
	var isValid	= true;

	if (joms.jQuery('#name').val() == "") {
		isValid = false;
		joms.jQuery('#errnamemsg').html('<?php echo addslashes(JText::_( 'COM_COMMUNITY_PLEASE_ENTER_NAME', true ));?>');
		joms.jQuery('#errnamemsg').show();
		joms.jQuery('#name').addClass('invalid');
	}

	if(joms.jQuery('#jsemail').val() !=  joms.jQuery('#email').val())
	{
		regex=/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
		isValid = regex.test(joms.jQuery('#jsemail').val());

		var fieldname = joms.jQuery('#jsemail').attr('name');;
		if(isValid == false){
			cvalidate.setMessage(fieldname, '', 'COM_COMMUNITY_INVALID_EMAIL');
			joms.jQuery('#jsemail').addClass('invalid');
		}
	}

	if(joms.jQuery('#password').val().length > 0 || joms.jQuery('#password2').val().length > 0) {
		//check the password only when the password is not empty!
		if(joms.jQuery('#password').val().length < 6 ){
			isValid = false;
			joms.jQuery('#jspassword').addClass('invalid');
			alert('<?php echo addslashes(JText::_( 'COM_COMMUNITY_PASSWORD_TOO_SHORT' ));?>');
		} else if (((joms.jQuery('#password').val() != "") || (joms.jQuery('#password2').val() != "")) && (joms.jQuery('#password').val() != joms.jQuery('#password2').val())){
			isValid = false;
			joms.jQuery('#jspassword').addClass('invalid');
			joms.jQuery('#jspassword2').addClass('invalid');
			var err_msg = "<?php echo addslashes(JText::_( 'COM_COMMUNITY_PASSWORD_NOT_SAME' )); ?>";
			alert(err_msg);
		} else if (r.exec(joms.jQuery('#password').val())) {
			isValid = false;
			joms.jQuery('#errpasswordmsg').html('<?php echo $validPassword; ?>');
			joms.jQuery('#errpasswordmsg').show();

			joms.jQuery('#jspassword').addClass('invalid');
		}
	}

	if(isValid) {
		//replace the email value.
		joms.jQuery('#email').val(joms.jQuery('#jsemail').val());
		joms.jQuery('#frmSaveProfile').submit();
	}
}

// Password strenght indicator
var password_strength_settings = {
	'texts' : {
		1 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L1')); ?>',
		2 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L2')); ?>',
		3 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L3')); ?>',
		4 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L4')); ?>',
		5 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L5')); ?>'
	}
}

joms.jQuery('#jspassword').password_strength(password_strength_settings);
</script>

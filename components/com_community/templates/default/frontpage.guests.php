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
<div class="cGuest clearfix">

	<!-- Start the Login Form -->
	<div class="cGuest-Access cFloat-R">
		<h2 class="cGuest-Head cResetH"><?php echo JText::_('COM_COMMUNITY_MEMBER_LOGIN'); ?></h2>
		<form action="<?php echo CRoute::getURI();?>" method="post" name="login" id="form-login" >
			<ul class="cFormList cFormFull cFormVertical cResetList">
				<li>
					<label class="form-label">
						<span class="small cFloat-R">
							<a href="<?php echo CRoute::_( 'index.php?option='.COM_USER_NAME.'&view=remind' ); ?>" tabindex="5">
								<?php echo JText::_('COM_COMMUNITY_FORGOT'); ?>
							</a>
						</span>
						<?php echo JText::_('COM_COMMUNITY_USERNAME'); ?>
					</label>
					<div class="form-field"><input type="text" class="input text frontlogin" name="username" id="username" tabindex="1" /></div>
				</li>
				<li>
					<label class="form-label">
						<span class="small cFloat-R">
							<a href="<?php echo CRoute::_( 'index.php?option='.COM_USER_NAME.'&view=reset' ); ?>" tabindex="6">
								<?php echo JText::_('COM_COMMUNITY_FORGOT'); ?>
							</a>
						</span>
						<?php echo JText::_('COM_COMMUNITY_PASSWORD'); ?>
					</label>
					<div class="form-field">
						<input type="password" class="input password frontlogin" name="<?php echo COM_USER_PASSWORD_INPUT;?>" id="password"  tabindex="2" />
					</div>
				</li>
				<li>
					<div class="form-field">
						<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
						<label for="remember" class="label-checkbox">
							<input type="checkbox" alt="<?php echo JText::_('COM_COMMUNITY_REMEMBER_MY_DETAILS'); ?>" value="yes" id="remember" name="remember"  tabindex="3" />
							<?php echo JText::_('COM_COMMUNITY_REMEMBER_MY_DETAILS'); ?>
						</label>
					<?php endif; ?>
					</div>
				</li>
				<li class="form-action has-seperator">
					<input type="submit" value="<?php echo JText::_('COM_COMMUNITY_LOGIN_BUTTON');?>" name="submit" id="submit" class="cButton cButton-Blue"  tabindex="4" />
					<input type="hidden" name="option" value="<?php echo COM_USER_NAME;?>" />
					<input type="hidden" name="task" value="<?php echo COM_USER_TAKS_LOGIN;?>" />
					<input type="hidden" name="return" value="<?php echo $return; ?>" />
					<?php echo JHTML::_( 'form.token' ); ?>
				</li>
			</ul>

			<!--
			<span>
				<a href="" class="login-forgot-password"><span><?php echo JText::_('COM_COMMUNITY_FORGOT_YOUR'). ' '. JText::_('COM_COMMUNITY_PASSWORD').'?'; ?></span></a><br />
				<a href="" class="login-forgot-username"><span><?php echo JText::_('COM_COMMUNITY_FORGOT_YOUR'). ' '. JText::_('COM_COMMUNITY_USERNAME').'?'; ?></span></a>
			</span>
			-->
			<?php if ($useractivation) { ?>
				<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=register&task=activation' ); ?>" class="login-forgot-username">
					<span><?php echo JText::_('COM_COMMUNITY_RESEND_ACTIVATION_CODE'); ?></span>
				</a>
			<?php } ?>
		</form>

		<?php echo $fbHtml;?>
	</div>


	<!-- Start the Intro text -->
	<div class="cGuest-Intro">
		<h2 class="cGuest-Head cResetH"><?php echo JText::_('COM_COMMUNITY_GET_CONNECTED_TITLE'); ?></h2>
		<ul class="cGuest-Story cResetList">
			<li>
				<i class="com-icon-tick cFloat-L"></i>
				<?php echo JText::_('COM_COMMUNITY_CONNECT_AND_EXPAND'); ?>
			</li>
			<li>
				<i class="com-icon-tick cFloat-L"></i>
				<?php echo JText::_('COM_COMMUNITY_VIEW_PROFILES_AND_ADD_FRIEND'); ?>
			</li>
			<li>
				<i class="com-icon-tick cFloat-L"></i>
				<?php echo JText::_('COM_COMMUNITY_SHARE_PHOTOS_AND_VIDEOS'); ?>
			</li>
			<li>
				<i class="com-icon-tick cFloat-L"></i>
				<?php echo JText::_('COM_COMMUNITY_GROUPS_INVOLVE'); ?>
			</li>
		</ul>
		<?php if ($allowUserRegister) : ?>
			<div class="cGuest-Action">
				<a class="cButton cButton-Green" href="<?php echo CRoute::_( 'index.php?option=com_community&view=register' , false ); ?>">
					<?php echo JText::_('COM_COMMUNITY_JOIN_US_NOW'); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
	<!-- End Intro text -->
</div>
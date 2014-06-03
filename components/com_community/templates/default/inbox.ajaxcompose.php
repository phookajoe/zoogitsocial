<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	friends		array or CUser (all user)
 * @param	total		integer total number of friends  
 */
defined('_JEXEC') or die();

$jnow		= CTimeHelper::getDate();
?>

<div id="writeMessageContainer">
	<form name="jsform-inbox-ajaxcompose" method="post" action="" name="writeMessageForm" id="writeMessageForm">
		<ul class="cFormList cFormVertical cResetList">
			<li>
				<!-- <label class="form-label"><label class="label"><?php echo JText::_('COM_COMMUNITY_COMPOSE_TO'); ?></label> -->
				<div class="form-field clearfix">
					<img src="<?php echo $user->getThumbAvatar(); ?>" height="50" alt="<?php echo $user->getDisplayName(); ?>" class="cFloat-L" />
					<strong>
						&nbsp;&nbsp;
						<?php echo $user->getDisplayName(); ?>
						&nbsp;&nbsp;
					</strong>
					<br />
					<span class="small">
						&nbsp;&nbsp;
						<?php echo $jnow->format( JText::_('DATE_FORMAT_LC2') );?>
						&nbsp;&nbsp;
					</span>
				</div>
			</li>
			<li class="has-seperator">
				<label for="subject" class="form-label"><?php echo JText::_('COM_COMMUNITY_COMPOSE_SUBJECT'); ?></label>
				<div class="form-field">
					<div class="input-wrap">
						<input class="input text" type="text" value="<?php echo (empty($subject))?'':$subject; ?>" id="subject" name="subject" style="width: 100%" />
					</div>
				</div>
			</li>
			<li>
				<label for="body" class="form-label"><?php echo JText::_('COM_COMMUNITY_COMPOSE_MESSAGE'); ?></label>
				<div class="form-field">
					<div class="input-wrap">
						<p>
							<textarea class="input textarea" style="height: 80px; width: 100%" id="body" name="body" ><?php echo (empty($body))?'':$body;; ?></textarea>
						</p>
					</div>
				</div>
			</li>
		</ul>
		<input type="hidden" value="<?php echo $user->id; ?>" name="to" />
	</form>
</div>

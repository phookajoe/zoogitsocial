<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	$event		CTableEvent object
 * @param	$message	String from post
 * @param	$title		String from post
 * @param	$editor		JEditor object    
 */
defined('_JEXEC') or die(); 
?>
<div class="cLayout cEvents-SendMail">
<form name="jsform-events-sendmail" action="<?php echo CRoute::getURI();?>" method="post" class="cForm event-email">
	<ul class="cFormList cFormVertical cResetList">
		<li>
			<div class="cNotice"><?php echo JText::sprintf('COM_COMMUNITY_EVENTS_EMAIL_DESCRIPTION', $event->getMembersCount( COMMUNITY_EVENT_STATUS_ATTEND ) );?></div>
		</li>
		<li>
			<label class="form-label">*<?php echo JText::_('COM_COMMUNITY_TITLE'); ?>:</label>
			<div class="form-field">
				<input type="text" name="title" value="<?php echo $this->escape($title);?>" class="input text required" style="width: 95%" />
			</div>
		</li>
		<li>
			<label class="form-label"><?php echo JText::_('COM_COMMUNITY_MESSAGE'); ?>:</label>
			<div class="form-field"><?php echo $editor->displayEditor( 'message',  $message , '100%', '450', '10', '20' , false ); ?></div>
		</li>
		<li class="has-seperator">
			<span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span>
		</li>
		<li class="form-action">
			<input type="submit" class="button cButton cButton-Blue" value="<?php echo JText::_('COM_COMMUNITY_SEND'); ?>">
			<input type="hidden" name="eventid" value="<?php echo $event->id;?>">
			<?php echo JHTML::_( 'form.token' ); ?>
		</li>
	</ul>	
</form>
</div>
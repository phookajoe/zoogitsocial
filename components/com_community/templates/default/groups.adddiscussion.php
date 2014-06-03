<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @params	isMine		boolean is this group belong to me
 * @params	members		An array of member objects 
 */
defined('_JEXEC') or die();
?>
<div class="cLayout cGroups-AddDiscussion">
<form class="cForm" name="jsform-groups-discussionform" action="<?php echo CRoute::getURI(); ?>" method="post">
	<?php
		if( !CStringHelper::isHTML($discussion->message) 
		&& $config->get('htmleditor') != 'none' 
		&& $config->getBool('allowhtml') )
		{
			$discussion->message = CStringHelper::nl2br($discussion->message);
		}
	?>

	<script type="text/javascript">
	function saveContent()
	{
		<?php echo $editor->saveText( 'message' ); ?>
		return true;
	}
	</script>	

	<ul class="cFormList cFormHorizontal cResetList">

		<?php echo $beforeFormDisplay;?>

		<li>
			<label for="title" class="form-label">*<?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION_TITLE'); ?></label>

			<div class="form-field">
				<input type="text" name="title" id="title" size="40" class="input text" style="width: 90%" value="<?php echo $discussion->title;?>" />
			</div>
		</li>

		<?php if ( $config->get( 'htmleditor' ) == 'jce' ) { ?>

			<li>
				<label for="message" class="form-label">*<?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION_BODY'); ?></label>

				<div class="form-field">
					<?php if( $config->get( 'htmleditor' ) && $config->getBool( 'allowhtml' ) ) : ?>
						<?php echo $editor->displayEditor( 'message',  $discussion->message , '95%', '450', '10', '20' , false ); ?>
					<?php else : ?>
						<textarea rows="3" cols="40" name="message" id="message" class="textarea" style="width: 90%"><?php echo $discussion->message;?></textarea>
					<?php endif; ?>
				</div>
			</li>
		
		<?php } else { ?>

			<li>
				<label for="message" class="form-label">*<?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION_BODY'); ?></label>

				<div class="form-field">
					<?php 
					if( $config->get( 'htmleditor' ) == 'none' && $config->getBool('allowhtml') )
					{
					?>
					<div class="htmlTag"><?php echo JText::_('COM_COMMUNITY_HTML_TAGS_ALLOWED');?></div>
					<?php
					}?>
					
					<?php if( $config->get( 'htmleditor' ) && $config->getBool('allowhtml') ) : ?>
						<?php echo $editor->displayEditor( 'message',  $discussion->message , '95%', '450', '10', '20' , false ); ?>
					<?php else : ?>
						<textarea rows="3" cols="40" name="message" id="message" style="width: 90%"><?php echo $discussion->message;?></textarea>
					<?php endif; ?>
				</div>
			</li>

		<?php } ?>



		<?php if($params->get('groupdiscussionfilesharing') > 0) { ?>
		<li class="has-seperator">
			<div class="form-field">
				<label for="filepermission-member" class="label-checkbox">
					<input type="checkbox" class="input checkbox" value="1" name="filepermission-member"/>
					<?php echo JText::_('COM_COMMUNITY_FILES_ALLOW_MEMBERS')?>
				</label>
			</div>
		</li>
		<?php } ?>


		<?php echo $afterFormDisplay;?>


		<li class="has-seperator">
			<div class="form-field">
				<span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span>
			</div>
		</li>
		<li class="form-action">
			<div class="form-field">
				<input type="hidden" value="<?php echo $group->id; ?>" name="groupid" />
				<input type="submit" class="cButton cButton-Blue" value="<?php echo JText::_('COM_COMMUNITY_GROUPS_ADD_DISCUSSION_BUTTON');?>" onclick="saveContent();" />
				<input type="button" class="cButton" name="cancel" value="<?php echo JText::_('COM_COMMUNITY_CANCEL_BUTTON'); ?>" onclick="javascript:history.go(-1);return false;" /> 
				<?php echo JHTML::_( 'form.token' ); ?>
			</div>
		</li>
	</ul>
</form>
</div>
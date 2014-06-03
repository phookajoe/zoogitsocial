<?php
/**
 * @package			JomSocial
 * @subpackage 	Template 
 * @copyright 	(c) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license			GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
?>
<div class="cLayout cMail Inbox">
<ul class="cMailBar cResetList cFloatedList clearfix">
	<li>
		<b class="cMail-MasterCheck">
			<input type="checkbox" name="select" class="checkbox jomNameTips" onclick="checkAll();" id="checkall" title="<?php echo JText::_('COM_COMMUNITY_INOBOX_SELECT_ALL'); ?>" />
		</b>
	</li>
	<li>
		<div class="cButtons">
			<?php if ( !JRequest::getVar('task') == 'sent' ) { ?>
				<a class="cButton" href="javascript:void(0);" onclick="setAllAsRead();"><?php echo JText::_('COM_COMMUNITY_INBOX_MARK_READ'); ?></a>&nbsp;&nbsp;&nbsp;
				<a class="cButton" href="javascript:void(0);" onclick="setAllAsUnread();"><?php echo JText::_('COM_COMMUNITY_INBOX_MARK_UNREAD'); ?></a>&nbsp;&nbsp;&nbsp;
				<a class="cButton" href="javascript:void(0);" onclick="joms.messaging.confirmDeleteMarked('inbox');"><?php echo JText::_('COM_COMMUNITY_INBOX_REMOVE_MESSAGE'); ?></a>&nbsp;
			<?php } else { ?>
				<a class="cButton" href="javascript:void(0);" onclick="joms.messaging.confirmDeleteMarked('sent');"><?php echo JText::_('COM_COMMUNITY_INBOX_REMOVE_MESSAGE'); ?></a>&nbsp;
			<?php } ?>
		</div>
	</li>
</ul>


<ul id="inbox-listing" class="cMailList cResetList">
	<?php foreach ( $messages as $message ) : ?>
	<li class="cMail-Item<?php echo $message->isUnread ? ' Unread' : ' Read'; ?>" id="message-<?php echo $message->id; ?>">
		<div class="cMail-Box clearfix">
			<input type="checkbox" name="message[]" value="<?php echo $message->id; ?>" class="cMail-Check cFloat-L checkbox" onclick="checkSelected();" />

			<a class="cMail-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=inbox&task=read&msgid='. $message->parent); ?>">
				<?php if((JRequest::getVar('task') == 'sent') && (! empty($message->smallAvatar[0])) ) { ?>
					<img width="48" src="<?php echo $message->smallAvatar[0]; ?>" alt="<?php echo $this->escape( JString::ucfirst( $message->to_name[0] ) ); ?>" class="cAvatar" />
				<?php } else { ?>
					<img width="48" src="<?php echo $message->avatar; ?>" alt="<?php echo $this->escape( JString::ucfirst( $message->from_name ) ); ?>" class="cAvatar" />
				<?php }//end if ?>
			</a>

			<div class="cMail-Excerpt">
				<div class="cMail-Actions cFloat-R small">
					<a href="javascript:jax.call('community', 'inbox,ajaxRemoveFullMessages', <?php echo $message->id; ?>);" class="cButton cButton-Small" title="<?php echo JText::_('COM_COMMUNITY_INBOX_REMOVE_CONVERSATION'); ?>">
						<?php echo JText::_('COM_COMMUNITY_INBOX_REMOVE'); ?>
					</a>
				</div>
				
				<strong class="cMail-Author">
				<?php if((JRequest::getVar('task') == 'sent') && (! empty($message->smallAvatar[0])) ) {
					echo $message->to_name[0];
				} else {
					echo $message->from_name;
				}//end if  ?> 
				</strong>
				&nbsp;
				<small class="cMail-Time">
				<?php
					$postdate =  CTimeHelper::timeLapse(CTimeHelper::getDate($message->posted_on));
					echo $postdate;
				?>
				</small>

				<div class="cMail-Subject">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=inbox&task=read&msgid='. $message->parent); ?>">
						<?php echo $message->subject; ?>
					</a>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>


<?php 
if ( $pagination ) 
{
?>
<div class="cPagination">
	<?php echo $pagination; ?>
</div>
<?php 
} 
?>
<script type="text/javascript">
function checkAll()
{
	joms.jQuery("#inbox-listing INPUT[type='checkbox']").each( function() {
		if ( joms.jQuery('#checkall').attr('checked') )
			joms.jQuery(this).attr('checked', true);
		else
			joms.jQuery(this).attr('checked', false);
	});
	return false;
}
function checkSelected()
{
	var sel;
	sel = false;
	joms.jQuery("#inbox-listing INPUT[type='checkbox']").each( function() {
		if ( !joms.jQuery(this).attr('checked') )
			joms.jQuery('#checkall').attr('checked', false);
	});
}
function markAsRead( id )
{
	joms.jQuery('#message-'+id).removeClass('Unread');
	joms.jQuery('#message-'+id).addClass('Read');
	joms.jQuery('#new-message-'+id).hide();
	joms.jQuery("#message-"+id+" INPUT[type='checkbox']").attr('checked', false);
	joms.jQuery('#checkall').attr('checked', false);
}
function markAsUnread( id )
{
	joms.jQuery('#message-'+id).removeClass('Read');
	joms.jQuery('#message-'+id).addClass('Unread');
	joms.jQuery('#new-message-'+id).show();
	joms.jQuery("#message-"+id+" INPUT[type='checkbox']").attr('checked', false);
	joms.jQuery('#checkall').attr('checked', false);
}
function setAllAsRead()
{
	joms.jQuery("#inbox-listing INPUT[type='checkbox']").each( function() {
		if ( joms.jQuery(this).attr('checked') ) {
			if ( joms.jQuery('#message-'+joms.jQuery(this).attr('value')).hasClass('Unread') ) {
				jax.call( 'community', 'inbox,ajaxMarkMessageAsRead', joms.jQuery(this).attr('value') );
			}
		}
	});
}
function setAllAsUnread()
{
	joms.jQuery("#inbox-listing INPUT[type='checkbox']").each( function() {
		if ( joms.jQuery(this).attr('checked') )
			if ( joms.jQuery('#message-'+joms.jQuery(this).attr('value')).hasClass('Read') ) {
				jax.call( 'community', 'inbox,ajaxMarkMessageAsUnread', joms.jQuery(this).attr('value') );
			}
	});
}
</script>
</div>

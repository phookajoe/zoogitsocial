<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @param	$discussions	An array of discussions object
 * @param	$groupId		The group id
 * @param	$total			The number of total discussions 
 */
defined('_JEXEC') or die();
?>
<ul class="cStreamList forDiscussion pushedUp cResetList">
<?php
if( $discussions )
{
	foreach($discussions as $row)
	{
		
?>
	<li>
		<a href="<?php echo CUrlHelper::userLink($row->user->id); ?>" class="cStream-Avatar cFloat-L">
			<img src="<?php echo $row->user->getThumbAvatar(); ?>"  alt="<?php echo $row->user->getDisplayName(); ?>" width="48" />
		</a>

		<div class="cStream-Content">
			
			<a class="cStream-Heading" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussion&groupid=' . $groupId. '&topicid=' . $row->id ); ?>">
				<?php echo $row->title; ?>
			</a>

			<div class="cStream-Actions clearfix small">
				<span>
					<?php echo JText::sprintf('COM_COMMUNITY_GROUPS_DISCUSSION_CREATOR' , '<a href="' . CUrlHelper::userLink( $row->user->id ) . '">' . $row->user->getDisplayName() . '</a>'); ?>
				</span>
				<span>
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussion&groupid=' . $groupId . '&topicid=' . $row->id ); ?>">
						<?php echo JText::sprintf( (CStringHelper::isPlural($row->count)) ? 'COM_COMMUNITY_TOTAL_REPLIES_MANY' : 'COM_COMMUNITY_GROUPS_DISCUSSION_REPLY_COUNT', $row->count); ?>
					</a>
				</span>
			</div>

			<?php if( $row->lastmessage ){ ?>
			<div class="cStream-Quote">
				<div class="stream-quote-text"><?php echo $this->escape( $row->lastmessage );?></div>
				<?php if( isset( $row->lastreplier ) && !empty( $row->lastreplier ) ) { ?>
				<div class="cStream-Actions clearfix small">
					<span><?php echo JText::sprintf('COM_COMMUNITY_GROUPS_DISCUSSION_REPLY_TIME', '<a href="' . CUrlHelper::userLink( $row->lastreplier->post_by->id ) . '">' . $row->lastreplier->post_by->getDisplayName() . '</a>', JHTML::_('date', $row->lastreplier->date, JText::_('DATE_FORMAT_LC')) ); ?></span>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
	</li>
	<?php
	}
	?>
<?php
}
else
{
?>
	<li>
		<div class="cAlert">
			<?php echo JText::_('COM_COMMUNITY_GROUPS_DISCUSSION_EMPTY_WARNING'); ?>
		</div>
	</li>
<?php
}
?>
</ul>
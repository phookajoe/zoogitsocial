<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
?>
<?php if (count ($rows) > 0 ) { ?>
<div class="cWindowNotification forMessage">

	<ul class="cWindowStream forInbox cResetList">
		<?php foreach ( $messages as $message ) : ?>
		<li id="noti-request-group-<?php echo $row->id; ?>">
			<a href="<?php echo $message->profileLink; ?>" class="cStream-Avatar cFloat-L">
				<img src="<?php echo $message->avatar; ?>" alt="<?php echo $this->escape( JString::ucfirst( $message->from_name ) ); ?>" class="cAvatar" />
			</a>
			<div class="cStream-Content">
				<div class="cStream-Headline">
					<a class="subject" href="<?php echo CRoute::_('index.php?option=com_community&view=inbox&task=read&msgid='. $message->parent); ?>">					
						<?php echo $message->subject; ?>
					</a>
				</div>
				<div class="cStream-Actions clearfix small" id="noti-answer-friend-<?php echo $row->connection_id; ?>">
					<span>
						<?php echo $this->escape( $message->from_name ); ?>,
						<?php
							$postdate =  CTimeHelper::getDate($message->posted_on);
							echo $postdate->format( JText::_('DATE_FORMAT_LC2') );
						?>
					</span>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
	
</div>
<?php } ?>
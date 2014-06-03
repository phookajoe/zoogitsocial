<?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

$user = CFactory::getUser($this->act->actor);
$user = CFactory::getUser(0);

// Required variables
//$stream = stdClass();

/*
{
"actor":5,
"target": 6,
"message":"string",
"group" : "JTableGroup object",
"event" : "JTableEvent object",
"headline" : "string",
"location" : "Kuala Lumpur",
 "attachments":
[
	{"type":"media"},
	{"type":"video", "id":0, "title":"", "description":"", "duration": "string"},
	{"type":"quote"}
]
}
*/
?>

<a class="cStream-Avatar cFloat-L" href="<?php echo CUrlHelper::userLink($stream->actor->id); ?>">
	<img class="cAvatar" data-author="<?php echo $user->id; ?>" src="<?php echo $stream->actor->getThumbAvatar(); ?>">
</a>

<div class="cStream-Content">
	<div class="cStream-Headline">
		<?php echo $stream->headline; ?>
		<?php if(!empty($stream->group)) {?>
		<span class="cStream-Reference">
			 ➜ <a class="cStream-Reference" href="<?php echo $group->getLink(); ?>"><?php echo $group->name; ?></a>
		</span>
		<?php } ?>
	</div>

	<?php
	// Contain message ?
	if($stream->message) {
	?>
	<div class="cStream-Attachment">
		<?php echo $stream->message; ?>
	</div>
	<?php } ?>

	<?php
	if( ! empty($stream->attachments)) {
		foreach ($stream->attachments as $attachment) {

			switch ($attachment->type) {
				case 'media':
					?>
					<div class="cStream-Attachment">
						<div class="cStream-Photo">
							<div class="cStream-PhotoRow row-fluid">
								<div class="span3">
									<a class="cPhoto-Thumb" href="#"><img src="http://placekitten.com/120/120" alt="photo"></a>
								</div>
							</div>
						</div>
					</div>
					<?php
					break;

				case 'album':
					?>
					<div class="cStream-Attachment">
						<div class="cStream-Photo">
							<div class="cStream-PhotoRow row-fluid">
								<div class="span3">
									<a class="cPhoto-Thumb" href="#"><img src="http://placekitten.com/120/120" alt="photo"></a>
								</div>
								<div class="span3">
									<a class="cPhoto-Thumb" href="#"><img src="http://placekitten.com/120/120" alt="photo"></a>
								</div>
								<div class="span3">
									<a class="cPhoto-Thumb" href="#"><img src="http://placekitten.com/120/120" alt="photo"></a>
								</div>
								<div class="span3">
									<a class="cPhoto-Thumb" href="#"><img src="http://placekitten.com/120/120" alt="photo"></a>
								</div>
							</div>
						</div>
					</div>
					<?php
					break;

				case 'video':
					// the id is optional. If avaiable, it linked to internal video id
					$link = (!empty($attachment->id)) ? "javascript:joms.walls.showVideoWindow('{$attachment->id}')" : "#";
					?>
					<div class="cStream-Attachment">
						<div class="cStream-Video clearfix">
							<a href="<?php echo $link; ?>" class="cVideo-Thumb cFloat-L">
								<img src="<?php echo $attachment->thumbnail; ?>" alt="<?php echo $this->escape($attachment->title); ?>">
								<b><?php echo $attachment->duration; ?></b>
							</a>

							<div class="cVideo-Content">
								<b class="cVideo-Title">
									<a href="<?php echo $link; ?>"><?php echo $attachment->title; ?></a>
								</b>
								<div class="cVideo-Desc">
									<?php echo JHTML::_('string.truncate', $attachment->description , $config->getInt('streamcontentlength'),true, false ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
					break;

				case 'quote':
					?>
					<div class="cStream-Attachment">
						<div class="cStream-Quote">
							<?php echo $attachment->message; ?>
						</div>
					</div>
					<?php
					break;
				default:
					# code...
					break;
			}
		} // end foreach
	} // end if

	$this->load('activities.actions');
	?>

</div>

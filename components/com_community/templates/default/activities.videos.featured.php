<?php
/**
 * @packageJomSocial
 * @subpackage Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

$param = new CParameter($this->act->params);

$user = CFactory::getUser($this->act->actor);
$video = JTable::getInstance('Video', 'CTable');
$video->load($this->act->cid);
?>

<div class="cStream-Content">
	<div class="cStream-Headline">
		<b>
			<?php echo JText::sprintf('COM_COMMUNITY_VIDEOS_IS_FEATURED','<a href="'.CRoute::_($param->get('video_url')).'" class="cStream-Title">'.$this->escape($video->title).'</a>')?>
		</b>
	</div>
	<div class="cStream-Attachment">
		<div class="cStream-Video clearfix">
			<a href="javascript:joms.walls.showVideoWindow('<?php echo $video->id ?>')" class="cVideo-Thumb cFloat-L">
				<img src="<?php echo $video->getThumbnail();?>" alt="">
				<b><?php echo $video->getDurationInHMS()?></b>
			</a>

			<div class="cVideo-Content">
				<div class="cVideo-Desc">
				<?php echo JHTML::_('string.truncate', $video->description, $config->getInt('streamcontentlength') );?>
				</div>
			</div>
		</div>
	</div>

	<?php
	// Tell actions that this is a featured stream
	$this->act->isFeatured = true;
	$this->load('activities.actions');
	?>
</div>
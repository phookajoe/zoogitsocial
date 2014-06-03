<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
?>

<?php if(!empty($data)) { ?>
<ul class="cThumbsList cResetList clearfix">
<?php foreach( $data as $video ) { ?>
	<li>
		<a class="cVideo-Thumb" href="<?php echo $video->getURL(); ?>">
			<img src="<?php echo $video->getThumbNail(); ?>" alt="<?php echo $video->getTitle(); ?>" class="cAvatar Video cMediaAvatar jomNameTips"  title="<?php echo $this->escape($video->title); ?>" />
			<b><?php echo $video->getDurationInHMS(); ?></b>
		</a>
	</li>
	<?php } ?>
</ul>
<?php } else {
?>
<div class="cEmpty"><?php echo JText::_('COM_COMMUNITY_VIDEOS_NO_VIDEO'); ?></div>
<?php } ?>

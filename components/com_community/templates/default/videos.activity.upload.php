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
<div class="cStream-Video clearfix">
	<a class="cVideo-Thumb cFloat-L" href="<?php //echo $url;?>javascript:joms.walls.showVideoWindow('<?php echo $video->getId(); ?>')">
		<img alt="<?php echo $this->escape( $video->getTitle() );?>" src="<?php echo $video->getThumbnail();?>"/>
		<b><?php echo $duration;?></b>
	</a>

	<div class="cVideo-Content">
		<b class="cVideo-Title">
			<a href="javascript:joms.walls.showVideoWindow('<?php echo $video->getId(); ?>')"><?php echo $video->getTitle(); ?></a>
		</b>
		<?php if ( $video->getDescription() ) { ?>
		<div class="cVideo-Desc">
			<?php echo JHTML::_('string.truncate', $video->getDescription() , $config->getInt('streamcontentlength'));?>
		</div>
		<?php } ?>
	</div>
</div>
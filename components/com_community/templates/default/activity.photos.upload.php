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

<div class="cStream-Photo">
	<?php
	$displayCount = $count;

	// If more than 3 but less than 6, clip to 3.
	$displayCount = $displayCount > 4 && $displayCount < 8 ? 4 : $count;

	// Otherwise, max out at 8
	$displayCount = $displayCount > 8 ? 8 : $displayCount;

	$photos = array_slice($photos, 0, $displayCount);
	$i = 0;
	foreach($photos as $photo)
	{
		if($i == 0)
		{
	?>
		<div class="cStream-PhotoRow row-fluid">
	<?php
		}
	?>
		<div class="span3">
			<a href="<?php echo $photo->getPhotoLink();?>" class="cPhoto-Thumb"><img alt="<?php echo $this->escape($photo->caption);?>" src="<?php echo $photo->getThumbURI();?>" /></a>
		</div>
	<?php
		$i++;
		if( $i % 4 == 0 )
		{
			$i = 0;
	?>
		</div>
	<?php
		} // end if
	} // end foreach
	?>
</div>


<?php if ( $album->description ) { ?>
<div class="cStream-Quote">
	<?php echo JHTML::_('string.truncate', $album->description, $config->getInt('streamcontentlength') );?>
</div>
<?php } ?>


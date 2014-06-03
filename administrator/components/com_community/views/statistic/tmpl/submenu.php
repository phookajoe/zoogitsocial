<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<script type="text/javascript">
Joomla.submitbutton = function(action){
	submitbutton( action );
}
</script>
<?php $is16 = JVERSION >= '1.6' ? 1 : 0; ?>

<?php if($is16) { ?>
<div id="submenu-box">
	<div class="t"><div class="t"><div class="t"></div></div></div>
	<div class="m">
<?php } ?>
		<ul id="submenu" class="jsconfiguration">
			<li><a href="#" onclick="return false;" id="basic" class="active"><?php echo JText::_( 'User' ); ?></a></li>
			<li><a href="#" onclick="return false;" id="image"><?php echo JText::_( 'Media' ); ?></a></li>
			<li><a href="#" onclick="return false;" id="video"><?php echo JText::_( 'Groups and Events' ); ?></a></li>
		</ul>
		<div class="clr"></div>
<?php if($is16) { ?>
	</div>
	<div class="b"><div class="b"><div class="b"></div></div></div>
</div>
<?php } ?>
<div class="clr"></div>

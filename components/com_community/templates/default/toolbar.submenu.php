<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 */
defined('_JEXEC') or die( 'Restricted Access' );
?>
<script type="text/javascript">
joms.jQuery(document).ready( function() {
	joms.jQuery('#community-wrap .cSubmenu li.action:last').addClass('last-child');
});
</script>
<ul class="cSubmenu cResetList cFloatedList clearfix">
<?php
foreach($submenu as $menu)
{
	$menuClass='';
	if( isset($menu->action) && ($menu->action) )
	{
		$menuClass .= 'action ';
	}
	if( isset($menu->childItem) && $menu->childItem )
	{
		$menuClass .= 'hasChildItem ';
	}

	$link=''; $linkClass=''; $onclick='';
	if( isset($menu->onclick) && !empty($menu->onclick) )
	{
		$link    = 'javascript: void(0);';
		$onclick =  $menu->onclick;
	} else {
		$link    = CRoute::_($menu->link);

		if( JString::strtolower( $menu->view ) == JString::strtolower($view) &&
		    JString::strtolower( $menu->task ) == JString::strtolower($task) )
		{
			$linkClass .= 'class="'.'active'.'"';
		}
	}
?>
	<li<?php if ($menuClass) { ?> class="<?php echo $menuClass ?>"<?php } ?>>
		<a href="<?php echo $link ?>"
		   <?php echo $linkClass ?>
		   onclick="<?php echo $onclick ?>"><?php echo $menu->title ?></a>
		<?php echo $menu->childItem ?>
	</li>		
<?php
}
?>
</ul>
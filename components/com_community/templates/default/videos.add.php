<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 *
 */
defined('_JEXEC') or die();
?>

<link rel="stylesheet" href="<?php echo JURI::root();?>components/com_community/assets/jquery-ui-tabs-1.8.14.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/jquery-ui-tabs.min.js"></script>
<?php
if( $enableVideoUpload )
{
?>
<script>
joms.jQuery(function() {
	joms.jQuery( "#tabs" ).tabs();
});
</script>
<?php
}
?>




<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
	<?php
	if( $enableVideoUpload )
	{
	?>
	<ul>
		<li><a href="#tabs-1"><?php echo JText::_('COM_COMMUNITY_VIDEOS_LINK'); ?></a></li>
		<li><a href="#tabs-2"><?php echo JText::_('COM_COMMUNITY_VIDEOS_UPLOAD'); ?></a></li>
	</ul>
	<?php
	}
	?>
	<div id="tabs-1">
		<div style="clear:both;display:block">
			<?php echo $linkUploadHtml;?>
		</div>
	</div>
	<?php
	if( $enableVideoUpload )
	{
	?>
	<div id="tabs-2">
		<div style="clear:both;display:block">
			<?php echo $videoUploadHtml;?>
		</div>
	</div>
		<?php
		}
		?>

</div>
<script type="text/javascript">
	joms.jQuery( document ).ready( function(){
		joms.privacy.init();
	});
</script>




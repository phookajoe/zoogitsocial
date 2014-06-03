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
<!-- begin: .app-widget -->
<div id="<?php echo 'jsapp-' . $app->id; ?>" class="cModule<?php if($app->core) echo " app-core"; ?> app-box app-widget">
	
	<!-- begin: .app-widget-header -->
	<div class="app-widget-header">
		<?php if( $isOwner && $app->hasConfig ){ ?>
		<a title="<?php echo JText::_('COM_COMMUNITY_EDIT');?>" href="javascript:void(0);" class="app-box-cog cFloat-R" onclick="joms.apps.showSettingsWindow('<?php echo $app->id;?>','<?php echo $app->name;?>');">
			<i class="com-icon-cog"></i>
		</a>
		<?php } ?>
		<h3 class="app-box-header cResetH">
			<?php echo JText::_('PLG_'.strtoupper($app->name).'_TITLE'); ?>
		</h3>
	</div>
	<!-- end: .app-widget-header -->
	
	<!-- begin: .app-widget-content -->
	<div class="app-widget-content">
		<?php echo $app->data; ?>
	</div>
	<!-- end: .app-widget-content -->
</div>
<!-- end: .app-widget -->


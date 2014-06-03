<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	applications	An array of applications object
 */
defined('_JEXEC') or die();

if( !empty( $apps ) )
{
?>


<?php
	foreach( $apps as $app )
	{
?>
	<?php if ($itemType=='edit') { ?>
		<div class="app-item <?php if ($app->isCoreApp) echo 'app-core'; ?> app-item-edit" id="app-<?php echo $app->id; ?>">
			<?php if( !$app->isCoreApp ) { ?>
			<a class="app-action-remove" href="javascript:void(0);" onclick="joms.apps.windowTitle= '<?php echo JText::_('COM_COMMUNITY_APPS_AJAX_REMOVED');?>';joms.apps.remove('<?php echo $app->id; ?>');" title="<?php echo JText::_('COM_COMMUNITY_APPS_LIST_REMOVE'); ?>">
				<i class="com-icon-block"></i>
			</a>
			<?php } ?>
		
			<img src="<?php echo $app->favicon['16']; ?>" alt="<?php echo $this->escape($app->title); ?>" class="app-favicon" />
			<b class="app-title"><?php echo $this->escape($app->title); ?></b>
			<div class="app-actions">
				<a href="javascript:void(0);" onclick="joms.apps.showAboutWindow('<?php echo $app->name; ?>');" title="<?php echo JText::_('COM_COMMUNITY_APPS_LIST_ABOUT'); ?>">
					<i class="com-icon-info"></i>
				</a>
				<a href="javascript:void(0);" onclick="joms.apps.showSettingsWindow('<?php echo $app->id; ?>','<?php echo $app->name; ?>');" title="<?php echo JText::_('COM_COMMUNITY_APPS_COLUMN_SETTINGS'); ?>">
					<i class="com-icon-cog"></i>
				</a>
				<a href="javascript:void(0);" onclick="joms.apps.showPrivacyWindow('<?php echo $app->name; ?>');" title="<?php echo JText::_('COM_COMMUNITY_APPS_COLUMN_PRIVACY'); ?>">
					<i class="com-icon-lock-open"></i>
				</a>
			</div>
		</div>
	<?php } ?>
	
	<?php if ($itemType=='browse') { ?>
		<div class="cApp-Item Browse <?php echo $this->escape($app->name); ?>">
			<div class="cApp-Content clearfix">
				<a class="cButton cFloat-R" href="javascript:void(0);" onclick="joms.editLayout.addApp('<?php echo $this->escape($app->name); ?>', '<?php echo $app->position; ?>');">
					<?php echo JText::_('COM_COMMUNITY_APPS_LIST_ADD'); ?>
				</a>
				<img width="50" src="<?php echo $app->favicon['64']; ?>" alt="<?php echo $this->escape($app->title); ?>" class="cApp-Avatar cFloat-L" />
				<div class="cApp-Title">
					<b><?php echo $this->escape($app->title); ?></b>
				</div>
				<div class="cApp-Description"><?php echo $this->escape($app->description); ?></div>
			</div>
		</div>
	<?php } ?>
<?php
	}
?>

<?php
}
else
{
?>
<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_NO_MORE_APPS_TO_BE_ADDED');?></div>
<?php
}
?>
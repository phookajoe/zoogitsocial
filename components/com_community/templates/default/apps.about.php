<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @param	$app	Application object
 */
defined('_JEXEC') or die();
?>

<table class="cFormTable FormInfo" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="label"><?php echo JText::_('COM_COMMUNITY_APPS_NAME');?></td>
		<td class="field"><?php echo $this->escape($app->name); ?></td>
	</tr>
	<?php if($this->params->get('appsShowAuthor')) { ?>
	<tr>
		<td class="label"><?php echo JText::_('COM_COMMUNITY_APPS_AUTHOR');?></td>
		<td class="field"><?php echo $this->escape($app->author); ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td class="label"><?php echo JText::_('COM_COMMUNITY_APPS_VERSION');?></td>
		<td class="field"><?php echo $this->escape($app->version); ?></td>
	</tr>
	<tr>
		<td class="label"><?php echo JText::_('COM_COMMUNITY_APPS_DESCRIPTION');?></td>
		<td class="field"><?php echo $this->escape( JText::_( $app->description ) ); ?></td>
	</tr>
</table>
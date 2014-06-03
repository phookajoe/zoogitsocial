<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 * @params	groups		An array of events objects.
 */
defined('_JEXEC') or die();
?>
<?php if(!empty($data)){?>
	<?php foreach($data as $_data){?>
		<li class="file_<?php echo $_data->id?>">
			<span class="cIcon <?php echo $_data->type; ?>"></span>
			<div>
				<span class="filename"><a href="javascript:void(0)" onClick ="joms.file.ajaxdownloadFile('group','<?php echo $_data->id?>');"><?php echo $_data->name?></a></span>
				<span class="info"><?php echo ($_data->hits > 1 ) ? JText::sprintf('COM_COMMUNITY_FILE_HIT_PLURAL',$_data->hits) : JText::sprintf('COM_COMMUNITY_FILE_HIT_SINGULAR',$_data->hits); ?> <?php echo $_data->filesize?></span><br>
				<span class="uploaded"><?php echo JText::sprintf('COM_COMMUNITY_FILES_UPLOAD_BY' , $_data->user->getDisplayName() , $_data->parentName , $_data->parentType );?></span>
				<a href="javascript:void(0)" class="cFile-Delete cFloat-R" onclick="joms.file.ajaxDeleteFile('discussion','<?php echo $_data->id?>');return false;"><?php echo JText::_('COM_COMMUNITY_DELETE'); ?></a>
			</div>
		</li>
	<?php }?>
<?php } 
	else 
	{
	?>	
		<span class="noFiles"><?php echo JText::_('COM_COMMUNITY_FILES_NO_FILE'); ?></span>
	<?php
	}
?>
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

<div class="cModule cGroups-FileDiscussions app-box">
	
	<?php if(!empty($data)) { ?>

	<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_FILES_AVAILABLE')?></h3>
	<div class="app-box-content">
		<ul class="cFilesList app-box-list cResetList">
			<?php for($i=0;$i<=4;$i++){?>
			<?php 	if(!empty($data[$i])){?>
				<li id="file_<?php echo $data[$i]->id?>" class="file_<?php echo $data[$i]->id?>">
					<a class="cFile-Name" href="javascript:void(0);" onClick ="joms.file.ajaxdownloadFile('<?php echo $type ?>','<?php echo $data[$i]->id ?>');">
						<?php echo JHTML::_('string.truncate', strip_tags($data[$i]->name),40); ?>
					</a>
					<div class="cFile-Author">
						<?php echo JText::sprintf('COM_COMMUNITY_PHOTOS_UPLOADED_BY' , $data[$i]->user->getDisplayName() );?>
					</div>
					<div class="cFile-Meta small">
						<?php if($data[$i]->deleteable) {?>
							<a href="javascript:void(0)" class="cFile-Delete cFloat-R" onClick="joms.file.ajaxDeleteFile('<?php echo $type?>',<?php echo $data[$i]->id?>);return false;">
								<?php echo JText::_('COM_COMMUNITY_FILES_DELETE')?>
							</a>
						<?php }?>
						<?php echo ($data[$i]->hits > 1 ) ? JText::sprintf('COM_COMMUNITY_FILE_HIT_PLURAL',$data[$i]->hits) : JText::sprintf('COM_COMMUNITY_FILE_HIT_SINGULAR',$data[$i]->hits) ?> <?php echo $data[$i]->filesize; ?>
					</div>
				</li>
			<?php 	} ?>
			<?php } ?>
		</ul>
	</div>

	<?php } else { ?>

	<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_FILES_AVAILABLE')?></h3>
	<div class="app-box-content">
		<?php echo JText::_('COM_COMMUNITY_FILES_NO_FILE')?>
	</div>

	<?php }?>
	<div class="app-box-footer clearfix">
		<?php if($permission){?>
			<a class="cFile-Upload cFloat-L" href="javascript:void(0)" onClick="joms.file.showFileUpload('<?php echo $type; ?>',<?php echo $id;?>)"><?php echo JText::_('COM_COMMUNITY_FILES_UPLOAD');?></a>
		<?php }?>
		<?php if(count($data)>5) { ?>
			<a class="cFile-More" href="javascript:void(0)" onClick="joms.file.viewMore('<?php echo $type?>',<?php echo $id?>)"><?php echo JText::_('COM_COMMUNITY_MORE'); ?></a>
		<?php }?>
	</div>
</div>
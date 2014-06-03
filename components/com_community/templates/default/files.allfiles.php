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

<script type="text/javascript">
joms.jQuery(document).ready(function() {
    joms.jQuery(".cTabNavContainer").easytabs();
}); 
</script>

<div class="fsearchWrap">
    <input type="text" onkeyup="joms.file.loadFile(this.value,'<?php echo $gid;?>',0,8,'<?php echo $type?>');" value="" placeholder="<?php echo JText::_('COM_COMMUNITY_FILES_SEARCH_FILES_PLACEHOLDER');?>" name="friendsearch" id="friend-search-filter">

</div>

<div class="cTabNavContainer cGroups-FilesListing">

    <ul class="cTabNav" >
        <li id="ctab-result" onclick="joms.file.getFileList('mostdownload',<?php echo $gid?>,0,8,'<?php echo $type ?>');"><a href="#most-download"><?php echo JText::_('COM_COMMUNITY_FILES_MOST_DOWNLOADED');?></a></li>
        <li id="ctab-selected" onclick="joms.file.getFileList('document',<?php echo $gid?>,0,8,'<?php echo $type ?>');"><a href="#files-document"><?php echo JText::_('COM_COMMUNITY_FILES_DOCUMENT');?></a></li>
        <li id="ctab-selected" onclick="joms.file.getFileList('archive',<?php echo $gid?>,0,8,'<?php echo $type ?>');"><a href="#files-archive"><?php echo JText::_('COM_COMMUNITY_FILES_ARCHIVE');?></a></li>
        <li id="ctab-selected" onclick="joms.file.getFileList('images',<?php echo $gid?>,0,8,'<?php echo $type ?>');"><a href="#files-images"><?php echo JText::_('COM_COMMUNITY_FILES_IMAGES');?></a></li>
        <li id="ctab-selected" onclick="joms.file.getFileList('multimedia',<?php echo $gid?>,0,8,'<?php echo $type ?>');"><a href="#files-multimedia"><?php echo JText::_('COM_COMMUNITY_FILES_AUDIO_VIDEO');?></a></li>
        <li id="ctab-selected" onclick="joms.file.getFileList('miscellaneous',<?php echo $gid?>,0,8,'<?php echo $type ?>');"><a href="#files-miscellaneous"><?php echo JText::_('COM_COMMUNITY_FILES_OTHER');?></a></li>
    </ul>

    <div class="cTabContainer">
    <div id="most-download" class="cTab clrfix">
        <ul id="most-download-list">
        <!-- HERE -->
        </ul>        
    </div>

    <!--Files Document-->
    <ul id="files-document" class="cTab clrfix">
		<!-- HERE -->
    </ul>

    <!--Files Archive-->
    <ul id="files-archive" class="cTab clrfix">
		<!-- HERE -->
    </ul>

     <!--Files Images-->
    <ul id="files-images" class="cTab clrfix">
        <!-- HERE -->
    </ul>
      <!--Files Video-->
    <ul id="files-multimedia" class="cTab clrfix">
		<!-- HERE -->
    </ul>

       <!--Files Others-->
    <ul id="files-miscellaneous" class="cTab clrfix">
		<!-- HERE -->
    </ul>

	<div id="load-more-btn" class="load-more-btn">
	</div>
    </div>
</div>
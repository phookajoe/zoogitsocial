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
<link rel="stylesheet" href="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.html4.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.html5.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<div id="photo-uploader" style="height:310px;overflow:hidden;">
    <div id="upload-content" class="clrfix">
    	<div id="html5_uploader"></div>
    </div><!--#upload-content-->
</div>
<div id="upload-footer" style="display:none">
		<a class="add-more" href="javascript: void(0); "><?php echo JText::_('COM_COMMUNITY_PHOTOS_ADD_MORE_FILES'); ?></a>
</div>	

	<div style="float: left; margin-right: 20px">
		
	</div>

<script type="text/javascript">
joms.jQuery(function() {

   joms.file.ajaxUploadFile('<?php echo $url;?>','<?php echo $fileType?>','<?php echo $maxFileSize?>');
   
});
</script>
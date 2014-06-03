<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die( 'Unauthorized Access');
?>
<div id="report-this" class="cPageReport page-action">
	<a href="javascript:void(0);" onclick="joms.report.emptyMessage = '<?php echo JText::_('COM_COMMUNITY_REPORT_MESSAGE_CANNOT_BE_EMPTY'); ?>';joms.report.showWindow('<?php echo $reportFunc;?>','<?php echo $argsData;?>');">
		<i class="com-icon-report-shade"></i>
		<span><?php echo $reportText;?></span>
	</a>
</div>
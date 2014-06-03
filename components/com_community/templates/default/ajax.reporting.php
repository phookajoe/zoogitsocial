 <?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
?>
<form id="report-form" name="report-form" action="" method="post" class="cForm">
	<ul class="cFormList cFormVertical cResetList">
		<li>
			<label class="form-label"><?php echo JText::_('COM_COMMUNITY_PREDEFINED_REPORTS');?></label>
			<div class="form-field">
				<select class="input select" id="report-predefined" onchange="if(this.value!=0) joms.jQuery('#report-message').val( this.value ); else joms.jQuery('#report-message').val('');" style="width: 100%;">
					<option selected="selected" value="0"><?php echo JText::_('COM_COMMUNITY_SELECT_PREDEFINED_REPORTS'); ?></option>
					<?php
					if( $reports )
					{
						foreach( $reports as $report )
						{
					?>
						<option value="<?php echo JText::_( $report );?>"><?php echo JText::_( $report ); ?></option>
					<?php
						}
					}
					?>
				</select>
			</div>
		</li>
		<li>
			<label class="form-label"><?php echo JText::_('COM_COMMUNITY_REPORT_MESSAGE');?><span id="report-message-error"></span></label>
			<div class="form-field">
				<div class="input-wrap">
					<p>
						<textarea id="report-message" class="input textarea" name="report-message" rows="3" style="width: 100%;"></textarea>
					</p>
				</div>
			</div>
		</li>
	</ul>
	<input type="hidden" name="reportFunc" value="<?php echo $reportFunc; ?>" />
</form>
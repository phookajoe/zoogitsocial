<script type="text/javascript">
//<![CDATA[

(function($) {

joms.status.Creator['custom'] = 
{
	attachment: [],

	focus: function()
	{
		this.Message.parent().hide();
		this.Privacy.parent().hide();
		this.ShareButton.hide();
	},

	blur: function()
	{
		this.Message.parent().show();
		this.Privacy.parent().show();
		this.ShareButton.show();
	},

	getAttachment: function()
	{
		return { type: 'custom' };
	}
}

})(joms.jQuery);

//]]>
</script>

<div class="creator-view type-custom">

	<div class="creator-form align-inherit">
		<form id="activities-custom-message" name="activities-custom-message" method="post" action="" class="cForm">
			<strong><?php echo JText::_('COM_COMMUNITY_ACTIVITES_CUSTOM_MESSAGES' );?></strong>
			<ul class="cFormList cResetList">
				<li>
					<label class="label-radio" for="custom-predefined-message">
						<input type="radio" name="custom-message" class="input radio" id="custom-predefined-message" value="predefined" onclick="joms.activities.selectCustom('predefined');" checked="checked"/>
						<?php echo JText::_('COM_COMMUNITY_SELECT_PREDEFINED_MESSAGES');?>						
					</label>
					<label class="label-radio">
						<select name="custom-predefined" id="custom-predefined" class="input select">
							<?php
							foreach( $customActivities as $key => $message )
							{
							?>
							<option value="<?php echo $key;?>"><?php echo $message; ?></option>
							<?php
							}
							?>
						</select>
					</label>
				</li>
				<li>
					<label class="label-radio" for="custom-text-message">
						<input type="radio" class="input radio" name="custom-message" id="custom-text-message" value="text" onclick="joms.activities.selectCustom('text');" />
						<?php echo JText::_('COM_COMMUNITY_WRITE_A_CUSTOM_MESSAGE');?>
					</label>
					<label class="label-radio">
						<textarea name="custom-text" id="custom-text" cols="45" rows="5" style="display: none;" class="input textarea"></textarea>
					</label>
				</li>
				<li class="has-seperator">
					<input type="button" class="cButton cButton-Black" name="button" id="button" value="<?php echo JText::_('COM_COMMUNITY_POST_IT');?>" onclick="joms.activities.addCustom()" />
				</li>
			</ul>
		</form>
	</div>

</div>
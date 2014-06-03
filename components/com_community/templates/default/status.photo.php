<script type="text/javascript">
//<![CDATA[

(function($) {

var Creator;

joms.status.Creator['photo'] =
{
	attachment: {},

	initialize: function()
	{
		Creator = this;

		Creator.Preview = Creator.View.find('.creator-preview');

		Creator.Form = Creator.View.find('.creator-form');

		Creator.Hint = Creator.View.find('.creator-hint');

		Creator.UploadContainer = Creator.View.find('.creator-upload-container');

		Creator.ToggleUpload = Creator.View.find('.creator-toggle-upload');

		Creator.ToggleUpload
			.hide()
			.click(function()
			{
				Creator.ToggleUpload.hide();
				Creator.newUpload();
			});

		Creator.newUpload();
	},

	focus: function()
	{
		Creator.Message.defaultValue("<?php echo JText::_('COM_COMMUNITY_STATUS_PHOTO_HINT'); ?>", 'hint');
	},

	newUpload: function()
	{

		if(joms.jQuery('#creator-upload').length)
		{
			joms.jQuery('#creator-upload').remove();
		}

		Creator.Upload =
			$('<a class="cButton cButton-Blue" href="javascript:joms.jQuery(\'#creator-upload\').click(); void(0);" style="display: block"> <?php echo JText::_('COM_COMMUNITY_PHOTOS_SELECT_FILE'); ?></a><input id="creator-upload" name="filedata" type="file" size="35" />')
				.change(function()
					{
						Creator.add.apply(Creator);
					})
				.prependTo(Creator.UploadContainer);

		Creator.Form.show();
	},

	add: function()
	{
		Creator.LoadingIndicator.show();

		$.ajaxFileUpload({

			fileElementId: 'creator-upload',
			url: "{url}",

			dataType: 'json',

			success: function(photo)
			{
				if (photo.error)
				{
					Creator.Hint
						.html(photo.msg)
						.show();

					Creator.newUpload();

					return;
				}

				photo.preview = $(decodeURIComponent(photo.html));

				photo.preview
					.find('.creator-change-photo')
					.click(function()
					{
						Creator.remove();
					});

				Creator.Preview.append(photo.preview);

				Creator.attachment = photo;

				Creator.Form.hide();

				Creator.Hint.hide();

				Creator.Upload.remove();

				Creator.LoadingIndicator.hide();
			},

			error: function()
			{
				Creator.LoadingIndicator.hide();
			}

		});

	},

	remove: function()
	{
		Creator.attachment.preview.remove();

		Creator.attachment = {};

		Creator.newUpload();
	},

	submit: function()
	{
		return Creator.attachment.id!=undefined;
	},

	reset: function()
	{
		Creator.remove();
	},

	error: function(message)
	{
		if ($.trim(message).length>0)
		{
			Creator.Hint
				.html(message)
				.show();
		}
	},

	getAttachment: function()
	{
		var attachment = {
			type: 'photo',
			id: Creator.attachment.id
		}

		return attachment;
	}
};

})(joms.jQuery);

//]]>
</script>

<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_community/assets/ajaxfileupload.pack.js"></script>

<div class="creator-view type-photo">
	<div class="creator-hint"></div>

	<div class="creator-preview"></div>

	<div class="creator-form">
		<label class="creator-upload-container label-filetype" for="creator-upload"></label>
		<a class="creator-toggle-upload icon-add" href="javascript: void(0);"><?php echo JText::_('COM_COMMUNITY_ADD_PHOTO'); ?></a>
	</div>
</div>
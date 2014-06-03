<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 */
defined('_JEXEC') or die();
?>
<p>
	<b><?php echo JText::_('COM_COMMUNITY_SHARE_THIS_VIA_LINK');?></b>
</p>
<ul class="cBookmarks cResetList cFloatedList clearfix">
	<?php
	foreach($bookmarks as $bookmark)
	{
	?>
	<li><a href="<?php echo $bookmark->link;?>" target="_blank" class="<?php echo $bookmark->className;?>"><?php echo $this->escape($bookmark->name); ?></a></li>
	<?php
	}
	?>
</ul>
<?php if($config->get( 'shareviaemail' )){ ?>
<hr class="cSeperator" />

<form id="bookmarks-email" class="cForm">
	<ul class="cFormList cFormVertical cResetList">
		<li>
			<label class="form-label"><?php echo JText::_('COM_COMMUNITY_SHARE_THIS_VIA_EMAIL');?></label>
			<div class="form-field">
				<div class="input-wrap">
					<input type="text" id="bookmarks-email" name="bookmarks-email" class="input text bookmarks-email" style="width: 100%" />
				</div>
				<span class="form-helper"><?php echo JText::_('COM_COMMUNITY_SHARE_THIS_VIA_EMAIL_INFO');?></span>
			</div>
		</li>
		<li>
			<label class="form-label"><?php echo JText::_('COM_COMMUNITY_SHARE_THIS_MESSAGE');?></label>
			<div class="form-field">
				<div class="input-wrap">
					<p>
						<textarea rows="3" class="input textarea bookmarks-message" id="bookmarks-message" name="bookmarks-message" style="width: 100%"></textarea>
					</p>
				</div>
			</div>
		</li>
	</ul>
</form>
<?php } ?>
<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" id="adminForm" method="post" name="adminForm" enctype="multipart/form-data">
<div id="config-document">
	<div id="page-main" class="tab">
		<table class="noshow">
			<tr>
				<td>
					<?php require_once( dirname(__FILE__) . '/reportings.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/advance_search.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/cronprocess.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/registrations.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/activity.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/filtering.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/likes.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . '/frontpage.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/bookmarkings.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/featured.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/messaging.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/walls.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/time_offset.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/email.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/status.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/profile.php' ); ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="page-antispam" class="tab">
		<table class="noshow">
			<tr>
				<td width="50%">
					<?php require_once( dirname(__FILE__) . '/akismet.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . '/limits.php' ); ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="page-media" class="tab">
		<table class="noshow">
			<tr>
				<td>
					<?php require_once( dirname(__FILE__) . '/photos.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . '/videos.php' ); ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="page-groups" class="tab">
		<table class="noshow">
			<tr>
				<td width="50%">
					<?php require_once( dirname(__FILE__) . '/groups.php' ); ?>
					
				</td>
				<td>&nbsp;
					
				</td>
			</tr>
		</table>
	</div>
	<div id="page-events" class="tab">
		<table class="noshow">
			<tr>
				<td width="50%">
					<?php require_once( dirname(__FILE__) . '/events.php' ); ?>

				</td>
				<td>&nbsp;
					
				</td>
			</tr>
		</table>
	</div>
	<div id="page-layout" class="tab">
		<table class="noshow">
			<tr>
				<td>
					<?php require_once( dirname(__FILE__) . '/karma.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/featured_listing.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . '/display.php' ); ?>
					<?php require_once( dirname(__FILE__) . '/frontpage_options.php' ); ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="page-privacy" class="tab">
		<table class="noshow">
			<tr>
				<td width="50%">
					<?php require_once( dirname(__FILE__) . '/privacy.php' ); ?>
				</td>
				<td>&nbsp;
					
				</td>
			</tr>
		</table>
	</div>
	
	<div id="page-facebook-connect" class="tab">
		<table class="noshow">
			<tr>
				<td>
					<?php require_once( dirname(__FILE__) . '/facebook_api.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . '/facebook_imports.php' ); ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="page-remote-storage" class="tab">
		<table class="noshow">
			<tr>
				<td>
					<?php require_once( dirname(__FILE__) . '/remote_storage_methods.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . '/remote_storage_s3.php' ); ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="page-integrations" class="tab">
		<table class="noshow">
			<tr>
				<td width="50%">
					<?php require_once( dirname(__FILE__) . '/myblog.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . '/google.php' ); ?>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="clr"></div>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="task" value="saveconfig" />
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="option" value="com_community" />
</form>

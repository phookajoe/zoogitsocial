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
<div id="config-document">
	<div id="page-basic" class="tab">
		<table class="noshow adminlist">
			<tbody>
				<tr>
					<td>
						<fieldset class="adminform">
							<legend>JomSocial Basic Information</legend>
							<table class="adminlist table table-striped">
								<thead>
									<tr>
										<th width="250">Setting</th>
										<th>Value</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>JomSocial Version</td>
										<td><?php echo $this->version?></td>
									</tr>
									<tr>
										<td>Image Processing Engine</td>
										<td>GD Lib</td>
									</tr>
									<tr>
										<td>Video Processing Engine</td>
										<td>FFMPEG</td>
									</tr>
									<tr>
										<td>JomSocial Configuration Override</td>
										<td>No</td>
									</tr>
									<tr>
										<td>JomSocial Template Override</td>
										<td>No</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2"></th>
									</tr>
								</tfoot>
							</table>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset class="adminform">
							<legend>PHP Basic Information</legend>
							<table class="adminlist table table-striped">
								<thead>
									<tr>
										<th width="250">Setting</th>
										<th>Value</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>PHP Version</td>
										<td><?php echo phpversion();?></td>
									</tr>
									<tr>
										<td>Upload Max File Size</td>
										<td><?php echo ini_get('upload_max_filesize');?></td>
									</tr>
									<tr>
										<td>Max Execution Time</td>
										<td><?php echo ini_get('max_execution_time');?></td>
									</tr>
									<tr>
										<td>Max Input Time</td>
										<td><?php echo ini_get('max_input_time');?></td>
									</tr>
									<tr>
										<td>Memory Limit</td>
										<td><?php echo ini_get('memory_limit');?></td>
									</tr>
									<tr>
										<td>Post Max Size</td>
										<td><?php echo ini_get('post_max_size');?></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2"></th>
									</tr>
								</tfoot>
							</table>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset class="adminform">
							<legend>Upload Folder Permission</legend>
							<table class="adminlist table table-striped">
								<thead>
									<tr>
										<th width="250">Setting</th>
										<th>Value</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>PHP Tmp Folder</td>
										<td>Writable</td>
									</tr>
									<tr>
										<td>Joomla! Tmp Folder</td>
										<td>Writable</td>
									</tr>
									<tr>
										<td>Joomla! Image Folder</td>
										<td>Writable</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2"></th>
									</tr>
								</tfoot>
							</table>

						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
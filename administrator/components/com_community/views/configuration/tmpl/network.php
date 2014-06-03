<?php
/**
 * @category	Core
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * @deprecated since 2.8 and to be removed in 3.0
 */
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<table  width="100%">
	<tr>
		<td width="50%">
			<?php require_once( dirname(__FILE__) . '/network_form.php' ); ?>
		</td>
		<td  width="50%">
			<?php require_once( dirname(__FILE__) . '/network_info.php' ); ?>
		</td>
	</tr>
</table>

<?php
/**
 * @package	JomSocial
 * @subpackage 	Template 
 * @copyright	(C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license	GNU/GPL, see LICENSE.php
 * 
 */
defined('_JEXEC') or die();
?>

<div class="cLike forPublic like-snippet">	
	<a href="javascript:void(0);" class="like-button" title="<?php echo JText::_('COM_COMMUNITY_LIKE'); ?>"><i class="com-icon-thumbup-shade"></i><?php echo $likes; ?></a>
	<a href="javascript:void(0);" class="dislike-button" title="<?php echo JText::_('COM_COMMUNITY_DISLIKE'); ?>"><i class="com-icon-thumbdown-shade"></i><?php echo empty($dislikes) ? '&nbsp;' : $dislikes ; ?></a>
</div>
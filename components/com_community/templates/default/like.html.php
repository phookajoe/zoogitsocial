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
<?php if(COwnerHelper::isRegisteredUser()){ ?>
<div id="<?php echo $likeId ?>" class="cLike like-snippet">
	<?php if( $likes > 0 ){ ?>
		<?php if( $userLiked==COMMUNITY_LIKE ) { ?>
			<a class="meLike" href="javascript:void(0);" onclick="joms.like.unlike(this);" title="<?php echo JText::_('COM_COMMUNITY_LIKE_ITEM'); ?>. <?php echo JText::_('COM_COMMUNITY_UNLIKE'); ?>?"><i class="com-icon-thumbup"></i><b><?php echo $likes; ?></b></a>
		<?php } else { ?>
			<a class="like-button" href="javascript:void(0);" onclick="joms.like.like(this)" title="<?php echo JText::_('COM_COMMUNITY_I_LIKE'); ?>"><i class="com-icon-thumbup"></i><b><?php echo $likes; ?></b></a>
		<?php } ?>
	<?php } else { ?>
		<a class="like-button" href="javascript:void(0);" onclick="joms.like.like(this)"><i class="com-icon-thumbup-shade"></i><b><?php echo JText::_('COM_COMMUNITY_LIKE'); ?></b></a>
	<?php } ?>
	
	<?php if( $dislikes > 0 ){ ?>
		<?php if( $userLiked==COMMUNITY_DISLIKE ) { ?>
			<a class="meDislike" href="javascript:void(0);" onclick="joms.like.unlike(this);" title="<?php echo JText::_('COM_COMMUNITY_DISLIKE_ITEM'); ?>. <?php echo JText::_('COM_COMMUNITY_UNDISLIKE'); ?>?"><i class="com-icon-thumbdown"></i><b><?php echo $dislikes; ?></b></a>
		<?php } else { ?>
			<a class="dislike-button" href="javascript:void(0);" onclick="joms.like.dislike(this);" title="<?php echo JText::_('COM_COMMUNITY_DISLIKE'); ?>"><i class="com-icon-thumbdown"></i><?php echo empty($dislikes) ? '' : '<b>' . $dislikes . '</b>' ; ?></a>
		<?php } ?>	
	<?php } else { ?>
		<a class="dislike-button" href="javascript:void(0);" onclick="joms.like.dislike(this);"><i class="com-icon-thumbdown-shade"></i><?php echo empty($dislikes) ? '' : '<b>' . $dislikes . '</b>' ; ?></a>
	<?php } ?>
</div>
<?php } ?>

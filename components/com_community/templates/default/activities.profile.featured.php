
<?php
/**
 * @packageJomSocial
 * @subpackage Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

$param = new CParameter($this->act->params); 

$user = CFactory::getUser($param->get('userid'));
			
?>

<a href="<?php echo CRoute::_($param->get('owner_url'))?>" class="cStream-Avatar cFloat-L">
	<img src="<?php echo $user->getThumbAvatar()?>" data-author="<?php echo $param->get('userid')?>" class="cAvatar">
</a>
<div class="cStream-Content">
	<div class="cStream-Headline">
		<b>
			<?php echo JText::sprintf('COM_COMMUNITY_MEMBER_IS_FEATURED','<a href="'.CRoute::_($param->get('owner_url')).'" class="cStream-Author">'.$user->getDisplayName().'</a>'); ?>
			
		</b>
	</div>
	<?php 
		// Tell actions that this is a featured stream
		$this->act->isFeatured = true;
		$this->load('activities.actions'); 
	?>
</div>
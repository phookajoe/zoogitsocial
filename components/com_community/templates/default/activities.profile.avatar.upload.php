<?php
/**
 * @packageJomSocial
 * @subpackage Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
$user = CFactory::getUser($this->act->actor);
$params = new JRegistry($this->act->params);
?>

<a class="cStream-Avatar cFloat-L" href="<?php echo CUrlHelper::userLink($user->id); ?>">
	<img class="cAvatar" data-author="<?php echo $user->id; ?>" src="<?php echo $user->getThumbAvatar(); ?>">
</a>

<div class="cStream-Content">
	<div class="cStream-Headline">
		<a class="cStream-Author" href="<?php echo CUrlHelper::userLink($user->id); ?>"><?php echo $user->getDisplayName(); ?></a> 
		<?php echo JText::_('COM_COMMUNITY_ACTIVITIES_NEW_AVATAR'); ?>	
	</div>
	
	<div class="cStream-Attachment">
		<?php
		$avatarPath = $params->get('attachment');
		?>
		<img src="<?php echo rtrim(JURI::root(), '/'). '/'. $avatarPath; ?>" />
	</div>
	
	<?php $this->load('activities.actions'); ?>
</div>
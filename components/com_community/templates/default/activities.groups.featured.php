<?php
/**
 * @packageJomSocial
 * @subpackage Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

$param = new CParameter($this->act->params);

$user = CFactory::getUser($this->act->actor);
?>
<a class="cStream-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$this->act->actor) ?>">
	<img src="<?php echo $user->getThumbAvatar()?>" data-author="<?php echo $this->act->actor ?>" class="cAvatar">
</a>

<div class="cStream-Content">
	<div class="cStream-Headline">
		<b>
			<?php echo $this->act->title; ?>
		</b>
	</div>

	<?php $this->load('activities.actions'); ?>

</div>
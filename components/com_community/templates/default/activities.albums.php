<?php
/**
 * @packageJomSocial
 * @subpackage Template
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

// Load params
$param = new JRegistry($act->params);
$user = CFactory::getUser($this->act->actor);
$album	= JTable::getInstance( 'Album' , 'CTable' );
$album->load( $act->cid );
$wall = JTable::getInstance('Wall', 'CTable');
$wall->load($param->get('wallid'));

?>
<a class="cStream-Avatar cFloat-L" href="<?php echo CUrlHelper::userLink($user->id); ?>">
	<img class="cAvatar" data-author="<?php echo $user->id; ?>" src="<?php echo $user->getThumbAvatar(); ?>">
</a>

<?php
//print_r($this->act->album); exit;
?>
<div class="cStream-Content">
	<div class="cStream-Headline" style="display:block">
		<a class="cStream-Author" href="<?php echo CUrlHelper::userLink($user->id); ?>"><?php echo $user->getDisplayName(); ?></a>
		<?php echo JText::sprintf('COM_COMMUNITY_ACTIVITIES_WALL_POST_ALBUM', CRoute::_($album->getURI()), $this->escape($album->name) ); ?>
		</br>
	</div>

	<div class="cStream-Attachment">
		<?php
		// Load some album photos. I'd says 4 is enough
		?>
		<!-- SHOW SOME ALBUM PREVIEW -->
		<div class="cStream-Quote">
			<?php echo CActivities::format( JHTML::_('string.truncate', $wall->comment, $config->getInt('streamcontentlength') ) );?>
		</div>
	</div>

	<?php
	// No comment on album comment?
	//$this->load('activities.actions');
	?>
</div>

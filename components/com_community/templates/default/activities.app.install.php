<?php
/**
 * @packageJomSocial
 * @subpackage Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();

$appLib = CAppPlugins::getInstance();
$user = CFactory::getUser($this->act->actor); 
$users = json_decode($this->act->actors);
$users = $users->userid;

// Get the plugin name
$param = new JRegistry($this->act->params);
$appName = $param->get('app');
$applicationName = '';

$plugin = $appLib->getPlugin($appName);
if(!is_null($plugin))
{
	$applicationName = $plugin->name;
}

$actorsHTML = array();
?>
<div class="cStream-Content">
<i class="cStream-Icon com-icon-groups"></i>
	<?php foreach($users as $actor) 
	{ 
		$user = CFactory::getUser($actor->id);
		$actorsHTML[] = '<a class="cStream-Author" href="'. CUrlHelper::userLink($user->id).'">'. $user->getDisplayName().'</a>'; 
	} 

	echo implode(', ', $actorsHTML); ?> 
	- 
	<?php echo JText::sprintf('COM_COMMUNITY_ACTIVITIES_APPLICATIONS_ADDED' , $applicationName); ?>
</div>
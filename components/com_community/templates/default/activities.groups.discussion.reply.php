<?php

$user = CFactory::getUser($this->act->actor);

// Setup event table
$group = $this->group;

// Load params
$param = new JRegistry($this->act->params);
$action = $param->get('action');
$actors = $param->get('actors');
$this->set('actors', $actors);

$discussion = JTable::getInstance('Discussion' , 'CTable' );
$discussion->load($act->cid);

$stream = new stdClass();
$stream->actor = $user;
$stream->target = null;
$stream->headline = '<a class="cStream-Author" href="' .CUrlHelper::userLink($user->id).'">'.$user->getDisplayName().'</a>'
		. JText::sprintf('COM_COMMUNITY_GROUPS_REPLY_DISCUSSION' , CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussion&groupid='.$discussion->groupid.'&topicid='.$discussion->id), $discussion->title );
$stream->message = "";
$stream->group = $group;
$stream->attachments = array();

$attachment = new stdClass();
$attachment->type = 'quote';
$attachment->message = $this->escape(JHTML::_('string.truncate', $this->act->content, $config->getInt('streamcontentlength'), true, false ));
$stream->attachments[] = $attachment;

$this->set('stream', $stream);
$this->load('activities.stream');

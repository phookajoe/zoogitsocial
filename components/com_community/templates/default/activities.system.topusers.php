<?php

$model		= CFactory::getModel( 'user' );
$members		= $model->getPopularMember( 10 );
$html    = '';

$this->set( 'members'    , $members );
//Get Template Page
// $tmpl   =	new CTemplate();
// $html   =	$tmpl	->set( 'members'    , $members )->set()
// 		->fetch( 'activity.members.popular' );
// OR, we can just display it here directly
//echo $html;

$this->load('activity.members.popular');
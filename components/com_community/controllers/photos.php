<?php
/**
 * @package     JomSocial
 * @subpackage  Controller
 * @copyright   (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class CommunityPhotosController extends CommunityBaseController
{
	public function regen()
	{
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		if (!COwnerHelper::isCommunityAdmin()) {
			$mainframe->redirect('index.php?option=com_community&view=frontpage');
		}

		$data 	= JRequest::get('post');
		$start 	= $jinput->get('startregen', 's', 'STRING'); //JRequest::getVar('startregen', 's');

		if (!empty($data) && $start == 's') {
			jimport('joomla.filesystem.file');

			$model = CFactory::getModel('photos');
			$photos = $model->getPhotoList($data);

			foreach ($photos as $pic) {
				//if( $photo->load( $pic->id ) )
				//{
				$srcPath = JPATH_ROOT .'/'. CString::str_ireplace(JPATH_ROOT .'/', '', $pic->image);
				$destPath = JPATH_ROOT .'/'. CString::str_ireplace(JPATH_ROOT .'/', '', $pic->thumbnail);

				if (JFile::exists($srcPath) && !JFile::exists($destPath)) {
					$info = getimagesize(JPATH_ROOT .'/'. $pic->image);
					$destType = image_type_to_mime_type($info[2]);

					CImageHelper::createThumb($srcPath, $destPath, $destType, 128, 128);
					$msg[] = "Regenerate thumbnails for " . $srcPath . '<br/>';
				} else {
					$originalPath = JPATH_ROOT .'/'. CString::str_ireplace(JPATH_ROOT .'/', '', $pic->original);

					if (JFile::exists($originalPath) && !JFile::exists($destPath)) {
						$info = getimagesize(JPATH_ROOT .'/'. $pic->original);
						$destType = image_type_to_mime_type($info[2]);

						CImageHelper::createThumb($originalPath, $destPath, $destType, 128, 128);

						$msg[] = "Regenerate thumbnails for " . $originalPath . '<br/>';
					} else {
						$msg[] = "cannot find image:" . $originalPath . '<br/>';
					}
				}
				// }
			}

			return;
		}

		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);

		echo $view->get(__FUNCTION__);
	}

	public function editPhotoWall($wallId)
	{


		$my = CFactory::getUser();

		$wall = JTable::getInstance('Wall', 'CTable');
		$wall->load($wallId);

		return $my->authorise('community.edit', 'photos.wall.' . $wallId, $wall);
	}

	public function ajaxSaveOrdering($ordering, $albumId)
	{
		$filter = JFilterInput::getInstance();
		$albumId = $filter->clean($albumId, 'int');
		// $ordering pending filter

		$my = CFactory::getUser();

		if ($my->id == 0) {
			return $this->ajaxBlockUnregister();
		}



		$objResponse = new JAXResponse();

		if (!$my->authorise('community.manage', 'photos.user.album.' . $albumId)) {
			$objResponse->addScriptCall('alert', JText::_('COM_COMMUNITY_ACCESS_DENIED'));
			return $objResponse->sendResponse();
		}

		$model = CFactory::getModel('photos');
		$ordering = explode('&', $ordering);
		$i = 0;
		$photos = array();

		for ($i = 0; $i < count($ordering); $i++) {
			$data = explode('=', $ordering[$i]);
			$photos[$data[1]] = $i;
		}

		$model->setOrdering($photos, $albumId);
		$objResponse->addScriptCall('void', 0);

		return $objResponse->sendResponse();
	}

	// Deprecated since 1.8.x
	public function jsonupload()
	{
		$this->upload();
	}

	private function _outputJSONText($hasError, $text, $thumbUrl = null, $albumId = null, $photoId = null)
	{
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;
		$nextUpload = $jinput->get->get('nextupload', '', 'STRING'); //JRequest::getVar('nextupload', '', 'GET');

		echo '{';

		if ($hasError) {
			echo '"error": "true",';
		}

		echo '"msg": "' . $text . '",';
		echo '"nextupload": "' . $nextUpload . '",';
		echo '"info": "' . $thumbUrl . "#" . $albumId . '",';
		echo '"photoId": "' . $photoId . '"';
		echo "}";
		exit;
	}

	private function _showUploadError($hasError, $message, $thumbUrl = null, $albumId = null, $photoId = null)
	{
		$this->_outputJSONText($hasError, $message, $thumbUrl, $albumId, $photoId);
	}

	private function _addActivity($command, $actor, $target, $title, $content, $app, $cid, $group, $event, $param = '', $permission)
	{


		$act = new stdClass();
		$act->cmd = $command;
		$act->actor = $actor;
		$act->target = $target;
		$act->title = $title;
		$act->content = $content;
		$act->app = $app;
		$act->cid = $cid;
		$act->access = $permission;

		$act->groupid = $group->id;
		$act->group_access = $group->approvals;

		// Not used here
		$act->eventid = null;
		$act->event_access = null;

		// Allow comment on the album
		$act->comment_type = $command;
		$act->comment_id = CActivities::COMMENT_SELF;

		// Allow like on the album
		$act->like_type = $command;
		$act->like_id = CActivities::LIKE_SELF;

		CActivityStream::add($act, $param);
	}

	/**
	 * Method to save new album or existing album
	 **/
	private function _saveAlbum($id = null, $albumName = '')
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('COM_COMMUNITY_INVALID_TOKEN'));
		$now = new JDate();

		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		// @rule: Only registered users are allowed to create groups.
		if ($this->blockUnregister()) {
			return;
		}

		$my = CFactory::getUser();
		$type = $jinput->request->get('type', PHOTOS_USER_TYPE, 'NONE');
		$mainframe = JFactory::getApplication();
		$config = CFactory::getConfig();

		// Load models, libraries



		$postData = ($albumName == '') ? JRequest::get('POST') : array('name' => $albumName);
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($id);
		$handler = $this->_getHandler($album);
		$handler->bindAlbum($album, $postData);

		// @rule: New album should not have any id's.
		if (is_null($id)) {
			$album->creator = $my->id;
		}

		$album->created = $now->toSql();
		$album->type = $handler->getType();

		$albumPath = $handler->getAlbumPath($album->id);
		$albumPath = CString::str_ireplace(JPATH_ROOT .'/', '', $albumPath);
		$albumPath = CString::str_ireplace('\\', '/', $albumPath);
		$album->path = $albumPath;

		// update permissions in activity streams as well
		$activityModel = CFactory::getModel('activities');
		$activityModel->updatePermission($album->permissions, null, $my->id, 'photos', $album->id);
		$activityModel->update(
			array('cid' => $album->id, 'app' => 'photos', 'actor' => $my->id),
			array('location' => $album->location));

		$appsLib = CAppPlugins::getInstance();
		$saveSuccess = $appsLib->triggerEvent('onFormSave', array('jsform-photos-newalbum'));

		if (empty($saveSuccess) || !in_array(false, $saveSuccess)) {
			$album->store();

			//Update inidividual Photos Permissions
			$photos = CFactory::getModel('photos');
			$photos->updatePermissionByAlbum($album->id, $album->permissions);

			//add notification: New group album is added
			if (is_null($id) && $album->groupid != 0) {

				$group = JTable::getInstance('Group', 'CTable');
				$group->load($album->groupid);

				$modelGroup =  $this->getModel('groups');
				$groupMembers = array();
				$groupMembers = $modelGroup->getMembersId($album->groupid, true);

				$params = new CParameter('');
				$params->set('albumName', $album->name);
				$params->set('group', $group->name);
				$params->set('group_url', 'index.php?option=com_community&view=groups&task=viewgroup&groupid=' . $group->id);
				$params->set('album', $album->name);
				$params->set('album_url', 'index.php?option=com_community&view=photos&task=album&albumid=' . $album->id . '&groupid=' . $group->id);
				$params->set('url', 'index.php?option=com_community&view=photos&task=album&albumid=' . $album->id . '&groupid=' . $group->id);
				CNotificationLibrary::add('groups_create_album', $my->id, $groupMembers, JText::sprintf('COM_COMMUNITY_GROUP_NEW_ALBUM_NOTIFICATION'), '', 'groups.album', $params);

			}
			return $album;
		}

		return false;
	}

	private function _storeOriginal($tmpPath, $destPath, $albumId = 0)
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.utilities.utility');

		// First we try to get the user object.
		$my = CFactory::getUser();
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		// Then test if the user id is still 0 as this might be
		// caused by the flash uploader.
		if ($my->id == 0) {
			$tokenId = $jinput->request->get('token', '', 'NONE'); //JRequest::getVar('token', '', 'REQUEST');
			$userId = $jinput->request->get('userid', '', 'NONE');  //JRequest::getInt('userid', '', 'REQUEST');

			$my = CFactory::getUserFromTokenId($tokenId, $userId);
		}
		$config = CFactory::getConfig();

		// @todo: We assume now that the config is using the relative path to the
		// default images folder in Joomla.
		// @todo:  this folder creation should really be in its own function
		$albumPath = ($albumId == 0) ? '' : '/' . $albumId;
		$originalPathFolder = JPATH_ROOT .'/'. $config->getString('photofolder') .'/'. JPath::clean($config->get('originalphotopath'));
		$originalPathFolder = $originalPathFolder .'/'. $my->id . $albumPath;

		if (!JFile::exists($originalPathFolder)) {
			JFolder::create($originalPathFolder, (int)octdec($config->get('folderpermissionsphoto')));
			JFile::copy(JPATH_ROOT .'/components/com_community/index.html', $originalPathFolder .'/index.html');
		}

		if (!JFile::copy($tmpPath, $destPath)) {
			JError::raiseWarning(21, JText::sprintf('COM_COMMUNITY_ERROR_MOVING_UPLOADED_FILE', $destPath));
		}
	}

	/**
	 * Allows user to link to the current photo as their profile picture
	 **/
	public function ajaxLinkToProfile($photoId)
	{
		$my = CFactory::getUser();
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');

		$response = new JAXResponse();

		$header = JText::_('COM_COMMUNITY_CHANGE_AVATAR');
		$message = '<form name="change-profile-picture" id="change-profile-picture" method="post" action="' . CRoute::_('index.php?option=com_community&view=profile&task=linkPhoto&userid=' . $my->id) . '">'
			. JText::_('COM_COMMUNITY_PHOTOS_SET_AVATAR_DESC')
			. '<input type="hidden" name="id" value="' . $photoId . '" />'
			. '</form>';

		$actions = '<button  class="button" onclick="joms.jQuery(\'#change-profile-picture\').submit()">' . JText::_('COM_COMMUNITY_YES') . '</button>';
		$actions .= '&nbsp;<button class="button" onclick="cWindowHide();">' . JText::_('COM_COMMUNITY_NO') . '</button>';

		$response->addAssign('cwin_logo', 'innerHTML', $header);
		$response->addScriptCall('cWindowAddContent', $message, $actions);

		return $response->sendResponse();
	}


	public function ajaxAddPhotoTag($photoId, $userId, $posX, $posY, $w, $h)
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');
		$userId = $filter->clean($userId, 'int');
		$posX = $filter->clean($posX, 'float');
		$posY = $filter->clean($posY, 'float');
		$w = $filter->clean($w, 'float');
		$h = $filter->clean($h, 'float');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$response = new JAXResponse();

		$my = CFactory::getUser();
		$photoModel = CFactory::getModel('photos');
		$tagging = new CPhotoTagging();

		$tag = new stdClass();
		$tag->photoId = $photoId;
		$tag->userId = $userId;
		$tag->posX = $posX;
		$tag->posY = $posY;
		$tag->width = $w;
		$tag->height = $h;

		$tagId = $tagging->addTag($tag);

		$jsonString = '{}';
		if ($tagId > 0)
		{
			$user = CFactory::getUser($userId);
			$isGroup = $photoModel->isGroupPhoto($photoId);
			$photo = $photoModel->getPhoto($photoId);

			$jsonString = '{'
				. 'id:' . $tagId . ','
				. 'photoId:' . $photoId . ','
				. 'userId:' . $userId . ','
				. 'displayName:\'' . addslashes($user->getDisplayName()) . '\','
				. 'profileUrl:\'' . CRoute::_('index.php?option=com_community&view=profile&userid=' . $userId, false) . '\','
				. 'top:' . $posX . ','
				. 'left:' . $posY . ','
				. 'width:' . $w . ','
				. 'height:' . $h . ','
				. 'canRemove:true'
				. '}';

			// jQuery call to update photo tagged list.
			$response->addScriptCall('joms.gallery.createPhotoTag', $jsonString);
			$response->addScriptCall('joms.gallery.createPhotoTextTag', $jsonString);
			$response->addScriptCall('cWindowHide');
			$response->addScriptCall('joms.gallery.cancelNewPhotoTag');


			//send notification emails
			$albumId = $photo->albumid;
			$photoCreator = $photo->creator;
			$url = '';
			$album = JTable::getInstance('Album', 'CTable');
			$album->load($albumId);

			$handler = $this->_getHandler($album);
			$url = $photo->getRawPhotoURI();

			if ($my->id != $userId) {
				// Add notification


				$params = new CParameter('');
				$params->set('url', $url);
				$params->set('photo', JText::_('COM_COMMUNITY_SINGULAR_PHOTO'));
				$params->set('photo_url', $url);

				CNotificationLibrary::add('photos_tagging', $my->id, $userId, JText::sprintf('COM_COMMUNITY_SOMEONE_TAG_YOU'), '', 'photos.tagging', $params);
			}

		} else {
			$html = $tagging->getError();
			$actions = '<button class="button" onclick="cWindowHide();joms.gallery.cancelNewPhotoTag();" name="close">' . JText::_('COM_COMMUNITY_BUTTON_CLOSE_BUTTON') . '</button>';

			//remove the existing cwindow (for friend selection)
			$response->addScriptCall('joms.jQuery(\'#cWindow\').remove();');

			//recreate the warning cwindow
			$response->addScriptCall('cWindowShow', '', JText::_('COM_COMMUNITY_NOTICE'), 450, 200, 'warning');
			$response->addScriptCall('cWindowAddContent', $html, $actions);
		}

		return $response->sendResponse();
	}

	public function ajaxRemovePhotoTag($photoId, $userId)
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');
		$userId = $filter->clean($userId, 'int');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$my = CFactory::getUser();
		$response = new JAXResponse();

		$taggedUser = CFactory::getUser($userId);

		if (!$my->authorise('community.remove', 'photos.tag.' . $photoId, $taggedUser)) {
			$response->addScriptCall('alert', JText::_('ACCESS FORBIDDEN'));
			return $response->sendResponse();
		}


		$tagging = new CPhotoTagging();

		if (!$tagging->removeTag($photoId, $userId)) {
			$html = $tagging->getError();

			$response->addScriptCall('cWindowShow', '', JText::_('COM_COMMUNITY_NOTICE'), 450, 200, 'warning');
			$reponse->addAssign('cWindowAddContent', $html);
		}

		return $response->sendResponse();
	}

	/**
	 *     Deprecated since 2.0.x
	 *     Use ajaxSwitchPhotoTrigger instead.
	 **/
	public function ajaxDisplayCreator($photoid)
	{
		$filter = JFilterInput::getInstance();
		$photoid = $filter->clean($photoid, 'int');

		$response = new JAXResponse();

		// Load the default photo

		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoid);

		$photoCreator = CFactory::getUser($photo->creator);

		$html = JText::sprintf('COM_COMMUNITY_UPLOADED_BY', CRoute::_('index.php?option=com_community&view=profile&userid=' . $photoCreator->id), $photoCreator->getDisplayName());
		$response->addAssign('uploadedBy', 'innerHTML', $html);

		return $response->sendResponse();
	}

	public function ajaxRemoveFeatured($albumId)
	{
		$filter = JFilterInput::getInstance();
		$albumId = $filter->clean($albumId, 'int');

		$objResponse = new JAXResponse();


		$my = CFactory::getUser();
		if ($my->id == 0) {
			return $this->ajaxBlockUnregister();
		}

		if (COwnerHelper::isCommunityAdmin()) {
			$model = CFactory::getModel('Featured');


			$featured = new CFeatured(FEATURED_ALBUMS);

			if ($featured->delete($albumId)) {
				$html = JText::_('COM_COMMUNITY_PHOTOS_ALBUM_REMOVED_FROM_FEATURED');
			} else {
				$html = JText::_('COM_COMMUNITY_REMOVING_ALBUM_FROM_FEATURED_ERROR');
			}
		} else {
			$html = JText::_('COM_COMMUNITY_NOT_ALLOWED_TO_ACCESS_SECTION');
		}

		$actions = '<input type="button" class="button" onclick="window.location.reload();" value="' . JText::_('COM_COMMUNITY_BUTTON_CLOSE_BUTTON') . '"/>';

		$objResponse->addScriptCall('cWindowAddContent', $html, $actions);

		return $objResponse->sendResponse();
	}

	public function ajaxAddFeatured($albumId)
	{
		$filter = JFilterInput::getInstance();
		$albumId = $filter->clean($albumId, 'int');

		$objResponse = new JAXResponse();

		$my = CFactory::getUser();

		if ($my->id == 0)
		{
			return $this->ajaxBlockUnregister();
		}

		if (COwnerHelper::isCommunityAdmin())
		{
			$model = CFactory::getModel('Featured');

			if (!$model->isExists(FEATURED_ALBUMS, $albumId))
			{


				$featured = new CFeatured(FEATURED_ALBUMS);
				$featured->add($albumId, $my->id);

				$table = JTable::getInstance('Album', 'CTable');
				$table->load($albumId);

				$html = JText::sprintf('COM_COMMUNITY_ALBUM_IS_FEATURED', $table->name);
			}
			else
			{
				$html = JText::_('COM_COMMUNITY_PHOTOS_ALBUM_ALREADY_FEATURED');
			}
		} else {
			$html = JText::_('COM_COMMUNITY_NOT_ALLOWED_TO_ACCESS_SECTION');
		}

		$actions = '<input type="button" class="button" onclick="window.location.reload();" value="' . JText::_('COM_COMMUNITY_BUTTON_CLOSE_BUTTON') . '"/>';

		$objResponse->addScriptCall('cWindowAddContent', $html, $actions);

		return $objResponse->sendResponse();
	}

	/**
	 * Method is called from the reporting library. Function calls should be
	 * registered here.
	 *
	 * return    String    Message that will be displayed to user upon submission.
	 **/
	public function reportPhoto($link, $message, $id)
	{

		$report = new CReportingLibrary();
		$config = CFactory::getConfig();
		$my = CFactory::getUser();

		if (!$config->get('enablereporting') || (($my->id == 0) && (!$config->get('enableguestreporting')))) {
			return '';
		}

		// Pass the link and the reported message
		$report->createReport(JText::_('COM_COMMUNITY_BAD_PHOTO'), $link, $message);

		// Add the action that needs to be called.
		$action = new stdClass();
		$action->label = 'COM_COMMUNITY_PHOTOS_UNPUBLISH';
		$action->method = 'photos,unpublishPhoto';
		$action->parameters = $id;
		$action->defaultAction = true;

		$report->addActions(array($action));

		return JText::_('COM_COMMUNITY_REPORT_SUBMITTED');
	}

	public function unpublishPhoto($photoId)
	{
		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);
		$photo->publish(null, 0);

		return JText::_('COM_COMMUNITY_PHOTOS_UNPUBLISHED');
	}

	/**
	 * Deprecated since 1.8.x
	 **/
	public function deletePhoto($photoId)
	{
// 		if ($this->blockUnregister()) return;
//
// 		$photo	= JTable::getInstance( 'Photo' , 'CTable' );
// 		$photo->load( $photoId );
// 		$photo->delete();
//
//
// 		$album = JTable::getInstance( 'Album' , 'CTable' );
// 		$album->load( $photo->albumId );
//
// 		// @todo: delete 1 particular activity
// 		// since we cannot identify any one activity (activity only store album id)
// 		// just delete 1 activity with a matching album id
// 		$actModel = CFactory::getModel('activities');
// 		$actModel->removeOneActivity('photos' , $album->id );
//
// 		return JText::_('COM_COMMUNITY_PHOTO_DELETED');
	}

	/**
	 * confirmation set default photo
	 **/
	public function ajaxConfirmDefaultPhoto($albumId, $photoId)
	{
		$my = CFactory::getUser();
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');

		$response = new JAXResponse();

		$header = JText::_('COM_COMMUNITY_PHOTOS_SET_AS_ALBUM_COVER');
		$message = '<form name="set-default-photo" id="set-default-photo" method="post" action="' . CRoute::_('index.php?option=com_community&view=photos&task=ajaxSetDefaultPhoto&userid=' . $my->id) . '">'
			. JText::_('COM_COMMUNITY_SET_PHOTO_AS_DEFAULT_DIALOG')
			. '<input type="hidden" name="photoid" value="' . $photoId . '" />'
			. '<input type="hidden" name="albumid" value="' . $albumId . '" />'
			. '</form>';

		$actions = '<button  class="button" onclick="jax.call(\'community\', \'photos,ajaxSetDefaultPhoto\', '.$albumId.','.$photoId.');cWindowHide();">' . JText::_('COM_COMMUNITY_YES') . '</button>';
		$actions .= '&nbsp;<button class="button" onclick="cWindowHide();">' . JText::_('COM_COMMUNITY_NO') . '</button>';

		$response->addAssign('cwin_logo', 'innerHTML', $header);
		$response->addScriptCall('cWindowAddContent', $message, $actions);

		return $response->sendResponse();
	}

	public function ajaxSetDefaultPhoto($albumId, $photoId)
	{
		$filter = JFilterInput::getInstance();
		$albumId = $filter->clean($albumId, 'int');
		$photoId = $filter->clean($photoId, 'int');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$response = new JAXResponse();



		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);
		$model = CFactory::getModel('Photos');
		$my = CFactory::getUser();
		$photo = $model->getPhoto($photoId);
		$handler = $this->_getHandler($album);

		if (!$handler->hasPermission($albumId)) {
			$message = JText::_('COM_COMMUNITY_PERMISSION_DENIED_WARNING');
		}else{
			$model->setDefaultImage($albumId, $photoId);
			$message = JText::_('COM_COMMUNITY_PHOTOS_IS_NOW_ALBUM_DEFAULT');


		}

		/*
		$header = JText::_('COM_COMMUNITY_PHOTOS_SET_AS_ALBUM_COVER');
		$actions .= '<button class="button" onclick="cWindowHide();">' . JText::_('COM_COMMUNITY_BUTTON_CLOSE_BUTTON') . '</button>';

		$response->addAssign('cwin_logo', 'innerHTML', $header);*/
		$response->addScriptCall('cWindowAddContent', $message);



		return $response->sendResponse();
	}

	/**
	 * Ajax method to display remove an album notice
	 *
	 * @param $id    Album id
	 **/
	public function ajaxRemoveAlbum($id, $currentTask)
	{
		$filter = JFilterInput::getInstance();
		$id = $filter->clean($id, 'int');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$response = new JAXResponse();

		// Load models / libraries

		$my = CFactory::getUser();
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($id);

		$content = '<div>';
		$content .= JText::sprintf('COM_COMMUNITY_PHOTOS_CONFIRM_REMOVE_ALBUM', $album->name);
		$content .= '</div>';

		$actions = '<form name="jsform-photos-ajaxRemoveAlbum" method="post" action="' . CRoute::_('index.php?option=com_community&view=photos&task=removealbum') . '">';
		$actions .= '<input type="submit" value="' . JText::_('COM_COMMUNITY_YES_BUTTON') . '" class="button" name="Submit"/>';
		$actions .= '<input type="hidden" value="' . $album->id . '" name="albumid" />';
		$actions .= '<input type="hidden" value="' . $currentTask . '" name="currentTask" />';
		$actions .= '&nbsp;';
		$actions .= '<input onclick="cWindowHide();" type="button" value="' . JText::_('COM_COMMUNITY_NO_BUTTON') . '" class="button" />';
		$actions .= JHTML::_('form.token');
		$actions .= '</form>';

		$response->addScriptCall('cWindowAddContent', $content, $actions);

		return $response->sendResponse();
	}

	public function ajaxConfirmRemovePhoto($photoId, $action = '', $updatePlayList = 1)
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');

		$response = new JAXResponse();



		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$model = CFactory::getModel('photos');
		$my = JFactory::getUser();
		$photo = $model->getPhoto($photoId);

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);
		$handler = $this->_getHandler($album);

		if (!$handler->hasPermission($album->id)) {
			$response->addScriptCall('alert', JText::_('COM_COMMUNITY_PERMISSION_DENIED_WARNING'));
			$response->sendResponse();
		}

		$html = JText::sprintf('COM_COMMUNITY_REMOVE_PHOTO_DIALOG', $photo->caption);

		$actions = '<button  class="button" onclick="joms.gallery.removePhoto(\'' . $photoId . '\',\'' . $action . '\',\'' . $updatePlayList . '\');">' . JText::_('COM_COMMUNITY_YES_BUTTON') . '</button>';

		$actions .= '&nbsp;<button class="button" onclick="cWindowHide();return false;">' . JText::_('COM_COMMUNITY_NO_BUTTON') . '</button>';

		$response->addAssign('cwin_logo', 'innerHTML', JText::_('COM_COMMUNITY_PHOTOS_REMOVE_PHOTO_BUTTON'));
		$response->addScriptCall('cWindowAddContent', $html, $actions);

		return $response->sendResponse();
	}

	public function ajaxRemovePhoto($photoId, $action = '')
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');


		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$response = new JAXResponse();

		$model = CFactory::getModel('photos');
		$my = JFactory::getUser();
		$photo = $model->getPhoto($photoId);

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);
		$handler = $this->_getHandler($album);

		if (!$handler->hasPermission($album->id)) {
			$actions = '<button class="button" onclick="cWindowHide();">' . JText::_('COM_COMMUNITY_BUTTON_CLOSE_BUTTON') . '</button>';
			$response->addScriptCall('cWindowAddContent', JText::_('COM_COMMUNITY_PERMISSION_DENIED_WARNING'), $actions);
			$response->sendResponse();
		}


		$appsLib = CAppPlugins::getInstance();
		$appsLib->loadApplications();

		$params = array();
		$params[] = $photo;

		$appsLib->triggerEvent('onBeforePhotoDelete', $params);
		$photo->delete();
		$appsLib->triggerEvent('onAfterPhotoDelete', $params);

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);

		//add user points

		CUserPoints::assignPoint('photo.remove');

		if (empty($action)) {
			$response->addScriptCall('window.location.reload');
		} else {
			$response->addScriptCall($action);
			$response->addScriptCall('joms.photos.photoSlider.removeThumb("'.$photoId.'");');
			$response->addScriptCall('jax.doneLoadingFunction();');
		}

		$this->cacheClean(array(COMMUNITY_CACHE_TAG_FRONTPAGE, COMMUNITY_CACHE_TAG_ACTIVITIES));

		return $response->sendResponse();
	}

	/**
	 * Populate the wall area in photos with wall/comments content
	 */
	public function showWallContents($photoId)
	{
		// Include necessary libraries



		$my = CFactory::getUser();
		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);

		//@todo: Add limit
		$limit = 20;

		if ($photo->id == '0') {
			echo JText::_('COM_COMMUNITY_PHOTOS_INVALID_PHOTO_ID');
			return;
		}


		$contents = CWallLibrary::getWallContents('photos', $photoId, ($my->id == $photo->creator || COwnerHelper::isCommunityAdmin()), $limit, 0, 'wall.content', 'photos,photo');


		$contents = CStringHelper::replaceThumbnails($contents);

		return $contents;
	}

	/**
	 * Ajax method to save the caption of a photo
	 *
	 * @param    int $photoId    The photo id
	 * @param    string $caption    The caption of the photo
	 **/
	public function ajaxSaveCaption($photoId, $caption, $needAddScript = true)
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');
		$caption = $filter->clean($caption, 'string');

		if (!COwnerHelper::isRegisteredUser()) return $this->ajaxBlockUnregister();

		$response = new JAXResponse();


		$my = CFactory::getUser();
		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);

		$handler = $this->_getHandler($album);

		if ($photo->id == '0') {
			// user shouldnt call this at all or reach here at all
			$response->addScriptCall('alert', JText::_('COM_COMMUNITY_PHOTOS_INVALID_PHOTO_ID'));
			return $response->sendResponse();
		}


		if (!$handler->hasPermission($album->id)) {
			$response->addScriptCall('alert', JText::_('COM_COMMUNITY_PHOTOS_NOT_ALLOWED_EDIT_CAPTION_ERROR'));
			return $response->sendResponse();
		}

		$photo->caption = $caption;
		$photo->store();

		if ($needAddScript === true) {
			$response->addScriptCall('joms.gallery.updatePhotoCaption', $photo->id, $photo->caption);
		}

		return $response->sendResponse();
	}


	/**
	 * Since 2.4
	 * Ajax method to save the album description
	 *
	 * @param    int $albumId    The album id
	 * @param    string $description    The album description to save
	 * @param    boolean $needAddScript If true then will update textarea in web browser
	 **/
	public function ajaxSaveAlbumDesc($albumId, $description, $needAddScript = true)
	{
		$filter = JFilterInput::getInstance();
		$albumid = $filter->clean($albumId, 'int');
		$description = $filter->clean($description, 'string');

		if (!COwnerHelper::isRegisteredUser()) return $this->ajaxBlockUnregister();

		$response = new JAXResponse();


		$my = CFactory::getUser();
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumid);

		$handler = $this->_getHandler($album);


		if (!$handler->hasPermission($album->id)) {
			$response->addScriptCall('alert', JText::_('COM_COMMUNITY_PHOTOS_NOT_ALLOWED_EDIT_ALBUM_DESC_ERROR'));
			return $response->sendResponse();
		}

		$album->description = $description;
		$album->store();

		if ($needAddScript === true) {
			$response->addScriptCall('joms.jQuery(".community-photo-desc-editable").val', $album->description);
		}

		return $response->sendResponse();
	}

	/**
	 * Trigger any necessary items that needs to be changed when the photo
	 * is changed.
	 **/
	public function ajaxSwitchPhotoTrigger($photoId)
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');

		$response = new JAXResponse();

		// Load the default photo

		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);
		$my = CFactory::getUser();
		$config = CFactory::getConfig();

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);

		// Since the only way for us to get the id is through the AJAX call,
		// we can only increment the hit when the ajax loads
		$photo->hit();

		// Update the hits each time the photo is switched
		$response->addAssign('photo-hits', 'innerHTML', $photo->hits);

		// Show creator
		$creator = CFactory::getUser($photo->creator);
		$creatorHTML = JText::sprintf('COM_COMMUNITY_UPLOADED_BY', CRoute::_('index.php?option=com_community&view=profile&userid=' . $creator->id), $creator->getDisplayName());
		$response->addAssign('uploadedBy', 'innerHTML', $creatorHTML);

		// Get the wall form
		$wallInput = $this->_getWallFormHTML($photoId);

		$response->addAssign('community-photo-walls', 'innerHTML', $wallInput);

		// Get the wall contents
		$wallContents = '';
		$wallContents = $this->showWallContents($photoId);
		$response->addAssign('wallContent', 'innerHTML', $wallContents);
		$response->addScriptCall("joms.utils.textAreaWidth('#wall-message');");

		//$photo		= JTable::getInstance( 'Photo' , 'CTable' );
		//$photo->load( $photoId );

		// When a photo is navigated, the sharing should also be updated.

		$bookmarks = new CBookmarks($photo->getPhotoLink(true));

		// Get the reporting data

		$report = new CReportingLibrary();

		// Add tagging code
		/*
		$tagsHTML = '';
		if($config->get('tags_photos')){

			$tags = new CTags();
			// @todo: permission checking might be wrong here
			$tagsHTML = $tags->getHTML('photos', $photoId, $photo->creator == $my->id || COwnerHelper::isCommunityAdmin());
		}*/

		$reportHTML = $report->getReportingHTML(JText::_('COM_COMMUNITY_REPORT_BAD_PHOTO'), 'photos,reportPhoto', array($photoId));
		// $response->addAssign('tag-photo', 'innerHTML', $tagsHTML);
		$response->addScriptCall('joms.gallery.updatePhotoReport', $reportHTML);
		$response->addScriptCall('joms.gallery.updatePhotoBookmarks', $bookmarks->getHTML());
		$response->addScriptCall('joms.jQuery("body").focus();');
		$response->addScriptCall('joms.gallery.bindFocus();');

		// Get the likes / dislikes item

		$like = new CLike();
		$likeHTML = $like->getHTML('photo', $photoId, $my->id);
		$response->addScriptCall('__callback', $likeHTML);

		return $response->sendResponse();
	}

	public function ajaxUpdateCounter($albumId)
	{
		$filter = JFilterInput::getInstance();
		$albumId = $filter->clean($albumId, 'int');

		$response = new JAXResponse();

		$model = CFactory::getModel('photos');
		$my = CFactory::getUser();
		$config = CFactory::getConfig();


		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$groupId = $album->groupid;

		if (!empty($groupId)) {
			$photoUploaded = $model->getPhotosCount($groupId, PHOTOS_GROUP_TYPE);
			$photoUploadLimit = $config->get('groupphotouploadlimit');
		} else {
			$photoUploaded = $model->getPhotosCount($my->id, PHOTOS_USER_TYPE);
			$photoUploadLimit = $config->get('photouploadlimit');
		}
		if ($photoUploaded / $photoUploadLimit >= COMMUNITY_SHOW_LIMIT) {
			$response->addScriptCall('joms.jQuery("#photoUploadedCounter").html("' . JText::sprintf('COM_COMMUNITY_UPLOAD_LIMIT_STATUS', $photoUploaded, $photoUploadLimit) . '")');
		}

		//  update again the photo count
		$album->store();

		return $response->sendResponse();
	}

	/**
	 * Get Album URL and Reload Browser to Album page
	 */
	public function ajaxGetAlbumURL($albumId, $groupId = '')
	{
		$my = CFactory::getUser();
		$groupURL = "";
		if (!empty($groupId)) {
			$groupURL = "&groupid=" . $groupId;
		}else{
			$groupURL = "&userid=".$my->id;
		}
		$albumURL = CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $albumId . '' . $groupURL, false);

		$objResponse = new JAXResponse();

		$objResponse->addScriptCall("joms.photos.multiUpload.goToAlbum", $albumURL);
		return $objResponse->sendResponse();
	}

	/**
	 * Goto Conventional Photo Upload Page if browser only supports html4
	 */
	public function ajaxGotoOldUpload($albumId, $groupId = '')
	{
		$my = CFactory::getUser();
		$albumURL = CRoute::_('index.php?option=com_community&view=photos&task=uploader&userid=' . $my->id, false);

		if ($groupId != '') {
			$albumURL = CRoute::_('index.php?option=com_community&view=photos&task=uploader&groupid=' . $groupId . '&albumid=' . $albumId, false);
		}

		$msg = JText::_('COM_COMMUNITY_PHOTOS_STATUS_BROWSER_NOT_SUPPORTED_ERROR');
		$action = '<script type="text/javascript">joms.jQuery("#cwin_close_btn").click(function() { joms.photos.multiUpload.goToOldUpload(\'' . $albumURL . '\') });</script><button class="button" onclick="joms.photos.multiUpload.goToOldUpload(\'' . $albumURL . '\')">' . JText::_('COM_COMMUNITY_OK_BUTTON') . '</button>';
		$objResponse = new JAXResponse();
		$objResponse->addScriptCall("cWindowAddContent", $msg, $action);
		//$objResponse->addScriptCall("joms.photos.multiUpload.goToOldUpload", $msg, $albumURL);

		return $objResponse->sendResponse();
	}

	/**
	 * Create new album for the photos
	 **/
	public function ajaxCreateAlbum($albumName, $groupId)
	{
		if ($this->blockUnregister()) {
			return;
		}

		$my = CFactory::getUser();
		$now = new JDate();


		// Get default album or create one
		$model = CFactory::getModel('photos');
		$objResponse = new JAXResponse();

		if ($albumName == '') {
			$album = $model->getDefaultAlbum($my->id);
			$newAlbum = false;

			if (empty($album)) {
				$album = JTable::getInstance('Album', 'CTable');
				$album->load();

				$handler = $this->_getHandler($album);

				$newAlbum = true;
				$album->creator = $my->id;
				$album->created = $now->toSql();
				$album->name = JText::sprintf('COM_COMMUNITY_DEFAULT_ALBUM_CAPTION', $my->getDisplayName());
				$album->type = $handler->getType();
				$album->default = '1';

				$albumPath = $handler->getAlbumPath($album->id);
				$albumPath = CString::str_ireplace(JPATH_ROOT .'/', '', $albumPath);
				$albumPath = CString::str_ireplace('\\', '/', $albumPath);
				$album->path = $albumPath;

				$album->store();
				$objResponse->addScriptCall('joms.photos.multiUpload.assignNewAlbum', $album->id, $album->name);
			} else {
				$objResponse->addScriptCall('joms.photos.multiUpload.assignNewAlbum', $album->id);
			}

			//$objResponse->addScriptCall( 'joms.photos.multiUpload.startUploading', $album->id );
		} else {

			$album = JTable::getInstance('Album', 'CTable');
			$handler = $this->_getHandler($album);

			$group = JTable::getInstance('Group', 'CTable');
			$group->load($groupId);

			JRequest::setVar('groupid', $group->id);

			// Check if the current user is banned from this group
			$isBanned = $group->isBanned($my->id);

			if (!$handler->isAllowedAlbumCreation() || $isBanned) {
				$objResponse->addAlert('Not Allowed to Create Album');
				$objResponse->addScriptCall('joms.photos.multiUpload.stopUploading');
			}


			$mainframe = JFactory::getApplication();


			if (empty($albumName)) {
				$objResponse->addAlert(JText::_('COM_COMMUNITY_ALBUM_NAME_REQUIRED'));
				$objResponse->addScriptCall('joms.photos.multiUpload.stopUploading');
			} else {
				$album = $this->_saveAlbum(null, $albumName);

				// Added to verify is save operation performed successfully or not
				if ($album === false) {
					$objResponse->addAlert(JText::_('COM_COMMUNITY_PHOTOS_STATUS_UNABLE_SAVE_ALBUM_ERROR'));
					$objResponse->addScriptCall('joms.photos.multiUpload.stopUploading');
				}

				//add user points

				CUserPoints::assignPoint('album.create');

				$objResponse->addScriptCall('joms.photos.multiUpload.assignNewAlbum', $album->id, $albumName);
				//$objResponse->addScriptCall( 'joms.photos.multiUpload.startUploading', $album->id );
			}
		}

		return $objResponse->sendResponse();
	}

	/**
	 * return the content of the popup when a user hover the mouse on album
	 */
	public function ajaxShowThumbnail($albumId = '')
	{
		$objResponse = new JAXResponse();
		$objPhoto = CFactory::getModel('photos');
		$selectedAlbum = $albumId;

		$dataThumbnails = $objPhoto->getPhotos($selectedAlbum, 5, 0, false);
		if (count($dataThumbnails) > 0) {
			$tmpl = new CTemplate();
			$html = $tmpl
				->set('thumbnails', $dataThumbnails)
				->fetch('photos.minitipThumbnail');
		} else {
			$html = JTEXT::_('COM_COMMUNITY_PHOTOS_NO_PHOTOS_UPLOADED');
		}

		$objResponse->addScriptCall('joms.tooltips.addMinitipContent', $html);
		return $objResponse->sendResponse();
	}

	/**
	 * Photo Upload Popup
	 */
	public function ajaxUploadPhoto($albumId = '', $groupId = '')
	{
		$my = CFactory::getUser();
		$objPhoto = CFactory::getModel('photos');

		if (empty($groupId)  || $groupId == 'undefined') {
			$dataAlbums = $objPhoto->getAlbums($my->id);
		} else {
			$dataAlbums = $objPhoto->getGroupAlbums($groupId);
		}

		$selectedAlbum = $albumId;
		$preMessage = '';
		if (CLimitsLibrary::exceedDaily('photos', $my->id)) {
			$preMessage = JText::_('COM_COMMUNITY_PHOTOS_LIMIT_PERDAY_REACHED');
			$disableUpload = true;
		} else {
			$preMessage = JText::_('COM_COMMUNITY_PHOTOS_DEFAULT_UPLOAD_NOTICE');
			$disableUpload = false;
		}

		$config = CFactory::getConfig();
		$maxFileSize = $config->get('maxuploadsize') . 'mb';

		$objResponse = new JAXResponse();
		$tmpl = new CTemplate();
		$html = $tmpl
			->set('my', $my)
			->set('allAlbums', $dataAlbums)
			->set('preMessage', $preMessage)
			->set('disableUpload', $disableUpload)
			->set('selectedAlbum', $selectedAlbum)
			->set('groupId', $groupId)
			->set('maxFileSize', $maxFileSize)
			->fetch('photos.htmlmultiuploader');

		$label = array(
			'filename' => JText::_("COM_COMMUNITY_PHOTOS_MULTIUPLOAD_FILENAME"),
			'size' => JText::_("COM_COMMUNITY_PHOTOS_MULTIUPLOAD_SIZE"),
			'status' => JText::_("COM_COMMUNITY_PHOTOS_MULTIUPLOAD_STATUS"),
			'filedrag' => JText::_("COM_COMMUNITY_PHOTOS_MULTIUPLOAD_DRAG_FILES"),
			'addfiles' => JText::_("COM_COMMUNITY_PHOTOS_MULTIUPLOAD_ADD_FILES"),
			'startupload' => JText::_("COM_COMMUNITY_PHOTOS_MULTIUPLOAD_START_UPLOAD"),
			'invalidfiletype' => JText::_("COM_COMMUNITY_PHOTOS_INVALID_FILE_ERROR"),
			'exceedfilesize' => JText::_("COM_COMMUNITY_VIDEOS_IMAGE_FILE_SIZE_EXCEEDED"),
			'stopupload' => JText::_("COM_COMMUNITY_PHOTOS_MULTIUPLOAD_STOP_UPLOAD")
		);

		$label = json_encode($label);

		$objResponse->addAssign('cwin_logo', 'innerHTML', JText::_('COM_COMMUNITY_PHOTOS_UPLOAD_PHOTOS'));
		$objResponse->addScriptCall('joms.photos.multiUpload.updateLabel', $label);

		$objResponse->addScriptCall('cWindowAddContent', $html);
		return $objResponse->sendResponse();
	}

	/**
	 * Photo Likes
	 */
	public function ajaxShowPhotoFeatured($photoId, $albumId)
	{
		$my = CFactory::getUser();
		$objResponse = new JAXResponse();

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);
		// Get wall count

		$wallCount = CWallLibrary::getWallCount('albums', $album->id);
		// Get photo link
		$photoCommentLink = CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $album->id . '&groupid=' . $album->groupid . '&userid=' . $album->creator . '#comments');

		$commentCountText = JText::_('COM_COMMUNITY_COMMENT');

		if ($wallCount > 1) {
			$commentCountText = JText::_('COM_COMMUNITY_COMMENTS');
		}


		// Get like

		$likes = new CLike();
		$likesHTML = $likes->getHTML('photo', $photoId, $my->id);
		$objResponse->addScriptCall('updateGallery', $photoId, $likesHTML, $wallCount, $photoCommentLink, $commentCountText);
		$objResponse->sendResponse();
	}

	/**
	 * This method is an AJAX call that displays the walls form
	 *
	 * @param    photoId    int The current photo id that is being browsed.
	 *
	 * returns
	 **/
	private function _getWallFormHTML($photoId)
	{
		// Include necessary libraries
		require_once(JPATH_COMPONENT .'/libraries/wall.php');

		// Include helper
		require_once(JPATH_COMPONENT .'/helpers/friends.php');

		// Load up required objects.
		$my = CFactory::getUser();
		$friendsModel = CFactory::getModel('friends');
		$config = CFactory::getConfig();
		$html = '';

		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);




		$handler = $this->_getHandler($album);

		if ($handler->isWallsAllowed($photoId)) {
			$html .= CWallLibrary::getWallInputForm($photoId, 'photos,ajaxSaveWall', 'photos,ajaxRemoveWall');
		}

		return $html;
	}

	public function ajaxRemoveWall($wallId)
	{
		require_once(JPATH_COMPONENT .'/libraries/activities.php');

		$filter = JFilterInput::getInstance();
		$wallId = $filter->clean($wallId, 'int');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$response = new JAXResponse();

		$wallsModel =  $this->getModel('wall');
		$wall = $wallsModel->get($wallId);
		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($wall->contentid);
		$my = CFactory::getUser();

		if ($my->id == $photo->creator || COwnerHelper::isCommunityAdmin()) {
			if ($wallsModel->deletePost($wallId)) {
				CActivities::removeWallActivities(array('app' => 'photos', 'cid' => $wall->contentid, 'createdAfter' => $wall->date), $wallId);

				//add user points
				if ($wall->post_by != 0) {

					CUserPoints::assignPoint('wall.remove', $wall->post_by);
				}
			} else {
				$response->addAlert(JText::_('COM_COMMUNITY_GROUPS_REMOVE_WALL_ERROR'));
			}
		} else {
			$response->addAlert(JText::_('COM_COMMUNITY_GROUPS_REMOVE_WALL_ERROR'));
		}
		$this->cacheClean(array(COMMUNITY_CACHE_TAG_ACTIVITIES));
		return $response->sendResponse();
	}

	public function ajaxAlbumRemoveWall($wallId)
	{
		require_once(JPATH_COMPONENT .'/libraries/activities.php');

		$filter = JFilterInput::getInstance();
		$wallId = $filter->clean($wallId, 'int');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}
		$response = new JAXResponse();

		$wallsModel =  $this->getModel('wall');
		$wall = $wallsModel->get($wallId);
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($wall->contentid);
		$my = CFactory::getUser();

		if ($my->id == $album->creator || COwnerHelper::isCommunityAdmin()) {
			if (!$wallsModel->deletePost($wallId)) {
				$response->addAlert(JText::_('COM_COMMUNITY_GROUPS_REMOVE_WALL_ERROR'));
			} else {
				CActivities::removeWallActivities(array('app' => 'albums', 'cid' => $wall->contentid, 'createdAfter' => $wall->date), $wallId);
			}
		} else {
			$response->addAlert(JText::_('COM_COMMUNITY_GROUPS_REMOVE_WALL_ERROR'));
		}
		return $response->sendResponse();
	}

	public function editalbumWall()
	{

	}

	/**
	 * Ajax function to save a new wall entry
	 *
	 * @param message    A message that is submitted by the user
	 * @param uniqueId    The unique id for this group
	 *
	 **/
	public function ajaxAlbumSaveWall($message, $uniqueId, $appId = null)
	{
		$filter = JFilterInput::getInstance();
		//$message = $filter->clean($message, 'string');
		$uniqueId = $filter->clean($uniqueId, 'int');
		$appId = $filter->clean($appId, 'int');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}
		$response = new JAXResponse();
		$my = CFactory::getUser();
		$config = CFactory::getConfig();
		//$message		= strip_tags( $message );

		//Load Libs







		$album = JTable::getInstance('Album', 'CTable');
		$album->load($uniqueId);

		$handler = $this->_getHandler($album);

		// If the content is false, the message might be empty.
		if (empty($message)) {
			$response->addAlert(JText::_('COM_COMMUNITY_WALL_EMPTY_MESSAGE'));
		} else {
			if ($config->get('antispam_akismet_walls')) {


				$filter = CSpamFilter::getFilter();
				$filter->setAuthor($my->getDisplayName());
				$filter->setMessage($message);
				$filter->setEmail($my->email);
				$filter->setURL(CRoute::_('index.php?option=com_community&view=photos&task=photo&albumid=' . $album->id));
				$filter->setType('message');
				$filter->setIP($_SERVER['REMOTE_ADDR']);

				if ($filter->isSpam()) {
					$response->addAlert(JText::_('COM_COMMUNITY_WALLS_MARKED_SPAM'));
					return $response->sendResponse();
				}
			}

			$wall = CWallLibrary::saveWall($uniqueId, $message, 'albums', $my, ($my->id == $album->creator), 'photos,album');
			$param = new CParameter('');
			$url = $handler->getAlbumURI($album->id, false);
			$param->set('photoid', $uniqueId);
			$param->set('action', 'wall');
			$param->set('wallid', $wall->id);
			$param->set('url', $url);

			// Get the album type
			$app = $album->type;

			// Add activity logging based on app's type
			$permission = $this->_getAppPremission($app, $album);

			if (($app == 'user' && $permission == '0') // Old defination for public privacy
				|| ($app == 'user' && $permission == PRIVACY_PUBLIC)
				|| ($app == 'user' && $permission == PRIVACY_MEMBERS)
			) {
				$group = JTable::getInstance('Group', 'CTable');
				$group->load($album->groupid);

				$event = null;
				$this->_addActivity('photos.wall.create', $my->id, 0, '', $message, 'albums.comment', $uniqueId, $group, $event, $param->toString(), $permission);
				//$this->_addActivity('photos.wall.create', $my->id, 0, '', '{url}', $album->name, $message, 'albums', $uniqueId, $group, $event, $param->toString(), $permission);
			}


			$params = new CParameter('');
			$params->set('url', $url);
			$params->set('message', $message);

			$params->set('album', $album->name);
			$params->set('album_url', $url);

			// @rule: Send notification to the photo owner.
			if ($my->id !== $album->creator) {
				// Add notification
				CNotificationLibrary::add('photos_submit_wall', $my->id, $album->creator, JText::sprintf('COM_COMMUNITY_ALBUM_WALL_EMAIL_SUBJECT'), '', 'album.wall', $params);
			} else {
				//for activity reply action
				//get relevent users in the activity
				$wallModel = CFactory::getModel('wall');
				$users = $wallModel->getAllPostUsers('albums', $uniqueId, $album->creator);
				if (!empty($users)) {
					CNotificationLibrary::add('photos_reply_wall', $my->id, $users, JText::sprintf('COM_COMMUNITY_ALBUM_WALLREPLY_EMAIL_SUBJECT'), '', 'album.wallreply', $params);
				}
			}

			//add user points

			CUserPoints::assignPoint('photos.wall.create');

			$response->addScriptCall('joms.walls.insert', $wall->content);
		}
		return $response->sendResponse();
	}

	/**
	 * Ajax function to save a new wall entry
	 *
	 * @param message    A message that is submitted by the user
	 * @param uniqueId    The unique id for this group
	 *
	 **/
	public function ajaxSaveWall($message, $uniqueId, $appId = null)
	{
		$filter = JFilterInput::getInstance();
		$message = $filter->clean($message, 'string');
		$uniqueId = $filter->clean($uniqueId, 'int');
		$appId = $filter->clean($appId, 'int');

		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$response = new JAXResponse();
		$my = CFactory::getUser();
		$config = CFactory::getConfig();
		$message = strip_tags($message);

		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($uniqueId);

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);

		$handler = $this->_getHandler($album);

		if (!$handler->isWallsAllowed($photo->id)) {
			echo JText::_('COM_COMMUNITY_NOT_ALLOWED_TO_POST_COMMENT');
			return;
		}

		// If the content is false, the message might be empty.
		if (empty($message)) {
			$response->addAlert(JText::_('COM_COMMUNITY_WALL_EMPTY_MESSAGE'));
		} else {
			// @rule: Spam checks
			if ($config->get('antispam_akismet_walls')) {


				$filter = CSpamFilter::getFilter();
				$filter->setAuthor($my->getDisplayName());
				$filter->setMessage($message);
				$filter->setEmail($my->email);
				$filter->setURL(CRoute::_('index.php?option=com_community&view=photos&task=photo&albumid=' . $photo->albumid) . '&photoid=' . $photo->id);
				$filter->setType('message');
				$filter->setIP($_SERVER['REMOTE_ADDR']);

				if ($filter->isSpam()) {
					$response->addAlert(JText::_('COM_COMMUNITY_WALLS_MARKED_SPAM'));
					return $response->sendResponse();
				}
			}

			$wall = CWallLibrary::saveWall($uniqueId, $message, 'photos', $my, ($my->id == $photo->creator), 'photos,photo');
			$url = $photo->getRawPhotoURI();
			$param = new CParameter('');
			$param->set('photoid', $uniqueId);
			$param->set('action', 'wall');
			$param->set('wallid', $wall->id);
			$param->set('url', $url);

			// Get the album type
			$app = $album->type;

			// Add activity logging based on app's type
			$permission = $this->_getAppPremission($app, $album);

			if (($app == 'user' && $permission == '0') // Old defination for public privacy
				|| ($app == 'user' && $permission == PRIVACY_PUBLIC)
			) {
				$group = JTable::getInstance('Group', 'CTable');
				$group->load($album->groupid);

				$event = null;
				$this->_addActivity( 'photos.wall.create' , $my->id , 0 , '', $message , 'photos.comment' , $uniqueId, $group, $event, $param->toString(), $permission );
			}

			// Add notification


			$params = new CParameter('');
			$params->set('url', $photo->getRawPhotoURI());
			$params->set('message', $message);
			$params->set('photo', JText::_('COM_COMMUNITY_SINGULAR_PHOTO'));
			$params->set('photo_url', $url);
			// @rule: Send notification to the photo owner.
			if ($my->id !== $photo->creator) {
				CNotificationLibrary::add('photos_submit_wall', $my->id, $photo->creator, JText::sprintf('COM_COMMUNITY_PHOTO_WALL_EMAIL_SUBJECT'), '', 'photos.wall', $params);
			} else {
				//for activity reply action
				//get relevent users in the activity
				$wallModel = CFactory::getModel('wall');
				$users = $wallModel->getAllPostUsers('photos', $photo->id, $photo->creator);
				if (!empty($users)) {
					CNotificationLibrary::add('photos_reply_wall', $my->id, $users, JText::sprintf('COM_COMMUNITY_PHOTO_WALLREPLY_EMAIL_SUBJECT'), '', 'photos.wallreply', $params);
				}
			}

			//add user points

			CUserPoints::assignPoint('photos.wall.create');

			$response->addScriptCall('joms.walls.insert', $wall->content);
		}
		$this->cacheClean(array(COMMUNITY_CACHE_TAG_ACTIVITIES));
		return $response->sendResponse();
	}

	private function _getAppPremission($app, $album)
	{
		switch ($app) {
			case 'user'        :
				$permission = $album->permissions;
				break;
			case 'event'    :
			case 'group'    :
				$group = JTable::getInstance('Group', 'CTable');
				$group->load($album->groupid);
				$permission = $group->approvals;
				break;
		}

		return $permission;
	}

	/**
	 * Default task in photos controller
	 **/
	public function display($cacheable=false, $urlparams=false)
	{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);

		if ($this->checkPhotoAccess()) {
			echo $view->get(__FUNCTION__);
		}
	}

	/**
	 * Alias method that calls the display task in photos controller
	 **/
	public function myphotos()
	{
		$my = JFactory::getUser();

		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);

		if ($this->checkPhotoAccess()) {
			echo $view->get(__FUNCTION__);
		}
	}

	/**
	 * Create new album for the photos
	 **/
	public function newalbum()
	{
		$my = JFactory::getUser();
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);
		$groupId = JRequest::getInt('groupid', '', 'REQUEST');

		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		if ($this->blockUnregister()) {
			return;
		}

		$album = JTable::getInstance('Album', 'CTable');
		$handler = $this->_getHandler($album);

		$group = JTable::getInstance('Group', 'CTable');
		$group->load($groupId);

		// Check if the current user is banned from this group
		$isBanned = $group->isBanned($my->id);

		if (!$handler->isAllowedAlbumCreation() || $isBanned) {
			echo $view->noAccess();
			return;
		}

		if (JRequest::getMethod() == 'POST') {
			$mainframe = JFactory::getApplication();
			$type = $jinput->post->get('type', '', 'NONE'); //JRequest::getVar('type', '', 'POST');
			$albumName = $jinput->post->get('name', '', 'STRING'); //JRequest::getVar('name', '', 'POST');

			if (empty($saveSuccess) || !in_array(false, $saveSuccess)) {
				if (empty($albumName)) {
					$view->addWarning(JText::_('COM_COMMUNITY_ALBUM_NAME_REQUIRED'));
				} else {
					$album = $this->_saveAlbum();

					// Added to verify is save operation performed successfully or not
					if ($album === false) {
						$message = $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PHOTOS_STATUS_UNABLE_SAVE_ALBUM_ERROR'), 'error');
						echo $view->get(__FUNCTION__);
						return;
					}

					//add user points

					CUserPoints::assignPoint('album.create');

					$groupString = "";
					if ($groupId != "") {

						$groupString = "&groupid=$groupId";
					}

					$url = CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $album->id . '' . $groupString,false); //= $handler->getUploaderURL( $album->id );
					$message = JText::_('COM_COMMUNITY_PHOTOS_STATUS_NEW_ALBUM');
					$mainframe->redirect($url, $message);
				}
			}
		}

		if ($this->checkPhotoAccess()) {
			echo $view->get(__FUNCTION__);
		}
	}

	/**
	 * Display all photos from the current album
	 *
	 **/
	public function album()
	{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);

		if ($this->checkPhotoAccess()) {
			echo $view->get(__FUNCTION__);
		}
	}

	/**
	 * Displays the photo
	 *
	 **/
	public function photo()
	{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);
		$my = CFactory::getUser();

		if ($this->checkPhotoAccess()) {
			echo $view->get(__FUNCTION__);
		}
	}

	/**
	 * Method to edit an album
	 **/
	public function editAlbum()
	{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);

		if ($this->blockUnregister()) {
			return;
		}

		// Make sure the user has permission to edit any this photo album
		$my = CFactory::getUser();
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		// Load models, libraries
		$albumid = $jinput->get->get('albumid', '', 'INT'); //JRequest::getVar('albumid', '', 'GET');
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumid);
		$handler = $this->_getHandler($album);

		if (!$handler->hasPermission($albumid, $album->groupid)) {
			$this->blockUserAccess();
			return true;
		}

		if (JRequest::getMethod() == 'POST') {
			$type = $jinput->post->get('type', '' , 'NONE'); //JRequest::getVar('type', '', 'POST');
			$referrer = $jinput->post->get('referrer', 'myphotos', 'STRING'); //JRequest::getVar('referrer', 'myphotos', 'POST');
			$album = $this->_saveAlbum($albumid);

			// Added to verify is save operation performed successfully or not
			if ($album === false) {
				$message = $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PHOTOS_STATUS_UNABLE_SAVE_ALBUM_ERROR'), 'error');
				echo $view->get(__FUNCTION__, $album);
				return;
			}

			if (preg_match('/grp$/', $referrer)) {
				$grouptxt = '&groupid=' . $album->groupid;
				$referrer = preg_replace('/grp$/', '', $referrer);
			} else {
				$grouptxt = '';
			}

			$url = CRoute::_('index.php?option=com_community&view=photos&task=' . $referrer . '&albumid=' . $albumid . '&userid=' . $my->id . $grouptxt, false);
//			$url = $handler->getEditedAlbumURL( $albumid );
			$this->cacheClean(array(COMMUNITY_CACHE_TAG_FRONTPAGE));
			$mainframe->redirect($url, JText::_('COM_COMMUNITY_PHOTOS_STATUS_ALBUM_EDITED'));
		}

		if ($this->checkPhotoAccess()) {
			echo $view->get(__FUNCTION__);
		}
	}

	/**
	 * Controller method to remove an album
	 **/
	public function removealbum()
	{
		if ($this->blockUnregister())
			return;

		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('COM_COMMUNITY_INVALID_TOKEN'));

		// Get the album id.
		$my = CFactory::getUser();
		$id = JRequest::getInt('albumid', '');
		$task = JRequest::getCmd('currentTask', '');
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($id);

		$handler = $this->_getHandler($album);

		// Load libraries


		$album = JTable::getInstance('Album', 'CTable');
		$album->load($id);



		if (!$handler->hasPermission($album->id, $album->groupid)) {
			$this->blockUserAccess();
			return;
		}

		$model = CFactory::getModel('photos');


		$appsLib = CAppPlugins::getInstance();
		$appsLib->loadApplications();

		$params = array();
		$params[] = $album;

		$url = $handler->getEditedAlbumURL($album->id);

		if ($album->delete())
		{
			$appsLib->triggerEvent('onAfterAlbumDelete', $params);

			// @rule: remove from featured item if item is featured

			$featured = new CFeatured(FEATURED_ALBUMS);
			$featured->delete($album->id);

			//add user points

			CUserPoints::assignPoint('album.remove');

			// Remove from activity stream
			CActivityStream::remove('photos', $id);

			$mainframe = JFactory::getApplication();

			$task = (!empty($task)) ? '&task=' . $task : '';


			$message = JText::sprintf('COM_COMMUNITY_PHOTOS_ALBUM_REMOVED', $album->name);
			$mainframe->redirect($url, $message);
		}
	}

	/**
	 *    Generates a resized image of the photo
	 **/
	public function showimage($showPhoto = true)
	{
		jimport('joomla.filesystem.file');
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		$imgid = $jinput->get('imgid', '', 'PATH'); //JRequest::getVar('imgid', '', 'GET');
		$maxWidth = $jinput->get('maxW', 0, 'INT'); //JRequest::getVar('maxW', '', 'GET');
		$maxHeight = $jinput->get('maxH', 0, 'INT'); //JRequest::getVar('maxH', '', 'GET');

		// round up the w/h to the nearest 10
		$maxWidth = round($maxWidth, -1);
		$maxHeight = round($maxHeight, -1);

		$photoModel = CFactory::getModel('photos');
		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->loadFromImgPath($imgid);

		$photoPath = JPATH_ROOT .'/'. $photo->image;
		$config = CFactory::getConfig();

		if (!JFile::exists($photoPath)) {
			$displayWidth = $config->getInt('photodisplaysize');
			$info = getimagesize(JPATH_ROOT .'/'. $photo->original);
			$imgType = image_type_to_mime_type($info[2]);
			$displayWidth = ($info[0] < $displayWidth) ? $info[0] : $displayWidth;

			CImageHelper::resizeProportional(JPATH_ROOT .'/'. $photo->original, $photoPath, $imgType, $displayWidth);

			if ($config->get('deleteoriginalphotos')) {
				$originalPath = JPATH_ROOT .'/'. $photo->original;
				if (JFile::exists($originalPath)) {
					JFile::delete($originalPath);
				}
			}
		}

		// Show photo if required
		if ($showPhoto) {
			$info = getimagesize(JPATH_ROOT .'/'. $photo->image);

			// @rule: Clean whitespaces as this might cause errors when header is used.
			$ob_active = ob_get_length() !== FALSE;

			if ($ob_active) {
				while (@ ob_end_clean()) ;
				if (function_exists('ob_clean')) {
					@ob_clean();
				}
			}

			header('Content-type: ' . $info['mime']);
			echo JFile::read($photoPath);
			exit;
		}
	}

	public function uploader()
	{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$view =  $this->getView($viewName, '', $viewType);
		$my = CFactory::getUser();



		if (CLimitsLibrary::exceedDaily('photos')) {
			$mainframe = JFactory::getApplication();
			$mainframe->redirect(CRoute::_('index.php?option=com_community&view=photos', false), JText::_('COM_COMMUNITY_PHOTOS_LIMIT_REACHED'), 'error');
		}

		// If user is not logged in, we shouldn't really let them in to this page at all.
		if ($this->blockUnregister()) {
			return;
		}

		// Load models, libraries


		$albumid = JRequest::getInt('albumid', '', 'GET');
		$groupId = JRequest::getInt('groupid', '0');

		if (!empty($groupId)) {

			$allowManagePhotos = CGroupHelper::allowManagePhoto($groupId);

			$group = JTable::getInstance('Group', 'CTable');
			$group->load($groupId);

			// Check if the current user is banned from this group
			$isBanned = $group->isBanned($my->id);

			if (!$allowManagePhotos || $isBanned) {
				echo JText::_('COM_COMMUNITY_PHOTOS_GROUP_NOT_ALLOWED_ERROR');
				return;
			}
		}

		// User has not selected album id yet
		if (!empty($albumid)) {
			$album = JTable::getInstance('Album', 'CTable');
			$album->load($albumid);

			if (!$album->hasAccess($my->id, 'upload')) {
				$this->blockUserAccess();
				return;
			}
		}


		if ($this->checkPhotoAccess()) {
			echo $view->get(__FUNCTION__);
		}
	}

	public function checkPhotoAccess()
	{
		$mainframe = JFactory::getApplication();
		$config = CFactory::getConfig();

		if (!$config->get('enablephotos')) {
			$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PHOTOS_DISABLED'), '');
			return false;
		}
		return true;
	}

	private function _imageLimitExceeded($size)
	{
		$config = CFactory::getConfig();
		$uploadLimit = (double)$config->get('maxuploadsize');

		if ($uploadLimit == 0) {
			return false;
		}

		$uploadLimit = ($uploadLimit * 1024 * 1024);

		return $size > $uploadLimit;
	}

	private function _validImage($image)
	{

		$config = CFactory::getConfig();

		if ($image['error'] > 0 && $image['error'] !== 'UPLOAD_ERR_OK') {
			$this->setError(JText::sprintf('COM_COMMUNITY_PHOTOS_UPLOAD_ERROR', $image['error']));
			return false;
		}

		if (empty($image['tmp_name'])) {
			$this->setError(JText::_('COM_COMMUNITY_PHOTOS_MISSING_FILENAME_ERROR'));
			return false;
		}

		// This is only applicable for html uploader because flash uploader uploads all 'files' as application/octet-stream
		//if( !$config->get('flashuploader') && !CImageHelper::isValidType( $image['type'] ) )
		if (!CImageHelper::isValidType($image['type'])) {
			$this->setError(JText::_('COM_COMMUNITY_IMAGE_FILE_NOT_SUPPORTED'));
			return false;
		}

		if (!CImageHelper::isMemoryNeededExceed($image['tmp_name'])) {
			$this->setError(JText::_('COM_COMMUNITY_IMAGE_NOT_ENOUGH_MEMORY'));
			return false;
		}
		if (!CImageHelper::isValid($image['tmp_name'])) {
			$this->setError(JText::_('COM_COMMUNITY_IMAGE_FILE_NOT_SUPPORTED'));
			return false;
		}

		return true;
	}

	/**
	 * Preview a photo upload
	 * @return type
	 *
	 */
	public function ajaxPreview()
	{
		$my = CFactory::getUser();
		$config = CFactory::getConfig();
		$groupId = JRequest::getInt('groupid', 0, 'REQUEST');

		$type = ($groupId == 0) ? PHOTOS_USER_TYPE : PHOTOS_GROUP_TYPE;
		$albumId = ($groupId == 0) ? $my->id : $groupId;



		if (CLimitsLibrary::exceedDaily('photos')) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_PHOTOS_LIMIT_REACHED'));
			return;
		}

		// We can't use blockUnregister here because practically, the CFactory::getUser() will return 0
		if ($my->id == 0) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_PROFILE_NEVER_LOGGED_IN'));
			return;
		}

		// Get default album or create one
		$model = CFactory::getModel('photos');

		$album = $model->getDefaultAlbum($albumId, $type);
		$newAlbum = false;

		if (empty($album)) {
			$album = JTable::getInstance('Album', 'CTable');
			$album->load();

			$handler = $this->_getHandler($album);

			$newAlbum = true;
			$now = new JDate();


			$album->creator = $my->id;
			$album->created = $now->toSql();

			$album->type = $handler->getType();
			$album->default = '1';
			$album->groupid = $groupId;

			switch ($type) {
				case PHOTOS_USER_TYPE:
					$album->name = JText::sprintf('COM_COMMUNITY_DEFAULT_ALBUM_CAPTION', $my->getDisplayName());
					break;

				case PHOTOS_GROUP_TYPE:
					$group = JTable::getInstance('Group', 'CTable');
					$group->load($groupId);
					$album->name = JText::sprintf('COM_COMMUNITY_DEFAULT_ALBUM_CAPTION', $group->name);
					break;
			}

			$albumPath = $handler->getAlbumPath($album->id);
			$albumPath = CString::str_ireplace(JPATH_ROOT .'/', '', $albumPath);
			$albumPath = CString::str_ireplace('\\', '/', $albumPath);
			$album->path = $albumPath;

			$album->store();
		} else {
			$albumId = $album->id;
			$album = JTable::getInstance('Album', 'CTable');
			$album->load($albumId);
			$handler = $this->_getHandler($album);
		}

		$photos = JRequest::get('Files');

		// @todo: foreach here is redundant since we exit on the first loop
		foreach ($photos as $imageFile) {
			$result = $this->_checkUploadedFile($imageFile, $album, $handler);

			if (!$result['photoTable']) {
				continue;
			}

			//assign the result of the array and assigned to the right variable
			$photoTable = $result['photoTable'];
			$storage = $result['storage'];
			$albumPath = $result['albumPath'];
			$hashFilename = $result['hashFilename'];
			$thumbPath = $result['thumbPath'];
			$originalPath = $result['originalPath'];
			$imgType = $result['imgType'];
			$isDefaultPhoto = $result['isDefaultPhoto'];

			// Remove the filename extension from the caption
			if (JString::strlen($photoTable->caption) > 4) {
				$photoTable->caption = JString::substr($photoTable->caption, 0, JString::strlen($photoTable->caption) - 4);
			}

			// @todo: configurable options?
			// Permission should follow album permission
			$photoTable->published = '0';
			$photoTable->permissions = $album->permissions;
			$photoTable->status = 'temp';

			// Set the relative path.
			// @todo: configurable path?
			$storedPath = $handler->getStoredPath($storage, $album->id);
			$storedPath = $storedPath .'/'. $albumPath . $hashFilename . CImageHelper::getExtension($imageFile['type']);

			$photoTable->image = CString::str_ireplace(JPATH_ROOT .'/', '', $storedPath);
			$photoTable->thumbnail = CString::str_ireplace(JPATH_ROOT .'/', '', $thumbPath);

			// In joomla 1.6, CString::str_ireplace is not replacing the path properly. Need to do a check here
			if ($photoTable->image == $storedPath) $photoTable->image = str_ireplace(JPATH_ROOT .'/', '', $storedPath);
			if ($photoTable->thumbnail == $thumbPath) $photoTable->thumbnail = str_ireplace(JPATH_ROOT .'/', '', $thumbPath);

			// Photo filesize, use sprintf to prevent return of unexpected results for large file.
			$photoTable->filesize = sprintf("%u", filesize($originalPath));

			// @rule: Set the proper ordering for the next photo upload.
			$photoTable->setOrdering();

			// Store the object
			$photoTable->store();

			if ($newAlbum) {
				$album->photoid = $photoTable->id;
				$album->store();
			}

			// We need to see if we need to rotate this image, from EXIF orientation data
			// Only for jpeg image.
			if ($config->get('photos_auto_rotate') && $imgType == 'image/jpeg') {
				$this->_rotatePhoto($imageFile, $photoTable, $storedPath, $thumbPath);
			}

			$tmpl = new CTemplate();
			$tmpl->set('photo', $photoTable);
			$tmpl->set('filename', $imageFile['name']);
			$html = $tmpl->fetch('status.photo.item');

			$photo = new stdClass();
			$photo->id = $photoTable->id;
			$photo->thumbnail = $photoTable->thumbnail;
			$photo->html = rawurlencode($html);

			echo json_encode($photo);
			exit;
		}
	}

	public function multiUpload()
	{
		$this->upload();
	}

	/**
	  *
	  * Called during photo uploading.
	  */
	public function upload()
	{
		$my = CFactory::getUser();
		$config = CFactory::getConfig();
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		// If user is using a flash browser, their session might get reset when mod_security is around
		if ($my->id == 0) {
			$tokenId = $jinput->request->get('token', '', 'NONE'); //JRequest::getVar('token', '', 'REQUEST');
			$userId = $jinput->request->get('uploaderid', '', 'NONE'); //JRequest::getVar('uploaderid', '', 'REQUEST');
			$my = CFactory::getUserFromTokenId($tokenId, $userId);
			$session = JFactory::getSession();
			$session->set('user', $my);
		}



		if (CLimitsLibrary::exceedDaily('photos', $my->id)) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_PHOTOS_LIMIT_PERDAY_REACHED'));
			return;
		}

		// We can't use blockUnregister here because practically, the CFactory::getUser() will return 0
		if ($my->id == 0) {
			return;
		}

		// Load up required models and properties
		$photos 	= JRequest::get('Files');
		$albumId 	= $jinput->request->get('albumid', '', 'INT'); //JRequest::getVar('albumid', '', 'REQUEST');
		$album 		= JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$handler = $this->_getHandler($album);

		foreach ($photos as $imageFile) {
			$result = $this->_checkUploadedFile($imageFile, $album, $handler);

			if (!$result['photoTable']) {
				continue;
			}

			//assign the result of the array and assigned to the right variable
			$photoTable = $result['photoTable'];
			$storage = $result['storage'];
			$albumPath = $result['albumPath'];
			$hashFilename = $result['hashFilename'];
			$thumbPath = $result['thumbPath'];
			$originalPath = $result['originalPath'];
			$imgType = $result['imgType'];
			$isDefaultPhoto = $result['isDefaultPhoto'];

			// Remove the filename extension from the caption
			if (JString::strlen($photoTable->caption) > 4) {
				$photoTable->caption = JString::substr($photoTable->caption, 0, JString::strlen($photoTable->caption) - 4);
			}

			// @todo: configurable options?
			// Permission should follow album permission
			$photoTable->published = '1';
			$photoTable->permissions = $album->permissions;

			// Set the relative path.
			// @todo: configurable path?
			$storedPath = $handler->getStoredPath($storage, $albumId);
			$storedPath = $storedPath .'/'. $albumPath . $hashFilename . CImageHelper::getExtension($imageFile['type']);

			$photoTable->image = CString::str_ireplace(JPATH_ROOT .'/', '', $storedPath);
			$photoTable->thumbnail = CString::str_ireplace(JPATH_ROOT .'/', '', $thumbPath);

			//In joomla 1.6, CString::str_ireplace is not replacing the path properly. Need to do a check here
			if ($photoTable->image == $storedPath) $photoTable->image = str_ireplace(JPATH_ROOT .'/', '', $storedPath);
			if ($photoTable->thumbnail == $thumbPath) $photoTable->thumbnail = str_ireplace(JPATH_ROOT .'/', '', $thumbPath);

			//photo filesize, use sprintf to prevent return of unexpected results for large file.
			$photoTable->filesize = sprintf("%u", filesize($originalPath));

			// @rule: Set the proper ordering for the next photo upload.
			$photoTable->setOrdering();

			// Store the object
			$photoTable->store();

			// We need to see if we need to rotate this image, from EXIF orientation data
			// Only for jpeg image.
			if ($config->get('photos_auto_rotate') && $imgType == 'image/jpeg') {
				$this->_rotatePhoto($imageFile, $photoTable, $storedPath, $thumbPath);
			}

			// Trigger for onPhotoCreate

			$apps = CAppPlugins::getInstance();
			$apps->loadApplications();
			$params = array();
			$params[] =  $photoTable;
			$apps->triggerEvent('onPhotoCreate', $params);

			// Set image as default if necessary
			// Load photo album table
			if ($isDefaultPhoto) {
				// Set the photo id
				$album->photoid = $photoTable->id;
				$album->store();
			}

			// @rule: Set first photo as default album cover if enabled
			if (!$isDefaultPhoto && $config->get('autoalbumcover')) {
				$photosModel = CFactory::getModel('Photos');
				$totalPhotos = $photosModel->getTotalPhotos($album->id);

				if ($totalPhotos <= 1) {
					$album->photoid = $photoTable->id;
					$album->store();
				}
			}

			// Generate activity stream
			$act = new stdClass();
			$act->cmd = 'photo.upload';
			$act->actor = $my->id;
			$act->access = $album->permissions;
			$act->target = 0;
			//$act->title	  	= JText::sprintf( $handler->getUploadActivityTitle() , '{photo_url}', $album->name );
			$act->title = '';	// Empty title, auto-generated by stream
			$act->content = ''; // Gegenerated automatically by stream. No need to add anything
			$act->app = 'photos';
			$act->cid = $albumId;
			$act->location = $album->location;

			// Store group info
			// I hate to load group here, but unfortunately, album does
			// not store group permission setting
			$group = JTable::getInstance('Group', 'CTable');
			$group->load($album->groupid);

			$act->groupid = $album->groupid;
			$act->group_access = $group->approvals;

			// Allow comment on the album
			$act->comment_type = 'albums';
			$act->comment_id = $albumId;

			// Allow like on the album
			$act->like_type = 'albums';
			$act->like_id = $albumId;

			$params = new CParameter('');
			$params->set('multiUrl', $handler->getAlbumURI($albumId, false));
			$params->set('photoid', $photoTable->id);
			$params->set('action', 'upload');
			$params->set('photo_url', $photoTable->getThumbURI());
			$params->set('style', COMMUNITY_STREAM_STYLE);

			// Set the upload count per session
			$session = JFactory::getSession();
			$uploadSessionCount = $session->get('album-'.$albumId.'-upload', 0);
			$uploadSessionCount++;
			$session->set('album-'.$albumId.'-upload', $uploadSessionCount);
			$params->set('count', $uploadSessionCount);

			// Add activity logging

			CActivityStream::remove($act->app, $act->cid);
			CActivityStream::add($act, $params->toString());

			//add user points

			CUserPoints::assignPoint('photo.upload');

			// Photo upload was successfull, display a proper message
			$this->_showUploadError(false, JText::sprintf('COM_COMMUNITY_PHOTO_UPLOADED_SUCCESSFULLY', $photoTable->caption), $photoTable->getThumbURI(), $albumId, $photoTable->id);
		}
		$this->cacheClean(array(COMMUNITY_CACHE_TAG_FRONTPAGE, COMMUNITY_CACHE_TAG_ACTIVITIES));
		exit;
	}

	private function _checkUploadedFile($imageFile, $album, $handler)
	{
		$my = CFactory::getUser();
		$config = CFactory::getConfig();
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		if (!$this->_validImage($imageFile)) {
			$this->_showUploadError(true, $this->getError());
			return false;
		}

		if ($this->_imageLimitExceeded(filesize($imageFile['tmp_name']))) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_VIDEOS_IMAGE_FILE_SIZE_EXCEEDED'));
			return false;
		}

		// We need to read the filetype as uploaded always return application/octet-stream
		// regardless of the actual file type
		$info = getimagesize($imageFile['tmp_name']);
		$isDefaultPhoto = $jinput->request->get('defaultphoto', FALSE, 'NONE'); //JRequest::getVar('defaultphoto', false, 'REQUEST');

		if ($album->id == 0 || (($my->id != $album->creator) && $album->type != PHOTOS_GROUP_TYPE)) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_PHOTOS_INVALID_ALBUM'));
			return false;
		}

		if (!$album->hasAccess($my->id, 'upload')) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_PHOTOS_INVALID_ALBUM'));
			return false;
		}

		// Hash the image file name so that it gets as unique possible
		$fileName		= JApplication::getHash($imageFile['tmp_name'] . time());
		$hashFilename	= JString::substr($fileName, 0, 24);
		$imgType		= image_type_to_mime_type($info[2]);

		// Load the tables
		$photoTable = JTable::getInstance('Photo', 'CTable');

		// @todo: configurable paths?
		$storage = JPATH_ROOT .'/'. $config->getString('photofolder');
		$albumPath = (empty($album->path)) ? '' : $album->id .'/';

		// Test if the photos path really exists.
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');


		$originalPath = $handler->getOriginalPath($storage, $albumPath, $album->id);


		// @rule: Just in case user tries to exploit the system, we should prevent this from even happening.
		if ($handler->isExceedUploadLimit(false) && !COwnerHelper::isCommunityAdmin()) {
			$groupId = JRequest::getInt('groupid', $album->groupid, 'REQUEST');
			$config = CFactory::getConfig();

			if (intval($groupId) > 0) {
				// group photo
				$photoLimit = $config->get('groupphotouploadlimit');
				$this->_showUploadError(true, JText::sprintf('COM_COMMUNITY_GROUPS_PHOTO_LIMIT', $photoLimit));
			} else {
				// user photo
				$photoLimit = $config->get('photouploadlimit');
				$this->_showUploadError(true, JText::sprintf('COM_COMMUNITY_PHOTOS_UPLOAD_LIMIT_REACHED', $photoLimit));
			}

			//echo JText::sprintf('COM_COMMUNITY_GROUPS_PHOTO_LIMIT' , $photoLimit );
			return false;
		}

		if (!JFolder::exists($originalPath)) {
			if (!JFolder::create($originalPath, (int)octdec($config->get('folderpermissionsphoto')))) {
				$this->_showUploadError(true, JText::_('COM_COMMUNITY_VIDEOS_CREATING_USERS_PHOTO_FOLDER_ERROR'));
				return false;
			}
			JFile::copy(JPATH_ROOT .'/components/com_community/index.html', $originalPath .'/index.html');
		}

		$locationPath = $handler->getLocationPath($storage, $albumPath, $album->id);

		if (!JFolder::exists($locationPath)) {
			if (!JFolder::create($locationPath, (int)octdec($config->get('folderpermissionsphoto')))) {
				$this->_showUploadError(true, JText::_('COM_COMMUNITY_VIDEOS_CREATING_USERS_PHOTO_FOLDER_ERROR'));
				return false;
			}
			JFile::copy(JPATH_ROOT .'/components/com_community/index.html', $locationPath .'/index.html');
		}

		$thumbPath = $handler->getThumbPath($storage, $album->id);
		$thumbPath = $thumbPath .'/'. $albumPath . 'thumb_' . $hashFilename . CImageHelper::getExtension($imageFile['type']);
		CPhotos::generateThumbnail($imageFile['tmp_name'], $thumbPath, $imgType);

		// Original photo need to be kept to make sure that, the gallery works
		$useAlbumId = (empty($album->path)) ? 0 : $album->id;
		$originalFile = $originalPath . $hashFilename . CImageHelper::getExtension($imgType);

		$this->_storeOriginal($imageFile['tmp_name'], $originalFile, $useAlbumId);
		$photoTable->original = CString::str_ireplace(JPATH_ROOT .'/', '', $originalFile);

		// In joomla 1.6, CString::str_ireplace is not replacing the path properly. Need to do a check here
		if ($photoTable->original == $originalFile) $photoTable->original = str_ireplace(JPATH_ROOT .'/', '', $originalFile);

		// Set photos properties
		$now = new JDate();

		$photoTable->albumid = $album->id;
		$photoTable->caption = $imageFile['name'];
		$photoTable->creator = $my->id;
		$photoTable->created = $now->toSql();

		$result = array(
			'photoTable' => $photoTable,
			'storage' => $storage,
			'albumPath' => $albumPath,
			'hashFilename' => $hashFilename,
			'thumbPath' => $thumbPath,
			'originalPath' => $originalPath,
			'imgType' => $imgType,
			'isDefaultPhoto' => $isDefaultPhoto
		);

		return $result;
	}

	/**
	 * Rotate the given image file
	 */
	private function _rotatePhoto($imageFile, $photoTable, $storedPath, $thumbPath)
	{
		$config = CFactory::getConfig();

		// Read orientation data from original file
		$orientation = CImageHelper::getOrientation($imageFile['tmp_name']);

		// A newly uplaoded image might not be resized yet, do it now
		$displayWidth = $config->getInt('photodisplaysize');
		JRequest::setVar('imgid', $photoTable->id, 'GET');
		JRequest::setVar('maxW', $displayWidth, 'GET');
		JRequest::setVar('maxH', $displayWidth, 'GET');

		$this->showimage(false);

		// Rotata resized files ince it is smaller
		switch ($orientation) {
			case 1: // nothing
				break;

			case 2: // horizontal flip
				// $image->flipImage($public,1);
				break;

			case 3: // 180 rotate left
				//  $image->rotateImage($public,180);
				CImageHelper::rotate($storedPath, $storedPath, 180);
				CImageHelper::rotate($thumbPath, $thumbPath, 180);
				break;

			case 4: // vertical flip
				//  $image->flipImage($public,2);
				break;

			case 5: // vertical flip + 90 rotate right
				//$image->flipImage($public, 2);
				//$image->rotateImage($public, -90);
				break;

			case 6: // 90 rotate right
				// $image->rotateImage($public, -90);
				CImageHelper::rotate($storedPath, $storedPath, -90);
				CImageHelper::rotate($thumbPath, $thumbPath, -90);
				break;

			case 7: // horizontal flip + 90 rotate right
// 			            $image->flipImage($public,1);
// 			            $image->rotateImage($public, -90);
				break;

			case 8: // 90 rotate left
// 			            $image->rotateImage($public, 90);
				CImageHelper::rotate($storedPath, $storedPath, 90);
				CImageHelper::rotate($thumbPath, $thumbPath, 90);
				break;
		}
	}

	/**
	 * Return photos handlers
	 */
	private function _getHandler(CTableAlbum $album)
	{
		$handler = null;

		// During AJAX calls, we might not be able to determine the groupid
		$groupId = JRequest::getInt('groupid', $album->groupid, 'REQUEST');
		$type = PHOTOS_USER_TYPE;

		if (intval($groupId) > 0) {
			// group photo
			$handler = new CommunityControllerPhotoGroupHandler($this);
		} else {
			// user photo
			$handler = new CommunityControllerPhotoUserHandler($this);
		}

		return $handler;
	}

	/**
	 *     Deprecated since 2.0.x
	 *     Use ajaxSwitchPhotoTrigger instead.
	 **/
	public function ajaxAddPhotoHits($photoId)
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');

		$response = new JAXResponse();

		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->hit($photoId);

		return $response->sendResponse();
	}

	/**
	 * Rotate the given photo
	 * @param  int $photoId     photo to rotate
	 * @param  string $orientation left/right
	 * @return stinr              response
	 */
	public function ajaxRotatePhoto($photoId, $orientation)
	{
		$filter = JFilterInput::getInstance();
		$photoId = $filter->clean($photoId, 'int');
		$app = JFactory::getApplication();

		// $orientation pending filter


		if (!COwnerHelper::isRegisteredUser()) {
			return $this->ajaxBlockUnregister();
		}

		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);

		if ($photo->storage != 'file') {
			// we don't want to support s3
			return false;
		}

		if ($photo->storage != 'file') {
			// download the image files to local server

			$storage = CStorage::getStorage($photoStorage);
			$currentStorage = CStorage::getStorage($photo->storage);
			if ($currentStorage->exists($photo->image)) {
				//$jconfig = JFactory::getConfig();
				//$jTempPath = $jconfig->getValue('tmp_path');
				$jTempPath = $app->getCfg('tmp_path');

				$tempFilename = $jTempPath .'/'. md5($photo->image);
				$currentStorage->get($photo->image, $tempFilename);
				$thumbsTemp = $jTempPath .'/thumb_' . md5($photo->thumbnail);
				$currentStorage->get($photo->thumbnail, $thumbsTemp);
				if (
					JFile::exists($tempFilename)
					&& JFile::exists($thumbsTemp)
					&& $storage->put($row->image, $tempFilename)
					&& $storage->put($photo->thumbnail, $thumbsTemp)
				) {
					$currentStorage->delete($photo->image);
					$currentStorage->delete($photo->thumbnail);
					JFile::delete($tempFilename);
					JFile::delete($thumbsTemp);
				}
			}
		}

		$photoPath = JPath::clean($photo->image);
		$thumbPath = JPath::clean($photo->thumbnail);

		// Hash the image file name so that it gets as unique possible
		$fileName = JApplication::getHash($photo->image . time());
		$fileName = JString::substr($fileName, 0, 24);
		$fileName = $fileName . '.' . JFile::getExt($photo->image);

		$fileNameLength = strlen($photo->image) - strrpos($photo->image, '/') - 1;

		$newPhotoPath = substr_replace($photoPath, $fileName, -$fileNameLength);
		$newThumbPath = substr_replace($photoPath, 'thumb_' . $fileName, -$fileNameLength);

		$degrees = 0;

		if (JFile::exists($photoPath) && JFile::exists($thumbPath)) {
			switch ($orientation) {
				case 'left':
					$degrees = 90;
					break;
				case 'right':
					$degrees = -90;
					break;
				default:
					$degrees = 0;
					break;
			}


			if ($degrees !== 0) {


				// Trim any '/' at the beginning of the filename
				$photoPath = ltrim ($photoPath, '/');
				$photoPath = ltrim ($photoPath, '/');
				$photoPath = ltrim ($photoPath, '/');
				$photoPath = ltrim ($photoPath, '/');

				$imageResult = CImageHelper::rotate(JPATH_ROOT .'/'.$photoPath, JPATH_ROOT .'/'.$newPhotoPath, $degrees);
				$thumbResult = CImageHelper::rotate(JPATH_ROOT .'/'.$thumbPath, JPATH_ROOT .'/'.$newThumbPath, $degrees);

				if ($imageResult !== false && $thumbResult !== false) {
					// This part is not really necessary for newer installations
					$newPhotoPath = CString::str_ireplace(JPATH_ROOT .'/', '', $newPhotoPath);
					$newThumbPath = CString::str_ireplace(JPATH_ROOT .'/', '', $newThumbPath);

					$newPhotoPath = CString::str_ireplace('\\', '/', $newPhotoPath);
					$newThumbPath = CString::str_ireplace('\\', '/', $newThumbPath);

					$photo->storage = 'file'; //just to make sure it's in the local server
					$photo->image = $newPhotoPath;
					$photo->thumbnail = $newThumbPath;
					$photo->store();

					//Delete the original file
					JFile::delete(JPATH_ROOT .'/'.$photoPath);
					JFile::delete(JPATH_ROOT .'/'.$thumbPath);
				}
			}
		}
		$response = new JAXResponse();
		$response->addScriptCall('joms.photos.photoSlider.updateThumb', $photo->id, $photo->getThumbURI());
		$response->addScriptCall('__callback', $photo->id, $photo->getImageURI(), $photo->getThumbURI());

		$this->cacheClean(array(COMMUNITY_CACHE_TAG_FRONTPAGE, COMMUNITY_CACHE_TAG_ACTIVITIES));

		return $response->sendResponse();
	}

	/**
	 * User avatar uploaded from profile page
	 */
	public function ajaxUploadAvatar($type, $id, $custom = '')
	{
		$isCustom = false;
		$aCustom = json_decode($custom, true);

		$cTable = JTable::getInstance(ucfirst($type), 'CTable');
		$cTable->load($id);

		$img = $cTable->getAvatar();

		$response = new JAXResponse();
		$my = CFactory::getUser();

		$customHTML = '';
		$customArg = '';

		// Replace content with custom value.
		if (isset($aCustom['content'])) {
			$customHTML = '<br>' . $aCustom['content'];
			$isCustom = true;
		} else if (isset($aCustom['call'])) {
			// Replace content with object output.
			// Require library.
			if (isset($aCustom['library'])) {

			}
			// Require function call to output custom content.
			if (isset($aCustom['call'][0]) && isset($aCustom['call'][1])) {
				$obj = $aCustom['call'][0];
				$method = $aCustom['call'][1];
				$params = count($aCustom['call']) > 2 ? array_slice($aCustom['call'], 2) : array();

				if (!empty($obj) && !empty($method)) {
					$customHTML = '<br>' . call_user_func_array(array($obj, $method), $params);
				}
			}

			// Arguement to post.
			if (isset($aCustom['arg'])) {
				$customArg .= '+';
				foreach ($aCustom['arg'] as $argType => $argValue) {
					//$customArg .= '\'&' . $value . '=\' + joms.jQuery(\'#' . $value.'\').val()';
					if ($argType == 'radio') {
						$customArg .= '\'&' . $argValue . '=\' + joms.jQuery(\'input[name=' . $argValue . ']:checked\').val()';
					}
				}
			}

			$isCustom = ', true';
		}

		$formAction	= CRoute::_('index.php?option=com_community&view=photos&task=changeAvatar&type=' . $type . '&id=' . $id);
		$content	= '<form id="jsform-uploadavatar" action="' . $formAction . '" method="POST" enctype="multipart/form-data">';
		$content	.= $customHTML;
		$content	.= '<div id="avatar-upload">';
		$action		= 'joms.jQuery(\'#jsform-uploadavatar\').attr(\'action\', joms.jQuery(\'#jsform-uploadavatar\').attr(\'action\')' . $customArg . ')';
		$content	.= '<p>' . JText::_('COM_COMMUNIT_SELECT_IMAGE_INSTR') . '</p>';
		$content	.= '<label class="label-filetype">';
		$content	.= '<a class="cButton cButton-Blue" href="javascript:joms.jQuery(\'#filedata\').click(); void(0);">'.JText::_('COM_COMMUNITY_PHOTOS_UPLOAD').'</a>';
		$content	.= '<input onchange="' . $action . ';joms.photos.ajaxUpload(\'' . $type . '\',' . $id . $isCustom . ')" type="file" size="50" name="filedata" id="filedata">';
		$content	.= '</label>'; //close
		$content	.= '</div>';
		$content	.= '</form>';

		//set call back
		$callBack = NULL;
		$actions = '';

		//check if default avatar is loaded
		if (!empty($cTable->avatar)) {
			$content .= '<div id="avatar-cropper">';
			$content .= '<strong>' . JText::_('COM_COMMUNITY_CROP_AVATAR_TITLE') . '</strong>';
			$content .= '<div class="crop-msg" style="margin: 0 0 10px">' . JText::_('COM_COMMUNITY_CROP_AVATAR_INSTR') . '</div>';
			// $content .= '<div id="update-thumbnail-guide" style="display: none;">' . JText::_('COM_COMMUNITY_UPDATE_THUMBNAIL_GUIDE') . '</div>';
			$content .= '<div class="crop-wrapper">';
			$content .= '<div id="thumb-crop"><img id="large-avatar-pic" width="160px" src=' . $img . ' /></div>';
			$content .= '<div id="thumb-preview">';
			$content .= '<strong>' . JText::_('COM_COMMUNITY_PREVIEW') . '</strong>';
			$content .= '<div class="thumb-desc" style="margin-bottom:5px">';
			$content .= '<span>' . JText::_('COM_COMMUNITY_AVATAR_THUMBDESC') . '</span>';
			$content .= '</div>';
			$content .= '<div class="preview">';
			$content .= '<div id="thumb-hold" style="float:left;position:relative;overflow:hidden;width:64px;height:64px"><img style="position:relative " width="160px" src=' . $img . ' /></div>';
			$content .= '</div></div>';
			$content .= '<div class="clear"></div>';
			$content .= '</div></div>';

			$callBack = "joms.photos.ajaxImgSelect()";
		}

		// Replace action with custom value.
		if (!isset($aCustom['action'])) {
			if (!empty($cTable->avatar)) {
				$actions .= "<button class=\"button\" onclick=\"location.href='".CRoute::_('index.php?option=com_community&view=photos&task=removeAvatar&type='.$type.'&id='.$id)."';cWindowHide();return false;\">" . JText::_('COM_COMMUNITY_REMOVE_AVATAR_BUTTON') . "</button>";
				$actions .= "<button class=\"button\" onclick=\"joms.photos.saveThumb('$type','$id');cWindowHide();return false;\">" . JText::_('COM_COMMUNITY_SAVE_BUTTON') . "</button>";
			}
			$actions .= "<button class=\"button\" onclick=\"cWindowHide();return false;\">" . JText::_('COM_COMMUNITY_BUTTON_CLOSE_BUTTON') . "</button>";
		} else {
			$action .= $aCustom['action'];
		}

		$response->addAssign('cwin_logo', 'innerHTML', JText::_('COM_COMMUNITY_CHANGE_AVATAR'));

		$response->addScriptCall('cWindowAddContent', $content, $actions, $callBack);
		return $response->sendResponse();
	}

	public function removeAvatar(){

		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		$type = $jinput->get('type', '', 'NONE');
		$id = $jinput->get('id', '', 'INT');
		$my = CFactory::getUser();

		$forbidden = true;
		if($type=='event' || $type=='group'){
			$cTable = JTable::getInstance(ucfirst($type), 'CTable');
			$cTable->load($id);
			if($type=='event'){
				$forbidden = $my->id == $cTable->creator?false:true;
			}else{
				$forbidden = $my->id == $cTable->ownerid?false:true;
			}


		}else{
			$cTable = JTable::getInstance('Profile', 'CTable');
			$cTable->load($id);
			$forbidden = $my->id == $id?false:true;
		}

		if(COwnerHelper::isCommunityAdmin() || $forbidden==false){
			$cTable->removeAvatar();
		}

		if($type=='profile'){
			$cRoute = CRoute::_('index.php?option=com_community&view=profile&userid='.$id,false);
		}elseif($type=='group'){
			$cRoute = CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$id,false);
		}elseif($type=='event'){
			$cRoute = CRoute::_('index.php?option=com_community&view=events&task=viewevent&eventid='.$id,false);
		}

		if($forbidden==true){
			$message = JText::_('COM_COMMUNITY_ACCESS_FORBIDDEN');
			$mainframe->redirect($cRoute,$message);
			exit;
		}

		$message = JText::_('COM_COMMUNITY_REMOVE_AVATAR_SUCCESS_MESSAGE');
		$mainframe->redirect($cRoute,$message);

	}

	/**
	 * Called when the user uploaded a new photo
	 */
	public function changeAvatar()
	{
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		$type		= $jinput->get('type', NULL, 'NONE');
		$id			= $jinput->get('id', NULL , 'INT');
		$saveAction	= $jinput->get('repeattype', NULL, 'STRING');
		$filter		= JFilterInput::getInstance();
		$type		= $filter->clean($type, 'string');
		$id			= $filter->clean($id, 'integer');

		$cTable		= JTable::getInstance(ucfirst($type), 'CTable');
		$cTable->load($id);

		$my			= CFactory::getUser();
		$config		= CFactory::getConfig();
		$userid		= $my->id;

		$fileFilter = new JInput($_FILES);
		$file = $fileFilter->get('filedata', '', 'array');
		//$file		= JRequest::getVar('filedata', '', 'FILES', 'array');

		//check if file is allwoed
		if (!CImageHelper::isValidType($file['type'])) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_IMAGE_FILE_NOT_SUPPORTED'));
			return;
		}

		//check upload file size
		$uploadlimit = (double)$config->get('maxuploadsize');
		$uploadlimit = ($uploadlimit * 1024 * 1024);

		if (filesize($file['tmp_name']) > $uploadlimit && $uploadlimit != 0) {
			$this->_showUploadError(true, JText::_('COM_COMMUNITY_VIDEOS_IMAGE_FILE_SIZE_EXCEEDED'));
			return;
		}

		//start image processing
		$imageMaxWidth	= 160;

		// Get a hash for the file name.
		$fileName		= JApplication::getHash($file['tmp_name'] . time());
		$hashFileName	= JString::substr($fileName, 0, 24);
		$avatarFolder	= ($type != 'profile' && $type != '') ? $type .'/' : '';

		//avatar store path
		$storage			= JPATH_ROOT .'/'. $config->getString('imagefolder') .'/avatar' .'/'. $avatarFolder;
		$storageImage		= $storage .'/'. $hashFileName . CImageHelper::getExtension($file['type']);
		$image				= $config->getString('imagefolder') . '/avatar/' . $avatarFolder . $hashFileName . CImageHelper::getExtension($file['type']);

		// filename for stream attachment
		$imageAttachment	= $config->getString('imagefolder').'/avatar/'.$hashFileName.'_stream_'.CImageHelper::getExtension( $file['type'] );

		//avatar thumbnail path
		$storageThumbnail	= $storage .'/thumb_' . $hashFileName . CImageHelper::getExtension($file['type']);
		$thumbnail			= $config->getString('imagefolder') . '/avatar/' . $avatarFolder . 'thumb_' . $hashFileName . CImageHelper::getExtension($file['type']);

		// Generate full image
		if (!CImageHelper::resizeProportional($file['tmp_name'], $storageImage, $file['type'], $imageMaxWidth)) {
			$this->_showUploadError(true, JText::sprintf('COM_COMMUNITY_ERROR_MOVING_UPLOADED_FILE', $storageImage));
			return;
		}

		// Generate thumbnail
		if (!CImageHelper::createThumb($file['tmp_name'], $storageThumbnail, $file['type'])) {
			$this->_showUploadError(true, JText::sprintf('COM_COMMUNITY_ERROR_MOVING_UPLOADED_FILE', $storageImage));
			return;
		}

		if ($type == 'profile') {
			$profileType	= $my->getProfileType();
			$multiprofile	= JTable::getInstance('MultiProfile', 'CTable');
			$multiprofile->load($profileType);

			$useWatermark = $profileType != COMMUNITY_DEFAULT_PROFILE && $config->get('profile_multiprofile') && !empty($multiprofile->watermark) ? true : false;

			if ( $useWatermark && $multiprofile->watermark ) {
				JFile::copy($storageImage, JPATH_ROOT .'/images/watermarks/original' .'/'. md5($my->id . '_avatar') . CImageHelper::getExtension($file['type']));
				JFile::copy($storageThumbnail, JPATH_ROOT .'/images/watermarks/original' .'/'. md5($my->id . '_thumb') . CImageHelper::getExtension($file['type']));

				$watermarkPath = JPATH_ROOT .'/'. CString::str_ireplace('/', '/' , $multiprofile->watermark);

				list($watermarkWidth, $watermarkHeight)	= getimagesize($watermarkPath);
				list($avatarWidth, $avatarHeight)		= getimagesize($storageImage);
				list($thumbWidth, $thumbHeight)			= getimagesize($storageThumbnail);

				$watermarkImage		= $storageImage;
				$watermarkThumbnail	= $storageThumbnail;

				// Avatar Properties
				$avatarPosition = CImageHelper::getPositions($multiprofile->watermark_location, $avatarWidth, $avatarHeight, $watermarkWidth, $watermarkHeight);

				// The original image file will be removed from the system once it generates a new watermark image.
				CImageHelper::addWatermark($storageImage, $watermarkImage, $file['type'], $watermarkPath, $avatarPosition->x, $avatarPosition->y);

				//Thumbnail Properties
				$thumbPosition = CImageHelper::getPositions($multiprofile->watermark_location, $thumbWidth, $thumbHeight, $watermarkWidth, $watermarkHeight);

				// The original thumbnail file will be removed from the system once it generates a new watermark image.
				CImageHelper::addWatermark($storageThumbnail, $watermarkThumbnail, $file['type'], $watermarkPath, $thumbPosition->x, $thumbPosition->y);

				$my->set('_watermark_hash', $multiprofile->watermark_hash);
				$my->save();
			}

			// Generate stream
			// Generate activity stream.
			$act               = new stdClass();
			$act->cmd          = 'profile.avatar.upload';
			$act->actor        = $userid;
			$act->target       = 0;
			$act->title        = '';
			$act->content      = '';
			$act->app          = 'profile.avatar.upload';
			$act->cid          = 0;
			$act->comment_id   = CActivities::COMMENT_SELF;
			$act->comment_type = 'profile.avatar.upload';

			$act->like_id      = CActivities::LIKE_SELF;;
			$act->like_type    = 'profile.avatar.upload';

			// We need to make a copy of current avatar and set it as stream 'attachement'
			// which will only gets deleted once teh stream is deleted
			$params = new JRegistry();

			JFile::copy($image, $imageAttachment);
			$params->set('attachment', $imageAttachment);

			// Add activity logging
			CActivityStream::add($act, $params->toString());

		}

		if (empty($saveAction)) {
			$cTable->setImage($image, 'avatar');
			$cTable->setImage($thumbnail, 'thumb');
		} else {
			// This is for event recurring save option ( current / future event )
			$cTable->setImage($image, 'avatar', $saveAction);
			$cTable->setImage($thumbnail, 'thumb', $saveAction);
		}

		// add points
		switch ($type) {
		 	case 'profile':
		 		CUserPoints::assignPoint('profile.avatar.upload');
		 		break;
		 	case 'group':
		 		CUserPoints::assignPoint('group.avatar.upload');
		 		break;

		 	case 'event':
		 		CUserPoints::assignPoint('events.avatar.upload');
		 		break;
		 }
		$this->_showUploadError(false, $cTable->getAvatar(), CUrlHelper::avatarURI($thumbnail, 'user_thumb.png'));

	}

	public function ajaxUpdateThumbnail($type, $id, $sourceX, $sourceY, $width, $height)
	{
		$filter = JFilterInput::getInstance();

		$type = $filter->clean($type, 'string');
		$id = $filter->clean($id, 'integer');
		$sourceX = $filter->clean($sourceX, 'float');
		$sourceY = $filter->clean($sourceY, 'float');
		$width = $filter->clean($width, 'float');
		$height = $filter->clean($height, 'float');

		$objResponse = new JAXResponse();

		$cTable = JTable::getInstance(ucfirst($type), 'CTable');
		$cTable->load($id);

		$srcPath = JPATH_ROOT .'/'. $cTable->avatar;
		$destPath = JPATH_ROOT .'/'. $cTable->thumb;

		$srcPath = str_replace('/', '/' , $srcPath);
		$destPath = str_replace('/', '/' , $destPath);

		$info = getimagesize($srcPath);
		$destType = $info['mime'];

		$destWidth = COMMUNITY_SMALL_AVATAR_WIDTH;
		$destHeight = COMMUNITY_SMALL_AVATAR_WIDTH;

		$currentWidth = $width;
		$currentHeight = $height;


		CImageHelper::resize($srcPath, $destPath, $destType, $destWidth, $destHeight, $sourceX, $sourceY, $currentWidth, $currentHeight);

		return $objResponse->sendResponse();
	}

	/**
	 * Full application view
	 */
	public function app()
	{
		$view = $this->getView('photos');
		echo $view->get('appFullView');
	}
}

abstract class CommunityControllerPhotoHandler
{
	protected $type = '';
	protected $model = '';
	protected $view = '';
	protected $my = '';

	abstract public function getType();

	abstract public function getAlbumPath($albumId);

	abstract public function getEditedAlbumURL($albumId);

	abstract public function getUploaderURL($albumId);

	abstract public function getOriginalPath($storagePath, $albumPath, $albumId);

	abstract public function getLocationPath($storagePath, $albumPath, $albumId);

	abstract public function getThumbPath($storagePath, $albumId);

	abstract public function getStoredPath($storagePath, $albumId);

	abstract public function getAlbumURI($albumId, $route = true);

	//abstract public function getPhotoURI( $albumId , $photoId, $route = true );
	abstract public function getUploadActivityTitle();

	abstract public function bindAlbum(CTableAlbum $album, $postData);

	abstract public function hasPermission($albumId, $groupid = 0);

	abstract public function canPostActivity($albumId);

	abstract public function isAllowedAlbumCreation();

	abstract public function isWallsAllowed($photoId);

	abstract public function isExceedUploadLimit();

	abstract public function isPublic($albumId);

	public function __construct()
	{
		$this->my = CFactory::getUser();
		$this->model = CFactory::getModel('photos');
	}
}

class CommunityControllerPhotoUserHandler extends CommunityControllerPhotoHandler
{
	public function __construct()
	{
		parent::__construct();
	}

	public function canPostActivity($albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		if ($album->permissions <= PRIVACY_PUBLIC) {
			return true;
		}
		return false;
	}

	public function isWallsAllowed($photoId)
	{


		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);
		$config = CFactory::getConfig();
		$isConnected = CFriendsHelper::isConnected($this->my->id, $photo->creator);
		$isMe = COwnerHelper::isMine($this->my->id, $photo->creator);

		// Check if user is really allowed to post walls on this photo.
		if (($isMe) || (!$config->get('lockprofilewalls')) || ($config->get('lockprofilewalls') && $isConnected) || COwnerHelper::isCommunityAdmin()) {
			return true;
		}
		return false;
	}

	public function isAllowedAlbumCreation()
	{
		return true;
	}

	public function getUploadActivityTitle()
	{
		return 'COM_COMMUNITY_ACTIVITIES_UPLOAD_PHOTO';
	}

	public function isPublic($albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		return $album->permissions <= PRIVACY_PUBLIC;
	}

	/*
	public function getPhotoURI( $albumId , $photoId, $route = true)
	{
		$photo			= JTable::getInstance( 'Photo' , 'CTable' );
		$photo->load( $photoId );

		$url = 'index.php?option=com_community&view=photos&task=photo&albumid=' . $albumId .  '&userid=' . $photo->creator . '#photoid=' . $photoId;
		$url = $route ? CRoute::_( $url ): $url;

		return $url;
	}
	*/

	public function getAlbumURI($albumId, $route = true)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$url = 'index.php?option=com_community&view=photos&task=album&albumid=' . $albumId . '&userid=' . $album->creator;
		$url = $route ? CRoute::_($url) : $url;

		return $url;
	}

	public function getStoredPath($storagePath, $albumId)
	{
		$path = $storagePath .'/photos' .'/'. $this->my->id;
		return $path;
	}

	public function getThumbPath($storagePath, $albumId)
	{
		$path = $storagePath .'/photos' .'/'. $this->my->id;

		return $path;
	}

	public function isExceedUploadLimit($display = true)
	{


		if (CLimitsHelper::exceededPhotoUpload($this->my->id, PHOTOS_USER_TYPE)) {
			$config = CFactory::getConfig();
			$photoLimit = $config->get('photouploadlimit');

			if ($display) {
				echo JText::sprintf('COM_COMMUNITY_PHOTOS_UPLOAD_LIMIT_REACHED', $photoLimit);
				return true;
			} else {
				return true;
			}
		}
		return false;
	}

	public function getLocationPath($storagePath, $albumPath, $albumId)
	{
		$path = (empty($albumPath)) ? $storagePath .'/photos' .'/'. $this->my->id : $storagePath .'/photos' .'/'. $this->my->id .'/'. $albumId;
		return $path;
	}

	public function getOriginalPath($storagePath, $albumPath, $albumId)
	{
		$config = CFactory::getConfig();

		$path = $storagePath .'/'. JPath::clean($config->get('originalphotopath')) .'/'. $this->my->id .'/'. $albumPath;

		return $path;
	}

	public function getUploaderURL($albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		return CRoute::_('index.php?option=com_community&view=photos&task=uploader&albumid=' . $album->id . '&userid=' . $album->creator, false);
	}

	public function getEditedAlbumURL($albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		return CRoute::_('index.php?option=com_community&view=photos&task=myphotos&userid=' . $album->creator, false);
	}

	public function getType()
	{
		return PHOTOS_USER_TYPE;
	}

	public function bindAlbum(CTableAlbum $album, $postData)
	{
		$album->bind($postData);

		return $album;
	}

	public function getAlbumPath($albumId)
	{
		$config = CFactory::getConfig();
		$storage = JPATH_ROOT .'/'. $config->getString('photofolder');
		$albumPath = $storage .'/photos' .'/'. $this->my->id .'/'. $albumId;

		return $albumPath;
	}

	public function hasPermission($albumId, $groupid = 0)
	{


		return $this->my->authorise('community.manage', 'photos.user.album.' . $albumId);
	}
}

class CommunityControllerPhotoGroupHandler extends CommunityControllerPhotoHandler
{
	private $groupid = null;

	public function __construct()
	{
		$this->groupid = JRequest::getInt('groupid', '', 'REQUEST');
		parent::__construct();
	}

	public function canPostActivity($albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);


		$group = JTable::getInstance('Group', 'CTable');
		$group->load($album->groupid);

		if ($group->approvals != COMMUNITY_PRIVATE_GROUP) {
			return true;
		}
		return false;
	}

	public function isWallsAllowed($photoId)
	{


		$photo = JTable::getInstance('Photo', 'CTable');
		$photo->load($photoId);

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($photo->albumid);

		if (CGroupHelper::allowPhotoWall($album->groupid)) {
			return true;
		}
		return false;
	}

	public function isAllowedAlbumCreation()
	{


		$allowManagePhotos = CGroupHelper::allowManagePhoto($this->groupid);

		return $allowManagePhotos;
	}

	public function getUploadActivityTitle()
	{
		return 'COM_COMMUNITY_ACTIVITIES_GROUP_UPLOAD_PHOTO';
	}

	public function isPublic($albumId)
	{


		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$group = JTable::getInstance('Group', 'CTable');
		$group->load($album->groupid);

		return $group->approvals == COMMUNITY_PUBLIC_GROUP;
	}

	public function getAlbumURI($albumId, $route = true)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$url = 'index.php?option=com_community&view=photos&task=album&albumid=' . $albumId . '&groupid=' . $album->groupid;
		$url = $route ? CRoute::_($url) : $url;

		return $url;
	}

	public function getStoredPath($storagePath, $albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);
		$path = $storagePath .'/groupphotos' .'/'. $album->groupid;

		return $path;
	}

	public function getThumbPath($storagePath, $albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$path = $storagePath .'/groupphotos' .'/'. $album->groupid;
		return $path;
	}

	public function getLocationPath($storagePath, $albumPath, $albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$path = $storagePath .'/groupphotos' .'/'. $album->groupid .'/'. $albumId;
		return $path;
	}

	public function isExceedUploadLimit($display = true)
	{
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;
		$albumId = $jinput->request->get('albumid', '', 'INT');

		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);


		if (CLimitsHelper::exceededPhotoUpload($album->groupid, PHOTOS_GROUP_TYPE)) {
			$config = CFactory::getConfig();
			$photoLimit = $config->get('groupphotouploadlimit');

			if ($display) {
				echo JText::sprintf('COM_COMMUNITY_GROUPS_PHOTO_LIMIT', $photoLimit);
				return true;
			} else {
				return true;
			}
		}

		return false;
	}

	public function getOriginalPath($storagePath, $albumPath, $albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		$config = CFactory::getConfig();
		$path = $storagePath .'/'. JPath::clean($config->get('originalphotopath')) .'/groupphotos' .'/'. $album->groupid .'/'. $albumPath;

		return $path;
	}

	public function getUploaderURL($albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		return CRoute::_('index.php?option=com_community&view=photos&task=uploader&albumid=' . $album->id . '&groupid=' . $album->groupid, false);
	}

	public function getEditedAlbumURL($albumId)
	{
		$album = JTable::getInstance('Album', 'CTable');
		$album->load($albumId);

		return CRoute::_('index.php?option=com_community&view=photos&groupid=' . $album->groupid, false);
	}

	public function getType()
	{
		return PHOTOS_GROUP_TYPE;
	}

	/**
	 * Binds posted data into existing album object
	 **/
	public function bindAlbum(CTableAlbum $album, $postData)
	{
		$album->bind($postData);

		$album->groupid = $this->groupid;

		// Group photo should always follow the group permission.
		$group = JTable::getInstance('Group', 'CTable');
		$group->load($album->groupid);
		$album->permissions = $group->approvals ? PRIVACY_GROUP_PRIVATE_ITEM : 0;

		return $album;
	}

	public function getAlbumPath($albumId)
	{
		$config = CFactory::getConfig();
		$storage = JPATH_ROOT .'/'. $config->getString('photofolder');

		return $storage .'/groupphotos' .'/'. $this->groupid .'/'. $albumId;
	}

	public function hasPermission($albumId, $groupid = 0)
	{



		$group = JTable::getInstance('Group', 'CTable');
		$group->load($groupid);

		return $this->my->authorise('community.manage', 'photos.group.album.' . $albumId, $group);
	}
}

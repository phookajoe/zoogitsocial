<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php 
 */
defined('_JEXEC') or die();
?>
<textarea id="wall-edit-<?php echo $id;?>" name="message" style="width: 95%; margin-bottom: 5px"><?php echo $message; ?></textarea>
<input type="button" class="cButton cButton-Small cButton-Blue" value="<?php echo JText::_('COM_COMMUNITY_SAVE');?>"   onclick="joms.walls.save('<?php echo $id;?>' , '<?php echo $editableFunc;?>');" />
<input type="button" class="cButton cButton-Small" value="<?php echo JText::_('COM_COMMUNITY_CANCEL');?>" onclick="joms.walls.edit('<?php echo $id;?>' , '<?php echo $editableFunc;?>');" />
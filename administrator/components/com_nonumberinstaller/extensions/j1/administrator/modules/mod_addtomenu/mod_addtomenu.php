<?php
/**
 * Main Module File
 * Does all the magic!
 *
 * @package         Add to Menu
 * @version         2.2.6
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

/**
 * Module that adds menu items
 */

// return if NoNumber Framework plugin is not installed
jimport('joomla.filesystem.file');
if (!JFile::exists(JPATH_PLUGINS . '/system/nnframework/nnframework.php')) {
	return;
}

jimport('joomla.filesystem.folder');
$option = JRequest::getCmd('option');
$folder = JPATH_ADMINISTRATOR . '/components/' . $option . '/addtomenu';
if (!JFolder::exists($folder)) {
	$folder = JPATH_ADMINISTRATOR . '/modules/mod_addtomenu/addtomenu/components/' . $option;
}
if (!JFolder::exists($folder)) {
	return;
}

// Include the syndicate functions only once
require_once __DIR__ . '/addtomenu/helper.php';

$helper = new modAddToMenu($params);
$helper->render();

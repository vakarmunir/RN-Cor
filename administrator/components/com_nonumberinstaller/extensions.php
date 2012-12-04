<?php
/**
 * Install File
 * Does the stuff for the specific extensions
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

$name = 'Add to Menu';
$alias = 'addtomenu';
$ext = $name . ' (administrator module)';

// MODULE
$states[] = installExtension($states, $alias, $name, 'module', array('access' => '3'), 1);

/* >>> [J1] >>> */
// Stuff to do after installation / update
// For Joomla 1.5
function afterInstall_j1(&$db)
{
	// Place module in correct position
	$query = "UPDATE `#__modules`
		SET `access` = 2
		WHERE `module` = 'mod_addtomenu'";
	$db->setQuery($query);
	$db->query();
}
/* <<< [J1] <<< */

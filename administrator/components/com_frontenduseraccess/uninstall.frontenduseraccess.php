<?php
/**
* @package Frontend-User-Access (com_frontenduseraccess)
* @version 4.1.6
* @copyright Copyright (C) 2008-2012 Carsten Engel. All rights reserved.
* @license GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html 
* @author http://www.pages-and-items.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

function com_uninstall(){ 

	$database = JFactory::getDBO();		
	/*
	$database->setQuery( "SELECT id, params "
	. "\nFROM #__modules "				
	. "\nWHERE client_id='0' "		
	);		
	$modules = $database->loadObjectList();
	
	foreach($modules as $module){			
		$id = $module->id;
		$params = $module->params;								
		$classname = 'frontend_user_access_module_hide_'.$id.'_';							
		if(strpos($params, $classname)){							
			$params = str_replace($classname,'',$params);
			$database->setQuery( "UPDATE #__modules SET params='$params' WHERE id='$id' ");
			$database->query();	
		}					
	}
	
	
	//delete content plugin
	$plugin_php = JPATH_PLUGINS.DS.'content'.DS.'frontenduseraccess'.DS.'frontenduseraccess.php';
	$plugin_xml = JPATH_PLUGINS.DS.'content'.DS.'frontenduseraccess'.DS.'frontenduseraccess.xml';
	$content_plugin_success = 0;
	if(file_exists($plugin_php) && file_exists($plugin_xml)){
		$content_plugin_success = JFile::delete($plugin_php);
		JFile::delete($plugin_xml);
	}	
	if($content_plugin_success){
		echo '<p style="color: #5F9E30;">content plugin succesfully uninstalled</p>';		
	}else{
		echo '<p style="color: red;">could not uninstall content plugin</p>';
	}   
	$database->setQuery("DELETE FROM #__extensions WHERE type='plugin' AND folder='content' AND element='frontenduseraccess' LIMIT 1");
    $database->query();	
	*/
	
	//delete system plugin
	$plugin_php = JPATH_PLUGINS.DS.'system'.DS.'frontenduseraccess'.DS.'frontenduseraccess.php';
	$plugin_xml = JPATH_PLUGINS.DS.'system'.DS.'frontenduseraccess'.DS.'frontenduseraccess.xml';
	$content_plugin_success = 0;
	if(file_exists($plugin_php) && file_exists($plugin_xml)){
		$content_plugin_success = JFile::delete($plugin_php);
		JFile::delete($plugin_xml);
	}
	if($content_plugin_success){
		echo '<p style="color: #5F9E30;">system plugin succesfully uninstalled</p>';		
	}else{
		echo '<p style="color: red;">could not uninstall system plugin</p>';
	}   
	$database->setQuery("DELETE FROM #__extensions WHERE type='plugin' AND folder='system' AND element='frontenduseraccess' LIMIT 1");
    $database->query();	
	
	//delete user plugin
	$plugin_php = JPATH_PLUGINS.DS.'user'.DS.'frontenduseraccess'.DS.'frontenduseraccess.php';
	$plugin_xml = JPATH_PLUGINS.DS.'user'.DS.'frontenduseraccess'.DS.'frontenduseraccess.xml';
	$content_plugin_success = 0;
	if(file_exists($plugin_php) && file_exists($plugin_xml)){
		$content_plugin_success = JFile::delete($plugin_php);
		JFile::delete($plugin_xml);
	}
	if($content_plugin_success){
		echo '<p style="color: #5F9E30;">user plugin succesfully uninstalled</p>';		
	}else{
		echo '<p style="color: red;">could not uninstall user plugin</p>';
	}   
	$database->setQuery("DELETE FROM #__extensions WHERE type='plugin' AND folder='user' AND element='frontenduseraccess' LIMIT 1");
    $database->query();
	
}

?>
<div style="width: 500px; text-align: left;">
	<h2>Frontend-User-Access</h2>	
	<p>
		Thank you for having used Frontend-User-Access.
	</p>
	<p>
		Why did you uninstall Frontend-User-Access? Missing any features? <a href="http://www.pages-and-items.com/" target="_blank">Let us know</a>.		
	</p>	
	<p>
		Check <a href="http://www.pages-and-items.com/" target="_blank">www.pages-and-items.com</a> for:
		<ul>
			<li>updates</li>
			<li>support</li>
			<li>documentation</li>
			<li>email notification service for updates and new extensions</li>	
		</ul>
	</p>	
</div>
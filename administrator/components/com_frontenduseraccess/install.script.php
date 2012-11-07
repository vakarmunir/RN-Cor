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

class com_frontenduseraccessInstallerScript {

	function postflight($type, $parent){
		
		/*
		//give it time
		@set_time_limit(240);

		//give it memory
		$max_memory = trim(@ini_get('memory_limit'));
		if($max_memory){
			$end =strtolower($max_memory{strlen($max_memory) - 1});
			switch($end) {
				case 'g':
					$max_memory	*=	1024;
				case 'm':
					$max_memory	*=	1024;
				case 'k':
					$max_memory	*=	1024;
			}
			if ( $max_memory < 16000000 ) {
				@ini_set( 'memory_limit', '16M' );
			}
			if ( $max_memory < 32000000 ) {
				@ini_set( 'memory_limit', '32M' );
			}
			if ( $max_memory < 48000000 ) {
				@ini_set( 'memory_limit', '48M' );
			}
		}
		ignore_user_abort(true);		
		*/
		
		$database = JFactory::getDBO();	
		
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_partsaccess (
   `id` int(11) NOT NULL auto_increment,
  `part_group` VARCHAR( 200 ) NOT NULL,
  PRIMARY KEY  (`id`)
)");
	$database->query();
	
$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_parts (
   `id` int(11) NOT NULL auto_increment,
  `name` VARCHAR( 200 ) NOT NULL,
  `description` TINYTEXT NOT NULL,
  PRIMARY KEY  (`id`)
)");
	$database->query();	
	
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_components (
	  `id` int(11) NOT NULL auto_increment,
	  `component_groupid` mediumtext NOT NULL,
	  PRIMARY KEY  (`id`)
	)");
		$database->query();
		
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_items (
	  `id` int(11) NOT NULL auto_increment,
	  `itemid_groupid` tinytext NOT NULL,
	  PRIMARY KEY  (`id`)
	)");
		$database->query();
	
		//take this out for free version
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_menuaccess (
	   `id` int(11) NOT NULL auto_increment,
	  `menuid_groupid` tinytext NOT NULL,
	  PRIMARY KEY  (`id`)
	)");
		$database->query();
	
	//take this out for free version	
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_categories (
	   `id` int(11) NOT NULL auto_increment,
	  `category_groupid` tinytext NOT NULL,
	  PRIMARY KEY  (`id`)
	)");
		$database->query();
	
	//take this out for free version		
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_modules_two (
	   `id` int(11) NOT NULL auto_increment,
	  `module_groupid` mediumtext NOT NULL,
	  PRIMARY KEY  (`id`)
	)");
		$database->query();	
	
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_usergroups (
		   `id` int(11) NOT NULL auto_increment,
	  `name` tinytext NOT NULL,
	  `description` text NOT NULL,
	  `url` tinytext NOT NULL,
	  `ordering` int(11) NOT NULL,	
	   PRIMARY KEY  (`id`)
		)");
			$database->query();		
			
			
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_userindex (
		  `id` int(11) NOT NULL auto_increment,
		  `user_id` int(11) NOT NULL,
		  `group_id` VARCHAR( 5120 ) NOT NULL,
		  PRIMARY KEY  (`id`)
		)");
		$database->query();							
	
		//table for configuration
		$database->setQuery("CREATE TABLE IF NOT EXISTS #__fua_config (
	  `id` varchar(255) NOT NULL,
	  `config` text NOT NULL,
	  PRIMARY KEY  (`id`)  
	)");
		$database->query();
		
		//check if the default 2 usergroups are already there
		$database->setQuery("SELECT id FROM #__fua_usergroups WHERE id='9' LIMIT 1 ");
		$default_groups_installed = $database->loadResult();
		if(!$default_groups_installed){
			$database->setQuery("INSERT INTO #__fua_usergroups (`id`, `name`, `description`, `url`) VALUES
			(9, 'logged in', 'all logged in users who have not been assigned to any usergroup',''),
			(10, 'not logged in', 'all users whom are not logged in','')
			");
			$database->query();
		}		
		
		//check if config is empty, if so insert default config
		$database->setQuery("SELECT config FROM #__fua_config WHERE id='fua' ");
		$fua_config = $database->loadResult();
		
		if(!$fua_config){			
			$configuration = 'default_usergroup=
redirect_url=
items_active=
items_reverse_access=
items_multigroup_access_requirement=one_group
items_message_type=only_text
message_no_item_access_full=
message_no_item_access=
categories_active=
category_reverse_access=
category_multigroup_access_requirement=one_group
modules_active=
modules_reverse_access=
use_componentaccess=
component_reverse_access=
component_multigroup_access_requirement=one_group
components_message_type=only_text
message_no_component_access=
use_menuaccess=
menu_reverse_access=
menuaccess_message_type=only_text
message_no_menu_access=
truncate_article_title=80
no_item_access_full_url=index.php
no_component_access_url=index.php
no_menu_access_url=index.php
redirecting_enabled=true
modules_multigroup_access_requirement=one_group
menu_multigroup_access_requirement=one_group
enable_from_select_to_group=
from_select_to_group=
fua_enabled=1
version_checker=true
enable_from_select_to_group_update=
from_select_to_group_update=
content_access_together=every_group
parts_active=
parts_reverse_access=
parts_multigroup_access_requirement=one_group
parts_not_active=as_access
mod_menu_override=
';
			
			//insert fresh config
			$database->setQuery( "INSERT INTO #__fua_config SET id='fua', config='$configuration' ");
			$database->query();	
		}else{
			//there is a config already
			//update if needed
			$updated_config = $fua_config;
			$config_needs_updating = 0;	
			
			//'inline message' when no access to article in full view is deprecated, so change old config to 'message on blank page'
			if(!strpos($fua_config, 'items_message_type=inline_text')){	
				str_replace('items_message_type=inline_text', 'items_message_type=only_text', $updated_config);			
				$config_needs_updating = 1;
			}
			
			//added in version 4.1.0
			if(!strpos($fua_config, 'mod_menu_override=')){	
				$updated_config .= '
mod_menu_override=
';		
				$config_needs_updating = 1;
			}
			
			if($config_needs_updating){
				$database->setQuery( "UPDATE #__fua_config SET config='$updated_config' WHERE id='fua' ");
				$database->query();
			}
		
		}
		
		//cleanup users table after bug might have inserted "0"
		$database->setQuery("DELETE FROM #__fua_userindex WHERE group_id='\"0\"' ");
		$database->query();
		
		//install system plugin
		$plgSrc = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_frontenduseraccess'.DS.'plugin_system'.DS;
		$plgDst = JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'frontenduseraccess'.DS;
		if(!file_exists($plgDst)){
			mkdir($plgDst);	
		}
		$system_plugin_success = 0;
		$system_plugin_success = JFile::copy($plgSrc.'frontenduseraccess.php', $plgDst.'frontenduseraccess.php');
		JFile::copy($plgSrc.'frontenduseraccess.xml', $plgDst.'frontenduseraccess.xml');
		JFile::copy($plgSrc.'index.html', $plgDst.'index.html');
		
		if($system_plugin_success){
			echo '<p style="color: #5F9E30;">system plugin installed</p>';		
			//enable plugin
			$database->setQuery("SELECT extension_id, enabled FROM #__extensions WHERE type='plugin' AND element='frontenduseraccess' AND folder='system' LIMIT 1 ");
			$rows = $database->loadObjectList();
			$system_plugin_id = 0;
			$system_plugin_enabled = 0;
			foreach($rows as $row){	
				$system_plugin_id = $row->extension_id;
				$system_plugin_enabled = $row->enabled;
			}
			if($system_plugin_id){
				//plugin is already installed
				//if(!$system_plugin_enabled){
					//publish plugin
					$database->setQuery( "UPDATE #__extensions SET enabled='1', access='1', ordering='-29000' WHERE extension_id='$system_plugin_id' ");
					$database->query();
				//}
			}else{
				//insert plugin and enable it
				$manifest_cache = '{"legacy":false,"name":"System - Frontend User Access","type":"plugin","creationDate":"febuari 2011","author":"Carsten Engel","copyright":"Copyright (C) 2011 Carsten Engel, pages-and-items","authorEmail":"-","authorUrl":"www.pages-and-items.com","version":"4.0.0","description":"Enforces various access restrictions as set in component Frontend-User-Access. Don\'t forget to ENABLE this plugin. Make sure this plugin is first in the plugin order of the system plugins.","group":""}';
				$manifest_cache = addslashes($manifest_cache);
				$database->setQuery( "INSERT INTO #__extensions SET name='System - Frontend User Access', type='plugin', element='frontenduseraccess', folder='system', enabled='1', access='1', manifest_cache='$manifest_cache', ordering='-29000' ");
				$database->query();
			}
			echo '<p style="color: #5F9E30;">system plugin enabled</p>';		
		}else{
			echo '<p style="color: red;">system plugin not installed</p><p><a href="http://www.pages-and-items.com/extensions/frontend-user-access" target="_blank">download the system plugin</a> and install with the Joomla installer.</p>';
		}
		
		//install user plugin
		$plgSrc = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_frontenduseraccess'.DS.'plugin_user'.DS;
		$plgDst = JPATH_ROOT.DS.'plugins'.DS.'user'.DS.'frontenduseraccess'.DS;
		if(!file_exists($plgDst)){
			mkdir($plgDst);	
		}
		$user_plugin_success = 0;
		$user_plugin_success = JFile::copy($plgSrc.'frontenduseraccess.php', $plgDst.'frontenduseraccess.php');
		JFile::copy($plgSrc.'frontenduseraccess.xml', $plgDst.'frontenduseraccess.xml');
		JFile::copy($plgSrc.'index.html', $plgDst.'index.html');
		
		if($user_plugin_success){
			echo '<p style="color: #5F9E30;">user plugin installed</p>';		
			//enable plugin
			$database->setQuery("SELECT extension_id, enabled FROM #__extensions WHERE type='plugin' AND element='frontenduseraccess' AND folder='user' LIMIT 1 ");
			$rows = $database->loadObjectList();
			$user_plugin_id = 0;
			$user_plugin_enabled = 0;
			foreach($rows as $row){	
				$user_plugin_id = $row->extension_id;
				$user_plugin_enabled = $row->enabled;
			}
			if($user_plugin_id){
				//plugin is already installed
				//if(!$user_plugin_enabled){
					//publish plugin
					$database->setQuery( "UPDATE #__extensions SET enabled='1', access='1' WHERE extension_id='$user_plugin_id' ");
					$database->query();
				//}
			}else{
				//insert plugin and enable it
				$manifest_cache = '{"legacy":false,"name":"User - Frontend User Access","type":"plugin","creationDate":"febuari 2011","author":"Carsten Engel","copyright":"Copyright 2011 (C) Carsten Engel - Engelweb. All rights reserved.","authorEmail":"-","authorUrl":"www.pages-and-items.com","version":"4.0.0","description":"Sets the default Frontend-User-Access usergroup for new users, and redirects users on login from the frontend, as set in the Frontend-User-Access configuration.","group":""}';
				$manifest_cache = addslashes($manifest_cache);
				$database->setQuery( "INSERT INTO #__extensions SET name='User - Frontend User Access', type='plugin', element='frontenduseraccess', folder='user', enabled='1', access='1', manifest_cache='$manifest_cache' ");
				$database->query();
			}
			echo '<p style="color: #5F9E30;">user plugin enabled</p>';		
		}else{
			echo '<p style="color: red;">user plugin not installed</p><p><a href="http://www.pages-and-items.com/extensions/frontend-user-access" target="_blank">download the user plugin</a> and install with the Joomla installer.</p>';
		}
		
		//reset version checker session var
		$app = &JFactory::getApplication();
		$app->setUserState( "com_frontenduseraccess.latest_version_message", '' );
		
		//remove deprecated frontend-user-access css classes from all frontend modules
		$database->setQuery( "SELECT id, params "
		." FROM #__modules "				
		." WHERE client_id='0' "		
		);		
		$modules = $database->loadObjectList();		
		foreach($modules as $module){			
			$id = $module->id;
			$params = $module->params;								
			$classname = 'frontend_user_access_module_hide_'.$id.'_';							
			if(strpos($params, $classname)){							
				$params = str_replace(' '.$classname,'',$params);
				$database->setQuery( "UPDATE #__modules SET params='$params' WHERE id='$id' ");
				$database->query();	
			}					
		}	
		
	
						
	}
	
	function uninstall($installer){
		
    }
}

?>

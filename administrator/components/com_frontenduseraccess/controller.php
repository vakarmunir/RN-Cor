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

jimport('joomla.application.component.controller');

class frontenduseraccessController extends JController{

	public $fua_config;	
	public $view;	
	public $has_usergroups = false;
	public $usergroups;
	public $db;	
	public $bot_installed_system = false;
	public $bot_published_system = false;		
	public $bot_installed_user = false;
	public $bot_published_user = false;
	public $fua_demo_seconds_left;	
	public $version = '4.1.6';
	public $fua_version_type = 'free';	//free trial or pro	
	public $is_super_user = false;

	function display(){		
		
		$app = JFactory::getApplication();	
		
		//make sure mootools is loaded
		JHTML::_('behavior.mootools');
		
		// Set a default view if none exists			
		if(!$this->view){	
			$view_from_session = $app->getUserStateFromRequest('com_frontenduseraccess.menu', 'menu', 'usergroups', 'word');				
			JRequest::setVar('view', $view_from_session);					
		}	
		
		//save view in session		
		if(JRequest::getCmd('view')!='config' && JRequest::getCmd('view')!='batchassign' && JRequest::getCmd('view')!='usergroup'){			
			$app->setUserState('com_frontenduseraccess.menu', JRequest::getCmd('view'));	
		}
		
		//reset view in case it changed
		$this->view = JRequest::getCmd('view');	
				
		//set header		
		JToolBarHelper::title('Frontend User Access', 'fua_icon');
		
		// Load the submenu		
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_frontenduseraccess'.DS.'helpers'.DS.'frontenduseraccess.php';		
		frontenduseraccessHelper::addSubmenu(JRequest::getWord('view', 'frontenduseraccess'), $this->fua_config);
		
		parent::display();
				
	}
	
	
	function __construct(){	
		
		$this->fua_config = $this->get_config();				
		$this->view = JRequest::getVar('view');			
		$this->fua_check_trial_version();			
		$this->db = JFactory::getDBO();		
		
		//check if system plugins is installed and published	
		if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'frontenduseraccess'.DS.'frontenduseraccess.php')){
			$this->bot_installed_system = true;	
			//check if plugin is published	
			$this->db->setQuery("SELECT enabled FROM #__extensions WHERE type='plugin' AND element='frontenduseraccess' AND folder='system' LIMIT 1 ");
			$rows = $this->db->loadObjectList();
			foreach($rows as $row){					
				if($row->enabled==1){
					$this->bot_published_system = true;
				}
			}		
		}			
		
		//check if user plugins is installed and published	
		if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'user'.DS.'frontenduseraccess'.DS.'frontenduseraccess.php')){
			$this->bot_installed_user = true;	
			//check if plugin is published			
			$this->db->setQuery("SELECT enabled FROM #__extensions WHERE type='plugin' AND element='frontenduseraccess' AND folder='user' LIMIT 1 ");
			$rows = $this->db->loadObjectList();
			foreach($rows as $row){					
				if($row->enabled==1){
					$this->bot_published_user = true;
				}
			}		
		}
		
		//check for usergroups
		$usergroups = false;
		$this->db->setQuery("SELECT id FROM #__fua_usergroups WHERE id<>9 AND id<>10 LIMIT 1");
		$rows = $this->db->loadObjectList();		
		foreach($rows as $row){
			$this->has_usergroups = true;
		}
		
		//check if super user	
		$user = JFactory::getUser();			
		$user_id = $user->id;
		$this->db->setQuery("SELECT group_id FROM #__user_usergroup_map WHERE user_id='$user_id' AND group_id='8' LIMIT 1");
		$rows = $this->db->loadObjectList();		
		foreach($rows as $row){
			$this->is_super_user = true;
		}		
		
		parent::__construct();		
	}	
	
	function get_config(){	
			
		$database = JFactory::getDBO();			
		
		$database->setQuery("SELECT config "
		."FROM #__fua_config "
		."WHERE id='fua' "
		."LIMIT 1"
		);		
		$raw = $database->loadResult();			
		
		$params = explode( "\n", $raw);
		
		for($n = 0; $n < count($params); $n++){		
			$temp = explode('=',$params[$n]);
			$var = $temp[0];
			$value = '';
			if(count($temp)==2){
				$value = trim($temp[1]);
				if($value=='false'){
					$value = false;
				}
				if($value=='true'){
					$value = true;
				}
			}							
			$config[$var] = $value;	
		}	
		
		//reformat redirect urls		
		$config['redirect_url'] = str_replace('[equal]','=',$config['redirect_url']);
		$config['no_item_access_full_url'] = str_replace('[equal]','=',$config['no_item_access_full_url']);			
		$config['no_component_access_url'] = str_replace('[equal]','=',$config['no_component_access_url']);
		$config['no_menu_access_url'] = str_replace('[equal]','=',$config['no_menu_access_url']);
		$new_line = '
';				
		$config['from_select_to_group'] = str_replace('[newline]',$new_line,$config['from_select_to_group']);
		$config['from_select_to_group'] = str_replace('[equal]','=',$config['from_select_to_group']);
		$config['from_select_to_group_update'] = str_replace('[newline]',$new_line,$config['from_select_to_group_update']);
		$config['from_select_to_group_update'] = str_replace('[equal]','=',$config['from_select_to_group_update']);		
			
		return $config;			
	}
	
	function get_var($name, $default = null, $hash = 'default', $type = 'none', $mask = 0){	
		$var = JRequest::getVar($name, $default, $hash, $type, $mask);		
		return $var;
	}		
	
	function echo_header(){	
	
		$this->check_demo_time_left();			
		
		echo '<script src="components/com_frontenduseraccess/javascript/javascript.js" language="JavaScript" type="text/javascript"></script>'."\n";		
		echo '<link href="components/com_frontenduseraccess/css/frontenduseraccess.css" rel="stylesheet" type="text/css" />'."\n";		
		
		echo '<div id="fua_header_messages">';
		//message if disabled
		if(!$this->fua_config['fua_enabled']){
			echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_DISABLED_MESSAGE').' <a href="index.php?option=com_frontenduseraccess&view=config&tab=general_settings">'.JText::_('COM_FRONTENDUSERACCESS_CONFIG').'</a>.<br/><br/></div>';
		}	
		
		//message if there are no usergroups		
		if(!$this->has_usergroups && $this->view!='usergroup' && $this->view!='usergroups'){
			echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NOUSERGROUPS').' <a href="index.php?option=com_frontenduseraccess&view=usergroups">'.JText::_('COM_FRONTENDUSERACCESS_CREATE_USERGROUPS').'</a>.<br/><br/></div>';
		}			
		
		//message if bot is not installed	
		if(!$this->bot_installed_system){				
			echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTINSTALLED').' (system).<br/><br/></div>';
		}
		
		//message if bot is not published	
		if(!$this->bot_published_system){				
			echo '<div style="text-align: left;"><span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTPUBLISHED').' (system)';
			if($this->view!='usergroup'){
				echo ' <a href="index.php?option=com_frontenduseraccess&task=enable_plugin&type=system&from='.$this->view.'">'.JText::_('COM_FRONTENDUSERACCESS_ENABLE_PLUGIN').'</a>';
			}
			echo '.</span><br/><br/></div>';
		}		
		
		//message if userplugin is not installed	
		if(!$this->bot_installed_user){				
			echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTINSTALLED').' (user).<br/><br/></div>';
		}
		
		//message if userplugin is not published	
		if(!$this->bot_published_user){				
			echo '<div style="text-align: left;"><span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTPUBLISHED').' (user)';
			if($this->view!='usergroup'){
				echo ' <a href="index.php?option=com_frontenduseraccess&task=enable_plugin&type=user&from='.$this->view.'">'.JText::_('COM_FRONTENDUSERACCESS_ENABLE_PLUGIN').'</a>';
			}
			echo '.</span><br/><br/></div>';
		}		
		
		//message template codes		
		$helper = new frontenduseraccessHelper();	
		if($helper->check_templates()){
			echo '<div style="text-align: left;">'.JText::_('COM_FRONTENDUSERACCESS_TEMPLATE_CODES_FOUND').' <a href="index.php?option=com_frontenduseraccess&view=templates">'.JText::_('COM_FRONTENDUSERACCESS_TEMPLATES').'</a>.<br/><br/></div>';
		}
		
		//message if advanced module manager is installed and loaded before FUA system plugin
		if(file_exists(JPATH_PLUGINS.DS.'system'.DS.'advancedmodules'.DS.'advancedmodules.php')){
			
			//check if enabled and which order
			$this->db->setQuery("SELECT enabled, ordering "
			." FROM #__extensions "
			." WHERE element='advancedmodules' AND folder='system' "
			." LIMIT 1 "
			);
			$rows = $this->db->loadObjectList();
			$advanced_module_manager_published = 0;
			$advanced_module_manager_order = 0;
			foreach($rows as $row){					
				$advanced_module_manager_published = $row->enabled;
				$advanced_module_manager_order = $row->ordering;
			}
			
			if($advanced_module_manager_published){
			
				
				//check which order the FUA system plugin has
				$this->db->setQuery("SELECT ordering "
				." FROM #__extensions "
				." WHERE element='frontenduseraccess' AND folder='system' "
				." LIMIT 1 "
				);
				$rows = $this->db->loadObjectList();
				$fua_order = 0;
				foreach($rows as $row){					
					$fua_order = $row->ordering;
				}
				
				//if advanced_module_manager is enabled AND FUA is not loaded first in order, show message	
				if($fua_order >= $advanced_module_manager_order){	
					echo '<div style="text-align: left;"><span style="color: red;">'.JText::_('COM_FRONTENDUSERACCESS_ADVANCEDMODULEMANAGER_D').'    Advanced-Module-Manager (by noNumber) '.JText::_('COM_FRONTENDUSERACCESS_ADVANCEDMODULEMANAGER_B').' Frontend-User-Access system '.JText::_('COM_FRONTENDUSERACCESS_ADVANCEDMODULEMANAGER_C').'.</span> <a href="index.php?option=com_plugins&filter_type=system">'.JText::_('COM_FRONTENDUSERACCESS_PLUGIN_MANAGER').'</a>.<br/><br/></div>';
				}
			}
		}	
		
		//message if MetaMod is installed and loaded before FUA system plugin
		if(file_exists(JPATH_PLUGINS.DS.'system'.DS.'metamod'.DS.'metamod.php')){
			
			//check if enabled and which order
			$this->db->setQuery("SELECT enabled, ordering "
			." FROM #__extensions "
			." WHERE element='metamod' AND folder='system' "
			." LIMIT 1 "
			);
			$rows = $this->db->loadObjectList();
			$metamod_published = 0;
			$metamod_order = 0;
			foreach($rows as $row){					
				$metamod_published = $row->enabled;
				$metamod_order = $row->ordering;
			}
			
			if($metamod_published){			
				
				//check which order the FUA system plugin has
				$this->db->setQuery("SELECT ordering "
				." FROM #__extensions "
				." WHERE element='frontenduseraccess' AND folder='system' "
				." LIMIT 1 "
				);
				$rows = $this->db->loadObjectList();
				$fua_order = 0;
				foreach($rows as $row){					
					$fua_order = $row->ordering;
				}
				
				//if advanced_module_manager is enabled AND FUA is not loaded first in order, show message	
				if($fua_order >= $metamod_order){	
					echo '<div style="text-align: left;"><span style="color: red;">'.JText::_('COM_FRONTENDUSERACCESS_ADVANCEDMODULEMANAGER_D').' MetaMod '.JText::_('COM_FRONTENDUSERACCESS_ADVANCEDMODULEMANAGER_B').' Frontend-User-Access system '.JText::_('COM_FRONTENDUSERACCESS_ADVANCEDMODULEMANAGER_C').'.</span> <a href="index.php?option=com_plugins&filter_type=system">'.JText::_('COM_FRONTENDUSERACCESS_PLUGIN_MANAGER').'</a>.<br/><br/></div>';
				}		
			}
		}		
			
			
		//message if emiIE6warning is installed
		if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'emiIE6warning'.DS.'emiIE6warning.php')){
			if($this->check_emi_ie6_plugin()){			
				echo '<div style="color: red; text-align: left;">'.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_A').' emiIE6warning '.JText::_('COM_FRONTENDUSERACCESS_FROM').' emi.marsteam.net '.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_B').' <a href="http://www.pages-and-items.com/contribute/other-stuff/fix-for-plugin-emiie6warning" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_READ_MORE').'</a><br/><br/></div>';	
			}			
		}
		
		//message if ztools is installed and enabled
		if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'plg_ztools'.DS.'plg_ztools.php')){
			if($this->check_ztools_plugin()){			
				echo '<div style="color: red; text-align: left;">'.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_A').' ZT Tools '.JText::_('COM_FRONTENDUSERACCESS_FROM').' ZooTemplate '.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_B').' '.JText::_('COM_FRONTENDUSERACCESS_ZTOOLS_WARNING').'. '.JText::_('COM_FRONTENDUSERACCESS_NO_CACHE').'.  <a href="index.php?option=com_frontenduseraccess&task=disable_ztools">'.JText::_('COM_FRONTENDUSERACCESS_DISABLE_PLUGIN').'</a>.<br/><br/></div>';	
			}			
		}
		
		//message if T3 is installed and not altered to work with FUA
		if($this->view=='menuaccess'){
			if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'jat3'.DS.'jat3'.DS.'core'.DS.'menu'.DS.'base.class.php')){		
				if(!$this->check_t3_plugin()){						
					echo '<div style="color: red; text-align: left;"><a href="http://wiki.joomlart.com/wiki/JA_T3_Framework_2/Overview" target="_blank">JA T3 Framework</a> '.JText::_('COM_FRONTENDUSERACCESS_FROM').' Joomlart '.JText::_('COM_FRONTENDUSERACCESS_IS_INSTALLED').'. '.JText::_('COM_FRONTENDUSERACCESS_T_WARNING').'. <a href="http://www.pages-and-items.com/extensions/frontend-user-access/faqs/hide-menu-items-in-other-menu-modules-then-the-joomla-menu-module#item851" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_READ_MORE').'</a>.<br/><br/></div>';	
				}			
			}
		}
		
		//message if ubar is installed and contains bad code
		if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'ubar'.DS.'ubar.php')){
			if($this->check_ubar_plugin()){			
				echo '<div style="color: red; text-align: left;">'.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_A').' System - UserToolbar (uBar) '.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_B').'. <a href="http://www.pages-and-items.com/contribute/other-stuff/fix-for-plugin-ubar" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_READ_MORE').'</a>.<br/><br/></div>';	
			}			
		}
		
		//message if Access-Manager is installed
		if(file_exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_accessmanager'.DS.'controller.php')){		
			if($this->check_accessmanager_plugin()){			
				echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_A').' \'System - Access Manager\' '.JText::_('COM_FRONTENDUSERACCESS_EMI_WARNING_B').'. '.JText::_('COM_FRONTENDUSERACCESS_DISABLE_PLUGIN').' \'System - Access Manager\'.<br/><br/></div>';	
			}			
		}
		
		//message if JAT3 system plugin is installed and enabled and the cache is still on
		if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'jat3'.DS.'jat3.php')){			
			$templates_with_enabled_cache = $this->check_jat3_plugin_and_cache();
			if(count($templates_with_enabled_cache)){
				$template_string = implode('<br />', $templates_with_enabled_cache);			
				echo '<div style="text-align: left;" class="fua_red">jat3 template cache should be disabled in template(s):<br />'.$template_string.'<br/><br/></div>';	
			}			
		}
		
		//message if Aridatatables is installed and not altered to work with FUA
		$file = JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'aridatatables'.DS.'kernel'.DS.'Module'.DS.'class.ModuleHelper.php';
		if(file_exists($file)){		
			if($this->check_aridatatables($file)){						
				echo '<div style="color: red; text-align: left;">content plugin aridatatables is installed and contains code which will cause errors <a href="http://www.pages-and-items.com/contribute/other-stuff/fix-for-aridatatables" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_READ_MORE').'</a>.<br/><br/></div>';	
			}			
		}
		$file = JPATH_ROOT.DS.'modules'.DS.'mod_aridatatables'.DS.'includes'.DS.'kernel'.DS.'Module'.DS.'class.ModuleHelper.php';
		if(file_exists($file)){		
			if($this->check_aridatatables($file)){						
				echo '<div style="color: red; text-align: left;">module aridatatables is installed and contains code which will cause errors <a href="http://www.pages-and-items.com/contribute/other-stuff/fix-for-aridatatables" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_READ_MORE').'</a>.<br/><br/></div>';	
			}			
		}
		
		echo '</div>';
		
	}		
	
	function usergroup_save(){			
			
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		//get vars
		$id = intval($this->get_var('id', 0, 'post'));
		$name = strip_tags($this->get_var('name', '', 'post'));
		$description = strip_tags($this->get_var('description', '', 'post'));
		$url = $this->get_var('url', '', 'post');		
		$name = addslashes($name);
		$description = addslashes($description);
			
		
		if($id==0){
			//new usergroup
			$this->db->setQuery( "INSERT INTO #__fua_usergroups SET name='$name', description='$description', url='$url' ");
			$this->db->query();
		}else{
			//edit usergroup
			$this->db->setQuery( "UPDATE #__fua_usergroups SET name='$name', description='$description', url='$url' WHERE id='$id' ");
			$this->db->query();
		}	
		
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=usergroups", JText::_('COM_FRONTENDUSERACCESS_USERGROUP_SAVED'));
	}	
	
	function usergroup_delete(){	
		
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');			
		
		$cid = JRequest::getVar('cid', null, 'post', 'array');		
		
		if (!is_array($cid) || count($cid) < 1) {
			echo "<script> alert(".JText::_('COM_FRONTENDUSERACCESS_SELECT_ITEM_TO_DELETE')."); window.history.go(-1);</script>";
			exit();
		}
		
		if (count($cid)){
			$ids = implode(',', $cid);			
			
			//update rows from user-index table which usergroup stops existing
			$this->db->setQuery("SELECT id FROM #__fua_userindex WHERE group_id IN ($ids)"  );
			$rows = $this->db ->loadObjectList();
			foreach($rows as $row){					
				$index_id = $row->id;
				$this->db->setQuery( "UPDATE #__fua_userindex SET group_id='0' WHERE id='$index_id'");
				$this->db->query();
			}		
			
			//delete usergroup
			$this->db->setQuery("DELETE FROM #__fua_usergroups WHERE id IN ($ids)");
			$this->db->query();
		}
		
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=usergroups", JText::_('COM_FRONTENDUSERACCESS_USERGROUP_DELETED'));
	}
	
	function components_save(){
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		$components_access_hidden = JRequest::getVar('components_access_hidden', null, 'post', 'array');		
		
		//get current component access
		$this->db->setQuery("SELECT component_groupid FROM #__fua_components");
		$access_components = $this->db->loadResultArray();
		
		//write component access	
		for($n = 0; $n < count($components_access_hidden); $n++){
			$value = $components_access_hidden[$n];
			$value_array = explode('__',$value);
			$right = $value_array[0].'__'.$value_array[1];			
			$selected = $value_array[3];
			
			//if right is now selected, but was not in table, do insert
			if($selected && !in_array($right,$access_components)){
				$this->db->setQuery( "INSERT INTO #__fua_components SET component_groupid='$right'");
				$this->db->query();
			}
			
			//if right is not selected, but was in table, take it out
			if(!$selected && in_array($right,$access_components)){				
				$this->db->setQuery("DELETE FROM #__fua_components WHERE component_groupid='$right'");
				$this->db->query();
			}
		}		
			
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=components", JText::_('COM_FRONTENDUSERACCESS_COMPONENT_ACCESS_SAVED'));
	}			
		
	function config_save(){
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
	
		$message_no_item_access_full = JRequest::getVar('message_no_item_access_full', '', 'post');
		$message_no_item_access_full = str_replace('"','&quot;',$message_no_item_access_full);
		$message_no_item_access = JRequest::getVar('message_no_item_access', '', 'post');
		$message_no_item_access = str_replace('"','&quot;',$message_no_item_access);					
		$message_no_component_access = JRequest::getVar('message_no_component_access', '', 'post');
		$message_no_component_access = str_replace('"','&quot;',$message_no_component_access);	
		$message_no_menu_access = JRequest::getVar('message_no_menu_access', '', 'post');
		$message_no_menu_access = str_replace('"','&quot;',$message_no_menu_access);
		$message_no_dowload_access = JRequest::getVar('message_no_dowload_access', '', 'post');
		$message_no_dowload_access = str_replace('"','&quot;',$message_no_dowload_access);		
		$redirect_url = JRequest::getVar('redirect_url', '', 'post');
		$redirect_url = str_replace('=','[equal]',$redirect_url);
		$no_item_access_full_url = JRequest::getVar('no_item_access_full_url', '', 'post');
		$no_item_access_full_url = str_replace('=','[equal]',$no_item_access_full_url);			
		$no_component_access_url = JRequest::getVar('no_component_access_url', '', 'post');
		$no_component_access_url = str_replace('=','[equal]',$no_component_access_url);
		$no_menu_access_url = JRequest::getVar('no_menu_access_url', '', 'post');
		$no_menu_access_url = str_replace('=','[equal]',$no_menu_access_url);
		$no_download_access_url = JRequest::getVar('no_download_access_url', '', 'post');
		$no_download_access_url = str_replace('=','[equal]',$no_download_access_url);		
		$default_usergroup = JRequest::getVar('default_usergroup', array(), 'post', 'array');
		//filter 0 out
		if(in_array(0, $default_usergroup)){
			$temp = array();
			foreach($default_usergroup as $group){
				if($group!=0){				
					$temp[] = $group;
				}
			}
			$default_usergroup = $temp;
		}		
		sort($default_usergroup);
		
		$new_line = '
';
		
		//make into csv string
		$default_usergroup = $this->array_to_csv($default_usergroup);	
		$from_select_to_group = JRequest::getVar('from_select_to_group','','post','string', JREQUEST_ALLOWRAW);
		$from_select_to_group = str_replace('=','[equal]',$from_select_to_group);
		$from_select_to_group = str_replace($new_line,'[newline]',$from_select_to_group);
		$from_select_to_group = addslashes($from_select_to_group);	
		
		$from_select_to_group_update = JRequest::getVar('from_select_to_group_update','','post','string', JREQUEST_ALLOWRAW);
		$from_select_to_group_update = str_replace('=','[equal]',$from_select_to_group_update);
		$from_select_to_group_update = str_replace($new_line,'[newline]',$from_select_to_group_update);
		$from_select_to_group_update = addslashes($from_select_to_group_update);	
						
				$config = 'default_usergroup='.$default_usergroup.'
redirecting_enabled='.JRequest::getVar('redirecting_enabled', '', 'post').'
redirect_url='.$redirect_url.'
items_active='.JRequest::getVar('items_active', '', 'post').'
items_reverse_access='.JRequest::getVar('items_reverse_access', '', 'post').'
items_multigroup_access_requirement='.JRequest::getVar('items_multigroup_access_requirement', 'one_group', 'post').'
items_message_type='.JRequest::getVar('items_message_type', 'alert', 'post').'
no_item_access_full_url='.$no_item_access_full_url.'
message_no_item_access_full='.addslashes($message_no_item_access_full).'
message_no_item_access='.addslashes($message_no_item_access).'
truncate_article_title='.JRequest::getVar('truncate_article_title', '', 'post').'
categories_active='.JRequest::getVar('categories_active', '', 'post').'
category_reverse_access='.JRequest::getVar('category_reverse_access', '', 'post').'
category_multigroup_access_requirement='.JRequest::getVar('category_multigroup_access_requirement', 'one_group', 'post').'
modules_active='.JRequest::getVar('modules_active', '', 'post').'
modules_reverse_access='.JRequest::getVar('modules_reverse_access', '', 'post').'
modules_multigroup_access_requirement='.JRequest::getVar('modules_multigroup_access_requirement', 'one_group', 'post').'
use_componentaccess='.JRequest::getVar('use_componentaccess', '', 'post').'
component_reverse_access='.JRequest::getVar('component_reverse_access', '', 'post').'
component_multigroup_access_requirement='.JRequest::getVar('component_multigroup_access_requirement', 'one_group', 'post').'
components_message_type='.JRequest::getVar('components_message_type', 'alert', 'post').'
message_no_component_access='.addslashes($message_no_component_access).'
no_component_access_url='.$no_component_access_url.'
use_menuaccess='.JRequest::getVar('use_menuaccess', '', 'post').'
menu_reverse_access='.JRequest::getVar('menu_reverse_access', '', 'post').'
menu_multigroup_access_requirement='.JRequest::getVar('menu_multigroup_access_requirement', 'one_group', 'post').'
menuaccess_message_type='.JRequest::getVar('menuaccess_message_type', 'text', 'post').'
message_no_menu_access='.addslashes($message_no_menu_access).'
no_menu_access_url='.$no_menu_access_url.'
enable_from_select_to_group='.JRequest::getVar('enable_from_select_to_group', '', 'post').'
from_select_to_group='.$from_select_to_group.'
fua_enabled='.JRequest::getVar('fua_enabled', '0', 'post', 'int').'
enable_from_select_to_group_update='.JRequest::getVar('enable_from_select_to_group_update', '', 'post').'
from_select_to_group_update='.$from_select_to_group_update.'
version_checker='.JRequest::getVar('version_checker', '', 'post').'
content_access_together='.JRequest::getVar('content_access_together', 'every_group', 'post').'
parts_active='.JRequest::getVar('parts_active', '', 'post').'
parts_reverse_access='.JRequest::getVar('parts_reverse_access', '', 'post').'
parts_multigroup_access_requirement='.JRequest::getVar('parts_multigroup_access_requirement', 'one_group', 'post').'
parts_not_active='.JRequest::getVar('parts_not_active', '', 'post').'
mod_menu_override='.JRequest::getVar('mod_menu_override', '', 'post').'
';

		//update config
		$this->db->setQuery( "UPDATE #__fua_config SET config='$config' WHERE id='fua' ");
		$this->db->query();	
		
		/*
		//if module access is enabled, make sure classnames are correct
		if(JRequest::getVar('modules_active', '', 'post') && JRequest::getVar('fua_enabled', '0', 'post', 'int')){
			$this->module_classes();
		}else{
			//module access disabled, so take classnames out
			$this->module_classes_remove();
		}
		*/
		
		//redirect			
		if(JRequest::getVar('sub_task', '')=='apply'){
			$url = 'index.php?option=com_frontenduseraccess&view=config';
		}else{
			$url = 'index.php?option=com_frontenduseraccess';
		}	
		$this->setRedirect($url, JText::_('COM_FRONTENDUSERACCESS_CONFIGSAVED'));
	}		

	function display_footer(){	
		
		echo '<div class="smallgrey" id="ua_footer">';
		echo '<table>';
		echo '<tr>';
		echo '<td class="text_right">';
		echo '<a href="http://www.pages-and-items.com" target="_blank">Frontend-User-Access</a>';
		echo '</td>';
		echo '<td class="five_pix">';
		echo '&copy;';
		echo '</td>';
		echo '<td>';
		echo '2008 - 2012 Carsten Engel';		
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="text_right">';
		echo $this->fua_strtolower(JText::_('JVERSION'));
		echo '</td>';
		echo '<td class="five_pix">';
		echo '=';
		echo '</td>';
		echo '<td>';
		echo $this->version.' ('.$this->fua_version_type.' '.$this->fua_strtolower(JText::_('JVERSION')).')';
		if($this->fua_version_type!='trial'){
			echo ' <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="blank">GNU/GPL License</a>';
		}
		echo '</td>';
		echo '</tr>';
		//version checker
		if($this->fua_config['version_checker']){
			echo '<tr>';
			echo '<td class="text_right">';
			echo $this->fua_strtolower(JText::_('COM_FRONTENDUSERACCESS_LATEST_VERSION'));
			echo '</td>';
			echo '<td class="five_pix">';
			echo '=';
			echo '</td>';
			echo '<td>';
			$app = JFactory::getApplication();
			$latest_version_message = $app->getUserState( "com_frontenduseraccess.latest_version_message", '');
			if($latest_version_message==''){
				$latest_version_message = JText::_('COM_FRONTENDUSERACCESS_VERSION_CHECKER_NOT_AVAILABLE');
				$url = 'http://www.pages-and-items.com/latest_version_fua_j1.6.txt';		
				$file_object = @fopen($url, "r");		
				if($file_object == TRUE){
					$version = fread($file_object, 1000);
					$latest_version_message = $version;
					if($this->version!=$version){
						$latest_version_message .= ' <span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NEWER_VERSION').'</span>';
						if($this->fua_version_type=='pro'){
							$download_url = 'http://www.pages-and-items.com/my-extensions';
						}else{
							$download_url = 'http://www.pages-and-items.com/extensions/frontend-user-access';
						}
						$latest_version_message .= ' <a href="'.$download_url.'" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_DOWNLOAD').'</a>';
					}else{
						$latest_version_message .= ' <span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_IS_LATEST_VERSION').'</span>';
					}
					fclose($file_object);
				}				
				$app->setUserState( "com_frontenduseraccess.latest_version_message", $latest_version_message );
			}
			echo $latest_version_message;
			echo '</td>';
			echo '</tr>';
		}		
		echo '</table>';		
		echo '</div>';			
	}			

	function users_save(){
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		$joomlagroups = JRequest::getVar('gid', null, 'post', 'array');	
		$user_ids = JRequest::getVar('user_id', null, 'post', 'array');	
		$usergroups = JRequest::getVar('usergroups', null, 'post', 'array');
		
		//get users in userindex			
		$this->db->setQuery("SELECT user_id FROM #__fua_userindex ");
		$user_ids_index = $this->db->loadResultArray();		
		
		//update users				
		for($n = 0; $n < count($user_ids); $n++){
			$user_id = $user_ids[$n];			
			
			//update or insert user index
			$usergroups_temp = array();
			if(isset($usergroups[$user_id])){
				$usergroups_temp = $usergroups[$user_id];
			}	
			
			//make sure they are in the right order
			sort($usergroups_temp);			
			
			$usergroups_string = $this->array_to_csv($usergroups_temp);	
			
			if(in_array($user_id, $user_ids_index)){
				if($usergroups_string=='"0"' || $usergroups_string==''){
					$this->db->setQuery("DELETE FROM #__fua_userindex WHERE user_id='$user_id' ");
					$this->db->query();
				}else{						
					$this->db->setQuery( "UPDATE #__fua_userindex SET group_id='$usergroups_string' WHERE user_id='$user_id' " );
					$this->db->query();	
				}
			}else{
				if($usergroups_string!='"0"' && $usergroups_string!=''){
					$this->db->setQuery( "INSERT INTO #__fua_userindex SET user_id='$user_id', group_id='$usergroups_string' ");
					$this->db->query();
				}
			}									
		}		
					
		$this->setRedirect('index.php?option=com_frontenduseraccess&view=users', JText::_('COM_FRONTENDUSERACCESS_USERSSAVED'));		
	}
	
	function access_items_save(){	
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');		
		
		$item_access_hidden = JRequest::getVar('item_access_hidden', null, 'post', 'array');		
				
		//get current item access
		$this->db->setQuery("SELECT itemid_groupid FROM #__fua_items");
		$access_items = $this->db->loadResultArray();	
		
		//write item access		
		for($n = 0; $n < count($item_access_hidden); $n++){
			$value = $item_access_hidden[$n];
			$value_array = explode('__',$value);
			$right = $value_array[0].'__'.$value_array[1];			
			$selected = $value_array[3];
			
			//if right is now selected, but was not in table, do insert
			if($selected && !in_array($right,$access_items)){
				$this->db->setQuery( "INSERT INTO #__fua_items SET itemid_groupid='$right'");
				$this->db->query();
			}
			
			//if right is not selected, but was in table, take it out
			if(!$selected && in_array($right,$access_items)){				
				$this->db->setQuery("DELETE FROM #__fua_items WHERE itemid_groupid='$right'");
				$this->db->query();
			}
		}		
		
		$this->clean_item_access_table();	
					
		$this->setRedirect('index.php?option=com_frontenduseraccess&view=items', JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS_SAVED'));
	}
	
	//take this out for free version
	function access_categories_save(){		
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=categories", JText::_('COM_FRONTENDUSERACCESS_CATEGORY_ACCESS_SAVED').'. '.JText::_('COM_FRONTENDUSERACCESS_NOT_IN_FREE'));
	}		
	
	function loop_usergroups($usergroups){
		foreach($usergroups as $usergroup){
			if($usergroup->id=='9'){
				$name = JText::_('COM_FRONTENDUSERACCESS_LOGGEDIN');
				$description = JText::_('COM_FRONTENDUSERACCESS_LOGGEDIN_DESCRIPTION');
			}elseif($usergroup->id=='10'){
				$name = JText::_('COM_FRONTENDUSERACCESS_NOT_LOGGEDIN');
				$description = JText::_('COM_FRONTENDUSERACCESS_NOT_LOGGEDIN_DESCRIPTION');
			}else{
				$name = stripslashes($usergroup->name);
				$description = stripslashes($usergroup->description);
			}
			$name = str_replace('"','&quot;',$name);
			$description = str_replace('"','&quot;',$description);			
			echo '<th style="text-align:center; width: 10%;">';			
			echo '<label';
			if($description!=''){
				echo ' class="hasTip" title="'.$name.'::'.$description.'"';
			}
			echo '>';
			echo $name;
			echo '</label>';
			echo '</th>';
		}
	}
	
	function check_demo_time_left(){			
		
	}	
	
	function reverse_access_warning($which){
		echo '<p>';
		echo '<input type="checkbox" name="fua_legend_box" id="fua_legend_box" value="" checked="checked" onclick="this.checked=true" onfocus="if(this.blur)this.blur();" class="checkbox" /> = ';
		if($this->fua_config[$which]){				
			echo JText::_('COM_FRONTENDUSERACCESS_USERGROUP_HAS_NO_ACCESS');
			echo '<img src="templates/hathor/images/menu/icon-16-notice.png" class="warning_img" alt="be carefull" />'.JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS_WARNING');
		}else{
			echo JText::_('COM_FRONTENDUSERACCESS_USERGROUP_HAS_ACCESS');
		}
		echo '</p>';
	}
	
	function fua_check_trial_version(){
		return true;
	}		

	//take this out for free version
	function modules_save(){	
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');		
					
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=modules", JText::_('COM_FRONTENDUSERACCESS_MODULE_ACCESS_SAVED').'. '.JText::_('COM_FRONTENDUSERACCESS_NOT_IN_FREE'));
	}			
	
	function not_in_free_version(){
		if($this->fua_version_type=='free'){
			echo '<p class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NOT_IN_FREE_VERSION').'</p>';
		}
	}
	
	function menuaccess_save(){	
		
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');	
					
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=menuaccess", JText::_('COM_FRONTENDUSERACCESS_MENU_ACCESS_SAVED').'. '.JText::_('COM_FRONTENDUSERACCESS_NOT_IN_FREE'));
	}	
	
	function accesscolumn_selector($show){
		$html =  '<select name="accesscolumn" class="inputbox" onchange="this.form.submit()">';		
		$html .= '<option value="yes">'.JText::_('COM_FRONTENDUSERACCESS_SHOW_ACCESS_COLUMN').'</option>';		
		$html .= '<option value="no"';		
		if($show=='no'){
			$html .= 'selected="selected"';
		}
		$html .= '>'.JText::_('COM_FRONTENDUSERACCESS_HIDE_ACCESS_COLUMN').'</option>';
		$html .= '</select>&nbsp;&nbsp;';
		return $html;
	}
	
	function usergroup_selector(){
		if (isset($_COOKIE["fua_selected_usergroups"])) {
			$fua_selected_usergroups = $_COOKIE["fua_selected_usergroups"];				
			$usergroup_array = array();
			$usergroup_array = explode(',',$fua_selected_usergroups);
			$cookie = 1;			
		}else{			
			$cookie = 0;				
		}			
		$this->db->setQuery("SELECT id, name, description "
		."FROM #__fua_usergroups "		
		."ORDER BY name "
		);		
		$usergroups = $this->db->loadObjectList();		
		$html = JText::_('COM_FRONTENDUSERACCESS_DISPLAY_USERGROUPS').': ';		
		$html .= '<select name="usergroup_selector[]" id="usergroup_selector" multiple="multiple" class="inputbox" size="7">';		
		$html .= '<option value="all" onclick="select_all_usergroups();">'.JText::_('JALL').'</option>';
		foreach($usergroups as $usergroup){
			$html .= '<option value="'.$usergroup->id.'"';
			if(!$cookie || ($cookie && in_array($usergroup->id,$usergroup_array))){
				$html .= ' selected="selected"';
			}
			$html .= '>';
			if($usergroup->id=='9'){
				$html .= JText::_('COM_FRONTENDUSERACCESS_LOGGEDIN');
			}elseif($usergroup->id=='10'){
				$html .= JText::_('COM_FRONTENDUSERACCESS_NOT_LOGGEDIN');
			}else{
				$html .= $usergroup->name;
			}
			$html .= '</option>';
		}
		$html .= '</select>';
		$html .= '&nbsp;&nbsp;<button onclick="usergroups_to_cookie();this.form.submit();">'.JText::_('COM_FRONTENDUSERACCESS_GO').'</button>';
		
		return $html;
	}	
	
	function get_usergroups(){
		if (isset($_COOKIE["fua_selected_usergroups"])) {
			$fua_selected_usergroups = $_COOKIE["fua_selected_usergroups"];				
			$usergroup_array = array();
			$usergroup_array = explode(',',$fua_selected_usergroups);			
			$where = "WHERE id in ($fua_selected_usergroups) ";
		}else{
			$where = '';						
		}		
		$this->db->setQuery("SELECT id, name, description "
		."FROM #__fua_usergroups "
		.$where
		."ORDER BY name "
		);	
		$usergroups = $this->db->loadObjectList();
		return $usergroups;
	}	
	
	function ajax_update_users(){
		
		//check token
		JRequest::checkToken( 'get' ) or die( '<span class="fua_red">Invalid Token</span>' );
		
		//only super admins should do this		
		if(!$this->is_super_user){
			die('<span class="fua_red">only super administrators can move users to different groups</span>');
		}		

		//get vars		
		$f = JRequest::getVar('f','0','get');		
		$user_id = JRequest::getVar('u','','get','int');
		$mode = JRequest::getVar('mode','','get');		
		
		//reformat usergroup string
		$groups_array = explode('-', $f);
		$groups_string = '';
		$first = 1;
		foreach($groups_array as $group){
			if($first){
				$first = 0;
			}else{
				$groups_string .= ',';
			}
			$groups_string .= '"'.intval($group).'"';
		}
		
		$f = $groups_string;			
		
		//check if user is in index table
		$this->db->setQuery("SELECT id, group_id FROM #__fua_userindex WHERE user_id='$user_id' ");			
		$index_data = $this->db->loadObjectList();
		$index_id = '';
		$group_id = '';
		foreach($index_data as $data){				
			$index_id = $data->id;
			$group_id = $data->group_id;	
		}		
		
		//if used also with multiple usergroups, swap the usergroup within the csv-string
		if($mode=='multi' && $index_id!=''){
			$old = JRequest::getVar('old','0','get','int');
			//make csv
			$old_csv = '"'.$old.'"';			
			//replace old group with new one
			$temp = str_replace($old_csv, $f, $group_id);
			//clean up for doubles, just in case new group was already in there
			$temp_array = $this->csv_to_array($temp);			
			$temp_unique = array_unique($temp_array);			
			sort($temp_unique);				
			$f = $this->array_to_csv($temp_unique);
		}		
		
		if($group_id!=$f){
			//only do something if there is a difference	
		
			if($index_id){
				if($f=='' || $f=='"0"'){
					//delete
					$this->db->setQuery("DELETE FROM #__fua_userindex WHERE id='$index_id'");
				}else{
					//update
					$this->db->setQuery( "UPDATE #__fua_userindex SET group_id='$f' WHERE user_id='$user_id' ");	
				}	
			}else{
				//insert
				$this->db->setQuery( "INSERT INTO #__fua_userindex SET group_id='$f', user_id='$user_id' ");		
			}
			$this->db->query();			
		}			
		
		//return update message
		echo '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_UPDATED').'</span>';
		exit;
	}
	
	function batch_assign_ready(){
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=users", JText::_('COM_FRONTENDUSERACCESS_BATCH_ASSIGN_SUCCESS'));
	}
	
	function truncate_string($string, $length){
		$dots='...';
		$string = trim($string);		
		if(strlen($string)<=$length){
			return $string;	
		}

		if(!strstr($string," ")){
			return substr($string,0,$length).$dots;
		}	
		$lengthf = create_function('$string','return substr($string,0,strrpos($string," "));');	
		$string = substr($string,0,$length);	
		$string = $lengthf($string);
		while(strlen($string)>$length){
			$string=$lengthf($string);
		}	
		return $string.$dots;
	}
	
	function array_to_csv($array){	
		$return = '';	
		for($n = 0; $n < count($array); $n++){
			if($n){
				$return .= ',';
			}
			$row = each($array);
			$value = $row['value'];
			if(is_string($value)){
				$value = addslashes($value);
			}	
			$return .= '"'.$value.'"';		
		}		
		return $return;
	}
	
	function csv_to_array($csv){		
		$array = array();
		$temp = explode(',', $csv);
		for($n = 0; $n < count($temp); $n++){
			$value = str_replace('"','',$temp[$n]);
			$array[] = $value;
		}
		return $array;
	}
	
	function save_order_groups(){
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');		
		
		$orders = JRequest::getVar('order', array(), 'post', 'array');
		$group_ids = JRequest::getVar('group_id', array(), 'post', 'array');
		
		for($n = 0; $n < count($group_ids); $n++){		
			$order = $orders[$n];
			$group_id = $group_ids[$n];	
			
			//update order						
			$this->db->setQuery( "UPDATE #__fua_usergroups SET ordering='$order' WHERE id='$group_id' ");
			$this->db->query();	
		}
			
		$url = 'index.php?option=com_frontenduseraccess&view=usergroups';
		$this->setRedirect($url, JText::_('COM_FRONTENDUSERACCESS_ORDER_SAVED'));
	}
	
	function enable_plugin(){
		$type = JRequest::getVar('type');
		$types = array('content', 'system', 'user');
		if(in_array($type, $types)){			
			if(!file_exists(JPATH_ROOT.DS.'plugins'.DS.$type.DS.'frontenduseraccess'.DS.'frontenduseraccess.php')){
				$message = JText::_('COM_FRONTENDUSERACCESS_BOTNOTINSTALLED').' '.JText::_('COM_FRONTENDUSERACCESS_BOTNOTPUBLISHED');
			}else{
				$database = JFactory::getDBO();
				$database->setQuery( "UPDATE #__extensions SET enabled='1' WHERE element='frontenduseraccess' AND folder='$type' AND type='plugin' "	);
				$database->query();
				$message = $type.' '.JText::_('COM_FRONTENDUSERACCESS_PLUGIN_ENABLED');
			}
		}else{
			$message = JText::_('COM_FRONTENDUSERACCESS_BOTNOTINSTALLED').' '.JText::_('COM_FRONTENDUSERACCESS_BOTNOTPUBLISHED');
		}	
		
		$from = JRequest::getVar('from', 'config');
		$app = JFactory::getApplication();
		$url = 'index.php?option=com_frontenduseraccess&view='.$from;
		$app->redirect($url, $message);
	}	
	
	function clean_search_string($search){
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::$this->fua_strtolower($search);
		return $search;
	}
	
	function ajax_version_checker(){
		$message = JText::_('COM_FRONTENDUSERACCESS_VERSION_CHECKER_NOT_AVAILABLE');	
		$url = 'http://www.pages-and-items.com/latest_version_fua_j1.6.txt';		
		$file_object = @fopen($url, "r");		
		if($file_object == TRUE){
			$version = fread($file_object, 1000);
			$message = JText::_('COM_FRONTENDUSERACCESS_LATEST_VERSION').' = '.$version;
			if($this->version!=$version){
				$message .= '<div><span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NEWER_VERSION').'</span>.</div>';
				if($this->fua_version_type=='pro'){
					$download_url = 'http://www.pages-and-items.com/my-extensions';
				}else{
					$download_url = 'http://www.pages-and-items.com/extensions/frontend-user-access';
				}
				$message .= '<div><a href="'.$download_url.'" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_DOWNLOAD').'</a></div>';
			}else{
				$message .= '<div><span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_IS_LATEST_VERSION').'</span>.</div>';
			}
			fclose($file_object);
		}
		
		//reset version checker session
		$app = JFactory::getApplication();
		$app->setUserState( "com_frontenduseraccess.latest_version_message", '' );
		
		echo $message;
		exit;
	}
	
	function access_parts_save(){		
	
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');	
		
		$part_access_hidden = JRequest::getVar('part_access_hidden', null, 'post', 'array');			
		
		//get current part access
		$this->db->setQuery("SELECT part_group FROM #__fua_partsaccess");
		$access_parts = $this->db->loadResultArray();
		
		//write part access	
		for($n = 0; $n < count($part_access_hidden); $n++){
			$value = $part_access_hidden[$n];
			$value_array = explode('__',$value);
			$right = $value_array[0].'__'.$value_array[1];			
			$selected = $value_array[3];
			
			//if right is now selected, but was not in table, do insert
			if($selected && !in_array($right,$access_parts)){
				$this->db->setQuery( "INSERT INTO #__fua_partsaccess SET part_group='$right'");
				$this->db->query();
			}
			
			//if right is not selected, but was in table, take it out
			if(!$selected && in_array($right,$access_parts)){				
				$this->db->setQuery("DELETE FROM #__fua_partsaccess WHERE part_group='$right'");
				$this->db->query();
			}
		}
						
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=parts", JText::_('COM_FRONTENDUSERACCESS_PART_ACCESS_SAVED'));
	}
	
	function part_save(){			
			
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');
		
		//get vars
		$id = intval($this->get_var('id', 0, 'post'));
		$name = strip_tags($this->get_var('name', '', 'post'));
		$description = strip_tags($this->get_var('description', '', 'post'));		
		$name = addslashes($name);
		$description = addslashes($description);		
		
		if($id==0){
			//new part
			$this->db->setQuery( "INSERT INTO #__fua_parts SET name='$name', description='$description' ");
			$this->db->query();
		}else{
			//edit part
			$this->db->setQuery( "UPDATE #__fua_parts SET name='$name', description='$description' WHERE id='$id' ");
			$this->db->query();
		}	
		
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=parts", JText::_('COM_FRONTENDUSERACCESS_PART_SAVED'));
	}	
	
	function part_delete(){	
		
		// Check for request forgeries 
		JRequest::checkToken() or jexit('Invalid Token');			
		
		$cid = JRequest::getVar('cid', null, 'post', 'array');		
		
		if (!is_array($cid) || count($cid) < 1) {
			echo "<script> alert(".JText::_('COM_FRONTENDUSERACCESS_SELECT_ITEM_TO_DELETE')."); window.history.go(-1);</script>";
			exit();
		}
		
		if (count($cid)){						
			
			//update rows in partsaccess table of part which stops existing
			$part_access_to_delete = array();
			foreach($cid as $part_id){	
				$this->db->setQuery("SELECT id, part_group "
				."FROM #__fua_partsaccess "
				."WHERE part_group LIKE '%".$part_id."_%' "				
				);
				$rows = $this->db->loadObjectList();
				foreach($rows as $row){	
					$part_access = $row->part_group;
					if(strpos($part_access, $part_id.'_')==0){
						$part_access_to_delete[] = $row->id;
					}					
				}
			}
			$part_access_to_delete = implode(',', $part_access_to_delete);
			//delete parts
			$this->db->setQuery("DELETE FROM #__fua_partsaccess WHERE id IN ($part_access_to_delete)");
			$this->db->query();
			
			//delete parts
			$ids = implode(',', $cid);
			$this->db->setQuery("DELETE FROM #__fua_parts WHERE id IN ($ids)");
			$this->db->query();
		}
		
		$this->setRedirect("index.php?option=com_frontenduseraccess&view=parts", JText::_('COM_FRONTENDUSERACCESS_PART_DELETED'));
	}
	
	function fua_strtolower($string){
		if(function_exists('mb_strtolower')){			
			$string = mb_strtolower($string, 'UTF-8');
		}
		return $string;
	}
	
	function check_emi_ie6_plugin(){
		$return = 1;
		$file = JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'emiIE6warning.php';	
		if ($fp = @fopen($file, "rb")){	
			$null = NULL;		
			$file_string = file_get_contents($file, $null, $null, 10, 2000);			
			fclose ($fp);					
			if(strpos($file_string, 'plgSystememiIE6warning')){			
				$return = 0;
			}			
		}			
		return $return;
	}
	
	function reorder_system_plugin(){
	
		$database = JFactory::getDBO();
		
		$database->setQuery("SELECT element, ordering "
		." FROM #__extensions "
		." WHERE type='plugin' AND folder='system' "
		." ORDER BY ordering ASC "
		);
		$rows = $database->loadObjectList();
		
		$order_element_array = array();
		//$order_array = array();
		$fua_current_ordering = 0;
		$fua_index_order = 0;		
		$fua_in_table = 0;
		$order_index = 0;
		foreach($rows as $row){	
			//echo $row->element.'<br>';
			$element = $row->element;	
			$order = $row->ordering;	
			if($row->element=='frontenduseraccess'){
				$fua_current_ordering = $row->ordering;
				$fua_index_order = $order_index;
				$fua_in_table = 1;
			}
			$order_element_array[] = array($order, $element);
			//$order_array[] = $order;
			$order_index++;
		}
		
		
		if($fua_in_table || $fua_current_ordering==0){
		
			//default for if no ordering was set
			$new_order = '-29000';
			
			//if FUA is second or later 
			if($fua_index_order!=0){
				//check if first is Akeeba
				$first_akeeba = 0;
				$first_order = $order_element_array[0][0];
				if($order_element_array[0][1]=='oneclickaction' || $order_element_array[0][1]=='admintools'){
					$first_akeeba = 1;					
				}
				//check if second is Akeeba
				$second_akeeba = 0;
				$second_order = $order_element_array[1][0];
				if($order_element_array[1][1]=='oneclickaction' || $order_element_array[1][1]=='admintools'){
					$second_akeeba = 1;					
				}
				//if first is not Akeeba, make FUA first if -29000 if not negative enough already
				if(!$first_akeeba && $first_order<=-29000){
					$new_order = $first_order-1;
				//if first is Akeeba, but second is not, get in between
				}elseif($first_akeeba && !$second_akeeba){
					$new_order = $second_order-1;				
				}
				
			}			
		
			$database->setQuery( "UPDATE #__extensions SET ordering='$new_order' WHERE element='frontenduseraccess' AND folder='system' AND type='plugin' "	);
			$database->query();
			$message = JText::_('COM_FRONTENDUSERACCESS_PLUGIN_REORDERED');
		
		}else{
			$message = JText::_('COM_FRONTENDUSERACCESS_BOTNOTINSTALLED');
		}			
		
		$url = 'index.php?option=com_frontenduseraccess&view=config';
		$this->setRedirect($url, $message);
	}	
	
	function check_ztools_plugin(){
		$database = JFactory::getDBO();		
		$database->setQuery("SELECT enabled "
		." FROM #__extensions "
		." WHERE element='plg_ztools' AND type='plugin' AND folder='system' "		
		);
		$rows = $database->loadObjectList();
		$enabled = 0;
		foreach($rows as $row){
			$enabled = $row->enabled;
		}
		return $enabled;
	}
	
	function disable_ztools(){
		$database = JFactory::getDBO();		
		$database->setQuery( "UPDATE #__extensions SET enabled='0' WHERE element='plg_ztools' AND type='plugin' AND folder='system' ");
		$database->query();
		$url = 'index.php?option=com_frontenduseraccess';
		$message = JText::_('COM_FRONTENDUSERACCESS_PLUGIN_DISABLED');
		$this->setRedirect($url, $message);
	}
	
	function check_t3_plugin(){
		$return = 0;			
		$file = JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'jat3'.DS.'jat3'.DS.'core'.DS.'menu'.DS.'base.class.php';	
		if ($fp = @fopen($file, "rb")){	
			$null = NULL;		
			$file_string = file_get_contents($file, $null, $null, 10, 8000);				
			fclose ($fp);					
			if(strpos($file_string, 'frontenduseraccessMenuAccessChecker')){			
				$return = 1;
			}			
		}				
		return $return;
	}
	
	function clean_item_access_table(){
	
		$database = JFactory::getDBO();
		
		//get array of article ids
		$database->setQuery("SELECT id "
		." FROM #__content "
		." WHERE state<>'-2' "
		);
		$content_article_ids = $database->loadResultArray();
		
		//get item-rights
		$database->setQuery("SELECT id, itemid_groupid "
		." FROM #__fua_items "
		);
		$rows = $database->loadObjectList();
		
		//check if article still exists
		foreach($rows as $row){	
			$temp = $row->itemid_groupid;
			$temp_array = explode('__', $temp);
			$temp_item_id = $temp_array[0];	
			if(!in_array($temp_item_id, $content_article_ids)){	
				//articles does no longer exist, so delete right for it	
				$row_id = $row->id;		
				$database->setQuery("DELETE FROM #__fua_items WHERE id='$row_id'");
				$database->query();
			}
			
		}
	}
	
	function check_ubar_plugin(){
		$database = JFactory::getDBO();	
		//check if plugin is enabled	
		$database->setQuery("SELECT enabled "
		." FROM #__extensions "
		." WHERE element='ubar' AND type='plugin' AND folder='system' "		
		);
		$rows = $database->loadObjectList();
		$enabled = 0;
		foreach($rows as $row){
			$enabled = $row->enabled;
		}
		
		//check if the bad code is in the plugin
		$bad_code = 0;
		$file = JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'ubar'.DS.'ubar.php';	
		if ($fp = @fopen($file, "rb")){	
			$null = NULL;		
			$file_string = file_get_contents($file, $null, $null, 10, 3000);				
			fclose ($fp);					
			if(strpos($file_string, '$this->_doc')){			
				$bad_code = 1;
			}			
		}
		
		$return = 0;
		if($enabled && $bad_code){
			$return = 1;
		}
		return $return;
	}
	
	function check_accessmanager_plugin(){
		$database = JFactory::getDBO();		
		$database->setQuery("SELECT enabled "
		." FROM #__extensions "
		." WHERE element='accessmanager' AND type='plugin' AND folder='system' "		
		);
		$rows = $database->loadObjectList();
		$enabled = 0;
		foreach($rows as $row){
			$enabled = $row->enabled;
		}
		return $enabled;
	}
	
	function check_jat3_plugin_and_cache(){
		
		$database = JFactory::getDBO();
		
		$database->setQuery("SELECT enabled "
		." FROM #__extensions "
		." WHERE element='jat3' AND type='plugin' AND folder='system' "		
		);
		$rows = $database->loadObjectList();
		$plugin_enabled = 0;
		foreach($rows as $row){
			$plugin_enabled = $row->enabled;
		}		
		$templates_with_enabled_cache = array();
		if($plugin_enabled){
			jimport( 'joomla.filesystem.folder' );
			$templates = JFolder::folders(JPATH_ROOT.DS.'templates');
			foreach($templates as $template){
				$file = JPATH_ROOT.DS.'templates'.DS.$template.DS.'params.ini';	
				if ($fp = @fopen($file, "rb")){	
					$null = NULL;		
					$file_string = file_get_contents($file, $null, $null, 0, 300);				
					fclose ($fp);					
					if(strpos($file_string, 'cache="1"')){			
						$templates_with_enabled_cache[] = $template;					
					}			
				}
			}	
		}
		return $templates_with_enabled_cache;
	}
	
	function check_aridatatables($file){	
		$bad_code = 0;			
		if ($fp = @fopen($file, "rb")){	
			$null = NULL;		
			$file_string = file_get_contents($file, $null, $null, 10, 3000);				
			fclose ($fp);					
			if(!strpos($file_string, 'if(!class_exists(\'JModuleHelper\')){')){			
				$bad_code = 1;
			}			
		}		
		return $bad_code;
	}
	

}
?>
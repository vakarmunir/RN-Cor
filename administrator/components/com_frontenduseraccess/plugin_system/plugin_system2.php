<?php
/**
* @package Frontend-User-Access (com_frontenduseraccess)
* @version 4.1.6
* @copyright Copyright (C) 2008-2012 Carsten Engel. All rights reserved.
* @license GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html 
* @author http://www.pages-and-items.com
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgSystemFrontenduseraccess extends JPlugin{

	protected $version_type = 'free';
	protected $database;
	protected $fua_config;
	protected $user_id;
	protected $is_super_user;
	protected $option;
	protected $view;
	protected $layout;
	protected $login_url = '';
	protected $trial_valid = 1;
	
	function plgSystemFrontenduseraccess(& $subject, $config){
	
		parent::__construct($subject, $config);
		
		$this->database = JFactory::getDBO();
		
		//get config		
		$this->fua_config = $this->get_config();
		
		//check trial version
		if($this->version_type=='trial'){			
			$this->trial_valid = 0;		
			if($this->fua_check_trial_version()){
				$this->trial_valid = 1;
			}			
		}	
		
		//get user id
		$user = JFactory::getUser();		
		$this->user_id = $user->get('id');	
		
		//dirty workaround to prevent site dying when used together with any of 
		//these plugins which load the module helper outside the plugin class
		if(file_exists(JPATH_PLUGINS.DS.'system'.DS.'advancedmodules'.DS.'advancedmodules.php') || 
		file_exists(JPATH_PLUGINS.DS.'system'.DS.'metamod'.DS.'metamod.php') ||
		file_exists(JPATH_PLUGINS.DS.'system'.DS.'plg_jamenuparams'.DS.'plg_jamenuparams.php') ||
		file_exists(JPATH_PLUGINS.DS.'system'.DS.'plg_gkextmenu'.DS.'plg_gkextmenu.php') ||
		file_exists(JPATH_PLUGINS.DS.'system'.DS.'jat3'.DS.'jat3.php') ||
		file_exists(JPATH_PLUGINS.DS.'system'.DS.'nnframework'.DS.'nnframework.php')
		){	
			$this->onAfterRoute();//to deal with the nnframework override on searches				
			$this->onAfterInitialise();
		}
		
		$uri = JFactory::getURI();
		$request_url = $uri->toString();
		$return_url = base64_encode($request_url);	
		$this->login_url = JURI::root().'index.php?option=com_users&view=login&return='.$return_url;		
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
		$config['no_item_access_full_url'] = str_replace('[equal]','=',$config['no_item_access_full_url']);				
		$config['no_component_access_url'] = str_replace('[equal]','=',$config['no_component_access_url']);	
		$config['no_menu_access_url'] = str_replace('[equal]','=',$config['no_menu_access_url']);					
				
		return $config;			
	}

	function work_on_buffer(){
		
		$app = JFactory::getApplication();
		if(!$app->isAdmin()){
		//only do stuff at the frontend
			
			//get buffer
			$buffer = JResponse::getBody();				
			
			//check for part access			
			//check for any parts to process for performance			
			$pos = 0;
			$pos = strpos($buffer, '{fua_part');
			if($pos){
				//get parts access rights
				$this->database->setQuery("SELECT part_group FROM #__fua_partsaccess ");
				$parts_access_array = $this->database->loadResultArray();	
			
				$regex = "/{fua_part(.*?){\/fua_part}/is";			
				preg_match_all($regex, $buffer, $matches);
						
				$regex_id = "/id=(.*?)}/is";
				
				//get usergroup
				$fua_usergroups_array = $this->get_usergroups_from_database();	
				
				//prevent double processing
				$part_tags = array_unique($matches[1]);
				
				foreach($part_tags as $part_tag){
				
					//take it apart
					$whole_tag = '{fua_part'.$part_tag.'{/fua_part}';	
					$tag_array = explode('{else}', $part_tag);
					$first_bit = $tag_array[0];
					preg_match_all($regex_id, $first_bit, $matches);					
					$part_id = $matches[1][0];
					$id_bit = 'id='.$part_id.'}';
					$content_with_access = str_replace($id_bit, '', $first_bit);
					$content_no_access = '';
					if(isset($tag_array[1])){
						$content_no_access = $tag_array[1];
					}												
					
					//check if parts restrictions is enabled
					if(!$this->fua_config['parts_active']){
						//parts restrictions is not enabled
						//check in config what to do
						if($this->fua_config['parts_not_active']=='as_access'){
							//show as if user has access
							$buffer = str_replace($whole_tag, $content_with_access, $buffer);	
						}elseif($this->fua_config['parts_not_active']=='as_no_access'){
							//show as if user has no access
							$buffer = str_replace($whole_tag, $content_no_access, $buffer);	
						}elseif($this->fua_config['parts_not_active']=='nothing'){
							//take complete tag out
							$buffer = str_replace($whole_tag, '', $buffer);	
						}
						//when option is code, do no replacing at all
						//elseif($this->fua_config['parts_not_active']=='code'					
					}else{
						//parts restrictions is enabled					
					
						$fua_part_access_array = array();
						
						foreach($fua_usergroups_array as $fua_usergroups_item){
						
							$part_right = $part_id.'__'.$fua_usergroups_item;						
							
							$fua_part_access_temp = 'yes';		
							
							if($this->fua_config['parts_reverse_access']){
								if(in_array($part_right, $parts_access_array)){									
									$fua_part_access_temp = 'no';				
								}
							}else{
								if(!in_array($part_right, $parts_access_array)){								
									$fua_part_access_temp = 'no';		
								}
							}						
							$fua_part_access_array[] = $fua_part_access_temp;						
						}
						
						//check with config if to give access or not
						$has_access_part = true;				
						if($this->fua_config['parts_multigroup_access_requirement']=='every_group'){
							if(in_array('no', $fua_part_access_array)){
								$has_access_part = false;
							}else{
								$has_access_part = true;
							}
						}else{
							if(in_array('yes', $fua_part_access_array)){
								$has_access_part = true;
							}else{
								$has_access_part = false;
							}				
						}
						
						//replace tag with access or no access content
						if($has_access_part || $this->is_super_user){
							//show content with access						
							$buffer = str_replace($whole_tag, $content_with_access, $buffer);														
						}else{
							//show content no access
							$buffer = str_replace($whole_tag, $content_no_access, $buffer);
						}
					
					}				
					
				}
			}//end parts restrictions		
					
			//$this->option does not seem to be available here when on the frontpage in Joomla 1.5. Wierd!			
			if(!$this->option){
				$this->option = JRequest::getVar('option', '');
			}						
			
			//check for component access
			if($this->fua_config['use_componentaccess'] && !$this->is_super_user){	
					
				//get usergroup					
				$fua_usergroups_array = $this->get_usergroups_from_database();			
				
				//get component access data
				$this->database->setQuery("SELECT component_groupid FROM #__fua_components");
				$fua_component_access_rights = $this->database->loadResultArray();					
				
				$fua_component_access_array = array();
				
				foreach($fua_usergroups_array as $fua_usergroups_item){
	
					$fua_component_right = $this->option.'__'.$fua_usergroups_item;
										
					//check component permission
					$fua_component_access_temp = 'yes';					
					if($this->fua_config['component_reverse_access']){
						if(in_array($fua_component_right, $fua_component_access_rights) && $this->option!='com_frontenduseraccess'){	
							$fua_component_access_temp = 'no';								
						}
					}else{
						if(!in_array($fua_component_right, $fua_component_access_rights) && $this->option!='com_frontenduseraccess'){	
							$fua_component_access_temp = 'no';									
						}
					}
					
					$fua_component_access_array[] = $fua_component_access_temp;
					
				}				
				
				//check with config if to give access or not
				$fua_component_access = true;				
				if($this->fua_config['component_multigroup_access_requirement']=='every_group'){
					if(in_array('no', $fua_component_access_array)){
						$fua_component_access = false;
					}else{
						$fua_component_access = true;
					}
				}else{
					if(in_array('yes', $fua_component_access_array)){
						$fua_component_access = true;
					}else{
						$fua_component_access = false;
					}				
				}
				
				//if user has no component-access-permission
				if(!$fua_component_access){
					if($this->fua_config['components_message_type']=='alert'){	
						$message = addslashes($this->fua_config['message_no_component_access']);
						$this->do_alert($message);	
					}elseif($this->fua_config['components_message_type']=='redirect'){							
						$url = JURI::root().$this->fua_config['no_component_access_url'];
						$app = JFactory::getApplication();
						$app->redirect($url);
					}elseif($this->fua_config['components_message_type']=='login'){							
						$url = $this->login_url;						
						$app = JFactory::getApplication();
						$app->redirect($url);
					}else{
						//get menu-item and live site							
						$menu_item = JRequest::getVar('Itemid', '');						
						$url = 'index.php?option=com_frontenduseraccess&view=noaccess&Itemid='.$menu_item.'&type=4';						
						if($this->fua_config['components_message_type']=='only_text' || $this->fua_config['components_message_type']=='inline_text'){
							$url .= '&tmpl=component';
						}	
						$url = $this->sef_url($url);	
						$app = JFactory::getApplication();
						$app->redirect($url);
					}
				}				
			}//end check for component access			
			
			//write buffer
			JResponse::setBody($buffer);			
		}		 
	}
	
	function check_menu_access(){		
			
		return true;		
	}	
	
	function check_article_view_access(){		
		
		static $fua_article_view_access_checked;
		
		if(!$fua_article_view_access_checked){
		
			$app = JFactory::getApplication();			
			
			//get vars			
			$item_id_temp = JRequest::getVar('id', '');	
			if(strpos($item_id_temp, ':')){
				$pos_item_id = strpos($item_id_temp, ':');
				$item_id = intval(substr($item_id_temp, 0, $pos_item_id));	
			}else{
				$item_id = intval($item_id_temp);	
			}					
				
			//start checking item full view access		
			if($this->option=='com_content' &&
			($this->view=='article' && ($this->layout=='default' || $this->layout=='')) &&
			$this->fua_config['items_active'] &&
			(!$this->is_super_user) 
			){														
				
				//check access
				$fua_full_item_access = $this->check_article_access($item_id);							
				
				//if no access
				if(!$fua_full_item_access){								
					if($this->fua_config['items_message_type']=='alert'){
						//javascript alert							
						$message = addslashes($this->fua_config['message_no_item_access_full']);
						$this->do_alert($message);
					}elseif($this->fua_config['items_message_type']=='redirect'){
						//redirect
						$url = JURI::root().$this->fua_config['no_item_access_full_url'];																		
						$app->redirect($url);	
					}elseif($this->fua_config['items_message_type']=='login'){						
						$url = $this->login_url;
						$app->redirect($url);	
					}else{								
						//white page with message	
						$menu_item = JRequest::getVar('Itemid', '');																						
						$url = 'index.php?option=com_frontenduseraccess&view=noaccess&Itemid='.$menu_item.'&type=1';
						if($this->fua_config['items_message_type']=='only_text' || $this->fua_config['items_message_type']=='inline_text'){
							$url .= '&tmpl=component';
						}	
						$url = $this->sef_url($url);										
						$app->redirect($url);										
					}
					
				}					
								
					
			}//end if anything needs checking
			$fua_article_view_access_checked = 1;
		}//end if only do this once
	}	
	
	function get_item_access_from_database(){
		
		static $item_access_array;
		
		if(!$item_access_array){	
			
			$this->database->setQuery("SELECT itemid_groupid FROM #__fua_items ");
			$item_access_array = $this->database->loadResultArray();	
			
		}
		
		return $item_access_array;
	}
	
	function get_usergroups_from_database(){
	
		static $fua_usergroups;
		
		if(!$fua_usergroups){
			$fua_usergroups = array();
			if(!$this->user_id){
				//user is not logged in
				$fua_usergroups = array(10);
			}else{
				$user_id = $this->user_id;
				$this->database->setQuery("SELECT group_id FROM #__fua_userindex WHERE user_id='$user_id' LIMIT 1 ");		
				$rows_group = $this->database->loadObjectList();			
				$fua_usergroups = 0;
				foreach($rows_group as $row){
					$temp = $row->group_id;
					$fua_usergroups = $this->csv_to_array($temp);
				}
				
				if(!$fua_usergroups){
					//user is logged in, but is not assigned to any usergroup, so make it 9
					$fua_usergroups = array(9);
				}
			}	
		}	
		return $fua_usergroups;
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
	
	function do_alert($message){		
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo "<script>alert('".html_entity_decode($message)."'); window.history.go(-1); </script>";
		exit('<html><body><noscript>'.$message.'</noscript></body></html>');
	}
	
	function onAfterRender(){	
	
		$this->option = JRequest::getVar('option', '');		
		$this->view = JRequest::getVar('view', '');	
		$this->layout = JRequest::getVar('layout', '');	
		
		//check if super user					
		$user_id = $this->user_id;		
		if($user_id){
			//only check if logged in
			$this->database->setQuery("SELECT group_id FROM #__user_usergroup_map WHERE user_id='$user_id' AND group_id='8' LIMIT 1");
			$rows = $this->database->loadObjectList();		
			foreach($rows as $row){
				$this->is_super_user = true;
			}
		}			
		
		if($this->fua_config['fua_enabled']){			
			$app = JFactory::getApplication();
			if(!$app->isAdmin()){	
				if($this->trial_valid){	
					//make sure page is not cached
					//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
					//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past					
					$this->check_article_view_access();
					$this->work_on_buffer();
				}							
			}
		}
	}
	
	function check_article_access($article_id){
	
		//get usergroups				
		$fua_usergroups_array = $this->get_usergroups_from_database();	
			
		$return_item_access = 1;
		//$fua_full_item_access_array = array();
		
		//article access
		$fua_item_access = true;	
		if($this->fua_config['items_active']){		
			$item_access_array = $this->get_item_access_from_database();			
			$fua_item_access_array = array();
			foreach($fua_usergroups_array as $fua_usergroups_item){	
				$item_right = $article_id.'__'.$fua_usergroups_item;
				$fua_item_access_temp = 'yes';	
				if($this->fua_config['items_reverse_access']){
					if(in_array($item_right, $item_access_array)){								
						$fua_item_access_temp = 'no';	
					}
				}else{
					if(!in_array($item_right, $item_access_array)){								
						$fua_item_access_temp = 'no';		
					}
				}	
				$fua_item_access_array[] = $fua_item_access_temp;
			}					
			
			//check with config if to give access or not
			$fua_item_access = true;				
			if($this->fua_config['items_multigroup_access_requirement']=='every_group'){
				if(in_array('no', $fua_item_access_array)){
					$fua_item_access = false;
				}else{
					$fua_item_access = true;
				}
			}else{
				if(in_array('yes', $fua_item_access_array)){
					$fua_item_access = true;
				}else{
					$fua_item_access = false;
				}				
			}
			
			if($fua_item_access){						
				$return_item_access = true;									
			}else{						
				$return_item_access = false;											
			}	
						
		}//end item access				
		
		return $return_item_access;
	}
		
	function onAfterRoute(){			
		
		static $onAfterRoute;
		$app = JFactory::getApplication();
		
		if(!$onAfterRoute){
		
			if(!$app->isAdmin() && !$this->is_super_user && $this->fua_config['fua_enabled']
			&& ($this->fua_config['items_active'] || $this->fua_config['use_componentaccess'])
			){	
				//only frontend and not super-admins
				
				$option = JRequest::getVar('option', '');
				$view = JRequest::getVar('view', '');
			
				require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess2.php');
				$access_script = new frontenduseraccessMenuAccessChecker();		
				
				$declare_array = array();			
				
				if($option=='com_content' && $view=='featured' && ($this->fua_config['items_active'])){
					$file = 'components'.DS.'com_content'.DS.'models'.DS.'featured.php';
					$code_replace = array();		
					$code_old = 'return $query;';								
					$code_new = '$query->where(" a.id'.$access_script->where_in_articles().' ");'.$code_old;					
					$code_replace[] = array($code_old, $code_new);					
					$code_old = 'require_once dirname(__FILE__) . \'/articles.php\';';
					$code_new = 'require_once JPATH_ROOT.DS.\'components\'.DS.\'com_content\'.DS.\'models\'.DS.\'articles.php\';';						
					$code_replace[] = array($code_old, $code_new);
					//extra for joomla 1.6
					$code_old = 'require_once dirname(__FILE__) . DS . \'articles.php\';';
					$code_new = 'require_once JPATH_ROOT.DS.\'components\'.DS.\'com_content\'.DS.\'models\'.DS.\'articles.php\';';						
					$code_replace[] = array($code_old, $code_new);				
					$declare_array[] = array($file, $code_replace);				
				}
				
				if($option=='com_content' && $view=='archive' && ($this->fua_config['items_active'])){
					$file = 'components'.DS.'com_content'.DS.'models'.DS.'archive.php';
					$code_replace = array();		
					$code_old = 'return $query;';				
					$code_new = '$query->where(" a.id'.$access_script->where_in_articles().' ");'.$code_old;						
					$code_replace[] = array($code_old, $code_new); 	
					$code_old = 'require_once dirname(__FILE__) . \'/articles.php\';';
					$code_new = 'require_once JPATH_ROOT.DS.\'components\'.DS.\'com_content\'.DS.\'models\'.DS.\'articles.php\';';						
					$code_replace[] = array($code_old, $code_new);	
					//extra for joomla 1.6
					$code_old = 'require_once dirname(__FILE__) . DS . \'articles.php\';';
					$code_new = 'require_once JPATH_ROOT.DS.\'components\'.DS.\'com_content\'.DS.\'models\'.DS.\'articles.php\';';						
					$code_replace[] = array($code_old, $code_new);	
					$declare_array[] = array($file, $code_replace);						
				}			
							
				if($option=='com_content' && $view=='category' && ($this->fua_config['items_active'])){
					$file = 'components'.DS.'com_content'.DS.'models'.DS.'category.php';
					$code_old = '$this->_children = $this->_item->getChildren();';				
					$code_new = $code_old.'$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();				
					$this->_children = $frontenduseraccessAccessChecker->filter_categories($this->_children);';						
					$code_replace[] = array($code_old, $code_new);
					$declare_array[] = array($file, $code_replace);				
					$file = 'components'.DS.'com_content'.DS.'models'.DS.'articles.php';
					$code_replace = array();		
					$code_old = '// Filter by Date Range or Relative Date';				
					$code_new = '$query->where(" a.id'.$access_script->where_in_articles().' ");'.$code_old;							
					$code_replace[] = array($code_old, $code_new);
					$declare_array[] = array($file, $code_replace);					
				}	
				
				if($option=='com_search'){
					$file = 'components'.DS.'com_search'.DS.'models'.DS.'search.php';
					$code_replace = array();					
					$code_old = '$this->_total	= count($rows);';				
					$code_new = '$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();				
					$rows = $frontenduseraccessAccessChecker->filter_search_results($rows);'.$code_old;						
					$code_replace[] = array($code_old, $code_new); 						
					$declare_array[] = array($file, $code_replace);				
				}					
				
				$this->declare_methods($declare_array);     
			}
			$onAfterRoute = 1;
		}	
   }
   
   function onAfterInitialise(){
   
   		static $onAfterInitialise;
		
		if(!$onAfterInitialise){
		
			$app = JFactory::getApplication();
			$database = JFactory::getDBO();							
			
			if(!$app->isAdmin() && !class_exists('JModuleHelper') && $this->fua_config['fua_enabled']){	
					
				$redirect_url = $app->getUserState( "com_frontenduseraccess.redirect_url", '' );
				if($redirect_url){				
					$app->setUserState( "com_frontenduseraccess.redirect_url", '');					
					$app->redirect($redirect_url);				
				}
				
				require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess2.php');
				$access_script = new frontenduseraccessMenuAccessChecker();		
				
				$declare_array = array();
					
				//modules	
				//check if we need to override the advanced module manager or MetaMod
				$fua_order = 0;
				if(file_exists(JPATH_PLUGINS.DS.'system'.DS.'advancedmodules.php') || file_exists(JPATH_PLUGINS.DS.'system'.DS.'metamod.php')){
					//check which order the FUA system plugin has
					$database->setQuery("SELECT ordering "
					." FROM #__extensions "
					." WHERE element='frontenduseraccess' AND folder='system' "
					." LIMIT 1 "
					);
					$rows = $database->loadObjectList();					
					foreach($rows as $row){					
						$fua_order = $row->ordering;
					}
				}				
				
				//advanced module manager
				$advanced_module_manager_published = 0;
				$advanced_module_manager_order = 0;	
				if(file_exists(JPATH_PLUGINS.DS.'system'.DS.'advancedmodules.php')){
					//check if enabled and which order
					$database->setQuery("SELECT published, ordering "
					." FROM #__extensions "
					." WHERE element='advancedmodules' AND folder='system' "
					." LIMIT 1 "
					);
					$rows = $database->loadObjectList();					
					foreach($rows as $row){					
						$advanced_module_manager_published = $row->published;
						$advanced_module_manager_order = $row->ordering;
					}				
				}
				
				//MetaMod
				//seems not to be for 1.7 leave in for a while to make sure it does not surprise me when making a comeback
				$metamod_published = 0;
				$metamod_order = 0;	
				if(file_exists(JPATH_PLUGINS.DS.'system'.DS.'metamod.php')){
					//check if enabled and which order
					$database->setQuery("SELECT published, ordering "
					." FROM #__extensions "
					." WHERE element='metamod' AND folder='system' "
					." LIMIT 1 "
					);
					$rows = $database->loadObjectList();					
					foreach($rows as $row){					
						$metamod_published = $row->published;
						$metamod_order = $row->ordering;
					}				
				}
				
				//jat3				
				$jat3_enabled = 0;				
				if(file_exists(JPATH_PLUGINS.DS.'system'.DS.'jat3'.DS.'jat3.php')){				
					//check if enabled and which order
					$database->setQuery("SELECT enabled "
					." FROM #__extensions "
					." WHERE element='jat3' AND folder='system' "
					." LIMIT 1 "
					);
					$rows = $database->loadObjectList();					
					foreach($rows as $row){					
						$jat3_enabled = $row->enabled;						
					}				
				}
				
				$got_module_helper = 0;
				if($jat3_enabled){	
					//if metamod is enabled AND FUA is loaded first in order
					//load the metamod helper and alter it
					$file = 'plugins'.DS.'system'.DS.'jat3'.DS.'jat3'.DS.'core'.DS.'joomla'.DS.'modulehelper.php';
					$got_module_helper = 1;
				}
				if(!$got_module_helper && $advanced_module_manager_published && ($fua_order < $advanced_module_manager_order)){	
					//if advanced_module_manager is enabled AND FUA is loaded first in order
					//load the advanced module managers module helper and alter it
					$file = 'plugins'.DS.'system'.DS.'advancedmodules'.DS.'modulehelper.php';
					$got_module_helper = 1;
				}
				if(!$got_module_helper && $metamod_published && ($am_order < $metamod_order)){	
					//if metamod is enabled AND AM is loaded first in order
					//load the metamod helper and alter it
					$file = 'plugins'.DS.'system'.DS.'metamod'.DS.'modulehelper.php';
					$got_module_helper = 1;
				}
				if(!$got_module_helper){
					$file = 'libraries'.DS.'joomla'.DS.'application'.DS.'module'.DS.'helper.php';
				}
				$code_replace = array();					
				//joomla 1.6 and 1.7		
				$code_old = 'require $path;';				
				$code_new = '								
				if(strpos($path, \'mod_articles_archive.php\')){					
					$params->def(\'count\', 10);
					$moduleclass_sfx = htmlspecialchars($params->get(\'moduleclass_sfx\'));					
					$list = modArchiveHelper::getList($params);				
					require JModuleHelper::getLayoutPath(\'mod_articles_archive\', $params->get(\'layout\', \'default\'));
				}elseif(strpos($path, \'mod_articles_categories.php\')){
					$list = modArticlesCategoriesHelper::getList($params);
					if (!empty($list)) {
						$moduleclass_sfx = htmlspecialchars($params->get(\'moduleclass_sfx\'));
						$startLevel = reset($list)->getParent()->level;
						require JModuleHelper::getLayoutPath(\'mod_articles_categories\', $params->get(\'layout\', \'default\'));
					}
				}elseif(strpos($path, \'mod_articles_category.php\')){
					// Prep for Normal or Dynamic Modes
					$mode = $params->get(\'mode\', \'normal\');
					$idbase = null;
					switch($mode)
					{
						case \'dynamic\':
							$option = JRequest::getCmd(\'option\');
							$view = JRequest::getCmd(\'view\');
							if ($option === \'com_content\') {
								switch($view)
								{
									case \'category\':
										$idbase = JRequest::getInt(\'id\');
										break;
									case \'categories\':
										$idbase = JRequest::getInt(\'id\');
										break;
									case \'article\':
										if ($params->get(\'show_on_article_page\', 1)) {
											$idbase = JRequest::getInt(\'catid\');
										}
										break;
								}
							}
							break;
						case \'normal\':
						default:
							$idbase = $params->get(\'catid\');
							break;
					}
					$cacheid = md5(serialize(array ($idbase,$module->module)));
					$cacheparams = new stdClass;
					$cacheparams->cachemode = \'id\';
					$cacheparams->class = \'modArticlesCategoryHelper\';
					$cacheparams->method = \'getList\';
					$cacheparams->methodparams = $params;
					$cacheparams->modeparams = $cacheid;					
					$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);
					if (!empty($list)) {
						$grouped = false;
						$article_grouping = $params->get(\'article_grouping\', \'none\');
						$article_grouping_direction = $params->get(\'article_grouping_direction\', \'ksort\');
						$moduleclass_sfx = htmlspecialchars($params->get(\'moduleclass_sfx\'));
						$item_heading = $params->get(\'item_heading\');					
						if ($article_grouping !== \'none\') {
							$grouped = true;
							switch($article_grouping){
								case \'year\':
								case \'month_year\':
									$list = modArticlesCategoryHelper::groupByDate($list, $article_grouping, $article_grouping_direction, $params->get(\'month_year_format\', \'F Y\'));
									break;
								case \'author\':
								case \'category_title\':
									$list = modArticlesCategoryHelper::groupBy($list, $article_grouping, $article_grouping_direction);
									break;
								default:
									break;
							}
						}
						require JModuleHelper::getLayoutPath(\'mod_articles_category\', $params->get(\'layout\', \'default\'));
					}							
				}elseif(strpos($path, \'mod_articles_latest.php\')){
					$list = modArticlesLatestHelper::getList($params);
					$moduleclass_sfx = htmlspecialchars($params->get(\'moduleclass_sfx\'));
					require JModuleHelper::getLayoutPath(\'mod_articles_latest\', $params->get(\'layout\', \'default\'));				
				}elseif(strpos($path, \'mod_articles_news.php\')){
					$list = modArticlesNewsHelper::getList($params);
					$moduleclass_sfx = htmlspecialchars($params->get(\'moduleclass_sfx\'));					
					require JModuleHelper::getLayoutPath(\'mod_articles_news\', $params->get(\'layout\', \'horizontal\'));
				
				}elseif(strpos($path, \'mod_articles_popular.php\')){
					$list = modArticlesPopularHelper::getList($params);
					$moduleclass_sfx = htmlspecialchars($params->get(\'moduleclass_sfx\'));					
					require JModuleHelper::getLayoutPath(\'mod_articles_popular\', $params->get(\'layout\', \'default\'));					
				}elseif(strpos($path, \'mod_related_items.php\')){
					$cacheparams = new stdClass;
					$cacheparams->cachemode = \'safeuri\';
					$cacheparams->class = \'modRelatedItemsHelper\';
					$cacheparams->method = \'getList\';
					$cacheparams->methodparams = $params;
					$cacheparams->modeparams = array(\'id\'=>\'int\',\'Itemid\'=>\'int\');					
					$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);					
					if (!count($list)) {
						return;
					}					
					$moduleclass_sfx = htmlspecialchars($params->get(\'moduleclass_sfx\'));
					$showDate = $params->get(\'showDate\', 0);					
					require JModuleHelper::getLayoutPath(\'mod_related_items\', $params->get(\'layout\', \'default\'));				
					';
				
				
				$end_code_17 = '						
				}else{				
					require $path;
				}';									
				$code_replace[] = array($code_old, $code_new.$end_code_17);									
				//same but then for joomla 2.5
				$code_old = 'include $path;';				
				$end_code_25 = '						
				}else{				
					include $path;
				}';	 	
				$code_replace[] = array($code_old, $code_new.$end_code_25); 			
				$declare_array[] = array($file, $code_replace);			
	
				//module articles archive
				$file = 'modules'.DS.'mod_articles_archive'.DS.'helper.php';
				$code_replace = array();										
				$code_old = '$query->where(\'state = 2 AND checked_out = 0\');';				
				$code_new = '$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();	
									$where_in_articles = $frontenduseraccessAccessChecker->where_in_articles();
									$query->where(" id $where_in_articles ");'.$code_old;	
				$code_replace[] = array($code_old, $code_new);
				$declare_array[] = array($file, $code_replace);			
				
				//module articles categories				
				$file = 'modules'.DS.'mod_articles_categories'.DS.'helper.php';				
				$code_replace = array();	
				$code_old = '$items = $category->getChildren();';	
				$code_new = $code_old.'$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();				
					$items = $frontenduseraccessAccessChecker->filter_categories($items);';
				$code_replace[] = array($code_old, $code_new);
				$declare_array[] = array($file, $code_replace);					
				
				//module articles category				
				$file = 'modules'.DS.'mod_articles_category'.DS.'helper.php';				
				$code_replace = array();	
				$code_old = 'return $items;';	
				$code_new = '$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();				
					$items = $frontenduseraccessAccessChecker->filter_articles($items);'.$code_old;
				$code_replace[] = array($code_old, $code_new);
				$declare_array[] = array($file, $code_replace);					
				
				//module articles latest				
				$file = 'modules'.DS.'mod_articles_latest'.DS.'helper.php';				
				$code_replace = array();		
				$code_old = '$items = $model->getItems();';					
				$code_new = $code_old.'$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();				
					$items = $frontenduseraccessAccessChecker->filter_articles($items);';													
				$code_replace[] = array($code_old, $code_new); 					
				$declare_array[] = array($file, $code_replace);
				
				//module articles news		
				$file = 'modules'.DS.'mod_articles_news'.DS.'helper.php';				
				$code_replace = array();		
				$code_old = '$items = $model->getItems();';					
				$code_new = $code_old.'$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();				
					$items = $frontenduseraccessAccessChecker->filter_articles($items);';													
				$code_replace[] = array($code_old, $code_new); 					
				$declare_array[] = array($file, $code_replace);
				
				//module articles popular		
				$file = 'modules'.DS.'mod_articles_popular'.DS.'helper.php';				
				$code_replace = array();		
				$code_old = '$items = $model->getItems();';					
				$code_new = $code_old.'$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();				
					$items = $frontenduseraccessAccessChecker->filter_articles($items);';													
				$code_replace[] = array($code_old, $code_new); 					
				$declare_array[] = array($file, $code_replace);
				
				//module related items		
				$file = 'modules'.DS.'mod_related_items'.DS.'helper.php';				
				$code_replace = array();		
				$code_old = '// Filter by language';					
				$code_new = '$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();	
									$where_in_articles = $frontenduseraccessAccessChecker->where_in_articles();
									$query->where(" a.id $where_in_articles ");'.$code_old;												
				$code_replace[] = array($code_old, $code_new); 					
				$declare_array[] = array($file, $code_replace);					
				
				$this->declare_methods($declare_array);  
			}
			$onAfterInitialise = 1;
		}		
	}
   
	function declare_methods($declare_array){				
		for($n = 0; $n < count($declare_array); $n++){					
			$file = JPATH_ROOT.DS.$declare_array[$n][0];
			if(file_exists($file)){					
				$handle = fopen($file, 'r');
				$code = fread($handle, filesize($file));
				$code = str_replace('<?php', '', $code);
				$code = str_replace('?>', '', $code);			
				$code_replace = $declare_array[$n][1];
				for($p = 0; $p < count($code_replace); $p++){					
					$code = str_replace($code_replace[$p][0], $code_replace[$p][1], $code);											
				}								
				eval($code);
			}			
		}
	}
	
	function sef_url($url){
		$url = JRoute::_($url);
		$url = str_replace('&amp;','&',$url);
		return $url;
	}
	
}

?>
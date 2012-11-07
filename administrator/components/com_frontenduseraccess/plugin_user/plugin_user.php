<?php
/**
* @package Frontend-User-Access (com_frontenduseraccess)
* @version 4.1.6
* @copyright Copyright (C) 2008-2012 Carsten Engel. All rights reserved.
* @license GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html 
* @author http://www.pages-and-items.com
*/

//no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgUserFrontenduseraccess extends JPlugin {
	
	protected $fua_config;	

	function plgUserFrontenduseraccess(& $subject, $config){
	
		parent::__construct($subject, $config);
		
		//get config		
		$this->fua_config = $this->get_config();	
		
	}	
	
	function onUserAfterSave($user, $isnew, $success, $msg){
				
		$option = JRequest::getVar('option', '');
		$task = JRequest::getVar('task', '');
				
		if($this->fua_config['fua_enabled'] && !($option=='com_extendedreg' && $task=='activate')){	
			$app = JFactory::getApplication();	
			$database = JFactory::getDBO();		
			$user_id = $user['id'];	
			$new_usergroup = $this->fua_config['default_usergroup'];				
			if($isnew){
				//new user
				
				if($this->fua_config['enable_from_select_to_group'] && $this->fua_config['from_select_to_group']!=''){
					$php_to_render = '<?php $user_id = \''.$user_id.'\'; $groups = \'\'; ';
					$php_to_render .= $this->fua_config['from_select_to_group'];	
					$php_to_render .= ' echo $groups; ?>';						
					$group_string = $this->phpWrapper($php_to_render);				
					if($group_string!=''){						
						if(strpos($group_string, ',')){
							//array							
							$new_usergroup = '';
							$groups_array = explode(',', $group_string);
							sort($groups_array);
							$first = 1;
							for($n = 0; $n < count($groups_array); $n++){
								if($groups_array[$n]!=''){
									if(!$first){
										$new_usergroup .= ',';									
									}else{
										$first = 0;
									}
									$new_usergroup .= '"'.$groups_array[$n].'"';
								}
							}						
						}else{
							//single value
							$new_usergroup = '"'.$group_string.'"';
						}
					}
				}
								
				if($new_usergroup){			
					$database->setQuery( "INSERT INTO #__fua_userindex SET user_id='$user_id', group_id='$new_usergroup' ");
					$database->query();
				}
				
			}else{	
				//edit user
				
				if($this->fua_config['enable_from_select_to_group']){
					$script = 0;
					//check which code to use
					if($this->fua_config['enable_from_select_to_group_update'] && $this->fua_config['from_select_to_group']!=''){
						//use registration script
						$script = $this->fua_config['from_select_to_group'];	
					}
					if(!$this->fua_config['enable_from_select_to_group_update'] && $this->fua_config['from_select_to_group_update']!=''){
						//use update script
						$script = $this->fua_config['from_select_to_group_update'];	
					}
					if($script){
					
						//check if user is already in user-index table
						//and get current groups
						$current_groups = '';
						$database->setQuery("SELECT id, group_id "
						."FROM #__fua_userindex "
						."WHERE user_id='$user_id' "
						."LIMIT 1 "
						);
						$user_rows = $database->loadObjectList();
						$user_in_index_table = 0;
						foreach($user_rows as $user_row){	
							$user_in_index_table = 1;
							$index_id = $user_row->id;
							$current_groups = $user_row->group_id;
						}	
						
						$php_to_render = '<?php $user_id = \''.$user_id.'\'; $groups = \'\';  $current_groups = \''.$current_groups.'\'; ';
						$php_to_render .= $script;	
						$php_to_render .= ' echo $groups; ?>';						
						$group_string = $this->phpWrapper($php_to_render);				
						if($group_string!=''){						
							if(strpos($group_string, ',')){
								//array							
								$new_usergroup = '';
								$groups_array = explode(',', $group_string);
								sort($groups_array);
								$first = 1;
								for($n = 0; $n < count($groups_array); $n++){
									if($groups_array[$n]!=''){
										if(!$first){
											$new_usergroup .= ',';									
										}else{
											$first = 0;
										}
										$new_usergroup .= '"'.$groups_array[$n].'"';
									}
								}						
							}else{
								//single value
								$new_usergroup = '"'.$group_string.'"';
							}
						}				
						
						if($user_in_index_table){
							//user is in table already, so do update
							$database->setQuery( "UPDATE #__fua_userindex SET group_id='$new_usergroup' WHERE id='$index_id' ");
							$database->query();
						}else{	
							//user is not in table yet, so do insert					
							$database->setQuery( "INSERT INTO #__fua_userindex SET user_id='$user_id', group_id='$new_usergroup' ");
							$database->query();
						}
					}
				}				
			}//end if edit user
		}//end if fua enabled				
	}
	
	function phpWrapper($content){
		$database = JFactory::getDBO();								
		ob_start();
		eval("?>" . $content);
		$content = ob_get_contents();
		ob_end_clean(); 		
		return $content;
	}	
	
	function onUserAfterDelete($user, $succes, $msg){
		$app = JFactory::getApplication();
		
		$user_id = $user['id'];
		$database = JFactory::getDBO();	
		$database->setQuery("DELETE FROM #__fua_userindex WHERE user_id='$user_id'");
		$database->query();		 	
	}	
	
	function onUserLogin($user, $options){
		$app = JFactory::getApplication();
		
		if(isset($options['silent'])){	
			return true;
		}
		
		$redirect_url = '';
		if(!$app->isAdmin() && $this->fua_config['redirecting_enabled'] && $this->fua_config['fua_enabled']){
			
			$database = JFactory::getDBO();	
	
			//$user_id = $user['id']; why on earth is the user id not parsed?	
			$user_email = $user['email'];	
			
			//get user id from email
			$database->setQuery("SELECT id "
			."FROM #__users  "
			."WHERE email='$user_email' "
			."LIMIT 1 "
			);
			$rows = $database->loadObjectList();
			$user_id = 0;
			foreach($rows as $row){	
				$user_id = $row->id;	
			}	
			
			//select fua-usergroups		
			$database->setQuery("SELECT group_id "
			."FROM #__fua_userindex  "
			."WHERE user_id='$user_id' "
			."LIMIT 1 "
			);
			$rows = $database->loadObjectList();
			$group_ids = 0;
			foreach($rows as $row){	
				$group_ids = $row->group_id;	
			}			
			
			//get first group in order
			$group_id = 0;			
			$group_ids_string = str_replace('"','',$group_ids);	
			$database->setQuery("SELECT id "
			."FROM #__fua_usergroups  "
			."WHERE id in ($group_ids_string) "
			."ORDER BY ordering ASC "
			."LIMIT 1 "
			);
			$rows = $database->loadObjectList();
			foreach($rows as $row){	
				$group_id = $row->id;	
			}				
			
			//continue only if there is a group_id
			if($group_id){
				//get redirect url
				$database->setQuery("SELECT url "
				."FROM #__fua_usergroups  "
				."WHERE id='$group_id' "
				."LIMIT 1 "
				);
				$rows = $database->loadObjectList();
				$redirect_url = 0;
				foreach($rows as $row){	
					$redirect_url = $row->url;						
				}						
			}else{			
				//user is logged in but is not assigned to any usergroup	
				if($this->fua_config['redirect_url']){	
					
					$redirect_url = $this->fua_config['redirect_url'];
				}
			}
			
			if($redirect_url!=''){	
				if(!strpos($redirect_url, 'ttp://')){
					$redirect_url = JURI::root().$redirect_url;	
				}			
				$app->setUserState( "com_frontenduseraccess.redirect_url", $redirect_url);			
			}
		}			
		return true;
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
		
		$config['from_select_to_group'] = str_replace('[newline]','
',$config['from_select_to_group']);
		$config['from_select_to_group'] = str_replace('[equal]','=',$config['from_select_to_group']);
		$config['from_select_to_group_update'] = str_replace('[newline]','
',$config['from_select_to_group_update']);
		$config['from_select_to_group_update'] = str_replace('[equal]','=',$config['from_select_to_group_update']);
				
		return $config;			
	}
}
?>
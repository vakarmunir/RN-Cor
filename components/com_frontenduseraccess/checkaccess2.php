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


class frontenduseraccessMenuAccessChecker{	

	protected $version_type = 'free';
	protected $fua_config;
	protected $user_id;
	protected $is_super_user;
	protected $database;
	protected $trial_valid = 1;	
	public $lead_items = array();
	public $intro_items = array();
	public $link_items = array();
	
	function __construct(){
	
		$this->database = JFactory::getDBO();
		
		//get config		
		$this->fua_config = $this->get_config();
		
		//get user id
		$user = JFactory::getUser();		
		$this->user_id = $user->get('id');			
		
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
		
		//check trial version
		if($this->version_type=='trial'){			
			$this->trial_valid = 0;		
			if($this->fua_check_trial_version()){
				$this->trial_valid = 1;
			}			
		}
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
				
		return $config;			
	}
	
	function filter_menu_items($rows, $menutype){		
		return $rows;		
	}
	
	function get_usergroups_from_database(){
		
		static $fua_usergroups;		
		
		if(!$fua_usergroups){
			
			$user_id = $this->user_id;				
				
			$fua_usergroups = array();
			if(!$user_id){
				//user is not logged in
				$fua_usergroups = array(10);
			}else{				
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
	
	function check_article_access($article_id, $category_id){
	
		//get usergroups				
		$fua_usergroups_array = $this->get_usergroups_from_database();	
			
		$return_item_access = 1;		
		
		$fua_item_access = 1;		
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
	
	function check_category_access($category_id){		
			
		return true;
	}
	
	function get_item_access_from_database(){
		
		static $item_access_array;
		
		if(!$item_access_array){	
			
			$this->database->setQuery("SELECT itemid_groupid FROM #__fua_items ");
			$item_access_array = $this->database->loadResultArray();	
			
		}
		
		return $item_access_array;
	}
	
	function get_category_access_from_database(){
	
		return true;
	}	
	
	function filter_articles($rows){

		if($this->is_super_user || !$this->trial_valid || !$this->fua_config['fua_enabled']){
			//dont restrict anything
			return $rows;
		}else{				
			foreach($rows as $key => $row){		
						
				//$row = (object)$row;
				$article_id = $row->id;
				$category_id = $row->catid;
				$article_access = $this->check_article_access($article_id, $category_id);	
				
				if(!$article_access){												
					unset($rows[$key]);						
				}
			}			
			return $rows;			
		}
	}	
	
	function filter_categories($rows){	
		
		return $rows;	
	}
	
	//deprecated, but still needs to be here because of possible remains of deprecated codes in template files
	function filter_category_blog($rows, $params){
		//filter articles	
		if($this->is_super_user || !$this->trial_valid || !$this->fua_config['fua_enabled']){	
			$items = $rows;	
		}else{
			$items = $this->filter_articles($rows);
		}
		$numLeading	= $params->def('num_leading_articles', 1);
		$numIntro = $params->def('num_intro_articles', 4);
		$numLinks = $params->def('num_links', 4);
		
		//add articles to the 3 output types
		$i = 0;
		foreach($items as $item){			
			$add_event = 1;
			if($i < $numLeading){
				$this->lead_items[$i] = $item;				
			}elseif($i < ($numLeading + $numIntro)){
				$this->intro_items[$i] = $item;				
			}else{
				$this->link_items[$i] = $item;
				$add_event = 0;
			}
			if($add_event){
				//run content events, but not when link-output
				$item->event = new stdClass();
				$dispatcher = JDispatcher::getInstance();
				$item->introtext = JHtml::_('content.prepare', $item->introtext);

				$results = $dispatcher->trigger('onContentAfterTitle', array('com_content.article', &$item, &$item->params, 0));
				$item->event->afterDisplayTitle = trim(implode("\n", $results));

				$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.article', &$item, &$item->params, 0));
				$item->event->beforeDisplayContent = trim(implode("\n", $results));

				$results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.article', &$item, &$item->params, 0));
				$item->event->afterDisplayContent = trim(implode("\n", $results));
			}
			$i++;
		}
		
		//reorder intro-items when in columns
		$columns = max(1, $params->def('num_columns', 1));
		$order = $params->def('multi_column_order', 1);
		if ($order == 0 && $columns > 1) {
			// call order down helper
			$this->intro_items = ContentHelperQuery::orderDownColumns($this->intro_items, $columns);
		}
		
	}
	
	
	function filter_search_results($rows){	
		
		if($this->is_super_user || !$this->trial_valid || !$this->fua_config['fua_enabled']){
			//dont restrict anything
			return $rows;
		}else{	
			$temp_rows = array();			
			foreach($rows as $key => $row){		
			
				if(isset($row->href)){
					$access = 1;				
					$href = $row->href;
					$option = '';
					
					$query = str_replace('index.php?', '', $href);
					$href_vars = explode('&', $query);
					$id = 0;
					$category_id = 0;				
					foreach($href_vars as $href_var){
						$temp = explode('=', $href_var);
						$key = $temp[0];
						$value = $temp[1];
						if($key=='id'){
							if(strpos($value, ':')){
								$temp2 = explode(':', $value);
								$value = $temp2[0];
							}
							$id = intval($value);						
						}
						if($key=='catid'){
							if(strpos($value, ':')){
								$temp2 = explode(':', $value);
								$value = $temp2[0];
							}
							$category_id = intval($value);							
						}
						if($key=='option'){
							$option = $value;							
						}
						if($key=='Itemid'){
							$menu_id = intval($value);							
						}					
					}	
					
					
						
					if(strpos($href, 'option=com_content&view=article&id=')){
						//article view										
						$access = $this->check_article_access($id, $category_id);							
					}
					
					if(isset($row->catid) && $option==''){								
						//category view
						//for category view the href is not fully parsed?						
						$option = 'com_content';										
					}
					
					if($access){										
						//component									
						$access = $this->check_component_access($option);
					}
					
					if($access){	
						$temp_rows[] = $row;
					}
				}
			}	
			$rows = $temp_rows;			
			return $rows;			
		}
	}
	
	function check_menu_access($menu_id){			
				
		return true;	
	}
	
	function check_component_access($option){		
			
		$fua_component_access = 1;
		
		//check category access
		if($this->fua_config['use_componentaccess']){
		
			$fua_component_access_rights = $this->get_component_access_from_database();			
				
			//get usergroup					
			$fua_usergroups_array = $this->get_usergroups_from_database();								
			
			$fua_component_access_array = array();
			
			foreach($fua_usergroups_array as $fua_usergroups_item){

				$fua_component_right = $option.'__'.$fua_usergroups_item;
									
				//check component permission
				$fua_component_access_temp = 'yes';					
				if($this->fua_config['component_reverse_access']){
					if(in_array($fua_component_right, $fua_component_access_rights) && $option!='com_frontenduseraccess'){	
						$fua_component_access_temp = 'no';								
					}
				}else{
					if(!in_array($fua_component_right, $fua_component_access_rights) && $option!='com_frontenduseraccess'){	
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
		}
		
		return $fua_component_access;	
	}
	
	function get_component_access_from_database(){
	
		static $component_access_array;
		
		if(!$component_access_array){	
			//get component access data
			$this->database->setQuery("SELECT component_groupid FROM #__fua_components");
			$component_access_array = $this->database->loadResultArray();
		}
		
		return $component_access_array;
	
	}
	
	function get_menu_access_from_database(){
	
		return true;
	
	}
	
	function where_in_articles(){
	
		static $fua_where_in_articles;
		
		//not for super-admins
		if($this->is_super_user){
			return '';
		}
		
		if(!$fua_where_in_articles){
		
			$trial_access = 1;
			if($this->version_type=='trial'){						
				$trial_access = $this->fua_check_trial_version();			
			}
		
			$fua_where_in_articles = '';
			if($trial_access){
				$database = JFactory::getDBO();
				
				//get all articles
				$database->setQuery("SELECT id, catid, sectionid FROM #__content ");
				$rows = $database->loadObjectList();
				
				//filter articles
				$filtered_articles = $this->filter_articles($rows);
				
				//make string
				$fua_where_in_articles = ' in (0';
				
				foreach($filtered_articles as $article){					
					$fua_where_in_articles .= ','.$article->id;
				}
				$fua_where_in_articles .= ') ';	
			}		
			
		}
		
		return $fua_where_in_articles;
	}
	

}
?>
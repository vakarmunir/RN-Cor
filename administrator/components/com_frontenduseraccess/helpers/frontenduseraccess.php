<?php
/**
* @package Frontend-User-Access (com_frontenduseraccess)
* @version 4.1.6
* @copyright Copyright (C) 2008-2012 Carsten Engel. All rights reserved.
* @license GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html 
* @author http://www.pages-and-items.com
*/

// No direct access
defined('_JEXEC') or die;

class frontenduseraccessHelper{	

	public static function addSubmenu($vName = 'frontenduseraccess', $fua_config){		
			
		JSubMenuHelper::addEntry(
			JText::_('COM_FRONTENDUSERACCESS_CONFIG'),
			'index.php?option=com_frontenduseraccess&view=config',
			$vName == 'config'
		);		
		JSubMenuHelper::addEntry(
			JText::_('COM_FRONTENDUSERACCESS_USERGROUPS'),
			'index.php?option=com_frontenduseraccess&view=usergroups',
			$vName == 'usergroups' || $vName == 'usergroup'
		);		
		JSubMenuHelper::addEntry(
			JText::_('COM_FRONTENDUSERACCESS_USERS'),
			'index.php?option=com_frontenduseraccess&view=users',
			$vName == 'users'
		);
		
		$dot_green = '<span class="fua_dot fua_green">&#149;</span> ';
		$dot_red = '<span class="fua_dot fua_red">&#149;</span> ';
		
		if($fua_config['items_active']){
			$dot = $dot_green;
		}else{
			$dot = $dot_red;
		}
		JSubMenuHelper::addEntry(
			$dot.JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS'),
			'index.php?option=com_frontenduseraccess&view=items',
			$vName == 'items'
		);
		if($fua_config['categories_active']){
			$dot = $dot_green;
		}else{
			$dot = $dot_red;
		}
		JSubMenuHelper::addEntry(
			$dot.JText::_('COM_FRONTENDUSERACCESS_CATEGORY_ACCESS'),
			'index.php?option=com_frontenduseraccess&view=categories',
			$vName == 'categories'
		);
		if($fua_config['modules_active']){
			$dot = $dot_green;
		}else{
			$dot = $dot_red;
		}
		JSubMenuHelper::addEntry(
			$dot.JText::_('COM_FRONTENDUSERACCESS_MODULE_ACCESS'),
			'index.php?option=com_frontenduseraccess&view=modules',
			$vName == 'modules'
		);
		if($fua_config['use_componentaccess']){
			$dot = $dot_green;
		}else{
			$dot = $dot_red;
		}
		JSubMenuHelper::addEntry(
			$dot.JText::_('COM_FRONTENDUSERACCESS_COMPONENT_ACCESS'),
			'index.php?option=com_frontenduseraccess&view=components',
			$vName == 'components'
		);
		if($fua_config['use_menuaccess']){
			$dot = $dot_green;
		}else{
			$dot = $dot_red;
		}
		JSubMenuHelper::addEntry(
			$dot.JText::_('COM_FRONTENDUSERACCESS_MENU_ACCESS'),
			'index.php?option=com_frontenduseraccess&view=menuaccess',
			$vName == 'menuaccess'
		);	
		if($fua_config['parts_active']){
			$dot = $dot_green;
		}else{
			$dot = $dot_red;
		}
		JSubMenuHelper::addEntry(
			$dot.JText::_('COM_FRONTENDUSERACCESS_PART_ACCESS'),
			'index.php?option=com_frontenduseraccess&view=parts',
			$vName == 'parts' || $vName == 'part'
		);	
		if($fua_config['parts_active']){
			$dot = $dot_green;
		}else{
			$dot = $dot_red;
		}
		/*
		JSubMenuHelper::addEntry(
			$dot.JText::_('COM_FRONTENDUSERACCESS_DOWNLOAD_ACCESS'),
			'index.php?option=com_frontenduseraccess&view=downloads',
			$vName == 'downloads' || $vName == 'download'
		);
		*/
		JSubMenuHelper::addEntry(
			JText::_('COM_FRONTENDUSERACCESS_SUPPORT'),
			'index.php?option=com_frontenduseraccess&view=support',
			$vName == 'support'
		);		
	}
	
	public function check_templates(){
	
		$files = $this->get_files();
		$database = JFactory::getDBO();	
		$code_is_in_files = 0;
		
		//get templates		
		$database->setQuery("SELECT name "
		." FROM #__extensions "
		." WHERE  client_id='0' AND type='template'  "		
		);
		$rows = $database->loadObjectList();
		foreach($rows as $template){			
			for($n = 0; $n < count($files); $n++){
				if($this->check_template_override($files[$n], $template->name)){
					$code_is_in_files = 1;
					break 2;
				}
			}
		}
		return $code_is_in_files;
	}
	
	
	public function check_template_override($template_override, $template){
		$file = JPATH_ROOT.DS.'templates'.DS.$template.DS.'html'.DS.$template_override.'.php';	
		$get_code = $this->get_code($template_override);
		$code = $get_code[2];
		$return = 1;		
		if(!file_exists($file)){
			//file is not there
			$return = 0;	
		}else{
			//file is there
			$fstring = JFile::read($file);
			if(!strpos($fstring, $code)){
				$return = 0;	
			}			
		}
		return $return;
	}
	
	
	public function get_files(){
		$files = array();
		$files[] = 'com_content/archive/default_items';
		$files[] = 'com_content/categories/default_items';
		$files[] = 'com_content/category/blog';
		$files[] = 'com_content/category/blog_children';
		$files[] = 'com_content/category/default_articles';
		$files[] = 'com_content/category/default_children';
		$files[] = 'com_content/featured/default';
		$files[] = 'com_search/search/default_results';
		$files[] = 'mod_articles_categories/default_items';
		$files[] = 'mod_articles_category/default';	
		$files[] = 'mod_articles_latest/default';
		$files[] = 'mod_articles_news/_item';	
		$files[] = 'mod_articles_popular/default';	
		$files[] = 'mod_related_items/default';				
		return $files;
	}
	
	function get_code($template_override){		
		
		$source_file = '';
		$path = '';
		$code = '';
		switch ($template_override) {
			case 'com_content/archive/default_items':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'archive'.DS.'tmpl'.DS.'default_items.php';
				$path = 'com_content'.DS.'archive';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this->items = $frontenduseraccessAccessChecker->filter_articles($this->items);
}
//end filter articles';
				break;	
			case 'com_content/categories/default_items':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'categories'.DS.'tmpl'.DS.'default_items.php';
				$path = 'com_content'.DS.'categories';
				$code = '//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this->items[$this->parent->id] = $frontenduseraccessAccessChecker->filter_categories($this->items[$this->parent->id]);
}
//end filter categories';
				break;
			case 'com_content/category/blog':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'category'.DS.'tmpl'.DS.'blog.php';
				$path = 'com_content'.DS.'category';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$frontenduseraccessAccessChecker->filter_category_blog($this->items, $this->params);
$this->lead_items = $frontenduseraccessAccessChecker->lead_items;
$this->intro_items = $frontenduseraccessAccessChecker->intro_items;
$this->link_items = $frontenduseraccessAccessChecker->link_items;
}
//end filter articles';
				break;
			case 'com_content/category/blog_children':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'category'.DS.'tmpl'.DS.'blog_children.php';
				$path = 'com_content'.DS.'category';				
				$code = '//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this->children[$this->category->id] = $frontenduseraccessAccessChecker->filter_categories($this->children[$this->category->id]);
}
//end filter categories';				
				break;
			case 'com_content/category/default_articles':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'category'.DS.'tmpl'.DS.'default_articles.php';
				$path = 'com_content'.DS.'category';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this->items = $frontenduseraccessAccessChecker->filter_articles($this->items);
}
//end filter articles';
				break;
			case 'com_content/category/default_children':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'category'.DS.'tmpl'.DS.'default_children.php';
				$path = 'com_content'.DS.'category';
				$code = '//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this->children[$this->category->id] = $frontenduseraccessAccessChecker->filter_categories($this->children[$this->category->id]);
}
//end filter categories';
				break;
			case 'com_content/featured/default':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'featured'.DS.'tmpl'.DS.'default.php';
				$path = 'com_content'.DS.'featured';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$frontenduseraccessAccessChecker->filter_category_blog($this->items, $this->params);
$this->lead_items = $frontenduseraccessAccessChecker->lead_items;
$this->intro_items = $frontenduseraccessAccessChecker->intro_items;
$this->link_items = $frontenduseraccessAccessChecker->link_items;
}
//end filter articles';
				break;
			case 'com_search/search/default_results':						
				$source_file = JPATH_ROOT.DS.'components'.DS.'com_search'.DS.'views'.DS.'search'.DS.'tmpl'.DS.'default_results.php';
				$path = 'com_search'.DS.'search';
				$code = '//start filter articles/categories/components/menu-items as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this->results = $frontenduseraccessAccessChecker->filter_search_results($this->results);
}
//end filter';
				break;	
			case 'mod_articles_categories/default_items':						
				$source_file = JPATH_ROOT.DS.'modules'.DS.'mod_articles_categories'.DS.'tmpl'.DS.'default_items.php';
				$path = 'mod_articles_categories';
				$code = '//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker->filter_categories($list);
}
//end filter';
				break;	
			case 'mod_articles_category/default':						
				$source_file = JPATH_ROOT.DS.'modules'.DS.'mod_articles_category'.DS.'tmpl'.DS.'default.php';
				$path = 'mod_articles_category';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker->filter_articles($list);
}
//end filter';
				break;
			case 'mod_articles_latest/default':						
				$source_file = JPATH_ROOT.DS.'modules'.DS.'mod_articles_latest'.DS.'tmpl'.DS.'default.php';
				$path = 'mod_articles_latest';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker->filter_articles($list);
}
//end filter';
				break;
			case 'mod_articles_news/_item':						
				$source_file = JPATH_ROOT.DS.'modules'.DS.'mod_articles_news'.DS.'tmpl'.DS.'_item.php';
				$path = 'mod_articles_news';
				$code = '//start filter article as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
if(!$frontenduseraccessAccessChecker->check_article_access($item->id, $item->catid)){
$item->title = \'\';
$item->afterDisplayTitle = \'\';
$item->introtext = \'\';
$item->link = \'\';
$item->readmore = \'\';
$item->linkText = \'\';
}
}
//end filter';
				break;
			case 'mod_articles_popular/default':						
				$source_file = JPATH_ROOT.DS.'modules'.DS.'mod_articles_popular'.DS.'tmpl'.DS.'default.php';
				$path = 'mod_articles_popular';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker->filter_articles($list);
}
//end filter';
				break;
			case 'mod_related_items/default':						
				$source_file = JPATH_ROOT.DS.'modules'.DS.'mod_related_items'.DS.'tmpl'.DS.'default.php';
				$path = 'mod_related_items';
				$code = '//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){
require_once(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker->filter_articles($list);
}
//end filter';
				break;							
		}
		$code = '
'.$code;
		return array($source_file, $path, $code);
	}
	
	function check_for_code($file, $code){		
		if(!file_exists($file)){
			return 0;
		}
		if ($fp = @fopen($file, "rb")){	
			$null = NULL;					
			$file_string = file_get_contents($file, $null, $null, 0, 3000);				
			fclose ($fp);							
			if(strpos($file_string, $code)){			
				return 1;					
			}			
		}
	}
	
}
?>
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

jimport( 'joomla.application.component.view');

class frontenduseraccessViewMenuaccess extends JView{

	protected $items;
	protected $pagination;
	protected $state;		

	function display($tpl = null){
	
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
	
		$database = JFactory::getDBO();
		$controller = new frontenduseraccessController();	
		$this->assignRef('controller', $controller);	
		
		//toolbar			
		JToolBarHelper::custom( 'menuaccess_save', 'save.png', 'save_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );	
		
		//get usergroups from db
		$fua_usergroups = $controller->get_usergroups();		
		$this->assignRef('fua_usergroups', $fua_usergroups);
		
		//get menu access from db
		$controller->db->setQuery("SELECT menuid_groupid FROM #__fua_menuaccess");
		$access_menuitems = $controller->db->loadResultArray();
		$this->assignRef('access_menuitems', $access_menuitems);
		
		/*
		//get menu types from db
		$controller->db->setQuery("SELECT title, menutype FROM #__menu_types ORDER BY title ASC"  );
		$menutypes = $controller->db->loadObjectList();
		$menutypes_db = array();	
		foreach($menutypes as $menutype_db){
			$fixed_type = str_replace('-','separator',$menutype_db->menutype);	
			$fixed_type = str_replace(' ','spacer',$fixed_type);			
			$new_menutype = array($fixed_type,$menutype_db->title);
			array_push($menutypes_db, $new_menutype);					
		}	
		$this->assignRef('menu_types', $menutypes_db);
		
		
		//get menuitems from db
		$controller->db->setQuery("SELECT id, menutype, name, parent, access, ordering FROM #__menu WHERE (published='0' OR published='1') ORDER BY ordering ASC");
		$fua_menu_items = $controller->db->loadObjectList();		
		$this->assignRef('fua_menu_items', $fua_menu_items);
		*/
		
		parent::display($tpl);
	}
	
	static function get_menu_type_options(){
		$database = JFactory::getDBO();
		$database->setQuery("SELECT menutype, title FROM #__menu_types ORDER BY title ASC"  );
		$menutypes = $database->loadObjectList();
		$options = array();
		foreach($menutypes as $menutype){
			$options[] = JHtml::_('select.option', $menutype->menutype, $menutype->title);					
		}		
		return $options;
	}
	
}
?>
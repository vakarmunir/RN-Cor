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

class frontenduseraccessViewCategories extends JView{

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
		
		$helper = new frontenduseraccessHelper();
		$this->assignRef('helper', $helper);	
		
		//toolbar		
		JToolBarHelper::custom( 'access_categories_save', 'save.png', 'save_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );
	
		//get usergroups from db
		$fua_usergroups = $controller->get_usergroups();
		$this->assignRef('fua_usergroups', $fua_usergroups);		
				
		//get category access from db
		$controller->db->setQuery("SELECT category_groupid FROM #__fua_categories");
		$access_categories = $controller->db->loadResultArray();
		$this->assignRef('access_categories', $access_categories);	
		
		/*
		//search			
		$search = $app->getUserStateFromRequest($option.'categories_search', 'categories_search', '', 'string');	
		$search = $controller->clean_search_string($search);
		if($search!=''){
			$where[] = 'title LIKE '.$controller->db->Quote( '%'.$controller->db->getEscaped( $search, true ).'%', false ).' ';
		}	
		$this->assignRef('search', $search);	
		
				
		$controller->db->setQuery( "SELECT SQL_CALC_FOUND_ROWS id, title, name "
		. "\nFROM #__categories "					
		. $where
		. "\nORDER BY title "
		. $limit_query
		);		
		$categories = $controller->db->loadObjectList();
		$this->assignRef('categories', $categories);	

		*/

		parent::display($tpl);
	}
}
?>
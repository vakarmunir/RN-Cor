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

class frontenduseraccessViewDownloads extends JView{
	
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
		JToolBarHelper::custom('part','new.png','new_f2.png',JText::_('JTOOLBAR_NEW'),false,false);	
		JToolBarHelper::custom('part_delete','delete.png','delete_f2.png',JText::_('JTOOLBAR_DELETE'),false,false);			
		JToolBarHelper::custom('access_parts_save', 'save.png', 'save_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );
		
		//get usergroups from db
		$fua_usergroups = $controller->get_usergroups();
		$this->assignRef('fua_usergroups', $fua_usergroups);
		
		//get downloads access from db
		$controller->db->setQuery("SELECT download_group FROM #__fua_downloadsaccess");
		$access_downloads = $controller->db->loadResultArray();
		$this->assignRef('access_downloads', $access_downloads);
		
		parent::display($tpl);
	}
	
}
?>
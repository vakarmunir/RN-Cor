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

class frontenduseraccessViewComponents extends JView{

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
		JToolBarHelper::custom( 'components_save', 'save.png', 'save_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );	
		
		//get usergroups from db
		$fua_usergroups = $controller->get_usergroups();
		$this->assignRef('fua_usergroups', $fua_usergroups);
		
		//get components access from db
		$controller->db->setQuery("SELECT component_groupid FROM #__fua_components");
		$access_components = $controller->db->loadResultArray();
		$this->assignRef('access_components', $access_components);		

		parent::display($tpl);
	}
}
?>
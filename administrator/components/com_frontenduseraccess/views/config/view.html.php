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

class frontenduseraccessViewConfig extends JView{

	function display($tpl = null){
	
		$controller = new frontenduseraccessController();	
		$this->assignRef('controller', $controller);	
		
		$helper = new frontenduseraccessHelper();
		$this->assignRef('helper', $helper);
		
		$system_plugin_correct_order = $this->check_system_plugin_order();
		$this->assignRef('system_plugin_correct_order', $system_plugin_correct_order);
		
		//toolbar	
		// Options button.
		if (JFactory::getUser()->authorise('core.admin', 'com_frontenduseraccess')) {
			JToolBarHelper::preferences('com_frontenduseraccess');
		}			
		JToolBarHelper::custom( 'config_save', 'save.png', 'save_f2.png', JText::_('JSAVE'), false, false );	
		JToolBarHelper::custom( 'config_apply', 'apply.png', 'apply_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );
		JToolBarHelper::custom( 'cancel', 'cancel.png', 'cancel_f2.png', JText::_('JTOOLBAR_CANCEL'), false, false );
		//JToolBarHelper::preferences('com_frontenduseraccess');	

		parent::display($tpl);
	}
	
	function get_groups(){
		$database = JFactory::getDBO();
		$database->setQuery(
			'SELECT a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level' .
			' FROM #__usergroups AS a' .
			' LEFT JOIN `#__usergroups` AS b ON a.lft > b.lft AND a.rgt < b.rgt' .
			' WHERE a.id<>8 AND a.id<>1 '.
			' GROUP BY a.id' .
			' ORDER BY a.lft ASC'
		);
		$groups = $database->loadObjectList();
		foreach ($groups as &$group) {
			$group->text = str_repeat('- ',$group->level).$group->text;
		}
		return $groups;
	}
	
	function check_system_plugin_order(){
	
		$database = JFactory::getDBO();	
				
		$system_plugin_correct_order = 0;
		
		$database->setQuery("SELECT element, ordering "
		." FROM #__extensions "
		." WHERE type='plugin' AND folder='system' "
		." ORDER BY ordering ASC "
		);
		$rows = $database->loadObjectList();
		$order = array();
		$fua_order = 0;
		foreach($rows as $row){	
			//echo $row->element.'<br>';
			$order[] = $row->element;	
			if($row->element=='frontenduseraccess'){
				$fua_order = $row->ordering;
			}
		}
		
		//check order
		if(
		//first position all good
		($order[0]=='frontenduseraccess') || 
		//if second and first is admintools or oneclickaction
		($order[1]=='frontenduseraccess' && ($order[0]=='oneclickaction' || $order[0]=='admintools')) ||
		//if third and first and second are admintools or oneclickaction 
		($order[2]=='frontenduseraccess' && ($order[0]=='oneclickaction' || $order[0]=='admintools') && ($order[1]=='oneclickaction' || $order[1]=='admintools'))
		){			
			$system_plugin_correct_order = 1;
		}		
		
		//check order is not 0
		if($fua_order==0){
			//not installed or order is '0'
			$system_plugin_correct_order = 0;
		}
		
		return $system_plugin_correct_order;
	}
}
?>
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

class frontenduseraccessViewUsergroup extends JView
{
	function display($tpl = null)
	{
		$database = JFactory::getDBO();
		$controller = new frontenduseraccessController();	
		$this->assignRef('controller', $controller);	
		
		//toolbar		
		JToolBarHelper::custom( 'usergroup_save', 'save.png', 'save_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );
		JToolBarHelper::custom( 'cancel', 'cancel.png', 'cancel_f2.png', JText::_('JTOOLBAR_CANCEL'), false, false );
		
		$sub_task = JRequest::getVar('sub_task', '');
		$this->assignRef('sub_task', $sub_task);
		
		parent::display($tpl);
	}
}
?>
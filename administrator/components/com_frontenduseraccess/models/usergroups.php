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

jimport('joomla.application.component.modellist');

class frontenduseraccessModelUsergroups extends JModelList{	

	protected function populateState(){
		
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.		
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'usergroups_search', '', 'string');					
		$this->setState('filter.search', $search);		

		// List state information.
		//parent::populateState('u.name', 'asc');
		//workaround for disfuntional code	
		$listDirn = JRequest::getVar('filter_order', 'u.name');			
		parent::populateState($listDirn, 'asc');
	}
	
	protected function getStoreId($id = ''){			
		
		$id	.= ':'.$this->getState('filter.search');

		return parent::getStoreId($id);
	}
	
	protected function getListQuery(){
	
		// Create a new query object.
		$db	= $this->getDbo();
		$query = $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'* '				
			)
		);
		$query->from('`#__fua_usergroups` AS u');
		$query->where('u.id<>"9" AND u.id<>"10" ');
		
		// Filter the comments over the search string if set.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('u.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('u.name LIKE '.$search);
			}
		}
		
		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'u.name')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));
		
		return $query;
		
	}
}
?>
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

class frontenduseraccessModelDownloads extends JModelList{	
	
	protected function populateState(){
		
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.		
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search', '', 'string');					
		$this->setState('filter.search', $search);	
		
		$accesscolumn = $app->getUserStateFromRequest('frontenduseraccess.accesscolumn', 'accesscolumn', 'yes');
		$this->setState('accesscolumn', $accesscolumn);	

		// List state information.
		//parent::populateState('p.name', 'asc');
		//workaround for disfuntional code	
		$listDirn = JRequest::getVar('filter_order', 'd.name');			
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
				'd.*'				
			)
		);
		$query->from('`#__fua_downloads` AS d');			
		
		// Filter the items over the search string if set.
		if ($this->getState('filter.search') !== '') {
			// Escape the search token.
			$token	= $db->Quote('%'.$db->getEscaped($this->getState('filter.search')).'%');

			// Compile the different search clauses.
			$searches	= array();
			$searches[]	= 'd.id LIKE '.$token;
			$searches[]	= 'd.file LIKE '.$token;	
			$searches[]	= 'd.name LIKE '.$token;		

			// Add the clauses to the query.
			$query->where('('.implode(' OR ', $searches).')');
		}	
		
		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'd.name')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));
		
		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
		
	}

}
?>
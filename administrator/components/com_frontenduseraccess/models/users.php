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

class frontenduseraccessModelUsers extends JModelList{	

	protected function populateState(){
	
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// search	
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'users_search', '', 'string');					
		$this->setState('filter.search', $search);		
		
		// joomla group filter
		$joomla_group = $app->getUserStateFromRequest($this->context.'.filter.joomla_group', 'users_joomla_group_filter', '', 'int');					
		$this->setState('filter.joomla_group', $joomla_group);	
		
		// exact
		$exact = $app->getUserStateFromRequest($this->context.'.filter.exact', 'exact', 'not_exact_mode', 'word');					
		$this->setState('filter.exact', $exact);
		
		// usergroup filter stuff	
		$controller = new frontenduseraccessController();	
		$usergroup_filter = JRequest::getVar('usergroup_filter', null, 'post', 'array');
		if(isset($usergroup_filter[0])){			
			//filter 0 out
			if(in_array(0, $usergroup_filter)){
				$temp = array();
				foreach($usergroup_filter as $group){
					if($group!=0){				
						$temp[] = $group;
					}
				}
				$usergroup_filter = $temp;
			}			
			sort($usergroup_filter);
			//make into csv string			
			$usergroup_filter = $controller->array_to_csv($usergroup_filter);
			//if a usergroup_filter is parsed, save it to session			
			$app->setUserState($this->context.'.filter.usergroups', $usergroup_filter);	
		}else{
			$usergroup_filter = $app->getUserStateFromRequest($this->context.'.filter.usergroups', '');
		}	
		$usergroup_filter_array = $controller->csv_to_array($usergroup_filter);	
		$this->setState('filter.usergroups_csv', $usergroup_filter);				
		$this->setState('filter.usergroups', $usergroup_filter_array);				

		// List state information.
		//parent::populateState('u.name', 'asc');
		//workaround for disfuntional code	
		$listDirn = JRequest::getVar('filter_order', 'u.username');			
		parent::populateState($listDirn, 'asc');
	}
	
	protected function getStoreId($id = ''){			
		
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.joomla_group');
		$id	.= ':'.$this->getState('filter.exact');
		$id	.= ':'.$this->getState('filter.usergroups_csv');
		$id	.= ':'.$this->getState('filter.usergroups');

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
				//'u.id AS id, u.name, u.username, u.email'
				'u.id AS id, u.*'
						
			)
		);
		$query->from('#__users AS u');		
		
		// Join over the user groups table.		
		$query->select('GROUP_CONCAT(DISTINCT g.title SEPARATOR '.$db->Quote("<br />").') AS gid');		
		$query->join('LEFT', '#__user_usergroup_map AS m ON m.user_id=u.id ');
		$query->group('u.id');
		
		//join fua usergroups
		$query->select('i.group_id AS fua_usergroups');		
		$query->join('LEFT', '#__fua_userindex AS i ON i.user_id=u.id ');	
		
		//join fua usergroup names
		//$query->select('fg.name AS fua_usergroupnames');	
		//$query->join('LEFT', '#__fua_usergroups AS fg ON fg.id=i.group_id ');	
			
		//join usergroups		
		$query->join('LEFT', '#__usergroups AS g ON g.id = m.group_id ');
		
		//join usergroups again
		$query->join('LEFT', '#__user_usergroup_map AS m2 ON m2.user_id=u.id ');
			
		//no super admins in list
		$query->where('8 NOT IN (SELECT group_id FROM #__user_usergroup_map WHERE user_id=u.id)');
		
		// Filter the items over the search string if set.
		if ($this->getState('filter.search') !== '') {
			// Escape the search token.
			$token	= $db->Quote('%'.$db->getEscaped($this->getState('filter.search')).'%');

			// Compile the different search clauses.
			$searches	= array();
			$searches[]	= 'u.name LIKE '.$token;
			$searches[]	= 'u.username LIKE '.$token;
			$searches[]	= 'u.email LIKE '.$token;

			// Add the clauses to the query.
			$query->where('('.implode(' OR ', $searches).')');
		}
		
		if($this->getState('filter.joomla_group')){		
			$query->where($this->getState('filter.joomla_group').' IN (SELECT group_id FROM #__user_usergroup_map WHERE user_id=u.id)');
		}
		
		if($this->getState('filter.usergroups_csv')){	
			if($this->getState('filter.exact')=='exact_mode'){				
				$query->where("(i.group_id='".$this->getState('filter.usergroups_csv')."')");
			}else{
				$group_filter = array();
				foreach($this->getState('filter.usergroups') as $usergroup_filter_item){
					$temp = '"'.$usergroup_filter_item.'"';										
					$group_filter[]	= "i.group_id LIKE '%".$temp."%'";
				}
				$query->where('('.implode(' OR ', $group_filter).')');
			}
		}
		
		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'u.name')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));
		
		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
		
	}
}
?>
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

class frontenduseraccessViewUsers extends JView{

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
		JToolBarHelper::custom( 'users_export', 'export', 'export', JText::_('COM_FRONTENDUSERACCESS_EXPORT_SELECTION'), false, false );
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();		
		JToolBarHelper::custom( 'users_save', 'save.png', 'save_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );		
		
		//get usergroups
		$controller->db->setQuery("SELECT * FROM #__fua_usergroups WHERE (id!='9') AND (id!='10') ORDER BY ordering ASC, name ASC");
		$fua_usergroups = $controller->db->loadObjectList();
		$this->assignRef('fua_usergroups', $fua_usergroups);	
		
		/*
		//get joomla usergroup index
		$group_id_index_array = $this->get_group_id_index_array();
		$this->assignRef('group_id_index_array', $group_id_index_array);	
		*/
		
		
		
		/*
		
		//get limits			
		global $option;
		$app = JFactory::getApplication();
		$limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );		
		$limit_query = "";
		if($limit!=0){
			$limit_query = "LIMIT ".$limitstart.", ".$limit." ";
		}			
		
		
		//start where
		$where = array();		
		$where[] = "8 NOT IN (SELECT group_id FROM #__user_usergroup_map WHERE user_id=u.id)";
		
		//search
		$search = $app->getUserStateFromRequest($option.'users_search', 'users_search', '', 'string');	
		$search = $controller->clean_search_string($search);
		if($search!=''){
			//$where[] = '((u.name LIKE '.$controller->db->Quote( '%'.$controller->db->getEscaped( $search, true ).'%', false ).') OR (u.username LIKE '.$controller->db->Quote( '%'.$controller->db->getEscaped( $search, true ).'%', false ).') OR (u.email LIKE '.$controller->db->Quote( '%'.$controller->db->getEscaped( $search, true ).'%', false ).'))';
		}
		$this->assignRef('search', $search);
		
		//joomla_group_filter
		$joomla_group_filter = $app->getUserStateFromRequest($option.'users_joomla_group_filter', 'users_joomla_group_filter', '', 'int');
		if($joomla_group_filter!=''){
			//$where[] = '(u.gid = '.$joomla_group_filter.')';
			$where[] = " ".$joomla_group_filter." IN (SELECT group_id FROM #__user_usergroup_map WHERE user_id=u.id)";
		}
		$this->assignRef('joomla_group_filter', $joomla_group_filter);	
		
		//usergroup exact filter stuff
		$exact = $app->getUserStateFromRequest($option.'exact', 'exact', '', 'word');
		if($exact!='exact_mode'){
			$exact = 'not_exact_mode';
		}
		$this->assignRef('exact', $exact);	
		
		//usergroup filter stuff	
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
			$app->setUserState("com_frontenduseraccess.usergroup_filter", $usergroup_filter);	
		}else{
			$usergroup_filter = $app->getUserStateFromRequest("com_frontenduseraccess.usergroup_filter", '');
		}	
		$usergroup_filter_array = $controller->csv_to_array($usergroup_filter);		
		$this->assignRef('usergroup_filter_array', $usergroup_filter_array);		
		if($usergroup_filter){	
			if($exact=='exact_mode'){	
				echo $usergroup_filter;
				$where[] = "(i.group_id='".$usergroup_filter."')";
			}else{									
				foreach($usergroup_filter_array as $usergroup_filter_item){
					$temp = '"'.$usergroup_filter_item.'"';
					$where[] = "(i.group_id LIKE '%".$temp."%')";
				}				
			}
		}else{
			$usergroup_filter = '0';
		}	
		$this->assignRef('usergroup_filter', $usergroup_filter);	
			
		//end where
		$where = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );	
		
		//order	
		$order = $app->getUserStateFromRequest($option.'users_order', 'users_order', 'u.name', 'cmd');		
		if(!in_array($order, array('u.name', 'username', 'email', 'group_id'))){
			$order = 'u.name';
		}
		$this->assignRef('order', $order);
		
		//order_dir
		$order_dir = $app->getUserStateFromRequest($option.'users_order_dir', 'users_order_dir', 'asc', 'word');			
		if(!in_array($order_dir, array('asc', 'desc'))){
			$order_dir = 'asc';
		}	
		$order_dir = strtoupper($order_dir);		
		$this->assignRef('order_dir', $order_dir);
		
		$orderby = " ORDER BY ". $order ." ". $order_dir." ";		
		
		//get users from db
		$controller->db->setQuery( "SELECT SQL_CALC_FOUND_ROWS "
		." COUNT(m.group_id) AS group_count, " // ?
		." GROUP_CONCAT(DISTINCT m.group_id SEPARATOR ".$controller->db->Quote(',').") AS gid, "
		." u.id AS id, u.name, u.username, u.email, "
		." i.group_id AS fua_usergroups "
		." FROM #__users AS u "			
		." LEFT JOIN #__user_usergroup_map AS m ON m.user_id=u.id "	
		." LEFT JOIN #__usergroups AS g ON g.id = m.group_id "	
		." LEFT JOIN #__user_usergroup_map AS m2 ON m2.user_id=u.id "				
		." LEFT JOIN #__fua_userindex AS i ON i.user_id=u.id "				
		.$where			
		." GROUP BY u.id "			
		.$orderby		
		.$limit_query			
		);		
		$fua_users = $controller->db->loadObjectList();
		
		//print_r($fua_users);
					
		
		$this->assignRef('fua_users', $fua_users);
		
		//get total from db just for pagination
		$controller->db->setQuery('SELECT FOUND_ROWS();');
		$total = $controller->db->loadResult();			
		
		//get pagination stuff
		jimport( 'joomla.html.pagination' );
		$pagination = new JPagination($total,$limitstart,$limit);
		$this->assignRef('pagination', $pagination);					
*/
		parent::display($tpl);
	}
	
	/*
	static function get_group_id_index_array(){	
		$database = JFactory::getDBO();
		$database->setQuery(
		" SELECT id, title "
		." FROM #__usergroups "		
		." ORDER BY title ASC "
		);
		$groups = $database->loadObjectList();
		$group_id_index_array = array();
		foreach($groups as $group){
			$group_id_index_array[$group->id] = $group->title;
		}		
		return $group_id_index_array;
	}
	*/
	
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
	
	
}
?>
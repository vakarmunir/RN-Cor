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

class frontenduseraccessViewBatchassign extends JView
{
	function display($tpl = null)
	{				
		$controller = new frontenduseraccessController();	
		$this->assignRef('controller', $controller);
		
		//only super admins should do this
		/*
		if(!$controller->is_super_user){
			die('only super admins can do this');
		}
		*/
		
		$batchtype = $controller->get_var('batchtype', '', 'get');
		$this->assignRef('batchtype', $batchtype);
		
		$mode = $controller->get_var('mode', '', 'get');
		$this->assignRef('mode', $mode);
		
		if($batchtype=='jf'){
			//joomlagroup to fua group
			
			$j = intval($controller->get_var('j', '', 'get', 'int'));
			$this->assignRef('j', $j);
			$f = $controller->get_var('f');			
			$this->assignRef('f', $f);
			
			//get users which need updating			
			$controller->db->setQuery( "SELECT u.id as id, u.username as username "
			. " FROM #__users AS u "			
			. " LEFT JOIN #__user_usergroup_map AS m "
			. " ON m.user_id=u.id "
			. " WHERE m.group_id='$j' "
			. " ORDER BY username ASC "
			);		
			
		}elseif($batchtype=='ff'){
			//fua group to fua group
						
			$f1 = $controller->get_var('f1', '', 'get');
			$this->assignRef('f1', $f1);
			$f2 = $controller->get_var('f2', '', 'get');
			$this->assignRef('f2', $f2);
			
			
			
			if($f1==$f2){
				$app = JFactory::getApplication();				
				$app->redirect('index.php?option=com_frontenduseraccess&view=config&tab=users', JText::_('COM_FRONTENDUSERACCESS_NO_USERS_TO_RENDER'));	
			}			
			
			if($f1=='0'){				
				
				//get userid's from index
				$controller->db->setQuery( "SELECT user_id "
				. "FROM #__fua_userindex "		
				);
				$fua_user_ids = $controller->db->loadResultArray();
				$fua_ids_string = '';
				$first = 1;
				foreach($fua_user_ids as $fua_user_id){
					if(!$first){
						$fua_ids_string .= ',';
					}
					$fua_ids_string .= $fua_user_id;
					$first = 0;
				}
				
				/*
				$controller->db->setQuery( "SELECT u.id as id, u.username as username "
				. " FROM #__users "	
				. " LEFT JOIN #__user_usergroup_map AS m "
				. " ON m.user_id=u.id "
				. " WHERE m.group_id<>'8' "				
				. " WHERE (id NOT IN ($fua_ids_string)) "
				. " ORDER BY username ASC "
				);	
				*/
				
				if($fua_ids_string!=''){	
					//user index table not empty
					
					/*
					$controller->db->setQuery( "SELECT id, username "
					. "FROM #__users "				
					. "WHERE (id NOT IN ($fua_ids_string)) AND (m.group_id<>'8') "
					. "ORDER BY username ASC "
					);
					*/
					//echo 'not empty';
					$controller->db->setQuery( "SELECT u.id as id, u.username as username "
					. " FROM #__users AS u"	
					. " LEFT JOIN #__user_usergroup_map AS m "
					. " ON m.user_id=u.id "
					. " WHERE (m.group_id<>'8') "				
					. " AND (id NOT IN ($fua_ids_string)) "
					. " ORDER BY username ASC "
					);
						
				}else{
					//user index table empty
					
					/*
					$controller->db->setQuery( "SELECT id, username "
					. "FROM #__users "				
					. "WHERE (m.group_id<>'8') "
					. "ORDER BY username ASC "
					);
					*/
					//echo 'empty';
					$controller->db->setQuery( "SELECT u.id as id, u.username as username "
					. " FROM #__users AS u"	
					. " LEFT JOIN #__user_usergroup_map AS m "
					. " ON m.user_id=u.id "
					. " WHERE m.group_id<>'8' "
					. " ORDER BY username ASC "
					);
					
				}
				
			}else{	
			
				//make requested group csv
				$f1_csv = '"'.$f1.'"';
				
				//echo $f1_csv;
				
				//switch for exact match or not
				if($mode=='single'){					
					$where = "='$f1_csv' ";					
				}else{
					$where = " LIKE '%".$f1_csv."%'";
				}
						
				//get users which need updating	
				$controller->db->setQuery( "SELECT u.id as id, u.username "
				. " FROM #__users AS u "		
				. " LEFT JOIN #__fua_userindex AS i "
				. " ON i.user_id=u.id "
				. " WHERE i.group_id $where "				
				. " ORDER BY username ASC "
				);	
			}
		}elseif($batchtype=='ffmulti'){			
			$f1 = $controller->get_var('f1', '', 'get');
			$this->assignRef('f1', $f1);
			$f2 = $controller->get_var('f2', '', 'get');
			$this->assignRef('f2', $f2);			
		
			if($f1==$f2){
				$app = JFactory::getApplication();				
				$app->redirect('index.php?option=com_frontenduseraccess&view=config&tab=users', JText::_('COM_FRONTENDUSERACCESS_NO_USERS_TO_RENDER'));	
			}	
			
			//make requested groups csv
			$f1_array = explode('-', $f1);
			$f1_csv = $controller->array_to_csv($f1_array);			
			
			
			//get users which need updating	
			
			/*
			$controller->db->setQuery( "SELECT u.id as id, u.username "
			. "FROM #__users AS u "		
			. "LEFT JOIN #__fua_userindex AS i "
			. "ON i.user_id=u.id "
			. "WHERE i.group_id='$f1_csv' "
			. "ORDER BY username ASC "
			);	
			*/
			if($f1!='0'){			
				//get users which need updating	
				$controller->db->setQuery( "SELECT u.id as id, u.username "
				." FROM #__users AS u "		
				." LEFT JOIN #__fua_userindex AS i "
				." ON i.user_id=u.id "
				." WHERE i.group_id='$f1_csv' "
				." ORDER BY username ASC "
				);	
			}else{
				//users are not in index table yet, so get those
				
				//get userid's from index
				$controller->db->setQuery( "SELECT user_id "
				. "FROM #__fua_userindex "		
				);
				$fua_user_ids = $controller->db->loadResultArray();
				$fua_ids_string = '';
				$first = 1;
				foreach($fua_user_ids as $fua_user_id){
					if(!$first){
						$fua_ids_string .= ',';
					}
					$fua_ids_string .= $fua_user_id;
					$first = 0;
				}
				
				if($fua_ids_string!=''){	
					//user index table not empty
					/*
					$controller->db->setQuery( "SELECT id, username "
					. "FROM #__users "				
					. "WHERE (id NOT IN ($fua_ids_string)) AND (usertype<>'Super Administrator') "
					. "ORDER BY username ASC "
					);
					*/					
					$controller->db->setQuery( "SELECT u.id as id, u.username as username "
					. " FROM #__users AS u"	
					. " LEFT JOIN #__user_usergroup_map AS m "
					. " ON m.user_id=u.id "
					. " WHERE (m.group_id<>'8') "				
					. " AND (id NOT IN ($fua_ids_string)) "
					. " ORDER BY username ASC "
					);	
				}else{
					//user index table empty
					/*
					$controller->db->setQuery( "SELECT id, username "
					. "FROM #__users "				
					. "WHERE (usertype<>'Super Administrator') "
					. "ORDER BY username ASC "
					);
					*/
					
					$controller->db->setQuery( "SELECT u.id as id, u.username as username "
					. " FROM #__users AS u"	
					. " LEFT JOIN #__user_usergroup_map AS m "
					. " ON m.user_id=u.id "
					. " WHERE m.group_id<>'8' "
					. " ORDER BY username ASC "
					);
				}
			}
			
		}else{
			die('no batch type');
		}
		
		//$users = $controller->db->loadObjectList() or die($controller->db->getErrorMsg());
		$users = $controller->db->loadObjectList();
		
		//print_r($users);
		//exit;
		$this->assignRef('users', $users);
		
		$total_to_render = count($users);		
		$this->assignRef('total_to_render', $total_to_render);		
		if($total_to_render==0){	
			$app = JFactory::getApplication();				
			$app->redirect('index.php?option=com_frontenduseraccess&view=config&tab=users', JText::_('COM_FRONTENDUSERACCESS_NO_USERS_TO_RENDER'));		
		}
	
		parent::display($tpl);
	}

}
?>
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

class frontenduseraccessViewModules extends JView{

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
		JToolBarHelper::custom( 'modules_save', 'save.png', 'save_f2.png', JText::_('JTOOLBAR_APPLY'), false, false );		
		
		//get usergroups from db
		$fua_usergroups = $controller->get_usergroups();
		$this->assignRef('fua_usergroups', $fua_usergroups);	
		
		//get module access from db
		$controller->db->setQuery("SELECT module_groupid FROM #__fua_modules_two");
		$access_modules = $controller->db->loadResultArray();
		$this->assignRef('access_modules', $access_modules);
		
		/*
		//get limits			
		global $option;
$app = JFactory::getApplication();
		$limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );		
		$limit_query = "";
		if($limit!=0){
			$limit_query = "LIMIT ".$limitstart.", ".$limit;
		}	
		
		//start where
		$where = array();
		$where[] = "client_id='0' ";
		
		//search		
		$search = $app->getUserStateFromRequest($option.'modules_search', 'modules_search', '', 'string');	
		$search = $controller->clean_search_string($search);
		if($search!=''){
			$where[] = 'title LIKE '.$controller->db->Quote( '%'.$controller->db->getEscaped( $search, true ).'%', false ).' ';
		}
		$this->assignRef('search', $search);	
		
		//end where			
		$where = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );		
		
		//get modules from database	
		$controller->db->setQuery( "SELECT SQL_CALC_FOUND_ROWS id, title "
		. "FROM #__modules "				
		. $where
		. "ORDER BY title "
		. $limit_query
		);		
		$fua_modules_object = $controller->db->loadObjectList();
		$this->assignRef('fua_modules_object', $fua_modules_object);
		
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
	
	static function getClientOptions(){
		// Build the filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '0', JText::_('JSITE'));
		$options[]	= JHtml::_('select.option', '1', JText::_('JADMINISTRATOR'));
		return $options;
	}
	
	static function getStateOptions(){
		// Build the filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option',	'1',	JText::_('JENABLED'));
		$options[]	= JHtml::_('select.option',	'0',	JText::_('JDISABLED'));
		$options[]	= JHtml::_('select.option',	'-2',	JText::_('JTRASH'));
		return $options;
	}
	
	static function getPositions($clientId){
	
		jimport('joomla.filesystem.folder');

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('DISTINCT(position)');
		$query->from('#__modules');
		$query->where('`client_id` = '.(int) $clientId);
		$query->order('position');

		$db->setQuery($query);
		$positions = $db->loadResultArray();
		$positions = (is_array($positions)) ? $positions : array();		

		// Build the list
		$options = array();
		foreach ($positions as $position) {
			if($position!=''){
				$options[]	= JHtml::_('select.option', $position, $position);
			}
		}
		return $options;
	}
	
	public static function getModules($clientId){
	
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('DISTINCT(m.module) AS value, e.name AS text');
		$query->from('#__modules AS m');
		$query->join('LEFT', '#__extensions AS e ON e.element=m.module');
		$query->where('m.`client_id` = '.(int)$clientId);

		$db->setQuery($query);
		$modules = $db->loadObjectList();
		foreach ($modules as $i=>$module) {
			$extension = $module->value;
			$path = $clientId ? JPATH_ADMINISTRATOR : JPATH_SITE;
			$source = $path . "/modules/$extension";
			$lang = JFactory::getLanguage();
				$lang->load("$extension.sys", $path, null, false, false)
			||	$lang->load("$extension.sys", $source, null, false, false)
			||	$lang->load("$extension.sys", $path, $lang->getDefault(), false, false)
			||	$lang->load("$extension.sys", $source, $lang->getDefault(), false, false);
			$modules[$i]->text = JText::_($module->text);
		}
		JArrayHelper::sortObjects($modules,'text');
		return $modules;
	}
}
?>
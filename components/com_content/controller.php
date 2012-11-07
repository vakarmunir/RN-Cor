<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Controller
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.5
 */
class ContentController extends JControllerLegacy
{
	function __construct($config = array())
	{
            $user = JFactory::getUser();
            $user_id = $user->id;
            $worker = $this->getWorkerById($user_id);
            $group = $this->getUserGroup();
            
            if($group == "loader")
            {
                if($worker->verified_status == "0")
                {
                    $url = "index.php?option=com_rednet&task=ask_password_change&view=workers";
                    $this->setRedirect(JRoute::_($url));
                    //$this->redirect();
                    
                }
            }
            
		// Article frontpage Editor pagebreak proxying:
		if (JRequest::getCmd('view') === 'article' && JRequest::getCmd('layout') === 'pagebreak') {
			$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
		}
		// Article frontpage Editor article proxying:
		elseif(JRequest::getCmd('view') === 'articles' && JRequest::getCmd('layout') === 'modal') {
			JHtml::_('stylesheet', 'system/adminlist.css', array(), true);
			$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
		}

		parent::__construct($config);
	}

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		JHtml::_('behavior.caption');

		// Set the default view name and format from the Request.
		// Note we are using a_id to avoid collisions with the router and the return page.
		// Frontend is a bit messier than the backend.
		$id		= JRequest::getInt('a_id');
		$vName	= JRequest::getCmd('view', 'categories');
		JRequest::setVar('view', $vName);

		$user = JFactory::getUser();

		if ($user->get('id') ||
			($_SERVER['REQUEST_METHOD'] == 'POST' &&
				(($vName == 'category' && JRequest::getCmd('layout') != 'blog') || $vName == 'archive' ))) {
			$cachable = false;
		}

		$safeurlparams = array('catid'=>'INT', 'id'=>'INT', 'cid'=>'ARRAY', 'year'=>'INT', 'month'=>'INT', 'limit'=>'UINT', 'limitstart'=>'UINT',
			'showall'=>'INT', 'return'=>'BASE64', 'filter'=>'STRING', 'filter_order'=>'CMD', 'filter_order_Dir'=>'CMD', 'filter-search'=>'STRING', 'print'=>'BOOLEAN', 'lang'=>'CMD');

		// Check for edit form.
		if ($vName == 'form' && !$this->checkEditId('com_content.edit.article', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			return JError::raiseError(403, JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
		}

		parent::display($cachable, $safeurlparams);

		return $this;
	}
        
        private function getUserGroup()
        {
            $user = JFactory::getUser();

            $userId = $user->id;

             $db = JFactory::getDbo();
                   $group_qry = "
                       
                    Select
                    rednet.#__users.id,
                    rednet.#__users.name,
                    rednet.#__users.username,
                    rednet.#__users.email,
                    rednet.#__users.password,
                    rednet.#__fua_userindex.group_id
                    From
                    rednet.#__users Inner Join
                    rednet.#__fua_userindex
                        On rednet.#__users.id = rednet.#__fua_userindex.user_id
                    Where
                    rednet.#__users.id = $userId
                                        ";
                   
                   $db->setQuery($group_qry);
                   $db->query();
                   $user_with_group_id = $db->loadObject();
                   $user_group_id = str_replace('"', '', $user_with_group_id->group_id);
                   
                   $group_name_qry = "SELECT * FROM #__fua_usergroups WHERE id=$user_group_id";
                   $db->setQuery($group_name_qry);
                   $db->query();
                   $user_group_obj = $db->loadObject();
                   $user_group_name = $user_group_obj->name;  
                   
                   return $user_group_name;
        }
        
        private function getWorkerById($user_id)
        {
           
            $db = JFactory::getDbo();
            
            //$query = "DELETE FROM #__users WHERE id IN($user_id)";            
            
            $query = "
            Select
  #__users.id,
  #__users.name,
  #__users.username,  
  #__workers.first_name,
  #__workers.user_id,
  #__workers.last_name,
  #__workers.s_n,
  #__workers.dob,
  #__workers.start_date,
  #__workers.dl_no,
  #__workers.class,
  #__workers.status,
  #__workers.email,
  #__workers.cell,
  #__workers.home,
  #__workers.shirt_size,
  #__workers.pant_leg,
  #__workers.waist,
  #__workers.receive_update_by,
  #__workers.desired_shift,
  #__workers.created_by,
  #__workers.created_date,
  #__workers.updated_by,
  #__workers.updated_date,
  #__workers.active_status,
  #__workers.verified_status,
  #__fua_userindex.id As fua_id,
  #__fua_userindex.user_id As user_id1,
  #__fua_userindex.group_id
From
  #__users Inner Join
  #__workers On #__users.id = #__workers.user_id
  Inner Join
  #__fua_userindex
    On #__users.id = #__fua_userindex.user_id
Where
  #__users.id = $user_id And
  #__workers.user_id = #__users.id And
  #__fua_userindex.user_id = #__users.id

            ";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $worker = $db->loadObject();
            
            return $worker;
        }
}

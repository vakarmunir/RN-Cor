<?php
/**
* @version		$Id: default_modelfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Models
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');

global $alt_libdir;
JLoader::import('joomla.application.component.modelitem', $alt_libdir);
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_rednet/tables');
/**
 * RednetModelAvailabilitycalendar
 * @author $Author$
 */
 
 
class RednetModelAvailabilitycalendar  extends JModelItem { 

	
	
	protected $context = 'com_rednet.availabilitycalendar';
       protected $_user = '';
       protected $_db = '';

        public function __construct($config = array ()) 
	{
		parent :: __construct($config);
                
                $this->_user = JFactory::getUser();
                $this->_db = JFactory::getDbo();                
	}
        
        /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	public function populateState()
	{
		$app = JFactory::getApplication();
                $user = JFactory::getUser();
                

		//$params	= $app->getParams();

		// Load the object state.
		$id	= JRequest::getInt('id');
		$this->setState('availabilitycalendar.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('availabilitycalendar.id');

		return parent::getStoreId($id);
	}
	
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem($id = null)
	{
		if ($this->_item === null) {
			
			$this->_item = false;

			if (empty($id)) {
				$id = $this->getState('availabilitycalendar.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Availabilitycalendar', 'Table');


			// Attempt to load the row.
			if ($table->load($id)) {
				
				// Check published state.
				if ($published = $this->getState('filter.published')) {
					
					if ($table->state != $published) {
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
				
			} else if ($error = $table->getError()) {
				
				$this->setError($error);
			}
		}


		return $this->_item;
	}
        
        public function add_availabilitycalendar($av_date)
        {
            $db = $this->_db;
            $user = $this->_user;            
            $query = "INSERT INTO #__user_availabilitycalendar (user_id,availability_date) VALUES ($user->id,'$av_date')";                       
            
         
            
                $db->setQuery($query);
                $db->query() or die("add_availabilitycalendar : ".mysql_error());
                return $db->insertid();
            
            
        }
        
        
        public function add_availabilitycalendar_complete($user_id,$av_date)
        {
            $db = $this->_db;
            
            $query = "INSERT INTO #__user_availabilitycalendar (user_id,availability_date) VALUES ($user_id,'$av_date')";                       
                                 
                $db->setQuery($query);
                $db->query() or die("add_availabilitycalendar_complete : ".mysql_error());
                return $db->insertid();                        
        }
        
        
        public function delete_availability_by_order_date($av_date,$user_id)
        {
            $db = $this->_db;
            
            $query = "DELETE FROM #__user_availabilitycalendar WHERE availability_date='$av_date' AND user_id=$user_id";                       
           
            
            
            $db->setQuery($query);
            $db->query() or die("add_availabilitycalendar_complete : ".mysql_error());
            //return $db->insertid();
        }
        
        public function add_user_availabilit_of_day($user_id,$day,$month)
        {
            $db = $this->_db;
            $curr_date = date('Y-m-d');            
            $query = "INSERT INTO #__user_availability_of_days (user_id,day,month,created_date) VALUES ($user_id,'$day',$month,'$curr_date')";
            
            //echo $query."<br />";
            //exit;
            
            $db->setQuery($query);
            $db->query() or die("add_user_availabilit_of_day : ".mysql_error());
            return $db->insertid();
        }
        public function delete_user_availabilit_of_day($user_id,$day,$month)
        {
            $db = $this->_db;            
            $query = "DELETE FROM #__user_availability_of_days WHERE user_id IN ($user_id) AND day IN ('$day') AND month IN ($month)";
            //echo $query;
            //exit;
            $db->setQuery($query);
            $db->query() or die("Error: ".mysql_error());
           
        }
		
        public function get_user_availabilit_of_day($user_id,$day,$month=NULL)
        {
            $db = $this->_db;
            
            $query="";
            
            if($month == NULL)
            {
                $query = "SELECT * FROM #__user_availability_of_days WHERE user_id = $user_id AND day = '$day'";                        
            }
            else
            {
                $query = "SELECT * FROM #__user_availability_of_days WHERE user_id = $user_id AND day = '$day' AND month=$month";                        
            }
            
            //echo $query.'<br />';
            //exit;
            
            $db->setQuery($query);
            $db->query() or die("Error: ".mysql_error());
            $av = $db->loadObject();
            return $av;
        }
		
        public function delete_availabilitycalendar($id)
        {
            
            $db = $this->_db;       
            $query = "DELETE FROM #__user_availabilitycalendar WHERE id=$id";                                   
            $db->setQuery($query);
            $db->query() or die("delete_availabilitycalendar ".mysql_error());
            
        }
		
        public function delete_availabilitycalendar_by_date($user_id,$availability_date)
        {            
            $db = $this->_db;       
            $query = "DELETE FROM #__user_availabilitycalendar WHERE user_id=$user_id AND availability_date='$availability_date'";
            $db->setQuery($query);
            $db->query() or die("delete_availabilitycalendar_by_date ".mysql_error());
            
        }
		
        public function get_user_availabilitycalendar($id)
        {
            
            $db = $this->_db;       
            $query = "SELECT * FROM #__user_availabilitycalendar WHERE user_id=$id";                                   
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $events = $db->loadObjectList();
            return $events;
        }
		
        public function get_user_availabilitycalendar_userId_avId($user_id,$av_date)
        {
            
            $db = $this->_db;       
            $query = "SELECT * FROM #__user_availabilitycalendar WHERE user_id=$user_id and availability_date='$av_date'";                                   
            
            //echo $query.'<br />';
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $events = $db->loadObjectList();
            return $events;
        }
		
        public function get_user_availabilitycalendar_by_date($date,$user_id)
        {
            
            $db = $this->_db;       
            $query = "SELECT * FROM #__user_availabilitycalendar WHERE user_id=$user_id AND availability_date='$date'";
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $events = $db->loadObject();
            
            //var_dump($events);
            //exit();
            return $events;
        }
		
}
?>
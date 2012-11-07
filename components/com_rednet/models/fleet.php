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
 * RednetModelFleet
 * @author $Author$
 */
 
 
class RednetModelFleet  extends JModelItem { 

	
	
	protected $context = 'com_rednet.fleet';   
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

		//$params	= $app->getParams();

		// Load the object state.
		$id	= JRequest::getInt('id');
		$this->setState('fleet.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('fleet.id');

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
				$id = $this->getState('fleet.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Fleet', 'Table');


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
        
        
        public function getFleets()
        {
            
          
            $db = JFactory::getDbo();
          
            //echo $from;
            
            $query = "SELECT * FROM #__vehicles_fleet";   
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $fleets = $db->loadObjectList();
            return $fleets;
        }
        
      
        public function getFleetById($id)
        {                      
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__vehicles_fleet WHERE id=$id";               
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $fleet = $db->loadObject();
            return $fleet;
        }
        
        public function getRentalById($id)
        {                      
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__vehicles_rental WHERE id=$id";               
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $rental = $db->loadObject();
            return $rental;
        }
        
      
        public function getRentals()
        {
            
          
            $db = JFactory::getDbo();
          
            //echo $from;
            
            $query = "SELECT * FROM #__vehicles_rental";   
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $fleets = $db->loadObjectList();
            return $fleets;
        }
        
      
        public function deleteFleet($f_id)
        {
            $db = JFactory::getDbo();            
            $query = "DELETE FROM #__vehicles_fleet WHERE id=$f_id";            
            
           
            $db->setQuery($query) or die(mysql_error());
            $db->query();            
        }
        
        public function deleteRental($f_id)
        {
            
            
            $db = JFactory::getDbo();            
            $query = "DELETE FROM #__vehicles_rental WHERE id=$f_id";            
                       
            $db->setQuery($query) or die(mysql_error());
            $db->query();            
        }
        
        
        public function save_fleet($data)
        {
          
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
            
            $name = mysql_real_escape_string($data['name']);
            $type = mysql_real_escape_string($data['type']);
            $out_of_service = (isset($data['out_of_service']) && $data['out_of_service']!=NULL)?('1'):('0');
            $from = date("Y-m-d",strtotime($data['from']));
            $to = date("Y-m-d",strtotime($data['to']));
            $created_date = date("Y-m-d");
            $updated_date = date("Y-m-d");
            $created_by = $user->id;
            $updated_by = $user->name;
            
            
            //echo $from;
            
            $query = "INSERT INTO #__vehicles_fleet 
            (           
            name,
            type,
            out_of_service,
            from_date,
            to_date,
            created_date,
            updated_date,
            created_by,
            updated_by
            )
            VALUES (           
            '$name',
            '$type',
            '$out_of_service',
            '$from',
            '$to',
            '$created_date',
            '$updated_date',
            '$created_by',
            '$updated_by'
            )
            ";   
            
           //echo $query;
           //exit();
           
            $db->quote($query);
            $db->setQuery($query);
            $db->query() or die(mysql_error());               
        }
        public function save_rental($data)
        {
            
          
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
            
            $name = mysql_real_escape_string($data['name']);
            $type = mysql_real_escape_string($data['type']);
            $out_of_service = (isset($data['out_of_service']) && $data['out_of_service']!=NULL)?('1'):('0');
            $from = date("Y-m-d",strtotime($data['from']));
            $to = date("Y-m-d",strtotime($data['to']));
            $created_date = date("Y-m-d");
            $updated_date = date("Y-m-d");
            $created_by = $user->id;
            $updated_by = $user->name;
            
            
            //echo $from;
            
            $query = "INSERT INTO #__vehicles_rental 
            (           
            name,
            type,
            out_of_service,
            from_date,
            to_date,
            created_date,
            updated_date,
            created_by,
            updated_by
            )
            VALUES (           
            '$name',
            '$type',
            '$out_of_service',
            '$from',
            '$to',
            '$created_date',
            '$updated_date',
            '$created_by',
            '$updated_by'
            )
            ";   
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());               
        }
        
        public function udpateFleet($data)
        {
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
            
            $id = $data['id'];
            $name = mysql_real_escape_string($data['name']);
            $type = mysql_real_escape_string($data['type']);
            $out_of_service = (isset($data['out_of_service']) && $data['out_of_service']!=NULL)?('1'):('0');
            $from = date("Y-m-d",strtotime($data['from']));
            $to = date("Y-m-d",strtotime($data['to']));
            $updated_date = date("Y-m-d");            
            $updated_by = $user->id;                                    
            
            $query = "UPDATE #__vehicles_fleet 
            SET
                    name='$name',
                    type='$type',
                    out_of_service='$out_of_service', 
                    from_date='$from',         
                    to_date='$to',                                          
                    updated_date='$updated_date',                                            
                    updated_by='$updated_by'  
           WHERE
                    id = $id
            ";   
                     
            
            $db->setQuery($query);
            $db->query() or die(mysql_error()." ======= "); 
        }
        public function udpateRental($data)
        {
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
            
            $id = $data['id'];
            $name = mysql_real_escape_string($data['name']);
            $type = mysql_real_escape_string($data['type']);
            $out_of_service = (isset($data['out_of_service']) && $data['out_of_service']!=NULL)?('1'):('0');
            $from = date("Y-m-d",strtotime($data['from']));
            $to = date("Y-m-d",strtotime($data['to']));
            $updated_date = date("Y-m-d");            
            $updated_by = $user->id;                                    
            
            $query = "UPDATE #__vehicles_rental 
            SET
                    name='$name',
                    type='$type',
                    out_of_service='$out_of_service', 
                    from_date='$from',         
                    to_date='$to',                                          
                    updated_date='$updated_date',                                            
                    updated_by='$updated_by'  
           WHERE
                    id = $id
            ";   
                     
            
            $db->setQuery($query);
            $db->query() or die(mysql_error()." ======= "); 
        }
		
}
?>
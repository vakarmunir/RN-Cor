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
 * RednetModelResourcesmap
 * @author $Author$
 */
 
 
class RednetModelResourcesmap  extends JModelItem { 

	
	
	protected $context = 'com_rednet.resourcesmap';   
        public $_id;
        public $_order_id;
        public $_user_id;
        public $_truck;
        public $_status;
        public $_created_date;
        public $_worker_role;
        
        protected $_db;
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
		$this->setState('resourcesmap.id', $id);

                $db  = JFactory::getDbo();
                
                $this->_db = $db;
                                
		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('resourcesmap.id');

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
				$id = $this->getState('resourcesmap.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Resourcesmap', 'Table');


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
	
        
        public function add_resourcesmap()
        {
            $db = $this->_db;
            $date = date('Y-m-d');
            $query = "insert INTO #__resourcesmap(
                        order_id,
                        user_id,
                        truck,
                        status,
                        created_date,
                        worker_role
                        ) VALUES

                        (
                        '$this->_order_id',
                        '$this->_user_id',
                        '$this->_truck',
                        '$this->_status',
                        '$date',
                        '$this->_worker_role'
                        )";

            
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            return $db->insertid();
        }
        public function get_resourcesmap_by_order_id($order_id)
        {
            $db = $this->_db;
            
            $query = "SELECT * FROM #__resourcesmap WHERE order_id = $order_id";            
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $rs = $db->loadObjectList();
            
            return $rs;
        }
        
        
        public function update_resource_status($rs_id,$update_value)
        {
            $db = $this->_db;
            
            $query = "UPDATE #__resourcesmap 
            SET
            status = '$update_value'
            WHERE id = $rs_id";                        
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
        }
        
        
        public function set_field_by_value($rcd_id,$field,$value)
        {
            $db = $this->_db;            
            $query = "UPDATE #__resourcesmap 
            SET
            $field = '$value'
            WHERE id = $rcd_id";                        
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
        }
        
        public function get_resourcemap_by_id($id)
        {
            
            $db = $this->_db;            
            $query = "SELECT * FROM #__resourcesmap WHERE id = $id";                                    
            $db->setQuery($query);
            $db->query() or die(mysql_error());                        
            return $db->loadObject();
        }
        
        
        
}
?>
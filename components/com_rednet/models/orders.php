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
 * RednetModelOrders
 * @author $Author$
 */
 
 
class RednetModelOrders  extends JModelItem { 

	
	
	protected $context = 'com_rednet.orders';   
        protected $_db;

        public $_order_id;
        public $_order_no;
        public $_name;
        public $_date_order;
        public $_type_order;
        public $_type_if_other;
        public $_no_of_men;
        public $_no_of_trucks;
        public $_truck_requirments;
        public $_out_of_town;
        public $_departure_time;
        public $_deposite;
        public $_is_addon;
        public $_instruction_file;
        public $_created_by;
        public $_created_date;
        public $_parent_order;
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
                $this->_db = JFactory::getDbo();
                
		//$params	= $app->getParams();

		// Load the object state.
		$id	= JRequest::getInt('id');
		$this->setState('orders.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('orders.id');

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
				$id = $this->getState('orders.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Orders', 'Table');


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
        
        public function add_order()
        {
            $db = $this->_db;
            $query = "INSERT INTO #__orders (            
            order_no,
            name,
            date_order,
            type_order,
            type_if_other,
            no_of_men,
            no_of_trucks,
            truck_requirments,
            out_of_town,
            departure_time,
            deposite,
            is_addon,
            addon_time,
            instruction_file,
            created_by,
            created_date,
            parent_order
            )
            VALUES(
            
            '$this->_order_no',
            '$this->_name',
            '$this->_date_order',
            '$this->_type_order',
            '$this->_type_if_other',
            '$this->_no_of_men',
            '$this->_no_of_trucks',
            '$this->_truck_requirments',
            '$this->_out_of_town',
            '$this->_departure_time',
            '$this->_deposite',
            '$this->_is_addon',
            '$this->_addon_time',
            '$this->_instruction_file',
            '$this->_created_by',
            '$this->_created_date',
            '$this->_parent_order'
            )
            ";                        
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            return $db->insertid();
        }
        
        public function update_order()
        {
            $db = $this->_db;
           $update_date = date('Y-m-d');
            $query = "UPDATE #__orders SET            
                order_no='$this->_order_no',
                name='$this->_name',
                date_order='$this->_date_order',
                type_order='$this->_type_order',
                type_if_other='$this->_type_if_other',
                no_of_men='$this->_no_of_men',
                no_of_trucks='$this->_no_of_trucks',
                truck_requirments='$this->_truck_requirments',
                out_of_town='$this->_out_of_town',
                departure_time='$this->_departure_time',
                deposite='$this->_deposite',
                is_addon='$this->_is_addon',
                addon_time='$this->_addon_time',
                instruction_file='$this->_instruction_file',            
                updated_date='$update_date'            
                   WHERE id=$this->_order_id;
            ";                        
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            
        }
        
        public function delete_order()
        {
            $db = JFactory::getDbo();
            $query = "DELETE FROM #__orders WHERE id = $this->_order_id";
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
        }
        
        public function getOrderById($id)
        {
            $db = $this->_db;
            
            $query = "SELECT * FROM #__orders WHERE id=$id";
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());                        
            return $db->loadObject();
        }
		
        public function getAdOnOrderById($id)
        {
            $db = $this->_db;
            
            $query = "SELECT * FROM #__orders WHERE parent_order=$id";
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());                        
            return $db->loadObjectList();
        }
		
}
?>
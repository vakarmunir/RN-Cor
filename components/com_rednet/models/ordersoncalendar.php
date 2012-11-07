<?php

global $alt_libdir;
JLoader::import('joomla.application.component.modellist', $alt_libdir);
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_rednet/tables');

class RednetModelOrdersoncalendar extends JModelList
{
        
        
	public function __construct($config = array())
	{		
	
		parent::__construct($config);
                
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
            
			parent::populateState();
			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$this->setState('orderslist.id', $id);			                        
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('orderslist.id');

		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
        
        
	protected function getListQuery()
	{
            
		//check the version
		$jv = new JVersion();
		if ($jv->RELEASE < 1.6) {
			$query = & $this->query;	
		} else {
				$db		= $this->getDbo();
				$query	= $db->getQuery(true);			
		}
	
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query->select('a.*');
		$query->from('#__orders as a ORDER BY id DESC');                                                          
                
                 
		return $query;
                
	}
        
	public function getAllOrders()
	{            
		//check the version
		$jv = new JVersion();
		if ($jv->RELEASE < 1.6) {
			$query = & $this->query;	
		} else {
				$db		= $this->getDbo();
				$query	= $db->getQuery(true);			
		}
                
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query->select('a.*');
		$query->from('#__orders as a ORDER BY id DESC');                                                                          
                $db->setQuery($query);
                $db->query();                                
                return $db->loadObjectList();                				
	}	
        
        
	public function getOrdersByWorkers($id)
	{            
		//check the version
		$jv = new JVersion();
		if ($jv->RELEASE < 1.6) {
			$query = & $this->query;	
		} else {
				$db		= $this->getDbo();
				$query	= $db->getQuery(true);			
		}
                
		$catid = (int) $this->getState('authorlist.id', 1);		
	
                
                $query = "                
SELECT                
  #__resourcesmap.order_id,
  #__resourcesmap.user_id,
  #__resourcesmap.truck,
  #__resourcesmap.status,
  #__resourcesmap.created_date,
  #__orders.id As orderId,
  #__orders.order_no,
  #__orders.name,
  #__orders.date_order,
  #__orders.type_order,
  #__orders.type_if_other,
  #__orders.no_of_men,
  #__orders.no_of_trucks,
  #__orders.truck_requirments,
  #__orders.out_of_town,
  #__orders.departure_time,
  #__orders.deposite,
  #__orders.is_addon,
  #__orders.addon_time,
  #__orders.instruction_file,
  #__orders.created_by,
  #__orders.created_date As created_date1,
  #__orders.updated_date,
  #__orders.parent_order
From
  #__resourcesmap Inner Join
  #__orders On #__orders.id = #__resourcesmap.order_id
Where
  #__resourcesmap.user_id = $id  
                ";
                $db->setQuery($query);
                $db->query();                
                
                
                return $db->loadObjectList();                				
	}	
        
        
}
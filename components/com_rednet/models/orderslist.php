<?php

global $alt_libdir;
JLoader::import('joomla.application.component.modellist', $alt_libdir);
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_rednet/tables');

class RednetModelOrderslist extends JModelList
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
                        $this->setState('list.limit', 0);                       
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

                
                $order_no = JRequest::getVar('order_no');
                $name = JRequest::getVar('name');
                $date_order = JRequest::getVar('date_order');
                
                $order_by = 'ORDER BY id DESC';
                                
                $query_string = '#__orders as a';                                
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query->select('a.*');                
		$query->from($query_string);                                                          
               
                if(isset($order_no) && $order_no!='')
                {                   
                    $query->where('order_no='."'$order_no'");                    
                }

                if(isset($name) && $name!='')
                {                   
                    $query->where('name LIKE '."'%$name%'");                    
                }

                if( (isset($date_order) && $date_order!='') && ( date('Y-m-d',  strtotime($date_order))!='1970-01-01') )
                {  
                    $q_date = date('Y-m-d',  strtotime($date_order));
                    $query->where('date_order='."'$q_date'");                    
                }
                //echo $query->dump();                                
		return $query;
	}	
}
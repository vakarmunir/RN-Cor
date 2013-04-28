<?php
/**
* @version		$Id: default_modelfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Models
* @copyright	Copyright (C) 2013, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');

global $alt_libdir;
JLoader::import('joomla.application.component.modelitem', $alt_libdir);
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_rednet/tables');
/**
 * RednetModelReportmaster
 * @author $Author$
 */
 
 
class RednetModelReportmaster  extends JModelItem { 

	
	
	protected $context = 'com_rednet.reportmaster';   
        public $id;
        public $order_id;
        public $departure_time;
        public $return_time;
        public $total_work_hours_billed;
        public $paid_hours;
        public $total_travel;
        public $travel_leak;
        public $dpt_time;
        public $total_invoice_amount;
        public $credit_card;
        public $debit_card;
        public $cheques;
        public $cash;
        public $outstanding;
        public $hst;
        public $damage;
        public $tip_on_invoice;
        public $net;
        public $comments_job;
        public $flag_job;
        public $is_paid;
        public $is_approved;
        
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
		$this->setState('reportmaster.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('reportmaster.id');

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
				$id = $this->getState('reportmaster.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Reportmaster', 'Table');
                        

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
        
        public function getReportmasterByOrderId($order_id)
        {            
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__reportmaster WHERE order_id = $order_id";
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
            return $db->loadObject();
        }
        
        public function deleteReportByOrderId($order_id)
        {
            $db = JFactory::getDbo();            
            $query = "DELETE FROM #__reportmaster WHERE order_id IN ($order_id)";
            //echo $query;
            //exit;
            $db->setQuery($query);
            $db->query() or die("Error: ".mysql_error());
           
        }
      

        public function deleteReportClientsByReportId($report_id)
        {
            $db = JFactory::getDbo();            
            $query = "DELETE FROM #__report_clients WHERE report_id IN ($report_id)";
            //echo $query;
            //exit;
            $db->setQuery($query);
            $db->query() or die("Error: ".mysql_error());
           
        }
        public function deleteReportDetailByReportId($report_id)
        {
            $db = JFactory::getDbo();            
            $query = "DELETE FROM #__reportdetail WHERE report_id IN ($report_id)";
            //echo $query;
            //exit;
            $db->setQuery($query);
            $db->query() or die("Error: ".mysql_error());
           
        }

        public function delete_report_how_paid($report_id)
        {
            $db = JFactory::getDbo();            
            $query = "DELETE FROM #__report_how_paid WHERE report_id IN ($report_id)";            
            $db->setQuery($query);
            $db->query() or die("Error: ".mysql_error());
           
        }


        public function getReportClientsByOrderReportId($report_id)
        {            
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__report_clients WHERE report_id = $report_id ORDER BY order_id ASC";
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
            return $db->loadObjectList();
        }
        
        public function getReportFilterd()
        {            
            $db = JFactory::getDbo();
            /*
            $query = "
            Select
  #__orders.id,
  #__orders.order_no,
  #__reportmaster.id As report_id,
  #__reportmaster.order_id,
  #__reportmaster.paid_hours,
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
  #__orders.created_date,
  #__orders.updated_date,
  #__orders.parent_order,
  #__orders.comments,
  #__reportmaster.departure_time As departure_time_report,
  #__reportmaster.return_time,
  #__reportmaster.total_work_hours_billed,
  #__reportmaster.total_travel,
  #__reportmaster.travel_leak,
  #__reportmaster.dpt_time,
  #__reportmaster.total_invoice_amount,
  #__reportmaster.credit_card,
  #__reportmaster.debit_card,
  #__reportmaster.cheques,
  #__reportmaster.cash,
  #__reportmaster.outstanding,
  #__reportmaster.hst,
  #__reportmaster.damage,
  #__reportmaster.tip_on_invoice,
  #__reportmaster.net,
  #__reportmaster.comments_job,
  #__reportmaster.flag_job,
  #__reportmaster.is_paid,
  #__reportmaster.is_approved,
  #__reportmaster.is_discount
From
  #__orders Inner Join
  #__reportmaster
    On #__orders.id = #__reportmaster.order_id
Where 1 And #__reportmaster.order_id = #__orders.id ";
      */
            
            $query="
             Select
  #__orders.id,
  #__orders.order_no,
  #__orders.name,
  #__orders.date_order,
  #__report_clients.id As client_tble_id,
  #__report_clients.report_id,
  #__report_clients.order_id,
  #__reportmaster.id As report_id_master,
  #__reportmaster.order_id As order_id1,
  #__reportmaster.paid_hours,
  #__report_clients.start,
  #__report_clients.`end`,
  #__report_clients.travel,
  #__reportmaster.departure_time,
  #__reportmaster.return_time,
  #__reportmaster.total_work_hours_billed,
  #__reportmaster.total_travel,
  #__reportmaster.travel_leak,
  #__reportmaster.dpt_time,
  #__reportmaster.total_invoice_amount,
  #__reportmaster.credit_card,
  #__reportmaster.debit_card,
  #__reportmaster.cheques,
  #__reportmaster.cash,
  #__reportmaster.outstanding,
  #__reportmaster.hst,
  #__reportmaster.tip_on_invoice,
  #__reportmaster.damage,
  #__reportmaster.net,
  #__reportmaster.comments_job,
  #__reportmaster.flag_job,
  #__reportmaster.is_paid,
  #__reportmaster.is_approved,
  #__reportmaster.is_discount,
  #__orders.type_order,
  #__orders.type_if_other,
  #__orders.no_of_men,
  #__orders.no_of_trucks,
  #__orders.truck_requirments,
  #__orders.out_of_town,
  #__orders.departure_time As departure_time1,
  #__orders.deposite,
  #__orders.is_addon,
  #__orders.addon_time,
  #__orders.instruction_file,
  #__orders.created_by,
  #__orders.created_date,
  #__orders.updated_date,
  #__orders.parent_order,
  #__orders.comments
From
  #__orders Right Join
  #__report_clients
    On #__orders.id = #__report_clients.order_id Right Join
  #__reportmaster On #__report_clients.report_id =
    #__reportmaster.id WHERE 1 
             ";
            
            $un_approve = JRequest::getVar('un_approve');
            $date_from = JRequest::getVar('date_from');
            $date_to = JRequest::getVar('date_to');
            $order_no = JRequest::getVar('order_no');
            
            //var_dump($un_approve);
            
            //exit();
            
            if(isset($un_approve) && $un_approve=='1')
            {
                $query.=" AND #__reportmaster.is_approved = '0' OR #__reportmaster.is_approved = ''";
                
              //  exit;
            }
            
            if(isset($order_no) && strlen($order_no) > 0)
            {
                //$query.=" AND #__orders.order_no = '$order_no'";
                $target_order_ids = array();
                $order = $this->get_order_by_order_no($order_no);
                if($order->is_addon == 0)
                {
                    // parent..
                    $query.=" AND #__orders.order_no = '$order_no'";
                }
                if($order->is_addon == 1)
                {
                    // adons...
                    array_push($target_order_ids, $order->parent_order);
                    $parent_order = $order->parent_order;
                    $adon_orders = $this->get_orders_by_parent_order($parent_order);
                    //var_dump($adon_orders);
                    foreach($adon_orders as $adon)
                    {
                        array_push($target_order_ids, $adon->id);
                    }
                    
                    //var_dump($target_order_ids);
                    $query.=" AND #__orders.id IN (";
                    $ids_cntr = 1;
                    $comma = "";
                    foreach($target_order_ids as $id)
                    {
                        if($ids_cntr < count($target_order_ids))
                        {
                            $comma = ",";
                        }else{
                            $comma = "";
                        }
                        
                        $query.="$id $comma";
                        
                        $ids_cntr ++;
                    }
                    
                    $query.=")";
                    //echo $query;
                    //exit;
                }
            }
            
            
            if((strlen($date_from)>0 && $date_from!='1970-01-01') && (strlen($date_to)>0 && $date_to!='1970-01-01'))
            {
                $query.=" AND (#__orders.date_order BETWEEN '".date("Y-m-d",strtotime($date_from))."' AND '".date("Y-m-d",strtotime($date_to))."')";             
            }
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
            return $db->loadObjectList();
        }
        
        public function get_order_by_order_no($order_no)
        {
            $db = JFactory::getDbo();            
            $query = "SELECT * FROM #__orders WHERE order_no='$order_no'";            
            $db->setQuery($query);
            $db->query() or die(mysql_error());                        
            $rcd = $db->loadObject();            
            return $rcd;            
        }
        
        public function get_orders_by_parent_order($parent_order)
        {
            $db = JFactory::getDbo();            
            $query = "SELECT * FROM #__orders WHERE parent_order ='$parent_order'";            
            $db->setQuery($query);
            $db->query() or die(mysql_error());                        
            $rcd = $db->loadObjectList();            
            return $rcd;            
        }
        
        public function getReportDetailsByOrderReportId($report_id)
        {            
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__reportdetail WHERE report_id = $report_id";
            
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
            return $db->loadObjectList();
        }
        
        public function getReportHowPaid($report_id)
        {            
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__report_how_paid WHERE report_id = $report_id";
            
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
            return $db->loadObjectList();
        }
        
        public function insertReportClient($report_id,$order_id ,$start,$end,$travel)
        {            
            $db = JFactory::getDbo();
            $query = "INSERT INTO #__report_clients (report_id,order_id ,start,end,travel) VALUES ($report_id,$order_id,'$start','$end','$travel')";
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
        }
        
        public function insert_report_how_paid($oid,$report_id,$total_invoice_amount,$credit_card,$debit_card,$cheques,$cash,$outstanding,$hst,$damage,$tip_on_invoice,$net)
        {            
            $db = JFactory::getDbo();
            $query = "INSERT INTO #__report_how_paid (
                report_id,
                order_id,
                total_invoice_amount,
                credit_card,
                debit_card,
                cheques,
                cash,
                outstanding,
                hst,damage,tip_on_invoice,net
                ) VALUES (
                    $report_id,$oid,'$total_invoice_amount','$credit_card','$debit_card','$cheques','$cash','$outstanding','$hst','$damage','$tip_on_invoice','$net'
                )";
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
        }
        
        public function updateReportByField($feild,$value,$report_id)
        {            
            $db = JFactory::getDbo();
            $query = "UPDATE #__reportmaster SET $feild='$value' WHERE id=$report_id";
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
        }
        
        public function insertReportDetail($report_id,$user_id,$role,$hours,$invoice,$tip_allow,$tip_amount,$flag,$bonus,$comments)
        {            
            $db = JFactory::getDbo();
            $query = "INSERT INTO #__reportdetail (                
                report_id,
                user_id ,
                role ,
                hours  ,
                invoice ,
                tip_allow ,
                tip_amount ,
                flag ,
                bonus,
                comments
            ) VALUES (                
                $report_id,
                $user_id,
                '$role',
                '$hours',
                '$invoice',
                '$tip_allow',
                '$tip_amount',
                '$flag',
                '$bonus',
                '$comments'
                    
            )";
            $db->setQuery($query);
            $db->query() or die(mysql_error().' ============= ');            
        }
        
        public function insert()
        {
            $db = JFactory::getDbo();
            $query = "INSERT INTO #__reportmaster (
                
                order_id,
                departure_time,
                return_time,
                total_work_hours_billed,
                paid_hours,
                total_travel,
                travel_leak,
                dpt_time,
                total_invoice_amount,
                credit_card,
                debit_card,
                cheques,
                cash,
                outstanding,
                hst,
                damage,
                tip_on_invoice,
                net,
                comments_job,
                flag_job
            ) VALUES (
                
                $this->order_id,
                '$this->departure_time',
                '$this->return_time',
                '$this->total_work_hours_billed',
                '$this->paid_hours',
                '$this->total_travel',
                '$this->travel_leak',
                '$this->dpt_time',
                '$this->total_invoice_amount',
                '$this->credit_card',
                '$this->debit_card',
                '$this->cheques',
                '$this->cash',
                '$this->outstanding',
                '$this->hst',
                '$this->damage',
                '$this->tip_on_invoice',
                '$this->net',
                '$this->comments_job',
                '$this->flag_job'
            )";
            $db->setQuery($query);
            $db->query() or die(mysql_error().' ********** ');            
            return $db->insertid();
        }
		
}
?>
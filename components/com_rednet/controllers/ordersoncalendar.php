<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Controllers
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/


// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * RednetOrders Controller
 *
 * @package    Rednet
 * @subpackage Controllers
 */


class RednetControllerOrdersoncalendar extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'ordersoncalendar'; 
	protected $_user;
	protected $_db;        
        
        public function __construct($config = array ()) 
	{
                $this->_user = JFactory::getUser();                
                
		parent :: __construct($config);
                
		JRequest :: setVar('view', $this->_viewname);                                
                
                $data = array();                
                $worker_model = $this->getModel('workers');                
                $ordersoncalendar_model = $this->getModel('ordersoncalendar');                
                $workers = $worker_model->getAllActiveWorkers();                                                
                
                $worker_id_non_admin = NULL;
                $authentication_group = $worker_model->getWorkerAuthenticationGroup($this->_user->id);
                if($authentication_group != 'admin')
                {
                    $worker_id_non_admin = $this->_user->id;
                }                
                $data['worker_id_non_admin'] = $worker_id_non_admin;                                                                                
                
                
                
                
                $data['workers'] = $workers;                                                
                JRequest::setVar('data',$data);                
                
                
                
	}
	
        public function day_status()
        {            
                $data = array();
                $date = JRequest::getVar('date');
                $data['date'] = $date;
                
                $ordersoncalendar_model = $this->getModel('ordersoncalendar');
                $day_status_obj = $ordersoncalendar_model->getDayByDate($date);
                
                $statuses = array();
                
                if($day_status_obj == NULL)
                {
                    $statuses['open'] = true;
                    $statuses['closed'] = false;
                    $statuses['hold'] = false;
                }
                                
                if(isset($day_status_obj) && $day_status_obj!=NULL)
                {
                    $status_value = $day_status_obj->status;
                    
                    switch ($status_value)
                    {
                        case 'open':
                            $statuses['open'] = true;
                            $statuses['closed'] = false;
                            $statuses['hold'] = false;
                            break;
                        
                        case 'closed':
                            $statuses['open'] = false;
                            $statuses['closed'] = true;
                            $statuses['hold'] = false;
                            break;
                        
                        case 'hold':
                            $statuses['open'] = false;
                            $statuses['closed'] = false;
                            $statuses['hold'] = true;                            
                            break;
                        
                            
                    }
                }
                                
                $data['statuses'] = $statuses;
                
                $layout = "default_day_status";
                JRequest::setVar('data',$data);
                JRequest::setVar('layout',$layout);
                
                parent::display();
        }
             
        
        public function day_status_save()
        {
            // =========== setting days status to Closed,Hold ============                
                $ordersoncalendar_model = $this->getModel('ordersoncalendar');
                
                $date = JRequest::getVar('date');
                $day_status = JRequest::getVar('day_status');
                
                $ordersoncalendar_model->date_of_days_status = $date;
                $ordersoncalendar_model->status_of_days_status = $day_status;
                                
                
                if(isset($date) && $date!=NULL)
                {                                        
                    $day_status_obj = $ordersoncalendar_model->getDayByDate($date);
                    if(isset($day_status_obj) && $day_status_obj!=NULL)
                    {
                        $ordersoncalendar_model->id_of_days_status = $day_status_obj->id;
                        $ordersoncalendar_model->updateDaysStatus();
                        echo "update me.";
                    }else{
                        $ordersoncalendar_model->insertDaysStatus();
                        echo "insert me.";
                    }
                    
                }
                
                $url = JURI::current();
                $msg = "Day status has been set.";
                $this->setRedirect($url, $msg);
                $this->redirect();
        }
        
        public function load_orders()
        {                
                $model = $this->getModel('ordersoncalendar');                                                
                $worker_id = JRequest::getVar('worker_id');
                
                $all_orders = array();
                
                if(isset($worker_id) && $worker_id!=NULL)
                {   
                    
                    $all_orders = $model->getParentOrdersByWorkers($worker_id); 
                    
                }else{
                    $all_orders = $model->getAllParentOrders(); 
                }

                $main_array = array();
                $color_class = '';
                
                
               
                
                foreach($all_orders as $av)
                {
                   
                   $order_id = NULL; 
                   $resourcesmap_model = $this->getModel('resourcesmap');
                   
                 
                   if(isset($worker_id) && $worker_id!=NULL)
                   {
                       $order_id = $av->order_id;
                   }else{
                       $order_id = $av->id;
                   }
                   
                   $order_in_resource_map = $resourcesmap_model->get_resourcesmap_by_order_id($order_id);
                   
                   //if($order_id == 58)
                   //{
                   //var_dump($order_id);
                   //echo "<br />============================================<br />";
                   //}
                   if(count($order_in_resource_map) == 0)
                   {
                       $color_class = 'green_class';
                   }
                   
                   
                   
                   foreach($order_in_resource_map as $rsm)
                   {
                       if(($rsm->user_id != '0') && ( ( ($rsm->status == 'A') || ($rsm->status == 'D') ) && ($rsm->status != 'C') && ($rsm->status != 'CD')))
                       {
                           $color_class = 'red_class';
                       }
                   }
                   
                   
                   foreach($order_in_resource_map as $rsm)
                   {
                       if(($rsm->user_id != '0') && ( ( ($rsm->status != 'A') && ($rsm->status != 'D') ) &&  (($rsm->status == 'C') || ($rsm->status == 'CD'))  ))
                       {
                           $color_class = 'black_class';
                       }
                   }
                   
                   // ====== preparing add-on order of orignal order here ==============
                     $array_of_adons = array();
                               $addon_orders = $model->getAdonOrders($order_id);      
                               foreach($addon_orders as $addon_order)
                               {
                                   $arr_addon = array(
                                                        'id'=>$addon_order->id,
                                                        'title'=>"$addon_order->name",                            
                                                        'start'=>$addon_order->date_order,
                                                        'no_of_men'=>$addon_order->no_of_men,
                                                        'no_of_trucks'=>$addon_order->no_of_trucks,
                                                     );
                                   array_push($array_of_adons,$arr_addon);
                               }
                   // ===== preparing orginal order here along with its add-on order =============
                    $arr = array(
                        
                        'id'=>$order_id,
                        'title'=>"$av->name",                            
                        'start'=>$av->date_order,
                        'no_of_men'=>$av->no_of_men,
                        'no_of_trucks'=>$av->no_of_trucks,
                        'color_class'=>$color_class,
                        'flag'=>'order',
                        'array_of_adons' => $array_of_adons
                    );
                    array_push($main_array, $arr);
                    
                    //getAdonOrders($p_o)
                }
                
                //echo "<br />****************************************************************<br />";
                
                
                
                   if(isset($worker_id) && $worker_id!=NULL)
                   {
                       $user_id_for_availability = $worker_id;
                   }else{
                       $user_id_for_availability = $this->_user->id;
                   }
                
                   
                   echo json_encode( array_merge($main_array, $this->get_availabilities_of_user($user_id_for_availability)) ) ;   
                //echo json_encode( $main_array );   
                exit();

        }
        
        
        public function get_availabilities_of_user($userId)
        {
                
                $model = $this->getModel('availabilitycalendar');
                $availability = $model->get_user_availabilitycalendar($userId); 
                $main_array = array();                
                
                foreach($availability as $av)
                {
                    $arr = array('id'=>$av->id,'title'=>'Available','start'=>$av->availability_date,'flag'=>'availability');
                    array_push($main_array, $arr);
                }
                         
                return $main_array;
        }
}// class
?>
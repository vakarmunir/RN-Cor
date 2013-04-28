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
	protected $_userId;
	protected $_db;        
        protected $_session;
        public function __construct($config = array ()) 
	{
                $this->_user = JFactory::getUser();                
                $this->_userId = $this->_user->id;
                
		parent :: __construct($config);
                
		JRequest :: setVar('view', $this->_viewname);                                
                
                
                $worker_selected = JRequest::getVar('worker_id');
                $session =& JFactory::getSession();
                                                
                if(isset($worker_selected) && $worker_selected != NULL)
                {
                    $session->set("non_admin_mode","true");
                    $this->_userId = $worker_selected;
                    $session->set("non_admin_id",$worker_selected);
                }else{
                    
                    if($session->has("non_admin_mode"))
                    {
                        $session->clear("non_admin_mode");
                        $session->clear("non_admin_id");
                        $this->_userId = $this->_user->id;
                    }
                }
                
                $this->_session = $session;
                
                
                
                $data = array();                
                $worker_model = $this->getModel('workers');                
                $ordersoncalendar_model = $this->getModel('ordersoncalendar');                
                $workers = $worker_model->getAllActiveWorkers();                                                
                
                $worker_id_non_admin = NULL;
                $authentication_group = $worker_model->getWorkerAuthenticationGroup($this->_userId);
                if($authentication_group != 'admin')
                {
                    $worker_id_non_admin = $this->_userId;
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
             
        
        public function day_status_json()
        {            
                $data = array();
                $date = JRequest::getVar('date');
                $data['date'] = $date;
                
                $ordersoncalendar_model = $this->getModel('ordersoncalendar');
                $day_status_obj = $ordersoncalendar_model->getDayByDate($date);
                
                $statuses = array();
                $status_text = "";
                
                if($day_status_obj == NULL)
                {
                    $status_text = "OPEN";
                }else{
                    $status_text = $day_status_obj->status;
                }

                echo $status_text.','.$date;                
                exit;
        }
             
        public function assocArrayToXML($root_element_name,$ar)
            {
                $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><{$root_element_name}></{$root_element_name}>");


                $f = create_function('$f,$c,$a','
                        foreach($a as $k=>$v) {
                            if(is_array($v)) {
                                $ch=$c->addChild($k);
                                $f($f,$ch,$v);
                            } else {
                                $c->addChild($k,$v);
                            }
                        }');
                $f($f,$xml,$ar);
                return $xml->asXML();
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
                
                $worker_model = $this->getModel('workers');                
                $authentication_group = $worker_model->getWorkerAuthenticationGroup($this->_userId);
                                
                
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
                   $order_no_of_men = NULL; 
                   $order_no_of_trucks = NULL; 
                   
                   $resourcesmap_model = $this->getModel('resourcesmap');
                   
                 
                   if(isset($worker_id) && $worker_id!=NULL)
                   {
                       $order_id = $av->order_id;
                       $order_no_of_men = $av->no_of_men;
                       $order_no_of_trucks = $av->no_of_trucks;
                   }else{
                       $order_id = $av->id;
                       $order_no_of_men = $av->no_of_men;
                       $order_no_of_trucks = $av->no_of_trucks;
                   }
                   
                   $order_in_resource_map_all = $resourcesmap_model->get_resourcesmap_by_order_id($order_id);
                   $order_in_resource_map_flt_array = array();                   
                   $order_in_resource_map_trucks_array = array();                   
                   
                   foreach ($order_in_resource_map_all as $rsm_flt)
                   {
                       if($rsm_flt->user_id > 0)
                       {
                           array_push($order_in_resource_map_flt_array, $rsm_flt);
                       }
                   }
                   
                   
                   foreach ($order_in_resource_map_all as $rsm_flt)
                   {
                       if($rsm_flt->user_id == 0){
                           array_push($order_in_resource_map_trucks_array, $rsm_flt);
                       }
                   }
                   
                   
                   
                   $order_in_resource_map = $order_in_resource_map_flt_array;
                   //if($order_id == 58)
                   //{
                   //var_dump($order_id);
                   //echo "<br />============================================<br />";
                   //}
                   if(count($order_in_resource_map) == 0)
                   {
                       if($authentication_group == 'admin')
                       {
                            $color_class = 'green_class';
                       }
                   }
                   
                   
                   if(count($order_in_resource_map) > 0)
                   {
                       if($authentication_group == 'admin')
                       {
                            $color_class = 'red_class';
                       }
                   }
                   
                   
                   
                   foreach($order_in_resource_map as $rsm)
                   {
                       if(($rsm->user_id != '0') && ( ( ($rsm->status == 'A') || ($rsm->status == 'D') ) && ($rsm->status != 'C') && ($rsm->status != 'CD')))
                       {
                           if($authentication_group == 'admin')
                           {
                               //$color_class = 'red_class';
                           }
                           
                       }
                   }
                   
                   $rs_total = count($order_in_resource_map);                   
                   $rs_counter_blk = 1;
                   $rs_counter_red = 1;
                   $rs_counter_grn = 1;
                   
                   
                   foreach($order_in_resource_map as $rsm)
                   {
                       
                       // logic to orange the partialy assinged resources.
                       if( ($rsm->user_id != '0') )
                       {
                           if($authentication_group == 'admin')
                           {
                               //logic for partial resources assignment
                               if($rs_total < $order_no_of_men)
                               {
                                   $color_class = 'orange_class';
                               }
                           }
                       }
                       
                       if( ($rsm->user_id != '0')  &&  ( ($rsm->status != 'D') && ($rsm->status != 'C') && ($rsm->status != 'CD') && ($rsm->status != 'R') ) && ( $rsm->status == 'A' ) )
                       {
                           if( ($authentication_group == 'loader' || $authentication_group == 'crew_office') || ($this->_session->get('non_admin_mode')=='true') )
                           {
                               $model_resourcesmap = $this->getModel('resourcesmap');
                               $rs_for_crnt_wrkr_of_crnt_ordr = $model_resourcesmap->get_resourcemap_by_UserId_and_OrderId($this->_userId,$order_id);
                                   
                               if($rs_for_crnt_wrkr_of_crnt_ordr->status == 'A')
                               {                                                                                                      
                                   $color_class = 'green_class';
                               }                                    
                           }
                       }
                       
                       
                       if( ($rsm->user_id != '0')  &&  ( ($rsm->status != 'D') && ($rsm->status != 'C') && ($rsm->status != 'CD') && ($rsm->status != 'A') ) && ( $rsm->status == 'R' ) )
                       {
                           if( ($authentication_group == 'loader' || $authentication_group == 'crew_office') || ($this->_session->get('non_admin_mode')=='true') )
                           {
                               $model_resourcesmap = $this->getModel('resourcesmap');
                               $rs_for_crnt_wrkr_of_crnt_ordr = $model_resourcesmap->get_resourcemap_by_UserId_and_OrderId($this->_userId,$order_id);
                                   
                               if($rs_for_crnt_wrkr_of_crnt_ordr->status == 'R')
                               {                                                                                                      
                                   $color_class = 'orange_class';
                               }                                    
                           }
                       }
                       
                       if( ($rsm->user_id != '0')  &&  ( ($rsm->status != 'R') && ($rsm->status != 'C') && ($rsm->status != 'CD') && ($rsm->status != 'A') ) && ( $rsm->status == 'D' ) )
                       {
                           if( ($authentication_group == 'loader' || $authentication_group == 'crew_office') || ($this->_session->get('non_admin_mode')=='true') )
                           {
                               $model_resourcesmap = $this->getModel('resourcesmap');
                               $rs_for_crnt_wrkr_of_crnt_ordr = $model_resourcesmap->get_resourcemap_by_UserId_and_OrderId($this->_userId,$order_id);
                                   
                               if($rs_for_crnt_wrkr_of_crnt_ordr->status == 'D')
                               {                                                                                                      
                                   $color_class = 'red_class';
                               }                                    
                           }
                       }
                       
                       
                       // do with trucks
                       
                       if( ($rsm->user_id == '0') )
                       {
                           if($authentication_group == 'admin')
                           {
                               
                           }
                       }
                       
                       if(($rsm->user_id != '0') && ( ( ($rsm->status != 'A') && ($rsm->status != 'D') ) &&  (($rsm->status == 'C') || ($rsm->status == 'CD'))  ))
                       {
                           // logic to color black an order on admin user 
                           if($authentication_group == 'admin')
                           {
                               //old logic do black if all assigned worker confirmed
                               if(($rs_total > 0) && ($rs_counter_blk > 0) && ($rs_total==$rs_counter_blk))                               
                               // new logic do black if any resource is confirmed
                               //if(($rs_total > 0) && ($rs_counter_blk > 0))
                               {
                                   $color_class = 'black_class';                                   
                               }
                               
                               //loginc for partial resources assignment
                               if($rs_total < $order_no_of_men)
                               {
                                   $color_class = 'orange_class';
                               }
                               
                               $rs_counter_blk++;                               
                           }
                           
                           
                           if( ($authentication_group == 'loader' || $authentication_group == 'crew_office') || ($this->_session->get('non_admin_mode')=='true') )
                           {
                               $model_resourcesmap = $this->getModel('resourcesmap');
                               $rs_for_crnt_wrkr_of_crnt_ordr = $model_resourcesmap->get_resourcemap_by_UserId_and_OrderId($this->_userId,$order_id);
                                   
                               if($rs_for_crnt_wrkr_of_crnt_ordr->status == 'C' || $rs_for_crnt_wrkr_of_crnt_ordr->status == 'CD')
                               {                                                                                                      
                                   $color_class = 'black_class';
                               }
                                    
                           }                           
                       }
                       
                       
                       
                        // logic to color Yellow If found any rejected resouces                            						  
                        if(($rsm->user_id != '0') && ( ( ($rsm->status != 'A') && ($rsm->status != 'D') ) &&  ($rsm->status == 'R')  ))
                        {
                             if($authentication_group == 'admin')
                             {
                                $color_class = 'yellow_class';                                                                  
                             }
                        }
                   }
                   
                   $rs_truck_counter = 0;
                   $total_trucks = count($order_in_resource_map_trucks_array);
                   //foreach ($order_in_resource_map_trucks_array as $rsm)
                   //{
                       if( ($authentication_group == 'admin') && ($this->_session->get('non_admin_mode')==NULL) )
                       {
                               if( ($total_trucks < $order_no_of_trucks) && $rs_total > 0 )
                               {
                                   $color_class = 'orange_class';
                               }                                
                               //$rs_truck_counter++;                                                                    
                       }
                   //}
                   
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
                       $user_id_for_availability = $this->_userId;
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
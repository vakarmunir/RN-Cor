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


class RednetControllerOrderslist extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'orderslist'; 
	protected $_user;
	protected $_db;        
        
        public function __construct($config = array ()) 
	{
                $this->_user = JFactory::getUser();                
                
		parent :: __construct($config);
                
		JRequest :: setVar('view', $this->_viewname);                                
                
	}
	
        public function daily_dispatch()
        {
            $layout = 'default_daily_dispatch';            
            JRequest::setVar('layout',$layout);
            parent::display();
        }
        
        public function daily_dispatch_submit()
        {
            $layout = 'default_daily_dispatch';                        
            $date_order = JRequest::getVar('date_order');
            
            //var_dump( date('Y-m-d',strtotime($date_order)) );
            //exit();
            
            $orders_model = $this->getModel('orders');
            
            if( (date('Y-m-d',strtotime($date_order))) !='1970-01-01' )
            {
                $orders = $orders_model->getOrderByDate(date('Y-m-d',strtotime($date_order)));
                $record = array();
                $all_records = array();
                //var_dump($orders);
                
                // ===== [start] getting all assigned workers ================
                $model_orders = $this->getModel('orders');
                $all_assigned_trucks = NULL;
                foreach($orders as $order)
                {
                    $all_assigned_trucks = $model_orders->getAllAssignedTrucksByOrderId($order->id);
                    $all_assigned_workers = $model_orders->getAllAssignedWorkerByOrderId($order->id);
                            
                            
                            $fleet_model = $this->getModel('fleet');
                            $all_assigned_trucks_formatted = array();
                            $all_assigned_workers_formatted = array();
                            $truck_wx = NULL;
                            // =========== formating trucks -==========
                            foreach ($all_assigned_trucks as $as_truck)
                            {
                                if($as_truck->truck_type == 'fleet')
                                {
                                    $truck_wx = $fleet_model->getFleetById($as_truck->truck);
                                }
                                if($as_truck->truck_type == 'rental')
                                {
                                    $truck_wx = $fleet_model->getRentalById($as_truck->truck);
                                }
                                    $truck_obj = new JObject();
                                    foreach($as_truck as $attr=>$w_obj)
                                    {
                                        $truck_obj->set($attr,$w_obj);
                                    }
                                        $truck_obj->set('truck_name',$truck_wx->name);
                                        array_push($all_assigned_trucks_formatted, $truck_obj);
                                //}
                            }
                            
                            //============== formating workers =====================
                            $model_worker = $this->getModel('workers');                            
                            foreach ($all_assigned_workers as $rs)
                            {
                               $worker_wx = $model_worker->getWorkerById($rs->user_id);
                               $worker_obj = new JObject();
                               
                                    foreach($rs as $attr=>$w_obj)
                                    {
                                        $worker_obj->set($attr,$w_obj);
                                    }
                               $worker_obj->set('full_name',$worker_wx->first_name.' '.$worker_wx->last_name);
                               array_push($all_assigned_workers_formatted, $worker_obj);     
                            }
                            
                    $order_dtl = $model_orders->getOrderById($order->id);                
                    $ad_on_orders = $model_orders->getAdOnOrderById($order->id);                
                
                    $record['order'] = $order;
                    $record['ad_on_orders'] = $ad_on_orders;
                    $record['all_assigned_trucks'] = $all_assigned_trucks_formatted;
                    $record['all_assigned_workers'] = $all_assigned_workers_formatted;
                    array_push($all_records, $record);
                }
                
                //var_dump($all_records);
            }
            $form_data = array();
            $model = $this->getModel('fleet');
            $fleets = $model->getFleetsInService();
            $rentals = $model->getRentalsByUpCommingToDates();
            
                        $model_resourcesmap = $this->getModel('resourcesmap');
                        $resources_all_fleets_by_orderdate = $model_resourcesmap->get_resourcemap_by_trucktype_and_OrdderDate('fleet', date('Y-m-d',strtotime($date_order))  );
                        //var_dump($resources_all_fleets_by_orderdate);                        
                        
                        $form_data['resources_all_fleets_by_orderdate'] = $resources_all_fleets_by_orderdate;
                        
                        
                        $resources_all_rentals_by_orderdate = $model_resourcesmap->get_resourcemap_by_trucktype_and_OrdderDate('rental', date('Y-m-d',strtotime($date_order)) );
                        //var_dump($resources_all_rentals_by_orderdate);                        
                        $form_data['resources_all_rentals_by_orderdate'] = $resources_all_rentals_by_orderdate;

                        $db = JFactory::getDbo();
                        $query_worker_available_on_date = "SELECT DISTINCT * FROM #__user_availabilitycalendar WHERE availability_date = '".date('Y-m-d',strtotime($date_order))."'";   
                        $db->setQuery($query_worker_available_on_date);
                        $users_available_on_date_list = $db->loadObjectList();   
                        
                        $worker_model = $this->getModel('workers');                        
                        $workers_on_order_date = array();                                                
                        
                        foreach($users_available_on_date_list as $usr_av)
                        {
                            $worker = $worker_model->getWorkerById($usr_av->user_id);                            
                            array_push($workers_on_order_date, $worker);                            
                        }
                        
                        $all_loaders = array();
                        $all_drivers = array();
                        $all_crews = array();
                        $all_loaders = $worker_model->getAllLoaders();                        
                        $all_drivers = $worker_model->getAllDrivers();                        
                        $all_crews = $worker_model->getAllCrews();                        
                        
            //JRequest::setVar('orders',$orders);
                        
            JRequest::setVar('all_loaders', $all_loaders);
            JRequest::setVar('all_drivers', $all_drivers);
            JRequest::setVar('all_crews', $all_crews);
            JRequest::setVar('workers_on_order_date', $workers_on_order_date);
            JRequest::setVar('form_data', $form_data);
            JRequest::setVar('fleets', $fleets);
            JRequest::setVar('rentals', $rentals);
            JRequest::setVar('all_records',$all_records);
            JRequest::setVar('layout',$layout);
            parent::display();
        }
        
       public function sendStatusActivationEmail($user_id,$order_id,$order_no_rs,$order_name_rs,$date_order_rs,$rs_id)
       { 
              
               // To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
			$headers .= 'From: Red-Net <info@turnkey-solutions.net>' . "\r\n";
			//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
			//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
                        
                        
                        /*
                if(!mail($email,"RED-NET - User activation", "Password:$password. Please login to your account: http://168.144.97.198/rednet/",$headers))
                {
                    echo "problem in email sending.";
                    exit();                        
                }  
                         * 
                         */
          $config =  new JConfig();
          
          $user = JFactory::getUser($user_id);
          
          $worker_model = $this->getModel('workers');
          $worker = $worker_model->getWorkerById($user_id);
          
          
          
          $mailer = JFactory::getMailer();
          $from = array("info@turnkey-solutions.net","Red-Net");
          $mailer->setSender($from);
          $recipients = array($user->email);
         $mailer->addRecipient($recipients);
         $mailer->addRecipie;
          $subject = "RED-NET - New Order Assigned - $worker->first_name $worker->last_name";
          $mailer->setSubject($subject);
          $body = "
                  Hi $worker->first_name $worker->last_name,<br /><br />

            You have assign an order.<br /><br />

            Order# : $order_no_rs <br />      
            Order Name: $order_name_rs <br />
            Order Date: $date_order_rs (mm/dd/yyyy)<br />
                        
            <a href='".JURI::base()."index.php/component/rednet/orders/?task=update_resource_status&o_i=$order_id&r=$rs_id&u_v=1&user=$user->username&passw=$user->password'>Click here to confirm order.</a>  
                  
                  <br /><br />
                  
            If you have any problem, please contact 416 CALL RED<br /><br />

            Thanks<br />
            RED-NET team<br />
          "          
        ;
          //echo $body;
          
          $mailer->IsHTML(true);
          $mailer->Encoding = 'base64';
          $mailer->setBody($body);
          $send = $mailer->Send();
            if ( $send !== true ) {
                $msg = 'Error sending order confirmation email to worker.';
                $this->setMessage($msg.$body);                
            } 
       }
        public function daily_dispatch_email($data)
        {
            
            
            $order_ids = $data['order_id'];
            $date_order = date( 'Y-m-d',strtotime($data['date_order']) );
            $resourcesmap_model = $this->getModel('resourcesmap');
            
            foreach ($order_ids as $order_id)
            {
                
                //echo "order_id : ".$order_id;
                //echo "<br />";
                
                // =========== [start] working with trucks =================
                //echo "trucks of orders..";
                //echo "<br />";
                
                $model_order = $this->getModel('orders');
                $order_obj = $model_order->getOrderById($order_id);
                
                $assigned_truck_field_string = "assignedtruckid_".$order_id;
                $assigned_worker_field_string = "assignedworkerid_".$order_id;
                $assigned_rs_field_string = "rsid_".$order_id;
                $assigned_rsw_field_string = "rsidw_".$order_id;
                $assigned_type_field_string = "assignedtrucktype_".$order_id;
                $assigned_worker_role_string = "w_roles".$order_id;
                //echo $assigned_truck_field_string;
                $assigned_trucks = $data[$assigned_truck_field_string];
                $assigned_workers = $data[$assigned_worker_field_string];
                $assigned_workers_roles = $data[$assigned_worker_role_string];
                $assigned_rsid = $data[$assigned_rs_field_string];
                $assigned_rsidw = $data[$assigned_rsw_field_string];
                $assigned_types = $data[$assigned_type_field_string];
                
                if(count($assigned_workers) > 0)
                {
                    $cntr = 0;
                    foreach($assigned_workers as $assigned_worker)
                    {
                        $rs_id = $assigned_rsidw[$cntr];

                            //  1 - **************************** ****************************                                                             
                            if(isset($rs_id))
                            {
                                $resource_obj = $resourcesmap_model->get_resourcemap_by_id($rs_id);
                                
                                if($resource_obj->is_dispatched != '1')
                                {                            
                                    $this->sendStatusActivationEmail($assigned_worker,$order_id,$order_obj->order_no,$order_obj->name,date('m/d/Y',strtotime($date_order)),$rs_id);
                                    $resourcesmap_model->update_resource_status($rs_id,'D');                        
                                    $resourcesmap_model->set_field_by_value($rs_id,'is_dispatched','1');                                                        
                                }
                                   //echo $assigned_worker. ' =====  '.$rs_id."<br />";
                            }                          
                        $cntr++;
                    }
                }
            }
            
            
                    $this->setMessage("Orders dispatched successfuly.");
                    $url = JURI::base()."index.php/component/rednet/orderslist/?task=daily_dispatch_submit&date_order=".date('m/d/Y',strtotime($date_order));
                    $this->setRedirect($url);
                    $this->redirect();
                    exit;
        }
        
        public function daily_dispatch_save()
        {
            
            $submit_val = JRequest::getVar('submit');
            if($submit_val == 'Dispatch')
            {
                $data = JRequest::get();
                $this->daily_dispatch_email($data);
                
            }
            
            $order_ids = JRequest::getVar('order_id');
            $date_order = JRequest::getVar('date_order');
            foreach ($order_ids as $order_id)
            {
                
                //echo "order_id : ".$order_id;
                //echo "<br />";
                
                // =========== [start] working with trucks =================
                //echo "trucks of orders..";
                //echo "<br />";
                $assigned_truck_field_string = "assignedtruckid_".$order_id;
                $assigned_worker_field_string = "assignedworkerid_".$order_id;
                $assigned_rs_field_string = "rsid_".$order_id;
                $assigned_rsw_field_string = "rsidw_".$order_id;
                $assigned_type_field_string = "assignedtrucktype_".$order_id;
                $assigned_worker_role_string = "w_roles".$order_id;
                //echo $assigned_truck_field_string;
                $assigned_trucks = JRequest::getVar($assigned_truck_field_string);
                $assigned_workers = JRequest::getVar($assigned_worker_field_string);
                $assigned_workers_roles = JRequest::getVar($assigned_worker_role_string);
                $assigned_rsid = JRequest::getVar($assigned_rs_field_string);
                $assigned_rsidw = JRequest::getVar($assigned_rsw_field_string);
                $assigned_types = JRequest::getVar($assigned_type_field_string);
                
                if(count($assigned_trucks) > 0)
                {
                    $cntr = 0;
                    foreach($assigned_trucks as $assigned_truck)
                    {
                        //echo $assigned_truck . ' | rsid: '.$assigned_rsid[$cntr];
                        //echo "<br />";
                         $rs_id = $assigned_rsid[$cntr];
                        
                            

                            //  1 - **************************** [start] deleting truck resource ****************************                                                             
                            if(isset($rs_id))
                            {
                                //var_dump($rs_id);
                                //echo " )))))))))";
                                $this->del_resource($rs_id);

                                // [starts] ===== dealing with add-on orderder =========                                                      
                                    $mdl_orders = $this->getModel('orders');
                                    $mdl_resourcesmap = $this->getModel('resourcesmap');
                                    $crnt_adon_orders = $mdl_orders->getAdOnOrderById($order_id);
                                    
                                    if(count($crnt_adon_orders) > 0)
                                    {
                                        foreach($crnt_adon_orders as $adon_order)
                                        {
                                            $rsm_adon = $mdl_resourcesmap->get_resourcemap_by_truck_and_OrderId($assigned_truck,$adon_order->id);
                                            if(isset($rsm_adon->id))
                                            {
                                                $this->del_resource($rsm_adon->id);
                                            }

                                        }
                                    }                                                                                       
                                // [end] ===== dealing with add-on orderder =========                         
                            }                          
                        $cntr++;
                    }
                                  
                }                
                // =========== [end] working with trucks =================
                
                // =========== [Start] working with workers =================
                $order_date = date("Y-m-d",  strtotime($date_order));
                if(count($assigned_workers) > 0)
                {
                    $cntr = 0;
                    foreach($assigned_workers as $assigned_worker)
                    {
                        //echo $assigned_truck . ' | rsid: '.$assigned_rsid[$cntr];
                        //echo "<br />";
                         $rs_id = $assigned_rsidw[$cntr];
                        
                            

                            //  1 - **************************** [start] deleting workers resource ****************************                                                             
                            if(isset($rs_id))
                            {
                                
                                $this->del_resource($rs_id);

                                // [starts] ===== dealing with add-on orderder =========                                                      
                                    $mdl_orders = $this->getModel('orders');
                                    $mdl_resourcesmap = $this->getModel('resourcesmap');
                                    $crnt_adon_orders = $mdl_orders->getAdOnOrderById($order_id);
                                    
                                    if(count($crnt_adon_orders) > 0)
                                    {
                                        foreach($crnt_adon_orders as $adon_order)
                                        {
                                            $rsm_adon = $mdl_resourcesmap->get_resourcemap_by_UserId_and_OrderId($assigned_worker,$adon_order->id);
                                            if(isset($rsm_adon->id))
                                            {
                                                $this->del_resource($rsm_adon->id);
                                            }

                                        }
                                    }                                                                                       
                                // [end] ===== dealing with add-on orderder =========                         
                                    
                                    // 2 - restoring user calender availbity
                                        
                                            $av_model = $this->getModel('availabilitycalendar');
                                            if($assigned_worker!='0')
                                            {
                                                $rs_map_model = $this->getModel('resourcesmap');
                                                //$worker_having_resources = $rs_map_model->get_resourcemap_by_userId($data['worker_id']);

                                                // getting worker having resources map on current orderDate
                                                $worker_having_resources = $rs_map_model->get_resourcemap_by_UserId_OrderId_OrdderDate($assigned_worker,$order_id,$order_date);

                                                //$av_already = $av_model->get_user_availabilitycalendar_userId_avId($data['worker_id'],$data['order_date']);                                                        
                                                if(count($worker_having_resources) == 0)
                                                {
                                                    $av_model->add_availabilitycalendar_complete($assigned_worker,$order_date);
                                                    // del email code
                                                    //if($data['status']!='A'){

                                                      //  $this->sendRemovalFromJobEmail($data['worker_id'],$data['ord_id']);                               
                                                    //}                                                               

                                                }

                                            }
                                        
                            }                          
                        $cntr++;
                    }
                                  
                }
                // =========== [End] working with workers =================
                
                       //  == - **************************** [start] assigning truck resource ****************************                          
                                $this->assign_resources($assigned_workers,$assigned_trucks,$assigned_types,$assigned_workers_roles,$order_id);
                                $no_of_rows = 0;
                    
                                if(count($assigned_workers) > count($assigned_trucks))
                                {
                                    $no_of_rows = count($assigned_workers);
                                }else{
                                    $no_of_rows = count($assigned_trucks);
                                }

                                                    //  ============= Removing Availabiltiy ===========                                         
                                $model_availabilitycalendar = $this->getModel('availabilitycalendar');                    

                                for($x = 0; $x<$no_of_rows; $x++)
                                {
                                    if($assigned_workers[$x] != NULL)
                                    {
                                        $model_availabilitycalendar->delete_availabilitycalendar_by_date($assigned_workers[$x],$order_date);
                                    }
                                }
                    
                        //  == - **************************** [end] adding truck resource ****************************                          
                        
                        //  == - **************************** [end] adding truck resource ****************************                          
                                
                //echo "<br />";echo "<br />";
            }
            
                    $this->setMessage("Ressources alloted successfuly.");
                    $url = JURI::base()."index.php/component/rednet/orderslist/?task=daily_dispatch_submit&date_order=".date('m/d/Y',strtotime($order_date));
                    $this->setRedirect($url);
                    $this->redirect();
        }
        
        public function del_resource($id)
        {
            //echo "here......";
            //exit;
            
            $db = JFactory::getDbo();
            $qry="DELETE FROM #__resourcesmap WHERE id = $id";
            $db->setQuery($qry);
            $db->query() or die(mysql_error());
        }
        
        
       public function assign_resources($workers,$trucks,$truck_types,$w_roles,$order_id)
       {           
           $rs_id=0;
           $w_cntr = 0;
           $t_cntr = 0;
                    $resources_model = $this->getModel('resourcesmap');
                    
                    if($workers!= NULL)
                    {
                        foreach($workers as $worker)
                        {       
                                $resources_model->_order_id = $order_id;
                                $resources_model->_user_id = $worker;                            
                                $resources_model->_worker_role = $w_roles[$w_cntr];                            
                                $resources_model->_status = 'A';                                                                                                                        
                                
                                $rs_id = $resources_model->add_resourcesmap();                            
                                $w_cntr++;
                        }
                    }
                    
                    //var_dump($trucks);
                    if($trucks != NULL)
                    {
                        
                        foreach($trucks as $truck)
                        {
                                $resources_model->_order_id = $order_id;                            
                                $resources_model->_user_id = 0;
                                $resources_model->_truck = $truck;
                                $resources_model->_truck_type = $truck_types[$t_cntr];
                                $resources_model->_status = '';                                                                                                                        
                                $resources_model->add_resourcesmap();

                                //var_dump($resources_model);
                                
                                $t_cntr++;
                        }
                    }
                    
                    
       }
        
}// class
?>
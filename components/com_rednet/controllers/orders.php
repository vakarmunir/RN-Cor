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
class RednetControllerOrders extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'orders'; 
	protected $_user;
	protected $_db;
        protected $_session_current;


        public function __construct($config = array ()) 
	{
                $this->_user = JFactory::getUser();                
                
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);
                
                $db = JFactory::getDbo();                
                
                
           // ==================== Updating the resources status =====================                                           
           $action = JRequest::getVar('action');           
           $task = JRequest::getVar('task');           
           
           if(isset($action) && $action == 'update_resource_status')
           {
               
               $comments = $_POST['dialog-form-comments-box-submit'];
               //var_dump($comments);
               //var_dump($_POST['dialog-form-comments-box-submit']);
               //exit();
               
                $rs_id = JRequest::getVar('rs_id');               
                $update_value = JRequest::getVar('confirm_order');                
                $resource_model = $this->getModel('resourcesmap');                         
                $resource_model->update_resource_status($rs_id,$update_value,$comments);           
                $url = JURI::base().'index.php/component/rednet/orders/?task=message';
                $this->setMessage("You have confirmed order successfully.");
                $this->setRedirect($url);           
           }
           
        // ==================== Updating the resources status =====================                                 
                $id = JRequest::getVar('id');                
                if(isset($id) && $id!=NULL )
                {                                            
                        $order_id = JRequest::getVar('id');
                        $model_orders = $this->getModel('orders');
                        
                        $form_data = array();
                        
                        $ad_on_orders = $model_orders->getAdOnOrderById($id);
                        
                        $order = $model_orders->getItem($order_id);                        
                        
                        
                        // ===== [start] getting all available workers ================
                            $model = $this->getModel('workers');                                                                               
                            //$all_available_workers = $model_orders->getAllAvailableWorkersByOrderId($id);                            
                            $all_available_workers_rslt = $model_orders->getAllAvailableWorkersByOrderId($id);                            
                            $all_available_workers = array();
                            
                            // ============= [start] filtering worker according to order type ==================
                           /*
                            if ($order->type_order == 'pack')
                            {
                                foreach($all_available_workers_rslt as $av_worker)
                                {

                                    $user_id = $av_worker->user_id;
                                    $worker_roles = $model->getWorkerRolesIndexs($user_id);
                                    
                                    if($this->IsRoleNameExist($worker_roles,'packer'))
                                    {
                                        array_push($all_available_workers, $worker_roles);                                        
                                    }                                    
                                }                            
                            }
                            */
                            if ($order->type_order == 'pack')
                            {
                                $array_source = $all_available_workers_rslt;
                                
                                foreach($all_available_workers_rslt as $i=>$av_worker)
                                {

                                    $user_id = $av_worker->user_id;
                                    $worker_roles = $model->getWorkerRolesIndexs($user_id);
                                    
                                    if(($this->IsRoleNameExist($worker_roles,'ldr-f') == true && count($worker_roles) == 1)   ||  ($this->IsRoleNameExist($worker_roles,'ldr-p') == true && count($worker_roles) == 1))
                                    {  
                                        //echo "in if ==> i am packer and only 1 usr =".$av_worker->first_name;
                                        unset($array_source[$i]);                                   
                                    }else{
                                        //echo "in else <br />";
                                    }
                                    
                                    //echo "<br />**** loop cycle ****<br />";
                                }
                                
                                $all_available_workers = $array_source;                                                                
                                //var_dump($all_available_workers_rslt);
                            }
                            
                            if ($order->type_order != 'pack')
                            {
                                $array_source = $all_available_workers_rslt;
                                
                                foreach($all_available_workers_rslt as $i=>$av_worker)
                                {

                                    $user_id = $av_worker->user_id;
                                    $worker_roles = $model->getWorkerRolesIndexs($user_id);
                                    
                                    if($this->IsRoleNameExist($worker_roles,'packer') == true && count($worker_roles) == 1)
                                    {  
                                        //echo "in if ==> i am packer and only 1 usr =".$av_worker->first_name;
                                        unset($array_source[$i]);                                   
                                    }else{
                                        //echo "in else <br />";
                                    }
                                    
                                    //echo "<br />**** loop cycle ****<br />";
                                }
                                
                                $all_available_workers = $array_source;                                                                
                                //var_dump($all_available_workers_rslt);
                            }
                            // ============= [end] filtering worker according to order type ==================
                            $form_data['all_available_workers'] = $all_available_workers;
                        // ===== [end] getting all available workers ================
                        
                        // ===== [start] getting all assigned workers ================
                            
                            //var_dump($order);
                            
                            $all_assigned_workers = $model_orders->getAllAssignedWorkerByOrderId($id);
                            $form_data['all_assigned_workers'] = $all_assigned_workers;
                        // ===== [end] getting all available workers ================
                        
                        
                        // ===== [start] getting all assigned workers ================
                            $all_assigned_trucks = $model_orders->getAllAssignedTrucksByOrderId($id);
                            $form_data['all_assigned_trucks'] = $all_assigned_trucks;
                        // ===== [end] getting all available workers ================
                        
                        
                        // ====== [end] checking status of date if OPEN,CLOSED,HOLD ==========                                                
                        $query_worker_available_on_date = "SELECT DISTINCT * FROM #__user_availabilitycalendar WHERE availability_date = '$order->date_order'";   
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
                        
                        /*
                        $all_loaders = $worker_model->getAllLoaders();                        
                        $all_drivers = $worker_model->getAllDrivers();                        
                        $all_crews = $worker_model->getAllCrews();                        
                        $all_packers = $worker_model->getAllPackers();                        
                        */
                        
                        
                       
                        $rs_model = $this->getModel('resourcesmap');
                        $rs_current_date = $rs_model->get_resourcemap_OrdderDate($order->date_order);
                        
                        //var_dump($rs_current_date);
                        $wrker_model = $this->getModel('workers');                        
                        $workers_in_rs_on_order_date = array();                                                                        
                        
                        foreach($rs_current_date as $rs)
                        {
                            if($rs->user_id > 0)
                            {
                                //echo "<br />=========================<br />";
                                //var_dump($rs);
                                $wrker = $wrker_model->getWorkerById($rs->user_id);                            
                                array_push($workers_in_rs_on_order_date, $wrker); 
                                //echo "<br />=========================<br />";
                            }
                            
                        }
                        
                        
                        
                        
                        $all_loaders = $worker_model->getAllLoaders();                        
                        $all_drivers = $worker_model->getAllDrivers();                        
                        $all_crews = $worker_model->getAllCrews();                        
                        $all_packers = $worker_model->getAllPackers();                        
                        
                        
                        $userId_for_rs = $this->_user->id;
                        $switch_to_none_admin = 'false';
                        $non_admin_id = JRequest::getVar("non_admin_id");
                        if(isset($non_admin_id))
                        {
                            $switch_to_none_admin = 'true';
                            $userId_for_rs = $non_admin_id;
                        }

                        $model_resourcesmap = $this->getModel('resourcesmap');
                        $resources = $model_resourcesmap->get_resourcesmap_by_order_id($order_id);
                        $rsId_for_crnt_wrkr_of_crnt_ordr = $model_resourcesmap->get_resourcemap_by_UserId_and_OrderId($userId_for_rs,$order_id);
                        $form_data['rsId_for_crnt_wrkr_of_crnt_ordr'] = $rsId_for_crnt_wrkr_of_crnt_ordr;
                        $form_data['switch_to_none_admin']=$switch_to_none_admin;
                        
                        
                        $resources_all_fleets_by_orderdate = $model_resourcesmap->get_resourcemap_by_trucktype_and_OrdderDate('fleet',$order->date_order);
                        
                        $form_data['resources_all_fleets_by_orderdate'] = $resources_all_fleets_by_orderdate;
                        
                        $resources_all_rentals_by_orderdate = $model_resourcesmap->get_resourcemap_by_trucktype_and_OrdderDate('rental',$order->date_order);
                        //var_dump($resources_all_rentals_by_orderdate);                        
                        $form_data['resources_all_rentals_by_orderdate'] = $resources_all_rentals_by_orderdate;
                        
                        $model = $this->getModel('fleet');
                        $fleets = $model->getFleets();
                        $fleets_not_assigned = $model->getFleetsNotAssigned();                                                
                        
                        $fleets_assigned = $model->getFleetsAssigned();                                                
                        
                        
                        $rentals = $model->getRentalsByUpCommingToDates();
                        $rentals_not_assigned = $model->getnNotAssignedRentalsByUpCommingToDates();
                        $rentals_assigned = $model->getAssignedRentals();
                        
                        

                        
                        $ordertype_model = $this->getModel('ordertype');
                        $ordertypes = $ordertype_model->getAllOrderTypes();
                        $form_data['ordertypes'] = $ordertypes;                        
                        
                        $workers_model = $this->getModel('workers');
                        $authentication_group = $workers_model->getWorkerAuthenticationGroup($this->_user->id);                        
                        $form_data['authentication_group'] = $authentication_group;
                        
                        // ================== Getting json output =====================
                        $request_mode = JRequest::getVar('mode');
                        
                        if($request_mode == 'json')
                        {
                            $data = array();
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
                            
                            $data['all_assigned_workers'] = $all_assigned_workers_formatted;                                                                                    
                            $data['all_assigned_trucks'] = $all_assigned_trucks_formatted;
                            echo json_encode($data);
                            //echo "==> $order_id";
                            exit();
                        }
                        
                        // ====== [start] checking status of date if OPEN,CLOSED,HOLD =========
                            //var_dump(strtotime($order->date_order));
                            
                            if($task == NULL)   
                            {
                                        $ordersoncalendar_model = $this->getModel('ordersoncalendar');
                                        $day_status_obj = $ordersoncalendar_model->getDayByDate($order->date_order);

                                        if(isset($day_status_obj) && $day_status_obj!=NULL)
                                        {
                                            $url = JURI::root().'index.php/component/rednet/ordersoncalendar/';
                                            if($day_status_obj->status == 'closed')
                                            {
                                                $msg = "Status of order's day is closed";
                                                $this->setRedirect($url,$msg);
                                                $this->redirect();
                                            }

                                            if($day_status_obj->status == 'hold')
                                            {
                                                $msg = "Status of order's day is hold";
                                                $this->setRedirect($url,$msg);
                                                $this->redirect();
                                            }
                                        }
                            }
                            
                        JRequest::setVar('form_data', $form_data);
                        JRequest::setVar('resources', $resources);
                        JRequest::setVar('fleets', $fleets);
                        JRequest::setVar('fleets_not_assigned', $fleets_not_assigned);
                        JRequest::setVar('fleets_assigned', $fleets_assigned);
                        JRequest::setVar('rentals', $rentals);
                        JRequest::setVar('rentals_not_assigned', $rentals_not_assigned);
                        JRequest::setVar('rentals_assigned', $rentals_assigned);
                        JRequest::setVar('all_loaders', $all_loaders);
                        JRequest::setVar('all_drivers', $all_drivers);
                        JRequest::setVar('all_crews', $all_crews);
                        JRequest::setVar('all_packers', $all_packers);
                        JRequest::setVar('workers_on_order_date', $workers_on_order_date);                                               
                        JRequest::setVar('workers_in_rs_on_order_date', $workers_in_rs_on_order_date);                                               
                        JRequest::setVar('ad_on_orders', $ad_on_orders);                                               
                }
                
                
                $order_id = JRequest::getVar('order_id');
                $order_no_rs = JRequest::getVar('order_no_rs');
                $order_name_rs = JRequest::getVar('order_name_rs');
                $date_order_rs = JRequest::getVar('date_order_rs');                                
                $submit_value = JRequest::getVar('submit');
                                 
                if(isset($order_id) && $order_id != NULL && $submit_value == "Save")
                {
                    //echo "here.......";
                    //exit();
                    
                    $ad_on_order_id = JRequest::getVar('ad_on_order_id');                        
                    $date_order = JRequest::getVar('date_order');
                    $workers = JRequest::getVar('workers');
                    $trucks = JRequest::getVar('trucks');
                    $truck_types = JRequest::getVar('truck_type');
                    $w_roles = JRequest::getVar('w_roles');
                    $status = JRequest::getVar('status');
                    $cntr = 0;
                    $no_of_rows = 0;
                    
                    if(count($workers) > count($trucks))
                    {
                        $no_of_rows = count($workers);
                    }else{
                        $no_of_rows = count($trucks);
                    }
                    //echo $date_order;
                    
                    
                    $stop_truck_to_add = false;
                    //========= Assigning Resources to orignal order ===========
                    
                    $this->assign_resources($workers,$trucks,$truck_types,$w_roles,$order_id);
                     // assigning resources to ad-on order
                    if($ad_on_order_id!=NULL)
                    {
                        foreach($ad_on_order_id as $order_ad_id)
                        {
                            $this->assign_resources($workers,$trucks,$truck_types,$w_roles,$order_ad_id);
                        }
                    }
                    
                   //  ============= Removing Availabiltiy ===========                     
                    $date_order = JRequest::getVar('date_order');
                    $model_availabilitycalendar = $this->getModel('availabilitycalendar');                    
                    
                    for($x = 0; $x<$no_of_rows; $x++)
                    {
                        if($workers[$x] != NULL)
                        {
                            $model_availabilitycalendar->delete_availabilitycalendar_by_date($workers[$x],$date_order);
                        }
                    }                                        
                                                            
                    $this->setMessage("Ressources alloted successfuly.");
                    $url = JURI::base()."index.php/component/rednet/orders/?id=$order_id";
                    $this->setRedirect($url);
                    $this->redirect();
                }
                
                if(isset($order_id) && $order_id != NULL && $submit_value == "Dispatch")
                {
                    $cntr_dsp = 0;
                    $workers_alloted = JRequest::getVar('workers_alloted');
                    $resource_id = JRequest::getVar('resource_id');
                    $resourcesmap_model = $this->getModel('resourcesmap');
                    
                    foreach($workers_alloted as $worker)
                    {                        
                        $user = JFactory::getUser($worker);                                                
                        $rs_id = $resource_id[$cntr_dsp];
                        
                        $resource_obj = $resourcesmap_model->get_resourcemap_by_id($rs_id);
                        
                        if($resource_obj->is_dispatched != '1')
                        {                            
                            $this->sendStatusActivationEmail($worker,$order_id,$order_no_rs,$order_name_rs,$date_order_rs,$rs_id);
                            $resourcesmap_model->update_resource_status($rs_id,'D');                        
                            $resourcesmap_model->set_field_by_value($rs_id,'is_dispatched','1');                                                        
                        }
                        
                        $cntr_dsp++;
                    }
                    
                    $this->setMessage("New ressources dispatched successfuly.");
                    $url = JURI::base()."index.php/component/rednet/orders/?id=$order_id";
                    $this->setRedirect($url);
                    $this->redirect();
                }
                
                // ============ Deleting allocated resources and resorting the values to there tables  ==========================================
                $action = JRequest::getVar('action');                
                $type = JRequest::getVar('type');                
                if($action =="del_resource")
                {
                    $data = JRequest::get();                    
                    
                    //  1 - deleting resource                                                            
                    $this->del_resource($data['rs_id']);
                    
                    // [starts] ===== dealing with add-on orderder =========
                    if($type=='worker')
                    {
                        $mdl_orders = $this->getModel('orders');
                       $mdl_resourcesmap = $this->getModel('resourcesmap');
                       $crnt_adon_orders = $mdl_orders->getAdOnOrderById($data['ord_id']);
                       foreach($crnt_adon_orders as $adon_order)
                       {
                          $rsm_adon = $mdl_resourcesmap->get_resourcemap_by_UserId_and_OrderId($data['worker_id'],$adon_order->id);
                          $this->del_resource($rsm_adon->id);
                       }                       
                    }
                       
                    if($type=='truck')
                    {
                       $mdl_orders = $this->getModel('orders');
                       $mdl_resourcesmap = $this->getModel('resourcesmap');
                       $crnt_adon_orders = $mdl_orders->getAdOnOrderById($data['ord_id']);
                       foreach($crnt_adon_orders as $adon_order)
                       {
                          $rsm_adon = $mdl_resourcesmap->get_resourcemap_by_truck_and_OrderId($data['truck'],$adon_order->id);
                          $this->del_resource($rsm_adon->id);
                       }                       
                    }
                       
                    // [end] ===== dealing with add-on orderder =========
                    
                    
                    // 2 - restoring user calender availbity
                    if($type=='worker')
                    {
                        $av_model = $this->getModel('availabilitycalendar');
                        if($data['worker_id']!='0')
                        {
                            $rs_map_model = $this->getModel('resourcesmap');
                            //$worker_having_resources = $rs_map_model->get_resourcemap_by_userId($data['worker_id']);
                                                        
                            // getting worker having resources map on current orderDate
                            $worker_having_resources = $rs_map_model->get_resourcemap_by_UserId_OrderId_OrdderDate($data['worker_id'],$order_id,$data['order_date']);
                            
                            //$av_already = $av_model->get_user_availabilitycalendar_userId_avId($data['worker_id'],$data['order_date']);                                                        
                            if(count($worker_having_resources) == 0)
                            {
                                $av_model->add_availabilitycalendar_complete($data['worker_id'],$data['order_date']);
                                // del email code
                                if($data['status']!='A'){
                                    
                                    $this->sendRemovalFromJobEmail($data['worker_id'],$data['ord_id']);                               
                                }                                                               
                                
                            }
                            
                        }
                    }
                    
                    //exit();
                    $this->setMessage("Ressources restored successfuly.");
                    $url = JURI::base()."index.php/component/rednet/orders/?id=$data[ord_id]";
                    $this->setRedirect($url);
                    $this->redirect();                    
                }                
	}
	
        
       private function assign_resources($workers,$trucks,$truck_types,$w_roles,$order_id)
       {           
           $rs_id=0;
           $w_cntr = 0;
           $t_cntr = 0;
                    $resources_model = $this->getModel('resourcesmap');
                    foreach($workers as $worker)
                    {       
                            $resources_model->_order_id = $order_id;
                            $resources_model->_user_id = $worker;                            
                            $resources_model->_worker_role = $w_roles[$w_cntr];                            
                            $resources_model->_status = 'A';                                                                                                                        
                            $rs_id = $resources_model->add_resourcesmap();                            
                            $w_cntr++;
                    }
                    
                    foreach($trucks as $truck)
                    {
                            $resources_model->_order_id = $order_id;                            
                            $resources_model->_user_id = 0;
                            $resources_model->_truck = $truck;
                            $resources_model->_truck_type = $truck_types[$t_cntr];
                            $resources_model->_status = '';                                                                                                                        
                            $resources_model->add_resourcesmap();
                            
                            $t_cntr++;
                    }
                    
       }
       
       private function sendStatusActivationEmail($user_id,$order_id,$order_no_rs,$order_name_rs,$date_order_rs,$rs_id)
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
       
    
       
        
       public function message()
       {
           $layout="default_message";
           JRequest::setVar('layout',$layout);
           parent::display();
       }
       public function update_resource_status()
       {
           
           
           $form_data = array();
           $rs_id = JRequest::getVar('r');
           $action = JRequest::getVar('task');
           $o_id = JRequest::getVar('o_i');
           
           $url = JURI::current()."?id=$o_id&rs_id=$rs_id&act=$action";
                     
           $this->setRedirect($url);
           $this->redirect();           

       }
       
        public function del_resource($id)
        {            
            if(isset($id))
            {
                $db = JFactory::getDbo();
                $qry="DELETE FROM #__resourcesmap WHERE id = $id";                
                $db->setQuery($qry);
                $db->query() or die(mysql_error());
            }            
        }

	public function order_form()
        {
                      
             $session =& JFactory::getSession();                                       
             $order = unserialize($session->get('order_return'));                          
             $session->clear('order_return');
             
             if(isset($order) && $order!=NULL)
             {
                 JRequest::setVar('order',$order);             
             }
             
             $session->set('order_redirect_ur',$_SERVER['REQUEST_URI']);
            
            $id = JRequest::getVar('id');
            $p_o = JRequest::getVar('p_o');            
            
            
            
            
            $action = "";
            $is_addon = "";
            $parent_order = $p_o;
            
            $form_data = array();
            if(isset($id) && $id!=NULL)
            {
                $model = $this->getModel('orders');
                $order = $model->getOrderById($id);                
                $ad_on_orders = $model->getAdOnOrderById($id);                
                $action = "update";
                JRequest::setVar('order',$order);                
            }else
            {
                $action = "add";
            }
            
            if(isset($p_o) && $p_o!=NULL)
            {
                $is_addon = "1";
                
                $m = JRequest::getVar('m');
                $t = JRequest::getVar('t');

                $form_data['m'] = $m;
                $form_data['t'] = $t; 
                
            $tr = JRequest::getVar('tr');
            $od = JRequest::getVar('od');
            $dt = JRequest::getVar('dt');
            
            $form_data['tr'] = $tr;
            $form_data['od'] = $od;
            $form_data['dt'] = $dt;

            
            
            }else
            {
                $is_addon = "0";
            }
            
            
            $ordertype_model = $this->getModel('ordertype');
            $ordertypes = $ordertype_model->getAllOrderTypes();
                        
            
            $form_data['ordertypes'] = $ordertypes;                        
            $form_data['parent_order'] = $parent_order;                        
            $form_data['action'] = $action;            
            $form_data['is_addon'] = $is_addon;            
            $form_data['ad_on_orders'] = $ad_on_orders;            
            $layout = 'default_order_form';            
            JRequest::setVar('layout',$layout);
            JRequest::setVar('form_data',$form_data);
            
            parent::display();
        }
	
	public function order_wizard()
        {
            $form_data = array();
            $p_o = JRequest::getVar('o_n_id');
            $m = JRequest::getVar('m');
            $t = JRequest::getVar('t');
            $tr = JRequest::getVar('tr');
            $od = JRequest::getVar('od');
            $dt = JRequest::getVar('dt');
            
            $form_data['p_o'] = $p_o;
            $form_data['m'] = $m;
            $form_data['t'] = $t;
            $form_data['tr'] = $tr;
            $form_data['od'] = $od;
            $form_data['dt'] = $dt;
            
            JRequest::setVar('form_data',$form_data);
            
            $layout = 'default_order_wizard';            
            JRequest::setVar('layout',$layout);            
            parent::display();
        }
        
        public function order_delete()
        {
            $id = JRequest::getVar('id');
            $order_model = $this->getModel('orders');
            
            
            
            //======= [start] retrive current order ===================
             $current_order = $order_model->getOrderById($id);
            //======= [end] retrive current order ===================
            
            $db = JFactory::getDbo();
            
            $query = "SELECT * FROM #__orders WHERE parent_order=$id ORDER BY id ASC";
            
            $db->setQuery($query);
            $db->query() or die(mysql_error());                        
            $objects_adons = $db->loadObjectList();
            
            //======= [start] formatting new main and adon orders ============            
            if( count($objects_adons) > 0 )
            {                            
                    $new_main_order = $objects_adons[0];            
                    $query_ua = "UPDATE #__orders SET is_addon=0 , parent_order=0 WHERE id=$new_main_order->id";
                    $db->setQuery($query_ua);
                    $db->query() or die(mysql_error());                        

                    $new_adon_orders = array();
                    $cntr = 0;

                    foreach($objects_adons as $order_adon)
                    {
                        if($cntr > 0)
                        {
                                $query_ua = "UPDATE #__orders SET is_addon=1 , parent_order=$new_main_order->id WHERE id=$order_adon->id";
                                $db->setQuery($query_ua);
                                $db->query() or die(mysql_error());                        
                            //array_push($new_adon_orders, $order_adon);
                        }
                        $cntr++;
                    }
                    
                    
                    // ======== email to resources ==================================
                        $resourcesmap_model = $this->getModel('resourcesmap');
                        $order_in_resource_map_all = $resourcesmap_model->get_resourcesmap_by_order_id($id);
                        $order_in_resource_map_worker_array = array();                                           

                        foreach ($order_in_resource_map_all as $rsm_flt)
                        {
                            if($rsm_flt->user_id > 0)
                            {
                                array_push($order_in_resource_map_worker_array, $rsm_flt);
                            }
                        }
                        
                        foreach ($order_in_resource_map_worker_array as $rs)
                        {
                            $rs->user_id;
                            $this->sendRemovalOfJobEmail($rs->user_id,$id);
                            //$resourcesmap_model->delete_resourcesmap($rs->id);
                        }
                    // ======== email to resources ==================================
           } 
        //======= [end] formatting new main and adon orders ============                        
            
            $order_model->_order_id = $id;
            $order_model->delete_order();
            
            
            //============ restoring the resources ===================
            $model_resourcesmap = $this->getModel('resourcesmap');
            $resources = $model_resourcesmap->get_resourcesmap_by_order_id($id);
                        
            foreach ($resources as $resource)
            {
                $model_resourcesmap->delete_resourcesmap($resource->id);
                
                if($resource->truck == '' || $resource->truck == '0') 
                {                                                                               
                            $av_model = $this->getModel('availabilitycalendar');                        
                            $rs_map_model = $this->getModel('resourcesmap');
                            
                            $worker_having_resources = $rs_map_model->get_resourcemap_by_UserId_OrderId_OrdderDate($resource->user_id,$id,$current_order->date_order);
                                                        
                            if(count($worker_having_resources) == 0)
                            {                               
                                $av_model->add_availabilitycalendar_complete($resource->user_id,$current_order->date_order);                                
                            }                                                                        
                }                                
            }
                        
            $this->setMessage("Order deleted.");
            $this->setRedirect(JRoute::_('index.php/component/rednet/orderslist'));
            $this->redirect();            
        }
	public function order_form_save()
        {
            
            
            
            $user = $this->_user;
            $order_model = $this->getModel('orders');
                        
            $order_no_check = JRequest::getVar('order_no');                        
            $date_order_string = JRequest::getVar('date_order');                        
            $date_order = Date('Y-m-d',  strtotime($date_order_string));
            $flag = $order_model->is_order_exist_at_date($order_no_check,$date_order);            
            
            $orderhelper = new JObject();                                                            
            
            $id = JRequest::getVar('id');
            $action = JRequest::getVar('action');            
            $form_data = array();
            
            if(isset($action) && $action=='add')
            {
                
                
// ================= [start] checking existing Order# ================
            if($flag == TRUE)
            {                 
                $orderhelper->set('order_no', $order_no_check);                 
                $orderhelper->set('name',JRequest::getVar('name'));
                $orderhelper->set('date_order',JRequest::getVar('date_order'));
                $orderhelper->set('type_order',JRequest::getVar('type_order'));
                $orderhelper->set('type_if_other',JRequest::getVar('type_order_other'));
                $orderhelper->set('no_of_men',JRequest::getVar('no_of_men'));
                $orderhelper->set('no_of_trucks',JRequest::getVar('no_of_trucks'));
                $orderhelper->set('truck_requirments',JRequest::getVar('truck_requirments'));
                $orderhelper->set('out_of_town',JRequest::getVar('out_of_town'));
                $orderhelper->set('comments',JRequest::getVar('comments'));
            
            $hrs = JRequest::getVar('hrs');
            $mins = JRequest::getVar('mins');
            $time_option = JRequest::getVar('time_option');
                
            $departure_time = date('H:i:s', strtotime("{$hrs}:{$mins} {$time_option}"));            
            $orderhelper->set('departure_time',$departure_time);                                                                                        
                
            $order = $orderhelper;                 
            $layout= 'default_order_form';                 
                $this->setMessage("Order#".JRequest::getVar('order_no')." already exist.");
                 
                $session =& JFactory::getSession();
                $session->set('order_return', serialize($order));
                 
                                   
                   $url = $session->get('order_redirect_ur');
                   $session->clear('order_redirect_ur');                   
                   $this->setRedirect($url);
                   $this->redirect();
            }
// ================= [end] checking existing Order# ================            
                
                
                //$instruction_file = $_FILES['instruction_file'];                                                
                //start of file block
                //exit;
                // end of file block
                
                $order_no = JRequest::getVar('order_no');
                $name = JRequest::getVar('name');
                $date_order = date('Y-m-d',  strtotime(JRequest::getVar('date_order')));
                
                $type_order = JRequest::getVar('type_order');
                $type_order_other = JRequest::getVar('type_order_other');
                $type_if_other = JRequest::getVar('type_order_other');
                $no_of_men = JRequest::getVar('no_of_men');
                $no_of_trucks = JRequest::getVar('no_of_trucks');
                $truck_requirments = JRequest::getVar('truck_requirments');
                $out_of_town = JRequest::getVar('out_of_town');
                $comments = JRequest::getVar('comments');
                
                
                
                $hrs = JRequest::getVar('hrs');
                $mins = JRequest::getVar('mins');
                $time_option = JRequest::getVar('time_option');
                                
                $departure_time = date('H:i:s', strtotime("{$hrs}:{$mins} {$time_option}"));
                $deposite = JRequest::getVar('deposite');
                $is_addon = JRequest::getVar('is_addon');
                
                if($is_addon == '1')
                {                    
                    $addon_time = date('H:i:s', strtotime("{$hrs}:{$mins} {$time_option}"));
                }else{
                    $addon_time = NULL;
                }
                
                
                
                $created_by = $user->id;
                $created_date = date('Y-m-d');
                
                $parent_order= JRequest::getVar('parent_order');
                
                if(isset($parent_order) && $parent_order!=NULL)
                {
                    $order_model->_parent_order = $parent_order;
                }else{
                    $order_model->_parent_order = NULL;
                }
                
                
                
                //$is_adon_val = JRequest::getVar('is_addon_val');
                //$parent_order_val = JRequest::getVar('parent_order_val');
                if($is_addon == '1' && $parent_order!='0')
                {
                   $model_order = $this->getModel('orders');                   
                   $dep_val = '';                   
                   $p_order = $model_order->getOrderById($parent_order);
                   $p_order_dep = strtotime($p_order->departure_time);
                   $cur_adon_order_dep = strtotime($departure_time);

                   if($p_order_dep > $cur_adon_order_dep)
                   {
                       $dep_val = date('H:i:s',$cur_adon_order_dep);
                       $model_order->update_parent_order_any_field($parent_order,'departure_time',$dep_val);
                   }                   
                }
                
                $order_model->_order_no = $order_no;
                $order_model->_name=$name;
                $order_model->_date_order=$date_order;
                $order_model->_type_order=$type_order;
                $order_model->_type_if_other=$type_order_other;
                $order_model->_no_of_men=$no_of_men;
                $order_model->_no_of_trucks=$no_of_trucks;
                $order_model->_truck_requirments=$truck_requirments;
                $order_model->_out_of_town=$out_of_town;
                $order_model->_departure_time=$departure_time;
                $order_model->_deposite=$deposite;
                $order_model->_is_addon=$is_addon;
                $order_model->_addon_time=$addon_time;
                $order_model->_instruction_file=$instruction_file_name;
                $order_model->_created_by=$created_by;
                $order_model->_created_date=$created_date;                               
                $order_model->_comments=$comments;                               
                $o_n_id = $order_model->add_order();
                
                
                                                                
                
                
                // [start] file uploading ========================
               
                if( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' && !empty( $_FILES ) )
                {
                    $cntr = 0;
                    foreach( $_FILES[ 'instruction_file' ][ 'tmp_name' ] as $index => $tmpName )
                    {
                        if( !empty( $_FILES[ 'instruction_file' ][ 'error' ][ $index ] ) )
                        {
                            
                        }                        
                        // check whether it's not empty, and whether it indeed is an uploaded file
                        if( !empty( $tmpName ) && is_uploaded_file( $tmpName ) )
                        {                                                     
                            $this->uploadFile($tmpName,$_FILES[ 'instruction_file' ][ 'name' ][ $index ],$cntr,$o_n_id);                                                     
                        }
                        $cntr++;
                    }
                }

                
                // [end] file uploading ========================
                
                
                if($is_addon == '0')
                {
                    $url = JRoute::_('index.php/component/rednet/orders/?task=order_wizard').'&o_n_id='.$o_n_id.'&m='.$no_of_men.'&t='.$no_of_trucks.'&tr='.$truck_requirments.'&od='.$date_order.'&dt='.$departure_time;
                    
                    $this->setRedirect($url);
                    $this->redirect();
                }else{
                    $this->setRedirect(JRoute::_('index.php/component/rednet/orderslist'));
                    $this->redirect();
                }                
            }
            
            if(isset($action) && $action=='update')
            {                                                                                
// ================= [start] checking existing Order# ================
            
                
            if( ($flag == TRUE && (JRequest::getVar('order_no') != JRequest::getVar('order_no_same'))) || ($flag == TRUE && $order_no_check != JRequest::getVar('order_no') ) )
            {                           
                   //$url = JURI::base()."index.php/component/rednet/orders/?task=order_form&id=$id";
                   $session = JFactory::getSession();
                   $url = $session->get('order_redirect_ur');
                   $session->clear('order_redirect_ur');
                   $this->setMessage("Order#".JRequest::getVar('order_no')." already exist.");
                   $this->setRedirect($url);
                   $this->redirect();
            }
             
// ================= [end] checking existing Order# ================            
                            
                $old_file_name = JRequest::getVar('old_instruction_file');
                
                $file = $_FILES['instruction_file'];
                $file_name = $file['name'];
                $file_name_val = '';
                $files_dir = JPATH_SITE.DS.'files'.DS; 
                
                /*
                if($file_name!='')
                {
                    
                    $instruction_file = $_FILES;                
                
                    $cDateTime = date("mdYHis");                
                    $arr = explode(".", $instruction_file['instruction_file']['name']);
                            $imgfile = $cDateTime.'.'.$arr[1];
                            $uploaddir = JPATH_SITE.DS.'files'.DS;
                            $upload = $uploaddir . $imgfile;

                            if(@move_uploaded_file($instruction_file['instruction_file']['tmp_name'], $upload))
                            {
                                $instruction_file_name = $imgfile;                                
                            }
                            else{
                                echo 'Problem instuction file uploading.';
                                exit;
                            }


                    $file_name_val = $instruction_file_name;                                        
                    
                    if($old_file_name !='' || $old_file_name!=NULL)
                    {
                        if(!unlink($files_dir.$old_file_name))
                        {
                            $this->setMessage('can not delete old instruction file.');
                            $this->setRedirect(JRoute::_('index.php/component/rednet/orderslist'));
                            $this->redirect();
                            exit();
                        }                                        
                    }
                    
                }else{
                    $file_name_val = $old_file_name;
                }
                
                */
                
                
                
                $order_no = JRequest::getVar('order_no');
                $name = JRequest::getVar('name');
                $date_order = date('Y-m-d',  strtotime(JRequest::getVar('date_order')));
                
                $type_order = JRequest::getVar('type_order');
                $type_order_other = JRequest::getVar('type_order_other');
                $type_if_other = JRequest::getVar('type_order_other');
                $no_of_men = JRequest::getVar('no_of_men');
                $no_of_trucks = JRequest::getVar('no_of_trucks');
                $truck_requirments = JRequest::getVar('truck_requirments');
                $out_of_town = JRequest::getVar('out_of_town');
                
                $hrs = JRequest::getVar('hrs');
                $mins = JRequest::getVar('mins');
                $time_option = JRequest::getVar('time_option');
                                
                $departure_time = date('H:i:s', strtotime("{$hrs}:{$mins} {$time_option}"));                                
                $deposite = JRequest::getVar('deposite');
                
                $updated_date = date('Y-m-d');
                $order_id = JRequest::getVar('id');
                
                $is_addon = JRequest::getVar('is_addon');
                
                $order_model = $this->getModel('orders');
                
                $order_model->_order_no = $order_no;
                $order_model->_name=$name;
                $order_model->_date_order=$date_order;
                $order_model->_type_order=$type_order;
                $order_model->_no_of_men=$no_of_men;
                $order_model->_no_of_trucks=$no_of_trucks;
                $order_model->_truck_requirments=$truck_requirments;
                $order_model->_out_of_town=$out_of_town;
                $order_model->_departure_time=$departure_time;
                $order_model->_deposite=$deposite;
                $order_model->_is_addon=$is_addon;
                $order_model->_addon_time=$addon_time;
                $order_model->_instruction_file=$file_name_val;
                $order_model->_type_if_other=$type_if_other;
                $order_model->_order_id=$order_id;
                
                
                $comments = JRequest::getVar("comments");
                $order_model->_comments=$comments;
                
                
                $order_model->update_order();
                
                $ordersoncalendar_model = $this->getModel('ordersoncalendar');
                $addon_orders = $ordersoncalendar_model->getAdonOrders($order_id);
                
                foreach($addon_orders as $adon_order)
                {
                    $order_model->update_add_on_order_any_field($adon_order->id,'departure_time',$departure_time);
                }
                
                
                $is_adon_val = JRequest::getVar('is_addon_val');
                $parent_order_val = JRequest::getVar('parent_order_val');
                if($is_adon_val == '1' && $parent_order_val!='0')
                {
                   $model_order = $this->getModel('orders');
                   
                   $dep_val = '';
                   
                   $p_order = $model_order->getOrderById($parent_order_val);
                   $p_order_dep = strtotime($p_order->departure_time);
                   $cur_adon_order_dep = strtotime($departure_time);

                   if($p_order_dep > $cur_adon_order_dep)
                   {
                       $dep_val = date('H:i:s',$cur_adon_order_dep);
                       $model_order->update_parent_order_any_field($parent_order_val,'departure_time',$dep_val);
                   }                   
                }
                
                // [start] file uploading ========================
               
                if( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' && !empty( $_FILES ) )
                {
                   
                    $cntr = 0;
                    foreach( $_FILES[ 'instruction_file' ][ 'tmp_name' ] as $index => $tmpName )
                    {
                        if( !empty( $_FILES[ 'instruction_file' ][ 'error' ][ $index ] ) )
                        {
                            
                        }                        
                        // check whether it's not empty, and whether it indeed is an uploaded file
                        if( !empty( $tmpName ) && is_uploaded_file( $tmpName ) )
                        {                            
                            $this->uploadFile($tmpName,$_FILES[ 'instruction_file' ][ 'name' ][ $index ],$cntr,$order_id);                                                     
                        }
                        $cntr++;
                    }
                }

                
                // [end] file uploading ========================
                
                
                $this->setMessage('Order updated.');
                $this->setRedirect(JRoute::_('index.php/component/rednet/orderslist'));
                $this->redirect();
                exit();
            }
            
            exit();
            $form_data['action'] = $action;            
            $layout = 'default_order_form';            
            JRequest::setVar('layout',$layout);
            JRequest::setVar('form_data',$form_data);
            parent::display();
        }
        
        private function IsRoleNameExist($array,$name)
        {
            $item = false;
            foreach($array as $struct) {
                if ($name == $struct->name) {
                    $item = true;                    
                }
            }
            
            return $item;
        }
	
        
        private function uploadFile($tmpName,$fileName,$cntr,$order_id)
        {
                if($fileName != '')                                
                {
                
                $order_model = $this->getModel('orders');
                $instruction_file_name_unq = '';
                $instruction_file_name_orgnl = '';
                            
                    $cDateTimeX = date("Y-m-d\TH:i:s");                                    
                    $cDateTime = strtotime($cDateTimeX);                
                    $arr = explode(".", $fileName);
			$imgfile = $cDateTime.$cntr.$this->randomstring().'.'.$arr[1];
			$uploaddir = JPATH_SITE.DS.'files'.DS;
			$upload = $uploaddir . $imgfile;
                                        
                        if(@move_uploaded_file($tmpName, $upload))
			{
                            $instruction_file_name_unq = $imgfile;
                            $instruction_file_name_orgnl = $arr[0];
                            
                            //echo "** Orginal Name: ".$instruction_file_name_orgnl."<br />";
                            //echo "** Unique Name: ".$instruction_file_name_unq;
                    
                            $order_model->insert_file($order_id,$instruction_file_name_unq,$instruction_file_name_orgnl);
                            
                            //echo "<br />";
                            //echo "<br />";
			}
			else{
                            echo 'Problem instuction file uploading file.';
                            exit;
			}
                }else{
                   // echo 'in else...';
                }
                
        }
        
        private function randomstring() {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); //remember to declare $pass as an array
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, strlen($alphabet)-1); //use strlen instead of count
                $pass[$i] = $alphabet[$n];
            }                                   
            return strtolower(substr(implode($pass),0,4)); //turn the array into a string
        }
        
        public function load_order_files()
        {
            $order_id = JRequest::getVar('order_id');
            $model_order = $this->getModel('orders');
            $files = $model_order->getOrderFiles($order_id);
            echo json_encode($files);
            exit();
        }
        public  function get_orders_by_ordertype()
        {
            $order_type = JRequest::getVar('order_type');
            $order_date = JRequest::getVar('order_date');
            $thedate = JRequest::getVar('thedate');
            $order_type_code = JRequest::getVar('order_type_code');
            
            
            
            $model_order = $this->getModel('orders');
                                    
            $order_date_formated = date('Y-m-d', strtotime($order_date));
            
            $orders = $model_order->getOrderByType($order_type,$order_date_formated);            
            
            //thedate+order_type_code+""+order_countr\
            $order_cntr = count($orders)+1;
            if($order_cntr < 10)
            {
                $order_cntr = "0".$order_cntr;
            }
            
            $uniq_order_no = $thedate."".$order_type_code."".$order_cntr;
             //echo "inputed: ".$uniq_order_no."<br />";
            
            
            $orders_x = $model_order->getOrderByNo($uniq_order_no);
            
            if(count($orders_x) > 0)
            {
                echo $this->order_no_validate($uniq_order_no);
            }else{
                echo $uniq_order_no;
            }
            
          
            //echo json_encode($orders);
            exit();
        }
        
        public function order_no_validate($uniq_order_no)
        {
            // ======== if exist =======
            $model_order = $this->getModel('orders');
            $orders_x = $model_order->getOrderByNo($uniq_order_no);
            //echo count($orders_x);
            if(count($orders_x) > 0)
            {
                
                $txt=$orders_x->order_no;
                $re1='(\\d+)';	# Integer Number 1
                $re2 = "";
                if(strlen($txt) > 9)
                {
                  $re2='((?:[a-z][a-z]+))';	# Word 1  
                }
                if(strlen($txt) > 0 && strlen($txt) <=9)
                {
                    $re2='([a-z])';	# Any Single Word Character (Not Whitespace) 1
                }                                
                $re3='(\\d+)';	# Integer Number 2

                if ($c=preg_match_all ("/".$re1.$re2.$re3."/is", $txt, $matches))
                {
                    $int1=$matches[1][0];
                    $word1=$matches[2][0];
                    $int2=$matches[3][0];
                                       
                    $cntr_new = $int2+1;
                    if($cntr_new <10)
                    {
                        $cntr_new = "0$cntr_new";
                    }
                    $order_no_new = $int1.$word1.$cntr_new;
                   
                    $this->order_no_validate($order_no_new);
                   
                    return $order_no_new;
                }
                
            }else{
                return $orders_x->order_no;
            }
        }
        public function del_order_files()
        {
            $id = JRequest::getVar('id');
            $fName = JRequest::getVar('fName');
            $files_dir = JPATH_SITE.DS.'files'.DS; 
            
            $model_order = $this->getModel('orders');
                                    
            if(unlink($files_dir.$fName))
            {
                $model_order->deleteOrderFiles($id);                
            }else{
                echo "error during deletion..";
            }
            echo '1';
            exit();
        }
        
       public function sendRemovalFromJobEmail($user_id,$order_id)
       { 
           
           
                $model = $this->getModel('orders');
                $order = $model->getOrderById($order_id);
                $the_date = date('m/d/Y',strtotime($order->date_order));
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
          $subject = "RED-NET - Removal from assigned order - $worker->first_name $worker->last_name";
          $mailer->setSubject($subject);
          $body = "
                  Hi $worker->first_name $worker->last_name,<br /><br />

            You have been removed from an assigned order.<br /><br />

            Order# : $order->order_no <br />      
            Order Name: $order->name <br />
            Order Date: $the_date (mm/dd/yyyy)<br />                                                                   
                  
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
       
       public function sendRemovalOfJobEmail($user_id,$order_id)
       { 
           
           
                $model = $this->getModel('orders');
                $order = $model->getOrderById($order_id);
                $the_date = date('m/d/Y',strtotime($order->date_order));
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
          $subject = "RED-NET - Job cancelled with Order# $order->order_no - $worker->first_name $worker->last_name";
          $mailer->setSubject($subject);
          $body = "
                  Hi $worker->first_name $worker->last_name,<br /><br />

            A job has been cancelled.<br /><br />

            Order# : $order->order_no <br />      
            Order Name: $order->name <br />
            Order Date: $the_date (mm/dd/yyyy)<br />                                                                   
                  
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
       
       public function getTimeString()
       {
            $hrs = JRequest::getVar('hrs');
            $mins = JRequest::getVar('mins');
            $time_option = JRequest::getVar('time_option');
                
            $departure_time = date('H:i:s', strtotime("{$hrs}:{$mins} {$time_option}"));            
            echo $departure_time;
            exit;
       }
}// class
?>
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
        
        
        public function __construct($config = array ()) 
	{
                $this->_user = JFactory::getUser();                
                
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);
                
                $db = JFactory::getDbo();                
                
                
                
                
                
           // ==================== Updating the resources status =====================                                           
           $action = JRequest::getVar('action');           
           
           if(isset($action) && $action == 'update_resource_status')
           {
                $rs_id = JRequest::getVar('rs_id');               
                $update_value = JRequest::getVar('confirm_order');                
                $resource_model = $this->getModel('resourcesmap');                         
                $resource_model->update_resource_status($rs_id,$update_value);           
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
                        
                        $ad_on_orders = $model_orders->getAdOnOrderById($id);
                        
                        $order = $model_orders->getItem($order_id);                        
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
                        $all_loaders = $worker_model->getAllLoaders();                        
                                                
                        $model_resourcesmap = $this->getModel('resourcesmap');
                        $resources = $model_resourcesmap->get_resourcesmap_by_order_id($order_id);
                        
                        
                        $model = $this->getModel('fleet');
                        $fleets = $model->getFleets();
                        $rentals = $model->getRentals();

                        
                        JRequest::setVar('resources', $resources);
                        JRequest::setVar('fleets', $fleets);
                        JRequest::setVar('rentals', $rentals);
                        JRequest::setVar('all_loaders', $all_loaders);
                        JRequest::setVar('workers_on_order_date', $workers_on_order_date);                                               
                        JRequest::setVar('ad_on_orders', $ad_on_orders);                                               
                }
                
                
                $order_id = JRequest::getVar('order_id');
                $order_no_rs = JRequest::getVar('order_no_rs');
                $order_name_rs = JRequest::getVar('order_name_rs');
                $date_order_rs = JRequest::getVar('date_order_rs');                                
                $submit_value = JRequest::getVar('submit');
                                 
                if(isset($order_id) && $order_id != NULL && $submit_value == "Save")
                {
                    $ad_on_order_id = JRequest::getVar('ad_on_order_id');                        
                    $date_order = JRequest::getVar('date_order');
                    $workers = JRequest::getVar('workers');
                    $trucks = JRequest::getVar('trucks');
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
                    //========= Assigning Resources ===========
                    
                    $this->assign_resources($workers,$trucks,$w_roles,$order_id);
                    
                    if($ad_on_order_id!=NULL)
                    {
                        foreach($ad_on_order_id as $order_ad_id)
                        {
                            $this->assign_resources($workers,$trucks,$w_roles,$order_ad_id);
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
                    
                    // 2 - restoring user calender availbity
                    if($type=='worker')
                    {
                        $av_model = $this->getModel('availabilitycalendar');
                        if($data['worker_id']!='0')
                            $av_model->add_availabilitycalendar_complete($data['worker_id'],$data['order_date']);
                    }
                    
                    $this->setMessage("Ressources resoted successfuly.");
                    $url = JURI::base()."index.php/component/rednet/orders/?id=$data[ord_id]";
                    $this->setRedirect($url);
                    $this->redirect();
                    
                }                
	}
	
        
       private function assign_resources($workers,$trucks,$w_roles,$order_id)
       {
           $rs_id=0;
           $w_cntr = 0;
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
                            $resources_model->_status = '';                                                                                                                        
                            $resources_model->add_resourcesmap();
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
          $subject = "RED-NET - New Order Assigned";
          $mailer->setSubject($subject);
          $body = "
                  Hi $worker->first_name $worker->last_name,<br /><br />

            You have assign an order.<br /><br />

            Order# : $order_no_rs <br />      
            Order Name: $order_name_rs <br />
            Order Date: $date_order_rs (mm/dd/yyyy)<br />
                        
            <a href='".JURI::base()."index.php/component/rednet/orders/?task=update_resource_status&r=$rs_id&u_v=1'>Click here to confirm order.</a>  
                  
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
           $form_data['rs_id']=$rs_id;           
           $layout = "update_resource_status";
           JRequest::setVar('layout',$layout);
           JRequest::setVar('form_data',$form_data);
           parent::display();
           
       }
       
        public function del_resource($id)
        {
            $db = JFactory::getDbo();
            $qry="DELETE FROM #__resourcesmap WHERE id = $id";
            $db->setQuery($qry);
            $db->query() or die(mysql_error());
        }

	public function order_form()
        {
                                    
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
            
            $order_model->_order_id = $id;            
            $order_model->delete_order();
            
            $this->setMessage("Order deleted.");
            $this->setRedirect(JRoute::_('index.php/component/rednet/orderslist'));
            $this->redirect();            
        }
	public function order_form_save()
        {
            $user = $this->_user;            
            $order_model = $this->getModel('orders');
            
            $id = JRequest::getVar('id');
            $action = JRequest::getVar('action');            
            $form_data = array();
            
            if(isset($action) && $action=='add')
            {
                $instruction_file = $_FILES;                
                
                
                //start of file block
                if($instruction_file['name'] != NULL)
                {
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
                            echo 'Problem instuction file uploading file.';
                            exit;
			}
                }
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
                $o_n_id = $order_model->add_order();
                
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
                
                $old_file_name = JRequest::getVar('old_instruction_file');
                
                $file = $_FILES['instruction_file'];
                $file_name = $file['name'];
                $file_name_val = '';
                $files_dir = JPATH_SITE.DS.'files'.DS; 
                
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
                
                $order_model->update_order();
                
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
	
}// class
?>
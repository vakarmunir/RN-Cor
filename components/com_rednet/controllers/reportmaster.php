<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Controllers
* @copyright	Copyright (C) 2013, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.database.database');

/**
 * RednetReportmaster Controller
 *
 * @package    Rednet
 * @subpackage Controllers
 */
class RednetControllerReportmaster extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'reportmaster'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);
                
                
                
                
                
                $data = array();
                $worker_model = $this->getModel('workers');                                
                $workers = $worker_model->getAllActiveWorkers();                                                
                $data['workers'] = $workers;
                
                
                $model_order = $this->getModel('orders');
                $all_orders = $model_order->getAllOrders();
                
                //var_dump($all_orders);
                $model = $this->getModel('reportmaster');
                $order_id = JRequest::getVar("order_id");
                
                
                
                
                if(isset($order_id))
                {
                    $reportmaster = $model->getReportmasterByOrderId($order_id);
                    if(isset($reportmaster))
                    {
                        $reportclients = $model->getReportClientsByOrderReportId($reportmaster->id);                
                        $reportdetail = $model->getReportDetailsByOrderReportId($reportmaster->id);
                        $reporthowpaid = $model->getReportHowPaid($reportmaster->id);

                        
                        
                        $order = $model_order->getOrderById($reportmaster->order_id);                   

                        $data['order'] = $order;
                        $data['reportmaster'] = $reportmaster;
                        $data['reportclients'] = $reportclients;
                        $data['reportdetail'] = $reportdetail;
                        $data['reporthowpaid'] = $reporthowpaid;
                    }
                    
                }
                
                
                JRequest::setVar('data',$data);
                JRequest::setVar('all_orders',$all_orders);
                                
	}
	
        public function approve_report()
        {
            $layout = "default_approve_report";
            $data = array();
            
            $task = JRequest::getVar("task");
            $un_approve = JRequest::getVar("un_approve");
            
            $model = $this->getModel('reportmaster');
            $reportmaster = $model->getReportFilterd();
                
            //echo count($reportmaster);
            
            //$url = JURI::base()."index.php/component/rednet/reportmaster/?task=approve_report";
            $data['reportmaster'] = $reportmaster;
            $data['un_approve'] = $un_approve;
            
            JRequest::setVar('layout',$layout);
            
            JRequest::setVar('task',$task);
            JRequest::setVar('data',$data);
            parent::display();
        }
        
        public function approve_report_save()
        {
          //echo "saving..";
            
            $report_ids = JRequest::getVar('report_id');
            $model = $this->getModel("reportmaster");
            foreach ($report_ids as $report_id) {
                
                $is_paid = JRequest::getVar("is_paid_$report_id");
                
                if($is_paid == '1')
                {
                    $model->updateReportByField('is_paid','1',$report_id);
                }else{
                    $model->updateReportByField('is_paid','0',$report_id);
                }
                
                $is_approved = JRequest::getVar("is_approved_$report_id");                                
                if($is_approved == '1')
                {
                    $model->updateReportByField('is_approved','1',$report_id);
                }else{
                    $model->updateReportByField('is_approved','0',$report_id);
                }
                
                $is_discount = JRequest::getVar("is_discount_$report_id");                                                                
                
                if($is_discount == '1')
                {                    
                    $model->updateReportByField('is_discount','1',$report_id);                    
                }else{                    
                    $model->updateReportByField('is_discount','0',$report_id);
                }
            }
            
            $message = "Report(s) updated.";
            
            
            $this->setMessage($message);
            $url = JURI::base()."index.php/component/rednet/reportmaster/?task=approve_report";
            $this->setRedirect($url);
            $this->redirect();
          
        }
        
        public function report_save()
        {
            //echo "saving..";            
            $user_current = JFactory::getUser();
            
            $order_id = JRequest::getVar('order_id');
            $report_id = JRequest::getVar('report_id');
            $order_no = JRequest::getVar('order_no');
            $name = JRequest::getVar('name');
            $date_order = JRequest::getVar('date_order');
            $departure_time = JRequest::getVar('departure_time');
            $return_time = JRequest::getVar('return_time');
            $total_work_hours_billed = JRequest::getVar('total_work_hours_billed');
            $dpt_time = JRequest::getVar('dpt_time');
            $travel_leak = JRequest::getVar('travel_leak');
            $total_travel = JRequest::getVar('total_travel');
            $paid_hours = JRequest::getVar('paid_hours');
            $total_invoice_amount = JRequest::getVar('total_invoice_amount');
            $total_invoice_amount_sum = 0;
            $credit_card = JRequest::getVar('credit_card');
            $debit_card = JRequest::getVar('debit_card');
            $cheques = JRequest::getVar('cheques');
            $cash = JRequest::getVar('cash');
            $outstanding = JRequest::getVar('outstanding');
            $hst = JRequest::getVar('hst');
            $damage = JRequest::getVar('damage');
            $client_name = JRequest::getVar('client_name');
            $client_start = JRequest::getVar('client_start');
            $client_end = JRequest::getVar('client_end');
            $travel = JRequest::getVar('travel');
            $o_id = JRequest::getVar('o_id');
            $user_id = JRequest::getVar('user_id');
            $role = JRequest::getVar('role');
            $hours = JRequest::getVar('hours');
            $invoice = JRequest::getVar('invoice');
            $tip_allow = JRequest::getVar('tip_allow');
            $tip_amount = JRequest::getVar('tip_amount');
            $flag = JRequest::getVar('flag');
            $bonus = JRequest::getVar('bonus');                        
            $comments = JRequest::getVar('comments');                        
            $comments_job = JRequest::getVar('comments_job');                        
            $net = JRequest::getVar('net');                        
            $tip_on_invoice = JRequest::getVar('tip_on_invoice');                        
            //var_dump($invoice);
            $flag_job = JRequest::getVar('flag_job');
            
            $flag_job_val = (isset($flag_job) && $flag_job=='on')?("1"):("0");
            
            
            
            $mode = JRequest::getVar('mode');
            
            
            
            $model = $this->getModel('reportmaster');
            
            
            //$total_invoice_amount = JRequest::getVar("total_invoice_amount");
            
            
            
            if($mode=='edit')
            {
                $model->deleteReportByOrderId($order_id);
                $model->deleteReportClientsByReportId($report_id);                
                $model->deleteReportDetailByReportId($report_id);
                $model->delete_report_how_paid($report_id);
            }
            
            $dept_time_array = explode(":", $departure_time);            
            $dept_time_array_x = explode(" ", $dept_time_array[1]);            
            $hrs = $dept_time_array[0];
            $mins = $dept_time_array_x[0];
            $time_option = $dept_time_array_x[1];                
            $departure_time_formated = date('H:i:s', strtotime("{$hrs}:{$mins} {$time_option}"));            
            
            
            $return_time_array = explode(":", $return_time);
            $return_time_array_x = explode(" ", $return_time_array[1]);
            $hrs_rt = $return_time_array[0];
            $mins_rt = $return_time_array_x[0];
            $time_option_rt = $return_time_array_x[1];    
            $return_time_formated = date('H:i:s', strtotime("{$hrs_rt}:{$mins_rt} {$time_option_rt}"));

            $total_work_hours_billed_array = explode(":", $total_work_hours_billed);
            $total_work_hours_billed_array_x = explode(" ", $total_work_hours_billed_array[1]);
            $hrs_whb = $total_work_hours_billed_array[0];
            $mins_whb = $total_work_hours_billed_array_x[0];
            $time_option_whb = $total_work_hours_billed_array_x[1];    
            $total_work_hours_billed_formated = date('H:i:s', strtotime("{$hrs_whb}:{$mins_whb} {$time_option_whb}"));

            $paid_hours_array = explode(":", $paid_hours);
            $paid_hours_array_x = explode(" ", $paid_hours_array[1]);
            $hrs_ph = $paid_hours_array[0];
            $mins_ph = $paid_hours_array_x[0];
            $time_option_ph = $paid_hours_array_x[1];    
            $paid_hours_formated = date('H:i:s', strtotime("{$hrs_ph}:{$mins_ph} {$time_option_ph}"));

            
            $total_travel_array = explode(":", $total_travel);
            $total_travel_array_x = explode(" ", $total_travel_array[1]);
            $hrs_tt = $total_travel_array[0];
            $mins_tt = $total_travel_array_x[0];
            $time_option_tt = $total_travel_array_x[1];    
            $total_travel_formated = date('H:i:s', strtotime("{$hrs_tt}:{$mins_tt} {$time_option_tt}"));

            $travel_leak_array = explode(":", $travel_leak);
            $travel_leak_array_x = explode(" ", $travel_leak_array[1]);
            $hrs_tl = $travel_leak_array[0];
            $mins_tl = $travel_leak_array_x[0];
            $time_option_tl = $travel_leak_array_x[1];    
            //$travel_leak_formated = date('H:i:s', strtotime("{$hrs_tl}:{$mins_tl} {$time_option_tl}"));
            $travel_leak_formated = $travel_leak;
            
            $dpt_time_array = explode(":", $dpt_time);
            $dpt_time_array_x = explode(" ", $dpt_time_array[1]);
            $hrs_dt = $dpt_time_array[0];
            $mins_dt = $dpt_time_array_x[0];
            $time_option_dt = $dpt_time_array_x[1];    
            $dpt_time_formated = date('H:i:s', strtotime("{$hrs_dt}:{$mins_dt} {$time_option_dt}"));
            
            
            
            $model->order_id = $order_id;
            $model->departure_time = $departure_time_formated;
            $model->return_time = $return_time_formated;
            $model->total_work_hours_billed = $total_work_hours_billed_formated;
            $model->paid_hours = $paid_hours_formated;
            $model->total_travel = $total_travel_formated;
            $model->travel_leak = $travel_leak_formated;
            $model->dpt_time = $dpt_time_formated;
            
            
            
            $model->comments_job = $comments_job;
            $model->flag_job = $flag_job_val;

            $report_id = $model->insert();
             
            $cntr_oId = 0;
            foreach ($o_id as $oId)
            {
                
                $client_start_array = explode(":", $client_start[$cntr_oId]);
                $client_start_array_x = explode(" ", $client_start_array[1]);
                $hrs_cs = $client_start_array[0];
                $mins_cs = $client_start_array_x[0];
                $time_option_cs = $client_start_array_x[1];    
                $client_start_formated = date('H:i:s', strtotime("{$hrs_cs}:{$mins_cs} {$time_option_cs}"));
                
                $client_end_array = explode(":", $client_end[$cntr_oId]);
                $client_end_array_x = explode(" ", $client_end_array[1]);
                $hrs_ce = $client_end_array[0];
                $mins_ce = $client_end_array_x[0];
                $time_option_ce = $client_end_array_x[1];    
                $client_end_formated = date('H:i:s', strtotime("{$hrs_ce}:{$mins_ce} {$time_option_ce}"));                                
                
                $travel_array = explode(":", $travel[$cntr_oId]);
                $travel_array_x = explode(" ", $travel_array[1]);
                $hrs_trvl = $travel_array[0];
                $mins_trvl = $travel_array_x[0];
                $time_option_trvl = $travel_array_x[1];    
                $travel_formated = date('H:i:s', strtotime("{$hrs_trvl}:{$mins_trvl} {$time_option_trvl}"));

                $model->insertReportClient($report_id,$oId,$client_start_formated,$client_end_formated,$travel_formated);
                
                $cntr_oId++;
            }
            
            $o_id_crnt_x=0;
            foreach ($o_id as $oid)
            {                                
                $model->insert_report_how_paid($oid,$report_id,$total_invoice_amount[$o_id_crnt_x],$credit_card[$o_id_crnt_x],$debit_card[$o_id_crnt_x],$cheques[$o_id_crnt_x],$cash[$o_id_crnt_x],$outstanding[$o_id_crnt_x],$hst[$o_id_crnt_x],$damage[$o_id_crnt_x],$tip_on_invoice[$o_id_crnt_x],$net[$o_id_crnt_x]);                
                $total_invoice_amount_sum = $total_invoice_amount_sum + $total_invoice_amount[$o_id_crnt_x];
                $o_id_crnt_x++;
            }
            
            $cntr_userId = 0;
            
            $workers_email_array = array();
            
            foreach($user_id as $userId)
            {
                $invoice_val = ($invoice[$cntr_userId] == 'on')?('1'):('0');
                $flag_val = ($flag[$cntr_userId] == 'on')?('1'):('0');
                
                $hours_array = explode(":", $hours[$cntr_userId]);
                $hours_array_x = explode(" ", $hours_array[1]);
                $hrs_hrsvl = $hours_array[0];
                $mins_hrsvl = $hours_array_x[0];
                $time_option_hrsvl = $hours_array_x[1];    
                $hours_formated = date('H:i:s', strtotime("{$hrs_hrsvl}:{$mins_hrsvl} {$time_option_hrsvl}"));

                $model->insertReportDetail($report_id,$userId,$role[$cntr_userId],$hours_formated,$invoice_val,$tip_allow[$cntr_userId],$tip_amount[$cntr_userId],$flag_val,$bonus[$cntr_userId],$comments[$cntr_userId]);
                
                //============== code send invoice ====================
                // === sending invoice from worker to invoice.cc@gmail.com
                if($invoice_val == '1')
                {
                    $grand_total = $total_invoice_amount_sum+($total_invoice_amount_sum*(13/100));
                    $this->sendInvoice($userId,$order_id,$user_current->id,$date_order,$hours_formated,$cash[$cntr_userId],$paid_hours,$tip_on_invoice,$total_invoice_amount_sum,$hst,$grand_total);
                   
                    //$user_wrkr = JFactory::getUser($userId);
                    //array_push($workers_email_array, $user_wrkr->email);
                }
                
                // === sending invoice from admin to workers =========
                if($invoice_val == '1')
                {
                    $grand_total = $total_invoice_amount_sum+($total_invoice_amount_sum*(13/100));
                    $this->sendInvoiceToWorkers($userId,$order_id,$user_current->id,$date_order,$hours_formated,$cash[$cntr_userId],$paid_hours,$tip_on_invoice,$total_invoice_amount_sum,$hst,$grand_total);
                   
                }
             
                //======== code send fallged report by worker =========
                
                if($flag_val == '1')
                {
                    $grand_total = $total_invoice_amount_sum+($total_invoice_amount_sum*(13/100));
                    
                    $model_worker = $this->getModel("workers");                
                    $admin_users = $model_worker->getWorkersByRoleName("admin");                
                    $admin_id_array = array();
                    $cntr = 1;
                    foreach ($admin_users as $admin)
                    {

                        array_push($admin_id_array, $admin->user_id);
                        $cntr++;
                    }
                    
                    $admin_ids_uniq = array_unique($admin_id_array);
                    foreach ($admin_ids_uniq as $admin_id) {                        
                        $this->sendFalgEmail($userId,$order_id,$admin_id);
                    }
                                        
                }
                
                
                $cntr_userId++;
            }
            
            $model_worker = $this->getModel("workers");                
            $admin_users = $model_worker->getWorkersByRoleName("admin");                
            $admin_id_array = array();
            $cntr = 1;
            foreach ($admin_users as $admin)
            {

               array_push($admin_id_array, $admin->user_id);
               $cntr++;
            }
                    
            if($flag_job_val == '1')
            {
                $admin_ids_uniq = array_unique($admin_id_array);
                
                foreach ($admin_ids_uniq as $admin_id) {
                    $this->sendFalgEmailJob(0,$order_id,$admin_id);
                }                
            }
            
            $msg="Report Created.";            
            $this->setMessage($msg);
            $url = JURI::base()."index.php/component/rednet/reportmaster";
            $this->setRedirect($url);
            $this->redirect();
            exit();
        }

        public function search_order()
        {            
            $morder_list_model = $this->getModel('orderslist');
            $order = $morder_list_model->searchOrder();
            $rcd = array();
            $rcd['id'] = "NULL";
            if($order!=NULL)
            {
                echo json_encode($order);
            }else{
                echo json_encode($rcd);
            }             
            
            exit();
        }
        
	public function search_order_by_field()
        {  
            
            $model = $this->getModel('orders');
            
            $order_no = JRequest::getVar('order_no');
            
            if(isset($order_no))
            {
                //var_dump($order_no);
                $orders = $model->getAllOrdersByField('order_no',$order_no);
                //var_dump($orders);
                echo json_encode($orders);
            }
            
            $order_name = JRequest::getVar('name');            
            if(isset($order_name))
            {
                //var_dump($order_no);
                $orders = $model->getAllOrdersByField('name',$order_name);
                //var_dump($orders);
                echo json_encode($orders);
            }
            
            $date_order = JRequest::getVar('date_order');            
            if(isset($date_order))
            {
                //var_dump($order_no);                
                $orders = $model->getAllOrdersByField( 'date_order', date('Y-m-d',strtotime($date_order)) );
                //var_dump($orders);
                echo json_encode($orders);
            }
            
           
            //echo json_encode($dt);
            exit();
            
            $morder_list_model = $this->getModel('orderslist');
            $order = $morder_list_model->searchOrders();
            $rcd = array();
            $rcd['id'] = "NULL";
            if($order!=NULL)
            {
                echo json_encode($order);
            }else{
                echo json_encode($rcd);
            }             
            
            exit();
        }
        
        
        public function get_order_assigned_workers()
        {
            $id = JRequest::getVar('order_id');
            $model_orders = $this->getModel('orders');            
            $model_workers = $this->getModel('workers');            
            $all_assigned_workers = $model_orders->getAllAssignedWorkerByOrderId($id);                       
            $rsltnt_workers = array();
            foreach ($all_assigned_workers as $worker)
            {                
                $user_wx = $model_workers->getWorkerById($worker->user_id);                                
                $worker_object = new JObject();
                foreach($worker as $attr=>$w_obj)
                {                  
                  $worker_object->set($attr,$w_obj);
                }                
                $worker_object->set("user_complete_name",$user_wx->first_name.' '.$user_wx->last_name);                
                
                array_push($rsltnt_workers, $worker_object);
            }
            
            echo json_encode($rsltnt_workers);            
            exit;
        }
	
        public function get_order_and_adons()
        {
            $id = JRequest::getVar('order_id');
            $model_orders = $this->getModel('orders');            
            
            
            $order = $model_orders->getOrderById($id);
            $order_adons = $model_orders->getAdOnOrderById($id);
            
            $order_data = array(
                'order'=>$order,
                'order_adons'=>$order_adons
                );
            echo json_encode($order_data);            
            exit;
        }
	
        public function get_reportmaster_by_order_id()
        {
            $order_id = JRequest::getVar("order_id");
            $model = $this->getModel('reportmaster');
            $reportmaster = $model->getReportmasterByOrderId($order_id);
            $obj = new JObject;
            $obj->set('order_id',0);
            if(isset($reportmaster))
            {
                echo json_encode($reportmaster);
            }else
            {
                echo json_encode($obj);
            }
            
            exit();
        }
        
         
       public function sendInvoice($user_id,$order_id,$admin_id,$date_order,$hours,$rate,$hourly_pay,$tip,$total,$hst,$grand_total,$workers_email=array())
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
          $admin_user = JFactory::getUser($admin_id);
          $admin_email = $admin_user->email;
          
          $worker_model = $this->getModel('workers');
          $worker = $worker_model->getWorkerById($user_id);
          $admin_worker = $worker_model->getWorkerById($admin_id);
                              
          $mailer = JFactory::getMailer();
          $from = array($admin_email,"Red-Net");
          $mailer->setSender($from);
          
          $recipients = array($config->invoice_address);
          if(count($workers_email) > 0)
          {
              $recipients = $workers_email;
          }                    
          $mailer->addRecipient($recipients);
          $mailer->addRecipie;
          $subject = "RED-NET - Contract Worker Invoice - $worker->first_name $worker->last_name";
          $mailer->setSubject($subject);
          $body = "                  
            <table width='250' border='0'>
  <tr>
    <td>From:</td>
    <td>$worker->first_name $worker->last_name</td>
  </tr>
  <tr>
    <td>For :</td>
    <td>Crew Chief Services</td>
  </tr>
  <tr>
    <td>Date:</td>
    <td>$date_order</td>
  </tr>
  <tr>
    <td>Hours:</td>
    <td>$hours</td>
  </tr>
  <tr>
    <td>Rate:</td>
    <td>$rate</td>
  </tr>
  <tr>
    <td>Hourly Pay:</td>
    <td>$hourly_pay</td>
  </tr>
  <tr>
    <td>Tip on vis:</td>
    <td>$tip</td>
  </tr>
  <tr>
    <td>Total:</td>
    <td>$total</td>
  </tr>
  <tr>
    <td>HST:</td>
    <td>$hst</td>
  </tr>
  <tr>
    <td>Grand Total:</td>
    <td>$grand_total</td>
  </tr>
  
</table>
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
       
       public function sendInvoiceToWorkers($user_id,$order_id,$admin_id,$date_order,$hours,$rate,$hourly_pay,$tip,$total,$hst,$grand_total,$workers_email=array())
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
          $admin_user = JFactory::getUser($admin_id);
          $admin_email = $admin_user->email;
          
          $worker_model = $this->getModel('workers');
          $worker = $worker_model->getWorkerById($user_id);
          $admin_worker = $worker_model->getWorkerById($admin_id);
                              
          $mailer = JFactory::getMailer();
          $from = array($admin_email,"Red-Net");
          $mailer->setSender($from);
          
          $recipients = array($user->email);
          
          $mailer->addRecipient($recipients);
          $mailer->addRecipie;
          $subject = "RED-NET - Contract Worker Invoice - $worker->first_name $worker->last_name";
          $mailer->setSubject($subject);
          $body = "                  
            <table width='250' border='0'>
  <tr>
    <td>From:</td>
    <td>$admin_worker->first_name $admin_worker->last_name</td>
  </tr>
  <tr>
    <td>For :</td>
    <td>Crew Chief Services</td>
  </tr>
  <tr>
    <td>Date:</td>
    <td>$date_order</td>
  </tr>
  <tr>
    <td>Hours:</td>
    <td>$hours</td>
  </tr>
  <tr>
    <td>Rate:</td>
    <td>$rate</td>
  </tr>
  <tr>
    <td>Hourly Pay:</td>
    <td>$hourly_pay</td>
  </tr>
  <tr>
    <td>Tip on vis:</td>
    <td>$tip</td>
  </tr>
  <tr>
    <td>Total:</td>
    <td>$total</td>
  </tr>
  <tr>
    <td>HST:</td>
    <td>$hst</td>
  </tr>
  <tr>
    <td>Grand Total:</td>
    <td>$grand_total</td>
  </tr>
  
</table>
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
       
       public function sendFalgEmail($user_id,$order_id,$admin_id)
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
          $current_user = JFactory::getUser();
          $admin_user = JFactory::getUser($admin_id);
          $admin_email = $admin_user->email;
          
          $worker_model = $this->getModel('workers');
          $worker = $worker_model->getWorkerById($user_id);
          $admin_worker = $worker_model->getWorkerById($admin_id);
                              
          $mailer = JFactory::getMailer();
          
          $current_user = JFactory::getUser();
          
          $from = array($current_user->email,"Red-Net");
          $mailer->setSender($from);
          $recipients = array($admin_user->email);
          $mailer->addRecipient($recipients);
          $mailer->addRecipie;
          $subject = "RED-NET - Red-Net Worker Flag – ($worker->first_name $worker->last_name)";
          $mailer->setSubject($subject);
          $body = "                  
              

<p>Attention $admin_worker->first_name $admin_worker->last_name</p>    
<p>
    Worker '$worker->first_name $worker->last_name', the '$order->name' order on '".date("m/d/Y",strtotime($order->date_order))."' has been flagged.  Please follow this link for additional details.
</p>
<p>
    <a href='".JURI::base()."index.php/component/rednet/reportmaster/?order_id=$order_id&u_v=1&user=$admin_user->username&passw=$admin_user->password'>Click here for report detail.</a>  
</p>
          "          
        ;
          
          /*
                       <table width='250' border='0'>
  <tr>
    <td>Order#:</td>
    <td>$order->order_no</td>
  </tr> 
  
  <tr>
    <td>Customer:</td>
    <td>$order->name</td>
  </tr> 
  
  <tr>
    <td>Worker:</td>
    <td>$worker->first_name $worker->last_name</td>
  </tr> 
  
  
</table> 
           
           */
          
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
       public function sendFalgEmailJob($user_id,$order_id,$admin_id)
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
          $current_user = JFactory::getUser();
          $admin_user = JFactory::getUser($admin_id);
          $admin_email = $admin_user->email;
          
          $worker_model = $this->getModel('workers');
          $worker = $worker_model->getWorkerById($user_id);
          $admin_worker = $worker_model->getWorkerById($admin_id);
                              
          $mailer = JFactory::getMailer();
          
          $current_user = JFactory::getUser();
          
          $from = array($current_user->email,"Red-Net");
          $mailer->setSender($from);
          $recipients = array($admin_user->email);
          $mailer->addRecipient($recipients);
          $mailer->addRecipie;
          $subject = "RED-NET - Red-Net Job Flag – ($order->name)";
          $mailer->setSubject($subject);
          $body = "                  
              

    <p>
    Attention '$admin_worker->first_name $admin_worker->last_name',
    </p>
<p>
     The '$order->name' order on '".date("m/d/Y",strtotime($order->date_order))."' has been flagged.  Please follow this link for additional details.
</p>

<p>
<a href='".JURI::base()."index.php/component/rednet/reportmaster/?order_id=$order_id&u_v=1&user=$admin_user->username&passw=$admin_user->password'>Click here for report detail.</a>  
</p>
          "          
        ;
          //echo $body;
          
          /*
           
                       <table width='250' border='0'>
  <tr>
    <td>Order#:</td>
    <td>$order->order_no</td>
  </tr> 
  
  <tr>
    <td>Customer:</td>
    <td>$order->name</td>
  </tr> 
  
  <tr>
    <td>Worker:</td>
    <td>$worker->first_name $worker->last_name</td>
  </tr> 
  
  
</table> 
           
           */
          
          $mailer->IsHTML(true);
          $mailer->Encoding = 'base64';
          $mailer->setBody($body);
          $send = $mailer->Send();
            if ( $send !== true ) {
                $msg = 'Error sending order confirmation email to worker.';
                $this->setMessage($msg.$body);            
            }                         
       }
       
       public function calc_leak()
       {
           
           
           $time1 = JRequest::getVar('time1').":00";
           $time2 = JRequest::getVar('time2').':00';
           
           //echo $time1;
           //echo '<br />';
           
           $rslt = $this->get_time_difference($time1, $time2);
           
           $data = array("rslt"=>$rslt);
           
           echo json_encode($data);
           exit;
       }
       
       public function get_time_difference($time1, $time2) {
                $date = date("Y-m-d H:i:s",strtotime("2013-04-13 $time2"));
                $date_x = date("Y-m-d H:i:s", strtotime("2013-04-13 $time1"));

           
                $Total_shift_time = strtotime($date_x) - strtotime($date);
                
                $hours=floor($Total_shift_time/3600);
                $Total_shift_time-=$hours*3600;
                $minutes=floor($Total_shift_time/60);
                $Total_shift_time-=$minutes*60;
                            $seconds=$Total_shift_time;
                            $Total_shift_time=$hours.":".$minutes.":".$seconds;

                return "$Total_shift_time";
       }
        
       public function sum_the_time($time1, $time2) 
       {
            $times = array($time1, $time2);
            $seconds = 0;
            foreach ($times as $time)
            {
              list($hour,$minute,$second) = explode(':', $time);
              $seconds += $hour*3600;
              $seconds += $minute*60;
              $seconds += $second;
            }
            $hours = floor($seconds/3600);
            $seconds -= $hours*3600;
            $minutes  = floor($seconds/60);
            $seconds -= $minutes*60;
            //return "$hours:$minutes:$seconds";
            return "{$hours}:{$minutes}".":00";
            //return "{$hours}:{$minutes}:{$seconds}";
            //return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
          }
       public function diff_the_time($time1, $time2) 
       {
            $times = array($time1, $time2);
            $seconds = 0;
            foreach ($times as $time)
            {
              list($hour,$minute,$second) = explode(':', $time);
              $seconds -= $hour*3600;
              $seconds -= $minute*60;
              $seconds -= $second;
            }
            $hours = floor($seconds/3600);
            $seconds += $hours*3600;
            $minutes  = floor($seconds/60);
            $seconds += $minutes*60;
            //return "$hours:$minutes:$seconds";
            return "{$hours}:{$minutes}".":00";
            //return "{$hours}:{$minutes}:{$seconds}";
            //return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
          }
}// class
?>
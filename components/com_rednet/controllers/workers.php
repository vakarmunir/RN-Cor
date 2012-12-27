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
 * RednetWorkers Controller
 *
 * @package    Rednet
 * @subpackage Controllers
 */
class RednetControllerWorkers extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'workers'; 
	protected $_user = null;
	protected $session = null;
        
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
                
                $this->session = JFactory::getSession();
		JRequest :: setVar('view', $this->_viewname);
                $user = JFactory::getUser();
                $this->_user = $user;
                
               
	}
	
        public function filter_worker()
        {
            
           $data = JRequest::get();
            
           $layout = "default_filter_worker"; 
           
           $model = $this->getModel("workers");
           
           $worker = $model->getFilteredWorkers($data);
           
           //var_dump($worker);
           JRequest::setVar('worker',$worker);
           JRequest::setVar('layout',$layout);           
           parent::display();
        }
        
        
        public function get_all_workers()
        {
            $model = $this->getModel("workers");
            $workers = $model->getAllWorkers();
            
            
            //header("Content-type: text/xml;charset=utf-8");
            
            $document =& JFactory::getDocument();
            $document->setMimeEncoding( 'text/xml' );
 
            $page = 1;
            $total_pages = 2;
            $count = 50;
            
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
            foreach($workers as $worker)
            {
                
                $s .= "<row id='". $worker->id."'>";  
                $s .= "<cell>". $worker->name."</cell>";
               $s .= "<cell><![CDATA[". $worker->email."]]></cell>";
                $s .= "</row>";
            }
            
            $s .= "</rows>"; 
            
            echo $s;
            exit();
        }
        
	public function add_worker()
        {
            
            $msg = "";            
            $layout = "default_add_worker";
            
            
            $model = $this->getModel('workers');
            
            $primary_roles = $model->getAllRolesByType('primary');
            $secondary_roles = $model->getAllRolesByType('secondary');
            $additional_roles = $model->getAllRolesByType('additional');
            
            
            
            JRequest::setVar('primary_roles', $primary_roles);
            JRequest::setVar('secondary_roles', $secondary_roles);
            JRequest::setVar('additional_roles', $additional_roles);
            JRequest::setVar('msg', $msg);
            JRequest::setVar('layout',$layout);
            
            parent::display();
        }
        
        
        
       public function ask_password_change()
       {
                        
              
           $layout = "default_change_password";
           JRequest::setVar('layout',$layout);
           parent::display();
                      
       }
       
       public function update_personal_info()
       {
           $layout = "default_update_personal_info";           
           $user = JFactory::getUser();
            $user_id = $user->id;           
           $model = $this->getModel('workers');
           $worker = $model->getWorkerById($user_id); 
           
            $worker_roles = $model->getWorkerRolesIndexs($user_id);
        
           
            $primary_roles = $model->getAllRolesByType('primary');
            $secondary_roles = $model->getAllRolesByType('secondary');
            $additional_roles = $model->getAllRolesByType('additional');
            
           
            
            JRequest::setVar('primary_roles', $primary_roles);
            JRequest::setVar('secondary_roles', $secondary_roles);
            JRequest::setVar('additional_roles', $additional_roles);
           
          
           
           
           JRequest::setVar('worker_roles',$worker_roles);
           
           
           JRequest::setVar('worker',$worker);
           JRequest::setVar('layout',$layout);
           
           parent::display();
       }
               
       public function update_personal_info_save()
       {
           
           $user = JFactory::getUser();
           $userId = $user->id;           
           $data = JRequest::get();
           
        
           $model = $this->getModel('workers');
           $model->updateWorkerPersonalInfo($data);            
           $msg = "Personal information is saved.";
           $this->setMessage($msg);
           
           $group_name = $model->getWorkerAuthenticationGroup($userId);                             
           
           if($group_name == "loader")      
              $layout = "default_worker_home";           
           if($group_name == "admin")      
              $layout = "default_admin_home";
           
            
           JRequest::setVar('layout',$layout);           
           parent::display();
       }
               
       
       public function add_worker_submit()
       {
           
           $primary_role_hidden_name = JRequest::getVar("primary_role_hidden_name");
           $secondary_role_hidden_name = JRequest::getVar("secondary_role_hidden_name");
           $additional_role_hidden_name = JRequest::getVar("additional_role_hidden_name");
           
           
           $primary_role = JRequest::getVar("primary_role");
           $wage_hr_primary = JRequest::getVar("wage_hr_primary");
           
           $secondary_role = JRequest::getVar("secondary_role");
           $wage_hr_secondary = JRequest::getVar("wage_hr_secondary");
           
           $additional_role = JRequest::getVar("additional_role");
           $wage_hr_additional = JRequest::getVar("wage_hr_additional");
                         
           $user = JFactory::getUser();
           
           $db = JFactory::getDbo();
           $name = JRequest::getVar("first_name");
           $username = JRequest::getVar("username");
           
           $password_enc = $this->randomPassword();           
         
           $password_enc_to_db = md5($password_enc);
           
           $email = JRequest::getVar("email");
           $block = 0;
           $sendEmail = 0;
           $registerDate = date("Y-m-d");
           $lastvisitDate = date("Y-m-d");
           $group_id = 2;
           
$first_name=JRequest::getVar("first_name"); 
$initial=JRequest::getVar("initial"); 
$last_name=JRequest::getVar("last_name"); 
$s_n=JRequest::getVar("s_n"); 
$dob=JRequest::getVar("dob"); 
$dob_new =date("Y-m-d",  strtotime($dob)); 
$start_date=JRequest::getVar("start_date"); 
$start_date_new =date("Y-m-d",  strtotime($start_date));  
$dl_no=JRequest::getVar("dl_no"); 
$class=JRequest::getVar("class"); 
$status=JRequest::getVar("status"); 
$email=JRequest::getVar("email"); 
$cell=JRequest::getVar("cell"); 
$home=JRequest::getVar("home"); 
$shirt_size=JRequest::getVar("shirt_size"); 
$pant_leg=JRequest::getVar("pant_leg"); 
$waist=JRequest::getVar("waist"); 
$receive_update_by=JRequest::getVar("receive_update_by"); 
$desired_shift=JRequest::getVar("desired_shift"); 
$created_by=$user->name; 
$created_date= date("Y-m-d"); 
$created_date_new=date("Y-m-d",  strtotime($created_date)); 
$updated_by=$user->name;
$updated_date=date("Y-m-d");
$updated_date_new=date("Y-m-d",  strtotime($updated_date)); 
$active_status='0';
$verified_status='0'; 
$verification_code =  md5(uniqid(rand(), true)); 

$inner_display_check = false;
$msg = "";

$model = $this->getModel("workers");

$rslt = $model->fieldValueCheck("email",$email);
$cell_field = $model->fieldValueCheckWorker("cell",$cell);
$home_field = $model->fieldValueCheckWorker("home",$home);

$msg_field = '';

if($rslt!=NULL || $cell_field!=NULL || $home_field!=NULL)
{    
            $inner_display_check = true;            
            $layout = "default_add_worker";
            
            if($rslt!=NULL)
            {
                $msg_field = $msg_field." Email: $email";                
            }
            
            if($cell_field!=NULL)
            {
                $msg_field = $msg_field." Cell: $cell";
            }
            
            if($home_field!=NULL)
            {
                $msg_field = $msg_field." Home: $home";
            }
            
            $msg = "Worker already exist with $msg_field";
            $form_data = JRequest::get();                                    
            JRequest::setVar('form_data',$form_data);
            
             $model = $this->getModel('workers');
            
            $primary_roles = $model->getAllRolesByType('primary');
            $secondary_roles = $model->getAllRolesByType('secondary');
            $additional_roles = $model->getAllRolesByType('additional');
                                    
            JRequest::setVar('primary_roles', $primary_roles);
            JRequest::setVar('secondary_roles', $secondary_roles);
            JRequest::setVar('additional_roles', $additional_roles);
                 
            
             JRequest::setVar('msg', $msg);
             JRequest::setVar('layout',$layout);            
             parent::display();
          
           return;                       
}


           $qry_user = "INSERT INTO #__users (
               name,
               username,
               password,
               email,
               block,sendEmail,registerDate,lastvisitDate)
               VALUES
               (
               '$name',
               '$email',
               '$password_enc_to_db',
               '$email',
               '$block','$sendEmail','$registerDate','$lastvisitDate')
               ";
           $db->setQuery($qry_user);
           $db->query() or die(mysql_error());
           
            $new_user_id = $db->insertid();
           
           
           
           $qry_user_group = "INSERT INTO #__user_usergroup_map(
               user_id,
               group_id
               )
               VALUES
               (
               '$new_user_id','2'
                )
               ";
           $db->setQuery($qry_user_group);
           $db->query() or die(mysql_error());
          
// ======= [Start] Block of Roles(group) assingment ================================
           // query for adding as loader - 13 is loader id and loader is usergroup of front-access-controll component.
           // values 13-for-loader , 11-for-admin
           
           if($primary_role_hidden_name == "admin" || $secondary_role_hidden_name=="admin" || $additional_role_hidden_name=="admin")
           {
               // 11 value is for admin
              $groupId ='\"11\"'; 
           }else{
               //13 value is for loader
                $groupId ='\"13\"';
           }
           
           $qry_user_group = "INSERT INTO #__fua_userindex(
               user_id,
               group_id
               )
               VALUES
               (
               '$new_user_id','$groupId'
                )
               ";
           $db->setQuery($qry_user_group);
           $db->query() or die(mysql_error());
// ======= [End] Block of Roles(group) assingment ================================          

          $qry_user_group = "INSERT INTO #__workers(            
            user_id,
            first_name,
            last_name,
            s_n,
            dob,
            start_date,
            dl_no,
            class,
            status,
            email,
            cell,
            home,
            shirt_size,
            pant_leg,
            waist,
            receive_update_by,
            desired_shift,
            created_by,
            created_date,
            updated_by,
            updated_date,
            active_status,
            verified_status,
            verification_code,
            initial
              )
              VALUES
              (
            '$new_user_id',
            '$first_name',
            '$last_name',
            '$s_n',
            '$dob_new',
            '$start_date_new',
            '$dl_no',
            '$class',
            '$status',
            '$email',
            '$cell',
            '$home',
            '$shirt_size',
            '$pant_leg',
            '$waist',
            '$receive_update_by',
            '$desired_shift',
            '$created_by',
            '$created_date_new',
            '$updated_by',
            '$updated_date_new',
            '$active_status',
            '$verified_status',
            '$verification_code',
            '$initial'
               )
              ";
          $db->setQuery($qry_user_group);
          $db->query() or die(mysql_error());

          
          //worker role wages queries -1
          
           $qry_role_wages_p = "INSERT INTO #__worker_role_index
                                (role_id,user_id,wage_hr  )
                                VALUES
                                ('$primary_role','$new_user_id','$wage_hr_primary')
                                ";
           $db->setQuery($qry_role_wages_p);
           $db->query() or die(mysql_error());
          
           
          //worker role wages queries -2
           $qry_role_wages_s = "INSERT INTO #__worker_role_index
                                (role_id,user_id,wage_hr  )
                                VALUES
                                ('$secondary_role','$new_user_id','$wage_hr_secondary')
                                ";
           $db->setQuery($qry_role_wages_s);
           $db->query() or die(mysql_error());
          
          //worker role wages queries -3
           $qry_role_wages_a = "INSERT INTO #__worker_role_index
                                (role_id,user_id,wage_hr  )
                                VALUES
                                ('$additional_role','$new_user_id','$wage_hr_additional')
                                ";
           $db->setQuery($qry_role_wages_a);
           $db->query() or die(mysql_error());
           $this->sendVerificationEmail($new_user_id, $verification_code,$email,$password_enc,$first_name,$last_name);
           
            $msg = "Worker added sucessfully";
            $this->setMessage($msg);
                    
            $url = JRoute::_('workers?task=add_worker');
            $this->setRedirect($url);
            $this->redirect();
       }
       
       public function randomPassword() {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); //remember to declare $pass as an array
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, strlen($alphabet)-1); //use strlen instead of count
                $pass[$i] = $alphabet[$n];
            }
                        
            return substr(implode($pass),0,4); //turn the array into a string
        }

       private function sendVerificationEmail($user_id,$verification_code,$email,$password,$fname,$lname)
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
                  
          $mailer = JFactory::getMailer();
          $from = array("info@turnkey-solutions.net","Red-Net");
          $mailer->setSender($from);
          $recipients = array($email,$fname.' '.$lname);
         $mailer->addRecipient($recipients);
         $mailer->addRecipie;
          $subject = "RED-NET - User activation";
          $mailer->setSubject($subject);
          $body = "
                  Hi $fname $lname,<br /><br />

            Your account has been setup in RED-NET, a web portal of Firemen Movers.
            Please login with the provided temporary password, to setup your new
            password and verify personal information.<br /><br />

            Email: $email <br />      
            Temporary Password:  $password <br />
            <a href='".JURI::base()."'>Click here to login</a><br /><br />
            If you have any problem, please contact 416 CALL RED<br /><br />

            Thanks<br />
            RED-NET team<br />
          "          
        ;
          $mailer->IsHTML(true);
          $mailer->Encoding = 'base64';
          $mailer->setBody($body);
          $send = $mailer->Send();
            if ( $send !== true ) {
                $msg = 'Error sending user activation email to newly added worker.';
                $this->setMessage($msg);
                $url = JRoute::_('index.php/component/rednet/workers?task=add_worker');
                $this->setRedirect($url);
                $this->redirect();
            } 
       }
                       
       
       public function admin_home()
       {
          
           $layout = "default_admin_home";
           JRequest::setVar('layout',$layout);
           parent::display();           
       }
       public function worker_home()
       {
           
           
           
           $layout = "default_worker_home";
           JRequest::setVar('layout',$layout);
           parent::display();           
       }
       
       
       
      
       
       
       public function load_orders()
       {       
           
                $user = JFactory::getUser();
           
                $model = $this->getModel('workers');
                $all_orders = $model->getAssignedResources($user->id); 
                $main_array = array();
                
                
                foreach($all_orders as $av)
                {
                    $arr = array(
                        
                        'id'=>$av->id,
                        'title'=>$av->name,                            
                            'start'=>$av->date_order
                    );
                    array_push($main_array, $arr);
                }
                
                echo json_encode($main_array);
                exit();

       }        
       
       
       
       public function activateWorker()
       {
         
           $db = JFactory::getDbo();
           $userId = JRequest::getVar('u');
           $activation_code = JRequest::getVar('c');
           
           if($userId!='' && $activation_code!='')
           {
                $query = "
                        UPDATE #__workers SET
                        verified_status = 1,
                        active_status = 1
                        WHERE        
                        user_id = $userId AND verification_code = '$activation_code'
                    ";
           
           
                    $db->setQuery($query);
                    $db->query() or die(mysql_error()); 
                    $msg = "User Activated.";
           }else{                                
                    $msg = "Invalid request.";
           }
           $this->setMessage($msg);
                
            $url = 'index.php?option=com_rednet&task=message_redirect&view=workers';
            $this->setRedirect($url);
            $this->redirect();            
       }
       
       public function message_redirect()
       {
           $layout = "default_message";
           JRequest::setVar('layout', $layout);
           parent::display();           
       }
       
       public function delete_worker()
       {
            $db = JFactory::getDbo();
            $model = $this->getModel('workers');
            $user_id= JRequest::getVar("id");
            
            $model->deleteWorker($user_id);
            
            $msg = "Worker deleted sucessfully";
            $this->setMessage($msg);
                    
            
            $url = 'index.php/component/rednet/workerslist';
            $this->setRedirect($url);
            $this->redirect();            
       }
       
       public function edit_worker_view()
       {
          //getWorkerById
           
           $user_id = JRequest::getVar('id');           
           $model = $this->getModel('workers');
           $worker = $model->getWorkerById($user_id); 
            
           $worker_roles = $model->getWorkerRolesIndexs($user_id);
        
           
            $primary_roles = $model->getAllRolesByType('primary');
            $secondary_roles = $model->getAllRolesByType('secondary');
            $additional_roles = $model->getAllRolesByType('additional');
            
           
            
            JRequest::setVar('primary_roles', $primary_roles);
            JRequest::setVar('secondary_roles', $secondary_roles);
            JRequest::setVar('additional_roles', $additional_roles);
           
          
           
           JRequest::setVar('worker',$worker);
           JRequest::setVar('worker_roles',$worker_roles);
           
           $layout = 'default_edit_worker';
           JRequest::setVar('layout',$layout);            
           parent::display();    
           
       }
       
       public function edit_worker_save()
       {
           
         
           
           $model = $this->getModel('workers');
           $data= JRequest::get();
           $model->updateWorker($data);
            
            $msg = "Worker updated sucessfully";
            $this->setMessage($msg);
                    
            $url = "index.php/component/rednet/workers/$data[userId]?task=edit_worker_view";
            $this->setRedirect($url);
            $this->redirect();   
       }
       
       public function change_password()
       {
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
            $pass = JRequest::getVar('new_pass');
            $pss_en = md5($pass);
            
            $query = "
                UPDATE #__users SET
                password    =   '$pss_en'   
                WHERE        
                id = $user->id
            ";
            $db->setQuery($query);
            $db->query() or die(mysql_error()); 
            
            $query_a = "
                UPDATE #__workers SET
                verified_status    =   '1'   
                WHERE        
                user_id = $user->id
            ";
            $db->setQuery($query_a);
            $db->query() or die(mysql_error()); 
            
            $msg = "Password has been changed.";
            $this->setMessage($msg);
                    
            $url = 'index.php?option=com_rednet&task=update_personal_info&view=workers';
            $this->setRedirect($url);
            $this->redirect();
       }
       
       public function worker_activaton()
       {
           echo "activation starts";
           
           $user = $this->_user;
           $model = $this->getModel('workers');
           $worker = $model->getWorkerById((int)$user->id);
           //var_dump($worker);
           
           if($worker->status == 1)
           {
               
              
              $msg="Worker is In-active. Contact to administrator.";
              $this->setMessage($msg);
              JRequest::setVar('w_status','0');
              JRequest::setVar('msg',$msg);
              parent::display();
           }
          
       }
	
}// class
?>




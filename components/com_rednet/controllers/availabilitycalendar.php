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
 * RednetFleet Controller
 *
 * @package    Rednet
 * @subpackage Controllers
 */

class RednetControllerAvailabilitycalendar extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'availabilitycalendar'; 
	protected $_user = '';
           
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
                
                $this->_user = JFactory::getUser();
             
                
		JRequest :: setVar('view', $this->_viewname);

	}
        
        
        public function get_availabilities()
        {
                                 
                $user = $this->_user;                                
                $worker_id = JRequest::getVar('worker_id');
                
                if(isset($worker_id) && $worker_id!=NULL)
                {
                    $userId = $worker_id;
                }else{
                    $userId = $user->id;
                }
                                                
                $model = $this->getModel('availabilitycalendar');
                $availability = $model->get_user_availabilitycalendar($userId); 
                $main_array = array();                
                
                foreach($availability as $av)
                {
                    $arr = array('id'=>$av->id,'title'=>'Available','start'=>$av->availability_date);
                    array_push($main_array, $arr);
                }
                
                echo json_encode($main_array);
                exit();

        }
        
        public function availability()
        {
            $user = $this->_user;            
            $worker_id = JRequest::getVar('worker_id');
                
                if(isset($worker_id) && $worker_id!=NULL)
                {
                    $userId = $worker_id;
                }else{
                    $userId = $user->id;
                }

            
            $model = $this->getModel('availabilitycalendar');            
            $model_worker = $this->getModel('workers');                                    
            $workers =  $model_worker->getAllWorkers();
            
            $av_day = array();            
            $current_month = JRequest::getVar('current_month');
           /* 
            if(isset($current_month))
            {
                $month = $current_month;                
            }else
            {
                $month = 1;
            }
            */
            
            $month = NULL;
            $av_sun = $model->get_user_availabilit_of_day($userId,'sun',$month);
            $av_day["sun"]=$av_sun;                                    
            
            $av_mon = $model->get_user_availabilit_of_day($userId,'mon',$month);
            $av_day["mon"]=$av_mon;
            
            $av_tue = $model->get_user_availabilit_of_day($userId,'tue',$month);
            $av_day["tue"]=$av_tue;
            
            $av_wed = $model->get_user_availabilit_of_day($userId,'wed',$month);
            $av_day["wed"]=$av_wed;
            
            $av_thur = $model->get_user_availabilit_of_day($userId,'thur',$month);
            $av_day["thur"]=$av_thur;
            
            $av_fri = $model->get_user_availabilit_of_day($userId,'fri',$month);
            $av_day["fri"]=$av_fri;
            
            $av_sat = $model->get_user_availabilit_of_day($userId,'sat',$month);
            $av_day["sat"]=$av_sat;
            
            $layout = "default_availability";            
            JRequest::setVar('layout',$layout);
            JRequest::setVar('av_day',$av_day);
            JRequest::setVar('month',$month);
            JRequest::setVar('workers',$workers);
            JRequest::setVar('current_month',$current_month);
            parent::display();
        }
        public function week_availability()
        {                        
            $user = $this->_user;                                                
            $user_id = JRequest::getVar('user_id');            
            $model = $this->getModel('availabilitycalendar');
                        
            $current_month = JRequest::getVar('current_month');
            
            if(isset($current_month))
            {
                $month = $current_month;
            }else
            {
                $month = 1;
            }
            
                        
            $sun = JRequest::getVar('sun');
            $mon = JRequest::getVar('mon');
            $tue = JRequest::getVar('tue');
            $wed = JRequest::getVar('wed');
            $thur = JRequest::getVar('thur');
            $fri = JRequest::getVar('fri');
            $sat = JRequest::getVar('sat');
            
            // Adding days availibilites.....
            $month_to_start = date('m');
            
          //for ($li=$month_to_start; $li<=12; $li++)  
          //{
          
              $month = $month_to_start;
             // $month = $li;
          
            if($sun == 'on')
            {   
                $model->delete_user_availabilit_of_day($user_id,'sun',$month);
                $this->delete_availability_on_calendar('sun', $month,$user_id);
                
                $model->add_user_availabilit_of_day($user_id,'sun',$month);                                
                $this->add_availability_on_calendar('sun', $month,$user_id);

            }  else {
                $model->delete_user_availabilit_of_day($user_id,'sun',$month);
                $this->delete_availability_on_calendar('sun', $month,$user_id);
            }
           
            
            if($mon == 'on')
            {   
                $model->delete_user_availabilit_of_day($user_id,'mon',$month);
                $this->delete_availability_on_calendar('mon', $month,$user_id);
                
                $model->add_user_availabilit_of_day($user_id,'mon',$month);                
                $this->add_availability_on_calendar('mon', $month,$user_id);
                
            }  else {
                $model->delete_user_availabilit_of_day($user_id,'mon',$month);
                $this->delete_availability_on_calendar('mon', $month,$user_id);
            }
           
            if($tue == 'on')
            {   
                $model->delete_user_availabilit_of_day($user_id,'tue',$month);
                $this->delete_availability_on_calendar('tue', $month,$user_id);
                
                $model->add_user_availabilit_of_day($user_id,'tue',$month);                
                $this->add_availability_on_calendar('tue', $month,$user_id);
            }  else {
                $model->delete_user_availabilit_of_day($user_id,'tue',$month);
                $this->delete_availability_on_calendar('tue', $month,$user_id);
            }
           
            if($wed == 'on')
            {   
                $model->delete_user_availabilit_of_day($user_id,'wed',$month);
                $this->delete_availability_on_calendar('wed', $month,$user_id);
                
                $model->add_user_availabilit_of_day($user_id,'wed',$month);                
                $this->add_availability_on_calendar('wed', $month,$user_id);
            }  else {
                $model->delete_user_availabilit_of_day($user_id,'wed',$month);
                $this->delete_availability_on_calendar('wed', $month,$user_id);
            }
           
            if($thur == 'on')
            {   
                $model->delete_user_availabilit_of_day($user_id,'thur',$month);
                $this->delete_availability_on_calendar('thur', $month,$user_id);
                
                $model->add_user_availabilit_of_day($user_id,'thur',$month);                
                $this->add_availability_on_calendar('thur', $month,$user_id);
            }  else {
                $model->delete_user_availabilit_of_day($user_id,'thur',$month);
                $this->delete_availability_on_calendar('thur', $month,$user_id);
            }
           
            if($fri == 'on')
            {   
                $model->delete_user_availabilit_of_day($user_id,'fri',$month);
                $this->delete_availability_on_calendar('fri', $month,$user_id);
                
                $model->add_user_availabilit_of_day($user_id,'fri',$month);
                $this->add_availability_on_calendar('fri', $month,$user_id);
            }  else {
                $model->delete_user_availabilit_of_day($user_id,'fri',$month);
                $this->delete_availability_on_calendar('fri', $month,$user_id);
            }
           
            if($sat == 'on')
            {   
                $model->delete_user_availabilit_of_day($user_id,'sat',$month);
                $this->delete_availability_on_calendar('sat', $month,$user_id);
                
                $model->add_user_availabilit_of_day($user_id,'sat',$month);
                $this->add_availability_on_calendar('sat', $month,$user_id);
            }  else {
                $model->delete_user_availabilit_of_day($user_id,'sat',$month);
                $this->delete_availability_on_calendar('sat', $month,$user_id);
            }
           
            
          //}
            $user_state = JRequest::getVar('user_state');
            
            
            if($user_state == 'old')
            {
                $url = 'index.php/component/rednet/availabilitycalendar?task=availability';
            }
            
            if($user_state == 'new')
            {
                $url = 'index.php/component/rednet/availabilitycalendar?task=availability&worker_id='.$user_id;
            }
                        
            
            //exit;
         
            $this->setRedirect($url);
            $this->redirect;
            
        }
        
        public function av_sending_date()
        {
           $day = JRequest::getVar('day');
           $month = JRequest::getVar('month');
           $year = JRequest::getVar('year');
           $user = $this->_user;
           
           $out_put = '';
           
           $user_id = JRequest::getVar('user_id');
           
            $av_date = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
            $model = $this->getModel('availabilitycalendar');
            $rs_map_model = $this->getModel('resourcesmap');
           
            $av_by_date = $model->get_user_availabilitycalendar_by_date($av_date,$user_id);
            
            if(isset($day))
            {
                if(!isset($av_by_date))
                {
                    
                    
                    $user_in_resources_map_with_avDate = $rs_map_model->get_resourcemap_by_UserId_OrderId_OrdderDate($user_id,NULL,$av_date);
                    // checking if user has assigned order at that day.
                    if(count($user_in_resources_map_with_avDate)>0)
                    {
                        $out_put = '0';
                    }else{
                        $insert_id = $model->add_availabilitycalendar_complete($user_id,$av_date);
                        $out_put = $insert_id;
                    }
                    
                    
                }                                
            }
            
            echo $out_put;
            exit();
        }
        public function av_remove_date()
        {
            $id = JRequest::getVar('id');                        
            if(isset($id))
            {
                $model = $this->getModel('availabilitycalendar');
                $model->delete_availabilitycalendar($id);              
            }
            
            exit();
        }
        
        
        private function add_availability_on_calendar($day,$month,$user_id)
        {
                    
                    $month_text =strtolower( date('M', mktime(0, 0, 0, $month, 1, 2000)) );            
                    $flag = true;
                    $day_s_no_cntr = 1;                        
                    $year = date("Y");

                    $time = strtotime(date('Y-m-d'));
                    $ending_date = date("Y-m-d", strtotime("+12 month", $time));
                    $ending_month = date('m',  strtotime($ending_date));
                    $ending_year = date('Y',  strtotime($ending_date));
                    
                    $model = $this->getModel('availabilitycalendar');

                    while($flag)
                    {			
                            $day_s_no = $day_s_no_cntr;	                                                        
                            
                            $reslutant_date = date('Y-m-d', strtotime("$month_text $year $day_s_no $day"));			
                            
                            $resultant_month = strtolower( date("M",strtotime($reslutant_date)) );		
                            $resultant_month_in_num = strtolower( date("m",strtotime($reslutant_date)) );		
                            $resultant_year = strtolower( date("Y",strtotime($reslutant_date)) );		
                            

                            if( ($resultant_month_in_num == $ending_month+1) && ($resultant_year == $ending_year))
                                {$flag = false;}
                            
                            if($flag == true)
                            {
                                 $model->add_availabilitycalendar_complete($user_id,$reslutant_date);
                            }	
                            
                            $day_s_no_cntr++;
                    } // end while
        }
        
        private function manage_calaneder($day,$month,$action)
        {
                    
                    $month_text =strtolower( date('M', mktime(0, 0, 0, $month, 1, 2000)) );            
                    $flag = true;
                    $day_s_no_cntr = 1;                        
                    $year = date("Y");
                    
                    $model = $this->getModel('availabilitycalendar');

                    while($flag)
                    {			
                            $day_s_no = $day_s_no_cntr;	
                            $reslutant_date = date('Y-m-d', strtotime("$month_text $year $day_s_no $day"));			
                            $resultant_month = strtolower( date("M",strtotime($reslutant_date)) );		
                            if($resultant_month == $month_text)
                            {
                                            //echo "<br />insert this > ".$reslutant_date;                                            
                                 $model->add_availabilitycalendar($reslutant_date);
                            }	
                            if($resultant_month != $month_text)
                            {$flag = false;}
                            $day_s_no_cntr++;
                    } // end while
        }
        
        private function delete_availability_on_calendar($day,$month,$user_id)
        {
                    
                    $month_text =strtolower( date('M', mktime(0, 0, 0, $month, 1, 2000)) );            
                    $flag = true;
                    $day_s_no_cntr = 1;                        
                    $year = date("Y");

                    $time = strtotime(date('Y-m-d'));
                    $ending_date = date("Y-m-d", strtotime("+12 month", $time));
                    $ending_month = date('m',  strtotime($ending_date));
                    $ending_year = date('Y',  strtotime($ending_date));
                    
                    $model = $this->getModel('availabilitycalendar');

                    while($flag)
                    {			
                            $day_s_no = $day_s_no_cntr;	                                                        
                            
                            $reslutant_date = date('Y-m-d', strtotime("$month_text $year $day_s_no $day"));			
                            
                            $resultant_month = strtolower( date("M",strtotime($reslutant_date)) );		
                            $resultant_month_in_num = strtolower( date("m",strtotime($reslutant_date)) );		
                            $resultant_year = strtolower( date("Y",strtotime($reslutant_date)) );		
                            
                              if( ($resultant_month_in_num == $ending_month+1) && ($resultant_year == $ending_year))
                                {$flag = false;}
                                
                            if($flag == true)
                            {
                                 $model->delete_availability_by_order_date($reslutant_date,$user_id);
                            }	
                            
                            $day_s_no_cntr++;
                    } // end while
        }
        
        
        
}// class
?>
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
                
                $workers = $worker_model->getAllActiveWorkers();
                
                $data['workers'] = $workers;
                
                
                
                JRequest::setVar('data',$data);
                
	}
	
        public function load_orders()
        {                
                $model = $this->getModel('ordersoncalendar');                                                
                $worker_id = JRequest::getVar('worker_id');
                
                $all_orders = array();
                
                if(isset($worker_id) && $worker_id!=NULL)
                {   
                    $all_orders = $model->getOrdersByWorkers($worker_id); 
                }else{
                    $all_orders = $model->getAllOrders(); 
                }

                $main_array = array();
                $color_class = 'green_class';
                
                foreach($all_orders as $av)
                {
                                        
                   $resourcesmap_model = $this->getModel('resourcesmap');
                   $order_in_resource_map = $resourcesmap_model->get_resourcesmap_by_order_id($av->id);
                   
                   if(count($order_in_resource_map) != 0)
                   {
                       $color_class = 'red_class';
                   }
                   
                   
                   foreach($order_in_resource_map as $rsm)
                   {
                       if(($rsm->user_id != '0') && ($rsm->status == '1'))
                       {
                           $color_class = 'black_class';
                       }
                   }
                   
                   
                    $arr = array(
                        
                        'id'=>$av->id,
                        'title'=>"$av->name",                            
                        'start'=>$av->date_order,
                        'no_of_men'=>$av->no_of_men,
                        'no_of_trucks'=>$av->no_of_trucks,
                        'color_class'=>$color_class
                    );
                    array_push($main_array, $arr);
                }
                
                echo json_encode($main_array);
                exit();

        }        
}// class
?>
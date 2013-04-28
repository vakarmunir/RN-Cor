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
class RednetControllerFleet extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'fleet'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	

	public function add_fleet()
        {
            $layout = "default_add_fleet";
            JRequest::setVar("layout",$layout);
            parent::display();
        }
	public function edit_fleet()
        {
            $model = $this->getModel('fleet');
            $id = JRequest::getVar('id');
            $layout = "default_edit_fleet";
            $fleet = $model->getFleetById($id);                       
            JRequest::setVar("layout",$layout);
            JRequest::setVar("fleet",$fleet);
            parent::display();
        }
	public function get_fleet_by_id()
        {
            $model = $this->getModel('fleet');
            $id = JRequest::getVar('id');
            
            $fleet = $model->getFleetById($id);                       
            echo json_encode($fleet);
            exit;
        }
	public function get_rental_by_id()
        {
            $model = $this->getModel('fleet');
            $id = JRequest::getVar('id');
            
            $rental = $model->getRentalById($id);                       
            echo json_encode($rental);
            exit;
        }
	public function edit_rental()
        {
            $model = $this->getModel('fleet');
            $id = JRequest::getVar('id');
            $layout = "default_edit_rental";
            $rental = $model->getRentalById($id);                         

            JRequest::setVar("layout",$layout);
            JRequest::setVar("rental",$rental);
            parent::display();
        }
	public function udpate_fleet()
        {
            $model = $this->getModel('fleet');
            $data = JRequest::get();
            
            $model->udpateFleet($data);
            
            $msg = "Fleet updated sucessfully";
            $this->setMessage($msg);            
            $url = 'index.php/component/rednet/fleet?task=manage_vehicles';
            $this->setRedirect($url);
            $this->redirect();   
        }
	public function udpate_rental()
        {
           
            $model = $this->getModel('fleet');
            $data = JRequest::get();
            
            $model->udpateRental($data);
            
            $msg = "Rental updated sucessfully";
            $this->setMessage($msg);            
            $url = 'index.php/component/rednet/fleet?task=manage_vehicles';
            $this->setRedirect($url);
            $this->redirect();   
        }
	public function add_rental()
        {
            $layout = "default_add_rental";
            JRequest::setVar("layout",$layout);
            parent::display();
        }
        
        
        public function manage_vehicles()
        {
            $layout = "default_manage_vehicles";            
            
            $model = $this->getModel('fleet');
            $fleets = $model->getFleets();
            $rentals = $model->getRentals();
                        
            JRequest::setVar("fleets",$fleets);            
            JRequest::setVar("rentals",$rentals);            
            JRequest::setVar("layout",$layout);
            parent::display();
        }
        
        
        public function delete_fleet()
       {
            
            $model = $this->getModel('fleet');
            
            $f_id = JRequest::getVar('id');
           
            $model->deleteFleet($f_id);
           
            $msg = "Fleet deleted sucessfully";
            $this->setMessage($msg);
                    
            
            $url = 'index.php/component/rednet/fleet?task=manage_vehicles';
            $this->setRedirect($url);
            $this->redirect();            
       }
       
       
        public function delete_rental()
       {
          
            $model = $this->getModel('fleet');
            
            $r_id = JRequest::getVar('id');
           
            $model->deleteRental($r_id);
           
            $msg = "Rental deleted sucessfully";
            $this->setMessage($msg);
                    
            
            $url = 'index.php/component/rednet/fleet?task=manage_vehicles';
            $this->setRedirect($url);
            $this->redirect();            
       }
       
       
        public function vehicle_fleet_save()
        {
            
            $data = JRequest::get();
            $model = $this->getModel('fleet');
            
            $model->save_fleet($data);
            
            $this->setMessage("Fleet added.");
            $url = "index.php/component/rednet/fleet?task=add_fleet";
            $this->setRedirect($url);
            $this->redirect();
            exit();
            
        }
        public function vehicle_rental_save()
        {
            
            $data = JRequest::get();
            $model = $this->getModel('fleet');
            
            $model->save_rental($data);
            
            $this->setMessage("Rental added.");
            $url = "index.php/component/rednet/fleet?task=add_rental";
            $this->setRedirect($url);
            $this->redirect();
            exit();
            
        }
	
}// class
?>
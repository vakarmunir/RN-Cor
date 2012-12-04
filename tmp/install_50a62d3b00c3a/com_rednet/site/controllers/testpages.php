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
 * RednetTestpages Controller
 *
 * @package    Rednet
 * @subpackage Controllers
 */
class RednetControllerTestpages extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'testpages'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);                
	}
	

       public function order_form()
       {
           
           $my_data_var = "This is data for heading.";           
           $layout = "default_order_form";          
           JRequest::setVar('my_data',$my_data_var);
           JRequest::setVar('layout',$layout);
           parent::display();
       }
	
       public  function worker_form()
       {
           $layout="default_worker_form";           
           JRequest::setVar('layout',$layout);
           parent::display();
       }
       
       public function etc_form()
               
             {
          $layout="default_etc_form";
         JRequest::setVar("layout",$layout);        
         $waqar="i am a data";
         JRequest::setVar("waqar",$waqar);
        parent::display();
        
             }
       
       
}// class
?>
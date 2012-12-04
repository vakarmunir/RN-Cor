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
	

        public function display_form()                
           {
            $name=$_POST['myname'];
            $status=$_POST['mystatus'];            
            
            $testpages_model = $this->getModel('testpages');
            $testpages_model->_name = $name;
            $testpages_model->_status = $status;
            $testpages_model->insert_testpage();
            $all_test_pages = $testpages_model->get_all_testpage();
                        
            
            
            $layout = "default";
            JRequest::setVar('all_test_pages',$all_test_pages);
            JRequest::setVar('layout',$layout);
            parent::display();
            
           }
        

           public function edit_form()
           {
               $id = $_GET['id'];
               
               if(isset($id) && $id!=NULL)
               {
                   $model = $this->getModel('testpages');
                   $a_test_page = $model->get_a_testpage_by_id($id);
                   $layout = "default_edit_form_dispaly";
                    JRequest::setVar('a_test_page',$a_test_page);
                    JRequest::setVar('layout',$layout);
                    parent::display();
            
               }
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
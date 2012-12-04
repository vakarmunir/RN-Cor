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
	

        public function view_all_pages()
        {
            $layout="default_all_pages";
            
            $id = $_GET['id'];
            
            
            $model = $this->getModel('testpages');
            $all_dbdata = $model->getAllPages();
            
            //var_dump($all_pages);
            
            JRequest::setVar("allrecords",$all_dbdata);
            JRequest::setVar('id',$id);
            JRequest::setVar('layout',$layout);
            parent::display();
        }
       
        public function insert_a_page()
        {
            $layout="default_insert_page";
            
            
            JRequest::setVar('layout',$layout);
            parent::display();
        }
       
}// class
?>
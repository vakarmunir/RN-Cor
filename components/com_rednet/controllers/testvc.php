<?php
/**
* @version		$Id: #name#.php 112 2012-02-24 18:37:40Z michel $
* @package		Rednet
* @subpackage 	Controllers
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * RednetTestvc Controller
 *
 * @package    Rednet
 * @subpackage Controllers
 */
class RednetControllerTestvc extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'testvc'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);
		JRequest :: setVar('model', "testvc");

	}
	
	public function display() {
		
		$document =& JFactory::getDocument();
	
		$viewType	= $document->getType();
		$view = & $this->getView($this->_viewname,$viewType);
		$model = & $this->getModel("workers");
	
		//$view->setModel($model,true);		
		$view->display();
	}
        
        public function testdisplay()
        {
            echo "testing..";
            $this->display();
        }
}// class
?>
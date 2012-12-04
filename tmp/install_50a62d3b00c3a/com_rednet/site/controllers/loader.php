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
 * RednetLoader Controller
 *
 * @package    Rednet
 * @subpackage Controllers
 */
class RednetControllerLoader extends RednetController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'loader'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	
        public function loader_home()
        {
            echo "loader_home";
            
            //exit();
            //JRequest::setVar($name);
            parent::display();
        }
		
}// class
?>
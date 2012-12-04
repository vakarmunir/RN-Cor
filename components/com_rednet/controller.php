<?php
/**
* @version		$Id:controller.php  1 2012-08-24Z  $
* @package		Rednet
* @subpackage 	Controllers
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class RednetController extends JController
{

	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_rednet";
	/**
	 * Constructor
	 */
		 
	public function __construct($config = array ()) {
		
		parent :: __construct($config);

		if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 

		JRequest :: setVar('view', $this->_viewname);
                $db = JFactory::getDbo();
                $session = JFactory::getSession();
                    
                $user = JFactory::getUser();
                if($user->id == 0)
                {
                
                    $r = $_SERVER['REQUEST_URI'];
                    if(isset($r) && $r!=NULL)
                    {                    
                        $return_url = $r;
                        $session->set('return_url',$return_url);                                                                       
                        //echo "here.....".$return_url;                     
                    }
                    
                    
                    $r_url = $session->get('return_url');                    
                    if(isset($r_url) && $r_url!=NULL)
                    {
                        $url = $r_url;                        
                        //echo "last url = ".$url;
                        //exit;
                    }
                    
                    
                    
                    $url = JURI::base();
                    $this->setRedirect($url);
                    $this->redirect();
                }
                
	}

	public function display() {
		
		$document =& JFactory::getDocument();
	
		$viewType	= $document->getType();
		$view = & $this->getView($this->_viewname,$viewType);
		$model = & $this->getModel($this->_mainmodel);
	
		$view->setModel($model,true);		
		$view->display();
	}
	
      
}// class
  	

  
?>
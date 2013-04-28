<?php
/**
* @version		$Id: default_viewfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Views
* @copyright	Copyright (C) 2013, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class RednetViewReportmaster  extends JView 
{
	public function display($tpl = null)
	{
		
		$app = &JFactory::getApplication('site');
		$document	= &JFactory::getDocument();
		$uri 		= &JFactory::getURI();
		$user 		= &JFactory::getUser();
		$pagination	= &$this->get('pagination');
		$params		= $app ->getParams();				
		$menus	= &JSite::getMenu();
		
		$menu	= $menus->getActive();
		if (is_object( $menu )) {
			$menu_params = $menus->getParams($menu->id) ;
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title', 'Reportmaster');
			}
		}		


		$item = $this->get( 'Item' );
		$this->assignRef( 'item', $item );

		$this->assignRef('params', $params);
		$this->assignRef('pagination', $pagination);
		
                $data = JRequest::getVar('data');
                if(isset($data))
                {
                    $this->assignRef('data', $data);
                }
                
                $task = JRequest::getVar('$task');
                if(isset($data))
                {
                    $this->assignRef('$task', $task);
                }
                
                
                $all_orders = JRequest::getVar('all_orders');
                if(isset($all_orders))
                {
                    $this->assignRef('all_orders', $all_orders);
                }
                
                $layout = JRequest::getVar('layout');
                if(isset($layout))
                {
                    $this->setLayout($layout);
                }
                
		parent::display($tpl);
	}
}
?>
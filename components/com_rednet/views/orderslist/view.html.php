<?php
/**
* @version		$Id: default_viewlist.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Views
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class RednetViewOrderslist  extends JView 
{
	public function display($tpl = null)
	{
		
		$app = &JFactory::getApplication('site');
		$document	= &JFactory::getDocument();
		$uri 		= &JFactory::getURI();
		$user 		= &JFactory::getUser();
		$pagination	= &$this->get('pagination');
                
                //var_dump($pagination);
                
		$params		= $app ->getParams();				
		$menus	= &JSite::getMenu();
		
		$menu	= $menus->getActive();
		if (is_object( $menu )) {
			$menu_params = $menus->getParams($menu->id) ;
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title', 'Rednet');
			}
		}		
				
		$items = $this->get( 'Items' );
                
                
                //var_dump($items);
                //exit();
                
		$this->assignRef( 'items', $items);

		$this->assignRef('params', $params);
		$this->assignRef('pagination', $pagination);

                
                $orders = JRequest::getVar('orders');
                if(isset($orders))
                {
                    $this->assignRef('orders', $orders);
                }
                
                $all_records = JRequest::getVar('all_records');
                if(isset($all_records))
                {
                    $this->assignRef('all_records', $all_records);
                }
                
                
                $fleets = JRequest::getVar('fleets');
                if(isset($fleets))
                {
                    $this->assignRef('fleets', $fleets);
                }
                
                $rentals = JRequest::getVar('rentals');
                if(isset($rentals))
                {
                    $this->assignRef('rentals', $rentals);
                }
                
                $workers_on_order_date = JRequest::getVar('workers_on_order_date');
                if(isset($workers_on_order_date))
                {
                    $this->assignRef('workers_on_order_date', $workers_on_order_date);
                }
                
                
                $all_loaders = JRequest::getVar('all_loaders');
                if(isset($all_loaders))
                {
                    $this->assignRef('all_loaders', $all_loaders);
                }
                
                $all_drivers = JRequest::getVar('all_drivers');
                if(isset($all_drivers))
                {
                    $this->assignRef('all_drivers', $all_drivers);
                }
                
                $all_crews = JRequest::getVar('all_crews');
                if(isset($all_crews))
                {
                    $this->assignRef('all_crews', $all_crews);
                }
                
                
                
                $form_data = JRequest::getVar('form_data');
                if(isset($fleets))
                {
                    $this->assignRef('form_data', $form_data);
                }
                
                
                $layout = JRequest::getVar('layout');
                
                //var_dump($layout);
                if(isset($layout))
                {
                    $this->setLayout($layout);
                }
                
		parent::display($tpl);
	}
}
?>
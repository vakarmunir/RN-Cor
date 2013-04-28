<?php
/**
* @version		$Id: default_viewfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Views
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class RednetViewOrders  extends JView 
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
				$params->set('page_title', 'Orders');
			}
		}		


		$item = $this->get( 'Item' );
		$this->assignRef( 'item', $item );

		$this->assignRef('params', $params);
		$this->assignRef('pagination', $pagination);
		
                
                
                $form_data = JRequest::getVar('form_data');
                
                if(isset($form_data))
                {

                  
                    $this->assignRef('form_data', $form_data);
                }
               
                
                $current_month = JRequest::getVar('current_month');
                
                if(isset($current_month))
                {

                  
                    $this->assignRef('current_month', $current_month);
                }
               
                
                $layout = JRequest::getVar('layout');
                if(isset($layout))
                {
                    $this->setLayout($layout);
                }                
                
                $msg = JRequest::getVar('msg');
                if(isset($msg))
                {
                    $this->assignRef('msg', $msg);
                }
               
                $order = JRequest::getVar('order');
                if(isset($order))
                {
                    $this->assignRef('order', $order);
                }                               
                
                $workers_on_order_date = JRequest::getVar('workers_on_order_date');
                if(isset($workers_on_order_date))
                {
                    $this->assignRef('workers_on_order_date', $workers_on_order_date);
                }                               
                
                $workers_in_rs_on_order_date = JRequest::getVar('workers_in_rs_on_order_date');
                if(isset($workers_in_rs_on_order_date))
                {
                    $this->assignRef('workers_in_rs_on_order_date', $workers_in_rs_on_order_date);
                }                               
                
                $resources = JRequest::getVar('resources');
                if(isset($resources))
                {
                    $this->assignRef('resources', $resources);
                }                                                     
                
                $fleets = JRequest::getVar('fleets');
                if(isset($fleets))
                {
                    $this->assignRef('fleets', $fleets);
                }
                
                $fleets_not_assigned = JRequest::getVar('fleets_not_assigned');
                if(isset($fleets_not_assigned))
                {
                    $this->assignRef('fleets_not_assigned', $fleets_not_assigned);
                }
                
                $fleets_assigned = JRequest::getVar('fleets_assigned');
                if(isset($fleets_assigned))
                {
                    $this->assignRef('fleets_assigned', $fleets_assigned);
                }
                
                $rentals = JRequest::getVar('rentals');
                if(isset($rentals))
                {
                    $this->assignRef('rentals', $rentals);
                }
                
                $rentals_not_assigned = JRequest::getVar('rentals_not_assigned');
                if(isset($rentals_not_assigned))
                {
                    $this->assignRef('rentals_not_assigned', $rentals_not_assigned);
                }
                
                $rentals_assigned = JRequest::getVar('rentals_assigned');
                if(isset($rentals_assigned))
                {
                    $this->assignRef('rentals_assigned', $rentals_assigned);
                }
                
                $all_packers = JRequest::getVar('all_packers');
                if(isset($all_packers))
                {
                    $this->assignRef('all_packers', $all_packers);
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
                
                
                $ad_on_orders = JRequest::getVar('ad_on_orders');
                if(isset($ad_on_orders))
                {
                    $this->assignRef('ad_on_orders', $ad_on_orders);
                }                                                     
                
                
		parent::display($tpl);
	}
}
?>
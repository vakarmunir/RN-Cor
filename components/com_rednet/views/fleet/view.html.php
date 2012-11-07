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

 
class RednetViewFleet  extends JView 
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
				$params->set('page_title', 'Fleet');
			}
		}		


		$item = $this->get( 'Item' );
		$this->assignRef( 'item', $item );

		$this->assignRef('params', $params);
		$this->assignRef('pagination', $pagination);
		  

                // ====== set application vars here ========
                $msg = JRequest::getVar('msg');
                if(isset($msg))
                {
                    $this->assignRef('msg', $msg);
                }
               
                
                $primary_roles = JRequest::getVar('primary_roles');
                if(isset($primary_roles))
                {
                    $this->assignRef('primary_roles', $primary_roles);
                }
                                               
                $secondary_roles = JRequest::getVar('secondary_roles');
                if(isset($secondary_roles))
                {
                    $this->assignRef('secondary_roles', $secondary_roles);
                }
                               
                $additional_roles = JRequest::getVar('additional_roles');
                if(isset($additional_roles))
                {
                    $this->assignRef('additional_roles', $additional_roles);
                }                               
                   
                $worker = JRequest::getVar('worker');
                if(isset($worker))
                {
                    $this->assignRef('worker', $worker);
                }
               
                $worker_roles = JRequest::getVar('worker_roles');
                if(isset($worker_roles))
                {
                    $this->assignRef('worker_roles', $worker_roles);
                }
               
                
                $w_status = JRequest::getVar('w_status');
                
                if(isset($w_status))
                {
                    
                  
                    $this->assignRef('w_status', $w_status);
                }
               
                
                $form_data = JRequest::getVar('form_data');
                
                if(isset($form_data))
                {

                  
                    $this->assignRef('form_data', $form_data);
                }
               
                
                $fleets = JRequest::getVar('fleets');
                
                if(isset($fleets))
                {
                    $this->assignRef('fleets', $fleets);
                }
               
                
                $fleet = JRequest::getVar('fleet');
                
                if(isset($fleet))
                {
                    $this->assignRef('fleet', $fleet);
                }
               
                
                $rental = JRequest::getVar('rental');
                
                if(isset($rental))
                {
                    $this->assignRef('rental', $rental);
                }
               
                
               
                
                
                $rentals = JRequest::getVar('rentals');                
                if(isset($rentals))
                {
                    $this->assignRef('rentals', $rentals);
                }
               
                
                $layout = JRequest::getVar('layout');
                if(isset($layout))
                {
                    $this->setLayout($layout);
                }                
                               
		parent::display($tpl);;
	}
}
?>
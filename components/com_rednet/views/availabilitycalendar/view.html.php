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

 
class RednetViewAvailabilitycalendar  extends JView 
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
				$params->set('page_title', 'Availabilitycalendar');
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
               
                $av_day = JRequest::getVar('av_day');
                if(isset($av_day))
                {                    
                    $this->assignRef('av_day', $av_day);
                }
               
                $month = JRequest::getVar('month');
                
                if(isset($month))
                {

                  
                    $this->assignRef('month', $month);
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
               
                $workers = JRequest::getVar('workers');
                if(isset($workers))
                {
                    $this->assignRef('workers', $workers);
                }
               
		parent::display($tpl);
	}
}
?>
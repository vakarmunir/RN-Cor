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

 
class RednetViewTestpages  extends JView 
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
				$params->set('page_title', 'Testpages');
			}
		}		


		$item = $this->get( 'Item' );
		$this->assignRef( 'item', $item );

		$this->assignRef('params', $params);
		$this->assignRef('pagination', $pagination);
		
                
                //=============================== 
                
                
                
                $heading_data = JRequest::getVar('my_data');
                
                if(isset($heading_data))
                {
                    $this->assignRef('h1', $heading_data);                    
                }                
                
                $layout=  JRequest::getVar('layout');
                //echo 'you are making layout='.$layout;
                
                if(isset($layout))
                {
                    $this->setLayout($layout);
                }
                
                
                $waqar=  JRequest::getVar('waqar');
               
                if(isset($waqar))
                {
                    $this->assignRef('waqar',$waqar);
                } 
                
                $all_test_pages=  JRequest::getVar('all_test_pages');
               
                if(isset($all_test_pages))
                {
                    $this->assignRef('all_test_pages',$all_test_pages);
                } 
                
                $a_test_page=  JRequest::getVar('a_test_page');
               
                if(isset($a_test_page))
                {
                    $this->assignRef('a_test_page',$a_test_page);
                } 
                
                //===============================
		parent::display($tpl);
	}
}
?>
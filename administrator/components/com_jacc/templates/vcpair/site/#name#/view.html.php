<?php 
/**
* @version		$Id: view.html.php 111 2012-02-24 18:37:06Z michel $
* @package		##Component##
* @subpackage 	Views
* @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
* @license ###license##
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class ##Component##View##Name##  extends JView 
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
				$params->set('page_title', '##Name##');
			}
		}		

		/**
		$item = $this->get( 'Item' );
		$this->assignRef( 'item', $item );
		**/
		$this->assignRef('params', $params);
		$this->assignRef('pagination', $pagination);
		
		parent::display($tpl);
	}
}
?>
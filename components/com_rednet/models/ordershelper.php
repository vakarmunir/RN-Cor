<?php
/**
* @version		$Id: default_modelfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Models
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');

global $alt_libdir;
JLoader::import('joomla.application.component.modelitem', $alt_libdir);
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_rednet/tables');
/**
 * RednetModelOrders
 * @author $Author$
 */
 
 
class RednetModelOrdersHelper  extends JModelItem { 

	
	
	protected $context = 'com_rednet.orders';   
        protected $db;

        public $order_id;
        public $order_no;
        public $name;
        public $date_order;
        public $type_order;
        public $type_if_other;
        public $no_of_men;
        public $no_of_trucks;
        public $truck_requirments;
        public $out_of_town;
        public $departure_time;
        public $deposite;
        public $is_addon;
        public $instruction_file;
        public $created_by;
        public $created_date;
        public $parent_order;
        
        /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	
		
}
?>
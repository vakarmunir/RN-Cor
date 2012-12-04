<?php
/**
* @version		$Id:orders.php  1 2012-09-25 08:03:56Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableOrders class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableOrders extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar name  **/
   public $name = null;

   /** @var int created_by  **/
   public $created_by = null;

   /** @var varchar order_no  **/
   public $order_no = null;

   /** @var date date_order  **/
   public $date_order = null;

   /** @var varchar type_order  **/
   public $type_order = null;

   /** @var varchar type_if_other  **/
   public $type_if_other = null;

   /** @var varchar no_of_men  **/
   public $no_of_men = null;

   /** @var varchar no_of_trucks  **/
   public $no_of_trucks = null;

   /** @var varchar truck_requirments  **/
   public $truck_requirments = null;

   /** @var varchar out_of_town  **/
   public $out_of_town = null;

   /** @var time departure_time  **/
   public $departure_time = null;

   /** @var float deposite  **/
   public $deposite = null;

   /** @var int is_addon  **/
   public $is_addon = null;

   /** @var time addon_time  **/
   public $addon_time = null;

   /** @var varchar instruction_file  **/
   public $instruction_file = null;

   /** @var date created_date  **/
   public $created_date = null;

   /** @var date updated_date  **/
   public $updated_date = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__orders', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind($array, $ignore = '')
	{ 
		
		return parent::bind($array, $ignore);		
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check()
	{



		/** check for valid name */
		/**
		if (trim($this->name) == '') {
			$this->setError(JText::_('Your Orders must contain a name.')); 
			return false;
		}
		**/		

		return true;
	}
}

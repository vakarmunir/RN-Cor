<?php
/**
* @version		$Id:reportmaster.php  1 2013-01-04 11:27:11Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2013, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableReportmaster class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableReportmaster extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;


   /** @var int order_id  **/
   public $order_id = null;

   /** @var time departure_time  **/
   public $departure_time = null;

   /** @var time return_time  **/
   public $return_time = null;

   /** @var time total_work_hours_billed  **/
   public $total_work_hours_billed = null;

   /** @var time paid_hours  **/
   public $paid_hours = null;

   /** @var time client_start  **/
   public $client_start = null;

   /** @var time client_end  **/
   public $client_end = null;

   /** @var time travel_time_billed  **/
   public $travel_time_billed = null;

   /** @var time travel_leak  **/
   public $travel_leak = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__reportmaster', 'id', $db);
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
		if (trim($this->id) == '') {
			$this->setError(JText::_('Your Reportmaster must contain a id.')); 
			return false;
		}
		**/		

		return true;
	}
}

<?php
/**
* @version		$Id:availabilitycalendar.php  1 2012-09-19 06:15:33Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableAvailabilitycalendar class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableAvailabilitycalendar extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var int user_id  **/
   public $user_id = null;

   /** @var date availability_date  **/
   public $availability_date = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__user_availabilitycalendar', 'id', $db);
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
			$this->setError(JText::_('Your Availabilitycalendar must contain a id.')); 
			return false;
		}
		**/		

		return true;
	}
}

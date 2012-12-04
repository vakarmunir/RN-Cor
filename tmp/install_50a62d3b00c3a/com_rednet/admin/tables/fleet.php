<?php
/**
* @version		$Id:fleet.php  1 2012-09-10 09:13:08Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableFleet class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableFleet extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar name  **/
   public $name = null;

   /** @var int created_by  **/
   public $created_by = null;

   /** @var varchar type  **/
   public $type = null;

   /** @var varchar out_of_service  **/
   public $out_of_service = null;

   /** @var date from  **/
   public $from = null;

   /** @var date to  **/
   public $to = null;

   /** @var date created_date  **/
   public $created_date = null;

   /** @var date updated_date  **/
   public $updated_date = null;

   /** @var int updated_by  **/
   public $updated_by = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__vehicles_fleet', 'id', $db);
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
			$this->setError(JText::_('Your Fleet must contain a name.')); 
			return false;
		}
		**/		

		return true;
	}
}

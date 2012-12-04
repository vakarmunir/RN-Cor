<?php
/**
* @version		$Id:ordertype.php  1 2012-11-16 09:58:40Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableOrdertype class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableOrdertype extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar name  **/
   public $name = null;

   /** @var varchar value  **/
   public $value = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__ordertype', 'id', $db);
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
			$this->setError(JText::_('Your Ordertype must contain a name.')); 
			return false;
		}
		**/		

		return true;
	}
}

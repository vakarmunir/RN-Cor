<?php
/**
* @version		$Id:role.php  1 2012-08-29 05:19:49Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableRole class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableRole extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar name  **/
   public $name = null;

   /** @var varchar type  **/
   public $type = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__worker_role', 'id', $db);
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
			$this->setError(JText::_('Your Role must contain a name.')); 
			return false;
		}
		**/		

		return true;
	}
}

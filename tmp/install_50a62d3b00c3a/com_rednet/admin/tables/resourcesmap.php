<?php
/**
* @version		$Id:resourcesmap.php  1 2012-10-08 09:40:24Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableResourcesmap class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableResourcesmap extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar truck  **/
   public $truck = null;

   /** @var int order_id  **/
   public $order_id = null;

   /** @var int user_id  **/
   public $user_id = null;

   /** @var varchar status  **/
   public $status = null;

   /** @var date created_date  **/
   public $created_date = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__resourcesmap', 'id', $db);
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
		if (trim($this->truck) == '') {
			$this->setError(JText::_('Your Resourcesmap must contain a truck.')); 
			return false;
		}
		**/		

		return true;
	}
}

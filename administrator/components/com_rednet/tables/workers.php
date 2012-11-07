<?php
/**
* @version		$Id:workers.php  1 2012-08-29 05:19:49Z  $
* @package		Rednet
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableWorkers class
*
* @package		Rednet
* @subpackage	Tables
*/
class TableWorkers extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar first_name  **/
   public $first_name = null;

   /** @var varchar created_by  **/
   public $created_by = null;

   /** @var varchar last_name  **/
   public $last_name = null;

   /** @var varchar s_n  **/
   public $s_n = null;

   /** @var datetime dob  **/
   public $dob = null;

   /** @var datetime start_date  **/
   public $start_date = null;

   /** @var varchar dl_no  **/
   public $dl_no = null;

   /** @var varchar class  **/
   public $class = null;

   /** @var varchar status  **/
   public $status = null;

   /** @var varchar email  **/
   public $email = null;

   /** @var varchar cell  **/
   public $cell = null;

   /** @var varchar home  **/
   public $home = null;

   /** @var varchar shirt_size  **/
   public $shirt_size = null;

   /** @var varchar pant_leg  **/
   public $pant_leg = null;

   /** @var varchar waist  **/
   public $waist = null;

   /** @var varchar receive_update_by  **/
   public $receive_update_by = null;

   /** @var varchar desired_shift  **/
   public $desired_shift = null;

   /** @var datetime created_date  **/
   public $created_date = null;

   /** @var datetime updated_by  **/
   public $updated_by = null;

   /** @var datetime updated_date  **/
   public $updated_date = null;

   /** @var int active_status  **/
   public $active_status = null;

   /** @var int verified_status  **/
   public $verified_status = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__workers', 'id', $db);
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
		if (trim($this->first_name) == '') {
			$this->setError(JText::_('Your Workers must contain a first_name.')); 
			return false;
		}
		**/		

		return true;
	}
}

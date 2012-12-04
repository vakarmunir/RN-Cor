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
 * RednetModelTestpages
 * @author $Author$
 */
 
 
class RednetModelTestpages  extends JModelItem { 

	
	
	protected $context = 'com_rednet.testpages';   
        public $_name = NULL;
        public $_status = NULL;
        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
        
        public function insert_testpage()
        {
            $db = JFactory::getDbo();
            $query= "INSERT INTO #__testpages (name,status) VALUES ('$this->_name','$this->_status')";
            $db->setQuery($query);
            $db->query() or die(mysql_error());            
        }
        
        public function get_all_testpage()
        {
            $db = JFactory::getDbo();
            $query= "SELECT * FROM #__testpages";
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $all_test_pages = $db->loadObjectList();
            return $all_test_pages;
        }
        
        public function get_a_testpage_by_id($id)
        {
            $db = JFactory::getDbo();
            $query= "SELECT * FROM #__testpages WHERE id=$id";
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $a_test_page = $db->loadObject();
            return $a_test_page;
        }
        
	public function populateState()
	{
		$app = JFactory::getApplication();

		//$params	= $app->getParams();

		// Load the object state.
		$id	= JRequest::getInt('id');
		$this->setState('testpages.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('testpages.id');

		return parent::getStoreId($id);
	}
	
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem($id = null)
	{
		if ($this->_item === null) {
			
			$this->_item = false;

			if (empty($id)) {
				$id = $this->getState('testpages.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Testpages', 'Table');


			// Attempt to load the row.
			if ($table->load($id)) {
				
				// Check published state.
				if ($published = $this->getState('filter.published')) {
					
					if ($table->state != $published) {
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
				
			} else if ($error = $table->getError()) {
				
				$this->setError($error);
			}
		}


		return $this->_item;
	}
        
        
        public function getAllPages()
        {
            $db = JFactory::getDbo();
            
            $query = "SELECT * FROM #__testpages";
            
            $db->setQuery($query);
            $db->query() or die ('DB Error : '.mysql_error());
            
            return $db->loadObjectList();
        }
		
}
?>
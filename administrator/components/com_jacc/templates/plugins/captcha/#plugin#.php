<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.environment.browser');

class plg##Plugtype####Plugin## extends JPlugin
{
	
	
	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}
	
	public function onInit($id)
	{
		// TODO: Your Code
	
		return true;
	}
	
	/**
	 * Gets the challenge HTML
	 *
	 * @return  string  The HTML to be embedded in the form.
	 *
	 * @since  2.5
	 */
	public function onDisplay($name, $id, $class)
	{
		$html[] = '<div></div>'; 
		
		return implode('',$html);
	}

	/**
	  * Calls an HTTP POST function to verify if the user's guess was correct
	  *
	  * @return  True if the answer is correct, false otherwise
	  *
	  * @since  2.5
	  */
	public function onCheckAnswer($code)
	{
		// TODO: Your Code
		
		return true;
	}

	
}

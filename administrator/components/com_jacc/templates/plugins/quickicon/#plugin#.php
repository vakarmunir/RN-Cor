<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plg##Plugtype####Plugin## extends JPlugin
{
	
	
	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onGetIcons($context)
	{
		if ($context != $this->params->get('context', 'mod_quickicon')) {
			return;
		}
	
		return array(array(
				'link' => 'index.php?option=com_something',
				'image' => 'header/icon-48-##plugin##.png',
				'text' => JText::_('PLG_QUICKICON_##Plugin##_CHECKING'),
				'id' => 'plg_quickicon_##plugin##'
		));
	}	
}

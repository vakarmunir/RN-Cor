<?php
/**
 * Module Helper File
 *
 * @package         Add to Menu
 * @version         2.2.6
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

class modAddToMenu
{
	function modAddToMenu(&$params)
	{
		// Load plugin parameters
		require_once JPATH_PLUGINS . '/system/nnframework/helpers/parameters.php';
		$this->parameters = NNParameters::getInstance();
		$this->params = $this->parameters->getModuleParams('addtomenu', 1, $params);
	}

	function render()
	{
		if (!isset($this->params->display_link)) {
			return;
		}

		$option = JRequest::getCmd('option');

		$this->vars = array();

		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$comp_file = '';
		$folder = JPATH_ADMINISTRATOR . '/components/' . $option . '/addtomenu';
		if (!JFolder::exists($folder)) {
			$folder = JPATH_ADMINISTRATOR . '/modules/mod_addtomenu/addtomenu/components/' . $option;
		}

		foreach (JFolder::files($folder, '.xml') as $filename) {
			$file = $folder . '/' . $filename;
			$xml = JFactory::getXMLParser('Simple');
			$xml->loadFile($file);
			if (isset($xml->document) && isset($xml->document->_children)) {
				$template = $this->parameters->getObjectFromXML($xml->document->_children);
				if (isset($template->params) && isset($template->params->required)) {
					if (!is_object($template->params->required) || modAddToMenu::checkRequiredFields($template->params->required)) {
						$template = $template->params;
						$comp_file = JFile::stripExt($filename);
						break;
					}
				}
			}
		}

		if (!$comp_file) {
			return;
		}

		$opt = $option;
		// load the admin language file
		if ($opt == 'com_categories') {
			$opt = JRequest::getCmd('extension', 'com_content');
		}
		$lang = JFactory::getLanguage();
		if ($lang->getTag() != 'en-GB') {
			// Loads English language file as fallback (for undefined stuff in other language file)
			$lang->load('mod_addtomenu', JPATH_ADMINISTRATOR, 'en-GB');
			$lang->load($opt, JPATH_ADMINISTRATOR, 'en-GB');
			$lang->load($opt . '.menu', JPATH_ADMINISTRATOR, 'en-GB');
		}
		$lang->load('mod_addtomenu', JPATH_ADMINISTRATOR, null, 1);
		$lang->load($opt, JPATH_ADMINISTRATOR, null, 1);
		$lang->load($opt . '.menu', JPATH_ADMINISTRATOR, null, 1);

		JHtml::_('behavior.modal');

		require_once JPATH_PLUGINS . '/system/nnframework/helpers/versions.php';
		$mt_version = NoNumberVersions::getMooToolsVersion();
		$version = NoNumberVersions::getXMLVersion('addtomenu', 'module', 1, 1);
		$nn_version = NoNumberVersions::getXMLVersion(null, null, null, 1);

		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root(true) . '/plugins/system/nnframework/css/status.css' . $nn_version);
		$document->addScript(JURI::root(true) . '/administrator/modules/mod_addtomenu/addtomenu/js/script' . $mt_version . '.js' . $version);
		$document->addStyleSheet(JURI::root(true) . '/administrator/modules/mod_addtomenu/addtomenu/css/style.css' . $version);

		// set height for popup
		$popup_width = 600 + (int) $this->params->adjust_modal_w;
		$popup_height = 320 + (int) $this->params->adjust_modal_h;
		if (isset($template->adjust_height)) {
			$popup_height += (int) $template->adjust_height;
		}
		if (isset($template->extras) && is_object($template->extras) && isset($template->extras->extra)) {
			if (!is_array($template->extras->extra)) {
				$template->extras->extra = array($template->extras->extra);
			}
			$haselements = 0;
			// + heights of elements
			foreach ($template->extras->extra as $element) {
				if (isset($element->type)) {
					$haselements = 1;
					switch ($element->type) {
						case 'radio':
							// add height for every line
							$popup_height += 8 + (16 * count($element->values->value));
							break;
						case 'textarea':
							$popup_height += 111;
							break;
						case 'hidden':
						case 'toggler':
							// no height
							break;
						default:
							$popup_height += 24;
							break;
					}
				}
			}
			if ($haselements) {
				// + height of title
				$popup_height += 23;
			}
		}

		$link = 'index.php?nn_qp=1';
		$link .= '&folder=administrator.modules.mod_addtomenu.addtomenu';
		$link .= '&file=addtomenu.inc.php';
		$link .= '&comp=' . $comp_file;

		$uri = JFactory::getURI();
		$url_query = $uri->getQuery(1);
		foreach ($url_query as $key => $val) {
			$this->vars[$key] = $val;
		}
		if (!isset($this->vars['option'])) {
			$this->vars['option'] = $option;
		}
		foreach ($this->vars as $key => $val) {
			if (is_array($val)) {
				$val = $val['0'];
			}
			$link .= '&vars[' . $key . ']=' . $val;
		}

		$text_ini = strtoupper(str_replace(' ', '_', $this->params->icon_text));
		$text = JText::_($text_ini);
		if ($text == $text_ini) {
			$text = JText::_($this->params->icon_text);
		}

		$title = $text;
		$class = '';
		if ($this->params->display_link == 'text') {
			$class = 'no_icon';
		} else if ($this->params->display_link == 'icon') {
			$text = '';
			$class = 'no_text';
		}

		if ($this->params->display_tooltip) {
			JHtml::_('behavior.tooltip');
			$class .= ' hasTip';
			$title = JText::_('ADD_TO_MENU') . '::' . JText::_($template->name);
		}

		$html = '<a href="' . $link . '" onfocus="this.blur();" class="nn_status_link modal" rel="{handler: \'iframe\', size: {x: ' . $popup_width . ', y: ' . $popup_height . '}}"><span class="nn_status_text ' . $class . '"  title="' . $title . '">' . $text . '</span></a>';
		$html = '<span class="addtomenu_status nn_status">' . $html . '</span>';

		echo $html;
	}

	function getVar($var)
	{
		if ($var['0'] == '$') {
			$var = substr($var, 1);
			$var = modAddToMenu::getVal($var);
		}
		return $var;
	}

	function getVal($value, $vars = '')
	{
		$url = JRequest::getVar('url');
		$extra = JRequest::getVar('extra');

		if (isset($vars[$value])) {
			$val = $vars[$value];
		} else if (isset($url[$value])) {
			$val = $url[$value];
		} else if (isset($extra[$value])) {
			$val = $extra[$value];
		} else {
			$val = JRequest::getVar($value);
			if ($val == '') {
				global $context;
				$app = JFactory::getApplication();
				$val = $app->getUserStateFromRequest($context . $value, $value);
			}
		}

		if (is_array($val)) {
			$val = $val['0'];
		}

		return $val;
	}

	function checkRequiredFields(&$required, $vars = '')
	{
		$pass = 1;
		foreach ($required as $key => $values) {
			$keyval = modAddToMenu::getVal($key, $vars);
			$values = explode(',', $values);
			foreach ($values as $val) {
				$pass = 0;
				switch ($val) {
					case '*':
						if (strlen($keyval)) {
							$pass = 1;
						}
						break;
					case '+':
						if ($keyval) {
							$pass = 1;
						}
						break;
					default:
						if ($keyval == $val) {
							$pass = 1;
						}
						break;
				}
				if ($pass) {
					break;
				}
			}
			if (!$pass) {
				break;
			}
			$this->vars[$key] = $keyval;
		}
		return $pass;
	}
}

<?php
/**
* @package Frontend-User-Access (com_frontenduseraccess)
* @version 4.1.6
* @copyright Copyright (C) 2008-2012 Carsten Engel. All rights reserved.
* @license GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html 
* @author http://www.pages-and-items.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class frontenduseraccessViewTemplates extends JView{

	//public $testcode = 'if(file_exists(JPATH_ROOT.DS.\'components\'.DS.\'com_frontenduseraccess\'.DS.\'checkaccess.php\')){';

	function display($tpl = null){
	
		$controller = new frontenduseraccessController();	
		$this->assignRef('controller', $controller);	
		
		$this->items = $this->get('Items');	
		
		$template_override = JRequest::getVar('template_override');	
		$do_undo = JRequest::getVar('do_undo');	
		
		$helper = new frontenduseraccessHelper();
		$this->assignRef('helper', $helper);		
		$files = $helper->get_files();			
		
		$template_overrides = array();
		$first = 1;		
		foreach($this->items as $template){		
			if($first){
				$this->first_template_name = str_replace('/', '-DS-', $template->name);
				$first = 0;
			}
			//check status and add to array
			for($n = 0; $n < count($files); $n++){
				
				$status = '';
				if($template_override==''){				
					$status = $this->check_template_override($files[$n], $template->name);
				}					
				
				$template_overrides[] = array($files[$n], $template->name, $status);
				
			}		
		}
		
		//$this->first_template_override = str_replace('/', '-DS-', $files[0]);
		$this->first_template_override = $files[0];		
		
		$template = JRequest::getVar('template');		
		$get_next = 0;
		$next_template_override = '';
		$next_template = '';
		if($template_override!=''){
			//processing files, so get next file and template
			$template_override = str_replace('-DS-', '/', $template_override);
			for($n = 0; $n < count($template_overrides); $n++){
				if($get_next){					
					$next_template_override = $template_overrides[$n][0];
					$next_template = $template_overrides[$n][1];
					break;
				}
				if($template_overrides[$n][0]==$template_override && $template_overrides[$n][1]==$template){
					$get_next = 1;					
					$new_status = $this->do_template_override($template_override, $template, $do_undo);											
				}			
			}	
			$this->new_status = $new_status;						
		}
		
		$this->do_undo = $do_undo;
		$this->next_template_override = $next_template_override;
		$this->next_template = $next_template;	
		$this->template = $template;	
		$this->template_override = $template_override;	
				
		$this->template_overrides = $template_overrides;		

		parent::display($tpl);
	}
	
	function check_template_override($template_override, $template){		
			
		$file = JPATH_ROOT.DS.'templates'.DS.$template.DS.'html'.DS.$template_override.'.php';	
		$status = '';
		
		$helper = new frontenduseraccessHelper();
		$get_code = $helper->get_code($template_override);		
		$code = $get_code[2];

		//check if file exists
		if(!file_exists($file)){
			$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_NO_TEMPLATE_OVERRIDE').'</span><br />';			
		}else{
			//file is there
			jimport( 'joomla.filesystem.file' );
			$fstring = JFile::read($file);
			if(!$fstring){
				//file not readable			
				$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_FILE_NOT_READABLE').'</span> '.JText::_('COM_FRONTENDUSERACCESS_MAKE_WRITEABLE').'<br />';
			}else{	
				//file readable	
				//check if code is in there
				if(strpos($fstring, $code)){
					//code is in there
					$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_CODE_IS_THERE').'</span><br />';							
				}else{
					//code is not in there
					$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_CODE_IS_NOT_THERE').'</span> ';
									
					//check if file is writeable
					if(!is_writable($file)){
						$status .= JText::_('COM_FRONTENDUSERACCESS_NOT_WRITEABLE').'. '.JText::_('COM_FRONTENDUSERACCESS_MAKE_WRITEABLE').'.<br />';			
					}
				}
			}			
		}			
		return $status;
	}
	
	function do_template_override($template_override, $template, $do_undo){
	
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );
		
		$file = JPATH_ROOT.DS.'templates'.DS.$template.DS.'html'.DS.$template_override.'.php';	
		
		$status = '';		
		
		$helper = new frontenduseraccessHelper();
		$get_code = $helper->get_code($template_override);	
		
		$source_file = $get_code[0];
		$path = $get_code[1];
		$code = $get_code[2];
				
		if($do_undo=='do'){
			//do template override
	
			//check if folders and file exists
			if(!file_exists($file)){	
			
				//create all needed folders				
				if (!JFolder::exists(JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.$path)){
					JFolder::create(JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.$path, 0755);
				}	
				
				//check folders
				if (!JFolder::exists(JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.$path)){
					$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_COULD_NOT_CREATE_FOLDER').'.</span> '.JText::_('COM_FRONTENDUSERACCESS_CHECK_TEMPLATES_WRITEABLE').' /templates<br />';	
				}else{			
				
					//try to copy the file from the original				
					if(!JFile::copy($source_file, $file)){					
						$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NO_TEMPLATE_OVERRIDE_CREATED').'</span><br />';
					}else{
						$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_TEMPLATE_OVERRIDE_CREATED').'</span><br />';		
					}
				
				}			
			}
			//end creating file
			
			//check file and add code if needed
			$fstring = JFile::read($file);
			if(!$fstring){	
				$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_FILE_NOT_READABLE').'</span><br />';
			}else{
				
				$not_defined_code = 'defined(\'_JEXEC\') or die;';
				
				if(strpos($fstring, $code)){
					//code is in there
					$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_CODE_IS_THERE').'</span><br />';
				}else{
					//code is not in there already
					if(!strpos($fstring, $not_defined_code)){	
						//wrong defined code in header				
						$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_FILE_CORRUPT').'</span>. '.JText::_('COM_FRONTENDUSERACCESS_TRY_MANUALLY_DELETE_CODE').'.<br />';					
					}else{
						//correct defined code in header
						$fstring = str_replace($not_defined_code, $not_defined_code.$code, $fstring);
						if(!JFile::write($file, $fstring)){
							//if not writeable
							$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NOT_WRITEABLE').'</span>. '.JText::_('COM_FRONTENDUSERACCESS_MAKE_WRITEABLE').'.<br />';	
						}else{
							//code has been added
							$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_CODE_HAS_BEEN_ADDED').'</span><br />';	
						}
					}
				}
			}
		
			//end do template override
		}else{
			//undo template stuff
			//$status = 'undo';
			
			//check if folders and file exists
			if(!file_exists($file)){
				$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_NO_TEMPLATE_OVERRIDE').'</span><br />';
				$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_CODE_IS_NOT_THERE').'</span><br />';
			}else{
				$fstring = JFile::read($file);
				if(!$fstring){
					//not readable
					$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_FILE_NOT_READABLE').'</span><br />';
				}else{
					//readable
					if(!strpos($fstring, $code)){
						//code is not in there
						$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_CODE_IS_NOT_THERE').'</span><br />';
					}else{
						//code is in file
						$fstring = str_replace($code, '', $fstring);
						if(!JFile::write($file, $fstring)){
							//if not writeable
							$status .= '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NOT_WRITEABLE').'</span>. '.JText::_('COM_FRONTENDUSERACCESS_MAKE_WRITEABLE').'.<br />';	
						}else{
							//code has been added
							$status .= '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_CODE_HAS_BEEN_TAKEN_OUT').'</span><br />';	
						}
					}					
				}
			}
		}
		
		
		return $status;
	}
	
	
	
}
?>
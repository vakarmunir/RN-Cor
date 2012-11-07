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

/*
if(!$this->controller->is_super_user){
	echo "<script> alert('you need to be logged in as a super administrator to edit the Frontend-User-Access config.'); window.history.go(-1); </script>";
	exit();
}
*/

//header
$this->controller->echo_header();

//make sure mootools is loaded for submitbutton script
JHTML::_('behavior.mootools');

$checked = ' checked="checked"';
$selected = ' selected="selected"';

?>

<script language="JavaScript" type="text/javascript">



Joomla.submitbutton = function(task){
	if (task == 'config_save') {
		submitform('config_save');
	}
	if (task == 'config_apply') {	
		document.getElementById('sub_task').value = 'apply';
		submitform('config_save');
	}		
	if (task == 'cancel') {
		document.location.href = 'index.php?option=com_frontenduseraccess';		
	}	
}

function check_latest_version(){
	document.getElementById('version_checker_target').innerHTML = document.getElementById('version_checker_spinner').innerHTML;
	ajax_url = 'index.php?option=com_frontenduseraccess&task=ajax_version_checker&format=raw';
	var req = new Request.HTML({url:ajax_url, update:'version_checker_target' });	
	req.send();
}

<?php

$tab = $this->controller->get_var('tab', false);	

if(!$tab){
	
	echo "cookie_value = getCookie('fua_tabs');"."\n";	
	echo "if(cookie_value!=null){"."\n";		
		echo "current_tab = cookie_value;"."\n";
	echo "}else{"."\n";		
		echo "setCookie('fua_tabs', 'general_settings', '', '', '', '');"."\n";
		echo "current_tab = 'general_settings';"."\n";
	echo "}"."\n";
}else{
	echo "setCookie('fua_tabs', '".$tab."', '', '', '', '');"."\n";
	echo "current_tab = '".$tab."';"."\n";
}

?>

function get_tab(tab){
	if(tab!=current_tab){
		new_tab = 'tab_'+tab;	
		document.getElementById(new_tab).className = 'on';
		old_tab = 'tab_'+current_tab;	
		document.getElementById(old_tab).className = 'none';
		document.getElementById(tab).style.display = 'block';	
		document.getElementById(current_tab).style.display = 'none';
		current_tab = tab;
		setCookie('fua_tabs', tab, '', '', '', '');
	}
}

function pi_config_menu_init(){
	current_tab_name = 'tab_'+current_tab;	
	document.getElementById(current_tab_name).className = 'on';
	document.getElementById(current_tab).style.display = 'block';	
}

if(window.addEventListener)window.addEventListener("load",pi_config_menu_init,false);else if(window.attachEvent)window.attachEvent("onload",pi_config_menu_init);

</script>

<form name="adminForm" method="post" action="">
	<input type="hidden" name="option" value="com_frontenduseraccess" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="sub_task" id="sub_task" value="" />	
	<?php echo JHTML::_( 'form.token' ); ?>	
	<div style="margin: 0 auto; text-align: left;">					
		<ul id="fua_menu">				
			<li>
				<a id="tab_general_settings" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('general_settings');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_GENERAL'); ?></span></a>
			</li>
			<li>
				<a id="tab_users" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('users');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_USERS'); ?></span></a>
			</li>				
			<li>
				<a id="tab_item_access" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('item_access');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS'); ?></span></a>
			</li>
			<li>
				<a id="tab_category_access" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('category_access');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_CATEGORY_ACCESS'); ?></span></a>
			</li>				
			<li>
				<a id="tab_module_access" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('module_access');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_MODULE_ACCESS'); ?></span></a>
			</li>		
			<li>
				<a id="tab_component_access" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('component_access');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_COMPONENT_ACCESS'); ?></span></a>
			</li>			
			<li>
				<a id="tab_menu_access" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('menu_access');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_MENU_ACCESS'); ?></span></a>
			</li>	
			<li>
				<a id="tab_part_access" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('part_access');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_PART_ACCESS'); ?></span></a>
			</li>			
			<li>
				<a id="tab_paid_content" onfocus="if(this.blur)this.blur();" href="javascript:get_tab('paid_content');"><span><?php echo JText::_('COM_FRONTENDUSERACCESS_PAID_CONTENT'); ?></span></a>
			</li>			
		</ul>				
		<div id="general_settings">
		<table class="adminlist fua_table">			
			<tr>
				<th colspan="3" align="left">									
					<?php echo JText::_('COM_FRONTENDUSERACCESS_GENERAL'); ?>
				</th>
			</tr>	
			<tr>		
				<td width="230">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ENABLE'); ?> Frontend-User-Access		
				</td>
				<td>
					<label style="white-space: nowrap;"><input type="radio" name="fua_enabled" value="1" class="radio" <?php if($this->controller->fua_config['fua_enabled']=='1'){echo 'checked="checked"';} ?> /><?php echo $this->controller->fua_strtolower(JText::_('COM_FRONTENDUSERACCESS_ENABLE')); ?></label><br />					
					<label style="white-space: nowrap;"><input type="radio" name="fua_enabled" value="0" class="radio" <?php if(!$this->controller->fua_config['fua_enabled']){echo 'checked="checked"';} ?> /><?php echo $this->controller->fua_strtolower(JText::_('JTOOLBAR_DISABLE')); ?></label>				
				</td>
				<td>
					<?php 
					echo JText::_('COM_FRONTENDUSERACCESS_ENABLE_INFO').'.'; 
					
					?>	
				</td>
			</tr>		
			<tr>		
				<td width="230">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_CACHE'); ?>		
				</td>
				<td style="white-space: nowrap;">
					<?php 
					 $config =& JFactory::getConfig();
        			if ($config->getValue('caching')){					
						echo '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_IS_ENABLED').'</span>';
					}else{
						echo '<span class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_IS_NOT_ENABLED').'</span>';
					}			
				?>					
				</td>
				<td>
					<?php 
					echo JText::_('COM_FRONTENDUSERACCESS_CACHE_INFO').'<br />'; 
					echo JText::_('COM_FRONTENDUSERACCESS_CACHE_INFO2'); 
					echo ' <a href="index.php?option=com_config">';
					echo JText::_('COM_FRONTENDUSERACCESS_GLOBAL_CONFIG');
					echo '</a> ';
					echo JText::_('COM_FRONTENDUSERACCESS_CACHE_INFO3').'.'; 
					?>	
				</td>
			</tr>					
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_STATUSBOT'); ?> (system)
				</td>
				<td style="white-space: nowrap;">
					<?php 
					if($this->controller->bot_installed_system){
						echo '<div class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_BOTINSTALLED').'</div>';				
					}else{
						echo '<div class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTINSTALLED').'</div>';
					}										
					if($this->controller->bot_published_system){
						echo '<div class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_BOTPUBLISHED').'</div>';		
					}else{
						echo '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTPUBLISHED').'</span>';
						echo ' <a href="index.php?option=com_frontenduseraccess&task=enable_plugin&type=system">'.JText::_('COM_FRONTENDUSERACCESS_ENABLE_PLUGIN').'</a>';
					}	
					//check ordering of system plugin
					if($this->system_plugin_correct_order){
						echo '<div class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_CORRECT_ORDER').'</div>';				
					}else{						
						echo '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BAD_ORDER').'</span>';
						echo ' <a href="index.php?option=com_frontenduseraccess&task=reorder_system_plugin">'.JText::_('COM_FRONTENDUSERACCESS_REORDER_PLUGIN').'</a>';
					}			
					?>
				</td>
				<td>					
					<?php					
						echo JText::_('COM_FRONTENDUSERACCESS_SYSTEM_PLUGIN_ORDER');
						echo ': \'System - One Click Action\' '.JText::_('COM_FRONTENDUSERACCESS_AND').' \'System - Admin Tools\'. ';
						echo '<br />'.JText::_('COM_FRONTENDUSERACCESS_ORDER_NOT_NULL').' 0. '.JText::_('COM_FRONTENDUSERACCESS_RECOMMENDED').' -29000.';
					?>					
				</td>
			</tr>			
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_STATUSBOT'); ?> (user)					
				</td>
				<td style="white-space: nowrap;">				
					<?php 
							
					if($this->controller->bot_installed_user){
						echo '<div class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_BOTINSTALLED').'</div>';				
					}else{
						echo '<div class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTINSTALLED').'</div>';
					}
					if($this->controller->bot_published_user){
						echo '<div class="fua_green">'.JText::_('COM_FRONTENDUSERACCESS_BOTPUBLISHED').'</div>';				
					}else{
						echo '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_BOTNOTPUBLISHED').'</span>';
						echo ' <a href="index.php?option=com_frontenduseraccess&task=enable_plugin&type=user">'.JText::_('COM_FRONTENDUSERACCESS_ENABLE_PLUGIN').'</a>';
					}				
					?>
				</td>
				<td>					
				</td>
			</tr>																
			<tr>		
				<td>
					<?php echo $this->controller->fua_strtolower(JText::_('JVERSION')); ?>	
				</td>
				<td style="white-space: nowrap;">
					<?php echo $this->controller->version.' ('.$this->controller->fua_version_type.' '.$this->controller->fua_strtolower(JText::_('JVERSION')).')'; ?>
				</td>
				<td>
					<input type="button" value="<?php echo JText::_('COM_FRONTENDUSERACCESS_CHECK_LATEST_VERSION'); ?>" onclick="check_latest_version();" />					
					<div id="version_checker_target"></div>	
					<span id="version_checker_spinner"><img src="components/com_frontenduseraccess/images/processing.gif" alt="processing" /></span>				
				</td>
			</tr>	
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_VERSION_CHECKER'); ?>	
				</td>
				<td>
					<label><input type="checkbox" class="checkbox" name="version_checker" value="true" <?php if($this->controller->fua_config['version_checker']){echo 'checked="checked"';} ?> /> <?php echo $this->controller->fua_strtolower(JText::_('COM_FRONTENDUSERACCESS_ENABLE')); ?></label>
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_VERSION_CHECKER_INFO'); ?>.				
				</td>
			</tr>			
			<tr>		
				<td colspan="3">&nbsp;
					
				</td>
			</tr>
			</table>
			</div>
			<div id="users">
			<table class="adminlist fua_table">			
			<tr>
				<th colspan="3" align="left">				
					<?php echo JText::_('COM_FRONTENDUSERACCESS_USERS'); ?>
				</th>
			</tr>			
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_DEFAULT_USERGROUP'); ?>
				</td>
				<td>
					<table>
						<tr>
							<td>
							<?php
								$this->controller->db->setQuery("SELECT * FROM #__fua_usergroups WHERE (id<>'9') AND (id<>'10') ORDER BY name");
								$fua_usergroups = $this->controller->db->loadObjectList();
								
								//get the configured default usergroups
								$default_usergroup = $this->controller->fua_config['default_usergroup'];
								$default_usergroup = $this->controller->csv_to_array($default_usergroup);
							?>					
							<select name="default_usergroup[]" multiple="multiple" size="5">
								<?php						
								if(count($fua_usergroups)){	
									echo '<option value="0">'.JText::_('COM_FRONTENDUSERACCESS_NONE').'</option>';									
									foreach($fua_usergroups as $row){								
										echo '<option ';
										if(in_array($row->id, $default_usergroup)){
											echo $selected;
										}
										echo 'value="'.$row->id.'">';														
										echo $row->name;
										echo '</option>';									
									}
								}
								?>	
							</select>
							</td>
							<td>
								<?php
								foreach($fua_usergroups as $row){
										if(in_array($row->id, $default_usergroup)){
											echo $row->name.'<br />';
										}								
									}
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<?php 					
					echo JText::_('COM_FRONTENDUSERACCESS_DEFAULT_USERGROUP_INFO'); 									
					?>					
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ASSIGN_USERGROUP_FROM_SELECT_ON_REGISTRATION_FORM'); ?>
				</td>
				<td>
					<label><input type="checkbox" class="checkbox" name="enable_from_select_to_group" value="true" <?php if($this->controller->fua_config['enable_from_select_to_group']){echo 'checked="checked"';} ?> /> <?php echo $this->controller->fua_strtolower(JText::_('COM_FRONTENDUSERACCESS_ENABLE')); ?></label>
					<br />
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REGISTRATION_FORM'); ?>:
					<br />
					&lt;?php<br />
					<textarea name="from_select_to_group" style="width: 300px;" rows="8" cols="60"><?php echo $this->controller->fua_config['from_select_to_group']; ?></textarea><br />
					?&gt;
					<br />
					<label><input type="checkbox" class="checkbox" name="enable_from_select_to_group_update" id="enable_from_select_to_group_update" value="true" <?php if($this->controller->fua_config['enable_from_select_to_group_update']){echo 'checked="checked"';} ?> /> <?php echo JText::_('COM_FRONTENDUSERACCESS_ENABLE_SELECT_TO_GROUP_UPDATE'); ?>.</label>
					<br />
					<?php echo JText::_('COM_FRONTENDUSERACCESS_UPDATE_FORM'); ?>:
					<br />
					&lt;?php<br />
					<textarea name="from_select_to_group_update" style="width: 300px;" rows="8" cols="60"><?php echo $this->controller->fua_config['from_select_to_group_update']; ?></textarea><br />
					?&gt;<br />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ASSIGN_USERGROUP_FROM_SELECT_ON_REGISTRATION_FORM_INFO'); ?>:										
					<br />
					<br />
					<select name="cb_relationshiptocamp">									
						<option value="camper">camper</option>
						<option value="parent">parent</option>								
						<option value="staff">staff</option>																	
						<option value="other">other</option>
					</select>
					<br />
					<br />
					&lt;select name=&quot;cb_relationshiptocamp&quot;&gt; <br />
&nbsp;&nbsp;&nbsp;&lt;option value=&quot;camper&quot;&gt;camper&lt;/option&gt;<br />
&nbsp;&nbsp;&nbsp;&lt;option value=&quot;parent&quot;&gt;parent&lt;/option&gt; <br />
&nbsp;&nbsp;&nbsp;&lt;option value=&quot;staff&quot;&gt;staff&lt;/option&gt; <br />
&nbsp;&nbsp;&nbsp;&lt;option value=&quot;other&quot;&gt;other&lt;/option&gt;<br />
&lt;/select&gt;
					<br />
					<br />
					<textarea name="exampletextarea" style="width: 100%; color: #666;" rows="7" cols="60">
$value = JRequest::getVar('cb_relationshiptocamp', '');
if($value=='camper'){
   $groups = '12'; 
}elseif($value=='parent'){
   $groups = '13'; 
}elseif($value=='staff'){
   $groups = '14,67,38'; 
}</textarea>		
					<br />
					<br />					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_AVAILABLE_ARE'); ?>: $user_id, $database, $current_groups.
					<br />
					<a href="http://www.pages-and-items.com/extensions/frontend-user-access/faqs/assign-users-to-group-from-select-on-registration-form" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_READ_MORE'); ?></a>			
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ENABLE_REDIRECTING'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="redirecting_enabled" value="true" <?php if($this->controller->fua_config['redirecting_enabled']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ENABLE_REDIRECTING_INFO'); ?>					
				</td>
			</tr>			
			<tr>		
				<td>
					<?php 
					echo JText::_('COM_FRONTENDUSERACCESS_REDIRECT_AFTER_LOGIN'); 					
					$redirect_url = '';
					if($this->controller->fua_config['redirect_url']){
						$redirect_url = $this->controller->fua_config['redirect_url'];
					}					
					?>					
				</td>
				<td width="350">
					<input type="text" name="redirect_url" value="<?php echo $redirect_url; ?>" style="width: 300px;" /><br />
					<?php echo JText::_('COM_FRONTENDUSERACCESS_EXAMPLE'); ?>:<br />
					index.php?option=com_content&amp;view=article&amp;id=19&amp;Itemid=27<br />	
					<?php echo JText::_('COM_FRONTENDUSERACCESS_OR'); ?><br />	
					http://www.pages-and-items.com	
				</td>
				<td>
					<?php 
					echo JText::_('COM_FRONTENDUSERACCESS_REDIRECT_AFTER_LOGIN_INFO').'.';
					?>
					<br />
					<br />
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ORDERING_INFO'); ?>. <a href="index.php?option=com_frontenduseraccess&view=usergroups"><?php echo JText::_('COM_FRONTENDUSERACCESS_REDIRECT_AFTER_LOGIN_SET_USERGROUP_ORDER'); ?></a>.					
				</td>
			</tr>
			<tr>		
				<td colspan="3">&nbsp;
					
				</td>
			</tr>			
			</table>
			</div>				
			<div id="item_access">
			<table class="adminlist fua_table">						
			<tr>
				<th colspan="3" align="left">
					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS'); ?>
				</th>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ITEMS_ACTIVATE'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="items_active" value="true" <?php if($this->controller->fua_config['items_active']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ITEMS_INFO').'. '.JText::_('COM_FRONTENDUSERACCESS_NOACCESS_IS_HIDDEN').'.<br />'.JText::_('COM_FRONTENDUSERACCESS_ONLY_IN_COM_CONTENT2').' (com_content) '.JText::_('COM_FRONTENDUSERACCESS_AND').' '.JText::_('COM_FRONTENDUSERACCESS_MODULES').': mod_articles_archive, mod_articles_categories, mod_articles_category, mod_articles_latest, mod_articles_news '.JText::_('COM_FRONTENDUSERACCESS_AND').' mod_articles_popular.'; ?>					
				</td>
			</tr>	
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="items_reverse_access" value="true" <?php if($this->controller->fua_config['items_reverse_access']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS_INFO'); ?>.					
				</td>
			</tr>	
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT'); ?>
				</td>
				<td>
					<label style="white-space: nowrap;"><input type="radio" name="items_multigroup_access_requirement" value="one_group" class="radio" <?php if($this->controller->fua_config['items_multigroup_access_requirement']=='one_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_ONE_GROUP'); ?></label><br />					
					<label style="white-space: nowrap;"><input type="radio" name="items_multigroup_access_requirement" value="every_group" class="radio" <?php if($this->controller->fua_config['items_multigroup_access_requirement']=='every_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_EVERY_GROUP'); ?></label>
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT_INFO'); ?>.					
				</td>
			</tr>					
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MESSAGETYPE_ITEMS'); ?><br />(option=com_content&amp;view=artcle)
				</td>
				<td colspan="2">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_NO_ACCESS_MESSAGE'); ?>:
					<input type="text" name="message_no_item_access_full" class="long_text_field" value="<?php if($this->controller->fua_config['message_no_item_access_full']){echo $this->controller->fua_config['message_no_item_access_full'];}else{echo JText::_('COM_FRONTENDUSERACCESS_NO_ACCESS_PAGE');} ?>" /><br />
					<label><input type="radio" name="items_message_type" value="alert" class="radio" <?php if($this->controller->fua_config['items_message_type']=='alert'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_COMPONENTS_MESSAGE_TYPE_ALERT'); ?></label><br />					
					<label><input type="radio" name="items_message_type" value="only_text" class="radio" <?php if($this->controller->fua_config['items_message_type']=='only_text'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_MESSAGE_TYPE_ONLY_TEXT'); ?></label><br />
					<label><input type="radio" name="items_message_type" value="redirect" class="radio" <?php if($this->controller->fua_config['items_message_type']=='redirect'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_REDIRECT_TO_URL'); ?></label>:
					<?php
					$no_item_access_full_url = '';
					if($this->controller->fua_config['no_item_access_full_url']){
						$no_item_access_full_url = $this->controller->fua_config['no_item_access_full_url'];
					}
					?>
					<input type="text" name="no_item_access_full_url" class="long_text_field" value="<?php echo $no_item_access_full_url; ?>" />
					<br />
					<label><input type="radio" name="items_message_type" value="login" class="radio" <?php if($this->controller->fua_config['items_message_type']=='login'){echo 'checked="checked"';} ?> /><?php echo $this->controller->fua_strtolower(JText::_('JLOGIN')); ?></label>
				</td>
			</tr>				
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_TRUNCATE_ARTICLE_TITLE'); ?>
				</td>
				<td>
					<?php 
					
					$selected = 'selected="selected"'; 					
					echo '<select name="truncate_article_title">';
					echo '<option value="">'.JText::_('COM_FRONTENDUSERACCESS_NONE').'</option>';
					$truncate_array = array(30, 40, 50, 60, 70, 80, 100);
					foreach($truncate_array as $truncate_number){		
						echo '<option value="'.$truncate_number.'"';
						if($this->controller->fua_config['truncate_article_title']==$truncate_number){
							echo $selected;
						}				
						echo '>'.$truncate_number.'</option>';						
					}
					echo '</select>';
					
					?>					
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_TRUNCATE_ARTICLE_TITLE_INFO'); ?>.					
				</td>
			</tr>			
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_A'); ?>
				</td>
				<td colspan="2">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_INFO_C').' (\''.JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS').'\', \''.JText::_('COM_FRONTENDUSERACCESS_CATEGORY_ACCESS').'\'), '.JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_INFO_B'); ?>.<br />
					<?php					
					if($this->controller->fua_version_type=='free'){
						echo '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NOT_IN_FREE').'.</span><br />';
					}
					?>
					<label><input type="radio" name="content_access_together" value="every_group" class="radio" <?php if($this->controller->fua_config['content_access_together']=='every_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_EVERY_GROUP'); ?></label><br />					
					<label><input type="radio" name="content_access_together" value="one_group" class="radio" <?php if($this->controller->fua_config['content_access_together']=='one_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_ONE_GROUP'); ?></label>
				</td>
			</tr>						
			<tr>		
				<td colspan="3">&nbsp;
					
				</td>
			</tr>	
			</table>
			</div>			
			<div id="category_access">
			<?php $this->controller->not_in_free_version(); ?>
			<table class="adminlist fua_table">					
			<tr>
				<th colspan="3" align="left">
					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_CATEGORY_ACCESS'); ?>
				</th>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_ACTIVATECATEGORIES'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="categories_active" value="true" <?php if($this->controller->fua_config['categories_active']){echo 'checked="checked"';} ?> />
				</td>
				<td>					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_CATEGORIES_INFO_B').'. '.JText::_('COM_FRONTENDUSERACCESS_NOACCESS_IS_HIDDEN_CATEGORIES').'.<br />'.JText::_('COM_FRONTENDUSERACCESS_ONLY_IN_COM_CONTENT2').' (com_content) '.JText::_('COM_FRONTENDUSERACCESS_AND').' '.JText::_('COM_FRONTENDUSERACCESS_MODULES').': mod_articles_archive, mod_articles_categories, mod_articles_category, mod_articles_latest, mod_articles_news '.JText::_('COM_FRONTENDUSERACCESS_AND').' mod_articles_popular.'; ?>	
				</td>
			</tr>	
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="category_reverse_access" value="true" <?php if($this->controller->fua_config['category_reverse_access']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT'); ?>
				</td>
				<td>
					<label style="white-space: nowrap;"><input type="radio" name="category_multigroup_access_requirement" value="one_group" class="radio" <?php if($this->controller->fua_config['category_multigroup_access_requirement']=='one_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_ONE_GROUP'); ?></label><br />					
					<label style="white-space: nowrap;"><input type="radio" name="category_multigroup_access_requirement" value="every_group" class="radio" <?php if($this->controller->fua_config['category_multigroup_access_requirement']=='every_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_EVERY_GROUP'); ?></label>
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT_INFO'); ?>.					
				</td>
			</tr>			
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MESSAGETYPE_CATEGORY'); ?>
				</td>
				<td colspan="2">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_SEE_ARTICLE_ACCESS').' \''.JText::_('COM_FRONTENDUSERACCESS_MESSAGETYPE_ITEMS').'\' '.JText::_('COM_FRONTENDUSERACCESS_ON_TAB'); ?> <a href="javascript: get_tab('item_access');"><?php echo JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS'); ?></a>.					
				</td>
			</tr>			
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_A'); ?>
				</td>
				<td colspan="2">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_INFO_C').' (\''.JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS').'\', \''.JText::_('COM_FRONTENDUSERACCESS_CATEGORY_ACCESS').'\'), '.JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_INFO_B'); ?>.<br />
					<?php echo JText::_('COM_FRONTENDUSERACCESS_SEE_ARTICLE_ACCESS').' \''.JText::_('COM_FRONTENDUSERACCESS_CONTENT_ACCESS_TOGETHER_A').'\' '.JText::_('COM_FRONTENDUSERACCESS_ON_TAB'); ?> <a href="javascript: get_tab('item_access');"><?php echo JText::_('COM_FRONTENDUSERACCESS_ITEM_ACCESS'); ?></a>.
				</td>
			</tr>		
			<tr>		
				<td colspan="3">&nbsp;
					
				</td>
			</tr>
			</table>
			</div>							
			<div id="module_access">
			<?php $this->controller->not_in_free_version(); 
			
			?>			
			<table class="adminlist fua_table">						
			<tr>
				<th colspan="3" align="left">
					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MODULE_ACCESS'); ?>
				</th>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_USE_MODULEACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" name="modules_active" value="true" <?php if($this->controller->fua_config['modules_active']){echo 'checked="checked"';} ?> />
				</td>
				<td><?php
				echo JText::_('COM_FRONTENDUSERACCESS_MODULES_INFO').'.';
				?>
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="modules_reverse_access" value="true" <?php if($this->controller->fua_config['modules_reverse_access']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT'); ?>
				</td>
				<td>
					<label style="white-space: nowrap;"><input type="radio" name="modules_multigroup_access_requirement" value="one_group" class="radio" <?php if($this->controller->fua_config['modules_multigroup_access_requirement']=='one_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_ONE_GROUP'); ?></label><br />					
					<label style="white-space: nowrap;"><input type="radio" name="modules_multigroup_access_requirement" value="every_group" class="radio" <?php if($this->controller->fua_config['modules_multigroup_access_requirement']=='every_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_EVERY_GROUP'); ?></label>
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT_INFO'); ?>.					
				</td>
			</tr>			
			<tr>
				<td colspan="3">&nbsp;
																								
				</td>
			</tr>			
			</table>
			</div>			
			<div id="component_access">			
			<table class="adminlist fua_table">						
			<tr>
				<th colspan="3" align="left">					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_COMPONENT_ACCESS'); ?>
				</th>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_USE_COMPONENTACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" name="use_componentaccess" value="true" <?php if($this->controller->fua_config['use_componentaccess']){echo 'checked="checked"';} ?> />
				</td>
				<td><?php echo JText::_('COM_FRONTENDUSERACCESS_COMPONENTS_INFO').'.'; ?>
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="component_reverse_access" value="true" <?php if($this->controller->fua_config['component_reverse_access']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT'); ?>
				</td>
				<td>
					<label style="white-space: nowrap;"><input type="radio" name="component_multigroup_access_requirement" value="one_group" class="radio" <?php if($this->controller->fua_config['component_multigroup_access_requirement']=='one_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_ONE_GROUP'); ?></label><br />					
					<label style="white-space: nowrap;"><input type="radio" name="component_multigroup_access_requirement" value="every_group" class="radio" <?php if($this->controller->fua_config['component_multigroup_access_requirement']=='every_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_EVERY_GROUP'); ?></label>
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_COMPONENTS_MESSAGE_TYPE'); ?>
				</td>
				<td colspan="2">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_NO_ACCESS_MESSAGE'); ?>:
					<input type="text" name="message_no_component_access" class="long_text_field" value="<?php if($this->controller->fua_config['message_no_component_access']){echo $this->controller->fua_config['message_no_component_access'];}else{echo JText::_('COM_FRONTENDUSERACCESS_NO_ACCESS_PAGE');} ?>" /><br />
					<label><input type="radio" name="components_message_type" value="alert" class="radio" <?php if($this->controller->fua_config['components_message_type']=='alert'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_COMPONENTS_MESSAGE_TYPE_ALERT'); ?></label><br />					
					<label><input type="radio" name="components_message_type" value="only_text" class="radio" <?php if($this->controller->fua_config['components_message_type']=='only_text'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_MESSAGE_TYPE_ONLY_TEXT'); ?></label><br />
					<label><input type="radio" name="components_message_type" value="redirect" class="radio" <?php if($this->controller->fua_config['components_message_type']=='redirect'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_REDIRECT_TO_URL'); ?></label>:
					<?php
					$no_component_access_url = '';
					if($this->controller->fua_config['no_component_access_url']){
						$no_component_access_url = $this->controller->fua_config['no_component_access_url'];
					}
					?>
					<input type="text" name="no_component_access_url" class="long_text_field" value="<?php echo $no_component_access_url; ?>" />
					<br />
					<label><input type="radio" name="components_message_type" value="login" class="radio" <?php if($this->controller->fua_config['components_message_type']=='login'){echo 'checked="checked"';} ?> /><?php echo $this->controller->fua_strtolower(JText::_('JLOGIN')); ?></label>
				</td>				
			</tr>
			<tr>
				<td colspan="3">&nbsp;
																								
				</td>
			</tr>			
			</table>
			</div>	
			<div id="menu_access">	
			<?php $this->controller->not_in_free_version(); ?>		
			<table class="adminlist fua_table">						
			<tr>
				<th colspan="3" align="left">					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MENU_ACCESS'); ?>
				</th>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_USE_MENU_ACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" name="use_menuaccess" value="true" <?php if($this->controller->fua_config['use_menuaccess']){echo 'checked="checked"';} ?> />
				</td>
				<td>
				<?php 
					echo JText::_('COM_FRONTENDUSERACCESS_MENU_INFO4').'.';					
					?>
					<br /><br />
					<input type="checkbox" name="mod_menu_override" value="true" <?php if($this->controller->fua_config['mod_menu_override']){echo 'checked="checked"';} ?> />
					<?php 
					echo JText::_('COM_FRONTENDUSERACCESS_MOD_MAINMENU_OVERRIDE_B').'.<br />';	
					echo JText::_('COM_FRONTENDUSERACCESS_ERROR_OVERRIDE_A').':<br /><span style="font-family: courier;">Cannot redeclare class modMenuHelper in /home/[mysitefolder]/public_html/modules/mod_menu/helper.php on line 16</span><br />';	
					echo JText::_('COM_FRONTENDUSERACCESS_ERROR_OVERRIDE_B').'.';					
					?>
					<br /><br />
					<?php
					echo '<a href="http://www.pages-and-items.com/extensions/frontend-user-access/faqs/hide-menu-items-in-other-menu-modules-then-the-joomla-menu-module" target="_blank">'.JText::_('COM_FRONTENDUSERACCESS_MAKE_YOUR_MENU_WORK_WITH_FUA').'</a>.';
					$config =& JFactory::getConfig();
					if(!$config->getValue('sef')){
						echo '<br /><br />'; 
						echo '<span class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_SEF_NOT_ENABLED').'</span>.';
						echo ' '.JText::_('COM_FRONTENDUSERACCESS_CACHE_INFO2');
						echo ' <a href="index.php?option=com_config">';
						echo JText::_('COM_FRONTENDUSERACCESS_GLOBAL_CONFIG');
						echo '</a> ';
						echo JText::_('COM_FRONTENDUSERACCESS_ON_TAB_SITE').'.';						
						echo '';
					}				
				?>
				</td>
			</tr>			
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="menu_reverse_access" value="true" <?php if($this->controller->fua_config['menu_reverse_access']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT'); ?>
				</td>
				<td>
					<label style="white-space: nowrap;"><input type="radio" name="menu_multigroup_access_requirement" value="one_group" class="radio" <?php if($this->controller->fua_config['menu_multigroup_access_requirement']=='one_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_ONE_GROUP'); ?></label><br />					
					<label style="white-space: nowrap;"><input type="radio" name="menu_multigroup_access_requirement" value="every_group" class="radio" <?php if($this->controller->fua_config['menu_multigroup_access_requirement']=='every_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_EVERY_GROUP'); ?></label>
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MENUACCESS_MESSAGE_TYPE'); 
					
					//set default when updating
					if(!$this->controller->fua_config['menuaccess_message_type']){
						$this->controller->fua_config['menuaccess_message_type'] = 'text';
					}
					
					?>
				</td>
				<td colspan="2">	
					<?php echo JText::_('COM_FRONTENDUSERACCESS_NO_ACCESS_MESSAGE'); ?>:
					<input type="text" name="message_no_menu_access" class="long_text_field" value="<?php if($this->controller->fua_config['message_no_menu_access']){echo $this->controller->fua_config['message_no_menu_access'];}else{echo JText::_('COM_FRONTENDUSERACCESS_NO_ACCESS_PAGE');} ?>" /><br />				
					<label><input type="radio" name="menuaccess_message_type" value="alert" class="radio" <?php if($this->controller->fua_config['menuaccess_message_type']=='alert'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_COMPONENTS_MESSAGE_TYPE_ALERT'); ?></label><br />							
					<label><input type="radio" name="menuaccess_message_type" value="only_text" class="radio" <?php if($this->controller->fua_config['menuaccess_message_type']=='only_text'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_MESSAGE_TYPE_ONLY_TEXT'); ?>.</label><br />
					<label><input type="radio" name="menuaccess_message_type" value="redirect" class="radio" <?php if($this->controller->fua_config['menuaccess_message_type']=='redirect'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_REDIRECT_TO_URL'); ?></label>:
					<?php
					$no_menu_access_url = '';
					if($this->controller->fua_config['no_menu_access_url']){
						$no_menu_access_url = $this->controller->fua_config['no_menu_access_url'];
					}
					?>
					<input type="text" name="no_menu_access_url" class="long_text_field" value="<?php echo $no_menu_access_url; ?>" />
					<br />
					<label><input type="radio" name="menuaccess_message_type" value="login" class="radio" <?php if($this->controller->fua_config['menuaccess_message_type']=='login'){echo 'checked="checked"';} ?> /><?php echo $this->controller->fua_strtolower(JText::_('JLOGIN')); ?></label>						
				</td>				
			</tr>					
			<tr>
				<td colspan="3">&nbsp;
																								
				</td>
			</tr>	
			</table>
			</div>
			<div id="part_access">	
			<table class="adminlist">						
			<tr>
				<th colspan="3" align="left">					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_PART_ACCESS'); ?>
				</th>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_ACTIVATE'); ?>
				</td>
				<td>
					<input type="checkbox" name="parts_active" value="true" <?php if($this->controller->fua_config['parts_active']){echo 'checked="checked"';} ?> />
				</td>
				<td><?php
				echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO').'.<br /><br />';
			echo JText::_('COM_FRONTENDUSERACCESS_EXAMPLE');
			?>
			1 : <input type="text" name="parts_example" value="{fua_part id=3} <?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_WHEN_ACCESS'); ?> {/fua_part}" class="long_text_field"  style="border:0; width: 500px;" /><br />
			<?php
			
			echo JText::_('COM_FRONTENDUSERACCESS_EXAMPLE');
			?>
			2 : <input type="text" name="parts_example2" value="{fua_part id=3} <?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_WHEN_ACCESS'); ?> {else} <?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_WHEN_NO_ACCESS'); ?> {/fua_part}" class="long_text_field" style="border:0; width: 500px;" />
			<?php
			echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO_FOUR').'.';
			echo '<br /><br />';
			echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO_TWO').'.';
			echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO_THREE').'.';
				?>
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS'); ?>
				</td>
				<td>
					<input type="checkbox" class="checkbox" name="parts_reverse_access" value="true" <?php if($this->controller->fua_config['parts_reverse_access']){echo 'checked="checked"';} ?> />
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_REVERSE_ACCESS_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT'); ?>
				</td>
				<td>
					<label style="white-space: nowrap;"><input type="radio" name="parts_multigroup_access_requirement" value="one_group" class="radio" <?php if($this->controller->fua_config['parts_multigroup_access_requirement']=='one_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_ONE_GROUP'); ?></label><br />					
					<label style="white-space: nowrap;"><input type="radio" name="parts_multigroup_access_requirement" value="every_group" class="radio" <?php if($this->controller->fua_config['parts_multigroup_access_requirement']=='every_group'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_EVERY_GROUP'); ?></label>
				</td>
				<td>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_MULTIGROUP_ACCESS_REQUIREMENT_INFO'); ?>.					
				</td>
			</tr>
			<tr>		
				<td width="300">
					<?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_NOT_ACTIVATE'); ?>
				</td>
				<td colspan="2">	
					<?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_NOT_ACTIVATE_INFO'); ?>.<br />
					<label><input type="radio" name="parts_not_active" value="as_access" class="radio" <?php if($this->controller->fua_config['parts_not_active']=='as_access'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_NOT_ACTIVATE_ACCESS'); ?>.</label><br />
					<label><input type="radio" name="parts_not_active" value="as_no_access" class="radio" <?php if($this->controller->fua_config['parts_not_active']=='as_no_access'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_NOT_ACTIVATE_NOACCESS'); ?>.</label><br />
					<label><input type="radio" name="parts_not_active" value="nothing" class="radio" <?php if($this->controller->fua_config['parts_not_active']=='nothing'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_NOT_ACTIVATE_NOTHING'); ?>.</label><br />					
					<label><input type="radio" name="parts_not_active" value="code" class="radio" <?php if($this->controller->fua_config['parts_not_active']=='code'){echo 'checked="checked"';} ?> /><?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_NOT_ACTIVATE_SHOWCODE'); ?>. (<?php echo JText::_('COM_FRONTENDUSERACCESS_PARTS_NOT_ACTIVATE_NOTHING_TWO'); ?>).</label><br />					
					
				</td>				
			</tr>			
			<tr>
				<td colspan="3">&nbsp;
																								
				</td>
			</tr>			
			</table>
			</div>		
			<div id="paid_content">				
			<table class="adminlist fua_table">						
			<tr>
				<th colspan="3" align="left">					
					<?php echo JText::_('COM_FRONTENDUSERACCESS_PAID_CONTENT'); ?>
				</th>
			</tr>
			<tr>							
				<td width="800">				
					<?php echo JText::_('COM_FRONTENDUSERACCESS_PAID_CONTENT_INFO_A'); ?>:
					<ul>
						<li>
							<a href="http://extensions.joomla.org/extensions/e-commerce/subscriptions/10723" target="_blank">AEC</a> 							
						</li>
						<li>
							<a href="http://extensions.joomla.org/extensions/e-commerce/paid-membership-a-subscriptions/16566" target="_blank">Payplans</a>
						</li>
						<li>
							<a href="http://extensions.joomla.org/extensions/e-commerce/shopping-cart/11340" target="_blank">Tienda</a>
						</li>
					</ul>	
					<a href="http://www.pages-and-items.com/extensions/frontend-user-access/subscriptions-and-paid-content" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_READ_MORE'); ?></a>	
				</td>
				<td>&nbsp;
				</td>		
				<td>&nbsp;
				</td>			
			</tr>			
			<tr>
				<td colspan="3">&nbsp;																								
				</td>
			</tr>					
			</table>
			</div>					
		</div>
</form>
<?php
$this->controller->display_footer();
?>
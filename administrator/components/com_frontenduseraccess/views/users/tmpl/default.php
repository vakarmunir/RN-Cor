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

//header and nav
$this->controller->echo_header();

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
	
JHtml::_('behavior.tooltip');
?>
<script language="JavaScript" type="text/javascript">

function toggle_exact_field(){
	if(document.adminForm.exact.value == '' || document.adminForm.exact.value == 'not_exact_mode'){		
		document.adminForm.exact.value = 'exact_mode';
	}else{
		document.adminForm.exact.value = 'not_exact_mode';
	}	
}

Joomla.submitbutton = function(task){		
	if (task=='users_export'){	
		document.location.href = 'index.php?option=com_frontenduseraccess&view=users&layout=csv';		
	} else {
		submitform('users_save');
	}	
}

function selected_values_to_string(element){
	
	//make selected stuff into array
	value_array = new Array();
	v = 0;
	for(i = 0; i < element.length; i++){			 
		if(element.options[i].selected){			
			temp = element[i].value;
			//alert('temp'+temp);
			value_array[v] = temp;			
			v++;
		}
	}
	
	//sort array
	value_array.sort();
	
	//make array to string
	values = '';
	first = true;
	for(i = 0; i < value_array.length; i++){
		if(first){
			first = false;
		}else{
			values = values+'-';
		} 	
		temp = value_array[i];					
		values = values+temp;		
	}
	
	return values;
}

function batch_form_submit(batch_type){	
	url = 'index.php?option=com_frontenduseraccess&view=batchassign&tmpl=component&';
	if(batch_type=='batch_assign_jtofua'){		
		if(confirm('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_SURE_BATCH_JTOFUA')); ?>')){			
			j = document.adminForm.batch_assign_jtofua_jgroup.value;
			f = document.adminForm.batch_assign_jtofua_fuagroup;			
			values = selected_values_to_string(f);			
			document.location.href = url+'j='+j+'&f='+values+'&batchtype=jf';
		}
	}
	if(batch_type=='batch_assign_fuatofua'){
		f1 = document.adminForm.batch_assign_fuatofua_old.value;
		f2 = document.adminForm.batch_assign_fuatofua_new.value;		
		mode = 'multi';
		if(document.adminForm.single.checked){
			mode = 'single';
		}
		if(f1==f2){
			alert('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_CAN_NOT_MOVE_TO_SAME_GROUP')); ?>');
		}else{
			if(confirm('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_SURE_BATCH_FUATOFUA')); ?>')){				
				document.location.href = url+'f1='+f1+'&f2='+f2+'&batchtype=ff&mode='+mode;
			}
		}		
	}
	if(batch_type=='batch_assign_fuatofuamulti'){
		f1 = document.adminForm.batch_assign_fuatofuamulti_old;
		values1 = selected_values_to_string(f1);
		f2 = document.adminForm.batch_assign_fuatofuamulti_new;
		values2 = selected_values_to_string(f2);
		if(values1=='' || values2==''){
			alert('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_NOUSERGROUPSELECTED')); ?>');
		}else{
			if(values1==values2){
				alert('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_CAN_NOT_MOVE_TO_SAME_GROUPS')); ?>');
			}else{
				if(confirm('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_SURE_BATCH_FUATOFUAS')); ?>')){				
					document.location.href = url+'f1='+values1+'&f2='+values2+'&batchtype=ffmulti';
				}
			}
		}	
	}
}

</script>
<form name="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_frontenduseraccess&view=users'); ?>">	
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />	
	<?php echo JHTML::_( 'form.token' ); ?>	
		
<table id="fua_subheader_users">
	<tr>
		<td>
		<p><?php echo JText::_('COM_FRONTENDUSERACCESS_NOT_SUPERADMIN'); ?>.</p>		
		<input type="text" name="users_search" id="users_search" value="<?php echo $this->state->get('filter.search'); ?>" class="text_area"  />	
		&nbsp;	
		<?php
		$selected = 'selected="selected"';
		
		echo JText::_('COM_FRONTENDUSERACCESS_JOOMLAGROUP').': '; 		
		?>
		<select name="users_joomla_group_filter"  id="users_joomla_group_filter">
			<option value=""><?php echo JText::_('JALL');?></option>
			<?php echo JHtml::_('select.options', $this->get_groups(), 'value', 'text', $this->state->get('filter.joomla_group'));?>
		</select>
		</td>
		<td style="padding-left: 10px;">
		<?php
		echo ucfirst(JText::_('COM_FRONTENDUSERACCESS_USERGROUPS')).': '; 
		?>					
		<p style="text-align: right; padding: 0; margin: 0;">
		<label class="hasTip" title="<?php echo JText::_('COM_FRONTENDUSERACCESS_EXACT').'::'.JText::_('COM_FRONTENDUSERACCESS_EXACT_INFO').'. '.JText::_('COM_FRONTENDUSERACCESS_EXACT_INFO2'); ?>"><?php echo JText::_('COM_FRONTENDUSERACCESS_EXACT'); ?></label>
		<input type="checkbox" value="1" name="toggle_exact" onclick="toggle_exact_field();" <?php
		if($this->state->get('filter.exact')=='exact_mode'){
			echo 'checked="checked"';
		}
		?> />
		<input type="hidden" value="<?php echo $this->state->get('filter.exact'); ?>" name="exact" />
		</p>
		</td>
		<td>
		<?php
		echo '<select name="usergroup_filter[]" id="usergroup_filter" multiple="multiple" size="7">';
		echo '<option value="0"';
		if($this->state->get('filter.usergroups_csv')==''){
			echo $selected;
		}
		echo '>'.JText::_('JALL').'</option>';			
		foreach($this->fua_usergroups as $usergroup){		
			echo '<option value="'.$usergroup->id.'"';						
			if(in_array($usergroup->id, $this->state->get('filter.usergroups'))){
				echo $selected;
			}	
			echo '>'.$usergroup->name.'</option>';						
		}
		echo '</select>';	
		//echo $this->state->get('filter.usergroups_csv');	
		?>
		&nbsp;
		<button onclick="this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
		&nbsp;
		<button onclick="document.getElementById('users_search').value='';document.getElementById('users_joomla_group_filter').value='';document.getElementById('usergroup_filter').value='0';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</td>
	</tr>
</table>		
<table class="adminlist">
	<tr>
		<th style="text-align: center;">
			id					
		</th>
		<th align="left">			
			<?php 
			$label = ucfirst(JText::_('COM_FRONTENDUSERACCESS_NAME')).' '; 			
			echo JHTML::_('grid.sort', $label, 'u.name', $listDirn, $listOrder); 
			?>
		</th>
		<th align="left">			
			<?php 
			$label = ucfirst(JText::_('COM_FRONTENDUSERACCESS_USERNAME')).' '; 			
			echo JHTML::_('grid.sort', $label, 'u.username', $listDirn, $listOrder); 
			?>
		</th>
		<th align="left">			
			<?php 
			$label = ucfirst(JText::_('COM_FRONTENDUSERACCESS_EMAIL')).' '; 			
			echo JHTML::_('grid.sort', $label, 'u.email', $listDirn, $listOrder); 
			?>
		</th>		
		<th align="left">			
			<?php 
			$label = ucfirst(JText::_('COM_FRONTENDUSERACCESS_JOOMLAGROUP')).' '; 			
			echo JHTML::_('grid.sort', $label, 'gid', $listDirn, $listOrder); 
			?>
		</th>		
		<th align="left">			
			<?php 
			$label = ucfirst(JText::_('COM_FRONTENDUSERACCESS_USERGROUPS')).' '; 			
			echo JHTML::_('grid.sort', $label, 'i.group_id', $listDirn, $listOrder); 
			?>				
		</th>		
	</tr>	

<?php
//print_r($this->items);
$k = 0;
for($i=0; $i < count( $this->items ); $i++) {
	$row = $this->items[$i];
		
	echo '<tr class="row'.$k.'">';
	echo '<td class="column_ids">';
	echo '<input type="hidden" name="user_id[]" value="'.$row->id.'" />';
	echo $row->id;
	echo '</td>';
	echo '<td width="25%">'.$row->name.'</td><td>'.$row->username.'</td><td><a href="mailto:'.$row->email.'">'.$row->email;
	echo '</a></td>';	
	echo '<td>';
	echo $row->gid;
	/*
	$gids = explode(',', $row->gid);
	foreach($gids as $gid){
		echo $this->group_id_index_array[$gid].'<br />';
	}
	*/	
	echo '</td>';	
	echo '<td>';	
	echo '<table>';
	echo '<tr>';
	echo '<td style="padding: 0;">';
	//echo $row->fua_usergroups;
	$row_users_fua_groups_array = $this->controller->csv_to_array($row->fua_usergroups);
	//print_r($row_users_fua_groups_array);
	echo '<select name="usergroups['.$row->id.'][]" multiple="multiple" size="5">';
	echo '<option value="0"> -- '.$this->controller->fua_strtolower(JText::_('COM_FRONTENDUSERACCESS_NONE')).' -- </option>';
	$users_groups_string = '';
	foreach($this->fua_usergroups as $fua_usergroup){
		if(in_array($fua_usergroup->id, $row_users_fua_groups_array)){
			$selected = ' selected="selected"';
			$users_groups_string .= $fua_usergroup->name.'<br />';
		}else{
			$selected = '';
		}		
		echo '<option value="'.$fua_usergroup->id.'" '.$selected.'>'.$fua_usergroup->name.'</option>';						
	}				
	echo '</select>';
	echo '</td>';
	echo '<td style="padding: 0 0 0 5px;">';	
	echo $users_groups_string;	
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '</td>';
	echo '</tr>';
	if($k==1){
		$k = 0;
	}else{
		$k = 1;
	}	
}
if(count($this->items)==0){
	echo '<tr><td colspan="6">'.JText::_('COM_FRONTENDUSERACCESS_NOUSERS').' <a href="index.php?option=com_users&task=view">user manager</a>.</td></tr>';
}else{
	echo '<tfoot><tr><td colspan="6">'.$this->pagination->getListFooter().'</td></tr></tfoot>';
	
}
?>
	
</table>
<br />
<table class="adminlist">
	<tr>		
		<th colspan="2"><?php echo JText::_('COM_FRONTENDUSERACCESS_BATCH_ASSIGN_USERS'); ?>					
		</th>
	</tr>
	<tr>		
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_FROM').' '.JText::_('COM_FRONTENDUSERACCESS_JOOMLAGROUP'); ?><br />					
			<select name="batch_assign_jtofua_jgroup">
				<option value=""> - <?php echo JText::_('COM_FRONTENDUSERACCESS_SELECT_USERGROUP');?> - </option>
				<?php echo JHtml::_('select.options', $this->get_groups(), 'value', 'text', 0);?>
			</select>
			<br />					
			<?php echo JText::_('COM_FRONTENDUSERACCESS_TO').' '.JText::_('COM_FRONTENDUSERACCESS_USERGROUP'); ?><br />
			<select name="batch_assign_jtofua_fuagroup" multiple="multiple" size="5">
				<?php
				if(count($this->fua_usergroups)){	
					echo '<option value="0">'.JText::_('COM_FRONTENDUSERACCESS_NONE').'</option>';									
					foreach($this->fua_usergroups as $row){								
						echo '<option value="'.$row->id.'">';														
						echo $row->name;
						echo '</option>';									
					}
				}
				?>						
			</select><br /><br />
			<input type="button" value="<?php echo JText::_('COM_FRONTENDUSERACCESS_GO'); ?>" onclick="batch_form_submit('batch_assign_jtofua')" />
		</td>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_BATCH_ASSIGN_USERS_INFO_JTOFUA').'.'; ?>
		</td>
	</tr>	
	<tr>		
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_FROM').' '.JText::_('COM_FRONTENDUSERACCESS_USERGROUP'); ?><br />
			<select name="batch_assign_fuatofua_old">
				<?php
				if(count($this->fua_usergroups)){	
					echo '<option value="0">'.JText::_('COM_FRONTENDUSERACCESS_NONE').'</option>';									
					foreach($this->fua_usergroups as $row){								
						echo '<option value="'.$row->id.'">';														
						echo $row->name;
						echo '</option>';									
					}
				}
				?>	
			</select><br />					
			<?php echo JText::_('COM_FRONTENDUSERACCESS_TO').' '.JText::_('COM_FRONTENDUSERACCESS_USERGROUP'); ?><br />
			<select name="batch_assign_fuatofua_new">
				<?php
				if(count($this->fua_usergroups)){	
					echo '<option value="0">'.JText::_('COM_FRONTENDUSERACCESS_NONE').'</option>';									
					foreach($this->fua_usergroups as $row){								
						echo '<option value="'.$row->id.'">';														
						echo $row->name;
						echo '</option>';									
					}
				}
				?>						
			</select><br /><br />
			<input type="button" value="<?php echo JText::_('COM_FRONTENDUSERACCESS_GO'); ?>" onclick="batch_form_submit('batch_assign_fuatofua')" />
		</td>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_BATCH_ASSIGN_USERS_INFO_FUATOFUA'); ?>.<br />
			
			<label><input type="radio" name="batch_assign_fuatofua_mode" value="single" id="single" class="radio" />				
			<?php echo JText::_('COM_FRONTENDUSERACCESS_BATCH_ASSIGN_USERS_INFO_FUATOFUA2'); ?></label><br />
			<label><input type="radio" name="batch_assign_fuatofua_mode" value="multi" checked="checked" class="radio" />				
			<?php echo JText::_('COM_FRONTENDUSERACCESS_BATCH_ASSIGN_USERS_INFO_FUATOFUA3'); ?></label>					
		</td>
	</tr>	
	<tr>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_FROM').' '.JText::_('COM_FRONTENDUSERACCESS_USERGROUPS'); ?><br />
			<select name="batch_assign_fuatofuamulti_old" multiple="multiple" size="5">
				<?php
				if(count($this->fua_usergroups)){	
					echo '<option value="0">'.JText::_('COM_FRONTENDUSERACCESS_NONE').'</option>';									
					foreach($this->fua_usergroups as $row){								
						echo '<option value="'.$row->id.'">';														
						echo $row->name;
						echo '</option>';									
					}
				}
				?>	
			</select><br />					
			<?php echo JText::_('COM_FRONTENDUSERACCESS_TO').' '.JText::_('COM_FRONTENDUSERACCESS_USERGROUPS'); ?><br />
			<select name="batch_assign_fuatofuamulti_new" multiple="multiple" size="5">
				<?php
				if(count($this->fua_usergroups)){	
					echo '<option value="0">'.JText::_('COM_FRONTENDUSERACCESS_NONE').'</option>';									
					foreach($this->fua_usergroups as $row){								
						echo '<option value="'.$row->id.'">';														
						echo $row->name;
						echo '</option>';									
					}
				}
				?>						
			</select><br /><br />
			<input type="button" value="<?php echo JText::_('COM_FRONTENDUSERACCESS_GO'); ?>" onclick="batch_form_submit('batch_assign_fuatofuamulti')" />
		</td>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_BATCH_ASSIGN_USERS_INFO_FUATOFUA4'); ?>.
		</td>
	</tr>	
</table>
</form>
<?php
$this->controller->display_footer();
?>
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
		
$components_db = array();
$components_options_gone = array();
foreach($this->items as $component_db_all){
	$component_name = $component_db_all->name;
	$component_option = $component_db_all->element;
	$component_id = $component_db_all->extension_id;
	$component_leveltitle = $component_db_all->leveltitle;
	//filter out pi_itemtypes and com_cpanel
	if(!strpos($component_option, '_pi_itemtype_') && $component_option!='com_cpanel' && $component_option!='' && $component_option!='com_frontenduseraccess' && $component_name!='Contact Categories' && $component_name!='Web Link Categories'){	
		//give com_category an option
		if($component_name=='Categories' || $component_name=='Manage Categories'){
			$component_option = 'com_categories';									
		}
		if(!in_array($component_option, $components_options_gone)){
			$components_options_gone[] = $component_option;
			$component_name = str_replace('com_', '', $component_name);
			$components_db[] = array($component_name, $component_option, $component_id, $component_leveltitle);
		}
	}
}	

//make javascript array from components
$javascript_array_components = 'var components = new Array(';
for($n = 0; $n < count($components_db); $n++){	
	if($n==0){
		$first = false;
	}else{
		$javascript_array_components .= ',';
	}
	$javascript_array_components .= "'".$components_db[$n][1]."'";
}	
$javascript_array_components .= ');';

?>

<script language="javascript" type="text/javascript">

<?php echo $javascript_array_components."\n"; ?>

function select_all(usergroup_id, select_all_id){
	action = document.getElementById(select_all_id).checked;		
	for (i = 0; i < components.length; i++){
		box_id = components[i]+'__'+usergroup_id;
		hidden_id = components[i]+'__'+usergroup_id+'__hidden';
		if(action==true){
			document.getElementById(box_id).checked = true;
			document.getElementById(hidden_id).value = hidden_id+'__1';
		}else{
			document.getElementById(box_id).checked = false;
			document.getElementById(hidden_id).value = hidden_id+'__';
		}
	}	
}

function toggle_right(hidden_field_id){
	field = document.getElementById(hidden_field_id);
	if(field.value==hidden_field_id+'__1'){
		field.value = hidden_field_id+'__';
	}else{
		field.value = hidden_field_id+'__1';
	}
}

</script>
<form name="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_frontenduseraccess&view=components'); ?>">	
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />		
	<?php echo JHTML::_( 'form.token' ); ?>	
<table id="fua_subheader">
	<tr>
		<td>
			<?php echo '<p>'.JText::_('COM_FRONTENDUSERACCESS_COMPONENTS_INFO').'.</p>';	

			//legend and message if reverse access	
			$this->controller->reverse_access_warning('component_reverse_access');
			
			//message if component access is not activated
			if($this->controller->fua_config['use_componentaccess']==false){				
				echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NO_COMPONENT_ACTIVE').'. <a href="index.php?option=com_frontenduseraccess&view=config&tab=component_access">'.JText::_('COM_FRONTENDUSERACCESS_ACTIVATE_IN_CONFIG').'</a><br/><br/></div>';
			}	
						
			 ?>
			<input type="text" name="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" class="text_area" />
			&nbsp;
			<button onclick="this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			&nbsp;
			<button onclick="document.adminForm.filter_search.value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</td>
		<td id="td_usergroup_selector">
			<?php 
			//echo $this->controller->accesscolumn_selector($this->state->get('accesscolumn')); 
			echo $this->controller->usergroup_selector(); 
			?>
		</td>
	</tr>
</table>	
<table class="adminlist">
	<tr>		
		<th style="text-align: center;">
			id						
		</th>
		<th align="left">&nbsp;
			<?php 
			$label = ucfirst(JText::_('JFIELD_TITLE_DESC')).' '; 			
			echo JHTML::_('grid.sort', $label, 'e.name', $listDirn, $listOrder); 			
			?>				
		</th>
		<?php
			if($this->state->get('accesscolumn')=='yes' && 'temp_disabled'=='true'){
		?>
		<th>
			<?php
				echo '<label class="hasTip" title="'.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVEL').'::Frontend-User-Access '.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVELS_INFO_A').'. Frontend-User-Access '.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVELS_INFO_B').'. Frontend-User-Access '.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVELS_INFO_C').'.">';
				$label = ucfirst(JText::_('JFIELD_ACCESS_LABEL')).' '; 			
				echo JHTML::_('grid.sort', $label, 'l.title', $listDirn, $listOrder); 	
				echo '</label>';
			?>
		</th>
		<?php	
			}//end if show accesscolumn		
			$this->controller->loop_usergroups($this->fua_usergroups);			
		?>			
	</tr>
		
	<?php
		
		//row with select_all checkboxes
		echo '<tr class="row0">';
		echo '<td>&nbsp;</td>';
		echo '<td align="left">'.JText::_('COM_FRONTENDUSERACCESS_SELECTALL').'</td>';
		if($this->state->get('accesscolumn')=='yes' && 'temp_disabled'=='true'){	
			echo '<td>&nbsp;</td>';
		}
		foreach($this->fua_usergroups as $fua_usergroup){
			echo '<td style="text-align:center;"><input type="checkbox" name="checkall[]" value="" id="checkall_'.$fua_usergroup->id.'" onclick="select_all('.$fua_usergroup->id.',this.id);" /></td>';
		}
		echo '</tr>';
				
		$k = 1;		
		$counter = 0;	
		for($n = 0; $n < count($components_db); $n++){			
			echo '<tr class="row'.$k.'">';
			echo '<td class="column_ids">'.$components_db[$n][2].'</td>';
			echo '<td>'.$components_db[$n][0].' ('.$components_db[$n][1].')</td>';	
			if($this->state->get('accesscolumn')=='yes' && 'temp_disabled'=='true'){		
				echo '<td>';	
				echo $components_db[$n][3];
				echo '</td>';
			}		
			foreach($this->fua_usergroups as $fua_usergroup){
				$checked = '';
				$checked_hidden = '';
				if (in_array($components_db[$n][1].'__'.$fua_usergroup->id, $this->access_components)) {
					$checked = 'checked="checked"';
					$checked_hidden = '1';
				}
				echo '<td align="center"><input type="hidden" name="components_access_hidden[]" id="'.$components_db[$n][1].'__'.$fua_usergroup->id.'__hidden" value="'.$components_db[$n][1].'__'.$fua_usergroup->id.'__hidden__'.$checked_hidden.'" /><input type="checkbox" name="componentsAccess[]" id="'.$components_db[$n][1].'__'.$fua_usergroup->id.'" onclick="toggle_right(\''.$components_db[$n][1].'__'.$fua_usergroup->id.'__hidden\');" value="'.$components_db[$n][1].'__'.$fua_usergroup->id.'" '.$checked.' /></td>';
			}
			echo '</tr>';
			if($k==1){
				$k = 0;
			}else{
				$k = 1;
			}			
			if($counter==7){
				echo '<tr><th>&nbsp;</th><th>&nbsp;</th>';	
				if($this->state->get('accesscolumn')=='yes' && 'temp_disabled'=='true'){	
					echo '<th>&nbsp;</th>';	
				}
				$this->controller->loop_usergroups($this->fua_usergroups);
				echo '</tr>';
				$counter = 0;
			}
			$counter = $counter+1;	
		}	
	?>
			
</table>
<table class="adminlist">
	<tfoot>
		<tr>
			<td>
			<?php 
				echo $this->pagination->getListFooter();
			?>
			</td>
		</tr>
	</tfoot>
</table>
</form>
<?php
$this->controller->display_footer();
?>
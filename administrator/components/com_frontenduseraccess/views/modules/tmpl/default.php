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

$fua_modules_array = array();
foreach($this->items as $fua_module){
	$fua_module_id = $fua_module->id;
	$fua_module_title = $fua_module->title;	
	$fua_module_leveltitle = $fua_module->leveltitle;	
	$fua_module_published = $fua_module->published;
	$fua_modules_array[] = array($fua_module_id, $fua_module_title, $fua_module_leveltitle, $fua_module_published);	
}	

//make javascript array from components
$javascript_array_modules = 'var modules = new Array(';
for($n = 0; $n < count($fua_modules_array); $n++){	
	if($n==0){
		$first = false;
	}else{
		$javascript_array_modules .= ',';
	}
	$javascript_array_modules .= "'".$fua_modules_array[$n][0]."'";
}	
$javascript_array_modules .= ');';

//echo $javascript_array_modules;
//echo $n;
?>
<script language="javascript" type="text/javascript">

<?php echo $javascript_array_modules."\n"; ?>

function select_all(usergroup_id, select_all_id){
	action = document.getElementById(select_all_id).checked;		
	for (i = 0; i < modules.length; i++){
		box_id = modules[i]+'__'+usergroup_id;
		hidden_id = modules[i]+'__'+usergroup_id+'__hidden';
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
<form name="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_frontenduseraccess&view=modules'); ?>">	
	<input type="hidden" name="task" value="" />	
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />				
		<?php echo JHTML::_( 'form.token' ); ?>	
<table id="fua_subheader">
	<tr>
		<td>
			<?php 
				echo '<p>'.JText::_('COM_FRONTENDUSERACCESS_MODULES_INFO').'. '.JText::_('COM_FRONTENDUSERACCESS_MODULES_INFO3').'.</p>';
				
				//legend and message if reverse access	
				$this->controller->reverse_access_warning('modules_reverse_access');
				
				//message in free version that these restrictions will not work in free version
				$this->controller->not_in_free_version();					
				
				//message if component access is not activated
				if($this->controller->fua_config['modules_active']==false){				
					echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NO_MODULES_ACTIVE').'. <a href="index.php?option=com_frontenduseraccess&view=config&tab=module_access">'.JText::_('COM_FRONTENDUSERACCESS_ACTIVATE_IN_CONFIG').'</a><br/><br/></div>';
				}				
				?>
				<input type="text" name="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" class="text_area"  />
				&nbsp;
				<button onclick="this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
				&nbsp;
				<button onclick="document.adminForm.filter_search.value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
				&nbsp;				
				<select name="filter_state" class="inputbox" onchange="this.form.submit()">
					<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
					<?php echo JHtml::_('select.options', $this->getStateOptions(), 'value', 'text', $this->state->get('filter.state'));?>
				</select>
				&nbsp;
				<select name="filter_access" class="inputbox" onchange="this.form.submit()">
					<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
					<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
				</select>
				&nbsp;
				<select name="filter_position" class="inputbox" onchange="this.form.submit()">
					<option value=""> - <?php echo JText::_('COM_FRONTENDUSERACCESS_SELECT_POSITION');?> - </option>
					<?php echo JHtml::_('select.options', $this->getPositions(0), 'value', 'text', $this->state->get('filter.position'));?>
				</select>
				&nbsp;
				<select name="filter_module" class="inputbox" onchange="this.form.submit()">
					<option value=""> - <?php echo JText::_('COM_FRONTENDUSERACCESS_SELECT_MODULE');?> - </option>
					<?php echo JHtml::_('select.options', $this->getModules(0), 'value', 'text', $this->state->get('filter.module'));?>
				</select>
				&nbsp;
				<select name="filter_language" class="inputbox" onchange="this.form.submit()">
					<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
					<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
				</select>
							
		</td>
		<td id="td_usergroup_selector">
			<?php 
			echo $this->controller->accesscolumn_selector($this->state->get('accesscolumn')); 
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
		<th align="left">
			<?php 
			$label = ucfirst(JText::_('JFIELD_TITLE_DESC')).' '; 			
			echo JHTML::_('grid.sort', $label, 'm.title', $listDirn, $listOrder); 			
			?>				
		</th>
		<?php
		if($this->state->get('accesscolumn')=='yes'){
		?>
		<th>
			<?php
				echo '<label class="hasTip" title="'.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVEL').'::Frontend-User-Access '.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVELS_INFO_A').'. Frontend-User-Access '.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVELS_INFO_B').'. Frontend-User-Access '.JText::_('COM_FRONTENDUSERACCESS_JOOMLA_ACCESS_LEVELS_INFO_C').'.">';
				$label = ucfirst(JText::_('JFIELD_ACCESS_LABEL')).' '; 			
				echo JHTML::_('grid.sort', $label, 'al.title', $listDirn, $listOrder); 	
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
		if($this->state->get('accesscolumn')=='yes'){	
			echo '<td>&nbsp;</td>';
		}
		foreach($this->fua_usergroups as $fua_usergroup){
			echo '<td style="text-align:center;"><input type="checkbox" name="checkall[]" value="" id="checkall_'.$fua_usergroup->id.'" onclick="select_all('.$fua_usergroup->id.',this.id);" /></td>';
		}
		echo '</tr>';
				
		$k = 1;		
		$counter = 0;	
		for($n = 0; $n < count($fua_modules_array); $n++){			
			echo '<tr class="row'.$k.'"><td class="column_ids">'.$fua_modules_array[$n][0].'</td>';
			$has_superscript = '';
			if($fua_modules_array[$n][3]=='0'){
				$has_superscript = ' class="has_superscript"';
			}
			echo '<td'.$has_superscript.'>'.$fua_modules_array[$n][1];
			if($fua_modules_array[$n][3]=='0'){
				echo '<sup class="fua_superscript">1</sup>';
			}
			echo '</td>';
			if($this->state->get('accesscolumn')=='yes'){		
				echo '<td>';	
				echo $fua_modules_array[$n][2];
				echo '</td>';
			}			
			foreach($this->fua_usergroups as $fua_usergroup){
				$checked = '';
				$checked_hidden = '';
				if (in_array($fua_modules_array[$n][0].'__'.$fua_usergroup->id, $this->access_modules)) {
					$checked = 'checked="checked"';					
					$checked_hidden = '1';
				}
				echo '<td align="center"><input type="hidden" name="module_access_hidden[]" id="'.$fua_modules_array[$n][0].'__'.$fua_usergroup->id.'__hidden" value="'.$fua_modules_array[$n][0].'__'.$fua_usergroup->id.'__hidden__'.$checked_hidden.'" /><input type="checkbox" name="module_access[]" id="'.$fua_modules_array[$n][0].'__'.$fua_usergroup->id.'" onclick="toggle_right(\''.$fua_modules_array[$n][0].'__'.$fua_usergroup->id.'__hidden\');" value="'.$fua_modules_array[$n][0].'__'.$fua_usergroup->id.'" '.$checked.' /></td>';
			}
			echo '</tr>';
			if($k==1){
				$k = 0;
			}else{
				$k = 1;
			}			
			if($counter==7){
				echo '<tr><th colspan="2">&nbsp;</th>';	
				if($this->state->get('accesscolumn')=='yes'){	
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
<table>
	<tr>
		<td class="fua_red">1
		</td>
		<td>=
		</td>
		<td><?php echo JText::_('COM_FRONTENDUSERACCESS_NOT_PUBLISHED_B'); ?>.
		</td>
	</tr>	
</table>
</form>
<?php
$this->controller->display_footer();
?>
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

//make javascript array from parts
$javascript_array_parts = 'var parts = new Array(';
$first = true;
foreach($this->items as $part){		
	if($first){
		$first = false;
	}else{
		$javascript_array_parts .= ',';
	}
	$javascript_array_parts .= "'".$part->id."'";
}	
$javascript_array_parts .= ');';
		
?>
<script language="javascript" type="text/javascript">

<?php echo $javascript_array_parts."\n"; ?>

function select_all(usergroup_id, select_all_id){
	action = document.getElementById(select_all_id).checked;	
	for (i = 0; i < parts.length; i++){
		box_id = parts[i]+'__'+usergroup_id;
		hidden_id = parts[i]+'__'+usergroup_id+'__hidden';
		if(action==true){
			document.getElementById(box_id).checked = true;
			document.getElementById(hidden_id).value = hidden_id+'__1';
		}else{
			document.getElementById(box_id).checked = false;
			document.getElementById(hidden_id).value = hidden_id+'__';
		}
	}	
}

Joomla.submitbutton = function(task){
	if (task == 'part') {			
		document.location.href = 'index.php?option=com_frontenduseraccess&view=part&sub_task=new';		
	}		
	if (task == 'part_delete') {
		if (document.adminForm.boxchecked.value == '0') {						
			alert('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_NOSELECTPART')); ?>');
			return;
		} else {
			if(confirm("<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_SUREDELETEPART')); ?>")){
				submitform('part_delete');
			}
		}
	}
	if (task == 'access_parts_save') {
		submitform('access_parts_save');
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
<form name="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_frontenduseraccess&view=parts'); ?>">	
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />	
	<input type="hidden" name="boxchecked" value="0" />	
	<?php echo JHTML::_( 'form.token' ); ?>	
<table id="fua_subheader">
	<tr>
		<td>
			<?php echo '<p>';
			echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO').'.<br /><br />';
			echo JText::_('COM_FRONTENDUSERACCESS_EXAMPLE');
			?>
			1 : <input type="text" name="parts_example" value="{fua_part id=3} <?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_WHEN_ACCESS'); ?> {/fua_part}" class="long_text_field"  style="border:0; font-weight: bold; width: 550px;" /><br />
			<?php
			
			echo JText::_('COM_FRONTENDUSERACCESS_EXAMPLE');
			?>
			2 : <input type="text" name="parts_example2" value="{fua_part id=3} <?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_WHEN_ACCESS'); ?> {else} <?php echo JText::_('COM_FRONTENDUSERACCESS_CONTENT_WHEN_NO_ACCESS'); ?> {/fua_part}" class="long_text_field" style="border:0; font-weight: bold; width: 550px;" />
			<?php
			echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO_FOUR').'.';
			echo '<br /><br />';
			echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO_TWO').'.';
			echo JText::_('COM_FRONTENDUSERACCESS_PARTS_INFO_THREE').'.';
			echo '</p>';

			//legend and message if reverse access	
			$this->controller->reverse_access_warning('parts_reverse_access');			
			
			//message if parts access is not activated	
			if($this->controller->fua_config['parts_active']==false){				
				echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NO_PARTS_ACTIVE').'. <a href="index.php?option=com_frontenduseraccess&view=config&tab=part_access">'.JText::_('COM_FRONTENDUSERACCESS_ACTIVATE_IN_CONFIG').'</a><br/><br/></div>';
			}	
			
			?>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" class="text_area"  />			
			&nbsp;
			<button onclick="this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			&nbsp;
			<button onclick="document.adminForm.filter_search.value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>			
		</td>
		<td id="td_usergroup_selector">
			<?php			
			echo $this->controller->usergroup_selector(); 
			?>
		</td>
	</tr>
</table>		
<table class="adminlist">
	<tr>	
		<th width="5" align="left">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />			
		</th>	
		<th style="text-align: center;">
			id			
		</th>	
		<th align="left">				
			<?php 
			$label = ucfirst(JText::_('COM_FRONTENDUSERACCESS_NAME')).' '; 			
			echo JHTML::_('grid.sort', $label, 'p.name', $listDirn, $listOrder); 			
			?>				
		</th>	
		<?php				
			$this->controller->loop_usergroups($this->fua_usergroups);			
		?>		
		
	</tr>
		
	<?php
							
		$k = 1;		
		
		//row with select_all checkboxes
		echo '<tr class="row1">';
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
		echo '<td>'.JText::_('COM_FRONTENDUSERACCESS_SELECTALL').'</td>';		
		foreach($this->fua_usergroups as $fua_usergroup){
			echo '<td style="text-align:center;"><input type="checkbox" name="checkall[]" value="" id="checkall_'.$fua_usergroup->id.'" onclick="select_all('.$fua_usergroup->id.',this.id);" /></td>';
		}
		echo '</tr>';
		
		$counter = 0;	
		foreach($this->items as $part){	
			if($k==1){
				$k = 0;
			}else{
				$k = 1;
			}				
			echo '<tr class="row'.$k.'">';
			echo '<td><input type="checkbox" id="cb'.$counter.'" name="cid[]" value="'.$part->id.'" onclick="isChecked(this.checked);" /></td>';
			echo '<td class="column_ids">'.$part->id.'</td>';			
			echo '<td>';			
			echo '<a href="index.php?option=com_frontenduseraccess&view=part&id='.$part->id.'">';	
			if($part->description!=''){
				echo '<label class="hasTip" title="'.$part->name.'::'.$part->description.'">';
			}			
			echo $part->name;
			if($part->description!=''){
				echo '</label>';
			}
			echo '</a></td>';					
			foreach($this->fua_usergroups as $fua_usergroup){
				$checked = '';
				$checked_hidden = '';
				if (in_array($part->id.'__'.$fua_usergroup->id, $this->access_parts)) {
					$checked = 'checked="checked"';
					$checked_hidden = '1';
				}
				echo '<td style="text-align:center;"><input type="hidden" name="part_access_hidden[]" id="'.$part->id.'__'.$fua_usergroup->id.'__hidden" value="'.$part->id.'__'.$fua_usergroup->id.'__hidden__'.$checked_hidden.'" /><input type="checkbox" name="part_access[]" id="'.$part->id.'__'.$fua_usergroup->id.'" onclick="toggle_right(\''.$part->id.'__'.$fua_usergroup->id.'__hidden\');" value="'.$part->id.'__'.$fua_usergroup->id.'" '.$checked.' /></td>';
			}
			echo '</tr>';			
			if($counter==7){
				echo '<tr><th>&nbsp;</th><th>&nbsp;</th>';					
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
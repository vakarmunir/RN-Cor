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

<script language="javascript" type="text/javascript">

<?php

//make javascript array from categories
$javascript_array_menuitems = 'var menuitems = new Array(';
$first = true;
foreach($this->items as $item){		
	if($first){
		$first = false;
	}else{
		$javascript_array_menuitems .= ',';
	}
	$javascript_array_menuitems .= "'".$item->id."'";
}	
$javascript_array_menuitems .= ');';

echo $javascript_array_menuitems."\n";

/*
//make javascript array from usergroups
$javascript_array_usergroups = 'var usergroups = new Array(';
$first = true;
foreach($this->fua_usergroups as $usergroup){
	if($first){
		$first = false;
	}else{
		$javascript_array_usergroups .= ',';
	}
	$javascript_array_usergroups .= '"'.$usergroup->id.'"';
}
$javascript_array_usergroups .= ');';
echo $javascript_array_usergroups."\n";
*/
?>

function toggle_right(hidden_field_id){
	field = document.getElementById(hidden_field_id);
	if(field.value==hidden_field_id+'__1'){
		field.value = hidden_field_id+'__';
	}else{
		field.value = hidden_field_id+'__1';
	}
}

function select_all(usergroup_id, select_all_id){	
	action = document.getElementById(select_all_id).checked;	
	for (i = 0; i < menuitems.length; i++){		
		box_id = menuitems[i]+'_0_'+usergroup_id;		
		hidden_id = menuitems[i]+'__'+usergroup_id+'__hidden';
		if(action==true){			
			document.getElementById(box_id).checked = true;
			document.getElementById(hidden_id).value = hidden_id+'__1';
		}else{
			
			document.getElementById(box_id).checked = false;
			document.getElementById(hidden_id).value = hidden_id+'__';
		}
	}	
}


</script>
<form name="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_frontenduseraccess&view=menuaccess'); ?>">	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />	
	<?php echo JHTML::_( 'form.token' ); ?>	
<table id="fua_subheader">
	<tr>
		<td>
			<?php 
				echo '<p>'.JText::_('COM_FRONTENDUSERACCESS_MENU_INFO2').'.</p>';				

				//legend and message if reverse access	
				$this->controller->reverse_access_warning('menu_reverse_access');
				
				//message in free version that these restrictions will not work in free version
				$this->controller->not_in_free_version();
				
				//message if item access is not activated		
				if($this->controller->fua_config['use_menuaccess']==false){				
					echo '<div style="text-align: left;" class="fua_red">'.JText::_('COM_FRONTENDUSERACCESS_NO_ACTIVE_MENU').'. <a href="index.php?option=com_frontenduseraccess&view=config&tab=menu_access">'.JText::_('COM_FRONTENDUSERACCESS_ACTIVATE_IN_CONFIG').'</a><br/><br/></div>';
				}		
						
			?>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" class="text_area"  />			
			&nbsp;
			<button onclick="this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			&nbsp;
			<button onclick="document.adminForm.filter_search.value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>			
			&nbsp;			
			<select name="filter_type" class="inputbox" onchange="this.form.submit()">
				<option value="all"> - <?php echo JText::_('COM_FRONTENDUSERACCESS_SELECT_MENU_TYPE');?> - </option>
				<?php echo JHtml::_('select.options', $this->get_menu_type_options(), 'value', 'text', $this->state->get('filter.type'), true);?>
			</select>
			&nbsp;
			<select name="filter_access" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
			</select>
			&nbsp;
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
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
		<th>
			<?php 
			$label = ucfirst(JText::_('JFIELD_TITLE_DESC')).' '; 			
			echo JHTML::_('grid.sort', $label, 'm.title', $listDirn, $listOrder); 			
			?>	
			&nbsp;	
			<?php 
			$label = ucfirst(JText::_('JFIELD_ORDERING_LABEL')).' '; 			
			echo JHTML::_('grid.sort', $label, 'm.lft', $listDirn, $listOrder); 			
			?>							
		</th>
		<?php
		if($this->state->get('accesscolumn')=='yes'){
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


$k = 1;		
			
//row with select_all checkboxes
echo '<tr class="row0">';
echo '<td>&nbsp;</td>';
echo '<td>'.JText::_('COM_FRONTENDUSERACCESS_SELECTALL').'</td>';
if($this->state->get('accesscolumn')=='yes'){	
	echo '<td>&nbsp;</td>';
}
foreach($this->fua_usergroups as $fua_usergroup){
	echo '<td style="text-align:center;"><input type="checkbox" name="checkall[]" value="" id="checkall_'.$fua_usergroup->id.'" onclick="select_all('.$fua_usergroup->id.',this.id);" /></td>';
}
echo '</tr>';

$counter = 0;
foreach($this->items as $item){
	if($k==1){
		$k = 0;
	}else{
		$k = 1;
	}
	echo '<tr class="row'.$k.'">';					
	echo '<td class="column_ids">'.$item->id.'</td>';
	$has_superscript = '';
	if($item->published=='0' || $item->type=='alias'){
		$has_superscript = ' has_superscript';
	}
	echo '<td class="indent-'.(intval(($item->level-1)*15)+4).$has_superscript.'">';	
	echo $item->title;
	if($item->published=='0'){
		echo '<sup class="fua_superscript">1</sup>';
	}
	if($item->type=='alias'){
		echo '<sup class="fua_superscript">2</sup>';
	}		
	echo '</td>';	
	if($this->state->get('accesscolumn')=='yes'){		
		echo '<td>';	
		echo $item->leveltitle;
		echo '</td>';
	}
	foreach($this->fua_usergroups as $usergroup){
		$checked = '';
		$checked_hidden = '';
		if (in_array($item->id.'_'.$usergroup->id, $this->access_menuitems)){
			$checked = 'checked="checked"';
			$checked_hidden = '1';
		}
		echo '<td align="center"><input type="hidden" name="menu_access_hidden[]" id="'.$item->id.'__'.$usergroup->id.'__hidden" value="'.$item->id.'__'.$usergroup->id.'__hidden__'.$checked_hidden.'" /><input type="checkbox" name="menu_access[]" id="'.$item->id.'_0_'.$usergroup->id.'" onclick="toggle_right(\''.$item->id.'__'.$usergroup->id.'__hidden\');" value="'.$item->id.'__'.$usergroup->id.'" '.$checked.' /></td>';
	}
	echo '</tr>';
	if($counter==7){
		echo '<tr><th>&nbsp;</th><th>&nbsp;</th>';
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
	<tr>
		<td class="fua_red">2
		</td>
		<td>=
		</td>
		<td><?php echo JText::_('COM_FRONTENDUSERACCESS_ALIAS_WARNING'); ?>.
		</td>
	</tr>
</table>
</form>
<?php

$this->controller->display_footer();

?>
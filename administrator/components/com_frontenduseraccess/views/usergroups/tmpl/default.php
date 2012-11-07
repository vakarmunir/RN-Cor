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

//jimport( 'joomla.filesystem.folder' );
//JFolder::create('templates'.DS.'test'.DS.'html'.DS.'soep', 0755);
//mkdir("testfolder");

?>

<script language="JavaScript" type="text/javascript">

Joomla.submitbutton = function(task){
	if (task == 'usergroup') {	
		document.location.href = 'index.php?option=com_frontenduseraccess&view=usergroup&sub_task=new';		
	}		
	if (task == 'usergroup_delete') {
		if (document.adminForm.boxchecked.value == '0') {						
			alert('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_NOSELECTUSERGROUPS')); ?>');
			return;
		} else {
			if(confirm("<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_SUREDELETEUSERGROUP')); ?>")){
				submitform('usergroup_delete');
			}
		}
	}
}

</script>

<form name="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_frontenduseraccess&view=usergroups'); ?>">	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />		
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />		
	<?php echo JHTML::_( 'form.token' ); ?>			
		<p style="margin-left: 4px;">
			<?php echo JText::_('COM_FRONTENDUSERACCESS_USERGROUPS_INFO'); ?>:<br />
			<ul>
				<li>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_NOT_LOGGEDIN'); ?> = <?php echo JText::_('COM_FRONTENDUSERACCESS_NOT_LOGGEDIN_INFO'); ?>
				</li>
				<li>
					<?php echo JText::_('COM_FRONTENDUSERACCESS_LOGGEDIN'); ?> = <?php echo JText::_('COM_FRONTENDUSERACCESS_LOGGEDIN_INFO'); ?>
				</li>				
			</ul>
		</p>		
		<div>		
			<input type="text" name="usergroups_search" id="usergroups_search" value="<?php echo $this->state->get('filter.search'); ?>" class="text_area"  />
			&nbsp;
			<button onclick="this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			&nbsp;
			<button onclick="document.getElementById('usergroups_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
<table class="adminlist">
	<tr>
		<th width="5" align="left">
			<input type="checkbox" name="toggle" value="" <?php if(isset($this->fua_usergroups)){ ?>onclick="checkAll(<?php echo count($this->fua_usergroups); ?>);"<?php } ?> />			
		</th>
		<th style="text-align: center;">
			id
		</th>
		<th align="left">
			<?php 
			$label = ucfirst(JText::_('COM_FRONTENDUSERACCESS_USERGROUPS')).' '; 			
			echo JHTML::_('grid.sort', $label, 'u.name', $listDirn, $listOrder); 
			?>
		</th>
		<th align="left">
			<?php echo JText::_('JGLOBAL_DESCRIPTION'); ?>
		</th>
		<th align="left" width="400">
			<div style="width: 180px; margin: 0 auto;">
				<?php 			
				$label = ucfirst(JText::_('JGRID_HEADING_ORDERING')).' '; 
				echo JHTML::_('grid.sort', $label, 'u.ordering', $listDirn, $listOrder); 
				?>			
				<a href="javascript:submitform('save_order_groups');" class="saveorder" title="Save Order"></a>
			</div>
		</th>
	</tr>
	<tr>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td align="center">
			<?php echo JText::_('COM_FRONTENDUSERACCESS_ORDERING_INFO'); ?>.
		</td>
	</tr>	

<?php


$k = 0;	
for($i=0; $i < count( $this->items ); $i++) {
	$row = $this->items[$i];		
	if($k==1){
		$k = 0;
	}else{
		$k = 1;
	}
	echo '<tr class="row'.$k.'"><td><input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$row->id.'" onclick="isChecked(this.checked);" /></td>';
	echo '<td class="column_ids">'.$row->id.'</td>';
	echo '<td><a href="index.php?option=com_frontenduseraccess&amp;view=usergroup&amp;id='.$row->id.'">'.$row->name.'</a></td>';
	echo '<td>';
	echo $row->description;
	echo '</td>';
	echo '<td align="center">';
	echo '<input type="hidden" name="group_id[]" value="'.$row->id.'" />';
	echo '<input type="text" name="order[]" value="'.$row->ordering.'" size="5" />';	
	echo '</td>';
	echo '</tr>';		
}
if(count($this->items)==0){
	echo '<tr><td colspan="5">'.JText::_('COM_FRONTENDUSERACCESS_NOUSERGROUPS').'</td></tr>';
}
?>

	</tr>
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
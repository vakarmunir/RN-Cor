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

//get id
$id = intval(JRequest::getVar('id', '', 'get'));

if($this->sub_task == 'new'){
	//new part
	
	$id = '';
	$name = '';	
	$description = '';
	
	
	//end new part
}else{
	//edit part
	
	//get data
	$this->controller->db->setQuery("SELECT * FROM #__fua_parts WHERE id='$id' LIMIT 1");
	$rows = $this->controller->db->loadObjectList();
	$row = $rows[0];
	$name = $row->name;
	$name = str_replace('"','&quot;',$name);	
	$description = $row->description;	
	$description = str_replace('"','&quot;',$description);	
	
	//end edit part
}

?>

<script language="JavaScript" type="text/javascript">

Joomla.submitbutton = function(task){		
	if (task=='cancel'){			
		document.location.href = 'index.php?option=com_frontenduseraccess&view=parts';		
	}
	if (task=='part_save'){	
		if (document.getElementById('name').value == '') {			
			alert('<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_NONAMEENTERED')); ?>');
			return;
		} else {
			submitform('part_save');
		}
	}
}

</script>

<form name="adminForm" method="post" action="">
		<input type="hidden" name="option" value="com_frontenduseraccess" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />		
		<?php echo JHTML::_( 'form.token' ); ?>			
<table class="adminlist">
	<tr>
		<th colspan="3">
			<?php 
				if($this->sub_task == 'new'){ 
					echo JText::_('COM_FRONTENDUSERACCESS_PART_NEW'); 
				}else{
					echo JText::_('COM_FRONTENDUSERACCESS_PART_EDIT').' id='.$id; 
				}
			?>
		</th>
	</tr>
	<tr>
		<td width="300">
			<?php echo JText::_('COM_FRONTENDUSERACCESS_NAME'); ?>
		</td>
		<td>
			<input name="name" id="name" type="text" value="<?php echo $name; ?>" class="text_area" style="width: 300px;" />
		</td>
		<td>&nbsp;
			
		</td>
	</tr>	
	<tr>
		<td width="300">
			<?php echo JText::_('JGLOBAL_DESCRIPTION'); ?>
		</td>
		<td>
			<textarea name="description" cols="20" rows="5" class="text_area" style="width: 300px;"><?php echo $description; ?></textarea>
		</td>
		<td>&nbsp;
			
		</td>
	</tr>		
</table>
</form>	 
<?php
$this->controller->display_footer();
?>
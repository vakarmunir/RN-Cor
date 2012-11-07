<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Templates' ).': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply();
JToolBarHelper::save();
if (!$edit) {
	JToolBarHelper::cancel();
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
}
?>

<script language="javascript" type="text/javascript">
<?php 
$jv = new JVersion();
if ($jv->RELEASE < 1.6): ?>

function submitbutton(task)
{
    var form = document.adminForm;
    if (task == 'cancel' || document.formvalidator.isValid(form)) {
		submitform(task);
	}
}
<?php else: ?>

Joomla.submitbutton = function(task)
{
	if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

<?php endif; ?>
</script>

	 	<form method="post" action="index.php" id="adminForm" name="adminForm">
	 	<div class="col width-60 fltlft">
		  <fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
				
                <?php if($this->isNew):?>
					<p><strong>Notice:</strong> The template install file will be compatible with Joomla 1.6 and higher.</p>
				<?php endif;?>	
											
				<?php echo $this->form->getLabel('name'); ?>
				
				<?php echo $this->form->getInput('name');  ?>
					
				<?php echo $this->form->getLabel('version'); ?>
				
				<?php echo $this->form->getInput('version');  ?>
					
				<?php echo $this->form->getLabel('use'); ?>
				
				<?php echo $this->form->getInput('use');  ?>
					
				<?php echo $this->form->getLabel('created'); ?>
				
				<?php echo $this->form->getInput('created');  ?>					
							
				<?php echo $this->form->getLabel('published'); ?>
				
				<?php echo $this->form->getInput('published');  ?>
			
						
          </fieldset>                      
        </div>
   <div class="col width-40 fltrt">
			<div style="margin-top:10px;"></div>
			<fieldset class="panelform">
				<legend><?php echo JText::_( 'Description' ); ?></legend>
					 <div class="clr"></div>
					<?php echo $this->form->getInput('description');  ?>
			</fieldset>
	
			<fieldset class="panelform">			
				<legend><?php echo JText::_( 'Versions' ); ?></legend>
				<div style="padding-left:50px;">
				<?php 
				
				if ($count= count($this->item->files)):
				
				?>
				 <ul>
				 		<?php foreach($this->item->files as $file):				 					 	
				 				$isRecent = stristr($file, '-'.$this->item->version.'.');
				 				?>
				 				<li style="border-bottom:1px dotted #c0c0c0;height:24px;">
				 					<a href="<?php echo JURI::base() ?>components/com_jacc/archives/<?php echo $file?>"><?php echo $file ?></a>
				 					<?php if (!$isRecent ): ?>
				 					<a  href="Javascript:vremove('<?php echo $file?>')" class="listicon"><img class="hasTip" src="<?php echo JURI::base() ?>components/com_jacc/assets/delete.png" title="Delete::Delete This Version" \ ></a>
									<?php endif; ?>
				 				</li>
				 		<?php
				 				$count--; 
				 				endforeach; ?>
				 </ul>				 
				 
				 <?php endif;?>
				 </div>
			</fieldset>					
        </div>                   
		<input type="hidden" name="option" value="com_jacc" />
		<input type="hidden" id="vremove" name="vremove" value="" />	
	    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="templates" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
	<div class="clr"></div>
	<div style="text-align:center;font-weight:bold;padding:10px;">Jacc Version <?php print JaccHelper::getVersion() ?></div> 
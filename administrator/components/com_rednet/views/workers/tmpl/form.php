<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Workers' ).': <small><small>[ ' . $text.' ]</small></small>' );
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
	 	<div class="col width-70 fltlft">
		  <fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
							
				<?php echo $this->form->getLabel('first_name'); ?>
				
				<?php echo $this->form->getInput('first_name');  ?>
					
				<?php echo $this->form->getLabel('last_name'); ?>
				
				<?php echo $this->form->getInput('last_name');  ?>
					
				<?php echo $this->form->getLabel('s_n'); ?>
				
				<?php echo $this->form->getInput('s_n');  ?>
					
				<?php echo $this->form->getLabel('dob'); ?>
				
				<?php echo $this->form->getInput('dob');  ?>
					
				<?php echo $this->form->getLabel('start_date'); ?>
				
				<?php echo $this->form->getInput('start_date');  ?>
					
				<?php echo $this->form->getLabel('dl_no'); ?>
				
				<?php echo $this->form->getInput('dl_no');  ?>
					
				<?php echo $this->form->getLabel('class'); ?>
				
				<?php echo $this->form->getInput('class');  ?>
					
				<?php echo $this->form->getLabel('status'); ?>
				
				<?php echo $this->form->getInput('status');  ?>
					
				<?php echo $this->form->getLabel('email'); ?>
				
				<?php echo $this->form->getInput('email');  ?>
					
				<?php echo $this->form->getLabel('cell'); ?>
				
				<?php echo $this->form->getInput('cell');  ?>
					
				<?php echo $this->form->getLabel('home'); ?>
				
				<?php echo $this->form->getInput('home');  ?>
					
				<?php echo $this->form->getLabel('shirt_size'); ?>
				
				<?php echo $this->form->getInput('shirt_size');  ?>
					
				<?php echo $this->form->getLabel('pant_leg'); ?>
				
				<?php echo $this->form->getInput('pant_leg');  ?>
					
				<?php echo $this->form->getLabel('waist'); ?>
				
				<?php echo $this->form->getInput('waist');  ?>
					
				<?php echo $this->form->getLabel('receive_update_by'); ?>
				
				<?php echo $this->form->getInput('receive_update_by');  ?>
					
				<?php echo $this->form->getLabel('desired_shift'); ?>
				
				<?php echo $this->form->getInput('desired_shift');  ?>
					
				<?php echo $this->form->getLabel('created_date'); ?>
				
				<?php echo $this->form->getInput('created_date');  ?>
					
				<?php echo $this->form->getLabel('updated_by'); ?>
				
				<?php echo $this->form->getInput('updated_by');  ?>
					
				<?php echo $this->form->getLabel('updated_date'); ?>
				
				<?php echo $this->form->getInput('updated_date');  ?>
					
				<?php echo $this->form->getLabel('active_status'); ?>
				
				<?php echo $this->form->getInput('active_status');  ?>
					
				<?php echo $this->form->getLabel('verified_status'); ?>
				
				<?php echo $this->form->getInput('verified_status');  ?>
					
					
			
						
          </fieldset>                      
        </div>
        <div class="col width-30 fltrt">
		        
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Parameters' ); ?></legend>
							
				<?php echo $this->form->getLabel('created_by'); ?>
				
				<?php echo $this->form->getInput('created_by');  ?>
								
			</fieldset>
			        

        </div>                   
		<input type="hidden" name="option" value="com_rednet" />
	    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="workers" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
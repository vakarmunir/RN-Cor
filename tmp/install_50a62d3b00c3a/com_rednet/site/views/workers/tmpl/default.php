<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();
$app = JFactory::getApplication();
if($user->id == 0)
    $app->redirect("index.php");


?>

<h3><?php echo $this->item->first_name; ?></h3>
<div class="form_wrapper_app">
	
	<div>
		First name: <?php echo $this->item->first_name; ?>
	</div>
	<div>
		Last name: <?php echo $this->item->last_name; ?>
	</div>
	<div>
		Sn#: <?php echo $this->item->s_n; ?>
	</div>
	<div>
		Dl#: <?php echo $this->item->dl_no; ?>
	</div>
	<div>
		Class: <?php echo $this->item->class; ?>
	</div>
	<div>
		Status: <?php echo $this->item->status; ?>
	</div>
	<div>
		Email: <?php echo $this->item->email; ?>
	</div>
	<div>
		Cell: <?php echo $this->item->cell; ?>
	</div>
	<div>
		Home: <?php echo $this->item->home; ?>
	</div>
	<div>
		Shirt size: <?php echo $this->item->shirt_size; ?>
	</div>
	<div>
		Pant leg: <?php echo $this->item->pant_leg; ?>
	</div>
	<div>
		Waist: <?php echo $this->item->waist; ?>
	</div>
	<div>
		Receive update by: <?php echo $this->item->receive_update_by; ?>
	</div>
	<div>
		Desired shift: <?php echo $this->item->desired_shift; ?>
	</div>
	

</div>

<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$app = JFactory::getApplication();
if($user->id == 0)
    $app->redirect("index.php");


?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>
<h3><?php echo $this->item->id; ?></h3>
<div class="contentpane">
	<div><h4></h4></div>
	
	<div>
	
	</div>

</div>

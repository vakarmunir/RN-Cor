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

/*
if(!$this->controller->is_super_user){
	die('only super admins can do this');
}
*/
	
//print_r($this->users);
	
?>
<link href="components/com_frontenduseraccess/css/frontenduseraccess.css" rel="stylesheet" type="text/css" />
<form name="adminForm" method="post" action="">
	<input type="hidden" name="option" value="com_frontenduseraccess" />
	<input type="hidden" name="task" value="" />		
<?php 

echo JHTML::_( 'form.token' ); 

echo '<div style="width: 600px; margin: 0 auto;">';

echo '<h1>';
echo 'updating users...';
echo '      <img src="components/com_frontenduseraccess/images/processing.gif" alt="updating users" />';
echo '</h1>';
echo '<p>';
echo 'total users to render = '.$this->total_to_render;
echo '</p>';

//make javascript array of user id's
$javascript_array_users = 'var array_users = new Array(';
$first = true;						
foreach($this->users as $user_temp){		
	if($first){
		$first = false;
	}else{
		$javascript_array_users .= ',';
	}
	$javascript_array_users .= "'".$user_temp->id."'";
}
$javascript_array_users .= ');';

//make sure mootools is loaded
JHTML::_('behavior.mootools');
?>

<script language="javascript" type="text/javascript">

<?php echo $javascript_array_users."\n"; 

if($this->batchtype=='jf'){
	echo "var f = '".$this->f."';\n";
	echo "var old = '';\n";
}else{
	echo "var f = '".$this->f2."';\n";
	echo "var old = '".$this->f1."';\n";
}

echo "var mode = '".$this->mode."';\n";
?>



var batchtype = '<?php echo $this->batchtype; ?>';

window.addEvent('domready', function() {
	var delay = 0;
	for (i = 0; i < array_users.length; i++){  
		ajax_url = 'index.php?option=com_frontenduseraccess&task=ajax_update_users&format=raw&batchtype='+batchtype+'&<?php echo JUtility::getToken(); ?>=1&';
		ajax_url = ajax_url+'mode='+mode+'&old='+old+'&';
		ajax_url = ajax_url+'f='+f+'&u='+array_users[i]; 		
		var req = new Request.HTML({url:ajax_url, update:'user_'+array_users[i], onComplete:progress_bar });
		delay += 500; // 0.5 seconds between each call
		req.send.delay(delay,req);         
	}
});


var rendered = 0;
var total_to_render = '<?php echo $this->total_to_render; ?>';

var percent;

function progress_bar(){
	rendered = rendered+1;	
	ready = total_to_render/rendered;		
	percent = 100/ready;	
	percent = Math.floor(percent);	
	document.getElementById('percent').innerHTML = percent+'%';	
	progress_width = percent*4;		
	document.getElementById('progress').style.width = progress_width+'px';
	if(ready==1){	
		//alert('ready');
		document.location.href = 'index.php?option=com_frontenduseraccess&task=batch_assign_ready';
	}
}

</script>
<div id="percent">
0%
</div>
<div style="width: 400px; height: 20px; border: 1px solid #ccc">
	<div id="progress" style="background: #000033; height: 20px; width: 0px;">
		&nbsp;
	</div>
</div>
<div>
<?php

echo '<br /><br />';	
echo '<strong>id '.$this->controller->fua_strtolower(JText::_('COM_FRONTENDUSERACCESS_USERNAME')).'</strong><br /><br />';

foreach($this->users as $user_temp){	
	
	echo $user_temp->id;
	echo ' ';	
	echo $user_temp->username;
	echo ' ';	
	echo '<span id="user_'.$user_temp->id.'"></span>';	
	echo '<br /><br />';		
}	

?>	
</div>	
	
</form>
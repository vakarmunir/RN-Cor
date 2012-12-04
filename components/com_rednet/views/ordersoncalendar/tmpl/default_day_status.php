<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();

$data = $this->data;

$statuses = $data['statuses'];

?>


<div style="margin-left: 50px!important">
<jdoc:include type="message" />

<h3>Set status for <?php echo date('m/d/Y',strtotime($data['date'])) ?></h3>

<style type="text/css">
    label{
        color: #000;
    }
</style>
<div>
    <br />
    <form id="form1" name="form1" method="post" action="<?php echo JURI::current(); ?>?task=day_status_save">
    
    <input type="hidden" name="date" value="<?php echo $data['date']; ?>" />
  <p>
    <label>
        <input type="radio" name="day_status" value="open" id="day_status_0" <?php echo ($statuses['open']==true)?('checked=checked'):('') ?> />
      Open</label>
    <br />
    <label>
      <input type="radio" name="day_status" value="closed" id="day_status_1" <?php echo ($statuses['closed']==true)?('checked=checked'):('') ?> />
      Closed</label>
    <br />
    <label>
      <input type="radio" name="day_status" value="hold" id="day_status_2" <?php echo ($statuses['hold']==true)?('checked=checked'):('') ?> />
      Hold</label>
    <br />
  </p>
  <br />
  <input id="order_button" class="button" type="submit" name="order_button" value="Proceed">
</form>
   
</div>

</div>
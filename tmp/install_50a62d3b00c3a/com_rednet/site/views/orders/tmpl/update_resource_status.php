<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_ ( 'behavior.formvalidation' );

$form_data = $this->form_data;
?>

<div style="margin-left: 50px!important">
<jdoc:include type="message" />

<h2>Please confirm the order.</h2>

<style type="text/css">
    label{
        color: #000;
    }
</style>
<div style="margin-left: 70px;">
    <br />
    <form id="form1" name="form1" method="post" action="<?php echo JURI::current(); ?>">
    <input type="hidden" name="action" value="update_resource_status" />
    <input type="hidden" name="rs_id" value="<?php echo $form_data['rs_id']; ?>" />
  <p>
    <label>
        <input type="radio" name="confirm_order" value="C" id="confirm_order_0" checked="checked" />
      Confirmed</label>
    <br />
    <label>
      <input type="radio" name="confirm_order" value="CD" id="confirm_order_1" />
      Confirm-Direct-Drive</label>
    <br />
    <label>
      <input type="radio" name="confirm_order" value="R" id="confirm_order_2" />
      Rejected</label>
    <br />
  </p>
  <br />
  <input id="order_button" class="button" type="submit" name="order_button" value="Proceed">
</form>
   
</div>

</div>
<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$f_data = $this->form_data;



?>

<script type="text/javascript">

$('document').ready(function(){
    $('input#addon_button').click(function(){
        var server = "<?php echo JURI::base(); ?>";
        var p_o = "<?php echo $f_data['p_o'];?>";
        var m = "<?php echo $f_data['m'];?>";
        var t = "<?php echo $f_data['t'];?>";
        var tr = "<?php echo $f_data['tr'];?>";
        var od = "<?php echo $f_data['od'];?>";
        var dt = "<?php echo $f_data['dt'];?>";
        window.location = server+"index.php/component/rednet/orders?task=order_form&p_o="+p_o+"&m="+m+"&t="+t+"&tr="+tr+"&od="+od+"&dt="+dt;
    });            
    $('input#skip_button').click(function(){
        var server = "<?php echo JURI::base(); ?>";
        
             window.location = server+"index.php/component/rednet/orderslist";                         
    });            
});

</script>

<h2>Create Add-on Order?</h2>

<input class="button" type="submit" value="Create.." name="addon_button" id="addon_button" />
<input class="button" type="submit" value="Skip" name="skip_button" id="skip_button" />
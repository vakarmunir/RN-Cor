<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_ ( 'behavior.formvalidation' );

$app = JFactory::getApplication();
?>


<jdoc:include type="message" />

<div>
    <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/order.gif" alt="  " id="lock_icon" width="40" /></td>
            <td><h3>Title of Page</h3></td>
        </tr>
        
        
    </table>
    
    
    <script type="text/javascript">    
    $('ready').ready(function(){    
        
        $('#adon_order_button').click(function(){          
            var server = "<?php echo JURI::base(); ?>";            
            var p_o= "<?php echo "$order->id"; ?>";
            var m = $('#no_of_men').val();
            var t = $('#no_of_trucks').val();
            var qry_string = "p_o="+p_o+"&m="+m+"&t="+t;
        
            var path =server+"<?php echo "index.php/component/rednet/orders?task=order_form&";?>"+qry_string;            
            window.location = path;
        });
    });
</script>
<?php if($form_data['action']=='update'){ ?>
    
<p>
    <input class="button" type="submit" value="Ad-On Order" name="order_button" id="adon_order_button" style="font-size: 12px;margin-left: 85px;" />
    
</p>
<br />
        
    
<?php } ?>

    
    
    
</div>


<div class="form_wrapper_app_order">
	
 <div class="mainform_left"></div>
  <div class="mainform_middle">

<input type="hidden" name="today_date" id="today_date" value="<?php echo date('m/d/Y') ?>" />

<form class="form-validate" id="edit_worker_form" action="<?php echo JRoute::_("index.php/component/rednet/orders?task=order_form_save")?>" method="post" onSubmit="return validate_order();" enctype="multipart/form-data">
    
          <input type="hidden" name="id" id="id" value="<?php echo $order->id;?>" />
          <input type="hidden" name="action" id="action" value="<?php echo $form_data['action'];?>" />          
          <input type="hidden" name="is_addon" id="is_addon" value="<?php echo (isset($order->is_addon) && $order->is_addon!='0')?($order->is_addon):( ($form_data['is_addon']=='1')?'1':'0' ) ;?>" />
          <input type="hidden" name="parent_order" id="parent_order" value="<?php echo isset($order->parent_order)?($order->parent_order):(JRequest::getVar('p_o'));?>" />
    
<table width="100%" border="0">
  <tr>
    <td><p class="field_para">        
        
            <label for="order_no">Order#</label>
      <input name="order_no" type="text" class="main_forms_field required" id="order_no" tabindex="1" value="<?php echo $order->order_no;?>" />      <label for="fist_name"></label>
    </p>
    </td>

    
    <td><p class="field_para">
      <label for="name">Name</label>
      <input name="name" type="text" class="main_forms_field required" id="name" tabindex="2" value="<?php echo $order->name;?>" /></p></td>
    <td>
    
    <p class="field_para">
      <label for="date_order">Date (mm/dd/yyyy)</label>
      
<input name="date_order" type="text" class="main_forms_field required" id="date_order" tabindex="3" value="<?php echo (isset($order->date_order))?(date('m/d/Y',strtotime($order->date_order))):('');?>">
    </p>
    
    
    </td>
    </tr>
    

  <tr>
    <td><p class="field_para" id="type_other">
      <label for="type_order_other">Order Other Type</label>
      <input name="type_order_other" type="text" class="main_forms_field" id="type_order_other" value="<?php echo $order->type_if_other;?>" />
      <label for="type_order_other"></label>
    </p></td>
    <td>    
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p class="field_para">
      <label for="dl_no2">Truck Requirments</label>
      <input name="truck_requirments" type="text" class="main_forms_field required" id="dl_no2" tabindex="6" value="<?php echo $order->truck_requirments;?>" />
      </p></td>
    <td><p class="field_para">
      <label for="class2">Out of town</label>    
      <p>
        <label>
          <input type="radio" name="out_of_town" value="yes" id="out_of_town_0" <?php echo ($order->out_of_town == 'yes')?('checked=checked'):('')?>>
          Yes</label>
        
        <label style="margin-left: 20px">
          <input type="radio" name="out_of_town" value="no" id="out_of_town_1" <?php echo (!isset($order->out_of_town))?('checked=checked'):('')?> <?php echo ($order->out_of_town == 'no')?('checked=checked'):('')?>  />
          No</label>
        
        </p>
      <p class="field_para">
        <td><p class="field_para">
          <label for="hrs">Departure time</label>      
          <br />
          <select name ="hrs" id="hrs" class="hrs" style="width: 10px;">          
            <option value="0">hrs</option>
            <?php for($i=1; $i<=12; $i++):?>
            <option value="<?php echo $i;?>" <?php echo ($i == "$time[0]")?('selected=selected'):('');?>><?php echo $i;?></option>
            <?php endfor; ?>
            </select>      
          <select name ="mins" id="mins" class="mins" style="width: 10px;">          
            <option value="nil">mins</option>
            <?php for($x=0; $x<=45; $x = $x+15):?>
            <option value="<?php echo ($x == '0')?('00'):($x);?>" <?php echo ($x == "$time[1]")?('selected=selected'):('');?>><?php echo ($x == '0')?('00'):($x);?></option>
            <?php endfor; ?>
            </select>      
          </p>
          <p style="font-size: 12px;">
            
            </p>
          <p style="font-size: 12px;">
            <label style="margin-left: 10px;">
              <input type="radio" name="time_option" value="am" id="time_option_0" <?php echo ($time_option=='am')?('checked=checked'):('')?> <?php echo(!isset($order->departure_time))?('checked=checked'):('') ?> />
              AM</label>
            <br>
            <label style="margin-left: 10px;">
              <input type="radio" name="time_option" value="pm" id="time_option_1" <?php echo ($time_option=='pm')?('checked=checked'):('')?>>
              PM</label>
            <br>
          </p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>  
    <td>&nbsp;</td>  
  </tr>
  </table>        
        <br />        
        <div class="role_wrapper"> </div>
<p style="float: left"><input type="submit" value="Save" name="save" /></p>


</form>
  </div> 
    
 <div class="mainform_left"></div>	  
</div>

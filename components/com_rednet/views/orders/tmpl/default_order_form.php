<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_ ( 'behavior.formvalidation' );



$app = JFactory::getApplication();
$form_data = $this->form_data;
$ad_on_orders = $form_data['ad_on_orders'];

$heading = '';
$add_on_txt = '';

if($form_data['is_addon'])
{
    $add_on_txt = 'Add-on ';
}

if($form_data['action']=='add')
{
    $heading = 'Create '.$add_on_txt.'Order';
}
if($form_data['action']=='update')
{
    $heading = 'Update Order';
            
}

$order = $this->order;

if($order->departure_time != NULL)
{
    $dep_time = date('h:i:s A',strtotime($order->departure_time));
}else
{
    $dep_time = date('h:i:s A',strtotime('07:30:00 AM'));
}

$time_array = array();
$time_array = split(' ',$dep_time);
$time = split(':',$time_array[0]);
$time_option = strtolower($time_array[1]);





?>


<script type="text/javascript">


$('document').ready(function(){
    $('input#type_order_other').keyup(function(){
        type_order_error=false;
    });
        
        <?php if($order->type_order == 'others'){ ?>                
            $('p#type_other').show();
        <?php } ?>
            
});

function CompDate(adate,bdate,msg)
{
	a = adate.split('/');
	b = bdate.split('/');
	var sDate = new Date(a[2],a[0]-1,a[1]);
	var eDate = new Date(b[2],b[0]-1,b[1]);

	if (sDate <= eDate )
	{
		return true; 
	}
	else
	{
	    //alert(msg);
		return false;
	}
}
function validate_order(){    
                                 
                 
        if($('select#hrs').val()==0)
        {
            alert('Please select Departure time correctly');
            if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
        }
        
        if($('select#mins').val()=='nil')
        {
            alert('Please select Departure time correctly');
            if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
        }
        
        if($('select#type_order').val()=='0')
        {
            alert('Please select Type!');
            if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
        }
        
        
        if(type_order_error==true)
        {
            
            alert('Please select Type other!');
            if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
        }
        
        
            if($('#instruction_file').val() != "")
            {
                var ext = $('#instruction_file').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['pdf','csv']) == -1) {
                    alert('Invalid instructions file type!');
                    if(navigator.appName == "Microsoft Internet Explorer")
                            event.returnValue = false;
                        else
                            return false;
                }
            }
            
            var return_val = true;
            var required_fields = $('.form-validate').find('.required').get();
            $(required_fields).each(function(indx,obj){                
                if($(obj).val()=='')
                {                  
                    alert("Please Enter "+$(obj).attr('name').split('_').join(' ').toUpperCase());
                   return_val = false;
                   if(navigator.appName == "Microsoft Internet Explorer")
                            event.returnValue = false;
                        else
                            return false;
                }
                    
                    return return_val;
            });
            
            
            
                             
        var today_date = $('#today_date').val();                
        var order_date = $('#date_order').val();                        
        var rslt_date = CompDate(today_date,order_date,"You are entring the 'Order Date' from previouse days.");


            if(rslt_date == false)
            {                
                var msg = confirm("'Order Date' is from previouse days.");                
                    if(msg == false)
                    {
                        if(navigator.appName == "Microsoft Internet Explorer")
                            event.returnValue = false;
                        else
                            return false;
                    }                
            }
            
            return return_val;
}
</script>

<style type="text/css">
    .invalid {color:#B30000;}
</style>

<jdoc:include type="message" />

<div>
    <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/order.gif" alt="  " id="lock_icon" width="40" /></td>
            <td><h3><?php echo $heading;?></h3></td>
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
    
<!-- start ad-on -->

                <?php if(count($ad_on_orders)!=0):?>                    
                    <?php foreach($ad_on_orders as $ordr): ?>
                                                                      
<tr>
    <td><p class="field_para">        
        
            <label for="order_no">Ad-On Order#&nbsp;<a style="text-decoration: none;font-weight: bold;" href="<?php echo JURI::base()."index.php/component/rednet/orders?task=order_form&id=$ordr->id" ; ?>">Edit</a></label>
      <input name="adorder_no" type="text" disabled="disables" class="main_forms_field" id="adorder_no" tabindex="" value="<?php echo $ordr->order_no;?>" />      <label for="adfist_name"></label>
    </p>
    </td>

    
    <td><p class="field_para">
      <label for="adname">Name</label>
      <input name="aadname" type="text" disabled="disables" class="main_forms_field" id="adname" tabindex="" value="<?php echo $ordr->name;?>" /></p></td>
    <td>
    
    <p class="field_para">
      <label for="date_order">Date (mm/dd/yyyy)</label>      
      <input name="ad_date_order" disabled="disables" type="text" class="main_forms_field" id="ad_date_order" tabindex="" value="<?php echo (isset($ordr->date_order))?(date('m/d/Y',strtotime($ordr->date_order))):('');?>">
    </p>
    
    
    </td>                            
        
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
    
<!-- end ad-on   -->
  <tr>
    <td><p class="field_para">
      <label for="type_order">Order Type</label>
      <select name="type_order" id="type_order" class="type_order" style="width: 135px;">
        <option value="0"> -- Select --</option>
        <option value="move" <?php echo ($order->type_order=='move')?('selected=selected'):('')?>>Move</option>
        <option value="move_fmi" <?php echo ($order->type_order=='move_fmi')?('selected=selected'):('')?>>Move/FMI</option>
        <option value="fmi_move" <?php echo ($order->type_order=='fmi_move')?('selected=selected'):('')?>>FMI/Move</option>
        <option value="fmi" <?php echo ($order->type_order=='fmi')?('selected=selected'):('')?>>FMI</option>
        <option value="wbe" <?php echo ($order->type_order=='pack')?('selected=selected'):('')?>>PACK</option>
        <option value="others" <?php echo ($order->type_order=='others')?('selected=selected'):('')?>>others</option>
      </select>
      <label for="type_order"></label>
    </p></td>
    <td><p class="field_para">
      <label for="no_of_trucks">No Of Men</label><input name="no_of_men" type="text" class="main_forms_field_date required" id="no_of_men" tabindex="4" value="<?php echo $order->no_of_men;?><?php echo (isset($form_data['m']))?($form_data['m']):('')?>" />
    </p></td>
    <td><p class="field_para">
      <label for="no_of_trucks">No Of Truck(s)</label>
      <input name="no_of_trucks" type="text" class="main_forms_field_date required" id="no_of_trucks" tabindex="5" value="<?php echo $order->no_of_trucks;?><?php echo (isset($form_data['t']))?($form_data['t']):('')?>"  />
    </p></td>
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
    
<!-- 
    <td><p class="field_para">
      <label for="deposite">Deposit</label>
      <input name="deposite" type="text" class="main_forms_field required" id="deposite" tabindex="7" value="<?php echo $order->deposite;?>" /></p>
    
    </td>
 -->   
   
 
 
    <td colspan="3">      
        <p class="field_para" style="margin-top: 20px">
        <label for="cell">Attach crew instruction</label>
        <input name="instruction_file" type="file" id="instruction_file" class="main_forms_field <?php echo (!isset($order->instruction_file))?(''):('');?>" tabindex="8" style="width: 300px" />
        <input name="old_instruction_file" type="hidden" id="old_instruction_file" value="<?php echo $order->instruction_file;?>" />
        
        <?php if(isset($order->instruction_file) && $order->instruction_file!='')
                        
            {?>        
            <p style="text-align: right;width: 210px"><a href="<?php echo JUri::base().'files/'.$order->instruction_file ?>">View file</a></p>
        <?php } ?>
      
      </p>      
      </td>
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

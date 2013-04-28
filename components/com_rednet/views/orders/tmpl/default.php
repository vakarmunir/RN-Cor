<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_ ( 'behavior.formvalidation' );



$db = JFactory::getDbo();
$app = JFactory::getApplication();


$rs_id_dummy = JRequest::getVar('rs_id');

$order = $this->item;



$heading = "Schedule Resources";
$dep_time = date('h:i:s A',strtotime($order->departure_time));
$time_array = array();
$time_array = split(' ',$dep_time);
$time = split(':',$time_array[0]);
$time_option = strtolower($time_array[1]);

$workers = $this->workers_on_order_date;
$workers_in_rs_on_order_date = $this->workers_in_rs_on_order_date;
//var_dump($workers_in_rs_on_order_date);


$fleets = $this->fleets; 
$rentals = $this->rentals;



$array_assigned_fleets = array();
$array_assigned_rental = array();

$rentals_not_assigned = $this->rentals_not_assigned;



$rentals_assigned = $this->rentals_assigned;



$fleets_not_assigned = $this->fleets_not_assigned;


//===================================================
/*
foreach($fleets_not_assigned as $flt)
{    
    // do somthing when not in range of [from-date] to [to-date]
    if( ! ( (strtotime($order->date_order) >= strtotime($flt->from_date)) && (strtotime($order->date_order) <= strtotime($flt->to_date)) )  )
    {
        echo " [[[ name : $flt->name ]]] <br />";
    }        
}
*/
// ========================================================

$fleets_assigned = $this->fleets_assigned;


$all_loaders = $this->all_loaders;
$all_drivers = $this->all_drivers;
$all_crews = $this->all_crews;
$all_packers = $this->all_packers;

$assigned_workers_list = array();

function make_status_list()
{
    echo "<option value='accepted'>Accepted</option><option value='rejected'>Rejected</option>";
}


$ad_on_orders = $this->ad_on_orders;
$form_data = $this->form_data;

$switch_to_none_admin = $form_data['switch_to_none_admin'];



$resources_all_fleets_by_orderdate = $form_data['resources_all_fleets_by_orderdate'];



$resources_all_rentals_by_orderdate = $form_data['resources_all_rentals_by_orderdate'];

//var_dump($resources_all_rentals_by_orderdate);
//var_dump($resources_all_fleets_by_orderdate);

$ordertypes = $form_data['ordertypes'];

$rsId_for_crnt_wrkr_of_crnt_ordr = $form_data['rsId_for_crnt_wrkr_of_crnt_ordr'];

$act = JRequest::getVar('act');

if($act == "update_resource_status")
{
    $heading = "Please confirm your status.";
}

$authentication_group = $form_data['authentication_group'];



$all_available_workers = count($form_data['all_available_workers']);

//echo "Debuggin... <br />";
//var_dump($form_data['all_available_workers']);


$all_available_trucks = count($fleets_not_assigned) + count($rentals_not_assigned);

$all_assigned_workers = count($form_data['all_assigned_workers']);
$all_assigned_trucks = count($form_data['all_assigned_trucks']);


?>



<?php

                    //echo "<br />================== Assigned fleets =============== <br />";                    
                    $arrayid_resources_all_fleets_by_orderdate = array();
                    foreach($resources_all_fleets_by_orderdate as $rs_flts_dt)
                    {                    
                        array_push($arrayid_resources_all_fleets_by_orderdate, $rs_flts_dt->truck);
                    }
                    $arrayid_resources_all_fleets_by_orderdate = array_unique($arrayid_resources_all_fleets_by_orderdate);
                    //var_dump($arrayid_resources_all_fleets_by_orderdate);
                    $assigned_fleets_array = array();
                    foreach($fleets as $flt)
                    {
                        foreach($arrayid_resources_all_fleets_by_orderdate as $assigned_fleet)
                        {
                            if($assigned_fleet == $flt->id)
                            {
                                array_push($assigned_fleets_array, $flt);
                            }
                        }
                    }
                    //echo "<br />******************************************* <br />";
                    //var_dump($assigned_fleets_array);
                    //echo "<br />=========================================== <br />";
                    //echo "<br />================== all fleets =============== <br />";                    
                    $array_of_fleets_id = array();                    
                    foreach ($fleets as $flt)
                    {
                        array_push($array_of_fleets_id, $flt->id);
                    }
                    //var_dump($array_of_fleets_id);
                    //echo "<br />=========================================== <br />";                    
                    $remaining_fleets_id = array_diff($array_of_fleets_id, $arrayid_resources_all_fleets_by_orderdate);                                                           
                    //echo "<br />================== reamaining fleets =============== <br />";
                    //var_dump($remaining_fleets_id);
                    
                    $remaining_fleets = array();
                    $remaining_fleets_fltr = array();
                    
                    $rm_cntr=0;
                    foreach ($remaining_fleets_id as $rm_flt)
                    {
                        $rm_flt_id = $rm_flt;                        
                        foreach ($fleets as $flt)
                        {
                            if($rm_flt_id == $flt->id)
                            {
                                array_push($remaining_fleets, $flt);
                            }
                        }                                                
                        $rm_cntr++;
                    }
                    
                    //echo "<br />******************************************* <br />";
                    //var_dump($remaining_fleets);
                    //echo "<br />=========================================== <br />";
                    
    ?>



<?php

                    //echo "<br />================== Assigned rentals =============== <br />";                    



                    $arrayid_resources_all_rentals_by_orderdate = array();
                    foreach($resources_all_rentals_by_orderdate as $rs_rntls_dt)
                    {                    
                        array_push($arrayid_resources_all_rentals_by_orderdate, $rs_rntls_dt->truck);
                    }
                    $arrayid_resources_all_rentals_by_orderdate = array_unique($arrayid_resources_all_rentals_by_orderdate);
                    //var_dump($arrayid_resources_all_rentals_by_orderdate);
                    $assigned_rentals_array = array();
                    foreach($rentals as $rntl)
                    {
                        foreach($arrayid_resources_all_rentals_by_orderdate as $assigned_rental)
                        {
                            if($assigned_rental == $rntl->id)
                            {
                                array_push($assigned_rentals_array, $rntl);
                            }
                        }
                    }
                    //echo "<br />******************************************* <br />";
                    //var_dump($assigned_rentals_array);
                    //echo "<br />=========================================== <br />";
                    //echo "<br />================== all rentals =============== <br />";                    
                    $array_of_rentals_id = array();                    
                    foreach ($rentals as $rntl)
                    {
                        array_push($array_of_rentals_id, $rntl->id);
                    }
                    //var_dump($array_of_rentals_id);
                    //echo "<br />=========================================== <br />";                    
                    $remaining_rentals_id = array_diff($array_of_rentals_id, $arrayid_resources_all_rentals_by_orderdate);                                                           
                    //echo "<br />================== reamaining rentals =============== <br />";
                    //var_dump($remaining_rentals_id);
                    
                    $remaining_rentals = array();
                    $remaining_rentals_fltr = array();
                    $rm_cntr=0;
                    foreach ($remaining_rentals_id as $rm_rntl)
                    {
                        $rm_rntl_id = $rm_rntl;                        
                        foreach ($rentals as $rntl)
                        {
                            if($rm_rntl_id == $rntl->id)
                            {
                                array_push($remaining_rentals, $rntl);
                            }
                        }                                                
                        $rm_cntr++;
                    }
                    
                    //echo "<br />******************************************* <br />";
                    //var_dump($remaining_rentals);
                    //echo "<br />=========================================== <br />";

?>


<?php
     $mode = JRequest::getVar('action');
     if($mode == 'print')
     {
?>
        <style type="text/css">
                p
                {
                    color: #000 !important;
                    font-size: 14px !important;
                    background-image: none !important;
                    background-color: #fff !important;
                }
                .main_forms_field
                {
                    color: #000 !important;
                    font-size: 14px !important;
                    background-image: none !important;
                    background-color: #fff !important;
                    font-weight: bold;
                }
                .main_forms_field_date
                {
                    color: #000 !important;
                    font-size: 14px !important;
                    background-image: none !important;
                    background-color: #fff !important;
                    font-weight: bold;
                }
                .resource_cell
                {
                    font-size: 14px !important;
                    background-color: #fff !important;
                }
                .drop
                {
                    font-size: 14px !important;
                    background-color: #fff !important;
                    color: #fff !important;
                }
                
        </style>
        
<?php } ?>

<style type="text/css">
    .comnts{
        border: 0 solid blue;
        float: right;
        font-family: arial;
        font-size: 14px;
        height: 20px;
        padding: 3px;
        text-align: left;
        color: #000;        
    }
</style>

<script type="text/javascript">


function count_available_trucks()
{
    var trucks = $(".truck_class").get();
    //alert(trucks.length.toString());
     $('#truck_counter_holder').text(trucks.length.toString());
}

$('document').ready(function(){
    
    count_available_trucks();
    
    $('input#type_order_other').keyup(function(){
        type_order_error=false;
        
    });
    

        <?php if($order->type_order == 'others'){ ?>                
            $('p#type_other').show();
        <?php } ?>
            
});





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
            
      
}


</script>

        
<style type="text/css">
    .invalid {color:#B30000;}
    
    .grid_anchor:hover
        {
            cursor: pointer;
        }
        .grid_anchor
        {
            cursor: pointer;
            text-decoration: underline;
        }
</style>

<script type="text/javascript">

var no_of_resources_html = 0;
var selected_worker_array = new Array();


    $('document').ready(function(){
        $('input#add_resources').click(function(){            
            no_of_resources_html = no_of_resources_html+1;
            var worker = "worker-"+no_of_resources_html;
                        
            $('div#resource_container').append(inrHtml);
            
            $('span#no_of_resources').html($('.row-of-resource').length);
            make_save_button();
        });
        
        $('span#no_of_resources').html($('.row-of-resource').length);        
        
    });

function worker_select_change(worker)
{    
    var worker_select_tags = $('.worker_select').get()
        
        $(worker_select_tags).each(function(indx,domObj){            
                 if($('#'+worker).val() != '0')
                 {                    
                    if($('#'+worker).attr('id') != $(domObj).attr('id'))
                    {                        
                         if( $('#'+worker).val()==$(domObj).val() )
                         {
                             alert("This worker is alrady selected.")
                             $('#'+worker).val(0);
                                    
                             if(navigator.appName == "Microsoft Internet Explorer")
                                  event.returnValue = false;
                             else
                                   return false;
                          }                        
                    }
                 }                 
        });                      
}

function remove_row(row)
{
    $('div#'+row+"").remove();    
    no_of_resources_html = no_of_resources_html-1;
    $('span#no_of_resources').html($('.row-of-resource').length);            
    make_save_button();
    return false;
}

function make_save_button()
{
    
        if($('.row-of-resource').length > 0)        
        {
            $('div#save_button_container').html("<input type='submit' name='submit' value='save' />");
        }else{
            $('div#save_button_container').html('');
        }        
}



function resource_validate()
{
    
    var worker_select_tags = $('.worker_select').get()
    var truck_select_tags = $('.truck_select').get()
    var status_select_tags = $('.status_select').get()
    var go_out = false;
    
        $(worker_select_tags).each(function(indx,domObj){                                              
                         if( $(domObj).val() == '0' )
                         {
                             
                             alert("Please complete the Worker resource selection.");
                             go_out = true;
                             
                             if(navigator.appName == "Microsoft Internet Explorer")
                                  event.returnValue = false;
                             else
                                   return false;                               
                             
                          }                                            
        });                      
    
        $(truck_select_tags).each(function(indx,domObj){                                              
                         if( $(domObj).val() == '0' )
                         {
                             alert("Please complete the Truck resource selection.");
                             go_out = true;
                             
                             if(navigator.appName == "Microsoft Internet Explorer")
                                  event.returnValue = false;
                             else
                                   return false;                               
                          }                                            
        });                      
    
        $(status_select_tags).each(function(indx,domObj){                                              
                         if( $(domObj).val() == '0' )
                         {
                             alert("Please complete the Status resource selection.");
                             go_out = true;
                             
                             if(navigator.appName == "Microsoft Internet Explorer")
                                  event.returnValue = false;
                             else
                                   return false;                               
                               
                          }                                            
        });                      
    
        
            if(go_out == true)
            {
                 if(navigator.appName == "Microsoft Internet Explorer")
                                  event.returnValue = false;
                             else
                                   return false;                               
            }                           
}



</script>



<script type="text/javascript">
    
    $('document').ready(function(){
        drag_drop_widget();
    });
    
    function drag_drop_widget()
    {
        	$(function(){
			$('.left .worker_class').draggable({
				revert:true,
				proxy:'clone'
			});
                        
			$('.truck_stack .truck_class').draggable({
				revert:true,
				proxy:'clone'
			});
                        
			$('.right td.drop').droppable({
				onDragEnter:function(){
					$(this).addClass('over');
				},
				onDragLeave:function(){
					$(this).removeClass('over');
				},
				onDrop:function(e,source){
					$(this).removeClass('over');
					if ($(source).hasClass('assigned')){
                                                    if($(this).attr('id') != $(source).attr('class'))
                                                    {
                                                        alert('Dropping Invalid Resource.');
                                                        return false;
                                                    }
                                                
						$(this).append(source);                                                
					} 
                                        else 
                                        {
                                            
                                                if($(this).attr('id') != $(source).attr('class'))
                                                    {
                                                        alert('Dropping Invalid Resource.');
                                                        return false;
                                                    }
                                                    var c = $(source).addClass('assigned');
                                                
                                                
						$(this).empty().append(c);
						c.draggable({
							revert:true
						});  
                                                
                                                
                                                
                                                if($(source).attr('class') == 'truck_class assigned')
                                                {
                                                    var table_id = $(source).parent().parent().parent().parent().attr('id');                                                
                                                    
                                                        var table_row = "";
                                                            if(table_id == 'workers_table')
                                                            {
                                                                table_row = "<tr><td class=\"blank\"></td><td class=\"drop\" id=\"worker_class\"><span class=\"drop_msg\">Drop Worker here</span></td><td class=\"resource_cell\"></td><td class=\"resource_cell\"></td></tr>";
                                                            }
                                                            if(table_id == 'truck_table')
                                                            {
                                                                table_row = "<tr><td class=\"blank\"></td><td class=\"drop\" id=\"truck_class\"><span class=\"drop_msg\">Drop Truck here</span></td></tr>";
                                                            }
                                                        
                                                        $('table#'+table_id).append(table_row);
                                                        drag_drop_widget();
                                                        
                                                        var in_source_html = $(source).get();
                                                        
                                                            var c_obj = source;
                                                            
                                                            
                                                            
                                                            var content=$(c_obj).clone().removeClass("truck_class assigned").addClass('all_loaders');
                                                            $('table#trucks_table tbody').append(content);
                                                }
                                                
                                                if($(source).attr('class') == 'worker_class assigned')
                                                {
                                                
                                                    
                                                    var table_id = $(source).parent().parent().parent().parent().attr('id');
                                                    var roles = $('#w_roles',  $(source).get()).val();
                                                    
                                                    var rs_row = $(source).parent().parent().get();
                                                    
                                                    var cntr = 1;
                                                        $(rs_row).children().each(function ()
                                                        {
                                                            var cell = $(this);
                                                                if(cntr == 3)
                                                                {
                                                                    $(this).text(roles);
                                                                }                                                            
                                                            cntr++;
                                                            // do something with the current <tr> and <td>
                                                        });
                                                    
                                                        var table_row = "";
                                                            if(table_id == 'workers_table')
                                                            {
                                                                table_row = "<tr><td class=\"blank\"></td><td class=\"drop\" id=\"worker_class\"><span class=\"drop_msg\">Drop Worker here</span></td><td class=\"resource_cell\"></td><td class=\"resource_cell\"></td></tr>";
                                                            }
                                                            if(table_id == 'truck_table')
                                                            {
                                                                table_row = "<tr><td class=\"drop\" id=\"truck_class\"><span class=\"drop_msg\">Drop Truck here</span></td></tr>";
                                                            }
                                                        
                                                        $('table#'+table_id).append(table_row);
                                                        drag_drop_widget();
                                                        
                                                        var in_source_html = $(source).get();
                                                
                                                        var droped_obj_role = $('#w_roles',in_source_html).val();
                                                        
                                                        if(droped_obj_role == "Loader")
                                                        {
                                                            var c_obj = source;
                                                            var content=$(c_obj).clone().addClass('all_loaders');
                                                            $('table#loaders_table tbody').append(content);
                                                        }
                                                        
                                                        if(droped_obj_role == "Crew Chief")
                                                        {
                                                            var c_obj = source;
                                                            var content=$(c_obj).clone().addClass('all_loaders');
                                                            $('table#crew_chief_table tbody').append(content);
                                                        }
                                                        if(droped_obj_role == "Driver")
                                                        {
                                                            var c_obj = source;
                                                            var content=$(c_obj).clone().addClass('all_loaders');
                                                            $('table#drivers_table tbody').append(content);
                                                        }
                                                        
                                                        if(droped_obj_role == "Packer")
                                                        {
                                                            var c_obj = source;
                                                            var content=$(c_obj).clone().addClass('all_loaders');
                                                            $('table#packers_table tbody').append(content);
                                                        }
                                                        
                                                        // marking assigned other workers
                                                        
                                                        //alert($(source).text());
                                                        var source_text = $(source).text();
                                                        
                                                        var worker_objs = $('div.worker_class').get();
                                                        //alert(worker_objs.length);
                                                        
                                                        $(worker_objs).each(function(i,obj){
                                                                if($(obj).text() == source_text)
                                                                {
                                                                        if( !$(obj).hasClass('assigned') && !$(obj).hasClass('all_loaders'))
                                                                        {
                                                                            $(obj).addClass('assigned all_loaders');
                                                                        }
                                                                }                                                            
                                                        });
                                                }                                                
                                                
                                                $('input#save_button').show();
					}
				}
			});
		});
    }
	
	</script>

        <script type="text/javascript">
        
                $('document').ready(function(){
                    var order_type = "<?php echo $order->type_order; ?>";
                    
                        if(order_type == 'pack')
                        {                            
                            $('div#packers_table_wrapper').show();
                            $('div#loaders_table_wrapper').hide();
                        }else{                         
                            $('div#packers_table_wrapper').hide();
                            $('div#loaders_table_wrapper').show();
                        }
                });
        
        </script>
        
<jdoc:include type="message" />



<div>
    <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/resourceassign.gif" alt="  " id="lock_icon" width="50" /></td>
            <td><h3><?php echo $heading;?></h3></td>
        </tr>
    </table>
    
</div>



<div class="form_wrapper_app_order" style="background: none !important;min-height: 190px !important">
	
    <div class="mainform_left" style=""></div>
  <div class="mainform_middle" style="height: auto !important">
      <form class="form-validate" id="edit_worker_form" action="<?php echo JRoute::_("index.php/component/rednet/orders?task=order_form_save")?>" method="post" enctype="multipart/form-data" onSubmit="return validate_order();">
    
          <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->id;?>" />
          
<table width="600px" border="0">
  <tr>
    <td><p class="field_para">        
        
            <label for="order_no">Order#</label>
            <input disabled="disabled" name="order_no" type="text" class="main_forms_field required" id="order_no" tabindex="1" value="<?php echo $order->order_no;?>" />      <label for="fist_name"></label>
    </p>
    </td>

    
    <td><p class="field_para">
      <label for="name">Name</label>
      <input disabled="disabled" name="name" type="text" class="main_forms_field required" id="name" tabindex="2" value="<?php echo $order->name;?>" /></p></td>
    <td>
    
    <p class="field_para">
      <label for="date_order">Date (mm/dd/yyyy)</label>
      
<input disabled="disabled" name="date_order" type="text" class="main_forms_field required" id="date_order" tabindex="3" value="<?php echo (isset($order->date_order))?(date('m/d/Y',strtotime($order->date_order))):('');?>">
    </p>
    
    
    </td>
    
    </tr>
    
    <tr>
        
    <td colspan="3">
        
          <p class="field_para">
        <label for="dl_no2">Comments</label>


        <p style="float: left;padding: 0px !important;margin-left: 15px !important" class="comnts">
        <?php echo $order->comments; ?>
        </p>

    </td>
    </tr>
    
    
<!-- start ad-on -->

                <?php if(count($ad_on_orders)!=0):?>                    
                    <?php foreach($ad_on_orders as $ordr): ?>
                                                                      
<tr>
    <td><p class="field_para">        
        
        <style type="text/css">
            .edit_sapn a{
                text-decoration: none;
                font-weight: bold;
            }
        </style>
        
        <label for="order_no">Ad-On Order#</label> 
        <?php if( ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) ) { ?>     
<!--        <span class="edit_sapn"><a href="<?php //echo JURI::current()."?id=$ordr->id" ?>" style="font-size: 14px;">Edit</a></span>-->
        <? } ?>
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
       <tr>                    
     <td colspan="3">
        
          <p class="field_para">
        <label for="dl_no2">Comments</label>


        <p style="float: left;padding: 0px !important;margin-left: 15px !important" class="comnts">
        <?php echo $ordr->comments; ?>
        </p>
<br />
    </td>
    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
    
<!-- end ad-on   -->
  <tr>
    
    
  <tr>
    <td><p class="field_para">
      <label for="no_of_trucks">No Of Men</label>
      <input disabled="disabled" name="no_of_men" type="text" class="main_forms_field_date required" id="no_of_men" tabindex="4" value="<?php echo $order->no_of_men;?><?php echo (isset($form_data['m']))?($form_data['m']):('')?>" style="width: 170px !important;" />
      </p></td>
    <td><p class="field_para">
      <label for="no_of_trucks">No Of Truck(s)</label>
      <input disabled="disabled" name="no_of_trucks" type="text" class="main_forms_field_date required" id="no_of_trucks" tabindex="5" value="<?php echo $order->no_of_trucks;?><?php echo (isset($form_data['t']))?($form_data['t']):('')?>" style="width: 170px !important;" />
      </p></td>
    <td>
        
     <p class="field_para">
      <label for="type_order">Order Type</label>      
      
        <?php foreach ($ordertypes as $ordertype): 
                if($order->type_order==$ordertype->value){
            ?>
            
            <input disabled="disabled" name="order_type" type="text" class="main_forms_field_date" id="order_type" value="<?php echo $ordertype->name;?>" style="width: 170px !important;" />
        <?php } endforeach; ?>
      
      
      <label for="type_order"></label>
    </p></td>
  </tr>
  <tr>
    <td><p class="field_para">
      <label for="dl_no2">Truck Requirments</label>
      <input disabled="disabled" name="truck_requirments" type="text" class="main_forms_field required" id="dl_no2" tabindex="6" value="<?php echo $order->truck_requirments;?>" />
      </p></td>
    <td><p class="field_para">
      <label for="class2">Out of town</label>    
      <p>        
       <?php echo ($order->out_of_town == 'yes')?('Yes'):('No'); ?> 
        </p>
      <p class="field_para">
        <td>
          <p class="field_para">
          <label for="hrs">Departure time</label>      
          <label for="hrs"></label>      
          <br />
          <?php echo $time[0];?> : <?php echo $time[1];?>          <?php echo $time_option;?>
          </p>          
        </td>
  </tr>
  
  <tr>
      <td colspan="1">

          <style type="text/css">
            a#add_push{
                text-decoration: none !important;
                font-size: 12px;
                font-weight: bold;
            }
            a#add_push:hover{
                text-decoration: none !important;
                font-size: 12px;
                font-weight: bold;
                cursor: pointer;
            }
            a.cross:hover{
                text-decoration: none !important;              
                cursor: pointer;
            }
            #files_container
            {
              border: 0px solid red;
              width: 300px;
            }
            #files_wrapper{
                border: 0px solid black;
                width: 225px;
                margin-left: 15px;
            }
            #files_wrapper p{
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
            .file_link_para a
            {
                color: #000;
                font-family: arial;
                font-size: 14px;
            }
            
            #f_hdng label
            {
                font-family: arial;
                font-size: 14px;
                color: #B30000;
                margin-left: 15px;
            }
        </style>
        
        
        <br />
        
        
        
          <div id="f_hdng"></div>
                    <div id="files_wrapper">
                        
                        
                    </div>
          <?php //if(isset($order->instruction_file) && $order->instruction_file!='')
                        
            //{?>
          
<!--            <div class="view_file_button">
                  <p><a target="_blank" href="<?php //echo JUri::base().'files/'.$order->instruction_file ?>">Download Instruction file</a></p>
            </div>-->
        <?php //} ?>
      
      </td>
      
      
      <td>
          

      </td>
      
      <td colspan="1">
          <div style="border: 0px solid red;height: 35px">
              <style type="text/css">
                  .detail_resources
                  {
                      border: 0px solid blue;
                      height:20px; 
                      padding: 3px;
                      float: right;
                      font-family: arial;
                      font-size: 12px;
                      text-align: center;
                  }
              </style>
              
         <?php if( ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) ) { ?>     
              <div class="detail_resources">
                  Resources Required  <br /> Men(&nbsp;<strong><?php echo $order->no_of_men;?><?php echo (isset($form_data['m']))?($form_data['m']):('')?></strong>&nbsp;)&nbsp; Trucks(&nbsp;<strong><?php echo $order->no_of_trucks;?><?php echo (isset($form_data['t']))?($form_data['t']):('')?></strong>&nbsp;)
              </div>
              <div class="detail_resources">
                  <br />Resources Available <br /> Men(&nbsp;<strong><?php 
                  
                  echo $all_available_workers;
                  

                  ?></strong>&nbsp;)&nbsp; Trucks(&nbsp;<strong><span id="truck_counter_holder"><?php 
// old code
//echo (count_truck_list_not_assigned($fleets_not_assigned,"fleet",$order) + count_truck_list_not_assigned($rentals_not_assigned,"fleet",$order)); 

// new cold
//echo (count($remaining_fleets)) + (count($remaining_rentals)) ; 
                                                                                                                                                
                  // latest code                                                                                                                                                
                  $fleets_counter = count(make_truck_list_not_assigned_counter($remaining_fleets,$remaining_fleets_fltr));
                  $rentals_counter =  count(make_truck_list_not_assigned_counter($remaining_rentals,$remaining_rentals_fltr));
                  
                  //echo "[".count($assigned_fleets_array)."] [".count($assigned_rentals_array)."]";
                                                                                                                                           ?></span></strong>&nbsp;)
              </div>
              
              <div class="detail_resources">
                 <br /><br /> Resources Assigned <br /> Men(&nbsp;<strong><?php echo $all_assigned_workers ?></strong>&nbsp;) Trucks(&nbsp;<strong><?php echo $all_assigned_trucks ?></strong>&nbsp;)
              </div>
          <?php } ?>    
          </div>
      </td>
  </tr>
  
  </table>        
        <br />        
        <div class="role_wrapper"> </div>

</form>
  </div> 
    
 <div class="mainform_left" style="height: 200px !important"></div>	  
</div>





<div style="margin-left: 80px;padding-top: 20px;">

</div>



<div style="width:750px;margin-left: 90px;">
    
	<h3>Assigned Resources</h3><br />
<table>
    <tr>
        <td>
        
            
            
	<div class="right">

<script type="text/javascript">
  $(function()
  {
    var submitActor = null;
    var $form = $( '#resource_form' );
    var $submitActors = $form.find( 'input[type=submit]' );

    $form.submit( function( event )
    {
        var return_val = true;
        
      if ( null === submitActor )
      {
        // If no actor is explicitly clicked, the browser will
        // automatically choose the first in source-order
        // so we do the same here
        submitActor = $submitActors[0];
      }

      //alert( submitActor.name );
          if(submitActor.id == 'save_button')
          {
              return_val = validate_resource();
          }
          if(submitActor.id == 'dispatch_button')
          {
              return_val = validate_resource_min();
          }
          if(submitActor.id == 'print_button')
          {
              //alert('printing....');
              $('.file_link_anchor').each(function(i,obj){
                  var nav_link = $(obj).attr('href');
                  //var link_name = "Print_"+$(obj).text();
                  //alert(link_name);
                  //window.open (nav_link);
              });
              
                      var nav_link_current = "<?php echo Juri::current()?>?id=<?php echo $_GET['id'];?>&action=print";
                      window.open (nav_link_current);
              return_val = false;
          }
      

      return return_val;
    });

    $submitActors.click( function( event )
    {
      submitActor = this;
    });

  } );

  </script>
            <script type="text/javascript">
                
                $('document').ready(function(){
                    var action = "<?php echo $_GET['action'] ?>";
                        if(action.length > 0)
                        {
                            //alert(action);
                            $('.sidebar1').hide();
                            $('#resource_stack_container').hide();
                            $('#dispatch_button').hide();
                            $('#print_button').hide();
                        }                    
                });
                
                function validate_resource()
                {
                    
                var desc = true;
                var w_table = $('table#workers_table tbody').get();
                var total_number_of_rows =  parseInt($('tr',w_table).length);
                var number_of_rows =  total_number_of_rows -  2;
                var no_of_men = parseInt($('#no_of_men').val());
                
                    if(number_of_rows > no_of_men)
                    {
                       var cnf = confirm("Your are assigning 'Worker(s)' more than required.");
                       
                           if(cnf == false)
                           {
                               desc = false;    
                           }
                    }
                
                    var w_table_x = $('table#truck_table tbody').get();
                    var total_number_of_rows_x_x =  parseInt($('tr',w_table_x).length);
                    var number_of_rows_x =  total_number_of_rows_x_x -  2;
                    var no_of_trucks = parseInt($('#no_of_trucks').val());
                
                    if(number_of_rows_x > no_of_trucks)
                    {
                       var cnf_x = confirm("Your are assigning 'Truck(s)' more than required.");
                       
                           if(cnf_x == false)
                           {
                               desc = false;    
                           }
                    }
                                    
                    var fields = $('#resource_form').find('input[type=text]').get();
                    //alert(fields);
                    $(fields).each(function(indx,obj){
                        
                            if($(obj).val() == '')
                            {
                                alert('Please select complete resource(s)');
                                desc = false;
                                return desc;
                            }                                                
                    });
                    
                    return desc;
                }                
                function validate_resource_min()
                {
                    
                var desc = true;
                var w_table = $('table#workers_table tbody').get();
                var total_number_of_rows =  parseInt($('tr',w_table).length);
                var number_of_rows =  total_number_of_rows -  2;
                var no_of_men = parseInt($('#no_of_men').val());
                
                    if(number_of_rows < no_of_men)
                    {
                       
                               desc = false;    
                       
                    }
                
                    var w_table_x = $('table#truck_table tbody').get();
                    var total_number_of_rows_x_x =  parseInt($('tr',w_table_x).length);
                    var number_of_rows_x =  total_number_of_rows_x_x -  2;
                    var no_of_trucks = parseInt($('#no_of_trucks').val());
                
                    if(number_of_rows_x < no_of_trucks)
                    {                       
                               desc = false;                               
                    }                                                                                                
                    
                    var desc_final = true;
                        if(desc == false)
                        {
                           var cnf = confirm("Not all resource(s) have been assigned to this order, do you want to continue");                       
                           if(cnf == false)
                           {
                               desc_final = false;    
                           }else{
                               desc_final = true; 
                           }
                        }
                        
                    return desc_final;
                }                
            </script>
            
            <script type="text/javascript">
                $('document').ready(function(){                    
                    $('input#save_button').hide();                                        
                });
                
                function check_box_clicked(rs_id,ord_id,worker_id,order_date,truck,type,status)
                {                                        
                    var url = "<?php echo JURI::current(); ?>"+"?rs_id="+rs_id+"&ord_id="+ord_id+"&worker_id="+worker_id+"&order_date="+order_date+"&action=del_resource&truck="+truck+"&type="+type+"&status="+status;
                    window.location = url;
                }
            </script>
            
            <form class="form-validate" action="<?php echo JURI::current(); ?>" method="post" name="resource_form" id="resource_form">
                
                
                <input type="hidden" name="in_resources_page" id="in_resources_page" value="yes" />                
                <input type="hidden" name="date_order" id="date_order" value="<?php echo $order->date_order; ?>" />
                <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->id; ?>" />                                
                <input name="order_no_rs" type="hidden" value="<?php echo $order->order_no;?>" />  
                <input name="order_name_rs" type="hidden" value="<?php echo $order->name;?>" />      
                <input name="date_order_rs" type="hidden" value="<?php echo (isset($order->date_order))?(date('m/d/Y',strtotime($order->date_order))):('');?>">

      <?php if(count($ad_on_orders)!=0):?>                    
                    <?php foreach($ad_on_orders as $ordr): ?>
					
                <input name="ad_on_order_id[]" type="hidden" id="ad_on_order_id" value="<?php echo $ordr->id;?>" />      

                    <?php endforeach; ?>
                <?php endif; ?>   
      
<!--    TABLE A    -->
<div style="min-height: 80px;">
<div style="float: left;width: 300px;">

		<table id="workers_table">
			<tr>
				<td class="blank"></td>
				<td class="title" id="worker_class">Worker</td>
				<td class="title" id="worker_class">Role</td>                                				
				<td class="title" id="worker_class">Status</td>                                				
				
			</tr>
                        
    <?php foreach($this->resources as $resource) { 
        
        $worker_assigned_obj = new JObject();
        
    ?>
             
      <?php if($resource->truck == '' || $resource->truck == '0') {?>                  
    <tr style="font-size: 14px;">       
    
        <td class="blank">
            
            
            <?php if(  ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) ) { ?>
            <input type="checkbox" name="del_check" checked="checked" id="del_check_<?php echo $resource->id; ?>" onclick="return check_box_clicked('<?php echo $resource->id?>','<?php echo $order->id ?>','<?php echo $resource->user_id; ?>','<?php echo $order->date_order; ?>','<?php echo $resource->truck ?>','worker','<?php echo $resource->status ?>')"></td>        
            <?php } ?>
        <td class="resource_cell"><?php 
        $wrkr = JFactory::getUser($resource->user_id);
        //echo $wrkr->name;                
        $db_wrkr = JFactory::getDbo();
        $qry_wrk = "SELECT * FROM #__workers WHERE user_id=$resource->user_id";
        $db_wrkr->setQuery($qry_wrk);
        $db_wrkr->query() or die(mysql_error());
        $worker_obj = $db_wrkr->loadObject();
        echo $worker_obj->first_name.' '.$worker_obj->last_name;        
        //imhere
        $worker_assigned_obj->set('name',$wrkr->name);
         ?>
        
            <input type="hidden" name="workers_alloted[]" id="workers_alloted" value="<?php echo $resource->user_id ?>" />
            <input type="hidden" name="resource_id[]" id="workers_alloted" value="<?php echo $resource->id ?>" />
        
        </td>
        
        
        <td class="resource_cell" id="role_td"><?php 
            /*
                    $db = JFactory::getDbo();
                    $query="SELECT * FROM #__worker_role_index WHERE user_id=$resource->user_id";
                    $db->setQuery($query);
                    $db->query();
                    $role_indexes = $db->loadObjectList();
                    $role_string = '';

                    $total = count($role_indexes);
                    $coma = ',';
                    $cntr=1;
                    

                    foreach($role_indexes as $ri)
                    {
                                if($cntr == $total || $total==1)
                                {   
                                $coma = '';
                                }
                         
                            $queryA="SELECT * FROM #__worker_role WHERE id=$ri->role_id";
                            $db->setQuery($queryA);
                            $db->query();
                            $role = $db->loadObject();                            

                            if($role->name!=NULL)
                                echo strtoupper($role->name).$coma;
                                                            
                        $cntr++;
                    }
*/
                       echo $resource->worker_role;
                       $worker_assigned_obj->set('role', $resource->worker_role);
                        
                       array_push($assigned_workers_list,$worker_assigned_obj);
        ?></td>
        
        
        <?php
        //class="report_username report-detail-user-search-click grid_anchor"
        
                if( ($resource->status == 'R' && $authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) )
                {
        ?>
        <td class="resource_cell">
            <a id="resourcelink_<?php echo $resource->id ?>" class="report_username report-detail-user-search-click grid_anchor"><?php echo $resource->status; ?></a>
            
            <textarea style="display: none !important" id="comments_<?php echo $resource->id ?>"><?php echo $resource->comments ?></textarea>
        </td>
          <?php }else{ ?>
                        <td class="resource_cell"><?php echo $resource->status; ?></td>
         <?php } ?>
        
        
    </tr>
  <?php 
  
      }
  } ?>        
    <?php if( ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy)) { ?>
			<tr>
				<td class="blank"></td>
                                <td class="drop" id="worker_class">
                                    
                                    <span class="drop_msg">Drop Worker here</span>
                                    
                                </td>
                                <td class="resource_cell"></td>                                				
                                <td class="resource_cell"></td>                                				
			</tr>						
    <?php } ?>                        
		</table>
    </div>
<div style="float: left;width: 300px">
<!--    TABLE B    -->
		<table id="truck_table">
			<tr>
				<td class="blank"></td>
				
				<td class="title" id="truck_class">Truck</td>	
			</tr>
                        
    <?php foreach($this->resources as $resource) { ?>
        
                        
<?php if($resource->user_id == '0') {?>                        
    <tr style="font-size: 14px;">       
    
        <td class="blank">
            
            <?php if( ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) ) { ?>
            <input type="checkbox" name="del_check" checked="checked" id="del_check_<?php echo $resource->id; ?>" onclick="return check_box_clicked('<?php echo $resource->id?>','<?php echo $order->id ?>','<?php echo $resource->user_id; ?>','<?php echo $order->date_order; ?>','<?php echo $resource->truck ?>','truck')"></td>        
            <?php } ?>
        
        <td class="resource_cell">
            <?php 
        
        $truck_val = $resource->truck;                
        $truck_val_to_print = "";
        $truck_type_val = "";
        
        $db = JFactory::getDbo();
        
        if($truck_val !='')
        {
            if($resource->truck_type == 'fleet')
            {
                    $qry = "SELECT * FROM #__vehicles_fleet WHERE id=$truck_val";
                    $db->setQuery($qry);
                    $db->query() or die("Some Error A ==>".mysql_error());
                    $truck_obj = $db->loadObject();
                    if(isset($truck_obj) && $truck_obj!=NULL)
                    {
                        $truck_val_to_print=  $truck_obj->name;                                               
                        //$truck_type_val = " $resource->truck_type";                        
                        array_push($array_assigned_fleets, $truck_obj->id);
                    }
            }
            
            if($resource->truck_type == 'rental')
            {
                        $qryA = "SELECT * FROM #__vehicles_rental WHERE id=$truck_val";
                        $db->setQuery($qryA);
                        $db->query() or die("Some Error B ==>".mysql_error());
                        $truck_objA = $db->loadObject();            

                        if(isset($truck_objA) && $truck_objA!=NULL)
                        {
                            $truck_val_to_print=  $truck_objA->name;
                            //$truck_type_val = " $resource->truck_type";
                            array_push($array_assigned_rental, $truck_objA->id);
                        }
            }

            echo $truck_val_to_print;
            //echo $truck_val_to_print.$truck_type_val;
            // flag one
        }else{
            echo " -- ";
        }
        
        
        ?>
        
        </td>
        
        
        
        
        
     
    </tr>
  <?php } 
    }
  ?>    
    <?php if( ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) ) { ?>
			<tr>
				<td class="blank"></td>
            
                                <td class="drop" id="truck_class">
                                    
                                        <span class="drop_msg">Drop Truck here</span>
                                    
                                </td>
				
			</tr>
			
	<?php } ?>		
		</table>

</div>

</div>
    <br />     
    
    <?php if( ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) ) { ?>
                <input type="submit" name="submit" value="Save" id="save_button" />
                <input type="submit" name="submit" value="Dispatch" id="dispatch_button" />
                <input type="submit" name="submit" value="Print" id="print_button" />
    <?php } ?>               
            </form>    
            
	</div>
    
    
            
        </td>
    </tr>
    
    <tr>
        <td>
        
<?php

function make_worker_list($workers,$role_type,$av_loader_names = null)
{
 
    foreach($workers as $worker)
    {
        
        if($worker != NULL)
        {
                     
        $db = JFactory::getDbo();
        $query="SELECT * FROM #__worker_role_index WHERE user_id=$worker->user_id";
        $db->setQuery($query);
        $db->query();
        $role_indexes = $db->loadObjectList();
                        
        $role_string = '';
        
        $total = count($role_indexes);
        $coma = ',';
        $cntr=1;
        $isPrint = false;
        $html_all_loders = "";
        $role_html = '';
        
        if(is_array($role_indexes))
        {
        
            
        foreach($role_indexes as $ri)
        {
            
            if($cntr == $total)
                $coma = '';
                
                $queryA="SELECT * FROM #__worker_role WHERE id=$ri->role_id";
                $db->setQuery($queryA);
                $db->query();
                $role = $db->loadObject();                            
                
                
                if($role_type == 'loader')
                {
                        if($role->name == 'ldr-f' || $role->name == 'ldr-p')
                        {
                            $isPrint=true;                            
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Loader";
                        }                                                
                                                
                }
                
                if($role_type == 'packer')
                {
                        if($role->name == 'packer')
                        {
                            $isPrint=true;                            
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Packer";
                        }                                                
                                                
                }
                
                if($role_type == 'driver')
                {
                        if($role->name == 'drv-z' || $role->name == 'drv-g')
                        {                                                   
                            $isPrint=true;                            
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Driver";
                        }
                }
                
                
                if($role_type == 'crew')
                {
                        if($role->name == 'cc' || $role->name == 'cct' || $role->name == 'acc' || $role->name == 'acc-g')
                        {                                                    
                            $isPrint=true;      
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Crew Chief";
                        }
                }                                
            $cntr++;
        }
        
        }
        
                                
                $name_to_right = $worker->first_name.' '.$worker->last_name;
                $name_to_right_trunk = substr($name_to_right, 0 , 12);
                
                $html = "<tr><td><div class=\"worker_class\" id=\"worker-$worker->user_id\">$name_to_right_trunk $role_string<input type=\"hidden\" name=\"workers[]\" value=\"$worker->user_id\" /><input type='hidden' name='w_roles[]' id='w_roles' value='$role_html' /></div></td></tr>";
                if($isPrint == true)
                {                        
                    echo $html.$html_all_loders;
                }

                
                
        }// end worker null check       
  }
  
  return $av_loader_names;
}



function make_worker_list_black($workers,$role_type,$av_loader_names = null)
{
 
    $wrkr_already_array = array();
    
    foreach($workers as $worker)
    {
        
        if($worker != NULL)
        {
                     
        $db = JFactory::getDbo();
        $query="SELECT * FROM #__worker_role_index WHERE user_id=$worker->user_id";
        $db->setQuery($query);
        $db->query();
        $role_indexes = $db->loadObjectList();
                        
        $role_string = '';
        
        $total = count($role_indexes);
        $coma = ',';
        $cntr=1;
        $isPrint = false;
        $html_all_loders = "";
        $role_html = '';
        
        if(is_array($role_indexes))
        {
        
            
        foreach($role_indexes as $ri)
        {
            
            if($cntr == $total)
                $coma = '';
                
                $queryA="SELECT * FROM #__worker_role WHERE id=$ri->role_id";
                $db->setQuery($queryA);
                $db->query();
                $role = $db->loadObject();                            
                
                
                if($role_type == 'loader')
                {
                        if($role->name == 'ldr-f' || $role->name == 'ldr-p')
                        {
                            $isPrint=true;                            
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Loader";
                        }                                                
                                                
                }
                
                if($role_type == 'packer')
                {
                        if($role->name == 'packer')
                        {
                            $isPrint=true;                            
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Packer";
                        }                                                
                                                
                }
                
                if($role_type == 'driver')
                {
                        if($role->name == 'drv-z' || $role->name == 'drv-g')
                        {                                                   
                            $isPrint=true;                            
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Driver";
                        }
                }
                
                
                if($role_type == 'crew')
                {
                        if($role->name == 'cc' || $role->name == 'cct' || $role->name == 'acc' || $role->name == 'acc-g')
                        {                                                    
                            $isPrint=true;      
                            array_push($av_loader_names, $worker->first_name.' '.$worker->last_name);
                            $role_html = "Crew Chief";
                        }
                }                                
            $cntr++;
        }
        
        }
        
                                
                $name_to_right = $worker->first_name.' '.$worker->last_name;
                $name_to_right_trunk = substr($name_to_right, 0 , 12);
                
                
                
                $html = "<tr><td><div class=\"all_loaders\">$name_to_right_trunk $role_string<input type=\"hidden\" name=\"workers[]\" value=\"$worker->user_id\" /><input type='hidden' name='w_roles[]' id='w_roles' value='$role_html' /></div></td></tr>";
                if($isPrint == true)
                {                        
                    if(!in_array($name_to_right_trunk, $wrkr_already_array))
                    {
                        echo $html.$html_all_loders;
                        array_push($wrkr_already_array, $name_to_right_trunk);
                    }
                    
                    
                }

                
                
        }// end worker null check       
  }
  
  return $av_loader_names;
}

function make_truck_list($fleets,$truck_type)
{
   
    foreach($fleets as $flt)
    {
        
        echo "<tr><td><div class=\"truck_class\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" /><input type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";
    }
    
    //echo "<tr><td><div class=\"truck_class\" id=\"truck1\">FM1<input type=\"hidden\" name=\"trucks[]\" value=\"FM1\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck2\">FM2<input type=\"hidden\" name=\"trucks[]\" value=\"FM2\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck3\">FM3<input type=\"hidden\" name=\"trucks[]\" value=\"FM3\" /></div></td></tr>";
}




function count_truck_list_not_assigned($trucks,$truck_type,$order)
{
   $cntr = 0;
    foreach($trucks as $flt)
    {    
        if( ! ( (strtotime($order->date_order) >= strtotime($flt->from_date)) && (strtotime($order->date_order) <= strtotime($flt->to_date)) )  )
        {
            $cntr = $cntr+1;
        }        
      
    }    
    
    return $cntr;
}

function make_truck_list_not_assigned($trucks,$truck_type,$order)
{
   
    if($truck_type == 'fleet')
    {
        foreach($trucks as $flt)
        {    
            // do somthing when not in range of [from-date] to [to-date]
            if( ! ( (strtotime($order->date_order) >= strtotime($flt->from_date)) && (strtotime($order->date_order) <= strtotime($flt->to_date)) )  )
            {
                echo "<tr><td><div class=\"truck_class\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" /><input type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";            

            }        
        }
    }
    if($truck_type == 'rental')
    {
        foreach($trucks as $flt)
        {    
            // do somthing when  in range of [from-date] to [to-date]
            if( ( (strtotime($order->date_order) >= strtotime($flt->from_date)) && (strtotime($order->date_order) <= strtotime($flt->to_date)) )  )
            {
                echo "<tr><td><div class=\"truck_class\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" /><input type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";            

            }        
        }        
    }
    
    /*
    foreach($trucks as $flt)
    {
        
        echo "<tr><td><div class=\"truck_class\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" /><input type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";
    }
    */
    //echo "<tr><td><div class=\"truck_class\" id=\"truck1\">FM1<input type=\"hidden\" name=\"trucks[]\" value=\"FM1\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck2\">FM2<input type=\"hidden\" name=\"trucks[]\" value=\"FM2\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck3\">FM3<input type=\"hidden\" name=\"trucks[]\" value=\"FM3\" /></div></td></tr>";
}

function make_truck_list_not_assigned_counter($trucks,$counter_array)
{
   
    foreach($trucks as $flt)
    {    
        // do somthing when not in range of [from-date] to [to-date]
        if( ! ( (strtotime($order->date_order) >= strtotime($flt->from_date)) && (strtotime($order->date_order) <= strtotime($flt->to_date)) )  )
        {
            //echo "<tr><td><div class=\"truck_class\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" /><input type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";    
            array_push($counter_array, $flt);                
        }        
    }    
    
    return $counter_array;
}

function make_truck_list_assigned($trucks,$truck_type)
{
   
    foreach($trucks as $flt)
    {
        
        echo "<tr><td><div class=\"all_loaders\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" /><input type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";
    }
    
    //echo "<tr><td><div class=\"truck_class\" id=\"truck1\">FM1<input type=\"hidden\" name=\"trucks[]\" value=\"FM1\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck2\">FM2<input type=\"hidden\" name=\"trucks[]\" value=\"FM2\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck3\">FM3<input type=\"hidden\" name=\"trucks[]\" value=\"FM3\" /></div></td></tr>";
}



?>    
  
        
<?php if( ($authentication_group == 'admin' && $switch_to_none_admin=='false') && !isset($rs_id_dummy) ) { ?>

    
<div id="resource_stack_container">    
    
    <h3 style="margin-bottom: 10px">Available Resources</h3>
    
    <div style="width: 600px;"> 
<div class="left sctack_container">
    
    <div id="loaders_table_wrapper">
    <h5>Loader(s)</h5>
		<table id="loaders_table">
                    
                    <?php 
                    
                    $av_loader_names = array();
                    $av_loader_names = make_worker_list($workers,'loader',$av_loader_names);
                                        
                    $number_of_loaders = count($av_loader_names);
                    
                    ?>
                    
                    
                    <?php                        
                    $rs_loader_names = array();
                    $rs_loader_names = make_worker_list_black($workers_in_rs_on_order_date,'loader',$rs_loader_names);                    
                    ?>
                    
                    
                    <?php                    
                    // praparing available loaders name
                            $all_loaders_names = array();
                            foreach ($all_loaders as $loader):                            
                                array_push($all_loaders_names, $loader->first_name.' '.$loader->last_name);                                
                            endforeach;                                                                                 
                    ?>
                    
                    <?php 
                         //$rem_loaders = array_diff($all_loaders_names,$av_loader_names);
                         //foreach ($rem_loaders as $rem_loader)
                         //{                                                      
                    ?>
<!--                    <tr><td><div class="all_loaders"><?php //echo $rem_loader ?></div></td></tr>   -->
                   <?php //} ?>
                    
                    
                    
                    <?php
//                    foreach($assigned_workers_list as $worker)
//                    {
//                        if($worker->role == 'Loader')
//                        {
?>
<!--                                <tr><td><div class="all_loaders"><?php //echo $worker->name ; ?></div></td></tr> -->
<?php               
//                        }
 //                   }
?>

		</table>
    </div>
    
    <div id="packers_table_wrapper">
                <h5>Packer(s)</h5>
		<table id="packers_table">
                    
                    <?php                     
                    $av_packer_names = array();
                    $av_packer_names = make_worker_list($workers,'packer',$av_packer_names);                    
                    ?>
                    
                    <?php                     
                    $rs_packer_names = array();
                    $rs_packer_names = make_worker_list_black($workers_in_rs_on_order_date,'packer',$rs_packer_names);                    
                    ?>
                    
                    
                     <?php                    
                    // praparing available packers name
                            $all_packers_names = array();
                            foreach ($all_packers as $packer):                            
                                array_push($all_packers_names, $packer->first_name.' '.$packer->last_name);                                
                            endforeach;                                                                                 
                    ?>
                    
                    <?php 
//                         $rem_packers = array_diff($all_packers_names,$av_packer_names);
//                         foreach ($rem_packers as $rem_packer)
//                         {                                                      
                    ?>
<!--                    <tr><td><div class="all_loaders"><?php //echo $rem_packer ?></div></td></tr>   -->
                   <?php // } ?>
                    
                    
                </table>
     </div>   
</div>
    
    
<div class="left sctack_container">
    
    
    <h5>Driver(s)</h5>
		<table id="drivers_table">
                    
                    <?php 
                    $av_driver_names = array();
                    $av_driver_names = make_worker_list($workers,'driver',$av_driver_names); 
                    ?>
                    
                    
                    <?php 
                    $rs_driver_names = array();
                    $rs_driver_names = make_worker_list_black($workers_in_rs_on_order_date,'driver',$rs_driver_names); 
                    ?>
                    
                    
                    <?php                    
                    // praparing available drivers name
                    
                            $all_drivers_names = array();
                            
                            //imhere
                            foreach ($all_drivers as $driver):                            
                                array_push($all_drivers_names, $driver->first_name.' '.$driver->last_name);                                
                            endforeach;                                                                                 
                    
                    ?>

<!--         Logic-A           -->
                    <?php 
//                         $rem_drivers = array_diff($all_drivers_names,$av_driver_names);
//                         foreach ($rem_drivers as $rem_driver)
//                         {                                                      
                    ?>
<!--                    <tr><td><div class="all_loaders"><?php //echo substr($rem_driver,0,12) ?></div></td></tr>   -->
                   <?php // } ?>

<!--  Logic-B       -->


<?php
//                    foreach($assigned_workers_list as $worker)
//                    {
//                        if($worker->role == 'Driver')
//                        {
?>
<!--                                <tr><td><div class="all_loaders"><?php //echo $worker->name ; ?></div></td></tr> -->
<?php               
//                        }
//                    }
?>

<!--    sample row                -->
<!--                        <tr>
                            <td><div class="worker_class" id="worker1">Worker-A<input type="text" name="worker-009" /></div></td>
			</tr>
			-->
		</table>
</div>
    
<div class="left sctack_container">
    <h5>Crew Chief(s)</h5>
		<table id="crew_chief_table">
                    
                    <?php 
                    
                        $av_crew_names = array();
                        $av_crew_names = make_worker_list($workers,'crew',$av_crew_names);
                    ?>
                    
                    
                    <?php 
                    
                        $rs_crew_names = array();
                        $rs_crew_names = make_worker_list_black($workers_in_rs_on_order_date,'crew',$rs_crew_names);
                    ?>
                    
                    
                    <?php                    
                    // praparing available drivers name
                    
                            $all_crews_names = array();
                            
                            foreach ($all_crews as $crew):                            
                                array_push($all_crews_names, $crew->first_name.' '.$crew->last_name);                                
                            endforeach;                                                                                 
                    
                    ?>

                    <?php 
                         //$rem_crews = array_diff($all_crews_names,$av_crew_names);
                         //foreach ($rem_crews as $rem_crew)
                         //{                                                      
                    ?>
<!--                    <tr><td><div class="all_loaders"><?php //echo substr($rem_crew,0,12) ?></div></td></tr>   -->
                   <?php //} ?>
                    
                    <?php
//                    foreach($assigned_workers_list as $worker)
//                    {
//                        if($worker->role == 'Crew Chief')
//                        {
?>
<!--                                <tr><td><div class="all_loaders"><?php //echo $worker->name ; ?></div></td></tr> -->
<?php               
//                        }
//                    }
?>

<!--    sample row                -->
<!--                        <tr>
                            <td><div class="worker_class" id="worker1">Worker-A<input type="text" name="worker-009" /></div></td>
			</tr>
			-->
		</table>
</div>
    
    
        
<div class="truck_stack sctack_container">
    
    <h5>Truck(s)</h5>
    
    
		<table id="trucks_table">
                    <tbody>
                      
                                <?php 
                                // old code
                                //make_truck_list_not_assigned($fleets_not_assigned,"fleet",$order); 
                                
                                
                                // new code                                
                                make_truck_list_not_assigned($remaining_fleets,"fleet",$order); 
                                ?>                        
                                <?php 
                                //old code
                                //make_truck_list_not_assigned($rentals_not_assigned,"rental",$order);
                                
                                //new code
                                make_truck_list_not_assigned($remaining_rentals,"rental",$order);
                                ?>
                                
                                <?php 
                                // old code
                                //make_truck_list_assigned($fleets_assigned,"fleet"); 
                                
                                make_truck_list_assigned($assigned_fleets_array,"fleet");                                 
                                ?>                        
                                <?php 
                                // old code
                                //make_truck_list_assigned($rentals_assigned,"rental"); 
                                
                                //new code
                                make_truck_list_assigned($assigned_rentals_array,"rental"); 
                                ?>
                        
                                
                    </tbody>
		</table>
</div>
    
    </div>
</div>
        
        <?php } //authentication group check.?>
            
        </td>
    </tr>
</table>



</div>

<script type="text/javascript">
    $('document').ready(function(){
        initiateLinkClick();        
        
    });
    
    
    function initiateLinkClick()
            {
                $( ".report-detail-user-search-click" )        
                                .click(function() {                                                                        
                                    var linkid = $(this).attr('id');
                                    var linkid_array = linkid.split('_');
                                    var the_id = linkid_array[1];
                                    var comment_id = "comments_"+the_id;                                    
                                    $('#dialog-form-user-search-message').html( $('#'+comment_id).val() );
                                    
                                    $('#apDiv3').show();
                                    
                                    
                                });  
                                
                                $('#cross_char').click(function(){
                                    
                                    $('#apDiv3').hide();
                                });
            }
            
</script>


<?php 
$rs_id = JRequest::getVar('rs_id');

$rs_comments = '';
$rs_status = '';

if($rs_id == NULL)
{
    $rs_id=$rsId_for_crnt_wrkr_of_crnt_ordr->id;
    $rs_comments = $rsId_for_crnt_wrkr_of_crnt_ordr->comments;    
    $rs_status = $rsId_for_crnt_wrkr_of_crnt_ordr->status;    
}



//var_dump($rsId_for_crnt_wrkr_of_crnt_ordr->status);

//if($act == "update_resource_status"){ 
            if($authentication_group !='admin' || $switch_to_none_admin=='true' || isset($rs_id_dummy))
            {
 ?>

    <script src="<?php echo $this->baseurl ?>/templates/atomic/js/jquery-1.8.3.js"></script>
    <script src="<?php echo $this->baseurl ?>/templates/atomic/js/jquery-ui.js"></script>    
    
    <script type="text/javascript">
        $('document').ready(function(){
            render_comment_dialog_form();
            render_assign_resources_dialog_form();            
        });
        
            function render_assign_resources_dialog_form()
            {
                        $(function() {
                            
                            $( "#dialog-form-user-search" ).dialog({
                                autoOpen: false,
                                height: 250,
                                width: 450,
                                modal: true,
                                buttons: {
                                    "Close": function() {
                                        // do some thing
                                        $( this ).dialog( "close" );
                                    }
                                    
                                },
                                close: function() {
                                    
                                }
                            });

                                 // click place
                                initiateLinkClick();  
                        });
            }
            
            
            
            
        
            function render_comment_dialog_form()
            {
                        $(function() {
                            
                            $( "#dialog-form-comment" ).dialog({
                                autoOpen: false,
                                height: 310,
                                width: 450,
                                modal: true,
                                buttons: {
                                    "Done": function() {
                                        /*
                                        var selected_user_id = $('#dialog-form-user-search-username-list').val();
                                        var selected_user_name = $('#dialog-form-user-search-username-list option:selected').text();
                                        var selected_role = $('#dialog-form-user-search-role-list option:selected').text();
                                        var uniq_code =  $('#current_unique_code').val();                                                                                
                                        
                                        // ========= setting values========
                                        $('#userid_'+uniq_code).val(selected_user_id);
                                        $('#namelink_'+uniq_code).html(selected_user_name);
                                        $('#role_'+uniq_code).html(selected_role);
                                        $('#rolefield_'+uniq_code).val(selected_role);
                                        */
                                       var reasons = $('#dialog-form-comments-box').val();                                       
                                       $('#dialog-form-comments-box-submit').val(reasons);
                                       $('#post_comment').val('yes');                                       
                                       //$('form#update_status_form').submit();
                                        $( this ).dialog( "close" );
                                        
                                    },
                                    Cancel: function() {
                                        $( this ).dialog( "close" );
                                    }
                                },
                                close: function() {
                                    
                                }
                            });

                           // click place
                        });
            }
    
    $('document').ready(function(){
    /*
        $('input[name=confirm_order]').change(function(obj){
                
                var status_value_current = $('input[name=confirm_order]:checked').val();
                alert(status_value_current);
                    if(status_value_current == 'R')
                    {
                        $( "#dialog-form-comment" ).dialog( "open" );
                    }
                
            });            
        */    
        $('input[name=confirm_order]').click(function(obj){
                
                var status_value_current = $('input[name=confirm_order]:checked').val();
                //alert(status_value_current);
                
                    
                    
                        if(status_value_current == 'R')
                        {
                            if( $('#rs_as_status').val().toString() == 'C' || $('#rs_as_status').val().toString() == 'CD')
                            {
                                alert('To Reject and order that you have already confirmed you must contact the office.');
                                if(navigator.appName == "Microsoft Internet Explorer")
                                        event.returnValue = false;
                                    else
                                        return false;
                                    
                                    //$('input[name=confirm_order]:checked').val();
                                    var checkboxes = $('input[name=confirm_order]').get();
                                    //alert(checkboxes.length);
                                    $(checkboxes).each(function(i,obj){
                                        //$('.myCheckbox').prop('checked', true);
                                            if(i==2)
                                            {
                                                //alert('here');
                                                var nmbr = '0';
                                                if( $('#rs_as_status').val().toString() == 'C')
                                                {
                                                    nmbr = '0';
                                                }
                                                if( $('#rs_as_status').val().toString() == 'CD')
                                                {
                                                    nmbr = '1';
                                                }
                                                $('input#confirm_order_'+nmbr).attr('checked','checked');
                                                //alert($('input#confirm_order_0').attr('checked'));
                                            }
                                        //alert($('.myCheckbox').val()+" = "+i);
                                    });
                            }else{
                                $( "#dialog-form-comment" ).dialog( "open" );
                            }
                            
                        }
                
            });            
            
            
    });
    
    </script>

<script type="text/javascript">
    function validate_update_status()
    {
        
            var role = "<?php echo $rsId_for_crnt_wrkr_of_crnt_ordr->worker_role; ?>";
            //alert(role);
            //alert($('input[name=confirm_order]:checked').val());
            var return_flag = true;                     
            if( ($('input[name=confirm_order]:checked').val() == 'CD') && (role == 'Driver' || role=='Crew Chief')  )
            {
                var cnf = confirm('Your role involves driving an FMI truck, are you sure you are able to direct drive for this job?');
                if(cnf == false)
                {
                    return_flag = false;
                }
            }
            
            if($('input[name=confirm_order]:checked').val() == 'R')
            {                                
                if($('#dialog-form-comments-box-submit').val().length < 5)
                {
                    alert("Please enter valid reason to reject.");
                    return_flag = false;
                }
            }
            
            
            return return_flag;
    }
    
    
    
</script>


<style type="text/css">

    div#dialog-form-user-search
    {
        font-size: 80.5%;
    }
    
    div#dialog-form-user-search h1,h2,span
    {
        font-size: 80.5%;
    }
    
  
select#dialog-form-user-search-username-list,select#dialog-form-user-search-role-list{
    display: inline-block;
    padding: 4px 3px 5px 5px;
    width: 175px;
    outline: none;
    color: #74646e;
    border: 1px solid #C8BFC4;
    border-radius: 4px;
    box-shadow: inset 1px 1px 2px #ddd8dc;
    background-color: #fff;        
}


        .dialog-form-user-search-username-list,select#dialog-form-user-search-role-list
        {
            position: inherit !important;            
            visibility: visible !important;
        }
        
        
        
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
        
        
    </style>

     <div style="margin-left: 70px;">
    
    <form id="update_status_form" name="update_status_form" method="post" action="<?php echo JURI::current(); ?>" onSubmit="return validate_update_status();">
    <input type="hidden" name="action" value="update_resource_status" />
    <input type="hidden" name="rs_id" value="<?php echo $rs_id; ?>" />
    <input type="hidden" name="action" value="update_resource_status" />
    <input type="hidden" name="post_comment" id="post_comment" value="no" />
    <input type="hidden" name="rs_as_status" id="rs_as_status" value="<?php echo $rs_status;?>" />
    
    <textarea style="display: none" name="dialog-form-comments-box-submit" id="dialog-form-comments-box-submit" class="dialog-form-comments-box-submit"></textarea>
  <p>
    <label>
        <input type="radio" name="confirm_order" value="C" id="confirm_order_0" <?php echo(  (isset( $rsId_for_crnt_wrkr_of_crnt_ordr) && $rsId_for_crnt_wrkr_of_crnt_ordr->status == 'C')   ||    $rsId_for_crnt_wrkr_of_crnt_ordr->status == 'D' || $rsId_for_crnt_wrkr_of_crnt_ordr->status == 'A' )?('checked=checked'):('') ?> />
      Confirmed</label>
    <br />
    <label>
      <input type="radio" name="confirm_order" value="CD" id="confirm_order_1" <?php echo(isset($rsId_for_crnt_wrkr_of_crnt_ordr) && $rsId_for_crnt_wrkr_of_crnt_ordr->status == 'CD')?('checked=checked'):('') ?> />
      Confirm-Direct-Drive</label>
    <br />
    <label>
      <input type="radio" name="confirm_order" value="R" id="confirm_order_2" <?php echo(isset($rsId_for_crnt_wrkr_of_crnt_ordr) && $rsId_for_crnt_wrkr_of_crnt_ordr->status == 'R')?('checked=checked'):('') ?>/>
      Rejected</label>
    <br />
  </p>
  <br />
  
  
  <div id="dialog-form-comment" title="Write Reason">
    
 

<table style="width:100%">
    <tr>
    
          <td><p class="field_para" style="padding-left: 0px !important">
        <label for="return_time">Reason</label>
        <textarea name="dialog-form-comments-box" id="dialog-form-comments-box" class="dialog-form-comments-box main_forms_field" cols="100" rows="6" style="width: 100% !important;font-size: 14px !important"><?php echo $rs_comments; ?></textarea>
        </p></td>
    </tr>
</table>

      
      
      
      
      
</p>

</div>
        

  <input id="order_button" class="button" type="submit" name="order_button" value="Proceed">
</form>
   
</div>
<?php 
            }
    //} ?>

    
<!--    <div id="dialog-form-user-search" title="Reason"></div>-->

<style type="text/css">
#popup_table tr td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #900;
	background-color: #F99;
	border: 1px solid #900;
	padding: 5px;
}
#popup_table tr td button{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px !important;
	color: #900;
	background-color: #F99;
	text-decoration: none;
        border: 0px solid;        
}
#popup_table tr td button:hover{
	cursor: pointer;   
}

#apDiv3 {
	position:absolute;	
	z-index:1;
	left: 444px;
	top: 666px;
        width: 500px;
        height: 500px;
        display: none;
}

</style>

<div id="apDiv3">
 <table id="popup_table" width="500" border="0">
  <tr>
      <td>[<button href="#" id="cross_char"> X </button>] <strong>Reason</strong></td>
  </tr>
  <tr>
    <td><div id="dialog-form-user-search-message"></div></td>
  </tr>
</table>
</div>
<?php

function getRoleNames($user_id)
{            
                    $db = JFactory::getDbo();
                    $query="SELECT * FROM #__worker_role_index WHERE user_id=$user_id";
                    $db->setQuery($query);
                    $db->query();
                    $role_indexes = $db->loadObjectList();
                    $role_string = '';

                    $total = count($role_indexes);
                    $coma = ',';
                    $cntr=1;
                    

                    foreach($role_indexes as $ri)
                    {
                                if($cntr == $total || $total==1)
                                {   
				$coma = '';
                                }
                         
                            $queryA="SELECT * FROM #__worker_role WHERE id=$ri->role_id";
                            $db->setQuery($queryA);
                            $db->query();
                            $role = $db->loadObject();                            

                            if($role->name!=NULL)
                            {
                                $role_string .= strtoupper($role->name).$coma;
                                
                                
                            }
                                                      
                        $cntr++;
                    }
                    
                    
                    return $role_string;
}

?>

<script type="text/javascript">
            
            $('document').ready(function(){
                
                loadOrderFiles();
            });
            function loadOrderFiles()
            {
                                
                var oId = "<?php echo JRequest::getVar('id') ?>";
                var url = "<?php echo JURI::current(); ?>/orders/?task=load_order_files";
                var file_link = "";
                $.post(url,{order_id:oId}, 
                function(data) {
                    
                    $.each(data,function(i,obj){
                        var file_url_link = "<?php echo JUri::base().'files/'?>"+obj.file_name;
                        var x_string = "";
                        file_link += "<p class='file_link_para' id='para_"+obj.file_name+"'>"+x_string+"<a target='_blank' class='file_link_anchor' href='"+file_url_link+"'>"+obj.file_title+"</a></p>";
                    });
                    
                    var hdng = "<label for='cell' class='fhdng'>Attached files("+data.length+")</label>";
                    $('#f_hdng').html(hdng);                    
                    $('#files_wrapper').html(file_link);                    
                },"json");
            }
         
        </script>
        
<?php

        function get_worker_by_id($user_id)
        {
           
            $db = JFactory::getDbo();
            
            //$query = "DELETE FROM #__users WHERE id IN($user_id)";            
            
            $query = "
            Select
  #__users.id,
  #__users.name,
  #__users.username,  
  #__workers.first_name,
  #__workers.user_id,
  #__workers.last_name,
  #__workers.s_n,
  #__workers.dob,
  #__workers.start_date,
  #__workers.dl_no,
  #__workers.class,
  #__workers.status,
  #__workers.email,
  #__workers.cell,
  #__workers.home,
  #__workers.shirt_size,
  #__workers.pant_leg,
  #__workers.waist,
  #__workers.receive_update_by,
  #__workers.desired_shift,
  #__workers.created_by,
  #__workers.created_date,
  #__workers.updated_by,
  #__workers.updated_date,
  #__workers.active_status,
  #__workers.verified_status,
  #__workers.initial,
  #__fua_userindex.id As fua_id,
  #__fua_userindex.user_id As user_id1,
  #__fua_userindex.group_id
From
  #__users Inner Join
  #__workers On #__users.id = #__workers.user_id
  Inner Join
  #__fua_userindex
    On #__users.id = #__fua_userindex.user_id
Where
  #__users.id = $user_id And
  #__workers.user_id = #__users.id And
  #__fua_userindex.user_id = #__users.id

            ";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $this->_worker = $db->loadObject();
            
            return $this->_worker;
        }
?>        
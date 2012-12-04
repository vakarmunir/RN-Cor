<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_ ( 'behavior.formvalidation' );




$db = JFactory::getDbo();

$app = JFactory::getApplication();
$order = $this->item;
$heading = "Schedule Resources";
$dep_time = date('h:i:s A',strtotime($order->departure_time));
$time_array = array();
$time_array = split(' ',$dep_time);
$time = split(':',$time_array[0]);
$time_option = strtolower($time_array[1]);

$workers = $this->workers_on_order_date;

$fleets = $this->fleets; 
$rentals = $this->rentals;

$all_loaders = $this->all_loaders;
function make_status_list()
{
    echo "<option value='accepted'>Accepted</option><option value='rejected'>Rejected</option>";
}


$ad_on_orders = $this->ad_on_orders;
//var_dump($ad_on_orders);

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
                                                        /*
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
                                                        */
                                                }                                                
                                                
                                                $('input#save_button').show();
					}
				}
			});
		});
    }
	
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
    
    
    
    
<!-- start ad-on -->

                <?php if(count($ad_on_orders)!=0):?>                    
                    <?php foreach($ad_on_orders as $ordr): ?>
                                                                      
<tr>
    <td><p class="field_para">        
        
            <label for="order_no">Ad-On Order#</label>
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
    
    
  <tr>
    <td><p class="field_para">
      <label for="no_of_trucks">No Of Men</label>
      <input disabled="disabled" name="no_of_men" type="text" class="main_forms_field_date required" id="no_of_men" tabindex="4" value="<?php echo $order->no_of_men;?><?php echo (isset($form_data['m']))?($form_data['m']):('')?>" />
      </p></td>
    <td><p class="field_para">
      <label for="no_of_trucks">No Of Truck(s)</label>
      <input disabled="disabled" name="no_of_trucks" type="text" class="main_forms_field_date required" id="no_of_trucks" tabindex="5" value="<?php echo $order->no_of_trucks;?><?php echo (isset($form_data['t']))?($form_data['t']):('')?>"  />
      </p></td>
    <td>
        
        
        
    </td>
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
      <td colspan="3">
          <?php if(isset($order->instruction_file) && $order->instruction_file!='')
                        
            {?>        
            <p style="text-align: left;width: 210px;margin-top: 10px;"><a href="<?php echo JUri::base().'files/'.$order->instruction_file ?>">View file</a></p>
        <?php }
        ?>
      
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
	<div class="right">
            
            <script type="text/javascript">
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
            </script>
            
            <script type="text/javascript">
                $('document').ready(function(){                    
                    $('input#save_button').hide();                                        
                });
                
                function check_box_clicked(rs_id,ord_id,worker_id,order_date,truck,type)
                {                                        
                    var url = "<?php echo JURI::current(); ?>"+"?rs_id="+rs_id+"&ord_id="+ord_id+"&worker_id="+worker_id+"&order_date="+order_date+"&action=del_resource&truck="+truck+"&type="+type;                    
                    window.location = url;
                }
            </script>
            
            <form class="form-validate" action="<?php echo JURI::current(); ?>" method="post" name="resource_form" id="resource_form" onsubmit="return validate_resource();">
                
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
                        
    <?php foreach($this->resources as $resource) { ?>
             
      <?php if($resource->truck == '' || $resource->truck == '0') {?>                  
    <tr style="font-size: 14px;">       
    
        <td class="blank">
            
            
            
            <input type="checkbox" name="del_check" checked="checked" id="del_check_<?php echo $resource->id; ?>" onclick="return check_box_clicked('<?php echo $resource->id?>','<?php echo $order->id ?>','<?php echo $resource->user_id; ?>','<?php echo $order->date_order; ?>','<?php echo $resource->truck ?>','worker')"></td>        
        <td class="resource_cell"><?php 
        $wrkr = JFactory::getUser($resource->user_id);
        echo $wrkr->name;                
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
        ?></td>
        
        <td class="resource_cell"><?php echo $resource->status; ?></td>
        
    </tr>
  <?php 
  
      }
  } ?>        
			<tr>
				<td class="blank"></td>
                                <td class="drop" id="worker_class"><span class="drop_msg">Drop Worker here</span></td>
                                <td class="resource_cell"></td>                                				
                                <td class="resource_cell"></td>                                				
			</tr>						
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
            
            <input type="checkbox" name="del_check" checked="checked" id="del_check_<?php echo $resource->id; ?>" onclick="return check_box_clicked('<?php echo $resource->id?>','<?php echo $order->id ?>','<?php echo $resource->user_id; ?>','<?php echo $order->date_order; ?>','<?php echo $resource->truck ?>','truck')"></td>        
        
        <td class="resource_cell">
            <?php 
        
        $truck_val = $resource->truck;                
        $truck_val_to_print = "";
        
        $db = JFactory::getDbo();
        
        if($truck_val !='')
        {        
        $qry = "SELECT * FROM #__vehicles_fleet WHERE id=$truck_val";
        $db->setQuery($qry);
        $db->query() or die("Some Error A ==>".mysql_error());
        $truck_obj = $db->loadObject();
        if(isset($truck_obj) && $truck_obj!=NULL)
        {
            $truck_val_to_print=  $truck_obj->name;
        }else{
            $qryA = "SELECT * FROM #__vehicles_rental WHERE id=$truck_val";
            $db->setQuery($qryA);
            $db->query() or die("Some Error B ==>".mysql_error());
            $truck_objA = $db->loadObject();            
            
            if(isset($truck_objA) && $truck_objA!=NULL)
            {
                $truck_val_to_print=  $truck_obj->name;
            }
        }                
        echo $truck_val_to_print;
        
        }else{
            echo " -- ";
        }
        
        
        ?>
        
        </td>
        
        
        
        
        
     
    </tr>
  <?php } 
    }
  ?>    
    
			<tr>
				<td class="blank"></td>
            
                                <td class="drop" id="truck_class"><span class="drop_msg">Drop Truck here</span></td>
				
			</tr>
			
			
		</table>

</div>

</div>
    <br />                
                <input type="submit" name="submit" value="Save" id="save_button" />
                <input type="submit" name="submit" value="Dispatch" id="dispatch_button" />
                
            </form>    
            
	</div>
    
    
    
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
                            $role_html = "Driver";
                        }
                }
                
                
                if($role_type == 'crew')
                {
                        if($role->name == 'cc' || $role->name == 'cct' || $role->name == 'acc' || $role->name == 'accg')
                        {                                                    
                            $isPrint=true;      
                            $role_html = "Crew Chief";
                        }
                }                                
            $cntr++;
        }
        
        }
        
                
                //$role_html = getRoleNames($worker->user_id);
                
                $html = "<tr><td><div class=\"worker_class\" id=\"worker-$worker->user_id\">$worker->first_name $worker->last_name $role_string<input type=\"hidden\" name=\"workers[]\" value=\"$worker->user_id\" /><input type='hidden' name='w_roles[]' id='w_roles' value='$role_html' /></div></td></tr>";
                if($isPrint == true)
                {                        
                    echo $html.$html_all_loders;
                }

                
                
        }// end worker null check       
  }
  
  return $av_loader_names;
}

function make_truck_list($fleets)
{
   
    foreach($fleets as $flt)
    {
        
        echo "<tr><td><div class=\"truck_class\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" /></div></td></tr>";
    }
    
    //echo "<tr><td><div class=\"truck_class\" id=\"truck1\">FM1<input type=\"hidden\" name=\"trucks[]\" value=\"FM1\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck2\">FM2<input type=\"hidden\" name=\"trucks[]\" value=\"FM2\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck3\">FM3<input type=\"hidden\" name=\"trucks[]\" value=\"FM3\" /></div></td></tr>";
}



?>    
    
<div id="resource_stack_container">    
    
    <h3 style="margin-bottom: 10px">Available Resources</h3>
    
    <div style="width: 600px;"> 
<div class="left sctack_container">
    <h5>Loader(s)</h5>
		<table id="loaders_table">
                    
                    <?php 
                    
                    $av_loader_names = array();
                    $av_loader_names = make_worker_list($workers,'loader',$av_loader_names);
                    
                    ?>
                    
                    
                    <?php
                    
                    // praparing available loaders name
                            $all_loaders_names = array();
                            foreach ($all_loaders as $loader):                            
                                array_push($all_loaders_names, $loader->first_name.' '.$loader->last_name);                                
                            endforeach;                                                        
                         
                    ?>
                    
                    <?php 
                         $rem_loaders = array_diff($all_loaders_names,$av_loader_names);
                         foreach ($rem_loaders as $rem_loader)
                         {                                                      
                    ?>
                    <tr><td><div class="all_loaders"><?php echo $rem_loader ?></div></td></tr>   
                   <?php } ?>
		</table>
</div>
    
    
<div class="left sctack_container">
    
    
    <h5>Driver(s)</h5>
		<table id="drivers_table">
                    
                    <?php echo make_worker_list($workers,'driver'); ?>

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
                    
                    <?php echo make_worker_list($workers,'crew'); ?>

<!--    sample row                -->
<!--                        <tr>
                            <td><div class="worker_class" id="worker1">Worker-A<input type="text" name="worker-009" /></div></td>
			</tr>
			-->
		</table>
</div>
    
    
<div class="truck_stack sctack_container">
    
    <h5>Truck(s)</h5>
		<table>
                    <?php make_truck_list($fleets); ?>
                    <?php make_truck_list($rentals); ?>
                    
                    
<!--                    sample row
			<tr>
                            <td><div class="truck_class" id="truck1">truck-A<input type="text" name="truck-009" /></div></td>
			</tr>
			-->
		</table>
</div>
    
    </div>
</div>
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
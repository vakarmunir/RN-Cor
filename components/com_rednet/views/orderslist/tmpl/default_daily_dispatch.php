<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
                $order_no = JRequest::getVar('order_no');
                $name = JRequest::getVar('name');
                $date_order = JRequest::getVar('date_order');
                
                
$all_records = $this->all_records;

$array_of_sum_of_assigned_workers = array();
$array_of_sum_of_assigned_trucks = array();

$fleets = $this->fleets; 
$form_data = $this->form_data;
$rentals = $this->rentals;
$workers = $this->workers_on_order_date;
$all_loaders = $this->all_loaders;
$all_drivers = $this->all_drivers;
$all_crews = $this->all_crews;


$resources_all_fleets_by_orderdate = $form_data['resources_all_fleets_by_orderdate'];


$resources_all_rentals_by_orderdate = $form_data['resources_all_rentals_by_orderdate'];

                    $arrayid_resources_all_fleets_by_orderdate = array();
                    if(count($resources_all_fleets_by_orderdate) > 0)
                    {
                        foreach($resources_all_fleets_by_orderdate as $rs_flts_dt)
                        {                    
                            array_push($arrayid_resources_all_fleets_by_orderdate, $rs_flts_dt->truck);
                        }
                    }
                    
                    $arrayid_resources_all_fleets_by_orderdate = array_unique($arrayid_resources_all_fleets_by_orderdate);
                    //var_dump($arrayid_resources_all_fleets_by_orderdate);
                    $assigned_fleets_array = array();
                    if(count($fleets) > 0)
                    {
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
                    }
                    
                    
                    
                    $array_of_fleets_id = array();                    
                    
                    if(count($fleets) > 0)
                    {
                        foreach ($fleets as $flt)
                        {
                            array_push($array_of_fleets_id, $flt->id);
                        }
                    }
                    
                    
                    $remaining_fleets_id = array_diff($array_of_fleets_id, $arrayid_resources_all_fleets_by_orderdate);
                    
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
                    
                    
                    
                    
                    
                    //echo "<br />================== Assigned rentals =============== <br />";                    
                    $arrayid_resources_all_rentals_by_orderdate = array();
                    
                    if(count($resources_all_rentals_by_orderdate) > 0)
                    {
                        foreach($resources_all_rentals_by_orderdate as $rs_rntls_dt)
                        {                    
                            array_push($arrayid_resources_all_rentals_by_orderdate, $rs_rntls_dt->truck);
                        }
                    }
                    
                    $arrayid_resources_all_rentals_by_orderdate = array_unique($arrayid_resources_all_rentals_by_orderdate);
                    //var_dump($arrayid_resources_all_rentals_by_orderdate);
                    $assigned_rentals_array = array();
                    
                    if(count($rentals) > 0)
                    {
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
                    }
                    
                    
                    $array_of_rentals_id = array();                    
                    if(count($rentals) > 0)
                    {
                        foreach ($rentals as $rntl)
                        {
                            array_push($array_of_rentals_id, $rntl->id);
                        }
                    }
                    
                    //var_dump($array_of_rentals_id);
                    //echo "<br />=========================================== <br />";                    
                    $remaining_rentals_id = array_diff($array_of_rentals_id, $arrayid_resources_all_rentals_by_orderdate);                                                           
                    
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

                    
?>

<style type="text/css">
    
</style>

<script type="text/javascript">
    $(function() {
		$( "#date_order" ).datepicker({
			showOn: "button",
			buttonImage: "/rednet/templates/atomic/images/calendar.gif",
			
			buttonImageOnly: true
		});
	});        
</script>


        

<script type="text/javascript">    
    $('ready').ready(function(){                
        
        $('#packers_table_wrapper').hide();
        
        $('#order_button').click(function(){          
            var server = "<?php echo JURI::base(); ?>";            
            var path =server+"<?php echo "index.php/component/rednet/orders?task=order_form";?>";            
            window.location = path;
        });
    });
</script>


<script type="text/javascript">
    
    $('document').ready(function(){
        dd_widget();
    });
    
    
    
    function dd_widget()
    {
        	$(function(){
                    
                    $('.row_droper').droppable({
				onDragEnter:function(){
					$(this).addClass('over');
                                        
				},
				onDragLeave:function(){
					$(this).removeClass('over');
				},
				onDrop:function(e,source){                                                                       
                                      
                                      var droper_id = $(this).attr('id');
                                      
//                                        alert("source id: " + $(source).attr('id'));
//                                        alert("target id: " + $(this).attr('id'));
                                        var source_id = parseInt($(source).attr('id').split('_')[1]);
                                        var target_id = parseInt($(this).attr('id').split('_')[1]);
                                        
                                        
                                        // ========= selecting the source row and assigning to target row ===============


                                                    // ============= [end] copying truck row =================
                                                    var td_data = new Array();
                                                    var td_cntr = 0;
                                                    var source_row = $('tr#truckrowid_'+source_id);
                                                    $(source_row).find('td').each(function(){
                                                        //alert($(this).html());
                                                        td_data[td_cntr] = $(this).html();
                                                        td_cntr++;
                                                    });

                                                    var target_row = $('tr#truckrowid_'+target_id);
                                                    var td_cntr_trgt = 0;
                                                    var td_data_trgt = new Array();

                                                    $(target_row).find('td').each(function(){                                                        
                                                        // here to set field attributes.
                                                        var td_data_x = td_data[td_cntr_trgt];
                                                        var order_id = droper_id.split('_')[1];
                                                        
                                                        
                                                        
                                                            if( $(td_data_x).find('input.source_truck').length > 0 || $(td_data_x).find('input#source_truck').length > 0)
                                                            {
                                                                
                                                                                                                                
                                                                $(this).html(td_data_x);
                                                                var truck_new_name = "assignedtruckid_"+order_id+"[]";
                                                                var type_new_name = "assignedtrucktype_"+order_id+"[]";
                                                                $(this).find('input.source_truck').attr('name',truck_new_name);
                                                                $(this).find('input.source_truck').attr('id',truck_new_name);
                                                                
                                                                $(this).find('input#source_truck').attr('name',truck_new_name);
                                                                $(this).find('input#source_truck').attr('id',truck_new_name);
                                                                
                                                                $(this).find('input.source_type').attr('name',type_new_name);
                                                                $(this).find('input.source_type').attr('id',type_new_name);
                                                                
                                                                $(this).find('input#source_type').attr('name',type_new_name);
                                                                $(this).find('input#source_type').attr('id',type_new_name);                                                                                                                                                                                                
                                                               
                                                            }
                                                        
                                                        
                                                            if( $(td_data_x).find('input.source_rs').length > 0 || $(td_data_x).find('input#source_rs').length > 0)
                                                            {
                                                                $(this).find('input.source_rs').each(function(){
                                                                    //alert('here.....');
                                                                    $(this).remove();
                                                                });
                                                                
                                                            }
                                                        
                                                        //$(this).html(td_data[td_cntr_trgt]);                                                        
                                                        td_cntr_trgt++;
                                                    });
                                                    // ============= [end] copying truck row =================

                                                    // ============= [start] copying work row =================
                                                    var td_data_wrkr = new Array();
                                                    var td_cntr_wrkr = 0;
                                                    var source_row_wrkr = $('tr#workerrowid_'+source_id);
                                                    
                                                    $(source_row_wrkr).find('td').each(function(){                                                    
                                                        td_data_wrkr[td_cntr_wrkr] = $(this).html();
                                                        td_cntr_wrkr++;
                                                    });
                                                    
                                                    
                                                    var target_row_wrkr = $('tr#workerrowid_'+target_id);
                                                    var td_cntr_trgt_wrkr = 0;
                                                    var td_data_trgt_wrkr = new Array();

                                                    $(target_row_wrkr).find('td').each(function(){
                                                        
                                                        var td_data_x = td_data_wrkr[td_cntr_trgt_wrkr];
                                                        var order_id = droper_id.split('_')[1];                                                                                                                
                                                            if( $(td_data_x).find('input.source_worker').length > 0 || $(td_data_x).find('input#source_worker').length > 0 )
                                                            {
                                                               $(this).html(td_data_x);
                                                                var worker_new_name = "assignedworkerid_"+order_id+"[]";
                                                                var role_new_name = "w_roles"+order_id+"[]";
                                                                $(this).find('input.source_worker').attr('name',worker_new_name);
                                                                $(this).find('input.source_worker').attr('id',worker_new_name);
                                                                
                                                                $(this).find('input#source_worker').attr('name',worker_new_name);
                                                                $(this).find('input#source_worker').attr('id',worker_new_name);
                                                                
                                                                $(this).find('input.source_role').attr('name',role_new_name);
                                                                $(this).find('input.source_role').attr('id',role_new_name);   
                                                                
                                                                $(this).find('input#source_role').attr('name',role_new_name);
                                                                $(this).find('input#source_role').attr('id',role_new_name);   
                                                                
                                                                $(this).find('input.source_rs').each(function(){
                                                                    $(this).remove();
                                                                });
                                                            }
                                                        //$(this).html(td_data_wrkr[td_cntr_trgt_wrkr]);
                                                        td_cntr_trgt_wrkr++;
                                                    });
                                           //======================================================

                                        var c = $(source).clone().addClass('assigned');                                                                                                
					$(this).empty().append(c);
				}
			});
                                        
                    
                    
			$('.worker_class').draggable({
				revert:true,
				proxy:'clone'
			});
                        
			//$('.truck_stack .truck_class').draggable({
			$('.truck_class').draggable({
				revert:true,
				proxy:'clone'
			});
                        
			//$('.truck_stack .truck_class').draggable({
			$('.row_holder').draggable({
				revert:true,
				proxy:'clone',
                                start: function(event,ui) {
                                    //alert($(ui));
                                }
			});
                        
                        $('.right td.drop').droppable({
				onDragEnter:function(){
					$(this).addClass('over');
                                        
				},
				onDragLeave:function(){
					$(this).removeClass('over');
				},
				onDrop:function(e,source){
                                    
					if ($(source).hasClass('assigned')){
                                                    if($(this).attr('id') != $(source).attr('class'))
                                                    {
                                                        //alert('Dropping Invalid Resource.');
                                                        return false;
                                                    }                                                
						$(this).append(source);                                                
					} 
                                        else 
                                        {
                                            
                                                if($(this).attr('id') != $(source).attr('class'))
                                                    {
                                                        //alert('Dropping Invalid Resource.');
                                                        return false;
                                                    }
                                                    
                                                    
                                                    //duplicatin....
                                                    //var c = $(source).addClass('assigned');
                                                    
                                                    //alert($(source).find('input#w_roles').length);
                                                    var order_id_ind = $(this).find('#orderid').val();                                                    
                                                    //var c = $(source).clone().addClass('assigned');
                                                    //$(this).empty().append(c);
                                                    var passed_from_worker = false;
                                                    
                                                    
                                                        if($(source).attr('class') == 'worker_class')
                                                        {
                                                                                                                if($(source).find('input#w_roles').length == 0)
                                                                        {
                                                                            //alert('worker = 0');

                                                                            var passed_from_worker = true;                                                            
                                                                            var c = $(source).clone().addClass('assigned');
                                                                            $(this).empty().append(c);

                                                                            var order_id = order_id_ind;
                                                                            var worker_name_new = "assignedworkerid_"+order_id+"[]";
                                                                            var role_name_new = "w_roles"+order_id+"[]";
                                                                            $(this).find('input.source_worker').attr('name',worker_name_new);
                                                                            $(this).find('input.source_role').attr('name',role_name_new);



                                                                            $(this).find('input.source_rs').each(function(){
                                                                                    $(this).remove();
                                                                                });
                                                                            //alert(order_id);

                                                                        }

                                                                        if($(source).find('input#w_roles').length > 0)
                                                                        {
                                                                            //alert('worker > 0');
                                                                            var c = $(source).addClass('assigned');                                                            
                                                                            $(this).empty().append(c);

                                                                            var order_id = order_id_ind;
                                                                            var worker_name_new = "assignedworkerid_"+order_id+"[]";
                                                                            var role_name_new = "w_roles"+order_id+"[]";
                                                                            //assignedworkerid_91[]

                                                                            //alert($(c).find('input#source_worker').attr('name'));
                                                                            $(this).find('input#source_worker').attr('name',worker_name_new);
                                                                            $(this).find('input#w_roles').attr('name',role_name_new);
                                                                            //alert($(c).html());                                                           
                                                                            //source_worke
                                                                            //alert($(source).html());
                                                                            //  $(this).find('input#orderid').each(function(){
                                                                                //    alert('gooooooo');
                                                                                //});

                                                                        }


                                                        }
                                                    
                                           if($(source).attr('class') == 'truck_class')
                                           {             
                                                        if($(source).find('input.from_truck').length == 0)
                                                        {
                                                            //alert('not form resource.');
                                                            //alert('truck = 0');
                                                            var c = $(source).clone().addClass('assigned');
                                                            $(this).empty().append(c);
                                                            
                                                            var order_id = order_id_ind;
                                                            
                                                            var truck_name_new = "assignedtruckid_"+order_id+"[]";
                                                            var type_new = "assignedtrucktype_"+order_id+"[]";
                                                            $(this).find('input.source_truck').attr('name',truck_name_new);
                                                            $(this).find('input.source_type').attr('name',type_new);
                                                            $(this).find('input.source_rs').each(function(){
                                                                    $(this).remove();
                                                                });
                                                         
                                                        }
                                                        if($(source).find('input.from_truck').length > 0)
                                                        {
                                                            //alert('truck > 0');
                                                            var c = $(source).addClass('assigned');                                                            
                                                            $(this).empty().append(c);                                                            
                                                            var order_id = order_id_ind;                                                            
                                                            var truck_name_new = "assignedtruckid_"+order_id+"[]";
                                                            var type_new = "assignedtrucktype_"+order_id+"[]";
                                                            $(this).find('input#source_truck').attr('name',truck_name_new);
                                                            $(this).find('input#source_type').attr('name',type_new);
                                                            
                                                            
                                                        }   
                                                    
                                           }
						c.draggable({
							revert:true
						});  
                                                
                                                
                                                //alert($(source).attr('class'));
                                                
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
                                                        dd_widget();
                                                        
                                                        var in_source_html = $(source).get();
                                                        
                                                            var c_obj = source;
                                                            
                                                            var content=$(c_obj).clone().removeClass("truck_class assigned").addClass('all_loaders');
                                                            $('table#trucks_table tbody').append(content);
                                                }
                                                
                                                
                                                
                                                if($(source).attr('class') == 'worker_class assigned')
                                                {
                                                
                                                    
                                                    //alert('here........');
                                                    
                                                    var table_id = $(source).parent().parent().parent().parent().attr('id');
                                                    var roles = $('#w_roles',  $(source).get()).val();
                                                    
                                                    var rs_row = $(source).parent().parent().get();
                                                    
                                                    var cntr = 1;
                                                        $(rs_row).children().each(function ()
                                                        {
                                                            var cell = $(this);
                                                                if(cntr == 3)
                                                                {
                                                                    //$(this).text(roles);
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
                                                        dd_widget();
                                                        
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
                        // =============================================================================================
                });
    }
    
</script>

<h3 style="margin-left: 80px">Daily Dispatch</h3>

<!--<p>
<input class="button" type="submit" value="Create Order" name="order_button" id="order_button" />
</p>-->
<br />


<form name="filter_order_list" id="filter_order_list" action="<?php echo JURI::current().'?task=daily_dispatch_submit'; ?>" method="post">
        <table width="55%" border="0" style="margin-left: 75px;margin-bottom: 10px;">
            
                 
        <tr>
            
            <td>
                <p class="field_para" style="width: 215px !important">
            <label for="date_order">Date (mm/dd/yyyy)</label>

            <input name="date_order" type="text" class="main_forms_field required" id="date_order" tabindex="3" value="<?php echo (isset($date_order))?($date_order):('') ?>">

            </p>        
            </td>
            
            <td>
            <p class="field_para" style="width: 105px !important">
                    <label for="date_order">&nbsp;&nbsp;&nbsp;</label>

            <input class="button" type="submit" value="Filter" name="order_button" id="filter" />

            </p>        
                
            </td>
            
            </tr>  
            
            
        </table>   
    
</form>

<p>
<div style="margin-left: 100px;"> <table id="order_list"></table> <div id="porder_list"></div></div>
  
</p>

<div class="right">
    
   <script src="<?php echo $this->baseurl ?>/templates/atomic/js/colResizable-1.3.min.js"></script> 
<!--  <script  src="js/colResizable-1.3.min.js"></script>-->
  <script type="text/javascript">
	$(function(){	
//
//		var onSampleResized = function(e){
//			var columns = $(e.currentTarget).find("th");
//			var msg = "columns widths: ";
//			columns.each(function(){ msg += $(this).width() + "px; "; })
//			$("#sample2Txt").html(msg);
//			
//		};	
//	
//		$("#workers_table").colResizable({
//			liveDrag:true, 
//			gripInnerHtml:"<div class='grip'></div>", 
//			draggingClass:"dragging", 
//			onResize:onSampleResized});
//		
	});	
  </script>

    <script type="text/javascript">
//        
//            $('document').ready(function(){
//                var all_assigned_trucks_values = new Array();
//                var all_assigned_workers_values = new Array();
//                var all_assigned_trucks_objects = new Array();
//                var all_assigned_workers_objects = new Array();
//                var max_trucks_global = null;
//                var max_workers_global = null;
//                //alert("<?php echo JURI::base() ?>index.php/component/rednet/orders/?id=");
//                $('tr.table_row').each(function(){
//                    //alert( $(this).attr('id') );
//                    var rowid_string = $(this).attr('id');
//                    var rowid_array = rowid_string.split('_');
//                    var order_id = rowid_array[1];
//                    //alert(order_id);
//                    var url = "<?php echo JURI::base() ?>index.php/component/rednet/orders/?id="+order_id+"&mode=json";
//                    //alert(url);
//                    
//                        $.post(url, function(data) {
//                            //alert(data.all_assigned_workers.length);
//                                if(data.all_assigned_workers.length != 0)
//                                {
//                                    var all_assigned_workers = data.all_assigned_workers;
//                                    var all_assigned_trucks = data.all_assigned_trucks;
//                                    
//                                    //alert("Data Loaded: " + data.all_assigned_workers);
//                                    //alert("Men: " + all_assigned_workers.length);
//                                    var total_assigned_trucks = all_assigned_trucks.length;
//                                    var total_assigned_workers = all_assigned_workers.length;
//                                    
//                                   
//                                    $('#noofmenassigned_'+order_id+"").val(all_assigned_workers.length.toString());
//                                    $('#nooftrucksassigned_'+order_id+"").val(total_assigned_trucks.toString());
//                                    all_assigned_trucks_values.push(total_assigned_trucks);
//                                    all_assigned_workers_values.push(total_assigned_workers);
//                                    
//                                    var max_trucks = Math.max.apply( null, all_assigned_trucks_values );
//                                    var max_workers = Math.max.apply( null, all_assigned_workers_values );
//                                    max_trucks_global = max_trucks;
//                                    max_workers_global = max_workers;
//                                    //$('#ptest').text(all_assigned_trucks_values.toString());
//                                    
//                                    //====== [start] generating trucks columns base on max assigned truck value ===========
//                                        if(max_trucks > 2)
//                                        {
//                                            $('#ptest').text(max_trucks.toString());
//                                            $('table#truck_info_table tr').html('');
//                                            var i;                                    
//                                                for( i=0; i < max_trucks; i++ )
//                                                {
//                                                    var col_counter = parseInt(columnCount('table#truck_info_table'))+1;                
//                                                    addColumn('table#truck_info_table',"Col-Truck-"+col_counter,"x-cell");
//                                                }
//                                        }                                    
//                                   
//                                   
//                                   all_assigned_trucks_objects.push(all_assigned_trucks);
//                                   //$('#ptest').html("<p>## "+all_assigned_trucks_objects.length+" ##</p>");
//                                   $('#ptest').html("<p>## "+all_assigned_trucks_objects.length+" ##</p>");
//                                   
//                                       var table = $("table#truck_info_table")[0];
//                                       
//                                       for(var row=0; row<all_assigned_trucks_objects.length; row++)
//                                       {
//                                               for(var col=0; col<max_trucks_global; col++)
//                                               {
//                                                   $('#ptest').append("<p>^^["+row+"]["+col+"] "+all_assigned_trucks_objects[row][col].truck+" ^^</p>");                                                   
//                                                   var cell = table.rows[row+1].cells[col];                                                   
//                                                   //alert(cell);
//                                                   //$(cell).css('background-color', 'yellow');
//                                                   var cell_data = all_assigned_trucks_objects[row][col].truck_name+"<input type='text' name='truck_assigned[]' id='truckassigned_"+all_assigned_trucks_objects[row][col].truck+"' value='"+all_assigned_trucks_objects[row][col].truck+"' /><input type='text' name='truck_assigned_type[]' id='truckassignedtype_"+all_assigned_trucks_objects[row][col].truck_type+"' value='"+all_assigned_trucks_objects[row][col].truck_type+"' />";
//                                                   $(cell).html(cell_data);
//                                               }
//                                           
//                                       }
//                                 //====== [end] generating trucks columns base on max assigned truck value ===========                                      
//                                   
//                                   
//                                   //====== [start] generating workers columns base on max assigned workers value ===========
//                                        if(max_workers > 10)
//                                        {
//                                        
//                                            $('#ptest').text(max_workers.toString());
//                                            $('table#workers_info_table tr').html('');
//                                            var i;                                    
//                                                for( i=0; i < max_workers; i++ )
//                                                {
//                                                    var col_counter = parseInt(columnCount('table#workers_info_table'))+1;                
//                                                    addColumn('table#workers_info_table',"Col-Worker-"+col_counter,"x-cell");
//                                                }
//                                        }                                    
//                                   
//                                   //alert(max_workers);
//                                   all_assigned_workers_objects.push(all_assigned_workers);
//                                   //$('#ptest').html("<p>## "+all_assigned_workers_objects.length+" ##</p>");
//                                   $('#ptest').html("<p>## "+all_assigned_workers_objects.length+" ##</p>");
//                                    
//                                       var table = $("table#workers_info_table")[0];
//                                       
//                                       for(var rowx=0; rowx<all_assigned_workers_objects.length; rowx++)
//                                       {
//                                           
//                                               for(var colx=0; colx<max_workers_global; colx++)
//                                               {
//                                                   var worker_dimension = all_assigned_workers_objects[rowx][colx];
//                                                   var cell = table.rows[rowx+1].cells[colx];
//                                                   if ( (typeof worker_dimension === "undefined" || typeof cell ==='undefined') && (typeof worker_dimension === "undefined" && typeof cell ==='undefined')  )
//                                                   {
//                                                           alert('Loading error...');
//                                                   }else{
//                                                       //alert(col.toString());
//                                                        //$('#ptest').append("<p>^^["+rowx+"]["+colx+"] "+worker_dimension.user_id+" ^^</p>");
//                                                                                                           
//                                                        //alert(cell);
//                                                        //$(cell).css('background-color', 'yellow');
//                                                            
//                                                                
//                                                            
//                                                        //var cell_data = worker_dimension.full_name+"<input type='text' name='workers_assigned[]' id='workersassigned_"+worker_dimension.user_id+"' value='"+worker_dimension.user_id+"' /><input type='text' name='workers_assigned_type[]' id='workersassignedtype_"+worker_dimension.user_id+"' value='"+worker_dimension.user_id+"' />";
//                                                        
//                                                        var cell_data = worker_dimension.full_name;
//                                                        //alert(worker_dimension.id);
//                                                        $(cell).html(cell_data);
//                                                   }
//                                                   
//                                               }
//                                           
//                                       }
//                                 //====== [end] generating workers columns base on max assigned workers value ===========                                      
//                                   
//
//                                    
//                                }// [ end of first if ]
//                                
//                        },'json');
//                        
//                        //alert(all_assigned_trucks_values);
//                        
//                });
//            });
    </script>

    
    
 
    <script type="text/javascript">
        $('document').ready(function(){
            $('#testbutton').click(function(){
                
                
                
                var col_counter = parseInt(columnCount('table#truck_info_table'))+1;                
                addColumn('table#truck_info_table',"T-"+col_counter,"x-cell");
                
            });            
        });
        
        function addColumn(table_selector,heading,cell)
        {
            
            // add column at x position
//            $(''+table_selector+' tr:first ').find('td').eq(1).after("<td class='title'>heading</td>");  
//            $(table_selector+' tr:not(:first)').each(function(){
//                $(this).find('td').eq(1).after("<td class='drop'>cell</td>");
//            });
            
            // add column at specific position
//            $('#workers_table tr:first ').find('td').eq(1).after("<td class='title'>heading</td>");  
//            $('#workers_table tr:not(:first)').each(function(){
//                $(this).find('td').eq(1).after("<td class='drop'>cell</td>");
//            });
//            
            
            //=========== add column at end position ==========
            //making ...
            $(table_selector+' tr:first ').append("<td class='title'>"+heading+"</td>");  
            $(table_selector+' tr:not(:first)').each(function(){
                $(this).append("<td class='drop'>"+cell+"</td>");
            });
            //appending...
//            $(table_selector+' tr:first ').append("<td class='title'>"+heading+"</td>");  
//            $(table_selector+' tr:not(:first)').each(function(){
//                $(this).append("<td class='drop'>"+cell+"</td>");
//            });
        }
        
        
        function columnCount(table_selector)
        {
            var numCols = $(table_selector).find('tr')[0].cells.length;
            //alert('Total columns : '+numCols);
            return numCols;
        }
    </script>
    
                
    

    <style type="text/css">
        #all_table_wrapper
        {
         
            border: 0px solid blue;
            width: 3145px;
        }
        #all_table_wrapper table tr td
        {
            font-size: 8px;
            min-width: auto;
        }
        .tdtext
        {
            border: 0px solid blue;
            width: 100%;
            font-size: 8px;
        }
        #all_table_wrapper table
        {
            float: left;
            clear: right;
            border: 0px solid red;
        }
        a.fontlink:hover{
            cursor: pointer !important;
        }
    </style>
    <p>
        Font-size: 
    <a class="fontlink">8</a> |
    <a class="fontlink">10</a> |
    <a class="fontlink">12</a> |
    </p>
    <script type="text/javascript">
        $('document').ready(function(){
            
            $('a.fontlink').click(function(){                
                var size = $(this).text();
                $('#all_table_wrapper table tr td').css('font-size',size+"px");
                $('div.tdtext').css('font-size',size+"px");
            });
           
            
        });
    </script>
    
<form name="daily_dispatch" id="daily_dispatch" action="<?php echo JURI::current().'?task=daily_dispatch_save'; ?>" method="post">
    
    <input name="date_order" type="hidden" id="date_order" tabindex="3" value="<?php echo (isset($date_order))?($date_order):('') ?>">
    
<div id="all_table_wrapper">    

   
<table class="workers_table" id="order_info_table">
			<tr>
				<td class="blank"></td>
				<td class="title" id="worker_class">Customer</td>
				<td class="title" id="worker_class">Out-Of-Town</td>                                				
                                <td class="title" id="worker_class">Men-R</td>                                				
				<td class="title" id="worker_class">Truck-R</td>                                								
				<td class="title" id="worker_class">Men-A</td>
				<td class="title" id="worker_class">Truck-A</td>                                
				
			</tr>
                        
<!-- orders data row -->

<?php
if($all_records != NULL)
{
    foreach ($all_records as $record)
    {
        
?>
<tr id="rowid_<?php echo $record['order']->id ?>" class="table_row">
		<td class="blank">
                    
                    <div class="dd_wraper">
                                                    
                                <div id="holder_<?php echo $record['order']->id ?>" class="row_holder"> </div>
                            
                            
                                <div id="droper_<?php echo $record['order']->id ?>" class="row_droper"></div>
                            
                        
                    </div>
                    
                    
                </td>
                <td class="drop" id="worker_class">
                    
                        <?php 
                                echo $record['order']->name;
                                        
                                
                        ?>
                    
                        <?php 
                        //var_dump(($record['ad_on_orders']));
                        foreach ($record['ad_on_orders'] as $adon)
                        {
                            ?>
                    <input type="hidden" value="<?php echo $adon->id ?>" name="ad_on_order_id_of_<?php echo $adon->id ?>[]" id="adonorderid_<?php echo $record['order']->id ?><?php echo $adon->id ?>" />
                  <?php }    ?>                                            
                    
                        <input type="hidden" name="order_id[]" id="orderid_<?php echo $record['order']->id ?>" value="<?php echo $record['order']->id ?>" />
                        <input type="hidden" name="name" id="name_<?php echo $record['order']->id ?>" value="<?php echo $record['order']->name ?>" />
                    
                </td>
                <td class="drop" id="worker_class"><input type="checkbox" name="out_of_town" id="outoftown_<?php echo $record['order']->id ?>" <?php echo ($record['order']->out_of_town == 'yes')?('checked=checked'):('') ?> /></td>                                				
                <td class="drop" id="worker_class"><?php echo $record['order']->no_of_men ?><input type="hidden" name="no_of_men" id="noofmen_<?php echo $record['order']->id ?>" value="<?php echo $record['order']->no_of_men ?>" /></td>                                				
                <td class="drop" id="worker_class"><?php echo $record['order']->no_of_trucks ?><input type="hidden" name="no_of_truck" id="nooftruck_<?php echo $record['order']->id ?>" value="<?php echo $record['order']->no_of_trucks ?>" /></td>
                <td class="drop" id="worker_class"><?php echo count($record['all_assigned_workers']); ?><input type="hidden" name="noofmenassigned" id="noofmenassigned_<?php echo $record['order']->id ?>" value="<?php
                    echo count($record['all_assigned_workers']); 
                    array_push( $array_of_sum_of_assigned_workers, count($record['all_assigned_workers']) );
                ?>" /></td>
                <td class="drop" id="worker_class"><?php echo count($record['all_assigned_trucks']); ?><input type="hidden" name="nooftrucksassigned" id="nooftrucksassigned_<?php echo $record['order']->id ?>" value="<?php 
                    echo count($record['all_assigned_trucks']);
                    array_push($array_of_sum_of_assigned_trucks, count($record['all_assigned_trucks']));
                ?>" /></td>                                				
                
                
    </tr>
    
 <?php 
    }
 } ?> 
<!--    <tr>
		<td class="blank"></td>
                        <td class="drop" id="worker_class"><input type="hidden" name="worker_name" id="worker_name" /></td>
                        <td class="drop" id="worker_class"><input type="checkbox" name="out_of_town" id="out_of_town" />
                        </td>                                				
                 <td class="drop" id="worker_class"><input type="hidden" name="no_of_men" id="no_of_men" /></td>                                				
                 <td class="drop" id="worker_class"><input type="hidden" name="no_of_truck" id="no_of_truck" /></td>                                				
                 <td class="drop" id="worker_class"> </td>                                				
                 <td class="drop" id="worker_class"> </td>                                				
                
    </tr>						-->
  
		</table>
    
<table id="truck_info_table">

<tr>
    
<?php 
if($array_of_sum_of_assigned_trucks != NULL)
{
    if( count($record['all_assigned_trucks']) >= 0 ) { ?>
    
    <?php 
        $t_col_cntr = 1;        
    
        $max_limit_x = 0;
        if(max($array_of_sum_of_assigned_trucks) < 2)
        {
            $max_limit_x = 2;
        }  else {
            $max_limit_x = max($array_of_sum_of_assigned_trucks);
        }
        
        
    for($i=0; $i<$max_limit_x; $i++)    
    {
        ?>

                <td class="title" id="worker_class">T-<?php echo $t_col_cntr ?></td>
                
   <?php
          $t_col_cntr++;
    } 
   ?>
			
<?php 

    }
}
?>
</tr>

<?php
if($all_records != NULL)
{
    foreach ($all_records as $record)
    {
?>
<tr id="truckrowid_<?php echo $record['order']->id ?>" class="table_row truck_row">
    <?php 
    
    
    $max_limit_x = 0;
        if(max($array_of_sum_of_assigned_trucks) < 2)
        {
            $max_limit_x = 2;
        }  else {
            $max_limit_x = max($array_of_sum_of_assigned_trucks);
        }
        
    for($i=0; $i<$max_limit_x; $i++)    
    {
    //foreach($record['all_assigned_trucks'] as $rs){ 
        
    ?>
        
            
                
                <?php if( $record['all_assigned_trucks'][$i]->truck_name != NULL) { ?>
                    <td class="drop">
                            <div class="truck_class" style="height: auto !important">
                                <div class="tdtext"><?php echo $record['all_assigned_trucks'][$i]->truck_name ?></div>
                                
                                <?php
                                    //    var_dump($record['all_assigned_trucks'][$i]);
                                ?>
                                <input type="hidden" name="assignedtruckid_<?php echo $record['order']->id ?>[]" id="assignedtruckid_<?php echo $record['order']->id ?>" value="<?php echo $record['all_assigned_trucks'][$i]->truck; ?>" class="source_truck" />
                                <input type="hidden" name="assignedtrucktype_<?php echo $record['order']->id ?>[]" id="assignedtruckid_<?php echo $record['order']->id ?>" value="<?php echo $record['all_assigned_trucks'][$i]->truck_type; ?>" class="source_type" />
                                <input type="hidden" name="rsid_<?php echo $record['order']->id ?>[]" id="rsid_<?php echo $record['order']->id ?>" value="<?php echo $record['all_assigned_trucks'][$i]->rs_id; ?>" class="source_rs" />
                            </div>
                    </td>
                <?php }  else { ?>
                    <td class="drop" id="truck_class">
                        <div style="min-height: 29px !important">
                            <input type="hidden" name="orderid" id="orderid" value="<?php echo $record['order']->id ?>" />
                        </div>
                        
                    </td>
                 <?php   } ?>    
            
        
    <?php } ?>
</tr>
<?php
    }
}
?>
</table>

    
<table id="workers_info_table">
<tr>
    
    
<?php  if( count($record['all_assigned_workers']) >= 0 ) { ?>
    
    <?php 
        $w_col_cntr = 1;                       
        
//        var_dump( max($array_of_sum_of_assigned_workers) );
        
//        for($i=0; $i<max($array_of_sum_of_assigned_workers); $i++)
//        {
//            
//        }
    if($array_of_sum_of_assigned_workers != NULL)        
    {
            $max_limit = 0;
            if(max($array_of_sum_of_assigned_workers) < 10)
            {
                $max_limit = 10;
            }  else {
                $max_limit = max($array_of_sum_of_assigned_workers);
            }
        for($i=0; $i<$max_limit; $i++)    
        //foreach($record['all_assigned_workers'] as $rs)
        { ?>
                                    <td class="title" id="worker_class">W-<?php echo $w_col_cntr; ?></td>

    <?php 
            $w_col_cntr++;
        } 
    }       
}?>                                
<!--                            <td class="title" id="worker_class">Col-Worker-1</td>
				<td class="title" id="worker_class">Col-Worker-2</td>
				<td class="title" id="worker_class">Col-Worker-3</td>
				<td class="title" id="worker_class">Col-Worker-4</td>
				<td class="title" id="worker_class">Col-Worker-5</td>
				<td class="title" id="worker_class">Col-Worker-6</td>
				<td class="title" id="worker_class">Col-Worker-7</td>
				<td class="title" id="worker_class">Col-Worker-8</td>
				<td class="title" id="worker_class">Col-Worker-9</td>
				<td class="title" id="worker_class">Col-Worker-10</td>  
                                -->
</tr>

<?php
if($all_records != NULL)
{
    foreach ($all_records as $record)
    {
?>
<tr id="workerrowid_<?php echo $record['order']->id ?>" class="table_row worker_row">
        <?php 
        //var_dump($record['all_assigned_workers']);         
        $max_limit = 0;
        if(max($array_of_sum_of_assigned_workers) < 10)
        {
            $max_limit = 10;
        }  else {
            $max_limit = max($array_of_sum_of_assigned_workers);
        }
            for($i=0; $i<$max_limit; $i++)        
            //foreach($record['all_assigned_workers'] as $rs)
            {                
        ?>
    
    
<!--    <div class="truck_class" style="height: auto !important"></div>-->
    

        <?php if( $record['all_assigned_workers'][$i]->user_id != NULL ){ ?>
        <td class="drop" id="worker_class">
            <div class="worker_class" style="height: auto !important">
                <div class="tdtext"><?php echo $record['all_assigned_workers'][$i]->full_name; ?></div>
                
                <?php
                            //var_dump($record['all_assigned_workers'][$i]);
                ?>
                    <input type="hidden" class="source_worker" name="assignedworkerid_<?php echo $record['order']->id ?>[]" value="<?php echo $record['all_assigned_workers'][$i]->user_id ?>" />
                    <input type="hidden" class="source_role" name="w_roles<?php echo $record['order']->id ?>[]" value="<?php echo $record['all_assigned_workers'][$i]->worker_role ?>" />
                    <input type="hidden" name="rsidw_<?php echo $record['order']->id ?>[]" id="rsidw_<?php echo $record['order']->id ?>" value="<?php echo $record['all_assigned_workers'][$i]->rs_id; ?>" class="source_rs" />
            </div>        
        </td>            
       <?php }  else { ?>
        <td class="drop" id="worker_class">
            <div style="min-height: 27px !important">
                <input type="hidden" name="orderid" id="orderid" value="<?php echo $record['order']->id ?>" />
            </div>
        </td>
       <?php } ?>      
    
      <?php } ?>
<!--  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>
  <td class="drop" id="worker_class">&nbsp;</td>-->
</tr>
<?php
    }
}
?>
</table>
        
        
</div>    
    <br />
    <br />
    <input type="submit" name="submit" value="Save" />
    <input type="submit" name="submit" value="Dispatch" />
    </form>
    </div> 

        <?php

function make_truck_list_not_assigned($trucks,$truck_type,$date_order)
{
   
    foreach($trucks as $flt)
    {    
        // do somthing when not in range of [from-date] to [to-date]
        if( ! ( (strtotime($date_order) >= strtotime($flt->from_date)) && (strtotime($date_order) <= strtotime($flt->to_date)) )  )
        {
            echo "<tr><td><div class=\"truck_class\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" class=\"from_truck\" id=\"source_truck\" /><input id=\"source_type\" type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";                        
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


function make_truck_list_assigned($trucks,$truck_type)
{
   
    foreach($trucks as $flt)
    {
        
        echo "<tr><td><div class=\"all_loaders\" id=\"$flt->id\">$flt->name<input type=\"hidden\" name=\"trucks[]\" value=\"$flt->id\" class=\"from_truck\" id=\"source_truck\" /><input id=\"source_truck\" type=\"hidden\" name=\"truck_type[]\" value=\"$truck_type\"/></div></td></tr>";
    }
    
    //echo "<tr><td><div class=\"truck_class\" id=\"truck1\">FM1<input type=\"hidden\" name=\"trucks[]\" value=\"FM1\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck2\">FM2<input type=\"hidden\" name=\"trucks[]\" value=\"FM2\" /></div></td></tr><tr><td><div class=\"truck_class\" id=\"truck3\">FM3<input type=\"hidden\" name=\"trucks[]\" value=\"FM3\" /></div></td></tr>";
}


function make_worker_list($workers,$role_type,$av_loader_names = null)
{
 
    if(count($workers) > 0)
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

                    $html = "<tr><td><div class=\"worker_class\" id=\"worker-$worker->user_id\">$name_to_right_trunk $role_string<input type=\"hidden\" name=\"workers[]\" id=\"source_worker\" value=\"$worker->user_id\" /><input type='hidden' name='w_roles[]' id='w_roles' value='$role_html' /></div></td></tr>";
                    if($isPrint == true)
                    {                        
                        echo $html.$html_all_loders;
                    }



            }// end worker null check       
    }
    }
    
  
  return $av_loader_names;
}
?>


<div id="resource_stack_container" style="margin-left: 212px !important;margin-top: 70px;">    
    
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
                    // praparing available loaders name
                            $all_loaders_names = array();
                            if(count($all_loaders) > 0)
                            {
                                foreach ($all_loaders as $loader):                            
                                    array_push($all_loaders_names, $loader->first_name.' '.$loader->last_name);                                
                                endforeach;                                                                                 
                            }
                            
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
    
    <div id="packers_table_wrapper">
                <h5>Packer(s)</h5>
		<table id="packers_table">
                    
                    <?php                     
                    $av_loader_names = array();
                    $av_loader_names = make_worker_list($workers,'packer',$av_loader_names);                    
                    ?>
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
                    // praparing available drivers name
                    
                            $all_drivers_names = array();
                            if(count($all_drivers) > 0)
                            {
                                foreach ($all_drivers as $driver):                            
                                    array_push($all_drivers_names, $driver->first_name.' '.$driver->last_name);                                
                                endforeach;                                                                                 
                            }
                            
                    
                    ?>

                    <?php 
                         $rem_drivers = array_diff($all_drivers_names,$av_driver_names);
                         foreach ($rem_drivers as $rem_driver)
                         {                                                      
                    ?>
                    <tr><td><div class="all_loaders"><?php echo substr($rem_driver,0,12) ?></div></td></tr>   
                   <?php } ?>
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
                    // praparing available drivers name
                    
                            $all_crews_names = array();
                            
                            if(count($all_crews)>0)
                            {
                                foreach ($all_crews as $crew):                            
                                    array_push($all_crews_names, $crew->first_name.' '.$crew->last_name);                                
                                endforeach;                                                                                 
                            }
                            
                    
                    ?>

                    <?php 
                         $rem_crews = array_diff($all_crews_names,$av_crew_names);
                         foreach ($rem_crews as $rem_crew)
                         {                                                      
                    ?>
                    <tr><td><div class="all_loaders"><?php echo substr($rem_crew,0,12) ?></div></td></tr>   
                   <?php } ?>
                    

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
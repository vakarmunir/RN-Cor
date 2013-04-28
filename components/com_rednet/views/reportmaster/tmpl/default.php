<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();
$user_current = JFactory::getUser();


$primary_roles = $this->primary_roles;
$secondary_roles = $this->secondary_roles;
$additional_roles = $this->additional_roles;
$form_data = $this->form_data;
$data = $this->data;
$workers = $data['workers'];
//var_dump($workers);

$order = $data['order'];
$reportmaster = $data['reportmaster'];
$reportclients = $data['reportclients'];
$reportdetail = $data['reportdetail'];
$reporthowpaid = $data['reporthowpaid'];

$mode = (isset($reportmaster))?('edit'):('add');


$rl = getWorkersRolesFunc($user_current->id);

$bonus_enable = (($rl=='admin') || ($rl==''))?(""):("readonly=readonly");

        function getWorkersRolesFunc($user_id)
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
        $isPrint = false;
        $html_all_loders = "";
        $role_html = '';
        $role_of_user = '';
        
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
                
                
                
                        if($role->name == 'ldr-f' || $role->name == 'ldr-p')
                        {
                            
                            $role_html = "Loader";
                            $role_of_user = "loader";
                        }                                                                                                
                
                
                
                        if($role->name == 'packer')
                        {
                            
                            $role_html = "Packer";
                            $role_of_user = "loader";
                        }                                                                                                
                        
                        if($role->name == 'admin')
                        {
                            
                            $role_html = "Admin";
                            $role_of_user = "admin";
                        }                                                                                                
                
                        
                
                        if($role->name == 'drv-z' || $role->name == 'drv-g')
                        {                                                   
                            
                            $role_html = "Driver";
                            $role_of_user = "loader";
                        }
                
                                
                        if($role->name == 'cc' || $role->name == 'cct' || $role->name == 'acc' || $role->name == 'acc-g')
                        {                                                    
                            
                            $role_html = "Crew Chief";
                            $role_of_user = "crew";
                        }
                                                
            $cntr++;
        }
        
        }
        
            return $role_of_user;
        }
?>


        
<style>

    .comments_class
    {
        display: none;
    }
    div#dialog-form-user-search
    {
        font-size: 80.5%;
    }
    
    div#dialog-form-user-search h1,h2,h3,span
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
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
        
        .grid_anchor:hover
        {
            cursor: pointer;
        }
        .grid_anchor
        {
            cursor: pointer;
            text-decoration: underline;
        }
        
        .report-order-search-click:hover{
            cursor: pointer !important;
        }
        .report-order-search-click{
            color: black !important;
        }
    </style>

    
<?php 
        if(isset($this->msg)):
?>    
        <p>        
                <?php echo $this->msg; ?>
        </p>
<?php    endif; ?>

<script src="<?php echo $this->baseurl ?>/templates/atomic/js/jquery-1.8.3.js"></script>
    <script src="<?php echo $this->baseurl ?>/templates/atomic/js/jquery-ui.js"></script>    
    <script src="<?php echo $this->baseurl ?>/templates/atomic/js/jquery.maskedinput-1.3.min.js"></script>    
            
        <div id="test_html"></div>

        <script type="text/javascript">
            $('document').ready(function(){
                $(".time_field").mask("99:99 aa",{completed:function(){
                    
                }});
            
                $("#dpt_time").mask("99:99",{completed:function(){
                    
                }});
            
                init_payment_key_up();
                init_tip_cal();
                initialzeMask();
                initialzeClicks();
                init_payment_key_up();
                
                render_search_order_form();
                render_search_order_form_by_name();
                render_search_order_form_by_date();
                render_user_search_dialog_form();
                render_comment_dialog_form();
               
                $('.loading_div').hide().ajaxStart(function(){
                        $(this).show();
                    }).ajaxStop(function() {
                        $(this).hide();
                    });
                    
                    $('#warning').hide();
                    
                $('#order_no').keyup(function(){
                    
                        if($(this).val().length > 0)
                        {
                            //execute_search(this);
                        }                    
                });
                
                $('#order_no_x').keyup(function(){
                    
                        if($(this).val().length > 0)
                        {                            
                            execute_search_by_field(this,"order_no");
                        }                    
                });
                
                $('#name').keyup(function(){
                        if($(this).val().length > 0)
                        {
                            //execute_search(this);
                        }
                });
                
                $('#name_x').keyup(function(){
                        if($(this).val().length > 0)
                        {
                            //alert($(this).val());
                            execute_search_by_field(this,"name");
                        }                    
                });
                
                $('#order_date_x').keyup(function(){
                        if($(this).val().length > 0)
                        {
                            //alert($(this).val());
                            execute_search_by_field(this,"date_order");
                        }                    
                });
                
                $('.time_field').keyup(function(){
                    
                //alert("xxxxxxxx");
                        if($(this).val().indexOf('_') == -1)
                        {                            
                            var paid_hours,src_wx,dst_wx;
                            
                                if($(this).attr('id')=='return_time' && $('#departure_time').val().length > 0)
                                {                                    
                                    // Executing formula A
                                    src_wx = $('#return_time').val();
                                    dst_wx = $('#departure_time').val();                                    
                                    formulaA($('#return_time'),src_wx,dst_wx);
                                    //alert(src_wx);
                                    //alert("here...");
                                }
                                if($(this).attr('id')=='departure_time' && $('#return_time').val().length > 0)
                                {   
                                    // Executing formula A
                                    src_wx = $('#return_time').val();
                                    dst_wx = $('#departure_time').val();                                    
                                    formulaA($('#return_time'),src_wx,dst_wx);                                    
                                }
                            //alert(moment_result_wx);
                        }
                    
                });
                $('input#dpt_time').keyup(function(){                    
                
                        if($(this).val().indexOf('_') == -1)
                        {                            
                            var paid_hours,src_wx,dst_wx;                                                                                                
                                    // Executing formula A
                                    src_wx = $('#return_time').val();
                                    dst_wx = $('#departure_time').val();                                    
                                    formulaA($('#return_time'),src_wx,dst_wx);                                    
                                    
                                    make_travel_leak();
                        }                    
                });
                
                
                
                $('.time_field_two').keyup(function(){
                        
                        if($(this).val().indexOf('_') == -1)
                        {
                                if($(this).attr('id')=='total_work_hours_billed' && $('#travel_time_billed').val().length > 0)
                                {                                    
                                  var rsltnt_sum =  AddTwoTimes($('#total_work_hours_billed'),$('#travel_time_billed').val());                                  
                                  $('#travel_leak').val(diffTwoTimes($('#paid_hours') , rsltnt_sum));
                                }
                                
                                if($(this).attr('id')=='travel_time_billed' && $('#total_work_hours_billed').val().length > 0)
                                {                                    
                                  var rsltnt_sum =  AddTwoTimes($('#total_work_hours_billed'),$('#travel_time_billed').val());                                  
                                  $('#travel_leak').val(diffTwoTimes($('#paid_hours') , rsltnt_sum));
                                }                                                                
                        }
                });                                
                
            });
            
           
           function formulaA(this_var,return_time,departure_time)
           {
               
               
                            var dst_array = $(this_var).val().split(':');
                                    var mints_dst_array = dst_array[1].split(' ');
                                    var dst_ampm = mints_dst_array[1];
                                    
                                    var src_array = departure_time.split(':');    
                                    var hrs,mints;
                                    hrs= src_array[0];
                                    var mints_array = src_array[1].split(' ');
                                    mints = mints_array[0];
                                    var src_ampm = mints_array[1];
                                    var moment_wx = moment($(this_var).val(),"hh:mm");
                                    //alert(dst_ampm +" ** "+src_ampm);
                                    var depot_time = $("#dpt_time").val();
                                    var depot_time_array = depot_time.split(":");
                                    var depot_hrs = parseInt(depot_time_array[0],10);
                                    var depot_mints = parseInt(depot_time_array[1],10);
                                    //alert(depot_hrs+" === "+depot_mints);
                                        if( ( (parseInt(dst_array[0],10) - parseInt(src_array[0],10)) >= 1 )  )
                                        {
                                            moment_wx.subtract('h',hrs);
                                            moment_wx.subtract('m',mints);
                                            
                                            moment_wx.add('h',depot_hrs);
                                            moment_wx.add('m',depot_mints);
                                            
                                            var rsltant_string = moment_wx.format("hh:mm");
                                            $("#paid_hours").val(rsltant_string);                                            
                                        }else{                                            
                                            moment_wx.subtract('h',hrs);
                                            moment_wx.subtract('m',mints);
                                            
                                            moment_wx.add('h',depot_hrs);
                                            moment_wx.add('m',depot_mints);
                                            
                                                if(dst_ampm == src_ampm)
                                                {                                                    
                                                    var rsltant_string_array = moment_wx.format("hh:mm").split(':');
                                                    var rsltant_string = "0:"+rsltant_string_array[1];
                                                    $("#paid_hours").val(rsltant_string);                                            
                                                }else{
                                                    var rsltant_string = moment_wx.format("hh:mm");
                                                    $("#paid_hours").val(rsltant_string);
                                                }
                                            
                                        }                                                                                                            
           }
           
           function SubtractTwoTimes(this_var,departure_time)
           {
               var rslt_val = null;
               var rslt_cut = false;     
                    var dst_array = $(this_var).val().split(':');
                                    var hrs_dst = dst_array[0].toString();
                                    var mints_dst_array = dst_array[1].split(' ');
                                    var mints_dst = mints_dst_array[0];
                                    var dst_ampm = mints_dst_array[1];
                                    
                                    var src_array = departure_time.split(':');    
                                    var hrs,mints;
                                    hrs= src_array[0];
                                    var mints_array = src_array[1].split(' ');
                                    mints = mints_array[0];
                                    var src_ampm = mints_array[1];
                                    var moment_wx = moment($(this_var).val(),"hh:mm");
                                    
                                    //alert(dst_ampm +" ** "+src_ampm);
                                    //alert( dst_array[0]+" - "+src_array[0]+" = "+ (parseInt(dst_array[0]) - parseInt(src_array[0])).toString() );
                                    var dst_num = parseInt(dst_array[0].toString(),10);
                                    var src_num = parseInt(src_array[0].toString(),10);
                                    var diff_of_time = dst_num - src_num;
                                    
                                    
                                        if( diff_of_time > 0 )  
                                        {
                                            
                                            var hrs_num = parseInt(hrs,10);
                                            var hrs_dst_num = parseInt(hrs_dst,10);
                                            var dif_of_both_hrs = hrs_dst_num - hrs_num;
                                            
                                            moment_wx.subtract('h',hrs);
                                            moment_wx.subtract('m',mints);                                    
                                            var rsltant_string = moment_wx.format("hh:mm");
                                            
                                            if( dif_of_both_hrs == 1 )
                                            {                                                
                                                if(mints_dst.toString()!="00" || mints.toString()!="00")
                                                {
                                                      if(rsltant_string.split(":")[0] == '12')
                                                      {
                                                          rsltant_string = "00:"+rsltant_string.split(":")[1];                                                          
                                                      }                                                  
                                                }
                                            }
                                            
                                            
                                            if( dif_of_both_hrs == 0 )
                                            {                                                
                                                
                                                if(mints_dst.toString()!="00" || mints.toString()!="00")
                                                {
                                                      if(rsltant_string.split(":")[0] == '12')
                                                      {
                                                          rsltant_string = "00:"+rsltant_string.split(":")[1];                                                          
                                                      }                                                  
                                                }
                                            }
                                            
                                            
                                            rslt_val = rsltant_string;                                            
                                        }else{                                            
                                            moment_wx.subtract('h',hrs);
                                            moment_wx.subtract('m',mints);
                                            
                                                if(dst_ampm == src_ampm)
                                                {                                                    
                                                    var rsltant_string_array = moment_wx.format("hh:mm").split(':');
                                                    var rsltant_string = "00:"+rsltant_string_array[1];
                                                    //$("#paid_hours").val(rsltant_string);                                            
                                                    
                                                    rslt_val = rsltant_string;
                                                }else{
                                                    var rsltant_string = moment_wx.format("hh:mm");
                                                    //$("#paid_hours").val(rsltant_string);
                                                    rslt_val = rsltant_string;
                                                }                                            
                                        }
                                        
                                        return rslt_val;
           }
           
           function diffTwoTimes(this_var,departure_time)
           {
				var rslt_diff = "";
               var dst_array = $(this_var).val().split(':');
                                    var mints_dst_array = dst_array[1].split(' ');
                                    var dst_ampm = mints_dst_array[1];
                                    
                                    var src_array = departure_time.split(':');    
                                    var hrs,mints;
                                    hrs= src_array[0];
                                    var mints_array = src_array[1].split(' ');
                                    mints = mints_array[0];
                                    var src_ampm = mints_array[1];
                                    var moment_wx = moment($(this_var).val(),"hh:mm");
                                    //alert(dst_ampm +" ** "+src_ampm);
                                    
                                       
                                            moment_wx.subtract('h',hrs);
                                            moment_wx.subtract('m',mints);                                    
                                            var rsltant_string = moment_wx.format("hh:mm");
                                            //$("#paid_hours").val(rsltant_string);
                                            rslt_diff = rsltant_string;                                        
                                    
                                        return rslt_diff;                                       
           }
           
           function AddTwoTimes(left_object,right_string)
           {
               var add_rslt;
               
               var dst_array = $(left_object).val().split(':');
                                    var mints_dst_array = dst_array[1].split(' ');
                                    var dst_ampm = mints_dst_array[1];
                                    
                                    var src_array = right_string.split(':');    
                                    var hrs,mints;
                                    hrs= src_array[0];
                                    var mints_array = src_array[1].split(' ');
                                    mints = mints_array[0];
                                    var src_ampm = mints_array[1];
                                    var moment_wx = moment($(left_object).val(),"hh:mm");
                                    //alert(dst_ampm +" ** "+src_ampm);
                                    
                                        
                                            moment_wx.add('h',hrs);
                                            moment_wx.add('m',mints);                                    
                                            var rsltant_string = moment_wx.format("hh:mm");
                                            //$("#paid_hours").val(rsltant_string);
                                            add_rslt = rsltant_string;
                                            
                   return add_rslt;                                                        
           } 
           
           function SumTwoTimes(left_object,right_string)
           {
               var add_rslt;
                                                   
                                    var hrs,mints;
                                    var src_array = right_string.split(':');
                                    hrs = src_array[0];
                                    mints = src_array[1];
                                    var moment_wx = moment(left_object,"HH:mm");                                    
                                    moment_wx.add('h',hrs);
                                    moment_wx.add('m',mints);                                    
                                    var rsltant_string = moment_wx.format("HH:mm");                                                                        
                                    add_rslt = rsltant_string;
                                                                        
                                   //alert("hrs = "+hrs+ " mints= "+ mints);         
                                   //alert(left_object+" + "+right_string+ " = "+ add_rslt);         
                   return add_rslt;                                                       
           }           
           
            function execute_search_by_field(this_var,field_type)
            {
                var field = null;
                    if(field_type=="order_no")
                    {
                        //alert(field_type);
                        field = "order_no";
                        
                                                        var order_no = $(this_var).val();
							var current_tag_id = $(this_var).attr('id');                    
							
							//{ "order_no": order_no },
							
							var request_url = "<?php echo JURI::current(); ?>/?task=search_order_by_field&"+field+"="+order_no+"";
							//alert(request_url);
							$.post(request_url, 
							function(data){
                                                            
                                                            var tbody = $('#orders_by_order_no tbody');
                                                                $(tbody).empty();
                                                                $(data).each(function(i,obj){
                                                                    //var order_date_new = new Date(obj.date_order,"mm/dd/yyyy");
                                                                    var order_date_new = new Date(obj.date_order);
                                                                    
                                                                   var tr_new = "<tr id='tr_"+obj.id+"'><td><a class='order_no_search' id='orderid_"+obj.id+"'>"+obj.order_no+"</a></td><td>"+obj.name+"</td><td>"+(order_date_new.getMonth()+1).toString()+"/"+order_date_new.getDate().toString()+"/"+order_date_new.getFullYear().toString()+"</td></tr>";
                                                                   $(tbody).append(tr_new);
                                                                   initialzeClicks();
                                                                   init_tip_cal();
                                                                   init_payment_key_up();
                                                                });
                                                            },"json");
                     
                    }
                    
                    if(field_type=="name")
                    {
                                                        
                                                        field = "name";
                        
                                                        var name_val = $(this_var).val();
							var current_tag_id = $(this_var).attr('id');                    
							
							//{ "order_no": order_no },
							
							var request_url = "<?php echo JURI::current(); ?>/?task=search_order_by_field&"+field+"="+name_val+"";
							//alert(request_url);
							$.post(request_url, 
							function(data){
                                                            //alert(request_url+" =====> "+data);
                                                            //alert(data.x);
                                                            var tbody = $('#orders_by_order_name tbody');
                                                                $(tbody).empty();
                                                                $(data).each(function(i,obj){
                                                                    //var order_date_new = new Date(obj.date_order,"mm/dd/yyyy");
                                                                   var order_date_new = new Date(obj.date_order);
                                                                   var tr_new = "<tr id='tr_"+obj.id+"'><td>"+obj.order_no+"</td><td><a class='order_no_search' id='orderid_"+obj.id+"'>"+obj.name+"</a></td><td>"+(order_date_new.getMonth()+1).toString()+"/"+order_date_new.getDate().toString()+"/"+order_date_new.getFullYear().toString()+"</td></tr>";
                                                                   $(tbody).append(tr_new);
                                                                   initialzeClicks();
                                                                   init_tip_cal();
                                                                   init_payment_key_up();
                                                                });
                                                            },"json");
                     
                    }
                    if(field_type=="date_order")
                    {
                                                        
                                                        field = "date_order";
                        
                                                        var date_val = $(this_var).val();
							var current_tag_id = $(this_var).attr('id');                    
							
							//{ "order_no": order_no },
							
							var request_url = "<?php echo JURI::current(); ?>/?task=search_order_by_field&"+field+"="+date_val+"";
							//alert(request_url);
							$.post(request_url, 
							function(data){
                                                            //alert(request_url+" =====> "+data);
                                                            //alert(data.x);
                                                            var tbody = $('#orders_by_order_date tbody');
                                                                $(tbody).empty();
                                                                $(data).each(function(i,obj){
                                                                    //var order_date_new = new Date(obj.date_order,"mm/dd/yyyy");
                                                                   var order_date_new = new Date(obj.date_order);
                                                                   var tr_new = "<tr id='tr_"+obj.id+"'><td>"+obj.order_no+"</td><td>"+obj.name+"</td><td><a class='order_no_search' id='orderid_"+obj.id+"'>"+(order_date_new.getMonth()+1).toString()+"/"+order_date_new.getDate().toString()+"/"+order_date_new.getFullYear().toString()+"</a></td></tr>";
                                                                   //alert(order_date_new);
                                                                       if((order_date_new.getMonth()+1).toString()+"/"+order_date_new.getDate().toString()+"/"+order_date_new.getFullYear().toString() != '1/1/1970')
                                                                       {
                                                                           $(tbody).append(tr_new);
                                                                       }
                                                                   
                                                                   initialzeClicks();
                                                                   init_payment_key_up();
                                                                });
                                                            },"json");
                     
                    }
                                                        
                                                        
            }
            
            function execute_search(this_var)
{
		 var order_no = $(this_var).val();
							var current_tag_id = $(this_var).attr('id');                    
							
							//{ "order_no": order_no },
							
							var request_url = "<?php echo JURI::current(); ?>/?task=search_order&"+current_tag_id+"="+order_no;
							//alert(request_url);
							$.post(request_url, 
							function(data){                        
									if(data.id== "NULL")
									{                                                                                                
										//$("input#name").val("");
                                                                                        if(current_tag_id == "order_no")
											{
                                                                                            
                                                                                            $("input#name").val("");
                                                                                        }
                                                                                        if(current_tag_id == "name")
											{
                                                                                            $("input#order_no").val("");
                                                                                        }
                                                                                        
										$("input#order_id").val("");
										$("input#date_order").val("");
										$('#warning').show();
									}else{                                
											if(current_tag_id != "order_no")
											{
												$("input#order_no").val(data.order_no);
											}                                
                                                                                        $("input#order_id").val(data.id);

                                                                                        if(current_tag_id != "name")
											{
												$("input#name").val(data.name);												
											}                                
																																		
										var order_date = new Date(data.date_order);
										var order_date_string = ("0"+ (order_date.getMonth()+1).toString() ).slice(-2) +"/"+("0"+order_date.getDate()).slice(-2)+"/"+order_date.getFullYear().toString();
                                                                                $("input#date_order").val(order_date_string);																				                                                                                
                                                                                
                                                                                $('#warning').hide();
                                                                                load_assigned_worker(data.id);
                                                                                
                                                                                init_tip_cal();
                                                                                init_payment_key_up();
									}                                                
							},"json");
                                                        
                                                        
}



                                                                                function load_assigned_worker(order_id)
                                                                                {
                                                                                    var request_url = "<?php echo JURI::current(); ?>/?task=get_order_assigned_workers&"+"order_id"+"="+order_id;
                                                                                    $.post(request_url,
                                                                                    function(data){                                                                                        
                                                                                        
                                                                                            if(data.length > 0)
                                                                                            {
                                                                                                var row_append;
                                                                                                $.each(data,function(i,obj){  
                                                                                                    var row_id = "rowid_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var user_id = "userid_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var name_link = "namelink_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var role = "role_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var rolefield = "rolefield_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var readwritelink = "readwritelink_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var commentbox = "commentbox_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var tip_allow_id = "tipallow_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var tip_allow_amount = "tipamount_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    var hours = "hours_"+obj.order_no+obj.order_id+obj.user_id;
                                                                                                    row_append = row_append + '<tr id="'+row_id+'"><td><span class="report_text">'+(i+1)+'</span></td><td><input type="hidden" class="user_id_holder" name="user_id[]" id="'+user_id+'" value="'+obj.user_id+'" /><span class="report_text"><a class="report_username report-detail-user-search-click grid_anchor" id="'+name_link+'">'+obj.user_complete_name+'</a></span></td><td><input name="role[]" type="hidden" id="'+rolefield+'" value="'+obj.worker_role+'" /><span id="'+role+'" class="report_text">'+obj.worker_role+'</span></td><td><input name="hours[]" type="text" class="main_forms_field required hours_holder '+hours+'" id="hours" value="" style="width:50px !important" /></td><td><input type="checkbox" name="invoice[]" id="invoice" /></td><td><input name="tip_allow[]" type="text" class="main_forms_field required tip_allow_holder '+tip_allow_id+'" id="tip_allow" value="" style="width:50px !important" /></td><td style="display:none!important;"><input name="tip_amount[]" type="text" class="main_forms_field required '+tip_allow_amount+'" id="tip_amount" value="" style="width:50px !important" /></td><td><input type="checkbox" name="flag[]" id="flag" /></td><td><input <?php echo $bonus_enable; ?> name="bonus[]" type="text" class="main_forms_field" id="bonus" value="0" style="width:50px !important" /></td><td><textarea name="comments[]" id="'+commentbox+'" class="comments_class" cols="50" rows="6"></textarea><span class="report_text"><a id="'+readwritelink+'" class="read_write report-detail-comment-click grid_anchor">Read/Write</a></span></td></tr>';
                                                                                                });
                                                                                                    $("#report_detail_table").html(row_append);

                                                                                            }else{
                                                                                                $("#report_detail_table").empty();
                                                                                            }
                                                                                        
                                                                                            initialzeClicks();
                                                                                            init_payment_key_up();
                                                                                    },"json");
                                                                                }				   
                                                                                
                                                                                
                                                                                function load_order_and_adonorders(order_id)
                                                                                {
                                                                                    var request_url = "<?php echo JURI::current(); ?>/?task=get_order_and_adons&"+"order_id"+"="+order_id;                                                                                    
                                                                                    $.post(request_url,
                                                                                    function(data){                                                                                                                                                                                                                                                                        
                                                                                        var order = data.order;
                                                                                        var order_adons = data.order_adons;                                                                                        
                                                                                        var row_append = "";
                                                                                        
                                                                                        $("#order_id").val(order.id);
                                                                                        row_append += '<tr id="'+order.id+'">        <td>          <p class="field_para"><label for="client_name">Client-1</label>       <input name="o_id[]" id="o_id_'+order.id+'" type="hidden" type="text" value="'+order.id+'" />                   <input style="width: 100px !important" name="client_name[]" type="text" class="main_forms_field required time_field" id="client_name_'+order.id+'" tabindex="7" value="'+order.name+'" />          </p>        </td>        <td>           <p class="field_para"><label for="client_start">Start</label>            <input style="width: 100px !important" name="client_start[]" type="text" class="main_forms_field required time_field calc_travel" id="client_start_'+order.id+'" tabindex="7" value="" />          </p>        </td>        <td>           <p class="field_para"><label for="client_end">End</label>            <input style="width: 100px !important" name="client_end[]" type="text" class="main_forms_field required time_field calc_travel" id="client_end_'+order.id+'" tabindex="7" value="" /> <input name="diff_start_end[]" type="hidden" id="diff_start_end_'+order.id+'" tabindex="7" value="" />         </p>        </td>        <td>           <p class="field_para"><label for="travel">Travel</label>            <input style="width: 100px !important" name="travel[]" type="text" class="main_forms_field required time_field calc_travel travel_fld" id="travel_'+order.id+'" tabindex="7" value="" />          </p>        </td>    </tr><tr><td><p class="field_para"><strong>How Paid</strong></p></td><td><p class="field_para"></p></td></tr><tr><td><p class="field_para"><label for="cash">Total Invoice Incl Tax</label><input name="total_invoice_amount[]" type="text" class="main_forms_field required payment_field total_invoice_amount_holder" id="total_invoice_amount_'+order.id+'" value="0" tabindex="7" /></p></td><td><p class="field_para"><label for="credit_card">Credit Card</label><input name="credit_card[]" type="text" class="main_forms_field required payment_field" id="credit_card" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="debit_card">Debit Card</label><input name="debit_card[]" type="text" class="main_forms_field required payment_field" id="debit_card" tabindex="7" value="0" /></p></td></tr><tr><td><p class="field_para"><label for="cheques">Cheques</label><input name="cheques[]" type="text" class="main_forms_field required payment_field" id="cheques" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="cash">Cash</label><input name="cash[]" type="text" class="main_forms_field required payment_field" id="cash" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="cash">Outstanding</label><input name="outstanding[]" type="text" class="main_forms_field required payment_field" id="outstanding" tabindex="7" value="0" /></p></td></tr><tr><td><p class="field_para"><strong>Revenue break out</strong></p></td><td><p class="field_para"></p></td></tr> <tr><td><p class="field_para"><label for="discount_given">HST</label><input name="hst[]" type="text" class="main_forms_field required payment_field uniq_'+order.id+'" id="hst_'+order.id+'" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="discount_given">Damage / Discount on invoice</label><input name="damage[]" type="text" class="damage_class main_forms_field required payment_field uniq_'+order.id+'" id="damage_'+order.id+'" tabindex="7" value="0" /></p></td></tr><tr><td><p class="field_para"><label for="cash">Tip On Invoice</label><input name="tip_on_invoice[]" type="text" class="tip_amount_holder main_forms_field required payment_field uniq_'+order.id+'" id="tip_on_invoice_'+order.id+'" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="discount_given">NET Revenue</label><input name="net[]" type="text" class="main_forms_field required payment_field uniq_'+order.id+'" id="net_'+order.id+'" tabindex="7" value="0" /></p></td></tr><tr><td><br /></td></tr>';
                                                                                        
                                                                                            if(order_adons.length > 0)
                                                                                            {
                                                                                                
                                                                                                $.each(order_adons,function(i,obj){  
                                                                                                   row_append += '<tr id="'+obj.id+'">        <td>          <p class="field_para"><label for="client_name">Client-'+(i+2)+'</label>       <input name="o_id[]" id="o_id_'+obj.id+'" type="hidden" type="text" value="'+obj.id+'" />                   <input style="width: 100px !important" name="client_name[]" type="text" class="main_forms_field required time_field" id="client_name_'+obj.id+'" tabindex="7" value="'+obj.name+'" />          </p>        </td>        <td>           <p class="field_para"><label for="client_start">Start</label>            <input style="width: 100px !important" name="client_start[]" type="text" class="main_forms_field required time_field calc_travel" id="client_start_'+obj.id+'" tabindex="7" value="" />          </p>        </td>        <td>           <p class="field_para"><label for="client_end">End</label>            <input style="width: 100px !important" name="client_end[]" type="text" class="main_forms_field required time_field calc_travel" id="client_end_'+obj.id+'" tabindex="7" value="" />  <input name="diff_start_end[]" type="hidden" id="diff_start_end_'+obj.id+'" tabindex="7" value="" />        </p>        </td>        <td>           <p class="field_para"><label for="travel">Travel</label>            <input style="width: 100px !important" name="travel[]" type="text" class="main_forms_field required time_field calc_travel travel_fld" id="travel_'+obj.id+'" tabindex="7" value="" />          </p>        </td>    </tr><tr><td><p class="field_para"><strong>How Paid</strong></p></td><td><p class="field_para"></p></td></tr><tr><td><p class="field_para"><label for="cash">Total Invoice Incl Tax</label><input name="total_invoice_amount[]" type="text" class="main_forms_field required payment_field total_invoice_amount_holder" id="total_invoice_amount_'+obj.id+'" value="0" tabindex="7" /></p></td><td><p class="field_para"><label for="credit_card">Credit Card</label><input name="credit_card[]" type="text" class="main_forms_field required payment_field" id="credit_card" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="debit_card">Debit Card</label><input name="debit_card[]" type="text" class="main_forms_field required payment_field" id="debit_card" tabindex="7" value="0" /></p></td></tr><tr><td><p class="field_para"><label for="cheques">Cheques</label><input name="cheques[]" type="text" class="main_forms_field required payment_field" id="cheques" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="cash">Cash</label><input name="cash[]" type="text" class="main_forms_field required payment_field" id="cash" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="cash">Outstanding</label><input name="outstanding[]" type="text" class="main_forms_field required payment_field" id="outstanding" tabindex="7" value="0" /></p></td></tr><tr><td><p class="field_para"><strong>Revenue break out</strong></p></td><td><p class="field_para"></p></td></tr> <tr><td><p class="field_para"><label for="discount_given">HST</label><input name="hst[]" type="text" class="main_forms_field required payment_field uniq_'+obj.id+'" id="hst_'+obj.id+'" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="discount_given">Damage / Discount on invoice</label><input name="damage[]" type="text" class="damage_class main_forms_field required payment_field uniq_'+obj.id+'" id="damage_'+obj.id+'" tabindex="7" value="0" /></p></td></tr><tr><td><p class="field_para"><label for="cash">Tip On Invoice</label><input name="tip_on_invoice[]" type="text" class="tip_amount_holder main_forms_field required payment_field uniq_'+obj.id+'" id="tip_on_invoice_'+obj.id+'" tabindex="7" value="0" /></p></td><td><p class="field_para"><label for="discount_given">NET Revenue</label><input name="net[]" type="text" class="main_forms_field required payment_field uniq_'+obj.id+'" id="net_'+obj.id+'" tabindex="7" value="0" /></p></td></tr><tr><td><br /></td></tr>';
                                                                                                });                                                                                                    
                                                                                            }
                                                                                            
                                                                                            $("#clients_table").html(row_append);
                                                                                            initialzeClicks();
                                                                                            initialzeMask();
                                                                                            calc_trvel_formultas();
                                                                                            init_tip_cal();
                                                                                            init_payment_key_up();
                                                                                            
                                                                                    },"json");
                                                                                }
                                                                                
                                                                                            
                                                                                            function initialzeMask()
                                                                                            {
                                                                                                $(".calc_travel").mask("99:99 aa",{completed:function(){
                                                                                                        
                                                                                                }});
                                                                                                $(".travel_fld").mask("99:99",{completed:function(){
                                                                                                        
                                                                                                }});
                                                                                            }
                                                                                            
                                                                                            function initialzeClicks()
                                                                                            {                                                                                                  
                                                                                                $('.order_no_search').click(function(){
                                                                                                    
                                                                                                    //alert('i am clicked');
                                                                                                    var orderid = $(this).attr('id').split('_')[1];
                                                                                                    //alert(orderid);
                                                                                                    var current_tbody = $(this).parent().parent().parent();
                                                                                                    var current_order_no = '';
                                                                                                    var current_name = '';
                                                                                                    var current_order_date = '';
                                                                                                    var current_vals_string = '';
                                                                                                    
                                                                                                    //alert(orderid);
                                                                                                    var url = "<?php echo JURI::base(); ?>index.php/component/rednet/reportmaster/?task=get_reportmaster_by_order_id";
                                                                                                    //alert(url);
                                                                                                    $.post(url, { "order_id": orderid },
                                                                                                    function(obj){
                                                                                                        var orderId = parseInt(obj.order_id.toString(),10);
                                                                                                            if(orderId > 0)
                                                                                                            {
                                                                                                                
                                                                                                                var cnfrm = confirm("Report already exist for this order. Click 'OK' to edit existing report and 'Cancel' to search other order.")
                                                                                                                    if(cnfrm == true)
                                                                                                                    {
                                                                                                                       url = "<?php echo JURI::base() ?>index.php/component/rednet/reportmaster/?order_id="+orderId;
                                                                                                                       window.location = url;
                                                                                                                    }else{
                                                                                                                        url = "<?php echo JURI::base() ?>index.php/component/rednet/reportmaster";
                                                                                                                        window.location = url;
                                                                                                                    }
                                                                                                            }else{
                                                                                                                //alert("no fount");
                                                                                                            }
                                                                                                        
                                                                                                    }, "json");
                                                                                                    
                                                                                                    $(current_tbody).find('td').each(function(i,obj){
                                                                                                            if( $(obj).parent().attr('id') == 'tr_'+orderid )
                                                                                                            {
                                                                                                                $(obj).css('background-color','#E1E1E1');
                                                                                                                current_vals_string += $(obj).text()+"spcr";
                                                                                                            }else{
                                                                                                                $(obj).css('background-color','#fff');
                                                                                                            }
                                                                                                        
                                                                                                    });
                                                                                                    
                                                                                                    var order_vals_array = current_vals_string.split('spcr');
                                                                                                    $('#selected_order_no').val(order_vals_array[0]);
                                                                                                    $('#selected_name').val(order_vals_array[1]);
                                                                                                    $('#selected_date_order').val(order_vals_array[2]);
                                                                                                    //$(this).parent().parent().css('background-color','gray');
                                                                                                    load_assigned_worker(orderid);
                                                                                                    load_order_and_adonorders(orderid);
                                                                                                    init_tip_cal();
                                                                                                    init_payment_key_up();
                                                                                                });

                                                                                                $( ".report-detail-user-search-click" )
                                                                                                //.button()
                                                                                                .click(function() {
                                                                                                    $( "#dialog-form-user-search" ).dialog( "open" );
                                                                                                });
                                                                                                
                                                                                                $( ".report-order-search-click" )
                                                                                                //.button()
                                                                                                .click(function() {
                                                                                                    //alert($(this).attr('id'));
                                                                                                    var id = $(this).attr('id');
                                                                                                    switch(id)
                                                                                                    {
                                                                                                        case "search_by_order_no":
                                                                                                            $( "#dialog-form-order-search" ).dialog( "open" );
                                                                                                        break;
                                                                                                        case "search_by_order_name":                                                                                                            
                                                                                                            $( "#dialog-form-order-search-by-name" ).dialog( "open" );
                                                                                                        break;
                                                                                                        case "search_by_order_date":                                                                                                            
                                                                                                            $( "#dialog-form-order-search-by-date" ).dialog( "open" );
                                                                                                        break;
                                                                                                    }
                                                                                                    
                                                                                                });
                                                                                                
                                                                                               
                                                                                                
                                                                                                $( ".report-detail-comment-click" )
                                                                                                //.button()
                                                                                                .click(function() {
                                                                                                    var unique_val = $(this).attr('id').split('_')[1].toString();                                                                                                    
                                                                                                    $('#current_unique_code').val(unique_val);
                                                                                                    
                                                                                                    var comments_aleady = $("#commentbox_"+unique_val).val();
                                                                                                    $("#dialog-form-comments-box").val(comments_aleady);
                                                                                                    $( "#dialog-form-comment" ).dialog( "open" );
                                                                                                });
                                                                                            }
// calculationg the formulas for travel.                                                                                        
function calc_trvel_formultas()
{
    var sum_of_start_end_diff = "00:00";
    var sum_of_travle = "00:00";
    
    $('.calc_travel').keyup(function(){        
        
        var go_out = true;
        var current_control = $(this);
        //======== iterating over order ids =======
        var cnt = 0;
        
        $('input[name=o_id\\[\\]]').each(function()    
        {
            //$('#testdiv').text("");
            //if(cnt == 0)
              //  {
            var o_id = parseInt($(this).val());            
            //alert($(this).val().indexOf('_').toString());
            var end = $('#client_end_'+o_id);
            var start = $('#client_start_'+o_id);
            var diff_start_end = $('#diff_start_end_'+o_id);
            //$('#testdiv').text($(current_control).val().indexOf('_'));
            if($(current_control).val().indexOf('_').toString() == '-1')
            {       
                
                //var tst = "start: "+$(start).val().length.toString()+" end: "+$(end).val().length.toString();                
                //$('#testdiv').text(tst);
                
                //alert($(start).val().length.toString());
                if($(start).val().length.toString() == '8' && $(end).val().length.toString() == '8')
                {                    
                    //alert("end = "+end+"  start="+$(start).val())
                    var travel_val =SubtractTwoTimes(end,$(start).val());
                    //$('#testdiv').append(travel_val);
                    
                    $(diff_start_end).val(travel_val);
                        if(travel_val.toString() == '00:00')
                        {
                            alert("You have entered invalid time. Make sure that you are entring valid time.");
                            go_out = false;
                        }
                        else
                        {
                           //$('#testdiv').append(travel_val+" , ");                           
                           //sum_of_start_end_diff = parseInt(sum_of_start_end_diff.toString(),10)  + parseInt(travel_val.toString(),10);                                                      
                           $('input[name=diff_start_end\\[\\]]').each(function(i,obj){                               
                                   if($(obj).val().length == 5)
                                   {
                                       
                                       sum_of_start_end_diff = SumTwoTimes(sum_of_start_end_diff,$(obj).val());                                       
                                       
                                   }
                           });
                           
                           //alert(sum_of_start_end_diff);
                           $("#total_work_hours_billed").val(sum_of_start_end_diff);
                           sum_of_start_end_diff = "00:00";
                           //alert("At: "+cnt.toString()+" sum of dif: "+sum_of_start_end_diff);
                           //$('#testdiv').text(sum_of_start_end_diff+" ** ");
                        }
                    
                }
                
                            $('input[name=travel\\[\\]]').each(function(i,obj){                               
                                   if($(obj).val().length == 5)
                                   {
                                       sum_of_travle = SumTwoTimes(sum_of_travle,$(obj).val());                                                                              
                                       $('#total_travel').val(sum_of_travle);
                                   }
                           });
                           sum_of_travle = "00:00";
            }
                //} 
                
                cnt++;
                return go_out;
        });                
        
        make_travel_leak();
    });
}

function make_travel_leak()
{
    //alert("travel leak....");
    
    
    var paid_hours = $("input#paid_hours").val();
    var total_hours = $("input#total_work_hours_billed").val();
    var total_travel = $("input#total_travel").val();
   /* 
   var url = "<?php echo JURI::base() ?>index.php/component/rednet/reportmaster/?task=calc_leak";
    
    $.post(url, { 
        "paid_hours": paid_hours ,
        "total_hours": total_hours, 
        "total_travel": total_travel 
    },
    function(data){
        alert(data.key);
    }, "json");
    */
    

        if(total_hours.length == 5 && total_travel.length == 5 && paid_hours.length == 5)
        {
            //alert("doing..");
            var sum_of_totalHrs_totalTravel = SumTwoTimes(total_hours,total_travel);    
            $("#sum_of_totalHrs_totalTravel").val(sum_of_totalHrs_totalTravel);
            
            //$("#sum_of_totalHrs_totalTravel")
            var paid_hrs_array = paid_hours.split(":");
            var hrs_paid = parseInt(paid_hrs_array[0],10);
            var min_paid = parseInt(paid_hrs_array[1],10);
            
            var sumOfTotalHrs_array = sum_of_totalHrs_totalTravel.toString().split(":");
            
            var hrs_sum = parseInt(sumOfTotalHrs_array[0],10);
            var min_sum = parseInt(sumOfTotalHrs_array[1],10);
            
            //if(hrs_paid-hrs_sum)
            var dif_of_both_hrs = hrs_sum-hrs_paid;
            var rsltant_string = "00:00";
           
            if( dif_of_both_hrs == 1 || dif_of_both_hrs == 0 )
            {                                                
               if(min_paid.toString()!="00" || min_sum.toString()!="00")
               {
                    var moment_wx = moment(sum_of_totalHrs_totalTravel,"HH:mm");                                    
                    
                    moment_wx.subtract('m',min_paid);
                    moment_wx.subtract('h',hrs_paid);
                    
                    var time_rslt = moment_wx.format("hh:mm");
                    
                    rsltant_string = time_rslt.toString();
                    
                        if(time_rslt.split(":")[0].toString() == "12")
                        {
                            rsltant_string = "00:"+time_rslt.split(":")[1].toString();
                        }
                    
              }
               if(min_paid.toString()=="00" || min_sum.toString()=="00")
               {
                    var moment_wx = moment(sum_of_totalHrs_totalTravel,"HH:mm");                                    
                    
                    moment_wx.subtract('m',min_paid);
                    moment_wx.subtract('h',hrs_paid);
                    var time_rslt = moment_wx.format("hh:mm");
                    //rsltant_string = "00:"+time_rslt.split(":")[1].toString();
                    rsltant_string = time_rslt.toString();
                    //$("#test_html").append("=> in 00 <= ");
              }
            }
            
            if( dif_of_both_hrs > 1 )
            {
                    var moment_wx = moment(sum_of_totalHrs_totalTravel,"HH:mm");                                    
                    
                    moment_wx.subtract('m',min_paid);
                    moment_wx.subtract('h',hrs_paid);
                    var time_rslt = moment_wx.format("hh:mm");
                    rsltant_string = time_rslt.toString();
            }
                                            
            
            if( dif_of_both_hrs < 0 )
            {
                    /*
                    var moment_wx = moment(sum_of_totalHrs_totalTravel,"HH:mm");                                    
                    moment_wx.subtract('h',hrs_paid);
                    moment_wx.subtract('m',min_paid);
                    var time_rslt = moment_wx.format("hh:mm");
                    rsltant_string = time_rslt.toString();
                    */
                   //$("#test_html").text(dif_of_both_hrs.toString()+"**");
            }
            
            //$("#test_html").text(dif_of_both_hrs.toString()+"**");
            
            // paid min > sum min
                
            if(isNaN(dif_of_both_hrs) || dif_of_both_hrs == 0) {
          
                        var url = "<?php echo JURI::base() ?>index.php/component/rednet/reportmaster/?task=calc_leak";
                        
                    $.post(url, {"time1": paid_hours , "time2":sum_of_totalHrs_totalTravel },
                    function(data){
                        //$("#test_html").text(data.rslt);
                        var rslt = data.rslt;
                        var rslt_array = rslt.split(":");
                        rsltant_string = "-"+rslt_array[0]+":"+rslt_array[1];
                        //alert(rsltant_string);
                        
                        
                        
                        
                        if ((min_paid > min_sum) && (hrs_paid.toString() == hrs_sum.toString())) 
                        {
                            var rsltant_string_array = rsltant_string.split(":");
                            rsltant_string = "-0:"+rsltant_string_array[1].toString();
                            
                            $("#travel_leak").val(rsltant_string);
                        }
                        
                        
                    }, "json");
                    
            
            }
            if(isNaN(dif_of_both_hrs) || dif_of_both_hrs < 0) {
                
                    var moment_wx = moment(sum_of_totalHrs_totalTravel,"HH:mm");                                    
                    
                    //moment_wx.subtract('m',min_paid);
                    //moment_wx.subtract('h',hrs_paid);
                    
                    moment_wx.subtract("m",min_paid).subtract("h",hrs_paid);
                    
                    var time_rslt = moment_wx.format("hh:mm");
                    rsltant_string = time_rslt.toString();
                    var time_array = rsltant_string.split(":");
                    var time_to_print = "";
                    
                    if(dif_of_both_hrs.toString().length < 2)
                    {
                        time_to_print = "0"+dif_of_both_hrs.toString();
                    }else{
                        time_to_print = ""+dif_of_both_hrs.toString();
                    }
                    
                    //rsltant_string = time_to_print.toString()+":"+time_array[1].toString();
                    rsltant_string = time_to_print.toString()+":"+time_array[1].toString();                    
                    
                    
                    //======== new code to cal leak =========
                    //sum_of_totalHrs_totalTravel chota
                    //paid_hours bara
            
                        
                            
                        
                    var url = "<?php echo JURI::base() ?>index.php/component/rednet/reportmaster/?task=calc_leak";
                    $.post(url, { "time1": paid_hours , "time2":sum_of_totalHrs_totalTravel },
                    function(data){
                        //$("#test_html").text(data.rslt);
                        var rslt = data.rslt;
                        var rslt_array = rslt.split(":");
                        rsltant_string = "-"+rslt_array[0]+":"+rslt_array[1];
                        //alert(rsltant_string);
                        
                        $("#travel_leak").val(rsltant_string);
                    }, "json");
                    
                    
            
                    //var text = "sum="+sum_of_totalHrs_totalTravel.toString()+"<br />paid hrs = "+paid_hours.toString();
                    //$("#test_html").text(text.toString());
            }
                                            
            //$("#test_html").text(dif_of_both_hrs.toString());
            
            
            
            
            var travel_leak = rsltant_string;
            //var travel_leak = diffTwoTimes($("#sum_of_totalHrs_totalTravel"),paid_hours);
            //$("#test_html").text(sum_of_totalHrs_totalTravel+" => "+travel_leak);
            //doing...
            
            
            
            //var _initial = moment("2013-02-01 06:00","YYYY-MM-DD HH:mm").duration().milliseconds();
            //var _final = moment("2013-02-01 08:00","YYYY-MM-DD HH:mm").duration().milliseconds();
            
            //var _initial = new Date("October 13, 1975 07:00 pm");
            //var _final = new Date("October 13, 1979 11:20 pm");
            
            //var mseconds = (_final.getTime() - _initial.getTime());
            //var nDate= new Date(mseconds);
            //var seconds = (_final.getTime() - _initial.getTime())/1000;
              //      $("#test_html").html("<p>** "+timex_a.toString()+" </p>");
                    //$("#test_html").append("<p>"+timex_b.subtract("h",1).subtract("m",2).format("YYYY-MM-DD HH:mm")+" </p>");
            //$("#test_html").append("<p>"+nDate.toTimeString()+" </p>");
                                        
            $("#travel_leak").val(travel_leak);
            //$("#test_html").append("diff = "+dif_of_both_hrs+" | "+travel_leak);
        }
    
}


function diffTimes(start, end)
{
    var parseStart = start.split(":");
    var parseEnd = end.split(":");

    var beginDate = new Date(1,1,1,parseStart[0],parseStart[1],0);
    var endDate = new Date(1,1,1,parseEnd[0],parseEnd[1],0);

    var hourDifference = endDate.getHours() - beginDate.getHours();
    var minuteDifference = endDate.getMinutes() - beginDate.getMinutes();

    if (minuteDifference < 0)
    {
        minuteDifference += 60;
        hourDifference--;
    }

    return(new Array(hourDifference, minuteDifference));
}


                </script>

        <script type="text/javascript">
            $('document').ready(function(){
                calc_trvel_formultas();
                
                
                
                jQuery('body').on('click','.report-detail-user-search-click', function(e){
                    var id = $(this).attr('id');
                    var uniq = id.split('_');
                    var rowid = "rowid_"+uniq[1];
                    var role = "role_"+uniq[1];
                    var userid_tag_id = "userid_"+uniq[1];
                    var user_id = $('#'+userid_tag_id).val();
                    var role_val = $('#'+role).text();
                    //alert(user_id);
                    $('#dialog-form-user-search-username').val(user_id);
                    $('#dialog-form-user-search-username-list').val(user_id);
                    $('#dialog-form-user-search-role-list').val(role_val);
                    $('#current_unique_code').val(uniq[1]);                     
                });
                
                jQuery('body').on('click','.read_write', function(e){
                    var id = $(this).attr('id');
                    var uniq = id.split('_');
                    var readwritelink= "readwritelink_"+uniq[1];
                    
                    $('#dialog-form-user-search-username').val();
                    
                });
                
            });
        </script>
        
        <style type="text/css">
            .loading_div{
                margin-left: 5px;                
        }
        .loading_div img{
            width: 15px !important;
        }
        
        #warning
        {
            border: 1px solid red;
            padding: 5px;
            background-color: pink;
            color: red;
            font-size: 12px;
            width: 300px;
            margin-left: 25px;
            margin-bottom: 10px;
            
        }
        .line_wrapp
        {
            height: 40px;
        }
        </style>




        <div class="line_wrapp">
            <div id="warning">
                <strong>Warning!</strong> Order not found, try a valid number.
            </div>       
        </div>
        
        <div id="testdiv">
            
        </div>        
        <script type="text/javascript">
            $("document").ready(function(){
                $(".nvgta").click(function(){
                    
                    var server = "<?php echo JURI::base(); ?>";                                   
                    window.location = server+"index.php/component/rednet/reportmaster";                         
                    
                });
                $(".nvgtb").click(function(){
                    
                    var server = "<?php echo JURI::base(); ?>";                                   
                    window.location = server+"index.php/component/rednet/reportmaster/?task=approve_report";                         
                    
                });
            });
        </script>
        <p>
        <table style="margin-left: 20px !important;">
    <tr>
        <td><input class="nvgta" type="submit" tabindex="25" name="save" value="New"></td>
        <td><input class="nvgtb" type="submit" tabindex="25" name="save" value="Approve"></td>
    </tr>
</table>
</p>

<div>
    <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/custom-report.png" alt="logo" id="lock_icon" width="60" /></td>
            <td><h4>Enter Trip Report</h4></td>
        </tr>
    </table>
    
</div>

<jdoc:include type="message" />

<form id="add_worker" action="<?php echo JURI::base()."index.php/component/rednet/reportmaster/?task=report_save" ?>" method="post" onsubmit="return validate_required();">

    <input type="hidden" name="mode" id="mode" value="<?php echo $mode ?>" />
    <input type="hidden" name="report_id" id="report_id" value="<?php echo $reportmaster->id ?>" />
    
<script type="text/javascript">
                $("document").ready(function(){
                    
                });
                
                function validate_required()
                {
                    var required_fields = $('.required').get();
                    var exit_flag = true;
                    $(required_fields).each(function(i,obj){
                        //alert($(obj).attr('name'));
                        var id_obj = $(obj).attr('id');
                        if($("#"+id_obj).val().length == 0)
                        {
                            var name_fld = $(obj).attr('name');
                            var name_rslt = replaceAll("_", " ", name_fld);
                            var name_rslt_final = name_rslt.replace(/\[+(.*?)\]+/g,"$1");
                            alert("Missing \" "+name_rslt_final.toUpperCase()+" \"");
                            exit_flag = false;
                        }
                        return exit_flag;
                    });
                    return exit_flag;
                }
                
                function replaceAll(find, replace, str) {
                    return str.replace(new RegExp(find, 'g'), replace);
                }
</script>


<div class="form_wrapper_app" style="background: none !important;min-height: auto !important;">
    
    

        

    <input class="" type="hidden" name="order_id" id="order_id" value="<?php echo (isset($order->id))?($order->id):("") ?>" />

    <div class="mainform_warpper">
    <br />
    <br />
<table width="100%" border="0">
  <tr>
 
    <td><p class="field_para">
            <label for="order_no">Order#
                
                <?php if($mode == 'add'): ?>
                    <span class=""><a id="search_by_order_no" class="report-order-search-click">Search</a></span>
                <?php endif; ?>
                
                    <span class="loading_div"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/loader-s.gif" alt="loading.." /></span>
                
            </label>
      <input name="order_no" type="text" class="main_forms_field required" id="order_no" tabindex="2" value="<?php echo (isset($order->order_no))?($order->order_no):("") ?>" /></p></td>
    <td><p class="field_para">
      <label for="name">Name
          <?php if($mode == 'add'): ?>
            <span class=""><a id="search_by_order_name" class="report-order-search-click">Search</a></span>
          <?php endif; ?>
          <span class="loading_div"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/loader-s.gif" alt="loading.." /></span></label>
      <input name="name" type="text" class="main_forms_field required" id="name" tabindex="3" value="<?php echo (isset($order->name))?($order->name):("") ?>">
    </p></td>
 
    <td><p class="field_para">
      <label for="s_n2">Date
          
          <?php if($mode == 'add'): ?>
                <span class=""><a id="search_by_order_date" class="report-order-search-click">Search</a></span>
          <?php endif; ?>
          
          <span class="loading_div"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/loader-s.gif" alt="loading.." /></span></label>
            <input name="date_order" type="text" class="main_forms_field required" id="date_order" tabindex="4" value="<?php echo (isset($order->date_order))?( date("m/d/Y",strtotime($order->date_order)) ):("") ?>" />
    </p></td>
    
    </tr>
</table>
<br />    
<table width="30%" border="0">    
    <tr>
        <td><p class="field_para"><label for="departure_time">Departure Time &nbsp;(hh:mm am)</label>
    
            <input name="departure_time" type="text" class="main_forms_field required time_field" id="departure_time" tabindex="7" value="<?php echo (isset($reportmaster->departure_time))?( strtolower(date('h:i A',strtotime($reportmaster->departure_time))) ):("") ?>" />
    </p></td>
    
    <td><p class="field_para">
        <label for="return_time">Return Time&nbsp;(hh:mm am)</label>
        <input name="return_time" type="text" class="main_forms_field required time_field" id="return_time" tabindex="7" value="<?php echo (isset($reportmaster->return_time ))?( strtolower(date('h:i A',strtotime($reportmaster->return_time))) ):("") ?>" />
    </p></td>
    </tr>
    
</table>
<br />
<table width="100%" border="0" id="clients_table">    

<?php

        if(count($reportclients) > 0)
        {
            $cntr = 0;
            foreach ($reportclients as $client)
            {
                $db = JFactory::getDbo();
                $query = "SELECT * FROM #__orders WHERE id=$client->order_id";
                $db->setQuery($query);
                $db->query() or die(mysql_error());
                $order_obj = $db->loadObject();
                
                $travel_val = $client->travel;
                $travel_val_to_print = "";
                
                if(isset($travel_val))
                {
                    $travel_array = split(":", $travel_val);
                
                    $travel_val_hr_zero = false;


                    if($travel_array[0] == '00')
                    {
                        $travel_val_hr_zero = true;
                    }else{
                        $travel_val_hr_zero = false;
                    }

                    $travel_db_val = (isset($client->travel))?( strtolower(date('h:i A',strtotime($client->travel))) ):("");

                    if($travel_val_hr_zero == true)
                    {
                       $trvl_ary = split(":",$travel_db_val);
                       if($trvl_ary[0] == '12')
                       {
                           $travel_val_to_print = "00:$trvl_ary[1]";
                       }
                    }else{
                       $travel_val_to_print = $travel_db_val;
                    }
                
                }                                                
?>    
    
    <tr id="<?php echo $client->order_id; ?>">       <td>          <p class="field_para"><label for="client_name">Client-<?php echo ($cntr+1) ?></label>       <input name="o_id[]" id="o_id_<?php echo $client->order_id?>" type="hidden" type="text" value="<?php echo $client->order_id?>" />                   <input style="width: 100px !important" name="client_name[]" type="text" class="main_forms_field required" id="<?php echo "client_name_$client->order_id"?>" tabindex="7" value="<?php echo $order_obj->name?>" />          </p>        </td>        <td>           <p class="field_para"><label for="client_start">Start</label>            <input style="width: 100px !important" name="client_start[]" type="text" class="main_forms_field required time_field calc_travel" id="client_start_<?php echo $client->order_id; ?>" tabindex="7" value="<?php echo (isset($client->start))?( strtolower(date('h:i A',strtotime($client->start))) ):("") ?>" />          </p>        </td>        <td>           <p class="field_para"><label for="client_end">End</label>            <input style="width: 100px !important" name="client_end[]" type="text" class="main_forms_field required time_field calc_travel" id="client_end_<?php echo $client->order_id;?>" tabindex="7" value="<?php echo (isset($client->end))?( strtolower(date('h:i A',strtotime($client->end))) ):("") ?>" /> <input name="diff_start_end[]" type="hidden" id="diff_start_end_<?php echo $client->order_id ?>" tabindex="7" value="" />         </p>        </td>        <td>           <p class="field_para"><label for="travel">Travel</label>            <input style="width: 100px !important" name="travel[]" type="text" class="main_forms_field required time_field calc_travel travel_fld" id="travel_order_<?php echo $client->order_id?>" tabindex="7" value="<?php echo $travel_val_to_print ?>" />          </p>        </td>    </tr>
    
   <?php foreach($reporthowpaid as $rhp):
       if($rhp->order_id == $client->order_id){
     ?> 
        <tr><td><p class="field_para"><strong>How Paid</strong></p></td><td><p class="field_para"></p></td></tr><tr><td><p class="field_para"><label for="cash">Total Invoice Incl Tax</label><input name="total_invoice_amount[]" type="text" class="main_forms_field required payment_field total_invoice_amount_holder" id="total_invoice_amount_<?php echo $client->order_id; ?>" value="<?php echo $rhp->total_invoice_amount; ?>" tabindex="7" /></p></td><td><p class="field_para"><label for="credit_card">Credit Card</label><input name="credit_card[]" type="text" class="main_forms_field required payment_field" id="credit_card" tabindex="7" value="<?php echo $rhp->credit_card; ?>" /></p></td><td><p class="field_para"><label for="debit_card">Debit Card</label><input name="debit_card[]" type="text" class="main_forms_field required payment_field" id="debit_card" tabindex="7" value="<?php echo $rhp->debit_card; ?>" /></p></td></tr><tr><td><p class="field_para"><label for="cheques">Cheques</label><input name="cheques[]" type="text" class="main_forms_field required payment_field" id="cheques" tabindex="7" value="<?php echo $rhp->cheques; ?>" /></p></td><td><p class="field_para"><label for="cash">Cash</label><input name="cash[]" type="text" class="main_forms_field required payment_field" id="cash" tabindex="7" value="<?php echo $rhp->cash; ?>" /></p></td><td><p class="field_para"><label for="cash">Outstanding</label><input name="outstanding[]" type="text" class="main_forms_field required payment_field" id="outstanding" tabindex="7" value="<?php echo $rhp->outstanding; ?>" /></p></td></tr>
        <tr><td><p class="field_para"><strong>Revenue break out</strong></p></td><td><p class="field_para"></p></td></tr> <tr><td><p class="field_para"><label for="discount_given">HST</label><input name="hst[]" type="text" class="main_forms_field required payment_field uniq_<?php echo $client->order_id; ?>" id="hst_<?php echo $client->order_id; ?>" tabindex="7" value="<?php echo $rhp->hst; ?>" /></p></td><td><p class="field_para"><label for="discount_given">Damage / Discount on invoice</label><input name="damage[]" type="text" class="damage_class main_forms_field required payment_field uniq_<?php echo $client->order_id; ?>" id="damage_<?php echo $client->order_id; ?>" tabindex="7" value="<?php echo $rhp->damage; ?>" /></p></td></tr><tr><td><p class="field_para"><label for="cash">Tip On Invoice</label><input name="tip_on_invoice[]" type="text" class="tip_amount_holder main_forms_field required payment_field uniq_<?php echo $client->order_id; ?>" id="tip_on_invoice_<?php echo $client->order_id; ?>" tabindex="7" value="<?php echo $rhp->tip_on_invoice; ?>" /></p></td><td><p class="field_para"><label for="discount_given">NET Revenue</label><input name="net[]" type="text" class="main_forms_field required payment_field uniq_<?php echo $client->order_id; ?>" id="net_<?php echo $client->order_id; ?>" tabindex="7" value="<?php echo $rhp->net; ?>" /></p></td></tr>
        <tr><td><br /></td></tr>
    <?php 
       }
        endforeach; ?>
        
  <?php 
                $cntr++;
            }
        } ?>
<!--   <tr>
        <td>
          <p class="field_para"><label for="client_name">Client-1</label>            
              <input style="width: 100px !important" name="client_name[]" type="text" class="main_forms_field required time_field" id="departure_time" tabindex="7" value="<?php echo (isset($form_data['departure_time']))?($form_data['departure_time']):("") ?>" />
          </p>
        </td>
        <td>
           <p class="field_para"><label for="client_start">Start</label>
            <input style="width: 100px !important" name="client_start[]" type="text" class="main_forms_field required time_field" id="departure_time" tabindex="7" value="<?php echo (isset($form_data['departure_time']))?($form_data['departure_time']):("") ?>" />
          </p>
        </td>
        <td>
           <p class="field_para"><label for="client_end">End</label>
            <input style="width: 100px !important" name="client_end[]" type="text" class="main_forms_field required time_field" id="departure_time" tabindex="7" value="<?php echo (isset($form_data['departure_time']))?($form_data['departure_time']):("") ?>" />
          </p>
        </td>
        <td>
           <p class="field_para"><label for="travel">Travel</label>
            <input style="width: 100px !important" name="travel[]" type="text" class="main_forms_field required time_field" id="departure_time" tabindex="7" value="<?php echo (isset($form_data['departure_time']))?($form_data['departure_time']):("") ?>" />
          </p>
        </td>
    </tr>-->
  </table>


<table width="100%" border="0">    
  
  <tr>
    
    <td><p class="field_para">
      <label for="total_work_hours_billed">Total Work hours Billed</label>
      <input name="total_work_hours_billed" type="text" class="main_forms_field time_field_two required" id="total_work_hours_billed" tabindex="12" value="<?php echo (isset($reportmaster->total_work_hours_billed))?( strtolower(date('h:i',strtotime($reportmaster->total_work_hours_billed))) ):("") ?>" />
    </p></td>
    <td><p class="field_para">
      <label for="travel_leak">Total Travel Billed</label>
      <input name="total_travel" type="text" class="main_forms_field time_field_two required" id="total_travel" tabindex="12" value="<?php echo (isset($reportmaster->total_travel))?( strtolower(date('H:i',strtotime($reportmaster->total_travel))) ):("") ?>" />
    </p></td>
    
    <td><p class="field_para">
      <label for="client_end">Shop Time</label>
      
      <?php 
      
      
              $dpt_val = $reportmaster->dpt_time;
                $dpt_val_to_print = "";
                
                if(isset($dpt_val))
                {
                    
                    $dpt_array = split(":", $dpt_val);
                
                    $dpt_val_hr_zero = false;


                    if($dpt_array[0] == '00')
                    {
                        $dpt_val_hr_zero = true;
                        
                    }else{
                        $dpt_val_hr_zero = false;
                    }

                    $dpt_db_val = (isset($reportmaster->dpt_time))?( strtolower(date('h:i A',strtotime($reportmaster->dpt_time))) ):("");

                    if($dpt_val_hr_zero == true)
                    {
                       $trvl_ary = split(":",$dpt_db_val);
                       if($trvl_ary[0] == '12')
                       {
                           $dpt_val_to_print = "00:$trvl_ary[1]";
                       }
                    }else{
                       $dpt_val_to_print = $dpt_db_val;
                    }                
                }else{
                    $dpt_val_to_print = "00:10";
                }                                
      ?>
      <input name="dpt_time" type="text" class="main_forms_field required" id="dpt_time" tabindex="11" value="<?php echo $dpt_val_to_print; ?>" />
    </p></td>
    
    </tr>
  <tr>
    <td><p class="field_para">
      <label for="paid_hours">Paid  Hours</label>
      <input name="paid_hours" type="text" class="main_forms_field time_field_two required" id="paid_hours" tabindex="12" value="<?php echo (isset($reportmaster->paid_hours))?( strtolower(date('h:i',strtotime($reportmaster->paid_hours))) ):("") ?>" />
      </p></td>
    <td><p class="field_para">
      <label for="travel_leak">Time Leak</label>
      <input name="travel_leak" type="text" class="main_forms_field time_field_two required" id="travel_leak" tabindex="12" value="<?php echo (isset($reportmaster->travel_leak))?( ( $reportmaster->travel_leak) ):("") ?>" />
      </p></td>
    <td>&nbsp;</td>
  </tr>
  </table>
        </div>
        <br />
        
        <div class="role_wrapper">
            
<table width="100%" border="0">
<!--  <tr>
      <td><p class="field_para"><strong>How Paid</strong></p></td>
      <td><p class="field_para"></p></td>
    </tr>
  <tr>
      
      <td><p class="field_para">
      <label for="cash">Total Invoice Incl Tax</label>
      <input name="total_invoice_amount" type="text" class="main_forms_field required payment_field" id="total_invoice_amount" tabindex="20" value="<?php echo (isset($reportmaster->total_invoice_amount))?($reportmaster->total_invoice_amount):("0") ?>" />
    </p></td>
      
    <td><p class="field_para">
      <label for="credit_card">Credit Card</label>
      <input name="credit_card" type="text" class="main_forms_field required payment_field" id="credit_card" tabindex="20" value="<?php echo (isset($reportmaster->credit_card))?($reportmaster->credit_card):("0") ?>" />
    </p></td>
    
    <td><p class="field_para">
      <label for="debit_card">Debit Card</label>
      <input name="debit_card" type="text" class="main_forms_field required payment_field" id="debit_card" tabindex="20" value="<?php echo (isset($reportmaster->debit_card))?($reportmaster->debit_card):("0") ?>" />
    </p></td>
    
    </tr>
  <tr>
    <td><p class="field_para">
      <label for="cheques">Cheques</label>
      <input name="cheques" type="text" class="main_forms_field required payment_field" id="cheques" tabindex="20" value="<?php echo (isset($reportmaster->cheques))?($reportmaster->cheques):("0") ?>" />
    </p></td>
    
    <td><p class="field_para">
      <label for="cash">Cash</label>
      <input name="cash" type="text" class="main_forms_field required payment_field" id="cash" tabindex="20" value="<?php echo (isset($reportmaster->cash))?($reportmaster->cash):("0") ?>" /></p></td>
    
    <td><p class="field_para">
      <label for="cash">Outstanding</label>
      <input name="outstanding" type="text" class="main_forms_field required payment_field" id="outstanding" tabindex="20" value="<?php echo (isset($reportmaster->outstanding))?($reportmaster->outstanding):("0") ?>" /></p></td>
    </tr>-->
    
<!--    <tr>
      <td><p class="field_para"><strong>Revenue break out</strong></p></td>
      <td><p class="field_para"></p></td>
    </tr>
    
  <tr>    
    <td><p class="field_para">
      <label for="discount_given">HST</label>
      <input name="hst" type="text" class="main_forms_field required payment_field" id="hst" tabindex="20" value="<?php echo (isset($reportmaster->hst))?($reportmaster->hst):("0") ?>" />
    </p></td>
    <td><p class="field_para">
      <label for="discount_given">Damage / Discount on invoice</label>
      <input name="damage" type="text" class="main_forms_field required payment_field" id="damage" tabindex="20" value="<?php echo (isset($reportmaster->damage))?($reportmaster->damage):("0") ?>" />
    </p></td>
    </tr>
    
    <tr>
    <td><p class="field_para">
      <label for="cash">Tip On Invoice</label>
      <input name="tip_on_invoice" type="text" class="main_forms_field required payment_field" id="tip_on_invoice" tabindex="20" value="<?php echo (isset($reportmaster->tip_on_invoice ))?($reportmaster->tip_on_invoice ):("0") ?>" />
    </p></td>
    <td><p class="field_para">
      <label for="discount_given">NET Revenue</label>
      <input name="net" type="text" class="main_forms_field required payment_field" id="net" tabindex="20" value="<?php echo (isset($reportmaster->net))?($reportmaster->net):("0") ?>" />
    </p></td>
    </tr>-->
    
</table>
        
        </div>
            
        
  
</div>

<br />


<script type="text/javascript">
                $("document").ready(function(){
                    
                    init_payment_key_up();
                });
                
                function init_payment_key_up()
                {
                    $(".payment_field").keyup(function(){
                        
                        //$("#test_html").text($(this).attr("class").toString()+" *** ");
                        var classes = $(this).attr("class").toString().split(" ");
                        var uniq_id = classes[classes.length-1];
                        
                        var uniq_key = uniq_id.split("_")[0];
                        var uniq_val = uniq_id.split("_")[1];
                            if(uniq_key == "uniq")
                            {
                                //alert(uniq_val);
                                var total_invoice_amount = $("#total_invoice_amount_"+uniq_val).val();                        
                                var hst = parseFloat($("#hst_"+uniq_val).val().toString(),8);
                                //alert($("#hst_"+uniq_val).val());
                                var tip_on_invoice = parseFloat($("#tip_on_invoice_"+uniq_val).val(),8);
                                var net = ((total_invoice_amount - hst) - tip_on_invoice);
                                var net_val = Number((net).toFixed(2));
                                $("#net_"+uniq_val).val(net_val.toString());
                            }
                            
                        var tip_on_invoice_all = $(".tip_amount_holder").get();
                        var tip_on_invoice_all_sum = 0.0;
                        $(tip_on_invoice_all).each(function(i,obj){
                                if($(obj).val().length > 0)
                                {
                                    tip_on_invoice_all_sum = tip_on_invoice_all_sum + Number((parseFloat($(obj).val(),8)).toFixed(2));
                                }
                        });
                        
  
                            if(tip_on_invoice_all_sum > 0)
                            {
                                
                                
                                var user_ids = $('.user_id_holder').get();
                                    if(user_ids.length > 0)
                                    {
                                        var no_of_workers = parseFloat(user_ids.length.toString(),8);
                                        var tip_per_worker = tip_on_invoice_all_sum/no_of_workers;
                                        var tip_per_worker_rounded = Number((tip_per_worker).toFixed(2));
                                        
                                        var formula_par_1 = (tip_per_worker_rounded * 100);
                                        var formula_par_1_string = formula_par_1;
                                        
                                        var tip_percent = parseFloat(formula_par_1_string,8)/tip_on_invoice_all_sum;
                                        var tip_percent_rounded = Number((tip_percent).toFixed(2));
                                        
                                        $(user_ids).each(function(i,obj){
                                            var uniq_id = $(obj).attr('id').split("_")[1];
                                            $(".tipallow_"+uniq_id).val(tip_percent_rounded);
                                            $(".tipamount_"+uniq_id).val(tip_per_worker_rounded);
                                        });
                                        
                                        //$("#test_html").text(tip_on_invoice.toString()+" | #user="+user_ids.length+ " | tip per worker="+tip_per_worker+"  | tip%="+tip_percent);
                                    }else{
                                        alert("No order selected or No assigned worker found!");
                                        $("#tip_on_invoice").val("0");
                                        $("#net").val("0");
                                    }                                
                            }else{
                                $("#test_html").text("");
                            }
                            
                            var paid_hours = $("#paid_hours").val();
                            if(paid_hours.toString().length > 0)
                            {
                                $(".hours_holder").val(paid_hours.toString());
                            }
                    });
                    
                    damage_checke();
                }
                
                
                function damage_checke()
                {
                    $('.damage_class').keyup(function(){
                        
                        var damage_class_all = $('.damage_class').get();
                        var is_found_damage_val = false;
                        // seach for any value of damage field.
                        $(damage_class_all).each(function(i,obj){
                            if($(obj).val().length > 0 && parseFloat($(obj).val()) > 0.0 )
                            {
                                is_found_damage_val = true;
                            }                            
                        });
                        
                        // if value for and damage field found, make comments required.
                        if(is_found_damage_val == true)
                        {
                           var comments_fields_all = $('.comments_class').get();
                           $(comments_fields_all).each(function(i,obj){
                               $(obj).addClass("required");
                           });
                        }else{
                           var comments_fields_all = $('.comments_class').get();
                           $(comments_fields_all).each(function(i,obj){
                               $(obj).removeClass("required");
                           });
                        }
                            
                    });
                }
                
</script>


<style type="text/css">
    .worker_table
    {
        border-left: 2px solid #C8BFC4 !important;
        border-top: 2px solid #C8BFC4 !important;
        border-right:  2px solid #C8BFC4 !important;
        border-bottom:  2px solid #C8BFC4 !important;        
    }
    
    .worker_table tr td
    {
        text-align: center !important;
        border-bottom: 1px solid #B30000 !important;
        padding-bottom: 5px !important;
    }
    .worker_table thead tr td
    {
        text-align: center !important;
    }
</style>

<table class="worker_table" width="100%" border="0">
    <thead>
        
<tr>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
      <label for="sr">Sr.</label>
<!--      <input name="credit_card" type="text" class="main_forms_field required" id="credit_card" tabindex="20" value="<?php echo (isset($form_data['credit_card']))?($form_data['credit_card']):("0") ?>" />-->
    </p>
  </td>
  <td>
          <p class="field_para">
            <label for="name_worker">Name</label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="name_worker">Role</label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="hours">Hours</label>
          </p>      
  </td>
  <td><p class="field_para" style="padding-left: 0px !important">
            <label for="invoice">Invoice</label>
          </p>      </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="tip_allow">Tip Allow %</label>
          </p>      
  </td>
  <td style="display: none !important;">
      <p class="field_para" style="padding-left: 0px !important">
            <label for="tip_allow">Tip Amount</label>
          </p>      
  </td>
<td>
<p class="field_para" style="padding-left: 0px !important">
            <label for="flag">Flag</label>
          </p>          
</td>
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Bonus</label>
     </p>          
</td>
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="comments">Comments</label>
     </p>              
</td>
</tr>
    </thead>    
    
<tbody id="report_detail_table">    

    <?php
     $cntr = 0;
     //var_dump($reportdetail);
     if(count($reportdetail) > 0)
     {
     foreach ($reportdetail as $detail):
                $db = JFactory::getDbo();
                $query_wrkr = "SELECT * FROM #__workers WHERE user_id=$detail->user_id";
                $db->setQuery($query_wrkr);
                $db->query() or die(mysql_error());
                $worker_obj = $db->loadObject();
                
                $id_string = "$order->order_no$order->id$detail->user_id";
                //echo $id_string." ** ";
    ?>
<!--    obj.order_no+obj.order_id+obj.user_id;-->
<tr id="rowid_<?php echo $id_string; ?>"><td><span class="report_text"><?php echo ($cntr+1); ?></span></td><td><input type="hidden" class="user_id_holder" name="user_id[]" id="userid_<?php echo $id_string; ?>" value="<?php echo $detail->user_id ?>" /><span class="report_text"><a class="report_username report-detail-user-search-click grid_anchor" id="namelink_<?php echo $id_string; ?>"><?php echo "$worker_obj->first_name $worker_obj->last_name" ?></a></span></td><td><input name="role[]" type="hidden" id="rolefield_<?php echo $id_string; ?>" value="<?php echo $detail->role ?>" /><span id="role_<?php echo $id_string; ?>" class="report_text"><?php echo $detail->role ?></span></td><td><input name="hours[]" type="text" class="main_forms_field required hours_holder <?php echo "hours_$id_string"?>" id="hours" value="<?php echo strtolower(date('h:i',strtotime($detail->hours))) ?>" style="width:50px !important" /></td><td><input type="checkbox" name="invoice[]" id="invoice" <?php echo ($detail->invoice == '1')?('checked=checked'):('') ?> /></td><td><input name="tip_allow[]" type="text" class="main_forms_field required tip_allow_holder tipallow_<?php echo $id_string; ?>" id="tip_allow" value="<?php echo $detail->tip_allow ?>" style="width:50px !important" /></td><td style="display: none !important;"><input name="tip_amount[]" type="text" class="main_forms_field required tipamount_<?php echo $id_string; ?>" id="tip_amount" value="<?php echo $detail->tip_amount ?>" style="width:50px !important" /></td><td><input type="checkbox" name="flag[]" id="flag" <?php echo ($detail->flag == '1')?('checked=checked'):('') ?> /></td><td><input <?php echo $bonus_enable; ?> name="bonus[]" type="text" class="main_forms_field" id="bonus" value="<?php echo (isset($detail->bonus) && strlen($detail->bonus)>0)?($detail->bonus):("0") ?>" style="width:50px !important" /></td><td><textarea name="comments[]" id="commentbox_<?php echo $id_string; ?>" class="comments_class" cols="50" rows="6"><?php echo $detail->comments ?></textarea><span class="report_text"><a id="readwritelink_<?php echo $id_string; ?>" class="read_write report-detail-comment-click grid_anchor">Read/Write</a></span></td></tr>
    <?php
        $cntr++;
    endforeach;
     }
    ?>
    
</tbody>

</table>

<script type="text/javascript">
                $("document").ready(function(){                    
                   init_tip_cal();
                   init_payment_key_up();
                });
                
                function init_tip_cal()
                {
                     $(".tip_allow_holder").keyup(function(){
                                                            
                        if($(this).val().length > 0)
                        {
                            var fld_classes = $(this).attr("class").split(" ");
                            var array_length = fld_classes.length;
                            var uniq_class = fld_classes[array_length-1];
                            var uniq_id = uniq_class.split("_")[1];
                            
                            var tip_amount_all = $(".tip_amount_holder").get();
                            var tip_amount_sum = 0.0;
                            
                            $(tip_amount_all).each(function(i,obj){
                                tip_amount_sum = tip_amount_sum + Number((parseFloat($(obj).val(),8)).toFixed(2));
                            });
                            
                            var tip = tip_amount_sum;
                            var tip_percent = parseFloat($(this).val(),8);
                            var tip_crnt = (tip*(tip_percent/100.00));
                            //alert(tip_crnt);
                            $(".tipamount_"+uniq_id).val(Number(tip_crnt.toFixed(2)));
                        }
                    });
                }
</script>

<table border="0">
    
    <tr>
        <td>
        
                    <p class="field_para">
<label for="discount_given">Comments</label>
<textarea class="main_forms_field" name="comments_job" cols='45' rows='4' style="width: 575px !important"><?php echo $reportmaster->comments_job;?><?php echo (isset($form_data['comments_job']) && $order->comments==NULL)?($form_data['comments_job']):('')?></textarea>
</p>
        </td>
        <td>        
                    <p class="field_para">
                        <label for="flag_job">Flag Job &nbsp;&nbsp;<input type="checkbox" name="flag_job" id="flag_job" <?php echo ($reportmaster->flag_job == '1')?('checked=checked'):('') ?> style="float: right" /></label>

</p>
        </td>
        
    </tr>
</table>
<br />
<p>
    <input type="submit" value="Save" name="save" tabindex="25" />
</p>
</form>

        <style type="text/css">
            .report_text a{
                font-family: arial !important;
                color: #000 !important;
                font-size: 14px !important;
            }
            .report_text{
                font-family: arial !important;
                color: #000 !important;
                font-size: 14px !important;
            }
        </style>        

        <script type="text/javascript">
            function render_search_order_form()
            {
                        $(function() {
                            
                            //$( "#dialog-form-user-search" ).dialog({
                            $( "#dialog-form-order-search" ).dialog({
                                autoOpen: false,
                                height: 550,
                                width: 740,
                                modal: true,
                                buttons: {
                                    "Done": function() {
                                        
                                        //alert('here..');
                                        $('#order_no').val($('#selected_order_no').val());
                                        $('#name').val($('#selected_name').val());
                                        $('#date_order').val($('#selected_date_order').val());                                        
                                                                                                    
                                        $( this ).dialog( "close" );
                                    }
                                },
                                close: function() {
                                    
                                }
                            });

                           // click place
                        });
            }
            function render_search_order_form_by_name()
            {
                        $(function() {
                            
                            //$( "#dialog-form-user-search" ).dialog({
                            $( "#dialog-form-order-search-by-name" ).dialog({
                                autoOpen: false,
                                height: 550,
                                width: 740,
                                modal: true,
                                buttons: {
                                    "Done": function() {
                                        //alert('here..');
                                        $('#order_no').val($('#selected_order_no').val());
                                        $('#name').val($('#selected_name').val());
                                        $('#date_order').val($('#selected_date_order').val());                                        
                                                                                                    
                                        $( this ).dialog( "close" );
                                    }
                                    
                                },
                                close: function() {
                                    
                                }
                            });

                           // click place
                        });
            }
            function render_search_order_form_by_date()
            {
                        $(function() {
                            
                            //$( "#dialog-form-user-search" ).dialog({
                            $( "#dialog-form-order-search-by-date" ).dialog({
                                autoOpen: false,
                                height: 550,
                                width: 740,
                                modal: true,
                                buttons: {
                                    "Done": function() {
                                        //alert('here..');
                                        $('#order_no').val($('#selected_order_no').val());
                                        $('#name').val($('#selected_name').val());
                                        $('#date_order').val($('#selected_date_order').val());                                        
                                                                                                    
                                        $( this ).dialog( "close" );
                                    }
                                },
                                close: function() {
                                    
                                }
                            });

                           // click place
                        });
            }
            function render_user_search_dialog_form()
            {
                        $(function() {
                            
                            $( "#dialog-form-user-search" ).dialog({
                                autoOpen: false,
                                height: 250,
                                width: 450,
                                modal: true,
                                buttons: {
                                    "Select": function() {
                                        var selected_user_id = $('#dialog-form-user-search-username-list').val();
                                        var selected_user_name = $('#dialog-form-user-search-username-list option:selected').text();
                                        var selected_role = $('#dialog-form-user-search-role-list option:selected').text();
                                        var uniq_code =  $('#current_unique_code').val();
                                        
                                        //alert(uniq_code);
                                        
                                        // ========= setting values========
                                        $('#userid_'+uniq_code).val(selected_user_id);
                                        $('#namelink_'+uniq_code).html(selected_user_name);
                                        $('#role_'+uniq_code).html(selected_role);
                                        $('#rolefield_'+uniq_code).val(selected_role);
                                        
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
                                        var selected_user_id = $('#dialog-form-user-search-username-list').val();
                                        var selected_user_name = $('#dialog-form-user-search-username-list option:selected').text();
                                        var selected_role = $('#dialog-form-user-search-role-list option:selected').text();
                                        var uniq_code =  $('#current_unique_code').val();
                                        $('#current_unique_code').empty();
                                        //alert(uniq_code);
                                        
                                        var comments = $('textarea#dialog-form-comments-box').val();                                        
                                        $('textarea#commentbox_'+uniq_code).val(comments);                                        
                                        //alert(comments);
                                        // ========= setting values========
                                        //$('#userid_'+uniq_code).val(selected_user_id);
                                        //$('#namelink_'+uniq_code).html(selected_user_name);
                                        //$('#role_'+uniq_code).html(selected_role);
                                        //$('#rolefield_'+uniq_code).val(selected_role);
                                        
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
    
    </script>

    <style type="text/css">
        #orders_by_order_no
        {
            margin-left: 15px;
        }
        
        #orders_by_order_no thead tr td
        {
            background-color: pink;
            font-size: 14px;
            padding: 5px;
        }
        #orders_by_order_no tbody tr td
        {
            
            font-size: 12px;
            padding: 5px;
        }
        #orders_by_order_name
        {
            margin-left: 15px;
        }
        
        #orders_by_order_name thead tr td
        {
            background-color: pink;
            font-size: 14px;
            padding: 5px;
        }
        #orders_by_order_name tbody tr td
        {
            
            font-size: 12px;
            padding: 5px;
        }
        
        #orders_by_order_date
        {
            margin-left: 15px;
        }
        
        #orders_by_order_date thead tr td
        {
            background-color: pink;
            font-size: 14px;
            padding: 5px;
        }
        #orders_by_order_date tbody tr td
        {
            
            font-size: 12px;
            padding: 5px;
        }
        
        a.order_name_search
        {
            color: #B30000 !important;            
        }
        a.order_no_search
        {
            color: #B30000 !important;                        
            text-decoration: underline;
        }
        a.order_no_search:hover
        {
            cursor: pointer;
            text-decoration: underline;
        }
        a.order_date_search
        {
            color: #B30000 !important;            
        }
    </style>
<div id="dialog-form-order-search" title="Search Order by Order#">
<table width="100%" border="0">
<tr>  
    <td>
        <p class="field_para" style="font-size: 12px !important">
           Click on 'Order#' then click 'Done'.
           <br />
           <br />
        </p>
        <p class="field_para">
            <label for="order_no">Order#
                <span class=""></span>
                <span class="loading_div"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/loader-s.gif" alt="loading.." /></span>
            </label>
      <input name="order_no_x" type="text" class="main_forms_field" id="order_no_x" tabindex="102" value="<?php echo (isset($form_data['order_no']))?($form_data['order_no']):("") ?>" />
        </p>
    </td>
    
    <td><p class="field_para">&nbsp;</p></td>
    <td>&nbsp;</td>
    </tr>
</table>

    
    <script type="text/javascript">
        $('document').ready(function(){
            
        });
    </script>
    
<table id="orders_by_order_no">
    <thead>
            <tr>
                <td>Order#</td>
                <td>Name</td>
                <td>Order Date</td>
            </tr> 
  </thead>
  
  <tbody>
        <?php foreach ($this->all_orders as $i => $order) : 
        
        if($order->out_of_service == '0')
        {
            $date_blank_a = true;
        }else{
            $date_blank_a = false;
        }                                        
        ?>  
      <?php 
            if($order->is_addon == 0):
      ?>
            <tr id="tr_<?php echo $order->id; ?>">
                <td><a class="order_no_search" id="orderid_<?php echo $order->id; ?>"><?php echo str_replace('"','\"',$order->order_no)?></a></td>
                <td><?php echo str_replace('"','\"',$order->name)?></td>
                <td><?php echo date('m/d/Y',strtotime(str_replace('"','\"',$order->date_order)))?></td>
            </tr> 
    
       <?php endif; ?>   
            
	<?php 
        
                    //}
         endforeach; 
        
                    
        ?>
      </tbody>      
    </table>
    </div>
<div id="dialog-form-order-search-by-name" title="Search Order by Name">
<table width="100%" border="0">
<tr>  
    <td>
        <p class="field_para" style="font-size: 12px !important">
           Click on 'Order Name' then click 'Done'.
           <br />
           <br />
        </p>
        <p class="field_para">
            <label for="order_no">Name
                <span class=""></span>
                <span class="loading_div"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/loader-s.gif" alt="loading.." /></span>
            </label>
      <input name="name_x" type="text" class="main_forms_field" id="name_x" tabindex="102" value="<?php echo (isset($form_data['order_no']))?($form_data['order_no']):("") ?>" /></p>
    </td>
    
    <td><p class="field_para">&nbsp;</p></td>
    <td>&nbsp;</td>
    </tr>
</table>

    
    <script type="text/javascript">
        $('document').ready(function(){
            
        });
    </script>
    
<table id="orders_by_order_name">
    <thead>
            <tr>
                <td>Order#</td>
                <td>Name</td>
                <td>Order Date</td>
            </tr> 
  </thead>
  
  <tbody>
        <?php foreach ($this->all_orders as $i => $order) : 
        
        if($order->out_of_service == '0')
        {
            $date_blank_a = true;
        }else{
            $date_blank_a = false;
        }                                        
        ?>       
      
      <?php 
            if($order->is_addon == 0):
      ?>
            <tr id="tr_<?php echo $order->id; ?>">
                <td><?php echo str_replace('"','\"',$order->order_no)?></td>
                <td><a class="order_no_search" id="orderid_<?php echo $order->id; ?>"><?php echo str_replace('"','\"',$order->name)?></a></td>
                <td><?php echo date('m/d/Y',strtotime(str_replace('"','\"',$order->date_order)))?></td>
            </tr> 
    <?php endif; ?>
            
	<?php 
        
                    //}
         endforeach; 
        
                    
        ?>
      </tbody>      
    </table>
    </div>
<div id="dialog-form-order-search-by-date" title="Search Order by Order Date">
<table width="100%" border="0">
<tr>  
    <td>
        
        <p class="field_para" style="font-size: 12px !important">
           Click on 'Order Date' then click 'Done'.
           <br />
           <br />
        </p>
        <p class="field_para">
            <label for="order_no">Order Date (mm/dd/yyyy)
                <span class=""></span>
                <span class="loading_div"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/loader-s.gif" alt="loading.." /></span>
            </label>
      <input name="order_date_x" type="text" class="main_forms_field" id="order_date_x" tabindex="102" value="" /></p>
    </td>
    
    <td><p class="field_para">&nbsp;</p></td>
    <td>&nbsp;</td>
    </tr>
</table>

    
    <script type="text/javascript">
        $('document').ready(function(){
            
        });
    </script>
    
<table id="orders_by_order_date">
    <thead>
            <tr>
                <td>Order#</td>
                <td>Name</td>
                <td>Order Date</td>
            </tr> 
  </thead>
  
  <tbody>
        <?php foreach ($this->all_orders as $i => $order) : 
        
        if($order->out_of_service == '0')
        {
            $date_blank_a = true;
        }else{
            $date_blank_a = false;
        }                                        
        ?> 
      <?php 
            if($order->is_addon == 0):
      ?>
            <tr id="tr_<?php echo $order->id; ?>">
                <td><?php echo str_replace('"','\"',$order->order_no)?></td>
                <td><?php echo str_replace('"','\"',$order->name)?></td>
                <td><a class="order_no_search" id="orderid_<?php echo $order->id; ?>"><?php echo date('m/d/Y',strtotime(str_replace('"','\"',$order->date_order)))?></a></td>
            </tr> 
    <?php endif; ?>
            
	<?php 
        
                    //}
         endforeach; 
        
                    
        ?>
      </tbody>      
    </table>
    </div>

    
<div id="dialog-form-user-search" title="Select Worker">
    
 
<p class="field_para">
      <label for="dialog-form-user-search-username"></label>
      <input name="dialog-form-user-search-username" type="hidden" class="" id="dialog-form-user-search-username" value="" />
      <input name="current_unique_code" type="hidden" class="" id="current_unique_code" value="" />
<table style="width:100%">
      <tr>
    <td><p class="field_para"><label for="dialog-form-user-search-username-list">Select Worker</label>
      <select name="dialog-form-user-search-username-list" id="dialog-form-user-search-username-list" class="dialog-form-user-search-username-list">
                    <option value="0"> -- Select --</option>
                    <?php foreach($workers as $worker):
                            if($worker->status == '1'){
                        ?>
                        <option value="<?php echo $worker->user_id ?>" <?php echo ($worker_id==$worker->user_id)?('selected=selected'):('')?>><?php echo $worker->first_name.' '.$worker->last_name; ?></option>
                    <?php 
                            }
                    endforeach; ?>
       </select>
      
    </p></td>
    
    <td><p class="field_para">
        <label for="return_time">Select Role</label>
        <select name="dialog-form-user-search-role-list" id="dialog-form-user-search-role-list" class="dialog-form-user-search-role-list">
                    <option value="Loader">Loader</option>
                    <option value="Driver">Driver</option>
                    <option value="Crew Chief">Crew Chief</option>                    
       </select>
    </p></td>
    </tr>
</table>

      
      
      
      
      
</p>

</div>
        
<div id="dialog-form-comment" title="Write Comments">
    
 

<table style="width:100%">
      <tr>
    
          <td><p class="field_para" style="padding-left: 0px !important">
        <label for="return_time">Comments</label>
        <textarea name="dialog-form-comments-box" id="dialog-form-comments-box" class="dialog-form-comments-box main_forms_field" cols="50" rows="6" style="width: 100% !important;font-size: 14px !important"></textarea>
    </p></td>
    </tr>
</table>

      
      
      
      
      
</p>

</div>
        
    <input type="hidden" id="selected_order_no" name="selected_order_no" value="" />
    <input type="hidden" id="selected_name" name="selected_name" value="" />
    <input type="hidden" id="selected_date_order" name="selected_date_order" value="" />
    <input type="hidden" id="sum_of_totalHrs_totalTravel" name="sum_of_totalHrs_totalTravel" value="" />
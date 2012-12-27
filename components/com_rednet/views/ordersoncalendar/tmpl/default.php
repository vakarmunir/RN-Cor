<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();

$data = $this->data;
$workers = $data['workers'];
$worker_id_non_admin = $data['worker_id_non_admin'];
$worker_id = JRequest::getVar('worker_id');


$event_url = "";
if(isset($worker_id) && $worker_id!=NULL)
{   
   $event_url = JURI::current()."?task=load_orders&worker_id=$worker_id";
}else{
   $event_url = JURI::current()."?task=load_orders";
}


if(isset($worker_id_non_admin) && $worker_id_non_admin!=NULL)
{  
   $event_url = JURI::current()."?task=load_orders&worker_id=$worker_id_non_admin";   
}

?>


<script type='text/javascript'>
    
   function go_allocated_resource(id)
   {
       var url = "<?php echo JURI::base(); ?>index.php/component/rednet/orders/?id="+id;
       window.location = url;
   }

	$('document').ready(function() {            
                var server = "<?php echo JURI::base(); ?>";                
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var event_insert_id = '';
                var event_url = "<?php echo $event_url; ?>";
                
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: ''
			},
			selectable: true,
                        loading: function(bool) {
                                if (bool) 
                                {
                                    
                                }else{
                                    
                                    draw_set_statup_buttons();
                                }
                        },
                        
                        complete: function() {
              
                        },
			selectHelper: true,
			dayClick: function(date, allDay, jsEvent,view) {			                                                                    
                                var d = date.getDate();
                                var m = date.getMonth()+1;
                                var y = date.getFullYear();
                                var date_string = y+"-"+m+"-"+d;
                                var url  = "<?php echo JURI::base() ?>index.php/component/rednet/ordersoncalendar/?date="+date_string+"&task=day_status";                                
                                
                                <?php if($worker_id_non_admin == NULL): ?>                                
                                    window.location = url;
                                <?php    endif; ?>    
                                
			},
			editable: true,
			events: event_url,
                        eventBackgroundColor: '#FCF !important',
                        eventRender: function(event, element) {                                                
                                                
                        
                        if(event.flag == 'order')
                        {
                            
                        var event_id = event.id;
                        var event_wrapper = "<div class='"+event.color_class+"'  id='event-"+event_id+"'></div>";                                               
                        $(element).html(event_wrapper);
                        var icon_path = '<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/sr_icon.png';
                        
                        // prepare addon-order here...                                                
                        var addon_data = event.array_of_adons;                        
                        var event_addon_html = "";
                        $.each(addon_data,function(index,add_on_event){                           
                                //event_addon_html = event_addon_html+"<p class='para_event'>"+add_on_event.title+"("+add_on_event.no_of_men+")"+"("+add_on_event.no_of_trucks+")</p>";    
                                event_addon_html = event_addon_html+"<p class='para_event' style='padding-top:7px !important'>"+add_on_event.title+""+"</p>";    
                        });
                        
                        
                        // prepare orginal order here...                        
                        var event_html = "<div class='event_wrapper'><p class='para_event'>"+event.title+"</p>"+ event_addon_html + "<p style='margin-top:5px!important;padding:0px !important;font-size:10px !important;'>("+event.no_of_men+")"+"("+event.no_of_trucks+")"+ "<span style='padding-left:5px'><input type='image' src='"+icon_path+"' id='lock_icon' width='15' height='12' onclick='return go_allocated_resource("+event_id+")' /></span></p>" +"</div>";    
                        $('div#event-'+event_id).html(event_html);
                        $(element).css('margin-bottom','5px');
                        //alert($('.fc-event').html());
                        
                        //alert($(element).attr('class'));
                        //return;
//                            $(element).height(50);
//                             var the_html = $('span',element).html();
//                             the_html = "<br />"+the_html;
//                             $('span',element).html(the_html);                             
                            }
                            
                            // [starts] if event is availability
                            if(event.flag == 'availability')
                            {
                                $(element).height(50);
                                var the_html = $('span',element).html();
                                the_html = "<br />"+the_html;
                                $('span',element).html(the_html);                             
                            }
                        },
                        eventClick: function( event, jsEvent, view ){
                            var eid = event.id;                            
                          

                        }                                                                                                      
		});
		
	});

</script>



<script type="text/javascript">
    $('document').ready(function(){
        
        //$('div#calendar_pane').hide();
        $('div#week_pane').hide();
        
        $('input#calendar_but').click(function(){
            $('div#calendar_pane').show();
            $('div#week_pane').hide();
        });
        $('input#week_but').click(function(){
            $('div#week_pane').show();
            $('div#calendar_pane').hide();
        });
        
        <?php
            if(isset($this->current_month))
            {
        ?>
                $('div#week_pane').show();
                $('div#calendar_pane').hide();
      <?php } ?>
    });
</script>


<style type='text/css'>

	#calendar {
		width: 700px;
		margin: 0 auto;
		}

</style>

<script type="text/javascript">    
    $('ready').ready(function(){                
        $('#order_button').click(function(){          
            var server = "<?php echo JURI::base(); ?>";            
            var path =server+"<?php echo "index.php/component/rednet/orders?task=order_form";?>";            
            window.location = path;
        });
    });
</script>

<?php if($worker_id_non_admin == NULL): ?>
<script type="text/javascript">
    $('document').ready(function(){
        
        
        $('.fc-button-prev').click(function(){
            //draw_set_statup_buttons();
        });
        
        $('.fc-button-next').click(function(){
            //draw_set_statup_buttons();
        });
        
        //draw_set_statup_buttons()
    });
    
    function draw_set_statup_buttons()
    {
        var day_content = $('.fc-day-content').get();                        
        $(day_content).each(function(index,element){        
        var date_box = $(element).parent().get();
            
            var day_of_date = $(".fc-day-number",date_box).text();
            var is_not_day_of_crnt_month = $(".fc-day-number",date_box).parents('td').hasClass('fc-other-month');
            
                    if(is_not_day_of_crnt_month == false)
                    {
                        var month_year_string = $.trim($('.fc-header-title h2').text()) ;                    
                        var month_year_array = month_year_string.split(' '); 

                        var month_string = month_year_array[0];
                        var year_string = month_year_array[1];

                        var months = {
                                    January:1,
                                    February:2,
                                    March:3 ,
                                    April:4 ,
                                    May:5 ,
                                    June:6 ,
                                    July:7 ,
                                    August:8,
                                    September:9 ,
                                    October:10 ,
                                    November:11 ,
                                    December:12 
                                };


                            var date_strng = year_string+"-"+months[month_string]+"-"+day_of_date;
                            var status_text = "";                                                        
               
                            $.post("<?php  echo JURI::current(); ?>/?task=day_status_json", { date: date_strng},
                                function(data) {
                                    var data_string = data;                                    
                                    var rslt_array = data_string.split(',');                                    
                                    //$("div#test").append(rslt_array[0]+' * '+rslt_array[1]+" *** ");
                                    
                                    var data_date,data_status;
                                    data_status = rslt_array[0].toUpperCase();
                                    data_date = rslt_array[1];                                                                        
                                    
                                    $("span#"+data_date).text(data_status);
                                        if(data_status == "OPEN")
                                        {
                                            $("span#"+data_date).css('background-color','#FFFFFF');
                                        }                                    
                                    
                                        if(data_status == "HOLD")
                                        {
                                            $("span#"+data_date).css('background-color','#B30000');
                                            $("span#"+data_date).css('color','#FFFFFF');
                                        }                                    
                                    
                                        if(data_status == "CLOSED")
                                        {
                                            $("span#"+data_date).css('background-color','#B30000');
                                            $("span#"+data_date).css('color','#FFFFFF');
                                        }                                    
                                    
                                });
                            
                            
                            
                            var day_table_html = "<table width='100%'><tr><td><span id='"+date_strng+"' style='font-size:10px;font-family:arial;padding:2px;'>"+status_text+"<span></td><td>"+day_of_date+"</td></tr></table>";            
                            $(".fc-day-number",date_box).css('width','90%').css('cursor', 'pointer').html(day_table_html);

                    }
            
        });
    }
</script>
<?php endif; ?>

<div id="test">
    
</div>

 <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/avalibility.gif" alt="" id="lock_icon" width="50" /></td>
            <td><h3>View Orders</h3></td>
        </tr>
 </table>


<?php if($worker_id_non_admin == NULL){ ?>
<table border="0" style="margin-left: 35px;" style="width: 100%">
  <tr>
            <td style="vertical-align: middle;padding-bottom: 18px" >&nbsp;Worker&nbsp; </td>
            
            <td style="vertical-align: middle">
                <select name="workers_list_on_clndr" id="workers_list_on_clndr" class="workers_list_on_clndr" style="width: 135px;">
                    <option value="0"> -- Select --</option>
                    <?php foreach($workers as $worker):
                            if($worker->status == '1'){
                        ?>
                        <option value="<?php echo $worker->user_id ?>" <?php echo ($worker_id==$worker->user_id)?('selected=selected'):('')?>><?php echo $worker->first_name.' '.$worker->last_name; ?></option>
                    <?php 
                            }
                    endforeach; ?>
                </select>    
            </td>
            
            <td>
                <div style="margin-left: 70px;">
                <input class="button" type="submit" value="Create Order" name="order_button" id="order_button" />
                </div>
            </td>
  </tr>
</table>

<?php } ?>

<div class="contentpane" id="calendar_pane">        
        <div id='calendar'></div>	
</div>



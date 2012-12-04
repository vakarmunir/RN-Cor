<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();
$day = $this->av_day;

$user = JFactory::getUser();

$worker_id = JRequest::getVar('worker_id');
$user_id = '';
$user_state = '';


$workerId = '';
$av_add_string = "";
$load_string = 'index.php/component/rednet/availabilitycalendar?task=get_availabilities';
if(isset($worker_id) && $worker_id!=NULL)
{
    $load_string = 'index.php/component/rednet/availabilitycalendar?task=get_availabilities'.'&worker_id='.$worker_id;
    $workerId = $worker_id;
    $user_id = $worker_id;
    $user_state = 'new';
    $av_add_string = "index.php/component/rednet/availabilitycalendar?task=av_sending_date&user_id=$user_id";
}else{
    $workerId = 0;
    $user_id = $user->id;
    $user_state = 'old';
    $av_add_string = "index.php/component/rednet/availabilitycalendar?task=av_sending_date&user_id=$user_id";
}




$db = JFactory::getDbo();

                   $group_qry = "                       
                    Select
                    rednet.#__users.id,
                    rednet.#__users.name,
                    rednet.#__users.username,
                    rednet.#__users.email,
                    rednet.#__users.password,
                    rednet.#__fua_userindex.group_id
                    From
                    rednet.#__users Inner Join
                    rednet.#__fua_userindex
                        On rednet.#__users.id = rednet.#__fua_userindex.user_id
                    Where
                    rednet.#__users.id = $user->id
                                        ";                   
                   $db->setQuery($group_qry);
                   $db->query();
                   $user_with_group_id = $db->loadObject();
                   $user_group_id = str_replace('"', '', $user_with_group_id->group_id);
                   
                   $group_name_qry = "SELECT * FROM #__fua_usergroups WHERE id=$user_group_id";
                   $db->setQuery($group_name_qry);
                   $db->query();
                   $user_group_obj = $db->loadObject();
                   $user_group_name = $user_group_obj->name; 

                   
?>
<script type='text/javascript'>

	$('document').ready(function() {            
              make_calendar();              
              $('#save_and_exit').hide();
	});

function make_calendar()
{
      var server = "<?php echo JURI::base(); ?>";
                
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var event_insert_id = '';
                
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: ''
			},
			selectable: true,
			selectHelper: true,
			dayClick: function(start, allDay, jsEvent,view) {
				
                                var av_date = start;
                                var d = av_date.getDate();
                                var m = av_date.getMonth();
                                var y = av_date.getFullYear();
                                var current_id = "";
                                                              
				$.post(server+"<?php echo $av_add_string; ?>",
                                {day:d,month:m+1,year:y},
                                    function(data) {                                    
                                        current_id = data;
                                         
                                         if(current_id.length != 0)
                                         {
                                                calendar.fullCalendar('renderEvent',
						{
                                                        id:current_id,
							title: 'Available',
							start: start,
							allDay: allDay,
                                                        e_id : current_id
						},
						false // make the event "stick"
                                            );                                                                                                
                                         }
                                         
                                         $('#save_and_exit').show();
                                });
                                
                                                               
				calendar.fullCalendar('unselect');
                                
			},
			editable: true,
			events: server+"<?php echo $load_string; ?>",
                        eventBackgroundColor: '#FCF !important',
                        eventRender: function(event, element) {
                            $(element).height(50);
                             var the_html = $('span',element).html();
                             the_html = "<br />"+the_html;
                             $('span',element).html(the_html);                             
                        },
                        eventClick: function( event, jsEvent, view ) {
                            var eid = event.id;                            
                          
                            $.post(server+"index.php/component/rednet/availabilitycalendar?task=av_remove_date",
                                {id:eid},
                                    function(data) {
                                        
                                            
                                                calendar.fullCalendar( 'removeEvents' , event.id );                                                                                   
                                });                                                                                    
                        $('#save_and_exit').show();
                        }                        
                                              
                                
		});
		
}
</script>



<script type="text/javascript">
    $('document').ready(function(){
        
        //$('div#calendar_pane').hide();
        $('div#week_pane').hide();
        
        $('input#calendar_but').click(function(){
            $('div#calendar_pane').show();
            $('div#week_pane').hide();
            
        $('#calendar').html('');
            make_calendar();
        });
        $('input#week_but').click(function(){
            $('div#week_pane').show();
            $('div#calendar_pane').hide();
        });
        
        $('input#save_and_exit').click(function(){
            window.location = "./";
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


<table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/avalibility.gif" alt="" id="lock_icon" width="50" /></td>
            <td><h4>Update Availability</h4></td>
        </tr>
</table>

<?php if($user_group_name == 'admin'): ?>
<table border="0" style="margin-left: 35px;">
  <tr>
            <td style="vertical-align: middle;padding-bottom: 18px" >&nbsp;Worker&nbsp; </td>
            <td style="vertical-align: middle">
                <select name="workers_list" id="workers_list" class="workers_list" style="width: 135px;">
                    <option value="0"> -- Select --</option>
                    <?php foreach($this->workers as $worker): ?>
                        <option value="<?php echo $worker->user_id ?>" <?php echo ($worker_id==$worker->user_id)?('selected=selected'):('')?>><?php echo $worker->first_name.' '.$worker->last_name; ?></option>
                    <?php endforeach; ?>
                </select>    
      </td>
  </tr>
</table>
<?php endif; ?>

<div id="link_pane" style="margin-left: 80px;">
    <input class="button" type="button" value="Set by calendar" name="calendar_but" id="calendar_but">
    <input class="button" type="button" value="Set by week" name="week_but" id="week_but">    
    <input class="button" type="button" value="Save & Exit" name="week_but" id="save_and_exit">    
</div>

<br />
<div class="contentpane" id="calendar_pane">        
        <div id='calendar'></div>	
</div>

<div style="margin-left: 70px;margin-top: 10px;" id="week_pane">
  
    
    
<div class="form_wrapper_app_small">
    <div class="mainform_left"></div>	
    <div class="mainform_middle">	        

        <form id="add_worker" action="<?php echo JRoute::_("index.php?option=com_rednet&task=week_availability&view=availabilitycalendar")?>" method="post" onSubmit="return validate_fleet();">

            <input type="hidden" name="current_month" id="current_month" value="<?php echo $this->month;?>" />
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" />
            <input type="hidden" name="user_state" id="user_state" value="<?php echo $user_state;?>" />
            
    <div class="mainform_warpper">
  
        <h4 style="margin-top: 20px;">Set Your Availability For Selected Month</h4> 
             
        <p class="field_para" style="display: none;" >
      
      <select name ="month_av" id ="month_av" class ="month_av" style="width: 130px;margin-left: 100px!important;border: 1px solid !important" tabindex="8">
        
        <option value="1" <?php echo (isset($this->month) && $this->month==1)?("selected=selected"):("") ?>>January</option>
        <option value="2" <?php echo (isset($this->month) && $this->month==2)?("selected=selected"):("") ?>>February</option>
        <option value="3" <?php echo (isset($this->month) && $this->month==3)?("selected=selected"):("") ?>>March</option>
        <option value="4" <?php echo (isset($this->month) && $this->month==4)?("selected=selected"):("") ?>>April</option>
        <option value="5" <?php echo (isset($this->month) && $this->month==5)?("selected=selected"):("") ?>>May</option>
        <option value="6" <?php echo (isset($this->month) && $this->month==6)?("selected=selected"):("") ?>>June</option>
        <option value="7" <?php echo (isset($this->month) && $this->month==7)?("selected=selected"):("") ?>>July</option>
        <option value="8" <?php echo (isset($this->month) && $this->month==8)?("selected=selected"):("") ?>>August</option>
        <option value="9" <?php echo (isset($this->month) && $this->month==9)?("selected=selected"):("") ?>>September</option>
        <option value="10" <?php echo (isset($this->month) && $this->month==10)?("selected=selected"):("") ?>>October</option>
        <option value="11" <?php echo (isset($this->month) && $this->month==11)?("selected=selected"):("") ?>>November</option>
        <option value="12" <?php echo (isset($this->month) && $this->month==12)?("selected=selected"):("") ?>>December</option>
      </select>      
            
        </p>
        
<table width="100%" border="0" style="margin-left: 5px;margin-top: 20px;color: #B30000">
  <tr>
    <td>
      
    <input type="checkbox" name="sun" id="sun" <?php echo isset($day['sun'])?('checked=checked'):(''); ?> />
    <label for="sun">Sunday</label>
    </td>
    <td><input type="checkbox" name="mon" id="mon" <?php echo isset($day['mon'])?('checked=checked'):(''); ?> />
    <label for="mon">Monday</label></td>
    <td><input type="checkbox" name="tue" id="tue" <?php echo isset($day['tue'])?('checked=checked'):(''); ?> />
    <label for="tue">Tuesday</label></td>
    <td><input type="checkbox" name="wed" id="wed" <?php echo isset($day['wed'])?('checked=checked'):(''); ?> />
    <label for="web">Wednesday</label></td>
    <td><input type="checkbox" name="thur" id="thur" <?php echo isset($day['thur'])?('checked=checked'):(''); ?> />
    <label for="thus">Thursday</label></td>
    <td><input type="checkbox" name="fri" id="fri" <?php echo isset($day['fri'])?('checked=checked'):(''); ?> />
    <label for="fri">Friday</label></td>
    <td><input type="checkbox" name="sat" id="sat" <?php echo isset($day['sat'])?('checked=checked'):(''); ?> />
    <label for="sat">Saturday</label></td>
  </tr>  
</table>
      
    </div>
        <br />
        
        <div class="role_wrapper"> </div>
<p><input type="submit" value="Save" name="save" tabindex="25" /></p>
</form>
    
        </div>
  <div class="mainform_left"></div>	  
</div>
    
</div>
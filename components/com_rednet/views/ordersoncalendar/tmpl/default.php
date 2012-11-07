<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();

$data = $this->data;
$workers = $data['workers'];

$worker_id = JRequest::getVar('worker_id');

$event_url = "";
if(isset($worker_id) && $worker_id!=NULL)
{   
   $event_url = JURI::current()."?task=load_orders&worker_id=$worker_id";
}else{
   $event_url = JURI::current()."?task=load_orders";
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
			selectHelper: true,
			dayClick: function(start, allDay, jsEvent,view) {
			        
			},
			editable: true,
			events: event_url,
                        eventBackgroundColor: '#FCF',
                        eventRender: function(event, element) {
                        
                        var event_id = event.id;
                        var event_wrapper = "<div class='"+event.color_class+"'  id='event-"+event_id+"'></div>";                                               
                        $(element).html(event_wrapper);
                        var icon_path = '<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/sr_icon.png';
                        
                        var event_html = "<div class='event_wrapper'><p class='para_event'>"+event.title+"("+event.no_of_men+")"+"("+event.no_of_trucks+")</p>"+ "<input type='image' src='"+icon_path+"' id='lock_icon' width='20' onclick='return go_allocated_resource("+event_id+" )' />" +"</div>";    
                        $('div#event-'+event_id).html(event_html);
                        $(element).css('margin-bottom','5px');
                        //alert($('.fc-event').html());
                        
                        //alert($(element).attr('class'));
                        //return;
//                            $(element).height(50);
//                             var the_html = $('span',element).html();
//                             the_html = "<br />"+the_html;
//                             $('span',element).html(the_html);                             
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


 <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/avalibility.gif" alt="" id="lock_icon" width="50" /></td>
            <td><h3>View Orders</h3></td>
        </tr>
 </table>



<table border="0" style="margin-left: 35px;">
  <tr>
            <td style="vertical-align: middle;padding-bottom: 18px" >&nbsp;Worker&nbsp; </td>
            
            <td style="vertical-align: middle">
                <select name="workers_list_on_clndr" id="workers_list_on_clndr" class="workers_list_on_clndr" style="width: 135px;">
                    <option value="0"> -- Select --</option>
                    <?php foreach($workers as $worker): ?>
                        <option value="<?php echo $worker->user_id ?>" <?php echo ($worker_id==$worker->user_id)?('selected=selected'):('')?>><?php echo $worker->first_name.' '.$worker->last_name; ?></option>
                    <?php endforeach; ?>
                </select>    
            </td>
            
  </tr>
</table>

<div class="contentpane" id="calendar_pane">        
        <div id='calendar'></div>	
</div>

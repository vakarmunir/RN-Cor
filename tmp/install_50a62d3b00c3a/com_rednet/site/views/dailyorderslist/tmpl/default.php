<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$no_of_orders = count($this->items);

?>



<script type="text/javascript">
            $("document").ready(function(){             
                          
var mydata = [
    
    <?php foreach ($this->items as $i => $order) : 
        
        if($order->out_of_service == '0')
        {
            $date_blank_a = true;
        }else{
            $date_blank_a = false;
        }        
        if($order->type_order == "others")
        {
            $order_type = $order->type_if_other;
        }else{
            $order_type = str_replace('_',' ',strtoupper($order->type_order));
        }        
        ?>
                    
            {id:"<?php echo $order->id?>",name:"<?php echo str_replace('"','\"',$order->name)?>",order_date:"<?php echo date('m/d/Y',strtotime(str_replace('"','\"',$order->date_order)))?>",departure_time:"<?php echo date('h:i:s A',strtotime($order->departure_time))?>",type:"<?php echo $order_type ?>",men:"<?php echo $order->no_of_men ?>",trucks:"<?php echo $order->no_of_trucks ?>",assign_resources:"Schedule Resources"},
	<?php endforeach; ?>	
	];
        
       
var lastgridsel;
jQuery("#order_list").jqGrid({
	data: mydata,
	datatype: "local",
	height: 250,
        width:900,
        
	rowNum: 10,
	rowList: [10,10,10],
   	colNames:['Id','Name','Order Date','Departure Time','Type','Men','Trucks','Schedule Resources'],
   	colModel:[
   		{name:'id',index:'id', width:60, sorttype:"int" , hidden:true},
   		{name:'name',index:'name', width:90, align:"center"},
   		{name:'order_date',index:'order_date', width:30, align:"center"},
   		{name:'departure_time',index:'departure_time', width:35, align:"center"},   		
   		{name:'type',index:'type', width:60, align:"center"},
   		{name:'men',index:'men', width:20, align:"center"},
   		{name:'trucks',index:'trucks', width:20, align:"center"},
   		{name:'assign_resources',index:'assign_resources', width:40, align:"center"}	
   			
   	],
   	pager: "#porder_list",
   	viewrecords: true,
   	caption: "Orders List - Schedule Resources",
    onSelectRow: function(id) {
    	if (id && id !== lastgridsel) {
            jQuery('#order_list').jqGrid('saveRow',lastgridsel, false, 'clientArray');
            jQuery('#order_list').jqGrid('editRow',id, true, null, null,'clientArray');
            lastgridsel = id;
        }
    },
    onCellSelect:function(rowid,iCol,cellcontent,e){
                    
            if(cellcontent == "Schedule Resources")
            {                
                    
                        var server = "<?php echo JURI::base(); ?>";
                        var url = server+"index.php/component/rednet/orders/?id="+rowid;
                        window.location = url;                                    
            }
    }
});
              
                      
            });
            
            
            
        </script> 
        

<script type="text/javascript">
    
    $('ready').ready(function(){
        
        
        $('#order_button').click(function(){          
            var server = "<?php echo JURI::base(); ?>";
            
            var path =server+"<?php echo "index.php/component/rednet/orders?task=order_form";?>";
            
            window.location =path;
        });

    });
</script>


<script type="text/javascript">

    $('document').ready(function(){        
        
       function validateDateFilter() 
       {
           alert($('#filter_date').val());
        
            if($('#filter_date').val()=="__/__/____"){
                alert('dashed...');
            }
       }
        
    });

</script>

<h1>Daily Orders List</h1>


<div style="padding-left: 10px;border: 0px solid;padding-bottom: 10px">
    <form method="post" action="<?php echo JRoute::_(JURI::current()) ?>" onSubmit="return validateDateFilter();">
    
    <p class="field_para" id="p_hide">
        <label for="filter_date">Filter by Date (mm/dd/yyyy)</label> 
        <input name="filter_date" type="text" class="main_forms_field_date" id="filter_date" tabindex="5" value="" />
        <label for="from"></label>
        
        <input type="submit" name="submit" value="Filter" />
      </p>
</form>    
</div>

<p>
<div style="margin-left: 20px;"> <table id="order_list"></table> <div id="porder_list"></div></div>
  
</p>



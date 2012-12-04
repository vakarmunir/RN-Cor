<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

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
                    
                    if($order->is_addon != '1')
                    {
                        
        ?>
                    
                    {id:"<?php echo $order->id?>",order_no:"<?php echo str_replace('"','\"',$order->order_no)?>",name:"<?php echo str_replace('"','\"',$order->name)?>",order_date:"<?php echo date('m/d/Y',strtotime(str_replace('"','\"',$order->date_order)))?>",departure_time:"<?php echo date('h:i:s A',strtotime($order->departure_time))?>",edit:"Edit",deleteit:"Delete"},
	<?php 
        
                    }
         endforeach; 
        
                    
        ?>];
        
       
var lastgridsel;
jQuery("#order_list").jqGrid({
	data: mydata,
	datatype: "local",
	height: 250,
        width:750,
        
	rowNum: 10,
	rowList: [10,10,10],
   	colNames:['Id','Order#','Name','Order Date','Departure Time','Edit','Delet'],
   	colModel:[
   		{name:'id',index:'id', width:60, sorttype:"int" , hidden:true},
   		{name:'order_no',index:'name', width:90, align:"center"},
   		{name:'name',index:'name', width:90, align:"center"},
   		{name:'order_date',index:'order_date', width:90, align:"center"},
   		{name:'departure_time',index:'departure_time', width:130, align:"center"},   		
   		{name:'edit',index:'edit', width:50, align:"center"},
   		{name:'deleteit',index:'deleteit', width:40, align:"center"}	
   			
   	],
   	pager: "#porder_list",
   	viewrecords: true,
   	caption: "Orders List - Edit/Delete",
    onSelectRow: function(id) {
    	if (id && id !== lastgridsel) {
            jQuery('#order_list').jqGrid('saveRow',lastgridsel, false, 'clientArray');
            jQuery('#order_list').jqGrid('editRow',id, true, null, null,'clientArray');
            lastgridsel = id;
        }
    },
    onCellSelect:function(rowid,iCol,cellcontent,e){
        
            if(cellcontent == "Edit")
            {
                var server = "<?php echo JURI::base(); ?>";
                var url = server+"index.php/component/rednet/orders?task=order_form&id="+rowid;
                window.location = url;
            }
            if(cellcontent == "Delete")
            {


                var conf = confirm("Are you sure to delete the order?");
                    if(conf == true)
                    {
                        var server = "<?php echo JURI::base(); ?>";
                        var url = server+"index.php/component/rednet/orders?task=order_delete&id="+rowid;
                        window.location = url;
                    }
                
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
            window.location = path;
        });
    });
</script>

<h3 style="margin-left: 80px">Orders List</h3>

<!--<p>
<input class="button" type="submit" value="Create Order" name="order_button" id="order_button" />
</p>-->
<br />
<p>
<div style="margin-left: 100px;"> <table id="order_list"></table> <div id="porder_list"></div></div>
  
</p>



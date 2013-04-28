<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
                $order_no = JRequest::getVar('order_no');
                $name = JRequest::getVar('name');
                $date_order = JRequest::getVar('date_order');
                
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
        ?>
                    
                    {id:"<?php echo $order->id?>",order_no:"<?php echo str_replace('"','\"',$order->order_no)?>",name:"<?php echo str_replace('"','\"',$order->name)?>",order_date:"<?php echo date('m/d/Y',strtotime(str_replace('"','\"',$order->date_order)))?>",departure_time:"<?php echo date('h:i:s A',strtotime($order->departure_time))?>",edit:"Edit",deleteit:"Delete",trip_report:"Trip Report"},
	<?php 
        
                    //}
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
   	colNames:['Id','Order#','Name','Order Date','Departure Time','Edit','Delet','Trip Report'],
   	colModel:[
   		{name:'id',index:'id', width:60, sorttype:"int" , hidden:true},
   		{name:'order_no',index:'name', width:90, align:"center"},
   		{name:'name',index:'name', width:90, align:"center"},
   		{name:'order_date',index:'order_date', width:90, align:"center",
                  sorttype:'date' ,formatter:'date', formatoptions: {srcformat: 'm/d/Y', newformat: 'm/d/Y'}
                },
   		{name:'departure_time',index:'departure_time', width:130, align:"center"},   		
   		{name:'edit',index:'edit', width:50, align:"center"},
   		{name:'deleteit',index:'deleteit', width:40, align:"center"},	
   		{name:'trip_report',index:'trip_report', width:50, align:"center"}	
   			
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
            if(cellcontent == "Trip Report")
            {
                
                var server = "<?php echo JURI::base(); ?>";
                var url = server+"index.php/component/rednet/reportmaster/?order_id="+rowid;                
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
        
        
        $('th#jqgh_order_list_order_date').click(function(){
            //alert('i m clicked');
        });
        
    });
</script>

<h3 style="margin-left: 80px">Orders List</h3>

<!--<p>
<input class="button" type="submit" value="Create Order" name="order_button" id="order_button" />
</p>-->
<br />



        <table width="80%" border="0" style="margin-left: 75px;margin-bottom: 10px;">
            <form name="filter_order_list" id="filter_order_list" action="<?php echo JURI::current(); ?>" method="get">
                 
        <tr>
            <td><p class="field_para">        

                    <label for="order_no">Order#</label>
                    <input type="hidden" name="action" value="filter" />
                    <input name="order_no" type="text" class="main_forms_field required" id="order_no" tabindex="1" value="<?php echo (isset($order_no))?($order_no):('') ?>" />      <label for="fist_name"></label>
            </p>
            </td>


            <td><p class="field_para">
            <label for="name">Name</label>
            <input name="name" type="text" class="main_forms_field required" id="name" tabindex="2" value="<?php echo (isset($name))?($name):('') ?>" /></p></td>
            <td>

            <p class="field_para">
            <label for="date_order">Date (mm/dd/yyyy)</label>

            <input name="date_order" type="text" class="main_forms_field required" id="date_order" tabindex="3" value="<?php echo (isset($date_order))?($date_order):('') ?>">

            </p>        
            </td>
            
            <td>
                <p class="field_para">
                    <label for="date_order">&nbsp;&nbsp;&nbsp;</label>

            <input class="button" type="submit" value="Filter" name="order_button" id="filter" />

            </p>        
                
            </td>
            
            </tr>
            
            </form>
            
        </table>      


<p>
<div style="margin-left: 100px;"> <table id="order_list"></table> <div id="porder_list"></div></div>
  
</p>



<?php
// no direct access
defined('_JEXEC') or die('Restricted access');


?>
<script type="text/javascript">
    
    $('ready').ready(function(){
        
        
        $('#rental').click(function(){          
            window.location = "fleet?task=add_rental";
        });
        $('#fleet').click(function(){
            window.location = "fleet?task=add_fleet";
        });
    });
</script>



<script type="text/javascript">
            $("document").ready(function(){             
                          
var mydata = [
    
    <?php foreach ($this->fleets as $i => $fleet) : 
        
        if($fleet->out_of_service == '0')
        {
            $date_blank_a = true;
        }else{
            $date_blank_a = false;
        }
        
        ?>
                    
                    {id:"<?php echo $fleet->id?>",name:"<?php echo str_replace('"','\"',$fleet->name)?>",type:"<?php echo str_replace('"','\"',$fleet->type)?>",o_o_s:"<?php echo ($fleet->out_of_service == '1')?('yes'):('no')?>",from:"<?php echo ($date_blank_a == true)?('--'):(date('m/d/Y',strtotime($fleet->from_date)))?>",to:"<?php echo ($date_blank_a == true)?('--'):(date('m/d/Y',strtotime($fleet->to_date)))?>",edit:"Edit",deleteit:"Delete"},
	<?php endforeach; ?>	
	];
        
       
var lastgridsel;
jQuery("#fleet_grid").jqGrid({
	data: mydata,
	datatype: "local",
	height: 250,
        width:600,
        
	rowNum: 10,
	rowList: [10,10,10],
   	colNames:['Id','Name','Type','Out of service','From','To','Edit','Delet'],
   	colModel:[
   		{name:'id',index:'id', width:60, sorttype:"int" , hidden:true},
   		{name:'name',index:'name', width:90, align:"center"},
   		{name:'type',index:'type', width:90, align:"center"},
   		{name:'o_o_s',index:'email', width:130, align:"center"},
   		{name:'from',index:'from', width:130, align:"center"},
   		{name:'to',index:'to', width:130, align:"center"},
   		{name:'edit',index:'edit', width:50, align:"center"},
   		{name:'deleteit',index:'deleteit', width:40, align:"center"}	
   			
   	],
   	pager: "#pfleet_grid",
   	viewrecords: true,
   	caption: "Fleets List - Edit/Delete",
    onSelectRow: function(id) {
    	if (id && id !== lastgridsel) {
            jQuery('#fleet_grid').jqGrid('saveRow',lastgridsel, false, 'clientArray');
            jQuery('#fleet_grid').jqGrid('editRow',id, true, null, null,'clientArray');
            lastgridsel = id;
        }
    },
    onCellSelect:function(rowid,iCol,cellcontent,e){
        
            if(cellcontent == "Edit")
            {
                var url = "fleet/?task=edit_fleet&id="+rowid;
                window.location = url;
            }
            if(cellcontent == "Delete")
            {
                
                var conf = confirm("Are you sure to delete the fleet?");
                    if(conf == true)
                    {
                        var url = "fleet/?task=delete_fleet&id="+rowid;
                        window.location = url;
                    }
                
            }
    }
});
              
                      
            });
            
            
            
        </script> 
        

<script type="text/javascript">
            $("document").ready(function(){             
             
var mydata = [
    
    <?php foreach ($this->rentals as $i => $rental) : 
        /*
        if($rental->out_of_service == '0')
        {
            $date_blank = true;
        }else{
            $date_blank = false;
        }
        */
                if($rental->to_date=='1970-01-01' &&  $rental->to_date=='1970-01-01')
                {
                    $date_blank = true;
                }else{
                    $date_blank = false;
                }
                
                $to_date = strtotime($rental->to_date);
                $today_date = strtotime(date('Y-m-d'));
                
                if($to_date>=$today_date)
                {
                
        ?>
		{id:"<?php echo $rental->id?>",name:"<?php echo str_replace('"','\"',$rental->name)?>",type:"<?php echo str_replace('"','\"',$rental->type)?>",o_o_s:"<?php echo ($rental->out_of_service == '1')?('yes'):('no')?>",from:"<?php echo ($date_blank == true)?('--'):(date("m/d/Y",strtotime($rental->from_date)))?>",to:"<?php echo ($date_blank == true)?('--'):(date("m/d/Y",strtotime($rental->to_date)))?>",edit:"Edit",deleteit:"Delete"},
	<?php 
                }
          endforeach; ?>	
	];
var lastgridsel;
jQuery("#rental_grid").jqGrid({
	data: mydata,
	datatype: "local",
	height: 250,
        width:600,
        
	rowNum: 10,
	rowList: [10,10,10],
   	colNames:['Id','Name','Type','From','To','Edit','Delet'],
   	colModel:[
   		{name:'id',index:'id', width:60, sorttype:"int",hidden:true},
   		{name:'name',index:'name', width:90, align:"center"},
                {name:'type',index:'type', width:90, align:"center"},                   		
   		{name:'from',index:'from', width:130, align:"center"},
   		{name:'to',index:'to', width:130, align:"center"},
   		{name:'edit',index:'edit', width:50, align:"center"},
   		{name:'deleteit',index:'deleteit', width:40, align:"center"}	
   			
   	],
   	pager: "#prental_grid",
   	viewrecords: true,
   	caption: "Rental List - Edit/Delete",
    onSelectRow: function(id) {
    	if (id && id !== lastgridsel) {
            jQuery('#rental_grid').jqGrid('saveRow',lastgridsel, false, 'clientArray');
            jQuery('#rental_grid').jqGrid('editRow',id, true, null, null,'clientArray');
            lastgridsel = id;
        }
    },
    onCellSelect:function(rowid,iCol,cellcontent,e){
        
            if(cellcontent == "Edit")
            {
               var url = "fleet/?task=edit_rental&id="+rowid;
               window.location = url;
            }
            if(cellcontent == "Delete")
            {
                
                var conf = confirm("Are you sure to delete the rental?");
                    if(conf == true)
                    {
                        
                        
                        var url = "fleet/?task=delete_rental&id="+rowid;
                        window.location = url;
                    }
                
            }
    }
});
              
                      
            });
            
            
            
        </script> 
         
        
<h2>Manage Vehicles</h2>



<p>
<input class="button" type="submit" value="Add Fleet" name="fleet" id="fleet" />
</p>

<p>
  <div style="margin-left: 135px;"> <table id="fleet_grid"></table> <div id="pfleet_grid"></div>
  </div>
</p>

<p>
<input class="button" type="submit" value="Add Rental" name="rental" id="rental" />
</p>


<p>
  <div style="margin-left: 135px;"> <table id="rental_grid"></table> <div id="prental_grid"></div>
  </div>
</p>
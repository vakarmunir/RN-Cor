<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
?>

<div class="contentpane">
	<h3 style="margin-left: 20px;">Workers List</h3>
        
        <jdoc:include type="message" />
                        
        <script type="text/javascript">
            $("document").ready(function(){             
             
var mydata = [
    
    <?php foreach ($this->items as $i => $item) : ?>
		{id:"<?php echo $item->user_id?>",first_name:"<?php echo $item->first_name?>",last_name:"<?php echo $item->last_name?>",cell:"<?php echo $item->cell ?>",email:"<?php echo $item->email ?>",edit:"Edit",deleteit:"Delete"},
	<?php endforeach; ?>	
	];
var lastgridsel;
jQuery("#list47").jqGrid({
	data: mydata,
	datatype: "local",
	height: 260,
        width:850,
        
	rowNum: 10,
	rowList: [10,10,10],
   	colNames:['Id','First Name','Last Name', 'Cell' ,'Email', 'Edit','Delet'],
   	colModel:[
   		{name:'id',index:'id', width:100, sorttype:"int",hidden:true},
   		{name:'first_name',index:'first_name', width:100, align:"center"},
   		{name:'last_name',index:'last_name', width:100, align:"center"},
   		{name:'cell',index:'cell', width:100, align:"center"},
   		{name:'email',index:'email', width:100, align:"center"},
   		{name:'edit',index:'edit', width:50, align:"center"},
   		{name:'deleteit',index:'deleteit', width:40, align:"center"}	
   			
   	],
   	pager: "#plist47",
   	viewrecords: true,
   	caption: "Workers List - Edit/Delete",
    onSelectRow: function(id) {
    	if (id && id !== lastgridsel) {
            jQuery('#list47').jqGrid('saveRow',lastgridsel, false, 'clientArray');
            jQuery('#list47').jqGrid('editRow',id, true, null, null,'clientArray');
            lastgridsel = id;
        }
    },
    onCellSelect:function(rowid,iCol,cellcontent,e){
        
            if(cellcontent == "Edit")
            {
                var url = "workers/"+rowid+"?task=edit_worker_view";
                window.location = url;
            }
            if(cellcontent == "Delete")
            {
                var conf = confirm("Are you sure to delete the worker?");
                    if(conf == true)
                    {
                        var url = "workers/"+rowid+"?task=delete_worker";
                        window.location = url;
                    }
                
            }
    }
});
              
                      
            });
            
            
            
        </script>        

        
        <div style="margin-left: 15px !important;padding: 10px;">
            
<form id="filter_form" name="filter_form" method="post" action="workers?task=filter_worker">
    <p>
<!--    <label for="name">Name</label>
  <input type="text" name="name" id="name" />
  
  -->
  <label for="status">Status</label>
  <select name="status_filter" id="status_filter" style="visibility: inherit  !important;position: inherit !important;">  
  <option value="">-- Select --</option>  
  <option value="0">In-active</option>  
  <option value="1">Active</option>   
  </select>
  
<!--  
  <label for="email">Email</label>
  <input type="text" name="email" id="email" />
  
  -->
  <input class="button" type="submit" value="Filter" name="Submit">
  </p>
  
</form> 
        </div>        
       <div style="margin-left: 40px;"> <table id="list47"></table> <div id="plist47"></div>

       </div>
	
        
</div>
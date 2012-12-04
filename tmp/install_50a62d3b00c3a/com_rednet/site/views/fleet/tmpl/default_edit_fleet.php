<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
$fleet = $this->fleet;

$from = $fleet->from_date;
$from_date = date('m/d/Y',strtotime($from));

$to = $fleet->to_date;


$to_date = date('m/d/Y',strtotime($to));

$check_string = ($fleet->out_of_service == 1)?("checked=checked"):("");

?>

<script type="text/javascript">
   
          
            var hide_from = false;
          var hide_to = false;
           
           
    $('document').ready(function(){      
        
        <?php
                if($check_string == '')
                {
        ?>
                    $('p#p_hide').css('display', 'none'); 
          <?php }else{ ?>
              
                     $('p#p_hide').css('display', 'block');
          <?php } ?>
        
       
        
       $('input#out_of_service').click(function(){
           
               if($('input#out_of_service').is(':checked') == true)
               {
                   $('input#from').removeClass('main_forms_field_date hasDatepicker').addClass('main_forms_field_date validate[required] hasDatepicker');
                   $('input#to').removeClass('main_forms_field_date hasDatepicker').addClass('main_forms_field_date validate[required] hasDatepicker');
                   $('p#p_hide').css('display', 'block');
                   
                   hide_from = true;
                   hide_to = true;
            
               }else{
                   $('input#from').removeClass('main_forms_field_date validate[required] hasDatepicker').addClass('main_forms_field_date hasDatepicker');
                   $('input#to').removeClass('main_forms_field_date validate[required] hasDatepicker').addClass('main_forms_field_date hasDatepicker');
                   $('p#p_hide').css('display', 'none');
                   hide_from = false;
                   hide_to = false;
               }
       });
    });
    
    
    
    function validate_fleet()
    {
          
           
                if($("input#name").val() == "")
                {
                    alert("Enter \"Name\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                if($("input#type").val() == "")
                {
                    alert("Enter \"Type\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
               
               
               
               
                     if(hide_from == true)
                    {                             
                            if($("input#from").val() == "" || $("input#from").val() == "01/01/1970")
                            {
                                alert("Enter \"From\"");
                                if(navigator.appName == "Microsoft Internet Explorer")
                                event.returnValue = false;
                            else
                                return false;
                            }
                    }                           
                
                    if(hide_to == true)
                    {   
                        if($("input#to").val() == "" || $("input#to").val() == "01/01/1970")
                        {
                            alert("Enter \"To\"");
                            if(navigator.appName == "Microsoft Internet Explorer")
                            event.returnValue = false;
                        else
                            return false;
                        }
                    }
                
    }        
</script>

<div>
    <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/truck_red.png" alt="" id="lock_icon" width="50" /></td>
            <td><h4>Edit Fleet</h4></td>
        </tr>
    </table>
    
</div>

<jdoc:include type="message" />

<div class="form_wrapper_app_small">
    <div class="mainform_left"></div>	
    <div class="mainform_middle">	        

        <form id="add_worker" action="index.php?option=com_rednet&task=udpate_fleet&view=fleet" method="post" onSubmit="return validate_fleet();">
            <input type="hidden" name="id" id="id" value="<?php echo $fleet->id ?>"/>

    <div class="mainform_warpper">
    
<table width="100%" border="0">
  
    
    
    
    
    
    <tr>
    <td>
        <p class="field_para">
            <label for="name">Name</label>
      <input class="main_forms_field validate[required]" type="text" name="name" id="name" value="<?php echo (isset($fleet->name))?($fleet->name):("") ?>" tabindex="1" />      
            <label for="name"></label>
        </p>
    </td>
    
    <td>
        <p class="field_para">
            <label for="type">Type</label>
      <input name="type" type="text" class="main_forms_field validate[required]" id="type" tabindex="2" value="<?php echo (isset($fleet->type))?($fleet->type):("") ?>" />
      <label for="type"></label>
        </p>
    </td>
    
 
    

    <td>
        
     <p class="field_para">
      <label for="out_of_service"></label>
      
     
     <div style="border: 0px solid; width: 225px !important;height: 35px !important">
         <span style="font-family: arial;font-size: 14px;color: #B30000;">Out of service </span>                  
         <span style="font-family: arial;padding-top: 5px;"><input type="checkbox" id="out_of_service" name="out_of_service" <?php echo $check_string;?> style="font-family: arial;padding-top: 5px;" /></span>
       
      </div>
         <label for="out_of_service"></label>
      </p>
    </td>

    
    </tr>
  <tr>
    <td><p class="field_para" id="p_hide">
            <label for="from">From (mm/dd/yyyy)</label> 
        <input name="from" type="text" class="main_forms_field_date validate[required]" id="from" tabindex="5" value="<?php echo $from_date; ?>" />
        <label for="from"></label>
      </p></td>
    
    <td>
      <p class="field_para" id="p_hide">
          <label for="to">To (mm/dd/yyyy)</label>
      <input name="to" type="text" class="main_forms_field_date validate[required]" id="to" tabindex="6" value="<?php echo $to_date; ?>" />
      <label for="to"></label>
      </p>
    
    </td>
    
    
     <td>
        
     <p class="field_para">
      <label for="out_of_service"></label>
      
     
     <div style="border: 0px solid; width: 225px !important;height: 35px !important">
         <span style="font-family: arial;font-size: 14px;color: #B30000;"></span>                  
         <span style="font-family: arial;padding-top: 5px;"></span>
         
      </div>
         <label for="out_of_service"></label>
      </p>
    </td>

    
    
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

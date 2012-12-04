<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
?>

<style type="text/css">
    .hide_the_p{
        display: none;
    }
</style>
<script type="text/javascript">
    
            var hide_from = false;
          var hide_to = false;
           
           
    $('document').ready(function(){      
        $('p#p_hide').css('display', 'none');
        
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
                            if($("input#from").val() == "")
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
                        if($("input#to").val() == "")
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
            <td><h4>Add Fleet</h4></td>
        </tr>
    </table>
    
</div>

<jdoc:include type="message" />

<div class="form_wrapper_app_small">
    <div class="mainform_left"></div>	
    <div class="mainform_middle">	        

        <form id="add_worker" action="index.php?option=com_rednet&task=vehicle_fleet_save&view=fleet" method="post" onSubmit="return validate_fleet();">

    <div class="mainform_warpper">
    
<table width="100%" border="0">
  
    
    
    
    
    
    <tr>
    <td>
        <p class="field_para">
            <label for="name">Name</label>
      <input class="main_forms_field validate[required]" type="text" name="name" id="name" value="<?php echo (isset($form_data['name']))?($form_data['name']):("") ?>" tabindex="1" />      
            <label for="name"></label>
        </p>
    </td>
    
    <td>
        <p class="field_para">
            <label for="type">Type</label>
      <input name="type" type="text" class="main_forms_field validate[required]" id="type" tabindex="2" value="<?php echo (isset($form_data['type']))?($form_data['type']):("") ?>" />
      <label for="type"></label>
        </p>
    </td>
    
 
    

    <td>
        
     <p class="field_para">
      <label for="out_of_service"></label>
      
     
     <div style="border: 0px solid; width: 225px !important;height: 35px !important">
         <span style="font-family: arial;font-size: 14px;color: #B30000;">Out of service </span>                  
         <span style="font-family: arial;padding-top: 5px;"><input type="checkbox" id="out_of_service" name="out_of_service" style="font-family: arial;padding-top: 5px;" /></span>
         
      </div>
         <label for="out_of_service"></label>
      </p>
    </td>

    
    </tr>
  <tr>
    <td><p class="field_para" id="p_hide">
            <label for="from">From (mm/dd/yyyy)</label> 
        <input name="from" type="text" class="main_forms_field_date" id="from" tabindex="5" value="<?php echo (isset($form_data['from']))?($form_data['from']):("") ?>" />
        <label for="from"></label>
      </p></td>
    
    <td>
      <p class="field_para" id="p_hide">
          <label for="to">To (mm/dd/yyyy)</label>
      <input name="to" type="text" class="main_forms_field_date" id="to" tabindex="6" value="<?php echo (isset($form_data['to']))?($form_data['to']):("") ?>" />
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


<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* The following line loads the MooTools JavaScript Library */
JHtml::_('behavior.framework', true);

/* The following line gets the application object for things like displaying the site name */


$user = JFactory::getUser();

$userId = $user->id;

$app = JFactory::getApplication();

            if ($userId == 0)
            {
     
                if(JRequest::getVar('view') == "frontpage" ) {
                    $url = JRoute::_('index.php?option=com_users&view=login', false);    
                    $app->redirect($url);
                }
                if(JRequest::getVar('view') == "featured" ) {
                    $url = JRoute::_('index.php?option=com_users&view=login', false);    
                    $app->redirect($url);
                }

            }
                          
            if ($userId != 0)
            {                   
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
                    rednet.#__users.id = $userId
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
                   
                   
                   if(isset($user_group_name))
                   {
                       $active_msg = '<p>User In-active.</p>';
                   }else{
                       $active_msg = "";
                   }
                   //if($user_group_name == "loader")                   
                   if($user_group_name=="loader")
                   {                                                                  
                   }                                      
                   
                
                
            }


            
        function getWorkersRoles($user_id)
        {
           
                     
        $db = JFactory::getDbo();
        $query="SELECT * FROM #__worker_role_index WHERE user_id=$user_id";
        $db->setQuery($query);
        $db->query();
        $role_indexes = $db->loadObjectList();
                        
        $role_string = '';
        
        $total = count($role_indexes);
        $coma = ',';
        $cntr=1;
        $isPrint = false;
        $html_all_loders = "";
        $role_html = '';
        $role_of_user = '';
        
        if(is_array($role_indexes))
        {
        
            
        foreach($role_indexes as $ri)
        {
            
            if($cntr == $total)
                $coma = '';
                
                $queryA="SELECT * FROM #__worker_role WHERE id=$ri->role_id";
                $db->setQuery($queryA);
                $db->query();
                $role = $db->loadObject();                            
                
                
                
                        if($role->name == 'ldr-f' || $role->name == 'ldr-p')
                        {
                            
                            $role_html = "Loader";
                            $role_of_user = "loader";
                        }                                                                                                
                
                
                
                        if($role->name == 'packer')
                        {
                            
                            $role_html = "Packer";
                            $role_of_user = "loader";
                        }                                                                                                
                
                
                
                        if($role->name == 'drv-z' || $role->name == 'drv-g')
                        {                                                   
                            
                            $role_html = "Driver";
                            $role_of_user = "loader";
                        }
                
                                
                        if($role->name == 'cc' || $role->name == 'cct' || $role->name == 'acc' || $role->name == 'acc-g')
                        {                                                    
                            
                            $role_html = "Crew Chief";
                            $role_of_user = "crew";
                        }
                                                
            $cntr++;
        }
        
        }
        
            return $role_of_user;
        }
        
?>

<?php echo '<?'; ?>xml version="1.0" encoding="<?php echo $this->_charset ?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>
		<!-- The following JDOC Head tag loads all the header and meta information from your site config and content. -->
		<jdoc:include type="head" />

		<!-- The following five lines load the Blueprint CSS Framework (http://blueprintcss.org). If you don't want to use this framework, delete these lines. -->
<!--		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php //echo $this->template ?>/css/blueprint/screen.css" type="text/css" media="screen, projection" />    -->
<!--		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php //echo $this->template ?>/css/blueprint/print.css" type="text/css" media="print" /> -->
		<!--[if lt IE 8]><link rel="stylesheet" href="blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php //echo $this->template ?>/css/blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection" /> 
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php //echo $this->template ?>/css/blueprint/plugins/joomla-nav/screen.css" type="text/css" media="screen" /> 
                
		<!-- The following line loads the template CSS file located in the template folder. -->
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" /> 
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/style.css" type="text/css" /> 
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/jquery.ui.all.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/customMessages.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/customMessages.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/validationEngine.jquery.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ui.jqgrid.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/fullcalendar.print.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/easyui.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/icon.css" />


		<!-- The following four lines load the Blueprint CSS Framework and the template CSS file for right-to-left languages. If you don't want to use these, delete these lines. -->
		<?php if($this->direction == 'rtl') : ?>
			<link rel="stylesheet" href="<?php //echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/blueprint/plugins/rtl/screen.css" type="text/css" />
			<link rel="stylesheet" href="<?php //echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_rtl.css" type="text/css" />
		<?php endif; ?>

		<!-- The following line loads the template JavaScript file located in the template folder. It's blank by default. -->
                <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.js"></script>
                <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/template.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/ddaccordion.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.ui.core.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.validationEngine-en.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.validationEngine.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.dropkick-1.0.0.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/grid.locale-en.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.maskedinput-1.3.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/fullcalendar.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/date.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.qtip-1.0.0-rc3.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/moment.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/messi.js"></script>

                
                <script type="text/javascript" charset="utf-8">
                    var gen_id_order_type = '';
                    var pr_role,sec_role,ad_role;
                    var role_error = false;
                    var type_order_error = false;
    $(function () {
      $('.primary_role').dropkick({
          change: function (value,label)
          {
             pr_role = label;
             $('input#primary_role_hidden_name').val(pr_role);
             
                if((pr_role == sec_role) || (pr_role == ad_role))
                {
                     role_error = true;
                     alert(label+" is already selected");
                     
                     if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                    else
                    return false;
                
                 }else{
                     role_error = false;
                 }                 
          }
      });
      
      $('.secondary_role').dropkick({
          change: function (value,label)
          {
             sec_role = label;
             
             $('input#secondary_role_hidden_name').val(sec_role);
           
                if((sec_role == pr_role) || (sec_role == ad_role))
                 {
                     role_error = true;
                     alert(label+" is already selected");
                     
                     if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                     else
                    return false;
                
                 }else{
                     role_error = false;
                 }
                 
                 
                 if(value != 0){
                     $('input#wage_hr_secondary').removeClass('main_forms_field');
                     $('input#wage_hr_secondary').addClass('main_forms_field validate[required]');                     
                 }else{
                     $('input#wage_hr_secondary').removeClass('main_forms_field validate[required]');
                     $('input#wage_hr_secondary').addClass('main_forms_field');                                          
                 }
          }
      });
      $('.additional_role').dropkick({
          change: function (value,label)
          {
             ad_role = label;
             $('input#additional_role_hidden_name').val(ad_role);
                  if((ad_role == sec_role) || (ad_role == pr_role))
                  {
                     role_error = true;
                     alert(label+" is already selected");
                     
                     if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                
                 }else{
                     role_error = false;
                 }
                 
                 
                 if(value != 0){
                     $('input#wage_hr_additional').removeClass('main_forms_field');
                     $('input#wage_hr_additional').addClass('main_forms_field validate[required]');                     
                 }else{
                     $('input#wage_hr_additional').removeClass('main_forms_field validate[required]');
                     $('input#wage_hr_additional').addClass('main_forms_field');                                          
                 }
          }
      });
      $('.status').dropkick();
      $('.status_edit').dropkick();
      $('.myclass').dropkick();
      $('.hrs').dropkick();
      $('.mins').dropkick();
      $('.type_order').dropkick({
          change: function(value,label)
          {
              gen_id_order_type = value;
              
              order_id_generation_code();
              
              if(value == 'others')
              {
                  type_order_error = true;
                  $('p#type_other').show();
              }else{
                  type_order_error = false;
                  $('p#type_other').hide();
              }
              
              if(value == 'pack')
              {
                  var in_resource_page = $('input#in_resources_page').val();
                      if(in_resource_page == 'yes')
                      {
                          $('div#packers_table_wrapper').show();
                          $('div#loaders_table_wrapper').hide();
                      }                  
              }else{
                  var in_resource_page = $('input#in_resources_page').val();
                      if(in_resource_page == 'yes')
                      {
                          $('div#packers_table_wrapper').hide();
                          $('div#loaders_table_wrapper').show();
                      }                  
              }
              
          }
      });
        
      $('.month_av').dropkick({
          
          change: function (value,label)
          {
              <?php
                    $worker_id_a = JRequest::getVar('worker_id');
                    $month_url = 'index.php/component/rednet/availabilitycalendar/component/rednet/?task=availability&current_month=';
                    if(isset($worker_id_a) && $worker_id_a!=NULL)
                    {
                        $month_url = 'index.php/component/rednet/availabilitycalendar/component/rednet/?task=availability&worker_id='.$worker_id_a.'&current_month=';                        
                    }
              ?>
             var server = "<?php echo JURI::base(); ?>";                          
         
             window.location = server+"<?php echo $month_url;?>"+value;                         
          }
      });
      
      $('.workers_list').dropkick({
          
          change: function (value,label)
          {
              if(value!='0')
              {
                  var server = "<?php echo JURI::base(); ?>"+"index.php/component/rednet/availabilitycalendar/?task=availability&worker_id="+value;                  
                      window.location = server;
              }
              
             
          }
      });
      
      $('.workers_list_on_clndr').dropkick({
          
          change: function (value,label)
          {
              if(value!='0')
              {
                  var server = "<?php echo JURI::base(); ?>"+"index.php/component/rednet/ordersoncalendar/?worker_id="+value; 
                  window.location = server;
              }
              
             
          }
      });
      
      $('.shirt_size').dropkick();
      $('.pant_leg').dropkick();
      $('.waist').dropkick();
      
      
    });




  </script>
                
<script>
    
    function init_vehicles_link(obj)
    {
        $(obj).click(function(){
                if($(obj).text() == 'Manage Vehicles')
                {                                        
                    var url = "<?php echo JUri::base()?>"+"index.php/component/rednet/fleet?task=manage_vehicles";                    
                    window.location = url;
                }
                
                
                if($(obj).text() == 'Manage Vehicles')
                {                                        
                    var url = "<?php echo JUri::base()?>"+"index.php/component/rednet/fleet?task=manage_vehicles";                    
                    window.location = url;
                }
                if($(obj).text() == 'Mmanage Ttrip Reports')
                {                                        
                    var url = "<?php echo JUri::base()?>"+"index.php/component/rednet/reportmaster";
                    window.location = url;
                }
                                    
                
        });
    }
    
		$(document).ready(function(){
                    
                    init_vehicles_link();
			// binds form submission and fields to the validation engine
                        
                        $('p#type_other').hide()
			$("#add_worker").validationEngine();
			$("#password_confirm_form").validationEngine();
			$("#worker_personal_info").validationEngine();
			$("#edit_worker_form").validationEngine();                        
			
                        
                    
                        $("#date_order").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }}); 
                    
                        $("#from").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }}); 
                    
                        $("#filter_date").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }}); 
                    
                        $("#to").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }}); 
                    
			$("#dob").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }});                         
			$("#start_date").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }});
                    
//			$(".time_field").mask("99:99 aa",{completed:function(){
//                                var date = $(this).val();
////                                var d_array =  date.split('/');                                
////                                 dateValidate(d_array);
//                            alert(date);
//                        }});
                    
			$(".time_field_two").mask("99:99",{completed:function(){
                               // var date = $(this).val();
//                                var d_array =  date.split('/');                                
//                                 dateValidate(d_array);                                 
                        }});                         
		});
                
                
                function dateValidate(d_array)
                {
                      if(d_array[0] > 12)
                                    {
                                      alert("Months exceeded. \nDate format is mm/dd/yyy");   
                                    }                                  
                                    if(d_array[1] > 31)
                                    {
                                      alert("Days exceeded. \nDate format is mm/dd/yyy");   
                                    }                                  
                                    if(d_array[2] > 2050)
                                    {
                                      alert("Years exceeded too much. \nDate format is mm/dd/yyy");   
                                    }  
                }
            
</script> 
                
                
<script>
	$(function() {
		$( "#dob" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/calendar.gif",
			
			buttonImageOnly: true
		});
	});
        
        
	$(function() {
		$( "#start_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/calendar.gif",
			
			buttonImageOnly: true
		});
	});
        
        
        
	$(function() {
		$( "#from" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/calendar.gif",
			
			buttonImageOnly: true
		});
	});
        
        
	$(function() {
		$( "#filter_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/calendar.gif",
			
			buttonImageOnly: true
		});
	});
        
        
        
        
	$(function() {
		$( "#to" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/calendar.gif",
			
			buttonImageOnly: true
		});
	});
        
        
        
</script>
                
<script type="text/javascript">


ddaccordion.init({
	headerclass: "expandable", //Shared CSS class name of headers group that are expandable
	contentclass: "categoryitems", //Shared CSS class name of contents group
	revealtype: "", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: false, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [w5], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
	onemustopen: true, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: false, //persist state of opened contents within browser session?
	toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
               //init_vehicles_link();
               //alert(headers);
               $(headers).each(function(i,obj){
                   
                       if($(obj).hasClass('openheader'))
                       {
                           //alert($(obj).text());
                           init_vehicles_link(obj);
                       }
                   
               });
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
                var currentIndex = index;
                
                    if(isuseractivated == true)
                    {
                        var server = "<?php echo JURI::base(); ?>";
                        
                            if(state == "block")
                            {                                                               
                                var option = $(header).text();
                               
                              
                                switch(option.toLowerCase())
                                {
                                    
                                    
                                    case "manage workers":
                                        window.location = server+"index.php/component/rednet/workerslist";
                                    break;
                                    
                                    case "manage vehicles":                                        
                                        window.location = server+"index.php/component/rednet/fleet?task=manage_vehicles";
                                    break;                                    
                                    
                                    case "manage trip reports":                                        
                                        window.location = server+"index.php/component/rednet/reportmaster";
                                    break;                                    
                                                                        
                                }
                            }
                            if(state == "none")
                            {
                               //window.location = server+"index.php";
                            }
                    }
	}
})


</script>
                
<script type="text/javascript">

function compare_passwords()
{
    var first,second;
    first = $("input[name=temp_pass]").val();
    second = $("input[name=new_pass]").val();
    
        if(first!=second)
        {
            alert("Passwords not matched.");
            
            if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
            else
                    return false;
                
        }
        
}

function personal_info_varification()
{    
           
         
          var home,cell;
    
        home = $("#home").val();
        cell = $("#cell").val();
         
            if(home.length < 1 && cell.length < 1)
            {
                alert("Please enter atleast \"Hom\" or \"Cell\"");
                if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
            }
            
          
            
            
         
                if($("select#class").val() == "")
                {
                    alert("Select \"Class\"");
                    
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                
                }
                
                
               
}
function add_worker_varification()
{       
    if(validateField($('#first_name'),"First Name")==false)
        return false;
    if(validateField($('#last_name'),"Last Name")==false)
        return false;      
    
    if(validateField($('#s_n2'),"S/N")==false)
        return false;
    
    if(validateField($('#dob'),"Date of birth")==false)
        return false;
    
    if(validateField($('#start_date'),"Start Date")==false)
        return false;
    
    if(validateField($('#dl_no2'),"DL#")==false)
        return false;
    
    if(validateField($('#email'),"Email")==false)
        return false;
            
    
    if(validateField($('#desired_shift'),"Desired Shift")==false)
        return false;
    
    
    var home,cell;
    
        home = $("#home").val();
        cell = $("#cell").val();
        
            if(home.length < 1 && cell.length < 1)
            {
                alert("Please enter atleast \"Hom\" or \"Cell\"");
                if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
            }
            
            if(role_error == true)
            {
                alert("You have selected a role multiple times.");
                if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
            }
            
            
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var address = $("#email").val();
            if(reg.test(address) == false) {
                alert(address + " is not a valid email.")
                if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
            }
            
            
            
           
            
                if($("select#class").val() == "")
                {
                    alert("Select \"Class\"");
                    
                    if(navigator.appName == "Microsoft Internet Explorer")
                        event.returnValue = false;
                    else
                        return false;
                }
               
                if($("select#myclass").val() == "")
                {
                    alert("Select \"Class\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                
                
                 
                if($("select#shirt_size").val() == "")
                {
                    alert("Select \"Shirt size\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                if($("select#pant_leg").val() == "")
                {
                    alert("Select \"Pant length\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                 
                if($("select#waist").val() == "")
                {
                    alert("Select \"waist\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                 
               
                 
                if($("select#primary_role").val() == 0)
                {
                    alert("Select \"Primary role\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                  
               
}

 
 
 
function edit_worker_varification()
{
    
    
    if(validateField($('#first_name'),"First Name")==false)
        return false;
    
     
     
    if(validateField($('#last_name'),"Last Name")==false)
        return false;
    
   
     
    if(validateField($('#s_n'),"S/N")==false)
        return false;
    
    
    
    if(validateField($('#dob'),"Date of birth")==false)
        return false;
    
    if(validateField($('#start_date'),"Start Date")==false)
        return false;
    
    if(validateField($('#dl_no2'),"DL#")==false)
        return false;
    
    if(validateField($('#email'),"Email")==false)
        return false;
            
    
    if(validateField($('#desired_shift'),"Desired Shift")==false)
        return false;
    
   
    var home,cell;
    
        home = $("#home").val();
        cell = $("#cell").val();
        
            if(home.length < 1 && cell.length < 1)
            {
                alert("Please enter atleast \"Hom\" or \"Cell\"");
                if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
            }
            
            if(role_error == true)
            {
                alert("You have selected a role multiple times.");
                if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
            }
            
            
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var address = $("#email").val();
            if(reg.test(address) == false) {
                alert(address + " is not a valid email.")
                if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
            }
            
            
            
           
            
                if($("select#class").val() == "")
                {
                    alert("Select \"Class\"");
                    
                    if(navigator.appName == "Microsoft Internet Explorer")
                        event.returnValue = false;
                    else
                        return false;
                }
               
                if($("select#myclass").val() == "")
                {
                    alert("Select \"Class\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                
                
                 
                if($("select#shirt_size").val() == "")
                {
                    alert("Select \"Shirt size\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                if($("select#pant_leg").val() == "")
                {
                    alert("Select \"Pant length\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                 
                if($("select#waist").val() == "")
                {
                    alert("Select \"waist\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                 
                if($("select#primary_role").val() == 0)
                {
                    alert("Select \"Primary role\"");
                    if(navigator.appName == "Microsoft Internet Explorer")
                    event.returnValue = false;
                else
                    return false;
                }
                
                 
               
}


                    function validateField(field,name)
                    {
                        
                        if(field.val().length < 1)
                        {
                            alert("Please enter \""+name+"\"");
                            return false;
                        }  
                    }
                    


</script>                

                <style type="text/css">

.arrowlistmenu{
width: 180px; /*width of accordion menu*/
}

.arrowlistmenu .menuheader{ /*CSS class for menu headers in general (expanding or not!)*/
font: bold 14px Arial;
color: white;
background: black url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/titlebar.png) repeat-x center left;
margin-bottom: 10px; /*bottom spacing between header and rest of content*/
text-transform: uppercase;
padding: 4px 0 4px 10px; /*header text is indented 10px*/
cursor: hand;
cursor: pointer;
}

.arrowlistmenu .openheader{ /*CSS class to apply to expandable header when it's expanded*/
background-image: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/titlebar-active.png);
}

.arrowlistmenu ul{ /*CSS for UL of each sub menu*/
list-style-type: none;
margin: 0;
padding: 0;
margin-bottom: 8px; /*bottom spacing between each UL and rest of content*/
}

.arrowlistmenu ul li{
padding-bottom: 2px; /*bottom spacing between menu items*/
}

.arrowlistmenu ul li a{
color: #A70303;
background: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/arrowbullet.png) no-repeat center left; /*custom bullet list image*/
display: block;
padding: 2px 0;
padding-left: 19px; /*link text is indented 19px*/
text-decoration: none;
font-weight: bold;
border-bottom: 1px solid #dadada;
font-size: 90%;
}

.arrowlistmenu ul li a:visited{
color: #A70303;
}

.arrowlistmenu ul li a:hover{ /*hover state CSS*/
color: #A70303;
background-color: #F3F3F3;
}

</style>
                
                <style type="text/css">
#apDiv1 {
	position:absolute;
	width:115px;
	height:115px;
	z-index:1;
	left: 125px;
	top: 0px;
}
#apDiv2 {
	position:absolute;
	width:115px;
	height:115px;
	z-index:1;
	left: 469px;
	top: 7px;
}
</style>    
                
                <script type="text/javascript">
                    $('document').ready(function(){
                        
                        $('input#jform_email').wrap('<div class="form_field_back input_shade"></div');
                                              
                       
                         $('img.ui-datepicker-trigger').height(20);
                         
                        
                    });
                    
                   
                </script>

	</head>
	<body>
            
                
                
<!-- ======================================================================== -->                


<div class="container">
  <div id="header" style="height:140px">
    
    <div id="apDiv1"><a href="./"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/firemenmovers_logo.png" alt="Insert Logo Here" id="Insert_logo2" /></a></div>
    <div id="apDiv2"><a href="./"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/heading.png" alt="Insert Logo Here" id="Insert_logo" /></a></div>
  </div>
  <div class="sidebar1">
      
      <?php 
            if ($userId != 0)
            {
         ?>
<jdoc:include type="modules" name="atomic-login-position" style="sidebar" />                            
      <?php } ?>

<br />
 <?php
 
                                
                                
                                 if ($userId != 0 && $user_group_name != NULL)
                                 {
                                  
                                     
                                     if($user_group_name == 'admin')
                                     {
                                         
                                         $worker = getWorkerById($userId);
                                                if((isset($worker->verified_status) && $worker->verified_status == 1) && $worker->status == 1)
                                                {
                                                    echo  '<jdoc:include type="modules" name="admin-menu-position" style="none" />';                                          
                                                }
                                                if($worker->verified_status == NULL)
                                                {
                                                    echo  '<jdoc:include type="modules" name="admin-menu-position" style="none" />';                                          
                                                }
                                                if(isset($worker->status) && $worker->status == 0)
                                                {
                                                    echo  $active_msg;
                                                }
                                                
                                     }  else {
                                         $crnt_role =   getWorkersRoles($userId);
                                         
                                         
                                         
                                                $worker = getWorkerById($userId);
                                                
                                                if((isset($worker->verified_status) && $worker->verified_status == 1) && $worker->status == 1)
                                                {
                                                    if($crnt_role == 'crew')
                                                    {
                                                        echo  '<jdoc:include type="modules" name="crewoffice-menu-position" style="none" />';
                                                    }
                                                    if($crnt_role == 'loader')
                                                    {
                                                        echo  '<jdoc:include type="modules" name="loader-menu-position" style="none" />';
                                                    }
                                                }
                                                
                                                if(isset($worker->status) && $worker->status == 0)
                                                {
                                                    echo  $active_msg;
                                                }
                                     }
                                     
                                     /*
                                          switch ($user_group_name)
                                        {
                                            case 'admin':
                                                $worker = getWorkerById($userId);
                                                if((isset($worker->verified_status) && $worker->verified_status == 1) && $worker->status == 1)
                                                {
                                                    echo  '<jdoc:include type="modules" name="admin-menu-position" style="none" />';                                          
                                                }
                                                if($worker->verified_status == NULL)
                                                {
                                                    echo  '<jdoc:include type="modules" name="admin-menu-position" style="none" />';                                          
                                                }
                                                if(isset($worker->status) && $worker->status == 0)
                                                {
                                                    echo  $active_msg;
                                                }
                                                
                                              
                                            break;
                                        
                                            case 'crew_office':
                                                echo  '<jdoc:include type="modules" name="crewoffice-menu-position" style="none" />';                                          
                                            break;
                                        
                                            case 'loader':          
                                                //echo "i m loader..";
                                                $worker = getWorkerById($userId);
                                                
                                                if((isset($worker->verified_status) && $worker->verified_status == 1) && $worker->status == 1)
                                                {
                                                    echo  '<jdoc:include type="modules" name="loader-menu-position" style="none" />';
                                                }
                                                
                                                if(isset($worker->status) && $worker->status == 0)
                                                {
                                                    echo  $active_msg;
                                                }
                                                
                                            break;
                                        }  
                                 
                                      * 
                                      */
                                }               
                                ?>

<!--<div class="arrowlistmenu">

<h3 class="menuheader">View Orders</h3>
<div></div>

<h3 class="menuheader">Enter Orders</h3>
<div></div>

<h3 class="menuheader expandable">Manage Workers</h3>
<ul class="categoryitems">
<li><a href="#">Add Worker</a></li>
<li><a href="#">View/Edit/Delete Worker(s)</a></li>
</ul>
<h3 class="menuheader expandable">Manage Trucks</h3>
<ul class="categoryitems">
<li><a href="#">Add Truck</a></li>
<li><a href="#">View/Edit/Delete Truck(s)</a></li>
</ul>

<h3 class="menuheader expandable">Manage Trip Reports</h3>
<ul class="categoryitems">
<li><a href="#">Enter Trip Report</a></li>
<li><a href="#">Review Trip Report</a></li>
</ul>

<h3 class="menuheader">Update Availability</h3>
<div></div>
<h3 class="menuheader">Update Personal Information</h3>
<div></div>
<h3 class="menuheader">Change Password</h3>
<div></div>


</div>-->

  </div>
  <div class="content">
   
   
        
        
       
		
			<?php if($this->countModules('atomic-search') or $this->countModules('position-0')) : ?>
		
	  	 			<jdoc:include type="modules" name="atomic-search" style="none" />
	  	 			<jdoc:include type="modules" name="position-0" style="none" />
		
			<?php endif; ?>

		<?php if($this->countModules('atomic-topmenu') or $this->countModules('position-2') ) : ?>
			<jdoc:include type="modules" name="atomic-topmenu" style="container" />
			<jdoc:include type="modules" name="position-1" style="container" />
		<?php endif; ?>

			<?php if($this->countModules('atomic-topquote') or $this->countModules('position-15') ) : ?>
				<jdoc:include type="modules" name="atomic-topquote" style="none" />
				<jdoc:include type="modules" name="position-15" style="none" />

			<?php endif; ?>
				<jdoc:include type="message" />
                                
                               
				<jdoc:include type="component" />
			
                                
                                <?php
                                                       
                                     
                                ?>
			<?php if($this->countModules('atomic-bottomleft') or $this->countModules('position-11')) : ?>

					<jdoc:include type="modules" name="atomic-bottomleft" style="bottommodule" />
					<jdoc:include type="modules" name="position-11" style="bottommodule" />
                                        

	        <?php endif; ?>

	        <?php if($this->countModules('atomic-bottommiddle') or $this->countModules('position-9')
				or $this->countModules('position-10')) : ?>

	        		<jdoc:include type="modules" name="atomic-bottommiddle" style="bottommodule" />
					<jdoc:include type="modules" name="position-9" style="bottommodule" />
					<jdoc:include type="modules" name="position-10" style="bottommodule" />

				
			<?php endif; ?>

			<?php if($this->countModules('atomic-sidebar') || $this->countModules('position-7')
			|| $this->countModules('position-4') || $this->countModules('position-5')
			|| $this->countModules('position-3') || $this->countModules('position-6') || $this->countModules('position-8'))
			: ?>
					<jdoc:include type="modules" name="atomic-sidebar" style="sidebar" />
					
					<jdoc:include type="modules" name="position-4" style="sidebar" />
					<jdoc:include type="modules" name="position-5" style="sidebar" />
					<jdoc:include type="modules" name="position-6" style="sidebar" />
					<jdoc:include type="modules" name="position-8" style="sidebar" />
					<jdoc:include type="modules" name="position-3" style="sidebar" />

			<?php endif; ?>

		
		<jdoc:include type="modules" name="debug" />
        
                
                
        
        
        
        
      
    
   
    
  <!-- end .content --></div>
  
  </div>


  <aside></aside>
  
  <!-- end .container --></div>
<!--
<div id="footer" style="border:0px solid #00F;height:60px;">
    <p style="text-align:center;window-shadow:500px;font-size:12px;color:#FFFFFF;margin-top:25px;font-weight:bold">Design and developed by Turnkey Solutions</p>
    
    <p style="text-align:center;window-shadow:500px;font-size:12px;color:#FFFFFF;margin-top:0px;line-height:1px;">
    Phone number: (647) 377-4657 and E-mail: info@turnkey-solutions.net
    </p>
    
   
  </div>-->


	</body>
  
</html>



  
    <?php
        function getWorkerById($user_id)
        {
           
            $db = JFactory::getDbo();
            
            //$query = "DELETE FROM #__users WHERE id IN($user_id)";            
            
            $query = "
            Select
  #__users.id,
  #__users.name,
  #__users.username,  
  #__workers.first_name,
  #__workers.user_id,
  #__workers.last_name,
  #__workers.s_n,
  #__workers.dob,
  #__workers.start_date,
  #__workers.dl_no,
  #__workers.class,
  #__workers.status,
  #__workers.email,
  #__workers.cell,
  #__workers.home,
  #__workers.shirt_size,
  #__workers.pant_leg,
  #__workers.waist,
  #__workers.receive_update_by,
  #__workers.desired_shift,
  #__workers.created_by,
  #__workers.created_date,
  #__workers.updated_by,
  #__workers.updated_date,
  #__workers.active_status,
  #__workers.verified_status,
  #__fua_userindex.id As fua_id,
  #__fua_userindex.user_id As user_id1,
  #__fua_userindex.group_id
From
  #__users Inner Join
  #__workers On #__users.id = #__workers.user_id
  Inner Join
  #__fua_userindex
    On #__users.id = #__fua_userindex.user_id
Where
  #__users.id = $user_id And
  #__workers.user_id = #__users.id And
  #__fua_userindex.user_id = #__users.id

            ";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $worker = $db->loadObject();
            
            return $worker;
        }
?>
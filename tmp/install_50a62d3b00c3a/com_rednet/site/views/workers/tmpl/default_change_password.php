<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();

?>


<h3 style="margin-left: 140px;">Change Password</h3>

<div class="form_wrapper" style="margin-left: 140px !important;">
    
     <div class="form_slides form_slide_left">
     
     </div>
     <div class="form_slides form_slide_middle">

         <form action="<?php echo JRoute::_('index.php?option=com_rednet&task=change_password&view=workers'); ?>" id="password_confirm_form" method="post" onsubmit="return compare_passwords();">

                    <table border="0" class="form_table" width="70%">
                        
				
		
                                    <tr>
                                        <td>
                                            
                                            <span class="form_label">
<label id="username-lbl" class="" for="username">Enter new password</label>
</span>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div class="form_field_back">
                                                <input class="form_field validate[required]" name="temp_pass" type="password" />
                                        </div>

                                        </td>
                                    </tr>

                             
                                    <tr>
                                        <td>
                                            
                                            <span class="form_label">
<label id="username-lbl" class="" for="username">Re-enter new Password</label>
</span>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div class="form_field_back">
                                                <input class="form_field validate[required]" name="new_pass" type="password" />
                                        </div>

                                        </td>
                                    </tr>

                             
                        
                                    <tr>
                                        <td>
                                            <span class="form_label" style="font-size:  12px !important">
			
				
			
			
                                            </span>
                                        </td>
                                    </tr>
                
                                    <tr>
                                        <td>
                                            
                                            <input type="submit" tabindex="25" name="save" value="Submit">
                
                                        </td>
                                    </tr>
                    </table>
					
					
		    
                
                </form>
     
     </div>
     
     <div class="form_slides form_slide_right">
     <?php
     $app = JFactory::getApplication();
     ?>
         <p class="login_upper_link_p">
         </p>
       
     </div>
     </div>
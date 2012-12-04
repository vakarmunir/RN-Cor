<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();

$primary_roles = $this->primary_roles;
$secondary_roles = $this->secondary_roles;
$additional_roles = $this->additional_roles;

$form_data = $this->form_data;

?>

<?php 
        if(isset($this->msg)):
?>    
        <p>        
                <?php echo $this->msg; ?>
        </p>
<?php    endif; ?>

<div>
    <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/group_labor.gif" alt="logo" id="lock_icon" width="60" /></td>
            <td><h4>Add Worker</h4></td>
        </tr>
    </table>
    
</div>

<jdoc:include type="message" />

<div class="form_wrapper_app">
    <div class="mainform_left"></div>	
    <div class="mainform_middle">	        

        <form id="add_worker" action="index.php?option=com_rednet&task=add_worker_submit&view=workers" method="post" onsubmit="return add_worker_varification();">

    <div class="mainform_warpper">
    
<table width="100%" border="0">
  <tr>
    <td>
        <p class="field_para"><label for="first_name">First Name</label>
      <input class="main_forms_field validate[required]" type="text" name="first_name" id="first_name" value="<?php echo (isset($form_data['first_name']))?($form_data['first_name']):("") ?>" tabindex="1" />      <label for="fist_name"></label>
        </p>
    </td>
    <td><p class="field_para"><label for="last_name">Last Name</label>
      <input name="last_name" type="text" class="main_forms_field validate[required]" id="last_name" tabindex="2" value="<?php echo (isset($form_data['last_name']))?($form_data['last_name']):("") ?>" /></p></td>
    <td><p class="field_para">
      <label for="initial">Initial</label>
      <input name="initial" type="text" class="main_forms_field" id="initial" tabindex="3" value="<?php echo (isset($form_data['initial']))?($form_data['initial']):("") ?>">
    </p></td>
    </tr>
  <tr>
    <td><p class="field_para">
      <label for="s_n2">S/N</label>
      <input name="s_n" type="text" class="main_forms_field validate[required]" id="s_n2" tabindex="4" value="<?php echo (isset($form_data['s_n']))?($form_data['s_n']):("") ?>" />
    </p></td>
    <td><p class="field_para">
      <label for="dob">Date of Birth (mm/dd/yyyy)</label>
      <input name="dob" type="text" class="main_forms_field_date validate[required]" id="dob" tabindex="5" value="<?php echo (isset($form_data['dob']))?($form_data['dob']):("") ?>" />
    </p></td>
    <td><p class="field_para">
      <label for="start_date">Start Date (mm/dd/yyyy)</label>
      <input name="start_date" type="text" class="main_forms_field_date validate[required]" id="start_date" tabindex="6" value="<?php echo (isset($form_data['start_date']))?($form_data['start_date']):("") ?>" />
    </p></td>
    </tr>
  <tr>
    <td><p class="field_para">
      <label for="dl_no2">DL#</label>
      <input name="dl_no" type="text" class="main_forms_field validate[required]" id="dl_no2" tabindex="7" value="<?php echo (isset($form_data['dl_no']))?($form_data['dl_no']):("") ?>" />
    </p></td>
    <td><p class="field_para">
      <label for="class2">Class</label>              
      <select name ="class" id ="class" class ="myclass" style="width: 130px;margin-left: 100px!important;border: 1px solid !important" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="G" <?php echo (isset($form_data['class']) && $form_data['class']=='G')?("selected=selected"):("") ?>>G</option>
        <option value="AZ" <?php echo (isset($form_data['class']) && $form_data['class']=='AZ')?("selected=selected"):("") ?>>AZ</option>
        <option value="DZ" <?php echo (isset($form_data['class']) && $form_data['class']=='DZ')?("selected=selected"):("") ?>>DZ</option>
        <option value="None" <?php echo (isset($form_data['class']) && $form_data['class']=='None')?("selected=selected"):("") ?>>None</option>
      </select>
      
      
    <td><p class="field_para">
      <label for="status">Status</label>
      <select name ="status" id ="status" class ="status" style="width: 130px;" tabindex="9">
        <option value="1">Active</option>
        <option value="0">In-active</option>
      </select>
    </p></td>
    </tr>
  <tr>
    <td><p class="field_para"><label for="email">Email</label>
      <input name="email" type="text" class="main_forms_field validate[required]" id="email" tabindex="10" /></p></td>
    <td><p class="field_para">
        
        <label for="cell">Cell</label>
      <input name="cell" type="text" class="main_forms_field" id="cell" tabindex="11" value="<?php echo (isset($form_data['cell']))?($form_data['cell']):("") ?>" />
    
    </p></td>
    <td><p class="field_para"><label for="home">Home</label>
      <input name="home" type="text" class="main_forms_field" id="home" tabindex="12" value="<?php echo (isset($form_data['home']))?($form_data['home']):("") ?>" /></p></td>
  </tr>
  <tr>
    <td><p class="field_para"><label for="shirt_size">Shirt Size</label>
      
            
            
            
       <select name ="shirt_size" id ="shirt_size" class ="shirt_size" style="width: 130px;margin-left: 100px!important;border: 1px solid !important" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="S" <?php echo (isset($form_data['shirt_size']) && $form_data['shirt_size']=='G')?("selected=selected"):("") ?>>S</option>
        <option value="M" <?php echo (isset($form_data['shirt_size']) && $form_data['shirt_size']=='M')?("selected=selected"):("") ?>>M</option>
        <option value="L" <?php echo (isset($form_data['shirt_size']) && $form_data['shirt_size']=='L')?("selected=selected"):("") ?>>L</option>
        <option value="XL" <?php echo (isset($form_data['shirt_size']) && $form_data['shirt_size']=='XL')?("selected=selected"):("") ?>>XL</option>
        <option value="XXL" <?php echo (isset($form_data['shirt_size']) && $form_data['shirt_size']=='XXL')?("selected=selected"):("") ?>>XXL</option>
      </select>            

        
        </p></td>
    <td><p class="field_para"><label for="pant_leg">Pant Length</label>
    
            
        <select name ="pant_leg" id ="pant_leg" class ="pant_leg" style="width: 130px;margin-left: 100px!important;border: 1px solid !important" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="30" <?php echo (isset($form_data['pant_leg']) && $form_data['pant_leg']=='30')?("selected=selected"):("") ?>>30</option>
        <option value="32" <?php echo (isset($form_data['pant_leg']) && $form_data['pant_leg']=='32')?("selected=selected"):("") ?>>32</option>
        <option value="34" <?php echo (isset($form_data['pant_leg']) && $form_data['pant_leg']=='34')?("selected=selected"):("") ?>>34</option>
        <option value="36" <?php echo (isset($form_data['pant_leg']) && $form_data['pant_leg']=='36')?("selected=selected"):("") ?>>36</option>
      </select>            

        </p></td>
    <td><p class="field_para"><label for="waist">Waist</label>      
        
       <select name ="waist" id ="waist" class ="waist" style="width: 130px;margin-left: 100px!important;border: 1px solid !important" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="30" <?php echo (isset($form_data['waist']) && $form_data['waist']=='28')?("selected=selected"):("") ?>>28</option>
        <option value="30" <?php echo (isset($form_data['waist']) && $form_data['waist']=='30')?("selected=selected"):("") ?>>30</option>
        <option value="32" <?php echo (isset($form_data['waist']) && $form_data['waist']=='32')?("selected=selected"):("") ?>>32</option>
        <option value="34" <?php echo (isset($form_data['waist']) && $form_data['waist']=='34')?("selected=selected"):("") ?>>34</option>
        <option value="36" <?php echo (isset($form_data['waist']) && $form_data['waist']=='36')?("selected=selected"):("") ?>>36</option>
        <option value="38" <?php echo (isset($form_data['waist']) && $form_data['waist']=='38')?("selected=selected"):("") ?>>38</option>
        <option value="40" <?php echo (isset($form_data['waist']) && $form_data['waist']=='40')?("selected=selected"):("") ?>>40</option>        
      </select>            


        
        </p></td>
  </tr>
  <tr>
    <td><p class="field_para"><label for="receive_update_by">Receive update by</label></p></td>
    <td colspan="2"><p>
      <label>
        <input disabled="disabled" type="checkbox" name="receive_update_by" value="text" id="receive_update_by_0" tabindex="16" />
        text</label>
      
      <label>
        <input disabled="disabled" type="checkbox" name="receive_update_by" value="email" id="receive_update_by_1" tabindex="17" />
        email</label>
      
      <label>
        <input disabled="disabled" type="checkbox" name="receive_update_by" value="both" id="receive_update_by_2" tabindex="18" />
        both</label>
      
    </p></p></td>
    </tr>
  <tr>
    <td><p class="field_para"><label for="desired_shift">Desired shift per month</label>
            <input class="main_forms_field validate[required]" type="text" name="desired_shift" value="<?php echo (isset($form_data['desired_shift']))?($form_data['desired_shift']):("") ?>" id="desired_shift" tabindex="19" /></p></td>
    <td><p class="field_para">&nbsp;</p></td>
    <td><p class="field_para">&nbsp;</p></td>
  </tr>
  </table>
        </div>
        <br />
        
        <div class="role_wrapper">
<table width="100%" border="0">
  <tr>
      <td><p class="field_para"><strong>Role</strong></p></td>
      <td><p class="field_para"><strong>Wage/hr</strong></p></td>
    </tr>
  <tr>
    <td><p class="field_para"><label for="primary_role">Primary Role</label>
      <select name="primary_role" id="primary_role" class="primary_role" style="width: 135px !important" tabindex="19">
          <option value="" class="validate[required]">-- Select --</option>
          <?php
            foreach($primary_roles as $pr):
          ?>
          <option value="<?php echo $pr->id;?>" <?php echo (isset($form_data['primary_role']) && $form_data['primary_role']==$pr->id)?("selected=selected"):("") ?>><?php echo $pr->name;?></option>
          <?php
            endforeach;
          ?>
      </select>
        
            <input type="hidden" name="primary_role_hidden_name" id="primary_role_hidden_name" value="<?php echo (isset($form_data['primary_role_hidden_name']))?($form_data['primary_role_hidden_name']):("") ?>" />
            
        </p></td>
      <td><p class="field_para"><input name="wage_hr_primary" type="text" class="main_forms_field validate[required]" id="wage_hr_primary" tabindex="20" value="<?php echo (isset($form_data['wage_hr_primary']))?($form_data['wage_hr_primary']):("") ?>" /></p></td>
    </tr>
  <tr>
    <td><p class="field_para"><label for="secondary_role">Secondary Role</label>
      <select name="secondary_role" id="secondary_role" class="secondary_role" style="width: 150px !important" tabindex="21">
          <option value="0">-- Select --</option>
          <?php
            foreach($secondary_roles as $sr):
          ?>
          <option value="<?php echo $sr->id;?>" <?php echo (isset($form_data['secondary_role']) && $form_data['secondary_role']==$sr->id)?("selected=selected"):("") ?>><?php echo $sr->name;?></option>
          <?php
            endforeach;
          ?>
          
          
      </select>
            <input type="hidden" name="secondary_role_hidden_name" id="secondary_role_hidden_name" value="<?php echo (isset($form_data['secondary_role_hidden_name']))?($form_data['secondary_role_hidden_name']):("") ?>" />
        </p></td>
    <td><p class="field_para"><input name="wage_hr_secondary" type="text" class="main_forms_field" id="wage_hr_secondary" tabindex="22" value="<?php echo (isset($form_data['wage_hr_secondary']))?($form_data['wage_hr_secondary']):("") ?>" /></p></td>
    </tr>
  <tr>
    <td><p class="field_para"><label for="additional_role">Additional Role</label>
      <select name="additional_role" id="additional_role" class="additional_role" style="width: 150px !important" tabindex="23">
          <option value="0">-- Select --</option>
            <?php
            foreach($additional_roles as $ar):
          ?>
          <option value="<?php echo $ar->id;?>" <?php echo (isset($form_data['additional_role']) && $form_data['additional_role']==$ar->id)?("selected=selected"):("") ?>><?php echo $ar->name;?></option>
          <?php
            endforeach;
          ?>
          
      </select>
            <input type="hidden" name="additional_role_hidden_name" id="additional_role_hidden_name" value="<?php echo (isset($form_data['additional_role_hidden_name']))?($form_data['additional_role_hidden_name']):("") ?>" />
        </p></td>
    <td><p class="field_para"><input name="wage_hr_additional" type="text" class="main_forms_field" id="wage_hr_additional" tabindex="24" value="<?php echo (isset($form_data['wage_hr_additional']))?($form_data['wage_hr_additional']):("") ?>" /></p></td>
  </tr>
</table>
        </div>
<p><input type="submit" value="Save" name="save" tabindex="25" /></p>
</form>
    
        </div>
  <div class="mainform_left"></div>	  
</div>


   
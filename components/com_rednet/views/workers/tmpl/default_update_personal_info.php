<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();

$worker = $this->worker;

$primary_roles = $this->primary_roles;
$secondary_roles = $this->secondary_roles;
$additional_roles = $this->additional_roles;

$worker_roles = $this->worker_roles;


?>

<h3>Update personal information</h3>

<form id="worker_personal_info" action="<?php echo JRoute::_("index.php?option=com_rednet&task=update_personal_info_save&view=workers")?>" method="post" onSubmit="return personal_info_varification();">

<div class="form_wrapper_app">
    <div class="mainform_left"></div>	
    <div class="mainform_middle">	        

        

    <div class="mainform_warpper">

        
<table width="100%" border="0">
  <tr>
    <td><p class="field_para"><label for="first_name">First Name</label>
      <input class="main_forms_field validate[required]" type="text" name="first_name" id="first_name" value="<?php echo $worker->first_name;?>" tabindex="1" />      <label for="fist_name"></label></p></td>
    <td><p class="field_para"><label for="last_name">Last Name</label>
      <input name="last_name" type="text" class="main_forms_field validate[required]" id="last_name" tabindex="2" value="<?php echo $worker->last_name;?>" /></p></td>
    <td><p class="field_para">
      <label for="initial">Initial</label>
      <input name="initial" type="text" class="main_forms_field" id="initial" tabindex="3" value="<?php echo $worker->initial;?>" />
    </p></td>
    </tr>
  <tr>
    <td><p class="field_para">
      <label for="s_n2">S/N</label>
      <input name="s_n" type="text" class="main_forms_field validate[required]" id="s_n2" tabindex="4" value="<?php echo $worker->s_n;?>" />
    </p></td>
    <td><p class="field_para">
      <label for="dob">Date of Birth</label>
      <input name="dob" type="text" class="main_forms_field_date validate[required]" id="dob" tabindex="5" value="<?php echo date("m/d/Y",strtotime($worker->dob));?>" />
    </p></td>
    <td><p class="field_para">
      <label for="start_date">Start Date</label>
      <input name="start_date" type="text" class="main_forms_field_date validate[required]" id="start_date" tabindex="6" value="<?php echo date("m/d/Y",strtotime($worker->start_date));?>" />
    </p></td>
    </tr>
  <tr>
    <td><p class="field_para">
      <label for="dl_no2">DL#</label>
      <input name="dl_no" type="text" class="main_forms_field validate[required]" id="dl_no2" tabindex="7" value="<?php echo $worker->dl_no;?>" />
    </p></td>
    <td><p class="field_para">
      <label for="cell">Cell</label>
      <input name="cell" type="text" class="main_forms_field" id="cell" tabindex="11" value="<?php echo $worker->cell;?>" />
    <td><p class="field_para">
      <label for="home3">Home</label>
      <input name="home" type="text" class="main_forms_field" id="home" tabindex="12" value="<?php echo $worker->home;?>" />
    </p></td>
    </tr>
  <tr>
    <td><p class="field_para">
            
      <label for="shirt_size3">Shirt Size</label>
      
      
      
       <select name ="shirt_size" id ="shirt_size" class ="shirt_size" style="width: 130px;margin-left: 100px!important;border: 1px solid !important;" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="S" <?php echo (isset($worker->shirt_size) && $worker->shirt_size=='S')?("selected=selected"):("") ?>>S</option>
        <option value="M" <?php echo (isset($worker->shirt_size) && $worker->shirt_size=='M')?("selected=selected"):("") ?>>M</option>
        <option value="L" <?php echo (isset($worker->shirt_size) && $worker->shirt_size=='L')?("selected=selected"):("") ?>>L</option>
        <option value="XL" <?php echo (isset($worker->shirt_size) && $worker->shirt_size=='XL')?("selected=selected"):("") ?>>XL</option>
        <option value="XXL" <?php echo (isset($worker->shirt_size) && $worker->shirt_size=='XXL')?("selected=selected"):("") ?>>XXL</option>
      </select>    
      
      </p></td>
    <td><p class="field_para">
      <label for="pant_leg3">Pant Length</label>
      
      <select name ="pant_leg" id ="pant_leg" class ="pant_leg" style="width: 130px;margin-left: 100px!important;border: 1px solid !important" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="30" <?php echo (isset($worker->pant_leg) && $worker->pant_leg=='30')?("selected=selected"):("") ?>>30</option>
        <option value="32" <?php echo (isset($worker->pant_leg) && $worker->pant_leg=='32')?("selected=selected"):("") ?>>32</option>
        <option value="34" <?php echo (isset($worker->pant_leg) && $worker->pant_leg=='34')?("selected=selected"):("") ?>>34</option>
        <option value="36" <?php echo (isset($worker->pant_leg) && $worker->pant_leg=='36')?("selected=selected"):("") ?>>36</option>
      </select>   
       
      
      </p></td>
    <td><p class="field_para">
      <label for="waist2">Waist</label>
      
        <select name ="waist" id ="waist" class ="waist" style="width: 130px;margin-left: 100px!important;border: 1px solid !important" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="28" <?php echo (isset($worker->waist) && $worker->waist=='28')?("selected=selected"):("") ?>>28</option>
        <option value="30" <?php echo (isset($worker->waist) && $worker->waist=='30')?("selected=selected"):("") ?>>30</option>
        <option value="32" <?php echo (isset($worker->waist) && $worker->waist=='32')?("selected=selected"):("") ?>>32</option>
        <option value="34" <?php echo (isset($worker->waist) && $worker->waist=='34')?("selected=selected"):("") ?>>34</option>
        <option value="36" <?php echo (isset($worker->waist) && $worker->waist=='36')?("selected=selected"):("") ?>>36</option>
        <option value="38" <?php echo (isset($worker->waist) && $worker->waist=='38')?("selected=selected"):("") ?>>38</option>
        <option value="40" <?php echo (isset($worker->waist) && $worker->waist=='40')?("selected=selected"):("") ?>>40</option>        
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
            <input class="main_forms_field validate[required]" type="text" name="desired_shift" value="<?php echo $worker->desired_shift;?>" id="desired_shift" tabindex="19" /></p></td>
    <td><p class="field_para">
      <label for="class3">Class</label>
      <select name ="class" id ="class" class ="myclass" style="width: 130px;" tabindex="8">
        <option value=""> -- Select -- </option>
        <option value="G" <?php echo (isset($worker->class) && $worker->class=='G')?("selected=selected"):("") ?>>G</option>
        <option value="AZ" <?php echo (isset($worker->class) && $worker->class=='AZ')?("selected=selected"):("") ?>>AZ</option>
        <option value="DZ" <?php echo (isset($worker->class) && $worker->class=='DZ')?("selected=selected"):("") ?>>DZ</option>
        <option value="None" <?php echo (isset($worker->class) && $worker->class=='None')?("selected=selected"):("") ?>>None</option>
      </select>
    </p></td>
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
            <select name="primary_role" id="primary_rolex" class="primary_rolex" style="width: 150px;display: none">
          <option value="0">-- Select --</option>
          <?php
          
          $pr_name = "";
            foreach($primary_roles as $pr):
                foreach($worker_roles as $wr)
                {
                    if($wr->type == 'primary')
                    {
                        $wage_hr = $wr->wage_hr;
                        
                        if($wr->id == $pr->id)
                        {
                            $selected_string_p = "selected=selected";
                            $pr_name = $pr->name;
                        }
                        else
                        {
                            $selected_string_p = "";
                        }
                    }
                }
          ?>
          <option <?php echo $selected_string_p;?> value="<?php echo $pr->id;?>"><?php echo $pr->name;?></option>
          <?php
            endforeach;
          ?>
      </select>
        
            <input class="main_forms_field" disabled="disabled" type="text" name="primary_role_hidden_name" id="primary_role_hidden_name" value="<?php echo (isset($pr_name))?($pr_name):("") ?>" />
        </p></td>
      <td><p class="field_para">
              <label for="primary_role">...</label>
              <input type="text" disabled="disabled" class="main_forms_field" name="wage_hr_primary" id="wage_hr_primary" value="<?php echo $wage_hr;?>" />
              <label for="primary_role"></label>
          </p></td>
    </tr>
  <tr>
    <td><p class="field_para"><label for="secondary_role">Secondary Role</label>
      <select name="secondary_rolex" id="secondary_rolex" class="secondary_rolex" style="width: 150px;display: none">
          
         
          <option value="0">-- Select --</option>
          <?php
          $sr_name = "";
            foreach($secondary_roles as $sr):
                
                foreach($worker_roles as $wr)
                {
                    if($wr->type == 'secondary')
                    {                                                
                        if($wr->id == $sr->id)
                        {
                            $selected_string_s = "selected=selected";
                            $wage_hr_s = $wr->wage_hr;
                            $sr_name = $sr->name;
                        }
                        else{
                            $selected_string_s = "";
                        }
                    }
                }
          ?>
          <option <?php echo $selected_string_s;?> value="<?php echo $sr->id;?>"><?php echo $sr->name;?></option>
          <?php
            endforeach;
          ?>
          
          
      </select>
        
            <input type="text" disabled="disabled" class="main_forms_field" name="secondary_role_hidden_name" id="secondary_role_hidden_name" value="<?php echo (isset($sr_name))?($sr_name):("") ?>" />
        
        </p></td>
    <td><p class="field_para">
                <label for="primary_role">...</label>
            <input type="text" disabled="disabled" class="main_forms_field" name="wage_hr_secondary" id="wage_hr_secondary" value="<?php echo $wage_hr_s;?>" />
           <label for="primary_role"></label>
        </p></td>
    </tr>
  <tr>
    <td><p class="field_para"><label for="additional_role">Additional Role</label>
      <select name="additional_rolex" id="additional_rolex" class="additional_rolex" style="width: 150px;display:none">
          <option value="0">-- Select --</option>
            <?php
            $ar_name = "";
            foreach($additional_roles as $ar):
               
                foreach($worker_roles as $wr)
                {
                    if($wr->type == 'additional')
                    {                                                
                        if($wr->id == $ar->id)
                        {
                            $selected_string_a = "selected=selected";
                            $wage_hr_a = $wr->wage_hr;
                            $ar_name = $ar->name;
                        }
                        else{
                            $selected_string_a = "";
                        }
                    }
                }
          ?>
          <option <?php echo $selected_string_a;?> value="<?php echo $ar->id;?>"><?php echo $ar->name;?></option>
          <?php
            endforeach;
          ?>
          
      </select>
        
            <input type="text" disabled="disabled" class="main_forms_field" name="additional_role_hidden_name" id="additional_role_hidden_name" value="<?php echo (isset($ar_name))?($ar_name):("") ?>" />
                    
        </p></td>
    <td>
        <p class="field_para">
        <label for="primary_role">...</label>
        <input type="text" disabled="disabled" class="main_forms_field" name="wage_hr_additional" id="wage_hr_additional" value="<?php echo $wage_hr_a;?>" />
        <label for="primary_role"></label>
        </p></td>
  </tr>
</table>
        
            </div>
        
<p><input type="submit" value="Save" name="save" tabindex="25" /></p>    
        </div>
  <div class="mainform_left"></div>	  
</div>
    
    
    </form>


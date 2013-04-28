<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();



$primary_roles = $this->primary_roles;
$secondary_roles = $this->secondary_roles;
$additional_roles = $this->additional_roles;
$form_data = $this->form_data;
$data = $this->data;
$workers = $data['workers'];
//var_dump($workers);

$order = $data['order'];
$reportmaster = $data['reportmaster'];
$reportclients = $data['reportclients'];
$reportdetail = $data['reportdetail'];
$un_approve = $data['un_approve'];

$mode = (isset($reportmaster))?('edit'):('add');

?>


        
<style>

    .comments_class
    {
        display: none;
    }
    div#dialog-form-user-search
    {
        font-size: 80.5%;
    }
    
    div#dialog-form-user-search h1,h2,h3,span
    {
        font-size: 80.5%;
    }
    
  
select#dialog-form-user-search-username-list,select#dialog-form-user-search-role-list{
    display: inline-block;
    padding: 4px 3px 5px 5px;
    width: 175px;
    outline: none;
    color: #74646e;
    border: 1px solid #C8BFC4;
    border-radius: 4px;
    box-shadow: inset 1px 1px 2px #ddd8dc;
    background-color: #fff;        
}


        .dialog-form-user-search-username-list,select#dialog-form-user-search-role-list
        {
            position: inherit !important;            
            visibility: visible !important;
        }
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
        
        .grid_anchor:hover
        {
            cursor: pointer;
        }
        .grid_anchor
        {
            cursor: pointer;
            text-decoration: underline;
        }
        
        .report-order-search-click:hover{
            cursor: pointer !important;
        }
        .report-order-search-click{
            color: black !important;
        }
    </style>

    
<?php 
        if(isset($this->msg)):
?>    
        <p>        
                <?php echo $this->msg; ?>
        </p>
<?php    endif; ?>


        
        <style type="text/css">
            .loading_div{
                margin-left: 5px;                
        }
        .loading_div img{
            width: 15px !important;
        }
        
        #warning
        {
            border: 1px solid red;
            padding: 5px;
            background-color: pink;
            color: red;
            font-size: 12px;
            width: 300px;
            margin-left: 25px;
            margin-bottom: 10px;
            
        }
        .line_wrapp
        {
            height: 40px;
        }
        </style>




       
        <script type="text/javascript">
            $("document").ready(function(){
                $(".nvgta").click(function(){
                    
                    var server = "<?php echo JURI::base(); ?>";                                   
                    window.location = server+"index.php/component/rednet/reportmaster";                         
                    
                });
                $(".nvgtb").click(function(){
                    
                    var server = "<?php echo JURI::base(); ?>";                                   
                    window.location = server+"index.php/component/rednet/reportmaster/?task=approve_report";                         
                    
                });
            });
        </script>
        <p>
        <table style="margin-left: 20px !important;">
    <tr>
        <td><input class="nvgta" type="submit" tabindex="25" name="save" value="New"></td>
<!--        <td><input class="nvgtb" type="submit" tabindex="25" name="save" value="Approve"></td>-->
    </tr>
</table>
</p>

        <di id="testdiv">
            
        </di>        
<div>
    <table border="0" style="margin-left: 35px;">
        <tr>
            <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/custom-report.png" alt="logo" id="lock_icon" width="60" /></td>
            <td><h4>Approve Trip Report</h4></td>
        </tr>
    </table>
    
</div>

<jdoc:include type="message" />

<script type="text/javascript">
                $("document").ready(function(){
                    
                    $("#date_from").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }}); 
                    
                    $("#date_to").mask("99/99/9999",{completed:function(){
                                var date = $(this).val();
                                var d_array =  date.split('/');                                
                                 dateValidate(d_array);                                 
                        }}); 
                    
                });
</script>



<table width="80%" border="0" style="margin-left: 75px;margin-bottom: 10px;">
    <form name="filter_order_list" id="filter_order_list" action="<?php echo JURI::base()."index.php/component/rednet/reportmaster/?task=approve_report"; ?>" method="post">
                 
        <tr>
            
            <td><p class="field_para">
                    <input id="un_approve" name="un_approve" type="checkbox" id="name" value="1" style="width: auto !important;float: left;margin-right: 5px" <?php echo ($un_approve == '1')?('checked'):('') ?> /><label for="name" style="width: auto !important;float: left">Un-approved</label>
            </p>
            </td>
            <td><p class="field_para">        

                    <label for="order_no">Order#</label>
                    <input type="hidden" name="action" value="filter" />
                    <input name="order_no" type="text" class="main_forms_field required" id="order_no" tabindex="1" value="" />      <label for="fist_name"></label>
            </p>
            </td>

        </tr>
        <tr>
            <td>

            <p class="field_para">
            <label for="date_order">From Date (mm/dd/yyyy)</label>

            <input name="date_from" type="text" class="main_forms_field required" id="date_from" tabindex="3" value="">

            </p>        
            </td>
            
            <td>

            <p class="field_para">
            <label for="date_order">To Date (mm/dd/yyyy)</label>

            <input name="date_to" type="text" class="main_forms_field required" id="date_to" tabindex="3" value="">

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



<form id="add_worker" action="<?php echo JURI::base()."index.php/component/rednet/reportmaster/?task=approve_report_save" ?>" method="post" onsubmit="return validate_required();">
    <input type="hidden" name="mode" id="mode" value="<?php echo $mode ?>" />
    
 
<style type="text/css">
    .worker_table
    {
        border-left: 2px solid #C8BFC4 !important;
        border-top: 2px solid #C8BFC4 !important;
        border-right:  2px solid #C8BFC4 !important;
        border-bottom:  2px solid #C8BFC4 !important;        
        margin-left: 60px;
    }
    
    .worker_table tr td
    {
        text-align: center !important;
        border-bottom: 1px solid #74646e;
        padding-bottom: 5px !important;
    }
    
    .order_break
    {
        text-align: center !important;
        border-bottom: 1px solid #B30000 !important;
        padding-bottom: 5px !important;
    }
    
    .worker_table thead tr td
    {
        text-align: center !important;
    }
    
    .tbl_data
    {
        color: #000 !important;
        font-size: 12px !important;
    }
    
    .report_link
    {
        color: #000 !important;
    }
</style>


<br />
    <p class="field_para" style="margin-left: 45px !important">
        Total: <?php echo count($reportmaster); ?>
    </p>
<table class="worker_table" width="100%" border="0">
    <thead>
        
<tr>
  <td>
    <p class="field_para" style="padding-left: 0px !important">
      <label for="sr">Date</label>
<!--      <input name="credit_card" type="text" class="main_forms_field required" id="credit_card" tabindex="20" value="<?php echo (isset($form_data['credit_card']))?($form_data['credit_card']):("") ?>" />-->
    </p>
  </td>
  <td>
          <p class="field_para">
            <label for="name_worker">Name</label>
          </p>      
  </td>
  <td>
          <p class="field_para">
            <label for="adon-orders">Reports#</label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="name_worker">Men#</label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="hours">Trucks#</label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="invoice">Invoice Total</label>
      </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="tip_allow">Work Hrs</label>
      </p>      
  </td>
<!--<td>
<p class="field_para" style="padding-left: 0px !important">
            <label for="flag">Discount (Y/N)</label>
          </p>          
</td>-->
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Travel Leak</label>
     </p>          
</td>
<!--<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Flag</label>
     </p>          
</td>-->
<!--<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Paid (Y/N)</label>
    </p>          
</td>-->
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Paid Hrs</label>
    </p>          
</td>
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Billed Hrs</label>
    </p>          
</td>

<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Outstanding Balance</label>
    </p>          
</td>
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Demage Amount</label>
    </p>          
</td>

<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Approved (Y/N)</label>
    </p>          
</td>

</tr>
    </thead>    
    
<tbody id="report_detail_table">    

    <?php
     $cntr = 0;
     $outstanding_sum = 0;
     $damage_sum = 0;
     $billed_hours_mins_sum = 0;
     $billed_hours_hrs_sum = 0;
     $paid_hours_sum_mins = 0;
     $work_hours_sum_min = 0;
     $work_hours_sum_hrs = 0;
     $paid_hours_sum_hrs = 0;
     $travel_leak_array = array();
     //headcode
     $tl_pos_hrs = array();
     $tl_pos_mins = array();
     $tl_neg_hrs = array();
     $tl_neg_mins = array();
     
     //var_dump($reportmaster);
     if(count($reportmaster) > 0)
     {
     foreach ($reportmaster as $report) :
        // if($report)
                
                //echo $id_string." ** ";
    ?>
<!--    obj.order_no+obj.order_id+obj.user_id;-->

        
<tr>
  <td>
    <p class="tbl_data">
        <input type="hidden" name="report_id[]" id="report_id" value="<?php echo $report->report_id ?>" />
      <?php echo date("m/d/Y",strtotime($report->date_order)); ?>
    </p>
  </td>
  <td>
      <?php 
      
      $access_id = 0;
      if($report->is_addon == 1)
      {
         $access_id = $report->parent_order; 
      }  else {
         $access_id = $report->order_id; 
      }
          
      ?>
          <p class="tbl_data">
              <a class="report_link" href="<?php echo JURI::base() ?>index.php/component/rednet/reportmaster/?order_id=<?php echo $access_id;?>"><?php echo $report->name; ?></a>
          </p>      
  </td>
  <td>
      <p class="tbl_data" style="padding-left: 0px !important">
            
            <?php
         //echo $report->order_id. ' - '.$report->report_id;
         
            $dbx = JFactory::getDbo();
            $queryx = "SELECT * FROM #__report_clients WHERE report_id=$report->report_id";
            $dbx->setQuery($queryx);
            $dbx->query() or die(mysql_error());
            $obj_adons = $dbx->loadObjectList();
            
                  
            if($report->is_addon == 1)
            {
               echo "--"; 
            }  else {
               echo count($obj_adons); 
            }
            
            ?>
      </p>      
  </td>
  <td>
      <p class="tbl_data" style="padding-left: 0px !important">
            <?php echo $report->no_of_men; ?>
          </p>      
  </td>
  <td>
      <p class="tbl_data" style="padding-left: 0px !important">
            <?php echo $report->no_of_trucks; ?>
          </p>      
  </td>
  <td>
      <p class="tbl_data" style="padding-left: 0px !important">
            <?php
         
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__report_how_paid WHERE order_id=$report->order_id AND report_id=$report->report_id";
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            $obj_rhp = $db->loadObject();
            echo $obj_rhp->total_invoice_amount;
            ?>
      </p>      
  </td>
  <td>
      <p class="tbl_data" style="padding-left: 0px !important">
            <?php echo $report->total_work_hours_billed; ?>
         
          <?php
          if($report->is_addon == 0)
        {
            $work_hours_array =  split(':', $report->total_work_hours_billed);             
            $work_hours_sum_min += $work_hours_array[1];            
            $work_hours_sum_hrs += $work_hours_array[0];                       
        }
          ?>
      </p>      
  </td>
<!--  
<td>
    <input type="checkbox" id="is_discount" name ="is_discount_<?php echo $report->report_id ?>" <?php echo (isset($report->is_discount) && $report->is_discount == '1')?('checked=checked'):('')?> value="1" /> 
</td>-->

<td>
    <p class="tbl_data" style="padding-left: 0px !important">
           <?php echo $report->travel_leak; ?>
        <?php
        //code
        if($report->is_addon == 0)
        {
            $travel_leak_array[] = $report->travel_leak;
        }
        ?>
     </p>          
</td>
<!--<td>
    <p class="tbl_data" style="padding-left: 0px !important">
        <?php echo (isset($report->flag_job) && $report->flag_job == '1')?('Yes'):('No')?>
    </p>
</td>-->
<!--<td>
    <input type="checkbox" id="is_paid" name ="is_paid_<?php echo $report->report_id ?>" <?php echo (isset($report->is_paid) && $report->is_paid == '1')?('checked=checked'):('')?> value="1"  />
</td>-->



<td>
    <p class="tbl_data" style="padding-left: 0px !important">
   <?php echo ''.$report->paid_hours.''; ?> 
        
        <?php
        
        if($report->is_addon == 0)
        {
            $paid_hours_array =  split(':', $report->paid_hours);             
            $paid_hours_sum_mins += $paid_hours_array[1];            
            $paid_hours_sum_hrs += $paid_hours_array[0];            
        }
         ?>
        </p>
</td>
<td>
    <p class="tbl_data" style="padding-left: 0px !important">
        
   <?php echo ''.$report->total_work_hours_billed.''; ?> 
        
        <?php
        
        if($report->is_addon == 0)
        {
            $billed_hours_array =  split(':', $report->total_work_hours_billed);
              //var_dump($billed_hours_array);
            $billed_hours_mins = $billed_hours_array[1];
            $billed_hours_hrs = $billed_hours_array[0];
              //echo $billed_hours_mins;
            $billed_hours_mins_sum += $billed_hours_mins;
            $billed_hours_hrs_sum += $billed_hours_hrs;            
        }
              
        ?>
        </p>
</td>
<td>
    <p class="tbl_data" style="padding-left: 0px !important">
        <?php
            $db = JFactory::getDbo();
            $query_x = "SELECT * FRoM #__report_how_paid WHERE order_id=$report->order_id AND report_id=$report->report_id";
            
            $db->setQuery($query_x);
            $db->query() or die(mysql_error());
            $rpt_hp = $db->loadObject();
            echo $rpt_hp->outstanding;
            
            //if($report->is_addon == 0)
            //{
                $outstanding_sum += $rpt_hp->outstanding;                
            //}                                     
        ?>

        </p>
</td>
<td>
    <p class="tbl_data" style="padding-left: 0px !important">
   <?php 
   echo $rpt_hp->damage;    
   $damage_sum += $rpt_hp->damage;
   ?> 
        </p>
</td>

<td>
    <input type="checkbox" id="is_approved" name ="is_approved_<?php echo $report->report_id ?>" <?php echo (isset($report->is_approved) && $report->is_approved == '1')?('checked=checked'):('')?> value="1"  />
</td>

</tr>

    <?php
        $cntr++;
    endforeach;
     }
    ?>
    
</tbody>

<tfoot>
    <tr>
  <td>
    <p class="field_para" style="padding-left: 0px !important">
      <label for="sr"></label>

    </p>
  </td>
  <td>
          <p class="field_para">
            <label for="name_worker"></label>
          </p>      
  </td>
  <td>
          <p class="field_para">
            <label for="adon-orders"></label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="name_worker"></label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="hours"></label>
          </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="invoice"></label>
      </p>      
  </td>
  <td>
      <p class="field_para" style="padding-left: 0px !important">
            <label for="tip_allow">
                <?php
                  
                    $time_y = strtotime('00:00');
                    $wh_endTime_with_mins = date("H:i", strtotime("+$work_hours_sum_min minutes", $time_y));
                
                $rstl_array_y = split(":", $wh_endTime_with_mins);
                $rslt_wh = ($rstl_array_y[0]+$work_hours_sum_hrs).":".$rstl_array_y[1];
                         echo $rslt_wh;
                ?>
            </label>
      </p>      
  </td>
<!--<td>
<p class="field_para" style="padding-left: 0px !important">
            <label for="flag">Discount (Y/N)</label>
          </p>          
</td>-->
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">
                <?php
                //footcode
                //print_r($travel_leak_array);
                foreach($travel_leak_array as $travel_leak)
                {
                    $tl_split = split(":", $travel_leak);
                    //echo " $tl_split[0] <br />";
                    $tl_splited_hr = $tl_split[0];
                    $tl_splited_min = $tl_split[1];
                    if($tl_splited_hr < 0)
                    {
                        //echo "(-iv) $tl_splited_hr:$tl_splited_min<br />";
                        $tl_neg_hrs[] = $tl_splited_hr;
                        $tl_neg_mins[] = $tl_splited_min;
                    }else{
                        //echo "(+iv) $tl_splited_hr:$tl_splited_min<br />";
                        $tl_pos_hrs[] = $tl_splited_hr;
                        $tl_pos_mins[] = $tl_splited_min;
                    }
                }
                
                $time_tl_zero = strtotime('00:00');
     // ========================== -ive time ==========
                $tl_neg_mins_sum = 0;                
                foreach($tl_neg_mins as $neg_min)
                {
                    $tl_neg_mins_sum+=$neg_min;
                }
                
                $tl_neg_hrs_sum = 0;
                foreach($tl_neg_hrs as $neg_hr)
                {
                    $tl_neg_hrs_sum += $neg_hr;
                }
                                
                $tl_endTime_neg_min = date("H:i", strtotime("+$tl_neg_mins_sum minutes", $time_tl_zero));
                
                $tl_endTime_neg_min_array = split(":", $tl_endTime_neg_min);
                
                $tl_neg_time = ($tl_endTime_neg_min_array[0]+substr($tl_neg_hrs_sum,1)).":".$tl_endTime_neg_min_array[1];
                
                //echo " (-iv) ".$tl_neg_time;
                
     // ========================= +ive time ====================                                           
                $tl_pos_mins_sum = 0;
                foreach($tl_pos_mins as $pos_min)
                {
                    $tl_pos_mins_sum+=$pos_min;
                }
                    
                $tl_pos_hrs_sum = 0;
                foreach($tl_pos_hrs as $pos_hr)
                {
                    $tl_pos_hrs_sum += $pos_hr;
                }

                
                
                $tl_endTime_pos_min = date("H:i", strtotime("+$tl_pos_mins_sum minutes", $time_tl_zero));              
                
                $tl_endTime_pos_min_array = split(":", $tl_endTime_pos_min);
                $tl_pos_time = ($tl_endTime_pos_min_array[0]+$tl_pos_hrs_sum).":".$tl_endTime_pos_min_array[1];
                
                //echo " ** (+iv) ".$tl_pos_time;
       
                //echo " ** ".get_time_difference($tl_pos_time,$tl_neg_time);
                $tl_pos_time_array = split(":", $tl_pos_time);
                $tl_neg_time_array = split(":", $tl_neg_time);
                
                
                if(($tl_pos_time_array[0] > 0 && $tl_pos_time_array[1] > 0) && ($tl_neg_time_array[0] > 0 && $tl_neg_time_array[1] > 0))
                {
                    echo get_time_difference($tl_pos_time,$tl_neg_time);
                }
                
                if(($tl_pos_time_array[0] == 0 && $tl_pos_time_array[1] == 0) && ($tl_neg_time_array[0] > 0 && $tl_neg_time_array[1] > 0))
                {
                    echo "-".$tl_neg_time;
                }
                
                
                if(($tl_pos_time_array[0] > 0 && $tl_pos_time_array[1] > 0) && ($tl_neg_time_array[0] == 0 && $tl_neg_time_array[1] == 0))
                {
                    echo $tl_pos_time;
                }
                
                
                
       function get_time_difference($time1, $time2) {
                $date = date("Y-m-d H:i:s",strtotime("2013-04-13 $time2"));
                $date_x = date("Y-m-d H:i:s", strtotime("2013-04-13 $time1"));
           
                $Total_shift_time = strtotime($date_x) - strtotime($date);                
                $hours=floor($Total_shift_time/3600);
                $Total_shift_time-=$hours*3600;
                $minutes=floor($Total_shift_time/60);
                $Total_shift_time-=$minutes*60;
                $seconds=$Total_shift_time;
                $Total_shift_time=$hours.":".$minutes.":".$seconds;
           return "$Total_shift_time";
       }
                ?>
            </label>
     </p>          
</td>
<!--<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Flag</label>
     </p>          
</td>-->
<!--<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">Paid (Y/N)</label>
    </p>          
</td>-->
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus">
                <?php
                
                $time_x = strtotime('00:00');
                $pr_endTime_with_mins = date("H:i", strtotime("+$paid_hours_sum_mins minutes", $time_x));                        
                $rstl_array_x = split(":", $pr_endTime_with_mins);            
                $pr_endTime_with_mins = ($rstl_array_x[0]+$paid_hours_sum_hrs).":".$rstl_array_x[1];
                echo $pr_endTime_with_mins.":00";
                ?>                
            </label>
    </p>          
</td>
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus"><?php 
            
            //echo $billed_hours_mins_sum; 
            $time = strtotime('00:00');
            $billed_endTime_with_mins = date("H:i", strtotime("+$billed_hours_mins_sum minutes", $time));                        
            $rstl_array = split(":", $billed_endTime_with_mins);            
            $rslt_sum_billed = ($rstl_array[0]+$billed_hours_hrs_sum).":".$rstl_array[1];
            echo $rslt_sum_billed.":00";

            ?></label>
    </p>          
</td>

<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus"><?php echo $outstanding_sum; ?></label>
    </p>          
</td>
<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus"><?php echo $damage_sum; ?></label>
    </p>          
</td>

<td>
    <p class="field_para" style="padding-left: 0px !important">
            <label for="bonus"></label>
    </p>          
</td>

</tr>
</tfoot>
</table>

    
<p>
    <br />
    <input type="submit" value="Save" name="save" tabindex="25" />
</p>
</form>

        <style type="text/css">
            .report_text a{
                font-family: arial !important;
                color: #000 !important;
                font-size: 14px !important;
            }
            .report_text{
                font-family: arial !important;
                color: #000 !important;
                font-size: 14px !important;
            }
        </style>        

    <style type="text/css">
        #orders_by_order_no
        {
            margin-left: 15px;
        }
        
        #orders_by_order_no thead tr td
        {
            background-color: pink;
            font-size: 14px;
            padding: 5px;
        }
        #orders_by_order_no tbody tr td
        {
            
            font-size: 12px;
            padding: 5px;
        }
        #orders_by_order_name
        {
            margin-left: 15px;
        }
        
        #orders_by_order_name thead tr td
        {
            background-color: pink;
            font-size: 14px;
            padding: 5px;
        }
        #orders_by_order_name tbody tr td
        {
            
            font-size: 12px;
            padding: 5px;
        }
        
        #orders_by_order_date
        {
            margin-left: 15px;
        }
        
        #orders_by_order_date thead tr td
        {
            background-color: pink;
            font-size: 14px;
            padding: 5px;
        }
        #orders_by_order_date tbody tr td
        {
            
            font-size: 12px;
            padding: 5px;
        }
        
        a.order_name_search
        {
            color: #B30000 !important;            
        }
        a.order_no_search
        {
            color: #B30000 !important;                        
            text-decoration: underline;
        }
        a.order_no_search:hover
        {
            cursor: pointer;
            text-decoration: underline;
        }
        a.order_date_search
        {
            color: #B30000 !important;            
        }
    </style>

    <input type="hidden" id="selected_order_no" name="selected_order_no" value="" />
    <input type="hidden" id="selected_name" name="selected_name" value="" />
    <input type="hidden" id="selected_date_order" name="selected_date_order" value="" />
    <input type="hidden" id="sum_of_totalHrs_totalTravel" name="sum_of_totalHrs_totalTravel" value="" />
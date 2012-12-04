<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();

$user = JFactory::getUser();
$user_id = $user->id;
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
            

            if(isset($worker->verified_status) && ($worker->verified_status == 0))
            {
                $url = "index.php?option=com_rednet&task=ask_password_change&view=workers";             
                $app->redirect($url);
            }

$app->redirect(JURI::root()."index.php/component/rednet/ordersoncalendar");

?>

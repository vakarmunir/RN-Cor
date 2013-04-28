<?php
/**
* @version		$Id: default_modelfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Rednet
* @subpackage 	Models
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/
 defined('_JEXEC') or die('Restricted access');

global $alt_libdir;
JLoader::import('joomla.application.component.modelitem', $alt_libdir);
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_rednet/tables');
/**
 * RednetModelWorkers
 * @author $Author$
 */
 
 
class RednetModelWorkers  extends JModelItem { 

	
	
	protected $context = 'com_rednet.workers';   
	protected $_roles_by_type = null;   
	protected $_worker = null;   
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	public function populateState()
	{
		$app = JFactory::getApplication();

		//$params	= $app->getParams();

		// Load the object state.
		$id	= JRequest::getInt('id');
		$this->setState('workers.id', $id);

		// Load the parameters.
		//TODO: componenthelper
		//$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('workers.id');

		return parent::getStoreId($id);
	}
	
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem($id = null)
	{
		if ($this->_item === null) {
			
			$this->_item = false;

			if (empty($id)) {
				$id = $this->getState('workers.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Workers', 'Table');


			// Attempt to load the row.
			if ($table->load($id)) {
				
				// Check published state.
				if ($published = $this->getState('filter.published')) {
					
					if ($table->state != $published) {
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
				
			} else if ($error = $table->getError()) {
				
				$this->setError($error);
			}
		}


		return $this->_item;
	}
        
        public function getFilteredWorkers($data)
        {
           
            $name=$data['name'];
            $status=$data['status_filter'];
            $email=$data['email'];
            $where = ' WHERE ';
            $and = ' AND ';
           
            
            
           
            $db = JFactory::getDbo();
            //$query = "SELECT * FROM #__workers";
            
            if( ($name=="") && ($status=="") && ($email=="") )
            {
                $query = "SELECT * FROM #__workers";
            }else{
                $query .= "SELECT * FROM #__workers".$where;
            }
            
           if($status != "")
           {
               $query.= " status='$status'";
           }
           
           if($name != "")
           {
               $query.= " name='$name'";
           }
           
           if($email != "")
           {
               $query.= " email='$email'";
           }
           
           $query.= " ORDER BY first_name ASC";
           
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $workers = $db->loadObjectList();
            return $workers;
        }
        
        
        
        public function getAllPackers()
        {            
            $packers = $this->getWorkersByRoleName('packer');            
            return $packers;
        }
        public function getAllLoaders()
        {            
            $ldr_p = $this->getWorkersByRoleName('ldr-p');
            $ldr_f = $this->getWorkersByRoleName('ldr-f');
            
            $loaders = array_merge($ldr_p,$ldr_f);
            return $loaders;
        }
        public function getAllDrivers()
        {            
            $drv_z = $this->getWorkersByRoleName('drv-z');
            $drv_g = $this->getWorkersByRoleName('drv-g');
            
            $drivers = array_merge($drv_z,$drv_g);
            return $drivers;
        }
        
        public function getAllCrews()
        {            
            $cc = $this->getWorkersByRoleName('cc');
            $cct = $this->getWorkersByRoleName('cct');
            $acc = $this->getWorkersByRoleName('acc');
            $accg = $this->getWorkersByRoleName('acc-g');
            
            $crews = array_merge($cc,$cct,$acc,$accg);
            
            return $crews;
        }
        
        public function getWorkersByRoleName($role_name)
        {
            $db = JFactory::getDbo();            
            $query = "
            Select
  #__worker_role.id,
  #__worker_role.name,
  #__worker_role.type,
  #__worker_role_index.id As roleId,
  #__worker_role_index.role_id,
  #__worker_role_index.user_id,
  #__worker_role_index.wage_hr,
  #__workers.id As workerId,
  #__workers.user_id As userId,
  #__workers.first_name,
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
  #__workers.verification_code,
  #__workers.initial
From
  #__worker_role Left Join
  #__worker_role_index On #__worker_role.id =
    #__worker_role_index.role_id Inner Join
  #__workers On #__workers.user_id =
    #__worker_role_index.user_id
Where
  #__worker_role.name = '$role_name'    
            ";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $wrks = $db->loadObjectList();
            return $wrks;
        }
        
        
        public function getAllRolesByType($type)
        {
            $db = JFactory::getDbo();            
            $query = "SELECT * FROM #__worker_role WHERE type='$type'";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $this->_roles_by_type = $db->loadObjectList();
            return $this->_roles_by_type;
        }
		
        public function deleteWorker($user_id)
        {
            $db = JFactory::getDbo();
            
            $query = "DELETE FROM #__users WHERE id IN($user_id)";            
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            
            $query = "DELETE FROM #__user_usergroup_map WHERE user_id IN($user_id)";            
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            
            $query = "DELETE FROM #__workers WHERE user_id IN($user_id)";            
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            
            $query = "DELETE FROM #__worker_role_index WHERE user_id IN($user_id)";            
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            
            $query = "DELETE FROM #__fua_userindex WHERE user_id IN($user_id)";            
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            
        }
        
        public function getWorkerById($user_id)
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
  #__workers.initial,
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
            $this->_worker = $db->loadObject();
            
            return $this->_worker;
        }
                
		
        public function getAllWorkers()
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
  #__workers.initial,
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
 
  #__workers.user_id = #__users.id And
  #__fua_userindex.user_id = #__users.id

ORDER BY #__workers.first_name ASC
            ";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $this->_worker = $db->loadObjectList();
            
            return $this->_worker;
        }
                
		
        public function getAllActiveWorkers()
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
  #__workers.initial,
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
 
  #__workers.user_id = #__users.id And #__workers.status = 1 AND
  #__fua_userindex.user_id = #__users.id

ORDER BY #__workers.first_name ASC
            ";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $this->_worker = $db->loadObjectList();
            
            return $this->_worker;
        }
                
		
        public function getWorkerRolesIndexs($user_id)
        {
           
            $db = JFactory::getDbo();
            
            //$query = "DELETE FROM #__users WHERE id IN($user_id)";            
            
            $query = "
                Select
  #__worker_role_index.role_id,
  #__worker_role_index.user_id,
  #__worker_role_index.wage_hr,
  #__worker_role.id,
  #__worker_role.name,
  #__worker_role.type
From
  #__worker_role_index Inner Join
  #__worker_role On #__worker_role_index.role_id =
    #__worker_role.id
Where
  #__worker_role_index.user_id = $user_id
                ";
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            $this->_worker = $db->loadObjectList();
            
            return $this->_worker;
        }
        
        
        public function updateWorker($data)
        {
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
                        
           $primary_role_hidden_name = $data["primary_role_hidden_name"];
           $secondary_role_hidden_name =$data["secondary_role_hidden_name"];
           $additional_role_hidden_name = $data["additional_role_hidden_name"];
           
                        
            $query = "
                UPDATE #__users SET
                name 	   = '$data[first_name]' ,	
                username  =  '$data[email]',
                email    =   '$data[email]'   
                WHERE        
                id = $data[userId]
            ";
            $db->setQuery($query);
            $db->query() or die(mysql_error()); 
            
            
   $dob = date('Y-m-d', strtotime($data[dob]));
   $start_date = date('Y-m-d', strtotime($data[start_date]));
   $updated_date = date('Y-m-d');
   
            $query = "
   UPDATE #__workers SET
first_name=  '$data[first_name]',
last_name=   '$data[last_name]',
s_n    ='$data[s_n]',
dob='$dob',
start_date='$start_date',
dl_no='$data[dl_no]',
class='$data[class]',
status='$data[status]',
email='$data[email]',
cell='$data[cell]',
home='$data[home]',
shirt_size='$data[shirt_size]',
pant_leg='$data[pant_leg]',
waist='$data[waist]',
receive_update_by='$data[receive_update_by]',
desired_shift='$data[desired_shift]',
updated_by='$user->name',
updated_date='$updated_date',
initial='$data[initial]'
            WHERE
            user_id = $data[userId]            
            ";
            $db->setQuery($query);
            $db->query() or die(mysql_error());
            
            //updating new password
            if(isset($data[password]) && $data[username]!='')
            {
                    $new_pass = md5($data['password']);
                
                    $query = "
                        UPDATE #__users SET
                        password    =   '$new_pass'   
                        WHERE        
                        id = $data[userId]
                    ";
                    $db->setQuery($query);
                    $db->query() or die(mysql_error()); 
            }
            
            
           $primary_role = $data["primary_role"];
           $wage_hr_primary = $data["wage_hr_primary"];
           
           $secondary_role = $data["secondary_role"];
           $wage_hr_secondary = $data["wage_hr_secondary"];
           
           $additional_role = $data["additional_role"];
           $wage_hr_additional = $data["wage_hr_additional"];
              
           $new_user_id = $data["userId"];
           
           
           
             // ======= [Start] Block of Roles(group) assingment ================================
           // query for adding as loader - 13 is loader id and loader is usergroup of front-access-controll component.
           // values 13-for-loader , 11-for-admin
           $groupId = "";
           
           
            // deleting user form old group
            $query = "DELETE FROM #__fua_userindex WHERE user_id IN($new_user_id)";            
            $db->setQuery($query) or die(mysql_error());
            $db->query();            
            
           if($primary_role_hidden_name == "admin" || $secondary_role_hidden_name=="admin" || $additional_role_hidden_name=="admin")
           {
               // 11 value is for admin
              $groupId ='\"11\"'; 
           }else{
               //13 value is for loader
                $groupId ='\"13\"';
           }
           $qry_user_group = "INSERT INTO #__fua_userindex(
               user_id,
               group_id
               )
               VALUES
               (
               '$new_user_id','$groupId'
                )
               ";
           $db->setQuery($qry_user_group);
           $db->query() or die(mysql_error());
// ======= [End] Block of Roles(group) assingment ================================   
           
           
           
           
           
            $query = "DELETE FROM #__worker_role_index WHERE user_id IN($data[userId])";            
            $db->setQuery($query) or die(mysql_error());
            $db->query();
            
               //worker role wages queries -1
           $qry_role_wages_p = "INSERT INTO #__worker_role_index
                                (role_id,user_id,wage_hr  )
                                VALUES
                                ('$primary_role','$new_user_id','$wage_hr_primary')
                                ";
           $db->setQuery($qry_role_wages_p);
           $db->query() or die(mysql_error());
          
           
          //worker role wages queries -2
           $qry_role_wages_s = "INSERT INTO #__worker_role_index
                                (role_id,user_id,wage_hr  )
                                VALUES
                                ('$secondary_role','$new_user_id','$wage_hr_secondary')
                                ";
           $db->setQuery($qry_role_wages_s);
           $db->query() or die(mysql_error());
          
          //worker role wages queries -3
           $qry_role_wages_a = "INSERT INTO #__worker_role_index
                                (role_id,user_id,wage_hr  )
                                VALUES
                                ('$additional_role','$new_user_id','$wage_hr_additional')
                                ";
           $db->setQuery($qry_role_wages_a);
           $db->query() or die(mysql_error());
          
           
                

           
        }
        
        
        public function updateWorkerPersonalInfo($data)
        {
            
          
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
            
            $query = "
                UPDATE #__users SET
                name 	   = '$data[first_name]' 	  
                WHERE        
                id = $user->id
            ";
               //var_dump($data);
           
         
            $db->setQuery($query);
            $db->query() or die(mysql_error()); 
            
            
   $dob = date('Y-m-d', strtotime($data[dob]));
   $start_date = date('Y-m-d', strtotime($data[start_date]));
   $updated_date = date('Y-m-d');
   
            $query = "
UPDATE #__workers SET
first_name='$data[first_name]',
last_name='$data[last_name]',
dob='$dob',
cell='$data[cell]',
home='$data[home]',
initial='$data[initial]',
s_n='$data[s_n]',
start_date='$start_date',
dl_no='$data[dl_no]',
shirt_size='$data[shirt_size]',
pant_leg='$data[pant_leg]',
waist='$data[waist]',
desired_shift='$data[desired_shift]',
updated_date='$updated_date',
class='$data[class]'
            WHERE
            user_id = $user->id            
            ";
            
           
            $db->setQuery($query);
            $db->query() or die(mysql_error());           
        }
        
        public function fieldValueCheck($field,$value)
        {
            $db = JFactory::getDbo();
            
            $query = "
                SELECT * FROM #__users                
                WHERE        
                $field = '$value'
            ";
            
           
            $db->setQuery($query);
            $db->query() or die(mysql_error()); 
            $obj = $db->loadObject();
            return $obj;
        }
                
        public function fieldValueCheckWorker($field,$value)
        {
            $db = JFactory::getDbo();
            
            $query = "
                SELECT * FROM #__workers                
                WHERE        
                $field = '$value'
            ";
            
           
            $db->setQuery($query);
            $db->query() or die(mysql_error()); 
            $obj = $db->loadObject();
            return $obj;
        }
                
	public function getWorkerAuthenticationGroup($userId)
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
                   return $user_group_name;
        }
        
        public function getAssignedResources($user_id)
        {
            $db = JFactory::getDbo();
            $query = "
            
                  Select
  #__resourcesmap.order_id,
  #__resourcesmap.user_id,
  #__resourcesmap.truck,
  #__resourcesmap.status,
  #__resourcesmap.created_date,
  #__resourcesmap.id,
  #__orders.name,
  #__orders.order_no,
  #__orders.id As the_order_id,
  #__orders.date_order,
  #__orders.type_order,
  #__orders.type_if_other,
  #__orders.no_of_men,
  #__orders.no_of_trucks,
  #__orders.truck_requirments,
  #__orders.out_of_town,
  #__orders.departure_time,
  #__orders.deposite,
  #__orders.is_addon,
  #__orders.addon_time,
  #__orders.instruction_file,
  #__orders.created_by,
  #__orders.created_date As created_date1,
  #__orders.updated_date,
  #__orders.parent_order
From
  #__resourcesmap Right Join
  #__orders On #__orders.id = #__resourcesmap.order_id
Where
  #__resourcesmap.user_id = $user_id
            ";
            
            $db->setQuery($query);
            $db->query($query) or die(mysql_error());
            
            $rsc = $db->loadObjectList();
            
            return $rsc;
        }
}
?>
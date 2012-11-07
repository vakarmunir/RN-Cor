<?php
/**
* @package Frontend-User-Access (com_frontenduseraccess)
* @version 3.3.0
* @copyright Copyright (C) 2008-2010 Carsten Engel. All rights reserved.
* @license GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html 
* @author http://www.pages-and-items.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$delimiter = ',';
$quote = '"';
$newline = "\r\n";

$out = '';
for($i=0; $i < count( $this->items ); $i++) {
	$row = $this->items[$i];		
	
	$out .= $quote.$row->id.$quote;	
	$out .= $delimiter;
	$out .= $quote.$row->username.$quote;
	$out .= $delimiter;
	$out .= $quote.$row->name.$quote;
	$out .= $delimiter;
	$out .= $quote.$row->email.$quote;
	$out .= $delimiter;	
	$out .= $quote.$row->block.$quote;
	$out .= $delimiter;
	$out .= $quote.$row->sendEmail.$quote;
	$out .= $delimiter;
	$out .= $quote.$row->registerDate.$quote;
	$out .= $delimiter;
	$out .= $quote.$row->lastvisitDate.$quote;
	$out .= $delimiter;
	$out .= $quote.$row->activation.$quote;
	$out .= $delimiter;
	
	$users_groups_string = '';
	$users_groups_ids_string = '';
	$row_users_fua_groups_array = $this->controller->csv_to_array($row->fua_usergroups);
	foreach($this->fua_usergroups as $fua_usergroup){
		if(in_array($fua_usergroup->id, $row_users_fua_groups_array)){	
			if($users_groups_string!=''){
				$users_groups_string .= ',';
				$users_groups_ids_string .= ',';
			}		
			$users_groups_string .= $fua_usergroup->name;
			$users_groups_ids_string .= $fua_usergroup->id;
		}				
	}				
		
	$out .= $quote.$users_groups_string.$quote;	
	$out .= $delimiter;
	$out .= $quote.$users_groups_ids_string.$quote;	
	$out .= $newline;
}

$out = chr(255).chr(254).mb_convert_encoding( $out, 'UTF-16LE', 'UTF-8');

@ob_end_clean();
$file_name = 'users_export'.date('YmdHis').'.csv';
@ini_set("zlib.output_compression", "Off");
header("Content-Type: text/comma-separated-values; charset=utf-8");
header("Content-Disposition: attachment;filename=\"$file_name\"");
header("Content-Transfer-Encoding: 8bit");
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: private");
header("Content-Length: ".strlen($out));
echo $out;
exit;

?>
<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$id = $this->my_id;
$all_dbdata = $this->model_data;
?>

<h1>All Pages</h1>
<table border="1">
<?php 

        foreach($all_dbdata as $record)     
        {
 ?>
    <tr>
        <td><?php echo $record->id;?></td>
        <td><?php echo $record->name;?></td>
        <td><?php echo $record->status;?></td>
    </tr>
<?php
            
        }
?>
</table>

<strong><?php echo $id; ?></strong>
<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$all_test_pages = $this->all_test_pages;
// $a_test_page = $this->a_test_page;
// $a_test_page->id;
// $a_test_page->name;
// $a_test_page->status;
?>

<form action="<?php echo JURI::current()."/?task=display_form"; ?>" method="post">
name:<input type="text" name="myname"/>
status:<input type="text" name="mystatus"/>
<input type="submit" value="Save" name="save_button" />
</form>


<table border="1" padding="5">
    <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Status</td>
    </tr>
    
      
<?php 

foreach($all_test_pages as $page)
{
?> 
    <tr>
        <td><?php echo $page->id; ?></td>
        <td><?php echo ($page->name); ?></td>
        <td><?php echo ($page->status); ?></td>        
        <td><a href="<?php echo JURI::current().'?task=edit_form&id='.$page->id; ?>">Edit</a></td>        
        <td><a href="#">Delete</a></td>        
    </tr>
<?php
}
?>
    
</table>    
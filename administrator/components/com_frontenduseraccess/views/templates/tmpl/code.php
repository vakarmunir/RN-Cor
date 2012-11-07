<?php
/**
* @package Frontend-User-Access (com_frontenduseraccess)
* @version 4.1.6
* @copyright Copyright (C) 2008-2012 Carsten Engel. All rights reserved.
* @license GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html 
* @author http://www.pages-and-items.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<script>
document.onload = window.parent.set_new_status('<?php echo $this->template_override; ?>', '<?php echo $this->template; ?>', '<?php echo addslashes($this->new_status); ?>');
<?php
if($this->next_template_override){
?>
document.onload = window.parent.do_next_file('<?php echo $this->next_template_override; ?>', '<?php echo $this->next_template; ?>', '<?php echo $this->do_undo; ?>');
<?php
}else{
?>
document.onload = window.parent.stop_overrides();
<?php
}
?>
</script>
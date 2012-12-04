<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

if(isset($this->msg) && $this->msg!='')
{
?>
<p><?php //echo $this->msg;?></p>
<?}?>

<jdoc:include type="message" />

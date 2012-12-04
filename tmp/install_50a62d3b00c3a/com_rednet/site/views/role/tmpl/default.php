<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();
$app = JFactory::getApplication();
if($user->id == 0)
{
    $app->redirect("index.php");
}
?>

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

//header
$this->controller->echo_header();


?>
<form class="adminForm">
<p style="margin-left: 4px;">
	<?php echo JText::_('COM_FRONTENDUSERACCESS_SUPPORT_INFO'); ?>:
</p>
<table class="adminlist fua_table">	
	<tr>
		<td style="width: 10px;">
			1.
		</td>			
		<td>
			<a href="http://www.pages-and-items.com/extensions/frontend-user-access/faqs" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_FAQS'); ?></a>
		</td>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_FAQS_INFO'); ?>.
		</td>
	</tr>
	<tr>
		<td>
			2.
		</td>			
		<td>
			<a href="http://www.pages-and-items.com/forum/advsearch?catids=37" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_SEARCH_FORUM'); ?></a> 
		</td>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_SEARCH_FORUM_INFO'); ?> 'Frontend-User-Access Joomla'.
		</td>
	</tr>
	<tr>
		<td>
			3.
		</td>			
		<td>
			<a href="http://www.pages-and-items.com/forum/37-frontend-user-access" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_POST_FORUM'); ?></a>
		</td>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_POST_FORUM_INFO'); ?> 'Frontend-User-Access Joomla'.
		</td>
	</tr>
	<tr>
		<td>
			4.
		</td>			
		<td>
			<a href="http://www.pages-and-items.com/contact" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_CONTACT'); ?></a>
		</td>
		<td>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_CONTACT_INFO'); ?>.
		</td>
	</tr>
</table>
<br /><br />
<p style="margin-left: 4px;">
<?php echo JText::_('COM_FRONTENDUSERACCESS_UPDATE_NOTIFICATIONS'); ?>:
</p>
<table class="adminlist fua_table">	
	<tr>
		<td style="width: 10px;">
			<img src="components/com_frontenduseraccess/images/mail.png" alt="mail" />
		</td>
		<td>
			<a href="http://www.pages-and-items.com/my-account/email-update-notifications" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_EMAIL_UPDATE_NOTIFICATIONS'); ?></a>
		</td>
	</tr>
	<tr>
		<td>
			<img src="components/com_frontenduseraccess/images/rss.png" alt="rss" />
		</td>
		<td>
			<a href="http://www.pages-and-items.com/extensions/frontend-user-access/update-notifications-for-frontend-user-access" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_RSS'); ?></a>
		</td>
	</tr>
	<tr>
		<td>
			<img src="components/com_frontenduseraccess/images/twitter.png" alt="twitter" />
		</td>
		<td>
			<a href="http://twitter.com/PagesAndItems" target="_blank"><?php echo JText::_('COM_FRONTENDUSERACCESS_TWITTER'); ?> Twitter</a>
		</td>
	</tr>
</table>	
</form>
<?php
$this->controller->display_footer();
?>
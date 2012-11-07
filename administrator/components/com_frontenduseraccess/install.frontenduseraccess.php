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
<div style="width: 800px; text-align: left; background: url(components/com_frontenduseraccess/images/icon.png) 10px 0 no-repeat;">
	<h2 style="padding: 10px 0 10px 70px;">Frontend-User-Access</h2>
	<div style="width: 1000px; overflow: hidden;">	
		<div style="width: 270px; float: left;">
			<p>
				Thank you for using Frontend-User-Access.		
			</p>
			<p>
				<input type="button" value="Go to Frontend-User-Access configuration" onclick="document.location.href='index.php?option=com_frontenduseraccess&view=config';" />				
			</p>
		</div>
		<div style="width: 380px; float: left;">
			<p>
				With Frontend-User-Access you can set frontend access restrictions to:
				<ul>
					<li>articles</li>
					<li>categories</li>
					<li>modules</li>
					<li>components</li>			
					<li>menu-items</li>			
					<li>parts of articles and templates</li>			
				</ul>
			</p>
			<p>
				You can make as many usergroups as you need and assign users to them. There are 2 predefined usergroups which are very userfull: 
				<ul>
					<li>not logged in = all users who are not logged in</li>
					<li>logged in = logged in but not assigned to any usergroup</li>
				</ul>
			</p>
			<p>
				You can configure for each restriction-type (components, modules, categories etc.) to reverse the access, so any box ticked becomes a restriction instead of an access-right.
			</p>	
			<p>
				Users can be assigned to multiple usergroups.
			</p>
		</div>
		<div style="width: 330px; float: left;">
			<p>
				Check <a href="http://www.pages-and-items.com" target="_blank">www.pages-and-items.com</a> for:
			<ul>
				<li><a href="http://www.pages-and-items.com/extensions/frontend-user-access" target="_blank">updates</a></li>
				<li><a href="http://www.pages-and-items.com/extensions/frontend-user-access/faqs" target="_blank">FAQs</a></li>	
				<li><a href="http://www.pages-and-items.com/forum/37-frontend-user-access" target="_blank">support forum</a></li>	
				<li><a href="http://www.pages-and-items.com/my-account/email-update-notifications" target="_blank">email notification service for updates and new extensions</a></li>	
				<li><a href="http://www.pages-and-items.com/extensions/frontend-user-access/update-notifications-for-frontend-user-access" target="_blank">subscribe to RSS feed update notifications</a></li>			
			</ul>
			</p>	
			<p>
				Follow us on <a href="http://www.twitter.com/PagesAndItems" target="_blank">Twitter</a> (only update notifications).
			</p>
		</div>
	</div>
</div>
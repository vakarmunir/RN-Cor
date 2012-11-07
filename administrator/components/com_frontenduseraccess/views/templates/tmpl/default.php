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
<script language="JavaScript" type="text/javascript">

function start_templates(do_undo){
	if(do_undo=='do'){
		confirm_message = '<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_SURE_TEMPLATES')); ?>';
	}else{
		confirm_message = '<?php echo addslashes(JText::_('COM_FRONTENDUSERACCESS_SURE_TEMPLATES_OUT')); ?>';
	}
	if(confirm(confirm_message)){
		document.getElementById('spinner').style.display = 'inline';
		document.getElementById('do_templates').disabled = 'true';
		document.getElementById('undo_templates').disabled = 'true';
		document.getElementById('status_on_load').style.display = 'none';				
		do_next_file('<?php echo $this->first_template_override; ?>', '<?php echo $this->first_template_name; ?>', do_undo);
	}	
}

function do_next_file(template_override, template, do_undo){	
	id = template+'/html/'+template_override;	
	document.getElementById(id).innerHTML = '<img src="components/com_frontenduseraccess/images/processing.gif" alt="processing" />';			
	document.getElementById("fua_iframe").src = "index.php?option=com_frontenduseraccess&view=templates&layout=code&tmpl=component&template_override="+template_override+"&template="+template+"&do_undo="+do_undo;	
}

function stop_overrides(){
	document.getElementById('spinner').style.display = 'none';
	document.getElementById('do_templates').disabled = false;
	document.getElementById('undo_templates').disabled = false;
}

function set_new_status(template_override, template, new_status){	
	id = template+'/html/'+template_override;	
	document.getElementById(id).innerHTML = new_status;	
}

</script>
<form name="adminForm" method="post" action="" id="adminForm">
<input type="hidden" name="option" value="com_frontenduseraccess" />
<input type="hidden" name="task" value="" />
<p style="margin-left: 4px;">	
	<span id="status_on_load"></span>
	<h1><?php echo JText::_('COM_FRONTENDUSERACCESS_TEMPLATES'); ?></h1>	
	<?php echo JText::_('COM_FRONTENDUSERACCESS_YOU_CAN_DELETE'); ?> <a href="index.php?option=com_frontenduseraccess&view=templates#codes"><?php echo JText::_('COM_FRONTENDUSERACCESS_THESE_CODES'); ?></a> <?php echo JText::_('COM_FRONTENDUSERACCESS_OR_AUTO_B'); ?>.
	<br /><br />
	
	<input type="button" name="do_templates" id="do_templates" value="add codes"  onclick="start_templates('do');" style="display: none;" />	
	
	
	<input type="button" name="undo_templates" id="undo_templates" value="<?php echo JText::_('COM_FRONTENDUSERACCESS_UNDO_TEMPLATE'); ?>"  onclick="start_templates('undo');"  />	
	<iframe src="components/com_frontenduseraccess/index.html" width="1" height="1" id="fua_iframe"></iframe>
	<span id="spinner" style="display: none; padding-left: 10px;">
		<img src="components/com_frontenduseraccess/images/processing.gif" alt="processing" />
	</span>
  <div id="fua_target">
  </div>
</p>
<table class="adminlist fua_table">	
	<tr>					
		<th style="width: 50%;">
			<?php echo JText::_('COM_FRONTENDUSERACCESS_TEMPLATE'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_STATUS'); ?>
		</th>
	</tr>
	<?php foreach($this->items as $template){ ?>
	<tr>				
		<td>
			<?php echo $template->name; ?>
		</td>
		<td>
			
		</td>
	</tr>
		<?php 
		for($n = 0; $n < count($this->template_overrides); $n++){
			if($template->name==$this->template_overrides[$n][1]){
		?>
			<tr>				
				<td style="padding-left: 20px;">
					templates/<?php echo $template->name; ?>/html/<?php echo $this->template_overrides[$n][0]; ?>.php
				</td>
				<td id="<?php echo $template->name; ?>/html/<?php echo $this->template_overrides[$n][0]; ?>">
					<?php echo $this->template_overrides[$n][2]; ?>
				</td>
			</tr>
		<?php 
			}
		}
		?>	
	<?php } ?>	
</table>
<br />
<br />
<br />
<a name="codes"></a>
<?php echo JText::_('COM_FRONTENDUSERACCESS_CODES_TO_DELETE'); ?>:
<ol>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_content/archive/default_items.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this-&gt;items = $frontenduseraccessAccessChecker-&gt;filter_articles($this-&gt;items);
}
//end filter articles</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_content/categories/default_items.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this-&gt;items[$this-&gt;parent-&gt;id] = $frontenduseraccessAccessChecker-&gt;filter_categories($this-&gt;items[$this-&gt;parent-&gt;id]);
}
//end filter categories</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_content/category/blog.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$frontenduseraccessAccessChecker-&gt;filter_category_blog($this-&gt;items, $this-&gt;params);
$this-&gt;lead_items = $frontenduseraccessAccessChecker-&gt;lead_items;
$this-&gt;intro_items = $frontenduseraccessAccessChecker-&gt;intro_items;
$this-&gt;link_items = $frontenduseraccessAccessChecker-&gt;link_items;
}
//end filter articles</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_content/category/blog_children.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this-&gt;children[$this-&gt;category-&gt;id] = $frontenduseraccessAccessChecker-&gt;filter_categories($this-&gt;children[$this-&gt;category-&gt;id]);
}
//end filter categories</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_content/category/default_articles.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this-&gt;items = $frontenduseraccessAccessChecker-&gt;filter_articles($this-&gt;items);
}
//end filter articles</textarea>		
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_content/category/default_children.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this-&gt;children[$this-&gt;category-&gt;id] = $frontenduseraccessAccessChecker-&gt;filter_categories($this-&gt;children[$this-&gt;category-&gt;id]);
}
//end filter categories</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_content/featured/default.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$frontenduseraccessAccessChecker-&gt;filter_category_blog($this-&gt;items, $this-&gt;params);
$this-&gt;lead_items = $frontenduseraccessAccessChecker-&gt;lead_items;
$this-&gt;intro_items = $frontenduseraccessAccessChecker-&gt;intro_items;
$this-&gt;link_items = $frontenduseraccessAccessChecker-&gt;link_items;
}
//end filter articles</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/com_search/default_results.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles/categories/components/menu-items as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$this-&gt;results = $frontenduseraccessAccessChecker-&gt;filter_search_results($this-&gt;results);
}
//end filter</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/mod_articles_categories/default_items.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter categories as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker-&gt;filter_categories($list);
}
//end filter</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/mod_articles_category/default.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker-&gt;filter_articles($list);
}
//end filter</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/mod_articles_latest/default.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker-&gt;filter_articles($list);
}
//end filter</textarea>
	</li>
	<li>
		<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
		<br />
		/templates/template_name/html/mod_articles_news/default.php
		<br />
		<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
		<br />
		defined('_JEXEC') or die;
		<br />
		<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter article as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
if(!$frontenduseraccessAccessChecker-&gt;check_article_access($item-&gt;id, $item-&gt;catid)){
$item-&gt;title = '';
$item-&gt;afterDisplayTitle = '';
$item-&gt;introtext = '';
$item-&gt;link = '';
$item-&gt;readmore = '';
$item-&gt;linkText = '';
}
}
//end filter</textarea>
		</li>
		<li>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
			<br />
			/templates/template_name/html/mod_articles_popular/default.php
			<br />
			<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
			<br />
			defined('_JEXEC') or die;
			<br />
			<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker-&gt;filter_articles($list);
}
//end filter</textarea>
		</li>
		<li>
			<?php echo JText::_('COM_FRONTENDUSERACCESS_FILE'); ?>:
			<br />
			/templates/template_name/html/mod_related_items/default.php
			<br />
			<?php echo JText::_('COM_FRONTENDUSERACCESS_DELETE_CODE'); ?>
			<br />
			defined('_JEXEC') or die;
			<br />
			<textarea name="foo" class="fua_textarea_code" rows="8" cols="100">//start filter articles as set in component Frontend-User-Access
if(file_exists(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php')){
require_once(JPATH_ROOT.DS.'components'.DS.'com_frontenduseraccess'.DS.'checkaccess.php');
$frontenduseraccessAccessChecker = new frontenduseraccessMenuAccessChecker();
$list = $frontenduseraccessAccessChecker-&gt;filter_articles($list);
}
//end filter</textarea>
		</li>	
</ol>



</form>
<?php
$this->controller->display_footer();
?>
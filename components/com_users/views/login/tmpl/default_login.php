<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>

<?php
$app = JFactory::getApplication();
?>

<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

		<?php if($this->params->get('logindescription_show') == 1) : ?>
			<?php echo $this->params->get('login_description'); ?>
		<?php endif; ?>

		<?php if (($this->params->get('login_image')!='')) :?>
			<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_USER_LOGIN_IMAGE_ALT')?>"/>
		<?php endif; ?>

                        
                        <table style="margin-left: 140px;">
                            <tr>
                                <td><img style="margin-right: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/lockicon.png" alt="logo" id="lock_icon" width="60" />                        </td>
                                <td style="padding-top: 38px;"><h2 class="form_heading" >Login</h2></td>
                            </tr>
                        </table>                       






     <div class="form_wrapper" style="margin-left: 140px !important;">
     
     <div class="form_slides form_slide_left">
     
     </div>
     <div class="form_slides form_slide_middle">

         
         
         	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
         	

                    <table border="0" class="form_table" width="70%">
                        <?php foreach ($this->form->getFieldset('credentials') as $field): ?>
				<?php if (!$field->hidden): ?>
		
                                    <tr>
                                        <td><span class="form_label"><?php echo $field->label; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><div class="form_field_back">
                                        <?php echo $field->input; ?>
                                        </div>

                                        </td>
                                    </tr>

                                <?php endif; ?>
                        <?php endforeach; ?>
                                    <tr>
                                        <td>
                                            <span class="form_label" style="font-size:  12px !important">
                                                <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			
				<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>
				<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" />
			
			<?php endif; ?>
                                            </span>
                                        </td>
                                    </tr>
                
                                    <tr>
                                        <td>
                                            
                                            <input type="image" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate(); ?>/images/form_button_03.png" name="password" />
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		
                
                                        </td>
                                    </tr>
                    </table>
					
					
		    
                
                </form>
     
     </div>
     
     <div class="form_slides form_slide_right">
     <?php
     $app = JFactory::getApplication();
     ?>
         <p class="login_upper_link_p">
         <table>
             <tr>
                 <td valign="middle">
                     <img style="margin-top: 8px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/bullet_03.png" alt="logo" id="Insert_logo2" />
                 </td>
                 <td valign="middle">
                        <a class="login_upper_link" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
                 </td>
             </tr>
             
             
              <tr>
                 <td valign="middle">
            <img style="margin-top: 5px !important;" src="<?php echo $this->baseurl ?>/templates/<?php echo $app->getTemplate() ?>/images/bullet_a_03.png" alt="logo" id="Insert_logo2" />
                </td>
             
                 <td>
                        <a class="login_upper_link" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
                  </td>
             </tr>
             
         </table>
             
          
	</p>
       
     </div>
     </div>

    

	

</div>


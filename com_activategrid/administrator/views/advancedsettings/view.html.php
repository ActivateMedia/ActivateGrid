<?php
/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <info@activatemedia.co.uk> - http://activatemedia.co.uk
 */

// No direct access
defined('_JEXEC') or die;
jimport('joomla.application.component.view');
jimport('joomla.form.helper');
/**
 * View to edit
 */
class ActivategridViewAdvancedsettings extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;
        protected $actions;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item	= $this->get('Item');
		$this->form	= $this->get('Form');
                
                $app = JFactory::getApplication();            
                $componentParams = JComponentHelper::getParams('com_activategrid');
                
                // Get the task
                $jinput = JFactory::getApplication()->input;
                $task = $jinput->get('task', "", '');
                //echo "Task: ".print_r($task,true);
                /*
                $instagram_config = array("client_id"     => $componentParams->get('instagram_client_id', ""),
                                          "client_secret" => $componentParams->get('instagram_client_secret', ""),
                                          "redirect_uri"  => $componentParams->get('instagram_redirect_uri', ""));                
                */
                
                if($task=="config")
                {
                    ActivategridHelper::saveConfig();
                } else if($task == "back")
                {
                    header("location: ".JURI::base()."index.php?option=com_activategrid");
                }
                
                $document = JFactory::getDocument();
                //JHtml::_('jquery.framework');
                JHtml::_('jquery.framework'); // load jquery
                JHtml::_('jquery.ui'); // load jquery ui from Joomla
                $document->addScript(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/js/jquery.ui.slider.js");
                $document->addScript(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/js/slider.js");
                //JHtml::_('bootstrap.framework');

                $document->addScript(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/js/colorpicker.js");
                
                $document->addStyleSheet(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/css/colorpicker.css");
                $document->addStyleSheet(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/css/layout.css");
                $document->addStyleSheet("http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
                                          
                //ActivategridHelper::generateSocialColorPalette();                              
                
                $this->html = "";
                
                $this->html .= "<form action='".JRoute::_('index.php?option=com_activategrid&view=advancedsettings')."' method='post' name='adminForm' id='adminForm'>\n";
                $this->html .= "   <h1>".JText::_('COM_ACTIVATEGRID_ADVANCED_CONFIGURATION_ELEMENT_STYLE')."</h1>\n";
                $this->html .= ActivategridHelper::AdvancedSettingsInterface($this);
                $this->html .= "   <input type='hidden' name='option' value='com_activategrid' />\n";
                $this->html .= "   <input type='hidden' name='task' value='' />\n";
                $this->html .= "   <input type='hidden' name='boxchecked' value='0' />\n";                
                $this->html .= "   ".JHtml::_('form.token')."\n";
                $this->html .= "</form>\n";
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
                    throw new Exception(implode("\n", $errors));
		}

                
		$this->addToolbar();
		parent::display($tpl);
	}

        /**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/activategrid.php';
                
                JToolBarHelper::title(JText::_('COM_ACTIVATEGRID')." / ".JText::_('COM_ACTIVATEGRID_ADVANCED_CONFIGURATION'), 'activates.png');
                JToolBarHelper::custom('config','save','','Save',false);
                //JToolBarHelper::save('activategrid.save');
                JToolBarHelper::preferences('com_activategrid','','','Options');
                //JToolBarHelper::back("Close without save", "javascript:history.back();" , "btn-back");
                JToolBarHelper::custom("back", 'cancel', '' ,'Close', false);
                
                JToolBarHelper::help('activatemedia', 'com_activategrid');
	}
        
}

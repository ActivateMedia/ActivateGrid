<?php
/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2014. All rights reserved.
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
            // Get the task
            $jinput = JFactory::getApplication()->input;
            $task = $jinput->get('task', "", '');

            if($task=="config")
            {
                ActivategridHelper::saveConfig();
            } 
            else if($task == "back")
            {
                header("location: ".JURI::base()."index.php?option=com_activategrid");
            }

            $document = JFactory::getDocument();
            JHtml::_('jquery.framework'); // load jquery
            JHtml::_('jquery.ui'); // load jquery ui from Joomla
            
            $document->addScript(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/js/jquery.ui.slider.js");
            $document->addScript(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/js/slider.js");
            $document->addScript(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/js/colorpicker.js");

            $document->addStyleSheet(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/css/colorpicker.css");
            $document->addStyleSheet(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/css/layout.css");
            $document->addStyleSheet(JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/css/jquery-ui.css");

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
            JToolBarHelper::title(JText::_('COM_ACTIVATEGRID')." / ".JText::_('COM_ACTIVATEGRID_ADVANCED_CONFIGURATION'), 'activates.png');
            JToolBarHelper::custom('config','save','','Save',false);
            JToolBarHelper::preferences('com_activategrid','','','Options');
            JToolBarHelper::custom("back", 'cancel', '' ,'Close', false);
            JToolBarHelper::help('activatemedia', 'com_activategrid');
	}
        
}

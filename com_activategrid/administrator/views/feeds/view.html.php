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

/**
 * View to edit
 */
class ActivategridViewFeeds extends JViewLegacy
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
                
                $jinput = JFactory::getApplication()->input;
                $task = $jinput->get('task', "", '');
                
                $app = JFactory::getApplication();   
                $document = JFactory::getDocument();
                $document->addStyleSheet(JURI::base()."components/com_activategrid/views/feeds/tmpl/assets/css/layout.css");
                
                JHtml::_('jquery.framework'); // load jquery
                $document->addScript(JURI::base()."components/com_activategrid/views/feeds/tmpl/assets/js/report.js");
                if($task == "back")
                {
                    header("location: ".JURI::base()."index.php?option=com_activategrid");
                }
                
                ActivategridHelper::generateReportPageHTML();
		
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
		//require_once JPATH_COMPONENT.'/helpers/activategrid.php';
                
                JToolBarHelper::title(JText::_('COM_ACTIVATEGRID')." / ".JText::_('COM_ACTIVATEGRID_GET_FEEDS'), '');
                //JToolBarHelper::save('activategrid.save');
                JToolBarHelper::preferences('com_activategrid','','','Basic Options');
//                JToolBarHelper::back("Back", "javascript:history.back();" , "btn-back");
JToolBarHelper::back();                
//JToolBarHelper::custom("back", 'cancel', '' ,'Back', false);
                
                JToolBarHelper::help('activategrid', 'com_activategrid');
	}
        
        private static function printButtons()
        {
            echo '<div class="row-fluid">';
            echo '   <div class="span12">';
            echo         '<div class="span6">';
            echo             '<a href="?option=com_config&amp;view=component&amp;component=com_activategrid">';
            echo                 '<button type="button" class="btn btn-large btn-block btn-info">'.@JText::_(COM_ACTIVATEGRID_CONFIGURATION).'</button>';
            echo             '</a>';
            echo         '</div>';
            echo         '<div class="span6">';
            echo             '<a href="index.php?option=com_activategrid&view=feeds">';
            echo                 '<button type="button" class="btn btn-large btn-block btn-success">'.@JText::_(COM_ACTIVATEGRID_GET_FEEDS).'</button>';
            echo             '</a>';
            echo         '</div>';            
            echo '   </div>';
            echo '</div><br/>';
        }
}

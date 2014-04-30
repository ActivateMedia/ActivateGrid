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
 * View class for a list of Activategrid.
 */
class ActivategridViewActivategrid extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
            JHtml::stylesheet('com_activategrid/com_activategrid.css', array(), true, false, false);
		$this->state		= $this->get('State');
		
		
                if(isset($_GET["code"]))
                {
                    $code = $_GET['code'];
                    header("location: ".JURI::root()."administrator/index.php?option=com_activategrid&view=instagraminit&code=".$code);                   
                }
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		//ActivategridHelper::addSubmenu('activates');
        
		//$this->addToolbar();
                $this->addToolbar();
                //$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

        protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/activategrid.php';
                JToolBarHelper::title(JText::_('COM_ACTIVATEGRID'), '48-activatemedia');
                JToolBarHelper::help('activategrid', 'com_activategrid');
                JToolBarHelper::preferences('com_activategrid');
	}
        
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar2()
	{
		require_once JPATH_COMPONENT.'/helpers/activategrid.php';

		$state	= $this->get('State');
		$canDo	= ActivategridHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_ACTIVATEGRID_TITLE_ACTIVATES'), 'activates.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/activate';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('activate.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('activate.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('activates.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('activates.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'activates.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('activates.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('activates.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'activates.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('activates.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_activategrid');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_activategrid&view=activates');
        
        $this->extra_sidebar = '';
        //
        
	}
    
	protected function getSortFields()
	{
		return array(
		);
	}

    
}

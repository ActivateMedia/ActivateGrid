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
                
                self::printButtons();
//                echo JPATH_SITE.DS."administrator".DS."components".DS."com_activategrid".DS."helpers".DS."activategrid.php";
                //require_once JPATH_SITE.DS."administrator".DS."components".DS."com_activategrid".DS."helpers".DS."activategrid.php";
                
                ActivategridHelper::get_all_social_networks_feeds();
                
                self::printButtons();
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		

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

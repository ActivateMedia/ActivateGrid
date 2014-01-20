<?php

/**
 * @version     1.0.0
 * @package     com_activategrid_pi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
// No direct access
defined('_JEXEC') or die;
define(DS, '/');

jimport('joomla.application.component.view');
/**
 * View to edit
 */
class activategridpiViewpublic_import extends JViewLegacy {

        protected $items;
        protected $pagination;
        protected $state;
        protected $params;

        
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{            
                $viewName = "public_import";
                $app =& JFactory::getApplication();
                require_once JPATH_SITE.DS."administrator".DS."components".DS."com_activategrid".DS."helpers".DS."activategrid.php";
                //ActivategridHelper::get_all_social_networks_feeds();
                
                $document = JFactory::getDocument();
                $document->addStyleSheet(JURI::base()."components/com_activategrid_pi/views/public_import/tmpl/assets/css/layout.css");
                JHtml::_('bootstrap.framework');
                JHtml::_('jquery.framework'); // load jquery
                $document->addScript(JURI::base()."components/com_activategrid_pi/views/public_import/tmpl/assets/js/report.js");
                                
                //ActivategridHelper::generateReportPageHTML();
				ActivategridHelper::get_all_social_networks_feeds();
                // Check for errors.
		if (count($errors = $this->get('Errors'))) {
                    throw new Exception(implode("\n", $errors));
		}
                
                $this->_prepareDocument();
                parent::display($tpl);
	}
		
	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();				
	}       
    
}
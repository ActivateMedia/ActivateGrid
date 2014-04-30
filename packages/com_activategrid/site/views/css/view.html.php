<?php

/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
/**
 * View to edit
 */
class ActivategridViewCss extends JViewLegacy {

        protected $items;
	protected $pagination;
	protected $state;
        protected $params;

        
	/**
	 * Display the view
	 */
	public function display($cachable = false, $urlparams = false)
	{            
                $app = JFactory::getApplication();
                $this->params = $app->getParams('com_activategrid');             
                $componentParams = JComponentHelper::getParams('com_activategrid');
                $db = JFactory::getDbo();
                $menu = $app->getMenu();
                $item =& $menu->getItem((int)$_GET["Itemid"]);
                //JHtml::_('jquery.framework');
                $document = JFactory::getDocument();
                //$document->setType('raw');
                echo "html";
	}
}

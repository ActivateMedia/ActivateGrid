<?php

/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
/**
 * View to edit
 */
class ActivategridPiViewImport extends JViewLegacy {

        protected $items;
	protected $pagination;
	protected $state;
        protected $params;

        
	/**
	 * Display the view
	 */
	public function display($cachable = false, $urlparams = false)
	{            
            require_once JPATH_SITE."/administrator/components/com_activategrid/helpers/activategrid.php";
            //ActivategridHelper::DLog($_POST);
            $action = htmlspecialchars($_POST["action"]);
            $allowedActions = array("get_twitter", "get_facebook", "get_storify", "get_instagram");
            if(in_array($action, $allowedActions))
            {
                if($action == $allowedActions[0])
                    ActivategridHelper::get_twitter();
                if($action == $allowedActions[1])
                    ActivategridHelper::get_facebook();
                if($action == $allowedActions[2])
                    ActivategridHelper::get_storify();
                if($action == $allowedActions[3])
                    ActivategridHelper::get_instagram();
            }
            else
            {
                // Forbidden Access
                echo "Forbidden Access";
            }                
        }                                	
}

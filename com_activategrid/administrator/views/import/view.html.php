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
class ActivategridViewImport extends JViewLegacy {

        protected $items;
	protected $pagination;
	protected $state;
        protected $params;

        
	/**
	 * Display the view
	 */
	public function display($cachable = false, $urlparams = false)
	{                            
                echo "Use raw format";
	}
}

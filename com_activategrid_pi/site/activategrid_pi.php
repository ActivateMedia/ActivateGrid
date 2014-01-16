<?php
/**
 * @version     1.0.0
 * @package     com_activategrid_pi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('ActivateGridPi');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

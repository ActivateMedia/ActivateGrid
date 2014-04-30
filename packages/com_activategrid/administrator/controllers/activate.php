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

jimport('joomla.application.component.controllerform');

/**
 * Activate controller class.
 */
class ActivategridControllerActivate extends JControllerForm
{

    function __construct() {
        $this->view_list = 'activates';
        parent::__construct();
    }

}
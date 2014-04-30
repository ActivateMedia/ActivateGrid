<?php
/**
 * @version     1.0.0
 * @package     com_binoculars
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class ActivateGridPIController extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/activategrid_pi.php';

		$view = JFactory::getApplication()->input->getCmd('view', 'public_import');
                JFactory::getApplication()->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
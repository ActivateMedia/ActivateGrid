<?php
/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <info@activatemedia.co.uk> - http://activatemedia.co.uk
 */


// No direct access
defined('_JEXEC') or die;

class ActivategridController extends JControllerLegacy
{
    protected $default_view = 'activategrid';
    
    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
            require_once JPATH_COMPONENT.'/helpers/activategrid.php';

            $view = $this->input->get('view', $default_view);
            
            JFactory::getApplication()->input->set('view', $view);
            
            parent::display($cachable, $urlparams);

            return $this;
    }
}

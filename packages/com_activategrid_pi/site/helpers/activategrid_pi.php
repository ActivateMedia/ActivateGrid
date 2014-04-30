<?php
/**
 * @version     1.0.0
 * @package     com_activategrid_pi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <info@activatemedia.co.uk> - http://activatemedia.co.uk
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Binoculars helper.
 */
class ActivateGridPiHelper
{       
        public function debug($str)
        {
            if(is_array($str))
                echo "<pre>".print_r($str,true)."</pre>";
            else if(is_object($str))
                echo "<pre>".print_r($str,true)."</pre>";
            else
                echo "<pre>".$str."</pre>";
        }
        
}

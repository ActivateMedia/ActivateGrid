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
class ActivategridViewStorifyinit extends JViewLegacy
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
                $app = JFactory::getApplication();            
                $componentParams = JComponentHelper::getParams('com_activategrid');  
                
                $storify_config = array("api_key"  => $componentParams->get('storify_api_key',  ""),
                                        "username" => $componentParams->get('storify_username', ""),
                                        "password" => $componentParams->get('storify_password', ""));        
                
                
                if(!empty($storify_config["api_key"]) && !empty($storify_config["username"]) && !empty($storify_config["password"]))
                {
                    $url = 'https://api.storify.com/v1/auth';
                    $data = array('username' => $storify_config["username"], 'password' => $storify_config["password"], 'api_key' => $storify_config["api_key"]);

                    // use key 'http' even if you send the request to https://...
                    $options = array(
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data),
                        ),
                    );
                    $context  = stream_context_create($options);
                    $result = file_get_contents($url, false, $context);
                    $storify = json_decode($result);
                    $storify_token   = $storify->content->_token;
                    $storify_website = $storify->content->website;

                    if(!empty($storify_token))
                    {
                        // Authorized App, I have to store the 'access token' in com_config
                        //I need username - ActivategridHelper::storeParam("storify_username", "Credentials need only once, so they were deleted for securiy");
                        ActivategridHelper::storeParam("storify_password", " ");
                        ActivategridHelper::storeParam("storify_token", $storify_token);
                        ActivategridHelper::storeParam("storify_website", $storify_website);
                        ActivategridHelper::displayMessage("message", @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_OK));
                        echo @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_ACTIONS);
                    }
                    else
                    {
                        // Something wrong in the HTTP/POST request - I haven't the access token
                        // Errors - App not authorized
                        ActivategridHelper::displayMessage("error", @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_FAIL));
                        echo @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_ACTIONS);
                    }
                }
                else
                {
                    /* Storify is not setup correctly, some informations are missing */
                    echo "<a href='index.php?option=com_config&view=component&component=com_activategrid'><button class='btn btn-danger'>";                   
                    echo @JText::_(COM_ACTIVATEGRID_CONFIG_STORIFY_SETUP_PLEASE);
                    echo "</button></a>\n";
                }                
                
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
}

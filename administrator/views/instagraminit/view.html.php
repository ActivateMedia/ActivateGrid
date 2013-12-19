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
class ActivategridViewInstagraminit extends JViewLegacy
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
                
                $instagram_config = array("client_id"     => $componentParams->get('instagram_client_id', ""),
                                          "client_secret" => $componentParams->get('instagram_client_secret', ""),
                                          "redirect_uri"  => $componentParams->get('instagram_redirect_uri', ""));                
                                                               
                if(!isset($_GET["code"]))
                {
                        if(isset($instagram_config["client_id"]) && isset($instagram_config["client_secret"]) && isset($instagram_config["redirect_uri"]))
                        {
                            $client_id     = $instagram_config["client_id"];
                            $client_secret = $instagram_config["client_secret"];
                            $redirect_uri  = $instagram_config["redirect_uri"];                     
                            $urlGenerated = "https://api.instagram.com/oauth/authorize/?client_id=".$client_id."&redirect_uri=".$redirect_uri."&response_type=code";
                            echo "<h3>URL Generating...</h3>";
                            echo "<h3>DONE!</h3>";
                            echo "<a href='".$urlGenerated."'><button class='btn btn-success'>";
                            echo @JText::_(COM_ACTIVATEGRID_CONFIG_INSTAGRAM_AUTHORIZE);
                            echo "</button></a>\n";
                            
                            echo "<a href='".JURI::root()."administrator/index.php?option=com_config&view=component&component=com_activategrid"."'><button class='btn'>";
                            echo @JText::_(COM_ACTIVATEGRID_STRINGS_CANCEL);
                            echo "</button></a>\n";
                        }
                        else
                        {                            
                            echo "<a href='index.php?option=com_config&view=component&component=com_activategrid'><button class='btn btn-danger'>";                   
                            echo @JText::_(COM_ACTIVATEGRID_CONFIG_INSTAGRAM_SETUP_PLEASE);
                            echo "</button></a>\n";
                        }
                }
                else
                {                    
                    require JPATH_COMPONENT.'/libs/instagram.class.php';
                    $code = $_GET['code'];
                    
                    $client_id     = $instagram_config["client_id"];
                    $client_secret = $instagram_config["client_secret"];
                    $redirect_uri  = $instagram_config["redirect_uri"];          
                            
                    $instagram = new Instagram(array(
                      'apiKey'      => $client_id,
                      'apiSecret'   => $client_secret,
                      'apiCallback' => $redirect_uri
                    ));

                    $data = $instagram->getOAuthToken($code);
                    //echo "<pre>".print_r($data,true)."</pre>";
                                        
                    if(isset($data->error_type))
                    {
                        // Errors - App not authorized
                        echo "<div>Error - ".$data->error_type."</div>";
                        echo "<div>".$data->error_message."</div>";
                    }
                    else
                    {    
                        // Authorized App, I have to store the 'access token' in com_config with the others Instagram API Keys
                        $accessToken = $data->access_token;
                        $username = $data->user->username;
                        ActivategridHelper::instagramStoreAccessToken($accessToken);
                        ActivategridHelper::instagramStoreUsername($username);
                        ActivategridHelper::displayMessage("message", @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_OK));
                        echo @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_ACTIONS);
                        
                        //header("location: ".JURI::root()."administrator/index.php?option=com_config&view=component&component=com_activategrid");
                    }
                    
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

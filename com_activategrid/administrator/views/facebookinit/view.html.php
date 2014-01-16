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
class ActivategridViewFacebookinit extends JViewLegacy
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
                
                $facebook_config =  array("appId"     => $componentParams->get('facebook_app_id', ""),
                                          "secret"    => $componentParams->get('facebook_app_secret', ""));                
                                                
                //ActivategridHelper::DLog($facebook_config);                                      
                if($facebook_config["appId"]!="" && $facebook_config["secret"]!="")
                {
                    ActivategridHelper::storeParam("facebook_access_token", "");
                    ActivategridHelper::storeParam("facebook_username_id", "");
                            
                    require JPATH_COMPONENT.'/libs/facebook-php-sdk/facebook.php';
                    $facebook = new Facebook($facebook_config);
                    $user_id = $facebook->getUser();
                    if( $user_id )
                    {
                        
                        $access_token = $facebook->getAccessToken();
                        if($access_token != "")
                        {
                            $fql = 'SELECT username from user where uid = ' . $user_id;
                            $ret_obj = $facebook->api(array(
                                   'method' => 'fql.query',
                                   'query' => $fql,
                            ));                            
                            ActivategridHelper::storeParam("facebook_access_token", $access_token);
                            ActivategridHelper::storeParam("facebook_username_id", $user_id);
                            ActivategridHelper::storeParam("facebook_username", $ret_obj[0]["username"]);
                            ActivategridHelper::displayMessage("message", @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_OK));
                            echo @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_ACTIONS);
                        }
                        else
                        {
                            ActivategridHelper::displayMessage("error", @JText::_(COM_ACTIVATEGRID_CONFIG_AUTHORIZE_FAIL)."<br/>".$e->getType()."<br/>".$e->getMessage());
                        }
                    }  
                    else
                    {                        
                        $login_url = $facebook->getLoginUrl(array('scope' => 'read_stream,offline_access'));
                        echo "<h3>URL Generating...</h3>";
                        echo "<h3>DONE!</h3>";
                        echo "<a href='".$login_url."'><button class='btn btn-success'>";
                        echo @JText::_(COM_ACTIVATEGRID_CONFIG_FACEBOOK_AUTHORIZE);
                        echo "</button></a>\n";
                        
                        echo "<a href='".JURI::root()."administrator/index.php?option=com_config&view=component&component=com_activategrid"."'><button class='btn'>";
                        echo @JText::_(COM_ACTIVATEGRID_STRINGS_CANCEL);
                        echo "</button></a>\n";

                    }
                }
                else
                {     
                    echo "<a href='index.php?option=com_config&view=component&component=com_activategrid'><button class='btn btn-danger'>";                   
                    echo @JText::_(COM_ACTIVATEGRID_CONFIG_FACEBOOK_SETUP_PLEASE);
                    echo "</button></a>\n";
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

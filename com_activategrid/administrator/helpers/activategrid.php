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
define('DS','/');
        
/**
 * Activategrid helper.
 */
class ActivategridHelper
{                                                     
        public static function checkFoldersPermissions($path)
        {
            if(is_writable($path)) return true;
            else return false;
        }
    
        public static function checkActiveSocialNetworks()
        {
            $componentParams = JComponentHelper::getParams('com_activategrid');             
            $switches = array("twitter"   => $componentParams->get('switch_channel_twitter',  false),
                              "instagram" => $componentParams->get('switch_channel_instagram',  false),
                              "facebook"  => $componentParams->get('switch_channel_facebook',  false),
                              "storify"   => $componentParams->get('switch_channel_storify',  false));
            
            $checkAllDisables = array_unique($switches);            
            if(count($checkAllDisables)==1 && $switches["twitter"]==false) {
                echo JText::_("COM_ACTIVATEGRID_NO_FEEDS_IMPORT");
                echo '<p>&nbsp;</p>';
            }
        }
        
        public static function get_all_social_networks_feeds()
        {
            self::checkActiveSocialNetworks();
            $componentParams = JComponentHelper::getParams('com_activategrid');     
            $switches = array("twitter"   => $componentParams->get('switch_channel_twitter',  false),
                              "instagram" => $componentParams->get('switch_channel_instagram',  false),
                              "facebook"  => $componentParams->get('switch_channel_facebook',  false),
                              "storify"   => $componentParams->get('switch_channel_storify',  false));
            
            if($switches["twitter"]) self::get_twitter();
            if($switches["instagram"]) self::get_instagram();
            if($switches["facebook"]) self::get_facebook();
            if($switches["storify"]) self::get_storify();
        }


        public static function checkIfActiveHaveCorrectAPI()
        {
            /*
            $componentParams = JComponentHelper::getParams('com_activategrid');    
            $switches = array("twitter"   => $componentParams->get('switch_channel_twitter',  false),
                              "instagram" => $componentParams->get('switch_channel_instagram',  false),
                              "facebook"  => $componentParams->get('switch_channel_facebook',  false),
                              "storify"   => $componentParams->get('switch_channel_storify',  false));            
            
            
            $api_check = array("twitter_1"   => $componentParams->get('twitter_access_token',  false),
                               "twitter_2"   => $componentParams->get('twitter_access_secret',  false),
                               "twitter_3"   => $componentParams->get('twitter_consumer_secret',  false),
                               "twitter_4"   => $componentParams->get('twitter_consumer_key',  false),
                
                );            
            
            $checkAllDisables = array_unique($switches);            
            if(count($checkAllDisables)==1 && $switches["twitter"]==false) {
                echo JText::_("COM_ACTIVATEGRID_NO_FEEDS_IMPORT");
                echo '<p>&nbsp;</p>';
            }
             * 
             */
        }
        
        public static function saveConfig()
        {
            $db = JFactory::getDbo();
            $jinput = JFactory::getApplication()->input;      
            $categories = self::getCategories();                        
            $properties = array();
            // Categories colors
            foreach($categories as $category)
            {
                $propertyName_cti = "cti_".$category->id; // title color
                $propertyName_cte = "cte_".$category->id; // text color
                $propertyName_ca = "ca_".$category->id;   // a color
                $propertyName_cbg = "cbg_".$category->id; // background color
                $propertyName_cbs = "cbs_".$category->id; // border size 
                $propertyName_cbr = "cbr_".$category->id; // border radius 
                $propertyName_cbc = "cbc_".$category->id; // border color
                $propertyName_cfs = "cfs_".$category->id; // font size
                $propertyName_ctmtb = "ctmtb_".$category->id; // text margins
                $propertyName_ctmlr = "ctmlr_".$category->id; // text margins
                $properties[$propertyName_cti] = $jinput->get($propertyName_cti, '', 'str');
                $properties[$propertyName_cte] = $jinput->get($propertyName_cte, '', 'str');
                $properties[$propertyName_ca] = $jinput->get($propertyName_ca, '', 'str');
                $properties[$propertyName_cbg] = $jinput->get($propertyName_cbg, '', 'str');
                $properties[$propertyName_cbs] = $jinput->get($propertyName_cbs, '0', 'str');                
                $properties[$propertyName_cbr] = $jinput->get($propertyName_cbr, '0', 'str');                
                $properties[$propertyName_cbc] = $jinput->get($propertyName_cbc, '0', 'str');                
                $properties[$propertyName_cfs] = $jinput->get($propertyName_cfs, '0', 'str');                
                $properties[$propertyName_ctmtb] = $jinput->get($propertyName_ctmtb, '0', 'str');                
                $properties[$propertyName_ctmlr] = $jinput->get($propertyName_ctmlr, '0', 'str');                
            }

            foreach($properties as $propertyName => $value)
            {
                $query = $db->getQuery(true);
                if(self::checkExistingConfig($propertyName))
                {
                    $query = "UPDATE #__activategrid SET value='".$value."' WHERE name='".$propertyName."' LIMIT 1;";
                    //echo "UPDATE -> ".$propertyName. " value=".$value."<br/>";
                }
                else
                {
                    $query = "INSERT INTO #__activategrid (context, name, value) VALUES ('category_color', '".$propertyName."', '".$value."');";
                    //echo "INSERT -> ".$propertyName. " value=".$value."<br/>";
                }
                $db->setQuery($query); //insert not empty
                $db->query();
            }
                                  
            echo "<div class='alert alert-success'>".JText::_('COM_ACTIVATEGRID_SAVED_SUCCESS')."</div>\n";
        }
        
        public static function YesNoRadio($id="", $defalt=1, $suffix="")
        {
            $html = "";          
            $html .= "<button type='button' id='".$id."_1' name='$id' class='btn active btn-success $suffix'>Yes</button>\n";            
            $html .= "<button type='button' id='".$id."_0' name='$id' class='btn $suffix'>No</button>\n";

            return $html;
        }
        
        public static function getConfig($context = '')
        {
            $db = JFactory::getDbo();
            if(!empty($context))
                $where = "WHERE context = '$context'";
            else
                $where = "";
            $query = "SELECT * FROM #__activategrid ".$where;
            $db->setQuery($query);
            $db->execute();
            $result = $db->loadObjectList();
            return $result;            
        }
                
        public static function getCategories()
        {
            $db = JFactory::getDBO();
            $query = "SELECT id,title,alias FROM #__categories WHERE extension='com_content';";
            $db->setQuery($query);
            $db->query();
            $results = $db->loadObjectList();   
            //self::DLog($results);
            return $results;
        }                
        
        public static function AdvancedSettingsInterface($doc)
        {                        
            $config = self::getConfig("category_color");
            $categories = self::getCategories();
            $html = "";
            $ids = array();
            
            $first = true;
            foreach($categories as $category)
            {
                 // I get the value from the DB
                if(self::checkExistingConfig("cti_".$category->id))
                {
                    $cti_color = self::checkExistingConfig("cti_".$category->id);
                    if($cti_color == -1) $cti_color = "";
                }
                else
                    $cti_color = "";
                // I get the value from the DB
                if(self::checkExistingConfig("cte_".$category->id))
                {
                    $cte_color = self::checkExistingConfig("cte_".$category->id);
                    if($cte_color == -1) $cte_color = "";
                }
                else
                    $cte_color = "";
                // I get the value from the DB
                if(self::checkExistingConfig("cbg_".$category->id))
                {
                    $cbg_color = self::checkExistingConfig("cbg_".$category->id);
                    if($cbg_color == -1) $cbg_color = "";
                }
                else
                    $cbg_color = "";
                // I get the value from the DB
                if(self::checkExistingConfig("ca_".$category->id))
                {
                    $ca_color = self::checkExistingConfig("ca_".$category->id);
                    if($ca_color == -1) $ca_color = "";
                }
                else
                    $ca_color = "";
                // I get the value from the DB
                if(self::checkExistingConfig("cbs_".$category->id))
                {
                    $cb_size = self::checkExistingConfig("cbs_".$category->id);
                    if($cb_size == -1) $cb_size = "0";
                }
                else
                    $cb_size = "0";
                // I get the value from the DB
                if(self::checkExistingConfig("cbr_".$category->id))
                {
                    $cb_radius = self::checkExistingConfig("cbr_".$category->id);
                    if($cb_radius == -1) $cb_radius = "0";
                }
                else
                    $cb_radius = "0";
                // I get the value from the DB
                if(self::checkExistingConfig("cbc_".$category->id))
                {
                    $cbc_color = self::checkExistingConfig("cbc_".$category->id);
                    if($cbc_color == -1) $cbc_color = "";
                }
                else
                    $cbc_color = "";
                // I get the value from the DB
                if(self::checkExistingConfig("cfs_".$category->id))
                {
                    $cfont_size = self::checkExistingConfig("cfs_".$category->id);
                    if($cfont_size == -1) $cfont_size = "12";
                }
                else
                    $cfont_size = "12";

                // I get the value from the DB
                if(self::checkExistingConfig("ctmtb_".$category->id))
                {
                    $ctext_margins_tb = self::checkExistingConfig("ctmtb_".$category->id);
                    if($ctext_margins_tb == -1) $ctext_margins_tb = "20";
                }
                else
                    $ctext_margins_tb = "20";

                // I get the value from the DB
                if(self::checkExistingConfig("ctmlr_".$category->id))
                {
                    $ctext_margins_lr = self::checkExistingConfig("ctmlr_".$category->id);
                    if($ctext_margins_lr == -1) $ctext_margins_lr = "20";
                }
                else
                    $ctext_margins_lr = "20";
                
                
                $icons_path = "/media/com_activategrid/images/social_icons/";
                $icons = array("instagram"  => $icons_path . "instagram.png",
                                "twitter"  => $icons_path . "twitter.png",
                                "facebook" => $icons_path . "facebook.png",
                                "storify"  => $icons_path . "storify.png");
                
                if($first)
                    $random_image = JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/images/random_images/15.jpg";
                else                        
                    $random_image = JURI::base()."components/com_activategrid/views/advancedsettings/tmpl/assets/images/random_images/".rand(1,15).".jpg";
                $html .= "<h3>".$category->title."</h3>\n";

                $html .= "<table class='table'>\n";
                $html .= "<tr><td><b>Title color:</b></td><td><input type='text' name='cti_".$category->id."' id='slider_cti".$category->id."_titlecolor_".$category->id."' class='cp cTitleColor' style='cursor: pointer' value='".$cti_color."' id='cti".$category->id."' />";
                $html .= "  <td rowspan='7'>\n";
                $html .= "      <div style='float:left' class='gridItem' id='gridItem".$category->id."'>\n";
                $html .= "          <span style='background: url($random_image);'></span>\n";
                $html .= "          <p class='category' id='title_".$category->id."'>".$category->title."</p>\n";
                $html .= "          <p class='text' id='text_".$category->id."'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc <a href='http://activatemedia.co.uk' target='_blank'>malesuada volutpat</a> orci sit amet varius.</p>\n";               
                if(isset($icons[strtolower($category->title)])) $html .= "          <p class='icon-container'><img src='".$icons[strtolower($category->title)]."' class='icon-".strtolower($category->title)."' alt='Logo'></p>\n";
                $html .= "      </div><div style='float:left' class='switches'>\n";
                $html .= "  <span>These buttons works only in this page for testing.</span>\n";
                /* Switches - START */
                $html .= "      <table class='table'>\n";
                $html .= "          <tr><td>Display image:</td><td>".self::YesNoRadio("switch_image_".$category->id, 1, "switch")."</td></tr>\n";
                $html .= "          <tr><td>Display title:</td><td>".self::YesNoRadio("switch_title_".$category->id, 1, "switch")."</td></tr>\n";
                $html .= "          <tr><td>Display text:</td><td>".self::YesNoRadio("switch_text_".$category->id, 1, "switch")."</td></tr>\n";
                $html .= "          <tr><td>Display icon:</td><td>".self::YesNoRadio("switch_icon_".$category->id, 1, "switch")."</td></tr>\n";                
                $html .= "          <tr><td colspan='2'><p><small>".JText::_("COM_ACTIVATEGRID_ADVANCED_CONFIG_PH_1")."</p><p>".JText::_("COM_ACTIVATEGRID_ADVANCED_CONFIG_PH_2")."</p><p>".JText::_("COM_ACTIVATEGRID_ADVANCED_CONFIG_PH_3")."</small></p></td></tr>\n";
                $html .= "     </table>";
                $html .= "   </div></td>\n";
                /* Switches - END */
                $html .= "</tr>\n";
                $html .= "<tr><td><b>Text color:</b></td><td><input type='text' name='cte_".$category->id."' class='cp cTextColor' style='cursor: pointer' value='".$cte_color."' id='slider_cte".$category->id."_textcolor_".$category->id."' /></td></tr>\n";
                $html .= "<tr><td><b>Links color:</b></td><td><input type='text' name='ca_".$category->id."' class='cp cAColor' style='cursor: pointer' value='".$ca_color."' id='slider_ca".$category->id."_acolor_".$category->id."' /></td></tr>\n";
                $html .= "<tr><td><b>Background color:</b></td><td><input type='text' name='cbg_".$category->id."' class='cp cBackgroundColor' style='cursor: pointer' value='".$cbg_color."' id='slider_cbg".$category->id."_backgroundcolor_".$category->id."' /></td></tr>\n";
                // Borders color Start
                $html .= "<tr><td><b>Borders color:</b></td><td><input type='text' name='cbc_".$category->id."' class='cp cBorderColor' style='cursor: pointer' value='".$cbc_color."' id='slider_cbc".$category->id."_bordercolor_".$category->id."' /></td></tr>\n";
                // Border color end                
                //
                // Borders size START
                $html .= "<tr><td><b>Borders size:</b></td><td>
                    <div class='controls controls-row'><div class='span10'><div class='slider'  id='slider_cbs".$category->id."_bordersize_".$category->id."'></div></div>
                    <div class='span2'><input type='text' value='".$cb_size."' class='cBorderSize' style='width:30px' name='cbs_".$category->id."' id='cbs".$category->id."'/></div></form>";
                $html .= "</td></tr>\n";
                // Borders Size END
                //
                // Border Radius START
                $html .= "<tr><td><b>Border Radius:</b></td><td>
                    <div class='controls controls-row'><div class='span10'><div class='slider' id='slider_cbr".$category->id."_bordersradius_".$category->id."'></div></div>
                    <div class='span2'><input type='text' value='".$cb_radius."' class='cBorderRadius' style='width:30px' name='cbr_".$category->id."' id='cbr".$category->id."'/></div></form>";
                $html .= "</td></tr>\n";                   
                // Border Radius END
                // 
                // Font Size START
                $html .= "<tr><td><b>Font Size:</b></td><td>
                    <div class='controls controls-row'><div class='span10'><div class='slider' id='slider_cfs".$category->id."_fontsize_".$category->id."'></div></div>
                    <div class='span2'><input type='text' value='".$cfont_size."' class='cFontSize' style='width:30px' name='cfs_".$category->id."' id='cfs".$category->id."'/></div></form>";
                $html .= "</td></tr>\n";                   
                // Font Size END
                //
                // Text Top/Bottom Margin START
                $html .= "<tr><td><b>Text top margin:</b></td><td>
                    <div class='controls controls-row'><div class='span10'><div class='slider' id='slider_ctmtb".$category->id."_textmarginstb_".$category->id."'></div></div>
                    <div class='span2'><input type='text' value='".$ctext_margins_tb."' class='cTextMarginsTb' style='width:30px' name='ctmtb_".$category->id."' id='ctmtb".$category->id."'/></div></form>";
                $html .= "</td></tr>\n";                   
                // Text Top/Bottom Margin END
                //
                // Text Left/Right Margin START
                $html .= "<tr><td><b>Text Left/Right margin:</b></td><td>
                    <div class='controls controls-row'><div class='span10'><div class='slider' id='slider_ctmlr".$category->id."_textmarginslr_".$category->id."'></div></div>
                    <div class='span2'><input type='text' value='".$ctext_margins_lr."' class='cTextMarginsLr' style='width:30px' name='ctmlr_".$category->id."' id='ctmlr".$category->id."'/></div></form>";
                $html .= "</td></tr>\n";                   
                // Text Left/Right Margin END
                //
                $html .= "</table>\n";
                
                $first = false;
            }                        
            
            $html .= "  </tbody>\n";
            $html .= "</table>\n";
            
            
            $html .= "";            
            return $html;
        }        
        
        private static function checkExistingConfig($name = '')
        {
            $config = self::getConfig();            
            foreach($config as $config_item)
            {       
                
                if($config_item->name == $name)
                {
                    //self::DLog($config_item);
                    if(empty($config_item->value))
                        return -1;
                    else
                        return $config_item->value;
                }
            }
            return false;
        }
        
        
        /**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_ACTIVATEGRID_TITLE_ACTIVATES'),
			'index.php?option=com_activategrid&view=activates',
			$vName == 'activates'
		);

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_activategrid';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
        
        /*
         * Replaces all the URLS, username and hashtags in the tweet with the <a> tag
         */
        private static function tweetURLReplace($tweet_text)
        {
            $tweet_text = preg_replace(
                '@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@',
                '<a href="$1" target="_blank">$1</a>',
                $tweet_text);

            $tweet_text = preg_replace(
                '/@(\w+)/',
                '<a href="http://twitter.com/$1" target="_blank">@$1</a>',
                $tweet_text);

            
            $tweet_text = preg_replace(
                '/\s+#(\w+)/',
                ' <a href="https://twitter.com/search?q=$1&src=hash" target="_blank">#$1</a>',
                $tweet_text);
            
            return $tweet_text;
        }

        
        /*
         * Get stories from Storify and creates the articles in Joomla!
         */
        public static function get_storify()
        {
            $output_html = "";
            $reportCounter = array("old"     => 0,
                                   "success" => 0,
                                   "warning" => 0,
                                   "error"   => 0);
            
            
            $app = JFactory::getApplication();
            $componentParams = JComponentHelper::getParams('com_activategrid'); 
            $db = JFactory::getDBO();
            $storify_config = array("api_key"          => $componentParams->get('storify_api_key',  ""),                                    
                                    "username"         => $componentParams->get('storify_username', ""),
                                    "token"            => $componentParams->get('storify_token', ""),
                                    "website"          => $componentParams->get('storify_website', ""),
                                    "maximum"          => $componentParams->get('storify_maximum', 10),
                                    "autopublish_feed" => $componentParams->get('autopublish_feed', 1),
                                    "caching_images"   => $componentParams->get('storify_pic_save', true),
                                    "images_directory" => $componentParams->get('storify_pic_folder',  JPATH_ROOT.DS."images".DS."storify"));
             
            $stop_import = false;
            
            // Do you want to save the images on the server?
            $images_directory = JPATH_ROOT.DS."images".DS.$storify_config["images_directory"].DS;
            $images_directory_light = DS."images".DS.$storify_config["images_directory"].DS;  
            
            
            if($storify_config["caching_images"])
            {
                // Is the folder writable?
                if(self::checkFoldersPermissions($images_directory))
                {
                    self::makeDir($storify_config["images_directory"]);
                }
                else
                {
                    // Folder not writable! ERROR
                    echo "<button class='btn btn-danger'>Folder (".$images_directory.") not writable.<br/>Please check your file permission.<br/>The permission value for the folder /images should be 757.</button><p>&nbsp;</p>";
                    $stop_import = true;
                }
            }
            
            // I check if the category exists
            $category_id = self::checkCategoryExists("storify");
            if(!$category_id)
            {
                // If autocreate_categories is true I can create the category and save the feed
                //$componentParams->get('autocreate_categories', TRUE)
                $autocreate_categories = true;
                if($autocreate_categories)
                {
                    $category_id = self::createJoomlaCategory("com_content", "Storify", "storify");
                }
                else
                {
                    // The category doesn't exists. Where do I save the article?
                    die();
                }
            }                        
           
            /* If I haven't the user's token - I request it and delete username/password */
            if(!empty($storify_config["token"]) && !$stop_import)
            {                
                /* I have the token - I will request user's stories */
                $url = 'https://api.storify.com/v1/stories/'.$storify_config["username"];
                //$DLog .= "Requesting to... ".$url."\n";
                $data = array();

                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'GET',
                        'content' => http_build_query($data),
                    ),
                );
                $context  = stream_context_create($options);
                $result = self::my_file_get_contents($url, false, $context);
                $storify = json_decode($result);
                
                $stories = $storify->content->stories;
                //self::DLog($stories);
                //die();
                foreach($stories as $story)
                {                          
                    $DLog = "";
                    $url = 'https://api.storify.com/v1/stories/'.$storify_config["username"]."/".$story->slug;
                    $data = array();
                    $options = array (
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'GET',
                            'content' => http_build_query($data),
                        ),
                    );
                    $context  = stream_context_create($options);
                    $result = self::my_file_get_contents($url, false, $context);
                    $story_feeds = json_decode($result);
                    
                    //self::DLog($story_feeds);
                       
                    $story_title = $story_feeds->content->title;
                    $permalink = $story_feeds->content->permalink;
                    $thumbnail = $story_feeds->content->thumbnail;
                    //echo "Thumbnail ----> ". $thumbnail." <br>";
                    if($thumbnail == "http://storify.com/public/img/default-thumb.gif") $thumbnail = "";
                    $creation_date = $story_feeds->content->date->published;
                    $author = $story_feeds->content->author->username;
                    $image_intro_caption = $story_feeds->content->elements[0]->type;;
                    $sid = $story_feeds->content->sid;
                    
                     $report_img = "";
                    if(strlen($thumbnail) > 0)
                    {
                        //$report_img = "<strong>1 image</strong>";
                        $report_img = "<div id='popover_".$story->sid."' class='btn btn-link popover-img'  rel='popover' data-content='{$thumbnail}' data-placement='left' data-original-title=''>1 image</div>";
                        /*if(!$caching_images)
                            $report_img = "<img style='height:60px' src='{$picURL}' />";
                        else
                            $report_img = "<img style='height:60px' src='".JURI::root().$picURL."' />";*/
                    }
                                
                    if(!self::checkArticleAlreadyImported($sid))
                    {
                        if($storify_config["caching_images"])
                        {
                            if(!empty($thumbnail))
                            {                                
                                $thumbnail = $images_directory_light.self::savePictureFromURL($thumbnail, $images_directory);
                                $DLog .= "<br/><a href='".$thumbnail."'><img style='max-width: 220px' src=\"$thumbnail\"></a><br/>";  
                            }
                        }      

                        $data = array (
                                'catid'      => $category_id,
                                'title'      => "Storify (#".$sid.")".self::cutFeedTitle($story_title, 50),
                                'introtext'  => self::cutFeedTitle($story_title, 50),
                                'fulltext'   => $story_title,
                                'created'    => $creation_date,
                                'state'      => $storify_config["autopublish_feed"],
                                'urls'       => '{"urla":"'.htmlspecialchars($permalink).'","urlatext":"","targeta":"1","urlb":false,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}',
                                'metadata'   => '{{"robots":"Activategrid","author":"'.$author.'","rights":"","xreference":"'.$permalink.'"}}',
                                'xreference' => $sid,
                                'images'     => '{"image_intro":'.json_encode($thumbnail).',"float_intro":"","image_intro_alt":"","image_intro_caption":"'.$image_intro_caption.'","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}',
                            );                                                                        


                                $article_import = self::createJoomlaArticle($data);

                                if($article_import===true)
                                {         
                                    $url = self::checkArticleAlreadyImported($sid);
                                    $output_html .= "<div class='row-fluid'>\n
                                                        <div class='span12'>\n
                                                            <div class='span1'>\n
                                                                <span class='badge badge-success'><span class='icon-ok report-icon'></span></span>\n
                                                            </div>\n
                                                            <div class='span8'><small>".self::cutFeedTitle($story_title, 100)."</small></div>\n
                                                            <div class='span2'>".$report_img."</div>\n
                                                            <div class='span1'><a href='{$url}' targat='_blank'><button class='btn btn-mini'>Edit</button></a></div>\
                                                        </div>\n
                                                     </div>\n";
                                    $reportCounter["success"]++;

                                }
                                else
                                {
                                    $output_html .= "<div class='row-fluid'>\n
                                                        <div class='span12'>\n
                                                            <div class='span1'>\n
                                                                <span class='badge badge-important'><span class='icon-remove report-icon'></span></span>\n
                                                            </div>\n
                                                            <div class='span8'><small>".self::cutFeedTitle($story_title, 100)."</small></div>\n
                                                            <div class='span2'>{$report_img}</div>\n
                                                            <div class='span1'></div>\n
                                                        </div>\n
                                                     </div>\n";
                                    $reportCounter["error"]++;
                                }
                        }
                        else {
                            $url = self::checkArticleAlreadyImported($sid);
                            $output_html .= "<div class='row-fluid'>\n
                                                    <div class='span12'>\n
                                                        <div class='span1'>\n
                                                            <span class='badge badge-info'><span class='icon-ok report-icon'></span></span>\n
                                                        </div>\n
                                                        <div class='span8'><small>".self::cutFeedTitle($story_title, 100)."</small></div>\n
                                                        <div class='span2'>".$report_img."</div>\n
                                                        <div class='span1'><a href='{$url}' targat='_blank'><button class='btn btn-mini'>Edit</button></a></div>\n
                                                    </div>\n
                                                 </div>\n";
                              $reportCounter["old"]++;
                        }
                        
                   /* $article_import = self::createJoomlaArticle($data);

                    if($article_import===true)        
                        self::DLog($DLog." <button class='btn btn-success'>Added in Joomla!</button><br/>".self::cutFeedTitle($story_title, 30));
                    else
                        self::DLog($DLog." <button class='btn btn-danger'>Error! ".$article_import."</button><br/>".self::cutFeedTitle($story_title, 30));
                    */
                    /*
                    $elements = $story_feeds->content->elements;                    
                    foreach($elements as $element)
                    {     
                        self::DLog($element);
                       
                        if(isset($element->source->username))
                        {
                            
                        }
                        
                        $DLog = "";                        
                        $elementDataArray = (array)$element->data;
                        
                        // I can have data[link|video|image|text]
                        // Thumbnail search 
                        $ArrayKeys = array_keys($elementDataArray);
                        if($element->type == "image")
                            $thumbnail = $elementDataArray[$ArrayKeys[0]]->src;
                        else if($element->type == "link" || $element->type == "video")
                            $thumbnail = $elementDataArray[$ArrayKeys[0]]->thumbnail;
                        else
                            $thumbnail = "";
                        
//                        self::DLog($thumbnail);
//                        die();
                        // Story's title searching..
                        if($element->type == "text")
                             $story_title = $elementDataArray[$ArrayKeys[0]];
                        else if ($element->type == "image")
                            $story_title = $elementDataArray[$ArrayKeys[0]]->caption;                                                    
                        else
                            $story_title = $elementDataArray[$ArrayKeys[0]]->title;                                                    
                             
                        $image_intro_caption = $element->type;
                        
                         $story_title = $story->title;
                        if($storify_config["caching_images"])
                        {
                            if(!empty($thumbnail))
                            {                                
                                $thumbnail = $images_directory_light.self::savePictureFromURL($thumbnail, $images_directory);
                                $DLog .= "<br/><a href='".$thumbnail."'><img style='max-width: 220px' src=\"$thumbnail\"></a><br/>";  
                            }
                        }                                                
                        
                        $permalink = $element->permalink;
                        $creation_date = date("Y-m-d H:i:s", strtotime($element->added_at));

                        $data = array (
                            'catid'      => $category_id,
                            'title'      => "Storify (#".$element->id.")".self::cutFeedTitle($story_title, 50),
                            'introtext'  => self::cutFeedTitle($story_title, 50),
                            'fulltext'   => $story_title,
                            'created'    => $creation_date,
                            'state'      => $storify_config["autopublish_feed"],
                            'urls'       => '{"urla":"'.htmlspecialchars($permalink).'","urlatext":"","targeta":"1","urlb":false,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}',
                            'metadata'   => '{{"robots":"Activategrid","author":"'.$element->title.'","rights":"","xreference":"'.$element->source->href.'"}}',
                            'xreference' => $element->id,
                            'images'     => '{"image_intro":'.json_encode($thumbnail).',"float_intro":"","image_intro_alt":"","image_intro_caption":"'.$image_intro_caption.'","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}',
                        );                                                                        
                        
                        $article_import = self::createJoomlaArticle($data);

                        if($article_import===true)        
                            self::DLog($DLog." <button class='btn btn-success'>Added in Joomla!</button><br/>".self::cutFeedTitle($story_title, 30));
                        else
                            self::DLog($DLog." <button class='btn btn-danger'>Error! ".$article_import."</button><br/>".self::cutFeedTitle($story_title, 30));
                    }
                    */
                }
            }
            $output_html .= "<script>setCounter('storify', 'old', ".$reportCounter["old"].");</script>\n"; 
            $output_html .= "<script>setCounter('storify', 'warning', ".$reportCounter["warning"].");</script>\n"; 
            $output_html .= "<script>setCounter('storify', 'error', ".$reportCounter["error"].");</script>\n"; 
            $output_html .= "<script>setCounter('storify', 'success', ".$reportCounter["success"].");</script>\n"; 
//            $output_html = self::generateReportBars(count($stories), $reportCounter).$output_html;
            echo $output_html;
        }
        
        /* Fix instagram image URL - for example: //instagram.com/p/iX327AH-ou/media
         * I haven't any file ext, and when I save the file, I have some problem.
         * To solve this, I will add a 'fake .jpg ext' to the filename
         */
        public static function fixImageURLWithoutFileExtension($path)
        {
            $filename = basename($path);
            $explode = explode(".", $filename);
            if(count($explode) == 1)
            {
                // there isn't any file ext, I will append it
                return basename($path).".jpg";
            }
            else return basename($path);
        }                
        
        public static function html_collapse_init()
        {
            echo "\n\n<div class='accordion' id='accordion2'>\n";
        }
        public static function html_collapse_close()
        {
            echo "</div>\n";
        }
        
        private static function html_collapse_header($name)
        {            
            echo "<div class='accordion-group'>\n";
            echo "  <div class='accordion-heading'>\n";
            echo "      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse_{$name}'>\n";
            echo "          <div class='controls controls-row has-spinner' id='controls_{$name}'>\n";
            echo "              <div class='span2'><h3>\n";
            echo "                 <span class='badge badge-info' id='feedItemsImport_old_{$name}'>0</span>\n";
            echo "                 <span class='badge badge-success badge-left-margin' id='feedItemsImport_success_{$name}'>0</span>\n";
            echo "                 <span class='badge badge-warning badge-left-margin' id='feedItemsImport_warning_{$name}'>0</span>\n";
            echo "                 <span class='badge badge-important badge-left-margin' id='feedItemsImport_error_{$name}'>0</span>\n";
            echo "              </h3></div>\n";
            echo "              <span class='span1'><h3><span class='spinner' id='spinner_{$name}'><i class='icon-spin icon-refresh' id='loader_{$name}'></i></h3></span></span>\n";
            echo "              <span class='span9'><h3>".ucfirst($name)."</h3></span>\n";
            echo "          </div>\n";
            echo "      </a>\n";
            echo "  </div>\n";                 
                          
            self::html_collapse_body($name);            
            echo "</div>\n";               
        }

        private static function html_collapse_body($name)
        {
            echo "<div id='collapse_{$name}' class='accordion-body collapse'>\n";
            echo "  <div class='accordion-inner' id='accordion_{$name}'>\n";
            echo "      Importing feed items...\n";
            echo "  </div>\n";
            echo "</div>\n";
                    
        }

        
        public static function generateReportPageHTML()
        {
            $componentParams = JComponentHelper::getParams('com_activategrid');             
            $switches = array("twitter"   => $componentParams->get('switch_channel_twitter',  false),
                              "instagram" => $componentParams->get('switch_channel_instagram',  false),
                              "facebook"  => $componentParams->get('switch_channel_facebook',  false),
                              "storify"   => $componentParams->get('switch_channel_storify',  false));
                        
            self::checkActiveSocialNetworks();
          //  self::checkIfActiveHaveCorrectAPI();
            
            self::html_collapse_init();
            foreach($switches as $feedName => $feedActive)
            {
                if($feedActive)
                {
                    //echo $feedName;
                    self::html_collapse_header($feedName);
                }
            }
            self::html_collapse_close();
        }
        
        
        private static function generateReportBars($total_items, $itemsResults)
        {
            
            if(!is_array($itemsResults)) return false;
            else if($total_items <= 0) return false;
            else
            {
                $olds      = $itemsResults["old"];
                $successes = $itemsResults["success"];
                $warnings  = $itemsResults["warning"];
                $errors    = $itemsResults["error"];
                
                $percentages = array("old"     => $olds/$total_items*100,
                                     "success" => $successes/$total_items*100,
                                     "warning" => $warnings / $total_items*100,
                                     "error"   => $errors / $total_items*100);
                
                echo "<div class='progress'>\n";
                echo "  <div class='bar progress-striped bar-info' style='width: ".$percentages["old"]."%;'>$olds</div>\n";
                echo "  <div class='bar progress-striped bar-success' style='width: ".$percentages["success"]."%;'>$successes</div>\n";
                echo "  <div class='bar progress-striped bar-warning' style='width: ".$percentages["warning"]."%;'>$warnings</div>\n";
                echo "  <div class='bar progress-striped bar-danger' style='width: ".$percentages["error"]."%;'>$errors</div>\n";
                echo "</div>\n";
            }
        }
        
        /*
         * Get tweets and creates the articles in Joomla!
         */
        public static function get_twitter()
        {            
            $output_html = "";
            $reportCounter = array("old"     => 0,
                                   "success" => 0,
                                   "warning" => 0,
                                   "error"   => 0);
            
            $app = JFactory::getApplication();
            
            $componentParams = JComponentHelper::getParams('com_activategrid');            
            $db = JFactory::getDBO();
            $twitter_config = array("consumer_key"     => $componentParams->get('twitter_consumer_key', ""),
                                    "consumer_secret"  => $componentParams->get('twitter_consumer_secret', ""),
                                    "access_token"     => $componentParams->get('twitter_access_token', ""),
                                    "access_secret"    => $componentParams->get('twitter_access_secret', ""),
                                    "username"         => $componentParams->get('twitter_username', ""),
                                    "maximum"          => $componentParams->get('twitter_maximum', 10),
                                    "caching"          => $componentParams->get('twitter_caching', 60),
                                    "url_replace"      => $componentParams->get('twitter_url_replace', 1),
                                    "autopublish_feed" => $componentParams->get('autopublish_feed', 1));
            
            // I check if the category exists
            $category_id = self::checkCategoryExists("twitter");
            if(!$category_id)
            {
                // If autocreate_categories is true I can create the category and save the feed
                //$componentParams->get('autocreate_categories', TRUE)
                $autocreate_categories = true;
                if($autocreate_categories)
                {
                    $category_id = self::createJoomlaCategory("com_content", "Twitter", "twitter");
                }
                else
                {
                    // The category doesn't exists. Where do I save the article?
                    die();
                }
            }

            // API Keys
            $consumerKey       = $twitter_config["consumer_key"];
            $consumerSecret    = $twitter_config["consumer_secret"];
            $accessToken       = $twitter_config["access_token"];
            $accessTokenSecret = $twitter_config["access_secret"];

            // Details
            $username    = $twitter_config["username"];
            $maximum     = $twitter_config["maximum"];
            $caching     = $twitter_config["caching"];
            $url_replace = $twitter_config["url_replace"];
                   
            /*
             * if the username field contains hash, i consider that like an hashtags list. I will
             * explode and search for the hashtags present in the strings.
             * if there isn't any hash, i consider it as a twitter username.
             */
            $twitter_mode = "";
            $hashtags_querystring = "";
            if(strstr($username, '#') == false)
            {
                // username!
                $hashtags_querystring = $username;
                $twitter_mode = "USER";
            }
            else
            {
                // Hashtags! 1 or more?
                $hashtags = explode('#', $username);                
                foreach ($hashtags as $hashtag)
                {
                    if(!empty($hashtag))
                        $hashtags_querystring .= $hashtag." ";
                }
                $hashtags_querystring = preg_replace('/\s+/', ' ', $hashtags_querystring);
                $hashtags_querystring = trim($hashtags_querystring);   
                $hashtags_querystring = rawurlencode($hashtags_querystring);
                $twitter_mode = "HASHTAG";
            }
            
            //$filename = basename(__FILE__, '.php').'.json';
            //$filetime = file_exists($filename) ? filemtime($filename) : time() - $caching - 1;
            $filetime = time() - $caching - 1;
                        
            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';            
            $base = 'GET&'.rawurlencode($url).'&'.rawurlencode("count={$maximum}&oauth_consumer_key={$consumerKey}&oauth_nonce={$filetime}&oauth_signature_method=HMAC-SHA1&oauth_timestamp={$filetime}&oauth_token={$accessToken}&oauth_version=1.0&screen_name={$username}");
            $key = rawurlencode($consumerSecret).'&'.rawurlencode($accessTokenSecret);
            $signature = rawurlencode(base64_encode(hash_hmac('sha1', $base, $key, true)));
            $oauth_header = "oauth_consumer_key=\"{$consumerKey}\", oauth_nonce=\"{$filetime}\", oauth_signature=\"{$signature}\", oauth_signature_method=\"HMAC-SHA1\", oauth_timestamp=\"{$filetime}\", oauth_token=\"{$accessToken}\", oauth_version=\"1.0\", ";

            $curl_request = curl_init();
            curl_setopt($curl_request, CURLOPT_HTTPHEADER, array("Authorization: Oauth {$oauth_header}", 'Expect:'));
            curl_setopt($curl_request, CURLOPT_HEADER, false);
            curl_setopt($curl_request, CURLOPT_URL, $url."?screen_name={$username}&count={$maximum}");
            curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl_request);

            // Hashtags
            //$username = rawurlencode($username);
            //die($username);
            
            if($twitter_mode == "USER")
            {
                $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
                $base = 'GET&'.rawurlencode($url).'&'.rawurlencode("count={$maximum}&oauth_consumer_key={$consumerKey}&oauth_nonce={$filetime}&oauth_signature_method=HMAC-SHA1&oauth_timestamp={$filetime}&oauth_token={$accessToken}&oauth_version=1.0&screen_name={$hashtags_querystring}");
            }
            else
            {
                $url = 'https://api.twitter.com/1.1/search/tweets.json';
                $base = 'GET&'.rawurlencode($url).'&'.rawurlencode("oauth_consumer_key={$consumerKey}&oauth_nonce=".md5($filetime)."&oauth_signature_method=HMAC-SHA1&oauth_timestamp={$filetime}&oauth_token={$accessToken}&oauth_version=1.0&q=".$hashtags_querystring."&results_per_page={$maximum}");
            }
            $key = rawurlencode($consumerSecret).'&'.rawurlencode($accessTokenSecret);
            $signature = rawurlencode(base64_encode(hash_hmac('sha1', $base, $key, true)));
            
            //print_r($base);
            
            if($twitter_mode == "USER")
            {
                $oauth_header = "oauth_consumer_key=\"{$consumerKey}\", oauth_nonce=\"{$filetime}\", oauth_signature=\"{$signature}\", oauth_signature_method=\"HMAC-SHA1\", oauth_timestamp=\"{$filetime}\", oauth_token=\"{$accessToken}\", oauth_version=\"1.0\", ";
            }
            else
            {
                $oauth_header = "oauth_consumer_key=\"{$consumerKey}\", oauth_nonce=\"".md5($filetime)."\", oauth_signature=\"{$signature}\", oauth_signature_method=\"HMAC-SHA1\", oauth_timestamp=\"{$filetime}\", oauth_token=\"{$accessToken}\", oauth_version=\"1.0\"";
            }                                                           
            
            $curl_request = curl_init();
            curl_setopt($curl_request, CURLOPT_HTTPHEADER, array("Authorization: Oauth {$oauth_header}", 'Expect:'));
            curl_setopt($curl_request, CURLOPT_HEADER, false);
            if($twitter_mode == "USER")
            {
                curl_setopt($curl_request, CURLOPT_URL, $url."?screen_name={$hashtags_querystring}&count={$maximum}");
            } else {
                curl_setopt($curl_request, CURLOPT_URL, $url."?q=".$hashtags_querystring."&results_per_page={$maximum}");
            }
            curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl_request);
                      
            $jTfeeds = json_decode($response);
            
            if($twitter_mode == "HASHTAG")
                $jTfeeds = $jTfeeds->statuses;
            
            if(isset($jTfeeds->errors))
            {
                foreach($jTfeeds->errors as $twitter_error)
                {
                    self::displayMessage("error", "<b>Twitter error</b> (code = ".$twitter_error->code.")<br/>".$twitter_error->message);
                }
            }
            
            $reportCounter["warning"]=2;
            foreach($jTfeeds as $tweet)
            {            
                $thisTweetIsReply = false;
                if($componentParams->get('twitter_import_replies', "0") == 0)
                {
                    // No tweets as replies!
                    if(substr($tweet->text,0,1)=="@")
                    {
                        $thisTweetIsReply = true;                                                                             
                    }
                }
                
                if(isset($tweet->id_str))
                {
                    // If the item has not been imported yet
                    if($thisTweetIsReply)
                    {
                        // No import!
                        $output_html .= "<div class='row-fluid'>\n
                                                    <div class='span12'>\n
                                                        <div class='span1'>\n
                                                            <span class='badge badge-warning'><span class='icon-remove report-icon'></span></span>\n
                                                        </div>\n
                                                        <div class='span10'><small>".self::cutFeedTitle($tweet->text, 100)."</small></div>\n
                                                        <div class='span1'>@ No imported.</div>\n
                                                    </div>\n
                                                 </div>\n";
                         $reportCounter["warning"]++;   
                    }
                    else if(!self::checkArticleAlreadyImported($tweet->id_str))
                    {
                        // URL generating... (example: https://twitter.com/rexromae/statuses/390802730769321984)
                        $tweet_url = "https://twitter.com/".$tweet->user->screen_name."/statuses/".$tweet->id_str;

                        // Creation Date
                        $creation_date = date("Y-m-d H:i:s", strtotime($tweet->created_at));

                        $data = array(
                            'catid'      => $category_id,
                            'title'      => self::cutFeedTitle($tweet->text, 30)."_".$tweet->id_str,
                            'introtext'  => self::cutFeedTitle($tweet->text, 30),
                            'fulltext'   => ($url_replace==1)?self::tweetURLReplace($tweet->text):$tweet->text,
                            'created'    => $creation_date,
                            'state'      => $twitter_config["autopublish_feed"],
                            'urls'       => '{"urla":"'.  htmlspecialchars($tweet_url).'","urlatext":"","targeta":"1","urlb":false,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}',
                            'metadata'   => '{{"robots":"Activategrid","author":"'.$tweet->user->screen_name.'","rights":"","xreference":"'.$tweet_url.'"}}',
                            'xreference' => $tweet->id_str,
                        );

                        $article_import = self::createJoomlaArticle($data);

                        if($article_import===true)
                        {              
                            $url = self::checkArticleAlreadyImported($tweet->id_str);
                            $output_html .= "<div class='row-fluid'>\n
                                                <div class='span12'>\n
                                                    <div class='span1'>\n
                                                        <span class='badge badge-success'><span class='icon-ok report-icon'></span></span>\n
                                                    </div>\n
                                                    <div class='span10'><small>".self::cutFeedTitle($tweet->text, 100)."</small></div>\n
                                                    <div class='span1'><a href='{$url}' targat='_blank'><button class='btn btn-mini'>Edit</button></a></div>\n
                                                </div>\n
                                             </div>\n";
                            $reportCounter["success"]++;

                        }
                        else
                        {
                            $output_html .= "<div class='row-fluid'>\n
                                                <div class='span12'>\n
                                                    <div class='span1'>\n
                                                        <span class='badge badge-important'><span class='icon-remove report-icon'></span></span>\n
                                                    </div>\n
                                                    <div class='span10'><small>".self::cutFeedTitle($tweet->text, 100)."</small></div>\n
                                                    <div class='span1'></div>\n
                                                </div>\n
                                             </div>\n";
                            $reportCounter["error"]++;
                        }
                    }
                    else {
                        $url = self::checkArticleAlreadyImported($tweet->id_str);
                        $output_html .= "<div class='row-fluid'>\n
                                                <div class='span12'>\n
                                                    <div class='span1'>\n
                                                        <span class='badge badge-info'><span class='icon-ok report-icon'></span></span>\n
                                                    </div>\n
                                                    <div class='span10'><small>".self::cutFeedTitle($tweet->text, 100)."</small></div>\n
                                                    <div class='span1'><a href='{$url}' targat='_blank'><button class='btn btn-mini'>Edit</button></a></div>\n
                                                </div>\n
                                             </div>\n";
                          $reportCounter["old"]++;
                    }
                }
                
            }                                            
            
            $output_html .= "<script>setCounter('twitter', 'old', ".$reportCounter["old"].");</script>\n"; 
            $output_html .= "<script>setCounter('twitter', 'warning', ".$reportCounter["warning"].");</script>\n"; 
            $output_html .= "<script>setCounter('twitter', 'error', ".$reportCounter["error"].");</script>\n"; 
            $output_html .= "<script>setCounter('twitter', 'success', ".$reportCounter["success"].");</script>\n"; 
            //$output_html = self::generateReportBars(count($jTfeeds), $reportCounter).$output_html;
            echo $output_html;
        }       
        
        /*
         * Get feeds from facebook and creates the articles in Joomla!
         */
        public static function get_facebook()
        {   
            $output_html = "";
            $reportCounter = array("old"     => 0,
                                   "success" => 0,
                                   "warning" => 0,
                                   "error"   => 0);
            
            require JPATH_COMPONENT.'/libs/facebook-php-sdk/facebook.php';
            $app = JFactory::getApplication();
            
            $componentParams = JComponentHelper::getParams('com_activategrid');            
            $db = JFactory::getDBO();
            $facebook_config = array("appId"             => $componentParams->get('facebook_app_id', ""),
                                     "secret"            => $componentParams->get('facebook_app_secret', ""),
                                     "access_token"      => $componentParams->get('facebook_access_token', ""),
                                     "user_id"           => $componentParams->get('facebook_username_id', ""),
                                     "page_name"         => $componentParams->get('facebook_page_name', ""),
                                     "maximum"           => $componentParams->get('facebook_maximum', 10),
                                     "caching_images"          => $componentParams->get('facebook_pic_save', ""),
                                     "images_directory"        => $componentParams->get('facebook_pic_folder', "facebook"),
                                     "autopublish_feed"  => $componentParams->get('autopublish_feed', 1));
            
            $stop_import = false;
            
            $caching_images = $facebook_config["caching_images"];
            $images_directory = JPATH_ROOT.DS."images".DS.$facebook_config["images_directory"].DS;
            $images_directory_light = DS."images".DS.$facebook_config["images_directory"].DS;  
            
            if($caching_images)
            {
                // Is the folder writable?
                if(self::checkFoldersPermissions($images_directory))
                {
                    self::makeDir($images_directory);
                }
                else
                {
                    // Folder not writable! ERROR
                    echo "<button class='btn btn-danger'>Folder (".$images_directory.") not writable.<br/>Please check your file permission.<br/>The permission value for the folder /images should be 757.</button><p>&nbsp;</p>";
                    $stop_import = true;
                }
            }
            
            if(!empty($facebook_config["access_token"]) && !$stop_import)
            {
                // I check if the category exists
                $category_id = self::checkCategoryExists("facebook");
                if(!$category_id)
                {
                    // If autocreate_categories is true I can create the category and save the feed
                    //$componentParams->get('autocreate_categories', TRUE)
                    $autocreate_categories = true;
                    if($autocreate_categories)
                    {
                        $category_id = self::createJoomlaCategory("com_content", "Facebook", "facebook");
                    }
                    else
                    {
                        // The category doesn't exists. Where do I save the article?
                        die();
                    }
                }

                $config = array(
                    'appId' => $facebook_config["appId"],
                    'secret' => $facebook_config["secret"],
                );
                
                $facebook = new Facebook($config);
                $facebook->setAccessToken( $facebook_config["access_token"] );
                
                if(empty($facebook_config["page_name"]))
                {
                    /* USER TIMELINE */
                    $feeds = $facebook->api('/'.$facebook_config["user_id"].'/posts?limit='.$facebook_config["maximum"],'GET');                                    
                    $fql = 'SELECT type,permalink,message,attachment.name,attachment.media,attachment.caption,created_time,post_id,actor_id from stream where actor_id = '. $facebook_config["user_id"] .' AND source_id = '. $facebook_config["user_id"] .' LIMIT '.$facebook_config["maximum"];
                    $ret_obj = $facebook->api(array(
                           'method' => 'fql.query',
                           'query' => $fql,
                    ));
                }
                else
                {
                    /* PAGE */
                    $feeds = $facebook->api('/'.$facebook_config["page_name"].'/feed?limit='.$facebook_config["maximum"],'GET');                                    
                    $ret_obj = $feeds["data"];
                }
                
//                self::DLog($ret_obj);            
//                die();

                foreach($ret_obj as $feed)
                {
//                    self::DLog($feed);
//                    self::DLog($feed["post_id"]);
                    /* if those fields are missing - I can't create no article because I haven't enough information 
                     * it's probably a comment 
                     */
                       
                    /* if i'm reading a Page, I generate the permalink */
                    if(!empty($facebook_config["page_name"]))
                    {
                        // the id is like: 349459645146295_503059653119626 where the first block of numbers
                        // represents the author id and the second block the post id 
                        $author_post_id = $feed["id"];
                        $author_id = explode("_", $author_post_id);
                        $author_id = $author_id[0];                        
                        $post_id = substr(strstr($author_post_id, "_"), 1);
                        $feed["post_id"] = $post_id;
                        $feed["permalink"] = "https://www.facebook.com/".$facebook_config["page_name"]."/posts/".$post_id;
                    }
                    else
                    {
                        $author_id = $feed["actor_id"];
                    }
                    
                    
                    /* Filtering */
                    /* If the feed contains a message */
                    $allowFeedChecks = array();
                    $allowFeedChecks[] = true;
                    
                    if(!empty($feed["permalink"]))
                        $allowFeedChecks[] = true;
                    else
                        $allowFeedChecks[] = false;
                    if(!empty($feed["message"])) $allowFeedChecks[] = true;
                    if(count($feed["attachment"]) > 0) $allowFeedChecks[] = true;
                    /*if(isset($feed["type"]))
                    {
                        if($feed["type"] == "photo")
                            $allowFeedChecks[] = true;
                        else
                            $allowFeedChecks[] = "0";
                    }*/
                    if(isset($feed["story"])) $allowFeedChecks[] = false;
                    if(!empty($facebook_config["page_name"]))
                    {
                        if($author_id != $feed["from"]["id"])
                        {
    //                        self::DLog($author_id);
    //                        self::DLog($feed["from"]["id"]);
                            $allowFeedChecks[] = false;
                        }
                    }
                    if(empty($feed["message"]) && count($feed["attachment"]) == 0)
                    {
                        $allowFeedChecks[] = false;
                    }
                        
                    $check = array_unique($allowFeedChecks);
                    
//                    echo "size = " .count($check);
//                    self::DLog($allowFeedChecks); 
                    
                    if(count($check) == 1) // it means all true so passed
                    {
                        //die("YES");
                        $DLog = "Facebook (ID: ".$feed["post_id"].") -- ";

                        $htmlMessage   = "<span class='facebook_text'>\n";
                        $plainMessage  = "";
                        if(!empty($feed["message"])) 
                        {
                            $htmlMessage  .= "<span class='user_status'>".$feed["message"]."</span>\n";
                            $plainMessage .= $feed["message"];
                        }
                        $urlb = "";
                        $urlc = "";
                        //self::DLog($feed);
                        // If the item has not been imported yet
                        if(!self::checkArticleAlreadyImported($feed["post_id"]))
                        {
                            $external_url = $feed["permalink"];

                            // Creation Date
                            if(!empty($facebook_config["page_name"]))
                                $creation_date = date("Y-m-d H:i:s", strtotime($feed["created_time"]));
                            else
                                $creation_date = date("Y-m-d H:i:s", $feed["created_time"]);
                            
                            // Media
                            $picURL = "";
                            if(isset($feed["attachment"]["media"]))
                            {
                                /* If the user upload pictures, media type doesn't exists, so I check by a different way */
                                $photoStream = false;
                                if($feed["attachment"]["name"] == "Timeline Photos")
                                    $photoStream = true;

                                $mediaType = $feed["attachment"]["media"][0]["type"];
                                $mediaAlt = $feed["attachment"]["media"][0]["alt"];
                                $mediaHREF = $feed["attachment"]["media"][0]["href"];
                                $image_intro_caption = $mediaType;
                                //self::DLog("type=".$mediaType);
                                
                                if($mediaType == "video" || $mediaType == "photo" || $photoStream == true)
                                {
                                    $picURL = $feed["attachment"]["media"][0]["src"];

                                    /* If the video is on FB servers I replace the size of the image with a trick */
                                    if(strpos($mediaHREF, "facebook") !== false)
                                    {
                                        $picURL = substr($picURL, 0, strlen($picURL)-5)."n.jpg";
                                    }
                                    else if(strpos($mediaHREF, "youtube") !== false)
                                    {
                                        parse_str(parse_url($mediaHREF, PHP_URL_QUERY), $youtubeParams);
                                        $youtubeVideoID = $youtubeParams["v"];
                                        $picURL = "http://img.youtube.com/vi/".$youtubeVideoID."/0.jpg";
                                    }

                                    /* Specificly for videos, I put in the urlc attribute of the article, the link to the video 
                                     */
                                    if($mediaType == "video")
                                    {
                                        $urlc = $feed["attachment"]["media"][0]["video"]["source_url"];
                                    }
                                }
                                else if($mediaType == "link")
                                {
                                    $picURL = $feed["attachment"]["media"][0]["src"];
                                    $mediaAlt = $feed["attachment"]["name"];
                                }
                                if(!empty($mediaAlt))
                                {
                                    /* Sometimes the pic has a different ALT attribute, I want to appand that value to the user status
                                     * actually contained in $htmlMessage. Other times the image's ALT and the $htmlMessage match, so I check this before
                                     * concatenate.
                                     */
                                    if($plainMessage != $mediaAlt && !empty($mediaAlt))
                                    {
                                        /* If the message and the image's ALT are different I will append the ALT --> $plainMessage + $mediaAlt */
                                        $htmlMessage  .= "<span class='attachment_alt'>".htmlspecialchars(addslashes($mediaAlt))."</span>\n";
                                        $plainMessage .= $mediaAlt;
                                    }
                                }

                                /* I concatene also the attachment's caption to the message */
                                $mediaCaption = $feed["attachment"]["caption"];
                                if(!empty($mediaCaption)) 
                                {
                                     $htmlMessage  .= "<span class='attachment_caption'>".htmlspecialchars(addslashes($mediaCaption))."</span>\n";
                                     $plainMessage .= $mediaCaption;                                 
                                }  

                                 $htmlMessage  .= "</span>\n";

                                $urlb = $feed["attachment"]["media"][0]["href"];

                                if(empty($external_url))
                                    $external_url = $urlb;
                            }
                            else if($feed["picture"] && !empty($facebook_config["page_name"]))
                            {
                                /* I try to get the most high resolution image */
                                if($feed["link"] == $feed["name"])
                                    $picURL = $feed["link"];
                                else
                                {
                                    $picURL = $feed["picture"];
                                    $picURL = substr($picURL, 0, strlen($picURL)-5)."n.jpg";
                                }
                            }                           
                                
                            
                            //echo "picURL = ".$picURL."<br/>";
                            if($caching_images && !empty($picURL))
                            {
                                //self::DLog("IMG = ".$picURL);
                                
                                // if the url is like: https://fbexternal-a.akamaihd.net/safe_image.php?d=AQDQUH8ycQ5RmOMh&w=154&h=154&url=http://www.bitmat.it/wp-content/uploads/2013/12/uruguay-300x199.png
                                // I explode the string for searching the final part.. url="URL THAT I NEED"
                                // and I use that URL for download the image.
                                if(strstr($picURL, "fbexternal") != false)
                                {
                                    $tmp = explode("url=", $picURL);
                                    $picURL = urldecode ($tmp[1]);
                                    //die("DAJE! ->".$picURL);
                                }
                                $picURL = $images_directory_light.DS.self::savePictureFromURL($picURL, $images_directory);
                            }
                            
                            $data = array(
                                'catid'      => $category_id,
                                'title'      => "Facebook (".$feed["post_id"].") ".self::cutFeedTitle($plainMessage, 50),
                                'introtext'  => self::cutFeedTitle($htmlMessage, 50),
                                'fulltext'   => $htmlMessage,
                                'created'    => $creation_date,
                                'state'      => $facebook_config["autopublish_feed"],                                
                                //'urls'       => '{"urla":"'. json_encode(htmlspecialchars($external_url)).'","urlatext":"","targeta":"1","urlb":"'.json_encode($urlb).'","urlbtext":"","targetb":"","urlc":"'.json_encode($urlc).'","urlctext":"","targetc":""}',
                                'urls'       => '{"urla":"'. htmlspecialchars($external_url).'","urlatext":"","targeta":"1","urlb":"'.htmlspecialchars($urlb).'","urlbtext":"","targetb":"","urlc":"'.htmlspecialchars($urlc).'","urlctext":"","targetc":""}',
                                'metadata'   => '{{"robots":"Activategrid","author":"'.$facebook_config["user_id"].'","rights":"","xreference":"'.$external_url.'"}}',
                                'xreference' => $feed["post_id"],
                                'images'     => '{"image_intro":'.json_encode($picURL).',"float_intro":"","image_intro_alt":"","image_intro_caption":"'.$image_intro_caption.'","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}',
                            );

                            $article_import = self::createJoomlaArticle($data);
                                                      
                            $report_img = "";
                            if(strlen($picURL) > 0)
                            {
                                $report_img = "<div id='popover_".$feed["post_id"]."' class='btn btn-link popover-img'  rel='popover' data-content='{$picURL}' data-placement='left' data-original-title=''>1 image</div>";
                                /*if(!$caching_images)
                                    $report_img = "<img style='height:60px' src='{$picURL}' />";
                                else
                                    $report_img = "<img style='height:60px' src='".JURI::root().$picURL."' />";*/
                            }
                            if($article_import===true)
                            {   
                                $url = self::checkArticleAlreadyImported($feed["post_id"]);
                                $output_html .= "<div class='row-fluid'>\n
                                                    <div class='span12'>\n
                                                        <div class='span1'>\n
                                                            <span class='badge badge-success'><span class='icon-ok report-icon'></span></span>\n
                                                        </div>\n
                                                        <div class='span8'><small>".self::cutFeedTitle($plainMessage, 100)."</small></div>\n
                                                        <div class='span2'>{$report_img}</div>\n
                                                        <div class='span1'><a href='{$url}' targat='_blank'><button class='btn btn-mini'>Edit</button></a></div>\n
                                                    </div>\n
                                                 </div>\n";
                                $reportCounter["success"]++;                                
                            }
                            else
                            {
                                $output_html .= "<div class='row-fluid'>\n
                                                    <div class='span12'>\n
                                                        <div class='span1'>\n
                                                            <span class='badge badge-important'><span class='icon-remove report-icon'></span></span>\n
                                                        </div>\n
                                                        <div class='span8'><small>".self::cutFeedTitle($plainMessage, 100)."</small></div>\n
                                                        <div class='span2'></div>\n
                                                        <div class='span1'></div>\n
                                                    </div>\n
                                                 </div>\n";
                                $reportCounter["error"]++;
                            }
                        }
                        else {
                            $url = self::checkArticleAlreadyImported($feed["post_id"]);
                            $output_html .= "<div class='row-fluid'>\n
                                                    <div class='span12'>\n
                                                        <div class='span1'>\n
                                                            <span class='badge badge-info'><span class='icon-ok report-icon'></span></span>\n
                                                        </div>\n
                                                        <div class='span8'><small>This feed item was already imported</small></div>\n
                                                        <div class='span2'></div>\n
                                                        <div class='span1'><a href='{$url}' targat='_blank'><button class='btn btn-mini'>Edit</button></a></div>\n
                                                    </div>\n
                                                 </div>\n";
                              $reportCounter["old"]++;
                        }         
                    }
                    else {
                            $output_html .= "<div class='row-fluid'>\n
                                                    <div class='span12'>\n
                                                        <div class='span1'>\n
                                                            <span class='badge badge-warning'><span class='icon-remove report-icon'></span></span>\n
                                                        </div>\n
                                                        <div class='span8'><small>This feed item is probably a comment or a notification. It hasn't been imported.</small></div>\n
                                                        <div class='span2'>{$report_img}</div>\n
                                                        <div class='span1'></div>\n
                                                    </div>\n
                                                 </div>\n";
                              $reportCounter["warning"]++;
                        }
                }
            }
            
                        
            $output_html .= "<script>setCounter('facebook', 'old', ".$reportCounter["old"].");</script>\n"; 
            $output_html .= "<script>setCounter('facebook', 'warning', ".$reportCounter["warning"].");</script>\n"; 
            $output_html .= "<script>setCounter('facebook', 'error', ".$reportCounter["error"].");</script>\n"; 
            $output_html .= "<script>setCounter('facebook', 'success', ".$reportCounter["success"].");</script>\n"; 
            //$output_html = self::generateReportBars(count($ret_obj), $reportCounter).$output_html;
            echo $output_html;   
        }   
        
        /*
         * Get instagram feeds and creates the articles in Joomla!
         */
        public static function get_instagram()
        {
            $output_html = "";
            $reportCounter = array("old"     => 0,
                                   "success" => 0,
                                   "warning" => 0,
                                   "error"   => 0);
            
            require JPATH_COMPONENT.'/libs/instagram.class.php';
            $app = JFactory::getApplication();
            
            $componentParams = JComponentHelper::getParams('com_activategrid');            
            $db = JFactory::getDBO();
            $instagram_config = array("client_id"        => $componentParams->get('instagram_client_id', ""),
                                      "client_secret"    => $componentParams->get('instagram_client_secret', ""),
                                      "redirect_uri"     => $componentParams->get('instagram_redirect_uri', ""),
                                      "access_token"     => $componentParams->get('instagram_access_token', ""),
                                      "username"         => $componentParams->get('instagram_username', ""),
                                      "maximum"          => $componentParams->get('instagram_maximum', 10),
                                      "autopublish_feed" => $componentParams->get('autopublish_feed', 1),
                                      "caching_images"   => $componentParams->get('instagram_pic_save', true),
                                      "images_directory" => $componentParams->get('instagram_pic_folder',  JPATH_ROOT.DS."images".DS."images".DS."instagram".DS));
            
            if(!empty($instagram_config["access_token"]))
            {
                // I check if the category exists
                $category_id = self::checkCategoryExists("instagram");
                if(!$category_id)
                {
                    // If autocreate_categories is true I can create the category and save the feed
                    //$componentParams->get('autocreate_categories', TRUE)
                    $autocreate_categories = true;
                    if($autocreate_categories)
                    {
                        $category_id = self::createJoomlaCategory("com_content", "Instagram", "instagram");
                    }
                    else
                    {
                        // The category doesn't exists. Where do I save the article?
                        die();
                    }
                }
                
                // API Keys
                $client_id     = $instagram_config["client_id"];
                $client_secret = $instagram_config["client_secret"];
                $redirect_uri  = $instagram_config["redirect_uri"];          
                $accessToken   = $instagram_config["access_token"];

                // Details
                $username  = $instagram_config["username"];
                $maximum   = $instagram_config["maximum"];
                $caching_images   = $instagram_config["caching_images"];
                $images_directory = JPATH_ROOT.DS."images".DS.$instagram_config["images_directory"].DS;
                $images_directory_light = "images".DS.$instagram_config["images_directory"].DS;
                self::makeDir($images_directory);
                
                $stop_import = false;
                
                if($caching_images)
                {
                    // Is the folder writable?
                    if(self::checkFoldersPermissions($images_directory))
                    {
                        self::makeDir($images_directory);
                    }
                    else
                    {
                        // Folder not writable! ERROR
                        echo "<button class='btn btn-danger'>Folder (".$images_directory.") not writable.<br/>Please check your file permission.<br/>The permission value for the folder /images should be 757.</button><p>&nbsp;</p>";
                        $stop_import = true;
                    }
                }

                if(!$stop_import)
                {
                    $instagram = new Instagram(array(
                      'apiKey'      => $client_id,
                      'apiSecret'   => $client_secret,
                      'apiCallback' => $redirect_uri
                    ));
                    // Store user access token
                    $instagram->setAccessToken($accessToken);

                    // Get all user likes
                    $userTimeline = $instagram->getUserMedia('self', $maximum);
                    
                    foreach ($userTimeline->data as $entry)
                    {
                        if(isset($entry->id))                
                        {
                            $DLog = "Instagram (ID: ".$entry->id.") -- ";
                            // If the item has not been imported yet
                            if(!self::checkArticleAlreadyImported($entry->id))
                            {                                                        
                                $instagram_url = $entry->link;

                                // Download and store the pic
                                $picURL = $entry->images->low_resolution->url;
                                if($caching_images)
                                    $picURL = $images_directory_light.DS.self::savePictureFromURL($picURL, $images_directory);
                                
                                // Video
                                if($entry->type == "video")
                                {                                    
                                    $video_url = $entry->videos->standard_resolution->url;
                                    $video_resolution = $entry->videos->standard_resolution->width."x".$entry->videos->standard_resolution->height;
                                    $image_intro_caption = $entry->type;                                    
                                }
                                
                                // Creation Date
                                $creation_date = date("Y-m-d H:i:s", $entry->created_time);

                                $DLog .= "<br/><a href='".$picURL."'><img src=\"{$entry->images->thumbnail->url}\"></a><br/>";  

                                $data = array(
                                    'catid'      => $category_id,
                                    'title'      => "Instagram - @".$username. " - #".$entry->id,
                                    'introtext'  => "",
                                    'fulltext'   => "",
                                    'created'    => $creation_date,
                                    'state'      => $instagram_config["autopublish_feed"],
                                    'urls'       => '{"urla":"'.  htmlspecialchars($instagram_url).'","urlatext":"","targeta":"1","urlb":false,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}',
                                    'metadata'   => '{{"robots":"Activategrid","author":"'.$username.'","rights":"","xreference":"'.$instagram_url.'"}}',
                                    'xreference' => $entry->id,
                                    'images'     => '{"image_intro":'.json_encode($picURL).',"float_intro":"","image_intro_alt":"","image_intro_caption":"'.$image_intro_caption.'","image_fulltext":"'.$video_url.'","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":"'.$video_resolution.'"}',
                                );                       

                                
                                $article_import = self::createJoomlaArticle($data);
                                if($article_import===true)
                                {                                
                                    $output_html .= "<div class='row-fluid'>\n
                                                        <div class='span12'>\n
                                                            <div class='span1'>\n
                                                                <span class='badge badge-success'><span class='icon-ok report-icon'></span></span>\n
                                                            </div>\n
                                                            <div class='span11'><img height='60' src=\"{$entry->images->thumbnail->url}\"></div>\n
                                                        </div>\n
                                                     </div>\n";
                                    $reportCounter["success"]++;
                                }
                                else
                                {
                                    $output_html .= "<div class='row-fluid'>\n
                                                    <div class='span12'>\n
                                                        <div class='span1'>\n
                                                            <span class='badge badge-important'><span class='icon-remove report-icon'></span></span>\n
                                                        </div>\n
                                                        <div class='span11'><img height='60' src=\"{$entry->images->thumbnail->url}\"></div>\n
                                                    </div>\n
                                                 </div>\n";
                                    $reportCounter["error"]++;
                                }
                            }
                            else {
                                $url = self::checkArticleAlreadyImported($entry->id);
                                $output_html .= "<div class='row-fluid'>\n
                                                        <div class='span12'>\n
                                                            <div class='span1'>\n
                                                                <span class='badge badge-info'><span class='icon-ok report-icon'></span></span>\n
                                                            </div>\n
                                                            <div class='span11'><img height='60' src=\"{$entry->images->thumbnail->url}\"></div>\n
                                                        </div>\n
                                                     </div>\n";
                                $reportCounter["old"]++;
                                //$url = self::checkArticleAlreadyImported($entry->id);
//                                self::DLog($DLog."<a href='".$url."' target='_blank'><button class='btn'>Already inserted in Joomla!</button></a>");
                            }
                        }
                    }
                }
            }
            
            $output_html .= "<script>setCounter('instagram', 'old', ".$reportCounter["old"].");</script>\n"; 
            $output_html .= "<script>setCounter('instagram', 'warning', ".$reportCounter["warning"].");</script>\n"; 
            $output_html .= "<script>setCounter('instagram', 'error', ".$reportCounter["error"].");</script>\n"; 
            $output_html .= "<script>setCounter('instagram', 'success', ".$reportCounter["success"].");</script>\n"; 
//            $output_html = self::generateReportBars(count($userTimeline->data), $reportCounter).$output_html;
            echo $output_html;     
        }
        
        private static function makeDir($path)
        {
           return is_dir($path) || mkdir($path);
        }
        
        private static function savePictureFromURL($pic_url, $images_directory)
        {       
            if(strpos($pic_url, "http") === false)
            {
                if(substr($pic_url, 0, 2) == "//")                        
                    $pic_url = "http:".$pic_url;
                else
                    $pic_url = "http://".$pic_url;
            }
                        
            $ts = md5(rand()+time());
            $file_ext = self::get_file_extension(basename($pic_url));
            $filename = $images_directory.md5($ts."_".self::fixImageURLWithoutFileExtension(basename($pic_url)));
            // If the file has an extension, I maintain that, if it hasn't I add .jpg
            if(!empty($file_ext))
            {
                $filename .= ".".$file_ext;
            } else
                $filename .= ".jpg";
            
            $ch = curl_init($pic_url);            
            $fp = fopen($filename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            
            if(strstr($pic_url, "//instagram.com/p") != false)
            {
                $imgData = self::my_file_get_contents($pic_url);
                $saveImg = file_put_contents($filename, $imgData);                
            }
            return self::fixImageURLWithoutFileExtension($filename);
        }
        
        function my_file_get_contents($uri)
        {
            if(ini_get('allow_url_fopen'))
                return file_get_contents ($uri);
            return self::url_get_contents($uri);
        }
        
        public static function url_get_contents ($Url) {
           if (!function_exists('curl_init')){ 
                die('CURL is not installed!');
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }
        
        function get_file_extension($file_name)
        {
            return substr(strrchr($file_name,'.'),1);
        }

        public static function updateExtensionConfig($params)
        {
            $db = JFactory::getDBO();
            $query = "UPDATE  #__extensions SET params = '".$params."' WHERE name='com_activategrid' LIMIT 1";
            $db->setQuery($query);
            $db->query();
        }
        
        public static function getExtensionConfigJSON()
        {
            $db = JFactory::getDBO();
            $query = "SELECT params FROM  #__extensions WHERE name='com_activategrid' LIMIT 1";
            $db->setQuery($query);
            $db->query();
            $params = $db->loadResult();
            return $params;
        }
        
        public static function getExtensionConfigArray()
        {
            $json_params = self::getExtensionConfigJSON();                                     
            return json_decode($json_params);
        }               
        
        public static function instagramStoreAccessToken($accessToken="")
        {
            $paramsArray = (array) self::getExtensionConfigArray();
            $paramsArray["instagram_access_token"] = $accessToken;
            self::updateExtensionConfig(self::array2json($paramsArray));
        }
        
        public static function instagramStoreUsername($username)
        {
            $paramsArray = (array) self::getExtensionConfigArray();
            $paramsArray["instagram_username"] = $username;
            self::updateExtensionConfig(self::array2json($paramsArray));
        }
        
        public static function storeParam($name ="", $value="")
        {
            if(empty($name)||empty($value)) return false;
            $paramsArray = (array) self::getExtensionConfigArray();
            $paramsArray[$name] = $value;
            self::updateExtensionConfig(self::array2json($paramsArray));
        }                
        
        public static function displayMessage($type="", $message="")
        {
            $application = JFactory::getApplication();
            $application->enqueueMessage($message, $type); 
        }
        
        /* Utils */                               
        
        private static function checkCategoryExists($alias = "")
        {
            $db = JFactory::getDBO();
            $alias = htmlspecialchars(addslashes($alias));
            $query = "SELECT id FROM #__categories WHERE alias = '".$alias."' AND published=1;";
            $db->setQuery($query);
            $db->query();
            $results = $db->loadObjectList();   
            if(sizeof($results) > 0) return $results[0]->id; // exists
            else return false; // not exists
        }

        public static function createJoomlaCategory($component, $title, $alias)
        {
            $db = JFactory::getDBO();
            $component = htmlspecialchars(addslashes($component));
            $title = htmlspecialchars(addslashes($title));
            $alias = htmlspecialchars(addslashes($alias));
            $query = "INSERT INTO #__categories (parent_id, extension, title, alias, path, published, level, access, created_time, language)
                      SELECT * FROM (SELECT 1 as parent_id, '".$component."', '".$title."' as t, '".$alias."' as a, '".$alias."' as p, 1 as published, 1 as level, 1 as access, NOW(), '*') AS tmp
                      WHERE NOT EXISTS(     
                          SELECT id   
                          FROM #__categories 
                          WHERE alias = '".$alias."' AND published=1
                      )";
            $db->setQuery($query);
            $db->query();

            return $db->insert_id();
        }

        public static function createJoomlaArticle($data)
        {
            if(!isset($data)) return false;

            $table = JTable::getInstance('Content', 'JTable', array());   

            // Bind data
            if (!$table->bind($data))
            {
                return $table->getError();
            }

            // Check the data.
            if (!$table->check())
            {
                return $table->getError();
            }

            // Store the data.
            if (!$table->store())
            {
                return $table->getError();
            }
            
            return true;
        }

        /*
         * This funcion checks if the feed has been already imported - it means we have an article
         * with the ID of the feed in com_content.xreference
         */
        public static function checkArticleAlreadyImported($xreference)
        {
            if($xreference==0 || $xreference=="") die("Fatal error: xreference missing in ActivategridHelper::checkActivateArticleExists()");
            $db = JFactory::getDBO();            
            $xreference = htmlspecialchars(addslashes($xreference));
            $query = "SELECT id,catid FROM #__content WHERE xreference = '".$xreference."' and state <> -2";
            //self::DLog("Query: ".$query);
            $db->setQuery($query);
            $db->query();
            $results = $db->loadObjectList(); 
 //           self::DLog("Results Number: ".sizeof($results));
            
            if(sizeof($results) > 0){ 
                // exists 
                //print_r($results);
                $url = JRoute::_('/administrator/index.php?option=com_content&task=article.edit&id='.$results[0]->id);            
                return $url; 
            }
            else return false; // not exists    
        }
        
        function cutFeedTitle($title, $max_chars)
        {
            if(strlen($title) > $max_chars)
            {
                return substr($title, 0, $max_chars)."...";
            }
            else
                return $title;    
        }
               
         public static function checkExistingCategoryColorPalette($name = 'cbg', $category_id = 0)
         {             
             $db = JFactory::getDBO();
             $db->setQuery("SELECT id FROM #__activategrid WHERE name='".$name.$category_id."'")->query();
             $result = $db->loadResult();
             if($result) return $result;
             else return false;             
         }

        function prettyPrint( $json )
        {
            $result = '';
            $level = 0;
            $prev_char = '';
            $in_quotes = false;
            $ends_line_level = NULL;
            $json_length = strlen( $json );

            for( $i = 0; $i < $json_length; $i++ ) {
                $char = $json[$i];
                $new_line_level = NULL;
                $post = "";
                if( $ends_line_level !== NULL ) {
                    $new_line_level = $ends_line_level;
                    $ends_line_level = NULL;
                }
                if( $char === '"' && $prev_char != '\\' ) {
                    $in_quotes = !$in_quotes;
                } else if( ! $in_quotes ) {
                    switch( $char ) {
                        case '}': case ']':
                            $level--;
                            $ends_line_level = NULL;
                            $new_line_level = $level;
                            break;

                        case '{': case '[':
                            $level++;
                        case ',':
                            $ends_line_level = $level;
                            break;

                        case ':':
                            $post = " ";
                            break;

                        case " ": case "\t": case "\n": case "\r":
                            $char = "";
                            $ends_line_level = $new_line_level;
                            $new_line_level = NULL;
                            break;
                    }
                }
                if( $new_line_level !== NULL ) {
                    $result .= "\n".str_repeat( "\t", $new_line_level );
                }
                $result .= $char.$post;
                $prev_char = $char;
            }

            return $result;
        }    
        
        
        public function DLog($str)
        {
            if(is_array($str))
                echo "<pre>".print_r($str,true)."</pre>";
            else if(is_object($str))
                echo "<pre>".print_r($str,true)."</pre>";
            else
                echo "<pre>".$str."</pre>";
        }
        
        
        private function array2json($arr) { 
            if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
            $parts = array(); 
            $is_list = false; 

            //Find out if the given array is a numerical array 
            $keys = array_keys($arr); 
            $max_length = count($arr)-1; 
            if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
                $is_list = true; 
                for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position 
                    if($i != $keys[$i]) { //A key fails at position check. 
                        $is_list = false; //It is an associative array. 
                        break; 
                    } 
                } 
            } 

            foreach($arr as $key=>$value) { 
                if(is_array($value)) { //Custom handling for arrays 
                    if($is_list) $parts[] = array2json($value); /* :RECURSION: */ 
                    else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */ 
                } else { 
                    $str = ''; 
                    if(!$is_list) $str = '"' . $key . '":'; 

                    //Custom handling for multiple data types 
                    if(is_numeric($value)) $str .= $value; //Numbers 
                    elseif($value === false) $str .= 'false'; //The booleans 
                    elseif($value === true) $str .= 'true'; 
                    else $str .= '"' . addslashes($value) . '"'; //All other things 
                    // :TODO: Is there any more datatype we should be in the lookout for? (Object?) 

                    $parts[] = $str; 
                } 
            } 
            $json = implode(',',$parts); 

            if($is_list) return '[' . $json . ']';//Return numerical JSON 
            return '{' . $json . '}';//Return associative JSON 
        }
        
}

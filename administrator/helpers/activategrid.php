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
    
        public static function saveConfig()
        {
            $db = JFactory::getDbo();
            $jinput = JFactory::getApplication()->input;
            $categories = self::getCategories();                        
            $properties = array();
            // Categories colors
            foreach($categories as $category)
            {
                $propertyName_cti = "cti".$category->id;
                $propertyName_cte = "cte".$category->id;
                $propertyName_cbg = "cbg".$category->id;
                $properties[$propertyName_cti] = $jinput->get($propertyName_cti, '', 'str');
                $properties[$propertyName_cte] = $jinput->get($propertyName_cte, '', 'str');
                $properties[$propertyName_cbg] = $jinput->get($propertyName_cbg, '', 'str');
            }
                                    
            foreach($properties as $propertyName => $value)
            {
                $query = $db->getQuery(true);
                if(self::checkExistingConfig($propertyName))
                {
                    $query = "UPDATE #__activategrid SET value='".$value."' WHERE name='".$propertyName."' LIMIT 1;";
                }
                else
                {
                    $query = "INSERT INTO #__activategrid (context, name, value) VALUES ('category_color', '".$propertyName."', '".$value."');";
                }
                /*if(empty($value) && self::checkExistingConfig($propertyName))
                    $db->setQuery($query); // update
                else if(!empty($value))
                */
                $db->setQuery($query); //insert not empty
                
                //self::DLog($query);
                
                
                $db->query();
            }
                       
            echo "<div class='alert alert-success'>".JText::_('COM_ACTIVATEGRID_SAVED_SUCCESS')."</div>\n";
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
        
        public static function createCategoriesColorPickerForm()
        {
            $config = self::getConfig("category_color");
            
            $categories = self::getCategories();
            $html = "";
            $ids = array();
            
            $html .= "<table class='table'>\n";            
            //$html .= "  <caption>".$category->title."</caption>\n";
            $html .= "  <thead>\n";
            $html .= "    <tr>\n";
            $html .= "      <th>Category</th>\n";
            $html .= "      <th>Title</th>\n";
            $html .= "      <th>Text</th>\n";
            $html .= "      <th>Background</th>\n";
            $html .= "    </tr>\n";
            $html .= "  </thead>\n";
            $html .= "  <tbody>\n";            
            foreach($categories as $category)
            {
                // I get the value from the DB
                if(self::checkExistingConfig("cti".$category->id))
                {
                    $cti_color = self::checkExistingConfig("cti".$category->id);
                    if($cti_color == 1) $cti_color = "";
                }
                else
                    $cti_color = "";
                // I get the value from the DB
                if(self::checkExistingConfig("cte".$category->id))
                {
                    $cte_color = self::checkExistingConfig("cte".$category->id);
                    if($cte_color == 1) $cte_color = "";
                }
                else
                    $cte_color = "";
                // I get the value from the DB
                if(self::checkExistingConfig("cbg".$category->id))
                {
                    $cbg_color = self::checkExistingConfig("cbg".$category->id);
                    if($cbg_color == 1) $cbg_color = "";
                }
                else
                    $cbg_color = "";
                
                
                $html .= "    <tr>\n";
                $html .= "      <td>".$category->title."</td>\n";
                $html .= "      <td><input type='text' name='cti".$category->id."' class='cp' style='cursor: pointer' value='".$cti_color."' id='cti".$category->id."' /></td>\n";                
                $html .= "      <td><input type='text' name='cte".$category->id."' class='cp' style='cursor: pointer' value='".$cte_color."' id='cte".$category->id."' /></td>\n";
                $html .= "      <td><input type='text' name='cbg".$category->id."' class='cp' style='cursor: pointer' value='".$cbg_color."' id='cbg".$category->id."' /></td>\n";
                $html .= "    </tr>\n";
                $html .= "    <tr>\n";
                $html .= "      <td colspan='4'>\n
                                    <div class='cat_bg_color' id='cat_".$category->id."_sample'>\n
                                        <span class='cat_title_color' id='cat_".$category->id."_title_sample'>Title</span>\n
                                        <span class='cat_text_color' id='cat_".$category->id."_text_sample'>Text</span>\n
                                    </div>\n
                                </td>\n";
                $html .= "    </tr>\n";
                
                
                /*
                $html .= "<div class='span12'>\n";
                //$html .= "  <div class='span12'>";
                $html .= "  <div class='span2'>\n";           
                $html .= "      <label>".$category->title."</label>\n";
                $html .= "  </div>\n";
                $html .= "  <div class='span1'>\n";           
                //$html .= "   <input type='text' class='span1' value='#8fff00' id='cp".$category->id."'>";           
                $html .= "       <input type='text' name='cp".$category->id."' class='cp' style='cursor: pointer' value='".$value."' id='cp".$category->id."' />\n";
                
               
                $html .= "   </div>\n";
                //$html .= " </div'>";
                $html .= "</div>\n";
                */
                $ids[] = $category->id;
                
                
            }
            
            $html .= "  </tbody>\n";
            $html .= "</table>\n";
            
             $html .= "";
            foreach($ids as $id)
            {
                
            }
            
            return $html;
        }
        
        private static function checkExistingConfig($name = '')
        {
            $config = self::getConfig();            
            foreach($config as $config_item)
            {       
                
                if($config_item->name == $name)
                {
                    if($config_item->value == "")
                        return true;
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
        /*
        public static function addSubmenu($submenu) 
        {
                JSubMenuHelper::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_MESSAGES'),
                                         'index.php?option=com_helloworld', $submenu == 'messages');
                JSubMenuHelper::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_CATEGORIES'),
                                         'index.php?option=com_categories&view=categories&extension=com_helloworld',
                                         $submenu == 'categories');
                // set some global property
                $document = JFactory::getDocument();
                $document->addStyleDeclaration('.icon-48-helloworld ' .
                                               '{background-image: url(../media/com_helloworld/images/tux-48x48.png);}');
                if ($submenu == 'categories') 
                {
                        $document->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION_CATEGORIES'));
                }
        }*/

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
         * Get tweets and creates the articles in Joomla!
         */
        public static function get_twitter()
        {            
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
                if($componentParams->get('autocreate_categories', TRUE))
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
            
            $filename = basename(__FILE__, '.php').'.json';
            $filetime = file_exists($filename) ? filemtime($filename) : time() - $caching - 1;

            if (time() - $caching > $filetime) {
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
                    curl_close($curl_request);

                    file_put_contents($filename, $response);
            } else {
                    $response = file_get_contents($filename);
            }

            //header('Content-Type: application/json');
            //header('Last-Modified: '.gmdate('D, d M Y H:i:s', $filetime).' GMT');
            self::DLog("<h1>Twitter</h1>");
            $jTfeeds = json_decode($response);

            
            foreach($jTfeeds as $tweet) {    
                //echo "<pre>";
                //print_r($tweet);
                //echo "</pre>";        
                if(isset($tweet->id_str))
                {
                    $DLog = "Tweet (ID: ".$tweet->id_str.") -- ";
                        // If the item has not been imported yet
                        if(!self::checkArticleAlreadyImported($tweet->id_str))
                        {
                            // URL generating... (example: https://twitter.com/rexromae/statuses/390802730769321984)
                            $tweet_url = "https://twitter.com/".$tweet->user->screen_name."/statuses/".$tweet->id_str;

                            // Creation Date
                            $creation_date = date("Y-m-d H:i:s", strtotime($tweet->created_at));
                            
                            $data = array(
                                'catid'      => $category_id,
                                'title'      => self::cutTweetTitle($tweet->text, 30),
                                'introtext'  => self::cutTweetTitle($tweet->text, 30),
                                'fulltext'   => ($url_replace==1)?self::tweetURLReplace($tweet->text):$tweet->text,
                                'created'    => $creation_date,
                                'state'      => $twitter_config["autopublish_feed"],
                                'urls'       => '{"urla":"'.  htmlspecialchars($tweet_url).'","urlatext":"","targeta":"1","urlb":false,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}',
                                'metadata'   => '{{"robots":"Activategrid","author":"'.$tweet->user->screen_name.'","rights":"","xreference":"'.$tweet_url.'"}}',
                                'xreference' => $tweet->id_str,
                            );

                            $article_import = self::createJoomlaArticle($data);
                           
                            if($article_import===true)        
                                self::DLog($DLog."<button class='btn btn-success'>Added in Joomla!</button><br/>".$tweet->text);
                            else
                                self::DLog($DLog."<button class='btn btn-danger'>Error! ".$article_import."</button><br/>".self::cutTweetTitle($tweet->text, 30));
                        }
                        else {
                            $url = self::checkArticleAlreadyImported($tweet->id_str);
                            self::DLog($DLog."<a href='".$url."' target='_blank'><button class='btn'>Already inserted in Joomla!</button></a>");
                        }
                }
            }
        }                        
        
        /*
         * Get instagram feeds and creates the articles in Joomla!
         */
        public static function get_instagram()
        {
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
            
            // I check if the category exists
            $category_id = self::checkCategoryExists("instagram");
            if(!$category_id)
            {
                // If autocreate_categories is true I can create the category and save the feed
                if($componentParams->get('autocreate_categories', TRUE))
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
            
            $instagram = new Instagram(array(
              'apiKey'      => $client_id,
              'apiSecret'   => $client_secret,
              'apiCallback' => $redirect_uri
            ));
            // Store user access token
            $instagram->setAccessToken($accessToken);

            // Get all user likes
            $userTimeline = $instagram->getUserMedia('self', $maximum);

            // Take a look at the API response            
            self::DLog("<h1>Instagram</h1>");
            
            
            foreach ($userTimeline->data as $entry) {
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
                            $picURL = $images_directory_light.DS.self::saveInstagramPic($picURL, $images_directory);
                        
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
                            'images'     => '{"image_intro":'.json_encode($picURL).',"float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}',
                        );                       
                        
                        self::createJoomlaArticle($data);
                        self::DLog($DLog."<button class='btn btn-success'>Added in Joomla!</button><br/>");
                    }
                    else {
                        $url = self::checkArticleAlreadyImported($entry->id);
                        self::DLog($DLog."<a href='".$url."' target='_blank'><button class='btn'>Already inserted in Joomla!</button></a>");
                    }
                }
            }
            
            //echo "<pre>";
            //print_r($userTimeline);
            //echo "</pre>";            
        }
        
        private static function makeDir($path)
        {
           return is_dir($path) || mkdir($path);
        }
        
        private static function saveInstagramPic($pic_url, $images_directory)
        {
            $filename = $images_directory.basename($pic_url);
            $ch = curl_init($pic_url);
            $fp = fopen($filename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);            
            return basename($filename);
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
            $query = "INSERT INTO jos_categories (parent_id, extension, title, alias, path, published, level, access, created_time, language)
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
            if($xreference==0 || $xreference=="") die("Fatal error: xreference missing in jutils.php::checkActivateArticleExists()");
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
                $url = JRoute::_('index.php?option=com_content&view=article&layout=edit&id='.$results[0]->id);            
                return $url; 
            }
            else return false; // not exists    
        }
        
        function cutTweetTitle($title, $max_chars)
        {
            if(strlen($title) > $max_chars)
            {
                return substr($title, 0, $max_chars)."...";
            }
            else
                return $title;    
        }

        
        public static function generateSocialColorPalette()
        {
            $socialnetowks_default_color = array("twitter"   => "#201f1f",
                                                 "instagram" => "#5e4439");
            
            $db = JFactory::getDBO();

            foreach($socialnetowks_default_color as $socialnetwork => $bgcolor)
            {
                $category_id = ActivategridHelper::checkCategoryExists($socialnetwork);
                if($category_id)
                {
                    if(!self::checkExistingCategoryColorPalette("cti", $category_id)) 
                        $db->setQuery("INSERT INTO #__activategrid (context, name, value) VALUES ('category_color', 'cti".$category_id."', '#ffffff');")->query();
                    if(!self::checkExistingCategoryColorPalette("cte", $category_id)) 
                        $db->setQuery("INSERT INTO #__activategrid (context, name, value) VALUES ('category_color', 'cte".$category_id."', '#ffffff');")->query();
                    if(!self::checkExistingCategoryColorPalette("cbg", $category_id)) 
                        $db->setQuery("INSERT INTO #__activategrid (context, name, value) VALUES ('category_color', 'cbg".$category_id."', '".$bgcolor."');")->query();
                }
            }
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

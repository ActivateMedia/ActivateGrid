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

/**
 * Activategrid helper.
 */
class ActivategridHelper
{
        public static function ActivateGrid($componentParams, $document, $itemid, $params)
        {
                $db = JFactory::getDbo();
                $grid = new stdClass();
                $loadjQuery = $componentParams->get('jquery', 1);
                $load_content_dinamically = $componentParams->get('load_content_dinamically', 1);
                $grid->gridItemWidth = $params->get('griditem_width', "240");
                $grid->gridItemHeight = $params->get('griditem_height', "350");
                $grid->gridItemSelector = $params->get('griditem_selector', "gridItem");
                $grid->show_category_title = $params->get('show_category_title', 1);
                
                $gridSelectors = "gridItem";
                if($grid->gridItemSelector != "gridItem")
                {
                    $gridSelectors .= " ".$grid->gridItemSelector;
                }
                            
                //ActivategridHelper::DLog($componentParams);
                $grid->load_content_dinamically = $load_content_dinamically;
                if($loadjQuery==1)
                    $document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js");
                    //$document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/jquery-2.0.3.min.js");
                
                $document->addStyleSheet(JURI::base()."?option=com_activategrid&view=css&tmpl=component&format=raw&Itemid=".$itemid);
                $document->addStyleSheet(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/css/grid.css");
                $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/responsivegrid.min.js");
                if($load_content_dinamically==1)
                {
                    $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/imagesloaded.min.js");
                    $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/modernizr.custom.js");
                    $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/classie.min.js");
                    $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/AnimOnScroll.min.js");
                }
                $document->addScript("http://platform.twitter.com/widgets.js");
                
                $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/masonry.pkgd.min.js");
                
                $show_category_intro_text = $params->get("show_category_intro");
                $grid->category_intro = "";
                if($show_category_intro_text == 1)
                {
                    $source_cat_id_intro_text = $params->get("source_category_intro");
                    
                    $category_intro_text = ActivategridHelper::getCategoryDescriptionByID($source_cat_id_intro_text);                                    
                    $grid->category_intro .= "<div class='head-category-title'>\n";                  
                    $grid->category_intro .= "  ".ActivategridHelper::getCategoryNameByID($source_cat_id_intro_text, false)."\n";
                    $grid->category_intro .= "</div>\n";                 
                    $grid->category_intro .= "<div class='head-category-intro'>\n";                  
                    $grid->category_intro .= "  ".$category_intro_text."\n";
                    $grid->category_intro .= "</div>\n";   
                    
                    $grid->category_intro .= "<div class='connaught-logo-container'>\n";
                    $grid->category_intro .= "  <div class='connaught-logo'></div>\n";
                    $grid->category_intro .= "  <div class='connaught-logo-line marginleft'></div>\n";
                    $grid->category_intro .= "  <div class='connaught-logo-line-divider'></div>\n";                    
                    $grid->category_intro .= "  <div class='connaught-logo-line marginright'></div>\n";   
                    $grid->category_intro .= "</div>\n";   
                    
                    
                }
                
                // I search the IDs of the selected categories and I create an aerray of them (id=>title)
                $selected_source_categories = $params->get("sources_category"); 
                
                if(sizeof($selected_source_categories) > 0)
                {
                    // Masonry Effect
                    $grid->load_effect = $params->get("load_effect");
                    if($grid->load_effect=="R")
                    {
                        // Random between 1 and 8
                        $grid->load_effect = (int)rand(1, 8);
                    }
                    $categories = array();
                    foreach($selected_source_categories as $cat)
                    {
                        $db->setQuery("SELECT cat.id FROM #__categories cat WHERE cat.title='".$cat."' and published=1");   
                        $catid = $db->loadResult();
                        $categories[$catid] = $cat;
                    }
                    // Now I have the array of categories              

                    // I search articles in those categories                
                    $categoryIN = "(";
                    foreach($categories as $catid => $cattitle)
                    {
                        $categoryIN .= $catid.",";
                    }
                    $categoryIN = substr($categoryIN, 0, strlen($categoryIN)-1).")";

                    // Order param
                    $order_criteria = $params->get("article_order");
                    $random_extra_field = "";
                    if($order_criteria == "a-z") $order_criteria_sql = " title ASC";
                    else if($order_criteria == "z-a") $order_criteria_sql = " title DESC";
                    else if($order_criteria == "date_asc") $order_criteria_sql = " created ASC";
                    else if($order_criteria == "date_desc") $order_criteria_sql = " created DESC";
                    else if($order_criteria == "random")
                    {
                        $order_criteria_sql = " rand";
                        $random_extra_field = ", RAND() as rand";
                    }

                    $query = "SELECT * ".$random_extra_field." FROM #__content cont WHERE cont.catid IN ".$categoryIN." and state=1 ORDER BY ".$order_criteria_sql;

                    $db->setQuery($query);   
                    $articles = array();
                    $articles = $db->loadObjectList();

                    /* Twitter */
                    $twitter_show_date = $componentParams->get('twitter_show_date', 1);
                    $twitter_show_actions = $componentParams->get('twitter_show_actions', 1);
                    $twitter_show_icon = $componentParams->get('twitter_show_icon', 1);
                    $twitter_replace_url = $componentParams->get('twitter_url_replace', 1);
                    /* Instagram */
                    $instagram_show_icon = $componentParams->get('instagram_show_icon', 1);
                    /* Facebook */
                    $facebook_show_icon = $componentParams->get('facebook_show_icon', 1);
                    /* Storify */
                    $storify_show_icon = $componentParams->get('storify_show_icon', 1);

                    $ONE_DAY = 24 * 3600; // in seconds
                    $grid->feedsRow = array();
                    $FB_INLINE_STYLE_PRINTED = false;
                    $STORIFY_INLINE_STYLE_PRINTED = false;
                    foreach($articles as $content)
                    {                                 
                        $category_name_safe = ActivategridHelper::getCategoryNameByID($content->catid, true);
                        $category_name = ActivategridHelper::getCategoryNameByID($content->catid);
                        $cat_title_color = ActivategridHelper::getConfigByName("cti".$content->catid);  
                        $cat_title_color = (ActivategridHelper::getConfigByName("cti".$content->catid))?"style='color:".$cat_title_color->value."'":"";
                        $cat_text_color_plain = ActivategridHelper::getConfigByName("cte".$content->catid);  
                        $cat_text_color = (ActivategridHelper::getConfigByName("cte".$content->catid))?"style='color:".$cat_text_color_plain->value."'":"";
                        $cat_bg_color = ActivategridHelper::getConfigByName("cbg".$content->catid);  
                        $cat_bg_color = (ActivategridHelper::getConfigByName("cbg".$content->catid))?"style='background-color:".$cat_bg_color->value."'":"";

                        // Twitter boxes
                        if($category_name_safe === "twitter")
                        {
                            $tweet_ID = $content->xreference;
                            $urls = json_decode($content->urls);
                            $url = $urls->urla;

                            if($twitter_replace_url == 0)
                            {
                                $content->fulltext = strip_tags($content->fulltext);                            
                            }
                                                        
                            $htmlrow = '<div onclick="OpenInNewTab(\''.$url.'\')" '.$cat_bg_color.' class="'.$gridSelectors.' '.$category_name_safe.'"><p '.$cat_text_color.' class="tweet">'.$content->fulltext.'</p>';

                            // Twitter publishing date
                            if($twitter_show_date == 1)
                            {
                                $htmlrow  .= '<p '.$cat_title_color.' class="tweet-date">';
                                $created_ts = strtotime($content->created);                              
                                if(date("d")==date("d", $created_ts))
                                    $htmlrow .= @JText::_(COM_ACTIVATEGRID_TODAY); 
                                else if((time()-$created_ts) <= $ONE_DAY*2)
                                {
                                    $htmlrow .= @JText::_(COM_ACTIVATEGRID_YESTERDAY);                                    
                                }
                                else
                                {                                    
                                    if(date("y")==date("y", $created_ts))
                                        $htmlrow .= date("jS F", $created_ts);
                                    else
                                        $htmlrow .= date("jS F y", $created_ts);
                                    $htmlrow .= '</p>';
                                }
                            }                        

                            // Twitter Actions (reply, retweet, favourite)
                            if($twitter_show_actions == 1)
                            {
                                $htmlrow .= "<p class='tweet-actions'>\n";
                                $htmlrow .= "   <a $cat_title_color class='tw' href='https://twitter.com/intent/tweet?in_reply_to=".$tweet_ID."'>reply</a>\n";
                                $htmlrow .= "   <a $cat_title_color class='tw' href='https://twitter.com/intent/retweet?tweet_id=".$tweet_ID."'>- retweet</a>\n";
                                $htmlrow .= "   <a $cat_title_color class='tw' href='https://twitter.com/intent/favorite?tweet_id=".$tweet_ID."'>- favorite</a>\n";
                                $htmlrow .= "</p>\n";
                            }

                            if($twitter_show_actions == 1)
                            {
                                $htmlrow .= "<p class='icon-container'>\n";
                                $htmlrow .= "   <img src='".JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/images/twitter.png' class='icon-twitter' alt='Twitter'/>\n";
                                $htmlrow .= "</p>\n";
                            }
                            $htmlrow .= "</div>\n";
                            $grid->feedsRow[] = $htmlrow;

                        }                        
                        else if($category_name_safe === "instagram")
                        {
                            $images = json_decode($content->images);
                            $urls = json_decode($content->urls);
                            $url = $urls->urla;
                            //$this->feedsRow[] = '<div onclick="OpenInNewTab(\''.$url.'\')" class="item span3 '.$category_name_safe.'"><a href="'.$url.'" target="_blank"><img src="'.$images->image_intro.'"/></a></div>';
                            $htmlrow  = '<div onclick="OpenInNewTab(\''.$url.'\')" '.$cat_bg_color.' class="'.$gridSelectors.'  '.$category_name_safe.'">'."\n";
                            $htmlrow .= "   <a href='".$url."' target='_blank'>\n";
                            $htmlrow .= "    <span class='bw'>\n";
                            $htmlrow .= "<img src='".$images->image_intro."'/></span></a>\n";
                            
                            /* Category title inside the box */
                            if($grid->show_category_title == 1)
                                $htmlrow .= "   <p $cat_title_color class='category'>".$category_name."</p>\n";
                            
                            if($instagram_show_icon == 1)
                            {
                                $htmlrow .= "<p class='icon-container'>\n";
                                $htmlrow .= "   <img src='".JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/images/instagram.png' class='icon-instagram' alt='Instagram'/>\n";
                                $htmlrow .= "</p>\n";
                            }

                            $htmlrow .= "</div>\n";
                            $grid->feedsRow[] = $htmlrow;
                        }
                        else if($category_name_safe === "facebook")
                        {
                            $images = json_decode($content->images);
                            $urls = json_decode($content->urls);
                            $url = $urls->urla;
                            $htmlrow  = '<div onclick="OpenInNewTab(\''.$url.'\')" '.$cat_bg_color.' class="'.$gridSelectors.'  '.$category_name_safe.'">'."\n";
                            if(!empty($images->image_intro))
                            {
                                //$htmlrow .= '<img src="'.$images->image_intro.'"/>';
                                $htmlrow .= '<span style="background: '.$cat_bg_color->value.' url('.$images->image_intro.') center center no-repeat;" class="facebook_thumb">&nbsp;</span>';
                                
                                /* If there is an image, I cut the text more then if there is just text */
                                $textLimit = 100;
                            }
                            else
                                $textLimit = 500;
                            /* Category title inside the box */
                            if($facebook_show_icon == 1)
                            {
                                if(empty($images->image_intro) || empty($content->fulltext))
                                {
                                    $htmlrow .= "<p class='icon-container'>\n";
                                    $htmlrow .= "   <img src='".JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/images/facebook.png' class='icon-facebook' alt='Facebook'/>\n";
                                    $htmlrow .= "</p>\n";
                                }
                            }
                            if(!$FB_INLINE_STYLE_PRINTED)
                            {
                                echo "\n<style>\n";
                                echo ".facebook span {
   color: ".$cat_text_color_plain->value."\n";
                                echo "}\n</style>\n";
                                $FB_INLINE_STYLE_PRINTED = true;
                            }
                            
                            if(!empty($content->fulltext))
                            {
                                //echo "<script>alert('".ActivategridHelper::cutString(stripcslashes($content->fulltext), $textLimit)."');</script>";
                                //$htmlrow .= '<p '.$cat_text_color.' class="title">'.ActivategridHelper::cutString(stripcslashes($content->fulltext), $textLimit).'</p>';
                                $htmlrow .= ActivategridHelper::truncateHTML(stripcslashes($content->fulltext), $textLimit);
                            }
                            
                            if($facebook_show_icon == 1)
                            {
                                $htmlrow .= "<p class='icon-container'>\n";
                                $htmlrow .= "   <img src='".JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/images/facebook.png' class='icon-facebook' alt='Facebook'/>\n";
                                $htmlrow .= "</p>\n";
                            }

                            $htmlrow .= "</div>\n";
                            $grid->feedsRow[] = $htmlrow;
                        }
                        else if($category_name_safe === "storify")
                        {
                            $images = json_decode($content->images);
                            $urls = json_decode($content->urls);
                            $url = $urls->urla;
                            $htmlrow  = '<div onclick="OpenInNewTab(\''.$url.'\')" '.$cat_bg_color.' class="'.$gridSelectors.'  '.$category_name_safe.'">'."\n";
                            if(!empty($images->image_intro))
                            {
                                $htmlrow .= '<span style="background: '.$cat_bg_color->value.' url('.$images->image_intro.') center center no-repeat;" class="storify_thumb">&nbsp;</span>';
                                
                                /* If there is an image, I cut the text more then if there is just text */
                                $textLimit = 100;
                            }
                            else
                                $textLimit = 350;
                            
                            if(!empty($content->fulltext))
                            {
                                $htmlrow .= "<span $cat_text_color class='storify_text'>".ActivategridHelper::truncateHTML(stripcslashes($content->fulltext), $textLimit)."</span>\n";
                            }
                            
                            if($storify_show_icon == 1)
                            {
                                $htmlrow .= "<p class='icon-container'>\n";
                                $htmlrow .= "   <img src='".JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/images/storify.png' class='icon-storify' alt='Storify'/>\n";
                                $htmlrow .= "</p>\n";
                            }

                            $htmlrow .= "</div>\n";
                            $grid->feedsRow[] = $htmlrow;
                        }
                        else
                        {                        
                            $images = json_decode($content->images);
                            $routable_url = "index.php?option=com_activategrid&view=pageslide&catid=".$content->catid."&artid=".$content->id."&Itemid=".$itemid;
                            $article_url = JRoute::_($routable_url);
//                            $extra_fields = ActivategridHelper::getExtraFields($content->id);
//                            $store_details = array("Store Address", "Store Telephone");
//                            if(isset($_GET["a"])) ActivategridHelper::DLog($extra_fields);
//                            $this->store_details_html = "";
//                            foreach ($extra_fields as $extra_field)
//                            {                                
//                                if($extra_field->field_name == $store_details[0])
//                                {
//                                    $this->store_details_html .= "<p class='store-address'>".$extra_field->field_data."</p>";
//                                }
//                                //else if($extra_field->field_name == $store_details[1])
//                                //{
//                                    //if(strlen($content->title)< 20)
//                                    //    $this->store_details_html .= "<p class='store-telephone'>".$extra_field->field_data."</p>";
//                                //}
//                            }
                            //$htmlrow = '<a href="'.$article_url.'"><li class="item span3 '.$category_name_safe.'">';
                            //$htmlrow .= '<div class="item span3 '.$category_name_safe.'">';

                            $htmlrow = '<div onclick="Open(\''.$article_url.'\')" '.$cat_bg_color.' class="'.$gridSelectors.'  '.$category_name_safe.'">';
                            if(isset($images->image_intro))
                            {
                                $htmlrow .= '<img src="'.$images->image_intro.'"/>';  
                            }
                            $htmlrow .= '<p '.$cat_title_color.' class="category">'.  strtoupper($category_name).'</p>';
                            $htmlrow .= '<p '.$cat_text_color.' class="title">'.$content->title.'</p>';
//                            $htmlrow .= $this->store_details_html;
                            $htmlrow .= '<p '.$cat_title_color.' class="readmore">More</p>';
                            $htmlrow .= '</div>';
                            //echo "Prima: ".$routable_url."<br/>";
                            //echo "Dopo: ".$article_url."<br/>";

                            $grid->feedsRow[] = $htmlrow;
                        }
                        //echo "<pre>".print_r($content, true)."</pre>";
                    }
                }
                //$user	= JFactory::getUser();
                //$view   = $jinput->getCmd('view', 'hardwares');

                return $grid;
        }
        
        public static function getExtraFields($artid=0)
        {
            $db = JFactory::getDBO();
            // I look for the extension ID in the table "jos_fieldsandfilters_elements"
            $query = "SELECT * FROM #__fieldsandfilters_extensions_type WHERE extension_name='content'";
            $db->setQuery($query);
            $db->query();
            $content_ext_id = $db->loadResult();
            
            $query = "SELECT fields.field_name, data.field_data FROM #__fieldsandfilters_fields as fields, #__fieldsandfilters_data as data,#__fieldsandfilters_elements as elements WHERE fields.field_id = data.field_id AND fields.field_type='input' AND elements.item_id = ".$artid." AND data.element_id = elements.element_id AND fields.extension_type_id=".$content_ext_id;            
            $db->setQuery($query);
            $db->query();
            $fields = $db->loadObjectList();           
            return $fields;            
        }
        
        public static function getCategoryNameByID($catid = 0, $cleaned = false)
        {
            $db = JFactory::getDBO();
            //$catid = (int)($catid);
            $query = "SELECT cat.title FROM #__categories cat  WHERE cat.id=".$catid;
            //echo $query;
            $db->setQuery($query);
            $db->query();
            $category_title = $db->loadResult();
            
            if($cleaned)
            {
                return self::clean($category_title);
            }
            else
            {
                return $category_title;            
            }
        }
        
        
        public static function getCategoryIDByArticleID($artid = 0)
        {
            $db = JFactory::getDBO();
            //$catid = (int)($catid);
            $query = "SELECT catid FROM #__content cont  WHERE cont.id=".$artid;
            //echo $query;
            $db->setQuery($query);
            $db->query();
            $result = $db->loadResult();
            return $result;
        }
        
        public static function getCategoryDescriptionByID($catid = 0)
        {
            $db = JFactory::getDBO();           
            $query = "SELECT cat.description FROM #__categories cat  WHERE cat.id=".$catid;
            $db->setQuery($query);
            $db->query();
            $result = $db->loadResult();
            return $result;
        }
        
        private static function clean($string) {
            $string = strtolower($string);                    
            $string = str_replace('', '-', $string); // Replaces all spaces with hyphens.            
            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }
        
        public static function getConfigByName($name = '')
        {
            $db = JFactory::getDbo();
            if(empty($name))
                return false;
            
            $query = "SELECT * FROM #__activategrid WHERE name='".$name."' LIMIT 1;";
            $db->setQuery($query);
            $db->execute();
            $result = $db->loadObjectList();
            if(isset($result[0]))
                return $result[0];
            else
                return false;
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
        
        public static function httpify($link, $append = 'http://', $allowed = array('http://', 'https://'))
        {
              $found = false;
              foreach($allowed as $protocol)
                if(strpos($link, $protocol) !== 0)
                  $found = true;

              if($found)
                return $link;
              return $append.$link;
        }
        
        function addhttp($url)
        {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            return $url;
        }
        
        public static function cutString($title, $max_chars)
        {
            if(strlen($title) > $max_chars)
            {
                return substr($title, 0, $max_chars)."...";
            }
            else
                return $title;    
        }
        
            /**
         *  function to truncate and then clean up end of the HTML,
         *  truncates by counting characters outside of HTML tags
         *  
         *  @author alex lockwood, alex dot lockwood at websightdesign
         *  
         *  @param string $str the string to truncate
         *  @param int $len the number of characters
         *  @param string $end the end string for truncation
         *  @return string $truncated_html
         *  
         *  **/
        public static function truncateHTML($str, $len, $end = '&hellip;'){
            //find all tags
            $tagPattern = '/(<\/?)([\w]*)(\s*[^>]*)>?|&[\w#]+;/i';  //match html tags and entities
            preg_match_all($tagPattern, $str, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER );
            //WSDDebug::dump($matches); exit; 
            $i =0;
            //loop through each found tag that is within the $len, add those characters to the len,
            //also track open and closed tags
            // $matches[$i][0] = the whole tag string  --the only applicable field for html enitities  
            // IF its not matching an &htmlentity; the following apply
            // $matches[$i][1] = the start of the tag either '<' or '</'  
            // $matches[$i][2] = the tag name
            // $matches[$i][3] = the end of the tag
            //$matces[$i][$j][0] = the string
            //$matces[$i][$j][1] = the str offest

            while($matches[$i][0][1] < $len && !empty($matches[$i])){

                $len = $len + strlen($matches[$i][0][0]);
                if(substr($matches[$i][0][0],0,1) == '&' )
                    $len = $len-1;


                //if $matches[$i][2] is undefined then its an html entity, want to ignore those for tag counting
                //ignore empty/singleton tags for tag counting
                if(!empty($matches[$i][2][0]) && !in_array($matches[$i][2][0],array('br','img','hr', 'input', 'param', 'link'))){
                    //double check 
                    if(substr($matches[$i][3][0],-1) !='/' && substr($matches[$i][1][0],-1) !='/')
                        $openTags[] = $matches[$i][2][0];
                    elseif(end($openTags) == $matches[$i][2][0]){
                        array_pop($openTags);
                    }else{
                        $warnings[] = "html has some tags mismatched in it:  $str";
                    }
                }


                $i++;

            }

            $closeTags = '';

            if (!empty($openTags)){
                $openTags = array_reverse($openTags);
                foreach ($openTags as $t){
                    $closeTagString .="</".$t . ">"; 
                }
            }

            if(strlen($str)>$len){
                //truncate with new len
                $truncated_html = substr($str, 0, $len);
                //add the end text
                $truncated_html .= $end ;
                //restore any open tags
                $truncated_html .= $closeTagString;


            }else
            $truncated_html = $str;


            return $truncated_html; 
        }
}

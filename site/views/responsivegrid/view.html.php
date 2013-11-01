<?php

/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
/**
 * View to edit
 */
class ActivategridViewResponsivegrid extends JViewLegacy {

        protected $items;
	protected $pagination;
	protected $state;
        protected $params;

        
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{            
                $app = JFactory::getApplication();
                $this->params = $app->getParams('com_activategrid');             
                $componentParams = JComponentHelper::getParams('com_activategrid');
                JHtml::_('jquery.framework');
                $db = JFactory::getDbo();
                $menu = $app->getMenu();
                JHtml::_('bootstrap.framework');
                $document = JFactory::getDocument();
                                // If the option to load jQuery is enalbed, I include it
                
                $loadjQuery = $componentParams->get('jquery', 1);     
                $load_content_dinamically = $componentParams->get('load_content_dinamically', 1);
                $this->load_content_dinamically = $load_content_dinamically;
                if($loadjQuery==1)
                    $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/jquery-2.0.3.min.js");

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
                
                
                // I search the IDs of the selected categories and I create an aerray of them (id=>title)
                $selected_source_categories = $this->params->get("sources_category"); 
                
                // Masonry Effect
                $this->load_effect = $this->params->get("load_effect");
                if($this->load_effect=="R")
                {
                    // Random between 1 and 8
                    $this->load_effect = (int)rand(1, 8);
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
                $order_criteria = $this->params->get("article_order");
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

                $twitter_show_date = $componentParams->get('twitter_show_date', 1);
                $twitter_show_actions = $componentParams->get('twitter_show_actions', 1);
                $twitter_show_icon = $componentParams->get('twitter_show_icon', 1);
                $twitter_replace_url = $componentParams->get('twitter_url_replace', 1);
                
                $instagram_show_icon = $componentParams->get('instagram_show_icon', 1);
                
                $ONE_DAY = 24 * 3600; // in seconds
                $this->feedsRow = array();
                foreach($articles as $content)
                {                                           
                    $category_name_safe = ActivategridHelper::getCategoryNameByID($content->catid, true);
                    $category_name = ActivategridHelper::getCategoryNameByID($content->catid);
                    $cat_title_color = ActivategridHelper::getConfigByName("cti".$content->catid);  
                    $cat_title_color = (ActivategridHelper::getConfigByName("cti".$content->catid))?"style='color:".$cat_title_color->value."'":"";
                    $cat_text_color = ActivategridHelper::getConfigByName("cte".$content->catid);  
                    $cat_text_color = (ActivategridHelper::getConfigByName("cte".$content->catid))?"style='color:".$cat_text_color->value."'":"";
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
                        $htmlrow = '<div onclick="OpenInNewTab(\''.$url.'\')" '.$cat_bg_color.' class="item span3 '.$category_name_safe.'"><p '.$cat_text_color.'>'.$content->fulltext.'</p>';
                        
                        // Twitter publishing date
                        if($twitter_show_date == 1)
                        {
                            $htmlrow  .= '<p '.$cat_title_color.' class="tweet-date">';
                            $created_ts = strtotime($content->created);
                            if((time()-$created_ts) <= $ONE_DAY)
                                $htmlrow .= @JText::_(COM_ACTIVATEGRID_YESTERDAY);
                            if(date("y")==date("y", $created_ts))
                                $htmlrow .= date("jS F", $created_ts);
                            else
                                $htmlrow .= date("jS F y", $created_ts);
                            $htmlrow .= '</p>';                                                        
                        }                        
                        
                        // Twitter Actions (reply, retweet, favourite)
                        if($twitter_show_actions == 1)
                        {
                            $htmlrow .= "<p class='tweet-actions'>\n";
                            $htmlrow .= "   <a ".$cat_title_color." class='tw' href='https://twitter.com/intent/tweet?in_reply_to=".$tweet_ID."'>reply</a>\n";
                            $htmlrow .= "   <a ".$cat_title_color." class='tw' href='https://twitter.com/intent/retweet?tweet_id=".$tweet_ID."'>- retweet</a>\n";
                            $htmlrow .= "   <a ".$cat_title_color." class='tw' href='https://twitter.com/intent/favorite?tweet_id=".$tweet_ID."'>- favorite</a>\n";
                            $htmlrow .= "</p>\n";
                        }
                        
                        if($twitter_show_actions == 1)
                        {
                            $htmlrow .= "<p class='icon-container'>\n";
                            $htmlrow .= "   <img src='".JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/images/twitter.png' class='icon-twitter' alt='Twitter'/>\n";
                            $htmlrow .= "</p>\n";
                        }
                        $htmlrow .= "</div>\n";
                        $this->feedsRow[] = $htmlrow;
                        
                    }                        
                    else if($category_name_safe === "instagram")
                    {
                        $images = json_decode($content->images);
                        $urls = json_decode($content->urls);
                        $url = $urls->urla;
                        //$this->feedsRow[] = '<div onclick="OpenInNewTab(\''.$url.'\')" class="item span3 '.$category_name_safe.'"><a href="'.$url.'" target="_blank"><img src="'.$images->image_intro.'"/></a></div>';
                        $htmlrow  = '<div onclick="OpenInNewTab(\''.$url.'\')" '.$cat_bg_color.' class="item span3 '.$category_name_safe.'">'."\n";
                        $htmlrow .= "   <a href='".$url."' target='_blank'><img src='".$images->image_intro."'/></a>\n";
                        if($instagram_show_icon == 1)
                        {
                            $htmlrow .= "<p class='icon-container'>\n";
                            $htmlrow .= "   <img src='".JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/images/instagram.png' class='icon-instagram' alt='Instagram'/>\n";
                            $htmlrow .= "</p>\n";
                        }
                        
                        $htmlrow .= "</div>\n";
                        $this->feedsRow[] = $htmlrow;
                    }
                    else
                    {                        
                        $images = json_decode($content->images);
                        $article_url = JRoute::_(JURI::base().'index.php?option=com_activategrid&view=pageslide&artid='.$content->id.'&catid='.$content->catid);
                        //$htmlrow = '<a href="'.$article_url.'"><li class="item span3 '.$category_name_safe.'">';
                        //$htmlrow .= '<div class="item span3 '.$category_name_safe.'">';
                        
                        $htmlrow = '<div onclick="Open(\''.$article_url.'\')" '.$cat_bg_color.' class="item span3 '.$category_name_safe.'">';
                        if(isset($images->image_intro))
                        {
                            $htmlrow .= '<img src="'.$images->image_intro.'"/>';  
                        }
                        $htmlrow .= '<p '.$cat_title_color.' class="category">'.  strtoupper($category_name).'</p>';
                        $htmlrow .= '<p '.$cat_text_color.' class="title">'.$content->title.'</p>';
                        $htmlrow .= '<p '.$cat_title_color.' class="readmore">More</p>';
                        $htmlrow .= '</div>';
                        $this->feedsRow[] = $htmlrow;
                    }
                    //echo "<pre>".print_r($content, true)."</pre>";
                }

                //$user	= JFactory::getUser();
                //$view   = $jinput->getCmd('view', 'hardwares');


                $this->state = $this->get('State');




                // Check for errors.
                if (count($errors = $this->get('Errors'))) {
                    throw new Exception(implode("\n", $errors));
                }

                $this->_prepareDocument();
                parent::display($tpl);
	}


	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('com_activategrid_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}       
    
}

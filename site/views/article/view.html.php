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
class ActivategridViewArticle extends JViewLegacy {

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
                $db = JFactory::getDbo();
                $menu = $app->getMenu();
                JHtml::_('jquery.framework');
                $document = JFactory::getDocument();
                // If the option to load jQuery is enalbed, I include it                
                $loadjQuery = $componentParams->get('jquery', 1);
                if($loadjQuery==1)
                    $document->addScript(JURI::base()."components/com_activategrid/views/responsivegrid/tmpl/assets/js/jquery-2.0.3.min.js");
                
                $document->addStyleSheet(JURI::base()."components/com_activategrid/views/article/tmpl/assets/css/style.css");
                
                $jinput = JFactory::getApplication()->input;
                $artid = $this->params->get("source_article");
                $catid = ActivategridHelper::getCategoryIDByArticleID($artid);                
                
                $query = "SELECT * FROM #__content WHERE id=".$artid." AND state=1 LIMIT 1";
                $db->setQuery($query);
                $db->query();
                $article = $db->loadObjectList();                
                $this->article = $article[0];   
                $this->article->category_name = ActivategridHelper::getCategoryNameByID($this->article->catid);
                $this->article->category_name_safe = ActivategridHelper::getCategoryNameByID($this->article->catid,true);
                
                $extra_fields = ActivategridHelper::getExtraFields($this->article->id);    
                
                $store_socials = array("store_twitter_url", "store_facebook_url", "store_google+_url", "store_pinterest_url", "store_youtube_url", "store_instagram_url", "store_tumbler_url");
                $socials_icons = array("twitter.png", "facebook.png", "google.png", "pinterest.png", "youtube.png", "instagram.png", "tumbler.png");                                                              
                
                
                /* Article date */
                $categories_with_date = array("news", "villagenews", "events", "festival", "villagehighlights");
                if(in_array($this->article->category_name_safe, $categories_with_date))
                {
                    $this->article->date = date("F Y", strtotime($this->article->created));
                }
                                
         
                $this->extrafields_html = "";
                $store_details = array("Store Address", "Store Telephone", "Store E-Mail", "Store Website URL");
                if(sizeof($extra_fields) > 0) $this->store_details_html = "<div class='store-details'>";
                $there_is_telephone = false;
                foreach($extra_fields as $extra_field)
                {
                    $extra_field_name = str_replace(" ", "_", strtolower($extra_field->field_name));                   
                    if(in_array($extra_field_name, $store_socials))
                    {
                        
                        $indexOf = array_search($extra_field_name, $store_socials);
                        $field_name = strtolower($extra_field->field_name);
                        $field_value = ActivategridHelper::httpify($extra_field->field_data);
                        $this->extrafields_html .= "<a href='".$field_value."' target='_blank' title=\"Follow ".$this->article->title." on ".  ucfirst(substr($socials_icons[$indexOf], 0, strpos($socials_icons[$indexOf], ".")))."\">\n";
                        $this->extrafields_html .= "    <img src='".JURI::base()."components/com_activategrid/views/pageslide/tmpl/assets/images/".$socials_icons[$indexOf]."' />\n";
                        $this->extrafields_html .= "</a>\n";
                    }
                    
                    if($extra_field->field_name == $store_details[0])
                    {
                        $this->store_details_html .= "<p class='store-address'>".$extra_field->field_data."</p>";
                    }
                    else if($extra_field->field_name == $store_details[1])
                    {
                        $this->store_details_html .= "<p class='store-telephone'>".$extra_field->field_data."</p>";
                    }
                    else if($extra_field->field_name == $store_details[2])
                    {
                        $this->store_details_html .= "<p class='store-email'><a href='mailto:".$extra_field->field_data."'>".$extra_field->field_data."</a></p>";
                        $there_is_telephone = true;
                    }
                    else if($extra_field->field_name == $store_details[3])
                    {
                        if($there_is_telephone) $this->store_details_html .= "<p class='store-details-divider'>|</p>";
                        $this->store_details_html .= "<p class='store-website'><a href='".ActivategridHelper::addhttp($extra_field->field_data)."' target='_blank'>".$extra_field->field_data."</a></p>";
                    }
                    
                } 
                if(sizeof($extra_fields) > 0) $this->store_details_html .= "</div>";
                
                $this->bgcolor = ActivategridHelper::getConfigByName("cbg".$this->article->catid);
               
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

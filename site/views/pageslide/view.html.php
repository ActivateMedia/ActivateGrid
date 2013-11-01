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
class ActivategridViewPageslide extends JViewLegacy {

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
                //JHtml::_('bootstrap.framework');
                $document = JFactory::getDocument();
                // If the option to load jQuery is enalbed, I include it
                $loadjQuery = $componentParams->get('jquery', 1);
                if($loadjQuery==1)
                    $document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js");
                
                $document->addStyleSheet(JURI::base()."components/com_activategrid/views/pageslide/tmpl/assets/css/style.css");
                
                $jinput = JFactory::getApplication()->input;
                $artid = (int)$jinput->get('artid', '0');
                $catid = (int)$jinput->get('catid', '0');
                
                $query = "SELECT * FROM #__content WHERE id=".$artid." AND catid=".$catid." AND state=1 LIMIT 1";
                $db->setQuery($query);
                $db->query();
                $article = $db->loadObjectList();
                
                $extra_fields = ActivategridHelper::getExtraFields();
                //ActivategridHelper::DLog($extra_fields);
                $store_socials = array("store_twitter_url", "store_facebook_url", "store_google+_url", "store_pinterest_url", "store_youtube_url");
                $socials_icons = array("twitter.png", "facebook.png", "google.png", "pinterest.png", "youtube.png");
                
                $this->extrafields_html = "";
                foreach($extra_fields as $extra_field)
                {
                    if(in_array($extra_field, $store_socials))
                    {
                        $indexOf = array_search($extra_field, $store_socials);
                        ActivategridHelper::DLog($extra_field);
                        $field_name = strtolower($extra_field->field_name);
                        $field_value = ActivategridHelper::httpify($extra_field->field_data);
                        $this->extrafields_html .= "<a href='".$field_value."' target='_blank' title='Follow us on ".$extra_field->field_name."'>\n";
                        $this->extrafields_html .= "    <img src='".JURI::base()."components/com_activategrid/views/pageslide/tmpl/assets/images/".$socials_icons[$indexOf]."' />\n";
                        $this->extrafields_html .= "</a>\n";
                    }
                }
                
                //ActivategridHelper::DLog($this->article->extrafields_html);
                
                $this->article = $article[0];   
                $this->article->category_name = ActivategridHelper::getCategoryNameByID($this->article->catid);
                $this->article->category_name_safe = ActivategridHelper::getCategoryNameByID($this->article->catid,true);
                //$this->close_button = "<a href='javascript:parent.$.pageslide.close()'><div class='close-btn'>X</div></a>";
                
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

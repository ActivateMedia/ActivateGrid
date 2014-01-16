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
class ActivategridViewCss extends JViewLegacy {

        protected $items;
	protected $pagination;
	protected $state;
        protected $params;

        
	/**
	 * Display the view
	 */
	public function display($cachable = false, $urlparams = false)
	{            
                $app = JFactory::getApplication();
                $this->params = $app->getParams('com_activategrid');             
                $componentParams = JComponentHelper::getParams('com_activategrid');
                $db = JFactory::getDbo();
                $menu = $app->getMenu();
                $itemid = (int)$_GET["Itemid"];
                $item =& $menu->getItem($itemid);
                //JHtml::_('jquery.framework');
                $document = JFactory::getDocument();
                //$document->setType('raw');
                
                $load_content_dinamically = $componentParams->get('load_content_dinamically', 1);
                $settings = ActivategridHelper::getConfig("category_color");                
                if($_GET["debug"]) ActivategridHelper::DLog($componentParams);
                if($_GET["debug"]) ActivategridHelper::DLog($settings);
                $this->gridItemWidth = $this->params->get('griditem_width', "200");
                $this->gridItemWidth = $this->params->get('griditem_width', "200");
                $this->gridItemHeight = $this->params->get('griditem_height', "350");
                $this->gridItemSelector = $this->params->get('griditem_selector', "gridItem");
                $this->gridItemHalfWidth = $this->gridItemWidth / 2;
                $this->css .= "";
                $this->css .= "/* CSS Genrated by Activate Grid - Joomla! Component \r";
                $this->css .= "   Copyright (C) 2013. All rights reserved.\r";
                $this->css .= "   Author: Activate Media - www.activatemedia.co.uk */\r\r";
                $this->css .= ".grid .$this->gridItemSelector {
   width: ".$this->gridItemWidth."px !important;
   height: ".$this->gridItemHeight."px !important;
}\n";
                $this->css .= ".grid .$this->gridItemSelector img {
   width: ".$this->gridItemWidth."px !important;
}\n";
                $this->css .= ".tweet-date {
    width: ".$this->gridItemWidth."px !important;
    margin-left: -".$this->gridItemHalfWidth."px !important;
}\n";
                
                $this->css .= ".$this->gridItemSelector .tweet-actions {
    width: ".$this->gridItemWidth."px !important;
    margin-left: -".$this->gridItemHalfWidth."px !important;
}\n";
                $this->css .= ".$this->gridItemSelector .icon-container {
    width: ".$this->gridItemWidth."px !important;
    margin-left: -".$this->gridItemHalfWidth."px !important;
}\n";
                $this->css .= ".gridItem .thumb {
    width: ".$this->gridItemWidth."px !important;
    height: ".$this->gridItemWidth."px !important;
    background-size: cover !important;
}\n";
                
                $this->css .= ".gridItem i {
    top: ".($this->gridItemWidth/2)."px !important;
}\n";
                
                if($load_content_dinamically != 1)
                    $this->css .= ".gridItem {
    opacity: 1 !important;
}\n";
                
                
               
                
                /* This part is to process the advanced style configuration 
                 * put in the interface provided in the component back end
                 */
                $this->css .= "\r/* Custom Advanced Style */\r";
                /* Border Radius */
                $cssBranches = array();
                $cssBranchesNested = array();
                foreach ($settings as $setting)
                {
                    //echo $setting->name." -> ".$setting->value."\r";
                    if(!empty($setting->value))
                    {
                        $explosion = explode("_", $setting->name);
                        $categoryID = $explosion[1];
                        $property = $explosion[0];
                        $categoryName = strtolower(ActivategridHelper::getCategoryNameByID($categoryID));
                        
                        if($property == "cbr") {
                            $cssBranches[$categoryName][] = "
    -webkit-border-radius: ".$setting->value."px;
    -moz-border-radius: ".$setting->value."px;
    border-radius: ".$setting->value."px;";
                         
                            // for radius - I specially need to change also the child image inside
                            $this->css .= ".".$categoryName. " span, .".$categoryName. " video, .".$categoryName. " iframe {
    -webkit-border-radius: ".$setting->value."px ".$setting->value."px 0 0;
    -moz-border-radius: ".$setting->value."px ".$setting->value."px 0 0;
    border-radius: ".$setting->value."px ".$setting->value."px 0 0;
}\r";
                        }                        
                       // Border Color
                       else if($property == "cbc") $cssBranches[$categoryName][] = "\r   border-color: ".$setting->value.";";
                       // Border Width
                       else if($property == "cbs")
                       {
                           $cssBranches[$categoryName][] = "\r   border-style: solid;";
                           $cssBranches[$categoryName][] = "\r   border-width:".$setting->value."px;";
                       }
                       else if($property == "cti")
                                $cssBranchesNested[$categoryName][".category"][] = "\r    color: ".$setting->value.";\r";
                       else if($property == "ca")
                       {
                                $cssBranchesNested[$categoryName][".text a"][] = "\r    color: ".$setting->value.";\r";
                                $cssBranchesNested[$categoryName]["a"][] = "\r    color: ".$setting->value.";\r";                                
                                if($categoryName == "twitter")
                                    $cssBranchesNested[$categoryName][".tweet-actions a, .tweet-date"][] = "\r    color: ".$setting->value.";\r";
                       }
                       else if($property == "cfs")
                       {
                                $cssBranchesNested[$categoryName][".text"][] = "\r    font-size: ".$setting->value."px;\r    line-height: ".($setting->value+6)."px;";
                                if($categoryName == "twitter")
                                    $cssBranchesNested[$categoryName][".tweet-actions, .tweet-date"][] = "\r    font-size: ".$setting->value."px;\r    line-height: ".($setting->value+6)."px;";
                       }
                       else if($property == "ctmtb")
                                $cssBranchesNested[$categoryName][".text"][] = "\r    margin-top: ".$setting->value."px;";
                       else if($property == "ctmlr")
                                $cssBranchesNested[$categoryName][".text"][] = "\r    margin-left: ".$setting->value."px;\r    margin-right: ".$setting->value."px;";
                    }
                }
                //print_r($cssBranches);
                foreach($cssBranches as $categoryName => $categoryCSSBlock)
                {
                    $this->css .= ".".$categoryName." { ";
                    foreach ($categoryCSSBlock as $categoryCSSElement)
                    {
                        $this->css .= $categoryCSSElement;
                    }
                    $this->css .= "\r}\r";
                }
                
                //print_r($cssBranchesNested);
                foreach($cssBranchesNested as $categoryName => $categoryCSSBlock)
                {                    
                    foreach ($categoryCSSBlock as $categoryCSSNode => $categoryCSSElement)
                    {
                        $this->css .= "\r.".$categoryName." ".$categoryCSSNode. " {";
                        foreach ($categoryCSSElement as $cssCode)
                        {
                            $this->css .= $cssCode;
                        }
                        $this->css .= "}\r";
                    }   
                    
                }
                
                
                
                
if(1!=1) {
    $this->css .= ".instagram {
  margin: 50px auto;
  width: 200px;
  height: 200px;
  background: #ccc;
  -webkit-border-radius: 40px;
  -moz-border-radius: 40px;
  border-radius: 40px;
  border: 3px solid rgba(41, 38, 38, 0.5);
  border-width: 5px 0;
  position: relative;
  border-width: 0 0 6px;
  -moz-box-shadow: inset 0px 0px 30px #000;
  -webkit-box-shadow: inset 0px 0px 30px #000;
  box-shadow: inset 0px 0px 30px #000000, 0px -137px 300px #ffffff;
  background: -moz-radial-gradient(center, ellipse cover, #f4f1ec 0%, #f4f1ec 31%, #785e51 100%);
  /* FF3.6+ */

  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #f4f1ec), color-stop(31%, #f4f1ec), color-stop(100%, #785e51));
  /* Chrome,Safari4+ */

  background: -webkit-radial-gradient(center, ellipse cover, #f4f1ec 0%, #f4f1ec 31%, #785e51 100%);
  /* Chrome10+,Safari5.1+ */

  background: -o-radial-gradient(center, ellipse cover, #f4f1ec 0%, #f4f1ec 31%, #785e51 100%);
  /* Opera 12+ */

  background: -ms-radial-gradient(center, ellipse cover, #f4f1ec 0%, #f4f1ec 31%, #785e51 100%);
  /* IE10+ */

  background: radial-gradient(ellipse at center, #f4f1ec 0%, #f4f1ec 31%, #785e51 100%);
  /* W3C */

}
.up {
  width: 200px;
  height: 60px;
  background: #9a6d50;
  -webkit-border-radius: 40px 40px 0 0;
  -moz-border-radius: 40px 40px 0 0;
  border-radius: 40px 40px 0 0;
  border-bottom: 2px solid #311B02;
  z-index: 1;
  overflow: hidden;
  -moz-box-shadow: inset 0px 5px 9px rgba(255, 255, 255, 0.5);
  box-shadow: inset 0px 5px 9px rgba(255, 255, 255, 0.5);
  background: -moz-radial-gradient(top, ellipse cover, #cc7f73 12%, #742e22 70%);
  /* FF3.6+ */

  background: -webkit-gradient(radial, center top, 0px, center center, 100%, color-stop(12%, #cc7f73), color-stop(70%, #742e22));
  /* Chrome,Safari4+ */

  background: -webkit-radial-gradient(top, ellipse cover, #cc7f73 12%, #742e22 70%);
  /* Chrome10+,Safari5.1+ */

  background: -o-radial-gradient(top, ellipse cover, #cc7f73 12%, #742e22 70%);
  /* Opera 12+ */

  background: -ms-radial-gradient(top, ellipse cover, #cc7f73 12%, #742e22 70%);
  /* IE10+ */

  background: radial-gradient(ellipse at top, #cc7f73 12%, #742e22 70%);
  /* W3C */

}
.up .rainbow {
  margin: 0 16px;
  width: 30px;
  height: 60px;
  background: -moz-linear-gradient(left, rgba(252, 53, 84, 0.7) 25%, rgba(250, 199, 46, 0.7) 25%, rgba(250, 199, 46, 0.7) 50%, rgba(109, 202, 147, 0.7) 50%, rgba(109, 202, 147, 0.7) 75%, rgba(63, 141, 250, 0.7) 75%);
  /* FF3.6+ */

  background: -webkit-gradient(linear, left top, right top, color-stop(25%, rgba(250, 199, 46, 0.7)), color-stop(50%, rgba(109, 202, 147, 0.7)), color-stop(75%, rgba(63, 141, 250, 0.7)));
  /* Chrome,Safari4+ */

  background: -webkit-linear-gradient(left, rgba(252, 53, 84, 0.7) 25%, rgba(250, 199, 46, 0.7) 25%, rgba(250, 199, 46, 0.7) 50%, rgba(109, 202, 147, 0.7) 50%, rgba(109, 202, 147, 0.7) 75%, rgba(63, 141, 250, 0.7) 75%);
  /* Chrome10+,Safari5.1+ */

  background: -o-linear-gradient(left, rgba(250, 199, 46, 0.7) 25%, rgba(109, 202, 147, 0.7) 50%, rgba(63, 141, 250, 0.7) 75%);
  /* Opera 11.10+ */

  background: -ms-linear-gradient(left, rgba(250, 199, 46, 0.7) 25%, rgba(109, 202, 147, 0.7) 50%, rgba(63, 141, 250, 0.7) 75%);
  /* IE10+ */

  background: linear-gradient(to right, rgba(252, 53, 84, 0.7) 25%, rgba(250, 199, 46, 0.7) 25%, rgba(250, 199, 46, 0.7) 50%, rgba(109, 202, 147, 0.7) 50%, rgba(109, 202, 147, 0.7) 75%, rgba(63, 141, 250, 0.7) 75%);
  /* W3C */

  -moz-box-shadow: inset 0px 5px 9px rgba(255, 255, 255, 0.3);
  -webkit-box-shadow: inset 0px 5px 9px rgba(255, 255, 255, 0.3);
  box-shadow: inset 0px 5px 9px rgba(255, 255, 255, 0.3);
}
.up .rainbow:after {
  content: 'Insta';
  border: 1px solid #381604;
  -webkit-border-radius: 13px;
  -moz-border-radius: 13px;
  border-radius: 13px;
  font-size: 10px;
  text-shadow: 1px 1px 1px #000;
  color: #e7e2df;
  top: 55px;
  position: absolute;
  left: 14px;
  padding: 2px 4px;
  border-width: 0 0 1px;
  background: -moz-linear-gradient(-77deg, #361f02 0%, #8d6432 50%, #361f02 100%);
  /* FF3.6+ */

  background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, #361f02), color-stop(50%, #8d6432), color-stop(100%, #361f02));
  /* Chrome,Safari4+ */

  background: -webkit-linear-gradient(-77deg, #361f02 0%, #8d6432 50%, #361f02 100%);
  /* Chrome10+,Safari5.1+ */

  background: -o-linear-gradient(-77deg, #361f02 0%, #8d6432 50%, #361f02 100%);
  /* Opera 11.10+ */

  background: -ms-linear-gradient(-77deg, #361f02 0%, #8d6432 50%, #361f02 100%);
  /* IE10+ */

  background: linear-gradient(-77deg, #361f02 0%, #8d6432 50%, #361f02 100%);
  /* W3C */

}
.up .eye {
  width: 30px;
  height: 30px;
  border: 3px solid rgba(255, 255, 255, 0.5);
  position: absolute;
  top: 15px;
  right: 15px;
  border-width: 3px 3px 3px;
  border-color: #520606 rgba(95, 27, 27, 0.71) rgba(218, 125, 125, 0.64);
  -webkit-border-radius: 9px;
  -moz-border-radius: 9px;
  border-radius: 9px;
  -moz-box-shadow: -1px 1px 0px rgba(255, 255, 255, 0.13), inset 0px 0px 7px #000000, inset 0px 12px 15px rgba(255, 255, 255, 0.3);
  -webkit-box-shadow: -1px 1px 0px rgba(255, 255, 255, 0.13), inset 0px 0px 7px #000000, inset 0px 12px 15px rgba(255, 255, 255, 0.3);
  box-shadow: -1px 1px 0px rgba(255, 255, 255, 0.13), inset 0px 0px 7px #000000, inset 0px 12px 15px rgba(255, 255, 255, 0.3);
  background: #333;
  background: -moz-radial-gradient(center, ellipse cover, #ffffff 0%, rgba(57, 39, 59, 0.77) 8%, rgba(32, 12, 35, 0.8) 9%, rgba(58, 42, 72, 0.97) 14%, rgba(59, 45, 74, 0.96) 15%, rgba(63, 70, 87, 0.92) 22%, rgba(68, 101, 104, 0.87) 31%, rgba(64, 79, 92, 0.79) 37%, rgba(60, 53, 78, 0.89) 44%, rgba(58, 42, 72, 0.93) 47%, rgba(0, 0, 0, 0.86) 50%, rgba(74, 109, 112, 0.81) 52%, rgba(73, 107, 110, 0.79) 53%, rgba(67, 98, 101, 0.81) 57%, #060309 100%);
  /* FF3.6+ */

  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #ffffff), color-stop(8%, rgba(57, 39, 59, 0.77)), color-stop(9%, rgba(32, 12, 35, 0.8)), color-stop(14%, rgba(58, 42, 72, 0.97)), color-stop(15%, rgba(59, 45, 74, 0.96)), color-stop(22%, rgba(63, 70, 87, 0.92)), color-stop(31%, rgba(68, 101, 104, 0.87)), color-stop(37%, rgba(64, 79, 92, 0.79)), color-stop(44%, rgba(60, 53, 78, 0.89)), color-stop(47%, rgba(58, 42, 72, 0.93)), color-stop(50%, rgba(0, 0, 0, 0.86)), color-stop(52%, rgba(74, 109, 112, 0.81)), color-stop(53%, rgba(73, 107, 110, 0.79)), color-stop(57%, rgba(67, 98, 101, 0.81)), color-stop(100%, #060309));
  /* Chrome,Safari4+ */

  background: -webkit-radial-gradient(center, ellipse cover, #ffffff 0%, rgba(57, 39, 59, 0.77) 8%, rgba(32, 12, 35, 0.8) 9%, rgba(58, 42, 72, 0.97) 14%, rgba(59, 45, 74, 0.96) 15%, rgba(63, 70, 87, 0.92) 22%, rgba(68, 101, 104, 0.87) 31%, rgba(64, 79, 92, 0.79) 37%, rgba(60, 53, 78, 0.89) 44%, rgba(58, 42, 72, 0.93) 47%, rgba(0, 0, 0, 0.86) 50%, rgba(74, 109, 112, 0.81) 52%, rgba(73, 107, 110, 0.79) 53%, rgba(67, 98, 101, 0.81) 57%, #060309 100%);
  /* Chrome10+,Safari5.1+ */

  background: -o-radial-gradient(center, ellipse cover, #ffffff 0%, rgba(57, 39, 59, 0.77) 8%, rgba(32, 12, 35, 0.8) 9%, rgba(58, 42, 72, 0.97) 14%, rgba(59, 45, 74, 0.96) 15%, rgba(63, 70, 87, 0.92) 22%, rgba(68, 101, 104, 0.87) 31%, rgba(64, 79, 92, 0.79) 37%, rgba(60, 53, 78, 0.89) 44%, rgba(58, 42, 72, 0.93) 47%, rgba(0, 0, 0, 0.86) 50%, rgba(74, 109, 112, 0.81) 52%, rgba(73, 107, 110, 0.79) 53%, rgba(67, 98, 101, 0.81) 57%, #060309 100%);
  /* Opera 12+ */

  background: -ms-radial-gradient(center, ellipse cover, #ffffff 0%, rgba(57, 39, 59, 0.77) 8%, rgba(32, 12, 35, 0.8) 9%, rgba(58, 42, 72, 0.97) 14%, rgba(59, 45, 74, 0.96) 15%, rgba(63, 70, 87, 0.92) 22%, rgba(68, 101, 104, 0.87) 31%, rgba(64, 79, 92, 0.79) 37%, rgba(60, 53, 78, 0.89) 44%, rgba(58, 42, 72, 0.93) 47%, rgba(0, 0, 0, 0.86) 50%, rgba(74, 109, 112, 0.81) 52%, rgba(73, 107, 110, 0.79) 53%, rgba(67, 98, 101, 0.81) 57%, #060309 100%);
  /* IE10+ */

  background: radial-gradient(ellipse at center, #ffffff 0%, rgba(57, 39, 59, 0.77) 8%, rgba(32, 12, 35, 0.8) 9%, rgba(58, 42, 72, 0.97) 14%, rgba(59, 45, 74, 0.96) 15%, rgba(63, 70, 87, 0.92) 22%, rgba(68, 101, 104, 0.87) 31%, rgba(64, 79, 92, 0.79) 37%, rgba(60, 53, 78, 0.89) 44%, rgba(58, 42, 72, 0.93) 47%, rgba(0, 0, 0, 0.86) 50%, rgba(74, 109, 112, 0.81) 52%, rgba(73, 107, 110, 0.79) 53%, rgba(67, 98, 101, 0.81) 57%, #060309 100%);
  /* W3C */

}";
}
                
                
                $mimetype = "Content-Type: text/css; charset=UTF-8";
                $document->setMimeEncoding("text/css");
                JFactory::getApplication()->setHeader($mimetype, 'creation-date="'.JFactory::getDate()->toRFC822().'"', true);
                echo $this->css;
 
		// Get the document object.
//		$document	= JFactory::getDocument();
//		$vName		= 'css';
//		$vFormat	= 'raw';
//
//		// Get and render the view.
//		//if ($view = $this->getView($vName, $vFormat))
//		//{
//			// Load the filter state.
//			$app = JFactory::getApplication();
//
//			// Push document object into the view.
//			$view->document = $document;
//
//			$view->display();
		//}
	}
}

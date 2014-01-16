<?php
/**
 * @copyright	Copyright (c) 2013 Activate Media (http://activatemedia.co.uk). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Activate Media - ActivateGrid Helper Class.
 *
 * @package		Joomla.Site
 * @subpakage	activategrid.activategrid
 */
class modactivategridHelper {
	public function debug($str)
        {
            if(is_array($str))
                echo "<pre>".print_r($str,true)."</pre>";
            else if(is_object($str))
                echo "<pre>".print_r($str,true)."</pre>";
            else
                echo "<pre>".$str."</pre>";
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
}
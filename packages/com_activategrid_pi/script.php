<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
define('DS','/');
/**
 * Script file of ActivateGrid component
 */
class com_activategrid_piInstallerScript
{

        function install($parent) 
        {
        }

        function uninstall($parent) 
        {          
            echo '<p>' . JText::_('COM_ACTIVATEGRID_PI_UNINSTALL_TEXT') . '</p>';
        }
 
        /**
         * method to update the component
         *
         * @return void
         */
        function update($parent) 
        {
            //echo '<div class="alert alert-info">';
            //echo '  <p>' . JText::_('COM_ACTIVATEGRID_PI_UPDATE_TEXT').' to the version: '.$parent->get('manifest')->version. '</p>';
            //echo '</div>';
        }
 
        /**
         * method to run before an install/update/uninstall method
         *
         * @return void
         */
        function preflight($type, $parent) 
        {
            //echo '<div class="alert alert-success">';
            //echo '  <p>' . JText::_('COM_ACTIVATEGRID_PI_INSTALL_TEXT' ) . '</p>';
            //echo '</div>';           
        }
 
        /**
         * method to run after an install/update/uninstall method
         *
         * @return void
         */
        function postflight($type, $parent) 
        {
			self::removeAdminMenuItem();
        }
		
		public function removeAdminMenuItem()
		{
			$db = JFactory::getDBO();
			$sql = "UPDATE #__menu SET client_id = 10 WHERE title = 'com_activategrid_pi' LIMIT 1";
			$db->setQuery($sql);
			$db->execute();
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
}
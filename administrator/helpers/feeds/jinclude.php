<?php
//define constant
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
 
//you need to adjust joomla path according to your joomla installation
define( 'JPATH_BASE', $_SERVER[ 'DOCUMENT_ROOT' ] . DS . 'andrea/joomla31' );
 
//include joomla core files
require_once( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
require_once( JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php' );
 
//create application
$app =& JFactory::getApplication('site');
$componentParams = $app->getParams('com_activategrid');
$db = JFactory::getDBO();

if (version_compare(JVERSION, '3.0', 'lt'))
{
	JTable::addIncludePath(JPATH_PLATFORM . 'joomla/database/table');
}
?>

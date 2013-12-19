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

/**
 * @param	array	A named array
 * @return	array
 */
function ActivategridBuildRoute(&$query)
{
       $segments = array();
       //echo "<pre><h1>BuildRoute Query</h1>".print_r( $query,true)."</pre>";
       /*if(isset( $query['view'] ))
       {
               $segments[] = $query['view'];
               unset( $query['view'] );
       };*/
       unset( $query['view'] );
       if(isset( $query['catid'] ))
       {
                $segments[] = $query['catid']."-".categoryID_to_Slug($query['catid']);
                unset( $query['catid'] );
       };
       if( isset($query['artid']) )
       {
                $segments[] = $query['artid']."-".articleID_to_Slug($query['artid']);
                unset( $query['artid'] );
       };
       
       //unset( $query['view'] );
       //echo "<pre><h1>BuildRoute Segments</h1>".print_r( $segments,true)."</pre>";
       
       return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 *
 * index.php?/activategrid/task/id/Itemid
 *
 * index.php?/activategrid/id/Itemid
 */
function ActivategridParseRoute( $segments )
{
       //echo "<pre><h1>ParseRoute Segments</h1>".print_r( $segments,true)."</pre>";
       $vars = array();
       /*$app =& JFactory::getApplication();
       $menu =& $app->getMenu();
       $item =& $menu->getActive();
       */
       $app = JFactory::getApplication();
       $menu = $app->getMenu();
       $item = $menu->getActive();
       //echo "<pre><h1>ParseRoute Item</h1>".print_r( $item,true)."</pre>";
       //echo "<pre><h1>Router</h1>".print_r( $item->query,true)."</pre>";
       
        // Count segments
       $count = count( $segments );
       //Handle View and Identifier
       /*$vars['catid']   = 13;// (int) $id[0];
                       $vars['artid']   = 244;// (int) $id[1];
                       $vars['view'] = 'pageslide';
       */
       
       
       if(isset($segments[0]))
       {
           $vars['view'] = "pageslide";
           $vars['catid']   = extractIDFrom_ParamSlug($segments[0]);
           $vars['artid']   = extractIDFrom_ParamSlug($segments[1]);
       }
       else
       {
           $vars['view'] = 'responsivegrid';
       }
       //echo "<h1>".$segments[1]."</h1>";
       //echo extractIDFrom_ParamSlug($segments[1]);
           /*
       switch( $segments[0] )
       {
                case 'responsivegrid':
                   // echo "TEST";                      
                       $vars['view'] = 'responsivegrid';
                    $vars['Itemid']   = 101;
                       break;
               case 'pageslide':                   
                       //$id   = explode( ':', $segments[$count-1] );
                       //echo "<pre><h1>ID</h1>".print_r($id,true)."</pre>";
                       $vars['view'] = $segments[0];
                       $vars['catid']   = (int) $segments[1];
                       $vars['artid']   = (int) $segments[2];
                       $vars['Itemid']   = 101;
                       break;
       }*/
       //echo "<pre><h1>ParseRoute Vars</h1>".print_r( $vars,true)."</pre>";
       return $vars;
}

function categoryID_to_Slug($id)
{
    $id = (int)$id;
    $db = JFactory::getDBO();
    $query = "SELECT alias FROM #__categories WHERE id=$id";
    $db->setQuery($query);
    $db->query();
    $result = $db->loadResult();   
    return $result;  
}


function articleID_to_Slug($id)
{
    $id = (int)$id;
    $db = JFactory::getDBO();
    $query = "SELECT alias FROM #__content WHERE id=$id";
    $db->setQuery($query);
    $db->query();
    $result = $db->loadResult();   
    return $result;  
}

function extractIDFrom_ParamSlug($param, $divider = ":")
{
    $dividerPos = strpos($param, $divider);
    if($dividerPos == -1) return 0;
    
    return substr($param, 0, $dividerPos);
}
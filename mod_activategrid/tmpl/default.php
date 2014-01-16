<?php
/**
 * @copyright	Copyright (c) 2013 Activate Media (http://activatemedia.co.uk). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
define('DS', '/');

require_once JPATH_SITE.DS."components".DS."com_activategrid".DS."helpers".DS."activategrid.php";

$app =& JFactory::getApplication();
$db = JFactory::getDbo();
$menu = &$app->getMenu();    
$activategrid_menu_itemid = $params->get("gridMenuItemid", -1);
if($activategrid_menu_itemid == -1) :
    echo "Error - select the Activategrid Menu Itemid.\n";
else :
$item =& $menu->getItem($activategrid_menu_itemid);
$itemid =&$item->id;
$articlesID = $item->params->get("sources_articles");
$document = JFactory::getDocument();

$componentParams = &JComponentHelper::getParams('com_activategrid');

$grid = ActivategridHelper::ActivateGrid($componentParams, $document, $itemid, $item->params);
 
    ?>


<div id="gridContainer" class="grid effect-<?=$grid->load_effect;?>">
    <?php foreach($grid->feedsRow as $feed) :
        echo $feed."\n";
    endforeach;
    ?>    
</div>  

<script type="text/javascript">
    $( document ).ready(function() {
        function startMasonry() {
            var container = document.querySelector('.grid');   
            var msnry = new Masonry( container, {
              // options...
              itemSelector: '.gridItem',
              columnWidth: 220
            });
            console.log(msnry);
        }
        startMasonry();
        
        <?php if($grid->load_content_dinamically==1) : ?>        
        new AnimOnScroll( document.getElementById( 'gridContainer' ), {
                minDuration : 0.4,
                maxDuration : 0.7,
                viewportFactor : 0.2
        } );       
        <?php endif; ?>
    });
</script>

<?php endif; ?>
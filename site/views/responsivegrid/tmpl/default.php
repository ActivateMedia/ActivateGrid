<?php
/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div id="container" class="grid effect-<?=$this->load_effect;?> js-masonry" data-masonry-options='{ "columnWidth": 240, "itemSelector": ".item" }'>    
    <? foreach($this->feedsRow as $feed) :
      echo $feed."\n";
    endforeach;
    ?>    
</div>

<?php 

if($this->load_content_dinamically==1) : ?>
<script>
$(document).ready(function(){
        new AnimOnScroll( document.getElementById( 'container' ), {
                minDuration : 0.4,
                maxDuration : 0.7,
                viewportFactor : 0.2
        } );
});
</script>

<?php endif; ?>
    
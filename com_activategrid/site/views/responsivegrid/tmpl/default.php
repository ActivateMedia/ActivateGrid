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

if(isset($this->grid->category_intro)) echo $this->grid->category_intro;
?>


<? if($this->grid->load_content_dinamically == 1) : ?>
<div id="container" class="grid effect-<?=$this->grid->load_effect;?> js-masonry" data-masonry-options='{ "columnWidth": <?=$this->grid->gridItemWidth;?>, "itemSelector": ".<?=$this->grid->gridItemSelector;?>" }'>
    <?php else: ?>  
<div id="container" class="grid effect-<?=$grid->load_effect;?>">
<?php endif; ?>    
    <? foreach($this->grid->feedsRow as $feed) :
        echo $feed."\n";
    endforeach;
    ?>    
</div>

<?php 

if($this->grid->load_content_dinamically==1) : ?>
<script>
$(document).ready(function(){
        new AnimOnScroll( document.getElementById( 'container' ), {
                minDuration : 0.4,
                maxDuration : 0.7,
                viewportFactor : 0.2
        } );
});
</script>

<?php else: ?>


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
    });
</script>

<?php endif; ?>
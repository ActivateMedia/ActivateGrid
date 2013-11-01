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

$images = json_decode($this->article->images);
$full_image = $images->image_fulltext;

echo "<div class='article_div' style='background-color:".$this->bgcolor->value."'>\n";

?>
<div class="article_div_img" style="background-image:url(<?=$full_image;?>);"></div>

<?php            
    echo "<div class='category'>".$this->article->category_name."</div>\n";
    echo "<div class='title'>".$this->article->title."</div>\n";
    echo "<div class='date'>".date("F Y", strtotime($this->article->created))."</div>\n";
    echo "<div class='social-networks'>".$this->extrafields_html."</div>\n";
    if(!empty($this->article->fulltext)) echo "<div class='content'>".$this->article->fulltext."</div>\n";
    else echo "<div class='content'>".$this->article->introtext."</div>\n";
?>

</div>

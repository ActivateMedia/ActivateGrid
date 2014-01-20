<?php
/**
 * @version     1.0.0
 * @package     com_activategrid
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Andrea Falzetti <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


echo $this->html;


?>


<script>
jQuery(document).ready(function ($) {
        var element;

        // Auto Style the sample DIV for each category
        $('.cp').each(function(i, obj) {  
            if(obj.value !== "")
            {                
                var tmpElementToChange = obj.id.substring(0, 3);            
                var tmp_category_id = obj.id.substring(3, obj.id.length);
                
                if(tmpElementToChange === "cti") // category title color
                    $("#cat_"+tmp_category_id+"_title_sample").css('color', obj.value);
                else if(tmpElementToChange === "cte") // category text color
                    $("#cat_"+tmp_category_id+"_text_sample").css('color', obj.value);
                else if(tmpElementToChange === "cbg") // category bacground color
                    {
//                        prompt("", "I change bg color to: " + "#cat_"+tmp_category_id+"_sample --> " + obj.value);
                    $("#cat_"+tmp_category_id+"_sample").css('backgroundColor', obj.value);
                    }
                //$(obj).css('backgroundColor', obj.value);      
            }
        });
        
       var currentSampleDivID;
       var currentSampleSpanTitleID;
       var currentSampleSpanTextID;
       var category_id;
       
        $('.cp').ColorPicker({
            
	color: '#ffffff',
        onBeforeShow: function () {
                element = this.id;
                $('input').ColorPickerSetColor($("#"+element).val());
                category_id = element.substring(3, element.length)
                currentSampleDivID = "cat_" + category_id + "_sample";
                currentSampleSpanTitleID = "cat_" + category_id + "_title_sample";
                currentSampleSpanTextID = "cat_" + category_id + "_text_sample";
	},
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);                
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		//$("#"+element).css('backgroundColor', '#' + hex);
                $("#"+element).val('#' + hex);
                var elementToChange = element.substring(0, 3);
                //alert(elementToChange);
                if(elementToChange == "cti") // category title color
                    $("#"+currentSampleSpanTitleID).css('color', '#' + hex);
                else if(elementToChange == "cte") // category text color
                    $("#"+currentSampleSpanTextID).css('color', '#' + hex);
                else if(elementToChange == "cbg") // category bacground color
                    $("#"+currentSampleDivID).css('backgroundColor', '#' + hex);
	}
        /*,
        onSubmit: function(hsb, hex, rgb, el) {
                $(el).css('backgroundColor', '#' + hex);
		$(el).val('#' + hex);
	}     */   
    })
});
</script>





jQuery( document ).ready(function( $ ) {  
    
    var cpElementID;
    var cpCategoryID;
    var cpAction;
    var cpSplitTMP;
    var cpValue;

    var btnClassAdd, btnClassRemove, opposite;
    // Input on change handler
    $( ".switch" ).click(function() {  
        
        cpElementID = this.id;
        cpSplitTMP = cpElementID.split("_");
        cpAction = cpSplitTMP[1];
        cpCategoryID = cpSplitTMP[2];
        cpValue = cpSplitTMP[3];
        
        //console.log(cpAction + " on #gridItem"+cpCategoryID+ " --> " + cpValue);
        
        if(cpValue === "1")
        {
            cpValue = "block";
            btnClassAdd = "btn-success";
            btnClassRemove = "btn-danger";
            opposite = cpSplitTMP[0] + "_" + cpSplitTMP[1] + "_" + cpSplitTMP[2] + "_0";
        }
        else
        {
            cpValue = "none";
            btnClassAdd = "btn-danger";
            btnClassRemove = "btn-success";
            opposite = cpSplitTMP[0] + "_" + cpSplitTMP[1] + "_" + cpSplitTMP[2] + "_1";
        }
        console.log(btnClassRemove);
        $(this).addClass(btnClassAdd);
        $("#"+opposite).removeClass(btnClassRemove);
        
        if(cpAction === "image")
            $("#gridItem"+cpCategoryID+" span").css("display", cpValue);            
        else if(cpAction === "title")
            $("#gridItem"+cpCategoryID+" .category").css("display", cpValue);            
        else if(cpAction === "text")
            $("#gridItem"+cpCategoryID+" .text").css("display", cpValue);            
        else if(cpAction === "icon")
            $("#gridItem"+cpCategoryID+" .icon-container").css("display", cpValue);            
    });
    
    
    $('.cp').ColorPicker({            
            onShow: function (colpkr) {
		cpElementID = this.id;
                console.log(cpElementID);
                cpSplitTMP = cpElementID.split("_");
                cpAction = cpSplitTMP[2];
                cpCategoryID = cpSplitTMP[3];
            },
            onChange: function (hsb, hex, rgb)
            {
                console.log(cpAction + " on #gridItem"+cpCategoryID+ " --> " + hex);
                // Update inputbox
                $("#"+cpElementID).val("#"+hex);
                // Update sample box
                if(cpAction === "bordercolor")
                {
                    $("#gridItem"+cpCategoryID).css("border-color", "#"+hex);                  
                }
                else if(cpAction === "backgroundcolor")
                {
                    $("#gridItem"+cpCategoryID).css("background-color", "#"+hex);                  
                }
                else if(cpAction === "titlecolor")
                {
                    $("#gridItem"+cpCategoryID + " .category").css("color", "#"+hex);                  
                }
                else if(cpAction === "textcolor")
                {
                    $("#gridItem"+cpCategoryID + " .text").css("color", "#"+hex);                  
                }
                else if(cpAction === "acolor")
                {
                    $("#gridItem"+cpCategoryID + " a").css("color", "#"+hex);                  
                }
            }
    });    
    
    // Slider Handler
    var slider = $( ".slider" ).slider({
      range: "max",
      min: 0,
      max: 50,
      value: 0,
      slide: function( event, ui ) {
          var elementID = this.id;          
          elementID = elementID.split("_");          
          //console.log(elementID);
          var typeOfSlider= elementID[2];
          //console.log("Type => " + typeOfSlider);
          var categoryID= elementID[3];
          elementID = elementID[1];
          $("#"+elementID).val(ui.value);
          if(typeOfSlider === "bordersize")
          {
              $("#gridItem"+categoryID).css("borderWidth", ui.value + "px");                  
          }
          else if(typeOfSlider === "bordersradius")
          {
              $("#gridItem"+categoryID).css("border-radius", ui.value + "px");
              $("#gridItem"+categoryID+" span").css("border-radius", ui.value + "px " + ui.value + "px 0 0");
          }
          else if(typeOfSlider === "fontsize")
          {
              $("#gridItem"+categoryID+" .text").css("font-size", ui.value + "px");            
              $("#gridItem"+categoryID+" .text").css("line-height", parseInt(ui.value)+2 + "px");
          } 
          else if(typeOfSlider === "textmarginstb")
          {
              $("#gridItem"+categoryID+" .text").css("margin-top", ui.value + "px");
          } 
          else if(typeOfSlider === "textmarginslr")
          {
              $("#gridItem"+categoryID+" .text").css("margin-left", ui.value + "px");
              $("#gridItem"+categoryID+" .text").css("margin-right", ui.value + "px");
          } 
      }
    });   
    
    // Title Color
    $( ".cTitleColor" ).each(function( index ) {        
        var categoryID = this.id.split("_")[3];
        $("#gridItem"+categoryID + " .category").css("color", this.value);         
    });
    // Text Color
    $( ".cTextColor" ).each(function( index ) {        
        var categoryID = this.id.split("_")[3];
        $("#gridItem"+categoryID + " .text").css("color", this.value);         
    });
    // A Color
    $( ".cAColor" ).each(function( index ) {        
        var categoryID = this.id.split("_")[3];
        $("#gridItem"+categoryID + " a").css("color", this.value);         
    });
    // Background Color
    $( ".cBackgroundColor" ).each(function( index ) {        
        var categoryID = this.id.split("_")[3];
        //console.log("#gridItem"+categoryID+ " background-color ---> #" + this.value);
        $("#gridItem"+categoryID).css("backgroundColor", this.value);         
    });    
    // Border SIZE
    $( ".cBorderSize" ).each(function( index ) {
        
        var categoryID = this.id.match(/\d+/);
        var elementID = "cbs" + categoryID;
        var value = $("#"+elementID).val();
        $("#gridItem"+categoryID).css("borderWidth", value + "px");                
    });
    // Border COLOR
    $( ".cBorderColor" ).each(function( index ) {        
        var categoryID = this.id.match(/\d+/);
        $("#gridItem"+categoryID).css("border-color", this.value);                
    });
    // Border RADIUS
    $( ".cBorderRadius" ).each(function( index ) {
        var categoryID = this.id.match(/\d+/);
        var elementID = "cbr" + categoryID;
        var value = $("#"+elementID).val();
        $("#gridItem"+categoryID).css("border-radius", value + "px");
        $("#gridItem"+categoryID+" span").css("border-radius", value + "px " + value + "px 0 0");        
    });    
    // Font-size
    $( ".cFontSize" ).each(function( index ) {        
        var categoryID = this.id.match(/\d+/);
        $("#gridItem"+categoryID+ " .text").css("font-size", this.value+"px");
        $("#gridItem"+categoryID+ " .text").css("line-height", parseInt(this.value)+2+"px");
    });     
    // Top Margin
    $( ".cTextMarginsTb" ).each(function( index ) {        
        var categoryID = this.id.match(/\d+/);
        $("#gridItem"+categoryID+ " .text").css("margin-top", this.value+"px");
    });    
    // Left/Right Margin
    $( ".cTextMarginsLr" ).each(function( index ) {        
        var categoryID = this.id.match(/\d+/);
        $("#gridItem"+categoryID+ " .text").css("margin-left", this.value+"px");
        $("#gridItem"+categoryID+ " .text").css("margin-right", this.value+"px");
    });    
    // Slider POSITION
    $( ".slider" ).each(function( index ) {
        var elementID = this.id.split("_")[1];
        var value = $("#"+elementID).val();
        $(this).slider("value", value);
    });
    
    
    
    
    // Keyboard or manual settings on slider
    $(".cTitleColor").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        // is an hex color?
        var isOk  = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.value);
        if( isOk ) 
        {
            $("#gridItem"+categoryID + " .category").css("color", this.value);                         
        }        
    });
     
    $(".cTextColor").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        // is an hex color?
        var isOk  = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.value);
        if( isOk ) 
        {
            $("#gridItem"+categoryID + " .text").css("color", this.value);                         
        }        
    });
    
    $(".cAColor").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        // is an hex color?
        var isOk  = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.value);
        if( isOk ) 
        {
            $("#gridItem"+categoryID + " a").css("color", this.value);                         
        }        
    });
    
    $(".cBackgroundColor").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        // is an hex color?
        var isOk  = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.value);
        if( isOk ) 
        {
            $("#gridItem"+categoryID).css("backgroundColor", this.value);                         
        }        
    });
    
    $(".cBorderColor").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        // is an hex color?
        var isOk  = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.value);
        if( isOk ) 
        {
            $("#gridItem"+categoryID).css("border-color", this.value);                         
        }        
    });
        
    $(".cBorderSize").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        var sliderID = "slider_cbs"+categoryID+"_bordersize_"+categoryID;
        // integer check
        if( Math.floor(this.value) == this.value && $.isNumeric(this.value)) 
        {
            // values range check
            if(this.value >= 0 && this.value <= 50)
            {
                $("#"+sliderID).slider("value", this.value);
                $("#gridItem"+categoryID).css("borderWidth", this.value + "px");
            }
        }        
    });
    $(".cBorderRadius").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        var sliderID = "slider_cbr"+categoryID+"_borderradius_"+categoryID;
        // integer check
        if( Math.floor(this.value) == this.value && $.isNumeric(this.value)) 
        {
            // values range check
            if(this.value >= 0 && this.value <= 50)
            {
                $("#"+sliderID).slider("value", this.value);
                $("#gridItem"+categoryID).css("border-radius", this.value + "px");
                $("#gridItem"+categoryID+" span").css("border-radius", this.value + "px " + this.value + "px 0 0");
            }                    
        }        
    });
    $(".cFontSize").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        var sliderID = "slider_cfs"+categoryID+"_fontsize_"+categoryID;
        // integer check
        if( Math.floor(this.value) == this.value && $.isNumeric(this.value)) 
        {
            // values range check
            if(this.value >= 0 && this.value <= 50)
            {
                $("#"+sliderID).slider("value", this.value);
                $("#gridItem"+categoryID+" .text").css("font-size", this.value + "px");            
                $("#gridItem"+categoryID+" .text").css("line-height", parseInt(this.value)+2 + "px");
            }                    
        }        
    });
    $(".cTextMarginsTb").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        var sliderID = "slider_cbr"+categoryID+"_borderradius_"+categoryID;
        // integer check
        if( Math.floor(this.value) == this.value && $.isNumeric(this.value)) 
        {
            // values range check
            if(this.value >= 0 && this.value <= 50)
            {
                $("#"+sliderID).slider("value", this.value);
                $("#gridItem"+categoryID+" .text").css("margin-top", this.value + "px");
            }                    
        }        
    });
    $(".cTextMarginsLr").on('keyup change', function() {
        var categoryID = this.id.match(/\d+/);
        var sliderID = "slider_cbr"+categoryID+"_borderradius_"+categoryID;
        // integer check
        if( Math.floor(this.value) == this.value && $.isNumeric(this.value)) 
        {
            // values range check
            if(this.value >= 0 && this.value <= 50)
            {
                $("#"+sliderID).slider("value", this.value);
                $("#gridItem"+categoryID+" .text").css("margin-left", this.value + "px");
                $("#gridItem"+categoryID+" .text").css("margin-right", this.value + "px");
            }                    
        }        
    });   
});
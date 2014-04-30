var counters_Values = new Array();
var counters_Types = new Array();
var reportCounters = new Array();

jQuery( document ).ready(function( $ ) {  
   
    $(".popover-img").live("hover", function() {
       var content = $(this).attr("data-content");
       content = "<img src='"+content+"' />";
       $("#"+this.id).popover({title: 'Related image', content: content, html: true});
       $("#"+this.id).popover('show');
    });
    
    $(".popover-img").live("mouseout", function() {
       $("#"+this.id).popover('destroy');
    });
   
    function getFeedItems(feedName)
    {
         $.ajax({ url: '/administrator/index.php?option=com_activategrid&view=import&format=raw&tmpl=component',
             data: {
                 action: 'get_'+ feedName},
                 type:   'post',
             success: function(output) {                 
                          $("#accordion_"+feedName).html(output);
                          $("#controls_"+feedName).css("cursor", "pointer");
                          $("#loader_"+feedName).removeClass("icon-refresh");
                          $("#loader_"+feedName).removeClass("icon-spin");
                          $("#loader_"+feedName).addClass("icon-ok");
                          
                          $("#feedItemsImport_old_"+feedName).html(counters_Values[feedName]["old"]);
                          $("#feedItemsImport_success_"+feedName).html(counters_Values[feedName]["success"]);
                          $("#feedItemsImport_warning_"+feedName).html(counters_Values[feedName]["warning"]);
                          $("#feedItemsImport_error_"+feedName).html(counters_Values[feedName]["error"]);
                 
                          // if no posts are found, i print a message
                          if(counters_Values[feedName]["old"] == 0 && counters_Values[feedName]["success"] == 0 && counters_Values[feedName]["warning"] == 0 && counters_Values[feedName]["error"] == 0)
                              {
                                  $("#accordion_"+feedName).html("No items found.");
                              }
                 
                          /*$("#feedItemsImport_"+counters_Types[feedName]+"_"+feedName).html(counters_Values[feedName]);
                          $("#feedItemsImport_"+counters_Types[feedName]+"_"+feedName).html(counters_Values[feedName]);
                          $("#feedItemsImport_"+counters_Types[feedName]+"_"+feedName).html(counters_Values[feedName]);
                          $("#feedItemsImport_"+counters_Types[feedName]+"_"+feedName).html(counters_Values[feedName]);*/
                          /*console.log(counters_Types);
                            counters_Types.each(function(index, value) 
                          {
                              console.log(index);
                              console.log("Success! #feedItemsImport_"+value+"_"+feedName + " --> "+counters_Values[feedName]);
                              $("#feedItemsImport_"+value+"_"+feedName).html(counters_Values[feedName]);
                          });*/
                                 

                      }
        });   
        
       // console.log("Ajax Request to -> /administrator/index.php?option=com_activategrid&view=import&format=raw&tmpl=component");
       
       
    }
    
    getFeedItems("twitter");
    getFeedItems("instagram");      
    getFeedItems("facebook");      
    getFeedItems("storify");      
});    


function setCounter(name, type, value)
{
    if(counters_Values[name] == null)
        {
            counters_Values[name] = new Array();
        }
    counters_Values[name][type] = value;
    //counters_Types[name] = type;   
    
    //console.log(counters_Types);
    //console.log("feedItemsImport_"+type+"_"+name+ " ----> " + value);
//    var obj = document.getElementById("feedItemsImport_"+type+"_"+name);
//    console.log("Onject -> " + obj);

    //reportCounters[name] = new Array();
    //reportCounters[name][type] = value;
}

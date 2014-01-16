function OpenInNewTab(url)
{
  var win=window.open(url, '_blank');
  win.focus();
}

function PlayVideo(id, url, type)
{
    if(supports_video())
    {
        if(type === "unsupported")
        {
            console.log("video no");
            OpenInNewTab(url);
        } else {
            // looking for the span thumb ID for hide that
            // id is: categoryName_[video|thumb]_jArticleID
            var spanThumbID = id.split('_');
            var categoryName = spanThumbID[0];
            var articleID = spanThumbID[2];
            spanThumbID = categoryName+"_thumb_"+articleID;
            var playBtnID = categoryName+"_playBtn_"+articleID;
            document.getElementById(spanThumbID).style.display = 'none';
            document.getElementById(playBtnID).style.display = 'none';        
            if(type==="mp4") document.getElementById(id).play();
            else if(type === "youtube")
            {
                var youtubeURL = document.getElementById(id).dataset.source;
                document.getElementById(id).src = youtubeURL;
            }
            document.getElementById(id).style.display = 'block';    
        }
    }
    else
        OpenInNewTab(url);
}

function Open(url)
{
    window.location = url; 
}

function supports_video() {
    return !!document.createElement('video').canPlayType;
}

$(document).ready(function() {
    
    $("video").bind("ended", function() {
        // the video is finished, I enable again the playBtn and the thumb
        var spanThumbID = this.id.split('_');
        var categoryName = spanThumbID[0];
        var articleID = spanThumbID[2];
        spanThumbID = categoryName+"_thumb_"+articleID;
        var playBtnID = categoryName+"_playBtn_"+articleID;
        $(this).hide();
        $("#"+spanThumbID).show();
        $("#"+playBtnID).show();
    }); 

    $("video").bind("pause", function() {
        // the video is finished, I enable again the playBtn and the thumb
        var spanThumbID = this.id.split('_');
        var categoryName = spanThumbID[0];
        var articleID = spanThumbID[2];
        spanThumbID = categoryName+"_thumb_"+articleID;
        var playBtnID = categoryName+"_playBtn_"+articleID;
        $("#"+playBtnID).show();
    }); 
});
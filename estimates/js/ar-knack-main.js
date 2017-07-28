function ttp_knack_page_render(event, page) {
    //alert('listener for page: ' + page.key);
    //$('#view_31 .view-header h2').html("Super Estimating");

    var inner = $('.kn-crumbtrail a').toArray();
    var estId = "";
    
    if (inner.length > 1) {
        estId = inner[1].hash;
        estId = estId.substr(estId.length-25,24);
        $('.kn-crumbtrail').replaceWith('<div class="ttp-button"><a href="'  + inner[1].href + '">' + inner[1].innerHTML + '</a></div>');

    } else {
        $('.kn-crumbtrail').replaceWith("");
    }
    
    //$('#information').replaceWith(estId);
    
    
    console.log(page);
    
}  


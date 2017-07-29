function ttp_knack_page_render(event, page) {

    //Add the estURLs to the page object
    page.estURLs = {
      "baseURL":"#estimates/estimate-details/",
      "deficiencies":{
          0:"view-general-conditions",
          1:"view-surface-conditions",
          2:"view-roofing-features",
          3:"view-exterior-surfaces",
          4:"view-interior-surfaces"
      }
    };
    
    if (page.scene_id) {
        //Change the breadcrumb
        var breadCrumb = $('.kn-crumbtrail a').toArray();
        $('.kn-crumbtrail').replaceWith('<div class="ttp-button"><a href="'  + breadCrumb[1].href + '">' + breadCrumb[1].innerHTML + '</a></div>');
        
        //Change the deficiency links
        changeLinks(event, page);
    }
    return true;
}  


function changeLinks(event, page) {
    
    var defURL;
    switch(page.key)
    {
        case "scene_23":
            defURL = $('#kn-' + page.key + ' #view_31 div.kn-details-group:nth-child(4) a').toArray();
            exchangeLinks(event,page,defURL, 99);
            break;
        case "scene_43":
            defURL = $('#kn-' + page.key + ' #view_59 div.kn-details-group:nth-child(3) a').toArray();
            exchangeLinks(event,page,defURL, 0);
            break;
        case "scene_44":
            defURL = $('#kn-' + page.key + ' #view_60 div.kn-details-group:nth-child(3) a').toArray();
            exchangeLinks(event,page,defURL, 1);
            break;
        case "scene_45":
            defURL = $('#kn-' + page.key + ' #view_61 div.kn-details-group:nth-child(3) a').toArray();
            exchangeLinks(event,page,defURL, 2);
            break;
        case "scene_46": 
            defURL = $('#kn-' + page.key + ' #view_62 div.kn-details-group:nth-child(3) a').toArray();
            exchangeLinks(event,page,defURL, 3);
            break;
        case "scene_47":
            defURL = $('#kn-' + page.key + ' #view_63 div.kn-details-group:nth-child(3) a').toArray();
            exchangeLinks(event,page,defURL, 4);
            break;
        default:
            defURL = 'none';
    }
    return true;
}
    

function exchangeLinks(event, page, defURL, whichOne) {
    
    var place = 0;
    var look = 0;

    while(place < defURL.length)
    {
        if(look !== whichOne) {
            defURL[place].hash = page.estURLs.baseURL + page.scene_id + '/' + page.estURLs.deficiencies[look] + '/' + page.scene_id;
            place++;
        } 
        look++;
    }
    
    return true;
}

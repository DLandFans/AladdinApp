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

    $('#kn-mobile-menu').click(function() {
        $('#kn-mobile-menu').removeClass("is-visible");
        $("#menu-show-dropdown").attr("checked", !1);
        $("html").css("overflow-y", "auto");
        $("html").off("touchmove");
        $("#kn-mobile-menu").off("touchmove");
        $('#mobile-modal-bg').remove();    
    });
    
    var linkUrl = location.origin + location.pathname + page.estURLs.baseURL + page.scene_id;
    var linkName = 'Back to Estimate Details';
    var returnButton = [ 43,44,45,46,47,48,49,50,75,84,145,192,112 ];
    
    //Add Return Button
    for(i=0;i<returnButton.length;i++)
    {
        $('#kn-scene_' + returnButton[i]).prepend('<div class="kn-menu kn-view view_713" id="view_713"><div class="control"><a class="km-link kn-link-1 kn-link-page kn-button" href="' + linkUrl + '"><span class="icon is-small"><i class="fa fa-arrow-left"></i></span><span>' + linkName + '</span></a></div></div>');
    }
    
    //Turn links into buttons
    $('.kn-back-link').addClass('kn-button control');
    $('div.kn-details-group .kn-details-group-column.column .kn-link-page').addClass('kn-button control');
    $('.kn-link-delete').addClass('kn-button control');
    $('.kn-filters-nav a').removeClass('kn-button');
    
    
    //Change the deficiency view links
    if (page.scene_id) {
        changeLinks(event, page);
    }
    
//    console.log(page);
    return true;
}  


function changeLinks(event, page) {
    
    var defURL;
    switch(page.key)
    {
        case "scene_23":
            ttp_scene_23(event,page);
            break;
        case "scene_43":
            ttp_deficiency(event,page,59,0);
            break;
        case "scene_44":
            ttp_deficiency(event,page,60,1);
            break;
        case "scene_45":
            ttp_deficiency(event,page,61,2);
            break;
        case "scene_46": 
            ttp_deficiency(event,page,62,3);
            break;
        case "scene_47":
            ttp_deficiency(event,page,63,4);
            break;
        default:
            defURL = 'none';
    }
    
//    console.log(test);
    
    return true;
}
    

//Estimate Details Page
function ttp_scene_23(event,page) {
    var defURL = $('#kn-' + page.key + ' #view_31 div.kn-details-group:nth-child(4) a').toArray();
    exchangeLinks(event,page,defURL, 99);
    expandDetailGroup(31);
}

function ttp_deficiency(event,page,view,listNum)
{
    var defURL = $('#kn-' + page.key + ' #view_' + view + ' div.kn-details-group:nth-child(4) a').toArray();
    exchangeLinks(event,page,defURL, listNum);
    expandDetailGroup(view);
  
    var grabColumns = $('#kn-' + page.key + ' #view_' + view + ' div.kn-details-group.column-2:nth-child(1) div.column').toArray();
    
    $(grabColumns).each(function(index){
       $(this).css('width','50%'); 
       $(this).css('float','left'); 
    });
    
}

function ttp_view(event, view, data) {
//    var test = $('#view_31 div.kn-details-group:nth-child(1) th.kn-label');
//    console.log(test);
//    console.log(data);
//    console.log(view);
}

function expandDetailGroup(id){
    $('#view_' + id + ' div.kn-details-group .kn-details-group-column.column').css('width','100%');
    $('#view_' + id + ' div.kn-details-group th.kn-label').css('width','25%');
    $('#view_' + id + ' div.kn-details-group th.kn-value').css('width','75%');
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
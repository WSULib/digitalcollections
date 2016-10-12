// Controller for Single Object Page


// Globals
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var APIdata = new Object();
var loaded = false;

// Primary API call
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function APIcall(singleObjectParams) {
    APIdata['singleObjectParams'] = singleObjectParams;
    PID = singleObjectParams['id']

    // config
    //number of results for related objects
    related_windowSize = 1

    // if user is logged in, include user hash with singleObjectPackage request
    if (typeof userData != 'undefined' && userData.loggedIn_WSUDOR == true) {
        // console.log(userData);
        var API_url = "/" + config.API_url + "?functions[]=singleObjectPackage&functions[]=objBitStreamTokens&PID=" + PID +"&username=" + userData.username_WSUDOR + "&clientHash=" + userData.clientHash
    }
    else {
        var API_url = "/" + config.API_url + "?functions[]=singleObjectPackage&PID=" + PID
    }

    // Calls API functions    
    $.ajax({
        url: API_url,
        dataType: 'json',
        success: callSuccess,
        error: callError
    });

    function callSuccess(response) {
        APIdata = response;

        //check object status    
        if (APIdata.singleObjectPackage.isActive.object_status == "Inactive" || APIdata.singleObjectPackage.isActive.object_status == "Absent") {
            loadError();
        } 
        else {            
            // make translations as necessary
            makeTranslations();
            // render results on page
            renderPage(PID);
        }

    }

    function callError(response) {
        // console.log("API Call unsuccessful.  Back to the drawing board.");
        loadError();
    }
}

function loadError() {
    load404(window.location.href);
}

function makeTranslations() {
    APIdata.translated = new Object();

    // pretty preferred content model    
    if (APIdata.singleObjectPackage.objectSolrDoc.rels_preferredContentModel != null) {
        APIdata.translated.preferredContentModelPretty = rosetta(APIdata.singleObjectPackage.objectSolrDoc.rels_preferredContentModel[0]);
    } else {
        APIdata.translated.preferredContentModelPretty = "Unknown";
    }
    // all content models
    if (APIdata.singleObjectPackage.objectSolrDoc.rels_hasContentModel != null) {
        APIdata.translated.contentModels = [];
        for (var i = 0; i < APIdata.singleObjectPackage.objectSolrDoc.rels_hasContentModel.length; i++) {
            APIdata.translated.contentModels.push({
                'key': APIdata.singleObjectPackage.objectSolrDoc.rels_hasContentModel[i],
                'value': rosetta(APIdata.singleObjectPackage.objectSolrDoc.rels_hasContentModel[i])
            });
        }
    } else {
        APIdata.translated.contentModels = "Unknown";
    }
}


// Render Page with API call data
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function renderPage(PID) {
    //Render Internal Templates
    $(document).ready(function() {
        $.Mustache.addFromDom() //read all template from DOM    

        // head
        $('head').mustache('head_t', APIdata);

        // info-panel    
        $.get('templates/info-panel.htm', function(template) {
            var html = Mustache.to_html(template, APIdata);
            $(".info-panel").html(html);
        });

        // display-more-info
        $.get('templates/display-more-info.htm', function(template) {
            var html = Mustache.to_html(template, APIdata);
            $(".display-more-info table").html(html);
            cleanEmptyMetaRows();
            // fire contentType Specific cleanup / changes
            ctypeSpecific();
        });

        // Content Model Specific
        function ctypeSpecific() {
            // WSUebooks
            if (APIdata.translated.preferredContentModelPretty == "WSUebook") {
                PID_suffix = PID.split(":")[1]

                // generate fullText URLs
                APIdata.fullText = [{
                    "key": "HTML",
                    "value": "http://" + config.APP_HOST + "/WSUAPI/bitStream/" + PID + "/HTML_FULL"
                }, {
                    "key": "PDF",
                    "value": "http://" + config.APP_HOST + "/WSUAPI/bitStream/" + PID + "/PDF_FULL"
                }, ];

                // check for OCLC num, generate citation link (ADDRESS IN V2)
                if ("mods_identifier_oclc_ms" in APIdata.singleObjectPackage.objectSolrDoc) {
                    APIdata.citationLink = "http://library.wayne.edu/inc/OCLC_citation.php?oclcnum=" + APIdata.singleObjectPackage.objectSolrDoc.mods_identifier_oclc_ms[0];
                }

                // check for Bib num, generate persistent link (ADDRESS IN V2)
                if ("mods_bibNo_ms" in APIdata.singleObjectPackage.objectSolrDoc) {
                    APIdata.persistLink = "http://elibrary.wayne.edu/record=" + APIdata.singleObjectPackage.objectSolrDoc.mods_bibNo_ms[0].slice(0, -1);
                }
            }

            // Collection objects
            if (APIdata.translated.preferredContentModelPretty == "Collection") {
                // remove iiif manifest link
                $("#iiif_manifest").remove();
            }

            // generate downloads
            generateDownloads();
        }

        // finish rendering page and templates (case switching based on content type)
        finishRendering();

    });

}


// Updates and Secondary API calls are performed here
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function finishRendering() {

    // unknown type handler
    function unknownType() {
        $.get('templates/singleObject/unknownType.htm', function(template) {
            var html = Mustache.to_html(template, APIdata);
            $(".primary-object-container").html(html);
        });
    }

    // update APIdata with config params
    APIdata.config = config;

    // Content Type Handling  
    ctype = APIdata.translated.preferredContentModelPretty;
    switch (ctype) {
        // All Images
        case "Image":
            // load main image template
            $.get('templates/singleObject/image.htm', function(template) {
                var html = Mustache.to_html(template, APIdata);
                $(".primary-object-container").html(html);
            });       
            break;

        //eBooks
        case "WSUebook":
            $.get('templates/singleObject/WSUebook.htm', function(template) {
                var html = Mustache.to_html(template, APIdata);
                $(".primary-object-container").html(html);
            });
            break;

        //Collections
        case "Collection":
            $.get('templates/singleObject/collection.htm', function(template) {
                var html = Mustache.to_html(template, APIdata);
                $(".primary-object-container").html(html);
            });
            break;

        //Audio
        case "Audio":
            $.get('templates/singleObject/audio.htm', function(template) {
                var html = Mustache.to_html(template, APIdata);
                $(".primary-object-container").html(html);
            });
            break;

        //Video
        case "Video":
            // unknownType();        
            $.get('templates/singleObject/video.htm', function(template) {
                var html = Mustache.to_html(template, APIdata);
                $(".primary-object-container").html(html);
            });
            break;

        //Container
        case "Container":
            $.get('templates/singleObject/hierarchical_container.htm', function(template) {
                var html = Mustache.to_html(template, APIdata);
                $(".primary-object-container").html(html);
            });
            break;

        //Document
        case "Document":
            $.get('templates/singleObject/hierarchical_document.htm', function(template) {
                var html = Mustache.to_html(template, APIdata);
                $(".primary-object-container").html(html);
            });
            break;

        // If none known, default to unkwown type    
        default:
            unknownType();
    }

    // genereate hierarchical tree
    genHierarchicalTree();

    // learning objects
    genLearningObjects();

}


// Add Item to Favorites
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function addFav() {
    if (typeof userData.username_WSUDOR != "undefined") {
        // stringify user / item / search object, send to addFavorite API function  
        var addDoc = new Object();
        addDoc.id = userData.username_WSUDOR + "_" + APIdata.APIParams.PID
        addDoc.fav_user = userData.username_WSUDOR;
        addDoc.fav_item = APIdata.APIParams.PID;
        var jsonAddString = "[" + JSON.stringify(addDoc) + "]";
        // console.log(jsonAddString);

        var APIaddURL = "/" + config.API_url + "?functions[]=addFavorite&raw=" + jsonAddString;
        // console.log(APIaddURL);

        function callSuccess(response) {
            // console.log(response);
            if (response.addFavorite.responseHeader.status == 0) {
                $('li.add-to-favorites').html('<img src="img/star.png" alt=""> Added to Favorites');
                bootbox.alert("Added to favorites");
                window.setTimeout(function() {
                    bootbox.hideAll();
                }, 2000);
                // .addClass('favorited');
            } else {
                bootbox.alert("Error");
            }
        }

        function callError(response) {
            // console.log(response);
            bootbox.alert("Error.");
        }

        $.ajax({
            url: APIaddURL,
            dataType: 'json',
            success: callSuccess,
            error: callError
        });

    } else {
        bootbox.alert("User not found.  Please <a style='color:green;' href='https://" + config.APP_HOST + "/digitalcollections/login.php'><strong>login or sign up</strong></a> to save favorites.");
    }
}



// show #container when things load and templates rendered
$(document).ready(function() {
    $("#container").show();
});

// Add to Playlist item to current player
function switchItem(playerName, ds_id) {
    console.log(ds_id);
    for (num in APIdata.singleObjectPackage.playlist) {
        if (APIdata.singleObjectPackage.playlist[num].ds_id == ds_id) {
            $("div.primary-object-container h3").html("<h3>" + APIdata.singleObjectPackage.playlist[num].label + " - " + APIdata.singleObjectPackage.playlist[num].mimetype + "</h3>");
            playerName.src("//" + APIdata.singleObjectPackage.playlist[num].mp3);
            playerName.poster("//" + APIdata.singleObjectPackage.playlist[num].preview);
            playerName.load();
            playerName.play();
        }
    }
}


// Related Objects
function genHierarchicalTree() {

    if (APIdata.singleObjectPackage.hierarchicalTree.parent.results.length > 0) {
        // set counts for use by templates
        APIdata.singleObjectPackage.hierarchicalTree.parent_siblings['count'] = APIdata.singleObjectPackage.hierarchicalTree.parent_siblings.results.length
        APIdata.singleObjectPackage.hierarchicalTree.siblings['count'] = APIdata.singleObjectPackage.hierarchicalTree.siblings.results.length
        APIdata.singleObjectPackage.hierarchicalTree.children['count'] = APIdata.singleObjectPackage.hierarchicalTree.children.results.length

        // functional 
        $.get('templates/hierarchicaltree.htm', function(template) {
            var html = Mustache.to_html(template, APIdata);
            $(".related-objects").append(html);
            // remove empties
            if (APIdata.singleObjectPackage.hierarchicalTree.parent.results.length == 0) {
                $(".parent").css('display', 'none');
            }
            if (APIdata.singleObjectPackage.hierarchicalTree.siblings['count'] == 0) {
                $(".siblings").css('display', 'none');
            }
            if (APIdata.singleObjectPackage.hierarchicalTree.children['count'] == 0) {
                $(".children").css('display', 'none');
            }
        }).done(function(){

            // IS learning object
            /*
                Consider moving this to a single, sparql query, which would include titles too
                These objects won't come up often, not that expensive to query a single API endpoint
            */
            if (APIdata.singleObjectPackage.objectSolrDoc.hasOwnProperty('rels_learningObjectFor')){
                if (APIdata.singleObjectPackage.objectSolrDoc.rels_learningObjectFor.length > 0) {
                    var lo_targets_package = {
                        "APP_HOST":config.APP_HOST
                    };
                    lo_targets_package.lo_targets = [];
                    for (var i = 0; i < APIdata.singleObjectPackage.objectSolrDoc.rels_learningObjectFor.length; i++) {
                        lo_target = APIdata.singleObjectPackage.objectSolrDoc.rels_learningObjectFor[i].split("/")[1]            
                        lo_targets_package.lo_targets.push(lo_target);
                    }

                    // functional 
                    $.get('templates/learningObjectTargets.htm', function(template) {
                        var html = Mustache.to_html(template, lo_targets_package);
                        $("#hier_tree").append(html);            
                    });
                }    
            }
        });
    }

}


function genLearningObjects() {

    // HAS associated learning objects
    if (APIdata.singleObjectPackage.learning_objects.length > 0) {
        
        // cleanup
        for (var i = 0; i < APIdata.singleObjectPackage.learning_objects.length; i++) {
            lo = APIdata.singleObjectPackage.learning_objects[i];
            lo.lo_pid = lo.lo_uri.split("/")[1];
        }

        // functional 
        $.get('templates/hasLearningObjects.htm', function(template) {
            var html = Mustache.to_html(template, APIdata);
            $(".related-objects").append(html);            
        });
    }

}


// Report Problem
function reportProb() {
    // send to reportProb API function  
    
    // transform form into JS object; re-map form element names with values; encode into JSON string
    var unindexed_array = $('.flag-form').serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });
    var flag_form_contents = JSON.stringify(indexed_array);

    if(loaded) return;
    PID = APIdata.APIParams.PID[0];
    var APIaddURL = "/" + config.API_url + "?functions[]=reportProb&PID=" + PID + "&notes=" + flag_form_contents;

    function callSuccess(response) {
        $('.flag-form').slideToggle();
         $(".flag").css({
            'background-color': 'rgba(51, 255, 102, 0.2)',
            'background-image': 'url(/digitalcollections/images/checklist-glyph.png)'
            });
        $(".flag").html("Your message has been sent. Thanks!");
    }

    function callError(response) {
        $(".flag").html("Ooops. Looks like we had an internal error. Please try again later. Thanks!");
    }

    $.ajax({
        url: APIaddURL,
        dataType: 'json',
        success: callSuccess,
        error: callError
    });

    loaded = true;
}

// Show report a problem form
function showForm(e) {
    $('.flag-form').slideToggle();
    e.preventDefault();
}


// Send the user-provided form data for associated problem object
function addProbNote() {
    // transform form into JS object; re-map form element names with values; encode into JSON string
    var unindexed_array = $('.flag-form').serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });
    var flag_form_contents = JSON.stringify(indexed_array);


    // Send form note for associated problem object

    PID = APIdata.APIParams.PID[0];
    var APIaddURL = "/" + config.API_url + "?functions[]=addProbNote&PID=" + PID + "&notes=" + flag_form_contents;
    function callSuccess(response) {
        console.log(response);
            $('.flag-form').slideToggle();
            $(".flag").html("Your message has been sent. Thanks!");
    }

    function callError(response) {
        console.log(response);
        $(".flag").html("Ooops. Looks like we had an internal error. Please try again later. Thanks!");
    }

    $.ajax({
        url: APIaddURL,
        dataType: 'json',
        success: callSuccess,
        error: callError
    });
}

    
// function to generate downloads
function generateDownloads() {

    // determine if admin user
    if (typeof userData != 'undefined' && userData.loggedIn_WSUDOR == true && APIdata.objBitStreamTokens.status != false) {
        var is_admin_user = true;
        $("#downloads_target").append('<div class="row" style="background-color:rgba(51, 255, 102, 0.2); padding-bottom:0px;"><div class="col-md-12"><p style="margin-bottom:10px;"><strong>Admin View:</strong> Each button comes with a token in the URL that allows for ONE download.  These can be downloaded here, or you can right-click the button and copy the link to send to others.  To regenerate download links, reload the page.</p></div></div>');
    }
    else {
        var is_admin_user = false;   
    }

    // build download object
    var data = {'APIdata':APIdata};

    // Content Type Handling  
    ctype = APIdata.translated.preferredContentModelPretty;
    switch (ctype) {

        // IMAGE
        case "Image":

            // update data object
            data['images'] = [];

            for (var i = 0; i < APIdata.singleObjectPackage.parts_imageDict.sorted.length; i++) {
                var image = APIdata.singleObjectPackage.parts_imageDict.sorted[i];                
                if (is_admin_user == true) {
                    image['bitStream'] = {
                        'ORIGINAL':APIdata.objBitStreamTokens[image.ds_id],
                        'ACCESS':APIdata.objBitStreamTokens[image.ds_id + "_ACCESS"],
                    }
                }
                data['images'].push(image);
            };

            // fire download template
            $.get('templates/singleObject/imageDownload.htm', function(template) {
                var html = Mustache.to_html(template, data);
                $("#downloads_target").append(html);
            });
            
            // show downloads
            $(".downloads").show();

            break;
        // END IMAGE

        // WSUebook
        case "WSUebook":

            if (is_admin_user == true) {
                data['bitStream'] = {
                    'PDF_FULL':APIdata.objBitStreamTokens.PDF_FULL,
                    'HTML_FULL':APIdata.objBitStreamTokens.HTML_FULL,
                }
            }

            // fire download template
            $.get('templates/singleObject/WSUebookDownload.htm', function(template) {
                var html = Mustache.to_html(template, data);
                $("#downloads_target").append(html);
            });
            
            // show downloads
            $(".downloads").show();

            break;
        // END WSUebook
    }

}



















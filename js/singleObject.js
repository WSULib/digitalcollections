// Controller for Single Object Page

// Globals
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var APIdata = new Object();

// Primary API call
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function APIcall(singleObjectParams){	    
  APIdata['singleObjectParams'] = singleObjectParams;
  PID = singleObjectParams['id']

  // config
  //number of results for related objects
  related_windowSize = 1
	
  // Calls API functions	  
  var API_url = "/"+config.API_url+"?functions[]=getObjectXML&functions[]=hasMemberOf&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&functions[]=objectLoci&PID="+PID+"&windowSize="+related_windowSize
  
  // determine if unique search (particularly from collection view)
  mergedParams = JSON.parse(localStorage.getItem('mergedParams'));  
  console.log(mergedParams);

  // determine if coming from unique search / browse results - if so, trigger "search" for objectLoci()
  // LOGIC HERE NEEDS WORK
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  if (mergedParams['fq[]'].length > 0 || mergedParams['solrSearchContext'] == "search") {  	  	
  	serialized_search_params = encodeURIComponent(localStorage.getItem('mergedParams'));  
  	search_index = singleObjectParams['search_index'];  	
  	API_url = API_url + "&loci_context=search&search_params="+serialized_search_params+"&search_index="+search_index+"&API_url="+config.API_url 
  }
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  var APIcallURL = API_url;  

  $.ajax({          
    url: APIcallURL,      
    dataType: 'json',               
    success: callSuccess,
    error: callError
  });

  function callSuccess(response){
  	// console.log(response);  
    APIdata = response;

    //check object status
    if (APIdata.getObjectXML.object_status == "Inactive" || APIdata.getObjectXML.object_status == "Absent"){
      loadError();
    }
    else{
      // make translations as necessary
      makeTranslations();       
      // render results on page
      renderPage(PID);                    
    }
  	
  }

  function callError(response){
  	// console.log("API Call unsuccessful.  Back to the drawing board.");
    loadError();                
  }
}

function loadError(){
	load404(window.location.href);	
}

function makeTranslations(){
  APIdata.translated = new Object();
  
  // content models   
    // pretty preferred content model    
    if (APIdata.solrGetFedDoc.response.docs[0].rels_preferredContentModel != null){
      APIdata.translated.preferredContentModelPretty = rosetta(APIdata.solrGetFedDoc.response.docs[0].rels_preferredContentModel[0]);
    }
    else {
      APIdata.translated.preferredContentModelPretty = "Unknown";
    }
    // all content models
    if (APIdata.solrGetFedDoc.response.docs[0].rels_hasContentModel != null){
      APIdata.translated.contentModels = [];
      for (var i=0; i < APIdata.solrGetFedDoc.response.docs[0].rels_hasContentModel.length; i++){        
        APIdata.translated.contentModels.push({          
          'key':APIdata.solrGetFedDoc.response.docs[0].rels_hasContentModel[i],
          'value':rosetta(APIdata.solrGetFedDoc.response.docs[0].rels_hasContentModel[i])
        });
      }
    }
    else {
      APIdata.translated.contentModels = "Unknown";
    }    
}



// Render Page with API call data
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function renderPage(PID){  
  //Render Internal Templates
  $(document).ready(function(){
    $.Mustache.addFromDom() //read all template from DOM    
    // Head
    $('head').mustache('head_t', APIdata);
    
    // Metadata
    // info-panel    
    $.get('templates/info-panel.htm',function(template){
      var html = Mustache.to_html(template, APIdata);
      $(".info-panel").html(html);
      cleanEmptyMetaRows();
    });    
    // display-more-info
    $.get('templates/display-more-info.htm',function(template){
      var html = Mustache.to_html(template, APIdata);
      $(".display-more-info table").html(html);
      cleanEmptyMetaRows();
    });       

    // Content Model Specific
    // WSUebooks
    if (APIdata.translated.preferredContentModelPretty == "WSUebook" ){
    	PID_suffix = PID.split(":")[1]    	
		
    	// generate fullText URLs
		APIdata.fullText = [
			{
				"key" : "HTML",
				"value" : "http://digital.library.wayne.edu/fedora/objects/"+PID_suffix+":fullbook/datastreams/HTML_FULL/content"},
			{
				"key" : "PDF",
				"value" : "http://digital.library.wayne.edu/fedora/objects/"+PID_suffix+":fullbook/datastreams/PDF_FULL/content"
			},
		];

		// check for OCLC num, generate citation link
		if ("mods_identifier_oclc_ms" in APIdata.solrGetFedDoc.response.docs[0]) {
			APIdata.citationLink = "http://library.wayne.edu/inc/OCLC_citation.php?oclcnum="+APIdata.solrGetFedDoc.response.docs[0].mods_identifier_oclc_ms[0];
		}

		// check for Bib num, generate persistent link
		if ("mods_bibNo_ms" in APIdata.solrGetFedDoc.response.docs[0]) {
			APIdata.persistLink = "http://elibrary.wayne.edu/record="+APIdata.solrGetFedDoc.response.docs[0].mods_bibNo_ms[0];
		}
    }

    // generate related objects (in DEV)
    // genRelatedItems();

  });
  
  finishRendering();

}


// Updates and Secondary API calls are performed here
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function finishRendering(){
  
  // unknown type handler
  function unknownType(){
    $.get('templates/singleObject/unknownType.htm',function(template){
      var html = Mustache.to_html(template, APIdata);
      $(".primary-object-container").html(html);  
        }); 
  }

  // Content Type Handling  
  ctype = APIdata.translated.preferredContentModelPretty;    
  switch (ctype) {
    //Images
    case "Image":
      $.get('templates/singleObject/image.htm',function(template){
        var html = Mustache.to_html(template, APIdata);
        $(".primary-object-container").html(html);
      }); 
      break;
    // Complex Images
    case "ComplexImage":
      $.get('templates/singleObject/complexImage.htm',function(template){
        var html = Mustache.to_html(template, APIdata);
        $(".primary-object-container").html(html);
      }); 
      break;
    //eBooks
    case "WSUebook":
      $.get('templates/singleObject/WSUebook.htm',function(template){
        var html = Mustache.to_html(template, APIdata);
        $(".primary-object-container").html(html);
      }); 
      break;
    //Collections
    case "Collection":
      $.get('templates/singleObject/collection.htm',function(template){
        var html = Mustache.to_html(template, APIdata);
        $(".primary-object-container").html(html);
      });      
      break;      
    //Audio
    case "Audio":
      $.get('templates/singleObject/audio.htm',function(template){
        var html = Mustache.to_html(template, APIdata);
        $(".primary-object-container").html(html);
      }); 
      break;       
    //Document
    case "Document":
      unknownType();        
      $.get('templates/singleObject/document.htm',function(template){
        var html = Mustache.to_html(template, APIdata);
        $(".primary-object-container").html(html);
      }); 
      break;  
    //Video
    case "Video":
      // unknownType();        
      $.get('templates/singleObject/video.htm',function(template){
        var html = Mustache.to_html(template, APIdata);
        $(".primary-object-container").html(html);
      }); 
      break;
    //Archive
    case "Archive":
      unknownType();                
      break;        
    default:
      unknownType();
  }
}


// Add Item to Favorites
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function addFav(){    
    if (typeof userData.username_WSUDOR != "undefined"){
      // stringify user / item / search object, send to addFavorite API function  
      var addDoc = new Object();
      addDoc.id = userData.username_WSUDOR+"_"+APIdata.APIParams.PID
      addDoc.fav_user = userData.username_WSUDOR;
      addDoc.fav_item = APIdata.APIParams.PID;
      var jsonAddString = "["+JSON.stringify(addDoc)+"]";
      // console.log(jsonAddString);

      var APIaddURL = "/"+config.API_url+"?functions[]=addFavorite&raw="+jsonAddString;
      // console.log(APIaddURL);

      function callSuccess(response){
        // console.log(response);
        if (response.addFavorite.responseHeader.status == 0){
          $('li.add-to-favorites').html('<img src="img/star.png" alt=""> Added to Favorites');
          bootbox.alert("Added to favorites");
          window.setTimeout(function(){
            bootbox.hideAll();
          }, 2000);
          // .addClass('favorited');
        }
        else {
          bootbox.alert("Error");
        }
      }
      function callError(response){
        // console.log(response);
        bootbox.alert("Error.");
      }

      $.ajax({          
        url: APIaddURL,      
        dataType: 'json',
        success: callSuccess,
        error: callError
      });
      
    }
  else {
    bootbox.alert("User not found.  Please <a style='color:green;' href='https://digital.library.wayne.edu/digitalcollections/login.php'><strong>login or sign up</strong></a> to save favorites.");    
  }  
}


// swap LargeImage
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateLargeView(self,PID){        
  $("#LargeView a img").attr('src','/imageServer?obj='+PID+'&ds=PREVIEW&aspectResize=(1024x768)');
  $("#LargeView a").attr('href','/digitalcollections/imageviewer_osd.php?PID='+PID+'&DS=JP2');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// show #container when things load and templates rendered
$(document).ready(function(){
  $("#container").show();    
});


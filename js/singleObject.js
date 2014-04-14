// Controller for Single Object Page

// Globals
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var APIdata = new Object();

// Primary API call
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function APIcall(PID){	
	
  // Calls API functions	
  var APIcallURL = "/WSUAPI?functions[]=getObjectXML&functions[]=hasMemberOf&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&PID="+PID;  

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
      renderPage();                    
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

  // content model fix  
  APIdata.translated = new Object();
  if (APIdata.solrGetFedDoc.response.docs[0].rels_preferredContentModel != null){
    APIdata.translated.contentModelPretty = rosetta(APIdata.solrGetFedDoc.response.docs[0].rels_preferredContentModel[0]);
  }
  else {
    APIdata.translated.contentModelPretty = "Unknown";
  }
}



// Render Page with API call data
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function renderPage(){  

	// update title
	// $("head title").html("WSU digital collections - "+APIdata.solrGetFedDoc.response.docs[0].dc_title_sorting);
  
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
    
    // Children
    if (APIdata.hasMemberOf.results.length > 0){
      $('#children').mustache('children_t', APIdata);   
    }
    else {
      $('#children').append("<p>This object has no sub-components.</p>");   
    }
    // Parents
    if (APIdata.isMemberOfCollection.results.length > 0){      
      $('#parents').mustache('parents_t', APIdata);   
    }
    else {
      $('#parents').append("<p>This object is not part of any collections.</p>");   
    }    
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
  if (APIdata.solrGetFedDoc.response.docs[0].rels_preferredContentModel != null){        
    ctype = APIdata.translated.contentModelPretty;    
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
        // $.get('templates/singleObject/archive.htm',function(template){
        //   var html = Mustache.to_html(template, APIdata);
        //   $(".primary-object-container").html(html);
        // }); 
        break;        
      default:
        unknownType();
    }
  }
  else{
    // fire unknown type handler
    unknownType();
  }

}


// Add Item to Favorites
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function addFav(){    
    if (typeof userData.username_WSUDOR != "undefined"){
      // stringify user / item / search object, send to solrAddDoc API function  
      var addDoc = new Object();
      addDoc.id = userData.username_WSUDOR+"_"+APIdata.APIParams.PID
      addDoc.fav_user = userData.username_WSUDOR;
      addDoc.fav_item = APIdata.APIParams.PID;
      var jsonAddString = "["+JSON.stringify(addDoc)+"]";
      // console.log(jsonAddString);

      var APIaddURL = "/WSUAPI?functions[]=solrAddDoc&raw="+jsonAddString;
      // console.log(APIaddURL);

      function callSuccess(response){
        // console.log(response);
        if (response.solrAddDoc.responseHeader.status == 0){
          $('li.add-to-favorites').html('<img src="img/star.png" alt=""> Added to Favorites');
          bootbox.alert("Added to favorites");
          window.setTimeout(function(){
            bootbox.hideAll();
          }, 3000);
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
    bootbox.alert("User not found.  Please login or sign up to save favorites.");
  }  
}


// swap LargeImage
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateLargeView(self,PID){      
  $("#LargeView a img").attr('src','/imageServer?imgURL=http://127.0.0.1/fedora/objects/'+PID+'/datastreams/PREVIEW/content&aspectResize=(1024x768)');
  // $("#LargeView a").attr('href','/imageServer?imgURL=http://127.0.0.1/fedora/objects/'+PID+'/datastreams/ACCESS/content');
  $("#LargeView a").attr('href','/dev/graham/digitalcollections/imageviewer_osd.php?PID='+PID+'&DS=JP2');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// show #container when things load and templates rendered
$(document).ready(function(){
  $("#container").show();    
});


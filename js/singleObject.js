// Controller for Single Object Page


// Globals
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var APIdata = new Object();
var userData = new Object();


// Primary API call
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function APIcall(PID){	
	
  // Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='getObjectXML hasMemberOf isMemberOfCollection solr4FedObjsID'&PID="+PID;
  // removed "getSiblings" in favor of Solr approach

  $.ajax({          
    url: APIcallURL,      
    dataType: 'json',    
    // jsonpCallback: "jsonpcallback",            
    success: callSuccess,
    error: callError
  });

  function callSuccess(response){
  	console.log(response);  
    APIdata = response;

    //check object status
    if (APIdata.getObjectXML.object_status == "Inactive" || APIdata.getObjectXML.object_status == "Absent"){
      loadError();
    }
    else{       
      // render results on page
      renderPage();                    
    }
  	
  }

  function callError(response){
  	console.log("API Call unsuccessful.  Back to the drawing board.");
    loadError();                
  }
}

function loadError(){
  $("#container").empty();  
  var template = '<h3 style="text-align:center;">Could not find Object in WSUDOR.</h3>';
  var html = Mustache.to_html(template, APIdata);
  $("#container").html(html);
  $("#container").show();  
}


// Render Page with API call data
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function renderPage(){  
  
  //Render Internal Templates
  $(document).ready(function(){
    $.Mustache.addFromDom() //read all template from DOM    
    // Head
    $('head').mustache('head_t', APIdata);
    // Metadata
    $('#metadata').mustache('metadata_t', APIdata);
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
    $.get('templates/unknownType.htm',function(template){
      var html = Mustache.to_html(template, APIdata);
      $("#preview_container").html(html);  
        }); 
  }

  // Content Type Handling
  if (APIdata.solr4FedObjsID.response.docs[0].rels_hasContentModel != undefined){ 

    ctype = APIdata.solr4FedObjsID.response.docs[0].rels_hasContentModel[0];
    switch (ctype) {
      //Images
      case "info:fedora/CM:Image":
        $.get('templates/image.htm',function(template){
          var html = Mustache.to_html(template, APIdata);
          $("#preview_container").html(html);
        }); 
        break;
      //Collections
      case "info:fedora/CM:Collection":
        $.get('templates/collection.htm',function(template){
          var html = Mustache.to_html(template, APIdata);
          $("#preview_container").html(html);
        });      
        break;
      //eBooks
      case "info:fedora/CM:WSUebook":
        $.get('templates/WSUebook.htm',function(template){
          var html = Mustache.to_html(template, APIdata);
          $("#preview_container").html(html);
        }); 
        break;
      //Audio
      case "info:fedora/CM:Audio":
        $.get('templates/audio.htm',function(template){
          var html = Mustache.to_html(template, APIdata);
          $("#preview_container").html(html);
        }); 
        break;       
      //Document
      case "info:fedora/CM:Document":
        unknownType();        
        // $.get('templates/document.htm',function(template){
        //   var html = Mustache.to_html(template, APIdata);
        //   $("#preview_container").html(html);
        // }); 
        break;  
      //Video
      case "info:fedora/CM:Video":
        // unknownType();        
        $.get('templates/video.htm',function(template){
          var html = Mustache.to_html(template, APIdata);
          $("#preview_container").html(html);
        }); 
        break;
      //Archive
      case "info:fedora/CM:Archive":
        unknownType();        
        // $.get('templates/archive.htm',function(template){
        //   var html = Mustache.to_html(template, APIdata);
        //   $("#preview_container").html(html);
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
  
  // HARDCODED FOR TESTING /////////////////////////////////////  
  userData.accessID = "oz9000";
  //////////////////////////////////////////////////////////////

  // stringify user / item / search object, send to solrAddDoc API function
  // can encapsulatein "raw" API parameter as jsonAddString
  var addDoc = new Object();
  addDoc.id = userData.accessID+"_"+APIdata.APIParams.PID
  addDoc.fav_user = userData.accessID;
  addDoc.fav_item = APIdata.APIParams.PID;
  var jsonAddString = "["+JSON.stringify(addDoc)+"]";
  console.log(jsonAddString);

  var APIaddURL = "http://silo.lib.wayne.edu/api/index.php?functions='solrAddDoc'&raw='"+jsonAddString+"'";
  $.ajax({          
    url: APIaddURL,      
    dataType: 'json',
    success: callSuccess,
    error: callError
  });

  function callSuccess(response){
    console.log(response);
    if (response.solrAddDoc.responseHeader.status == 0){
      alert("Favorite Added!");
    }
    else {
      alert("There haz problems.");
    }
  }
  function callError(response){
    console.log(response);
    alert("There haz problems.");
  }


}







////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//unleash the Kraken - show #container when things load and templates rendered
$(document).ready(function(){
  $("#container").show();  
});


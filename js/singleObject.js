// Controller for Single Object Page


// Globals
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var APIdata = new Object();

// Primary API call
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function APIcall(PID){	
	
  // Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='getObjectXML hasMemberOf isMemberOfCollection solr4FedObjsID'&PID="+PID;
  // removed "getSiblings" in favor of Solr approach

    $.ajax({          
      url: APIcallURL,      
      dataType: 'jsonp',    
      jsonpCallback: "jsonpcallback",            
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
    // Siblings
    $('#siblings').mustache('siblings_t', APIdata);        
  });

  
  finishRendering();

}


// Updates and Secondary API calls are performed here
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function finishRendering(){
  
  function unknownType(){
    $.get('templates/unknownType.htm',function(template){
      var html = Mustache.to_html(template, APIdata);
      $("#preview_container").html(html);  
        }); 
  }

  // Content Type Handling  
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // These should probably move to external template files eventually, so they can be reused in other views
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    unknownType();
  }

  // solrSiblings
  // isMemberOfCollection
  if (APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOfCollection != undefined){
    APIdata.solrSiblings = new Object();
    var collectionParents = APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOfCollection;  
    for (var i = collectionParents.length - 1; i >= 0; i--) {
      var parentComps = collectionParents[i].split(":");
      var safeName = parentComps[(parentComps.length - 1)]    
      getSolrSiblings(safeName, collectionParents[i],0,5);    
    };
  }
  // isMemberOf
  if (APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOf != undefined){
    APIdata.solrSiblings = new Object();
    var memberParents = APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOf;  
    for (var i = memberParents.length - 1; i >= 0; i--) {
      var parentComps = memberParents[i].split(":");
      var safeName = parentComps[(parentComps.length - 1)]    
      getSolrSiblings(safeName, memberParents[i],0,5);    
    };
  }
  else{
    $("#siblings").append("<p>This object has no siblings.");
  }

}



// CONTEXTUAL FUNCTIONS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get members of a collection, with pagination
function getSolrSiblings(safeName,PID,start,rows){  

  var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='getSolrSiblings'&PID='"+PID+"'&start="+start+"&rows="+rows;
  $.ajax({          
      url: APIcallURL,      
      dataType: 'jsonp',    
      jsonpCallback: "jsonpcallback",              
      success: getSolrSiblingsSuccess,
      error: getSolrSiblingsError
    });
  //append results to APIdata as "solrSiblings"
  function getSolrSiblingsSuccess(response){    
    APIdata.solrSiblings[safeName] = response;
    APIdata.solrSiblings[safeName].start = start;
    APIdata.solrSiblings[safeName].nextStart = start+5;
    APIdata.solrSiblings[safeName].prevStart = start-5;
    APIdata.solrSiblings[safeName].rows = rows;    
    APIdata.solrSiblings[safeName].PID = PID;

    //render collection siblings to page, appending to #siblings via {{collectionSiblings.htm, AFTER added to global object
    //grab and render template
    $.get('templates/collectionSiblings.htm', function(template) {      
      var html = Mustache.to_html(template, APIdata.solrSiblings[safeName]); //render with solrSiblings info
      //append or replace HTML   
      if ( $('[id="'+PID+'"]').length ) {
        $('[id="'+PID+'"]').replaceWith(html);    
      }
      else{
        $("#siblings").append(html);
      }       
    });

    
    
  }

  function getSolrSiblingsError(response){
    console.log('Could not complete siblings API request.');
  }
}








////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//unleash the Kraken - show #container when things load and templates rendered
$(document).ready(function(){
  $("#container").show();  
});


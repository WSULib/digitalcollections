//generic functions for singleObject page

var APIdata = new Object();
APIdata.fineTuning = {};

function APIcall(PID){	
	
  // Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='getObjectXML hasMemberOf isMemberOfCollection solr4FedObjsID'&PID="+PID;
  // removed "getSiblings" in favor of Solr approach

    $.ajax({          
      url: APIcallURL,      
      dataType: 'json',            
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
        renderTemplates();
        $("#container").show();              
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


// Render Templates with API call data
function renderTemplates(){  
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
function finishRendering(){
  
  function unknownType(){
    var template = '<img src="http://silo.lib.wayne.edu/fedora/objects/wayne:WSUDORThumbnails/datastreams/Unknown/content"/>';
    var html = Mustache.to_html(template, APIdata);
    $("#preview_container").html(html);
  }


  // Content Type Handling
  if (APIdata.solr4FedObjsID.response.docs[0].rels_hasContentModel != undefined){ 

    ctype = APIdata.solr4FedObjsID.response.docs[0].rels_hasContentModel[0];
    switch (ctype) {
      //Images
      case "info:fedora/Image":
        var template = '<a href="http://silo.lib.wayne.edu/fedora/objects/{{APIParams.PID}}/datastreams/ACCESS/content"><img src="http://silo.lib.wayne.edu/fedora/objects/{{APIParams.PID}}/datastreams/ACCESS/content"/></a>';
        var html = Mustache.to_html(template, APIdata);
        $("#preview_container").html(html);
        break;
      //Collections
      case "info:fedora/Collection":
        var template = '<a href="http://silo.lib.wayne.edu/digitalcollections/collectionPage.php?PID={{APIParams.PID}}"><img src="http://silo.lib.wayne.edu/fedora/objects/{{APIParams.PID}}/datastreams/THUMBNAIL/content"/></a>';
        var html = Mustache.to_html(template, APIdata);
        $("#preview_container").html(html);      
        break;
      //eBooks
      case "info:fedora/wayne:CMWSUebook":
        var template = '<iframe src="http://silo.lib.wayne.edu/eTextReader/eTextReader.php?ItemID={{APIParams.PID}}#page/1/mode/2up" width="600px" height="500px" frameborder="0" ></iframe>'
        var html = Mustache.to_html(template, APIdata);
        $("#preview_container").html(html);
        break;
      //Audio
      case "info:fedora/Audio":
        // var template = '<embed height="50" width="100" src="http://silo.lib.wayne.edu/fedora/objects/{{APIParams.PID}}/datastreams/ACCESS/content">'
        var template = '<audio controls height="100" width="100"><source src="http://silo.lib.wayne.edu/fedora/objects/{{APIParams.PID}}/datastreams/ACCESS/content" type="audio/mpeg"></audio>';
        var html = Mustache.to_html(template, APIdata);
        $("#preview_container").html(html);
        break;
      default:
        unknownType();
    }
  }
  else{
    unknownType();
  }



}



function solrSiblings(){
  var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='Cole's Awesome New Function'&PID="+PID;
  $.ajax({          
      url: APIcallURL,      
      dataType: 'json',            
      success: callSuccess,
      error: callError
    });
  //append results to APIdata as "solrSibs"
}


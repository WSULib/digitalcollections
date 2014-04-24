// Javascript for single collection view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global API response data
APIdata = new Object();
var type = '';

APIdata.ordered_facets = [
  	"rels_hasContentModel",
  	"rels_isMemberOfCollection",  	
  	"facet_mods_year",
  	"dc_subject",
  	"dc_creator",
  	"dc_coverage",
  	"dc_language"  	  	
  ];

// Default Search Parameters
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 24;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.fl = "id dc_title";
searchDefs.sort = "id asc";
searchDefs.facet = 'true';
searchDefs['facets[]'] = [];
for (var i=0; i<APIdata.ordered_facets.length; i++){ searchDefs['facets[]'].push(APIdata.ordered_facets[i]) }
searchDefs['f.facet_mods_year.facet.sort'] = "index";
searchDefs['fq[]'] = [];
searchDefs['facet.mincount'] = 1;




// INITIAL FUNCTIONS -- in collection-shared.js
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 1. searchGo()


// PAGE UPDATE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateCollectionTitle(){	

	var collectionTitle = "info:fedora/"+searchParams['id'];
	if (solrTranslationHash[collectionTitle] !== 'undefined'){
		$("h2#collection_title").html(solrTranslationHash[collectionTitle]);
	}

	else {
		$("h2#collection_title").html("Collection Title Unknown");
	} 

}

function updatePage(){

	// make collection equal q, so everything is passed on correctly through the API
	mergedParams.q = mergedParams.collection;

	// get current URL
	var cURL = document.URL;

	// update number of results
	updateNumbers();	

	// show "refined by" facets
	showFacets();	

	// // pagination
	paginationUpdate();

	// update link to the Collection's single object page	
	$("#learn_more").html("<a href='item?rendered=singleObject&id="+searchParams['id']+"'>Learn more about this collection</a>");

	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);

}

// DISPLAY RESULTS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// populate results - display uniqueness is found in templates
function populateResults(templateLocation,destination){
  
  //push results to results_container
  for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {

    	$.ajax({                
    	url: templateLocation,      
    	dataType: 'html',            
    	async:false,
    	success: function(response){        
        var template = response;
        var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);  
        $(destination).append(html);
      }     
    });
  } 
}














// Javascript for all collections view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
searchDefs['facets[]'].push("facet_mods_year","dc_subject","dc_creator","dc_language","rels_hasContentModel", "dc_coverage");
searchDefs['f.facet_mods_year.facet.sort'] = "index";
searchDefs['fq[]'] = [
	"rels_hasContentModel:info\\:fedora/CM\\:Collection",
	"rels_isPrimaryCollection:True"
];
searchDefs['facet.mincount'] = 1;


// Global API response data
APIdata = new Object();
var type = '';


//INITIAL LOAD 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(){		

	// Set Search Parameters
	searchParams['q'] = "*:*";
	searchParams['raw'] = "noescape";	

	// fix facets / fq	
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];

	// add API functions to mergedParams
	searchParams['functions[]'] = "solrSearch";		
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);				
	
	var APIcallURL = "/"+config.API_url;	
	$.ajax({          
		url: APIcallURL,      
		dataType: 'json',
		data:mergedParams,	         
		success: callSuccess,
		error: callError
		});
		function callSuccess(response){
			// console.log(response);
			mix(response, APIdata);

			// organize select collections at the front
			for (var i = APIdata.solrSearch.response.docs.length - 1; i >= 0; i--) {
				col = APIdata.solrSearch.response.docs[i]
				if (col.id == 'wayne:collectionvmc') {
					promote = APIdata.solrSearch.response.docs[i];
					APIdata.solrSearch.response.docs.splice(i,1);
					APIdata.solrSearch.response.docs.unshift(promote);
				};
				
			};

			populateCollectionsView();

		}
		function callError(response){			
			load503(APIcallURL);
		}
}


//DISPLAY RESULTS
//////////////////////////////////////////////////////////////////
function populateCollectionsView(){	
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		
  		$.ajax({          
		  url: 'templates/multipleCollectionsObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;		  	
		  	var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);		  	
		  	$(".collection_contents").append(html);		  	
		  }			    
		});
	}

	// skipping wait
	$(".loader").remove();
	$(".collection_contents").show();

}

function loadHardcodedCollections(url,image_url,collection_name){
	$(".collection_contents").append('<li class="collection object-container-grid"><div><a href="'+url+'"><img src="'+image_url+'"></a></div><h3><a href="'+url+'">'+collection_name+'</a></h3></li>');
}




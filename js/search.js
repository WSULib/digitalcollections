// Javascript for search view


// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters (pre form submission)
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 10;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.facet = 'true';
searchDefs.facets = [];
searchDefs.facets.push("dc_date","dc_subject","dc_creator","dc_language");
searchDefs.fq = [];
searchDefs['facet.mincount'] = 2;

// Global API response data
APIdata = new Object();

// Facet Hash
var facetHash = {
	"dc_date":"Date",
	"dc_subject":"Subject",
	"dc_creator":"Creator",
	"dc_language":"Language"
}



// PAGE UPDATE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function updatePage(){

	// get current URL
	var cURL = document.URL;

	// check that start not great than rows, otherwise reset
	if (mergedParams.start > APIdata.solrSearch.response.numFound )	{

	}

	// update number of results
	$("#q_string").html(mergedParams.q);	
	$("#num_results").html(APIdata.solrSearch.response.numFound);

	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);

	// update query box
	$("#q").val(mergedParams.q);

	// show "refined by" facets
	for (var i = 0; i < mergedParams.fq.length; i++){
		var facet_string = mergedParams.fq[i];
		var facet_type = facet_string.split(":")[0];
		var facet_value = facet_string.split(":")[1];				
		var nURL = cURL.replace(("fq[]="+encodeURI(facet_string)),'');
		$("#facet_refine_list").append("<li>"+facetHash[facet_type]+": "+facet_value+" <a href='"+nURL+"'>x</a></li>");
	}

	// pagination
	var tpages = parseInt((APIdata.solrSearch.response.numFound / mergedParams.rows) + 1);
	var spage = (mergedParams.start / mergedParams.rows) + 1;
	if (spage == 0) {
		spage = 1;
	}

	
	$('.pagination').bootpag({
	   total: tpages,
	   page: spage,
	   maxVisible: 10,
	   leaps:true
	}).on('page', function(event, num){			    
	    var nURL = updateURLParameter(window.location.href, "start", ((num * mergedParams.rows) - mergedParams.rows) );
	    // refresh page	
		window.location = nURL;
	});

}





// QUERYING
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(){

	// Set Search Parameters	
	// Pre-merge? Push default facets to params, such that they don't overwrite? May not be necessary, facets should be hardcoded...	
	// Merge default and URL search parameters
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();
	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='solrSearch'&GETparams='"+solrParamsString+"'";			

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'jsonp',	  
	  jsonpCallback: "jsonpcallback",          
	  success: callSuccess,
	  // error: callError
	});

	function callSuccess(response){

	    APIdata = response;
	    console.log("APIdata");
	    console.log(APIdata);
	    $(document).ready(function(){
	    	updatePage();
	    	populateFacets();
	    	populateResults();	    		
	    });
	    
	}

	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}
}


function updateSearch(){

	// get current URL
	var cURL = document.URL;

	// check rows to update
	searchParams.rows = $("#rows").val();
	var nURL = updateURLParameter(window.location.href, 'rows', searchParams.rows);

	// refresh page	
	window.location = nURL;
}




// DISPLAY RESULTS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function populateFacets(){

	// get current URL
	var cURL = document.URL;

	// for each facet field
	// this needs to create collapsing facets....
	for (var facet in APIdata.solrSearch.facet_counts.facet_fields) {		

		$("#facets_container").append("<div id='"+facetHash[facet]+"_facet'><p><strong>"+facetHash[facet]+"</strong></p><ul class='facet_list' id='"+facetHash[facet]+"_list'</div>");
		
		var facet_array = APIdata.solrSearch.facet_counts.facet_fields[facet];
		for (var i = 0; i < facet_array.length; i = i + 2){		
			fURL = cURL + "&fq[]=" + facet + ":\"" + facet_array[i] +"\""+"&start=0"; //set start to 0, most elegant way to handle less numFound than start count
			$("#"+facetHash[facet]+"_list").append("<li><a href='"+fURL+"'>"+facet_array[i]+" - "+facet_array[i+1]+"</a></li>");
		}		

	}
		
}

function populateResults(){
	
	//push results to results_container
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/searchResultObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);		  	
		  	$("#results_container").append(html);
		  }		  
		});
	}	
}




// UTILITIES
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * http://stackoverflow.com/a/10997390/11236
 */
function updateURLParameter(url, param, paramVal){
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (i=0; i<tempArray.length; i++){
            if(tempArray[i].split('=')[0] != param){
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

function debugSearchParams(){
	console.log("searchParams:");
	console.log(searchParams);
	console.log("searchDefs:");
	console.log(searchDefs);
	console.log("mergedParams:");
	console.log(mergedParams);

}

function removeParameter(url, parameter)
{
  var fragment = url.split('#');
  var urlparts= fragment[0].split('?');

  if (urlparts.length>=2)
  {
    var urlBase=urlparts.shift(); //get first part, and remove from array
    var queryString=urlparts.join("?"); //join it back up

    var prefix = encodeURIComponent(parameter)+'=';
    var pars = queryString.split(/[&;]/g);
    for (var i= pars.length; i-->0;) {               //reverse iteration as may be destructive
      if (pars[i].lastIndexOf(prefix, 0)!==-1) {   //idiom for string.startsWith
        pars.splice(i, 1);
      }
    }
    url = urlBase+'?'+pars.join('&');
    if (fragment[1]) {
      url += "#" + fragment[1];
    }
  }
  return url;
}

function jumpToPage(num){
	console.log(num);
}
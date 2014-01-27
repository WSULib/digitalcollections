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

function facetCollapseToggle(type, facet){
	$("#"+facet+"_less").toggle();
	$("#"+facet+"_more").toggle();	
	if (type == "more"){
		$("#"+facet+"_list.facet_list li.hidden_facet").fadeIn();			
	}
	if (type == "less"){
		$("#"+facet+"_list.facet_list li.hidden_facet").hide();		
	}	
}

//string contains
String.prototype.contains = function(it) { return this.indexOf(it) != -1; };

// string endsWith
String.prototype.endsWith = function(suffix) {
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
};

// mix objects
function mix(source, target) {
   for(var key in source) {
     if (source.hasOwnProperty(key)) {
        target[key] = source[key];
     }
   }

}

// function to clean URL
function URLcleaner(URL){

  // remove mult ampersands
  URL = URL.replace(/[&]+/g, "&");  

  // remove hanging "q=*"
  URL = URL.replace(/q=\*/g,"");  

  // remove hanging ampersand
  if (URL.endsWith("&")){
    URL = URL.substring(0, URL.length - 1);
  }  

  // remove multiple "start=0"
  return URL;  

}

// update page functions

// show facets
function showFacets(){
  // get current URL
  var cURL = document.URL;

  for (var i = 0; i < mergedParams['fq[]'].length; i++){    
    var facet_string = mergedParams['fq[]'][i];       
    var facet_type = facet_string.split(":")[0];
    var facet_value = facet_string.split(":").slice(1).join(":");
  

    var nURL = cURL.replace(("fq[]="+encodeURI(facet_string)),'');
    nURL = URLcleaner(nURL);
    $(".filtered-by").append("<span class='facet-item'><a href='"+nURL+"'>x "/*+rosetta(facet_type)+": "*/+rosetta(facet_value)+"</a></span>");
  }
}

function updateNumbers(){
  // update number of results
  $("#q_string").html(mergedParams.q);  
  $("#num_results").html(APIdata.solrSearch.response.numFound);
  // update rows selecctor
  $("#rows").val(mergedParams.rows).prop('selected',true);
}

function paginationUpdate(){
  // pagination
  var tpages = parseInt((APIdata.solrSearch.response.numFound / mergedParams.rows) + 1);
  var spage = parseInt(mergedParams.start / mergedParams.rows) + 1;
  if (spage == 0) {
    spage = 1;
  }
  
  $('.pagination-centered').bootpag({
     total: tpages,
     page: spage,
     maxVisible: 10,
     leaps:false
  }).on('page', function(event, num){         
      var nURL = updateURLParameter(window.location.href, "start", ((num * mergedParams.rows) - mergedParams.rows) );
      // refresh page 
    window.location = nURL;
  });
}






















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
  url = URLcleaner(url);
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
  
  // while ( URL.endsWith("start=0") ){
  //   URL = URL.substring(0, URL.length - 8);
  // }

  while ( URL.endsWith("?q=") ){
    URL = URL.substring(0, URL.length - 3);
  }  

  while ( URL.endsWith("?q=*") ){
    URL = URL.substring(0, URL.length - 4);
  }

  // remove single hanging offenders
  while ( URL.endsWith("?") || URL.endsWith("&") ){
    URL = URL.substring(0, URL.length - 1);
  }

  return URL;  

}

// refine by keyword function, triggered by keyword search form
function refineByKeyWord(context){   

  var cURL = window.location.href;  

  //get word from box
  var filter_input = $('#filter_input').val();  

  if (context == "search"){
    // tack on "*" to empty search  
    if (cURL.indexOf("?q=") == -1 ){
      cURL+="?q=*";
    }
    if (cURL.endsWith("?q=") == true ){
      cURL+="*";
    }  
  }  

  // check rows to update and add to fq[]
  var nURL = cURL+"&fq[]=text:"+filter_input+"&start=0";   

  nURL = URLcleaner(nURL);  

  // refresh page 
  window.location = nURL;

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
    $(".filtered-by").append("<span class='facet-item'><a href='"+nURL+"'>x "+rosetta(facet_value)+"</a></span>");
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
  var tpages = tpagesPaginate(APIdata.solrSearch.response.numFound,mergedParams.rows);
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

// populate facets
function populateFacets(){  

  // get current URL
  var cURL = document.URL;

  // tack on "*" to empty search  
  if (cURL.indexOf("?") == -1 ){
    cURL+="?";
  }
  if (cURL.endsWith("?q=") == true ){
    cURL+="*";
  }


  // set defaults
  var facet_limit = 18;
  // for each facet field
  for (var facet in APIdata.solrSearch.facet_counts.facet_fields) {
    $("#facets_container").append("<ul class='facet_container filter' id='"+facet+"_facet'><li><h3 class='tree-toggler'><span class='entypo-minus'></span>"+rosetta(facet)+"</h3><ul class='tree facet_list' id='"+facet+"_list'></ul></li>");


    var facet_array = APIdata.solrSearch.facet_counts.facet_fields[facet];    
    for (var i = 0; i < facet_array.length; i = i + 2){     
      // run through rosetta translation
      var facet_value = rosetta(facet_array[i]);      
      if (facet_array[i] != ""){                
        
        // find and replace start value with 0
        fURL = cURL + "&fq[]=" + facet + ":\"" + facet_array[i] +"\""/*+"&start=0"*/; 
        if (fURL.contains("start=")){
          fURL = fURL.replace(/start=([0-9]+)/g,"start=0");
        }
        else {
          fURL+="&start=0";
        }
        
        // for long facet lists, initially hide facets over facet_limit
        if (i > facet_limit) { 
          var facet_hidden = "class='hidden_facet'";
        } 
        else {
          var facet_hidden = ""
        }     
        $("#"+facet+"_list").append("<li "+facet_hidden+"><a href='"+fURL+"'>"+facet_value+" ("+facet_array[i+1]+")</a></li>"); 
      }


    }
    // hide empty facets
        $('ul:not(:has(li))').parent().parent(".facet_container").hide();  
        $('#search_facet').show();

        
    // add "more" button if longer than facet_limit   
    if (facet_array.length > facet_limit){            
      $("#"+facet+"_list").append("<p class='facet-more'><strong><a id='"+facet+"_more' href='#' onclick='facetCollapseToggle(\"more\", \""+facet+"\"); return false;'>View All &raquo;</a></strong></p>");
      $("#"+facet+"_list").append("<p class='facet-more'><strong><a class='facet_less' id='"+facet+"_less' href='#' onclick='facetCollapseToggle(\"less\", \""+facet+"\"); return false;'>&laquo; View Less</a></strong></p>");     
    }
  }   
}


// populate results - display uniqueness is found in templates
function populateResults(templateLocation,destination,templateData){
  
  //push results to results_container
  for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {
      $.ajax({                
      url: templateLocation,      
      dataType: 'html',            
      async:false,
      success: function(response){        
        var template = response;
        if (typeof(templateData) == 'undefined') {          
          var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);         
        }
        else {
          var html = Mustache.to_html(template, templateData);           
        }        
        $(destination).append(html);
      }     
    });
  } 
}

// render serials navigation block
function renderSerialNavBlock(){

  function prepareSerialWalk(results){

    var vols = {};
    var volsArray = []; 
    var sortingArray = [];
    var volNames = {};

    for (var i=0; i<results.length; i++){
      var node = results[i];
      // push to sorting array
      if (sortingArray.indexOf(node.volume) == -1){
        sortingArray.push(node.volume);
        volNames[node.volume] = node.volumeTitle;        
      }     
      // push to volumes object
      if (vols.hasOwnProperty(node.volume) == false ){
        vols[node.volume] = [];                   
        var temp = {};
        temp.issuePID = node.issue;
        temp.issueTitle = node.issueTitle;        
        vols[node.volume].push(temp);     
      }
      else{        
        var temp = {};
        temp.issuePID = node.issue;
        temp.issueTitle = node.issueTitle;        
        vols[node.volume].push(temp);
      }
    } 

    // push key-value pair
    APIdata.serialMeta.keyVols = vols;

    // alphanumeric sort sort by volume name
    sortingArray.alphanumSort();
    APIdata.sortingArray = sortingArray;    
    
    // pluck to array
    for (var i=0; i<APIdata.sortingArray.length; i++){
      var wholeVolObj = {};
      wholeVolObj.volPID = APIdata.sortingArray[i];
      wholeVolObj.volTitle = volNames[APIdata.sortingArray[i]]
      wholeVolObj.issuesArray = vols[APIdata.sortingArray[i]]
      volsArray.push(wholeVolObj)
    }

    // push volNames to global
    APIdata.serialMeta.volNames = volNames;

    APIdata.serialMeta.cleanVols = volsArray;
  }

  prepareSerialWalk(APIdata.serialMeta.serialWalk.results);

  $.ajax({                
    url: "templates/serial-nav-full.htm",      
    dataType: 'html',            
    async:true,
    success: function(response){        
      var template = response;
      var html = Mustache.to_html(template, APIdata);       
      $("#serial-nav").append(html);      
      renderMain();
    }     
  });  

}



// cleans empty rows from "more-info" pane
function cleanEmptyMetaRows(){
  var tds = $("td");
  tds.each(function(i,el) { 
    var elhtml = $(el).html();    
    if($.trim($(el).html())==''){      
      $(el).parent().hide();
    }
  });
}


function tpagesPaginate(results,rows){
	var tpage_dec = results / rows;
	if (tpage_dec % 1 != 0){
		return parseInt(tpage_dec) + 1
	}
	else {
		return tpage_dec
	}
}













// PROTOTYPES

// strip info:fedora/ prefix
String.prototype.stripFedRDFPrefix = function() {    
    return this.substring(12);
};

//natural language sorter
Array.prototype.alphanumSort = function(caseInsensitive) {
  for (var z = 0, t; t = this[z]; z++) {
    this[z] = []; var x = 0, y = -1, n = 0, i, j;

    while (i = (j = t.charAt(x++)).charCodeAt(0)) {
      var m = (i == 46 || (i >=48 && i <= 57));
      if (m !== n) {
        this[z][++y] = "";
        n = m;
      }
      this[z][y] += j;
    }
  }

  this.sort(function(a, b) {
    for (var x = 0, aa, bb; (aa = a[x]) && (bb = b[x]); x++) {
      if (caseInsensitive) {
        aa = aa.toLowerCase();
        bb = bb.toLowerCase();
      }
      if (aa !== bb) {
        var c = Number(aa), d = Number(bb);
        if (c == aa && d == bb) {
          return c - d;
        } else return (aa > bb) ? 1 : -1;
      }
    }
    return a.length - b.length;
  });

  for (var z = 0; z < this.length; z++)
    this[z] = this[z].join("");
}








// UTILITIES
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ALWAYS LOADS

// On utilities.js file load, generate translation hash from Solr
var solrTranslationHash = {}
var APIcallURL = "/"+config.API_url+"?functions[]=solrTranslationHash"
	$.ajax({          
		url: APIcallURL,      
		dataType: 'json',	  	    
		success: callSuccess,
		error: callError
	});
	function callSuccess(response){
		solrTranslationHash = response.solrTranslationHash;			
	}
	function callError(response){
		console.log("Could not retrieve solrTranslationHash");	  
	}

// Piwik (piwik.library.wayne.edu)
// Note: defers to /inc/struct_data.php when detects page is /
var locale = window.location.pathname.split(/[\/]+/).pop()
if (locale != "item"){
	var _paq = _paq || [];
	_paq.push(["setDomains", ["*.digital.library.wayne.edu"]]);
	_paq.push(['trackPageView']);
	_paq.push(['enableLinkTracking']);
	(function() {
		var u="//piwik.library.wayne.edu/";
		_paq.push(['setTrackerUrl', u+'piwik.php']);
		_paq.push(['setSiteId', 28]);
		var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
	})();
}


// Google Analytics (digital.library.wayne.edu)
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-63434748-1', 'auto');
ga('send', 'pageview');


// hide things that need localStorage
$(document).ready(function(){
	if (lsTest() === false){  
		// toggle views
		$("#toggleView").remove();
	}  
});


// Digital Collections Front-End Translation Dictionary
function rosetta(input){	
	
	// hardcoded facet translations
	var facetHash = {
		"dc_date":"Date",
		"facet_mods_year":"Date",
		"dc_subject":"Subject",
		"dc_creator":"Creator",
		"dc_language":"Language",
		"dc_coverage":"Coverage",  
		"dc_publisher":"Publisher",  
		"rels_hasContentModel":"Content Type",
		"rels_isMemberOfCollection":"Collection",
		"int_fullText":"Full-Text",
		"text":"Keyword",
		"metadata":"Item Record",
		"mods_name_creator_ms":"Creator"
	};

	// create APIdata.solrTranslationHash from retrieved and hard-coded
	APIdata.solrTranslationHash = jQuery.extend(solrTranslationHash,facetHash);		

	// strip quotes
	var s_input = input.replace(/"|'/g,'')
	if (typeof(APIdata.solrTranslationHash[s_input]) == 'undefined') {
		var output = s_input;
		return output;
	}	
	else{
		var output = APIdata.solrTranslationHash[s_input];
		return output;
	}
}


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
// radio buttons for metadata, fulltext, both
function refineByKeyWord(context, open_type){	

	//get search terms
	var refine_input = $('#refine_input').val();

	// non-search view (e.g. serial)
	if (context == 'serial'){

		// construct path that points to collection page
		var cURL = window.location.pathname;		
		cURL = cURL+'?id='+APIdata.serialMeta.APIParams.PID[0]+'&rendered=collection';		

		// set solr field
		var solr_field = 'int_fullText';
	}

	// search or collection view
	else {
		var cURL = window.location.href;		

		// get refine type
		var refine_type = $("input:radio[name ='refine_type']:checked").val();	
		if ( refine_type == "fulltext" ) {
			var solr_field = "int_fullText";
		}  
		else if ( refine_type == "metadata"){
			var solr_field = "metadata";
		}
		else {
			var solr_field = "text";
		}

	}

	// add parameters
	if (cURL.indexOf("?") == -1 ){
		cURL+="?";
	}	

	// write new URL with correct solr fq
	if (refine_input !== ""){
		var nURL = cURL+"&fq[]="+solr_field+":"+refine_input+"&start=0";   
	}
	else{
		var nURL = cURL+"&start=0";     
	}	

	// refresh page 
	nURL = URLcleaner(nURL);

	if (open_type == 'new'){
		window.open(
		  nURL,
		  '_blank' // <- This is what makes it open in a new window.
		);
	}
	else {
		window.location = nURL;	
	}
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
		$(".filtered-by").append("<span class='facet-item'><a href='"+nURL+"'><i class='icon-delete'></i> <span class='facet_name'>"+rosetta(facet_type)+"</span>: "+rosetta(facet_value)+"</a></span>");
	}
}

function updateNumbers(){
	// update number of results
	if (mergedParams.q != "*"){
		$("#search_results_ul").append("<li>&quot;" + mergedParams.q + "&quot;</li>")
	}	
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


	// DEBUG
	// var t0 = performance.now();

	total_facet_count = 0;

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
	var facet_limit = 10;

	for (var each=0; each < APIdata.ordered_facets.length; each++) {   		
		var facet = APIdata.ordered_facets[each];  	
		var facet_array = APIdata.solrSearch.facet_counts.facet_fields[facet];
		$("#facets_container").append("<ul class='facet_container filter' id='"+facet+"_facet'><li><h3 class='tree-toggler'><span class='icon-minus-thin'></span>"+rosetta(facet)+" ("+facet_array.length / 2+")</h3><ul class='tree facet_list' id='"+facet+"_list'></ul></li>");

		var compiled_facet_list = "";
		for (var i = 0; i < facet_array.length; i = i + 2){     
			// run through rosetta translation
			var facet_value = rosetta(facet_array[i]);      
			if (facet_array[i] != ""){        
				// find and replace start value with 0
				fURL = cURL + "&fq[]=" + facet + ":\"" + facet_array[i] +"\""; 
				if (fURL.contains("start=")){
					fURL = fURL.replace(/start=([0-9]+)/g,"start=0");
				}
				else {
					fURL+="&start=0";
				}				
				
				compiled_facet_list += "<li><a href='"+fURL+"'>"+facet_value+" ("+facet_array[i+1]+")</a></li>";
				// $("#"+facet+"_list").append("<li><a href='"+fURL+"'>"+facet_value+" ("+facet_array[i+1]+")</a></li>"); 

				// DEBUG
				total_facet_count += 1;
			}
		}

		// add compiled li elements
		$("#"+facet+"_list").append(compiled_facet_list); 
			
	}   

	// Stats
	var facet_stats = [total_facet_count + "\t" + (t1 - t0) + "\t" + (total_facet_count / (t1 - t0))]

	// DEBUG
	var t1 = performance.now();
	console.log("total facet count, time (ms), facets per millisecond");
	console.log(facet_stats);
	if (localStorageTest() == true) {
		console.time('storing_facet_times');
		if (localStorage.getItem("facet_log") === null) { 
			localStorage.setItem("facet_log", JSON.stringify([])); 
		}
		facet_log = JSON.parse(localStorage.getItem("facet_log"));
		facet_log.push(facet_stats);
		localStorage.setItem("facet_log", JSON.stringify(facet_log));
		console.timeEnd('storing_facet_times');
	}

}


// populate results - display uniqueness is found in templates
function populateResults(templateType, destination, templateData){
	// prescribe template locations
	templateHash = {
		'grid' : 'templates/gridObj.htm',
		'list' : 'templates/listObj.htm',
	}

	// catch undefined type
	if (templateHash[templateType] == undefined){    
		templateHash[templateType] = "templates/listObj.htm";
	}
	
	//push results to results_container
	$.ajax({                
		url: templateHash[templateType],      
		dataType: 'html',            
		async:false,
		success: function(response){
			var template = response;
			
			// loop through responses
			for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {
				if (typeof(templateData) == 'undefined') {
					template_package = {
						"config":config,
						"solr_data":APIdata.solrSearch.response.docs[i]
					}
					var html = Mustache.to_html(template, template_package);         
				}
				else {
					template_package = {
						"config":config,
						"solr_data":templateData
					}
					var html = Mustache.to_html(template, templateData);           
				}        
				$(destination).append(html);
			} 
			
		}     
	});

	// retroactively give them index numbers
	var items = $(".crop a");
	for (var i = 0; i < items.length; i++) { 

		// for related results work
		// items[i].href = items[i].href + "&search_index=" + i;
		// normal
		items[i].href = items[i].href; 

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
		// sortingArray.alphanumSort();    
		sortingArray.sort(sortAlphaNum);
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
			APIdata['config'] = config;
			var html = Mustache.to_html(template, APIdata);       
			$("#serial-nav").append(html);      
			renderMain();
		}     
	});  

}


// render serials navigation block
function test_renderSerialNavBlock(){  

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
		// sortingArray.alphanumSort();    
		sortingArray.sort(sortAlphaNum);
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
			APIdata['config'] = config;
			var html = Mustache.to_html(template, APIdata);
			$(".related-objects").append("<div id='serial-nav'></div>");
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




// 404 - Item Not Found
function load404(refURL){	
	window.location.replace("404.php");
}

// 503 - Error Page
function load503(refURL){	
	window.location.replace("error.php");
}

// use: Array.sort(sortAlphaNum);
function sortAlphaNum(a,b) {
		var reA = /[^a-zA-Z]/g;
		var reN = /[^0-9]/g;
		var aA = a.replace(reA, "");
		var bA = b.replace(reA, "");
		if(aA === bA) {
				var aN = parseInt(a.replace(reN, ""), 10);
				var bN = parseInt(b.replace(reN, ""), 10);
				return aN === bN ? 0 : aN > bN ? 1 : -1;
		} else {
				return aA > bA ? 1 : -1;
		}
}

//check for storage support
function localStorageTest() {
		var mod = 'test';
		try {
				localStorage.setItem(mod, mod);
				localStorage.removeItem(mod);
				return true;
		} catch(e) {
				return false;
		}
}


//toggle grid and list views
function toggleResultsView(context){  

	var cView = localStorage.getItem(context+"_resultsView");  
	if (cView == "grid"){
		localStorage.setItem(context+"_resultsView",'list');
	}
	if (cView == "list"){
		localStorage.setItem(context+"_resultsView",'grid');
	}
	// refresh
	location.reload();
}

// update results per page
$(document).ready(function(){
	$(".resPerPage").change(function() {    
		var nURL = window.location.href;    
		searchParams.rows = $(this).val();
		var nURL = updateURLParameter(nURL, 'rows', searchParams.rows); 
		// adjust start pointer
		if (searchParams.rows > searchParams.start){    
			var nURL = updateURLParameter(nURL, 'start', "0");
		} 
		// refresh page 
		window.location = nURL;
	});  
});


// check for localStorage
function lsTest(){
		var test = 'test';
		try {
				localStorage.setItem(test, test);
				localStorage.removeItem(test);
				return true;
		} catch(e) {
				return false;
		}
}

// check for get parameter
function checkGetParam(val) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

// serialize JS object into get parameter string
function object2GetParamsString(obj, prefix) {
  var str = [];
  for(var p in obj) {
    if (obj.hasOwnProperty(p)) {
      var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
      str.push(typeof v == "object" ?
        object2GetParamsString(v, k) :
        encodeURIComponent(k) + "=" + encodeURIComponent(v));
    }
  }
  return str.join("&");
}

function splitObjectLiteral(obj_lit_string){
	temp_obj = obj_lit_string.split("/");
	return_obj = {
		"pid":temp_obj[1],
		"ds_id":temp_obj[2],
	}
	return return_obj;
}


// hide more info dropdown, but reveal button
function noMoreMeta(){
	$(".display-more-info").hide();
	$(".more-info").html("More Info");
	$(".more-info-clickr").show();	
}


//keyboard shortcut to show hidden elements
$(document).ready(function(){
	Mousetrap.bind('up up down down left right left right b a enter', function(e) {
	    $(".ks_reveal").fadeToggle();
	    return false;
	});
	Mousetrap.bind('s h o w m e', function(e) {
	    $(".ks_reveal").fadeToggle();
	    return false;
	});
	Mousetrap.bind('l o g i n', function(e) {
	    $(".login_status").fadeToggle();
	    return false;
	});
	Mousetrap.bind('b u t t o n', function(e) {
	    $(".tempButtons").fadeToggle();
	    $(".original").fadeToggle();
	    return false;
	});
});


// fire freewall js for grid view
function gridInit(){
	
	// unhide
	$("#results_container").show();

	var wall = new freewall("#results_container");
	wall.reset({
		selector: '.tile',
		animate: false,
		cellW: 200,
		cellH: 'auto',
		onResize: function() {
			wall.fitWidth();
		}
	});

	var images = wall.container.find('.tile');
	images.find('img').load(function() {
		wall.fitWidth();
	});

}

// fire freewall js for grid view
function hierarchical_gridInit(){
	console.log('hierarchical firing!');
	
	// unhide
	$("#results_container").show();

	var wall = new freewall("#results_container");
	wall.reset({
		selector: '.tile',
		animate: false,
		cellW: 150,
		cellH: 'auto',
		onResize: function() {
			wall.fitWidth();
		}
	});

	var images = wall.container.find('.tile');
	images.find('img').load(function() {
		wall.fitWidth();
	});

}


// PROTOTYPES
// strip info:fedora/ prefix
String.prototype.stripFedRDFPrefix = function() {    
		return this.substring(12);
};


function toggleFacets(){
	$("#facets_container").toggle();
	$(".main-container").width("100%");
	$(".object-container-grid .crop").css("height","375px");
}

// // function for related items (V2, deprecated)
// function genRelatedItems(){
// 	APIdata.objectLoci.collection_list = [];
//     for (var key in APIdata.objectLoci.collection_loci) {      
//       var temp_obj = {
//       	"name":key,
//       	"previous_objects": APIdata.objectLoci.collection_loci[key]['previous_objects'],
//       	"next_objects": APIdata.objectLoci.collection_loci[key]['next_objects']
//       }
//       APIdata.objectLoci.collection_list.push(temp_obj)
//     }

//     // functional 
//     $.get('templates/related-objects.htm',function(template){
//       var html = Mustache.to_html(template, APIdata);
//       $(".related-objects").html(html);
//       cleanEmptyMetaRows();
//     });	
// }









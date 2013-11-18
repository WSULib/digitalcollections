// Javascript for collection view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 50;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.fl = "id dc_title";
searchDefs.sort = "id asc";
searchDefs.facet = 'true';
searchDefs['facets[]'] = [];
searchDefs['facets[]'].push("dc_date","dc_subject","dc_creator","dc_language","rels_hasContentModel", "dc_coverage");
searchDefs['f.dc_date.facet.sort'] = "index";
searchDefs['fq[]'] = [];
searchDefs['facet.mincount'] = 1;


// Global API response data
APIdata = new Object();
var type = '';

// ///////////////////////////////////////
// // Default Search Parameters (pre form submission)
// var searchDefs = {};
// var mergedParams = {};
// searchDefs.rows = 10;
// searchDefs.start = 0;
// searchDefs.wt = "json";
// searchDefs.facet = 'true';
// searchDefs['facets[]'] = [];
// searchDefs['facets[]'].push("dc_date","dc_subject","dc_creator","dc_language","rels_hasContentModel","rels_isMemberOfCollection", "dc_coverage");
// searchDefs['f.dc_date.facet.sort'] = "index";
// searchDefs['fq[]'] = [];
// searchDefs['facet.mincount'] = 1;
// searchDefs['fullView'] = '';
// ///////////////////////////////////////////


//INITIAL LOAD
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function collectionsCount(){	
	var str = searchParams.q;

	var CollectionListParams = {
		"rows":0,
		"start":0,
		"q":"*",
		"facet":"true",
		"facet.field":"rels_isMemberOfCollection"
		// "raw":"escapeterms"
	}
	
	CollectionListParams = JSON.stringify(CollectionListParams);

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrFacetSearch&solrParams="+CollectionListParams;

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){
		APIdata.collectionsCount = response;
		populateCollectionsView();
	}

	function callError(response){
		console.log("collectionCount Error");
		console.log(response);
	}
}

function collectionsList(type){

	// WSUAPI v2.0 / Stringify MO
	var CollectionListParams = {
		"rows":100,
		"start":0,
		"wt":"json",
		"sort":"id asc",
		"q":"rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORPublic",
		"raw":"escapeterms"
	}
	
	CollectionListParams = JSON.stringify(CollectionListParams);

	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrSearch&solrParams="+CollectionListParams;

	// Calls API functions
	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){

	    APIdata.collectionsList = response;
	    $(document).ready(function(){

	    	if (type == "collectionPage") {
				populateCollectionsList();
				}    

	    	else if (type == "allCollections") {
	    		collectionsCount();
	    	}
		
	    });
	    
	}

	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}
}


// PAGE UPDATE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function updatePage(){

	// make collection equal q, so everything is passed on correctly through the API
	mergedParams.q = mergedParams.collection;

	// get current URL
	var cURL = document.URL;

	// update number of results
	$("#q_string").html(mergedParams.q);

	$("#num_results").html(APIdata.objectList.solrSearch.response.numFound);

	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);

	// update query box
	$("#q").val(mergedParams.q);	

	// pagination
	var tpages = parseInt((APIdata.objectList.solrSearch.response.numFound / mergedParams.rows) + 1);
	var spage = parseInt(mergedParams.start / mergedParams.rows) + 1;
	if (spage == 0) {
		spage = 1;
	}

	// show "refined by" facets
	for (var i = 0; i < mergedParams['fq[]'].length; i++){		
		var facet_string = mergedParams['fq[]'][i];				
		var facet_type = facet_string.split(":")[0];
		var facet_value = facet_string.split(":").slice(1).join(":");
	

		var nURL = cURL.replace(("fq[]="+encodeURI(facet_string)),'');
		$("#facet_refine_list").append("<li><a href='"+nURL+"'>x</a> "+rosetta(facet_type)+": "+rosetta(facet_value)+"</li>");
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
function searchGo(type){

	// Set Search Parameters	
	searchParams['q'] = searchParams['collection'];
	searchParams['q'] = "rels_isMemberOfCollection:info:fedora/"+searchParams['q'];
	delete searchParams['collection'];
	searchParams['raw'] = "escapeterms";


	// fix facets / fq
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];

	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);	

	// WSUAPI v2.0
	// Usuing new API function solrSearch()
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrSearch&solrParams="+solrParamsString;
	console.log(APIcallURL);
	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	         
	  success: callSuccess,
	  // error: callError
	});

	function callSuccess(response){

	    APIdata.objectList = response;
	    APIdata.solrTranslationHash = APIdata.objectList.solrTranslationHash
	    $(document).ready(function(){
	    	if (type == "collectionPage"){
	    	collectionsList("collectionPage");
	    	updateCollectionTitle();
	    	updatePage();
	    	populateFacets();
	    	populateResults();	    	
	    	}
	    	else if (type == "allCollections"){
	    	collectionsList("allCollections");
	    	}	    		
	    });
	    
	}

	function callError(response){

		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}
}

function updateCollectionTitle(){	
	var str = searchParams.q;

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrGetFedDoc&PID="+searchParams.q;

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){

	    APIdata.collectionMeta = response;	    
	    $(document).ready(function(){

		    	if (APIdata.collectionMeta.solrGetFedDoc.response.docs[0].dc_title[0] !== 'undefined'){
				$("h2#title").html(APIdata.collectionMeta.solrGetFedDoc.response.docs[0].dc_title[0]);

			}	    		

	    });
	    
	}

	function callError(response){
		console.log("No Collection Title has been returned from ajax call");
		console.log(response);
	    $(document).ready(function(){
			$("h2#title").html("Untitled Collection");	    		
	    });


	}
	// }

}

function updateCollection(){

	// get current URL
	var cURL = document.URL;

	// check rows to update
	searchParams.q = $(".form-control").val();
	// searchParams.start = 0; 
	var nURL = updateURLParameter(window.location.href, 'start', 0);
	var nURL = updateURLParameter(nURL, 'collection', searchParams.q);

	// refresh page	
	window.location = nURL;
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

//DISPLAY RESULTS
//////////////////////////////////////////////////////////////////
function populateFacets(){	

	// get current URL
	var cURL = document.URL;
	// set defaults
	var facet_limit = 18;
	// for each facet field
	for (var facet in APIdata.objectList.solrSearch.facet_counts.facet_fields) {		
		$("#facets_container").append("<ul class='facet_container' id='"+facet+"_facet'><li><h5 class='tree-toggler'>"+rosetta(facet)+"</h5><ul class='tree facet_list' id='"+facet+"_list'></ul></li>");

		var facet_array = APIdata.objectList.solrSearch.facet_counts.facet_fields[facet];		
		for (var i = 0; i < facet_array.length; i = i + 2){			
			// run through rosetta translation			

			var facet_value = rosetta(facet_array[i]);			
			if (facet_array[i] != ""){
				// write URL
				//set start to 0, most elegant way to handle less numFound than start count
				fURL = cURL + "&fq[]=" + facet + ":\"" + facet_array[i] +"\""+"&start=0"; 
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
		// add "more" button if longer than facet_limit		
		if (facet_array.length > facet_limit){						
			$("#"+facet+"_list").append("<p style='text-align:right;'><strong><a id='"+facet+"_more' href='#' onclick='facetCollapseToggle(\"more\", \""+facet+"\"); return false;'>more >></a></strong></p>");
			$("#"+facet+"_list").append("<p style='text-align:right;'><strong><a class='facet_less' id='"+facet+"_less' href='#' onclick='facetCollapseToggle(\"less\", \""+facet+"\"); return false;'><< less</a></strong></p>");			
		}
	}		
}

function populateResults(){

	//push results to results_container
	for (var i = 0; i < APIdata.objectList.solrSearch.response.docs.length; i++) {		
		if (mergedParams.q == "rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORCollections"){
			$.ajax({          
			  url: 'templates/collectionResultObjAlt.htm',      
			  dataType: 'html',            
			  async:false,
			  success: function(response){
			  	var template = response;
			  	var html = Mustache.to_html(template, APIdata.objectList.solrSearch.response.docs[i]);		  	
			  	$(".collection_contents").append(html);
			  }		  
			});
	  	}

		else{
			// ******** TESTING VARIABLES *********
			// APIdata.objectList.solrSearch.response.docs = ["EM01aHMC_102a.gif", "EM01aHMC_102b.gif", "EM01aHMC_103a.gif", "EM01aHMC_103b.gif", "EM01aHMC_104a.gif", "EM01aHMC_104b.gif", "EM01aHMC_105a.gif", "EM01aHMC_105b.gif", "EM01aHMC_105c.gif", "EM01aHMC_106a.gif", "EM01aHMC_107a.gif", "EM01aHMC_108a.gif", "EM01aHMC_108b.gif", "EM01aHMC_109a.gif", "EM01aHMC_109b.gif", "EM01aHMC_109c.gif", "EM01aHMC_109d.gif", "EM01aHMC_10a.gif", "EM01aHMC_10b.gif", "EM01aHMC_10c.gif", "EM01aHMC_110a.gif", "EM01aHMC_110b.gif", "EM01aHMC_110c.gif", "EM01aHMC_111a.gif", "EM01aHMC_112a.gif", "EM01aHMC_112b.gif", "EM01aHMC_113a.gif", "EM01aHMC_113b.gif", "EM01aHMC_113c.gif", "EM01aHMC_114a.gif", "EM01aHMC_114b.gif", "EM01aHMC_115a.gif", "EM01aHMC_115b.gif", "EM01aHMC_116a.gif", "EM01aHMC_116b.gif", "EM01aHMC_117a.gif", "EM01aHMC_118a.gif", "EM01aHMC_118b.gif", "EM01aHMC_119a.gif", "EM01aHMC_119b.gif", "EM01aHMC_119c.gif", "EM01aHMC_11a.gif", "EM01aHMC_120a.gif", "EM01aHMC_120b.gif", "EM01aHMC_121a.gif", "EM01aHMC_121b.gif", "EM01aHMC_121c.gif", "EM01aHMC_122a.gif", "EM01aHMC_122b.gif", "EM01aHMC_123a.gif", "EM01aHMC_124a.gif", "EM01aHMC_124b.gif", "EM01aHMC_124c.gif", "EM01aHMC_125a.gif", "EM01aHMC_125b.gif", "EM01aHMC_126a.gif", "EM01aHMC_127a.gif", "EM01aHMC_127b.gif", "EM01aHMC_127c.gif", "EM01aHMC_128a.gif", "EM01aHMC_128b.gif", "EM01aHMC_129a.gif", "EM01aHMC_12a.gif", "EM01aHMC_12b.gif", "EM01aHMC_12c.gif", "EM01aHMC_130a.gif", "EM01aHMC_131a.gif", "EM01aHMC_131b.gif", "EM01aHMC_132a.gif", "EM01aHMC_132b.gif", "EM01aHMC_132c.gif", "EM01aHMC_133a.gif", "EM01aHMC_134a.gif", "EM01aHMC_135a.gif", "EM01aHMC_136a.gif", "EM01aHMC_137a.gif", "EM01aHMC_137b.gif", "EM01aHMC_138a.gif", "EM01aHMC_139a.gif", "EM01aHMC_13a.gif", "EM01aHMC_13b.gif", "EM01aHMC_13c.gif", "EM01aHMC_140a.gif", "EM01aHMC_140b.gif", "EM01aHMC_141a.gif", "EM01aHMC_141b.gif", "EM01aHMC_142a.gif", "EM01aHMC_142b.gif", "EM01aHMC_142c.gif", "EM01aHMC_143a.gif", "EM01aHMC_144a.gif", "EM01aHMC_145a.gif", "EM01aHMC_146a.gif", "EM01aHMC_147a.gif", "EM01aHMC_147b.gif", "EM01aHMC_148a.gif", "EM01aHMC_148b.gif", "EM01aHMC_148c.gif", "EM01aHMC_149a.gif", "EM01aHMC_149b.gif", "EM01aHMC_150a.gif", "EM01aHMC_150b.gif", "EM01aHMC_151a.gif", "EM01aHMC_152a.gif", "EM01aHMC_152b.gif", "EM01aHMC_152c.gif", "EM01aHMC_153a.gif", "EM01aHMC_154a.gif", "EM01aHMC_155a.gif", "EM01aHMC_156a.gif", "EM01aHMC_156b.gif", "EM01aHMC_156c.gif", "EM01aHMC_157a.gif", "EM01aHMC_158a.gif", "EM01aHMC_158b.gif", "EM01aHMC_159a.gif", "EM01aHMC_159b.gif", "EM01aHMC_15a.gif", "EM01aHMC_15b.gif", "EM01aHMC_15c.gif", "EM01aHMC_160a.gif", "EM01aHMC_161a.gif", "EM01aHMC_161b.gif", "EM01aHMC_162a.gif", "EM01aHMC_162b.gif", "EM01aHMC_163a.gif", "EM01aHMC_163b.gif", "EM01aHMC_164a.gif", "EM01aHMC_164b.gif", "EM01aHMC_165a.gif", "EM01aHMC_165b.gif", "EM01aHMC_166a.gif", "EM01aHMC_167a.gif", "EM01aHMC_167b.gif", "EM01aHMC_169a.gif", "EM01aHMC_169b.gif", "EM01aHMC_16a.gif", "EM01aHMC_16b.gif", "EM01aHMC_170a.gif", "EM01aHMC_171a.gif", "EM01aHMC_172a.gif", "EM01aHMC_172b.gif", "EM01aHMC_173a.gif", "EM01aHMC_173b.gif", "EM01aHMC_174a.gif", "EM01aHMC_175a.gif", "EM01aHMC_175b.gif", "EM01aHMC_176a.gif", "EM01aHMC_176b.gif", "EM01aHMC_177a.gif", "EM01aHMC_178a.gif", "EM01aHMC_179a.gif", "EM01aHMC_17a.gif", "EM01aHMC_17b.gif", "EM01aHMC_180a.gif", "EM01aHMC_181a.gif", "EM01aHMC_182a.gif", "EM01aHMC_183a.gif", "EM01aHMC_185a.gif", "EM01aHMC_186a.gif", "EM01aHMC_187a.gif", "EM01aHMC_188a.gif", "EM01aHMC_189a.gif", "EM01aHMC_18a.gif", "EM01aHMC_18b.gif", "EM01aHMC_18c.gif", "EM01aHMC_190a.gif", "EM01aHMC_191a.gif", "EM01aHMC_191b.gif", "EM01aHMC_191c.gif", "EM01aHMC_192a.gif", "EM01aHMC_193a.gif", "EM01aHMC_194a.gif", "EM01aHMC_195a.gif", "EM01aHMC_196a.gif", "EM01aHMC_1a.gif", "EM01aHMC_1b.gif", "EM01aHMC_20a.gif", "EM01aHMC_20b.gif", "EM01aHMC_20c.gif", "EM01aHMC_21a.gif", "EM01aHMC_21b.gif", "EM01aHMC_21c.gif", "EM01aHMC_220a.gif", "EM01aHMC_220b.gif", "EM01aHMC_226a.gif", "EM01aHMC_226b.gif", "EM01aHMC_228a.gif", "EM01aHMC_22a.gif", "EM01aHMC_22b.gif", "EM01aHMC_236a.gif", "EM01aHMC_236b.gif", "EM01aHMC_237a.gif", "EM01aHMC_23a.gif", "EM01aHMC_23b.gif", "EM01aHMC_23c.gif", "EM01aHMC_241a.gif", "EM01aHMC_242a.gif", "EM01aHMC_24a.gif", "EM01aHMC_24b.gif", "EM01aHMC_257a.gif", "EM01aHMC_257b.gif", "EM01aHMC_258a.gif", "EM01aHMC_258b.gif", "EM01aHMC_258c.gif", "EM01aHMC_259a.gif", "EM01aHMC_259b.gif", "EM01aHMC_25a.gif", "EM01aHMC_25b.gif", "EM01aHMC_260a.gif", "EM01aHMC_260b.gif", "EM01aHMC_260c.gif", "EM01aHMC_261a.gif", "EM01aHMC_262a.gif", "EM01aHMC_262b.gif", "EM01aHMC_262c.gif", "EM01aHMC_263a.gif", "EM01aHMC_263b.gif", "EM01aHMC_263c.gif", "EM01aHMC_264a.gif", "EM01aHMC_264b.gif", "EM01aHMC_265a.gif", "EM01aHMC_266a.gif", "EM01aHMC_266b.gif", "EM01aHMC_267a.gif", "EM01aHMC_267b.gif", "EM01aHMC_267c.gif", "EM01aHMC_268a.gif", "EM01aHMC_268b.gif", "EM01aHMC_269a.gif", "EM01aHMC_269b.gif", "EM01aHMC_26a.gif", "EM01aHMC_26b.gif", "EM01aHMC_26c.gif", "EM01aHMC_270a.gif", "EM01aHMC_271a.gif", "EM01aHMC_271b.gif", "EM01aHMC_272a.gif", "EM01aHMC_273a.gif", "EM01aHMC_273b.gif", "EM01aHMC_273c.gif", "EM01aHMC_274a.gif", "EM01aHMC_274b.gif", "EM01aHMC_274c.gif", "EM01aHMC_275a.gif", "EM01aHMC_275b.gif", "EM01aHMC_276a.gif", "EM01aHMC_277a.gif", "EM01aHMC_277b.gif", "EM01aHMC_277c.gif", "EM01aHMC_278a.gif", "EM01aHMC_279a.gif", "EM01aHMC_279b.gif", "EM01aHMC_27a.gif", "EM01aHMC_280a.gif", "EM01aHMC_280b.gif", "EM01aHMC_281a.gif", "EM01aHMC_283a.gif", "EM01aHMC_284a.gif", "EM01aHMC_284b.gif", "EM01aHMC_285a.gif", "EM01aHMC_285b.gif", "EM01aHMC_288a.gif", "EM01aHMC_288b.gif", "EM01aHMC_28a.gif", "EM01aHMC_28b.gif", "EM01aHMC_290a.gif", "EM01aHMC_292a.gif", "EM01aHMC_292b.gif", "EM01aHMC_293a.gif", "EM01aHMC_293b.gif", "EM01aHMC_294a.gif", "EM01aHMC_295a.gif", "EM01aHMC_295b.gif", "EM01aHMC_295c.gif", "EM01aHMC_296a.gif", "EM01aHMC_297a.gif", "EM01aHMC_298a.gif", "EM01aHMC_299a.gif", "EM01aHMC_29a.gif", "EM01aHMC_2a.gif", "EM01aHMC_2b.gif", "EM01aHMC_2c.gif", "EM01aHMC_300a.gif", "EM01aHMC_301a.gif", "EM01aHMC_302a.gif", "EM01aHMC_303a.gif", "EM01aHMC_303b.gif", "EM01aHMC_304a.gif", "EM01aHMC_304b.gif", "EM01aHMC_304c.gif", "EM01aHMC_305a.gif", "EM01aHMC_305b.gif", "EM01aHMC_306a.gif", "EM01aHMC_306b.gif", "EM01aHMC_307a.gif", "EM01aHMC_308a.gif", "EM01aHMC_308b.gif", "EM01aHMC_309a.gif", "EM01aHMC_310a.gif", "EM01aHMC_311a.gif", "EM01aHMC_312a.gif", "EM01aHMC_313a.gif", "EM01aHMC_314a.gif", "EM01aHMC_318a.gif", "EM01aHMC_319a.gif", "EM01aHMC_31a.gif", "EM01aHMC_320a.gif", "EM01aHMC_321a.gif", "EM01aHMC_322a.gif", "EM01aHMC_323a.gif", "EM01aHMC_325a.gif", "EM01aHMC_327a.gif", "EM01aHMC_328a.gif", "EM01aHMC_328b.gif", "EM01aHMC_329a.gif", "EM01aHMC_329b.gif", "EM01aHMC_32a.gif", "EM01aHMC_32b.gif", "EM01aHMC_32c.gif", "EM01aHMC_330a.gif", "EM01aHMC_331a.gif", "EM01aHMC_332a.gif", "EM01aHMC_333a.gif", "EM01aHMC_334a.gif", "EM01aHMC_335a.gif", "EM01aHMC_336a.gif", "EM01aHMC_337a.gif", "EM01aHMC_338a.gif", "EM01aHMC_33a.gif", "EM01aHMC_33b.gif", "EM01aHMC_340a.gif", "EM01aHMC_341a.gif", "EM01aHMC_342a.gif", "EM01aHMC_343a.gif", "EM01aHMC_344a.gif", "EM01aHMC_345a.gif", "EM01aHMC_346a.gif", "EM01aHMC_347a.gif", "EM01aHMC_347b.gif", "EM01aHMC_348a.gif", "EM01aHMC_348b.gif", "EM01aHMC_349a.gif", "EM01aHMC_349b.gif", "EM01aHMC_34a.gif", "EM01aHMC_34b.gif", "EM01aHMC_34c.gif", "EM01aHMC_351a.gif", "EM01aHMC_351b.gif", "EM01aHMC_351c.gif", "EM01aHMC_352a.gif", "EM01aHMC_352b.gif", "EM01aHMC_353a.gif", "EM01aHMC_353b.gif", "EM01aHMC_354a.gif", "EM01aHMC_354b.gif", "EM01aHMC_355a.gif", "EM01aHMC_355b.gif", "EM01aHMC_358a.gif", "EM01aHMC_358b.gif", "EM01aHMC_35a.gif", "EM01aHMC_35b.gif", "EM01aHMC_35c.gif", "EM01aHMC_361a.gif", "EM01aHMC_362a.gif", "EM01aHMC_363a.gif", "EM01aHMC_363b.gif", "EM01aHMC_364a.gif", "EM01aHMC_364b.gif", "EM01aHMC_365a.gif", "EM01aHMC_365b.gif", "EM01aHMC_366a.gif", "EM01aHMC_367a.gif", "EM01aHMC_368a.gif", "EM01aHMC_369a.gif", "EM01aHMC_36a.gif", "EM01aHMC_370a.gif", "EM01aHMC_371a.gif", "EM01aHMC_372a.gif", "EM01aHMC_372b.gif", "EM01aHMC_373a.gif", "EM01aHMC_374a.gif", "EM01aHMC_374b.gif", "EM01aHMC_375a.gif", "EM01aHMC_376a.gif", "EM01aHMC_376b.gif", "EM01aHMC_377a.gif", "EM01aHMC_377b.gif", "EM01aHMC_378a.gif", "EM01aHMC_378b.gif", "EM01aHMC_378c.gif", "EM01aHMC_379a.gif", "EM01aHMC_379b.gif", "EM01aHMC_379c.gif", "EM01aHMC_37a.gif", "EM01aHMC_37b.gif", "EM01aHMC_380a.gif", "EM01aHMC_380b.gif", "EM01aHMC_381a.gif", "EM01aHMC_382a.gif", "EM01aHMC_382b.gif", "EM01aHMC_383a.gif", "EM01aHMC_383b.gif", "EM01aHMC_384a.gif", "EM01aHMC_384b.gif", "EM01aHMC_385a.gif", "EM01aHMC_386a.gif", "EM01aHMC_386b.gif", "EM01aHMC_387a.gif", "EM01aHMC_387b.gif", "EM01aHMC_388a.gif", "EM01aHMC_389a.gif", "EM01aHMC_38a.gif", "EM01aHMC_38b.gif", "EM01aHMC_390a.gif", "EM01aHMC_391a.gif", "EM01aHMC_391b.gif", "EM01aHMC_392a.gif", "EM01aHMC_393a.gif", "EM01aHMC_394a.gif", "EM01aHMC_395a.gif", "EM01aHMC_395b.gif", "EM01aHMC_397a.gif", "EM01aHMC_397b.gif", "EM01aHMC_398a.gif", "EM01aHMC_398b.gif", "EM01aHMC_39a.gif", "EM01aHMC_39b.gif", "EM01aHMC_3a.gif", "EM01aHMC_400a.gif", "EM01aHMC_400b.gif", "EM01aHMC_402a.gif", "EM01aHMC_403a.gif", "EM01aHMC_403b.gif", "EM01aHMC_404a.gif", "EM01aHMC_404b.gif", "EM01aHMC_405a.gif", "EM01aHMC_405b.gif", "EM01aHMC_405c.gif", "EM01aHMC_406a.gif", "EM01aHMC_406b.gif", "EM01aHMC_407a.gif", "EM01aHMC_408a.gif", "EM01aHMC_409a.gif", "EM01aHMC_409b.gif", "EM01aHMC_40a.gif", "EM01aHMC_40b.gif", "EM01aHMC_40c.gif", "EM01aHMC_410a.gif", "EM01aHMC_411a.gif", "EM01aHMC_411b.gif", "EM01aHMC_411c.gif", "EM01aHMC_412a.gif", "EM01aHMC_412b.gif", "EM01aHMC_413a.gif", "EM01aHMC_414a.gif", "EM01aHMC_414b.gif", "EM01aHMC_415a.gif", "EM01aHMC_416a.gif", "EM01aHMC_418a.gif", "EM01aHMC_419a.gif", "EM01aHMC_41a.gif", "EM01aHMC_41b.gif", "EM01aHMC_41c.gif", "EM01aHMC_420a.gif", "EM01aHMC_420b.gif", "EM01aHMC_420c.gif", "EM01aHMC_421a.gif", "EM01aHMC_421b.gif", "EM01aHMC_422a.gif", "EM01aHMC_422b.gif", "EM01aHMC_423a.gif", "EM01aHMC_424a.gif", "EM01aHMC_425a.gif", "EM01aHMC_426a.gif", "EM01aHMC_427a.gif", "EM01aHMC_428a.gif", "EM01aHMC_428b.gif", "EM01aHMC_428c.gif", "EM01aHMC_429a.gif", "EM01aHMC_429b.gif", "EM01aHMC_42a.gif", "EM01aHMC_430a.gif", "EM01aHMC_43a.gif", "EM01aHMC_44a.gif", "EM01aHMC_45a.gif", "EM01aHMC_46a.gif", "EM01aHMC_46b.gif", "EM01aHMC_47a.gif", "EM01aHMC_48a.gif", "EM01aHMC_49a.gif", "EM01aHMC_49b.gif", "EM01aHMC_49c.gif", "EM01aHMC_4a.gif", "EM01aHMC_4b.gif", "EM01aHMC_50a.gif", "EM01aHMC_50b.gif", "EM01aHMC_50c.gif", "EM01aHMC_51a.gif", "EM01aHMC_51b.gif", "EM01aHMC_51c.gif", "EM01aHMC_51d.gif", "EM01aHMC_52a.gif", "EM01aHMC_52b.gif", "EM01aHMC_52c.gif", "EM01aHMC_52d.gif", "EM01aHMC_53a.gif", "EM01aHMC_53b.gif", "EM01aHMC_53c.gif", "EM01aHMC_53d.gif", "EM01aHMC_54a.gif", "EM01aHMC_54b.gif", "EM01aHMC_54c.gif", "EM01aHMC_55a.gif", "EM01aHMC_56a.gif", "EM01aHMC_56b.gif", "EM01aHMC_56c.gif", "EM01aHMC_57a.gif", "EM01aHMC_57b.gif", "EM01aHMC_57c.gif", "EM01aHMC_58a.gif", "EM01aHMC_58b.gif", "EM01aHMC_58c.gif", "EM01aHMC_59a.gif", "EM01aHMC_59b.gif", "EM01aHMC_5a.gif", "EM01aHMC_61a.gif", "EM01aHMC_62a.gif", "EM01aHMC_62b.gif", "EM01aHMC_63a.gif", "EM01aHMC_63b.gif", "EM01aHMC_64a.gif", "EM01aHMC_65a.gif", "EM01aHMC_65b.gif", "EM01aHMC_65c.gif", "EM01aHMC_66a.gif", "EM01aHMC_66b.gif", "EM01aHMC_66c.gif", "EM01aHMC_68a.gif", "EM01aHMC_68b.gif", "EM01aHMC_69a.gif", "EM01aHMC_69b.gif", "EM01aHMC_6a.gif", "EM01aHMC_70a.gif", "EM01aHMC_72a.gif", "EM01aHMC_72b.gif", "EM01aHMC_72c.gif", "EM01aHMC_73a.gif", "EM01aHMC_73b.gif", "EM01aHMC_74a.gif", "EM01aHMC_74b.gif", "EM01aHMC_76a.gif", "EM01aHMC_77a.gif", "EM01aHMC_77b.gif", "EM01aHMC_77c.gif", "EM01aHMC_78a.gif", "EM01aHMC_78b.gif", "EM01aHMC_79a.gif", "EM01aHMC_79b.gif", "EM01aHMC_7a.gif", "EM01aHMC_80a.gif", "EM01aHMC_80b.gif", "EM01aHMC_81a.gif", "EM01aHMC_81b.gif", "EM01aHMC_82a.gif", "EM01aHMC_83a.gif", "EM01aHMC_83b.gif", "EM01aHMC_84a.gif", "EM01aHMC_84b.gif", "EM01aHMC_85a.gif", "EM01aHMC_86a.gif", "EM01aHMC_86b.gif", "EM01aHMC_87a.gif", "EM01aHMC_87b.gif", "EM01aHMC_88a.gif", "EM01aHMC_88b.gif", "EM01aHMC_89a.gif", "EM01aHMC_89b.gif", "EM01aHMC_8a.gif", "EM01aHMC_8b.gif", "EM01aHMC_90a.gif", "EM01aHMC_90b.gif", "EM01aHMC_90c.gif", "EM01aHMC_91a.gif", "EM01aHMC_91b.gif", "EM01aHMC_92a.gif", "EM01aHMC_92b.gif", "EM01aHMC_93a.gif", "EM01aHMC_93b.gif", "EM01aHMC_93c.gif", "EM01aHMC_94a.gif", "EM01aHMC_94b.gif", "EM01aHMC_95a.gif", "EM01aHMC_95b.gif", "EM01aHMC_96a.gif", "EM01aHMC_97a.gif", "EM01aHMC_97b.gif", "EM01aHMC_97c.gif", "EM01aHMC_99a.gif", "EM01aHMC_9a.gif", "EM01aHMC_9b.gif", "EM01b_89_177_1081_A.gif", "EM01b_89_177_1081_B.gif", "EM01b_89_177_1081_C.gif", "EM01b_89_177_1081_D.gif", "EM01b_89_177_1081_E.gif", "EM01b_89_177_1081_F.gif", "EM01b_89_177_1081_G.gif", "EM01b_89_177_1081_H.gif", "EM01b_89_177_1081_I.gif", "EM01b_89_177_1081_J.gif", "EM01b_89_177_1084_1_A.gif", "EM01b_89_177_1084_1_B.gif", "EM01b_89_177_1089_1_A.gif", "EM01b_89_177_1089_1_B.gif", "EM01b_89_177_1089_1_C.gif", "EM01b_89_177_1089_1_D.gif", "EM01b_89_177_1089_2_A.gif", "EM01b_89_177_1089_2_B.gif", "EM01b_89_177_1089_2_C.gif", "EM01b_89_177_1089_2_D.gif", "EM01b_89_177_1089_3_A.gif", "EM01b_89_177_1089_3_B.gif", "EM01b_89_177_1089_3_C.gif", "EM01b_89_177_1089_3_D.gif", "EM01b_89_177_1089_3_E.gif", "EM01b_89_177_1089_4_A.gif", "EM01b_89_177_1089_4_B.gif", "EM01b_89_177_1089_4_C.gif", "EM01b_89_177_1089_5_A.gif", "EM01b_89_177_1089_5_B.gif", "EM01b_89_177_1089_6_A.gif", "EM01b_89_177_1089_6_B.gif", "EM01b_89_177_1189_A.gif", "EM01b_89_177_1189_B.gif", "EM01b_89_177_1189_C.gif", "EM01b_89_177_1189_D.gif", "EM01b_89_177_1464_A.gif", "EM01b_89_177_1464_B.gif", "EM01b_89_177_1464_C.gif", "EM01b_89_177_1464_D.gif", "EM01b_89_177_1464_E.gif", "EM01b_89_177_1464_F.gif", "EM01b_89_177_154_A.gif", "EM01b_89_177_154_B.gif", "EM01b_89_177_154_C.gif", "EM01b_89_177_154_D.gif", "EM01b_89_177_154_E.gif", "EM01b_89_177_708_A.gif", "EM01b_89_177_708_B.gif", "EM01b_89_177_708_C.gif", "EM01b_89_177_971_A.gif", "EM01b_89_177_971_B.gif", "EM01b_89_177_976_A.gif", "EM01b_89_177_976_B.gif", "EM01b_89_177_976_C.gif", "EM01b_89_177_976_D.gif", "EM01b_89_177_976_E.gif", "EM01b_89_177_976_F.gif"];
			// APIdata.objectList.solrSearch.response.docs = [{"id": "EM01aHMC_102a.gif"},{ "id": "EM01aHMC_102b.gif"},{ "id": "EM01aHMC_103a.gif"},{ "id": "EM01aHMC_103b.gif"},{ "id": "EM01aHMC_104a.gif"},{ "id": "EM01aHMC_104b.gif"},{ "id": "EM01aHMC_105a.gif"},{ "id": "EM01aHMC_105b.gif"},{ "id": "EM01aHMC_105c.gif"},{ "id": "EM01aHMC_106a.gif"},{ "id": "EM01aHMC_107a.gif"},{ "id": "EM01aHMC_108a.gif"},{ "id": "EM01aHMC_108b.gif"},{ "id": "EM01aHMC_109a.gif"},{ "id": "EM01aHMC_109b.gif"},{ "id": "EM01aHMC_109c.gif"},{ "id": "EM01aHMC_109d.gif"},{ "id": "EM01aHMC_10a.gif"},{ "id": "EM01aHMC_10b.gif"},{ "id": "EM01aHMC_10c.gif"},{ "id": "EM01aHMC_110a.gif"},{ "id": "EM01aHMC_110b.gif"},{ "id": "EM01aHMC_110c.gif"},{ "id": "EM01aHMC_111a.gif"},{ "id": "EM01aHMC_112a.gif"},{ "id": "EM01aHMC_112b.gif"},{ "id": "EM01aHMC_113a.gif"},{ "id": "EM01aHMC_113b.gif"},{ "id": "EM01aHMC_113c.gif"},{ "id": "EM01aHMC_114a.gif"},{ "id": "EM01aHMC_114b.gif"},{ "id": "EM01aHMC_115a.gif"},{ "id": "EM01aHMC_115b.gif"},{ "id": "EM01aHMC_116a.gif"},{ "id": "EM01aHMC_116b.gif"},{ "id": "EM01aHMC_117a.gif"},{ "id": "EM01aHMC_118a.gif"},{ "id": "EM01aHMC_118b.gif"},{ "id": "EM01aHMC_119a.gif"},{ "id": "EM01aHMC_119b.gif"},{ "id": "EM01aHMC_119c.gif"},{ "id": "EM01aHMC_11a.gif"},{ "id": "EM01aHMC_120a.gif"},{ "id": "EM01aHMC_120b.gif"},{ "id": "EM01aHMC_121a.gif"},{ "id": "EM01aHMC_121b.gif"},{ "id": "EM01aHMC_121c.gif"},{ "id": "EM01aHMC_122a.gif"},{ "id": "EM01aHMC_122b.gif"},{ "id": "EM01aHMC_123a.gif"},{ "id": "EM01aHMC_124a.gif"}];
			// console.log(APIdata.objectList.solrSearch.response);
			// ******** TESTING VARIABLES *********
	  		$.ajax({          
			  url: 'templates/collectionResultObj.htm',      
			  dataType: 'html',            
			  async:false,
			  success: function(response){
			  	var template = response;
			  	var html = Mustache.to_html(template, APIdata.objectList.solrSearch.response.docs[i]);		  	
			  	$(".collection_contents").append(html);
			  }		  
			});
		 }

	}	
}

function populateCollectionsList(){

	//push results to collectionSelector
	for (var i = 0; i < APIdata.collectionsList.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/collectionsListObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.collectionsList.solrSearch.response.docs[i]);		  	
		  	$("select.form-control").append(html);

		  }		  
		});
	}	
}

function populateCollectionsView(){
	for (var i = 0; i < APIdata.collectionsList.solrSearch.response.docs.length; i++) {
		var collectionObject = APIdata.collectionsList.solrSearch.response.docs[i].id;
		collectionObject = "info:fedora/"+collectionObject;

		if ($(APIdata.collectionsCount.solrFacetSearch[collectionObject]).length) {
			APIdata.collectionsList.solrSearch.response.docs[i]['count'] = APIdata.collectionsCount.solrFacetSearch[collectionObject];
		}
		else {
			console.log("nothing");
		}

  		$.ajax({          
		  url: 'templates/collectionsViewObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.collectionsList.solrSearch.response.docs[i]);		  	
		  	$(".collection_contents").append(html);

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

//string contains
String.prototype.contains = function(it) { return this.indexOf(it) != -1; };
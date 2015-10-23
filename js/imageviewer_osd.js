// javascript for openseadragon viewer
// most dependencies are in inc/osd


function launch(imageParams){	

	console.log(imageParams);

	// retrieve / create symlink
	var APIcallURL = "/"+config.API_url+"?functions[]=singleObjectPackage&functions[]=fedDataSpy&PID="+imageParams.PID+"&DS="+imageParams.DS	
	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  	    
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){
		APIdata = response;		
		symlinks = APIdata.fedDataSpy		
		fireViewer(symlinks);
	}

	function callError(response){
		console.log("API Call unsuccessful.");	  
	}

}

function fireViewer(symlinks){	

	if (imageParams.debug != undefined && imageParams.debug == "true"){
		var debugStatus = true;
	}
	else{
		var debugStatus = false;
	}

	// SINGLE IMAGE
	if (APIdata.singleObjectPackage.parts_imageDict.sorted.length == 1){
		// single image array
		symlink_single = location.protocol+"//"+window.location.host+"/fcgi-bin/iipsrv.fcgi?DeepZoom="+symlinks.symlink+".dzi";

		var viewer = OpenSeadragon({
			id: "openseadragon1",
			prefixUrl: "inc/osd/images/",

			// Navigator
			showNavigator:  false,        
			
			// Debug
			debugMode:  debugStatus,
			
			// Input
			tileSources: symlink_single    	
		});	
	}


	// MULTIPLE IMAGES
	if (APIdata.singleObjectPackage.parts_imageDict.sorted.length > 1){
		/*
			Running loop of fedDataSpy() calls to generate JP2 links
			Viewer is generated when these finish
		*/

		// build symlink array
		var sorted = APIdata.singleObjectPackage.parts_imageDict.sorted;
		var promises = [];

		// run loop
		for (var i = 0; i < sorted.length; i++){

			// retrieve / create symlink
			var APIcallURL = "/"+config.API_url+"?functions[]=fedDataSpy&PID="+sorted[i]['pid']+"&DS="+sorted[i]['jp2']	
			var result = $.ajax({          
			url: APIcallURL,      
			dataType: 'json',	  	    
			});
			promises.push(result);

		}
		// when promises finished
		$.when.apply(null, promises).done(function(){
			
			var symlinks_array = [];

			// generate links in array
			for (var i=0; i < promises.length; i++){
				symlink = promises[i].responseJSON.fedDataSpy.symlink;
				symlinks_array.push(location.protocol+"//"+window.location.host+"/fcgi-bin/iipsrv.fcgi?DeepZoom="+symlink+".dzi")
			}

			// build viewer
			var viewer = OpenSeadragon({
				id: "openseadragon1",
				prefixUrl: "inc/osd/images/",

				// Navigator
				showNavigator:  false,        

				// Toolbar
				toolbar: 'toolbarDiv',
				
				// Debug
				debugMode:  debugStatus,
				
				// Input
				tileSources: symlinks_array,
				sequenceMode: true,
				showReferenceStrip: true,
				referenceStripScroll: 'vertical',
				preserveViewport: false, 
				springStiffness: 10

			});

		})

	}
		
	   
	// finish updating page
	updatePage();


}

function updatePage(){
	var DS_root = imageParams.DS.split("_JP2")[0];

	// set item_record_link
	$("#item_record_link").attr('href','item?id='+imageParams.PID);
	
	// set downloads
	$("#fullsize").attr('href','/imageServer?obj='+imageParams.PID+'&ds='+DS_root+'_ACCESS');
	$("#mediumsize").attr('href','/imageServer?obj='+imageParams.PID+'&ds='+DS_root+'_PREVIEW');
	
	// update title
	$("head title").html(APIdata.singleObjectPackage.objectSolrDoc.dc_title);

}
		



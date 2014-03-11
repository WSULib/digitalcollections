// javascript for openseadragon viewer
// most dependencies are in inc/osd

function launch(imageParams){	

	// retrieve / create symlink
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=solrGetFedDoc&functions[]=fedDataSpy&PID="+imageParams.PID+"&DS="+imageParams.DS	
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
		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}

}

function fireViewer(symlinks){	

	if (imageParams.debug != undefined && imageParams.debug == "true"){
		var debugStatus = true;
	}
	else{
		var debugStatus = false;
	}


	var viewer = OpenSeadragon({
        id: "openseadragon1",
        prefixUrl: "inc/osd/images/",
        showNavigator:  true,
        debugMode:  debugStatus,
    });
    viewer.openDzi("http://silo.lib.wayne.edu/fcgi-bin/iipsrv.fcgi?DeepZoom="+symlinks.dzi_symlink);
    updatePage();
}

function updatePage(){
	// set downloads
	$("#fullsize").attr('href','http://silo.lib.wayne.edu/imageServer?imgURL=http://silo.lib.wayne.edu/fedora/objects/'+imageParams.PID+'/datastreams/ACCESS/content');
	$("#mediumsize").attr('href','http://silo.lib.wayne.edu/imageServer?imgURL=http://silo.lib.wayne.edu/fedora/objects/'+imageParams.PID+'/datastreams/PREVIEW/content');

	// update title
	$("head title").html(APIdata.solrGetFedDoc.response.docs[0].dc_title);
}
		



// javascript for openseadragon viewer
// most dependencies are in inc/osd

function launch(imageParams){	

	// retrieve / create symlink
	var APIcallURL = "/WSUAPI?functions[]=solrGetFedDoc&functions[]=fedDataSpy&PID="+imageParams.PID+"&DS="+imageParams.DS	
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
        debugMode:  debugStatus
    });
    symlink_url = location.protocol+"//"+window.location.host+"/fcgi-bin/iipsrv.fcgi?DeepZoom="+symlinks.jp2_symlink+".dzi";    
    viewer.openDzi(symlink_url);
    updatePage();
}

function updatePage(){
	// set downloads
	$("#fullsize").attr('href','/imageServer?imgURL=http://127.0.0.1/fedora/objects/'+imageParams.PID+'/datastreams/ACCESS/content');
	$("#mediumsize").attr('href','/imageServer?imgURL=http://127.0.0.1/fedora/objects/'+imageParams.PID+'/datastreams/PREVIEW/content');

	// update title
	$("head title").html(APIdata.solrGetFedDoc.response.docs[0].dc_title);
}
		



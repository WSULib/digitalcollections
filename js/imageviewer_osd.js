// javascript for openseadragon viewer
// most dependencies are in inc/osd

function launch(imageParams){	

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
	var DS_root = imageParams.DS.split("_JP2")[0];
	// set downloads
	$("#fullsize").attr('href','/imageServer?obj='+imageParams.PID+'&ds='+DS_root+'_ACCESS');
	$("#mediumsize").attr('href','/imageServer?obj='+imageParams.PID+'&ds='+DS_root+'_PREVIEW');
	// update title
	$("head title").html(APIdata.singleObjectPackage.objectSolrDoc.dc_title);
}
		



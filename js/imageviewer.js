// dealings with iipsrv and MOO viewer
APIdata = {};


function launch(imageParams){	
	console.log(imageParams);
	
	// retrieve / create symlink
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=fedDataSpy&PID="+imageParams.PID+"&DS="+imageParams.DS
	console.log(APIcallURL);
	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  	    
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){
		APIdata = response;		
		symlink = APIdata.fedDataSpy.symlink
		console.log(symlink);
		fireViewer(symlink);
	}

	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}	
}

function fireViewer(symlink){
	// The iipsrv server path (/fcgi-bin/iipsrv.fcgi by default)
    var server = '/fcgi-bin/iipsrv.fcgi';

    // The *full* image path on the server. This path does *not* need to be in the web
    // server root directory.    
    var images = symlink    

    // Copyright or information message
    var credit = 'Wayne State University Libraries';

    // Create our viewer object
    // See documentation for more details of options
    var iipmooviewer = new IIPMooViewer( "viewer", {
		image: images,
		server: server,
		// credit: credit, 
		scale: 20.0, 
		showNavWindow: true,
		showNavButtons: true,
		winResize: true,
		protocol: 'iip',
		render:'random'
    });

    setDownloads();

}

function setDownloads(){
	$("#fullsize").attr('href','http://silo.lib.wayne.edu/imageServer?imgURL=http://silo.lib.wayne.edu/fedora/objects/'+imageParams.PID+'/datastreams/ACCESS/content');
	$("#mediumsize").attr('href','http://silo.lib.wayne.edu/imageServer?imgURL=http://silo.lib.wayne.edu/fedora/objects/'+imageParams.PID+'/datastreams/PREVIEW/content');
}
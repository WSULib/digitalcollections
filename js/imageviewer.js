// dealings with iipsrv and MOO viewer
APIdata = {};


function launch(imageParams){	
	console.log(imageParams);
	
	// retrieve / create symlink
	var APIcallURL = "/"+config.API_url+"?functions[]=solrGetFedDoc&functions[]=fedDataSpy&PID="+imageParams.PID+"&DS="+imageParams.DS
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
		console.log("API Call unsuccessful.");	  
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

    uploadPage();

}

function uploadPage(){
	// set downloads
	$("#fullsize").attr('href','/imageServer?obj='+imageParams.PID+'&ds=ACCESS');
	$("#mediumsize").attr('href','/imageServer?obj='+imageParams.PID+'&ds=PREVIEW');

	// update title
	$("head title").html(APIdata.solrGetFedDoc.response.docs[0].dc_title);
}
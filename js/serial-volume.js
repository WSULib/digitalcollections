// Javascript for serial-volume view

// GLOBALS

APIdata = new Object();


function launch(PID){
	// APIdata.searchParams = PID;
	// PID = PID['id'];
	APIdata.searchParams = {};
	APIdata.searchParams.id = PID;	
	// returns serial object metadata	
	var URL = "/WSUAPI?functions[]=getObjectXML&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&PID="+PID;
	var json = "http://jsonviewer.stack.hu/#";	
	$.ajax({          
		url: URL,      
		dataType: 'json',
		success: callSuccess,
		error: callError
	});

	function callSuccess(response){		
		APIdata.volumeMeta = response;
		
		// determine what collection(s) / publication it's from
		if (response.isMemberOfCollection.results.length > 1){
			bootbox.alert("uh-oh...");
		}
		else {
			var collectionPID = response.isMemberOfCollection.results[0].subject;
			serialWalk(collectionPID);
		}			
	}
	function callError(response){
		console.log("API Call unsuccessful.");		
	}
	
}

function serialWalk(PID){		
	var URL = "/WSUAPI?functions[]=getObjectXML&functions[]=serialWalk&functions[]=solrGetFedDoc&PID="+PID;
	var json = "http://jsonviewer.stack.hu/#";	
	$.ajax({          
		url: URL,      
		dataType: 'json',
		success: callSuccess,
		error: callError
	});

	function callSuccess(response){		
		APIdata.serialMeta = response;		

		//check object status
		if (APIdata.serialMeta.getObjectXML.object_status == "Inactive" || APIdata.serialMeta.getObjectXML.object_status == "Absent"){
		  loadError();
		}
		else{
	  		// render serialBlockNav
			renderSerialNavBlock();               
		}
			
	}

	function callError(response){
		console.log("API Call unsuccessful.");		
	}
	
}



function renderMain(){

	// Here's the set of issues for the current volume
	var volOfCurrentIssues = APIdata.searchParams.id;
	APIdata.serialMeta.currentIssues = APIdata.serialMeta.keyVols[volOfCurrentIssues];

	// Here's the current volume title
	APIdata.serialMeta.currentTitle = APIdata.serialMeta.volNames[volOfCurrentIssues];

	var templateData = new Object();

	$.ajax({                
		url: "templates/serial-volume-content.htm",      
		dataType: 'html',            
		async:true,
		success: function(response){        
			var template = response;
			var html = Mustache.to_html(template, APIdata);       
			$("#serial-volume-content").append(html);
		}     
	});
}

function loadError(){
	bootbox.alert("move me to utilities!  same goes for singleObject page.");
}
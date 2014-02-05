// Javascript for serial-volume view

// GLOBALS

APIdata = new Object();


function launch(PID){
	APIdata.searchParams = PID;
	PID = PID['id'];
	// returns serial object metadata	
	var URL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=getObjectXML&functions[]=serialWalk&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&PID="+PID;
	var json = "http://jsonviewer.stack.hu/#";
	console.log(json+URL);
	$.ajax({          
		url: URL,      
		dataType: 'json',
		success: callSuccess,
		error: callError
	});

	function callSuccess(response){
		console.log("Serial metadata response:",response);  
		APIdata.serialMeta = response;
		// put searchParams in serialMeta for consistency
		APIdata.serialMeta.searchParams = APIdata.searchParams;

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
	var volOfCurrentIssues = APIdata.serialMeta.searchParams.vol;
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
	alert("move me to utilities!  same goes for singleObject page.");
}
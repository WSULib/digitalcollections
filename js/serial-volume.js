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
	var currentIssues = APIdata.serialMeta.searchParams.vol;
	APIdata.serialMeta.currentIssues = APIdata.serialMeta.keyVols[currentIssues];

	// Here's the current title
	// Currently, it's clunky as it iterates through all matches (matches = number of issues in current volume); maybe use .each()
	var len = APIdata.serialMeta.serialWalk.results.length;
	for(var i =0; i < len; i++) {
		if (currentIssues == APIdata.serialMeta.serialWalk.results[i].volume) {
			APIdata.serialMeta.currentTitle = APIdata.serialMeta.serialWalk.results[i].volumeTitle;
		}
	}

	// Break out Volume from Title and set it inside APIdata.SerialMeta as currentVolume
	// Set pattern to compare complete title against
	var pattern = APIdata.serialMeta.solrGetFedDoc.response.docs[0].dc_title[0];
	var completeTitle = APIdata.serialMeta.currentTitle;
	// Extract out the volume from the complete title and then remove whitespace
	var volume = completeTitle.replace(pattern, "");
	// var whitespaceRemoval = new RegExp(' ');
	volume = volume.replace(new RegExp(' '), "");
	APIdata.serialMeta.currentVolume = volume;

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
// JS FILE FOR SERIAL MAIN PAGE

// GLOBALS

APIdata = new Object();


function launch(PID){
	
	// returns serial object metadata	
	var URL = "http://silo.lib.wayne.edu/WSUAPI-dev?functions[]=getObjectXML&functions[]=serialWalk&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&PID="+PID;

	$.ajax({          
		url: URL,      
		dataType: 'json',
		success: callSuccess,
		error: callError
	});

	function callSuccess(response){
		console.log("Serial metadata response:",response);		
		APIdata.serialMeta = response;
		APIdata.serialMeta.cleanVols = cleanSerialWalk(response.serialWalk.results);		
		APIdata.counter = new Object();
		APIdata.counter = {
			'val':1,
			'count' : function () {
            return function (text, render) {
	                // note that counter is in the enclosing scope
	                return APIdata.counter.val++;	                	                
            	}
        	}
    	}

		//check object status
		if (APIdata.serialMeta.getObjectXML.object_status == "Inactive" || APIdata.serialMeta.getObjectXML.object_status == "Absent"){
			loadError();
		}
		else{
	  		// render serialBlockNav
			renderSerialNavBlock();
			// render serial-root-content
			renderMain();
		}
			
	}

	function callError(response){
		console.log("API Call unsuccessful.");		
	}
	
}

function cleanSerialWalk(results){

	var vols = {};
	var volsArray = [];	
	var sortingArray = [];
	for (var i=0; i<results.length; i++){
		var node = results[i];
		if (sortingArray.indexOf(node.volume) == -1){
			sortingArray.push(node.volume);
		}			
		if (vols.hasOwnProperty(node.volume) == false ){
			vols[node.volume] = [];
			var temp = [];
			temp.push(node.issue,node.issueTitle);
			vols[node.volume].push(temp);			
		}
		else{
			var temp = [];
			temp.push(node.issue,node.issueTitle);
			vols[node.volume].push(temp);
		}
	}	
	
	sortingArray.alphanumSort();
	APIdata.sortingArray = sortingArray;
	console.log(APIdata.sortingArray);
	
	// pluck to array
	for (var i=0; i<APIdata.sortingArray.length; i++){
		volsArray.push(vols[APIdata.sortingArray[i]])
	}

	return volsArray;
}


function renderSerialNavBlock(){

	$.ajax({                
		url: "templates/serial-nav.htm",      
		dataType: 'html',            
		async:true,
		success: function(response){        
			var template = response;
			var html = Mustache.to_html(template, APIdata);       
			$("#serial-nav").append(html);
		}     
	});

}

function renderMain(){	

	$.ajax({                
		url: "templates/serial-root-content.htm",      
		dataType: 'html',            
		async:true,
		success: function(response){        
			var template = response;
			var html = Mustache.to_html(template, APIdata);       
			$("#serial-root-content").append(html);
		}     
	});
}


function loadError(){
	alert("move me to utilities!  same goes for singleObject page.");
}















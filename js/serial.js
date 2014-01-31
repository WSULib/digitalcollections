// JS FILE FOR SERIAL MAIN PAGE

// GLOBALS

APIdata = new Object();


function launch(PID){
	
	// returns serial object metadata	
	var URL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=getObjectXML&functions[]=hasMemberOf&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&PID="+PID;

	$.ajax({          
		url: URL,      
		dataType: 'json',
		success: callSuccess,
		error: callError
	});

	function callSuccess(response){
		console.log("Serial metadata response:",response);  
		APIdata.serialMeta = response;

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




function renderSerialNavBlock(){

	// get 2nd level objects, volumes for now
	// use nested templates?

	var templateData = new Object();

	$.ajax({                
		url: "templates/serial-nav.htm",      
		dataType: 'html',            
		async:true,
		success: function(response){        
			var template = response;
			var html = Mustache.to_html(template, templateData);       
			$("#serial-nav").append(html);
		}     
	});

}

function renderMain(){


	var templateData = new Object();

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















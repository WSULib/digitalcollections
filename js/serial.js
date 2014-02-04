// JS FILE FOR SERIAL MAIN PAGE

// GLOBALS
APIdata = new Object();


function launch(PID){
	
	// returns serial object metadata	
	var URL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=getObjectXML&functions[]=serialWalk&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&PID="+PID;	

	$.ajax({          
		url: URL,      
		dataType: 'json',
		success: callSuccess,
		error: callError
	});

	function callSuccess(response){		
		APIdata.serialMeta = response;		
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
	  		// render serialBlockNav, also fires renderMain() as defined locally
			renderSerialNavBlock();			
		}
			
	}

	function callError(response){
		console.log("API Call unsuccessful.");		
	}
	
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















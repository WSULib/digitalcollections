// JS FILE FOR SERIAL MAIN PAGE

// GLOBALS
APIdata = new Object();


function launch(PID){
	
	// returns serial object metadata	
	var URL = "/WSUAPI-dev?functions[]=getObjectXML&functions[]=serialWalk&functions[]=isMemberOfCollection&functions[]=solrGetFedDoc&PID="+PID;	

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
			cleanEmptyMetaRows();
		}     
	});
}


function loadError(){
	bootbox.alert("move me to utilities!  same goes for singleObject page.");
}














// Add Item to Favorites
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function addFav(){    
    if (typeof userData.username_WSUDOR != "undefined"){
      // stringify user / item / search object, send to solrAddDoc API function  
      var addDoc = new Object();
      addDoc.id = userData.username_WSUDOR+"_"+APIdata.APIParams.PID
      addDoc.fav_user = userData.username_WSUDOR;
      addDoc.fav_item = APIdata.APIParams.PID;
      var jsonAddString = "["+JSON.stringify(addDoc)+"]";
      // console.log(jsonAddString);

      var APIaddURL = "/WSUAPI?functions[]=solrAddDoc&raw="+jsonAddString;
      // console.log(APIaddURL);

      $.ajax({          
        url: APIaddURL,      
        dataType: 'json',
        success: callSuccess,
        error: callError
      });

      function callSuccess(response){
        // console.log(response);
        if (response.solrAddDoc.responseHeader.status == 0){
          $('li.add-to-favorites').html('<img src="img/star.png" alt=""> Added to Favorites');
          bootbox.alert("Added to favorites");
          window.setTimeout(function(){
            bootbox.hideAll();
          }, 3000);
          // .addClass('favorited');
        }
        else {
          bootbox.alert("Error");
        }
      }
      function callError(response){
        // console.log(response);
        bootbox.alert("Error.");
      }
    }
  else {
    bootbox.alert("User not found.  Please login or sign up to save favorites.");
  }  
}
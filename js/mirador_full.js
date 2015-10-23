// mirador full js
/*
	10/23/2015
	The following JS is designed to sit on top of Mirador and provide some additioanl functionality.  
	With Mirador 2.1 on the way, our approach is to overlay limited functionality now, that may 
	appear in code later.
*/


// canvas ID changed, update download links and title
var canvasIDChange = function (oldCanvas, newCanvas) {

	// Mirador window handle
	var win = Mirador.viewer.workspace.windows[0];
	
	// extract current canvas from manifest
	var current_canvases = [];
    for (var i = 0; i < win.imagesList.length; i++) {
    	if ( win.imagesList[i]['@id'] == newCanvas){

    		if (win.currentFocus == "ImageView"){
    			win.imagesList[i].image_type = "single image";
    			current_canvases.push(win.imagesList[i]);
    			break;	
    		}    		

    		else if (win.currentFocus == "BookView"){

    			// determine the index of current canvas from focusImages
    			// adjusts if second page is clicked, offseting i - 1
    			if (win.focusImages.indexOf(newCanvas) == 1){
    				console.log('offsetting...');
    				i = i - 1;
    			}
    			if (i == 0){
    				win.imagesList[i].image_type = "first page";	
    			}
    			else if (i == (win.imagesList.length - 1)){
    				win.imagesList[i].image_type = "last page";
    			}
    			else {
    				win.imagesList[i].image_type = "left page";
    			}
    			current_canvases.push(win.imagesList[i]);    			
    			if (i != 0 && i != (win.imagesList.length - 1)){
    				win.imagesList[i+1].image_type = "right page";
    				current_canvases.push(win.imagesList[i+1]);	
    			}    			
    			break;
    		}    		
    	}
	}
	console.log("Current Canvases",current_canvases)
    
    // // parse ID
    // canvasID = newCanvas.split("/")[4].slice(7,-5);
    // PID = canvasID.split("|")[0]
    // DS = canvasID.split("|")[1]

    // fire work
    updateDownloads(current_canvases);

};


function updateDownloads(current_canvases){

	$(".fullsize_download ul").empty();

	for (var i = 0; i < current_canvases.length; i++) {
		cc = current_canvases[i];		
		$(".fullsize_download ul").append('<li><a target="_blank" href="'+cc.images[0].resource['@id']+'">download '+cc.image_type+' ('+cc.width+' x '+cc.height+')</a></li>');		
	};

}


/* On load, listen wait for Mirador object to be created */
var checkExist = setInterval(function() {
	if (Mirador) {

		// setting listener for current canvas change
		var intervalH = setInterval( watch(Mirador.viewer.workspace.windows[0], "currentCanvasID", canvasIDChange), 250);
		
		// other listener(s)
		// CONSIDER DRAWING ELEMENTS LIKE DOWNLOAD FROM HERE

		// run some functions for first time
		canvasIDChange(false, Mirador.viewer.workspace.windows[0].currentCanvasID);

		// finally, clear this intervaled check
		clearInterval(checkExist);
		
	}
	
}, 100); // check every 100ms


/* Utility to listen to object property changes */
function watch(obj, prop, handler) { // make this a framework/global function
    var currval = obj[prop];
    function callback() {
        if (obj[prop] != currval) {
            var temp = currval;
            currval = obj[prop];
            handler(temp, currval);
        }
    }
    return callback;
}
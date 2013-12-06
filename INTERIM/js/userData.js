// User Accounts

// NOT TERRIBLY IMPORTANT ANYMORE, CONSIDER PHASING OUT, HAVE 'WSUDOR' COOKIE NOW
// The 'userData' object then becomes available to all views that load this JS 
var userData = new Object();
// var extractData = $.cookie('validUser');
// if (typeof extractData != 'undefined'){
// 	extractData= extractData.split(":");
// 	userData.accessID_libCookie = extractData[1];	
// 	if (typeof userData.accessID_libCookie != 'undefined') {
// 		userData.loggedIn_libCookie = true;
// 	}
// 	else {
// 		userData.loggedIn_libCookie = false;
// 	}
// }
// else{
// 	userData.loggedIn_libCookie = false;
// }

// check WSUDOR cookie
$(document).ready(function(){
	console.log("Checking WSUDOR cookie");
	if (typeof $.cookie("WSUDOR") != 'undefined'){
		WSUDORcookie = $.parseJSON($.cookie("WSUDOR"));
		console.log(WSUDORcookie);      
		userData.username_WSUDOR = WSUDORcookie.username_WSUDOR;
		userData.loggedIn_WSUDOR = WSUDORcookie.loggedIn_WSUDOR;
		userData.displayName = WSUDORcookie.displayName;

		if (userData.loggedIn_WSUDOR == true){      			
			$("#login_status").html("<a onclick='$.removeCookie(\"WSUDOR\"); location.reload();' href='#'>Welcome "+userData.displayName+"! (Logout)</a>");
		}  
	}           
});
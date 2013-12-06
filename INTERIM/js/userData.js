// User Accounts

//Global 
var userData = new Object();


// NOT TERRIBLY IMPORTANT ANYMORE, CONSIDER PHASING OUT, HAVE 'WSUDOR' COOKIE NOW
//////////////////////////////////////////////////////////////////////////////////////////
// The 'userData' object then becomes available to all views that load this JS 
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
//////////////////////////////////////////////////////////////////////////////////////////


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
			// $("#login_status").html("Welcome "+userData.displayName+"! <a onclick='$.removeCookie(\"WSUDOR\"); location.reload();' href='#'>(Logout)</a>");
			$("#login_status").html("Welcome "+userData.displayName+"! <a onclick='logoutUser(); return false;' href='#'>(Logout)</a>");
			$("#login_status").parent().append("<li><a href='favorites.php' id='fav_link'>Favorites</a></li>");
		}  
	}           
});

function logoutUser(){
	$.removeCookie("WSUDOR");
	// $("#fav_link").remove(); 
	location.reload();
}
// User Accounts

//Global 
var userData = new Object();


// check WSUDOR cookie
$(document).ready(function(){
	console.log("Checking WSUDOR cookie");
	if (typeof $.cookie("WSUDOR") != 'undefined'){
		WSUDORcookie = $.parseJSON($.cookie("WSUDOR"));
		console.log(WSUDORcookie);      
		userData.username_WSUDOR = WSUDORcookie.username_WSUDOR;
		userData.loggedIn_WSUDOR = WSUDORcookie.loggedIn_WSUDOR;
		userData.displayName = WSUDORcookie.displayName;
		userData.clientHash = WSUDORcookie.clientHash;

		if (userData.loggedIn_WSUDOR == true){

			var postData = new Object();
			postData.username = userData.username_WSUDOR;
			postData.clientHash = userData.clientHash;
			var APIaddURL = "http://silo.lib.wayne.edu/WSUAPI-dev?functions[]=cookieAuth";
			console.log(APIaddURL);
			$.ajax({          
				url: APIaddURL,
				type: "POST",
				data: postData,      
				dataType: 'json',
				success: function(response){
				  console.log("cookieAuth response:");
				  console.log(response);
				  if (response.cookieAuth.hashMatch == false || typeof(response.cookieAuth.hashMatch) == "undefined"){
				  	console.log("Attack!  Attack!  Deleting cookie and refreshing.");
				  	logoutUser();				  	
				  }
				  
				},
				error: function(response){
				  console.log(response);
				  // alert("userData Error.");
				}
			});			

			$("li.login_status").html("Welcome "+userData.displayName+"! <a onclick='logoutUser(); return false;' href='#'>(Logout)</a>");
			$("li.sidr-class-login_status").html("<a onclick='logoutUser(); return false;' href='#'>Logout</a>");
			$('nav ul li:eq(2)').before("<li><a href='favorites.php' id='fav_link'>Favorites</a></li>");
			$('#sidr-main nav ul li:eq(2)').before("<li><a href='favorites.php' id='fav_link'>Favorites</a></li>");
		}  
	}      
	else {
		userData.loggedIn_WSUDOR = false;
	}     
});

function logoutUser(){
	$.removeCookie("WSUDOR",{
          path:"/"
        }
    );
	// $("#fav_link").remove(); 
	location.reload();
}
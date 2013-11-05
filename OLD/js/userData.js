// User Data
// This is where cookie analysis can happen
// The 'userData' object then becomes available to all views that load this JS

var userData = new Object();
var extractData = $.cookie('validUser');
extractData= extractData.split(":");
userData.accessID = extractData[1];
if (typeof userData.accessID != 'undefined') {
	userData.loggedIn = true;
}
else {
	userData.loggedIn = false;
}
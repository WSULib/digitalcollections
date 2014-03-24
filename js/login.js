// Controller for Login Page

// Globals
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var APIdata = new Object();
var userPackage = new Object();

// Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function loginGo(){
  $("#messages_container").append("<p>Starting login process.</p>");
}

function loginForm(){

  var postData = new Object();
  postData.username = $("#username").val();
  postData.password = $("#password").val();

  // check WSUDOR status    
  var APIcallURL = "/WSUAPI?functions[]=userSearch";  
  $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,            
      success: function(response){
        // console.log('result of WSUDOR account check:');            
        APIdata.loginWSUDORCheck = response;
        // console.log(APIdata.loginWSUDORCheck);
        
        // WSUDOR account not found 
        if (APIdata.loginWSUDORCheck.userSearch.extant == false){
          // console.log("No WSUDOR account. Yet...")
          // next step checking for LDAP 
          // console.log("checking LDAP for account, then credentials.");
          var APIcallURL = "/WSUAPI?functions[]=authUser";    
          $.ajax({    
            type: "POST",      
            url: APIcallURL,      
            dataType: 'json',
            data: postData,         
            success: function(response){        
              // console.log("LDAPCredCheck response:")
              APIdata.LDAPCredCheck = response;     
              // console.log(APIdata.LDAPCredCheck);

              // this scenario fires for first time LDAP creation
              if (typeof (APIdata.LDAPCredCheck.authUser.desc) == 'undefined' && APIdata.LDAPCredCheck.authUser.LDAP_result_set[0].length > 1){
                // console.log("LDAP credentials confirmed.  Creating WSU account on-the-fly.")
                // in this case, create account on-the-fly, and set cookie
                createAccountPrep('LDAPDefined');
              }
              else {
                // console.log("LDAP credentials don't jive.");  
                denyAccess();
              }
            },
            error: function(response){
              // console.log(response);
            }
          });
        } 
        // WSUDOR account found       
        else {          
          // console.log("WSUDOR account found.");          
          // WSU affiliated
          if (APIdata.loginWSUDORCheck.userSearch.user_WSU == true ){
            // console.log("WSU affilated. Check password against LDAP.");
            checkLDAPPassword();
          }
          // Community / Public
          else {
            // console.log("Community / Public.  Check password against WSUDOR.");
            checkWSUDORPassword();
          }
        }
      },
      error: function(response){
        // console.log("Error encountered.");
      }
    });

  // check WSUDOR credentials (not LDAP account)
  function checkWSUDORPassword(){
    // console.log("checking WSUDOR password.");  
    // console.log(postData);

    var APIcallURL = "/WSUAPI?functions[]=WSUDORuserAuth";    
    $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,         
      success: function(response){        
        // console.log("WSUDOR password check response:")
        APIdata.passwordWSUDORcheck = response;
        // console.log(APIdata.passwordWSUDORcheck);
        if (APIdata.passwordWSUDORcheck.WSUDORuserAuth.WSUDORcheck == true) {
          // console.log("WSUDOR credentials check out.")
          grantAccess(postData.username,APIdata.passwordWSUDORcheck.WSUDORuserAuth.clientHash);
        }
        else {
          // console.log("WSUDOR credentials don't match.")
          denyAccess();
        }

      },
      error: function(response){
        // console.log(response);
      }
    });
  }

  // check LDAP credentials (trumps WSUDOR account)
  function checkLDAPPassword(){
    // console.log("checking LDAP password.");
    var APIcallURL = "/WSUAPI?functions[]=authUser";    
    $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,         
      success: function(response){        
        // console.log("LDAPCredCheck response:")
        APIdata.LDAPCredCheck = response;     
        // console.log(APIdata.LDAPCredCheck);

        if (typeof (APIdata.LDAPCredCheck.authUser.desc) == 'undefined' && APIdata.LDAPCredCheck.authUser.LDAP_result_set[0].length > 1){
          // console.log("LDAP credentials confirmed.")
          grantAccess(APIdata.LDAPCredCheck.authUser.LDAP_result_set[0][1].uid[0],APIdata.LDAPCredCheck.authUser.clientHash);
        }
        else {
          // console.log("LDAP credentials don't jive.");  
          denyAccess();
        }
      },
      error: function(response){
        // console.log(response);
      }
    });
  }

}
  
// create Account Prep
function createAccountPrep(type){

  // special case, on-the-fly
  if (type == "LDAPDefined"){
    // set params for solr account creation
    var params = new Object();
    params.user_displayName = APIdata.LDAPCredCheck.authUser.LDAP_result_set[0][1].givenName[0];
    params.user_username = APIdata.LDAPCredCheck.authUser.LDAP_result_set[0][1].uid[0]
    params.user_password = ""
    params.user_WSU = 1;

    createAccount(params,"LDAPDefined");
  }

  if (type == "userDefined"){
    var params = new Object();
    params.user_displayName = $("#create_displayName").val();
    params.user_username = $("#create_username").val();
    params.user_password = $("#create_password").val();  
    params.user_WSU = 0;

    // check username availability in WSUDOR
    var APIcallURL = "/WSUAPI?functions[]=userSearch";
    var postData = new Object();
    postData.username = params.user_username;
    $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,         
      success: function(response){
        APIdata.userSearch = response;
        // console.log(response);      
        if (APIdata.userSearch.userSearch.extant == true){
          // console.log("Username not available in WSUDOR.");
          createAccountFail();
        }
        else {
          // console.log("WSUDOR username available.");          
          
          // check username in LDAP via anonymous call
          var APIcallURL = "/WSUAPI?functions[]=getUserInfo";
          var postData = new Object();
          postData.username = params.user_username;
          $.ajax({    
            type: "POST",      
            url: APIcallURL,      
            dataType: 'json',
            data: postData,         
            success: function(response){
              // console.log("LDAP user check...");
              APIdata.LDAPcheck = response;
              // console.log(APIdata.LDAPcheck);
              if (typeof APIdata.LDAPcheck.getUserInfo.desc != "undefined"){
                // console.log("Username not used in LDAP")
                createAccount(params,"userDefined");
              }              
              else {
                // console.log("Username used in LDAP, cannot create account with this name.");
                createAccountFail("This appears to be a WSU login, try logging in with this information above!");
              }
            },
            error: function (response){
              // console.log("LDAP username check unsuccessful");;    
            }
          });
          
        }
      },
      error: function (response){
        // console.log("WSUDOR username check unsuccessful.");    
      }
    });    
  }


}


// Create Account
function createAccount(params,type){  
  // console.log("Account to be created with these params: ");
  // console.log(params);
  
  // check for displayName
  if (params.user_displayName == ""){
    // console.log("No displayName provided.");
    createAccountFail();
    return;
  }

  // check for username
  if (params.user_username == ""){
    // console.log("No username provided.");
    createAccountFail();
    return;
  }

  // check for password
  if (params.user_password == "" && params.user_WSU == 0){
    // console.log("No password provided.");
    createAccountFail();
    return;
  }
  
  params.id = params.user_username;
  var postData = params;

  var APIaddURL = "/WSUAPI?functions[]=createUserAccount";
  // console.log(APIaddURL);

  $.ajax({          
    url: APIaddURL,
    type: "POST",
    data: postData,      
    dataType: 'json',
    success: function(response){
      // console.log("This is what you have to work with for creating account:",response);

      if (response.createUserAccount.createResponse.responseHeader.status == 0){      
        createAccountSuccess(params.user_username,response.createUserAccount.clientHash);
      }
      else {
        bootbox.alert("Account Creation Error");
      }
    },
    error: function(response){
      // console.log(response);
      bootbox.alert("Error.");
    }
  });  
}


// Reusable
////////////////////////////////////////////////////////////////////////////////////

function denyAccess(){  
  $("#messages_container").append("<p style='color:red;'>Access Denied.</p>");
  bootbox.alert("Login credentials don't match, please try again.");
}

function grantAccess(username,clientHash){
  $("#messages_container").append("<p style='color:green;'>Access Permitted for "+username+".  Setting Cookie.</p>");       
  setWSUDORCookie(username,clientHash);
}

function createAccountSuccess(username,clientHash){
  $("#messages_container").append("<p style='color:green;'>Account Created.  Setting Cookie.</p>"); 
  grantAccess(username,clientHash);      
}

function createAccountFail(message){
  $("#messages_container").append("<p style='color:red;'>Could Not Create Account.</p>");
  bootbox.alert("Could not create account.");
  if (typeof message != 'undefined'){
    $("#messages_container").append("<p style='color:red;'>"+message+"</p>");
  }      
}

/* Need to rework this such that you pass username AND clientHash from userSearch() call.*/
function setWSUDORCookie(username,clientHash){
  // console.log("setting WSUDOR cookie for "+username);
  // hit WSUDOR for displayName
  // check WSUDOR status    
  var APIcallURL = "/WSUAPI?functions[]=userSearch";  
  var postData = new Object ();
  postData.username = username;  
  $.ajax({    
    type: "POST",      
    url: APIcallURL,      
    dataType: 'json',
    data: postData,            
    success: function(response){
      // console.log(response);
      userData.displayName = response.userSearch.displayName;
      userData.loggedIn_WSUDOR = true;  
      userData.username_WSUDOR = username;
      // pull clientHash from authUser() *LDAP function, or WSUDORuserAuth();
      userData.clientHash = clientHash;

      // console.log("userData:",userData);

      $.cookie("WSUDOR", JSON.stringify(userData),{
          path:"/"
        }
      );
      // navigate back
      navBack();
    },
    error:function(response){
      // console.log("Could not retrieve displayName for cookie purposes");
    }
  });  
}

function navBack(){
  if (document.referrer == ""){
    bootbox.alert("You are now logged into WSU digitalcollections.", function(){
      window.history.back();
    });
  }
  else{
    bootbox.alert("You are now logged into WSU digitalcollections.", function(){
      window.location = document.referrer;
    });
    
  }
}











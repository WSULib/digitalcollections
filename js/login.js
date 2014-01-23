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
  var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=userSearch";  
  $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,            
      success: function(response){
        console.log('result of WSUDOR account check:');            
        APIdata.loginWSUDORCheck = response;
        console.log(APIdata.loginWSUDORCheck);
        // WSUDOR account not found 
        if (APIdata.loginWSUDORCheck.userSearch.extant == false){
          console.log("No WSUDOR account. Yet...")
          // next step checking for LDAP 
          console.log("checking LDAP for account, then credentials.");
          var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=authUser";    
          $.ajax({    
            type: "POST",      
            url: APIcallURL,      
            dataType: 'json',
            data: postData,         
            success: function(response){        
              console.log("LDAPCredCheck response:")
              APIdata.LDAPCredCheck = response;     
              console.log(APIdata.LDAPCredCheck);

              if (typeof (APIdata.LDAPCredCheck.authUser.desc) == 'undefined' && APIdata.LDAPCredCheck.authUser[0].length > 1){
                console.log("LDAP credentials confirmed.  Creating WSU account on-the-fly.")
                // in this case, create account on-the-fly, and set cookie
                createAccountPrep('LDAPDefined');
              }
              else {
                console.log("LDAP credentials don't jive.");  
                denyAccess();
              }
            },
            error: function(response){
              console.log(response);
            }
          });
        }        
        else {          
          console.log("WSUDOR account found.");          
          // WSU affiliated
          if (APIdata.loginWSUDORCheck.userSearch.user_WSU == true ){
            console.log("WSU affilated. Check password against LDAP.");
            checkLDAPPassword();
          }
          // Community / Public
          else {
            console.log("Community / Public.  Check password against WSUDOR.");
            checkWSUDORPassword();
          }
        }
      },
      error: function(response){
        console.log("Error encountered.");
      }
    });

  // check WSUDOR credentials (not LDAP account)
  function checkWSUDORPassword(){
    console.log("checking WSUDOR password.");  
    console.log(postData);

    var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=WSUDORuserAuth";    
    $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,         
      success: function(response){        
        console.log("WSUDOR password check response:")
        APIdata.passwordWSUDORcheck = response;
        console.log(APIdata.passwordWSUDORcheck);
        if (APIdata.passwordWSUDORcheck.WSUDORuserAuth.WSUDORcheck == true) {
          console.log("WSUDOR credentials check out.")
          grantAccess(postData.username);
        }
        else {
          console.log("WSUDOR credentials don't match.")
          denyAccess();
        }

      },
      error: function(response){
        console.log(response);
      }
    });
  }

  // check LDAP credentials (trumps WSUDOR account)
  function checkLDAPPassword(){
    console.log("checking LDAP password.");
    var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=authUser";    
    $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,         
      success: function(response){        
        console.log("LDAPCredCheck response:")
        APIdata.LDAPCredCheck = response;     
        console.log(APIdata.LDAPCredCheck);

        if (typeof (APIdata.LDAPCredCheck.authUser.desc) == 'undefined' && APIdata.LDAPCredCheck.authUser[0].length > 1){
          console.log("LDAP credentials confirmed.")
          grantAccess(APIdata.LDAPCredCheck.authUser[0][1].uid[0]);
        }
        else {
          console.log("LDAP credentials don't jive.");  
          denyAccess();
        }
      },
      error: function(response){
        console.log(response);
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
    params.user_displayName = APIdata.LDAPCredCheck.authUser[0][1].givenName[0];
    params.user_username = APIdata.LDAPCredCheck.authUser[0][1].uid[0]
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
    var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=userSearch";
    var postData = new Object();
    postData.username = params.user_username;
    $.ajax({    
      type: "POST",      
      url: APIcallURL,      
      dataType: 'json',
      data: postData,         
      success: function(response){
        APIdata.userSearch = response;
        console.log(response);      
        if (APIdata.userSearch.userSearch.extant == true){
          console.log("Username not available in WSUDOR.");
          createAccountFail();
        }
        else {
          console.log("WSUDOR username available.");          
          
          // check username in LDAP via anonymous call
          var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=getUserInfo";
          var postData = new Object();
          postData.username = params.user_username;
          $.ajax({    
            type: "POST",      
            url: APIcallURL,      
            dataType: 'json',
            data: postData,         
            success: function(response){
              console.log("LDAP user check...");
              APIdata.LDAPcheck = response;
              console.log(APIdata.LDAPcheck);
              if (typeof APIdata.LDAPcheck.getUserInfo.desc != "undefined"){
                console.log("Username not used in LDAP")
                createAccount(params,"userDefined");
              }              
              else {
                console.log("Username used in LDAP, cannot create account with this name.");
                createAccountFail("This appears to be a WSU login, try logging in with this information above!");
              }
            },
            error: function (response){
              console.log("LDAP username check unsuccessful");;    
            }
          });
          
        }
      },
      error: function (response){
        console.log("WSUDOR username check unsuccessful.");    
      }
    });    
  }


}


// Create Account
function createAccount(params,type){  
  console.log("Account to be created with these params: ");
  console.log(params);
  
  // check for displayName
  if (params.user_displayName == ""){
    console.log("No displayName provided.");
    createAccountFail();
    return;
  }

  // check for username
  if (params.user_username == ""){
    console.log("No username provided.");
    createAccountFail();
    return;
  }

  // check for password
  if (params.user_password == "" && params.user_WSU == 0){
    console.log("No password provided.");
    createAccountFail();
    return;
  }
  
  params.id = params.user_username;
  var postData = params;

  var APIaddURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=createUserAccount";
  console.log(APIaddURL);

  $.ajax({          
    url: APIaddURL,
    type: "POST",
    data: postData,      
    dataType: 'json',
    success: function(response){
      console.log(response);
      if (response.createUserAccount.responseHeader.status == 0){      
        createAccountSuccess(params.user_username);
      }
      else {
        alert("Account Creation Error");
      }
    },
    error: function(response){
      console.log(response);
      alert("Error.");
    }
  });  
}


// Reusable
////////////////////////////////////////////////////////////////////////////////////

function denyAccess(){
  $("#messages_container").append("<p style='color:red;'>Access Denied.</p>");    
}

function grantAccess(username){
  $("#messages_container").append("<p style='color:green;'>Access Permitted for "+username+".  Setting Cookie.</p>");       
  setWSUDORCookie(username);
}

function createAccountSuccess(username){
  $("#messages_container").append("<p style='color:green;'>Account Created.  Setting Cookie.</p>"); 
  grantAccess(username);      
}

function createAccountFail(message){
  $("#messages_container").append("<p style='color:red;'>Could Not Create Account.</p>");
  if (typeof message != 'undefined'){
    $("#messages_container").append("<p style='color:red;'>"+message+"</p>");
  }      
}

function setWSUDORCookie(username){
  console.log("setting WSUDOR cookie for "+username);
  // hit WSUDOR for displayName
  // check WSUDOR status    
  var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=userSearch";  
  var postData = new Object ();
  postData.username = username;  
  $.ajax({    
    type: "POST",      
    url: APIcallURL,      
    dataType: 'json',
    data: postData,            
    success: function(response){
      console.log(response);
      userData.displayName = response.userSearch.displayName;
      userData.loggedIn_WSUDOR = true;  
      userData.username_WSUDOR = username;
      userData.clientHash = response.userSearch.clientHash;
      $.cookie("WSUDOR", JSON.stringify(userData),{
          path:"/"
        }
      );
      // consider heading back?
      window.history.back();
    },
    error:function(response){
      console.log("Could not retrieve displayName for cookie purposes");
    }
  });  
  
  

}












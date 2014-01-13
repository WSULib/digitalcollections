<?php 
//Barebones of Single Object Page
$objectPID = $_REQUEST['PID'];
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
    <!--<![endif]-->
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>WSUDOR Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/global.css" type="text/css">
        <link rel="stylesheet" href="ico/style.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>

    </head>
    <!-- Additions ###################################################################################### -->
            <!--jquery-->            
            <script src="http://code.jquery.com/jquery.js"></script>
            <!--Mustache-->
            <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
            <script type="text/javascript" src="inc/mustache.js"></script>  
            <!--cookie.js-->
            <script src="inc/jquery.cookie.js"></script>                      
            <!-- Local JS -->
            <script src="js/utilities.js"></script>        
            <script src="js/login.js"></script>
            <script src="js/userData.js"></script>
            <!--WSUDOR Translation Dictionary-->
            <script type="text/javascript" src="js/rosettaHash.js"></script>
            <!--Pagination-->
            <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script>            
            

            <!-- Temporary CSS -->
            <style type="text/css">
                #login_form_container{
                    float:center;
                    margin:auto;
                    background-color:rgba(242,242,242,1);
                    margin-top:20px;
                    padding:10px;
                }
                #messages_container{
                    float:center;
                    margin:auto;
                    background-color:rgba(242,242,242,1);
                    margin-top:20px;
                    padding:10px;
                }
                #createAccount_container{
                    float:center;
                    margin:auto;
                    background-color:rgba(242,242,242,1);
                    margin-top:20px;
                    padding:10px;
                    display:none;
                }
                a{
                    color:blue;
                }
            </style>

        <!-- Additions ###################################################################################### -->
    <body>
        <div class="page-wrap">
            <header>
                
            </header>

            <div id="templateCM">

                <div class="container">                    

                    <div id="login_form_container" class="primary-object-container col-lg-9 col-xlg-9">                        
                        <h2>Hello Login World.</h2>
                        <hr>                    
                        <div id="login_form" class="col-lg-12 col-xlg-12">
                            <p>Wayne State user? Login with your accessID and password.</p>
                            <p>Community member?  General public?  Login with your username and password.</p>
                            <form onsubmit="loginForm(); return false;">                                
                                accessID or username: <input id="username" type="text" name="username"><br>
                                password: <input id="password" type="password" name="password">
                                <input type='submit'/></input>
                            </form>
                            <hr>
                        </div>                        
                        <div id="login_instructions" class="col-lg-12 col-xlg-12">
                            <p>Don't have an account? Click <a href="#" onclick="$('#createAccount_container').fadeToggle(); return false;">here</a> to create one.</p>
                        </div>
                    </div>

                    <div id="createAccount_container" class="primary-object-container col-lg-9 col-xlg-9">                        
                        <h2>Create a new account</h2>
                        <p style="color:green;">Remember, you can login with your WSU credentials above!</p>
                        <p>* required</p>
                        <form onsubmit="createAccountPrep('userDefined'); return false;">                                
                            * display name: <input id="create_displayName" type="text" name="create_displayName"><br>
                            * username: <input id="create_username" type="text" name="create_username"><br>
                            * password: <input id="create_password" type="password" name="create_password">
                            <input type='submit'/></input>
                        </form>
                        <hr>                            
                    </div>   

                    <div id="messages_container" class="primary-object-container col-lg-9 col-xlg-9">                        
                        <h2>Messages...</h2>
                        <hr>                            
                    </div>                  

                </div>                

            </div> <!-- closes templateCM -->

        </div> <!-- page wrap -->

        <footer>            
        </footer>        
        
    </body>
           
    <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script> 

    <!--API call-->
    <script type="text/javascript">
        $(document).ready(function(){            
            loginGo();
        })      
    </script>
    


</html>
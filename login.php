<?php 
//Barebones of Single Object Page
$objectPID = $_REQUEST['PID'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
      
        <!-- page specific dependencies -->
        <script src="js/vendor/bootbox.min.js"></script>         
        <script src="js/login.js"></script>

    </head>
    <body>

    <div class="container" id="templateCM">
        <h1 class="brand-login">
            <img src="img/wsulsLogo.png" alt="" style="display:block;margin:0 auto;margin-bottom:20px;width:90px;height:auto;">
            <!-- <a href="index.php">Digital Collections</a> -->
        </h1>
        <div class="flat-form">
            <ul class="tabs">
                <li>
                    <a href="#login_form_container" class="active">Login</a>
                </li>
                <li>
                    <a href="#createAccount_container">Sign Up</a>
                </li>
            </ul>
            <div id="login_form_container" class="form-action show">
                <h1>Welcome!</h1>
                <div id="login_form">
                    <p>Login with your Access ID / Username and Password. If you don't have an Access ID or Username, please sign up.</p>
                    <form onsubmit="loginForm(); return false;">
                        <ul>
                            <li><input id="username" type="text" name="username" placeholder="Username"></li>
                            <li><input id="password" type="password" name="password" placeholder="Password"></li>
                            <li><input type="submit" value="Login" class="button"></li>
                        </ul>
                    </form>
                </div>
            </div>
            <!--/#login.form-action-->
            <div id="createAccount_container" class="form-action hide">
                <h1>Register.</h1>
                <p>
                    If you do not have a WSU Access ID, then fill out the information below to sign up for an account.
                </p>
                <form onsubmit="createAccountPrep('userDefined'); return false;">
                    <ul>
                        <li>
                            <input id="create_displayName" type="text" name="create_displayName" placeholder="Your Name / Display Name" />
                        </li>
                        <li>
                            <input id="create_username" type="text" name="create_username" placeholder="Username" />
                        </li>
                        <li><input id="create_password" type="password" name="password" placeholder="Password"></li>
                        <li>
                            <input type="submit" value="Sign Up" class="button" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#register.form-action-->
        </div>
    </div>  

       
    </body>

    <script>(function( $ ) {
  // constants
  var SHOW_CLASS = 'show',
      HIDE_CLASS = 'hide',
      ACTIVE_CLASS = 'active';
  
  $( '.tabs' ).on( 'click', 'li a', function(e){
    e.preventDefault();
    var $tab = $( this ),
         href = $tab.attr( 'href' );
  
     $( '.active' ).removeClass( ACTIVE_CLASS );
     $tab.addClass( ACTIVE_CLASS );
  
     $( '.show' )
        .removeClass( SHOW_CLASS )
        .addClass( HIDE_CLASS )
        .hide();
    
      $(href)
        .removeClass( HIDE_CLASS )
        .addClass( SHOW_CLASS )
        .hide()
        .fadeIn( 550 );
  });
})( jQuery );</script>


    <!--API call-->
    <script type="text/javascript">
        $(document).ready(function(){            
            loginGo();
        })      
    </script>
    
</html>

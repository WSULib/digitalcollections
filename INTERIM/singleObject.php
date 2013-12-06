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
        <title></title>
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
            <script src="js/singleObject.js"></script>
            <script src="js/userData.js"></script>

            <!--WSUDOR Translation Dictionary-->
            <script type="text/javascript" src="js/rosettaHash.js"></script>
            <!--Pagination-->
            <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script>            
            

            <!-- Temporary CSS -->
            <style type="text/css">
                
            </style>

        <!-- Additions ###################################################################################### -->
    <body>
        <div class="page-wrap">
            <header>
                <ul class="top-nav">
                    <li id="login_status"><a href="login.php">Login / SignUp</a></li>                    
                </ul>
            </header>

            <div id="templateCM">

                <div class="container">
                    <div class="breadcrumb col-lg-3 col-xlg-3">
                        <!-- had this as JS back, but really doesn't work if jumping straight to page from somewhere else, or there is no back history -->
                        <a href="#" onclick="window.history.back(); return false;"><i class="icon-angle-left"></i> Back to (prev page)</a>
                    </div>

                    <div class="primary-object-container col-lg-6 col-xlg-6">
                        <!-- <img src="http://placehold.it/600x480" class="primary-image">

                        <div class="subcomponents">
                            <ul>
                                <li><img src="http://placehold.it/600x480"></li>
                                <li><img src="http://placehold.it/600x480"></li>
                                <li><img src="http://placehold.it/600x480"></li>
                                <li><img src="http://placehold.it/600x480"></li>
                            </ul>
                        </div> -->
                    </div>

                    <!-- metadata new -->
                    <div class="info-panel col-lg-3 col-xlg-3">

                    </div>

                </div>                

                <div class="container">
                    <div class="col-lg-6 col-lg-offset-3 col-xlg-6 col-xlg-offset-3">
                        <div class="display-more-info" id="more-info">
                            <table class="table table-hover">
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- closes templateCM -->

        </div> <!-- page wrap -->

        <footer>
            <!--<div class="container">
                <div class="uni-logo">
                </div>

                <div class="copyright">
                </div>

                <div class="footer-nav"> links to wsu and library, contact, terms of use, privary policy
                </div>

            
            </div>-->
        </footer>        
        
    </body>
           
    <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script> 

    <!--API call-->
    <script type="text/javascript">
        $(document).ready(function(){
            var PID = "<?php echo $objectPID; ?>";          
            APIcall(PID);   
        })      
    </script>
    


</html>
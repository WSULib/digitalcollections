<?php 
//Barebones of Single Object Page
$objectPID = $_REQUEST['PID'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Wayne State University Libraries - Digital Collections</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="ico/style.css" type="text/css">
        <!-- FONTS -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')
        </script>

            <!--Mustache-->
            <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
            <script type="text/javascript" src="inc/mustache.js"></script>
            <!-- Local JS -->
            <script src="js/utilities.js"></script>        
            <script src="js/singleObject.js"></script>
            <script src="js/userData.js"></script>
            <!--WSUDOR Translation Dictionary-->
            <script type="text/javascript" src="js/rosettaHash.js"></script>
            <!--Pagination-->
            <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
            <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
            <script src="js/main.js" type="text/javascript"></script>
            <script src="js/jquery.cookie.js" type="text/javascript"></script>   

    </head>

    <body>
        <header>
            <div class="row-fluid top-head">
                <div class="container">
                    <div class="libraries">
                        <a href="">Wayne State University</a> <span style="color:white;">&raquo;</span> 
                        <a href="">Libraries</a>
                    </div>
                    <ul class="top-nav">
                        <li id="login_status"><a href="login.php">Login / SignUp</a></li>
                    </ul>
                </div>
            </div>
            <div class="row-fluid" id="search_form">
                <div class="container">
                    <div class="row-fluid">
                        <h1 class="brand"><a href="search.php">Digital Collections</a></h1>
                        <div class="search-box">
                            <form class="search" action="search.php">
                                <input class="searchTerm" value="Search our digital collections" name="q" id="q" type="text" onBlur="if(this.value=='')this.value='Search our digital collections'" onFocus="if(this.value=='Search our digital collections')this.value='' " />
                                <input class="searchButton" type="submit" />
                                <span class="searchIcon"></span>
                            </form>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <nav class="navbar navbar-inverse" role="navigation">
                          <ul class="nav navbar-nav">
                            <li><a href="collection.php">Collections</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Etc</a></li>
                          </ul>
                        </nav>
                    </div>
                </div>
            </div> 
        </header>


        <div id="templateCM" class="container">

            <div class="breadcrumb col-lg-3 col-xlg-3">
                <!-- had this as JS back, but really doesn't work if jumping straight to page from somewhere else, or there is no back history -->
                <a href="#" onclick="window.history.back(); return false;"><i class="icon-angle-left"></i> Back to (prev page)</a>
            </div>

            <div class="primary-object-container col-lg-6 col-xlg-6">
                
            </div>

            <!-- metadata new -->
            <div class="info-panel col-lg-3 col-xlg-3">

            </div>


            <div class="col-lg-6 col-lg-offset-3 col-xlg-6 col-xlg-offset-3">
                <div class="display-more-info" id="more-info">
                    <table class="table table-hover">
                        
                    </table>
                </div>
            </div>

        </div> <!-- closes templateCM -->

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
    <script src="../INTERIM/js/main.js" type="text/javascript"></script> 

    <!--API call-->
    <script type="text/javascript">
        $(document).ready(function(){
            var PID = "<?php echo $objectPID; ?>";          
            APIcall(PID);   
        })      
    </script>
    


</html>
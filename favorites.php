<!DOCTYPE php>
<html>
    <head>
        <meta charset="utf-8">
        <title>Digital Collections - Wayne State University Libraries</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">

        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>

        <script src="inc/jquery.cookie.js" type="text/javascript"></script>           
        
        <!-- Local JS -->
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/utilities.js"></script>        
        <script src="js/favorites.js"></script>
        <script src="js/userData.js"></script>
        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>    
        <script src="inc/sidr/jquery.sidr.min.js"></script>      
            

            <!-- Temporary CSS -->
            <style type="text/css">
                #facet_refine_list{
                    list-style-type:none;
                }
                #facet_refine_list li{                    
                    /*background-color:#FFFFA9;*/ /*Just to set it off for the moment, see where they are*/
                }
                .main-container {
                    width: 100%;
                }
                .facet_less {
                    display:none;
                }
                .hidden_facet {
                    display:none;
                }
                #resultsControls div{
                    display:inline;
                }
                ul.bootpag li{
                    display:inline;                    
                }
                ul.bootpag li.disabled a{
                    color:rgb(230,230,230);
                }
                .favObjCRUD{
                    list-style:none;
                    font-size:9px;
                    padding-top:20px;   
                    text-transform: uppercase;                 
                }
            </style>

        <!-- Additions ###################################################################################### -->

    </head>
    <body>

        <?php include('inc/header.php'); ?>

        <div class="container">
            <div class="row-fluid sub-header">
               <h2>
                    Favorites for <span id="fav_user"></span>
                </h2>
                <ul>
                    <li><span id='num_results'></span> Objects</li>
                </ul>
                
            </div><!-- /row for sub-header -->            

            <div id="results_container" class="main-container-wide">
                
                <ul class="row-fluid objects-container">
                    <!-- results template -->
                </ul>
            </div><!-- /objects -->

            <div class="pagination-centered">
                    <!-- pagination -->
            </div><!-- /pagination -->
              
        </div> <!-- /container -->

        <?php include('inc/footer.php'); ?>

    </body>
    <!-- init search -->
    <script type="text/javascript">
    var searchParams = <?php echo json_encode($_GET); ?>;                
    $(document).ready(function(){         	
    	getFavs(searchParams);    	        
    });    
</script>
</html>
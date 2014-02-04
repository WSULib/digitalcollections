<!DOCTYPE php>
<html>
    <head>
        <meta charset="utf-8">
        <title>Digital Collections - Wayne State University Libraries</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/main.css" type="text/css">
        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>
        
        <!-- Local JS -->
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/favorites.js"></script>
        <script src="js/userData.js"></script>             
        <script src="js/collection.js"></script>
        <script src="js/utilities.js"></script>

        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 

    </head>
    <body>
        <?php include('inc/header.php'); ?>

            <div class="container main-content">
                <h2>
                    Collections
                </h2>
                <div class="row">
                    <div class="collection_contents"> <!-- Added by Cole -->
                    </div>
                </div>

                <div class="row">
                    <div class="pagination clearfix">
                    </div>
                </div>
            </div>

        <?php include('inc/footer.php'); ?>

        <!-- loading collections -->
        <script type="text/javascript"> 
            var searchParams = <?php echo json_encode($_REQUEST); ?>;
            if (jQuery.isEmptyObject(searchParams)){
                collectionsList("allCollections");                
            }
            else{    
            $(document).ready(function(){
                // updatePage();
                // searchGo("allCollections");
            });
            }    
        </script>
    </body>
</html>
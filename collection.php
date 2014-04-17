<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Collection | Digital Collections | WSULS</title>

        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
        <link rel="stylesheet" href="css/glyphicons.css">

        
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
        <script src="js/utilities.js"></script>
        <script src="js/collection-shared.js"></script>  
        <script src="js/collection.js"></script>
        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 
        <script src="inc/sidr/jquery.sidr.min.js"></script>

    </head>
    <body>
        <?php include('inc/header.php'); ?>

            <div class="container">
                <div class="sub-header">
                   <h2 id="collection_title">
                        <!-- title of collectionTitle of Collection -->
                    </h2>
                    <ul>
                        <li><span id="num_results"></span> Objects</li>
                        <li><span id="learn_more">Learn more about this collection</span></li>
                    </ul>
                   
                    
                </div><!-- / sub-header -->

                <div id="facets_container" class="facets">
                    <ul class="facet_container filter" id="search_facet">
                        <li>
                            <h3 class="tree-toggler">Filter by Keyword</h3>
                            <ul class="tree facet_list" id="search_facet_box">                                
                                <form onsubmit="refineByKeyWord('collection'); return false;">
                                    <input id="filter_input" placeholder="Filter by keyword" class="search-filter">
                                </form>
                            </ul>
                        </li>
                    </ul>
                    <!-- facets template -->
                </div><!-- /facets -->

                <div id="collection_contents" class="main-container">            
                    <div class="row-fluid filtered-by refined-by">
                        <!-- fiters -->
                    </div><!-- /filtered-by -->
                    <ul class="row-fluid objects-container">
                        <!-- results template -->
                        <div class="row">
                            <div class="collection_contents"> 
                            </div>
                        </div>
                    </ul>
                    <div class="pagination-centered">
                    <!-- pagination -->
                    </div><!-- /pagination -->
                </div><!-- /objects -->
                
            </div>

        <?php include('inc/footer.php'); ?>

        <!-- loading collections -->
        <script type="text/javascript"> 
            var searchParams = <?php echo json_encode($_GET); ?>;
            $(document).ready(function(){
                searchGo("collectionPage");
            });
        </script>
        <!-- ********************************************* -->
    </body>
</html>
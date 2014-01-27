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
                
        <script src="js/search.js"></script>
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

        <div class="container">
            <div class="row-fluid sub-header">
               <h2>
                    Search Results
                </h2>
                <ul>
                    <li><span id='num_results'></span> Objects</li>
                    <li>&quot;<span id='q_string'></span>&quot;</li>
                    <li><a href="#">Save this Search</a></li>
                </ul>
                <div class="row-fluid">
                    <!-- <select class="form-control pull-right" id='rows' onchange="updateSearch();">
                        <option value="12">12</option>
                        <option value="36">36</option>
                        <option value="48">48</option>
                        <option value="90">90</option>
                    </select> -->
                    <div class="switch-views">
                   <!--      <div id="list" class="list list-active"></div>
                        <div id="grid" class="grid"></div>
                        <div class="filter-on filter-active"></div>
                        <div class="filter-off"></div>
                    --> </div>
                </div><!-- /switch-views -->
                
            </div><!-- /row for sub-header -->
            
            <div id="facets_container" class="facets">
                <ul class="facet_container filter" id="search_facet">
                    <li>
                        <h3 class="tree-toggler">Filter by Keyword</h3>
                        <ul class="tree facet_list" id="search_facet_box">
                            <form onsubmit="refineByKeyWord(); return false;"><input id="filter_input" placeholder="Filter by keyword" class="search-filter"></form>
                        </ul>
                    </li>
                </ul>
                <!-- facets template -->
            </div><!-- /facets -->

            <div id="results_container" class="main-container">
                
                <div class="row-fluid filtered-by refined-by">
                    <!-- fiters -->
                </div><!-- /filtered-by -->
                <ul class="row-fluid objects-container">
                    <!-- results template -->
                </ul>
            </div><!-- /objects -->

            <div class="pagination-centered">
                    <!-- pagination -->
            </div><!-- /pagination -->
              
        </div> <!-- /container -->

        <?php include('inc/footer.php'); ?>

        <!-- init search -->
        <script type="text/javascript">
        var searchParams = <?php echo json_encode($_REQUEST); ?>;    
        $(document).ready(function(){        
            searchGo();    
        });    
        </script>
    </body>
</html>
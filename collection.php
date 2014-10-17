<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Collection | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
        <link rel="stylesheet" href="ico/style.css">
        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>
        
        <!-- Local JS -->
        <script src="config/config.js" type="text/javascript"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/favorites.js"></script>        
        <script src="js/userData.js"></script>             
        <script src="js/utilities.js"></script>
        <script src="js/collection.js"></script>        

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
                <ul style="width:50%; float:left;">                	
                    <li><span id='num_results'></span> Objects</li>
                    <li><a href="#" id="learn_more">About this Collection</a></li>                     
                </ul>                
                <ul style="width:50%; float:right; text-align:right;">                	                    
                    <li>
                    	<span>Items per page:</span>
                    	<select class="resPerPage">                    		
                    		<option value=10>10</option>
                    		<option value=20>20</option>
                    		<option value=50>50</option>
                    		<option value=100>100</option>
                		</select>
            		</li>
            		<li id="toggleView">
                    	<span style="cursor:pointer;" onclick="toggleResultsView('collection'); return false;">Toggle <i class="icon-list4"></i> / <i class="icon-layout"></i></span>
                    </li>
            	</ul>
            </div><!-- /row for sub-header -->
            
            <div id="facets_container" class="facets">
                <ul class="facet_container filter" id="search_facet">
                    <li>
                        <h3 class="tree-toggler">Filter by Term</h3>
                        <ul class="tree facet_list" id="search_facet_box">
                            <form onsubmit="refineByKeyWord('collection'); return false;" role="form">
                                <input id="refine_input" placeholder='Type in word or phrase' class="search-filter">                                                                
								<label class="radio-inline">
									<input type="radio" id="metadata" name="refine_type" value="metadata"> Item Record Only
								</label>
								<label class="radio-inline">
									<input type="radio" id="fulltext" name="refine_type" value="fulltext"> Full-Text Only
								</label>
								<label class="radio-inline">
									<input checked type="radio" id="both" name="refine_type" value="both"> Both
								</label>
                            </form>
                        </ul>
                    </li>
                </ul>
                <!-- facets template -->
            </div><!-- /facets -->

            <div class="main-container">
                <div class="row-fluid filtered-by refined-by">
                    <!-- fiters -->
                </div><!-- /filtered-by -->
                <ul class="row-fluid objects-container" id="results_container" >
                    <!-- results template -->
                </ul>
                <div class="pagination-centered">
                    <!-- pagination -->
                </div><!-- /pagination -->
            </div><!-- /objects -->
              
        </div> <!-- /container -->

        <?php include('inc/footer.php'); ?>

        <!-- loading collections -->
        <script type="text/javascript"> 
            var searchParams = <?php echo json_encode($_GET); ?>;                        
            $(document).ready(function(){
            	searchGo();            
        	});
        </script>
        <!-- ********************************************* -->
    </body>
</html>
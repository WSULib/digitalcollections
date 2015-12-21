<!DOCTYPE html>
<html>
    <head>
        <!-- page rendered as Collection -->
        <meta charset="UTF-8">
        <title>Collection | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
      
        <!-- page specific dependencies -->        
        <script src="js/collection.js?v=<?php echo date('n-j-Y'); ?>"></script>
        <script type="text/javascript" src="inc/freewall/freewall.js"></script>

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
                    		<option value=12>12</option>
                    		<option value=20>20</option>
                            <option value=50>50</option>                    		
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
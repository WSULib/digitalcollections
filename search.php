<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Search | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
          
        <!-- page specific dependencies -->
        <script src="js/search.js?v=<?php echo date('n-j-Y'); ?>"></script>        
        <script type="text/javascript" src="inc/freewall/freewall.js"></script>
        

    </head>
    <body>
        <?php include('inc/header.php'); ?>

        <div class="container cached">
            <div class="sub-header">
               <h2>
                    Search Results
                </h2>
                
                <div class="row">
	                <div class="col-md-6 pull-left">
		                <ul id="search_results_ul">
		                    <li><span id='num_results'></span> Objects</li>
		                    <!-- <li>&quot;<span id='q_string'></span>&quot;</li>-->
		                </ul>                
	                </div>
	                <div class="col-md-6 pull-right" style="text-align:right;">                
			            <!-- <ul style="width:50%; float:right; text-align:right;"> -->
			            <ul >                	                    		        	
			                <li>
			                	<span>Items per page:</span>
			                	<select class="resPerPage">                    		
			                		<option value=12>12</option>
			                		<option value=20>20</option>
			                		<option value=50>50</option>			                		
			            		</select>
			        		</li>
			        		<!-- old selector -->
                            <li id="toggleView">
			                	<span style="cursor:pointer;" onclick="toggleResultsView('search'); return false;">Toggle <i class="icon-list4"></i> / <i class="icon-layout"></i></span>
                            </li>                            
			        	</ul>
		        	</div>
	        	</div>
            </div><!-- /row for sub-header -->
            
            <div id="facets_container" class="facets">
                <ul class="facet_container filter" id="search_facet">                	
                    <li>
                        <h3 class="tree-toggler">Refine Results</h3>
                        <ul class="tree facet_list" id="search_facet_box">
                            <form onsubmit="refineByKeyWord('search','same'); return false;" role="form">
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
                <ul class="row-fluid objects-container" id="results_container">
                    <!-- results template -->
                </ul>
                <div class="pagination-centered">
                    <!-- pagination -->
                </div><!-- /pagination -->
            </div><!-- /objects -->
              
        </div> <!-- /container -->

        <?php include('inc/footer.php'); ?>

        <!-- init search -->
        <script type="text/javascript">

	    var searchParams = <?php echo json_encode($_GET); ?>;
	        
            $(document).ready(function(){                
                searchGo();
        	});
        </script>
        
    </body>
</html>


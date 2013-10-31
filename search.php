<html>
<head>
    <title>WSUDOR - Search</title>

	<!--jquery-->
	<script src="http://code.jquery.com/jquery.js"></script>
    <!--cookie.js-->
    <script src="inc/jquery.cookie.js"></script>
	<!--load bootstrap js-->    
    <script src="inc/bootstrap/js/bootstrap.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="inc/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!--Mustache-->
    <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
	<script type="text/javascript" src="inc/mustache.js"></script>
    <!--Pagination-->
    <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script>    
    <!-- Local JS -->
    <script src="js/utilities.js"></script>
    <script src="js/userData.js"></script>
    <script src="js/search.js"></script>
    <!-- Local CSS -->
	<link href="css/style.css" rel="stylesheet">
    <!--WSUDOR Translation Dictionary-->
    <script type="text/javascript" src="js/rosettaHash.js"></script>
    <script type="text/javascript" src="http://silo.lib.wayne.edu/fedora/objects/wayne:WSUDORTranslations/datastreams/digitalCollectionRosettaHash/content"></script>   
     
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
    

</head>

<body>

	<div id="search_container" class="container-fluid">
        
        <div class="row-fluid" id="search_form">
            <div class="span4">
                <h3><a href="search.php">RESET</a></h3>
            </div>            
            <div class="span4 pull-right">

                <form class="form-search" action="search.php">                    
                    <input style="height:30px;" class="input-large search-query" name='q' id='q' type='text' placeholder="e.g. Detroit"/>
                    <button type="submit" class="btn">Search</button>
                </form>

            </div>
        </div>            
        
        <div class="row-fluid">
            <div class="span12">
                <p>Your search for <strong><span id='q_string'></span></strong> returned <strong><span id='num_results'></span></strong> results.</p>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span6">
                <p><strong>Items per Page</strong></p>
                <select style="width:75px;" id='rows' onchange="updateSearch();">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="span6 pull-right pagination"></div>
        </div>

        <div class="row-fluid">
            <div id="facet_refine" class="span12">
                <p><strong>Refined By:</strong></p>
                <ul id="facet_refine_list"></ul>
            </div>
        </div>

        

        <div class="row-fluid">

            <!-- facets sidebar -->
            <div id="search_parameters" class="span4">
                <h4>Search Parameters</h4>            

                <!--Consider iterating through facets as selected in Limiters object...-->
                <div id="facets_container"></div>
            
            </div><!--closes search_parameters-->

            <!-- results -->
            <div id="search_results" class="span8">
                <!-- <h4>Search Results</h4>             -->
                <div id="results_container"></div>
            </div>
            <div class="span8 pull-right pagination"></div>

        </div><!--closes main second row-->
    
    </div> <!--closes container-->

	

</body>

<script type="text/javascript">
    var searchParams = <?php echo json_encode($_REQUEST); ?>;    
    $(document).ready(function(){
        // updatePage();
        searchGo();    
    });    
</script>
</html>

<html>
<head>
    <title>WSUDOR - Search</title>

	<!--jquery-->
	<script src="http://code.jquery.com/jquery.js"></script>
	<!--load bootstrap js-->    
    <script src="inc/bootstrap/js/bootstrap.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="inc/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!--Mustache-->
    <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
	<script type="text/javascript" src="inc/mustache.js"></script>
    <!-- Local JS -->
    <script src="js/search.js"></script>
    <!-- Local CSS -->
	<link href="css/style.css" rel="stylesheet">
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

</head>

<body>

	<div id="search_container" class="container-fluid">
        
        <div class="row-fluid" id="search_form">            
            <div class="span4 pull-right">

                <form class="form-search" action="search.php">                    
                    <input style="height:30px;" class="input-medium search-query" name='q' id='q' type='text' placeholder="e.g. Detroit"/>
                    <button type="submit" class="btn">Search</button>
                </form>

            </div>
        </div>            
        
        <div class="row-fluid">
            <div class="num_results span12">
                <span><strong>Number of Results</strong></span></br>
                <select style="width:75px;" id='rows' onchange="updateSearch();">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <div class="row-fluid">
            <div id="facet_refine" class="span12"><p>Hidden until facets are selected...</p></div>
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
            <h4>Search Results</h4>            
            <div id="results_container"></div>
        </div>

        </div><!--closes main second row-->
    
    </div> <!--closes container-->

	

</body>

<script type="text/javascript">
    var searchParams = <?php echo json_encode($_REQUEST); ?>;    
    searchGo();
</script>
</html>

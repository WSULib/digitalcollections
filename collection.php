<html>
<head>
    <title>WSUDOR - Title of Collection Here</title>

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
    <!--Pagination-->
    <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script>    
    <!-- Local JS -->
    <script src="js/collection.js"></script>
    <!-- Local CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

</head>

<body>

    <div id="search_container" class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
            <h2><a href="collection.php">Collection View</a></h2>
        </div>
      </div>                    
        
        <div class="row-fluid">
            <div class="span12">
                <p>There are <strong><span id='num_results'></span></strong> items in <strong><span id='title'></span></strong>.</p>
            </div>
        </div>

        <div class="row-fluid">
            <div class="titleSelector">
                <div class="span6 pull-left">
                <p><strong>Select Collection</strong></p>
                <select style="width:250px;" id='q' onchange="updateCollection();">
                    <option value="rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORCollections">All Collections</option>
                    <option value="rels_isMemberOfCollection:info:fedora/wayne:collectionCFAI">Changing Face of the Auto Industry</option>
                </select>
            </div>
            </div>            
            <div class="span6">
            <div class="span6">
                <p><strong>Items per Page</strong></p>
                <select style="width:75px;" id='rows' onchange="updateSearch();">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            </div>
            <div class="span8 pagination"></div>
        </div>

        

        <div class="row-fluid">

            <!-- results -->
            <div id="search_results" class="span8">
                <h4>Search Results</h4>            
                <div id="results_container"></div>
            </div>
            <div class="span8 pagination"></div>

        </div><!--closes main second row-->
    
    </div> <!--closes container-->

    

</body>

<script type="text/javascript">
    var searchParams = <?php echo json_encode($_REQUEST); ?>;    
    $(document).ready(function(){
        // updatePage();
        searchGo();
        // TitleSelect();
        // collectionSelect();    
    });    
</script>
</html>

<html>
<head>
    <title>WSUDOR - Collection Page</title>

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
    <script src="js/rosettaHash.js"></script>
    <!-- Local CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

</head>

<body>

    <div id="title_container" class="navbar navbar-fixed-top">
        
        <div class="row-fluid">
            <h1>
            </h1>
            <h2><a href="collection.php"><span id='title'></span></a></h2>
            <p>There are <strong><span id='num_results'>0</span></strong> items in this collection.</p>

<div class="collectionSelector">
                <div class="span3">
                <p><strong>Select Collection</strong></p>
                <select style="width:250px;" id='q' onchange="updateCollection();">
                    <option value=" " selected = "selected"></option>
                    <option value="rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORCollections">All Collections</option>
                    <option value="rels_isMemberOfCollection:info:fedora/wayne:collectionCFAI">Changing Face of the Auto Industry</option>
                </select>
            </div>
            </div>            
            <div class="span9">
                <p><strong>Items per Page</strong></p>
                <select style="width:75px;" id='rows' onchange="updateSearch();">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="span7 pagination"></div>
        </div>
            </div> <!--close title_container -->

        
    <div id="collection_container" class="container-fluid">
        <div class="row-fluid">

            <!-- results -->
            <div id="search_results" class="span8">
                <h4>Search Results</h4>            
                <div id="results_container"></div>
            </div>
            <!-- <div class="span8 pagination"></div> -->

        </div>
    
    </div> <!--closes collection_container-->

    

</body>

<script type="text/javascript">
    var searchParams = <?php echo json_encode($_REQUEST); ?>;    
    $(document).ready(function(){
        // updatePage();
        searchGo();
        // updateCollectionTitle();
        // collectionsList();    
    });    
</script>
</html>

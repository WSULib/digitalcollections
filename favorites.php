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

        <script src="inc/jquery.cookie.js" type="text/javascript"></script>           
        
        <!-- Local JS -->
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/utilities.js"></script>        
        <script src="js/favorites.js"></script>
        <script src="js/userData.js"></script>
        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>          
            

            <!-- Temporary CSS -->
            <style type="text/css">
                #facet_refine_list{
                    list-style-type:none;
                }
                #facet_refine_list li{                    
                    /*background-color:#FFFFA9;*/ /*Just to set it off for the moment, see where they are*/
                }
                .facet_less {
                    display:none;
                }
                .hidden_facet {
                    display:none;
                }
                #resultsControls div{
                    display:inline;
                }
                ul.bootpag li{
                    display:inline;                    
                }
                ul.bootpag li.disabled a{
                    color:rgb(230,230,230);
                }
                .favObjCRUD{
                    list-style:none;
                    font-size:9px;
                    padding-top:20px;   
                    text-transform: uppercase;                 
                }
            </style>

        <!-- Additions ###################################################################################### -->

    </head>
    <body>

        <?php include('inc/header.php'); ?>

        <div class="container">
            <div class="row-fluid sub-header">
               <h2>
                    Favorites for <span id="fav_user"></span>
                </h2>
                <ul>
                    <li><span id='num_results'></span> Objects</li>
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
            
            <div id="list_container" class="facets">
                <ul class="facet_container filter" id="search_facet">
                    <li>
                        <h3 class="tree-toggler">Lists</h3>
                        <ul class="tree facet_list" id="fav-list">
                            
                        </ul>
                        <div class="btn">Add New</div>
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




        <!-- 

            <div class="container main-content">
                <h2>
                    Favorites for <span id="fav_user"></span>
                </h2>
                <div class="collection-details">
                    <p>
                        <span id='num_results'></span> Objects
                    </p>
                </div>

                

                <div class="row">

                    
                    <div id="favorites_tools" class="facets col-lg-3 cl-xlg-3">
                        <ul>                    
                            <li id="facet_refine">
                                <h5>Lists</h5>
                                <ul id="facet_refine_list"></ul>
                            </li>
                        </ul>
                    </div>                    

                    <div id="results_container" class="browse col-lg-9 cl-xlg-9">
                        
                        <div class="col-lg-12 col-xlg-12 clearfix">   
                            <select class="form-control pull-right" id='rows' onchange="updateSearch();">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="form-control pull-right"><strong>Items per Page</strong></span>
                        </div>                        

                        <div class="refined-by col-lg-12 col-xlg-12">
                        </div>
                   
                    </div> 
                </div>
                <div class="row">
                    <div class="pagination clearfix">                            
                    </div>
                </div>

                
            </div> -->
    </body>
    <!-- init search -->
    <script type="text/javascript">
    var searchParams = <?php echo json_encode($_REQUEST); ?>;            
    $(document).ready(function(){        
        getFavs();
        // searchGo();    
    });    
</script>
</html>
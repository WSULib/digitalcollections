<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!-- <link rel="stylesheet" href="img/sprites/sprites.css" type="text/css"> -->
        <link rel="stylesheet" href="css/global.css" type="text/css">
        <link rel="stylesheet" href="ico/style.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!-- Additions ###################################################################################### -->
            <!--Mustache-->
            <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
            <script type="text/javascript" src="inc/mustache.js"></script>
            <!--cookie.js-->
            <script src="inc/jquery.cookie.js"></script>        
            <!-- Local JS -->
            <script src="js/utilities.js"></script>        
            <script src="js/search.js"></script>
            <script src="js/userData.js"></script>

            <!--WSUDOR Translation Dictionary-->
            <script type="text/javascript" src="js/rosettaHash.js"></script>
            <!--Pagination-->
            <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script>            
            

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
            </style>

        <!-- Additions ###################################################################################### -->

    </head>
    <body>
        <div class="page-wrap">
            <header>                
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
                <ul class="top-nav">
                    <li id="login_status"><a href="login.php">Login / SignUp</a></li>
                </ul>
            </header>

            <div class="container main-content">
                <h2>
                    Search Results
                </h2>
                <div class="collection-details">
                    <p>
                        <span class="items-in-collection"><span id='num_results'></span> Objects</span><span class="items-in-collection">Your search for '<span id='q_string'></span>'</span><span class="save-search"><a href="#">Save this Search</a></span>
                    </p>
                </div>

                

                <div class="row">
                    <div id="facets_container" class="facets col-lg-3 cl-xlg-3">
                    
                    <ul>                    
                        <li id="facet_refine">
                            <h5>Refined By:</h5>
                            <ul id="facet_refine_list"></ul>
                        </li>
                    </ul>
                    
                    </div>
                    <div id="results_container" class="browse col-lg-9 cl-xlg-9">
                        
                        <!-- <div id="resultsControls"> -->
                            <div class="col-lg-12 col-xlg-12 clearfix">
                                <select class="form-control pull-right">
                                    <option>Sort by</option>
                                    <option>Relevancy</option>
                                    <option>A-Z</option>
                                    <option>Z-A</option>
                                </select>                                                                
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
                       
                    </div> <!-- closes #results_container -->

                    <div class="row">
                        <div class="pagination clearfix">                            
                        </div>
                        <!-- <div class="span8 pull-right pagination"></div> -->
                    </div>

                </div>

                
            </div>
        </div>

        <footer>
          
        </footer>
        
        <script type="text/javascript">
            window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')
        </script>
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/main.min.js" type="text/javascript"></script>
    </body>
    <!-- init search -->
    <script type="text/javascript">
    var searchParams = <?php echo json_encode($_REQUEST); ?>;            
    $(document).ready(function(){        
        searchGo();    
    });    
</script>
</html>
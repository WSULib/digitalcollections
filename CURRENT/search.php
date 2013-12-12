<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Wayne State University Libraries - Digital Collections</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="ico/style.css" type="text/css">
        <!-- FONTS -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')
        </script>

            <!--Mustache-->
            <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
            <script type="text/javascript" src="inc/mustache.js"></script>
            <!-- Local JS -->
            <script src="js/utilities.js"></script>        
            <script src="js/search.js"></script>
            <!--WSUDOR Translation Dictionary-->
            <script type="text/javascript" src="js/rosettaHash.js"></script>
            <!--Pagination-->
            <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
            <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
            <script src="js/main.js" type="text/javascript"></script>
            <script src="js/jquery.cookie.js" type="text/javascript"></script>           

    </head>
    <body>
        <header>
            <div class="row-fluid top-head">
                <div class="container">
                    <div class="libraries">
                        <a href="">Wayne State University</a> <span style="color:white;">&raquo;</span> 
                        <a href="">Libraries</a>
                    </div>
                    <ul class="top-nav">
                        <li><a href="">Login / Sign up</a></li>
                    </ul>
                </div>
            </div>
            <div class="row-fluid" id="search_form">
                <div class="container">
                    <div class="row-fluid">
                        <h1 class="brand"><a href="search.php">Digital Collections</a></h1>
                        <div class="search-box">
                            <form class="search" action="search.php">
                                <input class="searchTerm" value="Search our digital collections" name="q" id="q" type="text" onBlur="if(this.value=='')this.value='Search our digital collections'" onFocus="if(this.value=='Search our digital collections')this.value='' " />
                                <input class="searchButton" type="submit" />
                                <span class="searchIcon"></span>
                            </form>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <nav class="navbar navbar-inverse" role="navigation">
                          <ul class="nav navbar-nav">
                            <li><a href="collection.php">Collections</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Etc</a></li>
                          </ul>
                        </nav>
                    </div>
                </div>
            </div> 
        </header>

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
                <div class="row-fluid" style="margin-top:-45px;">
                    <!-- <select class="form-control pull-right" id='rows' onchange="updateSearch();">
                        <option value="12">12</option>
                        <option value="36">36</option>
                        <option value="48">48</option>
                        <option value="90">90</option>
                    </select> -->
                    <div class="switch-views">
                        <div id="list" class="list list-active"></div>
                        <div id="grid" class="grid"></div>
                        <div class="filter-on filter-active"></div>
                        <div class="filter-off"></div>
                    </div>
                </div><!-- /switch-views -->
                
            </div><!-- /row for sub-header -->
            
            <div id="facets_container" class="facets">
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

        <footer>
            <!--<div class="container">
                <div class="uni-logo">
                </div>

                <div class="copyright">
                </div>

                <div class="footer-nav"> links to wsu and library, contact, terms of use, privary policy
                </div>

            
            </div>-->
        </footer>        
        <!-- init search -->
        <script type="text/javascript">
        var searchParams = <?php echo json_encode($_REQUEST); ?>;    
        $(document).ready(function(){        
            searchGo();    
        });    
        </script>
    </body>
</html>
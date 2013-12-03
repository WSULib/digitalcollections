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
                /*ul.bootpag li{
                    display:inline;                    
                }
                ul.bootpag li.disabled a{
                    color:rgb(230,230,230);
                }*/
                /*header {
                    height: 100px;
                    background: #A2BAB7;
                }*/
                header h3 {
                    display: inline;
                }
                header .search-box {
                  position: relative;
                  width: 50%;
                  float: right;
                }
                header .searchTerm {
                  position: absolute;
                  top: 0;
                  left: 0;
                  width: 100%;
                  -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
                  -moz-box-sizing: border-box;    /* Firefox, other Gecko */
                  box-sizing: border-box; 
                  height: 50px;
                  border: 5px solid #333;
                  xborder-radius: 5px;
                  outline: none;
                  padding: 5px 45px 5px 10px;
                }
                header .searchButton,
                header .searchIcon {
                  display: block;
                  position: absolute;
                  top: 0;
                  right: 0;
                  width: 40px;
                  height: 50px;
                  line-height: 50px;
                  font-family: 'FontAwesome';
                  background: #333;
                  text-align: center;
                  color: #fff;
                  xborder-radius: 5px;
                  -webkit-font-smoothing: subpixel-antialiased;
                  font-smooth: always;
                  cursor: pointer;
                }
                header .searchButton {
                  opacity: 0;
                  z-index: 1;
                }
                header .searchIcon:before {
                  content: '\f002';
                }
            </style>

    </head>
    <body>
        <header>
            <div class="row-fluid" id="search_form">
                <h3><a href="search.php">RESET</a></h3>
                <div class="search-box">

                    <form class="search" action="search.php">
                        <input class="searchTerm" value="Search our digital collections" name="q" id="q" type="text" onBlur="if(this.value=='')this.value='Search our digital collections'" onFocus="if(this.value=='Search our digital collections')this.value='' " />
                        <input class="searchButton" type="submit" />
                        <span class="searchIcon"></span>
                    </form>

                </div>
            </div> 
        </header>

            <div class="container">
                <div class="row sub-header">
                   <h2>
                        Search Results
                    </h2>
                    <ul>
                        <li><span id='num_results'></span> Objects</li>
                        <li>&quot;<span id='q_string'></span>&quot;</li>
                        <li><a href="#">Save this Search</a></li>
                    </ul>
                    <div class="row">
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
                    
                    <div class="row filtered-by refined-by">
                        <!-- fiters -->
                    </div><!-- /filtered-by -->
                    <ul class="row objects-container">
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
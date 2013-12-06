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
            <script src="js/collections.js"></script>
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
                
                header {
                    background: #f9f8f3;
                }
                header h1 {
                    display: inline;
                }
                header h1 a {
                    font-family: 'Roboto', sans-serif;
                    font-weight: 900;
                    color: #062728;
                    text-transform: uppercase;
                    text-decoration: none;
                    /*margin-top: 1.5em;
                    margin-bottom: 1.5em;*/
                }
                h1 a:hover {
                    text-decoration: none;
                }
                header .search-box {
                  position: relative;
                  width: 50%;
                  float: right;
                  margin-top: .5em;
                }
                header .searchTerm {
                  position: absolute;
                  top: 0;
                  left: 0;
                  width: 100%;
                  -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
                  -moz-box-sizing: border-box;    /* Firefox, other Gecko */
                  box-sizing: border-box; 
                  height: 40px;
                  border: 1px solid #A2BAB7;
                  border-radius: 3px;
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
                  height: 40px;
                  line-height: 40px;
                  font-family: 'FontAwesome';
                  background: #A2BAB7;
                  text-align: center;
                  color: #fff;
                  border-radius: 3px;
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
                .top-head {
                    background: #0c5449;
                    border-bottom: 1px solid #ddd;
                    font-size: 0.75em;
                    color: #333;
                    margin-bottom: 2.5em;
                }
                .top-head a {
                    color: #333;
                }
                .top-head .container {
                    height: 30px;
                }
                .libraries {
                    display: inline-block;
                    padding: 6px 0;
                    text-transform: uppercase;
                    letter-spacing: .1em;
                    word-spacing: .1em;
                }
                .libraries a {
                    color: #fff;
                }
                .top-nav {
                    list-style: none;
                    padding: 6px 0;
                    float: right;
                    text-transform: uppercase;
                    letter-spacing: .1em;
                }
                .top-nav li {
                    display: inline-block;
                }
                .top-nav li a {
                    padding: 10px 15px;
                    color: #fff;
                }
            </style>

    </head>
    <body>
        <header>
            <div class="row-fluid top-head">
                <div class="container">
                    <div class="libraries">
                        <a href="">Wayne State University Libraries</a>
                    </div>
                    <ul class="top-nav">
                        <li><a href="">Login</a></li>
                        <li><a href="">Sign Up</a>  </li>
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

            <div class="container main-content">
                <h2 id="title"> <!-- I gave the title an id to be able to update it dynamically -->
                    Wayne State University Digital Collections
                </h2>
                <div class="collection-details">
                    <p>
                        <span class="items-in-collection"><span id='num_results'>0</span> Objects</span>  <a href="singleObject-collection.html" class="items-in-collection">Learn more about this collection</a> 
                        <select class="form-control" onchange="updateCollection();">
                            <option>View different collection</option>
<!--                             <option>Collection 2</option>
                            <option>Collection 3</option>
                            <option>Collection 4</option>
                            <option>Collection 5</option> -->
                        </select>
                    </p>
                </div>
                <div class="row">
                    <div id="facets_container" class="hidden-facets col-lg-3 cl-xlg-3">
                    <!-- Facet Refines ############################################################################################################ -->                    
                    <ul>                    
                        <li id="facet_refine">
                            <h5>Refined By:</h5>
                            <ul id="facet_refine_list"></ul>
                        </li>
                    </ul>
                    <!-- Facet Refines ############################################################################################################ -->
                        
                        <!-- Axa Code -->
                        <!--<ul>
                            <li><h5 class="tree-toggler">Content Type</h5>
                                <ul class="tree">
                                    <li>Image (2296)</li>
                                    <li>WSUebook (35)</li>
                                    <li>Issues (18)</li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li><h5 class="tree-toggler">Collection</h5>
                                <ul class="tree">
                                    <li>Image (2296)</li>
                                    <li>WSUebook (35)</li>
                                    <li>Issues (18)</li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li><h5>Creator</h5>
                                <ul>
                                    <li>Image (2296)</li>
                                    <li>WSUebook (35)</li>
                                    <li>Issues (18)</li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li><h5>Date</h5>
                                <ul>
                                    <li>Image (2296)</li>
                                    <li>WSUebook (35)</li>
                                    <li>Issues (18)</li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li><h5>Subject</h5>
                                <ul>
                                    <li>Image (2296)</li>
                                    <li>WSUebook (35)</li>
                                    <li>Issues (18)</li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li><h5>Location</h5>
                                <ul>
                                    <li>Image (2296)</li>
                                    <li>WSUebook (35)</li>
                                    <li>Issues (18)</li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li><h5>Language</h5>
                                <ul>
                                    <li>Image (2296)</li>
                                    <li>WSUebook (35)</li>
                                    <li>Issues (18)</li>
                                </ul>
                            </li>
                        </ul>
                        -->


                    </div>
                    <div class="browse col-lg-12 cl-xlg-12">
                        <div class="col-lg-12 col-xlg-12 clearfix">
                            <span class="items-per-page">
                                <!--Show 96 per page -->
                            </span>
                            <span class="refine-more">
                                <i class="icon-filter"></i>
                            </span>
                        </div>

                        <div class="refined-by col-lg-12 col-xlg-12">
                        </div>
                        <div class="row">
                        <div class="collection_contents"> <!-- Added by Cole -->
                        </div>
                            <!-- <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-4 cl-xlg-4">
                            <img src="http://placehold.it/460x368">
                        
                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div>
                            <div class="collection col-lg-4 cl-xlg-4">
                                <img src="http://placehold.it/460x368">

                                <div class="collection-details">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                </div>
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="pagination clearfix">
<!--                                 <a href="#">«</a>
                                
                                <a href="#">1</a>
                                <strong>2</strong>
                                <a href="#">3</a>
                                
                                <a href="#">»</a> -->
                            </div>
                        </div>
                    </div>

                </div>

                
            </div>
        </div>

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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')
        </script>
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/main.min.js" type="text/javascript"></script>
        <!-- Cole Added the below stuff  *******************************************-->
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script>
        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>
        <!-- Local JS -->
        <script src="js/collection.js"></script>
        <!--WSUDOR Translation Dictionary-->            
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        <!-- loading collections -->
        <script type="text/javascript"> 
            var searchParams = <?php echo json_encode($_REQUEST); ?>;
            if (jQuery.isEmptyObject(searchParams)){
                window.location = "allcollections.php";

                // collectionsList("collectionPage");                
            }
            else{    
            $(document).ready(function(){
                // updatePage();
                searchGo("collectionPage");
            });
            }    
        </script>
        <!-- ********************************************* -->
    </body>
</html>
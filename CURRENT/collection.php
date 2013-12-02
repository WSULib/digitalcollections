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
        <link rel="stylesheet" href="img/sprites/sprites.css" type="text/css">
        <link rel="stylesheet" href="css/global.css" type="text/css">
        <link rel="stylesheet" href="ico/style.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript">
</script>

<!-- Added by Cole **************** -->            
            <script src="js/utilities.js"></script>
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

                ul.bootpag li{
                    display:inline;                    
                }
                ul.bootpag li.disabled a{
                    color:rgb(230,230,230);
                }
            </style>
            <!-- **************************************** -->
    </head>
    <body>
        <div class="page-wrap">
            <header>
                <!--<div class="container">
                <div class="logo">
                </div>
    
                <div class="nav">
                </div>

                <div class="login">
                    <ul>
                        <li>Login</li>
                        <li>Sign Up</li>
                    </ul>
                </div>

                <div class="search-box">
                </div>
                </div>-->
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
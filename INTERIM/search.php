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
            <!-- Local JS -->
            <script src="js/utilities.js"></script>        
            <script src="js/search.js"></script>
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
                    /*display:inline;                    */
                    background-color:#FFFFA9;                    
                }
                .hidden_facet {
                    /*display:none;*/
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
                    <!-- Facet Refines ############################################################################################################ -->
                    <!-- <div class="row-fluid">
                        <div id="facet_refine">
                            <h5>Refined By:</h5>
                            <ul id="facet_refine_list"></ul>
                        </div>
                    </div> -->
                    <ul>                    
                        <li id="facet_refine">
                            <h5>Refined By:</h5>
                            <ul id="facet_refine_list"></ul>
                        </li>
                    </ul>
                    <!-- Facet Refines ############################################################################################################ -->                        
                        
                        <!--
                        <ul>
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
                        </ul>-->
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

                        <!--
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="collection col-lg-12 col-xlg-12">
                                <div class="image pull-right col-lg-3 col-xlg-3">
                                    <img src="http://placehold.it/460x368">
                                </div>
                        
                                <div class="collection-details col-lg-9 col-xlg-9">
                                    <h4 class="object-title">
                                        Changing Face of the Auto Industry
                                    </h4>
                                    <span class="object-creator">
                                        Creator,
                                    </span>
                                    <span class="object-date">
                                        1920
                                    </span>
                                    <p class="object-description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate temporibus iste magni quibusdam ex porro ullam perspiciatis exercitationem. Molestias, molestiae voluptatem veritatis laborum repudiandae necessitatibus totam in deserunt architecto.
                                    </p>
                                </div>
                            </div>

                        </div> -->

                       
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
            <!--<div class="container">
                <div class="uni-logo">
                </div>

                <div class="copyright">
                </div>

                <div class="footer-nav"> links to wsu and library, contact, terms of use, privary policy
                </div>

            
            </div>-->
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
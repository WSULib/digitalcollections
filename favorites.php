<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Favorites | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
          
        <!-- page specific dependencies -->
        <script src="js/favorites.js?v=<?php echo date('n-j-Y'); ?>"></script>

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
                
            </div><!-- /row for sub-header -->            

            <div id="results_container" class="main-container-wide favorites">
                
                <ul class="row-fluid objects-container">
                    <!-- results template -->
                </ul>
            </div><!-- /objects -->

            <div class="pagination-centered">
                    <!-- pagination -->
            </div><!-- /pagination -->
              
        </div> <!-- /container -->

        <?php include('inc/footer.php'); ?>

    </body>
    <!-- init search -->
    <script type="text/javascript">
    var searchParams = <?php echo json_encode($_GET); ?>;                
    $(document).ready(function(){         	
    	getFavs(searchParams);    	        
    });    
</script>
</html>
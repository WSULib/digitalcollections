<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Collections | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
      
        <!-- page specific dependencies -->
        <script src="js/allcollections.js?v=<?php echo date('n-j-Y'); ?>"></script>

    </head>
    <body>
        <?php include('inc/header.php'); ?>

            <div class="container">
                <div class="sub-header">
                    <h2>
                        Collections
                    </h2>
                </div><!--  / sub-header -->
                
                <div class="row-fluid">
                	<div class="loader">
                    		<p>Loading Collections...</p>
                		</div>
                    <div class="collection_contents" style="display:none;">
                    </div>                    
                </div>

                <div class="pagination clearfix">
                </div>
            </div>

        <?php include('inc/footer.php'); ?>

        <!-- loading collections -->
        <script type="text/javascript"> 
            var searchParams = {};
            searchGo();                                            
        </script>
    </body>
</html>
<?php
session_start();
$objectPID = $_REQUEST['id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- page rendered as Single Object -->

        <!-- mirador -->
        <link rel="stylesheet" type="text/css" href="inc/mirador/css/mirador-combined.css">
        <link rel="stylesheet" type="text/css" href="css/mirador_local.css">

        <meta charset="utf-8">
        <title><?php echo $response['response']['docs'][0]['mods_title_ms'][0];?> | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
          
        <!-- page specific dependencies -->
        <script src="js/singleObject.js?v=<?php echo date('n-j-Y'); ?>"></script>        
        <script type="text/javascript">var switchTo5x=true;</script>
        

    </head>

    <body>

    	<?php include('inc/struct_data.php'); ?>
        <?php include('inc/header.php'); ?>

        <div id="templateCM" class="container">
        	
            <div class="row">
	            <div class="breadcrumb col-md-3">               
	                <a href="#" onclick="window.history.back(); return false;" style="font-size:17px;"><span style="font-size:20px; margin-right:5px;">&laquo;</span> Back</a>
	            </div>
            </div>

            <div class="row">

            	<!-- empty pending work -->
            	<div class="col-md-3 related-objects">                    	              
        		</div>

	            <div class="col-md-6 primary-object">
	                <div class="primary-object-container">
	                </div>

	                <div class=" metadata display-more-info" id="more-info">	
                        <table class="table table-hover"></table>                	
	                </div>
	            </div>

	            <!-- metadata new -->
	            <div class="info-panel col-md-3">
	            </div>

	            <!-- <div class="col-md-6 col-md-offset-3 display-more" id="display-more">                    
	            </div> -->

            </div>

        </div> <!-- closes templateCM -->

        <?php include('inc/footer.php'); ?>       
        
    </body>

    <!--API call-->
    <script type="text/javascript">
        $(document).ready(function(){            
            var singleObjectParams = <?php echo json_encode($_GET); ?>;               
            APIcall(singleObjectParams);   
        })      
    </script>
    
<script type="text/javascript">
    enquire.register("screen and (max-width:991px)", {
        match : function() { 
            // move to top
            $('.info-panel').prependTo('.primary-object');      
        },
        unmatch : function() {
            $('.info-panel').insertAfter('.primary-object');
        }
    });
</script>

</html>

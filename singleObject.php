<?php
session_start();
$objectPID = $_REQUEST['id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $response['response']['docs'][0]['mods_title_ms'][0];?> | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
        <link rel="stylesheet" href="ico/style.css">
        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>

        <script src="js/vendor/bootbox.min.js"></script>
        
        <!-- Local JS -->
        <script src="config/config.js" type="text/javascript"></script>
        <script src="js/utilities.js"></script>        
        <script src="js/singleObject.js"></script>
        <script src="js/userData.js"></script>
        <script src="js/favorites.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/script.js"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 
        <script src="inc/sidr/jquery.sidr.min.js"></script>
        <script src="js/vendor/enquire.min.js"></script>

        <script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>        
        <script type="text/javascript">stLight.options({publisher: "5131cbe9-49f8-4ed4-80d3-75fa951eadad", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

        <link rel="stylesheet" type="text/css" media="screen" href="inc/share.2.6/share/share.css" />
        <script src="inc/share.2.6/share/share.js" type="text/javascript"></script>

    </head>

    <body>

    	<?php include('inc/struct_data.php'); ?>
        <?php include('inc/header.php'); ?>

        <div id="templateCM" class="container">
        	<div class="row">
	            <div class="breadcrumb col-md-3">               
	                <a href="#" onclick="window.history.back(); return false;" style="font-size:17px;"><span style="font-size:20px; margin-right:5px;">&laquo;</span> Back to Search Results</a>
	            </div>
            </div>

            <div class="row">

            	<div class="col-md-3 related-objects">            		            		           		
        		</div>

	            <div class="col-md-6 primary-object">
	                <div class="primary-object-container">
	                </div>

	                <div class=" metadata display-more-info" id="more-info">	                	
	                </div>



	            </div>

	            <!-- metadata new -->
	            <div class="info-panel col-md-3">
	            </div>


	            <div class="col-md-6 col-md-offset-3 display-more" id="display-more">
	            </div>

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
                $('.display-more-info').prependTo('.display-more');
        },
        unmatch : function() {
                $('.display-more-info').insertAfter('.primary-object-container');
        }
    });
</script>

</html>

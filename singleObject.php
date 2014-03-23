<?php
$objectPID = $_REQUEST['id'];
?>

<!DOCTYPE php>
<html>
    <head>
        <meta charset="utf-8">
        <title>Digital Collections - Wayne State University Libraries</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
        <link rel="stylesheet" href="css/glyphicons.css">
        <link rel="stylesheet" href="css/social.css">
        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>

        <script src="js/vendor/bootbox.min.js"></script>
        
        <!-- Local JS -->
        <script src="js/utilities.js"></script>        
        <script src="js/singleObject.js"></script>
        <script src="js/userData.js"></script>
        <script src="js/favorites.js"></script>
        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
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

        <style>
        .social ul li {
            display: inline;
        }
        </style>

    </head>

    <body>
        <?php include('inc/header.php'); ?>


        <div id="templateCM" class="container" itemscope itemtype="http://schema.org/CreativeWork">
            <div class="breadcrumb col-md-3">
               
                <a href="#" onclick="window.history.back(); return false;" style="font-size:17px;"><span style="font-size:20px; margin-right:5px;">&laquo;</span> Back to Search Results</a>
            </div>

            <div class="col-md-6 primary-object">
                <div class="primary-object-container">
                </div>

                <div class="display-more-info" id="more-info">
                    <table class="table table-hover">
                    </table>
                </div>

            </div>

            <!-- metadata new -->
            <div class="info-panel col-md-3">
            </div>


            <div class="col-md-6 col-md-offset-3 display-more" id="display-more">
            </div>

        </div> <!-- closes templateCM -->

        <?php include('inc/footer.php'); ?>       
        
    </body>

    <!--API call-->
    <script type="text/javascript">
        $(document).ready(function(){
            var PID = "<?php echo $objectPID; ?>";          
            APIcall(PID);   
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
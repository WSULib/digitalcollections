<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced Search | Digital Collections | WSULS</title>
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
        
        <!-- Local JS -->
        <script src="config/config.js" type="text/javascript"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/favorites.js"></script>
        <script src="js/userData.js"></script>             
        
        <script src="js/utilities.js"></script>                
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 
        <script src="inc/sidr/jquery.sidr.min.js"></script>
</head>
<body>

    <?php include('inc/header.php'); ?>

    <div class="container">
        <h2>Advanced Search</h2>
          <div class="row">


                <div class="col-md-6 advanced-search">
                    <p>An extremely illuminating and helpful chunk of text here.</p>

                    <form method="post" action="inc/sendmail.php" role="form">

                        <div class="form-group">
                            <label for="q" class="nameLabel">Query</label>
                            <input id="q" type="text" name="q" placeholder="Enter your query string">
                        </div>

                        <div class="form-group">
                            <label for="fq" class="emailLabel">Filter Query Results</label>
                            <input id="fq" type="text" name="fq" placeholder="Enter string to filter results by">
                        </div>
                        
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="">
                            Search Full-Text Only
                          </label>
                        </div>

                        <!-- Filter by Collection -->
                        <div class="form-group">
                            <label for="collection" class="collectionLabel">Filter by Collection:</label>
                            <select id="collection_filter" name="collection" class="form-control"></select>
                        </div>

                        <!-- Filter by Content Type -->                        
                        <div class="form-group">
                            <label for="content-type" class="content-typeLabel">Filter by Content Type:</label>
                            <select id="content-type_filter" name="content-type" class="form-control"></select>
                        </div>


                        <button type="submit" class="btn">Search</button>
                    </form>
                </div>

            </div>
    </div>
    
    <?php include('inc/footer.php'); ?>
<script type="text/javascript"> 
    getImage(array);              
</script>    
</body>
</html>
<!DOCTYPE php>
<html>
    <head>
        <meta charset="utf-8">
        <title>Digital Collections - Wayne State University Libraries</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/main.css" type="text/css">
        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

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


        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>

<script type="text/javascript" src="js/script.js"></script>

</head>
<body>

    <?php include('inc/header.php'); ?>

	<div class="container">
		<div class="facets volume-view">
            <img src="img/DFQ.png" alt="" style="max-width:100%;border: 1px solid #ddd;">
            <ul class="buttons">
                <li class="add-to-favorites" onclick="addFav();">
                    <img src="img/star.png" alt=""> Add to Favorites
                </li>
                <li class="share">                                    
                    <img src="img/share.png" alt=""> Share Object
                </li>
            </ul>

            <p class="volumes-header"><span>Volumes in the Collection</span></p>

            <ul class="toc">
                <li class="button"><span class="facet-toggle">&#9654;</span> <a href="journal-volume.php">Volume 1</a></li>
                <li class="facet active">
                    <ul>
                        <li><a href="http://lib/digitalcollections/CURRENT/singleObject.php?PID=wayne:DFQv3i2">Issue 1</a></li>
                        <li>Issue 2</li>
                        <li>Issue 3</li>
                    </ul>
                </li>
                <li class="button">
                    <span class="facet-toggle">&#9654;</span> <a href="journal-volume.php">Volume 2</a></li>
                <li class="facet">
                    <ul>
                        <li>Issue 1</li>
                        <li>Issue 2</li>
                        <li>Issue 3</li>
                    </ul>
                </li>
                <li class="button">
                    <span class="facet-toggle">&#9654;</span> <a href="journal-volume.php">Volume 3</a></li>
                <li class="facet">
                    <ul>
                        <li>Issue 1</li>
                        <li>Issue 2</li>
                        <li>Issue 3</li>
                    </ul>
                </li>
            </ul>
        </div>
		<div class="main-container">
			<h3 class="title">
                    <a href="journal.php">Detroit Focus Quarterly</a> &raquo; Volume 1
                </h3>
                
                <ul class="row-fluid issues-container">
                	<li class="issue-container-grid">
                		<div class="crop">
                			<a href="http://lib/digitalcollections/CURRENT/singleObject.php?PID=wayne:DFQv3i2">
                				<img src="img/dfq_1.jpg" alt="">
                			</a>
                		</div>
                        <h3>Detroit Focus Quarterly Volume 1 Issue 1</h3>
                	</li>
                	<li class="issue-container-grid">
                		<div class="crop">
                			<a href="">
                				<img src="img/dfq_1.jpg" alt="">
                			</a>
                		</div>
                        <h3>Detroit Focus Quarterly Volume 1 Issue 2</h3>
                	</li>
                	<li class="issue-container-grid">
                		<div class="crop">
                			<a href="">
                				<img src="img/dfq_1.jpg" alt="">
                			</a>
                		</div>
                        <h3>Detroit Focus Quarterly Volume 1 Issue 3</h3>
                	</li>
                    <li class="issue-container-grid">
                        <div class="crop">
                            <a href="">
                                <img src="img/dfq_1.jpg" alt="">
                            </a>
                        </div>
                        <h3>Detroit Focus Quarterly Volume 1 Issue 4</h3>
                    </li>
                    <li class="issue-container-grid">
                        <div class="crop">
                            <a href="">
                                <img src="img/dfq_1.jpg" alt="">
                            </a>
                        </div>
                        <h3>Detroit Focus Quarterly Volume 1 Issue 5</h3>
                    </li>
                </ul>
		</div>
	</div>

    <?php include('inc/footer.php'); ?>
	
</body>
</html>
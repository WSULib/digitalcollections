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

        <style>
            .toc > li {
                margin: 0;
            }
        </style>

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
                <li class="button"><span class="facet-toggle">&#9660;</span> <a href="journal-volume.php">Volume 1</a></li>
                <li class="facet active">
                    <ul>
                        <li><a href="journal-volume-issue.php">Issue 1</a></li>
                        <li>Issue 2</li>
                        <li>Issue 3</li>
                    </ul>
                </li>
                <li class="button">
                    <span class="facet-toggle">&#9660;</span> <a href="journal-volume.php">Volume 2</a></li>
                <li class="facet">
                    <ul>
                        <li>Issue 1</li>
                        <li>Issue 2</li>
                        <li>Issue 3</li>
                    </ul>
                </li>
                <li class="button">
                    <span class="facet-toggle">&#9660;</span> <a href="journal-volume.php">Volume 3</a></li>
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
                    Detroit Focus Quarterly
                </h3>
                
                <p class="description" style="font-size: 13px;">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, cumque voluptatem quibusdam cupiditate nesciunt beatae autem eos nisi repellat! Saepe, magni, perspiciatis soluta laboriosam ipsum quis expedita aliquid aut perferendis nisi eligendi dolorem voluptates consequatur reiciendis iste eum nulla et sequi doloribus illo veritatis non harum cupiditate! Sequi, esse, quasi, consectetur nisi sed illo et magnam cumque unde dicta porro nulla adipisci provident modi excepturi cum nesciunt fugiat soluta incidunt assumenda voluptate ipsum repellendus delectus odio nostrum quibusdam vel fuga! Sint, itaque, ipsum inventore pariatur libero rerum nihil eligendi reiciendis aut cumque asperiores quod quam porro nostrum cupiditate ut iure.
                </p>
                <!-- <div class="more-info-clickr button" style="float:right;"><span class="more-info">More Info</span></div> -->

                <div class="metadata">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Date:</td>
                                <td>1914-1968</td>
                            </tr>
                            <tr>
                                <td>Subject:</td>
                                <td>Automobile factories--History<br>
                               Automobile factories--Michigan--Detroit--History<br>
                               Dodge automobile--History<br>
                               Automobile industry and trade--History</td>
                            </tr>
                            <tr>
                                <td>Rights:</td>
                                <td>Users can cite and link to these materials without obtaining permission. Users can also use the materials for non-commercial educational and research purposes in accordance with fair use. For other uses or to obtain high resolution images, please contact the copyright holder.</td>
                            </tr>
                            <tr>
                                <td>Full record:</td>
                                <td><a href="#">Download MODS File</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="volumes row">
                    <ul>
                        <li><span style="font-size: 12px; width:30px;display:inline-block;text-transform:uppercase;">View Vol#</span> <span style="font-size:36px;">1</span></li>
                        <li><span style="font-size: 12px; width:30px;display:inline-block;text-transform:uppercase;">View Vol#</span> <span style="font-size:36px;">2</span></li>
                        <li><span style="font-size: 12px; width:30px;display:inline-block;text-transform:uppercase;">View Vol#</span> <span style="font-size:36px;">3</span></li>
                        <li><span style="font-size: 12px; width:30px;display:inline-block;text-transform:uppercase;">View Vol#</span> <span style="font-size:36px;">4</span></li>
                        <li><span style="font-size: 12px; width:30px;display:inline-block;text-transform:uppercase;">View Vol#</span> <span style="font-size:36px;">5</span></li>
                        <li><span style="font-size: 12px; width:30px;display:inline-block;text-transform:uppercase;">View Vol#</span> <span style="font-size:36px;">6</span></li>
                        <li><span style="font-size: 12px; width:30px;display:inline-block;text-transform:uppercase;">View Vol#</span> <span style="font-size:36px;">7</span></li>
                    </ul>
                </div> -->

                
		</div>
	</div>

	<?php include('inc/footer.php'); ?>
	
</body>
</html>
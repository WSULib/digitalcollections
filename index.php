<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Digital Collections | Wayne State University Libraries</title>
  <meta name="viewport" content="initial-scale=1">

	<link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
        <link rel="stylesheet" href="ico/style.css">

        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic|Marcellus+SC' rel='stylesheet' type='text/css'>

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
        <script src="js/collection.js"></script>
        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 
        <script src="inc/sidr/jquery.sidr.min.js"></script>
</head>
<body class="index-bg">
	<?php include('inc/header.php'); ?>
	<div class="masthead cf masthead-overflowing">
        <div class="slides-wrap">
            <div class="slide photo" id="mh-slide-24956">
              <img data-pm-sized="yes" src="img/masthead1.jpeg" alt="Changing Face of the Auto Industry"></div>
        </div>
    </div>

    <div class="container feature">
        <div class="col-sm-6 col-md-7">
            <span class="featured-collection">Featured Collection</span>
            <h3><a href="/digitalcollections/item?start=0&id=wayne:collectionCFAI">Changing Face of the Auto Industry</a></h3>
           <!-- button to view collection -->
        </div>
        <div class="col-sm-6 col-md-5">
            <ul class="slider pull-right">
                <li class="thumbs"><img src="img/masthead1.jpeg" alt=""></li>
                <li class="thumbs"><img src="img/masthead2.jpeg" alt=""></li>
                <li class="thumbs"><img src="img/masthead3.jpeg" alt=""></li>
            </ul>
        </div>
    </div>

    <div class="container feature-bottom">
        <div class="col-md-6 featured-item">
            <div class="featured-image">
              <?php
                $rss = new DOMDocument();
                $rss->load('http://blogs.wayne.edu/digitalcollections/category/featured-item/feed/');
                $feed = array();
                foreach ($rss->getElementsByTagName('item') as $node) {
                  $item = array ( 
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'content' => $node->getElementsByTagName('encoded')->item(0)->nodeValue,
                    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                    );
                  array_push($feed, $item);
                }
                $limit = 1; 
                for($x=0;$x<$limit;$x++) {
                  $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                  $link = $feed[$x]['link'];
                  $content = $feed[$x]['content'];
                  $description = $feed[$x]['desc'];
                  $date = date('M d, Y', strtotime($feed[$x]['date']));


                  echo   ''.$content.'';
                }
              ?>
            </div>
        </div>
        <div class="col-md-6">
            <h4>Welcome to the WSU Digital Collections</h4>
            <p>The Wayne State University Library System, through its digital publishing initiatives, strives to bring unique, important, or institutionally relevant content to Wayne State University’s academic community and to the larger world.  Our Digital Collections represent text, images, and audiovisual material that support this mission through a diversity of projects.</p>
            <h4>Most Recent News</h4>
            <?php
                $rss = new DOMDocument();
                $rss->load('http://blogs.wayne.edu/digitalcollections/category/news/feed/');
                $feed = array();
                foreach ($rss->getElementsByTagName('item') as $node) {
                  $item = array ( 
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                    );
                  array_push($feed, $item);
                }
                $limit = 1; // number of posts to show
                for($x=0;$x<$limit;$x++) {
                  $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                  $link = $feed[$x]['link'];
                  $description = $feed[$x]['desc'];
                  $date = date('M d, Y', strtotime($feed[$x]['date']));


                  echo   '<h5><a href="'.$link.'" title="'.$title.'" target="_blank">'.$title.'</a></h5>';
                  echo   '<p>'.$description.'
                          <p class="date">Posted on '.$date.'</p><p class="more"><a href="'.$link.'" title="'.$title.'" target="_blank">Read more &raquo;</a></p>';
                }
              ?>
        </div>
    </div>
	
	<?php include('inc/footer.php'); ?>
	
</body>
</html>
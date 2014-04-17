<!doctype html>
<html lang="en" >

 <head>
  <meta charset="utf-8" />  
  <meta name="keywords" content="IIPImage HTML5 Ajax IIP Zooming Streaming High Resolution Mootools"/>
  <meta name="description" content="IIPImage: High Resolution Remote Image Streaming Viewer"/>
  <meta name="copyright" content="&copy; 2003-2011 Ruven Pillay"/>
  <meta name="viewport" content="initial-scale=1">  
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta http-equiv="X-UA-Compatible" content="IE=9" />

  <link rel="stylesheet" type="text/css" media="all" href="css/iip.css" />
  <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" media="all" href="css/ie.css" />
  <![endif]-->

  <link rel="shortcut icon" href="images/iip-favicon.png" />
  <link rel="apple-touch-icon" href="images/iip.png" />

  <title>Image Viewer | Digital Collections | WSULS</title>
  <!-- digitalcollections files-->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/imageviewer_tiled.js"></script>
  <script src="js/utilities.js"></script>

  <!-- viewer specific -->
  <script type="text/javascript" src="inc/mooviewer/mootools-core-1.3.2-full-nocompat.js"></script>
  <script type="text/javascript" src="inc/mooviewer/mootools-more-1.3.2.1.js"></script>
  <script type="text/javascript" src="inc/mooviewer/protocols.js"></script>
  <script type="text/javascript" src="inc/mooviewer/iipmooviewer-2.0.js"></script>

  <!--[if lt IE 7]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js">IE7_PNG_SUFFIX = ".png";</script>
  <![endif]-->  

  <style type="text/css">
    body{ height: 100%; }
    #viewer{ width: 100%; height: 100%;}
    #downloads{height:20px; width:100%; color:white; position:absolute; z-index:1000;}
    #downloads a{cursor:pointer; color:red;}
  </style>

 </head>

 <body>
   <div id="downloads">
   	<p>Download <a id="fullsize">fullsize JPEG</a> / <a id="mediumsize">medium JPEG</a></p>
   </div>

   <div id="viewer"></div>

  </body>

  <script type="text/javascript">
    var imageParams = <?php echo json_encode($_GET); ?>;
    $(document).ready(function(){        
      launch(imageParams);
    });    
  </script>

</html>

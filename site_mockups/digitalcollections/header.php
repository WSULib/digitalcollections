<?php require_once('connect.php') ?>

<!doctype html>
<html lang="en" class="<?php echo implode(" ", $htmlClasses) ?>">
<head>
<!-- META TAGS -->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1">
<meta name="keywords" content="Wayne State University, WSU, Library System, Libraries" />
<meta name="description" content="<?php echo $page['meta']['description'] ?>" />
<meta name="author" content="libwebmaster@wayne.edu" />
<meta name="Copyright" content="Copyright (c) <?php echo(date('Y')); ?> Wayne State University" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- TITLE TAG -->
<title><?php echo createTitle($pageTitle) ?></title>
<!-- LINK TAGS -->
<link href="<?php echo $hostOrgin ?>/img/wsu-shield3.ico" rel="icon" type="image/x-icon" />
<link href="<?php echo $hostOrgin ?>/fonts/Open-Sans/css/fonts.css" rel="stylesheet" type="text/css">
<link href="<?php echo $host ?>/css/index.css?date=<?php echo date("m/d/Y") ?>999993" rel="stylesheet" type="text/css">


<script src="<?php echo $hostOrgin ?>/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $hostOrgin ?>/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $hostOrgin ?>/js/jquery.easing.min.js" type="text/javascript"></script>
<script src="<?php echo $host ?>/js/masonry.pkgd.min.js" type="text/javascript"></script>
<script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>

<!-- <script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCWd1VRStd_yM5Vo1A3kraC5CaeWcTiXds"></script> -->
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3&client=AIzaSyCWd1VRStd_yM5Vo1A3kraC5CaeWcTiXds&sensor=false" /> -->
<!--
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false">
</script>
<script type="text/javascript">

function initialize()
{
    var myLatLng = new google.maps.LatLng(28.617161,77.208111);
    var map = new google.maps.Map(document.getElementById("map"),
    {
        zoom: 17,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker = new google.maps.Marker(
    {
        position: myLatLng,
        map: map,
        title: 'Rajya Sabha'
    });
}

</script>
-->

<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">

function initialize() {
    var myLatlng = new google.maps.LatLng(43.565529, -80.197645);
    var mapOptions = {
        zoom: 8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById('map-results'), mapOptions);

     //=====Initialise Default Marker    
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: 'marker'
     //=====You can even customize the icons here
    });

     //=====Initialise InfoWindow
    var infowindow = new google.maps.InfoWindow({
      content: "<B>Skyway Dr</B>"
  });

   //=====Eventlistener for InfoWindow
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
 -->


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyBscp8mCaP-xv8JwNHUJi148mxWZtHX5Qg"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.min.js"></script>

<script type="text/javascript">

<?php echo $htmlHeadScript ?>

</script>

<script type="text/javascript">

host = "<?php echo $host ?>";
query = "<?php echo $_GET['search']; ?>";
year = <?php echo date("Y"); ?>;

</script>

<script src="<?php echo $host ?>/js/index.js?date=<?php echo date("m/d/Y") ?>" type="text/javascript"></script>

<?php echo $pageAdditionalHeadTags ?>



</head>
<body>

<?php require_once('header-bar.php') ?>
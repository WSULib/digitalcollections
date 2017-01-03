<?php





















// $itemsall = array();
require_once("mapdata.php");
require_once("mapdata2.php");
require_once("mapdata3.php");
require_once("mapdata4.php");
require_once("mapdata5.php");
require_once("mapdata6.php");
require_once("mapdata_warren.php");
require_once("mapdata_canfield.php");
require_once("mapdata_cass.php");
require_once("mapdata_adams.php");
require_once("mapdata_fort.php");
require_once("mapdata_12th.php");
// require_once("mapdata_grand.php");
require_once("mapdata_vernor.php");
require_once("mapdata_trumbull.php");
require_once("mapdata_jefferson.php");
require_once("mapdata_myrtle.php");
require_once("mapdata_larned.php");

// $items2 = array_merge($items1, $items2, $items3, $items4, $items5, $items6);
$items2 = array();
foreach ($items as $key => $item_single) {
  $items2 = array_merge($items2, $item_single);
}



foreach ($items2 as $key => $item) {

  // echo 6775;

	// $phrase = getPhraseFromTitle( $item["title"] );

	// $geo = $phraseToGeo[ $phrase ];

	// $geo["formatted_address"];
	// $geo["geometry"]["location"]["lat"];
	// $geo["geometry"]["location"]["lng"];
	if ($item["geo"]["formatted_address"] != null) {
    // echo 22;
		$markersJson []= array(
			"id" => substr($item["id"], 6),
			"title" => $item["title"],
			// "description" => $item["description"],
			"thumbnail" => $item["thumbnail"],
			"date" => $item["date"],
			"year" => substr($item["date"], 0, 4),
      "phrase" => $item["phrase"],
      "formatted_address" => $item["geo"]["formatted_address"],
			"lat" => $item["geo"]["geometry"]["location"]["lat"],
			"lng" => $item["geo"]["geometry"]["location"]["lng"],
		);
	}
	

}


$htmlHeadScript = "markers = " . json_encode($markersJson) . ";";





$htmlClasses []= "map";


?>
<?php require_once("header.php"); ?>


<!--
<script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWd1VRStd_yM5Vo1A3kraC5CaeWcTiXds&callback=initMap">
    </script>
-->

<!-- <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
 -->


<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWd1VRStd_yM5Vo1A3kraC5CaeWcTiXds&sensor=false" />
 -->
<div id="map-page">

	<div id="map-options">

		<div style="padding:20px;-webkit-font-smoothing: antialiased;">

			<div>
				<label for="amount" style="float:left;font-weight:400;">Year Range:</label>
				<span id="slider-range-amount" style="color:#f6931f;font-weight:600;margin-left:10px;"></span>
			</div>

			<div style="padding:10px;">
				<div id="slider-range"></div>
			</div>

			<br>

			

		</div>



<!-- 		<div id="search-options-collapse"></div>
		<div class="search-option">
			<div class="search-option-title">Content Type</div>
			<div class="search-option-list"></div>
		</div>
		<div class="search-option">
			<div class="search-option-title">Collection</div>
			<div class="search-option-list"></div>
		</div>
		<div class="search-option">
			<div class="search-option-title">Date</div>
			<div class="search-option-list"></div>
		</div>
		<div class="search-option">
			<div class="search-option-title">Subject</div>
			<div class="search-option-list"></div>
		</div>
		<div class="search-option">
			<div class="search-option-title">Creator</div>
			<div class="search-option-list"></div>
		</div>
		<div class="search-option">
			<div class="search-option-title">Publisher</div>
			<div class="search-option-list"></div>
		</div> -->



	</div>

	<div id="map"></div>

	<div style="clear:both;"></div>

</div>




<?php require_once("footer.php"); ?>
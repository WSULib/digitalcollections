<?php require_once("header.php"); ?>
<?php




function formatProperty($prop) {
	return ucwords( str_replace("_", " ", $prop) );
}



// $query = $_POST['query'];
$query = "detroit building";
$query = urlencode($query);

$numberOfResults = 1;


$data_string = "q=".$query."&start=0&rows=".$numberOfResults."&wt=json&functions%5B%5D=solrSearch";

// echo $data_string;


$ch = curl_init('http://digital.library.wayne.edu/WSUAPI?');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//         'Content-Type: application/json',
//         'Content-Length: ' . strlen($data_string))
// );

$results = curl_exec($ch);
$results = json_decode($results, true);



// echo "<pre>";
// print_r($results);
// echo "</pre>";

// $results["solrSearch"]["response"]["docs"][0]


// $resultsFinal []= array(
// 	'id' => $result['id'],
// 	'url' => "http://digital.library.wayne.edu/digitalcollections/item?id=" . $result['id'],
// 	'title' => $SearchParser->replaceWithBold( $SearchParser->queryKeywords, $result['dc_title'][0] ),
// 	'description' => $SearchParser->replaceWithBold( $SearchParser->queryKeywords, $result['dc_description'][0] ),
// 	'isSensitive' => $result['rels_isSensitive'][0],
// );


foreach ($results['solrSearch']['response']['docs'] as $key => $result) {

	// echo "<pre>";
	// print_r($result);
	// echo "</pre>";


	# code...
	$item = array(
		'id' => $result['id'],
		'url' => "http://digital.library.wayne.edu/digitalcollections/item?id=" . $result['id'],
		'title' => $result['dc_title'][0],
		'subjects' => $result['mods_subject_topic_ms'][0],
		'date' => $result['dc_date'][0],
		'collection' => $result['mods_host_title_ms'][0],
		'size' => $result['obj_size_human'][0],
		'resource_type' => $result['mods_resource_type_ms'][0],
		'creator' => $result['mods_reversed_name_creator_ms'][0],



		'description' => $result['dc_description'][0],
		'is_sensitive' => $result['rels_isSensitive'][0],
		'thumbnail' => "https://digital.library.wayne.edu/loris/fedora:" . $result['id'] . "%7CTHUMBNAIL/full/full/0/default.jpg",
		'image' => "https://digital.library.wayne.edu/loris/fedora:" . $result['id'] . "%7CPREVIEW/full/full/0/default.jpg",


	);

	if ($key == $numberOfResults-1) {
		break;
	}
}




?>


<div id="viewer">
	<div id="viewer-nest">
		<img src="<?php echo $item['image'] ?>" />
	</div>
</div>


<div id="details">
	<div id="details-nest">
		<h1><?php echo $item['title'] ?></h1>
<!-- 		<div>
			<?php echo $item['description'] ?>
		</div> -->
		<div id="details-nest-left">
			
<!-- 			<div>
				<div>Subjects:</div><?php echo implode(' ', $item['subjects'] ) ?>
			</div> -->
			<div>
				<div class="label">Resource Type</div>
				<a href="#"><?php echo $item['resource_type'] ?></a>
			</div>
			<div>
				<div class="label">Collection</div>
				<a href="#"><?php echo $item['collection'] ?></a>
			</div>
			<div>
				<div class="label">Date</div>
				<a href="#"><?php echo $item['date'] ?></a>
			</div>
			<div>
				<div class="label">Creator</div>
				<a href="#"><?php echo $item['creator'] ?></a>
			</div>
			<div>
				<div class="label">Size</div>
				<a href="#"><?php echo $item['size'] ?></a>
			</div>
		</div>
		<div id="details-nest-right">
			<div id="details-nest-right-download">
				<div class="label">Download</div>
				<a href="download.php?id=<?php echo $item['id'] ?>">Small</a>
				<a href="download.php?id=<?php echo $item['id'] ?>">Medium</a>
				<a href="download.php?id=<?php echo $item['id'] ?>">Large</a>
				<a href="download.php?id=<?php echo $item['id'] ?>">Full Size</a>
			</div>
			<div>
				<div class="label">Share</div>
				<a href="#">Facebook</a>
				<a href="#">Twitter</a>
				<a href="#">Instagram</a>
				<a href="#">Pinterest</a>
			</div>
			<div>
				<div class="label">Order</div>
				<a href="download.php?id=<?php echo $item['id'] ?>">Original Scan</a>
				<a href="download.php?id=<?php echo $item['id'] ?>">Art Print</a>
			</div>
		</div>
	</div>
</div>


<div id="item-data">
	<?php

	$props = array(
		"title",
		"resource_type",
		"collection",
		"date",
		"size",
	);

	?>
	<?php foreach($props as $prop): ?>
		<div>
			<div class="label"><?php echo formatProperty($prop) ?></div>
			<a href="#"><?php echo $item[$prop] ?></a>
		</div>
	<?php endforeach ?>
</div>


<?php require_once("footer.php"); ?>
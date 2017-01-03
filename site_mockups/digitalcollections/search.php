<?php




function formatProperty($prop) {
	return ucwords( str_replace("_", " ", $prop) );
}



// $query = $_POST['query'];
$query = "detroit building";
$query = "digital dress";
$query = $_GET['search'];
$queryURLEncoded = urlencode($query);

$numberOfResults = 100;


$data_string = "q=".$queryURLEncoded."&start=0&rows=".$numberOfResults."&wt=json&functions%5B%5D=solrSearch";

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
	$items [] = array(
		'id' => $result['id'],
		'url' => "http://digital.library.wayne.edu/digitalcollections/item?id=" . $result['id'],
		'title' => $result['dc_title'][0],
		'subjects' => $result['mods_subject_topic_ms'][0],
		'date' => $result['dc_date'][0],
		'collection' => $result['mods_host_title_ms'][0],
		'size' => $result['obj_size_human'][0],
		'content_type' => $result['dc_type'][0],
		'resource_type' => $result['mods_resource_type_ms'][0],
		'creator' => $result['mods_reversed_name_creator_ms'][0],

		'note' => $result['mods_otherFormat_note_ms'][0],
		'credits' => $result['mods_note_creditLine_ms'][0],

		'subjects' => $result['dc_subject'],
		'coverage' => $result['dc_coverage'],




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
<?php require_once("header.php"); ?>


<div id="search-page">

	<div id="search-options">
		<div id="search-options-collapse"></div>
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
		</div>
	</div>

	<div id="search-results">

		<div id="search-results-facets">
			<?php if ( $_GET['content_type'] ): ?>
				<div class="facet">
					<div class="facet-remove"></div>
					<div class="facet-label">Content Type:</div>
					<div class="facet-value"><?php echo ucwords($_GET['content_type']) ?></div>
				</div>
			<?php endif; ?>
		</div>

		<div id="search-results-loading"></div>

		<!-- <div id="search-results-ne"> -->
			<div id="search-results-nest">
				<?php foreach ( $items as $item ): ?>
					<div class="search-result">
						<a class="search-result-imgwrap" href="<?php echo $host ?>/view.php?id=<?php echo $item['id'] ?>"><img src="<?php echo $item['thumbnail'] ?>" /></a>
						<a class="search-result-title" href="<?php echo $host ?>/view.php?id=<?php echo $item['id'] ?>"><?php echo $item['title'] ?></a>
						<a class="search-result-description" href="<?php echo $host ?>/view.php?id=<?php echo $item['id'] ?>"><?php echo strlen($item['description']) > 50 ? trim(substr($item['description'], 0, 100)) . "..." : $item['description'] ?></a>
					</div>
				<?php endforeach ?>
			</div>
		<!-- </div> -->
	</div>

	<div style="clear:both;"></div>
</div>


<?php require_once("footer.php"); ?>
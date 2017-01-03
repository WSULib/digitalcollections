<?php




function formatProperty($prop) {
	return ucwords( str_replace("_", " ", $prop) );
}



// $query = $_POST['query'];
$itemIdentifier = $_GET["id"];
// $query = $_GET['search'];
$queryURLEncoded = urlencode($itemIdentifier);

$numberOfResults = 1;


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
	$item = array(
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
		'publisher' => $result['dc_publisher'][0],

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


<div id="viewer">
	<div id="viewer-nest">
		<img src="<?php echo $item['image'] ?>" />
	</div>
	<div id="viewer-ribbon">
		<div id="viewer-ribbon-prev"></div>
		<div id="viewer-ribbon-next"></div>
		<div id="viewer-ribbon-nest">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
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
				<a href="download.php?id=<?php echo $item['id'] ?>&amp;title=<?php echo $item['title'] ?>">Small</a>
				<a href="download.php?id=<?php echo $item['id'] ?>&amp;title=<?php echo $item['title'] ?>">Medium</a>
				<a href="download.php?id=<?php echo $item['id'] ?>&amp;title=<?php echo $item['title'] ?>">Large</a>
				<a href="download.php?id=<?php echo $item['id'] ?>&amp;title=<?php echo $item['title'] ?>">Full Size</a>
			</div>
			<div id="details-nest-right-share">
				<div class="label">Share</div>
				<a id="details-nest-right-share-facebook" href="#">Facebook</a>
				<a id="details-nest-right-share-twitter" href="#">Twitter</a>
				<a id="details-nest-right-share-instagram" href="#">Instagram</a>
				<a id="details-nest-right-share-pinterest" href="#">Pinterest</a>
			</div>
<!-- 			<div id="details-nest-right-order">
				<div class="label">Order</div>
				<a href="download.php?id=<?php echo $item['id'] ?>">Original Scan</a>
				<a href="download.php?id=<?php echo $item['id'] ?>">Art Print</a>
			</div> -->
			<div id="details-nest-right-order">
				<div class="label">Permissions</div>
				<a href="download.php?id=<?php echo $item['id'] ?>">Inquire</a>
				<!-- <a href="download.php?id=<?php echo $item['id'] ?>">Inquire</a> -->
			</div>
		</div>
	</div>
</div>


<div id="item-data">
	<div id="item-data-nest">
		<div id="item-data-left">
			<h1>Item Data</h1>
			<?php if ( $item["title"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("title") ?></div>
					<div><?php echo $item["title"] ?></div>
				</div>
			<?php endif ?>
			<?php if ( $item["creator"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("creator") ?></div>
					<div><?php echo $item["creator"] ?></div>
				</div>
			<?php endif ?>
			<?php if ( $item["publisher"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("publisher") ?></div>
					<div><?php echo $item["publisher"] ?></div>
				</div>
			<?php endif ?>
			<?php if ( $item["collection"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("collection") ?></div>
					<a href="#"><?php echo $item["collection"] ?></a>
				</div>
			<?php endif ?>
			<?php if ( $item["subjects"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("subjects") ?></div>
					<div>
						<?php foreach ( $item["subjects"] as $subject ): ?>
							<div><a href="#"><?php echo $subject ?></a></div>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>
			<?php if ( $item["coverage"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("coverage") ?></div>
					<div>
						<?php foreach ( $item["coverage"] as $subject ): ?>
							<div><a href="#"><?php echo $subject ?></a></div>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>
			<?php if ( $item["date"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("date") ?></div>
					<a href="#"><?php echo $item["date"] ?></a>
				</div>
			<?php endif ?>
			<?php if ( $item["creator"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("creator") ?></div>
					<a href="#"><?php echo $item["creator"] ?></a>
				</div>
			<?php endif ?>
			<?php if ( $item["id"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("identifier") ?></div>
					<div><?php echo $item["id"] ?></div>
				</div>
			<?php endif ?>
			<?php if ( $item["resource_type"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("resource_type") ?></div>
					<div><?php echo $item["resource_type"] ?></div>
				</div>
			<?php endif ?>
			<?php if ( $item["content_type"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("content_type") ?></div>
					<div><?php echo $item["content_type"] ?></div>
				</div>
			<?php endif ?>
			<?php if ( $item["size"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("size") ?></div>
					<div><?php echo $item["size"] ?></div>
				</div>
			<?php endif ?>
			<?php if ( $item["note"] ) : ?>
				<div>
					<div class="label"><?php echo formatProperty("note") ?></div>
					<div><?php echo $item["note"] ?></div>
				</div>
			<?php endif ?>
		</div>
		<div id="item-data-right">
			<h1>Cite This Item</h1>
			<div>
				<div class="label">MLA FORMAT</div>
				<div class="cite">
					<?php echo $item["creator"] ? $item["creator"] . ", " : "" ?>Wayne State University Library. "<?php echo $item["title"] ?>" <i>Wayne State University Library Digital Collections</i>. <?php echo $item["date"] ?>. <?php echo $item["url"] ?>
				</div>
			</div>
			<div>
				<div class="label">APA FORMAT</div>
				<div class="cite">
					<?php echo $item["creator"] ? $item["creator"] . ", " : "" ?>Wayne State University Library. (<?php echo $item["date"] ?>). <?php echo $item["title"] ?>. Retrieved from <?php echo $item["url"] ?>
				</div>
			</div>
			<div>
				<div class="label">CHICAGO/TURABIAN FORMAT</div>
				<div class="cite">
					<?php echo $item["creator"] ? $item["creator"] . ", " : "" ?>Wayne State University Library. "<?php echo $item["title"] ?>" Wayne State University Library Digital Collections. Accessed <?php echo date("F j, Y") ?>. <?php echo $item["url"] ?>
				</div>
			</div>
			<div>
				<div class="label">WIKIPEDIA CITATION</div>
				<div class="cite">
					<div>
						&lt;ref name=NYPL&gt;{{cite web | url=<?php echo $item["url"] ?> | title= (<?php echo $item["resource_type"] ?>) <?php echo $item["title"] ?> }} |author=Digital Collections, Wayne State University Library |accessdate=<?php echo date("F j, Y") ?> |publisher=Wayne State University Library}}&lt;/ref&gt;
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php require_once("footer.php"); ?>
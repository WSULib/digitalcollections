<?php //require_once("header.php"); ?>
<?php



function formatProperty($prop) {
	return ucwords( str_replace("_", " ", $prop) );
}



$itemId = $_GET["id"];
$itemTitle = $_GET["title"];

$file_url = "https://digital.library.wayne.edu/loris/fedora:" . $itemId . "%7CPREVIEW/full/full/0/default.jpg";

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . formatProperty($itemTitle) . "\""); 
readfile($file_url);




?>
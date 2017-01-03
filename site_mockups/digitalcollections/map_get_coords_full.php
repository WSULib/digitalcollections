<?php





/*

Traffic; Woodward Avenue At Michigan.
Traffic; Jefferson Avenue East; At Woodward; At Bates.
Traffic; Michigan Avenue At Woodward.
Churches; Jewish; Temple Beth El. -Woodward at Gladstone
Churches; Catholic; Blessed Sacrament Catholic Church. Corner Woodward & Belmont.
Churches; Jewish; Temple Beth El. Woodward & Gladstone.
Churches; Presbyterian; Westminster Presbyterian Church. Old church, corner Woodward & Parsons.

Michigan; Cities. Birmingham Streets. Michigan; Cities; Birmingham; Streets corner of Woodward and Maple
Woodward between Larned + Congress
Blvd. West. at Woodward.




Wars; World; # 2; Memorials. In Ferndale, Michigan; Honor Roll at Nine Mile Rd. & Woodward.
----------Mile Rd. & Woodward.

Churches; Methodist; Fisher Memorial M. E. Church. Gratiot & E. Grand Blvd. . Date is 1910




*/










function formatProperty($prop) {
	return ucwords( str_replace("_", " ", $prop) );
}



// $query = $_POST['query'];
$query = "detroit building";
$query = "digital dress";
$query = $_GET['search'];
$queryURLEncoded = urlencode($query);

$numberOfResults = 100;
$numberOfResults = 500;
$numberOfResults = 1000;


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









function itemToPhrase($item) {



	// echo $item["title"] . "<br>\n";

	

	$numberToNumberWords = array(
        '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
        '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
        '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
        '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
        '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
        '80' => 'eighty','90' => 'ninty');

	$regexWrittenNumbers = <<<EOD

(?x)           # free-spacing mode
(?(DEFINE)
  # Within this DEFINE block, we'll define many subroutines
  # They build on each other like lego until we can define
  # a "big number"

  (?<one_to_9>  
  # The basic regex:
  # one|two|three|four|five|six|seven|eight|nine
  # We'll use an optimized version:
  # Option 1: four|eight|(?:fiv|(?:ni|o)n)e|t(?:wo|hree)|
  #                                          s(?:ix|even)
  # Option 2:
  (?:f(?:ive|our)|s(?:even|ix)|t(?:hree|wo)|(?:ni|o)ne|eight)
  ) # end one_to_9 definition

  (?<ten_to_19>  
  # The basic regex:
  # ten|eleven|twelve|thirteen|fourteen|fifteen|sixteen|seventeen|
  #                                              eighteen|nineteen
  # We'll use an optimized version:
  # Option 1: twelve|(?:(?:elev|t)e|(?:fif|eigh|nine|(?:thi|fou)r|
  #                                             s(?:ix|even))tee)n
  # Option 2:
  (?:(?:(?:s(?:even|ix)|f(?:our|if)|nine)te|e(?:ighte|lev))en|
                                          t(?:(?:hirte)?en|welve)) 
  ) # end ten_to_19 definition

  (?<two_digit_prefix>
  # The basic regex:
  # twenty|thirty|forty|fifty|sixty|seventy|eighty|ninety
  # We'll use an optimized version:
  # Option 1: (?:fif|six|eigh|nine|(?:tw|sev)en|(?:thi|fo)r)ty
  # Option 2:
  (?:s(?:even|ix)|t(?:hir|wen)|f(?:if|or)|eigh|nine)ty
  ) # end two_digit_prefix definition

  (?<one_to_99>
  (?&two_digit_prefix)(?:[- ](?&one_to_9))?|(?&ten_to_19)|
                                              (?&one_to_9)
  ) # end one_to_99 definition

  (?<one_to_999>
  (?&one_to_9)[ ]hundred(?:[ ](?:and[ ])?(?&one_to_99))?|
                                            (?&one_to_99)
  ) # end one_to_999 definition

  (?<one_to_999_999>
  (?&one_to_999)[ ]thousand(?:[ ](?&one_to_999))?|
                                    (?&one_to_999)
  ) # end one_to_999_999 definition

  (?<one_to_999_999_999>
  (?&one_to_999)[ ]million(?:[ ](?&one_to_999_999))?|
                                   (?&one_to_999_999)
  ) # end one_to_999_999_999 definition

  (?<one_to_999_999_999_999>
  (?&one_to_999)[ ]billion(?:[ ](?&one_to_999_999_999))?|
                                   (?&one_to_999_999_999)
  ) # end one_to_999_999_999_999 definition

  (?<one_to_999_999_999_999_999>
  (?&one_to_999)[ ]trillion(?:[ ](?&one_to_999_999_999_999))?|
                                    (?&one_to_999_999_999_999)
  ) # end one_to_999_999_999_999_999 definition

  (?<bignumber>
  zero|(?&one_to_999_999_999_999_999)
  ) # end bignumber definition

  (?<zero_to_9>
  (?&one_to_9)|zero
  ) # end zero to 9 definition

  (?<decimals>
  point(?:[ ](?&zero_to_9))+
  ) # end decimals definition
  
) # End DEFINE


####### The Regex Matching Starts Here ########
(?&bignumber)(?:[ ](?&decimals))?

### Other examples of groups we could match ###
#(?&bignumber)
# (?&one_to_99)
# (?&one_to_999)
# (?&one_to_999_999)
# (?&one_to_999_999_999)
# (?&one_to_999_999_999_999)
# (?&one_to_999_999_999_999_999)
    

EOD;
	
	$regexWrittenNumbers = "(one|two|three|four|five|six|seven|eight|nine|ten|eleven|twelve|thirteen|fourteen|fifteen|sixteen|seventeen|eighteen|nineteen)";

	$regexTwoWords = "([a-zA-Z0-9]+|[a-zA-Z0-9]+ [a-zA-Z0-9]+|(" . $regexWrittenNumbers . "|[0-9]+) Mile (Road|Rd|Rd.))";
	$regexDirection = "(| N | E | S | W )";
	$regexMt = "(| Mount | Mt | Mt. )";
	$regexAve = "(| Avenue| Ave| Ave.)";
	$regexRd = "(| Road| Rd| Rd.)";
	$regexStreet = "(| Street| St| St.)";
	$regexBlvd = "(| Boulevard| Blvd| Blvd.)";
	$regexHwy = "(| Highway| Hwy| Hwy.)";
	$regexStreetAbbr = $regexAve . $regexRd . $regexStreet . $regexBlvd . $regexHwy;
	$regexStreetName = "(Woodward" .$regexStreetAbbr. "|Gratiot" .$regexStreetAbbr. "|Grand River" .$regexStreetAbbr. "|Michigan" .$regexStreetAbbr. "|Lafayette" .$regexStreetAbbr. "|Jefferson" .$regexStreetAbbr. "|Groesbeck" .$regexStreetAbbr. "|Mack" .$regexStreetAbbr. "|Dequindre" .$regexStreetAbbr. "|John R" .$regexStreetAbbr. "|Canfield" .$regexStreetAbbr. "|Warren" .$regexStreetAbbr. "|Adams" .$regexStreetAbbr. "|Fort" .$regexStreetAbbr. "|Rosa Parks" .$regexStreetAbbr. "|12th" .$regexStreetAbbr. "|Grand" .$regexStreetAbbr. "|Vernor" .$regexStreetAbbr. "|Trumbull" .$regexStreetAbbr. "|Myrtle" .$regexStreetAbbr. "|Larned" .$regexStreetAbbr. "|larned" .$regexStreetAbbr. "|16th" .$regexStreetAbbr. ")+";
	$regexPrepositionOrPhrase = "(?:At |On |Streets Corner of |Street Corner of |Corner |Between |[.,;]+ )*";
	
	// if ( preg_match("/^Woodward \& ([ .a-zA-Z0-9]+)$/i", $item["title"], $match) ) {
	// if ( preg_match("/(Woodward \& ([ .a-zA-Z0-9]+))/i", $item["title"], $match) ) {
	// 	//str_replace("Woodward", "Woodward Avenue", $match[1])
	// 	echo "----------" . $match[1] . "<br>\n";
	// 	$phrase = $match[1];
	// }

	// if ( preg_match("/(([ .a-zA-Z0-9]+) \& Woodward)/i", $item["title"], $match) ) {
	// 	//str_replace("Woodward", "Woodward Avenue", $match[1])
	// 	echo "----------" . $match[1] . "<br>\n";
	// 	$phrase = $match[1];
	// }
	
	if ( preg_match_all("/" .$regexPrepositionOrPhrase. "(" .$regexStreetName. " (at|and|&) " .$regexTwoWords. "([.;,]+|$))/i", $item["title"], $match) ) {
		//str_replace("Woodward", "Woodward Avenue", $match[1])
		// echo "<pre>";
		// print_r($match);
		// echo "</pre>";
		$phrase = $match[1][count($match[1])-1];
		// echo "----------" . $phrase . "<br>\n";
	}

	if ( preg_match_all("/" .$regexPrepositionOrPhrase. "(" .$regexTwoWords. " (at|and|&) " .$regexStreetName. "([.;,]+|$))/i", $item["title"], $match) ) {
		//str_replace("Woodward", "Woodward Avenue", $match[1])
		// echo "<pre>";
		// print_r($match);
		// echo "</pre>";
		$phrase = $match[1][count($match[1])-1];
		// echo "----------" . $phrase . "<br>\n";
	}

	// if ( preg_match("/At Woodward; At ([ .a-zA-Z0-9]+)/i", $item["title"], $match) ) {
	// 	//str_replace("Woodward", "Woodward Avenue", $match[1])
	// 	echo "----------" . "Woodward and " . $match[1] . "<br>\n";
	// 	$phrase = $match[1];
	// }

	// if ( preg_match("/Streets Corner of (Woodward and ([ .a-zA-Z0-9]+))/i", $item["title"], $match) ) {
	// 	//str_replace("Woodward", "Woodward Avenue", $match[1])
	// 	echo "----------" . $match[1] . "<br>\n";
	// 	$phrase = $match[1];
	// }



	// convert & to at (because google geo api handles it better)
	$phrase = str_replace(" & ", " at ", $phrase);
	$phrase = str_replace(" and ", " at ", $phrase);

	// convert Nine Mile to 9 mile (because google geo api handles it better)
	$phrase = str_ireplace(array(
		'one',
		'two',
		'three',
		'four',
		'five',
		'six',
		'seven',
		'eight',
		'nine',
		'ten',
		'eleven',
		'twelve',
		'thirteen',
		'fourteen',
		'fifteen',
		'sixteen',
		'seventeen',
		'eighteen',
		'nineteen',
	), array(
		1,
		2,
		3,
		4,
		5,
		6,
		7,
		8,
		9,
		10,
		11,
		12,
		13,
		14,
		15,
		16,
		17,
		18,
		19,
	), $phrase);



	// $location_phrases []= array(

	// );

	// $item["location_phrase"] []= $phrase;

	// $titleToGeo[ $item["title"] ] = array(
	// 	"phrase" => $phrase,
	// 	"geo" => null
	// );



	// $phraseToGeo[$phrase] = null;


	return $phrase;



}







foreach ($items as $key => $item) {
	$phrase = itemToPhrase($item);

	$phraseToGeo[$phrase] = null;
	$item["phrase"] = $phrase;

	$items2 []= $item;
}




// echo "<pre>";
// print_r($phraseToGeo);
// echo "</pre>";
// exit;




foreach ($phraseToGeo as $phrase => $geo) {

	// echo $phrase . '<br>';

	// $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=woodward+and+edmund+place,+MI&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";
	// $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=woodward+and+edmund+place&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";
	// $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=Woodward%20and%20willis.&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";
	$apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" .urlencode($phrase). "&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";

	$apiResponse = file_get_contents($apiUrl);
	$apiResponse = json_decode($apiResponse, true);

	// echo "<pre>";
	// print_r($apiResponse);
	// echo "</pre>";

	foreach ($apiResponse["results"] as $key => $result) {
		foreach ($result["address_components"] as $address_components) {
			if ($address_components["long_name"] == "Michigan") {
				$phraseToGeo[$phrase] = $result;
			}
		}
		// if ( $result["address_components"][4]["long_name"] == "Michigan" ) {
		// 	$phraseToGeo[$phrase] = $result;
		// }
	}


}



// echo "<pre>";
// print_r($phraseToGeo);
// echo "</pre>";
// exit;



foreach ($items2 as $key => $item) {

	if ( $item["phrase"] ) {
		// echo "binno";
		// echo $item["phrase"];
		$item["geo"] = $phraseToGeo[ $item["phrase"] ];
		$items3 []= $item;
	}

}



// echo "<pre>";
// print_r($items3);
// echo "</pre>";
// exit;






// echo "<pre>";
// print_r($titles);
// echo "</pre>";


// echo "<pre>";
// print_r($items3);
// echo "</pre>";








// foreach ($phraseToGeo as $phrase => $geo) {

// 	// echo $phrase . '<br>';

// 	// $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=woodward+and+edmund+place,+MI&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";
// 	// $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=woodward+and+edmund+place&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";
// 	// $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=Woodward%20and%20willis.&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";
// 	$apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" .urlencode($phrase). "&key=AIzaSyBGyiQrFLiel2PCC6rvUxu0-uj_7jm65A0";

// 	$apiResponse = file_get_contents($apiUrl);
// 	$apiResponse = json_decode($apiResponse, true);

// 	// echo "<pre>";
// 	// print_r($apiResponse);
// 	// echo "</pre>";

// 	foreach ($apiResponse["results"] as $key => $result) {
// 		foreach ($result["address_components"] as $address_components) {
// 			if ($address_components["long_name"] == "Michigan") {
// 				$phraseToGeo[$phrase] = $result;
// 			}
// 		}
// 		// if ( $result["address_components"][4]["long_name"] == "Michigan" ) {
// 		// 	$phraseToGeo[$phrase] = $result;
// 		// }
// 	}


// }









// foreach ($items as $key => $item) {
// 	echo "\t" . '"' . $key . '": ' . '"' . $item . '"' . ",\n";
// }



echo "<pre>";
// print_r($phraseToGeo);
// var_export($phraseToGeo);
var_export($items3);
echo "</pre>";
// echo(count($phraseToGeo));


?>
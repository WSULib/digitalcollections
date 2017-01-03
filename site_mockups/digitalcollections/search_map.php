<?php






function getPhraseFromTitle($title) {


	$item["title"] = $title;

	

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

	$regexTwoWords = "([a-zA-Z0-9]+|[a-zA-Z0-9]+ [a-zA-Z0-9]+|" . $regexWrittenNumbers . " Mile Rd.)";
	$regexStreetName = "(Woodward|Gratiot|Grand River|Michigan Avenue|Michigan Ave|Michigan Ave.|Lafayette|Jefferson Avenue|Groesbeck|Mack Avenue|Dequindre|Dequindre Rd|John R|John R.)+";
	$regexPrepositionOrPhrase = "(?:At |Streets Corner of |Street Corner of |Corner |Between |[.,;]+ )*";
	
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





	return $phrase;



	// $location_phrases []= array(

	// );

	// $item["location_phrase"] []= $phrase;

	// $titleToGeo[ $item["title"] ] = array(
	// 	"phrase" => $phrase,
	// 	"geo" => null
	// );

	// $phraseToGeo[$phrase] = null;

}










$phraseToGeo =


/*
array (
  'Woodward at Clifford.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Clifford St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3349390999999997120539774186909198760986328125,
        'lng' => -83.04940759999999499996192753314971923828125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33628808029150292213671491481363773345947265625,
          'lng' => -83.048058619708484684451832436025142669677734375,
        ),
        'southwest' => 
        array (
          'lat' => 42.33359011970849650197123992256820201873779296875,
          'lng' => -83.050756580291505315472022630274295806884765625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjJXb29kd2FyZCBBdmUgJiBDbGlmZm9yZCBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Edmund Place.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Edmund Pl, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34375730000000004338289727456867694854736328125,
        'lng' => -83.0554384999999939509507385082542896270751953125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.345106280291503253465634770691394805908203125,
          'lng' => -83.0540895197084836354406434111297130584716796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3424083197084968333001597784459590911865234375,
          'lng' => -83.056787480291490055606118403375148773193359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBFZG11bmQgUGwsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Campus Martius.' => NULL,
  'Woodward at Adams.' => NULL,
  'obelisk at Woodward.' => NULL,
  'Woodward at Philadelphia' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Philadelphia St, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3779861000000011017618817277252674102783203125,
        'lng' => -83.078467799999998533166944980621337890625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.379335080291497206417261622846126556396484375,
          'lng' => -83.077118819708488217656849883496761322021484375,
        ),
        'southwest' => 
        array (
          'lat' => 42.37663711970849789167914423160254955291748046875,
          'lng' => -83.079816780291508848677040077745914459228515625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjhXb29kd2FyZCBBdmUgJiBXIFBoaWxhZGVscGhpYSBTdCwgRGV0cm9pdCwgTUkgNDgyMDIsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Hancock wrecking.' => NULL,
  'Woodward at Maple' => NULL,
  'Woodward at Willis.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Willis St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.35166359999998775265339645557105541229248046875,
        'lng' => -83.0607218999999901143382885493338108062744140625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.35301258029149806816349155269563198089599609375,
          'lng' => -83.05937291970849400968290865421295166015625,
        ),
        'southwest' => 
        array (
          'lat' => 42.3503146197084987534253741614520549774169921875,
          'lng' => -83.0620708802915004298483836464583873748779296875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjJXb29kd2FyZCBBdmUgJiBXIFdpbGxpcyBTdCwgRGV0cm9pdCwgTUkgNDgyMDEsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Baltimore at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'New Center',
        'short_name' => 'New Center',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Baltimore Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3684166000000033136529964394867420196533203125,
        'lng' => -83.0720769999999930632839095778763294219970703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.36976558029149231288101873360574245452880859375,
          'lng' => -83.0707280197084827477738144807517528533935546875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3670676197084929981429013423621654510498046875,
          'lng' => -83.0734259802915033787940046750009059906005859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjZXb29kd2FyZCBBdmUgJiBFIEJhbHRpbW9yZSBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  '6 Mile at Woodward.' => NULL,
  'Woodward at State Street' => NULL,
  'Woodward at Parsons.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Parsons St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34854599999999891224433667957782745361328125,
        'lng' => -83.058642800000001216176315210759639739990234375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34989498029150212232707417570054531097412109375,
          'lng' => -83.0572938197085051115209353156387805938720703125,
        ),
        'southwest' => 
        array (
          'lat' => 42.3471970197085028075889567844569683074951171875,
          'lng' => -83.05999178029151153168641030788421630859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBQYXJzb25zIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Belmont.' => NULL,
  'Woodward at Forest.' => NULL,
  'Woodward at Gladst1.' => NULL,
  'Woodward at Erskine.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Erskine St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34563299999999941292117000557482242584228515625,
        'lng' => -83.05670589999999720021151006221771240234375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.346981980291502623003907501697540283203125,
          'lng' => -83.0553569197085010955561301670968532562255859375,
        ),
        'southwest' => 
        array (
          'lat' => 42.34428401970850330826579011045396327972412109375,
          'lng' => -83.058054880291507515721605159342288970947265625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBFcnNraW5lIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Gladst1' => NULL,
  'Woodward at State' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & State St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33295600000000291629476123489439487457275390625,
        'lng' => -83.0478358999999954903614707291126251220703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33430498029149902095014113001525402069091796875,
          'lng' => -83.046486919708485174851375631988048553466796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3316070197084997062120237387716770172119140625,
          'lng' => -83.049184880291505805871565826237201690673828125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9Xb29kd2FyZCBBdmUgJiBTdGF0ZSBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Pingree' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Pingree St, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.37878400000000311820258502848446369171142578125,
        'lng' => -83.07899639999999408246367238461971282958984375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.38013298029149922285796492360532283782958984375,
          'lng' => -83.0776474197084979778082924894988536834716796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3774350197084999081198475323617458343505859375,
          'lng' => -83.080345380291504397973767481744289398193359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBQaW5ncmVlIFN0LCBEZXRyb2l0LCBNSSA0ODIwMiwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Michigan Avenue At Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Michigan Avenue',
        'short_name' => 'Michigan Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Michigan Ave & Woodward Ave, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33168599999999770489012007601559162139892578125,
        'lng' => -83.0470342999999928679244476370513439178466796875,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.333034980291500914972857572138309478759765625,
          'lng' => -83.045685319708496763269067741930484771728515625,
        ),
        'southwest' => 
        array (
          'lat' => 42.33033701970850160023474018089473247528076171875,
          'lng' => -83.0483832802915031834345427341759204864501953125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNNaWNoaWdhbiBBdmUgJiBXb29kd2FyZCBBdmUsIERldHJvaXQsIE1JIDQ4MjI2LCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'State at Woodward' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & State St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33295600000000291629476123489439487457275390625,
        'lng' => -83.0478358999999954903614707291126251220703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33430498029149902095014113001525402069091796875,
          'lng' => -83.046486919708485174851375631988048553466796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3316070197084997062120237387716770172119140625,
          'lng' => -83.049184880291505805871565826237201690673828125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9Xb29kd2FyZCBBdmUgJiBTdGF0ZSBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Hancock.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Hancock St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.35578710000000768332029110752046108245849609375,
        'lng' => -83.06368109999999660431058146059513092041015625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.3571360802915108934030286036431789398193359375,
          'lng' => -83.062332119708486288800486363470554351806640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.35443811970851157866491121239960193634033203125,
          'lng' => -83.065030080291506919820676557719707489013671875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBXIEhhbmNvY2sgU3QsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Stimson at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Stimson St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3464319000000131154592963866889476776123046875,
        'lng' => -83.057236399999993636811268515884876251220703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34778088029150922011467628180980682373046875,
          'lng' => -83.0558874197084833213011734187602996826171875,
        ),
        'southwest' => 
        array (
          'lat' => 42.34508291970850990537655889056622982025146484375,
          'lng' => -83.0585853802914897414666484110057353973388671875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBTdGltc29uIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Montcalm.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Montcalm St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33892180000000138306859298609197139739990234375,
        'lng' => -83.05219180000000278596417047083377838134765625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34027078029149748772397288121283054351806640625,
          'lng' => -83.0508428197085066813087905757129192352294921875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3375728197085123838405706919729709625244140625,
          'lng' => -83.053540780291513101474265567958354949951171875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjRXb29kd2FyZCBBdmUgJiBFIE1vbnRjYWxtIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at W.' => NULL,
  'Woodward at Ferry.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Ferry St, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.36103090000000293002813123166561126708984375,
        'lng' => -83.0670999999999963847585604526102542877197265625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.36237988029149192925615352578461170196533203125,
          'lng' => -83.0657510197084860692484653554856777191162109375,
        ),
        'southwest' => 
        array (
          'lat' => 42.359681919708492614518036134541034698486328125,
          'lng' => -83.0684489802915067002686555497348308563232421875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBFIEZlcnJ5IFN0LCBEZXRyb2l0LCBNSSA0ODIwMiwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Edmund.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Edmund Pl, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34375730000000004338289727456867694854736328125,
        'lng' => -83.0554384999999939509507385082542896270751953125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.345106280291503253465634770691394805908203125,
          'lng' => -83.0540895197084836354406434111297130584716796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3424083197084968333001597784459590911865234375,
          'lng' => -83.056787480291490055606118403375148773193359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBFZG11bmQgUGwsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Witherell at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Witherell St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.335983900000002222441253252327442169189453125,
        'lng' => -83.050199999999989586285664699971675872802734375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33733288029149122166927554644644260406494140625,
          'lng' => -83.04885101970847927077556960284709930419921875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3346349197084919069311581552028656005859375,
          'lng' => -83.05154898029149990179575979709625244140625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBXaXRoZXJlbGwgU3QsIERldHJvaXQsIE1JIDQ4MjI2LCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Cass' => NULL,
  'Woodward at Winder.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Winder St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34070239999999785140971653163433074951171875,
        'lng' => -83.0534004000000010137227945961058139801025390625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34205138029150106149245402775704860687255859375,
          'lng' => -83.0520514197084906982126994989812374114990234375,
        ),
        'southwest' => 
        array (
          'lat' => 42.3393534197085017467543366365134716033935546875,
          'lng' => -83.0547493802915113292328896932303905487060546875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBXaW5kZXIgU3QsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Clairmont.' => NULL,
  'Woodward at 8 Mile' => NULL,
  'Woodward at Grand Blvd.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Grand Boulevard',
        'short_name' => 'Grand Blvd',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Clarklake',
        'short_name' => 'Clarklake',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Columbia Township',
        'short_name' => 'Columbia Township',
        'types' => 
        array (
          0 => 'administrative_area_level_3',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Jackson County',
        'short_name' => 'Jackson County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '49234',
        'short_name' => '49234',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Grand Blvd & Woodward, Clarklake, MI 49234, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.12486349999999646342985215596854686737060546875,
        'lng' => -84.309619400000002542583388276398181915283203125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.12621248029149256808523205108940601348876953125,
          'lng' => -84.3082704197085064379280083812773227691650390625,
        ),
        'southwest' => 
        array (
          'lat' => 42.123514519708493253347114659845829010009765625,
          'lng' => -84.31096838029151285809348337352275848388671875,
        ),
      ),
    ),
    'place_id' => 'Ei9HcmFuZCBCbHZkICYgV29vZHdhcmQsIENsYXJrbGFrZSwgTUkgNDkyMzQsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Baltimore.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'New Center',
        'short_name' => 'New Center',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Baltimore Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3684166000000033136529964394867420196533203125,
        'lng' => -83.0720769999999930632839095778763294219970703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.36976558029149231288101873360574245452880859375,
          'lng' => -83.0707280197084827477738144807517528533935546875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3670676197084929981429013423621654510498046875,
          'lng' => -83.0734259802915033787940046750009059906005859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjZXb29kd2FyZCBBdmUgJiBFIEJhbHRpbW9yZSBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Farmer at Gratiot' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Gratiot Avenue',
        'short_name' => 'Gratiot Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Gratiot Ave & Farmer St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.333451900000000023283064365386962890625,
        'lng' => -83.04674049999999851934262551367282867431640625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33480088029150323336580186150968074798583984375,
          'lng' => -83.045391519708488203832530416548252105712890625,
        ),
        'southwest' => 
        array (
          'lat' => 42.33210291970849681320032686926424503326416015625,
          'lng' => -83.048089480291508834852720610797405242919921875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9HcmF0aW90IEF2ZSAmIEZhcm1lciBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Bates at Woodward' => NULL,
  'Woodward at Adelaide' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Adelaide St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34172099999999971942088450305163860321044921875,
        'lng' => -83.054090000000002191882231272757053375244140625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.3430699802915029295036219991743564605712890625,
          'lng' => -83.052741019708491876372136175632476806640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.340372019708496509338147006928920745849609375,
          'lng' => -83.05543898029151250739232636988162994384765625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjJXb29kd2FyZCBBdmUgJiBBZGVsYWlkZSBTdCwgRGV0cm9pdCwgTUkgNDgyMDEsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Jefferson.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward',
        'short_name' => 'Woodward',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Otisville',
        'short_name' => 'Otisville',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Forest Township',
        'short_name' => 'Forest Township',
        'types' => 
        array (
          0 => 'administrative_area_level_3',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Genesee County',
        'short_name' => 'Genesee County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48463',
        'short_name' => '48463',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward & Jefferson, Otisville, MI 48463, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 43.16667319999999818946889718063175678253173828125,
        'lng' => -83.527314899999993258461472578346729278564453125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 43.168022180291501399551634676754474639892578125,
          'lng' => -83.5259659197084829429513774812221527099609375,
        ),
        'southwest' => 
        array (
          'lat' => 43.16532421970850208481351728551089763641357421875,
          'lng' => -83.5286638802914893631168524734675884246826171875,
        ),
      ),
    ),
    'place_id' => 'Ei5Xb29kd2FyZCAmIEplZmZlcnNvbiwgT3Rpc3ZpbGxlLCBNSSA0ODQ2MywgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Mile Road at Woodward.' => NULL,
  'Woodward at Canfield.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Canfield St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.35270539999999783731254865415394306182861328125,
        'lng' => -83.0614410000000162881406140513718128204345703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.354054380291501047395286150276660919189453125,
          'lng' => -83.06009201970852018348523415625095367431640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.35135641970850173265716875903308391571044921875,
          'lng' => -83.0627899802915266036507091484963893890380859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjRXb29kd2FyZCBBdmUgJiBXIENhbmZpZWxkIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Traffic Tower at Woodward.' => NULL,
  'Woodward at Medbury.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Wayne State',
        'short_name' => 'Wayne State',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Edsel Ford Service Dr, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.364149400000002287924871779978275299072265625,
        'lng' => -83.0691861999999900945113040506839752197265625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.3654983802914983925802516750991344451904296875,
          'lng' => -83.0678372197084939898559241555631160736083984375,
        ),
        'southwest' => 
        array (
          'lat' => 42.36280041970849907784213428385555744171142578125,
          'lng' => -83.070535180291500410021399147808551788330078125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ej5Xb29kd2FyZCBBdmUgJiBFIEVkc2VsIEZvcmQgU2VydmljZSBEciwgRGV0cm9pdCwgTUkgNDgyMDIsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Holbrook.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Holbrook Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3811170000000032587195164524018764495849609375,
        'lng' => -83.0805969000000033020114642567932605743408203125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.382465980291499363374896347522735595703125,
          'lng' => -83.07924791970850719735608436167240142822265625,
        ),
        'southwest' => 
        array (
          'lat' => 42.37976801970850004863677895627915859222412109375,
          'lng' => -83.0819458802915136175215593539178371429443359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBIb2xicm9vayBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Holbrook' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Holbrook Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3811170000000032587195164524018764495849609375,
        'lng' => -83.0805969000000033020114642567932605743408203125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.382465980291499363374896347522735595703125,
          'lng' => -83.07924791970850719735608436167240142822265625,
        ),
        'southwest' => 
        array (
          'lat' => 42.37976801970850004863677895627915859222412109375,
          'lng' => -83.0819458802915136175215593539178371429443359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBIb2xicm9vayBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  '9 Mile Rd. at Woodward.' => NULL,
  'Arden Park at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Boston Edison',
        'short_name' => 'Boston Edison',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Arden Park Blvd, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3863692999999983612724463455379009246826171875,
        'lng' => -83.0841124999999891542756813578307628631591796875,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.38771828029148736050046863965690135955810546875,
          'lng' => -83.0827635197084788387655862607061862945556640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.385020319708502256617066450417041778564453125,
          'lng' => -83.08546148029148525893106125295162200927734375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjZXb29kd2FyZCBBdmUgJiBBcmRlbiBQYXJrIEJsdmQsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Michigan' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Michigan Avenue',
        'short_name' => 'Michigan Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Michigan Ave & Woodward Ave, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33168599999999770489012007601559162139892578125,
        'lng' => -83.0470342999999928679244476370513439178466796875,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.333034980291500914972857572138309478759765625,
          'lng' => -83.045685319708496763269067741930484771728515625,
        ),
        'southwest' => 
        array (
          'lat' => 42.33033701970850160023474018089473247528076171875,
          'lng' => -83.0483832802915031834345427341759204864501953125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNNaWNoaWdhbiBBdmUgJiBXb29kd2FyZCBBdmUsIERldHJvaXQsIE1JIDQ4MjI2LCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Park Streets.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Park Ave, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.335983900000002222441253252327442169189453125,
        'lng' => -83.050199999999989586285664699971675872802734375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33733288029149122166927554644644260406494140625,
          'lng' => -83.04885101970847927077556960284709930419921875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3346349197084919069311581552028656005859375,
          'lng' => -83.05154898029149990179575979709625244140625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9Xb29kd2FyZCBBdmUgJiBQYXJrIEF2ZSwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Downtown At John R;' => NULL,
);

*/

array (
  'Woodward at Clifford.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Clifford St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3349390999999997120539774186909198760986328125,
        'lng' => -83.04940759999999499996192753314971923828125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33628808029150292213671491481363773345947265625,
          'lng' => -83.048058619708484684451832436025142669677734375,
        ),
        'southwest' => 
        array (
          'lat' => 42.33359011970849650197123992256820201873779296875,
          'lng' => -83.050756580291505315472022630274295806884765625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjJXb29kd2FyZCBBdmUgJiBDbGlmZm9yZCBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Edmund Place.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Edmund Pl, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34375730000000004338289727456867694854736328125,
        'lng' => -83.0554384999999939509507385082542896270751953125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.345106280291503253465634770691394805908203125,
          'lng' => -83.0540895197084836354406434111297130584716796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3424083197084968333001597784459590911865234375,
          'lng' => -83.056787480291490055606118403375148773193359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBFZG11bmQgUGwsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Campus Martius.' => NULL,
  'Woodward at Adams.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Ferndale',
        'short_name' => 'Ferndale',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Oakland County',
        'short_name' => 'Oakland County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => '48220',
        'short_name' => '48220',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Adams Ct, Ferndale, MI 48220, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.45039969999999840410964679904282093048095703125,
        'lng' => -83.12790169999999534411472268402576446533203125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.4517486802914874033376690931618213653564453125,
          'lng' => -83.1265527197084992394593427889049053192138671875,
        ),
        'southwest' => 
        array (
          'lat' => 42.44905071970850229945426690392196178436279296875,
          'lng' => -83.129250680291505659624817781150341033935546875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBBZGFtcyBDdCwgRmVybmRhbGUsIE1JIDQ4MjIwLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'obelisk at Woodward.' => NULL,
  'Woodward at Philadelphia' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Philadelphia St, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3779861000000011017618817277252674102783203125,
        'lng' => -83.078467799999998533166944980621337890625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.379335080291497206417261622846126556396484375,
          'lng' => -83.077118819708488217656849883496761322021484375,
        ),
        'southwest' => 
        array (
          'lat' => 42.37663711970849789167914423160254955291748046875,
          'lng' => -83.079816780291508848677040077745914459228515625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjhXb29kd2FyZCBBdmUgJiBXIFBoaWxhZGVscGhpYSBTdCwgRGV0cm9pdCwgTUkgNDgyMDIsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Hancock wrecking.' => NULL,
  'Woodward at Maple' => NULL,
  'Woodward at Willis.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Willis St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.35166359999998775265339645557105541229248046875,
        'lng' => -83.0607218999999901143382885493338108062744140625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.35301258029149806816349155269563198089599609375,
          'lng' => -83.05937291970849400968290865421295166015625,
        ),
        'southwest' => 
        array (
          'lat' => 42.3503146197084987534253741614520549774169921875,
          'lng' => -83.0620708802915004298483836464583873748779296875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjJXb29kd2FyZCBBdmUgJiBXIFdpbGxpcyBTdCwgRGV0cm9pdCwgTUkgNDgyMDEsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Baltimore at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'New Center',
        'short_name' => 'New Center',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Baltimore Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3684166000000033136529964394867420196533203125,
        'lng' => -83.0720769999999930632839095778763294219970703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.36976558029149231288101873360574245452880859375,
          'lng' => -83.0707280197084827477738144807517528533935546875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3670676197084929981429013423621654510498046875,
          'lng' => -83.0734259802915033787940046750009059906005859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjZXb29kd2FyZCBBdmUgJiBFIEJhbHRpbW9yZSBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  '6 Mile at Woodward.' => NULL,
  'Woodward at State Street' => NULL,
  'Woodward at Parsons.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Parsons St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34854599999999891224433667957782745361328125,
        'lng' => -83.058642800000001216176315210759639739990234375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34989498029150212232707417570054531097412109375,
          'lng' => -83.0572938197085051115209353156387805938720703125,
        ),
        'southwest' => 
        array (
          'lat' => 42.3471970197085028075889567844569683074951171875,
          'lng' => -83.05999178029151153168641030788421630859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBQYXJzb25zIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Belmont.' => NULL,
  'Woodward at Forest.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Birmingham',
        'short_name' => 'Birmingham',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Oakland County',
        'short_name' => 'Oakland County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => '48009',
        'short_name' => '48009',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Forest Ave, Birmingham, MI 48009, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.545462500000013505996321327984333038330078125,
        'lng' => -83.210535899999996445330907590687274932861328125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.5468114802915096106517012231051921844482421875,
          'lng' => -83.2091869197085003406755276955664157867431640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.54411351970851029591358383186161518096923828125,
          'lng' => -83.21188488029150676084100268781185150146484375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjRXb29kd2FyZCBBdmUgJiBGb3Jlc3QgQXZlLCBCaXJtaW5naGFtLCBNSSA0ODAwOSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Gladst1.' => NULL,
  'Woodward at Erskine.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Erskine St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34563299999999941292117000557482242584228515625,
        'lng' => -83.05670589999999720021151006221771240234375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.346981980291502623003907501697540283203125,
          'lng' => -83.0553569197085010955561301670968532562255859375,
        ),
        'southwest' => 
        array (
          'lat' => 42.34428401970850330826579011045396327972412109375,
          'lng' => -83.058054880291507515721605159342288970947265625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBFcnNraW5lIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Gladst1' => NULL,
  'Woodward at State' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & State St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33295600000000291629476123489439487457275390625,
        'lng' => -83.0478358999999954903614707291126251220703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33430498029149902095014113001525402069091796875,
          'lng' => -83.046486919708485174851375631988048553466796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3316070197084997062120237387716770172119140625,
          'lng' => -83.049184880291505805871565826237201690673828125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9Xb29kd2FyZCBBdmUgJiBTdGF0ZSBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Pingree' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Pingree St, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.37878400000000311820258502848446369171142578125,
        'lng' => -83.07899639999999408246367238461971282958984375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.38013298029149922285796492360532283782958984375,
          'lng' => -83.0776474197084979778082924894988536834716796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3774350197084999081198475323617458343505859375,
          'lng' => -83.080345380291504397973767481744289398193359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBQaW5ncmVlIFN0LCBEZXRyb2l0LCBNSSA0ODIwMiwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Michigan Avenue At Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Michigan Avenue',
        'short_name' => 'Michigan Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Michigan Ave & Woodward Ave, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33168599999999770489012007601559162139892578125,
        'lng' => -83.0470342999999928679244476370513439178466796875,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.333034980291500914972857572138309478759765625,
          'lng' => -83.045685319708496763269067741930484771728515625,
        ),
        'southwest' => 
        array (
          'lat' => 42.33033701970850160023474018089473247528076171875,
          'lng' => -83.0483832802915031834345427341759204864501953125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNNaWNoaWdhbiBBdmUgJiBXb29kd2FyZCBBdmUsIERldHJvaXQsIE1JIDQ4MjI2LCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'State at Woodward' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & State St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33295600000000291629476123489439487457275390625,
        'lng' => -83.0478358999999954903614707291126251220703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33430498029149902095014113001525402069091796875,
          'lng' => -83.046486919708485174851375631988048553466796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3316070197084997062120237387716770172119140625,
          'lng' => -83.049184880291505805871565826237201690673828125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9Xb29kd2FyZCBBdmUgJiBTdGF0ZSBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Hancock.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Hancock St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.35578710000000768332029110752046108245849609375,
        'lng' => -83.06368109999999660431058146059513092041015625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.3571360802915108934030286036431789398193359375,
          'lng' => -83.062332119708486288800486363470554351806640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.35443811970851157866491121239960193634033203125,
          'lng' => -83.065030080291506919820676557719707489013671875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBXIEhhbmNvY2sgU3QsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Stimson at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Stimson St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3464319000000131154592963866889476776123046875,
        'lng' => -83.057236399999993636811268515884876251220703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34778088029150922011467628180980682373046875,
          'lng' => -83.0558874197084833213011734187602996826171875,
        ),
        'southwest' => 
        array (
          'lat' => 42.34508291970850990537655889056622982025146484375,
          'lng' => -83.0585853802914897414666484110057353973388671875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBTdGltc29uIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Montcalm.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Montcalm St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33892180000000138306859298609197139739990234375,
        'lng' => -83.05219180000000278596417047083377838134765625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34027078029149748772397288121283054351806640625,
          'lng' => -83.0508428197085066813087905757129192352294921875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3375728197085123838405706919729709625244140625,
          'lng' => -83.053540780291513101474265567958354949951171875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjRXb29kd2FyZCBBdmUgJiBFIE1vbnRjYWxtIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at W.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Berkley',
        'short_name' => 'Berkley',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Oakland County',
        'short_name' => 'Oakland County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => '48072',
        'short_name' => '48072',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & West Blvd, Berkley, MI 48072, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.49607470000000120080585475079715251922607421875,
        'lng' => -83.1653237000000018497303244657814502716064453125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.49742368029149730546123464591801166534423828125,
          'lng' => -83.16397471970850574507494457066059112548828125,
        ),
        'southwest' => 
        array (
          'lat' => 42.4947257197085122015778324566781520843505859375,
          'lng' => -83.1666726802915121652404195629060268402099609375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBXZXN0IEJsdmQsIEJlcmtsZXksIE1JIDQ4MDcyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Ferry.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Ferry St, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.36103090000000293002813123166561126708984375,
        'lng' => -83.0670999999999963847585604526102542877197265625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.36237988029149192925615352578461170196533203125,
          'lng' => -83.0657510197084860692484653554856777191162109375,
        ),
        'southwest' => 
        array (
          'lat' => 42.359681919708492614518036134541034698486328125,
          'lng' => -83.0684489802915067002686555497348308563232421875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBFIEZlcnJ5IFN0LCBEZXRyb2l0LCBNSSA0ODIwMiwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Edmund.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Edmund Pl, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34375730000000004338289727456867694854736328125,
        'lng' => -83.0554384999999939509507385082542896270751953125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.345106280291503253465634770691394805908203125,
          'lng' => -83.0540895197084836354406434111297130584716796875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3424083197084968333001597784459590911865234375,
          'lng' => -83.056787480291490055606118403375148773193359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBFZG11bmQgUGwsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Witherell at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Witherell St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.335983900000002222441253252327442169189453125,
        'lng' => -83.050199999999989586285664699971675872802734375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33733288029149122166927554644644260406494140625,
          'lng' => -83.04885101970847927077556960284709930419921875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3346349197084919069311581552028656005859375,
          'lng' => -83.05154898029149990179575979709625244140625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBXaXRoZXJlbGwgU3QsIERldHJvaXQsIE1JIDQ4MjI2LCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Cass' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Pontiac',
        'short_name' => 'Pontiac',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Oakland County',
        'short_name' => 'Oakland County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => '48342',
        'short_name' => '48342',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & N Cass Ave, Pontiac, MI 48342, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.6400205999999997175109456293284893035888671875,
        'lng' => -83.2978907999999904632204561494290828704833984375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.64136958029150292759368312545120716094970703125,
          'lng' => -83.296541819708494358565076254308223724365234375,
        ),
        'southwest' => 
        array (
          'lat' => 42.63867161970849650742820813320577144622802734375,
          'lng' => -83.2992397802915007787305512465536594390869140625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjFXb29kd2FyZCBBdmUgJiBOIENhc3MgQXZlLCBQb250aWFjLCBNSSA0ODM0MiwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Winder.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Winder St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34070239999999785140971653163433074951171875,
        'lng' => -83.0534004000000010137227945961058139801025390625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.34205138029150106149245402775704860687255859375,
          'lng' => -83.0520514197084906982126994989812374114990234375,
        ),
        'southwest' => 
        array (
          'lat' => 42.3393534197085017467543366365134716033935546875,
          'lng' => -83.0547493802915113292328896932303905487060546875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjBXb29kd2FyZCBBdmUgJiBXaW5kZXIgU3QsIERldHJvaXQsIE1JIDQ4MjAxLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Clairmont.' => NULL,
  'Woodward at 8 Mile' => NULL,
  'Woodward at Grand Blvd.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Grand Boulevard',
        'short_name' => 'Grand Blvd',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Clarklake',
        'short_name' => 'Clarklake',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Columbia Township',
        'short_name' => 'Columbia Township',
        'types' => 
        array (
          0 => 'administrative_area_level_3',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Jackson County',
        'short_name' => 'Jackson County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '49234',
        'short_name' => '49234',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Grand Blvd & Woodward, Clarklake, MI 49234, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.12486349999999646342985215596854686737060546875,
        'lng' => -84.309619400000002542583388276398181915283203125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.12621248029149256808523205108940601348876953125,
          'lng' => -84.3082704197085064379280083812773227691650390625,
        ),
        'southwest' => 
        array (
          'lat' => 42.123514519708493253347114659845829010009765625,
          'lng' => -84.31096838029151285809348337352275848388671875,
        ),
      ),
    ),
    'place_id' => 'Ei9HcmFuZCBCbHZkICYgV29vZHdhcmQsIENsYXJrbGFrZSwgTUkgNDkyMzQsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Baltimore.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'New Center',
        'short_name' => 'New Center',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Baltimore Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3684166000000033136529964394867420196533203125,
        'lng' => -83.0720769999999930632839095778763294219970703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.36976558029149231288101873360574245452880859375,
          'lng' => -83.0707280197084827477738144807517528533935546875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3670676197084929981429013423621654510498046875,
          'lng' => -83.0734259802915033787940046750009059906005859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjZXb29kd2FyZCBBdmUgJiBFIEJhbHRpbW9yZSBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Farmer at Gratiot' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Gratiot Avenue',
        'short_name' => 'Gratiot Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Gratiot Ave & Farmer St, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.333451900000000023283064365386962890625,
        'lng' => -83.04674049999999851934262551367282867431640625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33480088029150323336580186150968074798583984375,
          'lng' => -83.045391519708488203832530416548252105712890625,
        ),
        'southwest' => 
        array (
          'lat' => 42.33210291970849681320032686926424503326416015625,
          'lng' => -83.048089480291508834852720610797405242919921875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9HcmF0aW90IEF2ZSAmIEZhcm1lciBTdCwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Bates at Woodward' => NULL,
  'Woodward at Adelaide' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Adelaide St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.34172099999999971942088450305163860321044921875,
        'lng' => -83.054090000000002191882231272757053375244140625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.3430699802915029295036219991743564605712890625,
          'lng' => -83.052741019708491876372136175632476806640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.340372019708496509338147006928920745849609375,
          'lng' => -83.05543898029151250739232636988162994384765625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjJXb29kd2FyZCBBdmUgJiBBZGVsYWlkZSBTdCwgRGV0cm9pdCwgTUkgNDgyMDEsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Jefferson.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward',
        'short_name' => 'Woodward',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Otisville',
        'short_name' => 'Otisville',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Forest Township',
        'short_name' => 'Forest Township',
        'types' => 
        array (
          0 => 'administrative_area_level_3',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Genesee County',
        'short_name' => 'Genesee County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48463',
        'short_name' => '48463',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward & Jefferson, Otisville, MI 48463, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 43.16667319999999818946889718063175678253173828125,
        'lng' => -83.527314899999993258461472578346729278564453125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 43.168022180291501399551634676754474639892578125,
          'lng' => -83.5259659197084829429513774812221527099609375,
        ),
        'southwest' => 
        array (
          'lat' => 43.16532421970850208481351728551089763641357421875,
          'lng' => -83.5286638802914893631168524734675884246826171875,
        ),
      ),
    ),
    'place_id' => 'Ei5Xb29kd2FyZCAmIEplZmZlcnNvbiwgT3Rpc3ZpbGxlLCBNSSA0ODQ2MywgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Mile Road at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Royal Oak',
        'short_name' => 'Royal Oak',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Oakland County',
        'short_name' => 'Oakland County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => '48073',
        'short_name' => '48073',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W 10 Mile Rd, Royal Oak, MI 48073, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.47555729999999840629243408329784870147705078125,
        'lng' => -83.1454213999999893758285907097160816192626953125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.476906280291501616375171579420566558837890625,
          'lng' => -83.14407241970849327117321081459522247314453125,
        ),
        'southwest' => 
        array (
          'lat' => 42.47420831970850230163705418817698955535888671875,
          'lng' => -83.1467703802914996913386858068406581878662109375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjVXb29kd2FyZCBBdmUgJiBXIDEwIE1pbGUgUmQsIFJveWFsIE9haywgTUkgNDgwNzMsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Canfield.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Midtown',
        'short_name' => 'Midtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48201',
        'short_name' => '48201',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & W Canfield St, Detroit, MI 48201, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.35270539999999783731254865415394306182861328125,
        'lng' => -83.0614410000000162881406140513718128204345703125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.354054380291501047395286150276660919189453125,
          'lng' => -83.06009201970852018348523415625095367431640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.35135641970850173265716875903308391571044921875,
          'lng' => -83.0627899802915266036507091484963893890380859375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjRXb29kd2FyZCBBdmUgJiBXIENhbmZpZWxkIFN0LCBEZXRyb2l0LCBNSSA0ODIwMSwgVVNB',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Traffic Tower at Woodward.' => NULL,
  'Woodward at Medbury.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Wayne State',
        'short_name' => 'Wayne State',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E Edsel Ford Service Dr, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.364149400000002287924871779978275299072265625,
        'lng' => -83.0691861999999900945113040506839752197265625,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.3654983802914983925802516750991344451904296875,
          'lng' => -83.0678372197084939898559241555631160736083984375,
        ),
        'southwest' => 
        array (
          'lat' => 42.36280041970849907784213428385555744171142578125,
          'lng' => -83.070535180291500410021399147808551788330078125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ej5Xb29kd2FyZCBBdmUgJiBFIEVkc2VsIEZvcmQgU2VydmljZSBEciwgRGV0cm9pdCwgTUkgNDgyMDIsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Holbrook.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Holbrook Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3811170000000032587195164524018764495849609375,
        'lng' => -83.0805969000000033020114642567932605743408203125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.382465980291499363374896347522735595703125,
          'lng' => -83.07924791970850719735608436167240142822265625,
        ),
        'southwest' => 
        array (
          'lat' => 42.37976801970850004863677895627915859222412109375,
          'lng' => -83.0819458802915136175215593539178371429443359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBIb2xicm9vayBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Holbrook' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Virginia Park',
        'short_name' => 'Virginia Park',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Holbrook Ave, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3811170000000032587195164524018764495849609375,
        'lng' => -83.0805969000000033020114642567932605743408203125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.382465980291499363374896347522735595703125,
          'lng' => -83.07924791970850719735608436167240142822265625,
        ),
        'southwest' => 
        array (
          'lat' => 42.37976801970850004863677895627915859222412109375,
          'lng' => -83.0819458802915136175215593539178371429443359375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBIb2xicm9vayBBdmUsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  '9 Mile Rd. at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Ferndale',
        'short_name' => 'Ferndale',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Oakland County',
        'short_name' => 'Oakland County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => '48220',
        'short_name' => '48220',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & E 9 Mile Rd, Ferndale, MI 48220, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.4605894000000034793629311025142669677734375,
        'lng' => -83.134330699999992475568433292210102081298828125,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.4619383802914995840183109976351261138916015625,
          'lng' => -83.1329817197084821600583381950855255126953125,
        ),
        'southwest' => 
        array (
          'lat' => 42.45924041970850026928019360639154911041259765625,
          'lng' => -83.1356796802914885802238131873309612274169921875,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNXb29kd2FyZCBBdmUgJiBFIDkgTWlsZSBSZCwgRmVybmRhbGUsIE1JIDQ4MjIwLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Arden Park at Woodward.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Boston Edison',
        'short_name' => 'Boston Edison',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48202',
        'short_name' => '48202',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Arden Park Blvd, Detroit, MI 48202, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.3863692999999983612724463455379009246826171875,
        'lng' => -83.0841124999999891542756813578307628631591796875,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.38771828029148736050046863965690135955810546875,
          'lng' => -83.0827635197084788387655862607061862945556640625,
        ),
        'southwest' => 
        array (
          'lat' => 42.385020319708502256617066450417041778564453125,
          'lng' => -83.08546148029148525893106125295162200927734375,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjZXb29kd2FyZCBBdmUgJiBBcmRlbiBQYXJrIEJsdmQsIERldHJvaXQsIE1JIDQ4MjAyLCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Michigan' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Michigan Avenue',
        'short_name' => 'Michigan Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Michigan Ave & Woodward Ave, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.33168599999999770489012007601559162139892578125,
        'lng' => -83.0470342999999928679244476370513439178466796875,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.333034980291500914972857572138309478759765625,
          'lng' => -83.045685319708496763269067741930484771728515625,
        ),
        'southwest' => 
        array (
          'lat' => 42.33033701970850160023474018089473247528076171875,
          'lng' => -83.0483832802915031834345427341759204864501953125,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'EjNNaWNoaWdhbiBBdmUgJiBXb29kd2FyZCBBdmUsIERldHJvaXQsIE1JIDQ4MjI2LCBVU0E',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Woodward at Park Streets.' => 
  array (
    'address_components' => 
    array (
      0 => 
      array (
        'long_name' => 'Woodward Avenue',
        'short_name' => 'Woodward Ave',
        'types' => 
        array (
          0 => 'route',
        ),
      ),
      1 => 
      array (
        'long_name' => 'Downtown',
        'short_name' => 'Downtown',
        'types' => 
        array (
          0 => 'neighborhood',
          1 => 'political',
        ),
      ),
      2 => 
      array (
        'long_name' => 'Detroit',
        'short_name' => 'Detroit',
        'types' => 
        array (
          0 => 'locality',
          1 => 'political',
        ),
      ),
      3 => 
      array (
        'long_name' => 'Wayne County',
        'short_name' => 'Wayne County',
        'types' => 
        array (
          0 => 'administrative_area_level_2',
          1 => 'political',
        ),
      ),
      4 => 
      array (
        'long_name' => 'Michigan',
        'short_name' => 'MI',
        'types' => 
        array (
          0 => 'administrative_area_level_1',
          1 => 'political',
        ),
      ),
      5 => 
      array (
        'long_name' => 'United States',
        'short_name' => 'US',
        'types' => 
        array (
          0 => 'country',
          1 => 'political',
        ),
      ),
      6 => 
      array (
        'long_name' => '48226',
        'short_name' => '48226',
        'types' => 
        array (
          0 => 'postal_code',
        ),
      ),
    ),
    'formatted_address' => 'Woodward Ave & Park Ave, Detroit, MI 48226, USA',
    'geometry' => 
    array (
      'location' => 
      array (
        'lat' => 42.335983900000002222441253252327442169189453125,
        'lng' => -83.050199999999989586285664699971675872802734375,
      ),
      'location_type' => 'APPROXIMATE',
      'viewport' => 
      array (
        'northeast' => 
        array (
          'lat' => 42.33733288029149122166927554644644260406494140625,
          'lng' => -83.04885101970847927077556960284709930419921875,
        ),
        'southwest' => 
        array (
          'lat' => 42.3346349197084919069311581552028656005859375,
          'lng' => -83.05154898029149990179575979709625244140625,
        ),
      ),
    ),
    'partial_match' => true,
    'place_id' => 'Ei9Xb29kd2FyZCBBdmUgJiBQYXJrIEF2ZSwgRGV0cm9pdCwgTUkgNDgyMjYsIFVTQQ',
    'types' => 
    array (
      0 => 'intersection',
    ),
  ),
  'Downtown At John R;' => NULL,
);





































function formatProperty($prop) {
	return ucwords( str_replace("_", " ", $prop) );
}



// $query = $_POST['query'];
$query = "detroit building";
$query = "digital dress";
$query = $_GET['search'];
$query = "Woodward";
$queryURLEncoded = urlencode($query);

$numberOfResults = 100;
$numberOfResults = 500;


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


















foreach ($items as $key => $item) {

	$phrase = getPhraseFromTitle( $item["title"] );

	$geo = $phraseToGeo[ $phrase ];

	// $geo["formatted_address"];
	// $geo["geometry"]["location"]["lat"];
	// $geo["geometry"]["location"]["lng"];
	if ($geo["formatted_address"] != null) {
		$markersJson []= array(
			"id" => substr($item["id"], 6),
			"title" => $item["title"],
			// "description" => $item["description"],
			"thumbnail" => $item["thumbnail"],
			"date" => $item["date"],
			"year" => substr($item["date"], 0, 4),
			"formatted_address" => $geo["formatted_address"],
			"lat" => $geo["geometry"]["location"]["lat"],
			"lng" => $geo["geometry"]["location"]["lng"],
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

		<div style="padding:20px;">

			<div>
				<label for="amount" style="float:left;">Year Range:</label>
				<span id="slider-range-amount" style="color:#f6931f;font-weight:bold;margin-left:10px;"></span>
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
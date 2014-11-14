<?php

// STRUCTURED DATA
// Small snippet to extract metadata from item.php's metadata call,
// and write this to an invisible div #struct_data at the top of the page.
// Because this is server-side, indexers like Google are able to interpret this data.
// Other options include more complicated server-side rendering and caching of all pages,
// but this seemed like a functional, low-barrier, maintable way to create structured data.

// PIWIK
// This snippet also contains code for pushing information to piwik.
// Usually fires from utilities.js, defers to this for URL's ending with /item.

function concatRepeaters($field){
	// determine if repeating or not
	$type = gettype($field);
	// single
	if ($type === "string"){
		return $field;
	}
	// repeating
	if ($type === "array"){
		$concat_string = "";
		foreach ($field as $each){
			$concat_string .= $each."<br>";			
		}
		return $concat_string;
	}
}

?>

<!--piwik code here-->
<script type="text/javascript">	
 	var _paq = _paq || [];	
	// isMemberOfCollection
	
	<?php 
	$i = 1;
	if ( array_key_exists("rels_isMemberOfCollection",$response['response']['docs'][0]) ){
		foreach($response['response']['docs'][0]['rels_isMemberOfCollection'] as $collection){
			$pattern = '/info\:fedora\/wayne\:/i';
			$replacement = "";
			$string = $collection;
			$collection = preg_replace($pattern, $replacement, $string);		
			echo "_paq.push(['setCustomVariable', '$i', 'collection', '$collection', 'visit'])\n";		
			$i++;
		}
	}
	
	// content type - hasContentModel	
	if ( array_key_exists("rels_hasContentModel",$response['response']['docs'][0]) ){
		foreach($response['response']['docs'][0]['rels_hasContentModel'] as $content_model){
			$pattern = '/info\:fedora\/CM\:/i';
			$replacement = "";
			$string = $content_model;
			$content_model = preg_replace($pattern, $replacement, $string);		
			echo "_paq.push(['setCustomVariable', '$i', 'content_model', '$content_model', 'visit'])\n";		
			$i++;
		}
	}
	?>

	_paq.push(["trackPageView"]);
	_paq.push(["enableLinkTracking"]);	
	(function() {
		var u=(("https:" == document.location.protocol) ? "https" : "http") + "://cgi.lib.wayne.edu/stats/piwik/";
		_paq.push(["setTrackerUrl", u+"piwik.php"]);
		_paq.push(["setSiteId", "28"]);
		var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
		g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
	})();
</script>
<!--end piwik-->
<!-- hidden schema.org stuctured data -->
<div  id="struct_data" style="display:none;" itemscope itemtype="http://schema.org/CreativeWork">
<span itemprop="name"><?php echo concatRepeaters($response['response']['docs'][0]['dc_title']); ?></span>
<span itemprop="description"><?php echo concatRepeaters($response['response']['docs'][0]['dc_description']); ?></span>		
<span itemprop="text"><?php echo concatRepeaters($response['response']['docs'][0]['mods_abstract_transcription_ms']); ?></span>
<span itemprop="genre"><?php echo concatRepeaters($response['response']['docs'][0]['mods_resource_type_ms']); ?></span>
<span itemprop="dateCreated"><?php echo concatRepeaters($response['response']['docs'][0]['facet_mods_year']); ?></span>
<img src="http://digital.library.wayne.edu/fedora/objects/<?php echo $objectPID; ?>/datastreams/<?php echo $response['response']['docs'][0]['rels_isRepresentedBy'][0]; ?>_PREVIEW/content" class="primary-image" itemprop="image">
<meta itemprop="thumbnailUrl" content="http://digital.library.wayne.edu/fedora/objects/<?php echo $objectPID; ?>/datastreams/<?php echo $response['response']['docs'][0]['rels_isRepresentedBy'][0]; ?>_THUMBNAIL/content">
</div>
<!-- ******************************** -->
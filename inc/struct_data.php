<?php

// Small utility to extract metadata from item.php's metadata call,
// and write this to an invisible div #struct_data at the top of the page.
// Because this is server-side, indexers like Google are able to interpret this data.
// Other options include more complicated server-side rendering and caching of all pages,
// but this seemed like a functional, low-barrier, maintable way to create structured data.

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

<!-- hidden schema.org stuctured data -->
<!--<?php $objectPID = $_REQUEST['id']; ?>-->
<!--piwik code here-->
<script type="text/javascript">
 	var _paq = _paq || [];
	// Collection analyzer
	<?php 
	$i = 1;
	foreach($response['response']['docs'][0]['rels_isMemberOfCollection'] as $collection){
		$pattern = '/info\:fedora\/wayne\:/i';
		$replacement = "";
		$string = $collection;
		$collection = preg_replace($pattern, $replacement, $string);
		echo "_paq.push(['setCustomVariable', '$i', 'collection', '$collection', 'visit'])\n";
		$i++;
	}
	?>
// Collection analyzer

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

<div  id="struct_data" style="display:none;" itemscope itemtype="http://schema.org/CreativeWork">
<span itemprop="name"><?php echo concatRepeaters($response['response']['docs'][0]['dc_title']); ?></span>
<span itemprop="description"><?php echo concatRepeaters($response['response']['docs'][0]['dc_description']); ?></span>		
<span itemprop="text"><?php echo concatRepeaters($response['response']['docs'][0]['mods_abstract_transcription_ms']); ?></span>
<span itemprop="genre"><?php echo concatRepeaters($response['response']['docs'][0]['mods_resource_type_ms']); ?></span>
<span itemprop="dateCreated"><?php echo concatRepeaters($response['response']['docs'][0]['facet_mods_year']); ?></span>
<img src="http://digital.library.wayne.edu/fedora/objects/<?php echo $objectPID; ?>/datastreams/PREVIEW/content" class="primary-image" itemprop="image">
<meta itemprop="thumbnailUrl" content="http://digital.library.wayne.edu/fedora/objects/<?php echo $objectPID; ?>/datastreams/THUMBNAIL/content">
</div>
<!-- ******************************** -->
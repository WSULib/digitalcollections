// Digital Collections Front-End Translation Dictionary

function rosetta(input){	
	// strip quotes
	var s_input = input.replace(/"|'/g,'')
	if (typeof(translationDictionary[s_input]) == 'undefined') {
		var output = s_input;
		return output;
	}	
	else{
		var output = translationDictionary[s_input];
		return output;
	}
}

var translationDictionary = {
	// Facets
	"dc_date":"Date",
	"dc_subject":"Subject",
	"dc_creator":"Creator",
	"dc_language":"Language",
	"dc_coverage":"Coverage",
	"rels_hasContentModel":"Content Type",
	"rels_isMemberOfCollection":"Collection",
	
	// Content Types
	"info:fedora/CM:Image" : "Image",
	"info:fedora/CM:Audio" : "Audio",
	"info:fedora/CM:Video" : "Video",	
	"info:fedora/CM:Document" : "Document",
	"info:fedora/CM:WSUebook" : "WSUebook",
	"info:fedora/CM:Collection" : "Collection",	
	"info:fedora/CM:Issue": "Issues",
	"info:fedora/CM:Volume": "Volumes",

	// Collection Names
	"info:fedora/wayne:collectionCFAI" : "Changing Face of the Auto Industry",
	"info:fedora/wayne:collectionMIM" : "Made in Michigan Writers Series",
	"info:fedora/wayne:collectionWSUPress" : "WSU Press",
	"info:fedora/wayne:collectionWSUebooks" : "WSU eBooks",
	"info:fedora/wayne:collectionWSUDORCollections" : "WSU Digital Collections",
	"info:fedora/wayne:collectionMOT" : "Michigan Opera Theatre",
	"info:fedora/wayne:collectionDFQ" : "Detroit Focus Quarterly",
	"info:fedora/wayne:collectionRENCEN" : "Building of the Renaissance Center",
	"info:fedora/wayne:collectionBMC" : "BioMed Central Wayne State Publications",
	"info:fedora/wayne:collectionHeartTransplant" : "First U.S. Human-to-Human Heart Transplant",
	"info:fedora/wayne:collectionDSJ" : "Detroit Sunday Journal",
	"info:fedora/collection:WSUebooks" : "WSU Created eBooks",
	"info:fedora/collection:Ramsey" : "Ramsey Collection Of Literature For Young People",
};

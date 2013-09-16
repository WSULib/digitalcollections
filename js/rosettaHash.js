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
	"rels_hasContentModel":"Type",
	// Content Types
	"info:fedora/CM:Image" : "Image",
	// "\"info:fedora/CM:Image\"" : "Image",
	"info:fedora/CM:Document" : "Document",
	"info:fedora/CM:WSUebook" : "WSUebook",
	"info:fedora/CM:Collection" : "Collection",
	"info:fedora/singleObjectCM:WSUebook" : "WSUebook"	
};

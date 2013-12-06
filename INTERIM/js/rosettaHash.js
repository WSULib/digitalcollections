// Digital Collections Front-End Translation Dictionary
function rosetta(input){	
	
	// hardcoded facet translations
	var facetHash = {
		"dc_date":"Date",
		"dc_subject":"Subject",
		"dc_creator":"Creator",
		"dc_language":"Language",
		"dc_coverage":"Coverage",
		"rels_hasContentModel":"Content Type",
		"rels_isMemberOfCollection":"Collection"
	};

	// fold in hardcoded values
	APIdata.solrTranslationHash = jQuery.extend(APIdata.solrTranslationHash,facetHash);		

	// strip quotes
	var s_input = input.replace(/"|'/g,'')
	if (typeof(APIdata.solrTranslationHash[s_input]) == 'undefined') {
		var output = s_input;
		return output;
	}	
	else{
		var output = APIdata.solrTranslationHash[s_input];
		return output;
	}
}


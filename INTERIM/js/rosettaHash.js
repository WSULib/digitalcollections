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


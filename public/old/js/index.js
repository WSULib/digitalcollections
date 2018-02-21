

$(document).ready( function(){

	$("#header-search-nest-input").focus();


	$grid = $('#search-results-nest').masonry({
	  // options
	  itemSelector: '.search-result',
	  // columnWidth: 200,
	  gutter: 16,
	  transitionDuration: 0
	  // percentPosition: true,
	  // columnWidth: '.grid-sizer'

	});


	$grid.imagesLoaded().progress( function() {
		$grid.masonry('layout');
	});




	$grid2 = $('#collections').masonry({
	  // options
	  itemSelector: '.search-result',
	  // columnWidth: 200,
	  gutter: 16,
	  transitionDuration: 0
	  // percentPosition: true,
	  // columnWidth: '.grid-sizer'

	});


	$grid2.imagesLoaded().progress( function() {
		$grid2.masonry('layout');
	});





	$("#search-options-collapse").on("click", function(){

		if ($(this).hasClass("collapsed")) {
			$(this).removeClass("collapsed");

			$("#search-options").animate({
				"left": "0"
			}, 100, refreshGrid);
			$("#search-results").animate({
				"margin-left": "300px"
			}, 100, refreshGrid);
			$("#search-options-collapse").animate({
				"right": "20px"
			}, 100, refreshGrid);
		} else {
			$(this).addClass("collapsed");

			$("#search-options").animate({
				"left": "-280px"
			}, 100, refreshGrid);
			$("#search-results").animate({
				"margin-left": "20px"
			}, 100, refreshGrid);
			$("#search-options-collapse").animate({
				"right": "2px"
			}, 100, refreshGrid);
		}
	});

	
	$(document).on('scroll', checkIfBottom);




	// MAP
	dodaMap();







});




function onResize() {
	

	// var containerWdith = $("#search-results-nest").width();
	
	// $(".search-result").css("width", );
	// refreshGrid();
}


function refreshGrid() {
	$grid.masonry('layout');
}



function checkIfBottom() {
	var scrollBottom = $(window).scrollTop() + $(window).height();
	// console.log( $(window).scrollTop() );
	// console.log( parseInt($(window).height()) );
	if ( scrollBottom + 1000 > $(document).height() ) {
		if ( $("#search-options-collapse").hasClass("collapsed") ) {
			// console.log("Load more items");
			console.log("Load more items");
			$(document).unbind('scroll', checkIfBottom);
			loadItems();
		}
	}
}

itemRequestCount = 50;
loadItemsStart = 50;
function loadItems() {
	$("#search-results-loading").show();
	requestItems = $.ajax({
		url: "http://digital.library.wayne.edu/WSUAPI?q=" + query + "&start=" + loadItemsStart + "&rows=" + itemRequestCount + "&wt=json&functions%5B%5D=solrSearch",
		method: "POST",
		// data: {
		//   search_string: $('#masthead-search-nest-input').val()
		// },
		dataType: "json",
		success: function(response) {
			console.log("successssssssssssss");

			if (response.solrSearch.response.docs.length == 0) {
				console.log("END OF all items");
				$("#search-results-loading").hide();
				return;
			}

			// console.log(response);
			$.each(response.solrSearch.response.docs, function(i, item){
				console.log("item");
				id = item.id;
				title = item.dc_title['0'];
				description = item.dc_description['0'];
				thumbnail = "https://digital.library.wayne.edu/loris/fedora:" + item.id + "%7CTHUMBNAIL/full/full/0/default.jpg";
				itemHTML =
				'<div class="search-result search-result-just-loaded2" style="position: absolute; left: 0px; top: 0px;">' +
					'<a class="search-result-imgwrap" href="' + host + '/digitalcollections/view.php?id=' + id + '"><img src="' + thumbnail + '" width="200"></a>' +
					'<a class="search-result-title" href="' + host + '/digitalcollections/view.php?id=' + id + '">' + title + '</a>' +
					'<a class="search-result-description" href="' + host + '/digitalcollections/view.php?id=' + id + '">' + (description.length > 50 ? $.trim( description.substring(0, 100) ) + "..." : $item['description']) + '</a>' +
				'</div>';
				$("#search-results-nest").append(itemHTML);
				// $("#search-results-nest").masonry("appended", itemHTML);
				// $("#search-results-nest").masonry( 'reloadItems' );
				// refreshGrid();
			});

			$("#search-results-nest").masonry('reloadItems');
			$("#search-results-nest").masonry('layout');
			$grid.imagesLoaded().progress( function() {
				$grid.masonry('layout');
			});

			// $("#search-results-nest > .search-result-just-loaded").animate({
			// 	"opacity": 1
			// }, 750, function(){
			// 	$("#search-results-nest > .search-result-just-loaded").removeClass("search-result-just-loaded");
			// });
			
			loadItemsStart += itemRequestCount;
			$("#search-results-loading").hide();
			$(document).bind('scroll', checkIfBottom);
		}
	});
}






function dodaMap() {


	// var locations = [
	//     [
	//         "New Mermaid",
	//         36.9079,
	//         -76.199,
	//         1,
	//         "Georgia Mason",
	//         "",
	//         "Norfolk Botanical Gardens, 6700 Azalea Garden Rd.",
	//         "coming soon"
	//     ],
	//     [
	//         "1950 Fish Dish",
	//         36.87224,
	//         -76.29518,
	//         2,
	//         "Terry Cox-Joseph",
	//         "Rowena's",
	//         "758 W. 22nd Street in front of Rowena's",
	//         "found"
	//     ],
	//     [
	//         "A Rising Community",
	//         36.95298,
	//         -76.25158,
	//         3,
	//         "Steven F. Morris",
	//         "Judy Boone Realty",
	//         "Norfolk City Library - Pretlow Branch, 9640 Granby St.",
	//         "found"
	//     ],
	//     [
	//         "A School Of Fish",
	//         36.88909,
	//         -76.26055,
	//         4,
	//         "Steven F. Morris",
	//         "Sandfiddler Pawn Shop",
	//         "5429 Tidewater Dr.",
	//         "found"
	//     ],
	//     [
	//         "Aubrica the Mermaid (nee: Aubry Alexis)",
	//         36.8618,
	//         -76.203,
	//         5,
	//         "Myke Irving/ Georgia Mason",
	//         "USAVE Auto Rental",
	//         "Virginia Auto Rental on Virginia Beach Blvd",
	//         "found"
	//     ]
	// ]

 //    var map = new google.maps.Map(document.getElementById('map-results'), {
 //      zoom: 12,
 //      // center: new google.maps.LatLng(-33.92, 151.25),
 //      center: new google.maps.LatLng(36.8857, -76.2599),
 //      mapTypeId: google.maps.MapTypeId.ROADMAP
 //    });

 //    var infowindow = new google.maps.InfoWindow();

 //    var marker, i;

 //    for (i = 0; i < locations.length; i++) {  
 //      marker = new google.maps.Marker({
 //        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
 //        map: map
 //      });

 //      google.maps.event.addListener(marker, 'click', (function(marker, i) {
 //        return function() {
 //          infowindow.setContent(locations[i][0], locations[i][6]);
 //          infowindow.open(map, marker);
 //        }
 //      })(marker, i));
 //    }








    map = new GMaps({
      div: '#map',
      // lat: -12.043333,
      // lng: -77.028333,

      lat: 42.373132,
      lng: -83.074873,
      // 42.373132, -83.074873
      lat: 42.364144, 
      lng: -83.069221,

      lat: 42.358262,
      lng: -83.064125,

      lat: 42.356839, 
      lng: -83.064323,

      zoom: 14,
      zoom: 13,


      // styles: [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"simplified"},{"hue":"#0066ff"},{"saturation":74},{"lightness":100}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"off"},{"weight":0.6},{"saturation":-85},{"lightness":61}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#5f94ff"},{"lightness":26},{"gamma":5.86}]}],


	// styles: [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":-80},{"lightness":30},{"gamma":0.5},{"hue":"#3d433a"}]}]

	// styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]

	    // disableDefaultUI: true, // a way to quickly hide all controls
	    // mapTypeControl: true,
	    // scaleControl: true,
	    // zoomControl: true

	    // mapTypeId: google.maps.MapTypeId.SATELLITE,
	    // mapTypeId: google.maps.MapTypeId.HYBRID,

	    // mapTypeControl: false,
	    mapTypeControlOptions: {
            // style : 'SMALL',
            // position: 'BOTTOM_LEFT'
            position: google.maps.ControlPosition.TOP_RIGHT
        },
	    scaleControl: false,
	    streetViewControl: false,
	    // zoomControl: false,
	    // zoomControl: false,
	    zoomControlOptions: {
            // style : 'SMALL',
            // position: 'BOTTOM_LEFT'
            // position: google.maps.ControlPosition.TOP_RIGHT
            // position: google.maps.ControlPosition.RIGHT_TOP
            // position: google.maps.ControlPosition.TOP_RIGHT
            // position: google.maps.ControlPosition.RIGHT_BOTTOM
        },

	    controls: {
	        mapTypeControl: false,
	        zoomControl: false
	    }


    });


	// $( "#slider" ).slider();
	$( "#slider-range" ).slider({
      range: true,
      min: 1800,
      max: year,
      values: [ 1800, year ],
      slide: function( event, ui ) {
        $( "#slider-range-amount" ).html( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      }
    });
    $( "#slider-range-amount" ).html( "" + $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );

    $( "#slider-range" ).on( "slidestop", function( event, ui ) {

    	// console.log( ui.values );

    	// map.removeMarkers();
    	map.removeOverlays();


    	$.each(markers, function(i, v){

    		year = parseInt(v.year);
    		if ((year > ui.values[0] && year < ui.values[1]) || !year) {

	    		

		    	// console.log(v);

		    	map.drawOverlay({
			        lat: v.lat,
			        lng: v.lng,
			        content: '<div class="overlay overlayid' + v.id + '"></div>',
			        // click: function(e) {
			        //     openMapOverlay(v);
			        // }
			        // mouseover: function(e) {
			        //     openMapOverlay(v);
			        // }
					click: function(){
						// alert(435534);
						// openMapOverlay(v);
					}
			    });

			    $('#map').on("mouseover", '.overlayid' + v.id,  function(){
			    	// alert(76564);
			    	// console.log(3453);
			    	openMapOverlay(v);
			    });

			    $('#map').on("mouseout", '.overlayid' + v.id,  function(){
			    	// alert(76564);
			    	// console.log(3453);
			    	closeMapOverlay(v);
			    });

			}

	    });



    } );




	// map.drawOverlay({
 //        lat: 42.361407,
 //        lng: -83.069315,
 //        content: '<div class="overlay">3</div>',
 //        click: function(e) {
 //            //alert('You clicked in this marker');
 //            // viewPerson(3,3);
 //            // switchPage('grid');
 //            reloadGridByPlace('Byblos Cafe & Grill');
 //        }
 //    });

	latList = {};
	overlayList = {};

    $.each(markers, function(i, v){

    	// console.log(v);

    	// if same lng and lat already there, convert that overlay into an multiple overlay group

    	if ( overlayList["latlng" + v.lat + v.lng] && false ) {

    		map.removeOverlay( overlayList["latlng" + v.lat + v.lng] );

    		var overlaySameCoords = latList["latlng" + v.lat + v.lng];

    		overlayList["latlng" + v.lat + v.lng] = map.drawOverlay({
		        lat: v.lat,
		        lng: v.lng,
		        content: '<div class="overlay overlayMultiple overlayid' + v.id + '"><div class="overlayMultiple-number">' + overlaySameCoords.length + '</div></div>',
		        // click: function(e) {
		        //     openMapOverlay(v);
		        // }
		        // mouseover: function(e) {
		        //     openMapOverlay(v);
		        // }
				click: function(){
					// alert(435534);
					// openMapOverlay(v);
				}
		    });

		    $('#map').on("click", '.overlayid' + v.id,  function(){
		    	// alert(76564);
		    	// console.log(3453);
		    	openMapOverlayMultiple(v.id, overlaySameCoords);
		    });

		    // $('#map').on("click", '.overlayid' + v.id,  function(){
		    // 	// alert(76564);
		    // 	// console.log(3453);
		    // 	closeMapOverlay(v);
		    // });

    	} else {

    		overlayList["latlng" + v.lat + v.lng] = map.drawOverlay({
		        lat: v.lat,
		        lng: v.lng,
		        content: '<div class="overlay overlayid' + v.id + '"></div>',
		        // click: function(e) {
		        //     openMapOverlay(v);
		        // }
		        // mouseover: function(e) {
		        //     openMapOverlay(v);
		        // }
				click: function(){
					// alert(435534);
					// openMapOverlay(v);
				}
		    });

		    $('#map').on("mouseover", '.overlayid' + v.id,  function(){
		    	// alert(76564);
		    	// console.log(3453);
		    	openMapOverlay(v);
		    });

		    $('#map').on("mouseout", '.overlayid' + v.id,  function(){
		    	// alert(76564);
		    	// console.log(3453);
		    	closeMapOverlay(v);
		    });

		    $('#map').on("click", '.overlayid' + v.id,  function(){
		    	// alert(76564);
		    	// console.log(3453);
		    	// closeMapOverlay(v);

		    	window.open( host + "/view.php?id=" + v.id, '_blank' );

				// $("#theButton").button().click( function(event) {
					// $.post( "url", "data" )
					// .always( function( response ) {
					// 	window.open( host + "/view.php?id=" + v.id, '_blank' );
					// } );
				// } );
		    });

    	}
    	
    	// if ( latList["latlng" + v.lat + v.lng] ) {
    	// 	latList["latlng" + v.lat + v.lng] += 1;
    	// } else {
    	// 	latList["latlng" + v.lat + v.lng] = 1;
    	// }

		if ( latList["latlng" + v.lat + v.lng] ) {
    		latList["latlng" + v.lat + v.lng].push(v);
    	} else {
    		latList["latlng" + v.lat + v.lng] = [v];
    	}

	    

    });








}





function openMapOverlay(v) {
	overlay = $("#map .overlay.overlayid" + v.id);
	// overlay.css("z-index", "99999999999999999999");
	overlay.parent().css("z-index", "101");
	overlay.html(
		'<div class="overlay-popup">' +
			'<div class="overlay-popup-triangle"></div>' +
			'<div class="overlay-popup-image"><img style="width:100%;" src="' + v.thumbnail + '" /></div>' +
			'<div class="overlay-popup-title">' + v.title + '</div>' +
			'<div class="overlay-popup-date">Date: ' + v.date + '</div>' +
			'<div class="overlay-popup-date">Address: ' + v.formatted_address + '</div>' +
		'</div>'
	);
}



function closeMapOverlay(v) {
	overlay = $("#map .overlay.overlayid" + v.id);
	// overlay.css("z-index", "0");
	overlay.parent().css("z-index", "100");
	// overlay.html("");
	overlay.find(".overlay-popup").remove();
}


function openMapOverlayMultiple(id, overlaySameCoords) {
	console.log(id);
	overlay = $("#map .overlay.overlayid" + id);
	// overlay.css("z-index", "99999999999999999999");
	overlay.parent().css("z-index", "101");

	// overlay.html(
	// 	'<div class="overlay-popup">' +
	// 		'<div class="overlay-popup-image"><img style="width:100%;" src="' + v.thumbnail + '" /></div>' +
	// 		'<div class="overlay-popup-title">' + v.title + '</div>' +
	// 		'<div class="overlay-popup-date">Date: ' + v.date + '</div>' +
	// 		'<div class="overlay-popup-date">Address: ' + v.formatted_address + '</div>' +
	// 	'</div>'
	// );

	overlay.append('<div class="overlay-popup">');

	$.each(overlaySameCoords, function(i, v){
		overlay.find('.overlay-popup').append("<div>" + v.title + "</div>");
	});

}


// function initialize(){
//     var mapOptions = {
//         center: new google.maps.LatLng(-34.397, 150.644),
//         zoom: 8,
//         mapTypeId: google.maps.MapTypeId.ROADMAP
//     };
//     var map = google.maps.Map(
//               document.getElementById("map-results"),
//               mapOptions);
// }

// google.maps.event.addDomListener(window, 'load', initialize);
















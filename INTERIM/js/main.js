$( document ).ready(function() {
 
 //collections

    $( ".refine-more" ).on( "click", function() {
		$( ".browse" ).removeClass( "col-lg-12 col-xlg-12" ).addClass( "col-lg-9 col-xlg-9" );
		$( ".hidden-facets" ).show();
	});
 
 //single object

	$('.subcomponents img').click(function(){
		$('.primary-image').empty();
		$('.primary-image').attr('src',$(this).attr('src'));
	});

	$( ".more-info-clickr" ).on( "click", function() {
		$( ".display-more-info" ).fadeToggle(function() {
        $('.more-info').text($(this).is(':visible')? 'Less Info' : 'More Info');
      });
	});
});

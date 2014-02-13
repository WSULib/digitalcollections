$(function(){
    var default_view = 'list'; // choose the view to show by default (grid/list)
    
    // check the presence of the cookie, if not create "view" cookie with the default view value
    if($.cookie('view') !== 'undefined'){
        $.cookie('view', default_view, { expires: 7, path: '/' });
    }
    function get_grid(){
        $('.list').removeClass('list-active');
        $('.grid').addClass('grid-active');
        $('.obj-cnt').removeClass('object-container-list');
        $('.obj-cnt').addClass('object-container-grid');
    } // end "get_grid" function
    function get_list(){
        $('.grid').removeClass('grid-active');
        $('.list').addClass('list-active');
        $('.obj-cnt').removeClass('object-container-grid');
        $('.obj-cnt').addClass('object-container-list');
    } // end "get_list" function

    var default_filter = 'filter-on';

    if($.cookie('filter') !== 'undefined'){
        $.cookie('filter', default_filter, { expires: 7, path: '/' });
    }
    function get_filterOff(){
        $('.filter-on').hide();
        $('.filter-off').show();
        $('.facets').removeClass('show-me').addClass('hide-me');
        $('.main-container').removeClass('main-container').addClass('main-container-wide');
    }

    function get_filterOn(){
        $('.filter-off').hide();
        $('.filter-on').show();
        $('.facets').removeClass('hide-me').addClass('show-me');
        $('.main-container-wide').removeClass('main-container-wide').addClass('main-container');
    }

    if($.cookie('view') === 'list'){
        get_list();
    }

    if($.cookie('view') === 'grid'){
        get_grid();
    }

    if($.cookie('filter') === 'filter-off'){
        get_filterOff();
    }

    if($.cookie('filter') === 'filter-on'){
        get_filterOn();
    }

    // triggers

    $('.switch-views .list').click(function(){
        $.cookie('view', 'list');
        get_list();
    });

    $('.switch-views .grid').click(function(){
        $.cookie('view', 'grid');
        get_grid();
    });

    $('.switch-views .filter-on').click(function(){
        $.cookie('filter', 'filter-off');
        get_filterOff();
    });

    $('.switch-views .filter-off').click(function(){
        $.cookie('filter', 'filter-on');
        get_filterOn();
    });

    // hide filtered-by div if empty

});

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

    $( "body" ).on( "click", ".more-info-clickr", function() {
        $( ".display-more-info" ).fadeToggle(function() {
        $('.more-info').text($(this).is(':visible')? 'Less Info' : 'More Info');
      });
    });


   $('#responsive-menu-button').sidr({
      name: 'sidr-main',
      source: '#navigation, .top-nav'
    });

   $("body").on("click", ".view-share-buttons", function() {
        $('.share-buttons').slideToggle();
   });

});

$(document).ready(function(){
    /* This code is executed after the DOM has been completely loaded */

    /* Changing thedefault easing effect - will affect the slideUp/slideDown methods: */
    $.easing.def = "easeOutExpo";

    /* Using event delegation, listens for click on ".facet-toggle": */
    $(document).on('click','.tree-toggler',function(e){
    
        /* Finding the drop down list that corresponds to the current section: */
        var dropDown = $(this).next('ul');
        
        /* Closing all other drop down sections, except the current one */
        //$('.facet').not(dropDown).slideUp('slow');
        dropDown.slideToggle('slow');
        
        /* Preventing the default event (which would be to navigate the browser to the link's address) */
        e.preventDefault();

        // Toggle the class and check if the class has been already added or not  
            $(this).find('span').toggleClass('entypo-minus');
  
            if($(this).find('span').hasClass('entypo-plus')){
                $(this).find('span').removeClass('entypo-plus').addClass('entypo-minus');
            }else{
                $(this).find('span').removeClass('entypo-minus').addClass('entypo-plus');
            }
  
    });

    
    
});
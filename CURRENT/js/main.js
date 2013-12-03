$(function(){
    var default_view = 'grid'; // choose the view to show by default (grid/list)
    
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
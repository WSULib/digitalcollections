$( document ).ready(function() {

 //index background

    $('.thumbs img').click(function(){
        $('.slide.photo img').empty();
        $('.slide.photo img').attr('src',$(this).attr('src'));
    });

 //featured item feed

    $('.featured-item div').removeAttr("style");
    $('p:empty').hide();
 
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
        $( ".display-more-info" ).slideToggle(function() {
        $('.more-info').text($(this).is(':visible')? 'Less Info' : 'More Info');
      });
    });


   $('#responsive-menu-button').sidr({
      name: 'sidr-main',
      source: '.header-primary, .navbar-right'
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
            $(this).find('span').toggleClass('icon-minus-thin');
  
            if($(this).find('span').hasClass('icon-plus-thin')){
                $(this).find('span').removeClass('icon-plus-thin').addClass('icon-minus-thin');
            }else{
                $(this).find('span').removeClass('icon-minus-thin').addClass('icon-plus-thin');
            }
  
    });

    /* fire forced scroll bars */
    $(function() {
        // $('.facet_container').jScrollPane();
    });

    
    
});

/*
    Contact form
*/
jQuery(document).ready(function() {
    $('.contact-form form').submit(function() {

        $('.contact-form form .nameLabel').html('Name');
        $('.contact-form form .emailLabel').html('Email');
        $('.contact-form form .messageLabel').html('Message');

        var postdata = $('.contact-form form').serialize();
        $.ajax({
            type: 'POST',
            url: 'inc/sendmail.php',
            data: postdata,
            dataType: 'json',
            success: function(json) {
                if(json.nameMessage !== '') {
                    $('.contact-form form .nameLabel').append(' - <span class="validation"> ' + json.nameMessage + '</span>');
                }
                if(json.emailMessage !== '') {
                    $('.contact-form form .emailLabel').append(' - <span class="validation"> ' + json.emailMessage + '</span>');
                }
                if(json.messageMessage !== '') {
                    $('.contact-form form .messageLabel').append(' - <span class="validation"> ' + json.messageMessage + '</span>');
                }
                if(json.recaptchaMessage !== '') {
                    $('.contact-form form .recaptchaLabel').append(' - <span class="validation"> ' + json.recaptchaMessage + '</span>');
                }
                else {
                    if(json.nameMessage === '' && json.emailMessage === '' && json.messageMessage === '' && json.recaptchaMessage === '') {
                        $('.contact-form form').fadeOut('fast', function() {
                            $('.contact-form').append('<p class="thanks"><strong>Thanks for contacting us!</strong><br/>We will get back to you very soon.</p>');
                        });
                    }
                }
            }
        });
        return false;
    });
});

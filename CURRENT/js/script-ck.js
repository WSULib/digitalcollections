$(document).ready(function(){$.easing.def="easeOutExpo";$("li.button a").click(function(e){var t=$(this).parent().next();$(".dropdown").not(t).slideUp("slow");t.slideToggle("slow");e.preventDefault()})});
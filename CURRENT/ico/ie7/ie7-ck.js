/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script *//* The script tag referring to this file must be placed before the ending body tag. */(function(){function e(e,t){var n=e.innerHTML;e.innerHTML="<span style=\"font-family: 'icomoon'\">"+t+"</span>"+n}var t={"icon-star":"&#xe601;","icon-star-empty":"&#xe602;","icon-info":"&#xe600;","icon-facebook-sign":"&#xe603;","icon-twitter":"&#xe605;","icon-pinterest":"&#xe607;","icon-volume-up":"&#xe604;","icon-filter":"&#xe608;","icon-search":"&#xe609;","icon-download":"&#xe60a;","icon-chevron-down":"&#xe60b;","icon-caret-down":"&#xe60c;","icon-file-alt":"&#xe60e;","icon-book":"&#xe60f;","icon-chevron-left":"&#xe610;","icon-chevron-right":"&#xe611;","icon-caret-left":"&#xe612;","icon-caret-right":"&#xe613;","icon-angle-left":"&#xe614;","icon-angle-right":"&#xe615;","icon-angle-down":"&#xe616;","icon-question-sign":"&#xe617;","icon-calendar-empty":"&#xe618;","icon-globe":"&#xe619;","icon-share":"&#xe60d;","icon-save":"&#xe621;","icon-cloud-download":"&#xe622;","icon-link2":"&#xe606;","icon-play":"&#xe61a;","icon-books":"&#xe61b;","icon-calendar":"&#xe61c;","icon-book2":"&#xe61d;","icon-book3":"&#xe61e;","icon-book4":"&#xe61f;","icon-calendar2":"&#xe620;",0:0},n=document.getElementsByTagName("*"),r,i,s,o;for(r=0;;r+=1){o=n[r];if(!o)break;i=o.getAttribute("data-icon");i&&e(o,i);s=o.className;s=s.match(/icon-[^\s'"]+/);s&&t[s[0]]&&e(o,t[s[0]])}})();
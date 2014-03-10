/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-star': '&#xe601;',
		'icon-star-empty': '&#xe602;',
		'icon-info': '&#xe600;',
		'icon-facebook-sign': '&#xe603;',
		'icon-twitter': '&#xe605;',
		'icon-pinterest': '&#xe607;',
		'icon-volume-up': '&#xe604;',
		'icon-filter': '&#xe608;',
		'icon-search': '&#xe609;',
		'icon-download': '&#xe60a;',
		'icon-chevron-down': '&#xe60b;',
		'icon-caret-down': '&#xe60c;',
		'icon-file-alt': '&#xe60e;',
		'icon-book': '&#xe60f;',
		'icon-chevron-left': '&#xe610;',
		'icon-chevron-right': '&#xe611;',
		'icon-caret-left': '&#xe612;',
		'icon-caret-right': '&#xe613;',
		'icon-angle-left': '&#xe614;',
		'icon-angle-right': '&#xe615;',
		'icon-angle-down': '&#xe616;',
		'icon-question-sign': '&#xe617;',
		'icon-calendar-empty': '&#xe618;',
		'icon-globe': '&#xe619;',
		'icon-share': '&#xe60d;',
		'icon-save': '&#xe621;',
		'icon-cloud-download': '&#xe622;',
		'icon-link2': '&#xe606;',
		'icon-play': '&#xe61a;',
		'icon-books': '&#xe61b;',
		'icon-calendar': '&#xe61c;',
		'icon-book2': '&#xe61d;',
		'icon-book3': '&#xe61e;',
		'icon-book4': '&#xe61f;',
		'icon-calendar2': '&#xe620;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, attr, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());

/*
 
 bootpag - jQuery plugin for dynamic pagination

 Copyright (c) 2013 botmonster@7items.com

 Licensed under the MIT license:
   http://www.opensource.org/licenses/mit-license.php

 Project home:
   http://botmonster.com/jquery-bootpag/

 Version:  1.0.4

*/(function(e,t){e.fn.bootpag=function(t){function n(t,n){var o,u=0==s.maxVisible?1:s.maxVisible,c=1==s.maxVisible?0:1,p=Math.floor((n-1)/u)*u,d=t.find("li");s.page=n=0>n?0:n>s.total?s.total:n;d.removeClass("active");o=1>n-1?1:s.leaps&&n-1>=s.maxVisible?Math.floor((n-1)/u)*u:n-1;d.first().toggleClass("active",1===n).attr("data-lp",o).find("a").attr("href",r(o));c=1==s.maxVisible?0:1;o=n+1>s.total?s.total:s.leaps&&n+1<s.total-s.maxVisible?p+s.maxVisible+c:n+1;d.last().toggleClass("active",n===s.total).attr("data-lp",o).find("a").attr("href",r(o));u=d.filter("[data-lp="+n+"]");if(!u.not(".next,.prev").length){var v=n<=p?-s.maxVisible:0;d.not(".next,.prev").each(function(t){o=t+1+p+v;e(this).attr("data-lp",o).toggle(o<=s.total).find("a").html(o).attr("href",r(o))});u=d.filter("[data-lp="+n+"]")}u.addClass("active");i.trigger("page",n);i.data("settings",s)}function r(e){return s.href.replace(s.hrefVariable,e)}var i=this,s=e.extend({total:0,page:1,maxVisible:null,leaps:!0,href:"javascript:void(0);",hrefVariable:"{{number}}",next:"&raquo;",prev:"&laquo;"},i.data("settings")||{},t||{});if(0>=s.total)return this;!e.isNumeric(s.maxVisible)&&!s.maxVisible&&(s.maxVisible=s.total);i.data("settings",s);return this.each(function(){var t,i,o=e(this),u=['<ul class="pagination clearfix">'];s.prev&&u.push('<li data-lp="1" class="prev"><a href="'+r(1)+'">'+s.prev+"</a></li>");for(i=1;i<=Math.min(s.total,s.maxVisible);i++)u.push('<li data-lp="'+i+'"><a href="'+r(i)+'">'+i+"</a></li>");s.next&&(i=s.leaps&&s.total>s.maxVisible?Math.min(s.maxVisible+1,s.total):2,u.push('<li data-lp="'+i+'" class="next"><a href="'+r(i)+'">'+s.next+"</a></li>"));u.push("</ul>");o.find("ul.pagination").remove();o.append(u.join("")).addClass("pagination-centered");t=o.find("ul.pagination");o.find("li").click(function(){var r=e(this);r.hasClass("active")||n(t,parseInt(r.attr("data-lp"),10))});n(t,s.page)})}})(jQuery,window);
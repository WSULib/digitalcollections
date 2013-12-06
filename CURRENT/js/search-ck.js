// Javascript for search view
// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters (pre form submission)
function updatePage(){var e=document.URL;$("#q_string").html(mergedParams.q);$("#num_results").html(APIdata.solrSearch.response.numFound);$("#rows").val(mergedParams.rows).prop("selected",!0);$("#q").val(mergedParams.q);for(var t=0;t<mergedParams["fq[]"].length;t++){var n=mergedParams["fq[]"][t],r=n.split(":")[0],i=n.split(":").slice(1).join(":"),s=e.replace("fq[]="+encodeURI(n),"");$(".filtered-by").append("<span class='facet-item'><a href='"+s+"'>x "+rosetta(i)+"</a></span>")}var o=parseInt(APIdata.solrSearch.response.numFound/mergedParams.rows+1),u=parseInt(mergedParams.start/mergedParams.rows)+1;u==0&&(u=1);$(".pagination-centered").bootpag({total:o,page:u,maxVisible:10,leaps:!1}).on("page",function(e,t){var n=updateURLParameter(window.location.href,"start",t*mergedParams.rows-mergedParams.rows);window.location=n})}function searchGo(){function t(e){mix(e,APIdata);console.log("APIdata");console.log(APIdata);$(document).ready(function(){updatePage();populateFacets();populateResults()})}function n(e){console.log("API Call unsuccessful.  Back to the drawing board.")}searchParams["fq[]"]=searchParams.fq;delete searchParams.fq;mergedParams=jQuery.extend(!0,{},searchDefs,searchParams);debugSearchParams();solrParamsString=JSON.stringify(mergedParams);var e="http://silo.lib.wayne.edu/WSUAPI?functions[]=solrSearch&solrParams="+solrParamsString;$.ajax({url:e,dataType:"json",success:t,error:n})}function updateSearch(){var e=window.location.href;searchParams.rows=$("#rows").val();var e=updateURLParameter(e,"rows",searchParams.rows);if(searchParams.rows>searchParams.start)var e=updateURLParameter(e,"start","0");window.location=e}function populateFacets(){var e=document.URL,t=18;for(var n in APIdata.solrSearch.facet_counts.facet_fields){$("#facets_container").append("<ul class='facet_container filter' id='"+n+"_facet'><li><h3 class='tree-toggler'>"+rosetta(n)+"</h3><ul class='tree facet_list' id='"+n+"_list'></ul></li>");var r=APIdata.solrSearch.facet_counts.facet_fields[n];for(var i=0;i<r.length;i+=2){var s=rosetta(r[i]);if(r[i]!=""){fURL=e+"&fq[]="+n+':"'+r[i]+'"'+"&start=0";if(i>t)var o="class='hidden_facet'";else var o="";$("#"+n+"_list").append("<li "+o+"><a href='"+fURL+"'>"+s+" ("+r[i+1]+")</a></li>")}}if(r.length>t){$("#"+n+"_list").append("<p style='text-align:right;'><strong><a id='"+n+"_more' href='#' onclick='facetCollapseToggle(\"more\", \""+n+"\"); return false;'>more &raquo;</a></strong></p>");$("#"+n+"_list").append("<p style='text-align:right;'><strong><a class='facet_less' id='"+n+"_less' href='#' onclick='facetCollapseToggle(\"less\", \""+n+"\"); return false;'>&laquo; less</a></strong></p>")}}}function populateResults(){for(var e=0;e<APIdata.solrSearch.response.docs.length;e++)$.ajax({url:"templates/searchResultObj.htm",dataType:"html",async:!1,success:function(t){var n=t,r=Mustache.to_html(n,APIdata.solrSearch.response.docs[e]);$("#results_container").append(r)}})}var searchDefs={},mergedParams={};searchDefs.rows=12;searchDefs.start=0;searchDefs.wt="json";searchDefs.facet="true";searchDefs["facets[]"]=[];searchDefs["facets[]"].push("dc_date","dc_subject","dc_creator","dc_language","rels_hasContentModel","rels_isMemberOfCollection","dc_coverage");searchDefs["f.dc_date.facet.sort"]="index";searchDefs["fq[]"]=[];searchDefs["facet.mincount"]=1;searchDefs.fullView="";APIdata=new Object;
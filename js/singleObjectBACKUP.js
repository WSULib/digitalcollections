// singleObject view backup

  // // solrSiblings
  // // isMemberOfCollection
  // if (APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOfCollection != undefined){
  //   APIdata.solrSiblings = new Object();
  //   var collectionParents = APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOfCollection;  
  //   for (var i = collectionParents.length - 1; i >= 0; i--) {
  //     var parentComps = collectionParents[i].split(":");
  //     var safeName = parentComps[(parentComps.length - 1)]    
  //     // getSolrSiblings(safeName, collectionParents[i],0,5);    
  //   };
  // }
  // // isMemberOf
  // if (APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOf != undefined){
  //   APIdata.solrSiblings = new Object();
  //   var memberParents = APIdata.solr4FedObjsID.response.docs[0].rels_isMemberOf;  
  //   for (var i = memberParents.length - 1; i >= 0; i--) {
  //     var parentComps = memberParents[i].split(":");
  //     var safeName = parentComps[(parentComps.length - 1)]    
  //     // getSolrSiblings(safeName, memberParents[i],0,5);    
  //   };
  // }
  // else{
  //   $("#siblings").append("<p>This object has no siblings.");
  // }




  // Get members of a collection, with pagination
// function getSolrSiblings(safeName,PID,start,rows){  

//   var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='getSolrSiblings'&PID='"+PID+"'&start="+start+"&rows="+rows;
  
//   $.ajax({          
//       url: APIcallURL,      
//       dataType: 'jsonp',    
//       jsonpCallback: "jsonpcallback",              
//       success: getSolrSiblingsSuccess,
//       error: getSolrSiblingsError
//     });
//   //append results to APIdata as "solrSiblings"
//   function getSolrSiblingsSuccess(response){    
//     APIdata.solrSiblings[safeName] = response;
//     APIdata.solrSiblings[safeName].start = start;
//     APIdata.solrSiblings[safeName].nextStart = start+5;
//     APIdata.solrSiblings[safeName].prevStart = start-5;
//     APIdata.solrSiblings[safeName].rows = rows;    
//     APIdata.solrSiblings[safeName].PID = PID;

//     //render collection siblings to page, appending to #siblings via {{collectionSiblings.htm, AFTER added to global object
//     //grab and render template
//     $.get('templates/collectionSiblings.htm', function(template) {      
//       var html = Mustache.to_html(template, APIdata.solrSiblings[safeName]); //render with solrSiblings info
//       //append or replace HTML   
//       if ( $('[id="'+PID+'"]').length ) {
//         $('[id="'+PID+'"]').replaceWith(html);    
//       }
//       else{
//         $("#siblings").append(html);
//       }       
//     });    
//   }

//   function getSolrSiblingsError(response){
//     console.log('Could not complete siblings API request.');
//   }
// }

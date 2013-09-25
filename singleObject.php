<?php 
//Barebones of Single Object Page
$objectPID = $_REQUEST['PID'];
?>

<html>
<head>
    <script id="head_t" type="text/html">
        <title>{{solr4FedObjsID.response.docs.0.dc_title.0}}</title>
    </script>
	<!--jquery-->
	<script src="http://code.jquery.com/jquery.js"></script>
    <!--cookie.js-->
    <script src="http://silo.lib.wayne.edu/fedoraManager/js/jquery.cookie.js"></script>
	<!--load bootstrap js-->    
    <script src="inc/bootstrap/js/bootstrap.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="inc/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!--Mustache-->
    <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
	<script type="text/javascript" src="inc/mustache.js"></script>
    <!-- Local JS -->
    <script src="js/singleObject.js"></script>
    <!-- Local CSS -->
	<link href="css/style.css" rel="stylesheet">
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
</head>

<body>

	<div id="container" class="container-fluid">      
    	
		<!--row1-->
    	<div class="row-fluid">

    		<!--image preview testing-->
    		<div id="preview" class="templated span6">
    			<!-- <h3>Preview</h3>    			 -->
                <div id="preview_container"></div>
			</div>

    		<!--metadata testing-->
    		<div id="metadata" class="templated span6">    			
    			<script id="metadata_t" type="text/html">
					<p><strong>Title: </strong>{{solr4FedObjsID.response.docs.0.dc_title.0}}</p>					
					<p><strong>Description: </strong>{{solr4FedObjsID.response.docs.0.dc_description.0}}</p>
                    <p><strong>Date: </strong>{{solr4FedObjsID.response.docs.0.dc_date.0}}</p>
                    <p><strong>Language: </strong>{{solr4FedObjsID.response.docs.0.dc_language.0}}</p>
                    <p><strong>Rights: </strong>{{solr4FedObjsID.response.docs.0.dc_rights.0}}</p>                    
                    {{#solr4FedObjsID.response.docs.0.dc_subject}}
                    <p><strong>Subject: </strong>{{.}}</p>
                    {{/solr4FedObjsID.response.docs.0.dc_subject}}
                    <p><span style="color:green; font-weight:bold;">Content Type: {{solr4FedObjsID.response.docs.0.rels_hasContentModel.0}}</span></p>
				</script>                	
			</div>

		</div>

		<!--row2-->
    	<div class="row-fluid">

    		<!--children testing-->
    		<div id="children" class="templated span6">
    			<h3>Components:</h3>
                <script id="children_t" type="text/html">    				
                    {{#hasMemberOf.results}}    					
						<p><a href="http://silo.lib.wayne.edu/digitalcollections/singleObject.php?PID={{object}}">{{memberTitle}}</a></p>
					{{/hasMemberOf.results}}					
				</script> 
			</div>

    		<!--parents testing-->
    		<div id="parents" class="span6">    			
                <h3>Part of Collection(s):</h3>
                <script id="parents_t" type="text/html">                   
                    {{#isMemberOfCollection.results}}                                                
                        <p><a href="http://silo.lib.wayne.edu/digitalcollections/collection.php?PID={{subject}}">{{collectionTitle}}</a></p>
                    {{/isMemberOfCollection.results}}                    
                </script> 
			</div>

		</div>		
		
	</div>

	<!--Testing API call-->
	<script type="text/javascript">
		$(document).ready(function(){
			var PID = "<?php echo $objectPID; ?>";			
			APIcall(PID);	
		})		
	</script>

</body>
</html>

<?php include_once('functions.php'); 
    // Build out URI to reload from form dropdown
    $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    if (isset($_POST['uri']) && isset($_POST['section'])) {
        $pageURL .= $_POST[uri].$_POST[section];
        header("Location: $pageURL");
    }
?>
<!doctype HTML>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>WSULS UI Library</title>

	<link rel="stylesheet" href="css/ui-library.css" />
    <link rel="stylesheet" href="css/wsu-ui-library.css" />
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,700|Roboto+Condensed:400,400italic,700|Alegreya:700|Marcellus+SC" rel="stylesheet" type="text/css" />
    
</head>

<body class="xx">
    
    <?php if(isset($_GET["url"])) : ?>
        
        <?php include($patternsPath.$_GET["url"]) ?>

    <?php else : ?>

        <section class="main-content">
        
            <h1 class="xx-title">UI Library</h1>
            <p class="xx-subtitle">Wayne State University Libraries' style guide and pattern library</p>

            <div class="global-nav deluxe xx-nav">
                
                <ul class="inline-items">
                    <li><a href="#">WSU Libraries</a></li>
                </ul>
                
                <form action="" method="post" id="pattern" class="pattern-jump">
                    <select name="section" id="pattern-select" class="nav-section-select">
                        <option value="">Jump to&#8230;</option>
                        <?php displayOptions($patternsPath); ?>
                        
                    </select>
                    <input type="hidden" name="uri" value="<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>">
                    <button type="submit" id="pattern-submit">Go</button>
                </form>
                
            </div>
            
            <main role="main">
                
                <div class="pattern">
                	<div class="pattern-details">
                	    <h3 class="pattern-name">Swatches</h3>
                	</div>
                    <div class="pattern-preview">
                        <ul class="swatches">
                            <li class="swatch">
                                <p class="swatch-preview" style="background-color: #0c5449;">
                                    <span class="swatch-details"><strong>$wsu-green:</strong> #0c5449</span>
                                </p>
                            </li>
                            <li class="swatch">
                                <p class="swatch-preview" style="background-color: #062722;">
                                    <span class="swatch-details"><strong>$wsu-green-dark:</strong> #062722</span>
                                </p>
                            </li>
                            <li class="swatch">
                                <p class="swatch-preview" style="background-color: #ffcc33;"></span>
                                    <span class="swatch-details" style="color: #000;"><strong>$wsu-yellow:</strong> #ffcc33</span>
                                </p>
                            </li>
                            <li class="swatch">
                                <p class="swatch-preview" style="background-color: #ffdf80;"></span>
                                    <span class="swatch-details" style="color: #000;"><strong>$wsu-yellow-light:</strong> #ffdf80</span>
                                </p>
                            </li>
                            <li class="swatch">
                                <p class="swatch-preview" style="background-color: #f1efe5;">
                                    <span class="swatch-details" style="color: #000;"><strong>$wsu-beige:</strong> #f1efe5</span>
                                </p>
                            </li>
                		</ul>
                	</div>
                </div>

        		<div class="pattern">
        			<div class="pattern-details">
        			    <h3 class="pattern-name">Typography</h3>
        			</div>
        			<div class="pattern-preview">
        		    	<ul>
                            <li style="font-family: 'Marcellus SC', serif">Wayne State University: Marcellus SC <small>· <a href="http://www.google.com/fonts/specimen/Marcellus+SC">View at Google Fonts</a></small></li>
        		    		<li style="font-family: 'Roboto', sans-serif">Body text: Roboto <small>· <a href="https://www.google.com/fonts/specimen/Roboto">View at Google Fonts</a></small></li>
        		    		<li style="font-family: 'Roboto', sans-serif; font-style: italic">Body text: Roboto Italic</li>
        		    		<li style="font-family: 'Roboto', sans-serif; font-weight: 700;">Bold body text: Roboto 700</li>
        		    		
        		    		<li style="font-family: 'Roboto Condensed', sans-serif;">Condensed for mobile: Roboto Condensed · <a href="https://www.google.com/fonts/specimen/Roboto+Condensed">View at Google Fonts</a></li>
                            <li style="font-family: 'Roboto Condensed', sans-serif; font-style: italic;">Condensed for mobile: Roboto Condensed Italic</li>
                            <li style="font-family: 'Roboto Condensed', sans-serif; font-weight: 700;">Bold condensed for mobile: Roboto Condensed 700</li>
        		    	</ul>
        		    </div>
        		</div>
        		
                <?php displayPatterns($patternsPath); ?>
            
            </main>
        
        </section>
    
    <?php endif; ?>
	
</body>

<script src="js/pattern-lib.js"></script>

</html> 
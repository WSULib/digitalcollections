

<div id="header">
	<a id="header-logo" href="<?php echo $host ?>">
		<div id="header-logo-top">
			Wayne State University Libraries
		</div>
		<div id="header-logo-bottom">
			Digital Collections
		</div>
	</a>
	<div id="header-search">
		<div id="header-search-nest">
			<form action="<?php echo $host ?>/search.php" method="GET">
				<input id="header-search-nest-input" type="text" name="search" placeholder="Search collections, images, documents, ebooks and more" value="<?php echo $query ?>" autocomplete="off" />
			</form>
		</div>
	</div>
	<div id="header-links">
		<a href="<?php echo $host ?>/collections.php">Collections</a>
		<a href="<?php echo $host ?>/search.php">Browse</a>
		<a href="<?php echo $host ?>/about.php">About</a>
		<a href="<?php echo $host ?>/contact.php">Contact</a>
	</div>
</div>
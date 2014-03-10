<header class="header">
    <div class="container">
        
       <!--  <nav class="header-global">
            <ul class="top-level">
                <li><a href="#">Wayne State University</a></li>
                <li><a href="#">Libraries</a></li>
            </ul>

            <ul class="login">
                <li class="login_status"><a href="login.php">Log In / Sign Up</a></li>
            </ul>
        </nav> -->
        <div id="mobile-header">
            <a href="#sidr-main" id="responsive-menu-button"><img src="img/menu.svg" alt="Menu"></a>
        </div>
        <div class="logo-container">
            <h1>
                <a href="index.php"><img src="img/logo.png" alt="" class="logo"></a>
            </h1>
        </div>
        <div class="search-container">
            <div class="search-box">
                <form action="search.php" class="inline-form search-form" >
                    <fieldset>
                        <legend class="hide">Search</legend>
                        <label for="search-field" class="hide">Search</label>
                        <input class="searchTerm search-field" value="" name="q" id="q" type="text" autofocus="autofocus" placeholder="Search our digital collections" lang="en" x-webkit-speech />
                        <button type="submit" class="search-submit">
                            <span class="glyphicons search" aria-hidden="true"></span>
                            <span class="hide">Search</span>
                        </button>
                    </fieldset>
                </form>
            </div>
        </div>

        <div id="navigation" class="col-sm-12">
            <nav class="header-primary nav navbar" role="navigation">
                <ul class="nav navbar-nav">
                    <li><a href="allcollections.php">Collections</a></li>
                    <li><a href="search.php">Browse</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>

            <nav>
                <ul class="nav navbar-right">
                    <li class="login_status"><a href="login.php">Log In / Sign Up</a></li>
                </ul>
            </nav>
        </div>

    </div>
</header>
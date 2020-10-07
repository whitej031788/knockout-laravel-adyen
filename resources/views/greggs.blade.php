<!DOCTYPE html>
<html id="ng-app" data-ng-app="app" xmlns:ng="http://angularjs.org" class="geolocation localstorage canvas adownload no-touchevents formvalidation srcset ng-scope">
  <head>
    <style type="text/css">
      @charset "UTF-8";
      [ng\:cloak],
      [ng-cloak],
      [data-ng-cloak],
      [x-ng-cloak],
      .ng-cloak,
      .x-ng-cloak,
      .ng-hide:not(.ng-hide-animate) {
      display: none !important;
      }
      ng\:form {
      display: block;
      }
      .ng-animate-shim {
      visibility: hidden;
      }
      .ng-anchor {
      position: absolute;
      }
    </style>
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
    <script id="twitter-wjs" src="https://platform.twitter.com/widgets.js"></script>
    <script async="" src="https://www.greggs.co.uk//static.ads-twitter.com/uwt.js"></script>
    <script src="https://connect.facebook.net/signals/config/168209450773905?v=2.9.18&amp;r=stable" async=""></script>
    <script async="" src="https://connect.facebook.net/en_US/fbevents.js"></script>
    <script async="" src="https://www.greggs.co.uk//www.googletagmanager.com/gtm.js?id=GTM-KSCZXG"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    {{-- <title>Greggs</title> --}}
    <title>IP Centrum Invoice Generator</title>
    <meta name="description" content="From sandwiches to pasties, pick a great deal for breakfast and lunch at your local Greggs today. Read more here at greggs.co.uk">
    <meta name="keywords" content="">
    <meta http-equiv="content-type" content="text/html; charset=utf-8 ;">
    <meta http-equiv="Content-Security-Policy" content="default-src * data:; style-src 'self' http://* 'unsafe-inline'; script-src 'self' http://* 'unsafe-inline' 'unsafe-eval'">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Facebook Pixel Code -->
    <script>
      ! function(f, b, e, v, n, t, s) {
          if (f.fbq) return;
          n = f.fbq = function() {
              n.callMethod ?
                  n.callMethod.apply(n, arguments) : n.queue.push(arguments)
          };
          if (!f._fbq) f._fbq = n;
          n.push = n;
          n.loaded = !0;
          n.version = '2.0';
          n.queue = [];
          t = b.createElement(e);
          t.async = !0;
          t.src = v;
          s = b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t, s)
      }(window, document, 'script',
          'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '168209450773905');
      fbq('track', 'PageView');
    </script>
    <noscript>
      <img height="1" width="1" src="https://www.facebook.com/tr?id=168209450773905&ev=PageView
        &noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Twitter universal website tag code -->
    <script>
      ! function(e, t, n, s, u, a) {
          e.twq || (s = e.twq = function() {
                  s.exe ? s.exe.apply(s, arguments) : s.queue.push(arguments);
              }, s.version = '1.1', s.queue = [], u = t.createElement(n), u.async = !0, u.src = '//static.ads-twitter.com/uwt.js',
              a = t.getElementsByTagName(n)[0], a.parentNode.insertBefore(u, a))
      }(window, document, 'script');
      // Insert Twitter Pixel ID and Standard Event data below
      twq('init', 'o0yww');
      twq('track', 'PageView');
    </script>
    <!-- End Twitter universal website tag code -->
    <!-- Bing Meta -->
    <meta name="msvalidate.01" content="5DE99F8EB7E368279F5E83E1A8EC8EBC">
    <script>
      // Picture element HTML5 shiv
      document.createElement("picture");
    </script>
    <!-- FACBOOK META -->
    {{-- <meta property="og:title" content="Greggs">
    <meta property="og:description" content="From sandwiches to pasties, pick a great deal for breakfast and lunch at your local Greggs today. Read more here at greggs.co.uk">
    <meta property="og:image" content="https://greggs.co.uk/res/img/greggs_facebook_share.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">
    <!-- TWITTER META -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Greggs">
    <meta name="twitter:creator" content="@Greggs">
    <meta name="twitter:title" content="Greggs">
    <meta name="twitter:description" content="From sandwiches to pasties, pick a great deal for breakfast and lunch at your local Greggs today. Read more here at greggs.co.uk">
    <meta name="twitter:image" content="https://greggs.co.uk/res/img/greggs_twitter_share.jpg">
    <link rel="shortcut icon" href="https://www.greggs.co.uk/res/img/icon/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="https://www.greggs.co.uk/res/img/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://www.greggs.co.uk/res/img/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://www.greggs.co.uk/res/img/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://www.greggs.co.uk/res/img/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://www.greggs.co.uk/res/img/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://www.greggs.co.uk/res/img/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://www.greggs.co.uk/res/img/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://www.greggs.co.uk/res/img/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://www.greggs.co.uk/res/img/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://www.greggs.co.uk/res/img/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://www.greggs.co.uk/res/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://www.greggs.co.uk/res/img/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://www.greggs.co.uk/res/img/icon/favicon-16x16.png">
    <link rel="manifest" href="https://www.greggs.co.uk/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="res/img/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff"> --}}
    <link rel="shortcut icon" href="https://d372dbxlg0efz4.cloudfront.net/favicon.ico">
    <link rel="stylesheet" href="/css/greggs.min.css">
    <!--[if lte IE 8]>
    <script src="https://www.greggs.co.uk//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
    <![endif]-->
  </head>
  <body ng-controller="mainCtrl" class="ng-scope">
    {{-- <!-- MOBILE MENU -->
    <div id="mobile-menu">
      <div class="wrapper">
        <div class="panels">
          <a class="link" href="coronavirus" title="Coronavirus" alt="Coronavirus">
            <h3>Coronavirus Update</h3>
            <i class="fa fa-chevron-right"></i>
          </a>
          <div class="panel">
            <div class="panelheader" data-state="closed">
              <h3>Menu</h3>
              <i class="fa fa-chevron-right"></i>
            </div>
            <div class="panelcontent">
              <div class="panelwrapper">
                <ul>
                  <!-- ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope" style="">
                    <a ng-href="breakfast" alt="Breakfast" title="Breakfast" class="ng-binding" href="breakfast">Breakfast</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="sandwiches" alt="Sandwiches" title="Sandwiches" class="ng-binding" href="sandwiches">Sandwiches</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="pasta-salads-and-soup" alt="Pasta, Salads and Soup" title="Pasta, Salads and Soup" class="ng-binding" href="pasta-salads-and-soup">Pasta, Salads and Soup</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="drinks-and-snacks" alt="Drinks and Snacks" title="Drinks and Snacks" class="ng-binding" href="drinks-and-snacks">Drinks and Snacks</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="bakes" alt="Bakes" title="Bakes" class="ng-binding" href="bakes">Bakes</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="sweet-treats" alt="Sweet Treats" title="Sweet Treats" class="ng-binding" href="sweet-treats">Sweet Treats</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="platters" alt="Platters" title="Platters" class="ng-binding" href="platters">Platters</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="balanced-choice" alt="Balanced Choice" title="Balanced Choice" class="ng-binding" href="balanced-choice">Balanced Choice</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li ng-repeat="cat in categories" on-finish-render="ngRepeatFinished" class="ng-scope">
                    <a ng-href="hot-to-go" alt="Hot to Go" title="Hot to Go" class="ng-binding" href="hot-to-go">Hot to Go</a>
                  </li>
                  <!-- end ngRepeat: cat in categories -->
                  <li>
                    <!-- <button type="button" ng-click="openCatSearch();"><i class="fa fa-search"></i> Search</button> -->
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <a class="link" href="nutrition" title="Allergen and Nutrition" alt="Allergen and Nutrition">
            <h3>Allergen &amp; Nutrition</h3>
            <i class="fa fa-chevron-right"></i>
          </a>
          <a class="link" href="rewards" title="Greggs Rewards" alt="Greggs Rewards">
            <h3>Greggs Rewards</h3>
            <i class="fa fa-chevron-right"></i>
          </a>
          <a class="link" href="delivery" title="Delivery" alt="Delivery">
            <h3>Delivery</h3>
            <i class="fa fa-chevron-right"></i>
          </a>
          <a class="link" href="gifts" title="Greggs Gifts" alt="Greggs Gifts">
            <h3>Gifts</h3>
            <i class="fa fa-chevron-right"></i>
          </a>
          <div class="panel" id="extra">
            <div class="panelheader" data-state="closed">
              <h3>More</h3>
              <i class="fa fa-chevron-right"></i>
            </div>
            <div class="panelcontent">
              <div class="panelwrapper">
                <ul>
                  <li><a target="_blank" href="https://www.greggsfoundation.org.uk/" title="Greggs Foundation" alt="Greggs Foundation">Greggs
                    Foundation</a>
                  </li>
                  <li><a target="_blank" href="http://www.greggsfamily.co.uk/" alt="Work for Greggs" title="Work for Greggs">Work
                    for Greggs</a>
                  </li>
                  <li><a target="_blank" href="http://corporate.greggs.co.uk/" title="Greggs Corporate" alt="Greggs Corporate">Corporate</a></li>
                  <li><a href="about" title="About" alt="About">About</a></li>
                  <li><a href="contact" title="Contact Us" alt="Contact Us">Contact Us</a></li>
                  <li><a href="faq" title="Greggs FAQ" alt="Greggs FAQ">FAQ's</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="push"></div>
      </div>
      <div id="footer">
        <div id="social">
          <ul>
            <li>
              <a href="https://www.facebook.com/greggsofficial" target="_blank" alt="Greggs Facebook Link" title="Greggs Facebook Link"><i class="fa fa-facebook"></i></a>
            </li>
            <li><a href="https://twitter.com/greggsofficial" target="_blank" alt="Greggs Twitter Link" title="Greggs Twitter Link"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://instagram.com/greggs_official/" target="_blank" alt="Greggs Instagram Link" title="Greggs Instagram Link"><i class="fa fa-instagram"></i></a></li>
            <li class="last_child"><a href="https://www.youtube.com/user/GreggsFreshBaking" target="_blank" alt="Greggs Youtube Link" title="Greggs Youtube Link"><i class="fa fa-youtube-play"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div id="mobile_store_locator" style="display: none;">
      <form name="store_locator" class="ng-pristine ng-invalid ng-invalid-required">
        <div id="input_wrapper">
          <input type="text" ng-model="mobileSearch" id="mobileSearch" name="store_input" placeholder="Find a store" required="" class="ng-pristine ng-untouched ng-invalid ng-invalid-required">
          <button class="geolocation_button" type="button" geolocation=""><i class="fa fa-map-marker"></i></button>
        </div>
        <button id="mobileSearchLocator" type="submit" ng-click="mobileSearchLocator();">Search</button>
      </form>
    </div>
    <header id="main">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div id="logo" home-icon="">
              <a href="https://www.greggs.co.uk/" alt="Greggs Home" title="Greggs Home" event="event" category="Header" action="click" label="Main Logo">
                <h1>Greggs</h1>
              </a>
            </div>
            <button id="mobile-button" mobile-button="">
              <div id="nav-icon">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </button>
            <div id="right">
              <nav id="desktop">
                <ul>
                  <li>
                    <a ng-class="getClass('coronavirus')" href="coronavirus" title="coronavirus">Coronavirus Update</a>
                  </li>
                  <li>
                    <a alt="Our Meals" title="Our Menu" data-id="meals">Menu</a>
                  </li>
                  <li><a ng-class="getClass('nutrition')" href="nutrition" title="Allergen and Nutrition" alt="Allergen and Nutrition">Allergen
                    &amp; Nutrition</a>
                  </li>
                  <li>
                    <a ng-class="getClass('rewards')" href="rewards" alt="Greggs Rewards" title="Greggs Rewards">Greggs Rewards</a>
                  </li>
                  <li>
                    <a ng-class="getClass('delivery')" href="delivery" title="Delivery">Delivery</a>
                  </li>
                  <li>
                    <a ng-class="getClass('gifts')" href="gifts" alt="Greggs Gift" title="Greggs Gift" event="event" category="Header" action="click" label="Gifts">Gifts</a>
                  </li>
                  <li ng-show="!currentUser" event="event" category="Header" action="click" label="Register/Login" class="">
                    <a ng-href="https://www.greggs.co.uk/account/login" href="https://www.greggs.co.uk/account/login">Register / Login</a>
                  </li>
                  <!-- ngIf: currentUser -->
                </ul>
              </nav>
              <div id="more">
                <a data-id="extra" alt="extra" title="extra">
                  <ul>
                    <li style="color: rgb(255, 255, 255);">●</li>
                    <li style="color: rgb(255, 255, 255);">●</li>
                    <li style="color: rgb(255, 255, 255);">●</li>
                  </ul>
                  MORE
                </a>
              </div>
            </div>
            <button id="mobile_search" store-find-button="">
            <i class="fa fa-map-marker"></i> Find a Shop</button>
            <div id="header_store">
              <button id="store_find_button" store-find-button="">
              Shop Finder
              </button>
            </div>
            <div id="header_store">
              <button id="click_and_collect" store-find-button="">
              <b>Click & Collect</b>
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>
    <section id="sub_menu">
      <div id="wrapper">
        <div ng-switch="selectedMenu">
          <!-- ngSwitchWhen: meals -->
          <!-- ngSwitchWhen: extra -->
        </div>
      </div>
    </section>
    <section id="cat_search_bar">
      <form name="catsearch" ng-submit="searchCat(catsearch);" class="ng-pristine ng-valid ng-valid-pattern">
        <div id="search_wrapper">
          <div id="all_search">
            <div id="searchQueryWrapper">
              <div id="input_wrapper">
                <input type="text" placeholder="Search" name="search_input" ng-model="searchQuery" ng-pattern="/^([a-zA-Z0-9 _-]+)$/" class="ng-pristine ng-untouched ng-valid ng-valid-pattern">
                <!-- ngIf: catsearch.search_input.$touched -->
                <div class="preloader">
                  <svg class="spinner" width="20px" height="20px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                  </svg>
                </div>
              </div>
              <div id="submit_container">
                <button type="submit" id="cat_main_search" class="main_button yellow">Search</button>
                <button id="filter" type="button" ng-click="openFilters()"><i class="fa fa-sliders"></i></button>
              </div>
            </div>
            <button id="close_search img-cover" type="button" ng-click="closeSearchBar();"></button>
          </div>
          <div id="filter_search" checkbox-toggle="">
            <div class="wrapper">
              <div id="general">
                <div id="filters">
                  <div class="intro">
                    <h3>Categories</h3>
                    <p>Uncheck to remove from search</p>
                  </div>
                  <ul class="categories ng-isolate-scope">
                    <!-- ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope" style="">
                      <input id="checkbox-cat-0" class="checkbox-custom" name="categories" value="breakfast" type="checkbox">
                      <label for="checkbox-cat-0" class="checkbox-custom-label ng-binding">Breakfast</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-1" class="checkbox-custom" name="categories" value="sandwiches" type="checkbox">
                      <label for="checkbox-cat-1" class="checkbox-custom-label ng-binding">Sandwiches</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-2" class="checkbox-custom" name="categories" value="pasta-salads-and-soup" type="checkbox">
                      <label for="checkbox-cat-2" class="checkbox-custom-label ng-binding">Pasta, Salads and Soup</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-3" class="checkbox-custom" name="categories" value="drinks-and-snacks" type="checkbox">
                      <label for="checkbox-cat-3" class="checkbox-custom-label ng-binding">Drinks and Snacks</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-4" class="checkbox-custom" name="categories" value="bakes" type="checkbox">
                      <label for="checkbox-cat-4" class="checkbox-custom-label ng-binding">Bakes</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-5" class="checkbox-custom" name="categories" value="sweet-treats" type="checkbox">
                      <label for="checkbox-cat-5" class="checkbox-custom-label ng-binding">Sweet Treats</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-6" class="checkbox-custom" name="categories" value="platters" type="checkbox">
                      <label for="checkbox-cat-6" class="checkbox-custom-label ng-binding">Platters</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-7" class="checkbox-custom" name="categories" value="balanced-choice" type="checkbox">
                      <label for="checkbox-cat-7" class="checkbox-custom-label ng-binding">Balanced Choice</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                    <li ng-repeat="cat in categories" class="ng-scope">
                      <input id="checkbox-cat-8" class="checkbox-custom" name="categories" value="hot-to-go" type="checkbox">
                      <label for="checkbox-cat-8" class="checkbox-custom-label ng-binding">Hot to Go</label>
                    </li>
                    <!-- end ngRepeat: cat in categories -->
                  </ul>
                </div>
                <div id="calories_container">
                  <div class="intro">
                    <h3>Calories</h3>
                    <p>Search by number of calories.</p>
                  </div>
                  <div id="calories_input">
                    <input type="text" name="calories" ng-model="query.filters.maxCalories" placeholder="1000" class="ng-pristine ng-untouched ng-valid">
                    <label>Calories</label>
                  </div>
                  <input type="range" id="calories_range" name="range_calories" min="0" max="1000" ng-model="query.filters.maxCalories" class="ng-pristine ng-untouched ng-valid">
                  <p>Maximum 1000 calories</p>
                </div>
              </div>
              <div id="allergens">
                <div class="intro">
                  <h3>Allergens</h3>
                  <p>Uncheck to remove items that contain that ingredient.</p>
                </div>
                <ul class="allergies ng-isolate-scope">
                  <!-- ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope" style="">
                    <input id="checkbox-0" class="checkbox-custom" name="allergies" value="Wheat" type="checkbox">
                    <label for="checkbox-0" class="checkbox-custom-label"><span class="title ng-binding">Wheat</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-1" class="checkbox-custom" name="allergies" value="Milk" type="checkbox">
                    <label for="checkbox-1" class="checkbox-custom-label"><span class="title ng-binding">Milk</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-2" class="checkbox-custom" name="allergies" value="Mustard" type="checkbox">
                    <label for="checkbox-2" class="checkbox-custom-label"><span class="title ng-binding">Mustard</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-3" class="checkbox-custom" name="allergies" value="Soya" type="checkbox">
                    <label for="checkbox-3" class="checkbox-custom-label"><span class="title ng-binding">Soya</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-4" class="checkbox-custom" name="allergies" value="Barley" type="checkbox">
                    <label for="checkbox-4" class="checkbox-custom-label"><span class="title ng-binding">Barley</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-5" class="checkbox-custom" name="allergies" value="Egg" type="checkbox">
                    <label for="checkbox-5" class="checkbox-custom-label"><span class="title ng-binding">Egg</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-6" class="checkbox-custom" name="allergies" value="Fish" type="checkbox">
                    <label for="checkbox-6" class="checkbox-custom-label"><span class="title ng-binding">Fish</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-7" class="checkbox-custom" name="allergies" value="Celery" type="checkbox">
                    <label for="checkbox-7" class="checkbox-custom-label"><span class="title ng-binding">Celery</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-8" class="checkbox-custom" name="allergies" value="Oats" type="checkbox">
                    <label for="checkbox-8" class="checkbox-custom-label"><span class="title ng-binding">Oats</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-9" class="checkbox-custom" name="allergies" value="Sulphites" type="checkbox">
                    <label for="checkbox-9" class="checkbox-custom-label"><span class="title ng-binding">Sulphites</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-10" class="checkbox-custom" name="allergies" value="Sesame" type="checkbox">
                    <label for="checkbox-10" class="checkbox-custom-label"><span class="title ng-binding">Sesame</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-11" class="checkbox-custom" name="allergies" value="Nuts" type="checkbox">
                    <label for="checkbox-11" class="checkbox-custom-label"><span class="title ng-binding">Nuts</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-12" class="checkbox-custom" name="allergies" value="Rye" type="checkbox">
                    <label for="checkbox-12" class="checkbox-custom-label"><span class="title ng-binding">Rye</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-13" class="checkbox-custom" name="allergies" value="N/A" type="checkbox">
                    <label for="checkbox-13" class="checkbox-custom-label"><span class="title ng-binding">N/A</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                  <li ng-repeat="allegen in allergies" class="ng-scope">
                    <input id="checkbox-14" class="checkbox-custom" name="allergies" value="Crustaceans" type="checkbox">
                    <label for="checkbox-14" class="checkbox-custom-label"><span class="title ng-binding">Crustaceans</span></label>
                  </li>
                  <!-- end ngRepeat: allegen in allergies -->
                </ul>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div id="background"></div>
    </section> --}}
    <!-- uiView:  -->
    <main class="page" autoscroll="false" ui-view="" style="padding-top: 0px;">
      {{-- <section id="home" class="flex-col ng-scope">
        <section id="home_menu">
          <h2>Pay By Link Tender Option</h2>
          <h3>Store Location: NEWC637</h3>
          <section id="app_info" style="height: unset;">
            <div id="app_container" class="container-fluid">
              <div id="rewardinfo" style="margin: 0 auto; width: unset; height: unset; position: relative; top: 0%;transform: translateY(0%); padding: 20px;">
                <p>In order to allow taking secure, contactless payment, please use the below form to enter the customer order information and details using the following steps:</p>
                <br />
                <ol>
                  <li>1) Take customer order over the phone via the register</li>
                  <li>2) Confirm order selection with customer</li>
                  <li>3) Go to form below and enter minimum customer details</li>
                  <li>4) On successful submission, alert the customer they will receive a secure payment link via which they can make their payment</li>
                  <li>5) Let customer know that on receipt of successful payment, their order will be prepared and available for contactless pickup within 15 minutes</li>
                </ol>
              </div>
            </div>
          </section> --}}
          {{-- <section id="grid_products" class="menu_grid">
            <div class="container-fluid">
              <div class="product_grid">
                <!-- ko foreach: sellableItems -->
                <div class="product">
                  <a "attr: { alt: name, title: name }">
                    <div class="wrapper">
                      <div class="product_image img-cover" data-bind="style: {'background-image': 'url('+ image +')'}"></div>
                      <div class="info">
                        <h3 data-bind="text: name"></h3>
                        <p data-bind="text: '£' + price"></p>
                        <button type="button" id="add_item" class="submit_button main_button yellow" data-bind="click: function() { $parent.addOne($data); }" style="width: 40%; float: left;">Add +</button>
                        <button type="button" id="add_item" class="submit_button main_button yellow" data-bind="click: function() { $parent.removeOne($data); }" style="width: 40%; float: left; margin-left: 10px;">Remove -</button>
                        <span style="font-weight: 900; font-size: 18px;" data-bind="text: quantity, visible: quantity() > 0"></span>
                      </div>
                    </div>
                  </a>
                </div>
                <!-- /ko -->
              </div>
          </section> --}}
          {{-- <section id="product" class="container col-md-8 col-md-offset-2">
            <p>Please review your order below, and provide either your email address or telephone number to receive the payment link.</p>
            <div id="nutritional">
              <table class="table">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price Per</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- ko foreach: sellableItems -->
                    <tr data-bind="visible: quantity() > 0">
                      <td data-bind="text: name"></td>
                      <td data-bind="text: quantity()"></td>
                      <td data-bind="text: '£' + price"></td>
                      <td data-bind="text: '£' + (parseFloat(price) * quantity()).toFixed(2)"></td>
                    </tr>
                  <!-- /ko -->
                  <tr>
                    <td></td>
                    <td></td>
                    <td>Grand Total</td>
                    <td style="font-weight: 900;" data-bind="text: '£' + (parseFloat(totalAmount())).toFixed(2)"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section> --}}
          <h1 class="text-center" style="text-align:center;">Sample Pay By Link Invoice Generator</h1>
          <section id="login" class="container col-md-8 col-md-offset-2" style="margin-top: 20px;">
            <section id="login_form_wrapper" style="margin-top: 0px;">
              <form name="loginForm" novalidate="true" data-bind="submit:sendPaymentLink">
                <div class="input_container flex" data-bind="visible: !successMessage()">
                  <div class="input_wrapper">
                    <label>Company Name</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: customerName" type="text" id="credentials_email" value="" ng-model="credentials.email" name="credentials_email" placeholder="Company Name" required="" class="greggs_input ng-pristine ng-invalid ng-invalid-required ng-touched" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                      <div class="indicator_bar"></div>
                    </div>
                  </div>
                  <div class="input_wrapper">
                    <label>Company Address</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: pickupTime" type="text" id="credentials_phone" value="" ng-model="credentials.password" name="credentials_phone" autocomplete="off" placeholder="Company Address" required="" class="greggs_input ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-pattern" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    </div>
                  </div>
                </div>
                <div class="input_container flex" data-bind="visible: !successMessage()">
                  <div class="input_wrapper">
                    <label>Invoice #</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: reference" type="text" id="credentials_email" value="" ng-model="credentials.email" name="credentials_email" placeholder="Invoice #" required="" class="greggs_input ng-pristine ng-invalid ng-invalid-required ng-touched" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                      <div class="indicator_bar"></div>
                    </div>
                  </div>
                  <div class="input_wrapper">
                    <label>Invoice Amount</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: amount" type="text" id="credentials_phone" value="" ng-model="credentials.password" name="credentials_phone" autocomplete="off" placeholder="Amount" required="" class="greggs_input ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-pattern" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    </div>
                  </div>
                </div>
                <!-- /Disabling Chrome Autofill -->
                <div class="input_container flex" data-bind="visible: !successMessage()">
                  <div class="input_wrapper">
                    <label>Company Email</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: shopperEmail" type="text" id="credentials_email" value="" ng-model="credentials.email" name="credentials_email" placeholder="Email" required="" class="greggs_input ng-pristine ng-invalid ng-invalid-required ng-touched" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                      <div class="indicator_bar"></div>
                    </div>
                  </div>
                  <div class="input_wrapper">
                    <label>Company Phone</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: phoneNumber" type="text" id="credentials_phone" value="" ng-model="credentials.password" name="credentials_phone" autocomplete="off" placeholder="Phone #" required="" class="greggs_input ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-pattern" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    </div>
                  </div>
                </div>
                <div class="flex col-md-12" style="color:green; font-weight: bold; margin-bottom: 15px;">
                  <p>As much data as is required to generate an IP Centrum invoice, with necessary Adyen Pay By Link data passed onto the Adyen endpoint for URL generation</p>
                </div>
                <div class="flex col-md-12" style="color:green; font-weight: bold; margin-bottom: 15px;" data-bind="html: successMessage, visible: successMessage()"></div>
                <div class="flex col-md-12 alert-danger" style="color:red; font-weight: bold;" data-bind="text: errorMessage, visible: errorMessage()"></div>
                <div class="submit_container" data-bind="visible: !successMessage()">
                  <button type="submit" id="login_submit" class="submit_button main_button yellow">Submit Invoice</button>
                </div>
              </form>
            </section>
          </section>
          {{-- <section id="login" class="container col-md-8 col-md-offset-2" style="margin-top: 20px;">
            <section id="login_form_wrapper" style="margin-top: 0px;">
              <form name="loginForm" novalidate="true" data-bind="submit:sendPaymentLink">
                <div class="input_container flex" data-bind="visible: !successMessage()">
                  <div class="input_wrapper">
                    <label>Customer Name</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: customerName" type="text" id="credentials_email" value="" ng-model="credentials.email" name="credentials_email" placeholder="Customer Name" required="" class="greggs_input ng-pristine ng-invalid ng-invalid-required ng-touched" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                      <div class="indicator_bar"></div>
                    </div>
                  </div>
                  <div class="input_wrapper">
                    <label>Pickup Time</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: pickupTime" type="text" id="credentials_phone" value="" ng-model="credentials.password" name="credentials_phone" autocomplete="off" placeholder="Pickup Time" required="" class="greggs_input ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-pattern" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    </div>
                  </div>
                </div>
                <div class="input_container flex" data-bind="visible: !successMessage()">
                  <div class="input_wrapper">
                    <label>Order #</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: reference" type="text" id="credentials_email" value="" ng-model="credentials.email" name="credentials_email" placeholder="Order #" required="" class="greggs_input ng-pristine ng-invalid ng-invalid-required ng-touched" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                      <div class="indicator_bar"></div>
                    </div>
                  </div>
                  <div class="input_wrapper">
                    <label>Amount</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: amount" type="text" id="credentials_phone" value="" ng-model="credentials.password" name="credentials_phone" autocomplete="off" placeholder="Amount" required="" class="greggs_input ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-pattern" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    </div>
                  </div>
                </div>
                <!-- /Disabling Chrome Autofill -->
                <div class="input_container flex" data-bind="visible: !successMessage()">
                  <div class="input_wrapper">
                    <label>Email</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: shopperEmail" type="text" id="credentials_email" value="" ng-model="credentials.email" name="credentials_email" placeholder="Email" required="" class="greggs_input ng-pristine ng-invalid ng-invalid-required ng-touched" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                      <div class="indicator_bar"></div>
                    </div>
                  </div>
                  <div class="input_wrapper">
                    <label>Phone</label>
                    <div class="input-holder" input-animation="">
                      <input data-bind="value: phoneNumber" type="text" id="credentials_phone" value="" ng-model="credentials.password" name="credentials_phone" autocomplete="off" placeholder="Phone #" required="" class="greggs_input ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-pattern" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAkCAYAAADo6zjiAAAAAXNSR0IArs4c6QAAAbNJREFUWAntV8FqwkAQnaymUkpChB7tKSfxWCie/Yb+gbdeCqGf0YsQ+hU95QNyDoWCF/HkqdeiIaEUqyZ1ArvodrOHxanQOiCzO28y781skKwFW3scPV1/febP69XqarNeNTB2KGs07U3Ttt/Ozp3bh/u7V7muheQf6ftLUWyYDB5yz1ijuPAub2QRDDunJsdGkAO55KYYjl0OUu1VXOzQZ64Tr+IiPXedGI79bQHdbheCIAD0dUY6gV6vB67rAvo6IxVgWVbFy71KBKkAFaEc2xPQarXA931ot9tyHphiPwpJgSbfe54Hw+EQHMfZ/msVEEURjMfjCjbFeG2dFxPo9/sVOSYzxmAwGIjnTDFRQLMQAjQ5pJAQkCQJ5HlekeERxHEsiE0xUUCzEO9AmqYQhiF0Oh2Yz+ewWCzEY6aYKKBZCAGYs1wuYTabKdNNMWWxnaA4gp3Yry5JBZRlWTXDvaozUgGTyQSyLAP0dbb3DtQlmcan0yngT2ekE9ARc+z4AvC7nauh9iouhpcGamJeX8XF8MaClwaeROWRA7nk+tUnyzGvZrKg0/40gdME/t8EvgG0/NOS6v9NHQAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    </div>
                  </div>
                </div>
                <div class="flex col-md-12" style="color:green; font-weight: bold; margin-bottom: 15px;" data-bind="html: successMessage, visible: successMessage()"></div>
                <div class="flex col-md-12 alert-danger" style="color:red; font-weight: bold;" data-bind="text: errorMessage, visible: errorMessage()"></div>
                <div class="submit_container" data-bind="visible: !successMessage()">
                  <button type="submit" id="login_submit" class="submit_button main_button yellow">Submit Order</button>
                </div>
              </form>
            </section>
          </section> --}}
        </section>
      </section>
      {{-- <footer>
        <div class="container">
          <div id="logo_container">
            <img src="https://www.greggs.co.uk/res/img/logo.png" alt="Greggs Logo" title="Greggs Logo">
          </div>
          <div id="footer_wrapper">
            <div id="foot_about" class="left">
              <h3><a href="https://www.greggs.co.uk/about" alt="Greggs About Us" title="Greggs About Us" track-event="" event="event" category="Footer" action="click" label="About">About Us</a></h3>
              <div id="extra">
                <p>Want to know more about Greggs? You can discover our 75 year history, find out what it's like to be part of the Greggs Family, read about our community work, check out the latest Greggs news and get your questions answered.</p>
              </div>
            </div>
            <div id="foot_contact" class="right">
              <h3><a href="https://www.greggs.co.uk/contact" title="Contact Us" track-event="" event="event" category="Footer" action="click" label="Contact Us">Contact Us</a></h3>
              <address>
                Greggs plc<br>
                Greggs House<br>
                Quorum Business Park, Newcastle upon Tyne<br>
                NE12 8BU
              </address>
            </div>
          </div>
          <div id="foot_terms">
            <nav class="flex">
              <a href="privacy-policy" title="Privacy Policy" track-event="" event="event" category="Footer" action="click" label="Privacy Policy">Privacy Policy</a>
              <a href="cookie-policy" title="Cookie Policy" track-event="" event="event" category="Footer" action="click" label="Cookie Policy">Cookie Policy</a>
              <a href="https://greggs-prod-cms.s3.eu-west-2.amazonaws.com/Modern+Slavery+Statement+2018+(Signed)+dated+28.03.2019.pdf" target="_blank" title="Modern Slavery Statement" track-event="" event="event" category="Footer" action="click" label="Modern Slavery Statement">Modern Slavery Statement</a>
              <a href="https://corporate.greggs.co.uk/sites/default/files/Greggs_Gender_Pay_Gap_Report_January_2018.pdf" target="_blank" title="Gender Pay Gap" track-event="" event="event" category="Footer" action="click" label="Gender Pay Gap">Gender Pay Gap</a>
              <a href="terms-conditions" title="Terms &amp; Conditions" track-event="" event="event" category="Footer" action="click" label="Terms &amp; Conditions">T&amp;C's</a>
              <a href="site-map" title="Site Map" track-event="" event="event" category="Footer" action="click" label="Site Map">Site Map</a>
            </nav>
            <h5 class="ng-binding">Copyright © 2013 - 2020 Greggs plc</h5>
            <small>This website uses cookies for web analytics. The data is anonymous, only used for statistical analysis and does not operate outside this website. By using this site you are consenting to the use of these cookies.</small>
          </div>
          <div id="foot_social" class="flex flex-h-center">
            <a href="https://www.facebook.com/greggsofficial" target="_blank" title="Greggs Facebook Link" track-event="" event="event" category="Footer" action="click" label="Facebook Account"><i class="fa fa-facebook"></i></a>
            <a href="https://twitter.com/greggsofficial" target="_blank" title="Greggs Twitter Link" track-event="" event="event" category="Footer" action="click" label="Twitter Account"><i class="fa fa-twitter"></i></a>
            <a href="https://instagram.com/greggs_official/" target="_blank" title="Greggs Instagram Link" track-event="" event="event" category="Footer" action="click" label="Instagram Account"><i class="fa fa-instagram"></i></a>
            <a href="https://www.youtube.com/user/GreggsFreshBaking" target="_blank" title="Greggs Youtube Link" track-event="" event="event" category="Footer" action="click" label="Youtube Account"><i class="fa fa-youtube-play"></i></a>
          </div>
        </div>
      </footer> --}}
    </main>
    <div id="shadow_blocker"></div>
    <!--<script src="https://www.greggs.co.uk/res/js/greggs.min.js"></script>-->
    <!-- <script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit" async defer></script> -->
    <script async="" type="text/javascript" src="https://www.greggs.co.uk/_Incapsula_Resource?SWJIYLWA=719d34d31c8e3a6e6fffd425f7e032f3&amp;ns=1&amp;cb=1631109170"></script>
    <iframe height="0" width="0" style="display: none; visibility: hidden;" src="https://www.greggs.co.uk//1697160.fls.doubleclick.net/activityi;src=1697160;type=conte749;cat=000un0;ord=1838265232339;gtm=2wg4m0;auiddc=924628239.1588328857;u3=https%3A%2F%2Fwww.greggs.co.uk%2F;u5=Desktop;~oref=https%3A%2F%2Fwww.greggs.co.uk%2F?"></iframe>
    <div id="ngProgress-container" class="ng-scope">
      <div id="ngProgress" style="height: 2px; background-color: firebrick; color: firebrick; width: 0%; opacity: 1;"></div>
    </div>
    <script type="text/javascript" id="" src="https://secure.adnxs.com/px?id=1168649&amp;seg=19410407&amp;t=1"></script>
    <script type="text/javascript" id="" src="https://secure.adnxs.com/px?id=1168867&amp;t=1"></script>
    <noscript><img height="1" width="1" src="https://www.facebook.com/tr?id=168209450773905&amp;ev=PageView&amp;noscript=1">
    </noscript>
    <iframe scrolling="no" frameborder="0" allowtransparency="true" src="https://platform.twitter.com/widgets/widget_iframe.c63890edc4243ee77048d507b181eeec.html?origin=https%3A%2F%2Fwww.greggs.co.uk" title="Twitter settings iframe" style="display: none;"></iframe>
    <script src="https://analytics.twitter.com/i/adsct?p_id=Twitter&amp;p_user_id=0&amp;txn_id=o0yww&amp;events=%5B%5B%22pageview%22%2Cnull%5D%5D&amp;tw_sale_amount=0&amp;tw_order_quantity=0&amp;tw_iframe_status=0&amp;tpx_cb=twttr.conversion.loadPixels&amp;tw_document_href=https%3A%2F%2Fwww.greggs.co.uk%2F" type="text/javascript"></script>
    <!-- ADYEN -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
    <script src="/js/knockout/greggs.js"></script>
  </body>
</html>

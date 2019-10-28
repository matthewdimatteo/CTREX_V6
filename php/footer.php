<!--
php/footer.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the site footer as well as a bottom navigation bar for mobile devices
It is included in the file 'php/document.php' to display on all pages
-->
<div id = "bottom-nav-container">
	
	<!-- BOTTOM NAVIGATION FOR TABLET PORTRAIT AND MOBILE -->
	<div id = "bottom-nav">
		
		<!-- FILTERS -->
		<?php
		$bottomNavItemClassFilters 	= 'bottom-nav-item';
		$bottomNavItemImgFilters	= 'images/bottom-nav-filters';
		if($thisPage == 'filters.php')
		{ 
			$bottomNavItemClassFilters 	.= '-active'; 
			$bottomNavItemImgFilters	.= '-active';
		} // end if $thisPage == 'filters.php'
		if($searchType != 'publishers') { $filtersLabel = 'Filters'; } else { $filtersLabel = 'Resources'; }
		?>
		<a href = "filters.php">
		<div class = "<?php echo $bottomNavItemClassFilters;?>">
			<div class = "bottom-nav-item-image"><img src = "<?php echo $bottomNavItemImgFilters;?>.png" /></div>
			<div class = "bottom-nav-item-label"><?php echo $filtersLabel;?></div>
		</div>
		</a>
		
		<!-- SEARCH -->
		<?php
		$bottomNavItemClassSearch 	= 'bottom-nav-item';
		$bottomNavItemImgSearch		= 'images/bottom-nav-search';
		if($pageType == 'search')
		{ 
			$bottomNavItemClassSearch 	.= '-active';
			$bottomNavItemImgSearch		.= '-active';
		}
		?>
		<a href = "<?php echo $lastSearch;?>">
		<div class = "<?php echo $bottomNavItemClassSearch;?>">
			<div class = "bottom-nav-item-image"><img src = "<?php echo $bottomNavItemImgSearch;?>.png" /></div>
			<div class = "bottom-nav-item-label">Search</div>
		</div>
		</a>
		
		<!-- PROFILE -->
		<?php
		$bottomNavItemClassProfile 	= 'bottom-nav-item';
		$bottomNavItemImgProfile	= 'images/bottom-nav-profile';
		if($pageType == 'profile' or $thisPage == 'login.php') 	
		{ 
			$bottomNavItemClassProfile 	.= '-active';
			$bottomNavItemImgProfile	.= '-active';
		}
		if($login != true) 			{ $bottomNavProfileLink = 'login.php'; 				$bottomNavProfileLabel = 'Log In'; }
		else if($freeMode == true)	{ $bottomNavProfileLink = 'redirect-login.php'; 	$bottomNavProfileLabel = 'Subscriber Login'; }
		else 						{ $bottomNavProfileLink = $profileURL;				$bottomNavProfileLabel = 'Profile'; }
		?>
		<a href = "<?php echo $bottomNavProfileLink;?>">
		<div class = "<?php echo $bottomNavItemClassProfile;?>">
			<div class = "bottom-nav-item-image"><img src = "<?php echo $bottomNavItemImgProfile;?>.png" /></div>
			<div class = "bottom-nav-item-label"><?php echo $bottomNavProfileLabel;?></div>
		</div>
		</a>
		
		<!-- MORE OPTIONS -->
		<?php
		$bottomNavItemClassMore = 'bottom-nav-item';
		$bottomNavItemImgMore	= 'images/bottom-nav-more';
		if($thisPage == 'options.php')
		{ 
			$bottomNavItemClassMore .= '-active';
			$bottomNavItemImgMore	.= '-active';
		}
		?>
		<a href = "options.php">
		<div class = "<?php echo $bottomNavItemClassMore;?>">
			<div class = "bottom-nav-item-image"><img src = "<?php echo $bottomNavItemImgMore;?>.png" /></div>
			<div class = "bottom-nav-item-label">More</div>
		</div>
		</a>
		
	</div><!-- /#bottom-nav -->
	
	<!-- FOOTER (copyright) -->
	<footer>
		&copy; <?php echo $year;?> <a href = "about.php">Children's Technology Review</a>. <div class = "inline"><div class = "show-769-and-above">Version 6.0 (Beta).</div></div> All rights reserved. <a href = "disclaimer.php">Disclaimer</a>
	</footer>
</div><!-- /#bottom-nav-container -->
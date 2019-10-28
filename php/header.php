<?php
/*
php/header.php
By Matthew DiMatteo, Children's Technology Review

php/header.php
By Matthew DiMatteo, Children's Technology Review

This file contains the header to be included on each page within CTREX
It is divided into a top row, containing the logo, a back button, and a login form, and a bottom row, containing the main searchbar

Separate files 'php/powersearch.php' and 'php/messages.php' contain the output for the powersearch menu and subheader messages, respectively

The header element itself is set to be fixed at the top of the screen in 'css/main.css'
The content is offset by the div element #header-offset, below
A jQuery function bufferContent() in 'js/scripts.js' calculates the height of the header once its contents (including images) have loaded 
and sets the height of #header-offset accordingly

*/
require_once 'php/header-format.php'; // set variables
?>

<header id = "ctrex-header">
	<div id = "header-top">
	
		<!-- BACK BUTTON -->
		<div class = "header-col" id = "back-btn-container">
			<div <?php if($thisPage == 'home.php') { echo 'class = "hide" '; } ?> >
				<a href = "<?php echo $backBtnLink;?>"><?php echo $backBtnLabel;?></a>
			</div>
			<!-- MOBILE FILTERS LINK FOR HOME PAGE -->
			<div class = "<?php if($thisPage == 'home.php') { echo 'show-769-and-below'; } else { echo 'hide '; } ?>">
				<a href = "filters.php">< Filters</a>
			</div>
		</div><!-- /#back-btn-container -->
		
		<!-- LOGIN BUTTON -->
		<div class = "header-col" id = "login-btn-container">
			<?php
			if($profile == true)
			{
				/*
				// PROFILE LINK WITH USERNAME LABEL FOR SCREENS 1025+
				echo '<div class = "show-1025-and-above">';
					echo '<a href = "'.$profileURL.'">'.$usernameLabel.'</a><br/>';
				echo '</div>'; // /.show-1025-and-above

				// PROFILE LINK WITH GENERIC LABEL FOR SCREENS 769-
				echo '<div class = "show-769-and-below">';
					echo '<a href = "'.$profileURL.'">Profile</a><br/>';
				echo '</div>'; // /.show-769-and-below

				// LOGOUT LINK
				echo '<a href = "logout.php">Log Out</a>';
				*/
				// PROFILE MENU BTN CONTAINER -->
				echo '<div id = "profile-menu-btn-container" class = "pointer">';
					
					// SHOW BTN
					echo '<div id = "profile-menu-show" class = "block" title = "Show profile options">';
						echo '<div id = "profile-menu-label-show" onclick = "showItem(\'profile-menu-show\', \'profile-menu-hide\', \'profile-menu-container\')">Profile</div>';
					echo '</div>'; // /#profile-menu-show

					// HIDE BTN
					echo '<div id = "profile-menu-hide" class = "hide" title = "Hide profile options">';
						echo '<div id = "profile-menu-label-hide" onclick = "hideItem(\'profile-menu-show\', \'profile-menu-hide\', \'profile-menu-container\')">Profile</div>';
					echo '</div>'; // /#profile-menu-hide
					
				echo '</div>'; // /#profile-menu-btn-container
				
			}
			else if($profile != true and $login == true)
			{
				echo '<a href = "logout.php">Log Out</a>';
			}
			/*
			hide the header login form if logged in or on login page
			continue to output the elements with ids - needed for document.onclick event handling
			*/
			if($login == true or $thisPage == 'login.php')	{ $loginFormClass = 'hide'; }
			//if($thisPage == 'login.php') 					{ echo '<div class = "show-only-480"><div class = "header-col"></div></div>'; }
			
			echo '<div class = "'.$loginFormClass.'">';
			
				// show js toggle btn on 1025 and above
				echo '<div class = "show-1025-and-above">';
					echo '<div id = "login-menu-show" onclick = "showLogin()" title = "'.$loginHoverText.'">Log In</div>';
					echo '<div id = "login-menu-hide" onclick = "hideLogin()">Log In</div>';
				echo '</div>'; // /.show-1025-and-above
				
				// show link to login page on 769 and below
				echo '<div class = "show-769-and-below" id = "mobile-login-link">';
					echo '<div onclick = "openURL(\'login.php\')">Log In</div>';
					
				echo '</div>'; // /.show-769-and-below
				
			echo '</div>'; // //$loginFormClass
			
			// 10px TOP MARGIN FOR SUBSCRIBE LINK ON LOGIN PAGE FOR 480
			if($thisPage == 'login.php') { echo '<div class = "show-only-480"><div class = "top-10"></div></div>'; }
			
			// SUBSCRIBE LINK
			if($login != true) { echo '<div><a href = "subscribe.php" title = "'.$subscribeHoverText.'">Subscribe</a></div>'; }
			?>
		</div><!-- /#login-btn-container -->
		
		<!-- LOGIN MENU -->
		<div id = "login-menu-container">
			<div id = "login-menu"><?php if($thisPage != 'login.php') { require_once 'php/login-form.php'; } ?></div>
		</div><!-- /#login-menu-container -->

		<!-- LOGO -->
		<div id = "logo-container">

			<!-- LOGO HOME LINK -->
			<a id = "logo-home-link" href = "home.php" onMouseOver="swapItem('logo-hover', 'logo-idle')" onMouseOut="swapItem('logo-idle', 'logo-hover')" title = "Return home">
			<div id = "home-btn">

				<!-- LOGO IDLE -->
				<div id = "logo-idle">
					<?php
					if($logoType == 'Image') 
					{ 
						if($logoImg != NULL)	{ echo '<img src = "php/img.php?-url='.urlencode($logoImg).'" alt = "CTREX">'; }
						else					{ echo '<img src = "images/ctrex-6-logo-idle.png" alt = "CTREX">'; }
					}
					else 
					{ 
						echo '<div class = "logo-text">'.$logoText.'</div>';
						//echo '<div class = "logo-text-480">CTREX</div>'; 
					}
					?>
				</div><!-- /#logo-idle -->

				<!-- LOGO HOVER -->
				<div id = "logo-hover">
					<?php
					if($logoType == 'Image') 
					{ 
						if($logoImgHover != NULL)	{ echo '<img src = "php/img.php?-url='.urlencode($logoImgHover).'" alt = "CTREX">'; }
						else						{ echo '<img src = "images/ctrex-6-logo-hover.png" "CTREX">'; }
					}
					else 
					{ 
						echo '<div class = "logo-text">'.$logoText.'</div>'; 
						//echo '<div class = "logo-text-480">CTREX</div>'; 
					}
					?>
				</div><!-- /#logo-hover -->

			</div><!-- /#home-btn -->
			</a><!-- /logo-home-link -->

		</div><!-- /#logo-container -->
	
	</div><!-- /#header-top -->
	
	<!-- TAGLINE -->
	<div class = "logo-subheader" id = "tagline"><?php echo $tagline;?></div>
	
	<!-- BOTTOM ROW -->
	<div id = "header-bottom">
	
		<!-- MENU ICON CONTAINER -->
		<div class = "header-col" id = "menu-icon-container">
			<div>
				<div id = "menu-show" class = "block" title = "Open the menu">
					<img src = "images/menu.png" id = "menu-img-show" onclick = "showItem('menu-show', 'menu-hide', 'menu-container')" />
				</div>
                <div id = "menu-hide" class = "hide" title = "Close the menu">
					<img src = "images/menu.png" id = "menu-img-hide" onclick = "showItem('menu-show', 'menu-hide', 'menu-container')" />
				</div>
			</div>
		</div><!-- /#menu-icon-container -->
		
		<!-- POWERSEARCH ICON CONTAINER OFFSET -->
		<div class = "searchbar-margin" id = "powersearch-icon-container-offset"></div>

		<!-- SEARCHBAR INPUT -->
		<div id = "searchbar-container">
			<input type = "search" name = "keyword" id = "input-keyword" value = "<?php echo $keywordValue;?>" placeholder = "Search..." />
		</div>

		<!-- SHOW/HIDE POWERSEARCH BUTTON -->
		<div class = "searchbar-margin" id = "powersearch-icon-container">
			<?php 
			if($searchType == 'reviews' or $searchType == 'experts')
			{
				echo '<img id = "powersearch-show" src = "images/icon-expand-white.png" 	onclick = "powersearchShow()" title = "Additional search options: look up products by age range, platform, and subject matter, as well as custom lists for various topics"/>';
				echo '<img id = "powersearch-hide" src = "images/icon-collapse-white.png" 	onclick = "powersearchHide()" title = "Hide additional search options"/>';
			}
			?>
		</div><!-- /.searchbar-margin #powersearch-toggle-container -->
		
		<!-- MENU ICON CONTAINER OFFSET -->
		<div class = "header-col" id = "menu-icon-container-offset"></div>
		
	</div><!-- /#header-bottom -->
	
	<!-- POWERSEARCH -->
	<div id = "powersearch" class = "powersearch">
		<?php if($searchType == 'reviews' or $searchType == 'experts') { require_once 'php/powersearch.php'; } ?>
	</div><!-- /#powersearch -->
	
</header><!-- /#ctrex-header -->

<!-- OFFSET BETWEEN HEADER AND CONTENT -->
<div id = "header-offset"></div>

<!-- MENU -->
<?php require_once 'php/menu.php'; ?>

<!-- DASHBOARD MESSAGES -->
<div id = "message-area"><?php require_once 'php/messages.php';?></div><!-- /#message-area -->

<!-- OUTPUT FOR TARGET OF JS ONCLICK EVENT (MAKE TOGGLEABLE LOGIN MENU HIDE WHEN CLICKING OUTSIDE OF IT) -->
<div id = "target-output" class = "hide"></div><!-- /#target-output -->

<!-- debug div for width output from script outputWidth() in 'js/scripts.js'-->
<div id = "width-output"></div>

<?php
// debug output
//echo 'Guest Access: '.$guestAccess.'<br/>';

// show powersearch for 'quickfind searches' - this override handles WP redirect template links such as 'childrenstech.com/family'
if($quickfind != NULL) { echo '<script>powersearchShow();</script>'; } // js function defined in 'js/scripts.js'
?>
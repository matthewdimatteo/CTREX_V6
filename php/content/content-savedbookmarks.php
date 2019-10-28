<?php
/*
php/content/content-savedbookmarks.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the bookmarks page 'savedbookmarks.php'
*/

// only allow subscribers to access this page (subscriber $userID required to lookup bookmarks)
if($subscriber != true) 	{ $redirect = 'home.php'; require_once 'php/redirect.php'; exit(); } 

// ADD USERNAME TO PAGE TITLE
if($username != NULL)
{
	if($pageTitle == NULL) { $pageTitle = 'CTREX Profile'; }
	$pageTitle .= ' - '.$username;
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';
} // end if $username

// only lookup bookmarks if there are any
if($numSavedBookmarks > 0) 	{ require_once 'php/find-bookmarks.php'; } //else { require_once 'php/redirect.php'; exit(); }
require_once 'php/save-item-forms.php'; // forms for managing bookmarks
$numFolderContainers = $numBookmarkFolders + 1; // value used for num argument in selectItem(n, count) function (add 1 for uncategorized)

?>

<!-- PAGE CONTAINER -->
<div id = "savedbookmarks-page-container">

	<!-- SIDEBAR -->
	<div class = "sidebar">
	
		<!-- PRINT/EXPORT OPTIONS -->
		<div class = "sidebar-section">
			<?php require_once 'php/bookmark-options.php'; // print/export btns ?>
		</div><!-- /.sidebar-section -->
		
		<!-- NEW FOLDER FORM -->
		<div class = "sidebar-section new-bookmark-folder-form" id = "new-bookmark-folder-form-main">
			<div class = "inline">
				<input type = "text" 	name = "new-folder-name" id = "new-folder-name" placeholder = "New folder..."/>
			</div><!-- /.inline -->
			<div class = "inline left-10">
				<button type = "button" onclick = "bookmarkFolderAdd('main')">+</button>
			</div><!-- /.inline left-10 -->
		</div><!-- /.sidebar-section new-bookmark-folder-form #new-bookmark-folder-form-main -->
		
		<!-- UNCATEGORIZED -->
		<div class = "sidebar-section">
		
			<!-- UNCATEGORIZED SECTION HEADING -->
			<div class = "sidebar-section-heading">
				View uncategorized bookmarks:
			</div><!-- -/.sidebar-section-heading -->
			
			<!-- UNCATEGORIZED SECTION ITEMS -->
			<div class = "sidebar-section-items">
				<div class = "sidebar-section-item">
				
					<!-- SHOW UNCATEGORIZED BTN -->
					<div class = "hide" id = "btn-0">
						<div class = "sidebar-item-button" onclick = "showBookmarksFolder('0', '<?php echo $numFolderContainers;?>')">
							<div class = "sidebar-item-button-text">Uncategorized</div>
							<div class = "sidebar-item-button-icon">&#62;</div>
						</div><!-- /.sidebar-item-button -->
					</div><!-- /.show #btn-0 -->
					
					<!-- UNCATEGORIZED LABEL -->
					<div class = "show" id = "label-0">
						<div class = "sidebar-item-label">
							<div class = "sidebar-item-button-text">Uncategorized</div>
							<div class = "sidebar-item-button-icon">&#62;</div>
						</div><!-- /.sidebar-item-label -->
					</div><!-- /.hide #label-0 -->
					
				</div><!-- /.sidebar-section-item -->
			</div><!-- /.sidebar-section-items -->
			
		</div><!-- /.sidebar-section -->
		
		<!-- FOLDERS -->
		<?php if($numBookmarkFolders > 0) { $bookmarkFoldersClass = 'show'; } else { $bookmarkFoldersClass = 'hide'; } ?>
		<div class = "<?php echo $bookmarkFoldersClass;?>">
			<div class = "sidebar-section">
				<div class = "sidebar-section-heading">View bookmarks by folder:</div>
				<div class = "sidebar-section-items">
					<?php
					// if there are bookmark folders, output show/hide button pairs for each
					if($numBookmarkFolders > 0)
					{
						$bfn = 0; // declare a counter for each set of show/hide buttons (to allow for unique element ids)
						foreach($bookmarkFolders as $bookmarkFolder)
						{
							// get the array values for record id and folder name
							$bookmarkFolderID 	= $bookmarkFolder[0];
							$bookmarkFolderName = $bookmarkFolder[1];

							$bfn += 1; // increment the counter
							
							// FOLDER $bfn SHOW BTN, LABEL
							echo '<div class = "sidebar-section-item">';

								// SHOW BTN
								echo '<div class = "show" id = "btn-'.$bfn.'">';
									//echo '<div class = "sidebar-item-button" onclick = "selectItem('.$bfn.', '.$numFolderContainers.')">';
									echo '<div class = "sidebar-item-button" onclick = "showBookmarksFolder('.$bfn.', '.$numFolderContainers.')">';
										echo '<div class = "sidebar-item-button-text">'.$bookmarkFolderName.'</div>';
										echo '<div class = "sidebar-item-button-icon">&#62;</div>';
									echo '</div>'; // /sidebar-item-button
								echo '</div>'; // /.show
								
								// LABEL
								echo '<div class = "hide" id = "label-'.$bfn.'">';
									echo '<div class = "sidebar-item-label">';
										echo '<div class = "sidebar-item-button-text">'.$bookmarkFolderName.'</div>';
										echo '<div class = "sidebar-item-button-icon">&#62;</div>';
									echo '</div>'; // /sidebar-item-label
								echo '</div>'; // /.hide

							echo '</div>'; // /.sidebar-section-item
							
						} // end foreach bookmark folder
					} // end if $numBookmarkFolders > 0
					?>
				</div><!-- /.sidebar-section-items -->
			</div><!-- /.sidebar-section -->
		</div><!-- /.$bookmarkFoldersClass (show/hide) -->
		
	</div><!-- /.sidebar -->

	<!-- SEARCH AREA -->
	<div class = "search-area">
		
		<!-- TABLET PORTRAIT/MOBILE FOLDER OPTIONS -->
		<div class = "show-769-and-below">
			<div class = "folder-options-mobile-container">

				<!-- LEFT (FOLDER SELECT FORM) -->
				<div class = "folder-options-mobile-left">
					<?php if($numBookmarkFolders > 0) { $fsmClass = 'show'; } else { $fsmClass = 'hide'; } ?>
					<div id = "folder-select-mobile-container" class = "<?php echo $fsmClass;?>">
						<div id = "show-folder-select-mobile">
							<button type = "button" onclick = "showItem('show-folder-select-mobile', 'hide-folder-select-mobile', 'folder-select-mobile')">
								Select Folder
							</button>
						</div><!-- #show-folder-select-mobile -->
						<div id = "hide-folder-select-mobile" class = "hide">
							<button type = "button" onclick = "hideItem('show-folder-select-mobile', 'hide-folder-select-mobile', 'folder-select-mobile')">
								Select Folder
							</button>
						</div><!-- #hide-folder-select-mobile -->
						<div id = "folder-select-mobile" class = "hide">
							<div class = "menu-line" onclick = "showBookmarksFolder('0', '<?php echo $numFolderContainers;?>')">Uncategorized</div>
							<?php
							if($numBookmarkFolders > 0)
							{
								$bfnm = 0; // declare a counter for each set of show/hide buttons (to allow for unique element ids)
								foreach($bookmarkFolders as $bookmarkFolder)
								{
									// get the array values for record id and folder name
									$bookmarkFolderID 	= $bookmarkFolder[0];
									$bookmarkFolderName = $bookmarkFolder[1];

									$bfnm += 1; // increment the counter

									// FOLDER $bfnm
									echo '<div class = "menu-line" onclick = "showBookmarksFolder('.$bfnm.', '.$numFolderContainers.')">'.$bookmarkFolderName.'</div>';
								} // end foreach
							} // end if $numBookmarkFolders > 0
							?>
						</div><!-- #folder-select-mobile .$fsmClass -->
					</div><!-- /#folder-select-mobile-container -->
				</div><!-- /.folder-options-mobile-left -->

				<!-- CENTER (NEW FOLDER FORM) -->
				<div class = "folder-options-mobile-center">
					<div class = "new-bookmark-folder-form" id = "new-bookmark-folder-form-mobile">
						<div class = "inline">
							<input type = "text" 	name = "new-folder-name" id = "new-folder-name-mobile" placeholder = "New folder..."/>
						</div><!-- /.inline -->
						<div class = "inline left-2">
							<button type = "button" onclick = "bookmarkFolderAdd('mobile')">+</button>
						</div><!-- /.inline left-10 -->
					</div><!-- /.new-bookmark-folder-form #new-bookmark-folder-form-mobile -->
				</div><!-- /.folder-options-mobile-center -->

				<!-- RIGHT (PADDING) -->
				<div class = "folder-options-mobile-right">
				</div><!-- /.folder-options-mobile-right -->

			</div><!-- folder-options-mobile-container -->
		</div><!-- /.show-769-and-below -->
		
		<!-- UNCATEGORIZED BOOKMARKS -->
		<div id = "container-0">
			<div class = "results-heading">Uncategorized Bookmarks</div><!-- /.results-heading -->
			<div>
			<?php
			if($numSavedBookmarks > 0)
			{
				foreach($bookmarkRecords as $item)
				{
					require 'php/get-vars.php';
					if($folderID == NULL) { require 'php/result-item-savedbookmark.php'; }
				} // end foreach
			} // end if $numSavedBookmarks > 0
			else
			{
				echo '<p>You have no bookmarked reviews.</p>';
				echo '<p><a href = "'.$lastSearchReviews.'">Browse Reviews</a></p>';
			}
			?>
			</div>
		</div><!-- /#container-0 -->
		<?php
		if($numBookmarkFolders > 0)
		{
			$bfcn = 0; // declare a counter for toggling each folder container
			foreach($bookmarkFolders as $bookmarkFolder)
			{
				$bfcn += 1; // increment the counter
				$bookmarkFolderID 		= $bookmarkFolder[0];
				$bookmarkFolderName 	= $bookmarkFolder[1];
				$numBookmarksInFolder	= $bookmarkFolder[2];
				echo '<div class = "hide" id = "container-'.$bfcn.'">';
				
					// HEADING - FOLDER NAME, BOOKMARK COUNT, DELETE FOLDER BTN
					echo '<div class = "results-heading">';
					
						// LEFT - FOLDER NAME, BOOKMARK COUNT
						echo '<div class = "bookmarks-folder-heading">';
							echo $bookmarkFolderName.' ('.$numBookmarksInFolder.' bookmark';
							if($numBookmarksInFolder != 1) { echo 's'; } echo ')';
						echo '</div>'; // /.bookmarks-folder-heading
						
						// RIGHT - DELETE FOLDER BTN
						echo '<div class = "delete-folder-container">';
							echo '<button type = "button" onclick = "bookmarkFolderDelete('.$bookmarkFolderID.', '.$numBookmarksInFolder.')">Delete Folder</button>';
						echo '</div>'; // /.delete-folder-container
						
					echo'</div>'; // /.results-heading
					
					// LIST OF BOOKMARKS
					echo '<div class = "bookmarks-list">';
						if($numBookmarksInFolder > 0)
						{
							foreach($bookmarkRecords as $item)
							{
								require 'php/get-vars.php';
								if($folderID == $bookmarkFolderID) { require 'php/result-item-savedbookmark.php'; }
							} // end foreach
						} // end if $bookmarksInFolder > 0
						else { echo '<p>You have no bookmarks in this folder.</p>'; }
					echo '</div>'; // /.bookmarks-list
					
				echo '</div>'; // /.hide #container-$bfcn
			} // end foreach bookmark folder
		} // end if $numBookmarkFolders > 0
		?>
	</div><!-- /.search-area -->

</div><!-- /#savedbookmarks-page-container -->
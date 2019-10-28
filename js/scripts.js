/*
js/scripts.js
By Matthew DiMatteo, Children's Technology Review

This file contains the JavaScript functions utilized throughout CTREX. 
Order is as follows:

General use:
- open URL
- toggle display of items
- store a value in session storage

Header:
- adjust content margin based on header height
- hide login menu on clickaway
- check the 'login as publisher box' by clicking on label

Search:
- submit the search form
- submit keyword via enter key
- powersearch actions
- sort, filter, and clear a search

Review:
- toggle image gallery, load zoom

Profile:
- toggle/load section display
- update profile

*/

// GENERAL USE -------------------------------------------------------------------------------------------

function testAlert()
{
	alert("test");
}

// OPEN URL
function openURL(url)
{
	window.location.href = url;
}
// OPEN URL IN NEW WINDOW
function openBlank(url)
{
	window.open(url, '_blank');
}

function submitForm(id)
{
	document.getElementById(id).submit();
}

// PRINT
function printPage()
{
	window.print();
}

function setPageTitle(title)
{
	//alert("setPageTitle() triggered" + "\n" + "title: " + title);
	if(title) { document.title = title; }
}

// HIGHLIGHT
function highlight(id)
{
	document.getElementById(id).select();
}

// SWAP ITEM
function swapItem(show, hide)
{
	document.getElementById(show).style.display = "block";
	document.getElementById(hide).style.display = "none";
}
// SWAP ITEMS WITH BUTTON/LABEL COUNTERPARTS
function swapItems(show, hide)
{
	var showBtn 	= show + "-btn";
	var showLabel 	= show + "-label";
	var showElem	= show + "-container";
	var hideBtn 	= hide + "-btn";
	var hideLabel 	= hide + "-label";
	var hideElem	= hide + "-container"
	document.getElementById(showBtn).style.display = "none";
	document.getElementById(showLabel).style.display = "block";
	document.getElementById(showElem).style.display = "block";
	document.getElementById(hideBtn).style.display = "block";
	document.getElementById(hideLabel).style.display = "none";
	document.getElementById(hideElem).style.display = "none";
}

// SELECT 1 OF N ITEMS (WITH BUTTONS AND LABELS)
// used in 'php/content/content-submit.php' and 'php/content/content-savedbookmarks.php'
function selectItem(n, num)
{
	// this function assumes a numeric naming convention for element ids - buttons: btn-n, labels: label-n, containers: container-n
	//alert("selectItem() triggered" + "\n" + "n = " + n + "\n" + "num = " + num);
	// declare variables to be updated in for loop
	var btnID;
	var labelID;
	var elemID;
	var btn;
	var label;
	var elem;
	
	// first hide all the containers and labels, show the buttons
	for(var i = -1; i < num+1; i++)
	{
		
		// calculate the element ids according to the assumed naming convention
		btnID	= "btn-" + i;
		labelID = "label-" + i;
		elemID	= "container-" + i;
		//alert("i = " + i + "\n" + "index = " + index + "\n" + "btnID = " + btnID + "\n" + "labelID = " + labelID + "\n" + "elemID = " + elemID);
		
		// check whether the element exists
		btn 	= document.getElementById(btnID);
		label 	= document.getElementById(labelID);
		elem 	= document.getElementById(elemID);
		
		// hide all of the labels and containers, show all of the btns
		if(btn) 	{ document.getElementById(btnID).style.display 		= "block"; }
		if(label) 	{ document.getElementById(labelID).style.display 	= "none"; }
		if(elem) 	{ document.getElementById(elemID).style.display 	= "none"; }
	}
	//alert("finished hiding elements");
	// calculate the element ids according to the assumed naming convention
	var showBtnID 		= "btn-" + n;
	var showLabelID 	= "label-" + n;
	var showElemID		= "container-" + n;
	//alert("showBtnID = " + showBtnID + "\n" + "showLabelID = " + showLabelID + "\n" + "showElemID = " + showElemID);
	
	// show the selected container and label, hide the button
	document.getElementById(showBtnID).style.display 	= "none";
	document.getElementById(showLabelID).style.display 	= "block";
	document.getElementById(showElemID).style.display 	= "block";
}
// SHOW / HIDE ITEM (WITH BTN)
function showItem(showBtn, hideBtn, elem)
{
	document.getElementById(showBtn).style.display 	= "none";
	document.getElementById(hideBtn).style.display 	= "block";
	document.getElementById(elem).style.display 	= "block";
}
function hideItem(showBtn, hideBtn, elem)
{
	document.getElementById(showBtn).style.display 	= "block";
	document.getElementById(hideBtn).style.display 	= "none";
	document.getElementById(elem).style.display 	= "none";
}
// SHOW / HIDE Nth ITEM ( WITH BTN)
function showItemN(showBtn, hideBtn, elem, n)
{
	document.getElementById(showBtn + n).style.display 	= "none";
	document.getElementById(hideBtn + n).style.display 	= "block";
	document.getElementById(elem + n).style.display 	= "block";
}
function hideItemN(showBtn, hideBtn, elem, n)
{
	document.getElementById(showBtn + n).style.display 	= "block";
	document.getElementById(hideBtn + n).style.display 	= "none";
	document.getElementById(elem + n).style.display 	= "none";
}
function swapItemN(showBtn, hideBtn, showElem, hideElem, n)
{
	document.getElementById(showBtn + n).style.display 	= "none";
	document.getElementById(hideBtn + n).style.display 	= "block";
	document.getElementById(showElem + n).style.display 	= "block";
	document.getElementById(hideElem + n).style.display 	= "none";
}

// STORE ITEM
function storeItem(item, value)
{
	// save the display state in session storage
	var testKey = 'test';
	var storage = window.sessionStorage;
	try
	{
		storage.setItem(testKey, '1');
		storage.removeItem(testKey);
		sessionStorage.setItem(item, value);
	}
	catch ( error ) { }
}
// CLEAR SESSION STORAGE
function clearSessionStorage()
{
	sessionStorage.clear();
}

// HEADER ------------------------------------------------------------------------------------------------------

// SET TOP MARGIN OF CONTENT DYNAMICALLY BASED ON HEADER HEIGHT
function applyMargin()
{
	$("#main").css('display', "block");			// this is set to display:none in 'css/main.css' - prevents elements from jumping around individually
	var h = $("#ctrex-header").height();
	h -= 9;
	var margin = h + "px";
	$("#header-offset").css('height', margin);
	
	//alert(h);
	//outputWidth();
}
function outputWidth()
{
	var w = window.innerWidth;
	//alert("window.innerWidth = " + w);
	document.getElementById("width-output").innerHTML = "window.innerWidth = " + w;
}

// WAIT FOR ELEMENTS TO LOAD BEFORE APPLYING CONTENT MARGIN
function bufferContent()
{
	setTimeout(applyMargin, 100);
}

// APPLY MARGIN ON DOCUMENT READY AND ON ORIENTATION CHANGE
$(document).ready(bufferContent);
$(window).on('orientationchange', applyMargin);
$(window).resize(applyMargin);

// LOGIN FORM
function showLogin()
{
	showItem("login-menu-show", "login-menu-hide", "login-menu-container");
	//document.getElementById("tagline").style.display = "none";
	//applyMargin();
}
function hideLogin()
{
	hideItem("login-menu-show", "login-menu-hide", "login-menu-container");
	//document.getElementById("tagline").style.display = "block";
	//applyMargin();
}
document.onclick = function(event)
{
	var target = event.target.id;
	document.getElementById("target-output").innerHTML = "Target: " + target;
	
	// LOGIN MENU
	if(target === "login-menu-show") { return showItem("login-menu-show", "login-menu-hide", "login-menu-container"); }
	if
	(
		target !== "login-menu-hide" && 
		target !== "login-form" && 
		target !== "login-input-username" && 
		target !== "login-input-password" &&
		target !== "publisher" &&
		target !== "login-as-publisher-label" &&
		target !== "login-input-submit" &&
		target !== "login-username-row" &&
		target !== "login-password-row" &&
		target !== "login-as-publisher-row" &&
		target !== "login-submit-btn-row"
	)
	{
		//alert("hide login menu");
		hideItem("login-menu-show", "login-menu-hide", "login-menu-container");
	}
	
	// MAIN MENU
	if(target === "menu-img-show")
	{
		//alert("show main menu");
		showItem("menu-show", "menu-hide", "menu-container");
	}
	else
	{
		//alert("hide main menu");
		hideItem("menu-show", "menu-hide", "menu-container");
	}
	
	// PROFILE MENU
	if(target === "profile-menu-label-show") 
	{ 
		//alert("show profile menu");
		showItem("profile-menu-show", "profile-menu-hide", "profile-menu-container");
	}
	else
	{
		//alert("hide profile menu");
		hideItem("profile-menu-show", "profile-menu-hide", "profile-menu-container");
	}
	
};
function loginAsPublisher()
{
	var isChecked 	= document.getElementById("publisher").checked;
	if(isChecked) 	{ document.getElementById("publisher").checked = ""; }
	else 			{ document.getElementById("publisher").checked = true; }
}

function showPromocodeEntry()
{
	window.location.href = "#enter";
	document.getElementById("promocode").focus();
}

// SEARCH --------------------------------------------------------------------------------------------

// MAP THE UI INPUTS TO THE HIDDEN FORM INPUTS AND SUBMIT FORM
function searchReviews()
{
	// get the values from the UI inputs
	var keyword 	= document.getElementById("input-keyword").value;
	var age 		= document.getElementById("powersearch-age").value;
	var platform 	= document.getElementById("powersearch-platform").value;
	var subject 	= document.getElementById("powersearch-subject").value;
	var topic 		= document.getElementById("powersearch-topic").value;
	
	// map the UI input values to the hidden form inputs
	document.getElementById("search-reviews-keyword").value = keyword;
	document.getElementById("search-reviews-age").value = age;
	document.getElementById("search-reviews-platform").value = platform;
	document.getElementById("search-reviews-subject").value = subject;
	document.getElementById("search-reviews-topic").value = topic;
	
	if(age === '' && platform === '' && subject === '' && topic === '') { powersearchHide(); }
	
	document.getElementById("search-reviews-form").submit(); // submit the form
}
function searchPublishers()
{
	// get the values from the UI inputs
	var keyword 	= document.getElementById("input-keyword").value;
	// map the UI input values to the hidden form inputs
	document.getElementById("search-publishers-keyword").value = keyword;
	document.getElementById("search-publishers-form").submit(); // submit the form
}
function searchArchive()
{
	// get the values from the UI inputs
	var keyword 	= document.getElementById("input-keyword").value;
	// map the UI input values to the hidden form inputs
	document.getElementById("search-archive-keyword").value = keyword;
	document.getElementById("search-archive-form").submit(); // submit the form
}

// WAIT FOR DOM TO LOAD - THEN LISTEN FOR ENTER KEY RELEASE FROM KEYWORD FIELD
document.addEventListener('DOMContentLoaded', enterKeySearchReviews, false);
function enterKeySearchReviews()
{
	// ALLOW ENTER KEY FROM KEYWORD INPUT TO SUBMIT SEARCH
	var input = document.getElementById("input-keyword");
	input.addEventListener( "keyup", function(event) { if(event.keyCode === 13) { searchReviews(); } } );
}
document.addEventListener('DOMContentLoaded', enterKeySearchPublishers, false);
function enterKeySearchPublishers()
{
	// ALLOW ENTER KEY FROM KEYWORD INPUT TO SUBMIT SEARCH
	var input = document.getElementById("input-keyword");
	input.addEventListener( "keyup", function(event) { if(event.keyCode === 13) { searchPublishers(); } } );
}
document.addEventListener('DOMContentLoaded', enterKeySearchArchive, false);
function enterKeySearchArchive()
{
	// ALLOW ENTER KEY FROM KEYWORD INPUT TO SUBMIT SEARCH
	var input = document.getElementById("input-keyword");
	input.addEventListener( "keyup", function(event) { if(event.keyCode === 13) { searchArchive(); } } );
}

// WAIT FOR DOM TO LOAD - THEN LISTEN FOR ENTER KEY RELEASE FROM PROMOCODE FIELD
document.addEventListener('DOMContentLoaded', enterKeyEnterPromocode, false);
function enterKeyEnterPromocode()
{
	// ALLOW ENTER KEY FROM KEYWORD INPUT TO SUBMIT SEARCH
	var input = document.getElementById("promocode");
	input.addEventListener( "keyup", function(event) { if(event.keyCode === 13) { enterPromocode(); } } );
}

// TOGGLE POWER SEARCH
function powersearchShow()
{
	var elem = document.getElementById("powersearch");
	if(elem) { showItem("powersearch-show", "powersearch-hide", "powersearch"); }
	applyMargin(); // adjust the content
	storeItem("stored-powersearch", "show"); // save the display state in session storage
}
function powersearchHide()
{
	var elem = document.getElementById("powersearch");
	if(elem) { hideItem("powersearch-show", "powersearch-hide", "powersearch"); }
	applyMargin(); // adjust the content
	storeItem("stored-powersearch", "hide"); // save the display state in session storage
}
function loadPowersearch() // called in 'php/autoload.php'
{
	// show or hide the powersearch on page reloads based on its last display state
	var display = sessionStorage.getItem("stored-powersearch");
	switch(display)
	{
		case "show" : 
		powersearchShow();
		break;
		
		case "hide" : 
		powersearchHide();
		break;
		
		default :
		powersearchHide();
		break;
	}
}

// AND/OR CONTROLS
function powersearchAnd()
{
	// select the proper radio button
	document.getElementById("powersearch-and").checked 	= true;
	document.getElementById("powersearch-or").checked 	= false;
	storeItem("stored-and-or", "and"); // save the state in session storage
}
function powersearchOr()
{
	// select the proper radio button
	document.getElementById("powersearch-and").checked 	= false;
	document.getElementById("powersearch-or").checked 	= true;
	storeItem("stored-and-or", "or"); // save the state in session storage
}
function loadAndOr() // called in 'php/autoload.php'
{
	// select the proper radio button based on its last selection
	var andOr = sessionStorage.getItem("stored-and-or");
	switch(andOr)
	{
		case "and" : 
		powersearchAnd();
		break;
		
		case "or" : 
		powersearchOr();
		break;
		
		default :
		powersearchOr();
		break;
	}
}

/* 
POWER SEARCH A LA CARTE
when a dropdown selection is made, check whether it is an "and" or an "or" search
for "or" searches, clear the other powersearch dropdowns before submitting the form
*/
function powersearch(item) // called in 'php/powersearch.php'
{
	var itemValue 	= document.getElementById("powersearch-" + item).value; // get the value of the selected dropdown item
	var andChecked 	= document.getElementById("powersearch-and").checked;	// check whethere and/or is checked
	var orChecked 	= document.getElementById("powersearch-or").checked;
	if(orChecked)
	{
		powersearchOr();
		// clear all of the select elements for an OR search
		document.getElementById("powersearch-age").value = "";
		document.getElementById("powersearch-platform").value = "";
		document.getElementById("powersearch-subject").value = "";
		document.getElementById("powersearch-topic").value = "";
		document.getElementById("powersearch-" + item).value = itemValue; // re-enter the original value for the selected dropdown
		
		document.getElementById("input-keyword").value = ""; // also clear the keyword field
		//document.getElementById("search-reviews-keyword").value = "";
	}
	else if (andChecked) { powersearchAnd(); }
	searchReviews();
}

// SEARCH OPTIONS - SORT, FILTER
function sortReviews(sort, order) 	// called in 'php/search-options.php'
{
	document.getElementById("search-reviews-sort").value 	= sort;
	document.getElementById("search-reviews-order").value 	= order;
	searchReviews();
}
function sortPublishers(sort, order)// called in 'php/search-options-pub.php'
{
	document.getElementById("search-publishers-sort").value 	= sort;
	document.getElementById("search-publishers-order").value 	= order;
	searchPublishers();
}
function addFilter(filter)			// called in 'php/search-options.php'
{
	var checkboxStatus = document.getElementById(filter).checked;
	var inputID = "search-reviews-filter-" + filter;
	if(checkboxStatus)	{ document.getElementById(inputID).checked = true; }
	else				{ document.getElementById(inputID).checked = false; }
	var inputStatus = document.getElementById(inputID).checked;
}

// SEARCH OPTIONS - MORE
function velvetRope(text, link)
{
	// this function toggles the display of the search options velvet rope popup - it is triggered by each of the buttons under the "More" tab
	if(!text) 	{ text = "Log in as a subscriber to access this feature"; }
	if(!link)	{ link = "login.php?target=more-search-options"; }
	var html = "<a href = \"" + link + "\">" + text + "</a>"; 				// determine the content of the link inside the popup
	document.getElementById("velvet-rope-popup-content").innerHTML = html; 	// set the content of the link inside the popup
	var display = document.getElementById("velvet-rope-popup-container").style.display; // determine the display state
	if(display === "none" || display === null || display === "")
	{
		document.getElementById("velvet-rope-popup-container").style.display = "block"; // show the popup if it is hidden
	}
	else
	{
		document.getElementById("velvet-rope-popup-container").style.display = "none"; // hide the popup if it is shown
	}
}

// SAVED SEARCHES
function savedSearchAdd(url, summary)
{
	document.getElementById("save-search-url").value = url; // add the search url to the hidden form input
	document.getElementById("save-search-summary").value = summary; // add the search criteria summary to the hidden form input
	document.getElementById("save-search-type").value = "add";	// tell 'savesearch.php' to add saved search
	document.getElementById("save-search-form").submit(); // submit the form in 'php/save-item-forms.php' (processed by 'savesearch.php')
}
function savedSearchRemove(id)
{
	var confirmMessage = confirm("Are you sure you want to remove this saved search?");
	if(confirmMessage)
	{
		document.getElementById("save-search-type").value = "remove";	// tell 'savesearch.php' to remove search
		document.getElementById("save-search-id").value = id;			// tell 'savesearch.php' which record to remove
		document.getElementById("save-search-form").submit();			// submit the form in 'php/save-item-forms.php' (processed by 'savesearch.php')
	} // end if confirm
	else { }
}
function savedSearchRename(n)
{
	// calculate input element ids for description, recordID and get their values to set it in the form
	var descriptionInputName 	= "saved-search-description-" + n;
	var idInputName 			= "saved-search-id-" + n;
	var description				= document.getElementById(descriptionInputName).value;
	var id 						= document.getElementById(idInputName).value;
	
	document.getElementById("save-search-type").value = "rename";		// tell 'savesearch.php' to rename search
	document.getElementById("save-search-id").value = id;				// tell 'savesearch.php' which record to rename
	document.getElementById("save-search-summary").value = description; // set the new description value in the form
	document.getElementById("save-search-form").submit();				// submit the form in 'php/save-item-forms.php' (processed by 'savesearch.php')
}

// SAVED BOOKMARKS
function bookmarkAdd(id)
{
	document.getElementById("save-bookmark-type").value = "add";	// tell 'savebookmark.php' to add bookmark
	document.getElementById("save-bookmark-review-id").value = id;	// tell 'savebookmark.php' which review to add
	document.getElementById("save-bookmark-form").submit();			// submit the form in 'php/save-item-forms.php' (processed by 'savebookmark.php')
}
function bookmarkRemove(id)
{
	document.getElementById("save-bookmark-type").value = "remove";	// tell 'savebookmark.php' to remove bookmark
	document.getElementById("save-bookmark-id").value = id;			// tell 'savebookmark.php' which record to remove
	document.getElementById("save-bookmark-form").submit();			// submit the form in 'php/save-item-forms.php' (processed by 'savebookmark.php')
}
function bookmarkDeleteAll()
{
	var confirmMessage = confirm("Are you sure you want to delete ALL of your bookmarks?");
	if(confirmMessage)
	{
		document.getElementById("save-bookmark-type").value = "deleteAll";// tell 'savebookmark.php' to delete all bookmarks
		document.getElementById("save-bookmark-form").submit();			// submit the form in 'php/save-item-forms.php' (processed by 'savebookmark.php')
	} // end if confirm
	else { }
}
function moveBookmark(id)
{
	var selectID = "select-bookmark-" + id; // calculate the element id for the select input
	//alert("selectID: " + selectID);
	if(selectID) { folderID = document.getElementById(selectID).value; } 	// get the value of the select input to determine folder id
	//alert("folderID: " + folderID);
	document.getElementById("save-bookmark-type").value = "move";			// tell 'savebookmark.php' to move bookmark to folder
	document.getElementById("save-bookmark-id").value = id;					// tell 'savebookmark.php' which savedbookmark record to lookup
	document.getElementById("save-bookmark-folder-id").value = folderID;	// tell 'savebookmark.php' which folder to move bookmark to
	document.getElementById("save-bookmark-form").submit();					// submit the form in 'php/save-item-forms.php' (processed by 'savebookmark.php')
}
function bookmarkVelvet(id)
{
	// this function is triggered by the bookmark icon in the review item heading - it toggles the display of the velvet rope popup
	var display = document.getElementById(id).style.display;
	if(display === "none" || display === null || display === "")
	{ 
		document.getElementById(id).style.display = "block"; // show the popup if it is hidden
	}
	else
	{
		document.getElementById(id).style.display = "none"; // hide the popup if it is shown
	}
}

// BOOKMARK FOLDERS
function bookmarkFolderAdd(loc)
{
	var inputID = "new-folder-name";
	if(loc === "mobile") { inputID += "-mobile"; } // allow for trigger from main form in sidebar and mobile form in search area
	var newFolderName = document.getElementById(inputID).value; 				// get the name from the value of the new folder name input
	document.getElementById("save-folder-name").value = newFolderName;			// set the hidden input in the save-folder-form with the name value
	document.getElementById("save-folder-type").value = "folder-add";			// tell 'savebookmark.php' to add folder
	if(newFolderName) { document.getElementById("save-folder-form").submit(); }	// submit the form in 'php/save-item-forms.php' (processed by 'savebookmark.php')
}
function bookmarkFolderDeleteAction(id)
{
	document.getElementById("save-folder-id").value = id;				// set the hidden input in the save-folder-form with the folder id value
	document.getElementById("save-folder-type").value = "delete";		// tell 'savebookmark.php' to delete folder and its contained bookmarks
	document.getElementById("save-folder-form").submit();				// submit the form in 'php/save-item-forms.php' (processed by 'savebookmark.php')
}
function bookmarkFolderDelete(id, num)
{
	// if the folder is not empty, display confirm message indicating that action will delete contained bookmarks
	if(num > 0)
	{
		var confirmMessage = confirm("This action will delete all bookmarks in this folder. Proceed?");
		if(confirmMessage){ bookmarkFolderDeleteAction(id); } // end if confirm
		else { }
	} // end if num > = 0
	else { bookmarkFolderDeleteAction(id); }
} // end bookmarkFolderDelete(id, num)

// SAVED RUBRICS
function savedRubricUpdate(n)
{
	//alert("triggered");
	// calculate input element ids for description, recordID and get their values to set it in the form
	var nameInputName 			= "saved-rubric-name-" + n;
	var qaNamesInputName 		= "saved-rubric-qa-names-" + n;
	var qaFieldsInputName 		= "saved-rubric-qa-fields-" + n;
	var descriptionInputName 	= "saved-rubric-description-" + n;
	var idInputName 			= "saved-rubric-id-" + n;
	var name					= document.getElementById(nameInputName).value;
	var qaNames					= document.getElementById(qaNamesInputName).value;
	var qaFields				= document.getElementById(qaFieldsInputName).value;
	var description				= document.getElementById(descriptionInputName).value;
	var id 						= document.getElementById(idInputName).value;
	//alert("got input values");
	document.getElementById("save-rubric-type").value = "update";			// tell 'saverubric.php' to update rubric
	document.getElementById("save-rubric-id").value = id;					// tell 'saverubric.php' which record to rename
	document.getElementById("save-rubric-name").value = name; 				// set the new name value in the form
	document.getElementById("save-rubric-qa-names").value = qaNames; 		// set the qa name string value in the form
	document.getElementById("save-rubric-qa-fields").value = qaFields; 		// set the qa field string value in the form
	document.getElementById("save-rubric-description").value = description; // set the new description value in the form
	//document.getElementById("save-rubric-form").action = "saverubric.php";	// set the form action to 'saverubric.php'
	document.getElementById("save-rubric-form").submit();					// submit the form in 'php/save-item-forms.php' (processed by 'saverubric.php')
}
// DELETE SAVED RUBRIC
function savedRubricRemove(id)
{
	var confirmMessage = confirm("Are you sure you want to delete this saved rubric?");
	if(confirmMessage)
	{
		document.getElementById("save-rubric-type").value = "remove";	// tell 'saverubric.php' to remove rubric
		document.getElementById("save-rubric-id").value = id;			// tell 'saverubric.php' which record to remove
		//document.getElementById("save-rubric-form").action = "saverubric.php";	// set the form action to 'saverubric.php'
		document.getElementById("save-rubric-form").submit();			// submit the form in 'php/save-item-forms.php' (processed by 'saverubric.php')
	} // end if confirm
	else { }
}
// RUBRIC CREATION PAGE FUNCTIONS
function saveRubric(type)
{
	document.getElementById("save-rubric-type").value = type;
	document.getElementById("save-rubric-form").submit();
}

// VIEW MODE - REVIEWS
function showReviewsList(show, hide)
{
	swapItems(show, hide);
	storeItem("reviews-view", "list");
}
function showReviewsGrid(show, hide)
{
	swapItems(show, hide);
	storeItem("reviews-view", "grid");
}
function loadReviewsView()
{
	var view = sessionStorage.getItem("reviews-view");
	switch(view)
	{
		case "list" : swapItems("reviews-list", "reviews-grid"); break;
		case "grid" : swapItems("reviews-grid", "reviews-list"); break;
		default		: swapItems("reviews-list", "reviews-grid"); break;
	}
}

// TOGGLE MONTHLIES/WEEKLIES IN ARCHIVE
function searchArchiveType(type)
{
	if(type === null) { type = "monthly"; }
	document.getElementById("search-archive-type").value = type; // set hidden input
	document.getElementById("search-archive-page").value = 1; // reset page value to 1
	searchArchive(); // submit the form
}

// SET NUMBER OF RESULTS TO DISPLAY
function setNumResults()
{
	var n = +document.getElementById("select-num-results").value;
	document.getElementById("search-reviews-num-results").value = n;
	searchReviews();
}
function setListSize()
{
	var n = +document.getElementById("select-list-size").value;
	if(n)
	{
		document.getElementById("search-reviews-list-size").value = n;
		searchReviews();
	}
	else
	{
		alert("Please select a value between 1 and 100");
		document.getElementById("select-list-size").focus();
	}
}
function resetListSize()
{
	document.getElementById("search-reviews-list-size").value = "";
	searchReviews();
}

// LOAD MORE RESULTS
function loadMore(n)
{
	document.getElementById("search-reviews-num-results").value = n;
	searchReviews();
	var anchorID = "results-" + n;
	window.location.href = "#" + anchorID;
}

// SHOW MORE RESULTS
function showMore(n)
{
	var nextN = n + 1;
	var nextID = "results-group-" + nextN;
	document.getElementById(nextID).style.display = "block";
	
	var btnID = "results-group-more-" + n;
	document.getElementById(btnID).style.display = "none";
}

// CLEAR REVIEW SEARCH
function clearReviews()				// called in 'php/search-options.php'
{
	window.location.href = "home.php";
	powersearchHide();
}
function clearSearch(page)				// called in 'php/search-options.php'
{
	if(!page) { page = "home.php"; }
	window.location.href = page;
	powersearchHide();
}

// PROMOCODE ENTRY ----------------------------------------------------------------------------------------
function enterPromocode()
{
	var promocode = document.getElementById("promocode").value;
	// only submit the form if the field has a value
	if(promocode)
	{
		storeItem("promocode-entered", "true");
		document.getElementById("promocode-entry-form").submit();
	}
}
function loadPromocode()
{
	var promocode = sessionStorage.getItem("promocode-entered");
	if(promocode === "true") 
	{ 
		showItem("promo-message-show", "promo-message-hide", "promocode-form-container"); 
	}
	storeItem("promocode-entered", "");
}

// JUROR PANEL - STORE
function jurorPanelStore()
{
	//alert("jurorPanelStore() triggered");
	var count = document.getElementById("num-entries").value;
	//alert("count = " + count);
	
	// vars for input element IDs
	var yesID;
	var noID;
	var maybeID;
	var commentsID;
	var mentionID;
	var shortListID;
	
	// vars for input element objects
	var yesElem;
	var noElem;
	var maybeElem;
	var commentsElem;
	var mentionElem;
	var shortListElem;
	
	// vars for input element values
	var yesValue;
	var noValue;
	var maybeValue;
	var commentsValue;
	var mentionValue;
	var shortListValue;
	
	// array of entry item arrays
	var allEntries = [];
	
	// array var for each entry in loop
	var thisEntry = [];
	
	// loop through each set of inputs (one set for each entry)
	for(var i = 0; i < count; i++)
	{
		// determine the name of the inputs for each entry (prefix + counter)
		yesID 		= "yes-" + i;
		noID		= "no-" + i;
		maybeID		= "maybe-" + i;
		commentsID 	= "juror-comments-" + i;
		mentionID	= "mention-" + i;
		shortListID	= "shortlist-" + i;
		
		//alert("yesID: " + yesID + "\n" + "noID: " + noID + "\n" + "maybeID: " + maybeID + "\n" + "commentsID: " + commentsID + "\n" + "mentionID: " + mentionID + "\n" + "shortListID: " + shortListID);
		
		// check if input element exists - if so, get its value
		yesElem = document.getElementById(yesID);
		if(yesElem) { yesValue = document.getElementById(yesID).checked; } else { yesValue = ""; }
		//alert("yesElem: " + yesElem + "\n" + "yesValue: " + yesValue);
		
		noElem = document.getElementById(noID);
		if(noElem) { noValue = document.getElementById(noID).checked; } else { noValue = ""; }
		//alert("noElem: " + noElem + "\n" + "noValue: " + noValue);
		
		maybeElem = document.getElementById(maybeID);
		if(maybeElem) { maybeValue = document.getElementById(maybeID).checked; } else { maybeValue = ""; }
		//alert("maybeElem: " + maybeElem + "\n" + "maybeValue: " + maybeValue);
		
		commentsElem = document.getElementById(commentsID);
		if(commentsElem) { commentsValue = document.getElementById(commentsID).value; } else { commentsValue = ""; }
		if(commentsValue) { commentsValue = commentsValue.replace(",", "--"); } // replace commas, since used as delimiter in load script
		//alert("commentsElem: " + commentsElem + "\n" + "commentsValue: " + commentsValue);
		
		mentionElem = document.getElementById(mentionID);
		if(mentionElem) { mentionValue = document.getElementById(mentionID).checked; } else { mentionValue = ""; }
		//alert("mentionElem: " + mentionElem + "\n" + "mentionValue: " + mentionValue);
		
		shortListElem = document.getElementById(shortListID);
		if(shortListElem) { shortListValue = document.getElementById(shortListID).checked; } else { shortListValue = ""; }
		//alert("shortListElem: " + shortListElem + "\n" + "shortListValue: " + shortListValue);
		
		// set array of values for this entry
		thisEntry = [yesValue, noValue, maybeValue, commentsValue, mentionValue, shortListValue, "|"];
		
		// append the array of entry values to the array of all entries
		if(thisEntry)
		{ 
			//alert("i: " + i + "\n" + "thisEntry: " + thisEntry);
			allEntries[i] = thisEntry;
			//allEntries.push(thisEntry);
			//alert("array " + i + " added to allEntries");
		} // end if thisEntry
		
	} // end for
	
	// store items in session storage
	storeItem("juror-test-storage", "test-storage");
	storeItem("juror-entries", allEntries);
	//alert("items stored");
	//alert("allEntries: " + allEntries);
	
	// kapi textareas
	var kapiRankingsID = 'kapi-rankings';
	var kapiPioneersID = 'kapi-pioneers';
	var kapiRankingsElem = document.getElementById(kapiRankingsID);
	var kapiPioneersElem = document.getElementById(kapiPioneersID);
	if(kapiRankingsElem) { var kapiRankingsValue = document.getElementById(kapiRankingsID).value; storeItem("juror-kapi-rankings", kapiRankingsValue); }
	if(kapiPioneersElem) { var kapiPioneersValue = document.getElementById(kapiPioneersID).value; storeItem("juror-kapi-pioneers", kapiPioneersValue); }
	
} // end function jurorPanelStore(count)

function jurorPanelLoad()
{
	//alert("jurorPanelLoad() triggered");
	
	// vars for input element IDs
	var yesID;
	var noID;
	var maybeID;
	var commentsID;
	var mentionID;
	var shortListID;
	
	// vars for input element objects
	var yesElem;
	var noElem;
	var maybeElem;
	var commentsElem;
	var mentionElem;
	var shortListElem;
	
	// vars for input element values
	var yesValue;
	var noValue;
	var maybeValue;
	var commentsValue;
	var mentionValue;
	var shortListValue;
	
	// array var for each entry in loop
	var thisEntry;
	
	//var testStorage= sessionStorage.getItem("juror-test-storage"); alert("testStorage: " + testStorage);
	
	var allEntries = sessionStorage.getItem("juror-entries");
	if(allEntries)
	{
		allEntries = allEntries.split("|");
		//alert("allEntries: " + allEntries);
		var count = allEntries.length;
		//alert("count: " + count);
		for(var i = 0; i < count; i++)
		{
			// locate the values in the stored arrays
			thisEntry 		= allEntries[i];
			thisEntry 		= thisEntry.split(",");
			if(i === 0)
			{
                yesValue 		= thisEntry[0];
                noValue 		= thisEntry[1];
                maybeValue 		= thisEntry[2];
                commentsValue 	= thisEntry[3];
                mentionValue 	= thisEntry[4];
                shortListValue 	= thisEntry[5];
			}
			else
			{
				yesValue 		= thisEntry[1];
                noValue 		= thisEntry[2];
                maybeValue 		= thisEntry[3];
                commentsValue 	= thisEntry[4];
                mentionValue 	= thisEntry[5];
                shortListValue 	= thisEntry[6];
			}
			
			if(commentsValue) { commentsValue = commentsValue.replace("--", ","); } // replace commas, since used as delimiter in load script
			
			// determine the name of the inputs for each entry (prefix + counter)
            yesID 		= "yes-" + i;
            noID		= "no-" + i;
            maybeID		= "maybe-" + i;
            commentsID 	= "juror-comments-" + i;
            mentionID	= "mention-" + i;
            shortListID	= "shortlist-" + i;
			
			//alert("i = " + i + "\n" + "thisEntry: " + thisEntry + "\n" + "yesValue: " + yesValue + "\n" + "noValue: " + noValue + "\n" + "maybeValue: " + maybeValue + "\n" + "commentsValue: " + commentsValue + "\n" + "mentionValue: " + mentionValue + "\n" + "shortListValue: " + "\n" + shortListValue + "\n" + "\n" + "yesID: " + yesID + "\n" + "noID: " + noID + "\n" + "maybeID: " + maybeID + "\n" + "commentsID: " + commentsID + "\n" + "mentionID: " + mentionID + "\n" + "shortListID: " + shortListID);
		
			// check if input element exists - if so, set its value
			///*
            yesElem = document.getElementById(yesID);
			if(yesElem)
			{
				//alert("yesElem found" + "\n" + "yesValue: " + yesValue);
            	if(yesValue === true || yesValue === "true")				{ document.getElementById(yesID).checked = true; }
				else 														{ document.getElementById(yesID).checked = false; }
			}
			
            noElem = document.getElementById(noID);
			if(noElem)
			{
				//alert("noElem found" + "\n" + "noValue: " + noValue);
				if(noValue === true || noValue === "true") 					{ document.getElementById(noID).checked = true; }
				else 														{ document.getElementById(noID).checked = false; }
			}
			
            maybeElem = document.getElementById(maybeID);
			if(maybeElem)
            {
				//alert("maybeElem found" + "\n" + "maybeValue: " + maybeValue);
				if(maybeValue === true || maybeValue === "true")			{ document.getElementById(maybeID).checked = true; }
				else 														{ document.getElementById(maybeID).checked = false; }
			}
			
            commentsElem = document.getElementById(commentsID);
            if(commentsElem)												{ document.getElementById(commentsID).value = commentsValue; }

            mentionElem = document.getElementById(mentionID);
			if(mentionElem)
            {
				//alert("mentionElem found" + "\n" + "mentionValue: " + mentionValue);
				if(mentionValue === true || mentionValue === "true") 		{ document.getElementById(mentionID).checked = true; }
				else 														{ document.getElementById(mentionID).checked = false; }
			}
			
            shortListElem = document.getElementById(shortListID);
			if(shortListElem)
            {
				//alert("shortListElem found" + "\n" + "shortListValue: " + shortListValue);
				if(shortListValue === true || shortListValue === "true") 	{ document.getElementById(shortListID).checked = true; }
				else 														{ document.getElementById(shortListID).checked = false; }
			}
			//*/
		} // end for
	} // end if allEntries
	//else { alert("allEntries not found"); }
	
	// handle kapi textareas - get session storage items, if exist, set textarea values
	var kapiRankingsID = 'kapi-rankings';
	var kapiPioneersID = 'kapi-pioneers';
	var kapiRankingsElem = document.getElementById(kapiRankingsID);
	var kapiPioneersElem = document.getElementById(kapiPioneersID);
	
	var kapiRankingsValue = sessionStorage.getItem("juror-kapi-rankings");
	var kapiPioneersValue = sessionStorage.getItem("juror-kapi-pioneers");
	
	if(kapiRankingsValue)
	{
		if(kapiRankingsElem) { document.getElementById(kapiRankingsID).value = kapiRankingsValue; }
	}
	if(kapiPioneersValue)
	{
		if(kapiPioneersElem) { document.getElementById(kapiPioneersID).value = kapiPioneersValue; }
	}
	
} // end function jurorPanelLoad()

function jurorPanelClear()
{
	storeItem("juror-entries", "");
	storeItem("juror-kapi-rankings", "");
	storeItem("juror-kapi-pioneers", "");
}

// JUROR PANEL DISCARD
function discardJurorPanel(type)
{
	var dest;
	if(type === "bologna") 		{ dest = "bolognaragazzi.php"; }
	else if(type === "kapi") 	{ dest = "kapis.php"; }
	else						{ dest = "awards.php"; }
	openURL(dest);
}

// REVIEW PAGE QUICK EDIT
function quickEditShow()
{
	document.getElementById("show-quick-edit").style.display = "none"; 			// hide the enter quick edit mode btn
	document.getElementById("cancel-quick-edit").style.display = "block"; 		// show the discard changes btn
	document.getElementById("commit-quick-edit").style.display = "block"; 		// show the save changes btn
	document.getElementById("review-text").style.display = "none";				// hide the readonly review
	document.getElementById("review-text-quick-edit").style.display = "block"; 	// show the quick-edit review textarea
	var initialText = document.getElementById("review-text-pre-edit").innerHTML;// get the initial value of the review text from hidden div
	storeItem("quick-edit-before", initialText);								// store the initial value of the review text
}
function quickEditCancel()
{
	document.getElementById("show-quick-edit").style.display = "block"; 		// show the enter quick edit mode btn
	document.getElementById("cancel-quick-edit").style.display = "none"; 		// hide the discard changes btn
	document.getElementById("commit-quick-edit").style.display = "none"; 		// hide the save changes btn
	document.getElementById("review-text").style.display = "block";				// show the readonly review
	document.getElementById("review-text-quick-edit").style.display = "none"; 	// hide the quick-edit review textarea
	var initialText = sessionStorage.getItem("quick-edit-before");				// get the stored initial review text value
	if(initialText) { document.getElementById("quick-edit-textarea").value = initialText; } // reset the textarea with the initial review text
}
function quickEditCommit()
{
	document.getElementById("review-quick-edit-form").submit();
}

// EDITORIAL PAGE
function editorialInputsStore()
{
    //alert("editorialInputsStore() triggered");
	// get each of the input values
	var status		= document.getElementById("status").value;
	var issue		= document.getElementById("issue").value;
	var weekly		= document.getElementById("weekly").value;
	
	var title 		= document.getElementById("title").value;
	var copyright 	= document.getElementById("copyright").value;
	var company 	= document.getElementById("company").value;
	var price 		= document.getElementById("price").value;
	var filesize 	= document.getElementById("filesize").value;
	var ages 		= document.getElementById("ages").value;
	var grades 		= document.getElementById("grades").value;
	
	var platforms 	= document.getElementById("platforms").value;
	var subjects 	= document.getElementById("subjects").value;
	var topics 		= document.getElementById("topics").value;
	var languages 	= document.getElementById("languages").value;
	var scaffolding = document.getElementById("scaffolding").value;
	var languageNotes = document.getElementById("languageNotes").value;
	
	var platformsOther 	= document.getElementById("platformsOther").value;
	var subjectsOther 	= document.getElementById("subjectsOther").value;
	var topicsOther 	= document.getElementById("topicsOther").value;
	var languagesOther 	= document.getElementById("languagesOther").value;
	var scaffoldingOther= document.getElementById("scaffoldingOther").value;
	
	var linkItunes 	= document.getElementById("linkItunes").value;
	var linkAndroid	= document.getElementById("linkAndroid").value;
	var linkAmazon 	= document.getElementById("linkAmazon").value;
	var linkSteam 	= document.getElementById("linkSteam").value;
	var linkVideo 	= document.getElementById("linkVideo").value;
	
	var reviewText 	= document.getElementById("reviewText").value;
	var reviewNotes	= document.getElementById("reviewNotes").value;
	
	/*
	var standardQA1	= document.getElementById("standardQARating1").value;
	var standardQA2	= document.getElementById("standardQARating2").value;
	var standardQA3	= document.getElementById("standardQARating3").value;
	var standardQA4	= document.getElementById("standardQARating4").value;
	var standardQA5	= document.getElementById("standardQARating5").value;
	*/
	
	var awards 		= document.getElementById("awards").value;
	
	ratingCalcStandard(); // call this function to store the standard qa inputs values (as radio btns)
	
	/*
	alert(
	"status: " + status + "\n" +
	"issue: " + issue + "\n" +
	"weekly: " + weekly + "\n" +
	
	"title: " + title + "\n" +
	"copyright: " + copyright + "\n" +
	"company: " + company + "\n" +
	"price: " + price + "\n" +
	"filesize: " + filesize + "\n" +
	"ages: " + ages + "\n" +
	"grades: " + grades + "\n" +
	
	"platforms: " + platforms + "\n" +
	"subjects: " + subjects + "\n" +
	"topics: " + topics + "\n" +
	"languages: " + languages + "\n" +
	"scaffolding: " + scaffolding + "\n" +
	"languageNotes: " + languageNotes + "\n" +
	
	"linkItunes: " + linkItunes + "\n" +
	"linkAndroid: " + linkAndroid + "\n" +
	"linkAmazon: " + linkAmazon + "\n" +
	"linkSteam: " + linkSteam + "\n" +
	"linkVideo: " + linkVideo + "\n" +
	
	"reviewText: " + reviewText + "\n" +
	"reviewNotes: " + reviewNotes + "\n" +
	"standardQA1: " + standardQA1 + "\n" +
	"standardQA2: " + standardQA2 + "\n" +
	"standardQA3: " + standardQA3 + "\n" +
	"standardQA4: " + standardQA4 + "\n" +
	"standardQA5: " + standardQA5 + "\n" +
	
	"awards: " + awards + "\n"
	);
	*/
	
	// store items in session storage
	storeItem("editorial-test-storage", "test-storage");
	
	storeItem("editorial-status", status);
	storeItem("editorial-issue", issue);
	storeItem("editorial-weekly", weekly);storeItem("editorial-test-storage", "test-storage");
	
	storeItem("editorial-status", status);
	storeItem("editorial-issue", issue);
	storeItem("editorial-weekly", weekly);
	
	storeItem("editorial-title", title);
	storeItem("editorial-copyright", copyright);
	storeItem("editorial-company", company);
	storeItem("editorial-price", price);
	storeItem("editorial-filesize", filesize);
	storeItem("editorial-ages", ages);
	storeItem("editorial-grades", grades);
	
	storeItem("editorial-platforms", platforms);
	storeItem("editorial-subjects", subjects);
	storeItem("editorial-topics", topics);
	storeItem("editorial-languages", languages);
	storeItem("editorial-scaffolding", scaffolding);
	storeItem("editorial-language-notes", languageNotes);
	
	storeItem("editorial-platforms-other", platformsOther);
	storeItem("editorial-subjects-other", subjectsOther);
	storeItem("editorial-topics-other", topicsOther);
	storeItem("editorial-languages-other", languagesOther);
	storeItem("editorial-scaffolding-other", scaffoldingOther);
	
	storeItem("editorial-link-itunes", linkItunes);
	storeItem("editorial-link-android", linkAndroid);
	storeItem("editorial-link-amazon", linkAmazon);
	storeItem("editorial-link-steam", linkSteam);
	storeItem("editorial-link-video", linkVideo);
	
	storeItem("editorial-review-text", reviewText);
	storeItem("editorial-review-notes", reviewNotes);
	
	/*
	// if using number inputs - when using radio btns, the function ratingCalcStandard() performs this action, and is called by editorialInputsLoad()
	storeItem("editorial-standard-qa-1", standardQA1);
	storeItem("editorial-standard-qa-2", standardQA2);
	storeItem("editorial-standard-qa-3", standardQA3);
	storeItem("editorial-standard-qa-4", standardQA4);
	storeItem("editorial-standard-qa-5", standardQA5);
	*/
	
	storeItem("editorial-awards", awards);
}

function checkboxUpdate(boxID, boxValue, hiddenID)
{
	//alert("checkboxUpdate() triggered");
	// get the initial value of the hidden input (the total of all of the checked boxes)
	var initialValue = document.getElementById(hiddenID).value;
	var newValue;
	var replaceValue;
	var valuePos;
	var commaPos;
	
	// check whether the box is checked - if so, concatenate hidden value with box value - if not, remove box value from hidden value
	var isChecked = document.getElementById(boxID).checked;
	
	// if checking the box, add the box value to the hidden value
	if(isChecked)	
	{ 
		if(initialValue) 	{ newValue = initialValue + ", " + boxValue; } // if other items in the string, add a preceding comma
		else				{ newValue = boxValue; } // if no items already in string, just set to the checked value
	}
	
	// if unchecking the box, remove the box value from the hidden value
	else			
	{ 
		valuePos = initialValue.indexOf(boxValue); // check the position of the value in the string
		
		// if the box value begins in the hidden value at a position greater than 0, it is not the first value
		if(valuePos > 0) 	
		{ 
			replaceValue = ", " + boxValue; 
		} 
		
		// if the position of the box value is 0, it is the first value
		else 								
		{ 
			commaPos = initialValue.indexOf(","); // check whether the box value is the only value
			if(commaPos > -1) 	{ replaceValue = boxValue + ", "; } // if commaPos had valid value, there are multiple values with commas delimiting them
			else				{ replaceValue = boxValue; } // if commaPos invalid value, box value is only value in hidden value
		}
		newValue = initialValue.replace(replaceValue, ''); // define the substring to be replaced
	}
	//alert("boxID: " + boxID + "\n" + "boxValue: " + boxValue + "\n" + "hiddenID: " + hiddenID + "\n" + "initialValue: " + initialValue + "\n" + "isChecked: " + isChecked + "\n" + "valuePos: " + valuePos + "\n" + "commaPos: " + commaPos + "\n" + "replaceValue: " + replaceValue + "\n" + "newValue: " + newValue );
	document.getElementById(hiddenID).value = newValue; // update the hiddenID with the new string value
}
function checkboxSelect(boxID, boxValue, hiddenID)
{
	//alert("checkboxSelect() triggered");
	// get the initial value of the hidden input (the total of all of the checked boxes)
	var initialValue = document.getElementById(hiddenID).value;
	var newValue;
	var replaceValue;
	var valuePos;
	var boxElem;
	var commaPos;
	
	// check whether the box is checked - if so, concatenate hidden value with box value - if not, remove box value from hidden value
	var isChecked = document.getElementById(boxID).checked;
	
	// if not checked, check the box and add the box value to the hidden value
	if(!isChecked)	
	{ 
		boxElem = document.getElementById(boxID); // make sure the checkbox element exists
		if(boxElem) { document.getElementById(boxID).checked = true; } // check the box
		if(initialValue) 	{ newValue = initialValue + ", " + boxValue; } // if other items in the string, add a preceding comma
		else				{ newValue = boxValue; } // if no items already in string, just set to the checked value
	}
	
	// if checked, uncheck the box and remove the box value from the hidden value
	else			
	{ 
		boxElem = document.getElementById(boxID); // make sure the checkbox element exists
		if(boxElem) { document.getElementById(boxID).checked = false; } // uncheck the box
		
		valuePos = initialValue.indexOf(boxValue); // check the position of the value in the string
		// if the box value begins in the hidden value at a position greater than 0, it is not the first value
		if(valuePos > 0) 	
		{ 
			replaceValue = ", " + boxValue; 
		} 
		
		// if the position of the box value is 0, it is the first value
		else 								
		{ 
			commaPos = initialValue.indexOf(","); // check whether the box value is the only value
			if(commaPos > -1) 	{ replaceValue = boxValue + ", "; } // if commaPos had valid value, there are multiple values with commas delimiting them
			else				{ replaceValue = boxValue; } // if commaPos invalid value, box value is only value in hidden value
		}
		newValue = initialValue.replace(replaceValue, ''); // define the substring to be replaced
	}
	//alert("boxID: " + boxID + "\n" + "boxValue: " + boxValue + "\n" + "hiddenID: " + hiddenID + "\n" + "initialValue: " + initialValue + "\n" + "isChecked: " + isChecked + "\n" + "valuePos: " + valuePos + "\n" + "replaceValue: " + replaceValue + "\n" + "newValue: " + newValue );
	document.getElementById(hiddenID).value = newValue;
}
function loadCheckboxes(set, values)
{
	//alert("loadCheckboxes() triggered" + "\n" + "set: " + set + "\n" + "values: " + values);
	var boxValue;
	var boxID;
	var boxElem;
	var elemExists;
	if(values)
	{
		values = values.split(", ");
		//alert("values: " + values);
		for(var n = 0; n < values.length; n++)
		{
			boxValue = values[n];
			boxID = set + "_" + boxValue.replace(" ", "_");
			boxElem = document.getElementById(boxID); // check that element exists (protects against values added that are not on the list)
			if(boxElem) { elemExists = "true"; } else { elemExists = "false"; }
			//alert("boxValue: " + boxValue + ", boxID: " + boxID + ", elemExists: " + elemExists);
			if(boxElem) { document.getElementById(boxID).checked = true; }
		} // end for
	} // end if values
} // end function loadCheckboxes()

function editorialInputsLoad()
{
    //alert("editorialInputsLoad() triggered");
	// check if session storage is supported
	var test = sessionStorage.getItem("editorial-test-storage");
	//alert("test: " + test);
	// if session storage is supported, get stored items and set input fields with their values
	if(test)
	{ 
		// get stored items
		var status 		= sessionStorage.getItem("editorial-status");
		var issue 		= sessionStorage.getItem("editorial-issue");
		var weekly 		= sessionStorage.getItem("editorial-weekly");
		
		var title 		= sessionStorage.getItem("editorial-title");
		var copyright 	= sessionStorage.getItem("editorial-copyright");
		var company 	= sessionStorage.getItem("editorial-company");
		var price 		= sessionStorage.getItem("editorial-price");
		var filesize 	= sessionStorage.getItem("editorial-filesize");
		var ages 		= sessionStorage.getItem("editorial-ages");
		var grades 		= sessionStorage.getItem("editorial-grades");
		
		var platforms 	= sessionStorage.getItem("editorial-platforms");
		var subjects 	= sessionStorage.getItem("editorial-subjects");
		var topics	 	= sessionStorage.getItem("editorial-topics");
		var languages 	= sessionStorage.getItem("editorial-languages");
		var scaffolding	= sessionStorage.getItem("editorial-scaffolding");
		var languageNotes= sessionStorage.getItem("editorial-languageNotes");
		
		var platformsOther 	= sessionStorage.getItem("editorial-platforms-other");
		var subjectsOther 	= sessionStorage.getItem("editorial-subjects-other");
		var topicsOther	 	= sessionStorage.getItem("editorial-topics-other");
		var languagesOther 	= sessionStorage.getItem("editorial-languages-other");
		var scaffoldingOther= sessionStorage.getItem("editorial-scaffolding-other");
		
		var linkItunes 	= sessionStorage.getItem("editorial-link-itunes");
		var linkAndroid	= sessionStorage.getItem("editorial-link-android");
		var linkAmazon 	= sessionStorage.getItem("editorial-link-amazon");
		var linkSteam 	= sessionStorage.getItem("editorial-link-steam");
		var linkVideo 	= sessionStorage.getItem("editorial-link-video");
		
		var reviewText 	= sessionStorage.getItem("editorial-review-text");
		var reviewNotes	= sessionStorage.getItem("editorial-review-notes");
		
		var standardQA1	= sessionStorage.getItem("editorial-standard-qa-1");
		var standardQA2	= sessionStorage.getItem("editorial-standard-qa-2");
		var standardQA3	= sessionStorage.getItem("editorial-standard-qa-3");
		var standardQA4	= sessionStorage.getItem("editorial-standard-qa-4");
		var standardQA5	= sessionStorage.getItem("editorial-standard-qa-5");
		
		var awards 		= sessionStorage.getItem("editorial-awards");
		
		/*
		alert(
		"status: " + status + "\n" +
		"issue: " + issue + "\n" +
		"weekly: " + weekly + "\n" +

		"title: " + title + "\n" +
		"copyright: " + copyright + "\n" +
		"company: " + company + "\n" +
		"price: " + price + "\n" +
		"filesize: " + filesize + "\n" +
		"ages: " + ages + "\n" +
		"grades: " + grades + "\n" +

		"platforms: " + platforms + "\n" +
		"subjects: " + subjects + "\n" +
		"topics: " + topics + "\n" +
		"languages: " + languages + "\n" +
		"scaffolding: " + scaffolding + "\n" +
		"languageNotes: " + languageNotes + "\n" +
		
		"platformsOther: " + platformsOther + "\n" +
		"subjectsOther: " + subjectsOther + "\n" +
		"topicsOther: " + topicsOther + "\n" +
		"languagesOther: " + languagesOther + "\n" +
		"scaffoldingOther: " + scaffoldingOther + "\n" +

		"linkItunes: " + linkItunes + "\n" +
		"linkAndroid: " + linkAndroid + "\n" +
		"linkAmazon: " + linkAmazon + "\n" +
		"linkSteam: " + linkSteam + "\n" +
		"linkVideo: " + linkVideo + "\n" +

		"reviewText: " + reviewText + "\n" +
		"reviewNotes: " + reviewNotes + "\n" +
		"standardQA1: " + standardQA1 + "\n" +
		"standardQA2: " + standardQA2 + "\n" +
		"standardQA3: " + standardQA3 + "\n" +
		"standardQA4: " + standardQA4 + "\n" +
		"standardQA5: " + standardQA5 + "\n" +

		"awards: " + awards + "\n"
		);
		*/
	
		// set input fields with stored values
		document.getElementById("status").value = status;
		document.getElementById("issue").value = issue;
		document.getElementById("weekly").value = weekly;
		
		document.getElementById("title").value = title;
		document.getElementById("copyright").value = copyright;
		document.getElementById("company").value = company;
		document.getElementById("price").value = price;
		document.getElementById("filesize").value = filesize;
		document.getElementById("ages").value = ages;
		document.getElementById("grades").value = grades;
		
		document.getElementById("platforms").value = platforms;
		document.getElementById("subjects").value = subjects;
		document.getElementById("topics").value = topics;
		document.getElementById("languages").value = languages;
		document.getElementById("scaffolding").value = scaffolding;
		document.getElementById("languageNotes").value = languageNotes;
		
		document.getElementById("platformsOther").value = platformsOther;
		document.getElementById("subjectsOther").value = subjectsOther;
		document.getElementById("topicsOther").value = topicsOther;
		document.getElementById("languagesOther").value = languagesOther;
		document.getElementById("scaffoldingOther").value = scaffoldingOther;
		
		document.getElementById("linkItunes").value = linkItunes;
		document.getElementById("linkAndroid").value = linkAndroid;
		document.getElementById("linkAmazon").value = linkAmazon;
		document.getElementById("linkSteam").value = linkSteam;
		document.getElementById("linkVideo").value = linkVideo;
		
		document.getElementById("reviewText").value = reviewText;
		document.getElementById("reviewNotes").value = reviewNotes;
		
		document.getElementById("awards").value = awards;
		
		/*
		// using number inputs
		document.getElementById("standardQARating1").value = standardQA1;
		document.getElementById("standardQARating2").value = standardQA2;
		document.getElementById("standardQARating3").value = standardQA3;
		document.getElementById("standardQARating4").value = standardQA4;
		document.getElementById("standardQARating5").value = standardQA5;
		*/
		
		// check the radio btns for the standard QA
		var standardQABtnID;
		var standardQARatings = [standardQA1, standardQA2, standardQA3, standardQA4, standardQA5];
		var qaValue;
		var qaN;
		for(var i = 0; i < standardQARatings.length; i++)
		{
			qaValue = standardQARatings[i];
			qaN = i + 1;
			standardQABtnID = "standardQARating" + qaN + "Option" + qaValue;
			document.getElementById(standardQABtnID).checked = true;
		}
		
		//alert("before calling ratingCalcStandard and loadRubric");
		ratingCalcStandard(); 	// display the standard rating outputs
		loadRubric(); 			// load the rubric qa
		//alert("after calling ratingCalcStandard and loadRubric");
		
		// UPDATE RADIO BTNS
		if(status)
		{
			document.getElementById("unpublished").checked = false;
			document.getElementById("published").checked = true;
		}
		else
		{
			document.getElementById("unpublished").checked = true;
			document.getElementById("published").checked = false;
		}
		
		// UPDATE CHECKBOX SETS
		var checkboxSets = [["platforms", platforms], ["subjects", subjects], ["topics", topics], ["languages", languages], ["scaffolding", scaffolding], ["awards", awards]];
		var checkboxSetName;
		var checkboxSetValues;
		for(i = 0; i < checkboxSets.length; i++)
		{
			checkboxSetName 	= checkboxSets[i][0];
			checkboxSetValues 	= checkboxSets[i][1];
			loadCheckboxes(checkboxSetName, checkboxSetValues);
		} // end for
		//alert("end if test");
	} // end if test
	
	// IF NO STORAGE, TOGGLE THE DISPLAY OF STANDARD OVERALL RATING IF IT HAS A VALUE
	else
	{
		var standardOverallScoreElem = document.getElementById("standard-overall-score");
		if(standardOverallScoreElem)
		{ 
			var standardOverallScore = document.getElementById("standard-overall-score").value;
			if(standardOverallScore)
			{
				if(standardOverallScore !== "?")
				{
					var outputContainer = document.getElementById("standard-evaluation-total-container").id;
					var outputElem = document.getElementById("standard-score-output").id;
					if(outputContainer)
					{
						if(outputElem)
						{
							//alert("outputContainer: " + outputContainer + ", outputElem: " + outputElem);
							document.getElementById("standard-evaluation-total-container").style.display = "block";
							document.getElementById("standard-score-output").innerHTML = "Overall Rating: " + standardOverallScore + "%";
						} // end if outputElem
					} // end if outputContainer
				} // end if standardOverallScore != "?"
			} // end if standardOverallScore
		} // end if standardOverallScoreElem
	} // end else no storage
	//alert("editorialInputsLoad() complete");
} // end function editorialInputsLoad()

function editorialClear()
{
	// store items in session storage
	storeItem("editorial-test-storage", "");
	
	storeItem("editorial-status", "");
	storeItem("editorial-issue", "");
	storeItem("editorial-weekly", "");
	
	storeItem("editorial-title", "");
	storeItem("editorial-copyright", "");
	storeItem("editorial-company", "");
	storeItem("editorial-price", "");
	storeItem("editorial-filesize", "");
	storeItem("editorial-ages", "");
	storeItem("editorial-grades", "");
	
	storeItem("editorial-platforms", "");
	storeItem("editorial-subjects", "");
	storeItem("editorial-topics", "");
	storeItem("editorial-languages", "");
	storeItem("editorial-scaffolding", "");
	storeItem("editorial-language-notes", "");
	
	storeItem("editorial-link-itunes", "");
	storeItem("editorial-link-android", "");
	storeItem("editorial-link-amazon", "");
	storeItem("editorial-link-steam", "");
	storeItem("editorial-link-video", "");
	
	storeItem("editorial-review-text", "");
	storeItem("editorial-review-notes", "");
	
	storeItem("editorial-standard-qa-1", "");
	storeItem("editorial-standard-qa-2", "");
	storeItem("editorial-standard-qa-3", "");
	storeItem("editorial-standard-qa-4", "");
	storeItem("editorial-standard-qa-5", "");
	
	storeItem("editorial-awards", "");
}
function editorialRevert(reviewID)
{
	editorialClear();
	window.location.href = "review.php?id=" + reviewID;
}
function editorialDiscard(url)
{
	editorialClear();
	if(!url) { url = "home.php"; }
	window.location.href = url;
}
function editorialSubmit()
{
    //alert("editorialSubmit() triggered");
	
	// declare an array of visible field ids
	var fields = [
		"status", "issue", "weekly", 
		"title", "copyright", "company", "price", "filesize", "ages", "grades", 
		"platforms", "subjects", "topics", "languages", "scaffolding", "languageNotes",
		"platformsOther", "subjectsOther", "topicsOther", "languagesOther", "scaffoldingOther",
		"linkItunes", "linkAndroid", "linkAmazon", "linkSteam", "linkVideo", 
		"reviewText", "reviewNotes", 
		"standardQA1", "standardQA2", "standardQA3", "standardQA4", "standardQA5",
		"awards"
		];
    var fieldID;
	var hiddenID;
	var fieldElem;
	var hiddenElem;
	var fieldValue;
	for(var i = 0; i < fields.length; i++)
	{
		fieldID     = fields[i]; // get the visible field input id from the current index of the array
		hiddenID    = "editorial" + fieldID; // calculate the hidden input id
		fieldElem	= document.getElementById(fieldID); 	// check whether visible input element exists
		hiddenElem	= document.getElementById(hiddenID);	// check whether hidden input element exists
       	if(fieldElem)	{ fieldValue  = document.getElementById(fieldID).value; } // get the visible field contents
		else			{ fieldValue = ""; }
       	if(hiddenElem)	{ document.getElementById(hiddenID).value = fieldValue; } // set the hidden input values in 'php/rubric-output.php'
		//alert("fieldID: " + fieldID + "\n" + "hiddenID: " + hiddenID + "\n" + "fieldElem: " + fieldElem + "\n" + "hiddenElem: " + hiddenElem + "\n" + "fieldValue: " + fieldValue);
	}
	document.getElementById("rubric-evaluation-form").submit(); // submit the form
	
}
function ratingCalcStandard()
{
	//alert("ratingCalcStandard() triggered");
	// DECLARE COUNTER VARIABLES TO BE INCREMENTED
	var sum = 0; 			// unweighted sum of all points given by the user
	var numRatings = 0;		// the number of ratings eith values
	var ratings = [];		// array for ratings
	//var ratingID; 			// only used with number inputs
	var ratingName;			// name of an individual rating input element
	var rating;				// value of an individual rating input
	var ratingOptionID;		// the id of an individual radio btn
	var ratingOptionChecked;// whether an individual radio btn is checked
	var ratingOptionValue;	// the value of an individual radio btn
	var ratingOmit;			// whether to omit a rating (if set to "N") from the calculation
	var ratingOutputID;		// the id of a div element for outputting an individual rating value
	var hiddenInputID;		// the id of the hidden input containing an individual qa rating value
	
	// LOOP THROUGH EACH QA AND GET VALUES
	for(var q = 1; q < 6; q ++)
	{
		var i = q - 1;
		ratingName 		= "standardQARating" + q;
		ratingOutputID 	= "standard-qa-output-" + q;
		hiddenInputID	= "standardQA" + q;
		
		// determine whether "N" was checked
		ratingOptionID = ratingName + "OptionN";
		if(ratingOptionID)
		{
			ratingOptionChecked = document.getElementById(ratingOptionID).checked;
			ratingOptionValue	= document.getElementById(ratingOptionID).value;
			if(ratingOptionChecked)
			{
				ratingOmit = true;
				document.getElementById(ratingOutputID).innerHTML = "N";
				storeItem("editorial-standard-qa-" + q, "N");
				if(hiddenInputID) { document.getElementById(hiddenInputID).value = "N"; } // update the hidden input used for form submission
			}
			else { ratingOmit = false; }
		} // end if ratingOptionID
		//alert("ratingOptionID: " + ratingOptionID + "\n" + "ratingOptionChecked: " + ratingOptionChecked + "\n" + "ratingOptionValue: " + ratingOptionValue + "\n" + "ratingOmit: " + ratingOmit);
		
		// if N not checked, examine each radio btn to determine if checked
		if(!ratingOmit)
		{
			for(var r = 0; r < 11; r ++)
			{
				ratingOptionID = ratingName + "Option" + r;
				if(ratingOptionID)
				{
					ratingOptionChecked = document.getElementById(ratingOptionID).checked;
					ratingOptionValue	= +document.getElementById(ratingOptionID).value;
					if(ratingOptionChecked) 
					{ 
						rating = ratingOptionValue;
						sum += rating*10;
						numRatings ++;
						ratings[i] = rating;
						document.getElementById(ratingOutputID).innerHTML = rating + "/10";
						storeItem("editorial-standard-qa-" + q, rating);
						//alert("rating: " + rating + "\n" + "hiddenInputID: " + hiddenInputID);
						if(hiddenInputID) { document.getElementById(hiddenInputID).value = rating; } // update the hidden input used for form submission
					} // end if ratingOptionChecked
					else { rating = ""; }
				} // end if ratingOptionID
				//alert("ratingOptionID: " + ratingOptionID + "\n" + "ratingOptionChecked: " + ratingOptionChecked + "\n" + "ratingOptionValue: " + ratingOptionValue + "\n" + "rating: " + rating + "\n" + "sum: " + sum + "\n" + "numRatings: " + numRatings + "\n" + "hiddenInputID: " + hiddenInputID);
			} // end for r
			
		} // end if !ratingOmit
		
		/*
		// method using number inputs
		ratingID = "standardQARating" + q;
		rating 	= +document.getElementById(ratingID).value;
		if(rating)
		{
			sum += rating*10;
			numRatings ++;
			ratings[i] = rating;
		} // end if(rating)
		*/
	} // end for q = 1; q < 6; q ++
	
	// CALCULATE WEIGHTED AVERAGE, STARS
	var score = sum/numRatings;
	score = score.toFixed(2); 
	var stars = score / 20; stars = stars.toFixed(2);
	
	document.getElementById("standard-overall-score").value = score; 								// update the hidden form input for the overall score
	document.getElementById("standard-score-output").innerHTML = "Overall Rating: " + score + "%";	// update the output of the overall score
	
	if(score !== "NaN") { document.getElementById("standard-evaluation-total-container").style.display = "block"; } // display the overall score container
	else				{ document.getElementById("standard-evaluation-total-container").style.display = "none"; }
	//alert("score: " + score);
	//alert("ratings: " + ratings);
	// SAVE ARRAYS OF RATINGS AND WEIGHTS IN SESSION STORAGE
	storeItem("standard-ratings", ratings);
	
} // end function ratingCalcStandard()

// REVIEW PAGE QUICK RATING
function quickRatingOutput()
{
	/* 
	this function outputs the value of the slider input for a user's "quick rating" on the review page
	it is triggered by the onchange event attribute of the slider input in 'php/content-review.php'
	*/
	var rating = +document.getElementById("quick-rating-slider").value;			// get the slider value
	document.getElementById("quick-rating-score").value = rating;				// update the hidden input with the slider value
	document.getElementById("quick-rating-output").innerHTML = rating + "%";	// output the value as html
	postPreview();						// display the post preview	
	storeItem("quick-rating", rating);	// save the rating in session storage
}
function quickRatingInc(dir)
{
	/*
	this function increments or decrements the value of a user's "quick rating" by 1 on the review page
	it is triggered by the +/- buttons in 'php/content-review.php'
	*/
	
	// determine whether to increment or decrement
	var inc;
	if(dir === "inc") 	{ inc = 1; } 
	if(dir === "dec") 	{ inc = -1; }
	
	// get the initial value
	var oldVal = +document.getElementById("quick-rating-slider").value;
	
	// calculate the new value (constraining between 0 and 100)
	var newVal = oldVal + inc;
	if(newVal < 0) 		{ newVal = 0; }
	if(newVal > 100) 	{ newVal = 100; }
	
	// update the range input and the output
	document.getElementById("quick-rating-slider").value = newVal;
	quickRatingOutput();
}
function quickRatingLoad()
{
	/*
	this function gets the session storage values for a user's "quick rating" and comment on the review page and updates the form inputs/html outputs
	it is triggered by the body onload event - the file 'php/autoload.php' appends the $onload value with this function if $pageType == 'review'
	*/
	
	// get the stored values from session
	var rating 	= sessionStorage.getItem("quick-rating");
	var comment = sessionStorage.getItem("quick-rating-comment");
	var showPreview = false;
	
	if(rating)
	{
		showPreview = true; // if there is a rating value, show the post preview
		document.getElementById("quick-rating-slider").value = rating; // update the slider input
		quickRatingOutput(); // call the output function (above) which updates hidden score input and outputs innerHTML 
	}
	
	if(comment)
	{
		
		showPreview = true; // if there is a comment value, show the post preview
		document.getElementById("review-comment-textarea").value = comment; // update the textarea
	}
	
	// if either a rating or comment, display the post preview
	if(showPreview === true) { postPreview(); }
}
function quickRatingReset()
{
	/*
	this function resets a user's "quick rating" on the review page
	it is triggered by the Reset buttons (img and text) in 'php/content-review.php'
	*/

	document.getElementById("quick-rating-slider").value = 50;		// set the slider input to its default value
	document.getElementById("quick-rating-score").value = '';		// clear the hidden input value
	document.getElementById("quick-rating-output").innerHTML = '';	// clear the html output
	
	document.getElementById("post-preview-rating").innerHTML = '';	// clear the rating output for the post preview
	document.getElementById("post-preview-rating").style.display = "none"; // hide the rating output element of the post preview
	
	// check whether there is a comment - if not, hide the post preview entirely
	var comment = sessionStorage.getItem("quick-rating-comment");
	if(!comment) { document.getElementById("post-preview").style.display = "none"; }
	
	storeItem("quick-rating", ''); // clear the rating value from session storage
}
function postPreview()
{
	/*
	this function displays a preview of a user's comment/rating on the review page
	it is triggered by the onkeyup even attribute of the comment textarea and the functions (above) for outputing the rating value
	*/
	
	// check if there is a rating - if so, update the innerHTML and display the element, otherwise reset and hide
	var rating	= document.getElementById("quick-rating-score").value;
	if(rating) 
	{ 
		document.getElementById("post-preview-rating").innerHTML = "Rating: " + rating + "%";
		document.getElementById("post-preview-rating").style.display = "block";
	}
	else
	{
		document.getElementById("post-preview-rating").innerHTML = '';
		document.getElementById("post-preview-rating").style.display = "none";
	}
	
	// get the value from the comment textarea and output it in the preview element
	var comment = document.getElementById("review-comment-textarea").value;
	document.getElementById("post-preview-comment").innerHTML = comment;
	
	// if there is either a comment or rating, display the post preview - if not, hide it
	var showPreview = false;
	if(rating) 	{ showPreview = true; }
	if(comment) { showPreview = true; }
	if(showPreview === true) 	{ document.getElementById("post-preview").style.display = "block"; }
	else 						{ document.getElementById("post-preview").style.display = "none"; }
	
	// store the rating and comment values in session storage
	storeItem("quick-rating", rating);
	storeItem("quick-rating-comment", comment);
	
	//var storedComment = sessionStorage.getItem("quick-rating-comment");
	//alert("storedComment: " + storedComment);
}

// REVIEW IMAGE TOGGLE
function reviewImagesHide()
{
	var n;
	for(n = 1; n < 4; n++)
	{
		var imgID 	= "review-image-" + n;
		var thumbID = "review-image-thumb-" + n;
		var imgElem = document.getElementById(imgID);
		var thumbElem = document.getElementById(thumbID);
		if(imgElem) 	{ document.getElementById(imgID).className = "hide"; }
		if(thumbElem) 	{ document.getElementById(thumbID).className = "review-image-thumb-inactive"; }
	}
}
function reviewImageShow(n)			// called in 'php/content-review.php'
{
	reviewImagesHide();
	var imgID 	= "review-image-" + n;
	var thumbID = "review-image-thumb-" + n;
	document.getElementById(imgID).className = "review-image";
	document.getElementById(thumbID).className = "review-image-thumb-active";
}
function reviewImageZoom(url)		// called in 'php/content-review.php' 
{
	//alert("triggered");
	var url = url;
	if(url)
	{
		var qPos 	= url.indexOf('.php?');
		var urlPage = url.substring(0, qPos);
		//alert("url = " + url + "\n" + "qPos = " + qPos + "\n" + "urlPage = " + urlPage);
		if(urlPage === "login")		{ window.location.href = url; }
		else if(urlPage === "zoom") { window.open(url); }
	}
}

// RUBRICS ------------------------------------------------------------------------------------------------
function lettergrade(score)
{
	var grade;
	
			if	(score >= 96.5)					{	grade = 'A+';	}
	else	if	(score >= 93.5 && score < 96.5)	{	grade = 'A';	}
	else	if	(score >= 89.5 && score < 93.5)	{	grade = 'A-';	}
	else	if	(score >= 86.5 && score < 89.5)	{	grade = 'B+';	}
	else	if	(score >= 83.5 && score < 86.5)	{	grade = 'B';	}
	else	if	(score >= 79.5 && score < 83.5)	{	grade = 'B-';	}
	else	if	(score >= 76.5 && score < 79.5)	{	grade = 'C+';	}
	else	if	(score >= 73.5 && score < 76.5)	{	grade = 'C';	}
	else	if	(score >= 69.5 && score < 73.5)	{	grade = 'C-';	}
	else	if	(score >= 66.5 && score < 69.5)	{	grade = 'D+';	}
	else	if	(score >= 63.5 && score < 66.5)	{	grade = 'D';	}
	else	if	(score >= 59.5 && score < 63.5)	{	grade = 'D-';	}
	else	if	(score > 0 && score < 59.5)		{	grade = 'F';	}
	else 	{ grade = null; }
	return(grade);
}

// CALCULATE OVERALL RATING
function ratingCalc()
{
	//alert("ratingCalc() triggered");
	// DECLARE COUNTER VARIABLES TO BE INCREMENTED
	var sum = 0; 			// unweighted sum of all points given by the user
	var ptsPossible = 0; 	// total possible points defined by weights
	var ptsEarned = 0; 		// total points given (rating * weight)
	var ratings = [];		// array for ratings
	var weights = [];		// array for weights
	
	// DETERMINE THE NUMBER OF QA
	var numQA = +document.getElementById("num-qa").value;
	//alert("numQA: " + numQA);
	var qMax = numQA + 1;
	//alert("numQA: " + numQA);
	// LOOP THROUGH EACH QA AND GET VALUES
	for(var q = 1; q < qMax; q ++)
	{
		var i = q - 1;
		
		var scoreID		= "qa-score-" + q;	// hidden input - is set only after user inputs via slider
		var weightID 	= "qa-weight-" + q;	// weight slider
		
		var rating 	= +document.getElementById(scoreID).value;
		var weight 	= +document.getElementById(weightID).value;
		
		weights[i] = weight;
		
		if(rating)
		{
			sum += rating;
			if(weight) { ptsPossible += weight; }
			var wscore = (rating * weight) / 100;
			ptsEarned += wscore;
			
			ratings[i] = rating;
		} // end if(rating)
		
	} // end for q = 1; q < qMax; q ++
	
	// CALCULATE WEIGHTED AVERAGE, STARS
	var score = (ptsEarned / ptsPossible) * 100; 
	score = score.toFixed(2); 
	var stars = score / 20; stars = stars.toFixed(2);
	
	document.getElementById("score").value = score; 													// update the hidden form input for the overall score
	document.getElementById("rubric-evaluation-score").innerHTML = "Overall Rating: " + score + "%";	// update the output of the overall score
	if(score !== "NaN") { document.getElementById("rubric-evaluation-total-container").style.display = "block"; } // display the overall score container
	else				{ document.getElementById("rubric-evaluation-total-container").style.display = "none"; }
	
	//alert("ratings: " + ratings);
	// SAVE ARRAYS OF RATINGS AND WEIGHTS IN SESSION STORAGE
	storeItem("rubric-ratings", ratings);
	storeItem("rubric-weights", weights);
	//alert("stored ratings and weights");
} // end function ratingCalc()

// OUTPUT A PERCENTAGE BASED ON SLIDER INPUT AND RECALCULATE OVERALL RATING
function outputQA(type, n)
{
	var inputID 	= "qa-" + type + "-" + n;
	var outputID 	= "qa-" + type + "-output-" + n;
	var value	= +document.getElementById(inputID).value;
	if(type === "rating")
	{
		var hiddenID	= "qa-score-" + n;
		document.getElementById(hiddenID).value = value; // set the hidden input for ratings
	}
	document.getElementById(outputID).innerHTML = value + "%";
	ratingCalc(); // update the overall rating
}

// ADD/SUBSTRACT 1 FROM SLIDER
function incrementQA(dir, type, n)
{
	// determine whether to increment or decrement
	var inc;
	if(dir === "inc") 	{ inc = 1; } 
	if(dir === "dec") 	{ inc = -1; }
	
	// get the initial value
	var inputID = "qa-" + type + "-" + n;
	var oldVal = +document.getElementById(inputID).value;
	
	// calculate the new value (constraining between 0 and 100)
	var newVal = oldVal + inc;
	if(newVal < 0) 		{ newVal = 0; }
	if(newVal > 100) 	{ newVal = 100; }
	
	// update the range input and the output
	document.getElementById(inputID).value = newVal;
	outputQA(type, n);
}

// RESET A SINGLE QA
function resetQA(n)
{
	var ratingID 	= "qa-rating-" + n;	// range input (slider)
	var outputID	= "qa-rating-output-" + n;
	var scoreID		= "qa-score-" + n;	// hidden input - is set only after user inputs via slider
	var weightID 	= "qa-weight-" + n;
	var defaultID	= "qa-weight-default-" + n;
	var defaultWeight = document.getElementById(defaultID).value;
	document.getElementById(ratingID).value = 50;
	document.getElementById(outputID).innerHTML = "";
	document.getElementById(scoreID).value = null;
	document.getElementById(weightID).value = defaultWeight;
	outputQA("weight", n);
}

// RESET ALL QA
function resetRubric()
{
	var numQA = +document.getElementById("num-qa").value;
	if(numQA > 0)
	{
		var w;
		for(var i = 0; i < numQA; i++)
		{
			w = i + 1;
			resetQA(w);
		} // end for
	} // end if numQA > 0
} // end function

function loadWeightOutputs()
{
	var numQA = +document.getElementById("num-qa").value;
	if(numQA > 0)
	{
		var weightElem;
		var outputElem;
		var weightID;
		var outputID;
		var weight;
		var w;
		for(var i = 0; i < numQA + 1; i++)
		{
			w = i + 1;
			weightID 	= "qa-weight-" + w;
			outputID	= "qa-weight-output-" + w;
			weightElem 	= document.getElementById(weightID);
			outputElem 	= document.getElementById(outputID);
			if(weightElem) { weight	= document.getElementById(weightID).value; }
			if(outputElem) { document.getElementById(outputID).innerHTML = weight + "%"; }
		} // end for
	} // end if numQA > 0
} // end function

// STORE TEXTAREA FIELD CONTENTS FOR A RUBRIC EVALUATION
function storeRubricReview()
{
	var elem = document.getElementById("rubric-evaluation-textarea"); // check whether the element exists - is only output if there is a review loaded
	if(elem)
	{
		var review = document.getElementById("rubric-evaluation-textarea").value; // get the value of the textarea
		storeItem("rubric-review", review); // store the textarea contents in session storage
	} // end if elem
} // end function

// LOAD STORED RATINGS AND WEIGHTS FOR EACH QA
function loadRubric()
{
	//alert("loadRubric() triggered");
	var ratings = sessionStorage.getItem("rubric-ratings");
	var weights = sessionStorage.getItem("rubric-weights");
	var hasStorage = false;
	//alert("ratings: " + ratings);
	if(ratings)
	{
		//alert("has ratings");
		hasStorage 		= true;
		//alert("if ratings: ratings: " + ratings);
		ratings 		= ratings.split(',');
		var r;
		for(r = 0; r < ratings.length; r++)
		{
			var n = r + 1;
			var ratingID 	= "qa-rating-" + n;
			var scoreID		= "qa-score-" + n;
			var outputID	= "qa-rating-output-" + n;
			var rating		= ratings[r];
			if(rating)
			{
				document.getElementById(ratingID).value 	= rating;
				document.getElementById(scoreID).value 		= rating;
				document.getElementById(outputID).innerHTML = rating + "%";
			}
		} // end for
	} // end if ratings
	if(weights)
	{
		hasStorage 		= true;
		weights 		= weights.split(',');
		var w;
		for(w = 0; w < weights.length; w++)
		{
			var n = w + 1;
			var weightID 	= "qa-weight-" + n;
			var outputID	= "qa-weight-output-" + n;
			var weight		= weights[w];
			document.getElementById(weightID).value 	= weight;
			document.getElementById(outputID).innerHTML = weight + "%";
		} // end for
	} // end if weights
	
	if(hasStorage) 
	{ 
		ratingCalc(); // update the overall score
	}
	
	// LOAD THE REVIEW
	var review = sessionStorage.getItem("rubric-review"); // get the stored review from session storage
	if(review)
	{
		var elem = document.getElementById("rubric-evaluation-textarea"); // check whether the element exists - is only output if there is a review loaded
		if(elem)
		{
			document.getElementById("rubric-evaluation-textarea").value = review; // place the stored review in the textarea
		} // end if elem
	} // if review
	
	loadWeightOutputs(); // output weights (if switching to a rubric with more qa)
	
} // end function

// this isn't being used
function clearStoredRubric()
{
	alert("triggered");
	storeItem("ratings", "");
	storeItem("weights", "");
	alert("stored items");
	loadWeightOutputs(); alert("finished");
}

// COMMENT UPDATE/DELETE
function updatePost(n)
{
	var formID = "exchange-post-edit-" + n;
	document.getElementById(formID).submit();
}
function deletePost(n)
{
	var formID = "exchange-post-delete-" + n;
	//alert("formID: " + formID);
	document.getElementById(formID).submit();
}

// EXPERTS PAGE
function showExpertsList(show, hide)
{
	swapItems(show, hide);
	storeItem("experts-view", "list");
}
function showExpertsGrid(show, hide)
{
	swapItems(show, hide);
	storeItem("experts-view", "grid");
}
function loadExpertsView()
{
	var view = sessionStorage.getItem("experts-view");
	switch(view)
	{
		case "list" : swapItems("experts-list", "experts-grid"); break;
		case "grid" : swapItems("experts-grid", "experts-list"); break;
		default		: swapItems("experts-list", "experts-grid"); break;
	}
}

// PUBLISHER DIRECTORY
function showPublishersList(show, hide)
{
	swapItems(show, hide);
	storeItem("publishers-view", "list");
}
function showPublishersGrid(show, hide)
{
	swapItems(show, hide);
	storeItem("publishers-view", "grid");
}
function loadPublishersView()
{
	var view = sessionStorage.getItem("publishers-view");
	switch(view)
	{
		case "list" : swapItems("publishers-list", "publishers-grid"); break;
		case "grid" : swapItems("publishers-grid", "publishers-list"); break;
		default		: swapItems("publishers-list", "publishers-grid"); break;
	}
}

// DYNAMIC GRID VIEW
function showList(type)
{
	swapItems("list", "grid");
	var storageItem = type + "-view";
	storeItem(storageItem, "list");
}
function showGrid(type)
{
	swapItems("grid", "list");
	var storageItem = type + "-view";
	storeItem(storageItem, "grid");
}
function loadViewMode(type)
{
	var storageItem = type + "-view";
	var view = sessionStorage.getItem(storageItem);
	//alert("storageItem: " + storageItem + "\n" + "view: " + view);
	switch(view)
	{
		case "list" : swapItems("list", "grid"); break;
		case "grid" : swapItems("grid", "list"); break;
		default		: swapItems("list", "grid"); break; // make list the default
	}
}

// PROFILE PAGE -------------------------------------------------------------------------------------------

// PROFILE TAB CONTROL
function hideProfileSections(count)
{
	var i;
	var btnID;
	var labelID;
	var sectionID;
	var index = -1;
	for(i = 0; i < count; i++)
	{
		index ++;
		btnID 		= "tab-btn-" + index;
		labelID 	= "tab-label-" + index;
		sectionID 	= "profile-section-" + index;
		document.getElementById(btnID).style.display = "block";
		document.getElementById(labelID).style.display = "none";
		document.getElementById(sectionID).style.display = "none";
	} // end for
} // end hideProfileSections()
function showProfileSection(index, count)
{
	hideProfileSections(count);
	var btnID 		= "tab-btn-" + index;
	var labelID 	= "tab-label-" + index;
	var sectionID 	= "profile-section-" + index;
	document.getElementById(btnID).style.display = "none";
	document.getElementById(labelID).style.display = "block";
	document.getElementById(sectionID).style.display = "block";
	storeItem('stored-profile-section', index);
}
function loadProfileSection()
{
	var index = sessionStorage.getItem("stored-profile-section"); // get the stored index number
	var countElem = document.getElementById("num-profile-sections");
	if(countElem) 
	{ 
		var count = document.getElementById("num-profile-sections").value - 1; 
		if(index > count) { index = 0; }
	}
	if(!index) { index = 0; }
	showProfileSection(index);
}

// BOOKMARK FOLDERS
function showBookmarksFolder(index, count)
{
	selectItem(index, count);
	storeItem("stored-bookmarks-folder", index);
	storeItem("stored-bookmarks-num-folders", count);
	var mElem = document.getElementById("folder-select-mobile");
	if(mElem) { hideItem("show-folder-select-mobile", "hide-folder-select-mobile", "folder-select-mobile"); }
}
function loadBookmarksFolder(postDeletion)
{
	var index = sessionStorage.getItem("stored-bookmarks-folder"); 		// get the stored index number
	var count = sessionStorage.getItem("stored-bookmarks-num-folders"); // get the stored folder count
	
	// if a folder was just deleted, decrement the folder count by 1 and reset index to 0 (uncategorized)
	if(postDeletion) { index = 0; count -= 1; } // bool set in 'php/autoload.php' if $_SESSION item 'folderDeleted' is set
	if(index >= count) 	{ index = 0; } // constrain index 
	if(!index) 			{ index = 0; } // make 0 (uncategorized) if unspecified
	showBookmarksFolder(index, count); // call the above function to show the correct folder
}

// USAGE REPORTS
function usageReport(scope)
{
	//alert("usageReport() triggered - scope = " + scope);
	if(!scope) { scope = "alltime"; } // default to all time if not specified
	document.getElementById("usage-report-scope").value = scope; // set the hidden form input with the scope argument
	document.getElementById("usage-report-form").submit(); // submit the usage report form
}
function usageSort(sort)
{
	if(!sort) { sort = "date"; } // default to date if not specified
	document.getElementById("usage-report-sort").value = sort; // set the hidden form input with the sort argument
	document.getElementById("usage-report-form").submit(); // submit the usage report form
}

// SITE LICENSE ORDER FLOW -----------------------------------------
function licenseCalcClear()
{
	document.getElementById("license-calc-clear").submit();
}
function licenseOrderLoad()
{
	document.getElementById("license-calc-redirect").value = "license-order.php";
	document.getElementById("site-license-cost-calculator").submit();
}
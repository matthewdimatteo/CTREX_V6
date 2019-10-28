<!--
php/content/content-workshops.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Workshops and Consulting page of the site
-->

<?php
// get the stored $_SESSION values from a redirect (on captcha error)
$sessionItem = 'workshops-form-submission';
require_once 'php/form-submission-get.php';
?>

<!-- PAGE CONTAINER -->
<div id = "workshops-page-container">

	<!-- PAGE HEADER -->
	<div class = "page-header">Workshops and Consulting</div>
	
	<!-- PHOTO -->
	<div id="workshops-photo" class="inline width-10"><img src="http://childrenstech.com/files/2009/05/Screen-Shot-2013-03-06-at-10.12.25-PM-253x300.png"/></div>
	
	<!-- DESCRIPTION -->
    <div id = "workshops-description" class = "inline width-80">
		<div class = "paragraph left">
			<p>
			Professional workshops and consulting services are available for schools and libraries with <a href = "http://childrenstech.com" target = "_blank"><em>Children's Technology Review</em></a> founder and editor Warren Buckleitner, PhD.
			</p>
			<p>
			Please note that to protect the objectivity of our ratings, we do not consult for publishers whose products we might review.
			</p>
			<p>
			Dr. Buckleitner is a parent, teacher, and author of <a href = "https://www.gryphonhouse.com/books/details/buckleitners-guide-to-using-tablets-with-young-children" target = "_blank"><em>Buckleitner's Guide to Using Tablets with Young Children</em></a>. For ten years, he covered children's technology for the <a href = "http://www.nytimes.com/" target = "_blank"><em>New York Times</em></a>. Buckleitner is an adjunct professor at <a href = "http://tcnj.pages.tcnj.edu/" target = "_blank">The College of New Jersey</a>.
			He holds a BS in elementary education, an MS in human development, and a doctorate in educational psychology from <a href = "https://msu.edu/" target = "_blank">Michigan State University</a>.
			</p>
			<p>
			If you are a parent, teacher, student, or librarian with questions regarding psychological or developmental factors related to children's use of interactive media or technological trends within the space, use this form to express your interest in arranging a workshop or consulting session. Your request will be handled as quickly as possible.
			</p>
		</div><!-- /.paragraph -->
    </div><!-- /#workshops-description -->
	
	<!-- FORM -->
	<div id = "workshops-form-container" class = "paragraph">
	<form name = "workshops-form" id = "workshops-form" method = "POST" action = "workshops-process.php">
	<?php
	$workshopsFormFields = array
	(
		array('Name'		, 'inputName'		, $inputName		, 'text'	, true	, ''),
		array('Email'		, 'inputEmail'		, $inputEmail		, 'email'	, true	, ''),
		array('Occupation'	, 'occupation'		, $occupation		, 'text'	, false	, ''),
		array('Message'		, 'contactMessage'	, $contactMessage	, 'textarea', true	, '')
	);
	$_SESSION['workshops-form-fields'] = $workshopsFormFields;
	$fields = $workshopsFormFields;
	require 'php/form-fields-output.php';
	require_once 'php/captcha.php';
	?>
    <div class = "submit-row"><input type = "submit" name = "submit-workshops-form" value = "Submit Your Message"/></div>
	</form>
	</div><!-- /#workshops-form-container -->
	
</div><!-- /#workshops-page-container -->
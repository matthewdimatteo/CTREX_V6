<?php
/*
php/content/content-submit.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the product submission page 'submit.php'
It contains the product submission form, along with copy for the page description and other information
*/

// get the stored product submission after redirection
$sessionItem = 'product-submission';			// specifies the $_SESSION storage item for the form submission data
require_once 'php/form-submission-get.php';		// gets the stored submission data and assigns each item in the array to a variable
$confirmationType = 'product-submission';		// specifies $_SESSION storage item prefix for the confirmation number
require_once 'php/get-confirmation-number.php';	// gets the confirmation number from $_SESSION storage and displays it

// if logged in as a publisher, get contact info from $_SESSION storage and set fields with those values
if($publisher == true)
{
	$inputName 		= $_SESSION['publisher-info-name'];
	$website 		= $_SESSION['publisher-info-website'];
	$address 		= $_SESSION['publisher-info-address'];
	$contactName 	= $_SESSION['publisher-info-contact'];
	$inputEmail 	= $_SESSION['publisher-info-email'];
	$phone 			= $_SESSION['publisher-info-phone'];
	$fax 			= $_SESSION['publisher-info-fax'];
	$facebook 		= $_SESSION['publisher-info-facebook'];
	$twitter 		= $_SESSION['publisher-info-twitter'];
	$youtube 		= $_SESSION['publisher-info-youtube'];
}
?>

<!-- PAGE HEADER -->
<div class = "page-header">Submit Products for Review</div>

<!-- DESCRIPTION -->
<div class = "paragraph left bottom-20 instructions">
	We welcome submissions of children’s interactive media from any publisher of any size or part of the world. Any commercial product is "fair game" for a review, with no exceptions.
	<br/><br/>
	There are no fees associated with submitting products. Before you send us products, check to make sure your title is not already listed in the CTREX Database. You might also want to watch <a href = "http://childrenstech.com/blog/archives/14994" target = "_blank">"Working With the Press… Do’s and Don’ts"</a>
	<br/><br/>
	CTR considers apps, commercial video games, software, Internet sites and smart toys for ages birth to 15 years of age. We don’t look at linear media or non-interactive products, and we can’t ensure that we’ll review every product. 
</div><!-- /.paragraph left bottom-20 instructions -->

<!-- SELECTOR -->
<div class = "bottom-20" id = "submission-page-selector">
	<div class = "col space-20">
		<div id = "btn-2"><div class = "text-btn" onclick = "selectItem('2', 3)">What We Pick</div></div>
		<div id = "label-2" class = "hide"><div class = "bold">What We Pick</div></div>
	</div><!-- /.col space-20 -->
	<div class = "col space-10"> | </div>
	<div class = "col space-20">
		<div id = "btn-1" class = "hide"><div class = "text-btn" onclick = "selectItem('1', 3)">Submission Form</div></div>
		<div id = "label-1"><div class = "bold">Submission Form</div></div>
	</div><!-- /.col space-20 -->
	<div class = "col space-10"> | </div>
	<div class = "col space-20">
		<div id = "btn-3"><div class = "text-btn" onclick = "selectItem('3', 3)">Award Programs</div></div>
		<div id = "label-3" class = "hide"><div class = "bold">Award Programs</div></div>
	</div><!-- /.col space-20 -->
</div><!-- /.bottom-20 #submission-page-selector -->

<?php
// ARRAY OF SUBMISSION FORM SECTIONS AND THEIR FIELDS
// defines arrays for fields of each section of the product submission form
// array (label, name, value, type, required, note)
$productInformationFields = array
(
	array('Product Name'	, 'productName'		, $productName	, 'text'	, true	, ''),
	array('Description'		, 'description'		, $description	, 'textarea', false	, ''),
	array('Price'			, 'price'			, $price 		, 'text'	, true	, 'The suggested retail (or street) price in USD.'),
	array('Platform'		, 'platform'		, $platform		, 'text'	, true	, 'Hardware and platform information.'),
	array('Age'				, 'age'				, $age			, 'text'	, true	, 'The recommended age(s) for the product.'),
	array('Key Dates'		, 'keyDates'		, $keyDates		, 'text'	, true	, 'The street date (ideally we like to see products 30-60 days prior to the street date).'),
	array('Link'			, 'productLink'		, $productLink	, 'text'	, false	, 'The URL to download the product, or the product website.'),
	array('Codes'			, 'codes'			, $codes		, 'text'	, false	, 'Any required codes for access or downloading, to give us a child\'s eye view of your product.')
);
$_SESSION['submit-product-info-fields'] = $productInformationFields; // stored value accessed on 'submit-process.php'
$productScreenshotFields = array
(
	array('Image 1 URL'		, 'image1URL'		, $image1URL	, 'text'	, false	, 'Primary image - what the child does (typical activity).'),
	array('Image 2 URL'		, 'image2URL'		, $image2URL	, 'text'	, false	, 'Main menu or choice point.'),
	array('Image 3 URL'		, 'image3URL'		, $image3URL	, 'text'	, false	, 'Support image - another typical activity.')
);
$_SESSION['submit-product-screenshot-fields'] = $productScreenshotFields; // stored value accessed on 'submit-process.php'
$companyContactInfoFields = array
(
	array('Company Name', 'inputName'			, $inputName	, 'text'	, true	, ''),
	array('Web site'	, 'website'				, $website		, 'text'	, false	, ''),
	array('Address'		, 'address'				, $address		, 'textarea', false	, ''),
	array('Contact Name', 'contactName'			, $contactName	, 'text'	, true	, ''),
	array('Email'		, 'inputEmail'			, $inputEmail	, 'email'	, true	, ''),
	array('Phone'		, 'phone'				, $phone		, 'text'	, false	, ''),
	array('Fax'			, 'fax'					, $fax			, 'text'	, false	, ''),
	array('Facebook'	, 'facebook'			, $facebook		, 'text'	, false	, ''),
	array('Twitter'		, 'twitter'				, $twitter		, 'text'	, false	, ''),
	array('YouTube'		, 'youtube'				, $youtube		, 'text'	, false	, '')
);
$_SESSION['submit-product-contact-fields'] = $companyContactInfoFields; // stored value accessed on 'submit-process.php'
$additionalInfoFields = array
(
	array('', 'additionalInfo', $additionalInfo, 'textarea', false, '')
);
$_SESSION['submit-product-additional-info'] = $additionalInfoFields; // stored value accessed on 'submit-process.php'
$productScreenshotDescription = 
'
	Don\'t send images that are promotional in any way. We won\'t use those images. For apps, we like three images:<br/>
	<ol>
		<li>Typical activity</li>
		<li>Main menu or choice point</li>
		<li>Another typical activity. We want to show the child\'s eye view</li>
	</ol>
';

// defines array of each form section
// array (subheader, description, fields)
$submissionFormSections = array
(
	array('Product Information'			, ''							, $productInformationFields),
	array('Product Screenshots'			, $productScreenshotDescription	, $productScreenshotFields),
	array('Company Contact Information'	, ''							, $companyContactInfoFields),
	array('Any Additional Information'	, ''							, $additionalInfoFields)
);
?>

<!-- SUBMISSION FORM -->
<div class = "paragraph-container" id = "container-1">
<?php $tabindex = 0; ?>
<form name = "submit-products-form" id = "submit-products-form" method = "POST" action = "submit-process.php">
	<div class = "page-header">Product Submission Form</div>
	<?php
	foreach($submissionFormSections as $section)
	{
		$subheader 		= $section[0];
		$description 	= $section[1];
		$fields 		= $section[2];
		echo '<div class = "paragraph bottom-10">';
		if($subheader != NULL) 		{ echo '<div class = "subheader">'.$subheader.'</div>'; }
		if($description != NULL) 	{ echo '<div class = "paragraph left instructions">'.$description.'</div>'; }
		require 'php/form-fields-output.php';
		echo '</div>'; // /.bottom-10
	} // end foreach $section
	?>
	<div class = "subheader bottom-20">* Indicates required field</div>
	<br/>
	<?php require_once 'php/captcha.php';?>
	
	<!-- SUBMIT BUTTON -->
	<div class = "paragraph row top-20">
		<div class = "field-label"></div>
		<div class = "field-container"><input type = "submit" name = "submit-product-btn" id = "submit-product-btn" value = "Submit Product" /></div>
		<div class = "field-note"></div>
	</div><!-- /.row -->
	
	<!-- WHERE TO SEND MATERIALS -->
	<div class = "subheader top-20">Where to send materials *</div>
	<div class = "italic bottom-20">
		Children's Technology Review<br/>
		126 Main Street<br/>
		Flemington, NJ 08822<br/>
		<br/>
		908-284-0404 (phone, 9 AM - 3 PM, EST)<br/>
		908-284-0405 (fax)
	</div><!-- /.italic bottom-20 -->
	
	<!-- FOOTNOTE -->
	<div class = "italic field-footnote">* Final packaging and swag is not necessary and has no bearing on determining if a product gets reviewed.</div>
	
</form><!-- /#submit-products-form -->
</div><!-- /.paragraph-container #submit-products-form-container -->

<!-- WHAT WE PICK -->
<div class = "hide" id = "container-2">
<div class = "paragraph left instructions">
	<div class = "page-header">What We Pick For Review</div>
	<p>
		In the last four years, the number of children’s apps has far outnumbered our ability to provide comprehensive coverage. In determining how to spread our attention, we consider the following factors:
	</p>
	<ul>
		<li>Suggestions from readers. We tune into our subscribers and take requests.</li>
		<li>"Consumer Risk" – a free product is less likely to be reviewed, simply because you can give it a test to see for yourself. That’s not to say we don’t review all “free” products. We do consider children’s time in this formula. A product with popular characters does increase the chances we’ll have a look.</li>
		<li>Lack of PR resources. We especially look for promising products that might fly under the radar of other review services.</li>
		<li>The first of a series. We try to “nip it in the bud” to point out common errors for a planned series. Perhaps the creator can make changes.</li>
		<li>Newsworthiness. We’ll have a quick look, but determine it doesn’t merit the review time because it lacks something we call “newsworthiness.” For example, if an app is the second or third in a series, and the design doesn’t vary from others, we’ll make a note of the new product in the start of the original product with a date stamp, and move on.</li>
		<li>Does it fill the curriculum grid? We’re always looking for interactive products with learning value; worthy of classroom time and resources.</li>
	</ul>
</div><!-- /.paragraph left instructions -->
</div><!-- /.hide #what-we-pick -->

<!-- AWARD PROGRAMS -->
<div class = "hide" id = "container-3">
<div class = "paragraph left instructions">
	<div class = "page-header">Award Programs</div>
	<div class = "subheader">KAPi Awards (Kids At Play Awards for Innovation) and the Bologna Ragazzi Digital Prize</div>
	<p>
		Products submitted to CTR are also automatically considered for one of two prizes; however YOU MUST USE THE CONTEST ENTRY FORM (we’re just one vote of many).
	</p>
	<p>
		The annual KAPi Awards, to be given at the Kids at Play Summit in Las Vegas, NV during the first day of the International Consumer Electronics Show. Here’s how the award program works.
	</p>
	<p>
		In an effort to identify innovation and excellence in the design of children’s interactive media, CTR Editor Warren Buckleitner and the attendees of the Dust or Magic institute will create a list of nominees, following the three days of testing and live demonstrations that are the normal part of the Institute. The attendees help create the list. During the Kids at Play Institute event, the winners will be selected during the lunch. To be eligible for an award, a product must have the following:
	</p>
	<ul>
		<li>Prior year’s copyright date. This includes a significant upgrade to an existing product. Minor changes to an existing product are not eligible.</li>
		<li>Designed for ages birth to 15.</li>
		<li>Child appropriate content (EC, E or T rated ESRB content).</li>
		<li>Any form of interactive content can be considered. Non interactive (e.g., video content) is not considered.</li>
	</ul>
	<p>First week of December — Deadline for submitting products for KAPi Consideration, although please check with the formal site.</p>
	<p>First week of January — Award winners and finalists announced in public.</p>
</div><!-- /.paragraph left instructions -->
</div><!-- /.hide #award-programs-->

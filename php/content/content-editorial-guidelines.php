<?php
/*
php/content/content-editorial-guidelines.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Editorial Guidelines page
It is included dynamically in 'editorial-guidelines.php' by the file 'php/document.php'
Variable values are defined in the file 'php/settings.php'
*/

// PAGE HEADER, SUBHEADER
if($edGuidelinesHeader != NULL) 	{ echo '<div class = "page-header">'.$edGuidelinesHeader.'</div>'; }
if($edGuidelinesSubheader != NULL) 	{ echo '<div class = "subheader">'.$edGuidelinesSubheader.'</div>'; }

echo '<div class = "paragraph left">';

	// INTRO
	if($edGuidelinesIntroText != NULL) { echo '<p>'.$edGuidelinesIntroText.'</p>'; }
	
	// BIAS
	if($edGuidelinesBiasHeader != NULL) 	{ echo '<p><strong>'.$edGuidelinesBiasHeader.'</strong></p>'; }
	if($edGuidelinesBiasText != NULL) 		{ echo '<p>'.$edGuidelinesBiasText.'</p>'; }
	if($numBiasItems > 0)
	{
		echo '<p><ol>';
		for($i = 0; $i <= $numBiasItems; $i++) { if($edGuidelinesBiasItems[$i] != NULL) { echo '<li>'.$edGuidelinesBiasItems[$i].'</li>'; } }
		echo '</ol></p>';
	} // end if $edGuidelinesBiasItems
	
	// GIFTS
	if($edGuidelinesGiftsHeader != NULL) 	{ echo '<p><strong>'.$edGuidelinesGiftsHeader.'</strong></p>'; }
	if($edGuidelinesGiftsText != NULL) 		{ echo '<p>'.$edGuidelinesGiftsText.'</p>'; }
	if($numGiftsItems > 0)
	{
		echo '<p><ol>';
		for($i = 0; $i <= $numGiftsItems; $i++) { if($edGuidelinesGiftsItems[$i] != NULL) { echo '<li>'.$edGuidelinesGiftsItems[$i].'</li>'; } }
		echo '</ol></p>';
	} // end if $edGuidelinesGiftsItems
	
	// PR
	if($edGuidelinesPRHeader != NULL) 		{ echo '<p><strong>'.$edGuidelinesPRHeader.'</strong></p>'; }
	if($edGuidelinesPRText != NULL) 		{ echo '<p>'.$edGuidelinesPRText.'</p>'; }
	if($numPRItems > 0)
	{
		echo '<p><ol>';
		for($i = 0; $i <= $numPRItems; $i++) { if($edGuidelinesPRItems[$i] != NULL) { echo '<li>'.$edGuidelinesPRItems[$i].'</li>'; } }
		echo '</ol></p>';
	} // end if $edGuidelinesPRItems
	
	// CONSULTING
	if($edGuidelinesConsultingHeader != NULL){ echo '<p><strong>'.$edGuidelinesConsultingHeader.'</strong></p>'; }
	if($edGuidelinesConsultingText != NULL) { echo '<p>'.$edGuidelinesConsultingText.'</p>'; }
	if($numConsultingItems > 0)
	{
		echo '<p><ol>'; 
		for($i = 0; $i <= $numConsultingItems; $i++) { if($edGuidelinesConsultingItems[$i] != NULL) { echo '<li>'.$edGuidelinesConsultingItems[$i].'</li>'; } }
		echo '</ol></p>';
	} // end if $edGuidelinesConsultingItems
	
echo '</div>'; // /.paragraph left
?>

<!-- STATIC VERSION
<div class = "page-header">Editorial Guidelines</div>
<div class = "paragraph left">

	<p>
	In an effort to protect the independent, critical nature of our reviews, Active Learning Associates, Inc., publisher of Children’s Technology Review has established the following set of editorial guidelines.
	</p>
	
	<p><strong>EFFORTS TO MINIMIZE  POTENTIAL SOURCES OF BIAS</strong></p>
	
	<p>
	CTR editors and their immediate families are not permitted to work for or own stock, or have any vested financial interest in any company whose product — software or hardware — could qualify for review. In other words, we don’t own stock in Apple, Microsoft, Google, LeapFrog, Fisher-Price or any other software or technology-related company.
	</p>
	
	<p>
	<strong>More specifically, this means:</strong><br/>
	<ol>
		<li>
		No income from product sales. CTR does not sell or profit from the sales (in any form) of products that are reviewed. This includes links from reviews to ecommerce sites such as Amazon.com. CTR may sell links or banner advertising to a vendor that sells competing products, but may not put itself in a position to profit from the success or failure of any particular product.
		</li>
		<li>No entry fees. There is no cost for submitting a product to CTR.</li>
		<li>
		No award fees or trades. Publishers of products that have earned our “Editor’s Choice” seal are permitted to use it for promotional purposes. These seals can be ordered for the cost of printing, directly from an independent printer. CTR editors have no involvement or knowledge of the use of this seal. This is a transaction between the printer and the publisher.
		</li>
		<li>
		No Fees for endorsements or quotes. If you see a quote from CTR, the publisher did not pay for the placement. Any use of a quote or endorsement must be approved in writing.
		</li>
	</ol>
	</p>
	
	<p>
	GIFTS, PRESS JUNKETS, REVIEW HARDWARE AND OTHER TRADES<br/>
	<ol>
		<li>
		Press Junkets — PR events where transportation and housing costs are paid for must meet the following conditions (1) five or more other journalists from other media outlets must be present at the event, and (2) the event must have direct editorial significance to CTR.
		</li>
		<li>
		Gifts valued at over $50 (not related in some way to the product) will be returned or not accepted, unless it is in some way directly related to the product that is being reviewed (e.g., an electronic drum set or keyboard needed to review a product, is OK, for example). Items of value are donated to the <a href = "http://www.mediatech.org/" target = "_blank">Mediatech Foundation</a>, a public, non-profit community technology center located in Flemington, NJ.
		</li>
		<li>Review copies are treated as press releases, and will be archived for possible reference or product comparison. They will be not copied or sold.</li>
		<li>Hardware or software that is sent for review or testing purposes is donated Mediatech Foundation, a non-profit public community technology center.</li>
	</ol>
	</p>
	
	<p>
	PR ACTIVITIES AND SATELLITE MEDIA TOURS (SMTs)<br/>
	CTR editors do not do SMTs, defined as staged events where specific products are presented who have paid to be mentioned. SMTs are a tool used by the software industry to shape news. Any payment or reimbursement for commentary must come directly from the news media outlet and not a publisher. If you see a CTR reviewer in the news, you can trust that his or her opinions did not come as a result of some prior business transaction.
	</p>

	<p>
	INDUSTRY CONSULTING, SPEAKING AT INDUSTRY EVENTS AND GETTING COMPENSATION IN EXCHANGE FOR FEEDBACK<br/>
	<ol>
		<li>CTR editors are not permitted to consult on product development for compensation.</li>
		<li>Active Learning Associates, Inc., Children’s Technology Review or the name of any CTR staff member may not be listed or acknowledged in credits, documentation or public relations materials without express permission. The name of any CTR staff member may not appear as a member of an advisory board in product or company literature.
		</li>
	</ol>
	</p>
	
</div>
-->
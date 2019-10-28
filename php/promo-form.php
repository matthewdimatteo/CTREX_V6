<!--
php/promo-form.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the promocode entry form
It is included in the file 'php/messages.php'
The values for the submission are defined in the file 'php/get-promocode.php'

The form element with id "promocode-entry-form" and text input element with id "promocode" are referenced by JavaScript functions in 'js/scripts.js'
- enterPromocode() accesses the value of the text field before storing the form container's display state and submitting the form
- enterKeyEnterPromocode() allows the enterPromocode() function to be triggered by the enter key while the user is in the text field

In order to include this file in other places, these element ids and the JS functions that reference them would need to be adjusted
Alternatively, the 'php/messages.php' snippet would need to not include this file

-->
<?php $promocodeFormInstances += 1; ?>

<div class = "promocode-form-container" id = "enter-promocode">

	<!-- FORM -->
	<form name = "promocode-entry-form" 				id = "promocode-entry-form" method = "POST" action = "promo-process.php">
		<div class = "inline">
			<input type = "text" 	name = "promocode" 	id = "promocode" required value = "<?php echo $promocodeEntered;?>" placeholder = "Redeem promotional code..." />
			<input type = "hidden" 	name = "redirect" 	id = "promocode-redirect" value = "<?php echo $thisURL;?>" />
		</div>
		<div class = "inline"><button type = "button" onclick = "enterPromocode()">Enter</button></div>
	</form><!-- /#promocode-entry-form -->

	<!-- FEEDBACK FOR FORM SUBMISSION -->
	<div id = "promocode-submitted" class = "<?php echo $promocodeSubmittedClass;?>">
		<div id = "promocode-feedback" class = "<?php echo $promocodeFeedbackClass;?>"><?php echo $promocodeFeedback;?></div>
		<div id = "promocode-supporter"><?php echo $promocodeSupporter;?></div>
		<div id = "promocode-instructions"><?php echo $promocodeInstructions;?></div>
		<div id = "promocode-items">
			<?php
			// IF CODE IS ACTIVE AND HAS SALE ITEMS, GET THE ITEM INFO AND DISPLAY BTNS TO LINK TO SECURE ORDER FORMS
			if($promocodeStatus == 'Active' and $numPromocodeItems > 0)
			{
				foreach($promocodeItems as $promocodeItem)
				{
					$linkID 	= $promocodeItem[0];
					$btnLabel 	= $promocodeItem[1];	
					$footnote	= $promocodeItem[2];
					echo '<div class = "inline">';
						echo '<form name="PrePage" method="POST" action="https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target="_blank">';
							echo '<input type = "hidden" name = "LinkId" value ="'.$linkID.'" />';
							echo '<input type = "submit" value = "'.$btnLabel.'" title = "Proceed to secure order form"/>';
						echo '</form>';
						echo '<div class = "promo-item-footnote">'.$footnote.'</div>';
					echo '</div>';		
				} // end foreach ($promocodeItems)
			} // end if code is active and authItems != NULL
			?>
		</div><!-- /#promocode-items -->
	</div><!-- /#promocode-submitted -->

</div><!-- /.promocode-form-container -->
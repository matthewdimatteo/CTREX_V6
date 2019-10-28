<!--
php/license-calc-form.php
By Matthew DiMatteo, Children's Technology Review

This file contains the html for the site license cost calculator form
It is included in the files 'php/content/content-license.php' and php/content/content-license-order.php'

The values for a completed cost calculation are accessed in the file 'php/license-calc-get.php'
-->

<!-- COST CALCULATOR FORM -->
<form name = "site-license-cost-calculator" id = "site-license-cost-calculator" method = "POST" action = "license-calc.php">
<input type = "hidden" name = "redirect" id = "license-calc-redirect" value = "<?php echo $thisPage;?>" />
<div class = "row top-20" id = "cost-calculator-header">
	<div class = "inline quarters"></div>
	<div class = "inline quarters bold"># Admins:</div>
	<div class = "inline quarters bold"># Terminals:</div>
	<div class = "inline quarters"></div>
</div><!-- /.row #cost-calculator-header -->
<div class = "row">
	<div class = "inline quarters">
		<div class = "<?php echo $enterClass;?>">Enter:</div>
		<div class = "<?php echo $clearClass;?>"><div class = "btn-text" onclick = "licenseCalcClear()">Clear</div></div>
	</div>
	<div class = "inline quarters"><input type="number" name="num-admins" 	 id="num-admins" 	required	value="<?php echo $numAdmins;?>" /></div>
	<div class = "inline quarters"><input type="number" name="num-terminals" id="num-terminals" required 	value="<?php echo $numTerminals;?>" /></div>
	<div class = "inline quarters"><input type = "submit" name = "submit-cost-calc" id = "submit-cost-calc" value = "<?php echo $calcBtnLabel;?>" /></div>
</div><!-- /.row -->
</form>

<div id = "cost-summary" class = "<?php echo $costSummaryClass;?>">

<div class = "row top-10 bold">
	<div class = "inline quarters"></div>
	<div class = "inline quarters">x $<?php echo $adminRate;?>/ea.</div>
	<div class = "inline quarters">x $<?php echo $terminalRate;?>/ea.</div>
	<div class = "inline quarters" id = "total-cost-header">Total Cost</div>
</div><!-- /.row -->

<div class = "row">
	<div class = "inline quarters"></div>
	<div class = "inline quarters subtotal">$<?php echo $adminCost;?></div>
	<div class = "inline quarters subtotal">$<?php echo $terminalCost;?></div>
	<div class = "inline quarters text-20 total">$<?php echo $totalCost;?></div>
</div><!-- /.row -->

<div class = "row savings">
	<div class = "inline quarters"></div>
	<div class = "inline quarters">($<?php echo $adminSavings;?> savings)</div>
	<div class = "inline quarters">($<?php echo $terminalSavings;?> savings)</div>
	<div class = "inline quarters">($<?php echo $totalSavings;?> savings)</div>
</div><!-- /.row -->

<div class = "<?php echo $customizeBtnClass;?>">
	<div class = "row top-10 center"><button type = "button" onclick = "licenseOrderLoad()">Customize Your Site License >></button></div>
</div><!-- /.$customizeBtnClass -->

</div><!-- #cost-summary -->

<!-- RESET FORM -->
<div class = "hide">
<form name = "license-calc-clear" id = "license-calc-clear" method = "POST" action = "license-calc.php">
	<input type = "hidden" name = "reset" value = "reset" />
	<input type = "hidden" name = "redirect" value = "<?php echo $thisPage;?>" />
</form>
</div>
<?php
$findSub = $fmsubs->newFindCommand($fmsubsLayout);
$findSub->addFindCriterion('ctrexUsername','=='.$inputUsername);
$findSub->addFindCriterion('ctrexPassword','=='.$inputPassword);
$result = $findSub->execute();
?>
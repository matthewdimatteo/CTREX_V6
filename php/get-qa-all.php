<?php
// GET ALL QA
$getQA = $fmqa->newFindCommand($fmqaLayout);
$getQA->addFindCriterion('name', "*");
$getQA->addFindCriterion('active', "*");
$getQA->addSortRule('name', 1, FILEMAKER_SORT_ASCEND);
$qaResult = $getQA->execute();
if (FileMaker::isError ($qaResult) ) { echo $qaResult->getMessage(); exit; }	
$qaSet = $qaResult->getRecords();
$fields = $qaFields;
require 'php/get-qa.php';
?>
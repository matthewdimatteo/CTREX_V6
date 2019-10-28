<?php
/*
php/message-create.php
By Matthew DiMatteo, Children's Technology Review

This file creates a message record in the 'CSR.fmp12' database as notification for form submissions on CTREX
It is included in the file 'php/form-process, as well as certain other 'process' pages that require custom form processing
The variable values for the message parameters should be defined before including this file
*/

// add new record to 'messages' table in 'CSR.fmp12'
$newMessage = $fmmessages->createRecord($fmmessagesLayout);
$newMessage->setField('senderName', $inputName);
$newMessage->setField('senderEmail', $inputEmail);
$newMessage->setField('date', $dateConv);
$newMessage->setField('time', $time);
$newMessage->setField('subject', $emailSubject);
$newMessage->setField('message', $emailMessage);
$enterMessage = $newMessage->commit();
if (FileMaker::isError ($enterMessage) ) { echo $enterMessage->getMessage(); exit(); }
?>
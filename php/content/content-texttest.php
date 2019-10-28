<!--
php/content/content-texttest.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for a page to test database-driven text for web content
The file 'php/settings.php' is configured to query the 'CSR.fmp12' file's 'text' table to get values
The file 'php/dynamic-content.php' is configured to output the content - it can be included in any page's content file
-->

<div id = "texttest-page-container"><?php require_once 'php/dynamic-content.php';?></div><!-- /#text-test-page-container -->
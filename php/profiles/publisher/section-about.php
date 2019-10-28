<!--
php/profiles/publisher/section-about.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'About' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
Note: This tab only displays while in Edit Mode
-->
<div id = "about-info">
	<div class = "paragraph-90 left">
		<p>
		This is your CTREX Publisher Dashboard, a tool for you to manage information associated with your company in our records that appears on your <a href = "<?php echo $previewLink;?>">public profile page</a> visible to CTR subscribers.
		</p>

		<p>
		You can use this dashboard page to update your information and manage what is public. You can also add a company description, provide links to your website and social media pages, and embed a featured video.
		</p>
		<p>If you have any questions, please <a href = "contact.php">contact us</a>.</p>
	</div><!-- .paragrah-90 left -->

	<div class = "center">
		<p>Please Note: This dashboard is private and can be viewed only by you.</p>
		<p><a href = "<?php echo $previewLink;?>">View public profile</a></p>
	</div><!-- /.center -->
</div><!-- /#about-info -->
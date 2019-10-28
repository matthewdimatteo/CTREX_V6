<!--
php/supporter-forms.php
By Matthew DiMatteo, Children's Technology Review

This file displays the buttons for opening the order forms for supporter donations
It is included in the supporters page via 'php/content/content-supporters.php' and the sponsors page via 'php/content/content-sponsors.php'
-->

<!-- BECOME A SUPPORTER -->
<div class = "paragraph-center bottom-10" id = "become-a-supporter">
	<div class = "subheader">Become a Supporter</div>
	All supporters get a <a href = "http://dustormagic.com" target = "_blank" >Dust or Magic</a> fleece vest and are listed below.<br>
    Select any contribution amount to proceed to the secure order form:
</div><!-- /.paragraph center bottom-10 /#become-a-supporter -->

<!-- SUPPORTER FORM BTNS -->
<div class = "paragraph-center" id = "supporter-forms">
    
	<!-- $50 -->
    <div class = "inline left-5 right-5">
        <form name="PrePage" method = "post" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target = "_blank" >
            <input type = "hidden" name = "LinkId" value ="c50632da-ddd8-47a9-955a-d5b2a77c4e86" />
            <input type = "submit" value = "$50" class = "submit-btn"/>
        </form>
    </div><!-- /.inline left-5 right-5 -->
	
    <!-- $100 -->
    <div class = "inline left-5 right-5">
        <form name="PrePage" method = "post" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target = "_blank" >
            <input type = "hidden" name = "LinkId" value ="781176e3-4d49-4480-8d4b-3705353cb404" />
            <input type = "submit" value = "$100" class = "submit-btn"/>
        </form>
    </div><!-- /.inline left-5 right-5 -->
	
    <!-- $200 -->
    <div class = "inline left-5 right-5">
        <form name="PrePage" method = "post" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target = "_blank" >
            <input type = "hidden" name = "LinkId" value ="9d5cab70-f7b5-4df8-b526-7486be187912" />
            <input type = "submit" value = "$200" class = "submit-btn"/>
        </form>
    </div><!-- /.inline left-5 right-5 -->
	
    <!-- $500 -->
    <div class = "inline left-5 right-5">
        <form name="PrePage" method = "post" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target = "_blank" >
            <input type = "hidden" name = "LinkId" value ="09840bcb-3c85-47ec-b571-c418b11d5076" />
            <input type = "submit" value = "$500" class = "submit-btn"/>
        </form>
    </div><!-- /.inline left-5 right-5 -->
	
</div><!-- /.paragraph center /#supporter-forms -->
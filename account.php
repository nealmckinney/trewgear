<!doctype html>
<head>
<title>TREW | stylish and technical ski/snowboard outerwear</title>
<meta name = "Title" content = "TREW | stylish and technical ski/snowboard outerwear"/>
<meta property="og:image" content="http://trewgear.com/resources/images/nav/logo_2013.png"/>
<?php require_once("meta.php"); ?>

<link href="//api.hubsoft.ws/demo/css/checkout.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="resources/css/bootstrap.css">
<link href="resources/css/styles_2013.css" rel="stylesheet" type="text/css"/>

<!-- <link rel="stylesheet" href="resources/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="resources/css/bootstrap-responsive.min.css"> -->
<!-- <link rel="stylesheet" href="resources/css/bootstrap-theme.css"> -->

<script type="text/javascript" src="resources/js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="resources/js/jquery-more.js"></script>
<script type="text/javascript" src="resources/js/modernizr-2.5.3.min.js"></script>


</head>
<body>
<div id="outer">
	<?php require_once("navigation.php");?>
	<div style="background:#fff; min-height:600px;">
		<div class="content" id="accountPage" style="padding-top:100px;">
			
			
			
			<form action="#" class="form-inline modal" id="signInForm" tabindex="-1" role="dialog">
		        <div class="modal-header">
		            <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
		            <h3>Login</h3>
		        </div>
		        <div class="modal-body">
		            <input type="email" id="emailLogin"required class="email" placeholder="email" />
		            <input type="password" id="pwLogin" required class="password" placeholder="password" />
		            <div class="alert alert-error" style="display:none;">
		                <!-- <button type="button" class="close">×</button> -->
		                <span class="message">Credentials are invalid</span>
		            </div>
		        </div>
		        <div class="modal-footer">
		            <!-- <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
		            <button type="submit" class="btn btn-primary">Login</button>
		            <a href="#" class="reset-password pull-left">Reset Password?</a>
		        </div>
		    </form>

		    <form action="#" class="form-inline modal" id="resetPasswordForm" tabindex="-1" role="dialog" style="display:none">
		        <div class="modal-header">
		            <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
		            <h3>Reset Password</h3>
		        </div>
		        <div class="modal-body">
		            <input type="email" required class="email" placeholder="email" />
		            <div class="alert alert-error" style="display:none;">
		                <!-- <button type="button" class="close">×</button> -->
		                <span class="message">Could not find email address</span>
		            </div>
		            <div class="alert alert-success" style="display:none;">
		                <!-- <button type="button" class="close">×</button> -->
		                <span class="message">Check your email for your new password</span>
		            </div>
		        </div>
		        <div class="modal-footer">
		            <!-- <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
		            <button type="submit" class="btn btn-primary">Submit</button>
		        </div>
		    </form>

		    <div class="container">
		        <div class="loggedout">
		            <h1>You are Logged out</h1>
		        </div>
		        <div id="accountContent" class="loggedin"></div>
		    </div>

		    <script id="accountTemplate" type="template">
		        <h1>Welcome, [%=userInfo.firstName%]</h1>
		        <ul class="nav nav-tabs" id="accountTabs">
		            <li class="active"><a href="#promotions">Shop Promotions</a></li>
		            <li><a href="#history">Purchase History</a></li>
		            <li><a href="#password">Change Password</a></li>
		        </ul>

		        <div class="tab-content">
		            <div class="tab-pane active" id="promotions">
		                [% if (!userInfo.availablePromotions || userInfo.availablePromotions.length === 0) { %]
		                    <div>There are no promotions assigned to your account.</div>
		                [% } else {%]
		                    [% for(var i = 0; i < userInfo.availablePromotions.length; i++) { %]
		                       <a href="#" data-promotion="[%=userInfo.availablePromotions[i].promotionCode%]">[%=userInfo.availablePromotions[i].promotionName%]</a><br />
		                    [% } %]
		                [% } %]
		            </div>
		            <div class="tab-pane" id="history">
		                [% if (!userInfo.myOrders || userInfo.myOrders.length === 0) { %]
		                    <div>You have no purchase history.</div>
		                [% } else { %]
		                <table class="order-history table">
		                    <tr>
		                        <th>Order Date</th>
		                        <th>Programs</th>
		                        <th>Order #</th>
		                        <th>Status</th>
		                        <th>Date Shipped</th>
		                    </tr>
		                    [% for(var i = 0; i < userInfo.myOrders.length; i++) { 
		                        var myOrder = userInfo.myOrders[i];
		                    %]
		                        <tr class="quick-info">
		                            <td>[%=myOrder.orderDate%]</td>
		                            <td>[%=myOrder.promotionName%]</td>
		                            <td>[%=myOrder.orderNumber%]</td>
		                            <td>[%=myOrder.orderStatusDesc%]</td>
		                            <td>[%=myOrder.shippedDate%]</td>
		                        </tr>
		                        <tr class="detail">
		                            <td colspan="5">
		                                <div class="slide">
		                                    <table class="order-table" cellspacing="0" cellpadding="0" border="0">
		                                        <caption>Purchased Items</caption>
		                                        [% for(j = 0; j < myOrder.items.length; j++) { 
		                                            var item = myOrder.items[j];
		                                        %]
		                                        <tr>
		                                            <td><div class="img"><img src="[%=item.itemImage%]" /></div></td>
		                                            <td>[%=item.itemSize%] [%=item.itemColor%]</td>
		                                            <td>[%=item.itemName%] [%=item.itemQuantity%]</td>
		                                            <td>[%=item.itemNumber%]</td>
		                                            <td>[%=item.itemTotalPrice.toFixed(2)%]</td>
		                                        </tr>
		                                        [% } %]
		                                        <tr>
		                                            <td colspan="4" align="right">w/ tax &amp; shipping &nbsp;</td>
		                                            <td><b>[%=myOrder.totalOrderedAmount.toFixed(2)%]</b> total</td>
		                                        </tr>
		                                    </table>
		                                    <table class="order-detail" cellspacing="0" cellpadding="0" border="0" width="100%">
		                                        <caption class="header">Order Detail</caption>
		                                        <tr>
		                                            <td valign="top">
		                                                <b>Shipped To:</b><br />
		                                                [%=myOrder.shipToAttention%]<br />
		                                                [%=myOrder.shipToStreet%]<br />
		                                                [%=myOrder.shipToCity%], [%=myOrder.shipToState%] [%=myOrder.shipToZip%]
		                                            </td>
		                                            <td valign="top">
		                                                <b>Tracking Information</b><br />
		                                                Shipped: [%=myOrder.shippingMethodCode%]<br />
		                                                Tracking: [%=emeraldcode.trackingDisplay(myOrder.shippingMethodCode,myOrder.trackingNumber)%]                
		                                            </td>
		                                            <td valign="top">
		                                                <b>Billed To:</b><br />
		                                                zip code $[%=myOrder.billToZip%]
		                                            </td>
		                                        </tr>
		                                    </table>
		                                </div>
		                            </td>
		                        </tr>
		                    [% } %]
		                </table>
		                [% } %]
		            </div>
		            <div class="tab-pane" id="password">
		                <form action="#" method="post" id="changePasswordForm">
		                    <div>
		                        <input type="password" required name="oldPassword" placeholder="old password"><br />
		                        <input type="password" required name="newPassword" placeholder="new password"><br />
		                        <button type="submit" class="btn btn-success">Change Password</button>
		                        <div class="inline">
		                            <div class="alert alert-error" style="display:none;">
		                                <span class="message"></span>
		                            </div>
		                            <div class="alert alert-success " style="display:none;">
		                                <span class="message"></span>
		                            </div>
		                        </div>
		                    </div>
		                </form>
		            </div>
		        </div>
		    </script>
		
			<!-- <script type="text/javascript" src="resources/js/json2.js"></script>
			<script src="//api.hubsoft.ws/js/cartgui.js"></script>
			<script src="//api.hubsoft.ws/js/api.js"></script>
			<script src="//api.hubsoft.ws/js/plugins/ejs.js"></script> -->
			<script src="//api.hubsoft.ws/@js"></script>
			
			<script type="text/javascript" src="resources/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="resources/js/main.js"></script>
			<script type="text/javascript" src="resources/js/account.js"></script>
			
		</div>
	</div>
	<?php require_once("footer.php"); ?>
</div>
</body>
</html>

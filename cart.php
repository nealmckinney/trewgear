<!doctype html>
<head>
<title>TREW | stylish and technical ski/snowboard outerwear</title>
<meta name = "Title" content = "TREW | stylish and technical ski/snowboard outerwear"/>
<meta property="og:image" content="http://trewgear.com/resources/images/nav/logo_2013.png"/>
<?php require_once("meta.php"); ?>

<link href="//api.hubsoft.ws/demo/css/checkout.css" rel="stylesheet" type="text/css"/>
<link href="resources/css/styles_2013.css" rel="stylesheet" type="text/css"/>
<link href="resources/css/styles-responsive.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="resources/js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="resources/js/jquery-more.js"></script>
<script type="text/javascript" src="resources/js/modernizr-2.5.3.min.js"></script>


</head>
<body>
<div id="outer">
	<?php require_once("navigation.php");?>
	<div style="background:#fff; min-height:600px;">
		<div class="content" style="padding-top:100px;">
			
			<!-- this is an EJS JavaScript template but you can use any JavaScript template engine of your choosing -->
			<script id="cartTemplate" type="template">
			    <table id="cart">
			        <tr>
			            <th colspan="2" class="product-detail">product details</th>
			            <th>qty</th>
			            <th>price</th>
			            <th colspan="2" class="subtotal">sub total</th>
			        </tr>
			        [% for(var i = 0; i < items.length; i++) { %]
			            <tr data-sku="[%=items[i].sku%]">
			                <td><img class="cart-image" src="[%=items[i].images[0]%]"></td>
			                <td class="productName">[%=items[i].productName%] - Color: [%=items[i].colorName%] - Size: [%=items[i].sizeName%]</td>
			                <td><input class="qty" type="text" value="[%=items[i].quantity%]" maxlength="2"></td>
			                <td>$[%=items[i].unitPrice.toFixed(2)%]</td>
			                <td>$[%=(items[i].unitPrice * items[i].quantity).toFixed(2)%]</td>
			                <td><button class="close"></button></td>
			            </tr>
			        [% } %]
			        <tr>
			            <td colspan="6" class="subtotal"><strong>Subtotal:</strong> $[%=subtotal.toFixed(2)%]</td>
			        </tr>
			        <tr>
			            <td colspan="6" class="checkout"><a href="https://www.trewgear.com/checkout.php"><button class="checkout">Checkout</button></a></td>
			        </tr>
			    </table>
			    
			</script>
			<div id="no-items" style="display:none;"><h3 style="color:#000;">No Items in Cart</h3></div>
			<div id="cartList"></div>
			
			<!-- this is the required script files to run the demo -->
			<!-- <script type="text/javascript" src="resources/js/json2.js"></script>
			<script src="//api.hubsoft.ws/js/cartgui.js"></script>
			<script src="//api.hubsoft.ws/js/api.js"></script>
			<script src="//api.hubsoft.ws/js/plugins/ejs.js"></script> -->
			<script src="//api.hubsoft.ws/@js"></script>
			
			<script type="text/javascript" src="resources/js/main.js"></script>
			<script src="/resources/js/cart.js"></script>


			<script>   
			    (function (ec) {
			        // resposible for rendering the cart
			        function updateCart() {
						console.log("updateCart");
			            ec.getCartProducts(function (data) {
			                var i, len, html, item;
			                data.subtotal = 0;
							
			                if (data.items) {
			                    for (i = 0, len = data.items.length; i < len; i++) {
			                        item = data.items[i];
									//console.log("item: "+item);
									console.log("item: " + JSON.stringify(item));
			                        data.subtotal += (item.unitPrice * item.quantity);
			                    }
			                    html = new EJS({ element: 'cartTemplate' }).render(data);
			                    $('#cartList').html(html);
			                }
			                if (ec.cart.items.length === 0) {
								var cart = $('#cart');
			                    $('#cart').fadeOut('fast', function () {
			                    });
			                    $('#no-items').fadeIn('fast');
			                }
			            });
			        }

			        // remember to set your client ID
			        ec.clientid = 'trewgear';
			        ec.ready(function () {
			            // wait till emeraldcode object is ready
			            updateCart();
			        });

			        // removes all items from the cart
			        $('body').on('click', '#cart button.close', function (ev) {
			            var $tr = $(this).closest('tr'), sku = $tr.data('sku');
			            ec.cart.remove(sku);
			            $tr.fadeOut('fast', function () {
			                $tr.remove();
			                updateCart();
			            });
			        })
			        // prevents bad cart input on quantity
			        .on('keypress', '#cart input.qty', function (ev) {
			            if (ev.which !== 0 && ev.which !== 8 && (ev.which < 48 || ev.which > 57)) {
			                return false;
			            }
			        })
			        // sets or removes items from the cart based on input quantity        
			        .on('keyup', '#cart input.qty', function (ev) {
			            var val, sku = $(this).closest('tr').data('sku');
			            if (ev.which >= 48 && ev.which <= 57) {
			                val = parseInt($(this).val());
			                if (val === 0) {
			                    ec.cart.remove(sku);
			                } else {
			                    ec.cart.set(sku, val);
			                }
			                updateCart();
			            }
			        })
			        // redraws cart when blur event occurs
			        .on('blur', '#cart input.qty', function (ev) {
			            updateCart();
			        });
			    })(emeraldcode);
			</script>
			<!--  GeoTrust QuickSSL [tm] Smart Icon tag. Do not edit. -->
			<SCRIPT  LANGUAGE="JavaScript" TYPE="text/javascript"  
			SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
			<!-- end  GeoTrust Smart Icon tag -->
		</div>
	</div>
	<?php require_once("footer.php"); ?>
</div>
</body>
</html>

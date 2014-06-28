<!doctype html>
<head>
<title>TREW | stylish and technical ski/snowboard outerwear</title>
<meta name = "Title" content = "TREW | stylish and technical ski/snowboard outerwear"/>
<meta property="og:image" content="http://trewgear.com/resources/images/nav/logo_2013.png"/>
<?php require_once("meta.php"); ?>


<link href="resources/css/checkout.css" rel="stylesheet" type="text/css"/>
<link href="resources/css/styles_2014.css" rel="stylesheet" type="text/css"/>
<link href="resources/css/styles-responsive.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="resources/js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="resources/js/jquery-more.js"></script>
<script type="text/javascript" src="resources/js/modernizr-2.5.3.min.js"></script>

<script type="text/javascript" src="resources/js/core/events/EventDispatcher.js"></script>
<script type="text/javascript" src="resources/js/ui/SelectSkin.js"></script>



</head>
<body>
<div id="outer">
	<?php require_once("navigation.php");?>
	<div style="background:#fff; min-height:600px;">
		<div class="content" style="padding-top:100px;">
			<div class="container" id="cart-page">
			<h1>Place Order</h1>
			<div class="cart-empty-message">
			    Oops, your cart is empty.<br /><br /><a href="/shop">Continue to the shopping page.</a>
			</div>
			
			<div class="right">
			    <div class="header main-header">
			        <span>SUMMARY</span>
			        <a href="./cart.php" class="cart-edit">edit</a>
			    </div>
			    <div class="inner">
			        <div class="sub-total">
			            <div class="label">SUBTOTAL</div>
			            <div class="value"></div>
			            <div style="clear:both"></div>
			        </div>
			        <div class="shipping">
			            <div class="label">SHIPPING</div>
			            <div class="value"></div>
			            <div style="clear:both"></div>
			        </div>
			        <div class="tax">
			            <div class="label">TAX *</div>
			            <div class="value"></div>
			            <div style="clear:both"></div>
			        </div>
			        <div class="total">
			            <div class="label">TOTAL</div>
			            <div class="value"><span></span></div>
			            <div style="clear:both"></div>
			        </div>
			        <div class="cart">
			            <div class="header">IN YOUR CART (<span class="cart-count"></span>)</div>
			            <div class="contents"></div>
			            <div style="clear:both"></div>
			        </div>
					<form action="#" class="form-inline coupon-form">
						<input type="text" name="coupon" required="" placeholder="enter coupon" class="input-small">
					    <button class="btn btn-success">apply</button>
					</form>
			    </div>
			    <div style="clear:both;"></div>
			</div>
			
			<div class="left">
			    <div class="shipping-step step">
			        <div class="compact">
						<div class="number"><span>1</span></div>
			            <div class="title">Shipping</div>
			        </div>
			        <form action="#" method="post">
			            <div class="bg-rag">
			            <div class="header">
			                <div class="number"><span>1</span></div>
			                <div class="title">SHIPPING</div>
			            </div>
						<div class="formWrap">
			            <label>
			                <span class="col1">FIRST NAME *</span>
			                <input type="text" class="entry" required name="firstName" />
			            </label>
			            <label>
			                <span class="col1">LAST NAME *</span>
			                <input type="text" class="entry" required name="lastName" />
			            </label>
			            <label>
			                <span class="col1">Email *</span>
			                <input type="email" class="entry" required name="email" />
			            </label>
			            <label>
			                <span class="col1">Phone *</span>
			                <input type="text" class="entry" required name="phone" />
			            </label>
			            <label class="country-label">
			                <span class="col1">COUNTRY *</span>
			            </label>
			            <div class="visibility-if-country-selected">
			                <label>
			                    <span class="col1">ADDRESS *</span>
			                    <input required type="text" class="entry" name="address" />
			                </label>
			                <label>
			                    <span class="col1"></span>
			                    <input type="text" class="entry" name="address2" />
			                </label>
			                <label>
			                    <span class="col1">CITY *</span>
			                    <input required type="text" class="entry" name="city" />
			                </label>
			                <div class="usa canada">
			                    <label class="state-label">
			                        <span class="usa col1">STATE *</span>
			                        <span class="canada col1">PROVINCE *</span>
			                        <span class="state-placeholder"></span>
			                    </label>
			                </div>
			                <label class="postal-label">
			                    <span class="usa col1">Zip Code *</span>
			                    <span class="non-usa col1">Postal Code *</span>
			                    <input required type="text" class="entry postal-code" name="postalCode" />
			                </label>
			                <label>
			                    <span class="col1">SHIPMENT METHOD *</span>
			                    <select required name="shippingMethod" id="shippingMethod"></select>
			                </label>
			                <label>
			                    <span class="col1">comments</span>
			                    <textarea name="comments" rows="3" cols="60"></textarea>
			                </label>
			                <label>
			                    <span class="col1"></span>
			                    <input type="checkbox" name="additionalInfo" id="additionalInfo" checked="checked" value="1" />
			                    <span  class="checkbox-label"> Sign up to newsletter using this email address</span>
			                </label>
			            </div>
			            <div class="button-container">
			                <button class="checkout">Next Step</button> <span class="error-message"></span>
			                <span class="loading" style="display:none"></span>
			            </div>
						</div><!-- formWrap -->
			            </div>
			        </form>  
			        <div class="report">
			            <div class="bg-rag">
			                <a href="#" class="edit">edit</a>
			                <div class="header">
			                    <div class="number"><span>1</span></div>
			                    <div class="title">Shipping <span class="checkmark"></span></div>  
			                </div>
			                <div class="report-padding">
			                    <div class="floater">
			                        <div class="name"></div>
			                        <div>
			                            <span class="address"></span>
			                        </div>
			                        <div class="city-state-postal"></div>
			                        <div class="contact">
			                            <div class="phone"></div>
			                            <div class="email"></div>
			                        </div>
			                    </div>
			                    <div class="floater shipping-info">
			                        <span class="shipping-method"></span>
			                        <div class="comments"></div>
			                    </div>
			                    <div style="clear:both"></div>
			                </div>
			            </div>
			        </div>
			    </div>
			    <div class="payment-step step">
			        <div class="compact">
			            <div class="number"><span>2</span></div>
			            <div class="title">Payment</div>
			        </div>
			        <form action="#" method="post">
			            <div class="bg-rag">
			            <input type="hidden" name="orderNumber" />
			            <div class="header">
			                <div class="number"><span>2</span></div>
			                <div class="title">Payment</div>
			            </div>
						<div class="formWrap">
			            <label>
			                <span class="col1">Card <br />Number *</span>
			                <input type="text" required class="entry numbers-only" name="cardNumber" method="emeraldcode.validationMethods.validateCCNumber" />
			            </label>
			            <label>
			                <span class="col1">Security Code *</span>
			                <input type="text" required class="entry security-code numbers-only" name="securityCode" maxlength="4" />
			            </label>
			            <div class="expire-label label">
			                <span class="col1">Expires *</span>
			                <select required name="month" id="month">
			                    <option value="">Month</option>
			                    <option value="1">(1) Jan</option>
			                    <option value="2">(2) Feb</option>
			                    <option value="3">(3) Mar</option>
			                    <option value="4">(4) Apr</option>
			                    <option value="5">(5) May</option>
			                    <option value="6">(6) Jun</option>
			                    <option value="7">(7) Jul</option>
			                    <option value="8">(8) Aug</option>
			                    <option value="9">(9) Sep</option>
			                    <option value="10">(10) Oct</option>
			                    <option value="11">(11) Nov</option>
			                    <option value="12">(12) Dec</option>
			                </select>
			                <select required name="year" id="year"></select>
			            </div>
			            <label>
			                <span class="col1 card-type-label">Card Type</span>
			                <span class="card-container">
			                    <span class="card card-vi" data-card-name="Visa"></span>
			                    <span class="card card-mc" data-card-name="Master Card"></span>
			                    <span class="card card-ax" data-card-name="American Express"></span>
			                    <span class="card card-dr" data-card-name="Discover"></span>
			                </span>
			            </label>
			            <label class="copy-shipping-label">
			                <span class="col1"></span>
			                <span class="checkbox-label"><input type="checkbox" name="copyShipping" /> copy from shipping info</span>
			            </label>
			            <label>
			                <span class="col1">FIRST NAME *</span>
			                <input required class="entry" type="text" name="firstName" />
			            </label>
			            <label>
			                <span class="col1">LAST NAME *</span>
			                <input required class="entry" type="text" name="lastName" />
			            </label>
			            <label>
			                <span class="col1">EMAIL *</span>
			                <input required class="entry" type="email" name="email" />
			            </label>
			            <label>
			                <span class="col1">PHONE *</span>
			                <input required class="entry" type="text" name="phone" />
			            </label>
			            <label class="country-label">
			                <span required class="col1">COUNTRY *</span>
			            </label>
			            <div class="visibility-if-country-selected">
			                <label>
			                    <span class="col1">ADDRESS *</span>
			                    <input required type="text" class="entry" name="address" />
			                </label>
			                <label>
			                    <span class="col1"></span>
			                    <input type="text" class="entry" name="address2" />
			                </label>
			                <label>
			                    <span class="col1">CITY *</span>
			                    <input required type="text" class="entry" name="city" />
			                </label>
			                <div class="usa canada">
			                    <label class="state-label">
			                        <span class="usa col1">STATE *</span>
			                        <span class="canada non-usa col1">PROVINCE *</span>
			                        <span class="state-placeholder"></span>
			                    </label>
			                </div>
			                <label class="postal-label">
			                    <span class="usa col1">Zip Code *</span>
			                    <span class="non-usa col1">Postal Code *</span>
			                    <input type="text" class="entry postal-code" name="postalCode" />
			                </label>
			            </div>
			            <div class="button-container">
			                <button class="checkout">Next Step</button> <span class="error-message"></span>
			                <span class="loading" style="display:none"></span>
			            </div>
			            </div>
						</div>
			        </form>  
			        <div class="report">
			            <div class="bg-rag">
			                <a href="#" class="edit"><span>edit</span></a>
			                <div class="header">
			                    <div class="number"><span>2</span></div>
			                    <div class="title">Payment <span class="checkmark"></span></div>
			                </div>
			                <div class="report-padding">
			                    <div class="floater">
			                        <div class="name"></div>
			                        <div>
			                            <span class="address"></span>
			                        </div>
			                        <div class="city-state-postal"></div>
			                        <div class="contact">
			                            <div class="phone"></div>
			                            <div class="email"></div>
			                        </div>
			                    </div>
			                    <div class="floater card-info">
			                        <div class="card-number"></div>
			                        <div>
			                            expires <span class="month"></span> / <span class="year"></span>
			                        </div>  
			                    </div>
			                    <div style="clear:both"></div>
			                </div>
			            </div>
			        </div>
			    </div>
			    <div class="review-step step">
			        <div class="compact">
			            <div class="number"><span>3</span></div>
			            <div class="title">Order Review</div>
			        </div>
			        <form action="#" method="post">
			            <div class="header">
			                <div class="number"><span>3</span></div>
			                <div class="title">Review and Submit Your Order</div>
			            </div>
			            <div class="disclaimer">
			                By clicking the 'Place Order' button, you confirm that you have
			                read, understood and accept our Terms and Conditions, Return
			                Policy and Privacy Policy.
			            </div>
			            <div class="error-message"></div>
			            <div class="button-container" style="margin-left:65px;">
			                <button class="checkout">Place Order</button>
			                <span class="loading" style="display:none"></span>
			            </div>
			        </form>
			    </div>
			    <div class="receipt">
			        <div style="clear:both"></div>
			        <div class="thank-you section">
			            <div class="bg-rag">
			                <div class="big">Thank You<span class="exclamation">!</span></div>
			                <div class="blurb">Your order was placed successfully. Check your email for your order confirmation.</div>
			            </div>
			        </div>
			        <div class="order-meta section">
			            <div class="bg-rag">
			                <div class="entry">
			                    <div class="label">YOUR ORDER #:</div>
			                    <div class="value order-number"></div>
			                </div>
			                <div class="entry">
			                    <div class="label">ORDER DATE/TIME:</div>
			                    <div class="value date-time"></div>
			                </div>
			                <div style="clear:both"></div>
			            </div>
			        </div>
			        <div class="shipping section">
			            <div class="bg-rag">
			                <div class="header">SHIPPING</div>
			                <div class="contents"></div>
			                <div style="clear:both"></div>
			            </div>
			        </div>
			        <div class="payment section">
			            <div class="bg-rag">
			                <div class="header">PAYMENT</div>
			                <div class="contents"></div>
			                <div style="clear:both"></div>
			            </div>
			        </div>
			        <div class="cart section">
			            <div class="bg-rag">
			                <div class="header">SHOPPING CART</div>
			                <div class="contents"></div>
			            </div>
			        </div>
			        <div class="summary section">
			            <div class="bg-rag">
			                <div class="header">SUMMARY</div>
			                <div class="line"></div>
			                <div class="entry sub-total">
			                    <div class="label">SUBTOTAL</div>
			                    <div class="value"></div>
			                </div>
			                <div style="clear:both"></div>
			                <div class="entry shipping">
			                    <div class="label">SHIPPING &amp; HANDLING</div>
			                    <div class="value"></div>
			                </div>
			                <div style="clear:both"></div>
			                <div class="entry tax">
			                    <div class="label">TAX</div>
			                    <div class="value"></div>
			                </div>
			                <div style="clear:both"></div>
			                <div class="entry total">
			                    <div class="label">TOTAL</div>
			                    <div class="value"></div>
			                </div>
			                <div style="clear:both"></div>
			            </div>
			        </div>
			        <div style="clear:both"></div>
			        <div class="print-it"><span>Print It</span></div>
			        <div style="clear:both"></div>
			    </div>
			    <div class="secure">
			        <div class="line"></div>
			        <div class="checkout-secure-icons">

			        </div>
			    </div>
			    <div class=""></div>
			</div>
			
			<div style="clear:both;"></div>
		</div>

			<script id="country-template" type="text/html">
			<select name="country" id="country">
			    <option value="">Select Country</option>
			    <option value="AF">Afghanistan</option>
			    <option value="AX">&Aring;land Islands</option>
			    <option value="AL">Albania</option>
			    <option value="DZ">Algeria</option>
			    <option value="AS">American Samoa</option>
			    <option value="AD">Andorra</option>
			    <option value="AO">Angola</option>
			    <option value="AI">Anguilla</option>
			    <option value="AQ">Antarctica</option>
			    <option value="AG">Antigua and Barbuda</option>
			    <option value="AR">Argentina</option>
			    <option value="AM">Armenia</option>
			    <option value="AW">Aruba</option>
			    <option value="AU">Australia</option>
			    <option value="AT">Austria</option>
			    <option value="AZ">Azerbaijan</option>
			    <option value="BS">Bahamas</option>
			    <option value="BH">Bahrain</option>
			    <option value="BD">Bangladesh</option>
			    <option value="BB">Barbados</option>
			    <option value="BY">Belarus</option>
			    <option value="BE">Belgium</option>
			    <option value="BZ">Belize</option>
			    <option value="BJ">Benin</option>
			    <option value="BM">Bermuda</option>
			    <option value="BT">Bhutan</option>
			    <option value="BO">Bolivia, Plurinational State of</option>
			    <option value="BA">Bosnia and Herzegovina</option>
			    <option value="BW">Botswana</option>
			    <option value="BV">Bouvet Island</option>
			    <option value="BR">Brazil</option>
			    <option value="IO">British Indian Ocean Territory</option>
			    <option value="BN">Brunei Darussalam</option>
			    <option value="BG">Bulgaria</option>
			    <option value="BF">Burkina Faso</option>
			    <option value="BI">Burundi</option>
			    <option value="KH">Cambodia</option>
			    <option value="CM">Cameroon</option>
			    <option value="CA">Canada</option>
			    <option value="CV">Cape Verde</option>
			    <option value="KY">Cayman Islands</option>
			    <option value="CF">Central African Republic</option>
			    <option value="TD">Chad</option>
			    <option value="CL">Chile</option>
			    <option value="CN">China</option>
			    <option value="CX">Christmas Island</option>
			    <option value="CC">Cocos (Keeling) Islands</option>
			    <option value="CO">Colombia</option>
			    <option value="KM">Comoros</option>
			    <option value="CG">Congo</option>
			    <option value="CD">Congo, the Democratic Republic of the</option>
			    <option value="CK">Cook Islands</option>
			    <option value="CR">Costa Rica</option>
			    <option value="CI">C&ocirc;te &#39;Ivoire</option>
			    <option value="HR">Croatia</option>
			    <option value="CU">Cuba</option>
			    <option value="CY">Cyprus</option>
			    <option value="CZ">Czech Republic</option>
			    <option value="DK">Denmark</option>
			    <option value="DJ">Djibouti</option>
			    <option value="DM">Dominica</option>
			    <option value="DO">Dominican Republic</option>
			    <option value="EC">Ecuador</option>
			    <option value="EG">Egypt</option>
			    <option value="SV">El Salvador</option>
			    <option value="GQ">Equatorial Guinea</option>
			    <option value="ER">Eritrea</option>
			    <option value="EE">Estonia</option>
			    <option value="ET">Ethiopia</option>
			    <option value="FK">Falkland Islands (Malvinas)</option>
			    <option value="FO">Faroe Islands</option>
			    <option value="FJ">Fiji</option>
			    <option value="FI">Finland</option>
			    <option value="FR">France</option>
			    <option value="GF">French Guiana</option>
			    <option value="PF">French Polynesia</option>
			    <option value="TF">French Southern Territories</option>
			    <option value="GA">Gabon</option>
			    <option value="GM">Gambia</option>
			    <option value="GE">Georgia</option>
			    <option value="DE">Germany</option>
			    <option value="GH">Ghana</option>
			    <option value="GI">Gibraltar</option>
			    <option value="GR">Greece</option>
			    <option value="GL">Greenland</option>
			    <option value="GD">Grenada</option>
			    <option value="GP">Guadeloupe</option>
			    <option value="GU">Guam</option>
			    <option value="GT">Guatemala</option>
			    <option value="GG">Guernsey</option>
			    <option value="GN">Guinea</option>
			    <option value="GW">Guinea-Bissau</option>
			    <option value="GY">Guyana</option>
			    <option value="HT">Haiti</option>
			    <option value="HM">Heard Island and McDonald Islands</option>
			    <option value="VA">Holy See (Vatican City State)</option>
			    <option value="HN">Honduras</option>
			    <option value="HK">Hong Kong</option>
			    <option value="HU">Hungary</option>
			    <option value="IS">Iceland</option>
			    <option value="IN">India</option>
			    <option value="ID">Indonesia</option>
			    <option value="IR">Iran, Islamic Republic of</option>
			    <option value="IQ">Iraq</option>
			    <option value="IE">Ireland</option>
			    <option value="IM">Isle of Man</option>
			    <option value="IL">Israel</option>
			    <option value="IT">Italy</option>
			    <option value="JM">Jamaica</option>
			    <option value="JP">Japan</option>
			    <option value="JE">Jersey</option>
			    <option value="JO">Jordan</option>
			    <option value="KZ">Kazakhstan</option>
			    <option value="KE">Kenya</option>
			    <option value="KI">Kiribati</option>
			    <option value="KP">Korea, Democratic People&#39;s Republic of</option>
			    <option value="KR">Korea, Republic of</option>
			    <option value="KW">Kuwait</option>
			    <option value="KG">Kyrgyzstan</option>
			    <option value="LA">Lao People&#39;s Democratic Republic</option>
			    <option value="LV">Latvia</option>
			    <option value="LB">Lebanon</option>
			    <option value="LS">Lesotho</option>
			    <option value="LR">Liberia</option>
			    <option value="LY">Libyan Arab Jamahiriya</option>
			    <option value="LI">Liechtenstein</option>
			    <option value="LT">Lithuania</option>
			    <option value="LU">Luxembourg</option>
			    <option value="MO">Macao</option>
			    <option value="MK">Macedonia, the former Yugoslav Republic of</option>
			    <option value="MG">Madagascar</option>
			    <option value="MW">Malawi</option>
			    <option value="MY">Malaysia</option>
			    <option value="MV">Maldives</option>
			    <option value="ML">Mali</option>
			    <option value="MT">Malta</option>
			    <option value="MH">Marshall Islands</option>
			    <option value="MQ">Martinique</option>
			    <option value="MR">Mauritania</option>
			    <option value="MU">Mauritius</option>
			    <option value="YT">Mayotte</option>
			    <option value="MX">Mexico</option>
			    <option value="FM">Micronesia, Federated States of</option>
			    <option value="MD">Moldova, Republic of</option>
			    <option value="MC">Monaco</option>
			    <option value="MN">Mongolia</option>
			    <option value="ME">Montenegro</option>
			    <option value="MS">Montserrat</option>
			    <option value="MA">Morocco</option>
			    <option value="MZ">Mozambique</option>
			    <option value="MM">Myanmar</option>
			    <option value="NA">Namibia</option>
			    <option value="NR">Nauru</option>
			    <option value="NP">Nepal</option>
			    <option value="NL">Netherlands</option>
			    <option value="AN">Netherlands Antilles</option>
			    <option value="NC">New Caledonia</option>
			    <option value="NZ">New Zealand</option>
			    <option value="NI">Nicaragua</option>
			    <option value="NE">Niger</option>
			    <option value="NG">Nigeria</option>
			    <option value="NU">Niue</option>
			    <option value="NF">Norfolk Island</option>
			    <option value="MP">Northern Mariana Islands</option>
			    <option value="NO">Norway</option>
			    <option value="OM">Oman</option>
			    <option value="PK">Pakistan</option>
			    <option value="PW">Palau</option>
			    <option value="PS">Palestinian Territory, Occupied</option>
			    <option value="PA">Panama</option>
			    <option value="PG">Papua New Guinea</option>
			    <option value="PY">Paraguay</option>
			    <option value="PE">Peru</option>
			    <option value="PH">Philippines</option>
			    <option value="PN">Pitcairn</option>
			    <option value="PL">Poland</option>
			    <option value="PT">Portugal</option>
			    <option value="PR">Puerto Rico</option>
			    <option value="QA">Qatar</option>
			    <option value="RE">R&eacute;union</option>
			    <option value="RO">Romania</option>
			    <option value="RU">Russian Federation</option>
			    <option value="RW">Rwanda</option>
			    <option value="BL">Saint Barth&eacute;lemy</option>
			    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
			    <option value="KN">Saint Kitts and Nevis</option>
			    <option value="LC">Saint Lucia</option>
			    <option value="MF">Saint Martin (French part)</option>
			    <option value="PM">Saint Pierre and Miquelon</option>
			    <option value="VC">Saint Vincent and the Grenadines</option>
			    <option value="WS">Samoa</option>
			    <option value="SM">San Marino</option>
			    <option value="ST">Sao Tome and Principe</option>
			    <option value="SA">Saudi Arabia</option>
			    <option value="SN">Senegal</option>
			    <option value="RS">Serbia</option>
			    <option value="SC">Seychelles</option>
			    <option value="SL">Sierra Leone</option>
			    <option value="SG">Singapore</option>
			    <option value="SK">Slovakia</option>
			    <option value="SI">Slovenia</option>
			    <option value="SB">Solomon Islands</option>
			    <option value="SO">Somalia</option>
			    <option value="ZA">South Africa</option>
			    <option value="GS">South Georgia and the South Sandwich Islands</option>
			    <option value="ES">Spain</option>
			    <option value="LK">Sri Lanka</option>
			    <option value="SD">Sudan</option>
			    <option value="SR">Suriname</option>
			    <option value="SJ">Svalbard and Jan Mayen</option>
			    <option value="SZ">Swaziland</option>
			    <option value="SE">Sweden</option>
			    <option value="CH">Switzerland</option>
			    <option value="SY">Syrian Arab Republic</option>
			    <option value="TW">Taiwan, Province of China</option>
			    <option value="TJ">Tajikistan</option>
			    <option value="TZ">Tanzania, United Republic of</option>
			    <option value="TH">Thailand</option>
			    <option value="TL">Timor-Leste</option>
			    <option value="TG">Togo</option>
			    <option value="TK">Tokelau</option>
			    <option value="TO">Tonga</option>
			    <option value="TT">Trinidad and Tobago</option>
			    <option value="TN">Tunisia</option>
			    <option value="TR">Turkey</option>
			    <option value="TM">Turkmenistan</option>
			    <option value="TC">Turks and Caicos Islands</option>
			    <option value="TV">Tuvalu</option>
			    <option value="UG">Uganda</option>
			    <option value="UA">Ukraine</option>
			    <option value="AE">United Arab Emirates</option>
			    <option value="GB">United Kingdom</option>
			    <option value="US">United States</option>
			    <option value="UM">United States Minor Outlying Islands</option>
			    <option value="UY">Uruguay</option>
			    <option value="UZ">Uzbekistan</option>
			    <option value="VU">Vanuatu</option>
			    <option value="VE">Venezuela, Bolivarian Republic of</option>
			    <option value="VN">Viet Nam</option>
			    <option value="VG">Virgin Islands, British</option>
			    <option value="VI">Virgin Islands, U.S.</option>
			    <option value="WF">Wallis and Futuna</option>
			    <option value="EH">Western Sahara</option>
			    <option value="YE">Yemen</option>
			    <option value="ZM">Zambia</option>
			    <option value="ZW">Zimbabwe</option>
			</select>
			</script>
			<script type="text/html" id="canada-states-template">
			    <select name="state" id="state">
			        <option value="">SELECT</option>
			        <option value="AB">Alberta</option>
			        <option value="BC">British Columbia</option>
			        <option value="MB">Manitoba</option>
			        <option value="NU">Nunavut</option>
			        <option value="NB">New Brunswick</option>
			        <option value="NL">Newfoundland and Labrador</option>
			        <option value="NT">Northwest Territories</option>
			        <option value="NS">Nova Scotia</option>
			        <option value="ON">Ontario</option>
			        <option value="PE">Prince Edward Island</option>
			        <option value="QC">Quebec</option>
			        <option value="SK">Saskatchewan</option>
			        <option value="YT">Yukon</option>
			    </select>
			</script>
			<script type="text/html" id="usa-states-template">
			<select name="state" id="state">
			    <option value="">SELECT</option>
			    <option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">Dist of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			    <option value="AS">American Samoa</option>
			    <option value="GU">Guam</option>
			    <option value="PR">Puerto Rico</option>
			    <option value="VI">Virgin Islands</option>
			    <option value="AA">Armed Forces Americas</option>
			    <option value="AE">Armed Forces Europe</option>
			    <option value="AP">Armed Forces Pacific</option>
			</select>
			</script>
			<script id="cart-item-template" type="text/html">
			    <div class="item">
			        <img class="thumb" />
			        <div class="name"></div>
			        <div class="attribute">
			            <span class="label">SIZE:</span>
			            <span class="value size"></span>
			        </div>
			        <div class="attribute">
			            <span class="label">COLOR:</span>
			            <span class="value color"></span>
			        </div>
			        <div class="attribute">
			            <span class="label">QTY:</span>
			            <span class="value qty"></span>
			        </div>
			        <div class="total"></div>
			        <div style="clear:both"></div>
			    </div>
			</script>
			
			<script src="resources/js/terse.js"></script>
	        <script>
	            terse('emeraldcode')
	                .prop('thumbNailImageIndex', 0)
	                .obj('global').prop('googleAnalytics', '')
	                .end()
	                .obj('page')
	                    .prop('messages', {});
	            emeraldcode.clientid = 'trewgear';
	        </script>
	
	        <!-- <script type="text/javascript" src="resources/js/json2.js"></script>
	        <script src="//api.hubsoft.ws/js/cartgui.js"></script>
	        <script src="//api.hubsoft.ws/js/api.js"></script> -->
	        <script src="//api.hubsoft.ws/@js"></script>
	
	        <script src="//api.hubsoft.ws/js/plugins/jquery.dumbfix.1.0.js"></script>
	        <script src="//api.hubsoft.ws/js/plugins/jquery.dumbformstate.js"></script>
	        <script src="//api.hubsoft.ws/js/plugins/jquery.dumbvalidation.js"></script>
	        <script src="//api.hubsoft.ws/js/validation-methods.js"></script>
			<script type="text/javascript" src="resources/js/main.js"></script>
	        <script src="resources/js/checkout_v1.1.js"></script>
	
			<script>
			
			// function initSelects() {
			// 	var selects = $(document).find(".select-skin");
			// 	for (var i=0; i < selects.length; i++) {
			// 		var select = new SelectSkin($(selects[i]));
			// 	};
			// 	var select = new SelectSkin($("#state"));
			// }
			
			
			$(document).ready(function() {
				
			});
			(function (ec) { // "ec" shortcut for "emeraldcode"
			    ec.ready(function () {
			       console.log("ec.ready");
					//setTimeout(initSelects, 1000);
			    });
			})(emeraldcode);
			</script>
			<p class="note" style="margin-left:10px;">For International Shipments, TREW reserves the right to alter shipping charges to reflect actual costs of shipping</p>
			<div style="margin-left:10px;">
				<!--  GeoTrust QuickSSL [tm] Smart Icon tag. Do not edit. -->
				<SCRIPT  LANGUAGE="JavaScript" TYPE="text/javascript"  
				SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
				<!-- end  GeoTrust Smart Icon tag -->
			</div>
			
		</div>
		
	</div>
	
	<?php
	$isCheckout = true;
	require_once("footer.php"); 
	?>
</div>
</body>
</html>

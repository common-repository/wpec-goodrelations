<?php
function gr_edit_product_form_show($product_data) {
	global $devmode, $gr_setup;
	if ($devmode) echo print_r($product_data, true);
	?>

	<div style="text-align:right;">
	<input type="checkbox" name="productmeta_values[gr_no_annotation][checkbox]" id="gr_annotation_form_checkbox" value="1" onclick="if(document.getElementById('gr_annotation_form_checkbox').checked == 1) {document.getElementById('gr_annotation_form').style.display = 'none'; document.getElementById('gr_add_annotation').style.display = 'none'; document.getElementById('gr_dont_add_annotation').style.display = '';} else {document.getElementById('gr_annotation_form').style.display = '';document.getElementById('gr_add_annotation').style.display = ''; document.getElementById('gr_dont_add_annotation').style.display = 'none';}"<?php if($product_data['gr_no_annotation']['checkbox'] == 1) echo "checked"; ?> /> 
	Don't add GoodRelations annotation for this product.
</div>
<br />
<br />
<strong>
	Add GoodRelations annotation to <span id='gr_add_annotation' <?php if($product_data['gr_no_annotation']['checkbox'] == 1) echo "style='display:none'"; ?>>this</span><span id='gr_dont_add_annotation' <?php if($product_data['gr_no_annotation']['checkbox'] != 1) echo "style='display:none'"; ?>>each</span> product!
</strong>
<br />
<div id="product_master" class="gr_field" >

<table id="gr_annotation_form" <?php if($product_data['gr_no_annotation']['checkbox'] == 1) echo "style='display:none'"; ?>>
	<tbody>
		<tr>
			<td>
				<strong><span title="European Article Number" class="tooltip">EAN</span> / <span title="Universal Product Code" class="tooltip">UPC</span> / <span title="Japanese Article Number" class="tooltip">JAN</span> / <span title="International Standard Book Number" class="tooltip">ISBN</span>: </strong>
			</td>
			<td>
				<input name="productmeta_values[gr_ean]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_ean']; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<strong><span title="Global Trade Item Number" class="tooltip">GTIN-14</span>:</strong>
			</td>
			<td>
				<input name="productmeta_values[gr_gtin14]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_gtin14']; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<strong>Manufacturers Part Number (MPN):</strong>
				
			</td>
			<td>
				<input name="productmeta_values[gr_mpn]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_mpn']; ?>">
			</td>
		</tr>
		<tr id='serialnumber_row' <?php if($gr_setup['gr_field']['serialnumber'] == '1') { echo ''; } else { echo 'style="display:none"'; } ?>>
			<td>
				<strong>Serial number:</strong>
				
			</td>
			<td>
				<input name="productmeta_values[gr_serialnumber]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_serialnumber']; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<strong>Color:</strong><span style="color:gray;text-decoration:none"> e.g. 'blue'</span>
				
			</td>
			<td>
				<input name="productmeta_values[gr_color]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_color']; ?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<br />
				<strong>Offering and price validity:</strong>
				<br />
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][gr_validity]" id="globals_gr_validity" value="1" onclick="if(document.getElementById('globals_gr_validity').checked == 1) {document.getElementById('gr_validity').style.display = 'none';} else {document.getElementById('gr_validity').style.display = '';}"<?php if($product_data['gr_globals']['gr_validity'] == 1) echo "checked"; ?> /> 
				apply global validity settings
				<br /><br />
			</td>
		</tr>
		<tr id="gr_validity" <?php if($product_data['gr_globals']['gr_validity'] == 1) echo "style='display:none'"; ?>>
			<td colspan="2">
				<table width="100%">
					<thead>
						<tr>
							<td width="50%">
								<a href="http://purl.org/goodrelations/v1#validThrough" target="_new">Offering validity:</a>
							</td>
							<td width="50%">
								<a href="http://purl.org/goodrelations/v1#validThrough" target="_new">Price validity:</a>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select name="productmeta_values[gr_product_validThrough_days]" style="width:100px" onchange="document.getElementById('gr_product_validThrough_field').value=this.options[this.selectedIndex].value; document.getElementById('gr_product_validThrough_field').disabled=this.selectedIndex!=0">
										<option value="">select ...</option>
										<option value="1">1 Day</option>
										<option value="7">1 Week ( 7 days )</option>
										<option value="30">1 Month( 30 days )</option>
										<option value="365">1 Year ( 365 days )</option>
								</select>
								&nbsp;&nbsp;
								<input style="width:80px" name="productmeta_values[gr_product_validThrough_days]" id="gr_product_validThrough_field" type="text" title="you may enter a range of days which is not in the list" value="<?php echo $product_data['gr_product_validThrough_days']; ?>" />
								day(s)
							</td>
							<td>
								<select name="productmeta_values[gr_price_validThrough_days]" style="width:100px" onchange="document.getElementById('gr_price_validThrough_field').value=this.options[this.selectedIndex].value; document.getElementById('gr_price_validThrough_field').disabled=this.selectedIndex!=0">
										<option value="">select ...</option>
										<option value="1">1 Day</option>
										<option value="7">1 Week ( 7 days )</option>
										<option value="30">1 Month( 30 days )</option>
										<option value="365">1 Year ( 365 days )</option>
								</select>
								&nbsp;&nbsp;
								<input style="width:80px" name="productmeta_values[gr_price_validThrough_days]" id="gr_price_validThrough_field" type="text" title="you may enter a range of days which is not in the list" value="<?php echo $product_data['gr_price_validThrough_days']; ?>" />
								day(s)
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#condition" target="_new">Condition</a> </strong><span style="color:gray;text-decoration:none"> (by default: 'new')</span>
			</td>
		</tr>
		<tr>
			<td>
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" onclick="if(document.getElementById('globals_gr_condition').checked == 1) {document.getElementById('gr_condition').style.display = 'none';} else {document.getElementById('gr_condition').style.display = '';}" id="globals_gr_condition" name="productmeta_values[gr_globals][gr_condition]" value="1" <?php if($product_data['gr_globals']['gr_condition'] == 1) echo "checked"; ?> /> 
				apply global condition settings
				<br/>
				<br />
			</td>
			<td id="gr_condition" <?php if($product_data['gr_globals']['gr_condition'] == 1) echo "style='display:none'"; ?> >
				<input name="productmeta_values[gr_condition]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_condition']; ?>">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong>Language of the product description:</strong>
			</td>
		</tr>
		<tr>
			<td>
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][gr_language]" id="globals_gr_language" onclick="if(document.getElementById('globals_gr_language').checked == 1) {document.getElementById('gr_language').style.display = 'none';} else {document.getElementById('gr_language').style.display = '';}" value="1" <?php if($product_data['gr_globals']['gr_language']) echo "checked"; ?> /> 
				apply global language settings
				<br />
				<br />
			</td>
			<td id="gr_language" <?php if($product_data['gr_globals']['gr_language']) echo "style='display:none'"; ?>>
				<select name="productmeta_values[gr_language]" style="width:100px" onchange="document.getElementById('gr_language_field').value=this.options[this.selectedIndex].value; document.getElementById('gr_language_field').disabled=this.selectedIndex!=0">
					<option value="">select ...</option>
					<option value="de">de</option>
					<option value="en">en</option>
					<option value="es">es</option>
					<option value="fr">fr</option>
					<option value="it">it</option>
				</select>
				&nbsp;&nbsp;
				<input style="width:80px" name="productmeta_values[gr_language]" id="gr_language_field" type="text" title="you may enter a custom language code that is not defined in the list" value="<?php echo $product_data['gr_language']; ?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#WarrantyPromise" target="_new">Warranty Settings</a>:</strong>
				<br />
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][warranty]" id="globals_warranty" value="1" onclick="if(document.getElementById('globals_warranty').checked == 1) {document.getElementById('gr_warranty').style.display = 'none';} else {document.getElementById('gr_warranty').style.display = '';}"<?php if($product_data['gr_globals']['warranty'] == 1) echo "checked"; ?> /> 
				apply global warranty settings
				<br />
				<br />
			</td>
		</tr>
		<tr id="gr_warranty" <?php if($product_data['gr_globals']['warranty'] == 1) echo "style='display:none'"; ?> >
			<td colspan="2" >
				<strong>&nbsp;give duration in months </strong>
				<br />
				<table width="100%">
					<colgroup>
						<col width="33%">
						<col width="33%">
						<col width="33%">
					</colgroup>
					<tbody>
						<tr>
							<td>
								<a href="http://purl.org/goodrelations/v1#Labor-BringIn" target="_new">labor - bring in</a>
							</td>
							<td>
								<a href="http://purl.org/goodrelations/v1#PartsAndLabor-BringIn" target="_new">parts and labor - bring in</a>
							</td>
							<td>
								<a href="http://purl.org/goodrelations/v1#PartsAndLabor-PickUp" target="_new">parts and labor - pick up</a>
							</td>
						</tr>
						<tr>
							<td>
								<input  name="productmeta_values[gr_Labor-BringIn]" type="text" size="15" maxlength="30" value="<?php echo $product_data['gr_Labor-BringIn']; ?>" /> <br />
							</td>
							<td>
								<input name="productmeta_values[gr_PartsAndLabor-BringIn]" type="text" size="15" maxlength="30" value="<?php echo $product_data['gr_PartsAndLabor-BringIn']; ?>" /><br />
							</td>
							<td>
								<input name="productmeta_values[gr_PartsAndLabor-Pickup]" type="text" size="15" maxlength="30" value="<?php echo $product_data['gr_PartsAndLabor-Pickup']; ?>" /><br />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#hasUnitOfMeasurement" target="_new">Unit of measurement</a>:</strong>
				<br />
				<span style="color:gray;text-decoration:none">
					(by default: 'C62' for piece, see <a href="http://www.unece.org/cefact/recommendations/rec20/rec20_00cf20a1-3e.pdf#page=50" target=_new">unece.org 	p.50-84</a> for further common codes)
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" onclick="if(document.getElementById('globals_gr_UnitOfMeasurement').checked == 1) {document.getElementById('gr_UnitOfMeasurement').style.display = 'none';} else {document.getElementById('gr_UnitOfMeasurement').style.display = '';}" id="globals_gr_UnitOfMeasurement" name="productmeta_values[gr_globals][gr_UnitOfMeasurement]" value="1" <?php if($product_data['gr_globals']['gr_UnitOfMeasurement'] == 1) echo "checked"; ?> />
				apply global unit of measurement
				<br />
				<br />
			</td>
			<td id="gr_UnitOfMeasurement" <?php if($product_data['gr_globals']['gr_UnitOfMeasurement'] == 1) echo "style='display:none'"; ?>>
				<input name="productmeta_values[gr_UnitOfMeasurement]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_UnitOfMeasurement']; ?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong>
					<a href="http://purl.org/goodrelations/v1#billingIncrement" target="_new">Minimum value for billing increment</a>
				</strong>
				<br />
				<span style="color:gray;text-decoration:none">(by default: '1')</span>
			</td>
		</tr>
		<tr>
			<td>
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" onclick="if(document.getElementById('globals_gr_billingIncrement').checked == 1) {document.getElementById('gr_billingIncrement').style.display = 'none';} else {document.getElementById('gr_billingIncrement').style.display = '';}" id="globals_gr_billingIncrement" name="productmeta_values[gr_globals][gr_billingIncrement]" value="1" <?php if($product_data['gr_globals']['gr_billingIncrement'] == 1) echo "checked"; ?> /> 
				apply global billing increment
				<br />
				<br />
			</td>
			<td id="gr_billingIncrement" <?php if($product_data['gr_globals']['gr_billingIncrement'] == 1) echo "style='display:none'"; ?>>
				<input name="productmeta_values[gr_billingIncrement]" type="text" size="30" maxlength="30" value="<?php echo $product_data['gr_billingIncrement']; ?>" />
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;" colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#eligibleCustomerTypes" target="_new">Range of customers</a>:</strong>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][gr_eligibleCustomerTypes]" value="1" id="globals_gr_eligibleCustomerTypes" onClick="if(document.getElementById('globals_gr_eligibleCustomerTypes').checked == 1) {document.getElementById('gr_eligibleCustomerTypes').style.display = 'none';} else {document.getElementById('gr_eligibleCustomerTypes').style.display = '';}" <?php if($product_data['gr_globals']['gr_eligibleCustomerTypes'] == 1) echo "checked"; ?> /> 
				apply global range of customers 
				<br />
				<br />
			</td>
			<td id="gr_eligibleCustomerTypes"  <?php if($product_data['gr_globals']['gr_eligibleCustomerTypes']) echo "style='display:none'"; ?>>
				<div id="resizeable" class="ui-widget-content gr-multiple-select">
					<input type="checkbox" name="productmeta_values[gr_eligibleCustomerTypes][Endser]" value="1" <?php if($product_data['gr_eligibleCustomerTypes']['Enduser'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Enduser" target="_new">Enduser</a><br>
					<input type="checkbox" name="productmeta_values[gr_eligibleCustomerTypes][Business]" value="1" <?php if($product_data['gr_eligibleCustomerTypes']['Business'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Business" target="_new">Business</a><br>
					<input type="checkbox" name="productmeta_values[gr_eligibleCustomerTypes][PublicInstitution]" value="1" <?php if($product_data['gr_eligibleCustomerTypes']['PublicInstitution'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#PublicInstitution" target="_new">Public Institutions</a><br>
					<input type="checkbox" name="productmeta_values[gr_eligibleCustomerTypes][Reseller]" value="1" <?php if($product_data['gr_eligibleCustomerTypes']['Reseller'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Reseller" target="_new">Reseller</a><br>
				</div>
				<br /><br />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#DeliveryMethod" target="_new">Available delivery methods</a>:</strong>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][gr_DeliveryMethod]" id="globals_gr_DeliveryMethod" onClick="if(document.getElementById('globals_gr_DeliveryMethod').checked == 1) {document.getElementById('gr_DeliveryMethod').style.display = 'none';} else {document.getElementById('gr_DeliveryMethod').style.display = '';}" <?php if($product_data['gr_globals']['gr_DeliveryMethod']) echo "checked"; ?> value=1 />
				apply global delivery methods
				<br />
				<br />
			</td>
			<td id="gr_DeliveryMethod"  <?php if($product_data['gr_globals']['gr_DeliveryMethod']) echo "style='display:none'"; ?>>
				<div id="resizeable" class="gr-multiple-select">
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][DeliveryModeDirectDownload]" value="1" <?php if($product_data['gr_DeliveryMethod']['DeliveryModeDirectDownload'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeDirectDownload" target="_new">Direct download</a><br>
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][DeliveryModeFreight]" value="1" <?php if($product_data['gr_DeliveryMethod']['DeliveryModeFreight'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeFreight" target="_new">Freight</a><br>
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][DeliveryModeMail]" value="1" <?php if($product_data['gr_DeliveryMethod']['DeliveryModeMail'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeMail" target="_new">Mail</a><br>
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][DeliveryModeOwnFleet]" value="1" <?php if($product_data['gr_DeliveryMethod']['DeliveryModeOwnFleet'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeOwnFleet" target="_new">Own fleet</a><br>
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][DeliveryModePickUp]" value="1" <?php if($product_data['gr_DeliveryMethod']['DeliveryModePickUp'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModePickUp" target="_new">Pick up</a><br>
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][UPS]" value="1" <?php if($product_data['gr_DeliveryMethod']['UPS'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#UPS" target="_new">UPS</a><br>
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][FederalExpress]" value="1" <?php if($product_data['gr_DeliveryMethod']['FederalExpress'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#FederalExpress" target="_new">FedEx</a><br>
					<input type="checkbox" name="productmeta_values[gr_DeliveryMethod][DHL]" value="1" <?php if($product_data['gr_DeliveryMethod']['DHL'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DHL" target="_new">DHL</a><br>
					<input type="hidden" name="productmeta_values[gr_DeliveryMethod][foo]" value="1">
				</div>
				<br /><br />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#acceptedPaymentMethods" target="_new">Accepted payment methods</a>:</strong>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][gr_PaymentMethod]" id="globals_gr_PaymentMethod" onClick="if(document.getElementById('globals_gr_PaymentMethod').checked == 1) {document.getElementById('gr_PaymentMethod').style.display = 'none';} else {document.getElementById('gr_PaymentMethod').style.display = '';}" <?php if($product_data['gr_globals']['gr_PaymentMethod']) echo "checked"; ?> value="1" />
				apply global payment methods
				<br />
				<br />
			</td>
			<td id="gr_PaymentMethod"  <?php if($product_data['gr_globals']['gr_PaymentMethod']) echo "style='display:none'"; ?> >
				<div id="resizeable" class="gr-multiple-select">
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][ByBankTransferInAdvance]" value="1" <?php if($product_data['gr_PaymentMethod']['ByBankTransferInAdvance'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ByBankTransferInAdvance" target="_new">Bank transfer in advance</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][ByInvoice]" value="1" <?php if($product_data['gr_PaymentMethod']['ByInvoice'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ByInvoice" target="_new">Invoice</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][Cash]" value="1" <?php if($product_data['gr_PaymentMethod']['Cash'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Cash" target="_new">Cash</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][CheckInAdvance]" value="1" <?php if($product_data['gr_PaymentMethod']['CheckInAdvance'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#CheckInAdvance" target="_new">Check in advance</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][COD]" value="1" <?php if($product_data['gr_PaymentMethod']['COD'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#COD" target="_new">Cash on delivery</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][DirectDebit]" value="1" <?php if($product_data['gr_PaymentMethod']['DirectDebit'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DirectDebit" target="_new">Direct debit</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][PayPal]" value="1" <?php if($product_data['gr_PaymentMethod']['PayPal'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#PayPal" target="_new">PayPal</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][GoogleCheckout]" value="1" <?php if($product_data['gr_PaymentMethod']['GoogleCheckout'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#GoogleCheckout" onclick="alert('This property is defined individually \n for your Store and will be part of a \n future release of GoodRelations.')" target="_new">Google Checkout</a><br> 
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][AmericanExpress]" value="1" <?php if($product_data['gr_PaymentMethod']['AmericanExpress'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#AmericanExpress" target="_new">AmericanExpress</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][DinersClub]" value="1" <?php if($product_data['gr_PaymentMethod']['DinersClub'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DinersClub" target="_new">DinersClub</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][Discover]" value="1" <?php if($product_data['gr_PaymentMethod']['Discover'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Discover" target="_new">Discover</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][MasterCard]" value="1" <?php if($product_data['gr_PaymentMethod']['MasterCard'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#MasterCard" target="_new">MasterCard</a><br>
					<input type="checkbox" name="productmeta_values[gr_PaymentMethod][VISA]" value="1" <?php if($product_data['gr_PaymentMethod']['VISA'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#VISA" target="_new">VISA</a><br>
					<input type="hidden" name="productmeta_values[gr_PaymentMethod][foo]" value="1" />
				</div>
				<br /><br />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#BusinessFunction" target="_new">Business function</a></strong>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][gr_BusinessFunction]" id="globals_gr_BusinessFunction" onClick="if(document.getElementById('globals_gr_BusinessFunction').checked == 1) {document.getElementById('gr_BusinessFunction').style.display = 'none';} else {document.getElementById('gr_BusinessFunction').style.display = '';}" <?php if($product_data['gr_globals']['gr_BusinessFunction']) echo "checked"; ?> value=1 />
				apply global business function
				<br />
				<br />
			</td>
			<td id="gr_BusinessFunction" <?php if($product_data['gr_globals']['gr_BusinessFunction']) echo "style='display:none'"; ?> >
				<div id="resizeable" class="ui-widget-content gr-multiple-select">
					<input type="checkbox" name="productmeta_values[gr_BusinessFunction][Sell]" value="1" <?php if($product_data['gr_BusinessFunction']['Sell'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Sell" target="_new">Sell</a><br>
					<input type="checkbox" name="productmeta_values[gr_BusinessFunction][Leaseout]" value="1" <?php if($product_data['gr_BusinessFunction']['LeaseOut'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#LeaseOut" target="_new">Lease Out</a><br>
					<input type="checkbox" name="productmeta_values[gr_BusinessFunction][ConstructionInstallation]" value="1" <?php if($product_data['gr_BusinessFunction']['constructioninstallation'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ConstructionInstallation" target="_new">Construction or Installation</a><br>
					<input type="checkbox" name="productmeta_values[gr_BusinessFunction][Dispose]" value="1" <?php if($product_data['gr_BusinessFunction']['Dispose'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Dispose" target="_new">Dispose</a><br>
					<input type="checkbox" name="productmeta_values[gr_BusinessFunction][Maintain]" value="1"<?php if($product_data['gr_BusinessFunction']['Maintain'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Maintain" target="_new">Maintain</a><br>
					<input type="checkbox" name="productmeta_values[gr_BusinessFunction][Provideservice]" value="1" <?php if($product_data['gr_BusinessFunction']['ProvideService'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ProvideService" target="_new">Provide Service</a><br>
					<input type="checkbox" name="productmeta_values[gr_BusinessFunction][Repair]" value="1" <?php if($product_data['gr_BusinessFunction']['Repair'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Repair" target="_new">Repair</a><br>
					<input type="hidden" name="productmeta_values[gr_BusinessFunction][foo]" value="1" />
					</div>
				<br /><br />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong><a href="http://purl.org/goodrelations/v1#availableAtOrFrom" target="_new">Store locations where the product is available</a></strong>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<br />
				&nbsp;&nbsp;
				<input type="checkbox" name="productmeta_values[gr_globals][gr_availableAtOrFrom]" id="globals_gr_availableAtOrFrom" onClick="if(document.getElementById('globals_gr_availableAtOrFrom').checked == 1) {document.getElementById('gr_availableAtOrFrom').style.display = 'none';} else {document.getElementById('gr_availableAtOrFrom').style.display = '';}" <?php if($product_data['gr_globals']['gr_availableAtOrFrom']) echo "checked"; ?> value=1 />
				apply global store locations
			</td>
			<td id="gr_availableAtOrFrom" <?php if($product_data['gr_globals']['gr_availableAtOrFrom']) echo "style='display:none'"; ?>>
				<div id="resizeable" class="gr-multiple-select">
<?php 
global $wpdb;
$sql="SELECT id, name FROM {$wpdb->prefix}gr_address WHERE kind = 2";
$lososp = $wpdb->get_results($sql, ARRAY_A);
if($lososp) {
foreach($lososp as $pointer) {
	?>
					<input type="checkbox" name="productmeta_values[gr_availableAtOrFrom][<?php echo $pointer['id']; ?>]" value="1" <?php if($product_data['gr_availableAtOrFrom'][$pointer['id']] == 1) echo "checked"; ?> />&nbsp;<?php echo $pointer['name']; ?><br>
	<?php

}
}
else {
echo "&nbsp;No store locations created yet.<br />&nbsp;This may be changed in the <br />&nbsp;GoodRelations administration menu.";
}
?>
					<input type="hidden" name="productmeta_values[gr_availableAtOrFrom][foo]" value="1"/>
				</div>
				<br />
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="productmeta_values[gr_globals][foo]" value="1" />
<input type="hidden" name="productmeta_values[gr_no_annotation][foo]" value="1" />
</div>
<?php
}
?>
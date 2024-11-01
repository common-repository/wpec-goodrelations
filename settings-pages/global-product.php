<?php
function gr_options_global_product() {
global $wpdb, $devmode;
$sql="SELECT option_name, option_value FROM {$wpdb->prefix}options WHERE option_name LIKE 'gr_%'";
$results = $wpdb->get_results($sql);
// echo print_r($results, true);
foreach ($results as $result) {
$gr_option[$result->option_name] = maybe_unserialize($result->option_value);
}
$sql="SELECT id, name FROM {$wpdb->prefix}gr_address WHERE kind = 2";
$lososp = $wpdb->get_results($sql, ARRAY_A);

?>
<br />

<?php //$gr_options = get_option('gr_DeliveryMethod');
// echo print_r($gr_options, true);
?>

<h3>Enter the global product options</h3>
<?php 
if($_GET['tab'] == 'global_product_options' ) {
if($_GET['updated'] >= '1') { ?><font color="red"><strong>Update was successful!</strong></font><br /><?php 
} 
elseif($_GET['updated'] == '0') { ?><font color="red"><strong>No update was made!</strong></font><br /><?php 
}
elseif($_GET['error']) { ?><font color="red"><strong>You have a problem with MySQL!<br /><?php echo '<pre>'.$_GET['error'].'</pre>'; ?></strong></font><br /><?php 
}
}
?><div class="global_product_options">
<form name="global_product_master" id="global_product_master" method="POST" action=""> 
	<div class="submit">
		<input type="submit" value="<?php echo __('Update &raquo;', 'wpec_goodrelations');?>" name="updateglobalproduct" />
	</div>
	These options will be the standard for each product and may be changed individually on each product page.
	<br />
	<br />
	<br />
	<table style="border:0;" cellspacing="0" id="gr_annotation_form" <?php if($gr_option['gr_no_annotation'] == 1) echo "style='visibility:hidden'"; ?>>
		<tbody>
			<tr>
				<td colspan="2">
					<strong>Offering and price validity:</strong>
					<br />
				</td>
			</tr>
			<tr id="gr_validity" <?php if($gr_option['gr_globals']['gr_validity'] == 1) echo "style='visibility:hidden'"; ?>>
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
									<select name="gr_option[gr_validity][product]" style="width:100px" onchange="document.getElementById('gr_product_validThrough_field').value=this.options[this.selectedIndex].value; document.getElementById('gr_product_validThrough_field').disabled=this.selectedIndex!=0">
										<option value="">select ...</option>
										<option value="1">1 Day</option>
										<option value="7">1 Week ( 7 days )</option>
										<option value="30">1 Month( 30 days )</option>
										<option value="365">1 Year ( 365 days )</option>
									</select>
									&nbsp;&nbsp;
									<input style="width:80px" name="gr_option[gr_validity][product]" id="gr_product_validThrough_field" type="text" title="you may enter a range of days which is not in the list" value="<?php echo $gr_option['gr_validity']['product']; ?>" />
									day(s)
								</td>
								<td>
									<select name="gr_option[gr_validity][price]" style="width:100px" onchange="document.getElementById('gr_price_validThrough_field').value=this.options[this.selectedIndex].value; document.getElementById('gr_price_validThrough_field').disabled=this.selectedIndex!=0">
										<option value="">select ...</option>
										<option value="1">1 Day</option>
										<option value="7">1 Week ( 7 days )</option>
										<option value="30">1 Month( 30 days )</option>
										<option value="365">1 Year ( 365 days )</option>
									</select>
									&nbsp;&nbsp;
									<input style="width:80px" name="gr_option[gr_validity][price]" id="gr_price_validThrough_field" type="text" title="you may enter a range of days which is not in the list" value="<?php echo $gr_option['gr_validity']['price']; ?>" />
									day(s)
									<br />
									<br />
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
				<td style="width: 250px">
					<br />
					&nbsp;
					<br />
				</td>
				<td id="gr_condition">
					<input name="gr_option[gr_condition]" type="text" size="30" maxlength="30" value="<?php echo $gr_option['gr_condition']; ?>">
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
					&nbsp;
					<br />

				</td>
				<td id="gr_language">
					<select name="gr_option[gr_language]" style="width:100px" onchange="document.getElementById('gr_language_field').value=this.options[this.selectedIndex].value; document.getElementById('gr_language_field').disabled=this.selectedIndex!=0">
						<option value="">select ...</option>
						<option value="de">de</option>
						<option value="en">en</option>
						<option value="es">es</option>
						<option value="fr">fr</option>
						<option value="it">it</option>
					</select>
					&nbsp;&nbsp;
					<input style="width:100px" name="gr_option[gr_language]" id="gr_language_field" type="text" title="you may enter a custom language code that is not defined in the list" value="<?php echo $gr_option['gr_language']; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<strong>Warranty settings:</strong>
					<br />

				</td>
			</tr>
			<tr id="gr_warranty" <?php if($gr_option['gr_globals']['warranty'] == 1) echo "style='visibility:hidden'"; ?> >
				<td colspan="2" >
					<br />
					<strong>Give duration in months </strong>
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
									<a href="http://purl.org/goodrelations/v1#Labor-BringIn" target="_new">Labor - bring in</a>
								</td>
								<td>
									<a href="http://purl.org/goodrelations/v1#PartsAndLabor-BringIn" target="_new">Parts and labor - bring in</a>
								</td>
								<td>
									<a href="http://purl.org/goodrelations/v1#PartsAndLabor-PickUp" target="_new">Parts and labor - pick up</a>
								</td>
							</tr>
							<tr>
								<td>
									<input  name="gr_option[gr_Labor-BringIn]" style="width:150px" type="text" size="10" maxlength="30" value="<?php echo $gr_option['gr_Labor-BringIn']; ?>" /> <br />
									<br />
									<br />
								</td>
								<td>
									<input name="gr_option[gr_PartsAndLabor-BringIn]" style="width:150px" type="text" size="10" maxlength="30" value="<?php echo $gr_option['gr_PartsAndLabor-BringIn']; ?>" /><br />
								</td>
								<td>
									<input name="gr_option[gr_PartsAndLabor-PickUp]" style="width:150px" type="text" size="10" maxlength="30" value="<?php echo $gr_option['gr_PartsAndLabor-PickUp']; ?>" /><br />
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
						(by default: 'C62' for piece, see <a href="http://www.unece.org/cefact/recommendations/rec20/rec20_00cf20a1-3e.pdf#page=50" target=_new">unece.org</a> for further common codes)
					</span>
				</td>
			</tr>
			<tr>
				<td>
					<br />
					&nbsp;&nbsp;
					<br />
					<br />
				</td>
				<td id="gr_UnitOfMeasurement" <?php if($gr_option['gr_globals']['gr_UnitOfMeasurement'] == 1) echo "style='visibility:hidden'"; ?>>
					<input name="gr_option[gr_UnitOfMeasurement]" type="text" size="30" maxlength="30" value="<?php echo $gr_option['gr_UnitOfMeasurement']; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<strong>
						<a href="http://purl.org/goodrelations/v1#billingIncrement" target="_new">Minimum value for billing increment of a product</a>
					</strong>
					<br />
					<span style="color:gray;text-decoration:none">(by default: '1')</span>
				</td>
			</tr>
			<tr>
				<td>
					<br />
					&nbsp;&nbsp;
					<br />
					<br />
				</td>
				<td id="gr_billingIncrement" <?php if($gr_option['gr_globals']['gr_billingIncrement'] == 1) echo "style='visibility:hidden'"; ?>>
					<input name="gr_option[gr_billingIncrement]" type="text" size="30" maxlength="30" value="<?php echo $gr_option['gr_billingIncrement']; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<strong><a href="http://purl.org/goodrelations/v1#eligibleCustomerTypes" target="_new">Range of customers</a>:</strong>
				</td>
			</tr>
			<tr>
				<td>
					<br />
					&nbsp;&nbsp;
					<br />
					<br />
					<br />
				</td>
				<td id="gr_eligibleCustomerTypes"  <?php if($gr_option['gr_globals']['gr_eligibleCustomerTypes']) echo "style='visibility:hidden'"; ?>>
					<div id="resizeable" class="ui-widget-content gr-multiple-select">
						<input type="checkbox" name="gr_option[gr_eligibleCustomerTypes][Enduser]" value="1" <?php if($gr_option['gr_eligibleCustomerTypes']['Enduser'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Enduser" target="_new">Enduser</a><br>
						<input type="checkbox" name="gr_option[gr_eligibleCustomerTypes][Business]" value="1" <?php if($gr_option['gr_eligibleCustomerTypes']['Business'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Business" target="_new">Business</a><br>
						<input type="checkbox" name="gr_option[gr_eligibleCustomerTypes][PublicInstitution]" value="1" <?php if($gr_option['gr_eligibleCustomerTypes']['PublicInstitution'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#PublicInstitution" target="_new">Public Institutions</a><br>
						<input type="checkbox" name="gr_option[gr_eligibleCustomerTypes][Reseller]" value="1" <?php if($gr_option['gr_eligibleCustomerTypes']['Reseller'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Reseller" target="_new">Reseller</a><br>
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
				<td>
					<br />
					&nbsp;&nbsp;
					<br />
					<br />
				</td>
				<td id="gr_DeliveryMethod"  <?php if($gr_option['gr_globals']['gr_DeliveryMethod']) echo "style='visibility:hidden'"; ?>>
					<div id="resizeable" class="gr-multiple-select">
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][DeliveryModeDirectDownload]" value="1" <?php if($gr_option['gr_DeliveryMethod']['DeliveryModeDirectDownload'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeDirectDownload" target="_new">Direct download</a><br>
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][DeliveryModeFreight]" value="1" <?php if($gr_option['gr_DeliveryMethod']['DeliveryModeFreight'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeFreight" target="_new">Freight</a><br>
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][DeliveryModeMail]" value="1" <?php if($gr_option['gr_DeliveryMethod']['DeliveryModeMail'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeMail" target="_new">Mail</a><br>
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][DeliveryModeOwnFleet]" value="1" <?php if($gr_option['gr_DeliveryMethod']['DeliveryModeOwnFleet'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModeOwnFleet" target="_new">Own fleet</a><br>
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][DeliveryModePickUp]" value="1" <?php if($gr_option['gr_DeliveryMethod']['DeliveryModePickUp'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DeliveryModePickUp" target="_new">Pick up</a><br>
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][UPS]" value="1" <?php if($gr_option['gr_DeliveryMethod']['UPS'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#UPS" target="_new">UPS</a><br>
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][FederalExpress]" value="1" <?php if($gr_option['gr_DeliveryMethod']['FederalExpress'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#FederalExpress" target="_new">FedEx</a><br>
						<input type="checkbox" name="gr_option[gr_DeliveryMethod][DHL]" value="1" <?php if($gr_option['gr_DeliveryMethod']['DHL'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DHL" target="_new">DHL</a><br>
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
				<td>
					<br />
					&nbsp;&nbsp;
					<br />
					<br />
				</td>
				<td id="gr_PaymentMethod"  <?php if($gr_option['gr_globals']['gr_PaymentMethod']) echo "style='visibility:hidden'"; ?> >
					<div id="resizeable" class="gr-multiple-select">
						<input type="checkbox" name="gr_option[gr_PaymentMethod][ByBankTransferInAdvance]" value="1" <?php if($gr_option['gr_PaymentMethod']['ByBankTransferInAdvance'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ByBankTransferInAdvance" target="_new">Bank transfer in advance</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][ByInvoice]" value="1" <?php if($gr_option['gr_PaymentMethod']['ByInvoice'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ByInvoice" target="_new">Invoice</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][Cash]" value="1" <?php if($gr_option['gr_PaymentMethod']['Cash'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Cash" target="_new">Cash</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][CheckInAdvance]" value="1" <?php if($gr_option['gr_PaymentMethod']['CheckInAdvance'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#CheckInAdvance" target="_new">Check in advance</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][COD]" value="1" <?php if($gr_option['gr_PaymentMethod']['COD'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#COD" target="_new">Cash on delivery</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][DirectDebit]" value="1" <?php if($gr_option['gr_PaymentMethod']['DirectDebit'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DirectDebit" target="_new">Direct debit</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][PayPal]" value="1" <?php if($gr_option['gr_PaymentMethod']['PayPal'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#PayPal" target="_new">PayPal</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][GoogleCheckout]" value="1" <?php if($gr_option['gr_PaymentMethod']['GoogleCheckout'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#GoogleCheckout" onclick="alert('This property is defined individually \n for your Store and will be part of a \n future release of GoodRelations.')" target="_new">Google Checkout</a><br> 
						<input type="checkbox" name="gr_option[gr_PaymentMethod][AmericanExpress]" value="1" <?php if($gr_option['gr_PaymentMethod']['AmericanExpress'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#AmericanExpress" target="_new">AmericanExpress</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][DinersClub]" value="1" <?php if($gr_option['gr_PaymentMethod']['DinersClub'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#DinersClub" target="_new">DinersClub</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][Discover]" value="1" <?php if($gr_option['gr_PaymentMethod']['Discover'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Discover" target="_new">Discover</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][MasterCard]" value="1" <?php if($gr_option['gr_PaymentMethod']['MasterCard'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#MasterCard" target="_new">MasterCard</a><br>
						<input type="checkbox" name="gr_option[gr_PaymentMethod][VISA]" value="1" <?php if($gr_option['gr_PaymentMethod']['VISA'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#VISA" target="_new">VISA</a><br>
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
				<td>
					<br />
					&nbsp;&nbsp;
					<br />
					<br />
				</td>
				<td id="gr_BusinessFunction" <?php if($gr_option['gr_globals']['gr_BusinessFunction']) echo "style='visibility:hidden'"; ?> >
					<div id="resizeable" class="ui-widget-content gr-multiple-select">
						<input type="checkbox" name="gr_option[gr_BusinessFunction][Sell]" value="1" <?php if($gr_option['gr_BusinessFunction']['Sell'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Sell" target="_new">Sell</a><br>
						<input type="checkbox" name="gr_option[gr_BusinessFunction][Leaseout]" value="1" <?php if($gr_option['gr_BusinessFunction']['LeaseOut'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#LeaseOut" target="_new">Lease Out</a><br>
						<input type="checkbox" name="gr_option[gr_BusinessFunction][ConstructionInstallation]" value="1" <?php if($gr_option['gr_BusinessFunction']['constructioninstallation'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ConstructionInstallation" target="_new">Construction or Installation</a><br>
						<input type="checkbox" name="gr_option[gr_BusinessFunction][Dispose]" value="1" <?php if($gr_option['gr_BusinessFunction']['Dispose'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Dispose" target="_new">Dispose</a><br>
						<input type="checkbox" name="gr_option[gr_BusinessFunction][Maintain]" value="1"<?php if($gr_option['gr_BusinessFunction']['Maintain'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Maintain" target="_new">Maintain</a><br>
						<input type="checkbox" name="gr_option[gr_BusinessFunction][Provideservice]" value="1" <?php if($gr_option['gr_BusinessFunction']['ProvideService'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#ProvideService" target="_new">Provide Service</a><br>
						<input type="checkbox" name="gr_option[gr_BusinessFunction][Repair]" value="1" <?php if($gr_option['gr_BusinessFunction']['Repair'] == 1) echo "checked"; ?> />&nbsp;<a href="http://purl.org/goodrelations/v1#Repair" target="_new">Repair</a><br>
					</div>
					<br /><br />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<strong><a href="http://purl.org/goodrelations/v1#availableAtOrFrom" target="_new">Store locations where a product is available</a></strong>
				</td>
			</tr>
			<tr>
				<td>
					<br />
					&nbsp;&nbsp;
				</td>
				<td id="gr_availableAtOrFrom" <?php if($gr_option['gr_globals']['gr_availableAtOrFrom']) echo "style='visibility:hidden'"; ?>>
					<div id="resizeable" class="gr-multiple-select">
						<?php 
						global $wpdb;
						$sql="SELECT id, name FROM {$wpdb->prefix}gr_address WHERE kind = 2";
						$lososp = $wpdb->get_results($sql, ARRAY_A);
						if($lososp) {
						foreach($lososp as $pointer) {
							?>
							<input type="checkbox" name="gr_option[gr_availableAtOrFrom][<?php echo $pointer['id']; ?>]" value="1" <?php if($gr_option['gr_availableAtOrFrom'][$pointer['id']] == 1) echo "checked"; ?> />&nbsp;<?php echo $pointer['name']; ?><br>
							<?php
						}
						}
						else {
						echo "&nbsp;No store locations created yet.<br />&nbsp;This may be changed in the <br />&nbsp;GoodRelations administration menu.";
						}
						?>
					</div>
					<br />
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="gr_option[gr_BusinessFunction][foo]" value="1" />
	<input type="hidden" name="gr_option[gr_warranty][foo]" value="1" />
	<input type="hidden" name="gr_option[gr_validity][foo]" value="1" />
	<input type="hidden" name="gr_option[gr_eligibleCustomers][foo]" value="1" />
	<input type="hidden" name="gr_option[gr_DeliveryMethod][foo]" value="1" />
	<input type="hidden" name="gr_option[gr_BusinessFunction][foo]" value="1" />
	<input type="hidden" name="gr_option[gr_PaymentMethod][foo]" value="1">
	<input type="hidden" name="gr_option[gr_availableAtOrFrom][foo]" value="1"/>
	<div class="submit">
		<input type='hidden' name='gr_admin_action' value='submit_global_product' />
		<?php wp_nonce_field('update-global-product', 'gr-update-global-product'); ?>
		<input type="submit" value="<?php echo __('Update &raquo;', 'wpec_goodrelations');?>" name="updateglobalproduct"/>
	</div>
</form>
		
</div>
<?php
if($devmode) echo '<pre>'.print_r($gr_option, true).'</pre>';
}
?>
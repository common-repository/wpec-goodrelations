<?php
function gr_options_businessentity() {
global $wpdb, $devmode;
$company = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}gr_address WHERE kind = 1", ARRAY_A);
			
?>
<script type="text/javascript" language="javascript">
function form_check() {
if(document.getElementById('company_legal_name').value == '') {
document.getElementById('update_message').innerHTML = '<font color="red"><strong>Enter at least the name of your company!</strong></font>';
}
else if(document.getElementById('company_tel').value != '') {
var myString = document.getElementById('company_tel').value;
var muster = /^\+{1}[0-9]{1,3}\-{1}[0-9]{1,5}\-{1}[0-9]*$/;
var matches = myString.match(muster);
if (!matches) { 
document.getElementById('update_message').innerHTML = '<font color="red"><strong>Format the phone number like +123-1234-1234567890</strong></font>'; 
}
if (matches) {
document.company_master.submit();
}
}
else {
document.company_master.submit();
}
}
</script>


<?php if($devmode) print_r($_post); ?>
<br />

<h3><a href="http://purl.org/goodrelations/v1#BusinessEntity" target="_new">Company data</a></h3>
<br /><div id="update_message">
<?php 
if($_GET['tab'] == 'company' ) {
if($_GET['updated'] == '1') { ?><font color="red"><strong>Update was successful!</strong></font><br /><?php 
} 
elseif($_GET['updated'] == '0') {  ?><font color="red"><strong>No update was made!</strong></font><br /><?php 
}
elseif($_GET['error']) { ?><font color="red"><strong>You have a problem with MySQL!<br /><?php echo '<pre>'.$_GET['error'].'</pre>'; ?></strong></font><br /><?php 
}
}
?></div>
<form name="company_master" id="company_master" method="POST" action="">
	<div class="submit">&nbsp;&nbsp;<input type="button" onclick="form_check()" value="<?php echo __('Update &raquo;', 'wpec_goodrelations');?>" name="updatecompany"/>
	</div>
	<br />
	<table style="width:100%;border:0;" cellspacing="3px;"> 
			<tr>
				<td style="width:480px">
					<a href="http://purl.org/goodrelations/v1#legalName" target="_new">Legal name of your company</a>
				</td>
				<td>
					<input style="width:480px" name="company_legal_name" id="company_legal_name" type="text" value="<?php echo $company['name']; ?>"/>
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#country-name" target="_new">Country</a>
				</td>
				<td>
					<input style="width:480px" name="company_country_name" id="company_country_name" type="text" value="<?php echo $company['country_name']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#region" target="_new">Region</a>
				</td>
				<td>
				<input style="width:480px" name="company_region"id="company_region" type="text" value="<?php echo $company['region']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#locality" target="_new">City</a>
				</td>
				<td>
					<input style="width:480px" name="company_locality" id="company_locality" type="text" value="<?php echo $company['locality']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#postal-code" target="_new">ZIP code</a>
				</td>
				<td>
					<input style="width:480px" name="company_postal_code" id="company_postal_code" type="text" value="<?php echo $company['postal_code']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#street-address" target="_new">Street and number</a> 
				</td>
				<td>
					<input style="width:480px" name="company_street_address" id="company_street_address" type="text" value="<?php echo $company['street_address']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#tel" target="_new">Phone number</a>
					<span style="font-size:11px;color:gray;">
						please enter like +49-0123-456789
					</span>
				</td>
				<td>
					<input style="width:480px" name="company_tel" id="company_tel" type="text" value="<?php echo $company['tel']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#logo" target="_new">URL of your company logo</a> 
					<span style="font-size:11px;color:gray;">
						e.g. http://www.example.com/image.(jpg|png|gif|svg)
					</span>
				</td>
				<td>
					<input style="width:480px" name="company_logo" id="company_logo" type="text" value="<?php echo $company['logo']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#email" target="_new">Email address of your company</a>
				</td>
				<td>
					<input style="width:480px" name="company_email" id="company_email" type="text" value="<?php echo $company['email']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<span title="Data Universal Numbering System" class="tooltip">DUNS</span>
					<span style="font-size:11px; color:gray"> see <a href="http://www.dnb.co.uk/duns-number.asp" target="_new">dnb.co.uk/duns-number.asp</a> for further information</span>
				</td>
				<td>
					<input style="width:480px" name="company_duns" id="company_duns" type="text" value="<?php echo $company['duns']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<span title="Global Location Number" class="tooltip">GLN</span>
					<span style="font-size: 11px; color:gray">
						see <a href="http://www.gs1.org/barcodes/technical/idkeys/gln" target="_new">gs1.org/barcodes/technical/idkeys/gln</a> for further information
					</span>
				</td>
				<td>
					<input style="width:480px" name="company_gln" id="company_gln" type="text" value="<?php echo $company['gln']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<span title="International Standard Industrial Classification" class="tooltip">ISICv4</span>
					<span style="font-size:11px;color:gray">
						see <a href="http://unstats.un.org/unsd/cr/registry/isic-4.asp" target="_new">unstats.un.org/unsd/cr/registry/isic-4.asp</a> for further information
					</span>
				</td>
				<td>
					<input style="width:480px" name="company_isicv4" id="company_isicv4" type="text" value="<?php echo $company['isicv4']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<span title="North American Industry Classification System" class="tooltip">NAICS</span>
					<span style="font-size:11px;color:gray">
						see <a href="http://www.census.gov/eos/www/naics/" target="_new">census.gov/eos/www/naics/</a> for further information
					</span>
 				</td>
				<td>
					<input style="width:480px" name="company_naics" id="company_naics" type="text" value="<?php echo $company['naics']; ?>" />
				</td>
			</tr> 
			
			
			<tr>
				<td style="width:480px">
					Language of your address information 
					<span style="font-size:11px;color:gray;">
						select language code from <a href="http://en.wikipedia.org/wiki/ISO_639-1">ISO 639-1</a>, e.g. "en" or "de"
					</span>
				</td>
				<td>
					<select name="company_language" style="width:100px" onchange="document.getElementById('company_language').value=this.options[this.selectedIndex].value; document.getElementById('company_language').disabled=this.selectedIndex!=0">
						<option value="">select ...</option>
						<option value="de">de</option>
						<option value="en">en</option>
						<option value="es">es</option>
						<option value="fr">fr</option>
						<option value="it">it</option>
					</select>
					&nbsp;&nbsp;
					<input style="width:100px" name="company_language" id="company_language" type="text" title="you may enter a custom language code that is not defined in the list" value="<?php echo $company['language']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#Location" target="_new">Geo position</a>
					<input type="button" value="Get geo position for the address above" onclick="javascript:codeAddressComp()" />
				</td>
				<td style="width:480px">
					Latitude (<input style="width:100px" name="company_lati" id="company_latitude" type="text" value="<?php echo $company['lati']; ?>" />)
					&nbsp;&nbsp;
					Longitude (<input style="width:100px" name="company_long" id="company_longitude" type="text" value="<?php echo $company['long']; ?>" />)
				</td>
			</tr> 
			<tr>
				<td>
					<span id="geo_string">
					</span>
				</td>
				<td>
					<div id="map_canvas" style="width:480px; height:0px;">
					</div>
				</td>
			</tr>	

		</table> 
	<div class="submit">
		<input type="hidden" name="company_id" id="company_id" value="<?php echo $company['id'] ?>" />
		<input type="hidden" name="company_kind" id="company_kind" value="1" />
		<input type='hidden' name='gr_admin_action' value='submit_company' />
		<?php wp_nonce_field('update-company', 'gr-update-company'); ?>
		<input type="button" onclick="form_check()" value="<?php echo __('Update &raquo;', 'wpec_goodrelations');?>" name="updatecompany"/>
	</div>
</form> 

<?php
}
?>
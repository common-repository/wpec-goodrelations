<?php
function gr_options_lososp() {
$sendback = wp_get_referer();
$sendback = add_query_arg('page', 'wpec_goodrelations', $sendback);
$sendback = add_query_arg('tab', 'lososp', $sendback);

?>

<script type="text/javascript" language="javascript">
   var http_request = false;
   var JSONObject;

   function makePOSTRequest(url, parameters, followthis) {
      http_request = false;
      if (window.XMLHttpRequest) { // Mozilla, Safari,...
         http_request = new XMLHttpRequest();
         if (http_request.overrideMimeType) {
         	// set type accordingly to anticipated content type
            //http_request.overrideMimeType('text/xml');
            http_request.overrideMimeType('text/html');
         }
      } else if (window.ActiveXObject) { // IE
         try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
            try {
               http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
         }
      }
      if (!http_request) {
         alert('Cannot create XMLHTTP instance');
         return false;
      }
      if (followthis == 'showpos') {
      http_request.onreadystatechange = showPos;
	  }
	  if (followthis == 'deletepos') {
	  http_request.onreadystatechange = deletePos;
	  }
	  if (followthis == 'show_pos_options') {
	  http_request.onreadystatechange = show_pos_options;
	  }
	  http_request.open('POST', url, true);
      http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_request.setRequestHeader("Content-length", parameters.length);
      http_request.setRequestHeader("Connection", "close");
      http_request.send(parameters);
   }

   function showPos() {
      if (http_request.readyState == 4) {
         if (http_request.status == 200) {
            // alert(http_request.responseText);
			JSONObject = eval( "( " + http_request.responseText + " )" )
			showAddress();
			document.getElementById('lososp_id').value = JSONObject.id;
			document.getElementById('lososp_legal_name').value = JSONObject.name;
			document.getElementById('lososp_country_name').value = JSONObject.country_name;
			document.getElementById('lososp_region').value = JSONObject.region;
			document.getElementById('lososp_locality').value = JSONObject.locality;
			document.getElementById('lososp_postal_code').value = JSONObject.postal_code;
			document.getElementById('lososp_street_address').value = JSONObject.street_address;
			document.getElementById('lososp_tel').value = JSONObject.tel;
			document.getElementById('lososp_logo').value = JSONObject.logo;
			document.getElementById('lososp_email').value = JSONObject.email;
			document.getElementById('lososp_duns').value = JSONObject.duns;
//			document.getElementById('lososp_isicv4').value = JSONObject.isicv4;
			document.getElementById('lososp_gln').value = JSONObject.gln;
			document.getElementById('lososp_language').value = JSONObject.language;
//			document.getElementById('lososp_naics').value = JSONObject.naics;
			document.getElementById('lososp_latitude').value = JSONObject.lati;
			document.getElementById('lososp_longitude').value = JSONObject.long;
			document.getElementById("geo_string").innerHTML = '';
			document.getElementById("map_canvas").style.height = "0px";
			document.getElementById('update_message').innerHTML = 'Edit <i>'+JSONObject.name+'</i>';
			document.getElementById('error_message').innerHTML = '<br />';
			document.getElementById('delete_button').innerHTML = '<input type="button" name="button" value="Delete !" onClick="delete_pos(document.getElementById(\'pos_id\'));" />';
            openinghours('');
			clear_openinghours();
			if(document.getElementById('lososp_duns').value == 'same as company') hideAddress();
			if(JSONObject.openinghours.am) {
				if(JSONObject.openinghours.am.mon_fri) {
				document.getElementById('opens_mon_am').value = JSONObject.openinghours.am.mon_fri.opens;
				document.getElementById('closes_mon_am').value = JSONObject.openinghours.am.mon_fri.closes;
				document.getElementById('mon_fri').value='1';
				document.getElementById('mon_fri_checkbox').checked = 'checked'
				openinghours('on');
				}
				if(JSONObject.openinghours.am.mon) {
				document.getElementById('opens_mon_am').value = JSONObject.openinghours.am.mon.opens;
				document.getElementById('closes_mon_am').value = JSONObject.openinghours.am.mon.closes;
				}
				if(JSONObject.openinghours.am.tue) {
				document.getElementById('opens_tue_am').value = JSONObject.openinghours.am.tue.opens;		
				document.getElementById('closes_tue_am').value = JSONObject.openinghours.am.tue.closes;		
				}
				if(JSONObject.openinghours.am.wed) {
				document.getElementById('opens_wed_am').value = JSONObject.openinghours.am.wed.opens;			
				document.getElementById('closes_wed_am').value = JSONObject.openinghours.am.wed.closes;		
				}
				if(JSONObject.openinghours.am.thu) {	
				document.getElementById('opens_thu_am').value = JSONObject.openinghours.am.thu.opens;			
				document.getElementById('closes_thu_am').value = JSONObject.openinghours.am.thu.closes;	
				}
				if(JSONObject.openinghours.am.fri) {		
				document.getElementById('opens_fri_am').value = JSONObject.openinghours.am.fri.opens;			
				document.getElementById('closes_fri_am').value = JSONObject.openinghours.am.fri.closes;			
				}
				if(JSONObject.openinghours.am.sat) {
				document.getElementById('opens_sat_am').value = JSONObject.openinghours.am.sat.opens;		
				document.getElementById('closes_sat_am').value = JSONObject.openinghours.am.sat.closes;		
				}			
				if(JSONObject.openinghours.am.sun) {		
				document.getElementById('opens_sun_am').value = JSONObject.openinghours.am.sun.opens;	
				document.getElementById('closes_sun_am').value = JSONObject.openinghours.am.sun.closes;	
				}
				if(JSONObject.openinghours.am.pub) {		
				document.getElementById('opens_pub_am').value = JSONObject.openinghours.am.pub.opens;	
				document.getElementById('closes_pub_am').value = JSONObject.openinghours.am.pub.closes;	
				}
			}
			if(JSONObject.openinghours.pm) {
				if(JSONObject.openinghours.pm.mon_fri) {
				document.getElementById('opens_mon_pm').value = JSONObject.openinghours.pm.mon_fri.opens;
				document.getElementById('closes_mon_pm').value = JSONObject.openinghours.pm.mon_fri.closes;
				document.getElementById('mon_fri').value='1';
				document.getElementById('mon_fri_checkbox').checked = 'checked'
				openinghours('on');
				}
				if(JSONObject.openinghours.pm.mon) {
				document.getElementById('opens_mon_pm').value = JSONObject.openinghours.pm.mon.opens;
				document.getElementById('closes_mon_pm').value = JSONObject.openinghours.pm.mon.closes;
				}
				if(JSONObject.openinghours.pm.tue) {
				document.getElementById('opens_tue_pm').value = JSONObject.openinghours.pm.tue.opens;		
				document.getElementById('closes_tue_pm').value = JSONObject.openinghours.pm.tue.closes;		
				}
				if(JSONObject.openinghours.pm.wed) {	
				document.getElementById('opens_wed_pm').value = JSONObject.openinghours.pm.wed.opens;			
				document.getElementById('closes_wed_pm').value = JSONObject.openinghours.pm.wed.closes;		
				}
				if(JSONObject.openinghours.pm.thu) {		
				document.getElementById('opens_thu_pm').value = JSONObject.openinghours.pm.thu.opens;			
				document.getElementById('closes_thu_pm').value = JSONObject.openinghours.pm.thu.closes;	
				}
				if(JSONObject.openinghours.pm.fri) {		
				document.getElementById('opens_fri_pm').value = JSONObject.openinghours.pm.fri.opens;			
				document.getElementById('closes_fri_pm').value = JSONObject.openinghours.pm.fri.closes;			
				}
				if(JSONObject.openinghours.pm.sat) {		
				document.getElementById('opens_sat_pm').value = JSONObject.openinghours.pm.sat.opens;		
				document.getElementById('closes_sat_pm').value = JSONObject.openinghours.pm.sat.closes;		
				}
				if(JSONObject.openinghours.pm.sun) {		
				document.getElementById('opens_sun_pm').value = JSONObject.openinghours.pm.sun.opens;	
				document.getElementById('closes_sun_pm').value = JSONObject.openinghours.pm.sun.closes;	
				}
				if(JSONObject.openinghours.pm.pub) {		
				document.getElementById('opens_pub_pm').value = JSONObject.openinghours.pm.pub.opens;	
				document.getElementById('closes_pub_pm').value = JSONObject.openinghours.pm.pub.closes;	
				}
				}
			} else {
            alert('There was a problem with the request.');
         }
      }
   }


   
   function delete_pos(obj) {
   if ( document.getElementById("pos_id").value == 'new' ) {
		document.getElementById('update_message').innerHTML = '<font color="red"><strong>Nothing to delete!</strong></font><br />';
	}
	else {
	document.getElementById('update_message').innerHTML = '<font color="red"><strong>You are about to delete <i>'+document.getElementById("lososp_legal_name").value+'</i>. Are you sure? </strong></font><input type="button" onClick="delete_confirm();" value="Yes" /> &nbsp; <input type="button" onClick="document.getElementById(\'update_message\').innerHTML = \'\'" value="No" />';
	}
   }
   

   function get(obj) {

		if ( document.getElementById("pos_id").value == 'new') { 
			document.getElementById('lososp_id').value = '';
			document.getElementById('lososp_legal_name').value = '';
			document.getElementById('lososp_country_name').value = '';
			document.getElementById('lososp_region').value = '';
			document.getElementById('lososp_locality').value = '';
			document.getElementById('lososp_postal_code').value = '';
			document.getElementById('lososp_street_address').value = '';
			document.getElementById('lososp_tel').value = '';
			document.getElementById('lososp_logo').value = '';
			document.getElementById('lososp_email').value = '';
			document.getElementById('lososp_duns').value = '';
//			document.getElementById('lososp_isicv4').value = '';
			document.getElementById('lososp_gln').value = '';
			document.getElementById('lososp_language').value = '';
//			document.getElementById('lososp_naics').value = '';
			document.getElementById('lososp_latitude').value = '';
			document.getElementById('lososp_longitude').value = '';
			document.getElementById("geo_string").innerHTML = '';
			document.getElementById("map_canvas").style.height = "0px";
			document.getElementById('update_message').innerHTML = '<i>Create new store location</i>';
			document.getElementById('delete_button').innerHTML = '<br />';
			clear_openinghours();
			showAddress();
			}
			else {
			document.getElementById('update_message').innerHTML = '<font color="red"><strong>Please wait while connecting to database...</strong></font><br />';
      var poststr = "action=show-lososp&gr_ajax=true&admin=true&pos_id=" + document.getElementById('pos_id').value;
     // alert(ajaxurl + poststr);
	  makePOSTRequest(ajaxurl, poststr, 'showpos');
   }
   }
   
   	function deletePos() {
	if (http_request.readyState == 4) {
         if (http_request.status == 200) {
            //alert(http_request.responseText);
			JSONObject = eval( "( " + http_request.responseText + " )" );
			document.getElementById('update_message').innerHTML = '<font color="red"><strong>'+JSONObject.message+'</strong></font><br />';
			document.getElementById('lososp_id').value = '';
			document.getElementById('lososp_legal_name').value = '';
			document.getElementById('lososp_country_name').value = '';
			document.getElementById('lososp_region').value = '';
			document.getElementById('lososp_locality').value = '';
			document.getElementById('lososp_postal_code').value = '';
			document.getElementById('lososp_street_address').value = '';
			document.getElementById('lososp_tel').value = '';
			document.getElementById('lososp_logo').value = '';
			document.getElementById('lososp_email').value = '';
			document.getElementById('lososp_duns').value = '';
//			document.getElementById('lososp_isicv4').value = '';
			document.getElementById('lososp_gln').value = '';
			document.getElementById('lososp_language').value = '';
//			document.getElementById('lososp_naics').value = '';
			document.getElementById('lososp_latitude').value = '';
			document.getElementById('lososp_longitude').value = '';
			document.getElementById("geo_string").innerHTML = '';
			document.getElementById("map_canvas").style.height = "0px";
			document.getElementById('delete_button').innerHTML = '<br />';
			//}
			pos_options();
			}
		}
	}
	
   function delete_confirm() {
   document.getElementById('update_message').innerHTML = '<font color="red"><strong>Please wait while deleting...</strong></font><br />';
   var poststr = "action=delete-lososp&gr_ajax=true&admin=true&pos_id=" + document.getElementById('pos_id').value;
   //alert(ajaxurl + poststr);
	makePOSTRequest(ajaxurl, poststr, 'deletepos');
   }

  function pos_options() {
  document.getElementById('update_message').innerHTML = '<font color="red"><strong>Please wait while retreiving data</strong></font><br />';
var poststr = "action=show-lososp-options&gr_ajax=true&admin=true";
   //alert(ajaxurl + poststr);
	makePOSTRequest(ajaxurl, poststr, 'show_pos_options');
  }
  
  function show_pos_options() {
  if (http_request.readyState == 4) {
         if (http_request.status == 200) {
  JSONObject = eval( "( " + http_request.responseText + " )" );
  //alert(JSONObject.form);
  document.getElementById('pos_options').innerHTML = JSONObject.form;
  document.getElementById('update_message').innerHTML = '<i>Create new store location or edit an existing</i>';
  }
  }
  }
  var checkboxvalue
  function openinghours(checkboxvalue) {
  if (checkboxvalue == 'on') {
 // alert(checkboxvalue);
   document.getElementById('mon').innerHTML = 'Mon-Fri<input type="hidden" name="mon_fri" id="mon_fri" value="1" />';
   
   document.getElementById('tue').style.visibility = 'hidden';
   document.getElementById('wed').style.visibility = 'hidden';
   document.getElementById('thu').style.visibility = 'hidden';
   document.getElementById('fri').style.visibility = 'hidden';
   
   document.getElementById('tueao').style.visibility = 'hidden';
   document.getElementById('wedao').style.visibility = 'hidden';
   document.getElementById('thuao').style.visibility = 'hidden';
   document.getElementById('friao').style.visibility = 'hidden';
   
   document.getElementById('tueac').style.visibility = 'hidden';
   document.getElementById('wedac').style.visibility = 'hidden';
   document.getElementById('thuac').style.visibility = 'hidden';
   document.getElementById('friac').style.visibility = 'hidden';
   
   document.getElementById('tuepo').style.visibility = 'hidden';
   document.getElementById('wedpo').style.visibility = 'hidden';
   document.getElementById('thupo').style.visibility = 'hidden';
   document.getElementById('fripo').style.visibility = 'hidden';
   
   document.getElementById('tuepc').style.visibility = 'hidden';
   document.getElementById('wedpc').style.visibility = 'hidden';
   document.getElementById('thupc').style.visibility = 'hidden';
   document.getElementById('fripc').style.visibility = 'hidden';
   }
  if (checkboxvalue == 'off') {
// alert(checkboxvalue);
	document.getElementById('mon').innerHTML = 'Mon<input type="hidden" name="mon_fri" id="mon_fri" value="0" />';

   document.getElementById('tue').style.visibility = '';
   document.getElementById('wed').style.visibility = '';
   document.getElementById('thu').style.visibility = '';
   document.getElementById('fri').style.visibility = '';
   
   document.getElementById('tueao').style.visibility = '';
   document.getElementById('wedao').style.visibility = '';
   document.getElementById('thuao').style.visibility = '';
   document.getElementById('friao').style.visibility = '';
   
   document.getElementById('tueac').style.visibility = '';
   document.getElementById('wedac').style.visibility = '';
   document.getElementById('thuac').style.visibility = '';
   document.getElementById('friac').style.visibility = '';
   
   document.getElementById('tuepo').style.visibility = '';
   document.getElementById('wedpo').style.visibility = '';
   document.getElementById('thupo').style.visibility = '';
   document.getElementById('fripo').style.visibility = '';
   
   document.getElementById('tuepc').style.visibility = '';
   document.getElementById('wedpc').style.visibility = '';
   document.getElementById('thupc').style.visibility = '';
   document.getElementById('fripc').style.visibility = '';
  }
  }
  
  function clear_openinghours() {
  document.getElementById('mon').innerHTML = 'Mon<input type="hidden" name="mon_fri" id="mon_fri" value="0" />';
  document.getElementById('mon_fri_checkbox').checked = ''
				openinghours('off');
				document.getElementById('opens_mon_am').value = '';
				document.getElementById('closes_mon_am').value = '';
				document.getElementById('opens_tue_am').value = '';		
				document.getElementById('closes_tue_am').value = '';		
				document.getElementById('opens_wed_am').value = '';			
				document.getElementById('closes_wed_am').value = '';		
				document.getElementById('opens_thu_am').value = '';			
				document.getElementById('closes_thu_am').value = '';	
				document.getElementById('opens_fri_am').value = '';			
				document.getElementById('closes_fri_am').value = '';			
				document.getElementById('opens_sat_am').value = '';		
				document.getElementById('closes_sat_am').value = '';		
				document.getElementById('opens_sun_am').value = '';	
				document.getElementById('closes_sun_am').value = '';	
				document.getElementById('opens_pub_am').value = '';	
				document.getElementById('closes_pub_am').value = '';	
				document.getElementById('opens_mon_pm').value = '';
				document.getElementById('closes_mon_pm').value = '';
				document.getElementById('opens_tue_pm').value = '';		
				document.getElementById('closes_tue_pm').value = '';		
				document.getElementById('opens_wed_pm').value = '';			
				document.getElementById('closes_wed_pm').value = '';		
				document.getElementById('opens_thu_pm').value = '';			
				document.getElementById('closes_thu_pm').value = '';	
				document.getElementById('opens_fri_pm').value = '';			
				document.getElementById('closes_fri_pm').value = '';			
				document.getElementById('opens_sat_pm').value = '';		
				document.getElementById('closes_sat_pm').value = '';		
				document.getElementById('opens_sun_pm').value = '';	
				document.getElementById('closes_sun_pm').value = '';	
				document.getElementById('opens_pub_pm').value = '';	
				document.getElementById('closes_pub_pm').value = '';	
				}
function hideAddress() {
var name_address = document.getElementsByName('address');
for(var i = 0; i < name_address.length; i++) name_address[i].style.display = 'none';
document.getElementById('lososp_duns').value = 'same as company';
document.getElementById('address_switch').checked = true;
}
function showAddress() {
var name_address = document.getElementsByName('address');
for(var i = 0; i < name_address.length; i++) name_address[i].style.display = '';
document.getElementById('lososp_duns').value = '';
document.getElementById('address_switch').checked = false;
}
function form_check() {
if(document.getElementById('lososp_legal_name').value == '') {
document.getElementById('update_message').innerHTML = '<font color="red"><strong>Enter a name for your store location first!</strong></font>';
}
else if(document.getElementById('lososp_tel').value != '') {
var myString = document.getElementById('lososp_tel').value;
var muster = /^\+{1}[0-9]{1,3}\-{1}[0-9]{1,5}\-{1}[0-9]*$/;
var matches = myString.match(muster);
if (!matches) { 
document.getElementById('update_message').innerHTML = '<font color="red"><strong>Format the phone number like +123-1234-1234567890</strong></font>'; 
}
if (matches) {
document.lososp_master.submit();
}
}
else {
document.lososp_master.submit();
}
}
</script>
<style type="text/css">
	.tooltip {text-decoration:underline;}
	.tooltip:hover {text-decoration:none;}
	.gr-multiple-select {
background:#FFFFFF none repeat scroll 0 0;
border:1px solid #DFDFDF;
display:inline-block;
max-height:90px;
min-height:60px;
margin:0;
overflow-x:hidden;
overflow-y:auto;
padding:0;
position:relative;
width:250px;
}
</style><br />
<div id='error_message'>
<?php if($_GET['error'] == 'name' ) {
?><font color="red"><strong>No Update - Missing name!</strong></font><?php 
}
elseif($_GET['updated'] >= '1') { ?><font color="red"><strong>Update was successful!</strong></font><?php 
} 
elseif($_GET['updated'] == '0') { ?><font color="red"><strong>No Update was made!</strong></font><?php 
}
elseif($_GET['error'] ) { ?><font color="red"><strong>You have a problem with MySQL!<br /><?php echo '<pre>'.$_GET['error'].'</pre>'; ?></strong></font><br />
<?php 
}
?>
</div><div id='update_message'>
<i>Create new store location or edit an existing</i>
</div><br />

<br />
Choose your <a href="http://purl.org/goodrelations/v1#LocationOfSalesOrServiceProvisioning" target="_new">store location</a>: &nbsp;&nbsp;

<div id="pos_options" >Please be patient while loading existing store location</div>
<script type="text/javascript" language="javascript">
pos_options();
</script>


<div id='delete_button'><br /></div>
<form name="lososp_master" id="lososp_master" method="POST" action=""> 
<div class="submit">&nbsp;&nbsp;<input type="button" value="<?php echo __('Update &raquo;', 'wpec_goodrelations');?>" onclick="form_check();" name="updatelososp" /></div>
If your store location has the same address as your company you don't need to enter your addressdata again!<br />
<input type="checkbox" id="address_switch" onclick="if(this.checked == '1'){hideAddress();} else {showAddress();}" value="1"/>&nbsp;Same address as company
<br />
<br />
	<table style="width:100%;border:0;" cellspacing="3px;"> 
			<tr>
				<td style="width:480px">
					Name of store location
				</td>
				<td>
					<input style="width:480px" name="lososp_legal_name" id="lososp_legal_name" type="text" value="<?php echo $lososp['name']; ?>" />
				</td>
			</tr> 
			<tr name="address">
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#country-name" target="_new">Country</a>
				</td>
				<td>
					<input style="width:480px" name="lososp_country_name" id="lososp_country_name" type="text" value="<?php echo $lososp['country_name']; ?>" />
				</td>
			</tr> 
			<tr name="address">
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#region" target="_new">Region</a>
				</td>
				<td>
					<input style="width:480px"name="lososp_region"id="lososp_region" type="text" value="<?php echo $lososp['region']; ?>" />
				</td>
			</tr> 
			<tr name="address">
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#locality" target="_new">City</a>
				</td>
				<td>
					<input style="width:480px" name="lososp_locality" id="lososp_locality" type="text" value="<?php echo $lososp['locality']; ?>" />
				</td>
			</tr> 
			<tr name="address">
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#postal-code" target="_new">ZIP code</a>
				</td>
				<td>
					<input style="width:480px" name="lososp_postal_code" id="lososp_postal_code" type="text" value="<?php echo $lososp['postal_code']; ?>" />
				</td>
			</tr> 
			<tr name="address">
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#street-address" target="_new">Street and number</a> 
				</td>
				<td>
					<input style="width:480px" name="lososp_street_address" id="lososp_street_address" type="text" value="<?php echo $lososp['street_address']; ?>" />
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
					<input style="width:480px" name="lososp_tel" id="lososp_tel" type="text" value="<?php echo $lososp['tel']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#logo" target="_new">URL of your store location logo</a> 
					<span style="font-size:11px;color:gray;">e.g. http://www.example.com/image.(jpg|png|gif|svg)</span>
				</td>
				<td>
					<input style="width:480px" name="lososp_logo" id="lososp_logo" type="text" value="<?php echo $lososp['logo']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#email" target="_new">Store locations emailaddress</a>
				</td>
				<td>
					<input style="width:480px" name="lososp_email" id="lososp_email" type="text" value="<?php echo $lososp['email']; ?>" />
				</td>
			</tr> 
			<tr style="display:none">
				<td style="width:480px">
					<span title="Data Universal Numbering System" class="tooltip">DUNS</span>
					<span style="font-size:11px; color:gray"> see <a href="http://www.dnb.co.uk/duns-number.asp" target="_new">dnb.co.uk/duns-number.asp</a> for further information</span>
				</td>
				<td>
					<input style="width:480px" name="lososp_duns" id="lososp_duns" type="text" value="<?php echo $lososp['duns']; ?>" />
				</td>
			</tr>
			<tr name="address">
				<td style="width:480px">
					<span title="Global Location Number" class="tooltip">GLN</span>
					<span style="font-size: 11px; color: gray"> see <a href="http://www.gs1.org/barcodes/technical/idkeys/gln" target="_new">gs1.org/barcodes/technical/idkeys/gln</a> for further information</span>
				</td>
				<td>
					<input style="width:480px" name="lososp_gln" id="lososp_gln" type="text" value="<?php echo $lososp['gln']; ?>" />
				</td>
			</tr> 
			<tr style="display:none">
				<td style="width:480px">
					<span title="International Standard Industrial Classification" class="tooltip">ISICv4</span>
					<span style="font-size:11px;color:gray"> see <a href="http://unstats.un.org/unsd/cr/registry/regcst.asp?Cl=2" target="_new">unstats.un.org/unsd/cr/registry/regcst.asp?Cl=2</a> for further information</span>
				</td>
				<td>
					<input style="width:480px" name="lososp_isicv4" id="lososp_isicv4" type="text" value="<?php echo $lososp['isicv4']; ?>" />
				</td>
			</tr> 
			<tr style="display:none">
				<td style="width:480px">
					<span title="North American Industry Classification System" class="tooltip">NAICS</span>
					<span style="font-size:11px;color:gray"> see <a href="http://www.census.gov/eos/www/naics/" target="_new">census.gov/eos/www/naics/</a> for further information</span>
 				</td>
				<td>
					<input style="width:480px" name="lososp_naics" id="lososp_naics" type="text" value="<?php echo $lososp['naics']; ?>" />
				</td>
			</tr> 
			<tr>
				<td style="width:480px">
					Language for address information
					<span style="font-size:11px;color:gray;">select language code from <a href="http://en.wikipedia.org/wiki/ISO_639-1">ISO 639-1</a>, e.g. "en" or "de"<br>if nothing entered "en" will be assumed</span>
				</td>
				<td style="width:480px">
					<select name="lososp_language" style="width:100px" onchange="document.getElementById('lososp_language').value=this.options[this.selectedIndex].value; document.getElementById('lososp_language').disabled=this.selectedIndex!=0">
						<option value="">select ...</option>
						<option value="de">de</option>
						<option value="en">en</option>
						<option value="es">es</option>
						<option value="fr">fr</option>
						<option value="it">it</option>
					</select>
					&nbsp;&nbsp;<input style="width:100px" name="lososp_language" id="lososp_language" type="text" title="you may enter a custom language code that is not defined in the list" value="<?php echo $lososp['language']; ?>" />
				</td>
			</tr> 
			<tr name="address">
				<td style="width:480px">
					<a href="http://www.w3.org/2006/vcard/ns-2006.html#Location" target="_new">Geo position</a>			
					<input type="button" value="Get geo position for the address above" onClick="javascript:codeAddressLososp()" />
				</td>
				<td style="width:480px">
					Latitude (<input style="width:100px" name="lososp_lati" id="lososp_latitude" type="text" value="<?php echo $lososp['lati']; ?>" />)
					&nbsp;&nbsp;
					Longitude (<input style="width:100px" name="lososp_long" id="lososp_longitude" type="text" value="<?php echo $lososp['long']; ?>" />)
					&nbsp;&nbsp;
				</td>
			</tr> 
			<tr>
				<td>
					<span id="geo_string"></span>
				</td>
				<td>
					<div id="map_canvas" style="width:480px; height:0px;"></div>
				</td>
			</tr>	
			<tr>
				<td colspan="2">
					<br />
					<br />
					<br />
					Specify <a href="http://purl.org/goodrelations/v1#OpeningHoursSpecification" target="_new">opening hours</a>:
					<br />
					<br />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="checkbox" id="mon_fri_checkbox"  onClick="if(document.getElementById('mon_fri_checkbox').checked == 1) { openinghours('on'); } else { openinghours('off'); }" />
					Same opening hours from monday to friday
					<br />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<td>&nbsp;</td>
							<td id='mon'>Mon</td>
							<td id='tue'>Tue</td>
							<td id='wed' >Wed</td>
							<td id='thu'>Thu</td>
							<td id='fri' >Fri</td>
							<td>Sat</td>
							<td>Sun</td>
							<td>Public holidays</td>
							<td rowspan="5">&nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td>Opens AM</td>
							<td><input type="text" style="width: 6em" name="openinghours[mon][am][opens]" id="opens_mon_am" /></td>
							<td id='tueao'><input type="text" style="width: 6em" name="openinghours[tue][am][opens]" id="opens_tue_am" /></td>
							<td id='wedao'><input type="text" style="width: 6em" name="openinghours[wed][am][opens]" id="opens_wed_am" /></td>
							<td id='thuao'><input type="text" style="width: 6em" name="openinghours[thu][am][opens]" id="opens_thu_am" /></td>
							<td id='friao'><input type="text" style="width: 6em" name="openinghours[fri][am][opens]" id="opens_fri_am" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sat][am][opens]" id="opens_sat_am" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sun][am][opens]" id="opens_sun_am" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[pub][am][opens]" id="opens_pub_am" /></td>
							<td rowspan="4">
								<div style="outline: 1px solid; background-color: white; outline-color: #DFDFDF; outline-bottom-left-radius: 4px 4px; outline-bottom-right-radius: 4px 4px; outline-style: solid; outline-width: 1px; outline-top-left-radius: 4px 4px; outline-top-right-radius: 4px 4px">
										&nbsp;Note: If your store location is closed <br />
										&nbsp;on a given day of the week leave the <br />
										&nbsp;opening hours fields empty. Don't use <br />
										&nbsp;the p.m. fields if your store location <br />
										&nbsp;doesn't close over lunch time.<br />
										&nbsp;Use 24-hour format (e.g. 08:00).
								</div>
							</td>
							</tr>
						<tr>
							<td>Closes AM</td>
							<td><input type="text" style="width: 6em" name="openinghours[mon][am][closes]" id="closes_mon_am" /></td>
							<td id='tueac'><input type="text" style="width: 6em" name="openinghours[tue][am][closes]" id="closes_tue_am" /></td>
							<td id='wedac'><input type="text" style="width: 6em" name="openinghours[wed][am][closes]" id="closes_wed_am" /></td>
							<td id='thuac'><input type="text" style="width: 6em" name="openinghours[thu][am][closes]" id="closes_thu_am" /></td>
							<td id='friac'><input type="text" style="width: 6em" name="openinghours[fri][am][closes]" id="closes_fri_am" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sat][am][closes]" id="closes_sat_am" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sun][am][closes]" id="closes_sun_am" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[pub][am][closes]" id="closes_pub_am" /></td>
						</tr>
						<tr>
							<td>Opens PM</td>
							<td><input type="text" style="width: 6em" name="openinghours[mon][pm][opens]" id="opens_mon_pm" /></td>
							<td id='tuepo'><input type="text" style="width: 6em" name="openinghours[tue][pm][opens]" id="opens_tue_pm" /></td>
							<td id='wedpo'><input type="text" style="width: 6em" name="openinghours[wed][pm][opens]" id="opens_wed_pm" /></td>
							<td id='thupo'><input type="text" style="width: 6em" name="openinghours[thu][pm][opens]" id="opens_thu_pm" /></td>
							<td id='fripo'><input type="text" style="width: 6em" name="openinghours[fri][pm][opens]" id="opens_fri_pm" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sat][pm][opens]" id="opens_sat_pm" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sun][pm][opens]" id="opens_sun_pm" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[pub][pm][opens]" id="opens_pub_pm" /></td>
						</tr>
						<tr>
							<td>Closes PM</td>
							<td><input type="text" style="width: 6em" name="openinghours[mon][pm][closes]" id="closes_mon_pm" /></td>
							<td id='tuepc'><input type="text" style="width: 6em" name="openinghours[tue][pm][closes]" id="closes_tue_pm" /></td>
							<td id='wedpc'><input type="text" style="width: 6em" name="openinghours[wed][pm][closes]" id="closes_wed_pm" /></td>
							<td id='thupc'><input type="text" style="width: 6em" name="openinghours[thu][pm][closes]" id="closes_thu_pm" /></td>
							<td id='fripc'><input type="text" style="width: 6em" name="openinghours[fri][pm][closes]" id="closes_fri_pm" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sat][pm][closes]" id="closes_sat_pm" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[sun][pm][closes]" id="closes_sun_pm" /></td>
							<td><input type="text" style="width: 6em" name="openinghours[pub][pm][closes]" id="closes_pub_pm" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table> 
	<div class="submit">
		<input type="hidden" name="lososp_id" id="lososp_id" value="<?php echo $lososp['id'] ?>" />
		<input type="hidden" name="lososp_kind" id="lososp_kind" value="2" />
		<input type='hidden' name='gr_admin_action' value='submit_lososp' ></input>
		<?php wp_nonce_field('update-lososp', 'gr-update-lososp'); ?>
		<input type="button" value="<?php echo __('Update &raquo;', 'wpec_goodrelations');?>" onclick="form_check();" name="updatelososp" />
		<input type="button" value="Reset" onClick="get(document.getElementById('pos_choose'))" ></input>
	</div>
</form>
<?php
} 
?>
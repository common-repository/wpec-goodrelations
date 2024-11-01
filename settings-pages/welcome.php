<?php
function gr_options_welcome() {
global $gr_setup, $devmode;
$gr_notify = $gr_setup['gr_notify'];
?>
<script type="text/javascript" language="javascript">
   var http_request = false;
   var JSONObject;

   function makePOSTRequest(url, parameters) {
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
	  http_request.onreadystatechange = show_notified;
	  
	  http_request.open('POST', url, true);
      http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_request.setRequestHeader("Content-length", parameters.length);
      http_request.setRequestHeader("Connection", "close");
      http_request.send(parameters);
   }
   
     function gr_notify() {
  document.getElementById('gr_notify').innerHTML = '<font color="red"><strong>notifying gr-notify about your sitemap.xml</strong></font><br />';
//var ajaxurl = "http://gr-notify.appspot.com/submit";
var poststr = "gr_ajax=true&action=gr_notify";
   //alert(ajaxurl + poststr);
	makePOSTRequest(ajaxurl, poststr);
  }
  
  function show_notified() {
  if (http_request.readyState == 4) {
         if (http_request.status == 200) {
  //JSONObject = eval( "( " + http_request.responseText + " )" );
  //alert(http_request.resposeText);
  document.getElementById('gr_notify').innerHTML = 'Result:'+http_request.responseText;
  
  }
  }
  }
</script>
<br />
<?php if ($_GET['updated']) {
echo "<font style='color:red;'><strong>Setup complete!</strong></font>
<br /><br />
<strong>
	Start now by adding <a href='?page=wpec_goodrelations&tab=lososp'>store locations</a>, then add additional information to your products.
</strong>
<br /><br />\n";
}
?>
<table>
	<tr>
		<td>
			<a href="http://purl.org/goodrelations/" target="_new"><img src="<?php echo WP_PLUGIN_URL; ?>/wpec-goodrelations/goodrelations_logo.gif" alt="GoodRelations Ontology for E-Commerce" /></a>
		</td>
		<td style="width: 400px">
			<center><div style="width: 350px">
			<br />
			<?php if( $gr_notify['last'] == '0' ) { ?>Your Sitemap has not been submitted yet<?php } else { ?>
			Sitemap.xml was last submitted on <br /><?php echo date(DATE_RFC822, $gr_notify['last']); } ?>
			</div></center>
			<?php
				if ( $gr_notify['last'] <=  mktime(date('H'), date('i'), date('s') , date("m")  , date("d")-1, date("Y")) ) {
			?>
			<center>
			<div id='gr_notify' style="width: 350px">
				Notify <a href="http://gr-notify.appspot.com/" target="_new">gr-notify.appspot.com</a> about your sitemap.xml
				<br />
				<form method="" action="" onSubmit="gr_notify()">
					<input type="button" name="notify" onclick="gr_notify()" value="notify!" />
				</form>
			</div>
			</center>
			<?php
			}
			?>
		</td>
	</tr>
</table>


<div><br />Welcome to GoodRelations for WP e-Commerce.
<br /><br />

For additional information about GoodRelations please visit <a href="http://purl.org/goodrelations/">purl.org/goodrelations</a>.
<br /><br />
This plugin enriches your WP e-Commerce Store with RDFa Data for the <a href="http://en.wikipedia.org/wiki/Semantic_Web" target="_new">Semantic Web</a>
Search engines are herewith able to
<br />
read all details of your products description and is reported to improve your ranking in search engine results.<br/><br />

GoodRelations is already in use by companies like Google, BestBuy, Overstock.com, Yahoo, OpenLink Software, O'Reilly Media, <br />
the RDF Book Mashup and many others.<br /><br />

To increase your visibility in the Web, you should install a separate pluing which creates a sitemap.xml, enable the product <br />
rating feature of WP e-Commerce and activate the permalink feature of Wordpress!
<br /> <br />
You may test the results of the GoodRelations markup with the following tools:<br />
<ul>
	<li> <a href="http://www.google.com/webmasters/tools/richsnippets" target="_new">Rich Snippets Testing Tool by Google</a> </li>
	<li> <a href="http://inspector.sindice.com/" target="_new">Sindice Web Data Inspector</a> </li>
	<li> <a href="http://graphite.ecs.soton.ac.uk/geo2kml/" target="_new">RDF 2 Geo by Christopher Gutteridge</a> </li>
	<li> <a href="http://graphite.ecs.soton.ac.uk/browser/" target="_new">Quick and Dirty RDF Browser by Christopher Gutteridge</a></li>
</ul>
<br />
<br />
<div style="padding:10px; width:650px; outline: 1px solid; background-color: white; outline-color: #DFDFDF;">
	<center>
		<a href="http://purl.org/goodrelations" target="_new">
			This plugin is based on the GoodRelations ontology, developed by Martin Hepp
		</a>
	</center>
</div>
<?php
if($devmode) echo print_r($gr_setup,true).time().(time() - '86400');
}
?>
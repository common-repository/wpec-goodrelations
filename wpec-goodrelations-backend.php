<?php
// Backend
// contains
// 	|-> Hooks
// 	|->	Navigation
// 	|->	GoodRelations Optionen
//	|	|->	Installation
//	|	|-> Optionen
//	|	|	|->	Welcome
//	|	|	|	|->	Bsc Research (until Jan 10 2010)
//	|	|	|-> General
//	|	|	|->	Company
//	|	|	|	|-> Anzeigen
// 	|	|	|	|-> Speichern
//	|	|	|->	Points of Sale
//	|	|	|	-> Points of Sale Ajax
//	|	|	|	-> Points of Sale Speichern
//	|	|	|->	Global Product Options
//	|	|	|	|-> Anzeigen
//	|	|	|	|-> Speichern
// 	|->	edit/add Product
// 	|	|-> Product Form

// Hooks

// fügt dem haken adminmenu die function gr_setup_options hinzu
add_action( 'admin_menu', 'gr_setup_options' );

// fügt den header auf der gewünschten seite ein
//  und fügt die submenu page ein 
// mit dem aufruf an function gr_display_settings
// welche zwischen administration und installation wählt
function gr_setup_options(){
	$gr_page2=add_submenu_page('wpsc-sales-logs', 'GoodRelations for WP e-Commerce', 'GoodRelations', '7', 'wpec_goodrelations', 'gr_display_settings');
	add_action( 'admin_head-'. $gr_page2, 'gr_admin_header' );
	$pagename = 'store_page_wpsc-edit-products';
	add_action( 'admin_head-'.$pagename, 'gr_admin_header');
}

// fügt dem haken admin menu gr_add_product_meta_box hinzu
add_action('admin_menu','gr_add_product_meta_box');
// fügt auf der produktseite die function gr_product_meta_box hinzu
function gr_add_product_meta_box() {
	$pagename = 'store_page_wpsc-edit-products';
	add_meta_box('gr_product_meta_box', 'GoodRelations', 'gr_product_meta_box', $pagename, 'normal', 'high', $product_data);
}

add_action('admin_init', 'gr_notify_check');


// abhängige Hooks

// wenn gr_ajax und admin == true dann wird die funktion gr_admin_ajax aufgerufen
if(($_REQUEST['gr_ajax'] == "true") && ($_REQUEST['admin'] == "true")) {
	add_action('admin_init', 'gr_admin_ajax', 2);
}

// wenn gr_ajax und admin == true dann wird die funktion gr_admin_ajax aufgerufen
if(($_REQUEST['gr_ajax'] == "true") && ($_REQUEST['action'] == "gr_notify")) {
	add_action('admin_init', 'gr_notify_ajax', 2);
}

// wenn ein point of sale gespeichert werden soll wird gr_submit_lososp aufgerufen
if($_REQUEST['gr_admin_action'] == 'submit_lososp') {
	add_action('admin_init', 'gr_submit_lososp');
}
// wenn eine Company gespeichert werden soll wird gr_submit_company aufgerufen
if($_REQUEST['gr_admin_action'] == 'submit_company') {
	add_action('admin_init', 'gr_submit_company');
}

// wenn die global product options gespeichert werden sollen wird
// gr_submit_global_product aufgerufen
if($_REQUEST['gr_admin_action'] == 'submit_global_product') {
	add_action('admin_init', 'gr_submit_global_product');
}

// wenn die general options gespeichert werden sollen wird
// gr_submit_general_options aufgerufen
if($_REQUEST['gr_admin_action'] == 'submit_general_options') {
	add_action('admin_init', 'gr_submit_general_options');
}

// GR Notify - gr-notify.appspot.com

function gr_notify_check() {
	global $gr_setup, $gr_version;
	if ( $gr_setup['gr_notify']['do'] == '1' && $gr_setup['gr_notify']['last'] <=  mktime(date('H'), date('i'), date('s') , date("m")  , date("d")-$gr_setup['gr_notify']['schedule'], date("Y"))  )  
	{
		gr_notify();
	}
	if ( !$gr_setup['gr_notify'] )
	{
		$gr_notify = array (
			'do' => '1',
			'uri' => home_url().'/sitemap.xml',
			'schedule' => '7',
			'last' => '0',
			'contact' => 'enter your email here'
			);
		$gr_setup['gr_notify'] = $gr_notify;
		update_option('gr_setup', $gr_setup);
	}
}

function gr_notify_ajax() {
	gr_notify('result');
	exit;
}

function gr_notify($display_result = 0) {
	global $gr_setup, $gr_version, $devmode;
	$gr_notify = $gr_setup['gr_notify'];

	$host = "gr-notify.appspot.com";
	$path = "/submit";
	$referer = $_SERVER['REQUEST_URI'];
	$data = "uri=".$gr_notify['uri']."&contact=".$gr_notify['contact']."&agent=wpec-goodrelations-".$gr_version;
	$res = @file_get_contents('http://'.$host.$path.'?'.$data);
	if($res) {
		$needle1 = '<div class="flash">';
		$needle2 = '</div>';
		$pos1 = strpos( $res, $needle1 );
		$pos2 = strpos( $res, $needle2 , $pos1);
		$pos1 = $pos1 - 10;
		$pos2 = $pos2 - 6 - $pos1;
		$res = substr( $res, $pos1 , $pos2 );
		if( strpos($res, 'Database updated' || strpos($res, 'OK') ) || strpos($res, 'updated') ) {
			$gr_setup['gr_notify']['last'] = time();
			update_option('gr_setup', $gr_setup);
		}
		if($display_result) {
			$res = '<br />'.$res;
			print $res;
		}
	}
}
 
// Goodrelations

// wählt zwischen installation und administration
// installation ruft gr_installation auf
// administration ruft gr_display_settings_page auf
function gr_display_settings() {
$gr_setup = get_option('gr_setup');
if ( $gr_setup['tables'] == 'created' ) {
if ( $gr_setup['businessentity'] == 'done' && $gr_setup['global_product_options'] == 'done' && $gr_setup['gr_do_annotation'] ) {
	gr_display_settings_page();
}

elseif ($gr_setup['businessentity'] == 'done' ) {
	require_once('settings-pages/global-product.php');
	echo "<h3>Revise the given options if they are applicable for your store and change them if neccessary!</h3>";
	gr_options_global_product();
}
else {
	require_once('settings-pages/businessentity.php');
	echo "<h3>Enter the general data about your company!</h3>";
	gr_options_businessentity();

}
}
else {
gr_installation();
}
}




// GoodRelations Installation
function gr_installation() { 

require_once('settings-pages/installation.php');
gr_setup_installation();
}




// GoodRelations Optionen

// wenn ein gr_ajax aufruf erfolgt, wird diese funktion aufgerufen
function gr_admin_ajax() {
	global $wpdb;
	if ($_POST['action'] == 'show-lososp' && $_POST['pos_id']) {

		$lososp = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}gr_address WHERE id = {$_POST['pos_id']} AND kind = 2", ARRAY_A);
		$openinghours = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gr_openinghours WHERE pos_id = {$_POST['pos_id']}", ARRAY_A);
		$openinghour = array();
		foreach($openinghours as $ophour) {
			$openinghour[$ophour['am_pm']][$ophour['day']]['opens'] = $ophour['opens'];
			$openinghour[$ophour['am_pm']][$ophour['day']]['closes'] = $ophour['closes'];
		}

		$lososp['openinghours'] = $openinghour;

		$output = json_encode($lososp);

		exit($output);
	}

	if ($_POST['action'] == 'delete-lososp' && $_POST['pos_id']) {
		$lososp_name = $wpdb->get_var("SELECT name FROM {$wpdb->prefix}gr_address WHERE id = {$_POST['pos_id']} AND kind = 2");
		if($lososp_name) $lososp['address'] = $wpdb->query("DELETE FROM {$wpdb->prefix}gr_address WHERE id = {$_POST['pos_id']} AND kind = 2");
		if($lososp_name) $lososp['openinghours'] = $wpdb->query("DELETE FROM {$wpdb->prefix}gr_openinghours WHERE pos_id = {$_POST['pos_id']}");
		if ($lososp['address']) {
			$output['result'] = true;
			$output['message'] = "You have deleted {$lososp_name} successful!";
			$output['pos_id'] = $_POST['pos_id'];
		}
		else {
			$output['result'] = false;
			$output['message'] = mysql_error();
		}

		$output = json_encode($output);

		exit($output);

	}

	if ($_POST['action'] == 'show-lososp-options') {
		$results = $wpdb->get_results("SELECT id, name FROM {$wpdb->prefix}gr_address WHERE kind = 2");
		$options_start = '<form action="javascript:delete_pos(document.getElementById(\'pos_choose\'));" name="pos_choose" id="pos_choose"><select onChange="get(document.getElementById(\'pos_choose\'));" id="pos_id" name="pos_id"><option selected value="new">Create new store location</option>';
		$options_end = '</select></form>';
		$options = array();
		foreach ($results as $result) {
			$options[] = '<option value="'.$result->id.'">'.$result->name.'</option>';
		}
		$options_middle = implode('', $options);
		$options = '';
		$options['form'] = $options_start.$options_middle.$options_end;
		$output = json_encode($options);

		exit($output);
	}

}

// wenn die general options gespeichert werden sollen wird diese funktion aufgerufen
function gr_submit_general_options() {
global $gr_setup;
check_admin_referer('update-general-options', 'gr-update-general-options');
$option = get_option('gr_setup');
if($option['gr_do_annotation'] == $_POST['option']['gr_do_annotation']) {
 $updated = 0;
 }
else {
$option['gr_do_annotation'] = $_POST['option']['gr_do_annotation'];
if (update_option('gr_setup', $option)) $updated = 1;
}
$option['do_header'] = $_POST['option']['do_header'];
$option['gr_field'] = $_POST['option']['gr_field'];
$option['annotation_in_category'] = $_POST['option']['annotation_in_category'];
$option['gr_notify'] = $_POST['option']['gr_notify'];
$option['gr_notify']['last'] = $gr_setup['gr_notify']['last'];
if($option['gr_notify']['schedule'] < '1') $option['gr_notify']['schedule'] = '1';
if (update_option('gr_setup', $option)) $updated = 2;
$sendback = wp_get_referer();
	$sendback = add_query_arg('page', 'wpec_goodrelations', $sendback);
	$sendback = add_query_arg('updated', $updated, $sendback);
	if($error) $sendback=add_query_arg('error', $error, $sendback);
	wp_redirect($sendback);
}



// wenn eine company gespeichert werden soll wird diese funktion aufgerufen
function gr_submit_company($selected='') {
	check_admin_referer('update-company', 'gr-update-company');
	global $wpdb;
	foreach (array_keys($_POST) as $pointer){
		$$pointer = $_POST[$pointer];
	}
	if($_POST['company_id']){
		$sql = "UPDATE `{$wpdb->prefix}gr_address` SET `name` = '{$company_legal_name}' ,`country_name` = '{$company_country_name}' ,`region` = '{$company_region}' ,`locality` = '{$company_locality}' ,`postal_code` = '{$company_postal_code}' ,`street_address` = '{$company_street_address}' ,`tel` = '{$company_tel}' ,`logo` = '{$company_logo}' ,`email` = '{$company_email}' ,`duns` = '{$company_duns}' ,`gln` = '{$company_gln}' ,`isicv4` = '{$company_isicv4}' ,`naics` = '{$company_naics}' ,`language` = '{$company_language}' ,`lati` = '{$company_lati}' ,`long` = '{$company_long}' WHERE `{$wpdb->prefix}gr_address`.`id` = {$company_id};";
		$result = $wpdb->query($sql);
		if (!$result)
		{
			if ( !mysql_error() )
			{
				$updated = 0;
			}
			if ( mysql_error() )
			{
				$error = mysql_error();
			}
		}
		if($result) $updated = 1;
	}
	else {
	$company_url = home_url();
		$sql = "INSERT INTO `{$wpdb->prefix}gr_address` 
(`id`, `name`, `street_address`, `postal_code`, `locality`, `region`, `country_name`, `email`, `tel`, `logo`, `url`, `kind`, `annotation`, `lati`, `long`, `duns`, `gln`, `isicv4`, `naics`, `language`) VALUES 
( NULL ,'{$company_legal_name}' , '{$company_street_address}' , '{$company_postal_code}' , '{$company_locality}' , '{$company_region}' , '{$company_country_name}' , '{$company_email}' , '{$company_tel}' , '{$company_logo}' , '{$company_url}' , '{$company_kind}', 'company', '{$company_lati}' , '{$company_long}' , '{$company_duns}' , '{$company_gln}' , '{$company_isicv4}', '{$company_naics}', '{$company_language}' )";
		$result = $wpdb->query($sql);
		if (!$result)
		{
			if ( !mysql_error() )
			{
				$updated = 0;
			}
			if ( mysql_error() )
			{
				$error = mysql_error();
			}
		}
		if($result) $updated = 1;
	}
	if($updated == 1) {
	$gr_setup = get_option('gr_setup');
	$gr_setup['businessentity'] = 'done';
	update_option('gr_setup', $gr_setup);
	}
	$sendback = wp_get_referer();
	$sendback = add_query_arg('page', 'wpec_goodrelations', $sendback);
	$sendback = add_query_arg('updated', $updated, $sendback);
	if($error) $sendback=add_query_arg('error', $error, $sendback);
	wp_redirect($sendback);
	exit();
}

// wenn eine point of sale gespeichert werden soll wird diese function aufgerufen

function gr_submit_lososp ($selected='') {
	check_admin_referer('update-lososp', 'gr-update-lososp');
	global $wpdb;
	if($_POST['lososp_legal_name'] == ''){
	$error = 'name';
	}
	else {
	$lososp_language = 'en';
	foreach (array_keys($_POST) as $pointer){
		$$pointer = $_POST[$pointer];
	}
	if($_POST['lososp_id']){
		$sql = "UPDATE `{$wpdb->prefix}gr_address` SET `name` = '{$lososp_legal_name}' ,`country_name` = '{$lososp_country_name}' ,`region` = '{$lososp_region}' ,`locality` = '{$lososp_locality}' ,`postal_code` = '{$lososp_postal_code}' ,`street_address` = '{$lososp_street_address}' ,`tel` = '{$lososp_tel}' ,`logo` = '{$lososp_logo}' ,`email` = '{$lososp_email}' ,`duns` = '{$lososp_duns}' ,`gln` = '{$lososp_gln}' ,`isicv4` = '{$lososp_isicv4}' ,`naics` = '{$lososp_naics}' ,`language` = '{$lososp_language}' ,`lati` = '{$lososp_lati}' ,`long` = '{$lososp_long}' WHERE `{$wpdb->prefix}gr_address`.`id` = {$lososp_id};";
		$result = $wpdb->query($sql);
		if (!$result)
		{
			if ( !mysql_error() )
			{
				$updated = 0;
			}
			if ( mysql_error() )
			{
				$error = mysql_error();
			}
		}
		if($result) $updated = 1;
	}
	else {
		$lososp_insert = Array(
		'id' => '',
		'name' => $lososp_legal_name,
		'street_address' => $lososp_street_address,
		'postal_code' => $lososp_postal_code,
		'locality' => $lososp_locality,
		'region' => $lososp_region,
		'country_name' => $lososp_country_name,
		'email' => $lososp_email,
		'tel' => $lososp_tel,
		'logo' => $lososp_logo,
		'url' => home_url(),
		'kind' => $lososp_kind,
		'annotation' => 'store',
		'lati' => $lososp_lati,
		'long' => $lososp_long,
		'duns' => $lososp_duns,
		'gln' => $lososp_gln,
		'isicv4' => $lososp_isicv4,
		'naics' => $lososp_naics,
		'language' => $lososp_language,
		);
		$result = $wpdb->insert($wpdb->prefix.'gr_address', $lososp_insert);
		$lososp_id = $wpdb->insert_id;
		if (!$result)
		{
			if ( !mysql_error() && $updated == 0)
			{
				$updated = 0;
			}
			if ( !mysql_error() && $updated == 1) {}
			if ( mysql_error() )
			{
				$error = mysql_error();
			}
		}
		if($result) $updated = 1;
	}
	
	if($openinghours) {
		$openinghours_post = array();
		if ( is_array ( $openinghours ) ) {
			foreach(array_keys($openinghours) as $day) {
				foreach(array_keys($openinghours[$day]) as $am_pm) {
					if(!empty($openinghours[$day][$am_pm]['opens'])) {
						$dayvar = $day;
						if( $mon_fri == '1' && $day == 'mon' ) $dayvar = 'mon_fri';
						$openinghours_post[$dayvar][$am_pm]['opens'] = $openinghours[$day][$am_pm]['opens'];
						$openinghours_post[$dayvar][$am_pm]['closes'] = $openinghours[$day][$am_pm]['closes'];
					}
				}
			}
		}
		$openinghours_table = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gr_openinghours WHERE pos_id = {$lososp_id}", ARRAY_A);
		$openinghour_table = array();
		foreach($openinghours_table as $ophour) {
			if($openinghours_post[$ophour['day']][$ophour['am_pm']]['opens'] != $ophour['opens'] || $openinghours_post[$ophour['day']][$ophour['am_pm']]['closes'] != $ophour['closes']) {
				$openinghour_table['update'] = 'doupdate';
			}
			else {
				$openinghour_table[$ophour['day']][$ophour['am_pm']]['opens'] = $ophour['opens'];
				$openinghour_table[$ophour['day']][$ophour['am_pm']]['closes'] = $ophour['closes'];
			}}
		if ( count($openinghour_table,1) != count($openinghours_post,1) ) {
			$openinghour_table['update'] = 'doupdate'; 
		}
		
		if ( !$openinghour_table['update'] ) {
			if($updated == 0 ) $updated = '0';
		}
		if ($openinghour_table['update']) {
			$sql = "DELETE FROM {$wpdb->prefix}gr_openinghours WHERE pos_id = '{$lososp_id}'";
			$wpdb->query($sql);
			
			$insert = array();
			$i = 0;
			foreach(array_keys($openinghours) as $day){
				foreach(array_keys($openinghours[$day]) as $am_pm){
					if(!empty($openinghours[$day][$am_pm]['opens'])) {
						$insert[$i]['pos_id'] = $lososp_id;
						$insert[$i][day] = $day;
						if( $mon_fri == '1' && $day == 'mon' ) $insert[$i][day] = 'mon_fri';
						$insert[$i][am_pm] = $am_pm;
						$insert[$i][opens] = $openinghours[$day][$am_pm]['opens'];
						$insert[$i][closes] = $openinghours[$day][$am_pm]['closes'];
						if( $mon_fri == '1' && ($day == 'tue' || $day == 'wed' || $day == 'thu' || $day == 'fri' )) $i --;
						$i ++;
					}
				}
			}
			$j = 0;
			while($j < $i){
				$this_insert = $insert[$j];
				
				$result = $wpdb->insert($wpdb->prefix.'gr_openinghours', $this_insert);
				if ($result) $j++;
				if (!$result) die(mysql_error());
			}
			$updated = '1';
		}
	}
	
	}
	$sendback = wp_get_referer();
	$sendback = add_query_arg('page', 'wpec_goodrelations', $sendback);
	$sendback = add_query_arg('updated', $updated, $sendback);
	if($error) {
	$sendback=add_query_arg('error', $error, $sendback);
	}
	else {
	$sendback=remove_query_arg('error', $sendback);
	}
	wp_redirect($sendback);
	exit();

}

// wenn die global product options gespeichert werden soll wird diese function aufgerufen

function gr_submit_global_product($selected='') {
	global $wpdb;
	check_admin_referer('update-global-product', 'gr-update-global-product');

	//update options
	if(isset($_POST['gr_option'])){
		foreach($_POST['gr_option'] as $key=>$value){
			if($value != get_option($key)) {
				update_option($key, $value);
				$updated++;
			}
		}
	}
	
	$sendback = wp_get_referer();

	if ( isset($updated) ) {
		
			$gr_setup = get_option('gr_setup');
			$gr_setup['global_product_options'] = 'done';
			update_option('gr_setup', $gr_setup);
	}
	else {
	$updated = '0';
	}
	$sendback = add_query_arg('updated', $updated, $sendback);
	$sendback = add_query_arg('page', 'wpec_goodrelations', $sendback);
	wp_redirect($sendback);
	exit();
}


// fügt den Header für Jscript ein, wenn die GoodRelations Optionen aufgerufen werden
function gr_admin_header(){
	echo '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript" src="'.WP_PLUGIN_URL.'/wpec-goodrelations/wpec-goodrelations-setup.js"></script>
<link rel="stylesheet" id="wpec-goodrelations-admin-css"  href="'.WP_PLUGIN_URL.'/wpec-goodrelations/wpec-gr-admin.css" type="text/css" media="all" />';
}


// ruft gr_the_settings_tabs auf und entscheidet welcher tab zu öffnen ist
// je nachdem welcher tab zu öffnen ist, wird die jeweilige php datei 
// geöffnet und ausgeführt
function gr_display_settings_page(){

	gr_the_settings_tabs(); 
	if(isset($_GET['tab'])){
		$page = $_GET['tab'];
	}else{
		$page = 'welcome';
	}

	?> <div id='wpec_goodrelations_page'> <?php
	switch($page) {
	case "lososp";
		require_once('settings-pages/lososp.php');
		gr_options_lososp();
		break;
	case "company";
		require_once('settings-pages/businessentity.php');
		gr_options_businessentity();
		break;
	case "global_product_options";
		require_once('settings-pages/global-product.php');
		gr_options_global_product();
		break;
	case "general";
		require_once('settings-pages/general.php');
		gr_options_general();
		break;
		
		default;
	case "welcome";
		require_once('settings-pages/welcome.php');
		gr_options_welcome();
		break;
	
	}
	$_SESSION['gr_settings_curr_page'] = $page;
	?>
	</div>
	</div>
	<?php
}

// wird aufgerufen von gr_display_settings_page und ruft selbst gr_settings_tabs auf, um die reihenfolge der Tabs zu bestimmen
// gibt außerdem die navigation der tabs aus
function gr_the_settings_tabs(){
	global $redir_tab;
	$tabs = gr_settings_tabs();

	if ( !empty($tabs) ) {
		echo '<div id="wpec_goodrelations_nav_bar" style="width:100%;">';
		echo "<ul id='sidemenu' >\n";
		if ( isset($redir_tab) && array_key_exists($redir_tab, $tabs) )
		$current = $redir_tab;
		elseif ( isset($_GET['tab']) && array_key_exists($_GET['tab'], $tabs) )
		$current = $_GET['tab'];
		else {
			$keys = array_keys($tabs);
			$current = array_shift($keys);
		}
		foreach ( $tabs as $callback => $text ) {
			$class = '';
			if ( $current == $callback ) {
				$class = " class='current'";
			}
			$href = add_query_arg(array('tab'=>$callback));
			$href = remove_query_arg( 'updated', $href );
			$href = remove_query_arg( 'error', $href );			
			$href = wp_nonce_url($href, "tab-$callback");
			$link = "<a href='" . clean_url($href) . "'$class>$text</a>";
			echo "\t<li id='" . attribute_escape("tab-$callback") . "'>$link</li>\n";
		}
		echo "</ul>\n";
		
		echo '</div>';
		echo "<div style='clear:both;'></div>";
	}

}

// wird aufgerufen von gr_the_settings_tabs und legt die reihenfolge der tabs fest
// gibt außerdem die möglichkeit über den filter
// 'wpec-goodrelations_settings_tabs' die reihenfolge der tabs zu ändern 
// oder weitere hinzuzufügen
function gr_settings_tabs() {
	$_default_tabs = array(
	'welcome' => __('Welcome', 'wpec-goodrelations'),
	'general' => __('General Options', 'wpec-goodrelations'),
	'company' => __('Company Data', 'wpec-goodrelations'),
	'lososp' => __('Store locations Data', 'wpec-goodrelations'),
	'global_product_options' => __('Global product Options', 'wpec-goodrelations'),
	);

	return apply_filters('wpec-goodrelations_settings_tabs', $_default_tabs);
}

/////////////////////////////////////////////////////////
// add / edit Product
/////////////////////////////////////////////////////////

/// legt fest, dass grundsätzlich die globalen product werte angenommen werden
// und ruft gr_edit_product_form auf, die den html inhalt enthält
// die funktion übernimmt die variable $product_data und erweitert sie
function gr_product_meta_box($product_data=''){
	global $closed_postboxes, $wpdb, $variations_processor;
	
	// define defaults for goodrelations product data 
	// all values which can be set global are checked
	$product_data['gr_globals']['gr_BusinessFunction'] = 1;
	$product_data['gr_globals']['gr_eligibleCustomerTypes'] = 1;
	$product_data['gr_globals']['gr_condition'] = 1;
	$product_data['gr_globals']['gr_billingIncrement'] = 1;
	$product_data['gr_globals']['gr_UnitOfMeasurement'] = 1;
	$product_data['gr_globals']['gr_language'] = 1;
	$product_data['gr_globals']['gr_DeliveryMethod'] = 1;
	$product_data['gr_globals']['warranty'] = 1;
	$product_data['gr_globals']['gr_availableAtOrFrom'] = 1;
	$product_data['gr_globals']['gr_PaymentMethod'] = 1;
	$product_data['gr_globals']['gr_validity'] = 1;
	
	$sql ="SELECT `meta_key`, `meta_value` FROM ".WPSC_TABLE_PRODUCTMETA." WHERE `meta_key` LIKE 'gr_%' AND `product_id`=".$product_data['id'];
	$results = $wpdb->get_results($sql, ARRAY_A);
	if ($results) {
	foreach ($results as $result) {
		$product_data[$result['meta_key']] = maybe_unserialize($result['meta_value']);
		
	}
	}
	$siteurl = get_option('siteurl');
	$output='';
	if ($product_data == 'empty') {
		$display = "style='display:none;'";
	}

	?> <div id='gr_product_meta_box' class='postbox <?php echo ((array_search('gr_product_meta_box', $product_data['closed_postboxes']) !== false) ? 'closed' : '');	?>' <?php echo ((array_search('gr_product_meta_box', $product_data['hidden_postboxes']) !== false) ? 'style=\"display: none;\"' : ''); ?>>
	
	
	
	
	<h3 class='hndle'><?php echo GoodRelations; ?></h3>
	<div class='inside'>
	
	<?php gr_edit_product_form($product_data) ?>
	</div>
	</div>
	<?php 

	$output = apply_filters('gr_product_meta_box', $output);

	return $output;
}

// wird von gr_product_meta_box aufgerufen und soll die html -form 
// für die goodrelations produkt daten wiedergeben
// function gr_edit_product_form
function gr_edit_product_form($product_data) {
$gr_setup = get_option('gr_setup');
if ( $gr_setup['tables'] == 'created' && $gr_setup['businessentity'] == 'done' && $gr_setup['global_product_options'] == 'done' && $gr_setup['gr_do_annotation'] ) { 
require_once('settings-pages/single-product.php');
gr_edit_product_form_show($product_data);
}
else {
echo '<font color="red"><strong>You need to complete the Setup of the GoodRelations for WP E-Commerce Plugin first!</strong></font><br />';
echo '<i><a href="admin.php?page=wpec_goodrelations">Follow this link!</a></i>';
}
}

// verändert die reihenfolge der angezeigten produktoptionen, so dass
// die goodrelations meta box weiter oben angezeigt wird.
// fügt hierzu einen filter hinzu
add_filter('wpsc_products_page_forms','gr_edit_product_page_filter',10,1);
// wird vom filter aufgerufen
function gr_edit_product_page_filter ($order){
	//echo $order;
	$new_order = array(
	"wpsc_product_category_and_tag_forms",
	"wpsc_product_price_and_stock_forms",
	"wpsc_product_shipping_forms",
	"gr_product_meta_box",
	"wpsc_product_variation_forms",
	"wpsc_product_advanced_forms",
	"wpsc_product_image_forms",
	"wpsc_product_download_forms"
	);
	return $new_order;
	
}

?>
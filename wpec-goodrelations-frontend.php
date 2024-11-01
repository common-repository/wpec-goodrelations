<?php
// Frontend
// contains
//	|->Hooks
// 	|-> Header modification
//	|-> support functions
//	|-> Businessentity
//	|	|-> Lososp
//	|-> Productannotation

//////////////////////////////////
// Hooks
//////////////////////////////////

if($gr_setup['do_header']['namespace'] == '1') {
	// filter für language_attributes
	add_filter('language_attributes', 'gr_language_attributes');
}
if($gr_setup['do_header']['doctype'] == '1') {
	// haken für buffer setzen
	add_action('get_header', 'buffer_start');
	add_action('wp_head', 'buffer_end');
}

if($gr_setup['gr_do_annotation'] == 'automatic' ) {
	// Inserts businessentity on front page of wordpress 
	// if latest posts are displayed, it will be shown before the first post
	add_action('get_template_part_loop','gr_businessentity');
	// on static pages or if get_template_part_loop is not called it will be displayed in the wp_footer
	add_action('wp_footer', 'gr_businessentity');

	// Inserts Annotation after before description
	add_action('wpsc_product_before_description', 'gr_product_annotation');
}


function gr_template_company() {
	global $gr_setup;
	if($gr_setup['gr_do_annotation'] == 'template') gr_businessentity();
}
function gr_template_product($productid = 0) {
	global $gr_setup;
	if($gr_setup['gr_do_annotation'] == 'template') {
			gr_product_annotation($productid);
	}
}

// Header modification
///////////////////////////////////////////////////////////////
//															 //
//			Replacing Doctype and Header Tags				 //
//															 //
///////////////////////////////////////////////////////////////


// functions für buffer
function buffer_start() { ob_start("callback"); }
function buffer_end() { ob_end_flush(); }

//manipulation des Headercodes via buffer
function callback($buffer) {  
	global $devmode;
	if($devmode) echo "<b>function</b> callback($buffer)<br />";
	// suche ob "<!DOCTYPE" in $buffer vorkommt und bestimme die position von "<!DOCTYPE" in $buffer
	$gr_needle_doctype = "<!DOCTYPE";
	$gr_pos_doctype = strpos($buffer, $gr_needle_doctype);
	// wenn "<!Doctype" in $buffer vorkommt
	if($gr_pos_doctype !== false) {
		// bestimme die position des schließenden ">" tag von <!doctype  
		$gr_pos_doctype_closing = strpos($buffer, ">");
		// erhöhe den positionsmaker um eins
		$gr_pos_doctype_closing++;
		// gebe $buffer ab der position des schließenden tags von <!doctype> zurück
		$buffer = substr($buffer, $gr_pos_doctype_closing);
		// stelle den neuen doctype an den beginn von $buffer
		$buffer = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">'.$buffer;
		// testsequenz  
		// $buffer = "gr_pos_doctype =".$gr_pos_doctype."gr_pos_doctype_closing = ".$gr_pos_doctype_closing.$buffer;
	}

	// charset anpassung
	$gr_char_search = '<meta charset="'.get_bloginfo('charset').'" />';
	$gr_char_replace = '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo('charset').'" />';
	$buffer = str_replace($gr_char_search, $gr_char_replace, $buffer);
	
	// kommentar im quelltext
	if($devmode) $buffer = "<!-- start buffer -->".$buffer."<!-- ende buffer -->";

	return $buffer;
}



function gr_language_attributes($output) {
	// entfernt sich selbst aus dem filter, um einer endlosschleife vorzubeugen
	remove_filter('language_attributes', 'gr_language_attributes');
	// generiert language_attributes mit dem parameter xhmtl und dem zusatz ´xmlns´ und ´version´ neu
	$output = language_attributes('xhtml').' xmlns="http://www.w3.org/1999/xhtml" version="XHTML+RDFa 1.0" ';

	return $output;
}

// support functions
// several support functions

// converts the product weight units of wpec to goodrelations conform units
function gr_product_weight_unit() {
	global $wpsc_query;
	$product_weight_unit = $wpsc_query->product['weight_unit'];
	switch ($product_weight_unit) {
	case 'pound' :
		$product_weight_unit = "LBM";
		break;
	case 'ounce' :
		$product_weight_unit = "ONZ";
		break;
	case 'gram' :
		$product_weight_unit = "GRM";
		break;
	case 'kilogram' :
		$product_weight_unit = "KGM";
		break;
	}
	return $product_weight_unit;
}
// converts several units of wpec to goodrelation conform units
function gr_unit_converter($unit) {
	$unit = strtolower ($unit);
	switch ($unit) {
	case 'pound' :
		$unit = "LBM";
		break;
	case 'ounce' :
		$unit = "ONZ";
		break;
	case 'gram' :
		$unit = "GRM";
		break;
	case 'kilogram' :
		$unit = "KGM";
		break;
	case 'meter' :
		$unit = "MTR";
		break;
	case 'in' :
		$unit = "INH";
		break;
	case 'cm' :
		$unit = "CMT";
		break;
		default :
		$unit = strtoupper ($unit);
		break;
	}
	return $unit;
}

// returns sth like 'http://www.example.com/wordpress/#company_1'
function gr_node_company () {
	global $gr_data;
	return $gr_data->company_node($pos_id);
}
// returns sth like 'http://www.example.com/wordpress/#address_3
function gr_node_address ($id) {
	$gr_node = home_url().'/#address_'.$id;
	return $gr_node;
}

// returns sth like 'http://www.example.com/wordpress/#pos_2'
function gr_node_pos($pos_id) {
	global $gr_data;
	return $gr_data->lososp_node($pos_id);
}

// returns sth like 'http://www.example.com/wordpress/#OpeninghoursSpecifictaion_2_mon_am_5'
function gr_node_openinghours($openinghours_id) {
	global $gr_data;
	return $gr_data->openinghours_node($openinghours_id);
}

function gr_currency($currency_type = 0) {
	global $wpdb;
	if(!$currency_type) $currency_type = get_option('currency_type');
	$gr_currency_data = $wpdb->get_var("SELECT `code` FROM `".WPSC_TABLE_CURRENCY_LIST."` WHERE `id`='".$currency_type."' LIMIT 1");
	return $gr_currency_data;
}

//class gr_data
$query_number = 0;
$gr_data = new gr_data();

class gr_data {
	var $address_table;
	var $openinghours_table;
	var $this_product;

	
	private function address_query() {
		if(!$this->address_table) {
			global $wpdb;
			$this->address_table = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."gr_address", ARRAY_A);
		}

	}
	private function openinghours_query() {
		if(!$this->openinghours_table) {
			global $wpdb;
			$this->openinghours_table = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."gr_openinghours", ARRAY_A);
		}

	}

	public function lososp_node($id = 0) {
		if($id) {

			if(!$this->address_table) $this->address_query();
			$query = $this->address_table;
			if ( is_array($query) ) {
				foreach ($query as $pointer=>$result) {

					if ($result['id'] == $id && $result['kind'] == '2') {
						$gr_node_lososp = home_url().'/#'.$result['annotation'].'_'.$result['id'];
						return $gr_node_lososp;
						break;
					}
				}
			}
		}
		else {
			return "error - no id";
		}
	}
	// returns sth like 'http://www.example.com/wordpress/#company_1'
	public function company_node () {
		if(!$this->address_table) $this->address_query();
		$query = $this->address_table;
		if(is_array($query)){
			foreach ($query as $pointer=>$result) {
				if ($result['kind'] == '1') {
					$gr_node_comp = home_url().'/#'.$result['annotation'].'_'.$result['id'];
					return $gr_node_comp;
					break;
				}
			}
		}
	}
	public function openinghours_node($id = 0) {
		if($id) {
			if(!$this->openinghours_table) $this->openinghours_query();
			$query = $this->openinghours_table;
			if ( is_array($query) ) {
				foreach ($query as $pointer=>$result) {
					if ($result['id'] == $id) {
						$gr_node_openh = home_url().'/#OpeningHoursSpecification_'.$result['pos_id'].'_'.$result['day'].'_'.$result['am_pm'].'_'.$result['id'];
						return $gr_node_openh;
						break;
					}
				}
			}
		}
	}
	
	// returns the openinghours of a lososp, match by pos_id
	public function openinghours($id = 0) {
		if ($id) {
			if(!$this->openinghours_table) $this->openinghours_query();
			$query = $this->openinghours_table;
			if (is_array($query)) {
						foreach ($query as $pointer=>$result) {
				
					if ($result['pos_id'] == $id) {
						$openinghoursdata[] = $result;
					}
				}		
				return $openinghoursdata;
			}
		}
	}
	
	public function company_data() {
		if(!$this->address_table) $this->address_query();
		$query = $this->address_table;
		if (is_array($query)){
			foreach ($query as $pointer=>$result) {
				if($result['kind'] == '1') {
					return $query[$pointer];
					break;
				}
			}
		}
	}
	public function lososp_data($id = 0) {
		if(!$this->address_table) $this->address_query();
		$query = $this->address_table;
		
		if(!$id && is_array($query)) {
			foreach ($query as $pointer=>$result) {
				if($result['kind'] == '2') {
					$lososp_data[] = $query[$pointer];
				}
			}
			return $lososp_data;
		}
		elseif($id && is_array($query)) {
			foreach ($query as $pointer=>$result) {
				if($result['kind'] == '2' && $result['id'] == $id) {
					$lososp_data = $query[$pointer];
					return $lososp_data;
					break;
				}
			}
		}
	}
}


// end of support functions
///////////////////////////////////////////////////////////////
//															 //
//		Adding gr:BusinessEntity to Shop-Home				 //
//															 //
///////////////////////////////////////////////////////////////

// insert businessentity
function gr_businessentity() {
	global $devmode, $gr_setup; 
	if($devmode) echo "<b>function</b> gr_businessentity()<br />Number of queries: ".get_num_queries()."<br />";

	// kommentar im quelltext
	
	
	if ((is_front_page() && !is_paged()) || ( $gr_setup['gr_do_annotation'] == 'template' )){
		global $gr_data;
		$output = include_once('company_template.php');
		return $output;
	}
}

/////////////// END OF BUSINESSENTITY //////////////////////

///////////////////////////////////////////////////////////////
//															 //
//			´Adding Product-Data to Product-Page 			 //
//															 //
///////////////////////////////////////////////////////////////

// Produkt Annotation
if (!$gr_setup['annotation_in_category']  == '1') $gr_product_counter = 0;
function gr_product_annotation($product_id = 0,$gr_annotation = 0) {
	global $devmode, $gr_product_counter, $gr_setup, $wpdb; 
	if($devmode) echo "<b>function</b> gr_product_annotation()<br />Queries before gr_product_annotation(): ".get_num_queries()."<br />";
	if($devmode) $devmode_queries = get_num_queries();
	if (!$gr_setup['annotation_in_category']  == '1') {

		if($gr_product_counter == 0) 
		{
			$wpsc_this_page_url = wpsc_this_page_url();
			$wpsc_the_product_permalink = wpsc_the_product_permalink();
			if ($wpsc_this_page_url == $wpsc_the_product_permalink ) $gr_do_annotation = true;
			$gr_product_counter++;
		}
	}

	if ($gr_setup['gr_do_annotation'] == 'template' || $gr_setup['annotation_in_category'] == '1')
	{
		$gr_do_annotation = true;
		$wpsc_the_product_permalink = wpsc_the_product_permalink();
	}
	
	if($gr_do_annotation) {

		global $wpsc_query;


		// sets the xml language tag to en by default;
		$gr_the_product_language = "en";
		// price calculation like in /wp-e-commerce/wpsc-includes/processing.functions.php
		if(($wpsc_query->product['special_price'] > 0) && (($wpsc_query->product['price'] - $wpsc_query->product['special_price']) >= 0) && ($wpsc_query->product['special'] !== 0)) {
			$price = $wpsc_query->product['price'] - $wpsc_query->product['special_price'];
		} else {
			$price = $wpsc_query->product['price'];
		}
		
		
		// chars to change node_names
		$gr_replace = array('-' => '_', '&auml;' => 'ae', '&ouml;' => 'oe', '&uuml;' => 'ue', ' ' => '_',	'?' => '_',	'&' => '_', '#' => '_', '%' => '_',);
		$gr_product = array(
		'permalink' => $wpsc_the_product_permalink,
		'gr_description' => htmlspecialchars (strip_tags(wpsc_the_product_description())),
		'gr_comment' => htmlspecialchars (strip_tags( wpsc_the_product_additional_description() )),
		'gr_language' => $gr_the_product_language,
		'gr_title' => htmlspecialchars(wpsc_the_product_title()),
		'gr_image' => wpsc_the_product_image(),
		'gr_quantity' => wpsc_product_remaining_stock(),
		'gr_weight' => $wpsc_query->product['weight'],
		'weight_unit' =>$wpsc_query->product['weight_unit'],
		'id' => $wpsc_query->product['id'],
		'gr_price' => $price,
		'gr_old_price' => $wpsc_query->product['price'],
		'gr_thumbnail' => wpsc_the_product_thumbnail(),
		'gr_notax' => $wpsc_query->product['notax'],
		'gr_category' => $wpsc_query->product['category'],
		'gr_currency' => gr_currency(),
		'gr_product_validFrom' => date(c),
		'gr_product_validThrough_days' => 7,
		'gr_price_validFrom' => date(c),
		'gr_price_validThrough_days' => 2,
		'gr_UnitOfMeasurement' => 'C62',
		);
		
		// sets unitofmeasurement to c62 if nothing else is provided
		if(!$gr_product['gr_UnitOfMeasurement']) $gr_product['gr_UnitOfMeasurement'] = "C62";
		
		// get metadata
		
		// get all metadata as array_value of $gr_product[]
		// includes  the wpec metadata like
		// url_name sku table_rate_price custom_tax dimensions(subclasses: height, width, depth ) merchant_notes engraved 
		// can_have_uploaded_image external_link unpublish_oos thumbnail_width thumbnail_height currency[]
		// and the additional metadata of the goodrelationsplugin
		// gr_ean gr_gtin14 gr_mpn gr_language gr_Labor-BringIn gr_PartsAndLabor-BringIn gr_PartsAndLabor-PickUp gr_color
		// gr_serialnumber gr_billingIncrement gr_UnitOfMeasurement gr_price_validFrom gr_price_validThrough gr_product_validFrom 
		// gr_product_ValidThrough gr_product_availabilityStarts gr_product_availabilityEnds gr_priceType gr_node_name gr_availableAtOrFrom 
		// gr_BusinessFunction gr_eligibleCustomerTypes
		// gr_condition 
		$results = $wpdb->get_results("SELECT `meta_key`,`meta_value` FROM `".WPSC_TABLE_PRODUCTMETA."` WHERE `product_id`='".$gr_product['id']."'", ARRAY_A);
		if(is_array($results)) {
			foreach ($results as $result) {
				$gr_product[$result['meta_key']] = maybe_unserialize($result['meta_value']);
			}
		}
		if ($gr_product['gr_no_annotation']['checkbox'] == '1') return "<!-- no goodrelations data for this product -->";

		if( $gr_product['gr_globals']['gr_DeliveryMethod'] ) $gr_product['gr_DeliveryMethod'] = get_option('gr_DeliveryMethod');
		if( $gr_product['gr_globals']['gr_BusinessFunction'] ) $gr_product['gr_BusinessFunction'] = get_option('gr_BusinessFunction');
		if(	$gr_product['gr_globals']['gr_eligibleCustomerTypes'] ) $gr_product['gr_eligibleCustomerTypes'] = get_option('gr_eligibleCustomerTypes');
		if(	$gr_product['gr_globals']['gr_condition'] ) $gr_product['gr_condition'] = get_option('gr_condition');
		if(	$gr_product['gr_globals']['gr_billingIncrement'] ) $gr_product['gr_billingIncrement'] = get_option('gr_billingIncrement');
		if(	$gr_product['gr_globals']['gr_UnitOfMeasurement'] ) $gr_product['gr_UnitOfMeasurement'] = get_option('gr_UnitOfMeasurement');
		if(	$gr_product['gr_globals']['gr_language'] ) $gr_product['gr_language'] = htmlspecialchars(get_option('gr_language'));
		if(	$gr_product['gr_globals']['warranty'] ) {
			$gr_product['gr_PartsAndLabor-PickUp'] = get_option('gr_PartsAndLabor-PickUp');
			$gr_product['gr_PartsAndLabor-BringIn'] = get_option('gr_PartsAndLabor-BringIn');
			$gr_product['gr_Labor-BringIn'] = get_option('gr_Labor-BringIn');
		}
		if(	$gr_product['gr_globals']['gr_availableAtOrFrom'] ) $gr_product['gr_availableAtOrFrom'] = get_option('gr_availableAtOrFrom');
		if(	$gr_product['gr_globals']['gr_PaymentMethod'] ) $gr_product['gr_PaymentMethod'] = get_option('gr_PaymentMethod');
		if( $gr_product['gr_globals']['gr_validity'] )	{
			$gr_validity = get_option('gr_validity');
			$gr_product['gr_product_validThrough_days'] = $gr_validity['product'];
			$gr_product['gr_price_validThrough_days'] = $gr_validity['price'];
		}
		
		
		$gr_product['gr_node_name'] = wpsc_the_product_id()."_".str_replace(array_keys($gr_replace), array_values($gr_replace), wpsc_the_product_title());

		$gr_product['gr_product_validThrough'] = date(c, mktime(date(H), date(i), date(s),   date(m)  , date(d)+$gr_product['gr_product_validThrough_days'], date(Y)));
		$gr_product['gr_price_validThrough'] = date(c, mktime(date(H), date(i), date(s),   date(m)  , date(d)+$gr_product['gr_price_validThrough_days'], date(Y)));
		
		
		if ( get_option('product_ratings') == 1 ) {
			$sql = "SELECT AVG(`rated`) AS 'average', COUNT(*) AS 'count' FROM ".WPSC_TABLE_PRODUCT_RATING." WHERE productid = '".$gr_product['id']."'";
			$gr_rating = $wpdb->get_results($sql, ARRAY_A);
			$gr_product['rating_average'] = round($gr_rating[0]['average'], 2);
			$gr_product['rating_count'] = $gr_rating[0]['count'];
			unset($sql);
			unset($gr_rating);
		}
		
		$sql = "SELECT ".$wpdb->prefix."wpsc_currency_list.isocode FROM ".$wpdb->prefix."wpsc_currency_list, ".$wpdb->prefix."wpsc_category_tm, ".$wpdb->prefix."wpsc_item_category_assoc WHERE
(".$wpdb->prefix."wpsc_currency_list.id = ".$wpdb->prefix."wpsc_category_tm.countryid AND ".$wpdb->prefix."wpsc_category_tm.visible = 1 
AND ".$wpdb->prefix."wpsc_category_tm.categoryid = ".$wpdb->prefix."wpsc_item_category_assoc.category_id 
AND ".$wpdb->prefix."wpsc_item_category_assoc.product_id =".$gr_product['id']." )";
		$gr_regions = $wpdb->get_results($sql, ARRAY_A);
		$gr_regions_j = count($gr_regions);
		$gr_regions_i=0;
	
		$output = include('product_template.php');
		return $output;
	}
}

////// END OF PRODUCTDATA
?>
<?php
function gr_setup_installation() {
gr_setup_create_tables();
gr_setup_global_options();
gr_setup_product_globals();
?>
<br />
You need to fill the following forms about your company and enter your global product options!
<br />
<br />
<a href="admin.php?page=wpec_goodrelations"> &gt;&gt; click this link to continue... </a>
<br />
<?php
}
// During the installation of the GoodRelations for WP-E-Commerce Plugin
// the following tables have to be created:
// (wp_)gr_address, (wp_)gr_openinghours
// And the following data has to be added to the database:
// For each product all global defineable values have to be set to global
// INSERT INTO  `wp02`.`wp_wpsc_productmeta` (
// `id` ,
// `product_id` ,
// `meta_key` ,
// `meta_value` ,
// `custom`
// )
// VALUES (
// NULL ,
// '{product_id}',  
// 'gr_globals', 
// 'a:12:{s:11:\"gr_validity\";s:1:\"1\";s:11:"gr_language";s:1:"1";s:8:"warranty";s:1:"1";s:20:"gr_UnitOfMeasurement";s:1:"1";s:19:"gr_billingIncrement";s:1:"1";s:12:"gr_condition";s:1:"1";s:24:"gr_eligibleCustomerTypes";s:1:"1";s:17:"gr_DeliveryMethod";s:1:"1";s:16:"gr_PaymentMethod";s:1:"1";s:19:"gr_BusinessFunction";s:1:"1";s:20:"gr_availableAtOrFrom";s:1:"1";s:3:"foo";s:1:"1";}',
// '0'
// );
// The global values have to be defined to a standard:
// gr_DeliveryMethod => DeliveryModeMail (a:2:{s:16:"DeliveryModeMail";s:1:"1";s:3:"foo";s:1:"1";})
// gr_PaymentMethod => PayPal, COD (a:3:{s:3:"COD";s:1:"1";s:6:"PayPal";s:1:"1";s:3:"foo";s:1:"1";})
// gr_BusinessFunction => Sell (a:2:{s:4:"sell";s:1:"1";s:3:"foo";s:1:"1";})
// warranty => no warranty
// gr_UnitOfMeasurement => C62
// gr_billingIncrement => 1
// gr_availableAtOrFrom => no value
// gr_condition => new
// gr_eligibleCustomerTypes = Enduser (a:2:{s:7:"enduser";s:1:"1";s:3:"foo";s:1:"1";})
// gr_language => en
// gr_validity = Price=>2days Offering=>7days (a:2:{s:5:"price";s:1:"2";s:8:"offering";s:1:"7";})
//
function gr_setup_product_globals() {
	global $wpdb;
	$productid = $wpdb->get_results("SELECT id FROM {$wpdb->prefix}wpsc_product_list WHERE 1", ARRAY_A);
	$numberofproducts = count($productid);
	$i = 0;
	foreach($productid as $id) {
		$sql="INSERT INTO {$wpdb->prefix}wpsc_productmeta ( id, product_id, meta_key, meta_value, custom )
VALUES ( NULL, '{$id['id']}', 'gr_globals', 'a:12:{s:11:\"gr_validity\";s:1:\"1\";s:11:\"gr_language\";s:1:\"1\";s:8:\"warranty\";s:1:\"1\";s:20:\"gr_UnitOfMeasurement\";s:1:\"1\";s:19:\"gr_billingIncrement\";s:1:\"1\";s:12:\"gr_condition\";s:1:\"1\";s:24:\"gr_eligibleCustomerTypes\";s:1:\"1\";s:17:\"gr_DeliveryMethod\";s:1:\"1\";s:16:\"gr_PaymentMethod\";s:1:\"1\";s:19:\"gr_BusinessFunction\";s:1:\"1\";s:20:\"gr_availableAtOrFrom\";s:1:\"1\";s:3:\"foo\";s:1:\"1\";}', '0'
)";
		$result = $wpdb->query($sql);
		if ($result) $i++;
	}
	echo "<br />Updated {$i} of {$numberofproducts} Products<br />";
}
function gr_setup_global_options() {
	$gr_DeliveryMethod = array(
	'DeliveryModeMail' => 1
	);
	$gr_PaymentMethod = array(
	'Paypal' => 1
	);
	$gr_BusinessFunction = array(
	'Sell' => 1
	);
	$gr_eligibleCustomerTypes = array(
	'Enduser' => 1
	);
	$gr_validity = array(
	'price' => 2,
	'product' => 7
	);
	add_option('gr_DeliveryMethod' , $gr_DeliveryMethod, '', 'yes');
	add_option('gr_PaymentMethod', $gr_PaymentMethod, '', 'yes');
	add_option('gr_BusinessFunction', $gr_BusinessFunction, '', 'yes');
	add_option('gr_UnitOfMeasurement', 'C62', '', 'yes');
	add_option('gr_billingIncrement', '1', '', 'yes');
	add_option('gr_availableAtOrFrom', null, '', 'yes');
	add_option('gr_condition', 'new', '', 'yes');
	add_option('gr_eligibleCustomerTypes', $gr_eligibleCustomerTypes, '', 'yes');
	add_option('gr_language', 'en', '', 'yes');
	add_option('gr_validity', $gr_validity, '', 'yes');

}

function gr_setup_create_tables() {
	global $wpdb;
	// Table (wp_)gr_address
	$sql="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gr_address (
id int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
street_address varchar(100) NOT NULL,
postal_code int(10) NOT NULL,
locality varchar(50) NOT NULL,
region varchar(50) NOT NULL,
country_name varchar(20) NOT NULL,
email varchar(50) NOT NULL,
tel varchar(15) NOT NULL,
logo varchar(100) NOT NULL,
url varchar(100) NOT NULL,
kind int(1) NOT NULL COMMENT '1 = BusinessEntitity 2=LocationOfSalesOrServiceProvisioning 3=Manufacterer',
annotation varchar(10) NOT NULL,
lati varchar(11) NOT NULL,
`long` varchar(11) NOT NULL,
duns varchar(20) NOT NULL,
gln varchar(20) NOT NULL,
isicv4 varchar(11) NOT NULL,
naics varchar(11) NOT NULL,
`language` varchar(3) NOT NULL,
PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	$result = $wpdb->query($sql);
	if ($result){
		echo "<br />Added table {$wpdb->prefix}gr_address to Database<br />";
	}
	$sql="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gr_openinghours (
id int(11) NOT NULL AUTO_INCREMENT,
pos_id int(11) NOT NULL,
`day` varchar(7) NOT NULL COMMENT 'Possible values: mon, tue, wed, thu, fri, sat, sun, pub, mon_fri',
am_pm varchar(2) NOT NULL,
opens time NOT NULL,
closes time NOT NULL,
PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	$result = $wpdb->query($sql);
	if ($result) { 
		echo "<br />Added table {$wpdb->prefix}gr_openinghours to Database<br />";
	}
	$setup = array (
		'tables' => 'created',
		'gr_do_annotation' => 'automatic',
		'do_header' => array (
			'doctype' => '1',
			'namespace' => '1',
		),
		'gr_notify' => array (
			'do' => '1',
			'uri' => home_url().'/sitemap.xml',
			'schedule' => '7',
			'last' => '0',
			'contact' => 'enter your email here'
		)
		
	);
	update_option('gr_setup', $setup, '', 'yes');
}
?>

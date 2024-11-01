<?php		
//////////////////////////////////////////////////////////////////////////////////
//  This work is based on the GoodRelations ontology, developed by Martin Hepp 	//
//		  for further information see http://purl.org/goodrelations				//
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////
//					 Copyright (c) 2010 by Christian Junghanns					//
//			 This company_template.php is available under the terms of			//
//					Creative Commons Attribution 3.0 license					//
//							see license-cc-by.txt or 							//
//				vist http://creativecommons.org/licenses/by/3.0/				//
//																				//
//	  You are free																//
//		— to copy, distribute and transmit the work								//
//		- to adapt the work														//
// 	  as long as you attribute your work by stating "This work is based on		//
//	  company_template.php of wpec-goodrelations plugin for wordpress" and		//
//	  linking back to http://www.christian-junghanns.de/wpec-goodrelations		//
//////////////////////////////////////////////////////////////////////////////////

// needed vars:
// $gr_company (
//	id
//	country_name
//	locality
//	postal-code
//	region
// 	street-address
//	name
//	lati
//	long
//	duns
//	gln
// 	isicv4
//	naics
// 	url
//	tel
// 	logo
// )
// $store_locations (
// 	i (
//		id
//		name
// 		language
//		duns {'same as company'||''}
//		street-address
//		country-name
//		locality
//		postal_code
//		region
//		tel
//		logo
//		url
//		lati
//		long
//	)
// )
// $openinghours($store_locations[i][id](
//	i (
//		id
//		pos_id
//		opens
//		closes
// 		day {mon_fri||mon||tue||wed||thu||fri||sat||sun||pub}
//	)
// )
?>

<div xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" 
	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" 
	xmlns="http://www.w3.org/1999/xhtml" 
	xmlns:foaf="http://xmlns.com/foaf/0.1/" 
	xmlns:gr="http://purl.org/goodrelations/v1#" 
	xmlns:vcard="http://www.w3.org/2006/vcard/ns#" 
	xmlns:xsd="http://www.w3.org/2001/XMLSchema#"
	xmlns:v="http://rdf.data-vocabulary.org/#"
	xmlns:media="http://search.yahoo.com/searchmonkey/media/">
	<div about="<?php echo home_url(); ?>/#GoogleCheckout" typeof="gr:PaymentMethod"></div>
<?php
// load company_data
$gr_company = $gr_data->company_data();
	if ($gr_company) {
?>
	<div about="<?php echo gr_node_company(); ?>" typeof="gr:BusinessEntity"> 
		<div rel="vcard:adr">
			<div about="<?php echo gr_node_address($gr_company['id']); ?>" typeof="vcard:Address">
<?php
		if ( $gr_company['country_name'] ) { 
?>
			<div property="vcard:country-name" content="<?php echo htmlspecialchars( $gr_company['country_name'] ); ?>" xml:lang="en"></div> 
<?php 
		} 
?>
<?php  
		if ( $gr_company['locality'] ) { 
?>
			<div property="vcard:locality" content="<?php echo htmlspecialchars( $gr_company['locality'] ); ?>" xml:lang="en"></div> 
<?php 
		} 
?>
<?php  
if ( $gr_company['postal_code'] ) { 
?>
			<div property="vcard:postal-code" content="<?php echo htmlspecialchars( $gr_company['postal_code'] ); ?>" datatype="xsd:string"></div> 
<?php 
}
 ?>
<?php  
if ( $gr_company['region'] ) { 
?>
			<div property="vcard:region" content="<?php echo htmlspecialchars( $gr_company['region'] ); ?>" xml:lang="en"></div> 
<?php 
} 
?>
<?php
  if ( $gr_company['street_address'] ) { 
  ?>
			<div property="vcard:street-address" content="<?php echo htmlspecialchars( $gr_company['street_address'] ); ?>" xml:lang="en"></div>
<?php 
} 
?>
			</div> 
		</div>
<?php
	if ( $gr_company['name'] ) {
?>
		<div property="gr:legalName" content="<?php echo htmlspecialchars( $gr_company['name'] ); ?>" xml:lang="en"></div>
		<div property="vcard:fn" content="<?php echo htmlspecialchars( $gr_company['name'] ); ?>" xml:lang="en"></div>
<?php
	} 
?>
<?php 
	if ( $gr_company['lati'] &&  $gr_company['long'] ) { 
?>
		<div rel="vcard:geo v:geo">
			<div about="<?php echo gr_node_address($gr_company['id']); ?>_geo" typeof="rdf:Description vcard:Location">
				<div property="vcard:latitude v:latitude" content="<?php echo htmlspecialchars( $gr_company['lati'] ); ?>" datatype="xsd:float"></div>
				<div property="vcard:longitude v:longitude" content="<?php echo htmlspecialchars( $gr_company['long'] ); ?>" datatype="xsd:float"></div>
			</div>
		</div>
<?php 
	} 
?>
<?php
	if ( $gr_company['duns'] ) { 
?>
		<div property="gr:hasDUNS" content="<?php echo htmlspecialchars( $gr_company['duns'] ); ?>" datatype="xsd:string"></div>
<?php 
	} 
?>
<?php
	if ( $gr_company['gln'] ) { 
?>
		<div property="gr:hasGlobalLocationNumber" content="<?php echo htmlspecialchars( $gr_company['gln'] ); ?>" datatype="xsd:string"></div>
<?php 
	} 
?>
<?php
	if ( $gr_company['isicv4'] ) { 
?>
		<div property="gr:hasISICv4" content="<?php echo htmlspecialchars( $gr_company['isicv4'] ); ?>" datatype="xsd:string"></div>
<?php 
	} 
?>
<?php
	if ( $gr_company['naics'] ) { 
?>
		<div property="gr:hasNAICS" content="<?php echo htmlspecialchars( $gr_company['naics'] ); ?>" datatype="xsd:string"></div>
<?php 
	} 
?>
<?php	
	// load store locations
	$store_locations = $gr_data->lososp_data();
	if ( is_array ($store_locations) ) {
?>
		<div rel="gr:hasPOS">
<?php
		foreach ($store_locations as $store_location) {
			// load openinghours for store locations
			$openinghours = $gr_data->openinghours($store_location['id']);
?>
			<div about="<?php echo gr_node_pos($store_location['id']); ?>" typeof="gr:LocationOfSalesOrServiceProvisioning">
				<div property="gr:name" content="<?php echo htmlspecialchars( $store_location['name'] ); ?>"></div>
				<div property="vcard:fn" content="<?php echo htmlspecialchars( $store_location['name'] ); ?>"></div>
				<div property="rdfs:label" content="<?php echo htmlspecialchars( $store_location['name'] ); ?>"></div>
<?php
			// if street-address postal-code locality or country-name of a store-location is not filled point to the adress of the bussinesentity
?>
<?php
			if ($store_location['duns'] == 'same as company' OR !$store_location['street_address'] OR ( !$store_location['postal_code'] && !$store_location['locality'] ) OR !$store_location['country_name'] ) {
?>
				<div rel="vcard:adr" resource="<?php echo gr_node_address($gr_company['id']); ?>"></div>
				<div rel="vcard:geo v:geo" about="<?php echo gr_node_address($gr_company['id']); ?>_geo"></div>
<?php 
			} 
			else {
?>
				<div rel="vcard:adr">
					<div about="<?php echo gr_node_address($store_location['id']); ?>" typeof="vcard:Address">
						<div property="vcard:country-name" content="<?php echo htmlspecialchars( $store_location['country_name'] ); ?>" xml:lang="<?php echo htmlspecialchars( $store_location['language'] ); ?>"></div> 
						<div property="vcard:locality" content="<?php echo htmlspecialchars( $store_location['locality'] ); ?>" xml:lang="<?php echo htmlspecialchars( $store_location['language'] ); ?>"></div> 
						<div property="vcard:postal-code" content="<?php echo htmlspecialchars( $store_location['postal_code'] ); ?>" datatype="xsd:string"></div> 
<?php
				if ($store_location['region']) { 
?>
						<div property="vcard:region" content="<?php echo htmlspecialchars( $store_location['region'] ); ?>" xml:lang="<?php echo htmlspecialchars( $store_location['language'] ); ?>"></div> 
<?php
}
?>
						<div property="vcard:street-address" content="<?php echo htmlspecialchars( $store_location['street_address'] ); ?>" xml:lang="<?php echo htmlspecialchars( $store_location['language'] ); ?>"></div>
					</div>
				</div>
<?php 
} 
?>
<?php
			if ($store_location['tel'])	{ 
?>				<div property="vcard:tel" content="<?php echo htmlspecialchars( $store_location['tel'] ); ?>" datatype="xsd:string"></div>
<?php }
			if ($store_location['gln'])	{
?>				<div property="gr:hasGlobalLocationNumber" content="<?php echo htmlspecialchars( $store_location['gln'] ); ?>" datatype="xsd:string"></div>
<?php }
			if ($store_location['logo']) {
?>				<div rel="foaf:depiction" resource="<?php echo htmlspecialchars( $store_location['logo'] ); ?>"></div>
				<div rel="media:image" resource="<?php echo htmlspecialchars( $store_location['logo'] ); ?>"></div>
<?php }			if ($store_location['url'])	{
?>				<div rel="foaf:page" resource="<?php echo $store_location['url'] ; ?>"></div>
				<div rel="vcard:url" resource="<?php echo $store_location['url'] ; ?>"></div>
				<div rel="rdfs:seeAlso" resource="<?php echo $store_location['url'] ; ?>"></div>
<?php }			if ( $store_location['lati'] &&  $store_location['long'] ) { 
?>				<div rel="vcard:geo v:geo">
					<div about="<?php echo gr_node_address($store_location['id']); ?>_geo" typeof="rdf:Description vcard:Location">
						<div property="vcard:latitude v:latitude" content="<?php echo htmlspecialchars( $store_location['lati'] ); ?>" datatype="xsd:float"></div>
						<div property="vcard:longitude v:longitude" content="<?php echo htmlspecialchars( $store_location['long'] ); ?>" datatype="xsd:float"></div>
					</div>
				</div>
<?php 
} 
?>
<?php
	if ( is_array ( $openinghours ) ) {
	?>
				<div rel="gr:hasOpeningHoursSpecification">
<?php
		foreach ($openinghours as $openinghour) {
?>
					<div about="<?php echo gr_node_openinghours($openinghour['id']); ?>" typeof="gr:OpeningHoursSpecification">
						<div property="gr:opens" content="<?php echo $openinghour['opens']; ?>" datatype="xsd:time"></div>
						<div property="gr:closes" content="<?php echo $openinghour['closes']; ?>" datatype="xsd:time"></div>
<?php
				if($openinghour['day'] == 'mon_fri') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Monday"></div>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Tuesday"></div>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Wednesday"></div>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Thursday"></div>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Friday"></div>
<?php
 } 
 ?>
<?php
				if($openinghour['day'] == 'mon') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Monday"></div>
<?php
 } 
?>
<?php
				if($openinghour['day'] == 'tue') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Tuesday"></div>
<?php 
} 
?>
<?php
				if($openinghour['day'] == 'wed') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Wednesday"></div>
<?php 
} 
?>
<?php
				if($openinghour['day'] == 'fri') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Friday"></div>
<?php 
} 
?>
<?php
				if($openinghour['day'] == 'sat') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Saturday"></div>
<?php 
} 
?>
<?php
				if($openinghour['day'] == 'sun') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#Sunday"></div>
<?php
 }
 ?>
<?php
				if($openinghour['day'] == 'pub') {
?>
						<div rel="gr:hasOpeningHoursDayOfWeek" resource="http://purl.org/goodrelations/v1#PublicHolidays"></div>
<?php
 } 
 ?>
					</div>
<?php
				}
?>
				</div>
<?php 	
			} 
?>
			</div>	
<?php 
		} 
?>
		</div>
<?php
	}
?>
<?php  
			if ( $gr_company['url'] ) { 
			?>
		<div rel="foaf:page" resource="<?php echo  $gr_company['url'] ; ?>"></div>
		<div rel="vcard:url" resource="<?php echo  $gr_company['url'] ; ?>"></div>
		<div rel="rdfs:seeAlso" resource="<?php echo  $gr_company['url'] ; ?>"></div>
<?php 
			} 
?>
<?php  
			if ( $gr_company['tel'] ) { 
?>
		<div property="vcard:tel" content="<?php echo htmlspecialchars( $gr_company['tel'] ); ?>" datatype="xsd:string"></div>
<?php 
			} 
?>
<?php  
			if ( $gr_company['logo'] ) { 
?>
		<div rel="foaf:depiction" resource="<?php echo htmlspecialchars( $gr_company['logo'] ); ?>"></div>
		<div rel="media:image" resource="<?php echo htmlspecialchars ( $gr_company['logo'] ); ?>"></div>
<?php 
			} 
?>
	</div>
<?php 
		} 
		?>
</div>



<?php		
//////////////////////////////////////////////////////////////////////////////////
//  This work is based on the GoodRelations ontology, developed by Martin Hepp 	//
//		  for further information see http://purl.org/goodrelations				//
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////
//				   Copyright (c) 2010 by Christian Junghanns					//
//			    This product_template.php is available under the 				//
//					Creative Commons Attribution 3.0 license					//
//							see license-cc-by.txt or 							//
//				visit http://creativecommons.org/licenses/by/3.0/				//
//																				//
//	  You are free																//
//		— to copy, distribute and transmit the work								//
//		- to adapt the work														//
// 	  as long as you attribute your work by stating "This work is based on		//
//	  company_template.php of wpec-goodrelations plugin for wordpress" and		//
//	  linking back to http://www.christian-junghanns.de/wpec-goodrelations		//
//////////////////////////////////////////////////////////////////////////////////
?>

<div xmlns="http://www.w3.org/1999/xhtml"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
	xmlns:xsd="http://www.w3.org/2001/XMLSchema#"
	xmlns:gr="http://purl.org/goodrelations/v1#"
	xmlns:foaf="http://xmlns.com/foaf/0.1/"
	xmlns:v="http://rdf.data-vocabulary.org/#"
	xmlns:media="http://search.yahoo.com/searchmonkey/media/">		
<?php
		// gr:Offering
?>
	<div typeof="gr:Offering" about="<?php echo $wpsc_the_product_permalink; ?>#offering_<?php echo $gr_product['gr_node_name']; ?>">
<?php
		if(gr_node_company()) {
?>
		<div rev="gr:offers" resource="<?php echo gr_node_company(); ?>"></div>
<?php
}
?>
		<div rel="gr:includesObject"> 
			<div typeof="gr:TypeAndQuantityNode" about="<?php echo $wpsc_the_product_permalink; ?>#TypeAndQuantityNode_<?php echo $gr_product['gr_node_name']; ?>"> 
				<div property="gr:amountOfThisGood" content="1.0" datatype="xsd:float"></div> 
				<div property="gr:hasUnitOfMeasurement" content="<?php echo htmlspecialchars ($gr_product['gr_UnitOfMeasurement']); ?>" datatype="xsd:string"></div>
				<div rel="gr:typeOfGood">
<?php
			if (!$gr_product['gr_serialnumber']) { 
?>
					<div typeof="gr:ProductOrServicesSomeInstancesPlaceholder"about="<?php echo $wpsc_the_product_permalink; ?>#product_placeholder_<?php echo $gr_product['gr_node_name']; ?>">
<?php
			}
			elseif ($gr_product['gr_serialnumber']) {
?>
					<div typeof="gr:ActualProductOrServiceInstance"about="<?php echo $wpsc_the_product_permalink; ?>#product_instance_<?php echo $gr_product['gr_node_name']; ?>">
<?php
			}
?>
<?php
			// gr:name and gr: description
?>
						<div property="gr:name" content="<?php echo $gr_product['gr_title']; ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
						<div property="gr:description" content="<?php echo $gr_product['gr_description']; ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
						<div property="rdfs:comment" content="<?php echo $gr_product['gr_comment']; ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
<?php
		if ( $gr_product['sku'] ) {
?>
						<div property="gr:hasStockKeepingUnit" content="<?php echo $gr_product['sku']; ?>" datatype="xsd:string"></div>	
<?php
			}
?>
<?php
		if ( $gr_product['gr_condition'] ) {
?>
						<div property="gr:condition" content="<?php echo htmlspecialchars ($gr_product['gr_condition']); ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
<?php
			}
?>
<?php
		if ( $gr_product['gr_image'] ) {
?>
						<div rel="foaf:depiction" resource="<?php echo $gr_product['gr_image']; ?>"></div>
						<div rel="media:image" resource="<?php echo $gr_product['gr_image']; ?>"></div>
<?php
			}
?>
<?php
		if ( $gr_product['gr_thumbnail'] ) {
?>
						<div rel="foaf:thumbnail" resource="<?php echo $gr_product['gr_thumbnail']; ?>"></div>
<?php
			}
?>
<?php
		if ( $gr_product['gr_category'] ) {
?>
						<div property="gr:category" content="<?php echo $gr_product['gr_category']; ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
<?php
			}
?>
<?php
		if ( $gr_product['gr_color'] ) {
?>
						<div property="gr:color" content="<?php echo htmlspecialchars ($gr_product['gr_color']); ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
<?php
			}
?>
<?php
		if ($gr_product['gr_has_external_model'] ) {
			// has external make and model or datasheet
?>
						<div rel="gr:hasMakeAndModel">
							<div typeof="gr:ProductOrServiceModel" resource=<?php echo $gr_product['gr_has_external_model']; ?>"></div>
						</div>
<?php
			}
?>
<?php		
		if ( $gr_product['gr_ean'] ) {
?>
						<div property="gr:hasEAN_UCC-13" content="<?php echo $gr_product['gr_ean']; ?>" datatype="xsd:string"></div>
<?php
			}
?>
<?php
		if ( $gr_product['gr_gtin14'] ) {
?>
						<div property="gr:hasGTIN-14" content="<?php echo $gr_product['gr_gtin14']; ?>" datatype="xsd:string"></div>
<?php
			}
?>
<?php
		if ( $gr_product['serialnumber'] ) {
?>
						<div property="gr:serialNumber" content="<?php echo $gr_product['serialnumber']; ?>" datatype="xsd:string"></div>	
<?php
			}
?>
<?php
		if ( $gr_product['gr_mpn'] ) {
?>
						<div property="gr:hasMPN" content="<?php echo $gr_product['gr_mpn']; ?>" datatype="xsd:string"></div>
<?php
			}
?>
<?php
		

		// gr:weight
		
		if ( $gr_product['gr_weight'] ) {
?>
						<div rel="gr:weight">
							<div typeof="gr:QuantitativeValueFloat" about="<?php echo $wpsc_the_product_permalink; ?>#weight_<?php echo $gr_product['gr_node_name']; ?>">
								<div property="gr:hasUnitOfMeasurement" content="<?php echo gr_unit_converter($gr_product['weight_unit']); ?>" datatype="xsd:string"></div>
								<div property="gr:hasValueFloat" content="<?php echo $gr_product['gr_weight']; ?>" datatype="xsd:float"></div>
							</div>
						</div>
<?php
			}
?>
<?php
		
		// gr dimension propertys gr:width gr:height gr:depth
		
		if ( $gr_product['dimensions']['width'] ) {
?>
						<div rel="gr:width">
							<div typeof="gr:QuantitativeValueFloat" about="<?php echo $wpsc_the_product_permalink; ?>#width_<?php echo $gr_product['gr_node_name']; ?>">
								<div property="gr:hasUnitOfMeasurement" content="<?php echo gr_unit_converter($gr_product['dimensions']['width_unit']); ?>" datatype="xsd:string"></div>
								<div property="gr:hasValueFloat" content="<?php echo $gr_product['dimensions']['width']; ?>"  datatype="xsd:float"></div>
							</div>
						</div>
<?php
			}
?>
<?php			
		if ( $gr_product['dimensions']['height'] ) {
?>
						<div rel="gr:height">
							<div typeof="gr:QuantitativeValueFloat" about="<?php echo $wpsc_the_product_permalink; ?>#height_<?php echo $gr_product['gr_node_name']; ?>">
								<div property="gr:hasUnitOfMeasurement" content="<?php echo gr_unit_converter($gr_product['dimensions']['height_unit']); ?>" datatype="xsd:string"></div>
								<div property="gr:hasValueFloat" content="<?php echo $gr_product['dimensions']['height']; ?>" datatype="xsd:float"></div>
							</div>
						</div>
<?php
			}
?>
<?php
		if ( $gr_product['dimensions']['length'] ) {
?>
						<div rel="gr:depth">
							<div typeof="gr:QuantitativeValueFloat" about="<?php echo $wpsc_the_product_permalink; ?>#depth_<?php echo $gr_product['gr_node_name']; ?>">
								<div property="gr:hasUnitOfMeasurement" content="<?php echo gr_unit_converter($gr_product['dimensions']['length_unit']); ?>" datatype="xsd:string"></div>
								<div property="gr:hasValueFloat" content="<?php echo $gr_product['dimensions']['length']; ?>" datatype="xsd:float"></div>
							</div>
						</div>
<?php			
		}
?>
<?php
			// closing div for gr:ProductOrServicesSomeInstancesPlaceholder and includes
?>
					</div>
				</div>
			</div>
		</div>
<?php			
		// additional markup related to gr:Offering
			

		
		// hasInventory Level
			if( wpsc_product_has_stock() ) {
?>
		<div rel="gr:hasInventoryLevel">
			<div typeof="gr:QuantitativeValue" about="<?php echo $wpsc_the_product_permalink; ?>#inventorylevel_<?php echo $gr_product['gr_node_name']; ?>">
				<div property="gr:hasMinValue" content="1" datatype="xsd:float"></div>
<?php
				if($gr_product['gr_quantity'] >= '1') {
?>
				<div property="gr:hasMaxValue" content="<?php echo $gr_product['gr_quantity']; ?>" datatype="xsd:float"></div>
<?php
}
?>
				<div property="gr:hasUnitOfMeasurement" content="<?php echo htmlspecialchars ($gr_product['gr_UnitOfMeasurement']); ?>" datatype="xsd:string"></div>
			</div>
		</div>
<?php
			}
?>
<?php
		// v:rating
		if(get_option('product_ratings') == 1) {
			 ?>
		<div rel="v:hasReview"> 
			<div class="description" typeof="v:Review-aggregate" about="<?php echo $wpsc_the_product_permalink; ?>#review_<?php echo $gr_product['gr_node_name']; ?>"> 
				<div property="v:count" content="<?php echo $gr_product['rating_count']; ?>"></div> 
				<div property="v:rating" content="<?php echo $gr_product['rating_average']; ?>"></div> 
			</div> 
		</div>
<?php
		}
?>
<?php		
					// gr:PriceSpecification
			
	if( $gr_product['gr_price'] || $gr_product['max_price'] || $gr_product['min_price'] ) {
		$gr_pricespec = '';
		$gr_pricespec .= "\t\t<div rel=\"gr:hasPriceSpecification\">\n";
		$gr_pricespec .= "\t\t\t<div typeof=\"gr:UnitPriceSpecification\" about=\"".$wpsc_the_product_permalink."#unitPriceSpecification_".$gr_product['gr_node_name']."\">\n";
		$gr_pricespec .= "\t\t\t\t<div property=\"gr:hasCurrency\" content=\"".$gr_product['gr_currency']."\" datatype=\"xsd:string\"></div>\n";
		if ($gr_product['notax'] == '1') {
			$gr_pricespec .= "\t\t\t\t<div property=\"gr:valueAddedTaxIncluded\" content=\"false\" datatype=\"xsd:boolean\"></div>\n";
}
		else {
			$gr_pricespec .= "\t\t\t\t<div property=\"gr:valueAddedTaxIncluded\" content=\"true\" datatype=\"xsd:boolean\"></div>\n";
		}
		if ( $gr_product['max_price'] ) $gr_pricespec .= "\t\t\t\t<div property=\"gr:hasMaxCurrencyValue\" content=\"".$gr_product['max_price']."\" datatype=\"xsd:float\"></div>\n";			
		if ( $gr_product['min_price'] ) $gr_pricespec .= "\t\t\t\t<div property=\"gr:hasMinCurrencyValue\" content=\"".$gr_product['min_price']."\" datatype=\"xsd:float\"></div>\n";			
		if ( $gr_product['gr_price'] ) $gr_pricespec .= "\t\t\t\t<div property=\"gr:hasCurrencyValue\" content=\"".$gr_product['gr_price']."\" datatype=\"xsd:float\"></div>\n";			
		if ( $gr_product['gr_price_validFrom'] ) $gr_pricespec .= "\t\t\t\t<div property=\"gr:validFrom\" content=\"".$gr_product['gr_price_validFrom']."\" datatype=\"xsd:dateTime\"></div>\n";			
		if ( $gr_product['gr_price_validThrough'] ) $gr_pricespec .= "\t\t\t\t<div property=\"gr:validThrough\" content=\"".$gr_product['gr_price_validThrough']."\" datatype=\"xsd:dateTime\"></div>\n";
		$gr_pricespec .= "\t\t\t\t<div property=\"gr:hasUnitOfMeasurement\" content=\"".htmlspecialchars ($gr_product['gr_UnitOfMeasurement'])."\" datatype=\"xsd:string\"></div>\n";
		if ( $gr_product['gr_billingIncrement'] ) $gr_pricespec .= "\t\t\t\t<div property=\"gr:billingIncrement\" content=\"".htmlspecialchars ($gr_product['gr_billingIncrement'])."\" datatype=\"xsd:float\"></div>\n";
		$gr_pricespec .= "\t\t\t</div>\n";
		$gr_pricespec .= "\t\t</div>\n";
		echo $gr_pricespec;
	}
		
?>
<?php		
		// gr:eligibleRegions
		while ($gr_regions_i<$gr_regions_j) {
?>
		<div property="gr:eligibleRegions" content="<?php echo $gr_regions[$gr_regions_i]['isocode']; ?>" datatype="xsd:string"></div>
<?php
			$gr_regions_i++;
		}
?>
<?php		
		// gr:valid(From|Through) and gr:availability(Starts|Ends)
?>
<?php
		if ( $gr_product['gr_product_validFrom'] )   {
?>
		<div property="gr:validFrom" content="<?php echo $gr_product['gr_product_validFrom']; ?>" datatype="xsd:dateTime"></div>
<?php
			}
?>
<?php			
		if ( $gr_product['gr_product_validThrough'] )   {
?>
		<div property="gr:validThrough" content="<?php echo $gr_product['gr_product_validThrough']; ?>" datatype="xsd:dateTime"></div>
<?php
			}
?>
<?php			
		if ( $gr_product['gr_product_availabilityStarts'] )   {
?>
		<div property="gr:availabilityStart" content="<?php echo $gr_product['gr_product_availabiltyStarts']; ?>" datatype="xsd:dateTime"></div>
<?php
			}
?>
<?php			
		if ( $gr_product['gr_product_availabilityEnds'] )   {
?>
		<div property="gr:availabilityEnds" content="<?php echo $gr_product['gr_product_availabilityEnds']; ?>" datatype="xsd:dateTime"></div>
<?php
			}
?>
<?php			
		
		
		// gr:WarrantyPromise #Labor-BringIn #PartsAndLabor-BringIn #PartsAndLabor-Pickup
		
		if ( $gr_product['gr_Labor-BringIn'] )   {
?>
		<div rel="gr:hasWarrantyPromise">
			<div typeof="gr:WarrantyPromise" about="<?php echo $wpsc_the_product_permalink; ?>#warranty_Labor-BringIn_<?php echo $gr_product['gr_node_name']; ?>">
				<div property="gr:durationOfWarrantyInMonths" content="<?php echo $gr_product['gr_Labor-BringIn']; ?>" datatype="xsd:int"></div>
				<div rel="gr:hasWarrantyScope" ressource="http://purl.org/goodrelations/v1#Labor-BringIn"></div>
			</div>
		</div>
<?php
			}
?>
<?php			
		if ( $gr_product['gr_PartsAndLabor-BringIn'] ) {
?>
		<div rel="gr:hasWarrantyPromise">
			<div typeof="gr:WarrantyPromise" about="<?php echo $wpsc_the_product_permalink; ?>#warranty_PartsAndLabor-BringIn_<?php echo $gr_product['gr_node_name']; ?>">
				<div property="gr:durationOfWarrantyInMonths" content="<?php echo $gr_product['gr_PartsAndLabor-BringIn']; ?>" datatype="xsd:int"></div>
				<div rel="gr:hasWarrantyScope" ressource="http://purl.org/goodrelations/v1#PartsAndLabor-BringIn"></div>
			</div>
		</div>
<?php
			}
?>
<?php			
		if ( $gr_product['gr_PartsAndLabor-PickUp'] ) {
?>
		<div rel="gr:hasWarrantyPromise">
			<div typeof="gr:WarrantyPromise" about="<?php echo $wpsc_the_product_permalink; ?>#warranty_PartsAndLabor-PickUp_<?php echo $gr_product['gr_node_name']; ?>">
				<div property="gr:durationOfWarrantyInMonths" content="<?php echo $gr_product['gr_PartsAndLabor-PickUp']; ?>" datatype="xsd:int"></div>
				<div rel="gr:hasWarrantyScope" ressource="http://purl.org/goodrelations/v1#PartsAndLabor-PickUp"></div>
			</div>
		</div>
<?php
			}
?>
<?php			
		// gr:BusinessFunction
		$gr_busfunc = '';
		if($gr_product['gr_BusinessFunction']['Sell']) $gr_busfunc .= "\t\t<div rel=\"gr:hasBusinessFunction\" resource=\"http://purl.org/goodrelations/v1#Sell\"></div>\n";
		if($gr_product['gr_BusinessFunction']['LeaseOut']) $gr_busfunc .= "\t\t<div rel=\"gr:hasBusinessFunction\" resource=\"http://purl.org/goodrelations/v1#LeaseOut\"></div>\n";
		if($gr_product['gr_BusinessFunction']['ConstructionInstallation']) $gr_busfunc .= "\t\t<div rel=\"gr:hasBusinessFunction\" resource=\"http://purl.org/goodrelations/v1#ConstructionInstallation\"></div>\n";
		if($gr_product['gr_BusinessFunction']['Dispose']) $gr_busfunc .= "\t\t<div rel=\"gr:hasBusinessFunction\" resource=\"http://purl.org/goodrelations/v1#Dispose\"></div>\n";
		if($gr_product['gr_BusinessFunction']['Maintain']) $gr_busfunc .= "\t\t<div rel=\"gr:hasBusinessFunction\" resource=\"http://purl.org/goodrelations/v1#Maintain\"></div>\n";
		if($gr_product['gr_BusinessFunction']['ProvideService']) $gr_busfunc .= "\t\t<div rel=\"gr:hasBusinessFunction\" resource=\"http://purl.org/goodrelations/v1#ProvideService\"></div>\n";
		if($gr_product['gr_BusinessFunction']['Repair']) $gr_busfunc .= "\t\t<div rel=\"gr:hasBusinessFunction\" resource=\"http://purl.org/goodrelations/v1#Repair\"></div>\n";
		echo $gr_busfunc;
	
?>
<?php			
		
		
		// gr:eligibleCustomerTypes
		$gr_customers = '';
		if ( $gr_product['gr_eligibleCustomerTypes']['Business'] ) $gr_customers .= "\t\t<div rel=\"gr:eligibleCustomerTypes\" resource=\"http://purl.org/goodrelations/v1#Business\"></div>\n";
		if ( $gr_product['gr_eligibleCustomerTypes']['Enduser'] ) $gr_customers .= "\t\t<div rel=\"gr:eligibleCustomerTypes\" resource=\"http://purl.org/goodrelations/v1#Enduser\"></div>\n";
		if ( $gr_product['gr_eligibleCustomerTypes']['PublicInstitution'] ) $gr_customers .= "\t\t<div rel=\"gr:eligibleCustomerTypes\" resource=\"http://purl.org/goodrelations/v1#PublicInstitution\"></div>\n";
		if ( $gr_product['gr_eligibleCustomerTypes']['Reseller'] ) $gr_customers .= "\t\t<div rel=\"gr:eligibleCustomerTypes\" resource=\"http://purl.org/goodrelations/v1#Reseller\"></div>\n";
?>
<?php	echo $gr_customers; ?>
<?php
		
		// gr:acceptedPaymentMethods
		$gr_payment = '';
		if ( $gr_product['gr_PaymentMethod']['ByBankTransInAdvance'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#ByBankTransferInAdvance\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['ByInvoice'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#ByInvoice\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['Cash'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#Cash\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['CheckInAdvance'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#CheckInAdvance\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['COD'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#COD\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['DirectDebit'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#DirectDebit\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['PayPal'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#PayPal\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['AmericanExpress'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#AmericanExpress\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['DinersClub'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#DinersClub\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['Discover'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#Discover\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['MasterCard'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#MasterCard\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['VISA'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"http://purl.org/goodrelations/v1#VISA\"></div>\n";
		if ( $gr_product['gr_PaymentMethod']['GoogleCheckout'] ) $gr_payment .= "\t\t<div rel=\"gr:acceptedPaymentMethods\" resource=\"".get_bloginfo('url')."/#GoogleCheckout\"></div>\n";
?>
<?php echo $gr_payment; ?>
<?php		
		// gr:availableDeliveryMethods
		

		$gr_delivery = '';
		if ( $gr_product['gr_DeliveryMethod']['DeliveryModePickUp']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#DeliveryModePickUp\"></div>\n";
		if ( $gr_product['gr_DeliveryMethod']['DeliveryModeMail']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#DeliveryModeMail\"></div>\n";
		if ( $gr_product['gr_DeliveryMethod']['UPS']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#UPS\"></div>\n";
		if ( $gr_product['gr_DeliveryMethod']['FederalExpres']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#FederalExpress\"></div>\n";
		if ( $gr_product['gr_DeliveryMethod']['DeliveryModeOwnFleet']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#DeliveryModeOwnFleet\"></div>\n";
		if ( $gr_product['gr_DeliveryMethod']['DeliveryModeDirectDownload']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#DeliveryModeDirectDownload\"></div>\n";
		if ( $gr_product['gr_DeliveryMethod']['DHL']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#DHL\"></div>\n";
		if ( $gr_product['gr_DeliveryMethod']['DeliveryModeFreight']) $gr_delivery .= "\t\t<div rel=\"gr:availableDeliveryMethods\" resource=\"http://purl.org/goodrelations/v1#DeliveryModeFreight\"></div>\n";

?>
<?php echo $gr_delivery; ?>
<?php		
		// gr:availableAtOrFrom
?>
<?php   if ( is_array ( $gr_product['gr_avalableAtOrFrom'] ) ) {
			foreach(array_keys($gr_product['gr_availableAtOrFrom']) as $pos_id) {
				if(gr_node_pos($pos_id)) {
					echo "\t\t<div rel=\"gr:availableAtOrFrom\" resource=\"".gr_node_pos($pos_id)."\"></div>\n";
				}
			}
		}
?>
<?php
// start of google actualproductorserviceinstance helper
// as google is up to 12/02/2010 not able to handle a actualproductorserviceinstance properly this construct helps to show at least a reach snippet
		if ($gr_product['gr_serialnumber'] != '') {
			// gr:name and gr: description
?>
		<div property="gr:name" content="<?php echo $gr_product['gr_title']; ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
		<div property="gr:description" content="<?php echo $gr_product['gr_description']; ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
		<div property="rdfs:comment" content="<?php echo $gr_product['gr_comment']; ?>" xml:lang="<?php echo $gr_product['gr_language']; ?>"></div>
<?php
			if ( $gr_product['gr_image'] ) {
?>
		<div rel="foaf:depiction" resource="<?php echo $gr_product['gr_image']; ?>"></div>
		<div rel="media:image" resource="<?php echo $gr_product['gr_image']; ?>"></div>
<?php
			}
		}
// end of google actualproductorserviceinstance helper
?>
<?php
		// closing div for offering and namespace
?>
	</div>
</div>
<?php
?>
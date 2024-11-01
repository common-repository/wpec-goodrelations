<?php
/*
Plugin Name: GoodRelations for WP e-Commerce
Plugin URI: http://www.christian-junghanns.de/wpec-goodrelations
Version: 0.1.8
Author: Christian Junghanns 
Author URI: http://www.christian-junghanns.de/
Description: Add GoodRelations Data to WP e-Commerce Plugin from getshopped.org
License: GNU General Public License (GPL) version 2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Dependencies: wp-e-commerce/wp-shopping-cart.php 
*/
$gr_version = '0.1.8';
//////////////////////////////////////////////////////////////////////////////////
//	wpec-goodrelations - Adds GoodRelations RDFa Data to WP e-Commerce Plugin	//
//	Copyright (C) 2010 Christian Junghanns										//
//																				//
//	This program is free software; you can redistribute it and/or				//
//	modify it under the terms of the GNU General Public License					//
//	as published by the Free Software Foundation; either version 2				//
//	of the License, or (at your option) any later version.						//
//																				//
//	This program is distributed in the hope that it will be useful,				//
//	but WITHOUT ANY WARRANTY; without even the implied warranty of				//
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the				//
//	GNU General Public License for more details.								//
//																				//
//	You should have received a copy of the GNU General Public License			//
//	along with this program; if not, write to the Free Software					//
//	Foundation, Inc.,                                                           //
//	51 Franklin Street,                                                         //
//	Fifth Floor,                                                                //
//	Boston, MA  02110-1301, USA.                                                //
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////
//  This work is based on the GoodRelations ontology, developed by Martin Hepp 	//
//		  for further information see http://purl.org/goodrelations				//
//////////////////////////////////////////////////////////////////////////////////

//$devmode = 1;

//if($devmode) error_reporting(E_ALL);  
$gr_setup = get_option('gr_setup');
if ( $gr_setup['gr_do_annotation'] ) {
 include_once('wpec-goodrelations-frontend.php');
}
if ( is_admin ) include_once('wpec-goodrelations-backend.php');
?>
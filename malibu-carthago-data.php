<?php 

/**
 * Plugin Name: Malibu Carthago Data
 * Author: The Wild Fields
 * Author URI: https://thewildfields.com
 * Description: Utilities for Malibu Carthago Website
 * Text Domain: malibu-carthago-data-data
 */

define('___MCD__PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ));
define('___MCD__PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ));

// Post Types
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/post-types/cpt-fahrzeuge.php';
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/post-types/cpt-haendler.php';

// Taxonomies
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/taxonomies/tax-fahrzeugart.php';
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/taxonomies/tax-fahrzeugklasse.php';
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/taxonomies/tax-motorisierung.php';
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/taxonomies/tax-haendlertyp.php';

// API Endpoints
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/api/dealers.php';
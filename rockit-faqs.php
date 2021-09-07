<?php
/**
 * Plugin Name:       Rockit FAQs
 * Plugin URI:        https://www.siterig.io/rockit/faqs
 * Description:       Simple and lightweight Frequently Asked Questions plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.3
 * Author:            SiteRig
 * Author URI:        https://www.siterig.io/
 * Contributors:      MeMattStone
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       rockit-faqs
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
}

// Set the path to this plugin
define( 'ROCKIT_FAQS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ROCKIT_FAQS_PLUGIN_BASENAME', plugin_basename(__FILE__) );
define( 'ROCKIT_FAQS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Check Rockit Core was not already loaded by another Rockit plugin or theme
if ( ! class_exists( '\SiteRig\Rockit\Core' ) ) {
    require_once( ROCKIT_FAQS_PLUGIN_PATH . 'lib/core/class-rockit-core.php' );
}

// Rockit FAQs class
require_once( ROCKIT_FAQS_PLUGIN_PATH . 'lib/class-rockit-faqs.php' );

// Create FAQs instance
$rockit_faqs = new \SiteRig\Rockit\FAQs;

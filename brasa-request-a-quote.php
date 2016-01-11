<?php
/**
 *
 *
 * @package   brasa-request-a-quote
 * @author    Brasa Design <matheus@brasa.art.br>
 * @license   GPL-2.0+
 * @link      http://brasa.art.br
 * @copyright Brasa Design - 2016
 *
 * @wordpress-plugin
 * Plugin Name:       Brasa Request a Quote
 * Plugin URI:        http://brasa.art.br
 * Description:       Another Request a Quote WooCommerce plugin
 * Version:           0.1
 * Author:            Brasa Design
 * Author URI:        http://brasa.art.br
 * Text Domain:       brasa-request-a-quote
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/brasadesign/brasa-request-a-quote
 */
// define plugin directory location
define( 'BRASA_REQUEST_A_QUOTE_DIR', plugin_dir_path( __FILE__ ) );
// include metabox class
require_once BRASA_REQUEST_A_QUOTE_DIR . 'inc/metabox-class.php';
// include metaboxes options
require_once BRASA_REQUEST_A_QUOTE_DIR . 'inc/metabox-options.php';


// include Request a Quote Class
require_once BRASA_REQUEST_A_QUOTE_DIR . 'inc/request-a-quote-class.php';

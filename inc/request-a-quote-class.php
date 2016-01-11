<?php
/**
  * Class Brasa_Request_A_Quote
  */
class Brasa_Request_A_Quote {

	/**
	 * @var boolean
	 */
	private $is_quote_cart = false;

	/**
	 * Class Constructor
	 * @return null
	 */
	public function __construct() {
		// Check if WooCommerce is active
		add_action( 'admin_notices', array( $this, 'check_woocommerce_is_install' ) );

		// Filter WooCommerce Default Cart to remove quote items
		add_filter( 'woocommerce_cart_item_product', array( $this, 'filter_woocommerce_default_cart' ), 9999999 );

		// Add Quote cart
		add_action( 'woocommerce_after_cart', array( $this, 'add_quote_cart' ) );

		// Add get param to checkout URL
		add_filter( 'woocommerce_get_checkout_url', array( $this, 'add_quote_param_checkout_url' ), 9999999 );

		// Change WooCommerce strings to request a quote
		add_filter( 'gettext', array( $this, 'change_woocommerce_strings' ), 20, 3 );

		// Remove coupons button on quote cart
		add_filter( 'woocommerce_coupons_enabled', array( $this, 'remove_coupons_button_on_quote_cart' ), 9999999 );

	}
	/**
	 * Check if WooCommerce is active. If not, send a admin notice
	 * @return null
	 */
	public function check_woocommerce_is_install() {
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    		printf( '<div class="error"><p>%s</p></div>', __( '<b>Brasa Request a Quote:</b> WooCommerce is needed to activate', 'brasa-request-a-quote' ) );
		}
	}
	/**
	 * Check if is quote product
	 * @param string $product_id
	 * @return boolean
	 */
	public function is_quote_product( $product_id ) {
		if ( $field = get_post_meta( $product_id, 'is_request_a_quote', true ) ) {
			if ( $field == 'true' ) {
				return true;
			}
		}
		return false;
	}
	/**
	 * Check if cart item is quote product, if true, remove from the cart list
	 * @param object $data
	 * @param array $cart_item
	 * @param array $cart_item_key
	 * @return mixed
	 */
	public function filter_woocommerce_default_cart( $data, $cart_item = array(), $cart_item_key = array() ) {
		if ( ! $this->is_quote_cart && $this->is_quote_product( $data->post->ID ) ) {
			return false;
		}
		return $data;
	}
	/**
	 * Check if has quote product on cart
	 * @return boolean
	 */
	public function has_quote_product_on_cart () {
		global $woocommerce;
		if ( $woocommerce->cart->is_empty() ) {
			return false;
		}
		$items = $woocommerce->cart->get_cart();
		foreach( $items as $item => $values ) {
			if ( $this->is_quote_product( $values['data']->post->ID ) ) {
				return true;
				break;
			}
		}
		return false;
	}
	/**
	 * Add quote cart on cart page
	 * @return null
	 */
	public function add_quote_cart() {
		if ( ! $this->is_quote_cart && $this->has_quote_product_on_cart() ) {
			$this->is_quote_cart = true;
			printf( apply_filters( 'brasa_request_a_quote_cart_title_html', '<h3 class="title">%s</h1>' ), __( 'Request a Quote', 'brasa-request-a-quote' ) );

			// Remove woocommerce checkout options
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

			wc_get_template( 'cart/cart.php' );
			$this->is_quote_cart = false;
		}
	}
	/**
	 * Add quote get param to checkout url
	 * @param string $url
	 * @return string
	 */
	public function add_quote_param_checkout_url( $url ) {
		if ( $this->is_quote_cart ) {
			return $url . '?brasa_request_a_quote_checkout=true';
		}
		return $url;
	}
	/**
	 * Change WooCommerce text to Quote
	 * @param string $translated_text
	 * @param string $text
	 * @param string $text_domain
	 * @return string
	 */
	public function change_woocommerce_strings ( $translated_text = null, $text = null, $text_domain = null ) {
		if ( $text_domain != 'woocommerce' ) {
			return $translated_text;
		}

		if ( $this->is_quote_cart ) {
			if ( $text == 'Proceed to Checkout' ) {
				return __( 'Request a Quote', 'brasa-request-a-quote' );
			}
			if ( $text == 'Update Cart' ) {
				return __( 'Update Quote', 'brasa-request-a-quote' );
			}
		}
		if ( $text == 'Add to Cart' ) {
			return __( 'Add to Quote', 'brasa-request-a-quote' );
		}
		return $translated_text;
	}
	/**
	 * Remove coupons area on quote cart
	 * @param boolean $value
	 * @return boolean;
	 */
	function remove_coupons_button_on_quote_cart ( $value ) {
		if ( $this->is_quote_cart ) {
			return false;
		}
		return $value;
	}
}
global $brasa_request_quote;
$brasa_request_quote = new Brasa_Request_A_Quote();

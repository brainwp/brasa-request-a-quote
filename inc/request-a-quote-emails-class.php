<?php
/**
  * Class Brasa_Request_A_Quote_Emails
  */
class Brasa_Request_A_Quote_Emails {
	/**
	 * Check if is quote email
	 * @var boolean
	 */
	public $is_quote_email = false;
	/**
	 * Class Constructor
	 * @return null
	 */
	public function __construct() {
		// Check if is quote email
		add_action( 'woocommerce_before_template_part', array( $this, 'check_is_quote_email' ), 99999 );

		// Change emails strings
		add_filter( 'gettext', array( $this, 'change_woocommerce_strings' ), 20, 3 );

		// Remove price
		add_filter( 'woocommerce_order_formatted_line_subtotal', array( $this, 'remove_emails_price' ), 20, 3 );

	}
	public function check_is_quote_email( $template_name = null, $template_path = null, $located = null, $args = array() ) {
		global $brasa_request_quote;

		if ( $template_name == 'emails/admin-new-order.php' ) {

			if ( isset( $_POST['is_request_a_quote_order'] ) && $_POST['is_request_a_quote_order'] == 'true' ) {
			 	$this->is_quote_email = true;
			}
		}
	}
	/**
	 * Change email strings
	 * @param type|null $translated_text
	 * @param type|null $text
	 * @param type|null $text_domain
	 * @return type
	 */
	public function change_woocommerce_strings ( $translated_text = null, $text = null, $text_domain = null ) {
		global $post, $wp, $order;
		if ( ! $this->is_quote_email ) {
			return $translated_text;
		}
		if ( $text_domain != 'woocommerce' ) {
			return $translated_text;
		}

		//var_dump( $order );
		if ( $text == 'You have received an order from %s. The order is as follows:' ) {
			return __( 'You have received new quote: ', 'brasa-request-a-quote' );
		}
		if ( $text == 'Price') {
			return '';
		}
		return $translated_text;

	}
	public function remove_emails_price( $subtotal, $item = null, $object = null ) {
		if ( $this->is_quote_email ) {
			return '';
		}
		return $subtotal;
	}
}
new Brasa_Request_A_Quote_Emails();


<?php
/*
 * Plugin Name: Credit Key Payment Gateway
 * Description: Enable your customer to pay for your products through Credit Key.
 * Author: Onepix
 * Author URI: https://onepix.net
 * Version: 1.0.0
 */

add_filter( 'woocommerce_payment_gateways', 'add_credit_key_gateway_class' );
function add_credit_key_gateway_class( $gateways ) {
	$gateways[] = 'Credit_Key_Gateway';
	return $gateways;
}
add_action( 'plugins_loaded', 'credit_key_init_gateway_class' );
function credit_key_init_gateway_class() {
	class Credit_Key_Gateway extends WC_Payment_Gateway {
		/**
		 * Class constructor
		 */
		public function __construct() {
			$plugin_dir = plugin_dir_url(__FILE__);

			$this->id = 'credit_key';
			$this->method_title = esc_html__( 'Credit Key Gateway', 'credit_key' );
			$this->method_description = esc_html__( 'Enable your customer to pay for your products through Credit Key.', 'credit_key' );
			$this->supports = array(
				'products',
			);
			$this->init_form_fields();
			
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		}

		/**
		 * Plugin options
		 */
		public function init_form_fields(){
			$this->form_fields = array(
				'enabled' => array(
					'title'       => esc_html__('Enable/Disable', 'credit_key' ),
					'label'       => esc_html__('Enable Credit Key Payment Gateway', 'credit_key' ),
					'type'        => 'checkbox',
					'description' => '',
					'default'     => 'no'
				),

				'title' => array(
					'title'       => esc_html__('Title', 'credit_key' ),
					'type'        => 'text',
					'description' => esc_html__('This controls the title which the user sees during checkout.', 'credit_key' ),
					'default'     => esc_html__('Pay with Credit key', 'credit_key' ),
					'desc_tip'    => true,
				),
				'description' => array(
					'title'       => esc_html__('Description', 'credit_key' ),
					'type'        => 'textarea',
					'description' => esc_html__('This controls the description which the user sees during checkout.', 'credit_key' ),
					'default'     => esc_html__('Pay the order via Credit Key payment gateway.', 'credit_key' ),
				),

				'order_prefix' => array(
					'title'       => esc_html__('Orders prefix', 'credit_key' ),
					'type'        => 'text',
					'default'     => 'wс_ck_',
				),

				'is_test' => array(
					'title'       => esc_html__('Test Mode/Live Mode', 'credit_key'),
					'label'       => esc_html__('Enable Test Mode/Disable Test Mode', 'credit_key' ),
					'type'        => 'checkbox',
					'description' => '',
					'default'     => 'no'
				),

				'public_key ' => array(
					'title'       => esc_html__('Public Key', 'credit_key' ),
					'type'        => 'text',
				),

				'test_public_key ' => array(
					'title'       => esc_html__('Public Key', 'credit_key' ),
					'type'        => 'text',
				),

				'shared_secret' => array(
					'title'       => esc_html__('Shared Secret', 'credit_key' ),
					'type'        => 'text',
				),

				'test_shared_secret' => array(
					'title'       => esc_html__('Test Shared Secret', 'credit_key' ),
					'type'        => 'text',
				),
			);
		}

		public function payment_fields() {
			echo '<p>' . $this->description. '</p>';
		}

		public function process_payment( $order_id ) {

		}
	}
}
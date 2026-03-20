<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    XT_Woo_Floating_Cart
 * @subpackage XT_Woo_Floating_Cart/public
 * @author     XplodedThemes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class XT_Woo_Floating_Cart_Public {

	/**
	 * Core class reference.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      XT_Woo_Floating_Cart    $core
	 */
	private $core;

	/**
	 * Var that holds the menu class object.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      XT_Woo_Floating_Cart_Theme_Fixes  $theme_fixes   Theme Fixes
	 */
	public $theme_fixes;

	/**
	 * Var that holds the menu class object.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      XT_Woo_Floating_Cart_Menu  $menu   Menu
	 */
	public $menu;

    /**
     * Var that holds custom payment buttons
     *
     * @since    2.1.2
     * @access   public
     * @var      array  $payment_buttons   buttons
     */
	public $payment_buttons = array();

    /**
     * Var that holds custom payment buttons enabled count
     *
     * @since    2.1.2
     * @access   public
     * @var      int  $payment_buttons_enabled   count
     */
    public $payment_buttons_enabled = 0;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param XT_Woo_Floating_Cart $core Plugin core class
	 *
	 * @since    1.0.0
	 */
	public function __construct( &$core ) {

		$this->core = $core;

		$this->init_ajax();

		$this->core->plugin_loader()->add_action( 'init', $this, 'init', 10 );
	}

	public function init() {

		$this->core->plugin_loader()->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		$this->core->plugin_loader()->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );

        add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );

		if ( $this->core->access_manager()->can_use_premium_code__premium_only() ) {

            $this->init_custom_payment_buttons__premium_only();

            $this->core->plugin_loader()->add_filter( 'wc_get_template', $this, 'wc_get_template_cart_shipping__premium_only', 10, 2 );

			$this->core->plugin_loader()->add_action( 'xt_woofc_cart_body_header', $this, 'render_coupon_form__premium_only', 10 );
			$this->core->plugin_loader()->add_action( 'xt_woofc_cart_body_header', $this, 'render_header_message__premium_only', 15 );
            $this->core->plugin_loader()->add_action( 'xt_woofc_before_product_body', $this, 'do_woocommerce_after_cart_item_name', 10, 2);
			$this->core->plugin_loader()->add_action( 'xt_woofc_cart_body_footer', $this, 'render_checkout__premium_only', 15 );
			$this->core->plugin_loader()->add_action( 'xt_woofc_cart_body_footer', $this, 'render_totals__premium_only', 20 );

            $this->core->plugin_loader()->add_action( 'xt_woofc_after_coupon_form', $this, 'render_coupon_list__premium_only', 10 );
			$this->core->plugin_loader()->add_filter( 'woocommerce_cart_totals_coupon_html', $this, 'filter_coupon_html__premium_only', 10, 1 );
			$this->core->plugin_loader()->add_filter( 'woocommerce_loop_add_to_cart_args', $this, 'woocommerce_loop_add_to_cart_args__premium_only', 10, 2);
			$this->core->plugin_loader()->add_action( 'woocommerce_after_add_to_cart_button', $this, 'woocommerce_single_add_product_image_info__premium_only', 10);

            $this->core->plugin_loader()->add_action( 'xt_woofc_custom_payment_buttons', $this, 'render_custom_payment_buttons__premium_only' );

			if($this->suggested_products_enabled()) {

				$position = $this->core->customizer()->get_option('suggested_products_position', 'below_list');

				if($position === 'below_list') {

					$this->core->plugin_loader()->add_action('xt_woofc_cart_body_footer', $this, 'render_suggested_products__premium_only', 10);

				}else if($position === 'above_totals') {

					$this->core->plugin_loader()->add_action('xt_woofc_cart_body_footer', $this, 'render_suggested_products__premium_only', 19);

				}else if($position === 'below_totals') {

					$this->core->plugin_loader()->add_action('xt_woofc_cart_body_footer', $this, 'render_suggested_products__premium_only', 25);
				}
			}

			$total_savings_enabled = $this->core->customizer()->get_option_bool('enable_total_savings', false);

			if($total_savings_enabled) {
				// Hook our values to the Basket and Checkout pages
				$this->core->plugin_loader()->add_action( 'woocommerce_cart_totals_after_order_total', $this, 'total_savings', 99 );
				$this->core->plugin_loader()->add_action( 'woocommerce_review_order_after_order_total', $this, 'total_savings', 99 );
			}
		}

		$this->core->plugin_loader()->add_filter( 'woocommerce_cart_item_price', $this, 'change_cart_price_display', 30, 3 );
		$this->core->plugin_loader()->add_action( 'template_redirect', $this, 'define_woocommerce_constants', 10 );
		$this->core->plugin_loader()->add_action( 'wp_footer', $this, 'render' );

		$this->init_frontend_dependencies();
	}

	// Init  Ajax
	public function init_ajax() {

		new XT_Woo_Floating_Cart_Ajax($this->core);
	}

	// Init Frontend Dependencies
	public function init_frontend_dependencies() {

		$this->theme_fixes = new XT_Woo_Floating_Cart_Theme_Fixes($this->core);

		if($this->core->access_manager()->can_use_premium_code__premium_only()) {

			if ( $this->menu_item_enabled() ) {

				$this->menu = new XT_Woo_Floating_Cart_Menu( $this->core );
			}

			if ( $this->shortcode_enabled() ) {

				$this->shortcode = new XT_Woo_Floating_Cart_Shortcode( $this->core );
			}
		}
	}

	public function enabled() {

		if ( $this->should_not_load() || $this->is_cart_page() || $this->is_checkout_page() ) {
			return false;
		}

		$exclude_pages = $this->core->customizer()->get_option( 'hidden_on_pages', array() );
		if ( ! empty( $exclude_pages ) ) {
			foreach ( $exclude_pages as $page ) {
				if ( ! empty( $page ) && is_page( $page ) ) {
					return false;
				}
			}
		}

		return true;
	}

	public function menu_item_enabled() {

		return $this->core->customizer()->get_option_bool( 'cart_menu_enabled', false );
	}

	public function shortcode_enabled() {

		return $this->core->customizer()->get_option_bool( 'cart_shortcode_enabled', false );
	}

	public function wc_get_template_cart_shipping__premium_only($template_name, $args = array()) {

		if(strpos($template_name, 'cart/cart-shipping.php') !== false && empty($args['show_shipping_calculator']) ) {

			if($this->enabled() && ($this->totals_enabled() || $this->checkout_form_enabled())) {

				$template_name = $this->core->get_template( 'parts/cart/shipping', $args, false, true );
			}
		}

		return $template_name;
	}

	public function suggested_products_enabled() {

        $enabled = $this->core->customizer()->get_option_bool('suggested_products_enabled', false);
        $enabled_mobile = $this->core->customizer()->get_option_bool('suggested_products_mobile_enabled', false);

        return $enabled || ($enabled_mobile && wp_is_mobile());
    }

    public function totals_enabled() {

        return $this->core->customizer()->get_option_bool( 'enable_totals', false );
    }

    public function checkout_form_enabled() {

        return $this->core->customizer()->get_option_bool( 'cart_checkout_form', false );
    }

    public function coupon_form_enabled() {

        return $this->core->customizer()->get_option_bool( 'enable_coupon_form', false );
    }

    public function coupon_list_enabled() {

        return $this->coupon_form_enabled() && $this->core->customizer()->get_option_bool( 'enable_coupon_list', false );
    }

	public function is_checkout_page() {

		$checkout_page_id = wc_get_page_id( 'checkout' );

		return is_page( $checkout_page_id );
	}

	public function is_cart_page() {

		$cart_page_id = wc_get_page_id( 'cart' );

		return is_page( $cart_page_id );
	}

	public function should_not_load() {

		$do_not_load = false;

		// skip if divi or elementor builder
		if(!empty($_GET['et_fb']) || !empty($_GET['elementor-preview'])) {
			$do_not_load = true;
		}

		return $do_not_load;
	}

	public function define_woocommerce_constants() {

		do_action( 'xt_woofc_before_woocommerce_constants' );

		if ( $this->enabled() && $this->core->access_manager()->can_use_premium_code__premium_only() ) {

			if(wp_doing_ajax() && ($this->totals_enabled() || $this->checkout_form_enabled())) {
				$this->define_cart_constant();
			}

			if ( $this->checkout_form_enabled() ) {
                add_filter( 'woocommerce_is_checkout', '__return_true' );
			}
		}
	}

    public function define_cart_constant() {

        wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );
    }

    public function define_checkout_constant() {

        wc_maybe_define_constant( 'WOOCOMMERCE_CHECKOUT', true );
    }

	function total_savings() {

		$discount_total = 0;

		foreach ( WC()->cart->get_cart() as $cart_item_key => $values) {

			$_product = $values['data'];

			if ( $_product->is_on_sale() ) {
				$regular_price = $_product->get_regular_price();
				$sale_price = $_product->get_sale_price();
				$discount = ($regular_price - $sale_price) * $values['quantity'];
				$discount_total += $discount;
			}

		}

		if ( $discount_total > 0 ) {
			echo '
			<tr class="xt_woofc-total-savings">
			    <th>'. esc_html__( 'Total savings', 'woo-floating-cart' ) .'</th>
			    <td data-title=" '. esc_html__( 'Total savings', 'woo-floating-cart' ) .' ">
					<strong>'.wc_price( $discount_total + WC()->cart->discount_cart ).'</strong>
			    </td>
		    </tr>';
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in XT_Woo_Floating_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The XT_Woo_Floating_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if($this->menu_item_enabled() || $this->shortcode_enabled()) {
			wp_enqueue_style( 'xt-woo-custom', $this->core->plugin_url( 'public/assets/css', 'woo-custom.css' ), array(), $this->core->plugin_version(), 'all' );
			wp_enqueue_style( 'xt-icons' );
		}

		if ( ! $this->enabled() ) {
			return;
		}

		wp_register_style(
			$this->core->plugin_slug(),
			$this->core->plugin_url( 'public/assets/css', 'frontend.css' ),
			array(),
			filemtime( $this->core->plugin_path( 'public/assets/css', 'frontend.css' ) ),
			'all'
		);
		wp_enqueue_style( $this->core->plugin_slug() );

		if ( $this->core->access_manager()->can_use_premium_code__premium_only() && is_rtl() ) {
			wp_register_style(
				$this->core->plugin_slug( 'rtl' ),
				$this->core->plugin_url( 'public/assets/css', 'rtl.css' ),
				array( $this->core->plugin_slug() ),
				filemtime( $this->core->plugin_path( 'public/assets/css', 'rtl.css' ) ),
				'all'
			);
			wp_enqueue_style( $this->core->plugin_slug( 'rtl' ) );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in XT_Woo_Floating_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The XT_Woo_Floating_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( !$this->enabled() ) {
			return;
		}

        wp_enqueue_script('jquery-effects-core');
        wp_enqueue_style( 'xt-icons');

        if ( $this->core->access_manager()->can_use_premium_code__premium_only() && $this->core->customizer()->get_option_bool('flytocart_animation', false )) {

            wp_enqueue_script( 'xt-gsap', $this->core->plugin_url( 'public' ) . 'assets/vendors/gsap.min.js', array( 'jquery' ), $this->core->plugin_version(), false );
            wp_add_inline_script( 'xt-gsap', '
				window.xt_gsap = window.gsap;
			');
        }

        if ( $this->core->customizer()->get_option_bool( 'active_cart_body_lock_scroll', false ) ) {
            wp_enqueue_script( 'xt-body-scroll-lock', $this->core->plugin_url( 'public' ) . 'assets/vendors/bodyScrollLock' . XTFW_SCRIPT_SUFFIX . '.js', array(), $this->core->plugin_version(), false );
        }

        if($this->suggested_products_enabled()){
            wp_enqueue_script( 'xt-lightslider', $this->core->plugin_url( 'public/assets/vendors/lightslider/js', 'lightslider'.XTFW_SCRIPT_SUFFIX.'.js'), array( 'jquery' ), $this->core->plugin_version(), false );
            wp_enqueue_style( 'xt-lightslider', $this->core->plugin_url( 'public/assets/vendors/lightslider/css', 'lightslider.css'), array(), $this->core->plugin_version(), 'all' );
        }

        if ( ! $this->is_cart_page() ) {
            wp_dequeue_script( 'wc-cart' );
        }

        // MAIN SCRIPT
		wp_register_script(
			$this->core->plugin_slug(),
			$this->core->plugin_url( 'public/assets/js', 'frontend' . XTFW_SCRIPT_SUFFIX . '.js' ),
			array(
				'jquery',
				'wc-cart-fragments',
                'xt-jquery-touch',
                'xt-jquery-ajaxqueue',
                'xt-observers-polyfill'
			),
			filemtime( $this->core->plugin_path( 'public/assets/js', 'frontend' . XTFW_SCRIPT_SUFFIX . '.js' ) ),
			true
		);

		$vars = array(
			'wc_ajax_url'          => $this->core->wc_ajax()->get_ajax_url(),
			'layouts'              => $this->core->customizer()->breakpointsJson(),
			'can_use_premium_code' => $this->core->access_manager()->can_use_premium_code__premium_only(),

			'can_checkout'         => xt_woofc_can_checkout(),
			'body_lock_scroll'     => $this->core->customizer()->get_option_bool( 'active_cart_body_lock_scroll', false ),
			'suggested_products_enabled' => $this->suggested_products_enabled(),
            'suggested_products_arrow' => $this->core->customizer()->get_option( 'suggested_products_arrow', 'xt_wooqvicon-arrows-18' ),
            'cart_autoheight'      => xt_woofc_option_bool( 'cart_autoheight_enabled', false ),
			'cart_menu_enabled'    => $this->menu_item_enabled(),
			'cart_menu_click_action' => xt_woofc_option( 'cart_menu_click_action', 'toggle' ),
			'cart_shortcode_enabled' => $this->shortcode_enabled(),
			'cart_shortcode_click_action'  => xt_woofc_option( 'cart_shortcode_click_action', 'toggle' ),
			'override_addtocart_spinner' => xt_woofc_option_bool( 'override_addtocart_spinner', false ),
			'addtocart_spinner' => xt_woofc_option( 'addtocart_spinner', 'xt_icon-spinner' ),
			'addtocart_checkmark' => xt_woofc_option( 'addtocart_checkmark', 'xt_icon-spinner' ),
			'trigger_selectors' => XT_Framework_Customizer_Helpers::repeater_fields_string_to_array(xt_woofc_option('trigger_extra_selectors', array())),

			'lang' => array(
				'wait'              => esc_html__( 'Please wait', 'woo-floating-cart' ),
				'loading'           => esc_html__( 'Loading', 'woo-floating-cart' ),
				'min_qty_required'  => esc_html__( 'Min quantity required', 'woo-floating-cart' ),
				'max_stock_reached' => esc_html__( 'Stock limit reached', 'woo-floating-cart' ),
				'restoring'         => esc_html__( 'Restoring product...', 'woo-floating-cart' ),
                'coupons'           => esc_html__( 'Coupons', 'woo-floating-cart' ),
                'title'             => esc_html__( 'Cart', 'woo-floating-cart' )
			)
		);

		wp_localize_script( $this->core->plugin_slug(), 'XT_WOOFC', $vars );
		wp_enqueue_script( $this->core->plugin_slug() );
	}

	public function init_custom_payment_buttons__premium_only() {

	    if(is_admin()) {
	        return;
        }

	    $button_template = '<div data-or="'.esc_html__('OR', 'woo-floating-cart').'" class="xt_woofc-payment-btn widget_shopping_cart xt_woofc-%2$s-btn">%1$s</div>';

	    // Paypal button
        // https://wordpress.org/plugins/woocommerce-gateway-paypal-express-checkout/
        if( $this->core->customizer()->get_option_bool('paypal_express_checkout') && function_exists( 'wc_gateway_ppec' ) ) {

            ob_start();
            wc_gateway_ppec()->cart->display_mini_paypal_button();
            $button = ob_get_clean();

            if (!empty($button)) {

                $this->payment_buttons['paypal-express'] = sprintf($button_template, $button, 'ppec-paypal');
            }

            $this->payment_buttons_enabled++;
        }

        $this->payment_buttons = apply_filters('xt_woofc_custom_payment_buttons', $this->payment_buttons, $button_template);
    }

    // Render payment buttons
    public function render_custom_payment_buttons__premium_only(){

        $buttons_template = '<div class="xt_woofc-payment-btns">%s</div>';

	    echo sprintf($buttons_template, implode("", $this->payment_buttons));
    }

    public function custom_payment_buttons_enabled__premium_only() {

        return $this->payment_buttons_enabled > 0;
    }

	public function render_coupon_form__premium_only() {

		if ( !$this->coupon_form_enabled() ) {
            return;
		}

        $this->core->get_template( 'parts/cart/coupon', array() );
    }

    public function render_coupon_list__premium_only($partial = false) {

        if( !$this->coupon_list_enabled() ) {
            return;
        }

        $this->core->get_template( 'parts/cart/coupon-list', array('partial' => $partial) );
    }

	public function render_header_message__premium_only($partial = false) {

		if(!$this->core->customizer()->get_option_bool('cart_header_msg_enabled')) {
			return;
		}

		$message = $this->core->customizer()->get_option('cart_header_msg');

		if ( !empty( $message ) ) {
			$this->core->get_template( 'parts/cart/header-message', array( 'message' => $message, 'partial' => $partial ) );
		}
	}

	public function do_woocommerce_after_cart_item_name($cart_item, $cart_item_key) {

        // After Cart Item Name Hook
        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

    }

	public function render_checkout__premium_only() {

		if ( $this->checkout_form_enabled() ) {

			add_filter( 'woocommerce_is_checkout', '__return_true' );
			$this->core->get_template( 'parts/checkout/checkout', array( 'checkout' => WC()->checkout() ) );
			remove_filter( 'woocommerce_is_checkout', '__return_false' );
		}
	}

	public function render_totals__premium_only() {

		if ( $this->totals_enabled() || $this->checkout_form_enabled() ) {

			$this->core->get_template( 'parts/cart/totals', array() );
		}
	}

	public function render_suggested_products__premium_only() {

		$customizer = $this->core->customizer();

		$type        = $customizer->get_option( 'suggested_products_type', 'cross_sells' );
		$items_count = $customizer->get_option( 'suggested_products_count', 5 );
		$title       = $customizer->get_option( 'suggested_products_title', esc_html__( 'Products you may like', 'woo-floating-cart' ) );

		$cart          = WC()->cart->get_cart();
		$cart_is_empty = WC()->cart->is_empty();

		$suggested_products = array();
		$exclude_ids        = array();

		if ( ! $cart_is_empty ) {
			foreach ( $cart as $cart_item ) {
				$exclude_ids[] = $cart_item['product_id'];
			}

			switch ( $type ) {
				case 'cross_sells':
					$suggested_products = WC()->cart->get_cross_sells();
					break;

				case 'up_sells':

					$last_cart_item = end( $cart );
					$product_id     = $last_cart_item['product_id'];
					$variation_id   = $last_cart_item['variation_id'];

					if ( $variation_id ) {
						$product            = wc_get_product( $product_id );
						$suggested_products = $product->get_upsell_ids();
					} else {
						$suggested_products = $last_cart_item['data']->get_upsell_ids();
					}
					break;

				case 'related':

					shuffle( $cart );

					foreach ( $cart as $cart_item ) {
						if ( count( $suggested_products ) >= $items_count ) {
							break;
						}

						$product_id         = $cart_item['variation_id'] ? $cart_item['variation_id'] : $cart_item['product_id'];
						$related_products   = wc_get_related_products( $product_id, $items_count, $exclude_ids );
						$suggested_products = array_merge( $suggested_products, $related_products );
					}
					break;

				case 'selection':

					$selection = $customizer->get_option( 'suggested_products_selection', '');
					if(!empty($selection)) {
						$selection = str_replace(" ", "", $selection);
						$selection = explode(",", $selection);
						foreach($selection as $id) {

							if ( count( $suggested_products ) >= $items_count ) {
								break;
							}

							$suggested_products[] = intval($id);
						}
					}

					break;
			}
		}

		$suggested_products = array_diff($suggested_products, $exclude_ids);

		$vars = array(
			'suggested_products' => $suggested_products,
			'items_count'        => $items_count,
			'exclude_ids'        => $exclude_ids,
			'title'              => $title
		);

		$vars = apply_filters( 'xt_woofc_suggested_product_vars', $vars );

		add_filter( 'xt_woovs_shop_swatches_enabled', '__return_false');

		$this->core->get_template( 'parts/cart/suggested-products', $vars );

		add_filter( 'xt_woovs_shop_swatches_enabled', '__return_true');

	}

	public function filter_coupon_html__premium_only( $coupon_html ) {

		if ( did_action( 'xt_woofc_before_totals' ) && ! did_action( 'xt_woofc_after_totals' ) ) {

			$coupon_html = str_replace( 'woocommerce-remove-coupon', 'xt_woofc-remove-coupon', $coupon_html );

			$coupon_imploded = explode('<a', $coupon_html);
            $coupon_imploded[1] = '<a'.$coupon_imploded[1];

            $coupon_imploded = array_reverse($coupon_imploded);

            $coupon_html = implode("", $coupon_imploded);
		}

		return $coupon_html;
	}

	public function change_cart_price_display( $price, $values, $cart_item_key ) {
		$slashed_price = $values['data']->get_price_html();
		$is_on_sale = $values['data']->is_on_sale();
		if ( $is_on_sale ) {
			$price = $slashed_price;
		}
		return $price;
	}

	public function woocommerce_loop_add_to_cart_args__premium_only($args, $product) {

		$image_data  = $this->get_product_image_data($product);

		if(!empty($image_data)) {
			$args['attributes']['data-product_image_src'] = $image_data[0];
			$args['attributes']['data-product_image_width'] = $image_data[1];
			$args['attributes']['data-product_image_height'] = $image_data[2];
		}

		return $args;
	}

	public function woocommerce_single_add_product_image_info__premium_only() {

		global $product;

		$image_data = $this->get_product_image_data( $product );

		if ( ! empty( $image_data ) ) {
			echo '<meta class="xt_woofc-product-image" data-product_image_src="' . esc_attr( $image_data[0] ) . '" data-product_image_width="' . esc_attr( $image_data[1] ) . '" data-product_image_height="' . esc_attr( $image_data[2] ) . '" />';
		}
	}

	public function get_product_image_data($product) {

		$image_id = $product->get_image_id();

		return wp_get_attachment_image_src( $image_id, 'woocommerce_thumbnail', 0);

	}

    public function get_coupons(){

	    $cache_key = 'xt_woofc_coupons';

	    $coupons = wp_cache_get($cache_key);

	    if(false === $coupons) {

            $showCouponList = $this->coupon_list_enabled();

            if (!$showCouponList) return array();

            $couponListType = $this->core->customizer()->get_option('coupon_list_type', 'all');
            $totalCoupons = intval($this->core->customizer()->get_option('coupon_list_total', 20));

            $includes = array();

            if ($couponListType === 'selection') {
                $selection = trim($this->core->customizer()->get_option('coupon_list_selection', ''));
                if (!empty($selection)) {
                    $includes = array_map('trim', explode(',', $selection));
                }
            }

            $args = array(
                'posts_per_page' => $totalCoupons,
                'include' => $includes,
                'orderby' => 'title',
                'order' => 'asc',
                'post_type' => 'shop_coupon',
                'post_status' => 'publish'
            );

            $coupons_post = get_posts($args);

            if (empty($coupons_post)) return array();

            $coupons = array('valid' => array(), 'invalid' => array());

            $hide_for_error_codes = array(
                105, //Not exists.
                107, //Expired
            );

            $hide_for_error_codes = apply_filters('xoo_wsc_coupon_hide_invalid_codes', $hide_for_error_codes);

            $applied_coupons = WC()->cart->get_applied_coupons();

            foreach ($coupons_post as $coupon_post) {

                $coupon = new WC_Coupon($coupon_post->ID);
                $discounts = new WC_Discounts(WC()->cart);

                $valid = $discounts->is_coupon_valid($coupon);
                $code = $coupon->get_code();

                if(in_array($code, $applied_coupons)){
                    continue;
                }

                $off_amount = $coupon->get_amount();

                $off_value = 'percent' === $coupon->get_discount_type() ? $off_amount . '%' : wc_price($off_amount);

                $data = array(
                    'code' => $code,
                    'coupon' => $coupon,
                    'notice' => '',
                    'off_value' => $off_value
                );

                if (is_wp_error($valid)) {

                    if ($couponListType !== 'all') continue;

                    $error_code = $valid->get_error_code();

                    if (in_array($error_code, $hide_for_error_codes)) continue;

                    $data['notice'] = $valid->get_error_message();

                }

                $coupons[is_wp_error($valid) ? 'invalid' : 'valid'][] = $data;
            }

            wp_cache_set($cache_key, $coupons);
        }

        $coupons = apply_filters( 'xoo_wsc_coupons_list', $coupons );

        return $coupons;
    }

	public function render() {

		if ( ! $this->enabled() ) {
			return false;
		}

		WC()->cart->calculate_totals();

		echo '<div id="xt_woofc">';
		$this->core->get_template( 'minicart' );
		echo '</div>';

	}
}

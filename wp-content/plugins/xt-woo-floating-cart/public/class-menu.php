<?php
/**
 * The Cart Menu Item functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    XT_Woo_Floating_Cart
 * @subpackage XT_Woo_Floating_Cart_Menu/public
 * @author     XplodedThemes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class XT_Woo_Floating_Cart_Menu {

	/**
	 * Core class reference.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      XT_Woo_Floating_Cart $core
	 */
	private $core;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param XT_Woo_Floating_Cart $core Plugin core class
	 *
	 * @since    1.0.0
	 */
	public function __construct( &$core ) {

		$this->core = $core;

		$this->filter_nav_menus();
		$core->plugin_loader()->add_filter( 'woocommerce_add_to_cart_fragments', $this, 'cart_fragments', 1, 1 );
	}

	/**
	 * Add filters to selected menus to add cart item <li>
	 */
	public function filter_nav_menus() {

		$menus = $this->core->customizer()->get_option('cart_menu_menus', array());

		if ( !empty($menus) ) {
			foreach ($menus as $menu_slug) {
				$this->core->plugin_loader()->add_filter( 'wp_nav_menu_' . $menu_slug . '_items', $this, 'add_to_menu', 10, 2 );
			}
		}
	}
	/**
	 * Add Cart Menu to menu
	 *
	 * @return string Menu items + Menu Cart item
	 */
	public function add_to_menu( $items ) {

		$cart_count = WC()->cart->get_cart_contents_count();

		$menu_display_empty = $this->core->customizer()->get_option_bool('cart_menu_display_empty', false);
		$menu_alignment_desktop = $this->core->customizer()->get_option('cart_menu_alignment', 'left');
		$menu_alignment_tablet = $this->core->customizer()->get_option('cart_menu_alignment_tablet', 'inherit');
		$menu_alignment_mobile = $this->core->customizer()->get_option('cart_menu_alignment_mobile', 'inherit');
		$menu_position = $this->core->customizer()->get_option('cart_menu_position', 'last');

		$classes = array(
			'menu-item',
			'xt_woofc-menu',
			'xt_woofc-menu-desktop-align-'.$menu_alignment_desktop,
			'xt_woofc-menu-tablet-align-'.$menu_alignment_tablet,
			'xt_woofc-menu-mobile-align-'.$menu_alignment_mobile,
		);

		if(!$menu_display_empty) {
			$classes[] = 'xt_woofc-menu-hide-empty';
		}

		if($cart_count === 0) {
			$classes[] = 'xt_woofc-menu-empty';
		}

		$common_classes = $this->get_common_li_classes($items);
		if (!empty($common_classes)) {
			$classes = array_merge($classes, $common_classes);
		}

		// Filter for <li> item classes
		/* Usage (in the themes functions.php):
		function theme_prefix_xt_woofc_menu_class ($classes) {
			$classes[] = 'yourclass';
			return $classes;
		}
		add_filter('xt_woofc_menu_classes', 'theme_prefix_xt_woofc_menu_class', 1, 1);
		*/

		$classes = apply_filters( 'xt_woofc_menu_classes', $classes );
		$classes = implode(" ", $classes);

		$menu_li = '<li class="'.esc_attr($classes).'">' . $this->cart_menu_link() . '</li>';

		if ( $menu_position === 'first' ) {
			$items = apply_filters( 'xt_woofc_menu_wrapper', $menu_li ) . $items;
		} else {
			$items .= apply_filters( 'xt_woofc_menu_wrapper', $menu_li );
		}

		return $items;
	}

	/**
	 * Get a flat list of common classes from all menu items in a menu
	 * @param  string $items nav_menu HTML containing all <li> menu items
	 * @return array        flat (imploded) list of common classes
	 */
	public function get_common_li_classes($items) {
		if (empty($items)) return array();
		if (!class_exists('DOMDocument')) return array();

		$libxml_previous_state = libxml_use_internal_errors(true); // enable user error handling

		$dom_items = new DOMDocument;
		$dom_items->loadHTML( $items );
		$lis = $dom_items->getElementsByTagName('li');

		if (empty($lis)) {
			libxml_clear_errors();
			libxml_use_internal_errors($libxml_previous_state);
			return array();
		}

		$li_classes = array();
		foreach($lis as $li) {
			if ($li->parentNode->tagName != 'ul')
				$li_classes[] = explode( ' ', $li->getAttribute('class') );
		}

		// Uncomment to dump DOM errors / warnings
		//$errors = libxml_get_errors();
		//print_r ($errors);

		// clear errors and reset to previous error handling state
		libxml_clear_errors();
		libxml_use_internal_errors($libxml_previous_state);

		$common_li_classes = array();
		if ( !empty($li_classes) ) {
			$common_li_classes = array_shift($li_classes);
			foreach ($li_classes as $li_class) {
				$common_li_classes = array_intersect($li_class, $common_li_classes);
			}
		}

		if (($key = array_search('xt-is-option', $common_li_classes)) !== false) {
			unset($common_li_classes[$key]);
		}

		return $common_li_classes;
	}

	/**
	 * Cart Menu Fragments
	 */
	public function cart_fragments( $fragments ) {

		$fragments['a.xt_woofc-menu-link'] = $this->cart_menu_link();
		return $fragments;
	}

	/**
	 * Create HTML for Menu Cart item
	 */
	public function cart_menu_link() {

		$cart = (object) array(
			'total'	=> xt_woofc_checkout_total(),
			'count'	=> WC()->cart->get_cart_contents_count(),
		);

		$menu_title = esc_html__('View your shopping cart', 'woo-floating-cart');
		$cart_count = sprintf(_n('%s%d%s %sitem%s', '%s%d%s %sitems%s', $cart->count, 'woo-floating-cart'), '<span>', $cart->count, '</span>', '<span>', '</span>');

		$menu_display = $this->core->customizer()->get_option('cart_menu_display', 'items');
		$menu_counter_type_class = $this->core->customizer()->get_option('cart_menu_counter_type', 'text');
		$menu_cart_click_action = $this->core->customizer()->get_option('cart_menu_click_action', 'toggle');

		if(!in_array($menu_cart_click_action, array('toggle', 'cart'))) {
			$menu_href = apply_filters('xt_woofc_menu_url', wc_get_checkout_url() );
		}else{
			$menu_href = apply_filters('xt_woofc_menu_url', wc_get_cart_url() );
		}

		$menu_title = apply_filters('xt_woofc_menu_title', $menu_title );

		$menu_classes = array(
			'xt_woofc-menu-link'
		);

		if($cart->count > 999) {
			$menu_classes[] = 'xt_woofc-count-bigger';
		}else if($cart->count > 99) {
			$menu_classes[] = 'xt_woofc-count-big';
		}

		if(in_array($menu_display, array('items')) && $menu_counter_type_class === 'badge') {
			$menu_classes[] = 'xt_woofc-menu-has-badge';
		}

		if(defined('UBERMENU_VERSION') && (version_compare(UBERMENU_VERSION, '3.0.0') >= 0)){
			$menu_classes[] = 'ubermenu-target';
		}

		$menu_classes = apply_filters ('xt_woofc_menu_link_classes', $menu_classes );
		$menu_classes = implode(" ", $menu_classes);

		$menu = '<a class="'.esc_attr($menu_classes).'" href="'.esc_url($menu_href).'" title="'.esc_attr($menu_title).'">';

		$menu_cart_icon = $this->core->customizer()->get_option('cart_menu_icon', null);

		$menu_content = '';
		if (!empty($menu_cart_icon)) {
			$menu_icon = '<i class="xt_woofc-menu-icon '.esc_attr($menu_cart_icon).'" role="img" aria-label="'.esc_html__( 'Cart','woo-floating-cart' ).'"></i>';
			$menu_content .= $menu_icon;
		} else {
			$menu_icon = '';
		}

		$counter_classes = array('xt_woofc-menu-count', 'xt_woofc-counter-type-'.$menu_counter_type_class);

		if($menu_counter_type_class === 'badge') {

			$counter_classes[] = 'xt_woofc-counter-position-'.$this->core->customizer()->get_option( 'cart_menu_counter_badge_position', 'above' );
		}

		$counter_classes = implode(" ", $counter_classes);

		switch ($menu_display) {
			case 'items': //items only
				$menu_content .= '<span class="'.esc_attr($counter_classes).'">'.$cart_count.'</span>';
				break;
			case 'price': //price only
				$menu_content .= '<span class="xt_woofc-menu-amount">'.$cart->total.'</span>';
				break;
			case 'both': //items & price
				$menu_content .= '<span class="'.esc_attr($counter_classes).'">'.$cart_count.'</span><span class="xt_woofc-menu-amount">'.$cart->total.'</span>';
				break;
		}
		$menu_content = apply_filters('xt_woofc_menu_link_content', $menu_content, $menu_icon, $cart_count, $cart->total, $cart );

		$menu .= $menu_content . '</a>';

		$menu = apply_filters('xt_woofc_menu_link', $menu, $menu_content, $cart_count, $cart->total, $cart);

		if( !empty( $menu ) ) {
			return $menu;
		}

		return null;
	}
}

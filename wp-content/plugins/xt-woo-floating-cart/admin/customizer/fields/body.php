<?php
if ( $this->core->access_manager()->can_use_premium_code__premium_only() ) {

	$fields[] = array(
		'id'        => 'cart_body_bg_color',
		'section'   => 'body',
		'label'     => esc_html__( 'Cart Body Bg Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#ffffff',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-bg-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_body_text_color',
		'section'   => 'body',
		'label'     => esc_html__( 'Cart Body Text Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#666666',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_body_link_color',
		'section'   => 'body',
		'label'     => esc_html__( 'Cart Body Link Color', 'woo-floating-cart' ),
		'type' => 'color',
		'priority'  => 10,
		'default'   => '#2b3e51',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-link-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_body_link_hover_color',
		'section'   => 'body',
		'label'     => esc_html__( 'Cart Body Link Hover Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#2b3e51',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-link-hover-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_body_border_color',
		'section'   => 'body',
		'label'     => esc_html__( 'Cart Body Border Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#e6e6e6',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-border-color'
			)
		)
	);

} else {

	$fields[] = array(
		'id'      => 'body_features',
		'section' => 'body',
		'type'    => 'xt-premium',
		'default' => array(
			'type'  => 'image',
			'value' => $this->core->plugin_url() . 'admin/customizer/assets/images/body.png',
			'link'  => $this->core->plugin_upgrade_url()
		)
	);
}
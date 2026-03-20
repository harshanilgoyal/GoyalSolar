<?php

if ( $this->core->access_manager()->can_use_premium_code__premium_only() ) {

	$fields[] = array(
		'id'          => 'cart_header_msg_enabled',
		'section'     => 'header',
		'label'       => esc_html__( 'Cart Header Message Enabled', 'woo-floating-cart' ),
		'type'        => 'radio-buttonset',
		'choices'     => array(
			'1' => esc_attr__( 'Enable', 'woo-floating-cart' ),
			'0' => esc_attr__( 'Disable', 'woo-floating-cart' )
		),
		'default'     => '0'
	);

	$fields[] = array(
		'id'          => 'cart_header_msg',
		'section'     => 'header',
		'label'       => esc_html__( 'Cart Header Message', 'woo-floating-cart' ),
		'type'        => 'text',
		'transport'   => 'postMessage',
		'partial_refresh'    => [
			'cart_header_msg' => [
				'selector'        => '.xt_woofc-header-message',
				'render_callback' => function() {
					$this->core->frontend()->render_header_message__premium_only(true);
				},
			]
		],
		'active_callback' => array(
			array(
				'setting'  => 'cart_header_msg_enabled',
				'operator' => '==',
				'value'    => '1',
			),
		),
		'default'     => ''
	);

	$fields[] = array(
		'id'        => 'cart_header_message_bg_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Message Bg Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-msg-bg-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_header_msg_enabled',
				'operator' => '==',
				'value'    => '1',
			),
		)
	);

	$fields[] = array(
		'id'        => 'cart_header_message_text_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Message Text Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-msg-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_header_msg_enabled',
				'operator' => '==',
				'value'    => '1',
			),
		)
	);

	$fields[] = array(
        'id'          => 'cart_header_close_enabled',
        'section'     => 'header',
        'label'       => esc_html__( 'Enable cart close icon in the header', 'woo-floating-cart' ),
        'description' => sprintf( esc_html__( 'This is useful when the cart animation is set to "Slide". The "Morph" Animation already has a close button in the footer', 'woo-floating-cart' ), '<strong>', '</strong>' ),
        'type'        => 'radio-buttonset',
        'choices'     => array(
            '1' => esc_attr__( 'Enable', 'woo-floating-cart' ),
            '0' => esc_attr__( 'Disable', 'woo-floating-cart' )
        ),
        'default'     => '0'
    );

    $fields[] = array(
        'id'              => 'cart_header_close_icon',
        'section'         => 'header',
        'label'           => esc_html__( 'Cart Header Close Icon', 'woo-floating-cart' ),
        'type'            => 'xticons',
        'choices'         => array( 'types' => array( 'close' ) ),
        'priority'        => 10,
        'default'         => 'xt_woofcicon-close-2',
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.xt_woofc-header-close',
                'function' => 'class'
            )
        ),
        'active_callback' => array(
            array(
                'setting'  => 'cart_header_close_enabled',
                'operator' => '==',
                'value'    => '1',
            ),
        )
    );

    $fields[] = array(
        'id'              => 'cart_header_close_icon_color',
        'section'         => 'header',
        'label'           => esc_html__( 'Cart Header Close Icon Color', 'woo-floating-cart' ),
        'type'            => 'color',
        'priority'        => 10,
        'default'         => '#000000',
        'transport'       => 'auto',
        'output'          => array(
	        array(
		        'element'       => ':root',
		        'property' => '--xt-woofc-header-close-color',
	        )
        ),
        'active_callback' => array(
            array(
                'setting'  => 'cart_header_close_enabled',
                'operator' => '==',
                'value'    => '1',
            ),
        )
    );

	$fields[] = array(
		'id'        => 'cart_header_bg_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Bg Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#ffffff',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-bg-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_header_bottom_border_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Bottom Border Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#e6e6e6',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-border-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_header_title_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Title Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#263646',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-title-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_header_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Text Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#808b97',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_header_link_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Link Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#2b3e51',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-link-color',
			)
		)
	);
	$fields[] = array(
		'id'        => 'cart_header_link_hover_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Link Hover Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#2b3e51',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-link-hover-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'cart_header_error_color',
		'section'   => 'header',
		'label'     => esc_html__( 'Cart Header Error Message Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#dd3333',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-header-error-color',
			)
		)
	);

} else {

	$fields[] = array(
		'id'      => 'header_features',
		'section' => 'header',
		'type'    => 'xt-premium',
		'default' => array(
			'type'  => 'image',
			'value' => $this->core->plugin_url() . 'admin/customizer/assets/images/header.png',
			'link'  => $this->core->plugin_upgrade_url()
		)
	);
}
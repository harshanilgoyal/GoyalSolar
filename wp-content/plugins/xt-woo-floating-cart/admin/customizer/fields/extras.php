<?php
if ( $this->core->access_manager()->can_use_premium_code__premium_only() ) {

    $fields[] = array(
        'id' => 'checkout_form',
        'section'   => 'extras',
        'label'     => esc_html__( 'Checkout Form', 'woo-floating-cart' ),
        'type' => 'custom'
    );

	$fields[] = array(
		'id'          => 'cart_checkout_form',
		'section'     => 'extras',
		'label'       => esc_html__( 'Enable Checkout Form', 'woo-floating-cart' ),
		'description' => sprintf( esc_html__( 'This option will load the checkout form below the cart list and will transform the %1$sCheckout%2$s button into a %1$sPlace Order%2$s button. If checkout registration is disabled and not logged in, this option will be disabled.', 'woo-floating-cart' ), '<strong>', '</strong>' ),
		'type'        => 'radio-buttonset',
		'choices'     => array(
			'1' => esc_attr__( 'Enable', 'woo-floating-cart' ),
			'0' => esc_attr__( 'Disable', 'woo-floating-cart' )
		),
		'default'     => '0'
	);
	$fields[] = array(
		'id'          => 'cart_checkout_form_font_size',
		'section'     => 'extras',
		'label'       => esc_html__( 'Checkout Form Overall Font Size', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '100',
			'max'  => '200',
			'step' => '1',
			'suffix' => '%'
		),
		'default'   => '120',
		'transport' => 'auto',
		'output' => array(
			array(
				'element' => ':root',
				'property' => '--xt-woofc-checkout-form-font-size',
				'value_pattern' => '$%'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_checkout_form',
				'operator' => '==',
				'value'    => '1',
			),
		),
	);

    $fields[] = array(
        'id' => 'cart_totals',
        'section'   => 'extras',
        'label'     => esc_html__( 'Cart Totals', 'woo-floating-cart' ),
        'type' => 'custom'
    );

	$fields[] = array(
		'id'              => 'enable_totals',
		'section'         => 'extras',
		'label'           => esc_html__( 'Enable Totals', 'woo-floating-cart' ),
		'type'            => 'radio-buttonset',
		'choices'         => array(
			'0' => esc_html__( 'No', 'woo-floating-cart' ),
			'1' => esc_html__( 'Yes', 'woo-floating-cart' )
		),
		'default'         => '0',
		'active_callback' => array(
			array(
				'setting'  => 'cart_checkout_form',
				'operator' => '==',
				'value'    => '0',
			),
		),
	);

	$fields[] = array(
		'id'              => 'enable_total_savings',
		'section'         => 'extras',
		'label'           => esc_html__( 'Enable Total Savings', 'woo-floating-cart' ),
		'description'     => sprintf( esc_html__( 'This option requires the "Enable Totals" or "Enable Checkout Form" options to be enabled.', 'woo-floating-cart' ), '<strong>', '</strong>' ),
		'type'            => 'radio-buttonset',
		'choices'         => array(
			'0' => esc_html__( 'No', 'woo-floating-cart' ),
			'1' => esc_html__( 'Yes', 'woo-floating-cart' )
		),
		'default'         => '0'
	);

	$fields[] = array(
		'id'      => 'total_savings_color',
		'section' => 'extras',
		'label' => esc_html__( 'Total Savings Text Color', 'woo-floating-cart' ),
		'type' => 'color',
		'priority' => 10,
		'default' => '#4b9b12',
		'transport' => 'auto',
		'output' => array(
			array(
				'element' => ':root',
				'property' => '--xt-woofc-totals-savings-color',
			)
		),
		'active_callback' => array(
			array(
				'setting' => 'enable_total_savings',
				'operator' => '==',
				'value' => '1',
			),
		)
	);

    $fields[] = array(
        'id' => 'express_payment_buttons',
        'section'   => 'extras',
        'label'     => esc_html__( 'Express Payment buttons', 'woo-floating-cart' ),
        'type' => 'custom'
    );

    $fields[] = array(
        'id'              => 'paypal_express_checkout',
        'section'         => 'extras',
        'label'           => esc_html__( 'Paypal Express Checkout', 'woo-floating-cart' ),
        'description'     => '<p><a href="https://wordpress.org/plugins/woocommerce-gateway-paypal-express-checkout/" target="_blank">'.esc_html__( 'Download paypal plugin', 'woo-floating-cart').'</a></p>',
        'type'            => 'radio-buttonset',
        'transport'       => 'postMessage',
        'choices'         => array(
            '0' => esc_attr__( 'Disable', 'woo-floating-cart' ),
            '1'     => esc_attr__( 'Enable', 'woo-floating-cart' )
        ),
        'default'         => '0',
        'js_vars'         => array(
            array(
                'element'  => '.xt_woofc',
                'function' => 'toggleClass',
                'class' => 'xt_woofc-custom-payments',
                'value' => '1'
            )
        ),
    );

    $fields[] = array(
        'id' => 'suggested_products',
        'section'   => 'extras',
        'label'     => esc_html__( 'Suggested Products', 'woo-floating-cart' ),
        'type' => 'custom'
    );

    $fields[] = array(
        'id'          => 'suggested_products_enabled',
        'section'     => 'extras',
        'label'       => esc_html__( 'Enable Suggested Products', 'woo-floating-cart' ),
        'type'        => 'radio-buttonset',
        'choices'     => array(
            '1' => esc_attr__( 'Enable', 'woo-floating-cart' ),
            '0' => esc_attr__( 'Disable', 'woo-floating-cart' )
        ),
        'default'     => '1',
    );

    $fields[] = array(
        'id'          => 'suggested_products_mobile_enabled',
        'section'     => 'extras',
        'label'       => esc_html__( 'Enable Suggested Products on Mobile', 'woo-floating-cart' ),
        'type'        => 'radio-buttonset',
        'choices'     => array(
            '1' => esc_attr__( 'Enable', 'woo-floating-cart' ),
            '0' => esc_attr__( 'Disable', 'woo-floating-cart' )
        ),
        'default'     => '0',
        'active_callback' => array(
            array(
                'setting'  => 'suggested_products_enabled',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    );

    $fields[] = array(
        'id'          => 'suggested_products_type',
        'section'     => 'extras',
        'label'       => esc_html__( 'Suggested Products Type', 'woo-floating-cart' ),
        'type'        => 'radio-buttonset',
        'input_attrs' => array(
	        'data-col' => '2'
        ),
        'choices'     => array(
	        'cross_sells' => esc_attr__( 'Cross-Sells', 'woo-floating-cart' ),
	        'up_sells'   => esc_attr__( 'Up-Sells', 'woo-floating-cart' ),
            'related'    => esc_attr__( 'Related', 'woo-floating-cart' ),
	        'selection'    => esc_attr__( 'Selection', 'woo-floating-cart' )
        ),
        'default'     => 'cross_sells',
        'active_callback' => array(
            array(
                'setting'  => 'suggested_products_enabled',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    );

	$fields[] = array(
		'id'          => 'suggested_products_selection',
		'section'     => 'extras',
		'label'       => esc_html__( 'Suggested Products Selection', 'woo-floating-cart' ),
		'description' => esc_html__( 'Enter product ids separated by a comma', 'woo-floating-cart' ),
		'type'        => 'text',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'suggested_products_enabled',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'suggested_products_type',
				'operator' => '==',
				'value'    => 'selection',
			),
		),
	);

	$fields[] = array(
		'id'          => 'suggested_products_position',
		'section'     => 'extras',
		'label'       => esc_html__( 'Suggested Products Position', 'woo-floating-cart' ),
		'type'        => 'radio',
		'choices'     => array(
			'below_list'   => esc_attr__( 'Below Cart List', 'woo-floating-cart' ),
			'above_totals' => esc_attr__( 'Above Cart Totals', 'woo-floating-cart' ),
			'below_totals'    => esc_attr__( 'Below Cart Totals', 'woo-floating-cart' )
		),
		'default'     => 'below_list',
		'active_callback' => array(
			array(
				'setting'  => 'suggested_products_enabled',
				'operator' => '==',
				'value'    => '1',
			),
		),
	);

    $fields[] = array(
        'id'          => 'suggested_products_title',
        'section'     => 'extras',
        'label'       => esc_html__( 'Suggested Products Title', 'woo-floating-cart' ),
        'type'        => 'text',
        'default'     => esc_html__('Products you might like','woo-floating-cart'),
        'active_callback' => array(
            array(
                'setting'  => 'suggested_products_enabled',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    );

    $fields[] = array(
        'id'          => 'suggested_products_count',
        'section'     => 'extras',
        'label'       => esc_html__( 'Suggested Products Count', 'woo-floating-cart' ),
        'type'      => 'slider',
        'choices'   => array(
            'min'  => '1',
            'max'  => '10',
            'step' => '1',
        ),
        'default'   => '5',
        'active_callback' => array(
            array(
                'setting'  => 'suggested_products_enabled',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    );

    $fields[] = array(
        'id'              => 'suggested_products_arrow',
        'section'         => 'extras',
        'label'           => esc_html__( 'Suggested Products Arrows Icon', 'woo-floating-cart' ),
        'type'            => 'xticons',
        'choices'         => array( 'types' => array( 'arrow' ) ),
        'priority'        => 10,
        'default'         => 'xt_wooqvicon-arrows-28',
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.xt_woofc-inner .xt_woofc-sp-arrow-icon',
                'function' => 'class'
            )
        ),
        'active_callback' => array(
            array(
                'setting'  => 'suggested_products_enabled',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    );

	$fields[] = array(
		'id' => 'suggested_products_arrow_size',
		'section' => 'extras',
		'label' => esc_html__( 'Suggested Products Arrows Size', 'woo-floating-cart' ),
		'type' => 'slider',
		'choices' => array(
			'min' => '14',
			'max' => '30',
			'step' => '1',
            'suffix' => 'px',
		),
		'priority' => 10,
		'default' => '20',
		'transport' => 'auto',
		'output' => array(
			array(
				'element' => ':root',
				'property' => '--xt-woofc-sp-arrow-size',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
			array(
				'setting' => 'suggested_products_enabled',
				'operator' => '==',
				'value' => '1',
			),
		)
	);

	$fields[] = array(
		'id' => 'suggested_products_arrow_color',
		'section' => 'extras',
		'label' => esc_html__( 'Suggested Products Arrows Color', 'woo-floating-cart' ),
		'type' => 'color',
		'priority' => 10,
		'default' => '#2b3e51',
		'transport' => 'auto',
		'output' => array(
			array(
				'element' => ':root',
				'property' => '--xt-woofc-sp-arrow-color',
			)
		),
		'active_callback' => array(
			array(
				'setting' => 'suggested_products_enabled',
				'operator' => '==',
				'value' => '1',
			),
		)
	);

	$fields[] = array(
		'id' => 'suggested_products_arrow_hover_color',
		'section' => 'extras',
		'label' => esc_html__( 'Suggested Products Arrows Hover Color', 'woo-floating-cart' ),
		'type' => 'color',
		'priority' => 10,
		'default' => '#1a3651',
		'transport' => 'auto',
		'output' => array(
			array(
				'element' => ':root',
				'property' => '--xt-woofc-sp-arrow-hover-color',
			)
		),
		'active_callback' => array(
			array(
				'setting' => 'suggested_products_enabled',
				'operator' => '==',
				'value' => '1',
			),
		)
	);

} else {

	$fields[] = array(
		'id'      => 'extras_features',
		'section' => 'extras',
		'type'    => 'xt-premium',
		'default' => array(
			'type'  => 'image',
			'value' => $this->core->plugin_url() . 'admin/customizer/assets/images/extras.png',
			'link'  => $this->core->plugin_upgrade_url()
		)
	);
}
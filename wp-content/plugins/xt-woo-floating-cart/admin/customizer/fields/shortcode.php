<?php
if ( $this->core->access_manager()->can_use_premium_code__premium_only() ) {

	$fields[] = array(
		'id'       => 'cart_shortcode_enabled',
		'section'  => 'shortcode',
		'label'       => esc_html__( 'Enable Cart Trigger Shortcode', 'woo-floating-cart' ),
		'type'        => 'radio-buttonset',
		'choices'     => array(
			'0' => esc_html__( 'No', 'woo-floating-cart' ),
			'1' => esc_html__( 'Yes', 'woo-floating-cart' )
		),
		'default'     => '0',
		'priority'    => 10
	);

	$fields[] = array(
		'id' => 'cart_shortcode_output',
		'section'  => 'shortcode',
		'type' => 'custom',
		'label' => esc_html__('The Shortcode', 'woo-floating-cart'),
		'description' => sprintf(esc_html__('You can place this shortcode anywhere within wordpress editor or directly within your child theme templates using the %s function', 'woo-floating-cart'), '<a target="_blank" href="https://css-tricks.com/snippets/wordpress/shortcode-in-a-template/">do_shortcode()</a>'),
		'default' => '<br><input readonly="readonly" class="xirki-code-input" value="[xt_woofc_shortcode]" />',
		'priority' => 10,
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
		)
	);

	$fields[] = array(
		'id'              => 'cart_shortcode_size',
		'section'         => 'shortcode',
		'label'           => esc_html__( 'Overall Size', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '10',
			'max'  => '50',
			'step' => '1',
			'suffix' => 'px',
		),
		'priority'        => 10,
		'default'         => '16',
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-shortcode-size',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			)
		)
	);

	$fields[] = array(
		'id'       => 'cart_shortcode_display',
		'section'  => 'shortcode',
		'label'       => esc_html__( 'Display Mode', 'woo-floating-cart' ),
		'description' => esc_html__( 'What would you like to display in the trigger?', 'woo-floating-cart' ),
		'type'        => 'radio-buttonset',
		'choices'     => array(
			'icon'	  => esc_html__( 'Icon Only' , 'woo-floating-cart' ),
			'items'	  => esc_html__( 'Counter' , 'woo-floating-cart' ),
			'price'	  => esc_html__( 'Price' , 'woo-floating-cart' ),
			'both'	  => esc_html__( 'Both' , 'woo-floating-cart'),
		),
		'input_attrs' => array(
			'data-col' => '2'
		),
		'default'     => 'items',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'partial_refresh'    => [
			'cart_shortcode_display' => [
				'selector'        => 'a.xt_woofc-shortcode-link',
				'render_callback' => function() {
					return $this->core->frontend()->shortcode->cart_shortcode_link();
				},
			]
		],
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
		)
	);

	$fields[] = array(
		'id'       => 'cart_shortcode_counter_type',
		'section'  => 'shortcode',
		'label'       => esc_html__( 'Counter Type', 'woo-floating-cart' ),
		'description' => esc_html__( 'What would you like to display the counter?', 'woo-floating-cart' ),
		'type'        => 'radio-buttonset',
		'choices'     => array(
			'text'	        => esc_html__( 'Text' , 'woo-floating-cart' ),
			'badge'	        => esc_html__( 'Badge' , 'woo-floating-cart' ),
		),
		'input_attrs' => array(
			'data-col' => '2'
		),
		'default'     => 'text',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'js_vars'     => array(
			array(
				'element'  => '.xt_woofc-shortcode-count',
				'function' => 'class',
				'prefix' => 'xt_woofc-counter-type-'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'cart_shortcode_display',
				'operator' => 'in',
				'value'    => array('items', 'both'),
			)
		)
	);

	$fields[] = array(
		'id'       => 'cart_shortcode_counter_badge_position',
		'section'  => 'shortcode',
		'label'    => esc_html__( 'Counter Badge Position', 'woo-floating-cart' ),
		'type'     => 'radio-buttonset',
		'choices'     => array(
			'above'	    => esc_html__( 'Above' , 'woo-floating-cart' ),
			'inline'	=> esc_html__( 'Inline' , 'woo-floating-cart' ),
		),
		'input_attrs' => array(
			'data-col' => '2'
		),
		'default'     => 'above',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'js_vars'     => array(
			array(
				'element'  => '.xt_woofc-shortcode-count',
				'function' => 'class',
				'prefix' => 'xt_woofc-counter-position-'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'cart_shortcode_display',
				'operator' => 'in',
				'value'    => array('items', 'both'),
			),
			array(
				'setting'  => 'cart_shortcode_counter_type',
				'operator' => '==',
				'value'    => 'badge',
			),
		)
	);

	$fields[] = array(
		'id'       => 'cart_shortcode_counter_badge_size',
		'section'  => 'shortcode',
		'label'    => esc_html__( 'Counter Badge Size', 'woo-floating-cart' ),
		'type'     => 'slider',
		'choices'  => array(
			'min'  => '0.8',
			'max'  => '1.2',
			'step' => '0.1',
			'suffix' => 'x',
		),
		'priority'        => 10,
		'default'         => '1',
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-shortcode-badge-scale'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'cart_shortcode_display',
				'operator' => 'in',
				'value'    => array('items', 'both'),
			),
			array(
				'setting'  => 'cart_shortcode_counter_type',
				'operator' => '==',
				'value'    => 'badge',
			),
		)
	);

	$fields[] = array(
		'id'              => 'cart_shortcode_badge_text_color',
		'section'         => 'shortcode',
		'label'           => esc_html__( 'Counter Badge Color', 'woo-floating-cart' ),
		'type'            => 'color',
		'priority'        => 10,
		'default'         => '',
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-shortcode-badge-color'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'cart_shortcode_display',
				'operator' => 'in',
				'value'    => array('items', 'both'),
			),
			array(
				'setting'  => 'cart_shortcode_counter_type',
				'operator' => '==',
				'value'    => 'badge',
			),
		)
	);

	$fields[] = array(
		'id'              => 'cart_shortcode_badge_bg_color',
		'section'         => 'shortcode',
		'label'           => esc_html__( 'Counter Badge Bg Color', 'woo-floating-cart' ),
		'type'            => 'color',
		'priority'        => 10,
		'default'         => '',
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-shortcode-badge-bg-color'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'cart_shortcode_display',
				'operator' => 'in',
				'value'    => array('items', 'both'),
			),
			array(
				'setting'  => 'cart_shortcode_counter_type',
				'operator' => '==',
				'value'    => 'badge',
			),
		)
	);

	$fields[] = array(
		'id'       => 'cart_shortcode_click_action',
		'section'  => 'shortcode',
		'label'       => esc_html__( 'Click Action', 'woo-floating-cart' ),
		'type'        => 'radio-buttonset',
		'choices'     => array(
			'toggle' => esc_html__( 'Toggle Cart', 'woo-floating-cart' ),
			'cart' => esc_html__( 'Go To Cart', 'woo-floating-cart' ),
			'checkout' => esc_html__( 'Go To Checkout', 'woo-floating-cart' )
		),
		'default'     => 'toggle',
		'priority'    => 10,
		'partial_refresh'    => [
			'cart_shortcode_click_action' => [
				'selector'        => 'a.xt_woofc-shortcode-link',
				'render_callback' => function() {
					return $this->core->frontend()->shortcode->cart_shortcode_link();
				},
			]
		],
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			),
		)
	);

	$fields[] = array(
		'id'              => 'cart_shortcode_icon_size',
		'section'         => 'shortcode',
		'label'           => esc_html__( 'Icon Size', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '1',
			'max'  => '1.5',
			'step' => '0.1',
			'suffix' => 'x',
		),
		'priority'        => 10,
		'default'         => '1.2',
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-shortcode-icon-scale'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			)
		)
	);

	$fields[] = array(
		'id'              => 'cart_shortcode_icon',
		'section'         => 'shortcode',
		'label'           => esc_html__( 'Select Icon', 'woo-floating-cart' ),
		'type'            => 'xticons',
		'choices'         => array( 'types' => array( 'cart' ) ),
		'priority'        => 10,
		'default'         => 'xt_woofcicon-shop',
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => '.xt_woofc-shortcode-icon',
				'function' => 'class'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			)
		)
	);

	$fields[] = array(
		'id'              => 'cart_shortcode_icon_color',
		'section'         => 'shortcode',
		'label'           => esc_html__( 'Icon Color', 'woo-floating-cart' ),
		'type'            => 'color',
		'priority'        => 10,
		'default'         => '',
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-shortcode-icon-color'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			)
		)
	);

	$fields[] = array(
		'id'              => 'cart_shortcode_text_color',
		'section'         => 'shortcode',
		'label'           => esc_html__( 'Text Color', 'woo-floating-cart' ),
		'type'            => 'color',
		'priority'        => 10,
		'default'         => '',
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-shortcode-text-color'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_shortcode_enabled',
				'operator' => '==',
				'value'    => '1',
			)
		)
	);

} else {

	$fields[] = array(
		'id'      => 'cart_shortcode_features',
		'section' => 'shortcode',
		'type'    => 'xt-premium',
		'default' => array(
			'type'  => 'image',
			'value' => $this->core->plugin_url() . 'admin/customizer/assets/images/shortcode.png',
			'link'  => $this->core->plugin_upgrade_url()
		)
	);
}
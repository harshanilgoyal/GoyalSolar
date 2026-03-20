<?php
/* @var $customizer XT_Framework_Customizer */

$fields[] = array(
	'id'          => 'ajax_init',
	'section'     => 'general',
	'label'       => esc_html__( 'Force Ajax Initialization', 'woo-floating-cart' ),
	'description' => esc_html__( 'Enable only if encountering caching issues / conflicts with your theme', 'woo-floating-cart' ),
	'type'        => 'radio-buttonset',
	'choices'     => array(
		'0' => esc_html__( 'No', 'woo-floating-cart' ),
		'1' => esc_html__( 'Yes', 'woo-floating-cart' )
	),
	'default'     => '0',
	'priority'    => 10,
	'transport'   => 'postMessage'
);

$fields[] = array(
	'id'          => 'active_cart_body_lock_scroll',
	'section'     => 'general',
	'label'       => esc_html__( 'Lock page scroll when active', 'woo-floating-cart' ),
	'description' => esc_html__( 'When the floating cart is open, lock main site body scroll', 'woo-floating-cart' ),
	'type'        => 'radio-buttonset',
	'choices'     => array(
		'0' => esc_html__( 'No', 'woo-floating-cart' ),
		'1' => esc_html__( 'Yes', 'woo-floating-cart' )
	),
	'default'     => '1',
	'priority'    => 10
);

$fields[] = array(
	'id'        => 'active_cart_body_overlay_color',
	'section'   => 'general',
	'label'     => esc_html__( 'Overlay Color', 'woo-floating-cart' ),
	'description' => esc_html__( 'Set the Overlay Color on top of the page content, behind the cart. This helps focusing on the cart.', 'woo-floating-cart' ),
	'type'      => 'color',
	'choices'   => array(
		'alpha' => true
	),
	'priority'  => 10,
	'default'   => 'rgba(0,0,0,.5)',
	'transport' => 'auto',
	'output'    => array(
		array(
			'element'  => ':root',
			'property' => '--xt-woofc-overlay-color',
		)
	)
);

$fields[] = array(
	'id'        => 'position',
	'section'   => 'general',
	'label'     => esc_html__( 'Trigger / Cart Position', 'woo-floating-cart' ),
	'type'      => 'radio',
	'priority'  => 10,
	'choices'   => array(
		'top-left'     => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'    => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left'  => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right' => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'     => '.xt_woofc',
			'function'    => 'class',
			'prefix'      => 'xt_woofc-pos-',
			'media_query' => $customizer->media_query('desktop', 'min'),
		),
		array(
			'element'     => '.xt_woofc',
			'function'    => 'html',
			'attr'        => 'data-position',
			'media_query' => $customizer->media_query('desktop', 'min'),
		)
	),
	'default'   => 'bottom-right',
	'screen' => 'desktop'
);

$fields[] = array(
	'id'        => 'position_tablet',
	'section'   => 'general',
	'label'     => esc_html__( 'Trigger / Cart Position', 'woo-floating-cart' ),
	'type'      => 'radio',
	'priority'  => 10,
	'choices'   => array(
		'top-left'     => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'    => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left'  => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right' => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'     => '.xt_woofc',
			'function'    => 'class',
			'prefix'      => 'xt_woofc-tablet-pos-',
			'media_query' => $customizer->media_query('tablet', 'max'),
		),
		array(
			'element'     => '.xt_woofc',
			'function'    => 'html',
			'attr'        => 'data-tablet_position',
			'media_query' => $customizer->media_query('tablet', 'max'),
		)
	),
	'default'   => 'bottom-right',
	'screen' => 'tablet'
);

$fields[] = array(
	'id'        => 'position_mobile',
	'section'   => 'general',
	'label'     => esc_html__( 'Trigger / Cart Position', 'woo-floating-cart' ),
	'type'      => 'radio',
	'priority'  => 10,
	'choices'   => array(
		'top-left'     => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'    => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left'  => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right' => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'     => '.xt_woofc',
			'function'    => 'class',
			'prefix'      => 'xt_woofc-mobile-pos-',
			'media_query' => $customizer->media_query('mobile', 'max'),
		),
		array(
			'element'     => '.xt_woofc',
			'function'    => 'html',
			'attr'        => 'data-mobile_position',
			'media_query' => $customizer->media_query('mobile', 'max'),
		)
	),
	'default'   => 'bottom-right',
	'screen' => 'mobile'
);


$fields[] = array(
	'id'        => 'counter_position',
	'section'   => 'general',
	'label'     => esc_html__( 'Product Counter Position', 'woo-floating-cart' ),
	'type'      => 'radio',
	'priority'  => 10,
	'choices'   => array(
		'top-left'     => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'    => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left'  => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right' => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'     => '.xt_woofc',
			'function'    => 'class',
			'prefix'      => 'xt_woofc-counter-pos-',
			'media_query' => $customizer->media_query('desktop', 'min'),
		)
	),
	'default'   => 'top-left',
	'screen' => 'desktop'
);

$fields[] = array(
	'id'        => 'counter_position_tablet',
	'section'   => 'general',
	'label'     => esc_html__( 'Product Counter Position', 'woo-floating-cart' ),
	'type'      => 'radio',
	'priority'  => 10,
	'choices'   => array(
		'top-left'     => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'    => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left'  => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right' => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'     => '.xt_woofc',
			'function'    => 'class',
			'prefix'      => 'xt_woofc-counter-tablet-pos-',
			'media_query' => $customizer->media_query('tablet', 'max'),
		)
	),
	'default'   => 'top-left',
	'screen' => 'tablet'
);

$fields[] = array(
	'id'        => 'counter_position_mobile',
	'section'   => 'general',
	'label'     => esc_html__( 'Product Counter Position', 'woo-floating-cart' ),
	'type'      => 'radio',
	'priority'  => 10,
	'choices'   => array(
		'top-left'     => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'    => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left'  => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right' => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'     => '.xt_woofc',
			'function'    => 'class',
			'prefix'      => 'xt_woofc-counter-mobile-pos-',
			'media_query' => $customizer->media_query('mobile', 'max'),
		)
	),
	'default'   => 'top-left',
	'screen' => 'mobile'
);

if ( $this->core->access_manager()->can_use_premium_code__premium_only() ) {

    $fields[] = array(
        'id'        => 'animation_type',
        'section'   => 'general',
        'label'     => esc_html__( 'Animation Type', 'woo-floating-cart' ),
        'type'        => 'radio-buttonset',
        'priority'  => 10,
        'choices'   => array(
            'morph'     => esc_html__( 'Morph', 'woo-floating-cart' ),
            'slide'    => esc_html__( 'Slide', 'woo-floating-cart' )
        ),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'     => '.xt_woofc',
                'function'    => 'class',
                'prefix'      => 'xt_woofc-animation-'
            ),
            array(
                'element'     => '.xt_woofc',
                'function'    => 'html',
                'attr'        => 'data-animation',
            )
        ),
        'default'   => 'morph'
    );

    $fields[] = array(
		'id'        => 'trigger_size',
		'section'   => 'general',
		'label'     => esc_html__( 'Trigger Size', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '40',
			'max'  => '100',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '72',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-trigger-size',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'        => 'trigger_size_tablet',
		'section'   => 'general',
		'label'     => esc_html__( 'Trigger Size', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '40',
			'max'  => '100',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '72',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-trigger-size',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'        => 'trigger_size_mobile',
		'section'   => 'general',
		'label'     => esc_html__( 'Trigger Size', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '40',
			'max'  => '100',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '72',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-trigger-size',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'mobile'
	);

	$fields[] = array(
		'id'        => 'counter_size',
		'section'   => 'general',
		'label'     => esc_html__( 'Product Counter Size', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '20',
			'max'  => '40',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '25',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-counter-size',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'        => 'counter_size_tablet',
		'section'   => 'general',
		'label'     => esc_html__( 'Product Counter Size', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '20',
			'max'  => '40',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '25',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-counter-size',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'        => 'counter_size_mobile',
		'section'   => 'general',
		'label'     => esc_html__( 'Product Counter Size', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '20',
			'max'  => '40',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '25',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-counter-size',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'mobile'
	);

	$fields[] = array(
		'id'        => 'hoffset',
		'section'   => 'general',
		'label'     => esc_html__( 'Horizontal Offset', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '0',
			'max'  => '300',
			'step' => '1',
            'suffix' => 'px',
		),
		'priority'  => 10,
		'default'   => '20',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-hoffset',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'        => 'hoffset_tablet',
		'section'   => 'general',
		'label'     => esc_html__( 'Horizontal Offset', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '0',
			'max'  => '300',
			'step' => '1',
            'suffix' => 'px',
		),
		'priority'  => 10,
		'default'   => '20',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-hoffset',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'        => 'hoffset_mobile',
		'section'   => 'general',
		'label'     => esc_html__( 'Horizontal Offset', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '0',
			'max'  => '300',
			'step' => '1',
            'suffix' => 'px',
		),
		'priority'  => 10,
		'default'   => '0',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-hoffset',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'mobile'
	);

	$fields[] = array(
		'id'        => 'voffset',
		'section'   => 'general',
		'label'     => esc_html__( 'Vertical Offset', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '0',
			'max'  => '300',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '20',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-voffset',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'        => 'voffset_tablet',
		'section'   => 'general',
		'label'     => esc_html__( 'Vertical Offset', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '0',
			'max'  => '300',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '20',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-voffset',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'        => 'voffset_mobile',
		'section'   => 'general',
		'label'     => esc_html__( 'Vertical Offset', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '0',
			'max'  => '300',
			'step' => '1',
            'suffix' => 'px',
		),
		'default'   => '0',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-voffset',
				'value_pattern' => '$px'
			)
		),
		'screen' => 'mobile'
	);


    $fields[] = array(
        'id'        => 'cart_autoheight_enabled',
        'section'   => 'general',
        'label'     => esc_html__( 'Cart Auto Height', 'woo-floating-cart' ),
        'type'        => 'radio-buttonset',
        'priority'  => 10,
        'choices'   => array(
            '0'    => esc_html__( 'Disabled', 'woo-floating-cart' ),
            '1'     => esc_html__( 'Enabled', 'woo-floating-cart' )
        ),
        'transport' => 'postMessage',
        'default'   => '0'
    );

    $fields[] = array(
		'id'        => 'cart_dimensions_unit',
		'section'   => 'general',
		'label'     => esc_html__( 'Cart Dimensions Unit', 'woo-floating-cart' ),
		'type'        => 'radio-buttonset',
		'priority'  => 10,
		'choices'   => array(
			'pixels'     => esc_html__( 'Pixels', 'woo-floating-cart' ),
			'percent'    => esc_html__( 'Percent', 'woo-floating-cart' )
		),
		'default'   => 'pixels',
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'     => '.xt_woofc',
				'function'    => 'class',
				'prefix'      => 'xt_woofc-dimensions-'
			)
		),
	);

	$fields[] = array(
		'id'              => 'cart_width',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Width (px)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '250',
			'max'  => '1000',
			'step' => '5',
            'suffix' => 'px',
		),
		'default'         => '440',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-width',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'pixels',
			),
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'              => 'cart_height',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Height (px)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '240',
			'max'  => '1000',
			'step' => '5',
            'suffix' => 'px',
		),
		'default'         => '400',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-height',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_autoheight_enabled',
				'operator' => '!=',
				'value'    => '1',
			),
            array(
                'setting'  => 'cart_dimensions_unit',
                'operator' => '==',
                'value'    => 'pixels',
            ),
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'              => 'cart_width_percent',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Width (%)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '30',
			'max'  => '100',
			'step' => '1',
            'suffix' => '%',
		),
		'default'         => '30',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root .xt_woofc-dimensions-percent',
				'property' => '--xt-woofc-width',
				'value_pattern' => '$vw'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'percent',
			),
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'              => 'cart_height_percent',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Height (%)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '30',
			'max'  => '100',
			'step' => '1',
            'suffix' => '%',
		),
		'default'         => '50',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root .xt_woofc-dimensions-percent',
				'property' => '--xt-woofc-height',
				'value_pattern' => '$vh'
			)
		),
		'active_callback' => array(
            array(
                'setting'  => 'cart_autoheight_enabled',
                'operator' => '!=',
                'value'    => '1',
            ),
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'percent',
			),
		),
		'screen' => 'desktop'
	);

	$fields[] = array(
		'id'              => 'cart_width_tablet',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Width (px)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '250',
			'max'  => '1000',
			'step' => '5',
            'suffix' => 'px',
		),
		'default'         => '440',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-width',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'pixels',
			),
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'              => 'cart_height_tablet',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Height (px)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '240',
			'max'  => '1000',
			'step' => '5',
            'suffix' => 'px',
		),
		'default'         => '400',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-height',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
            array(
                'setting'  => 'cart_autoheight_enabled',
                'operator' => '!=',
                'value'    => '1',
            ),
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'pixels',
			),
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'              => 'cart_width_percent_tablet',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Width (%)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '30',
			'max'  => '100',
			'step' => '1',
            'suffix' => '%',
		),
		'default'         => '40',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root .xt_woofc-dimensions-percent',
				'property' => '--xt-woofc-width',
				'value_pattern' => '$vw'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'percent',
			),
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'              => 'cart_height_percent_tablet',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Height (%)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '30',
			'max'  => '100',
			'step' => '1',
            'suffix' => '%',
		),
		'default'         => '80',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root .xt_woofc-dimensions-percent',
				'property' => '--xt-woofc-height',
				'value_pattern' => '$vh'
			)
		),
		'active_callback' => array(
            array(
                'setting'  => 'cart_autoheight_enabled',
                'operator' => '!=',
                'value'    => '1',
            ),
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'percent',
			),
		),
		'screen' => 'tablet'
	);

	$fields[] = array(
		'id'              => 'cart_width_mobile',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Width (px)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '250',
			'max'  => '1000',
			'step' => '5',
            'suffix' => 'px',
		),
		'default'         => '440',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--xt-woofc-width',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'pixels',
			),
		),
		'screen' => 'mobile'
	);

	$fields[] = array(
		'id'              => 'cart_height_mobile',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Height (px)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '240',
			'max'  => '1000',
			'step' => '5',
            'suffix' => 'px',
		),
		'default'         => '1000',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'       => ':root',
				'property'      => '--xt-woofc-height',
				'value_pattern' => '$px'
			)
		),
		'active_callback' => array(
            array(
                'setting'  => 'cart_autoheight_enabled',
                'operator' => '!=',
                'value'    => '1',
            ),
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'pixels',
			),
		),
		'screen' => 'mobile'
	);

	$fields[] = array(
		'id'              => 'cart_width_percent_mobile',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Width (%)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '60',
			'max'  => '100',
			'step' => '1',
            'suffix' => '%',
		),
		'default'         => '100',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'       => ':root .xt_woofc-dimensions-percent',
				'property'      => '--xt-woofc-width',
				'value_pattern' => '$vw'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'percent',
			),
		),
		'screen' => 'mobile'
	);

	$fields[] = array(
		'id'              => 'cart_height_percent_mobile',
		'section'         => 'general',
		'label'           => esc_html__( 'Cart Height (%)', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '30',
			'max'  => '100',
			'step' => '1',
            'suffix' => '%',
		),
		'default'         => '100',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'       => ':root .xt_woofc-dimensions-percent',
				'property'      => '--xt-woofc-height',
				'value_pattern' => '$vh'
			)
		),
		'active_callback' => array(
            array(
                'setting'  => 'cart_autoheight_enabled',
                'operator' => '!=',
                'value'    => '1',
            ),
			array(
				'setting'  => 'cart_dimensions_unit',
				'operator' => '==',
				'value'    => 'percent',
			),
		),
		'screen' => 'mobile'
	);

    $fields[] = array(
        'id'        => 'border_radius',
        'section'   => 'general',
        'label'     => esc_html__( 'Closed Cart Border Radius', 'woo-floating-cart' ),
        'type'      => 'slider',
        'choices'   => array(
            'min'  => '0',
            'max'  => '35',
            'step' => '1',
            'suffix' => 'px',
        ),
        'default'   => '6',
        'priority'  => 10,
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'       => '.xt_woofc:not(.xt_woofc-cart-open)',
                'property'      => '--xt-woofc-radius',
                'value_pattern' => '$px'
            )
        ),
        'screen' => 'desktop'
    );

    $fields[] = array(
        'id'        => 'border_radius_tablet',
        'section'   => 'general',
        'label'     => esc_html__( 'Closed Cart Border Radius', 'woo-floating-cart' ),
        'type'      => 'slider',
        'choices'   => array(
            'min'  => '0',
            'max'  => '35',
            'step' => '1',
            'suffix' => 'px',
        ),
        'default'   => '6',
        'priority'  => 10,
        'transport' => 'auto',
        'output'    => array(
	        array(
		        'element'       => '.xt_woofc:not(.xt_woofc-cart-open)',
		        'property'      => '--xt-woofc-radius',
		        'value_pattern' => '$px'
	        )
        ),
        'screen' => 'tablet'
    );

    $fields[] = array(
        'id'        => 'border_radius_mobile',
        'section'   => 'general',
        'label'     => esc_html__( 'Closed Cart Border Radius', 'woo-floating-cart' ),
        'type'      => 'slider',
        'choices'   => array(
            'min'  => '0',
            'max'  => '35',
            'step' => '1',
            'suffix' => 'px',
        ),
        'default'   => '6',
        'priority'  => 10,
        'transport' => 'auto',
        'output'    => array(
	        array(
		        'element'       => '.xt_woofc:not(.xt_woofc-cart-open)',
		        'property'      => '--xt-woofc-radius',
		        'value_pattern' => '$px'
	        )
        ),
        'screen' => 'mobile'
    );

    $fields[] = array(
        'id'        => 'border_radius_expanded',
        'section'   => 'general',
        'label'     => esc_html__( 'Opened Cart Border Radius', 'woo-floating-cart' ),
        'type'      => 'slider',
        'choices'   => array(
            'min'  => '0',
            'max'  => '35',
            'step' => '1',
            'suffix' => 'px',
        ),
        'default'   => '6',
        'priority'  => 10,
        'transport' => 'auto',
        'output'    => array(
	        array(
		        'element'       => '.xt_woofc-cart-open',
		        'property'      => '--xt-woofc-radius',
		        'value_pattern' => '$px'
	        )
        ),
        'screen' => 'desktop'
    );

    $fields[] = array(
        'id'        => 'border_radius_expanded_tablet',
        'section'   => 'general',
        'label'     => esc_html__( 'Opened Cart Border Radius', 'woo-floating-cart' ),
        'type'      => 'slider',
        'choices'   => array(
            'min'  => '0',
            'max'  => '35',
            'step' => '1',
            'suffix' => 'px',
        ),
        'default'   => '6',
        'priority'  => 10,
        'transport' => 'auto',
        'output'    => array(
	        array(
		        'element'       => '.xt_woofc-cart-open',
		        'property'      => '--xt-woofc-radius',
		        'value_pattern' => '$px'
	        )
        ),
        'screen' => 'tablet'
    );

    $fields[] = array(
        'id'        => 'border_radius_expanded_mobile',
        'section'   => 'general',
        'label'     => esc_html__( 'Opened Cart Border Radius', 'woo-floating-cart' ),
        'type'      => 'slider',
        'choices'   => array(
            'min'  => '0',
            'max'  => '35',
            'step' => '1',
            'suffix' => 'px',
        ),
        'default'   => '6',
        'priority'  => 10,
        'transport' => 'auto',
        'output'    => array(
	        array(
		        'element'       => '.xt_woofc-cart-open',
		        'property'      => '--xt-woofc-radius',
		        'value_pattern' => '$px'
	        )
        ),
        'screen' => 'mobile'
    );

	$fields[] = array(
		'id'       => 'flytocart_animation',
		'section'  => 'general',
		'label'    => esc_html__( 'Enable Fly To Cart animation', 'woo-floating-cart' ),
		'type'        => 'radio-buttonset',
		'choices'     => array(
			'0' => esc_html__( 'No', 'woo-floating-cart' ),
			'1' => esc_html__( 'Yes', 'woo-floating-cart' )
		),
		'default'  => '1',
		'priority' => 10
	);

	$fields[] = array(
		'id'              => 'flytocart_animation_duration',
		'section'         => 'general',
		'label'           => esc_html__( 'Fly To Cart animation Duration', 'woo-floating-cart' ),
		'type'            => 'slider',
		'choices'         => array(
			'min'  => '300',
			'max'  => '2000',
			'step' => '10',
            'suffix' => 'ms',
		),
		'priority'        => 10,
		'default'         => 650,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => '.xt_woofc',
				'function' => 'html',
				'attr'     => 'data-flyduration'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'flytocart_animation',
				'operator' => '==',
				'value'    => '1',
			),
		)
	);

	$fields[] = array(
		'id'        => 'open_cart_on_product_add',
		'section'   => 'general',
		'label'     => esc_html__( 'Open cart after adding products', 'woo-floating-cart' ),
		'type'      => 'radio-buttonset',
		'choices'   => array(
			'0' => esc_html__( 'No', 'woo-floating-cart' ),
			'1' => esc_html__( 'Yes', 'woo-floating-cart' )
		),
		'default'   => '0',
		'priority'  => 10,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.xt_woofc',
				'function' => 'html',
				'attr'     => 'data-opencart-onadd'
			)
		)
	);

	$fields[] = array(
		'id'        => 'shake_trigger',
		'section'   => 'general',
		'label'     => esc_html__( 'Shake Trigger after adding products', 'woo-floating-cart' ),
		'type'      => 'radio',
		'priority'  => 10,
		'choices'   => array(
			''           => esc_html__( 'No Shake', 'woo-floating-cart' ),
			'horizontal' => esc_html__( 'Horizontal Shake', 'woo-floating-cart' ),
			'vertical'   => esc_html__( 'Vertical Shake', 'woo-floating-cart' ),
		),
		'default'   => 'vertical',
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.xt_woofc',
				'function' => 'html',
				'attr'     => 'data-shaketrigger'
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'open_cart_on_product_add',
				'operator' => '!=',
				'value'    => '1',
			),
		)
	);

	$fields[] = array(
		'id'        => 'loading_spinner',
		'section'   => 'general',
		'label'     => esc_html__( 'In Cart Loading Spinner', 'woo-floating-cart' ),
		'type'      => 'radio',
		'priority'  => 10,
		'choices'   => array(
			'0'                 => esc_html__( 'No Spinner', 'woo-floating-cart' ),
			'1-rotating-plane'  => esc_html__( 'Rotating Plane', 'woo-floating-cart' ),
			'2-double-bounce'   => esc_html__( 'Double Bounce', 'woo-floating-cart' ),
			'3-wave'            => esc_html__( 'Wave', 'woo-floating-cart' ),
			'4-wandering-cubes' => esc_html__( 'Wandering Cubes', 'woo-floating-cart' ),
			'5-pulse'           => esc_html__( 'Pulse', 'woo-floating-cart' ),
			'6-chasing-dots'    => esc_html__( 'Chasing Dots', 'woo-floating-cart' ),
			'7-three-bounce'    => esc_html__( 'Three Bounce', 'woo-floating-cart' ),
			'8-circle'          => esc_html__( 'Circle', 'woo-floating-cart' ),
			'9-cube-grid'       => esc_html__( 'Cube Grid', 'woo-floating-cart' ),
			'10-fading-circle'  => esc_html__( 'Fading Circle', 'woo-floating-cart' ),
			'11-folding-cube'   => esc_html__( 'Folding Cube', 'woo-floating-cart' ),
			'loading-text'      => esc_html__( 'Boring Loading Text', 'woo-floating-cart' )
		),
		'transport' => 'postMessage',
		'default'   => '7-three-bounce'
	);

	$fields[] = array(
		'id'        => 'loading_spinner_color',
		'section'   => 'general',
		'label'     => esc_html__( 'In Cart Loading Spinner Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => '#2c97de',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-spinner-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'loading_overlay_color',
		'section'   => 'general',
		'label'     => esc_html__( 'In Cart Loading Overlay Color', 'woo-floating-cart' ),
		'type'      => 'color',
		'priority'  => 10,
		'default'   => 'rgba(255,255,255,0.5)',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'       => ':root',
				'property' => '--xt-woofc-spinner-overlay-color',
			)
		)
	);

	$fields[] = array(
		'id'        => 'loading_timeout',
		'section'   => 'general',
		'label'     => esc_html__( 'In Cart Loading Spinner Extra Delay', 'woo-floating-cart' ),
		'type'      => 'slider',
		'choices'   => array(
			'min'  => '0',
			'max'  => '2000',
			'step' => '10',
            'suffix' => 'ms',
		),
		'priority'  => 10,
		'default'   => 300,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.xt_woofc',
				'function' => 'html',
				'attr'     => 'data-loadingtimeout'
			)
		)
	);

} else {

	$fields[] = array(
		'id'      => 'general_features',
		'section' => 'general',
		'type'    => 'xt-premium',
		'default' => array(
			'type'  => 'image',
			'value' => $this->core->plugin_url() . 'admin/customizer/assets/images/general.png',
			'link'  => $this->core->plugin_upgrade_url()
		)
	);
}
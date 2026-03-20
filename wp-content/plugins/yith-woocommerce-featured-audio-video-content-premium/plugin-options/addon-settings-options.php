<?php
if( ! defined( 'ABSPATH' ) )
    exit;

$zoom_active = ywcfav_check_is_zoom_magnifier_is_active() ?  array() : array('disabled'  => 'disabled');
$addon =   array(

    'addon-settings'    =>  array(

        'addon_section_start'  =>  array(
            'name'  => __( 'General Settings', 'yith-woocommerce-featured-video'),
            'id'    =>  'ywcfav_addon_start',
            'type'  =>  'title'
        ),
        'addon_zoom_magnifier'   =>  array(
            'name'  =>  __('Video and Audio in the slider', 'yith-woocommerce-featured-video' ),
            'desc'  => __('It shows audios and videos in slider, replacing the featured image. This option is possible only if YITH WooCommerce Zoom Magnifier is enabled.', 'yith-woocommerce-featured-video' ),
            'id'    =>  'ywcfav_zoom_magnifer_option',
            'type'  => 'checkbox',
            'default'   =>  'no',
            'custom_attributes' => $zoom_active
        ),
        'addon_slider_widget' => array(
        	'name' => __( 'Video and Audio in sidebar', 'yith-woocommerce-featured-video' ),
	        'desc' => __( 'Show the audio and video sliders in a sidebar instead of under the product image gallery', 'yith-woocommerce-featured-video' ),
	        'id' => 'ywcfav_show_gallery_in_sidebar',
	        'type' => 'checkbox',
	        'default' => 'no'
        ),
        'addon_section_end'  =>  array(
            'type'  =>  'sectionend'
        ),
    )
);

return apply_filters( 'ywcfav_addons_option', $addon );

